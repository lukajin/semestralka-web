<?php
function delete_post(Session $session, Database $db){
    $id = $_POST['id'] ?? null;
    if(!($user = $session->user_info())
        ||($user->roleid !== 3 && $user->roleid !== 0)){// Autor,SuperAdmin
        return ['success'=>false,'message'=>'permission denied'];
    }
    if(!$id ||!($post = $db->get_post($id))){
        return ['success'=>false,'message'=>'post missing'];
    }
    if(!empty($post['soubor'])){
        if(($filename=$post['soubor']) && file_exists(UPLOAD_DIR.$filename)){
            if(!unlink(UPLOAD_DIR.$filename)){
                return ['success'=>false,'message'=>'unlink failed'];
            }
        }
    }
    $db->delete_post($id,$user->roleid===0 ? null : $user->id);
}
