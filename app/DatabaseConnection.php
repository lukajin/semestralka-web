<?php
/**
 * Třída zprostředkující přístup k databázi
 */
class DatabaseConnection {
    /** @var PDO Instance připojení k databázi */
    private $pdo;
    /** @var string Identifikace zdroje dat */
    private $dsn;
    /** Uživatelské jméno pro přístup k databázi */
    private $user;
    /** Heslo uživatele pro přístup k databázi */
    private $password;
    /**
     * Vytvoří připojení k databázi. Samotné spojení s databází
     * se provede až při požadavku na dotaz pomocí jedné z metod této třídy.
     * @param string $dsn Identifikace zdroje dat;
     * např. pro MySQL je v základním formátu "mysql:host=SERVER;dbname=NÁZEV_DB"
     * @param string $user Uživatelské jméno pro přístup k databázi
     * @param string $password Heslo uživatele pro přístup k databázi
     */
    public function __construct($dsn,$user=null,$password=null){
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
    }
    /**
     * Provede skutečné připojení k databázi, pokud k němu ještě nedošlo.
     */
    public function connect(){
        if(!$this->pdo){
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
        }
        return $this->pdo;
    }
    /**
     * Provede zadaný SQL dotaz a vrátí všechny výsledky
     * @param string $sql SQL dotaz
     * @param array $cond Podmínky pro výběr záznamů (klauzule 'where'),
     * kde název sloupce je klíč pole (tj. např ["cislo" => 10]).
     * Všechny podmínky musí být splněny současně, disjunkce není podporována.
     * Omezení nerovností (např. id>=10) tento parametr rovněž neumožňuje.
     * Předané hodnoty jsou chráněny proti SQL Injection, názvy sloupců ale ne.
     * Je-li tento parametr použit, nesmí se ve vlastním SQL dotazu (1. parametr)
     * vyskytovat klauzule 'where' ani nesmí být SQL dotaz ukončen středníkem.
     * Nejsou-li tyto podmínky dodrženy, jinak platný SQL dotaz může
     * po zpracování obsahovat syntaktické chyby nebo vrátit nesprávné výsledky.
     * @param array $params Dodatečné parametry (["parametr" => hodnota]),
     * zadané v SQL dotazu jako ":parametr".
     * Zadané hodnoty jsou chráněny proti SQL injekci.
     * Nejsou-li uvedeny podmínky ($cond), tyto parametry se nepoužijí!
     * @return array|false asociativní pole výsledků (viz PDOStatement::fetchAll)
     * nebo false pokud došlo k chybě
     */
    public function query($sql, $cond=[], $params=[]){
        if(!$this->pdo && !$this->connect()){
            return false;
        }
        if($cond){
            $sql .= ' where ';
            foreach($cond as $key => $value){
                $param = str_replace(".", "_", $key);
                $params[$param] = $value;
                $sql .= "$key = :$param and ";
            }
            $q = $this->pdo->prepare(
                // odstranit poslední "and" přidané výše, včetně mezer kolem
                substr($sql, 0, strlen($sql) - 5) . ";"
            );
            if($q === false || !$q->execute($params)){
                return false;
            }
        } 
        else if(($q = $this->pdo->query($sql)) === false){
            return false;
        }
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Vloží záznam do databáze
     * @param string $table Název tabulky pro vložení dat
     * @param array $values Pole hodnot pro vložení do tabulky,
     * kde název sloupce je klíč pole (tj. např ["cislo" => 10]).
     * Předané hodnoty jsou chráněny proti SQL Injection,
     * názvy tabulky a sloupců ale nikoliv!
     * @return bool true při úspěchu, false při chybě
     */
    public function insert($table, $values){
        if(!$this->pdo && !$this->connect()){
            return false;
        }
        $sql = "insert into $table (";
        $sqlval = ") values (";
        foreach($values as $key => $value){
            $sql .= "$key,";
            $sqlval .= ":$key,";
        }
        $q = $this->pdo->prepare(
            // odstranit poslední čárky přidané v cyklu výše
            substr($sql, 0, strlen($sql) - 1)
            . substr($sqlval, 0, strlen($sqlval) - 1) . ");"
        );
        return $q && $q->execute($values);
    }
}
