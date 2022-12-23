<?php
/* Adresář s PHP skripty */
define("APP_DIR","../app/");
/* Adresář se šablonami stránek */
define("PAGES_DIR","../pages/");
/* Přípona souborů se šablonami stránek */
define("PAGES_EXT",".twig");
/* Soubor s hlavní/úvodní/výchozí stránkou (bez cesty a přípony) */
define("PAGE_DEFAULT","home");
/* Soubor se stránkou, která se zobrazí namísto neexistující stránky */
define("PAGE_NOTFOUND","notfound");

/*
Následují údaje pro připojení k databázi.
Aplikaci je možné použít s jakýmkoli DBMS kompatibilním s PDO.

Pro připojení je potřeba uvést celý řetězec DSN (Data Source Name).
Např. pro MySQL je v základním formátu
    "mysql:host=ADRESA_SERVERU;dbname=NÁZEV_DATABÁZE"

Definici uživatele a jeho hesla (DB_USER, DB_pASS)
lze odstranit nebo zakomentovat, nejsou-li pro daný DBMS potřeba.
*/

/** Ǐdentifikátor zdroje dat (DSN, Data Source Name) */
define("DB_DSN","mysql:host=localhost;dbname=web");

/** Uživatel databáze. */
define("DB_USER","web");

/** Heslo uživatele databáze */
define("DB_PASS","\$ecretPass");
?>