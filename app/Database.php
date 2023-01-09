<?php
/**
 * Třída zprostředkující provádění akcí uživatelů v databázi
 * @author Jindřich Lukáš
 */
class Database{
    /** @var DatabaseConnection $db Připojení k databázi */
    private $db;
    /**
     * Připraví práci se session a databází
     * @param DatabaseConnection $db Připojení k databázi.
     */
    public function __construct(DatabaseConnection $db){
        $this->db = $db;
    }
    /**
     * Přihlásí uživatele a vrátí informace o něm.
     * @param string $login Uživatelské jméno
     * @param string $password Heslo
     * @return User|false Informace o přihlášeném uživateli
     * nebo false pokud se přihlášení nepodařilo.
     */
    public function login($login,$password){
        $userinfo = $this->db->query(
            "select uzivatel.id, role as roleid,
            role.nazev as role, login, jmeno, heslo, povolen
            from uzivatel left join role on role = role.id",
            ["login" => $login]);
        if(!$userinfo || !is_array($userinfo) || $userinfo[0]['povolen'] == 'N'){
            return false;
        }
        $userinfo = $userinfo[0];
        if(!password_verify($password, $userinfo['heslo'])){
            return false;
        }
        return new User(
            $userinfo['id'],
            $userinfo['roleid'],
            $userinfo['role'],
            $userinfo['login'],
            $userinfo['jmeno']
        );
    }

    /**
     * Zjistí, zda je dané uživatelské jméno dostupné pro registraci.
     */
    public function is_username_available($login){
        return empty($this->db->query("select id from uzivatel",
            ["login" => $login]));
    }

    /**
     * Zaregistruje nového uživate a při úspěchu jej přihlásí
     * a vrátí informace o něm.
     * Dojde-li k chybě, vrací false.
     */
    public function register($name, $login, $password){
        if(!$this->db->insert("uzivatel",[
            "jmeno" => $name,
            "login" => $login,
            "heslo" => password_hash($password, PASSWORD_BCRYPT)
        ])){
            return false;
        }
        return $this->login($login, $password);
    }

    /**
     * Získá informace o všech uživatelích nebo o uživateli s daným ID
     * @param number $id ID uživatele (vynecháno nebo null -> všichni uživatelé)
     * @return array|false
     */
    public function query_user_info($id = null){
        $res = $this->db->query(
            "select uzivatel.id, role as roleid,
            role.nazev as role, login, jmeno, povolen
            from uzivatel left join role on role = role.id",
            isset($id) ? ["uzivatel.id" => $id] : null);
        return (isset($id) && !empty($res)) ? $res[0] : $res;
    }

    public function update_user($id, $target_role_check, $field, $value){
        return $this->db->query(
            "update uzivatel set $field = :value",
            ["id" => $id, "role" => $target_role_check],
            ["value" => $value]);
    }

    /**
     * Vrátí seznam příspěvků autora
     * @param number $id ID požadujícího uživatele
     * @return array|false Pole příspěvků nebo false při chybě.
     */
    public function get_author_posts($id){
        return $this->db->query("select id, nazev, abstrakt, zmenen, soubor, stav
        from prispevek",['autor'=>$id]);
    }

    public function create_post($author, $title, $abstract){
        return $this->db->insert("prispevek",[
            "autor"=>$author,
            "nazev"=>$title,
            "abstrakt"=>$abstract,
            "zmenen"=>null
        ]) ? $this->db->get_last_insert_id() : false;
    }

    /**
     * Upraví záznam o příspěvku. ID a Autor jsou povinné atributy.
     * Ostatní jsou nepovinné, null zachová původní hodnotu.
     * @param number $id ID příspěvku
     * @param number $author ID autora (bezpečnostní kontrola)
     * @param string $title Název/titulek příspěvku
     * @param string $abstract Abstrakt
     * @param string $filename Jméno nahraného souboru
     * @return bool true při úspěchu
     */
    public function update_post($id, $author, $title, $abstract, $filename){
        if(!$title && !$abstract && !$filename) return true;
        $sql = "update prispevek set";
        $values = [];
        if(isset($title)){
            $sql .= " nazev=:nazev,";
            $values["nazev"]=$title;
        }
        if(isset($abstract)){
            $sql .= " abstrakt=:abstrakt,";
            $values["abstrakt"]=$abstract;
        }
        if(isset($filename)){
            $sql .= " soubor=:soubor,";
            $values["soubor"]=$filename;
        }
        $sql = substr($sql, 0, strlen($sql) - 1);
        return false !== $this->db->query($sql,["id"=>$id,"autor"=>$author],$values);
    }

    /**
     * Získá informace o příspěvku
     * @param number $id ID příspěvku
     * @return array|null Asociativní pole informací o příspěvku
     * nebo null pokud příspěvek neexistuje nebo došlo k chybě
     */
    public function get_post($id){
        $arr = $this->db->query("select * from prispevek",['id'=>$id]);
        return ($arr && is_array($arr) && count($arr)) ? $arr[0] : null;
    }

    /**
     * Odstraní záznam o příspěvku z databáze.
     * @param number $id ID příspěvku
     * @param number|null $author Autor příspěvku (bezpečnostní kontrola).
     * Předáním null bude příspěvek smazán bez ohledu na jeho autora.
     */
    public function delete_post($id, $author){
        return $this->db->query("delete from prispevek",
            isset($author) ? ['id'=>$id,'autor'=>$author] : ['id'=>$id]
        );
    }
}
