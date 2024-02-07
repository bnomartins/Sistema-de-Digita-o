<?php


namespace Application\Custom;

use DateTime;

class VerifySession
{
    public static function verify($token){

        if(isset($_SESSION['token'])){

            $dec = (new Cript())->decript($token);      
            $data = date('dmY-');
            $nome = !empty($_SESSION['user']['nome']) ? $_SESSION['user']['nome'] : '';
            $email = !empty($_SESSION['user']['email']) ? $_SESSION['user']['email'] : '';
            $ext = !empty($_SESSION['user']['nome']) ? "@#BrUn0S3c" : '';
            
            if($dec !== $data.$nome.$email.$ext){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public static function generate(){
        return (new Cript())->cript(date('dmY-').$_SESSION['user']['nome'].$_SESSION['user']['email']."@#BrUn0S3c");
    }


}
