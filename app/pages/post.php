<?php
function page_post(User|null $user, Database $db){
    if(!$user || $user->roleid !== 3){
        return false;
    }
    if(($id = $_GET["id"] ?? null)
        &&($post = $db->get_post($id))){
        $post['zmenen'] = (new DateTime($post['zmenen']))->format('j. n. Y G:i');
        return $post;
    }
    return null;
}
