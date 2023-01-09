<?php
function page_myposts(User|null $user, Database $db){
    if(!$user || $user->roleid !== 3){
        return false;
    }
    $posts = $db->get_author_posts($user->id);
    foreach($posts as &$post){
        $post['zmenen'] = (new DateTime($post['zmenen']))->format('j. n. Y G:i');
    }
    return $posts;
}
