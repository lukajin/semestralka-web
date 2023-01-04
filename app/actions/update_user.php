<?php
function update_user($session){
    $target_id = $_POST['id'] ?? null;
    $target_role = $_POST['current-role'] ?? null;
    $field = $_POST['field'] ?? null;
    $value = $_POST['value'] ?? null;
    if(!isset($target_id) || !isset($target_role) || !isset($field) || !isset($value)){
        return ["success"=>false,"message"=>"arguments missing"];
    }
    /*
     * kontrola roli je krypticka, takze zde je vysvetleni (a kontrola)
     *
     * kdokoliv muze menit svoje heslo
     * admin muze navic menit role ne-admina na ne-admina
     * superadmin muze menit vsechno
     *
     * je admin?
     *    meni neadmina?
     *       nemeni roli? -> povolit
     *       meni na neadmina -> povolit
     *    je superadmin? -> povolit
     * meni svoje heslo? -> povolit
     * jinak zakazat
     *
     * => podminka pro odmitnuti akce:
     * ((neni admin)
     *    nebo ((meni admina
     *      nebo (meni roli a meni ji na admina)
     *    ) a neni superadmin))
     * a (nemeni sebe nebo nemeni heslo = nemeni svoje heslo)
     */
    if(!($user = $session->user_info()) /* neprihlasen */
        || (($user['roleid'] > 1) /* neni admin */
            || (($target_role <= 1 /* meni admina */
                || ($field == 'role' && $value <= 1 ) /* nebo roli na admina */
            ) && $user['roleid'] > 0)) /* neni superadmin */
        && (($target_id!=-1 && $target_id!=$user['id']) || $field != 'heslo')){
        return ["success"=>false,"message"=>"permission denied"];
    }
    if($target_id == -1){
        $target_id = $user['id'];
    }
    if($field == 'heslo'){
        $value = password_hash($value,PASSWORD_BCRYPT);
    }
    else if($field != 'jmeno' && $field != 'role' && $field != 'povolen'){
        return ["success"=>false,"message"=>"cannot change $field"];
    }
    return ["success" =>
        $session->update_user($target_id, $target_role, $field, $value)!==false];
}
?>
