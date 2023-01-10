<?php
function post_add_review(Session $session, Database $db){
    $id = $_POST['id'] ?? null;
    $rev = $_POST['user'] ?? null;
    $action = $_POST['action'] ?? null;
    if(!($user = $session->user_info()) || $user->roleid > 1){
        return ['success'=>false,'message'=>'permission denied'];
    }
    if(!$id || !$rev){
        return ['success'=>false,'message'=>'paramenter missing'];
    }
    return ["success" => $action === 'rm'
        ? $db->post_rm_review($id, $rev)
        : $db->post_add_review($id, $rev)];
}
