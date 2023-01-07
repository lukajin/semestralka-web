<?php
function page_users(User|null $user, Database $db){
    if(!$user || $user->roleid > 1){
        return false;
    }
    return $db->query_user_info();
}
