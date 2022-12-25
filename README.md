# Konferenční systém - semestrální práce z předmětu WEB
## Zadání
Cílem práce je vytvořit kompletní webové stránky konference.
Zadání semestrální práce je shrnuto (v bodech)
v souboru [`zadani.md`](zadani.md). Původní znění je (po přihlášení) k dispozici
[na stránkách CourseWare předmětu KIV/WEB](https://courseware.zcu.cz/portal/studium/courseware/kiv/web/samostatna-prace/index.html).

## Dílčí části práce
- [x] Kostra aplikace - index.php, databáze, session, Twig
- [x] Přihlašování a odhlašování uživatelů
- [ ] Vymyslet téma konference
- [ ] Navrhnout design stránek
- [ ] Obsah domovské stránky
- [ ] Plně responzivní stránky
- [ ] Zobrazení seznamu publikovaných příspěvků
- [ ] Zobrazení příspěvků
- [ ] Vytváření a úprava příspěvků (autoři)
- [ ] Recenze (recenzenti)
- [ ] Schvalování příspěvků (admini)
- [ ] Registrace uživatele
- [ ] Správa uživatelů (admini)
- [ ] Kompletní testovací data
- [ ] Kompletní postup instalace (Docker i ruční)
- [ ] Dokumentace

## Struktura adresářů
* Kořenový adresář - organizační soubory
* `app` - PHP skripty aplikace
	* `actions` - skripty akcí (přihlášení, jakékoli změny dat v databázi)
	* `pages` - dodatečné akce související se zobrazením konkrétních stránek
	* Třídy zprostředkující práci s databází (`database.php`)
        a session (`session.php`)
* `dbsetup` - skripty pro instalaci databáze
* `docker` - skript pro automatické zprovoznění aplikace pomocí Dockeru (viz dále)
* `pages` - šablony stránek (Twig)
* `public` - kořenová složka webového serveru (tzv. document root)
    * `index.php` - vstupní bod aplikace
* `vendor` (není distribuován) - komponenty stažené přes Composer (Twig)

## Automatická instalace (Docker)
Pro jednoduchou instalaci (i odinstalaci)
aplikace lze použít [Docker](https://www.docker.com/).
Tento postup byl použit autorem práce a lze jej použít i pro vývoj a provoz
jiných, podobně strukturovaných webových aplikací.

Následující kroky předpokládají
[nainstalované](https://docs.docker.com/engine/install/)
a funkční běhové prostředí Docker (verze 20.10 nebo novější)
a možnost jej ovládat příkazovou řádkou.
Během sestavování obrazu (viz dále) je potřeba internetové připojení
pro stažení balíků webového a databázového serveru
(stáhne se přibližně 65 MB dat).
Další software není potřeba.

...TODO

## Ruční instalace
Alternativně lze aplikaci nainstalovat ručně.
Následující postup předpokládá
funkční webový a databázový server (produkční server či
vývojový balík jako např. [EasyPHP](https://www.easyphp.org/)
či [XAMPP](https://www.apachefriends.org/))
a schopnost tento konfigurovat.

Doporučenou kombinací softwaru je opět Apache (díky jeho dobré podpoře jazyka
PHP) a MySQL/MariaDB (pro který jsou napsány instalační skripty).
Je ale možné použít i jiný software.

Pro ruční zprovoznění aplikace je potřeba:
* Nasměrovat webový server (document root) na zdejší adresář `public`.
Nestačí tento adresář někam zkopírovat, jelikož aplikace vedle něj předpokládá
další adresáře tohoto projektu.
V případě serveru Apache lze tohoto docílit umístěním např. kódu níže
přímo do konfiguračního souboru `httpd.conf`
(čímž se adresář stane výchozím pro celý server!)
nebo (lépe, v případě produkčního serveru) do nastavení virtuálního serveru
([VirtualHost](https://httpd.apache.org/docs/2.4/vhosts/)):
```
DocumentRoot "/cesta/k/adresari/public"
<Directory "/cesta/k/adresari/public">
Require all granted
</Directory>
```

* V databázovém serveru importovat skripty z adresáře `dbsetup`.
Pro jiný DBMS než MySQL/MariaDB může být potřeba skripty upravit
kvůli odlišnostem v podporované syntaxi jazyka SQL.
Dále může být vhodné skripty upravit s ohledem na místní prostředí,
zejména změnit jméno uživatele či databáze či použít existující.
  * `1_setup.sql` - Založí databázi s názvem `web` a stejnojmenného uživatele,
  který bude mít při přístupu z místního stroje (`localhost`) plná
  oprávnění k této databázi.
  * `2_schema.sql` - Vytvoří v databázi `web` potřebné tabulky
  a naplní tabulku se seznamem rolí uživatelů.
  * `3_data.sql` - Naplní tabulky databáze `web` testovacími daty.
  (Lze vynechat, není-li toto žádoucí.)
  


* Upravit přístupové údaje k databázovému serveru v souboru `config.php`
v tomto adresáři.
