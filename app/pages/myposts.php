<?php
function datum($datum){
    return (new DateTime($datum))->format('j. n. Y G:i');
}
function page_myposts(User|null $user, Database $db){
    if(!$user){
        return false;
    }
    if($user->roleid == 3){
        $posts = $db->get_author_posts($user->id);
    }
    elseif($user->roleid == 2){
        $posts = $db->get_review_posts($user->id);
    }
    else{
        $posts = $db->get_posts();
        $postmap = [];
        $reviewermap = [];
        foreach($posts as &$post){
            $post['recenze'] = [];
            $post['recenzenti'] = [];
            $reviewermap[$post['id']] = [];
            $postmap[$post['id']] = &$post;
        }
        foreach($db->get_reviews() as &$r){
            $r['datum'] = $r['datum'][0] == 0 ? null : datum($r['datum']);
            $r['h_celkem'] = intval(($r['h_obsah']+$r['h_aktualnost']+$r['h_jazyk'])/3);
            $postmap[$r['prispevek']]['recenze'][] = &$r;
            $reviewermap[$r['prispevek']][$r['recenzent']] = true;
        }
        foreach($db->get_reviewers() as &$reviewer){
            foreach($reviewermap as $postid=>&$reviewed){
                if(!isset($reviewed[$reviewer['id']])){
                    $postmap[$postid]['recenzenti'][] = &$reviewer;
                }
            }
        }
    }
    foreach($posts as &$post){
        $post['zmenen'] = datum($post['zmenen']);
    }
    //var_dump($posts);
    return $posts;
}
