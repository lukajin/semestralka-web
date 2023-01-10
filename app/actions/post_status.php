<?php
function post_status(Session $session, Database $db){
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;
    if(!($user = $session->user_info()) || $user->roleid > 1){
        return ['success'=>false,'message'=>'permission denied'];
    }
    if(!$id || !$status){
        return ['success'=>false,'message'=>'paramenter missing'];
    }
    return ["success" => $db->update_post_status($id, $status)];
}
