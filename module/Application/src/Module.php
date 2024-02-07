<?php

declare(strict_types=1);

namespace Application;

session_cache_limiter('nocache');
session_cache_expire(120);

ini_set('session.save_path', getcwd() . '/temp');
session_start();
ini_set('memory_limit', '2G');
ini_set('display_errors', 'On');
error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
}
