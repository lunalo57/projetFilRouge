<?php

function debug($variable){
    echo '<pre>' . print_r($variable , true) . '</pre>';
}


function str_random($length){
    $alphabet ="0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet,$length)), 0 , $length);
}

function logged_only(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header("Location: ../skeleton/login.php");
        exit();
    }
}

function reconnect_from_cookie(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once 'db.php';
        if(!isset($pdo)){
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $userIdd = $parts[0];
        // debug($userIdd);
        $req = $pdo -> prepare("SELECT * FROM tbl_user WHERE user_id = ?");
        $req -> execute([$userIdd]);
        $user = $req -> fetch();
        if($user){
            $expected = $userIdd . '==' . $user -> remember_token . sha1($userIdd . 'respireMec');
            if($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember',$remember_token,time() + 60 * 60 * 24 * 7);
            }else{
                setcookie('remember',null, -1);
            }
        }else{
            setcookie('remember',null, -1);
        }
    }
}
