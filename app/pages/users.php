<?php
function page_users($session){
    if(!($user = $session->user_info()) || $user['roleid'] > 1){
        return false;
    }
    return $session->query_user_info();
}
?>
