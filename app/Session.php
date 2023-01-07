<?php
/**
 * Třída zprostředkující stav přihlášení uživatele
 * @author Jindřich Lukáš
 */
class Session{
    /**
     * Připraví práci se session
     */
    public function __construct(){
        session_start();
    }
    /**
     * Přihlásí uživatele do Session. Údaje o uživateli pak bude možné
     * získat voláním metody user_info().
     * @param User $user Informace o uživateli
     */
    public function login($user){
        $_SESSION["user"] = $user;
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
     * @return User|null
     */
    public function user_info(){
        return $_SESSION["user"] ?? null;
    }
}
