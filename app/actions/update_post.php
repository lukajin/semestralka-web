<?php
function update_post(Session $session, Database $db){
    $id = $_POST['id'] ?? null;
    $title = $_POST['nazev'] ?? null;
    $abstract = $_POST['abstrakt'] ?? null;
    $file = $_FILES['soubor'] ?? null;
    if(!($user = $session->user_info())
        ||($user->roleid !== 3 && $user->roleid !== 0)){// Autor,SuperAdmin
        return ['success'=>false,'message'=>'permission denied'];
    }
    $author = $_POST['autor'] ?? $user->id;
    if(isset($file)
        && (!isset($file['error'])
        || is_array($file['error'])
        || $file['error'] != UPLOAD_ERR_OK
        )){
        return ['success'=>false,'message'=>'invalid file'];
    }
    if(!$id){ // novy prispevek
        if(!$title){
            return ['success'=>false,'message'=>'title missing'];
        }
        if(false===($id = $db->create_post($user->id, $title, $abstract))){
            return ['success'=>false,'message'=>'create failed'];
        }
        $title = null;
        $abstract = null;
    }
    if($file){ // pridat soubor do noveho nebo existujiciho prispevku
        $post = $db->get_post($id);
        if(!$post){
            return ['success'=>false,'message'=>'post not found'];
        }
        if(($filename=$post['soubor']) && file_exists(UPLOAD_DIR.$filename)){
            if(!unlink(UPLOAD_DIR.$filename)){
                return ['success'=>false,'message'=>'unlink failed'];
            }
        }
        $filename = $id.'_'.preg_replace(// https://stackoverflow.com/a/42058764
            '~
            [<>:"/\\\|?*]|      # file system reserved
            [\x00-\x1F\x7F]|    # control characters 
            [#\[\]@!$&\'(),;=]| # URI reserved https://www.rfc-editor.org/rfc/rfc3986#section-2.2
            [{}^\~`]            # URL unsafe characters https://www.ietf.org/rfc/rfc1738.txt
            ~x', '-', $file['name']);
        if(strlen($filename)>64){
            $ext = strrchr($filename,'.');
            if(!$ext){
                $ext = '.pdf';
            }
            $filename = mb_strcut($filename,0,64-strlen($ext)).$ext;
        }
        move_uploaded_file($file['tmp_name'],UPLOAD_DIR.$filename);
    }
    else $filename = null;
    return ["file"=>$filename, "success" =>
        $db->update_post($id, $author, $title, $abstract, $filename)];
}
