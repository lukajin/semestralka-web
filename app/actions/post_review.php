<?php
function post_review(Session $session, Database $db){
    $id = $_POST['id'] ?? null;
    $komentar = $_POST['komentar'] ?? null;
    $obsah = $_POST['obsah'] ?? null;
    $aktualnost = $_POST['aktualnost'] ?? null;
    $jazyk = $_POST['jazyk'] ?? null;
    if(!isset($id) || !isset($komentar) || !isset($obsah) || !isset($aktualnost) || !isset($jazyk)){
        return ["success"=>false,"message"=>"arguments missing"];
    }
    if(!($user = $session->user_info()) || $user->roleid != 2){
        return ["success"=>false,"message"=>"permission denied"];
    }
    return ["success" =>
        $db->update_review($user->id, $id, $komentar, $obsah, $aktualnost, $jazyk)];
}
