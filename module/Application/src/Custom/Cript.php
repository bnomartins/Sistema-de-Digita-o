<?php
// use Application\Custom\Log;

// $log = new Log();
// $log->Alert('teste');

namespace Application\Custom;

use Exception;
use Laminas\Log\Logger as LogLogger;
use Laminas\Log\Writer\Stream;

class Cript
{

    private $ciphering = "AES-128-CTR";
    private $options = 0;
    private $encryption_iv = '1234567891011121';
    private $decryption_iv = '1234567891011121';
    private $encryption_key = "keyBno@2023";
    private $decryption_key = "keyBno@2023";

    public function cript($msg){

        // $Chave =  random_bytes(32);
        $IV = random_bytes(openssl_cipher_iv_length($this->ciphering)); 

        $TextoCifrado = openssl_encrypt($msg, $this->ciphering, $this->encryption_key, OPENSSL_RAW_DATA, $IV);

        return base64_encode($IV.$TextoCifrado);
    }

    public function decript($msg){
        $Resultado = base64_decode($msg);

        $TextoCifrado = mb_substr($Resultado, openssl_cipher_iv_length($this->ciphering), null, '8bit');
        
        //$Chave = pack('H*', 'be3494ff4904fd83bf78e3cec0d38ddbf48d0a6a666be05420667a5a7d2c4e0d');
        $IV = mb_substr($Resultado, 0, openssl_cipher_iv_length($this->ciphering), '8bit');
        
        return openssl_decrypt($TextoCifrado, $this->ciphering, $this->decryption_key, OPENSSL_RAW_DATA, $IV);
    }

}