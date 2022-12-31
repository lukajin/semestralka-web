<?php
/**
 * Třída zprostředkující stav a provádění akcí uživatelů
 * @author Jindřich Lukáš
 */
class Session{
    /** @var Database Připojení k databázi */
    private $db;
    /**
     * Připraví práci se session a databází
     * @param Database $db Připojení k databázi. Pro některé operace není
     * potřeba, proto není nutné jej uvést.
     */
    public function __construct($db=null){
        $this->db = $db;
        session_start();
    }
    /**
     * Přihlásí uživatele a vrátí informace o něm.
     * @param string $login Uživatelské jméno
     * @param string $password Heslo
     * @return array|false Informace o přihlášeném uživateli (stejné jako z metody user_info())
     * nebo false pokud se přihlášení nepodařilo.
     */
    public function login($login,$password){
        $userinfo = $this->db->query(
            "select id,role,login,heslo,jmeno,povolen from uzivatel",
            ["login" => $login]);
        if(!$userinfo || !is_array($userinfo) || $userinfo[0].povolen == 'N'){
            return false;
        }
        $userinfo = $userinfo[0];
        if(!password_verify($password, $userinfo['heslo'])){
            return false;
        }
        unset($userinfo['heslo']);
        $_SESSION["user"]=$userinfo;
        return $userinfo;
    }
    /**
     * Odhlásí uživatele. Tato operace nevyžaduje přístup k databázi.
     */
    public function logout(){
        unset($_SESSION["user"]);
    }

    /**
     * Vrátí informace o přihlášeném uživateli nebo false pokud uživatel
     * není přihlášen.
     * @return array|false 
     */
    public function user_info(){
        if(isset($_SESSION["user"])){
            return $_SESSION["user"];
        }
        else return false;
    }
}
?>