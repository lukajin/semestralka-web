<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../config.php';
require_once '../vendor/autoload.php'; // Composer - Twig
require_once APP_DIR.'database.php';
require_once APP_DIR.'session.php';

// Pro odchycení útoků využívajících speciální znaky v názvu požadované stránky
define('SAFE_NAME_REGEX', '/^[a-z\-\_]+$/i');

$db = new Database(DB_DSN, DB_USER, DB_PASS);
$session = new Session($db);
$twig = new \Twig\Environment(
    new \Twig\Loader\FilesystemLoader(PAGES_DIR),
    ['cache'=>'/tmp',
    'auto_reload'=>true]);

// Provedení dalších akcí dle parametrů
$status = null;
$data = null;
if(isset($_POST['a'])
    && preg_match(SAFE_NAME_REGEX, $action = $_POST['a'])
    && file_exists($action_script = APP_DIR."actions/$action.php")){
    require_once $action_script;
    $status = $action($session,$_POST);
}

/* Jaká stránka se zobrazí při chybových stavech?
    isset -> !empty -> "safe" -> exists -> OK
      |        v         |         v
      \---> DEFAULT <----/     NOT_FOUND
*/
if(!isset($_GET['p'])
    || empty($page = $_GET['p'])
    || !preg_match(SAFE_NAME_REGEX, $page)){
    $page = PAGE_DEFAULT;
}
else if(!file_exists(PAGES_DIR.$page.PAGES_EXT)){
    $page = PAGE_NOTFOUND;
}

// Provést akce specifické pro danou stránku (nemusí existovat - to je taky OK)
if(file_exists($page_script = APP_DIR."pages/$page.php")){
    require_once $page_script;
    $data = 'page_'.$page();
}

// Vlastní vykreslení stránky
$pdata = [
    'default_page'=>PAGE_DEFAULT,
    'current_page'=>$page,
    'user'=>$session->user_info(),
    'status'=>$status,
    'data'=>$data
];
echo $twig->render($page.PAGES_EXT,$pdata);
//var_dump($pdata);
?>