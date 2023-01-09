<?php
function page_posts(User|null $user, Database $db){
    $posts = $db->get_public_posts();
    foreach($posts as &$post){
        $post['zmenen'] = (new DateTime($post['zmenen']))->format('j. n. Y G:i');
    }
    return $posts;
}
