<?php
// use Application\Custom\Log;

// $log = new Log();
// $log->Alert('teste');

namespace Application\Custom;

use Exception;
use Laminas\Log\Logger as LogLogger;
use Laminas\Log\Writer\Stream;

class Log
{
    private $logger;
    private $ip = "";
    private $route = "";
    private $bronwser = "";
    private $method = "";

    public function __construct()
    {
        $this->logger = new LogLogger();

        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->route = $_SERVER['REQUEST_URI'];
        $this->bronwser = $_SERVER['HTTP_USER_AGENT'];
        $this->method = $_SERVER['REQUEST_METHOD'];

        $dt = date('ymd');
        $stream = @fopen(__DIR__.'/../../logs/log-'.$dt, 'a', false);
        if (! $stream) {
            (new Log())->Err('Failed to open stream /../../logs/log-dt ');
            throw new Exception('Failed to open stream /../../logs/log-$dt ');
        }
        
        $writer = new Stream($stream);

        // $writer = new Stream('php://output');
        $this->logger->addWriter($writer);
        
    }

    public function Debug($msg) {
        $this->logger->log(LogLogger::DEBUG, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);
    }

    public function Info($msg) {
        $this->logger->log(LogLogger::INFO, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);
    }

    public function Notice($msg) {
        $this->logger->log(LogLogger::NOTICE, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);
    }

    public function Warn($msg) {
        $this->logger->log(LogLogger::WARN, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);
    }

    public function Err($msg) {
        $this->logger->log(LogLogger::ERR, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);

    }

    public function Crit($msg) {
        $this->logger->log(LogLogger::CRIT, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);

    }

    public function Alert($msg) {
        $this->logger->log(LogLogger::ALERT, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);

    }

    public function Emerg($msg) {
        $this->logger->log(LogLogger::EMERG, "\n IP: ".$this->ip.", \n Rota: ".$this->route.", \n Método: ".$this->method."  \n Navegador: ".$this->bronwser."\n Msg: ".$msg);
        LogLogger::registerErrorHandler($this->logger);

    }

}