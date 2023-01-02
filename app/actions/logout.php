<?php
function logout($session){
    $session->logout();
    if(isset($_GET["p"]) && $_GET["p"] != 'posts'){
        unset($_GET['p']);
        return ['redirect' => PAGE_DEFAULT];
    }
}
?>