<?php
/**
 * Přepravka s údaji o přihlášeném uživateli
 * @author Jindřich Lukáš
 */
class User{
    /**
     * Vytvoří instanci uživatele
     */
    public function __construct(
        public readonly int $id,
        public readonly int $roleid,
        public readonly string $role,
        public readonly string $login,
        public readonly string $jmeno
    ){}
}
