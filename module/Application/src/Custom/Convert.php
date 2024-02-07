<?php


namespace Application\Custom;

use DateTime;

class Convert
{
    private static $dt;

    public function __construct($dt)
    {
        self::$dt = $dt;
    }
    // $data = !empty($candidate->getNascimento()) ? $candidate->getNascimento()->format('Y-m-d') : ''; echo $data;
    public static function dateBrl($dt){
        // return !empty($dt) ? $dt->format('d-m-Y') : '';
        return !empty($dt) ? $dt->format('d-m-Y') : '';
    }

    public static function dateBrlFull($dt){
        // return !empty($dt) ? $dt->format('d-m-Y') : '';
        return !empty($dt) ? $dt->format('d-m-Y h:i:s') : '';
    }


    public static function dateUsa($dt){
        return !empty($dt) ? $dt->format('Y-m-d') : '';
        // DateTime::createFromFormat('Y-m-d', $dados['nascimento'])
    }

}
