# Konferenční systém - semestrální práce z předmětu WEB
## Zadání
Cílem práce je vytvořit kompletní webové stránky konference.
Zadání semestrální práce je shrnuto (v bodech)
v souboru [`zadani.md`](zadani.md). Původní znění je (po přihlášení) k dispozici
[na stránkách CourseWare předmětu KIV/WEB](https://courseware.zcu.cz/portal/studium/courseware/kiv/web/samostatna-prace/index.html).

## Dílčí části práce
TODO

## Struktura adresářů
TODO

## Automatická instalace (Docker)
Pro jednoduchou instalaci (i odinstalaci)
aplikace lze použít [Docker](https://www.docker.com/).
Tento postup byl použit při vývoji aplikace.

Následující kroky předpokládají
[nainstalované](https://docs.docker.com/engine/install/)
a funkční běhové prostředí Docker (verze 20.10 nebo novější)
a možnost jej ovládat příkazovou řádkou. Další software není potřeba.

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

* V databázovém serveru nainstalovat skripty z adresáře `dbinst`.
Pro jiný DBMS než MySQL/MariaDB může být potřeba skripty upravit
kvůli odlišnostem v podporované syntaxi jazyka SQL.
  * `1_schema.sql` - Vytvoří databázi s názvem `web` a v ní potřebné tabulky.
     (Vzhledem k oprávněním a jiným okolnostem může být vhodné
     použít jiné jméno databáze či již existující databázi.)
  * `2_data.sql` - Naplní tabulky testovacími daty.
  (Lze vynechat, není-li toto žádoucí.)
  


* Upravit přístupové údaje k databázovému serveru v souboru `config.php`
v tomto adresáři.
