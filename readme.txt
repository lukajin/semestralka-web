Struktura adresářů:
app - PHP skripty aplikace
 \ actions - skripty akcí (přihlášení, jakékoli změny dat v databázi)
 \ pages - dodatečné akce související se zobrazením konkrétních stránek
 \ model - třídy zprostředkující práci s databází a session
dbsetup - skripty pro instalaci databáze
docker - skript pro automatické zprovoznění aplikace pomocí Dockeru (viz dále)
pages - šablony stránek (Twig)
public - kořenová složka webového serveru (tzv. document root)
 \ index.php - vstupní bod aplikace
 \ soubory CSS a JavaScriptu
vendor (není distribuován) - komponenty stažené přes Composer (Twig)
Kořenový adresář - organizační soubory jinde nezařazené
