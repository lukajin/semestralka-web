<?php
function login(Session $session, Database $db){
    if(!($user = $db->login($_POST['user'] ?? null, $_POST['password'] ?? null))){
        return ['alert' => [
            'class' => 'danger',
            'message' => 'Přihlášení se nezdařilo: neplatné uživatelské jméno nebo heslo.',
            'dismissible' => true
        ]];
    }
    $session->login($user);
    if(isset($_GET["p"]) && $_GET["p"] == 'register'){
        unset($_GET['p']);
        return ['redirect' => PAGE_DEFAULT];
    }
}
