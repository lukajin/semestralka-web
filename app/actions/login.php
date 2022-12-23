<?php
function login($session,$data){
    if($session->login($data['user'],$data['password'])){
        return "Přihlášení proběhlo úspěšně";
    } else return "Přihlášení se nezdařilo: neexistující uživatel nebo špatné heslo.";
}
?>