<?php
/**
 * Třída zprostředkující přístup k databázi
 */
class Database{
    /** @var PDO Instance připojení k databázi */
    private $pdo;
    /** @var string Identifikace zdroje dat */
    private $dsn;
    /** Uživatelské jméno pro přístup k databázi */
    private $user;
    /** Heslo uživatele pro přístup k databázi */
    private $password;
    /**
     * Vytvoří připojení k databázi
     * @param string $dsn Identifikace zdroje dat;
     * např. pro MySQL je v základním formátu "mysql:host=SERVER;dbname=NÁZEV_DB"
     * @param string $user Uživatelské jméno pro přístup k databázi
     * @param string $password Heslo uživatele pro přístup k databázi
     */
    public function __construct($dsn,$user=null,$password=null){
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        //$this->pdo = new PDO($dsn, $user, $password);
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
     * Předané podmínky jsou chráněny proti SQL Injection.
     * Je-li tento parametr použit, nesmí se ve vlastním SQL dotazu (1. parametr)
     * vyskytovat klauzule 'where' ani nesmí být SQL dotaz ukončen středníkem.
     * Nejsou-li tyto podmínky dodrženy, jinak platný SQL dotaz může
     * po zpracování obsahovat syntaktické chyby nebo vrátit nesprávné výsledky.
     * @return array asociativní pole výsledků (viz PDOStatement::fetchAll)
     * nebo false pokud došlo k chybě
     */
    public function query($sql, $cond=[]){
        if(!$this->pdo && !$this->connect()){
            echo "Database connection failed";
            return false;
        }
        if($cond){
            $sql .= ' where ';
            foreach($cond as $key => $value){
                $sql .= "$key = :$key and ";
            }
            $q = $this->pdo->prepare(
                // odstranit poslední "and" přidané výše, včetně mezer kolem
                substr($sql, 0, strlen($sql) - 5) . ";"
            );
            if($q == false || !$q->execute($cond)){
                return false;
            }
        } 
        else if(($q = $this->pdo->query($sql)) == false){
            return false;
        }
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>