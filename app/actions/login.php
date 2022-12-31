<?php
function login($session,$data){
    if(!$session->login($data['user'],$data['password'])){
        return ['alert' => [
            'class' => 'danger',
            'message' => 'Přihlášení se nezdařilo: neplatné uživatelské jméno nebo heslo.',
            'dismissible' => true
        ]];
    }
}
?>