<?php
function register($session){
    if($session->user_info()){
        return false;
    }
    $allvalid = true;
    $name = $_POST['jmeno'] ?? null;
    $login = $_POST['login'] ?? null;
    $pw = $_POST['heslo'] ?? null;
    $pw2 = $_POST['heslo2'] ?? null;
    $result = [
        'success'=>'false',
        'redirect'=>'register'
        //'redirect'=>'ajax'
    ];
    foreach(['jmeno','login','heslo','heslo2'] as $i){
        $result[$i] = ['value'=>$_POST[$i] ?? ''];
    }
    if(empty($name) || strlen($name)>64 || !preg_match("/.+ .+/",$name)){
        $result['jmeno']['invalid'] = true;
        $allvalid = false;
    }
    if(empty($login) || strlen($login)>32 || !preg_match(SAFE_NAME_REGEX,$login)){
        $result['login']['invalid'] = true;
        $allvalid = false;
    }
    else if(!$session->is_username_available($_POST['login'])){
        $result['login']['invalid'] = true;
        $result['login']['used'] = true;
        $allvalid = false;
    }
    if(empty($pw)){
        $result['heslo']['invalid'] = true;
        $allvalid = false;
    }
    if($pw != $pw2){
        $result['heslo2']['invalid'] = true;
        $allvalid = false;
    }
    if(!$allvalid){
        return $result;
    }
    if(!$session->register($name,$login,$pw)){
        $result['alert'] = [
            'class' => 'danger',
            'message' => 'Při registraci došlo k neočekávané chybě.',
            'dismissible' => true
        ];
        return $result;
    }
    return ['success'=>true];
}
?>