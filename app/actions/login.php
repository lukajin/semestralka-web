<?php
function login($session){
    if(!$session->login($_POST['user'] ?? null, $_POST['password'] ?? null)){
        return ['alert' => [
            'class' => 'danger',
            'message' => 'Přihlášení se nezdařilo: neplatné uživatelské jméno nebo heslo.',
            'dismissible' => true
        ]];
    }
    if(isset($_GET["p"]) && $_GET["p"] == 'register'){
        unset($_GET['p']);
        return ['redirect' => PAGE_DEFAULT];
    }
}
?>