<?php
function page_profile($session){
    if(!($user = $session->user_info())){
        return false;
    }
    if(!isset($_GET['id']) || $_GET['id'] == $user['id']){
        return $user;
    }
    if($user['roleid'] <= 1 /* admin? */
        && ($u = $session->query_user_info($_GET['id'])) /* existuje? */
        /* SuperAdmin vs Admin: */
        && ($user['roleid'] < $u['roleid'] || $user['roleid'] == 0)){ 
        return $u;
    }
    return false;
}
?>
