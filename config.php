<?php
/* Adresář s PHP skripty aplikace (relativní vůči public/index.php) */
const APP_DIR = "../app/";
/* Adresář se šablonami stránek (relativní vůči public/index.php) */
const PAGES_DIR = "../pages/";
/* Přípona souborů se šablonami stránek */
const PAGES_EXT = ".twig";
/* Soubor s hlavní/úvodní/výchozí stránkou (bez cesty a přípony) */
const PAGE_DEFAULT = "home";
/* Soubor se stránkou, která se zobrazí namísto neexistující stránky */
const PAGE_NOTFOUND = "notfound";

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
const DB_DSN = "mysql:host=localhost;dbname=web";

/** Uživatel databáze. */
const DB_USER = "web";

/** Heslo uživatele databáze */
const DB_PASS = "\$ecretPass";
