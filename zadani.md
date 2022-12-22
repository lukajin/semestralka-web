# Zadání semestrální práce
Následuje shrnutí zadání semestrální práce, převzaté ze
[stránek CourseWare předmětu KIV/WEB](https://courseware.zcu.cz/portal/studium/courseware/kiv/web/samostatna-prace/index.html).

## Požadavky
* Standardní zadání: Kompletní webové stránky konference (téma libovolné)
* Povinně HTML5, CSS, PHP (architektura MVC), MySQL (nebo jiná databáze; použít PDO)
* Volitelně šablony (Twig), JS, AJAX, Bootstrap
* Vstupní soubor index.php dle parametrů URL provede akci (zavolá controller) a vypíše výstup uživateli
* Ochrana proti XSS a SQL injection
* Responzivní design
* Databáze s alespoň 3 tabulkami s ukázkovými daty pro předvedení aplikace
* Zadání možné upravit "k obrazu svému", ale musí být zachována složitost zadání:
	* vždy minimálně 3+1 role uživatelů,
	* 3 tabulky v databázi,
	* upload souboru,
	* smysluplný význam rolí
## Uživatelé (standardní zadání)
* Nepřihlášený
	* Vidí publikované příspěvky
	* Může se registrovat jako autor
* Autor
	* Vidí svoje příspěvky včetně stavu (recenze)
	* Může přidávat příspěvky
	* Může měnit a mazat své nepublikované příspěvky
		* Případně i publikované příspěvky - ponecháno na tvůrci systému
* Recenzent
	* Vidí příspěvky jemu přidělené k recenzi
	* Může příspěvky hodnotit
		* Minimálně 3 kritéria hodnocení
	* Může měnit svá hodnocení nepublikovaných příspěvků
		* U publikovaných nelze
* Administrátor
	* Spravuje uživatele (role, blokování, mazání)
	* Přiřazuje příspěvky recenzentům
		* Minimálně 3 recenzenti pro každý příspěvek
	* Publikuje příspěvky dle hodnocení recenzentů
* SuperAdmin
	* Jako administrátor, ale může navíc spravovat administrátory

## Odevzdání
* Ideálně do Vánoc
* Osobní předvedení cvičícímu
	* Na cvičeních nebo ve stanovených termínech ve zkouškovém období
	* Web poběží na počítači v učebně nebo na vlastním notebooku
	* Server bude localhost nebo students.kiv.zcu.cz
* **Po předvedení a schválení** odevzdání na CourseWare
	* PRIJMENI-JMENO.ZIP, bude obsahovat:
		* readme.txt (popis obsahu jednotlivých adresářů)
		* Skripty pro instalaci databáze
		* Dokumentace
			* PDF
			* Musí obsahovat
				* Jméno
				* URL publikovaných stránek (jsou-li?)
				* e-mail
				* datum vytvoření
				* název předmětu
				* název aplikace
				* použité technologie a kde byly použity
				* adresářovou strukturu aplikace
				* architektura aplikace (jednotlivé třídy)
				* defaultní uživatelé, jejich loginy a hesla
	* Odevzdaná práce musí dále obsahovat
		* Postup instalace webu, včetně skriptů pro vytvoření databáze a její naplnění testovacími daty
		* Všechny přístupové údaje na využívané externí služby.
		* Všechny další soubory potřebné k provozu dané webové aplikace.
## Hodnocení
* Minimum 20 bodů z >60 možných (ke zkoušce se přenáší max. 60)
* Povinně (14 - 29 bodů)
	* MVC architektura - 8 bodů (s menšími chybami 4 body)
	* Responzivní design - 5 bodů (s menšími chybami 3 body)
	* Plně funkční web - 8 bodů (pouze demostrace - 3 body)
	* Design: "normální" - 2 body, pěkný - 5 bodů, propracovaný - 8 bodů
	* Šifrování hesel (Bcrypt) - 1 bod
	* Ošetření útoků (SQL Injection, XSS) - 1 bod
* Odevzdání do vánoc (do posledního cvičení) - 10 bodů
* SuperAdmin - admini se nemůžou ovlivňovat navzájem - 2b.
* SuperAdmin může všechno - 2b.
* Unikátní názvy souborů po uploadu - 1b.
* Další vychytávky - 1b.
* Bootstrap částečně - 3b. (vč. ikon, hlášení apod. - 5b.)
* JS, jQuery, Angular - místy 2b, více 4b.
* AJAX - místy 1b, více 3b
* Twig - místy 2b, více 4b
* WYSIWIG editor (např. CKEditor) - 3b
* Zdrojové kódy na GitHubu - 2b
