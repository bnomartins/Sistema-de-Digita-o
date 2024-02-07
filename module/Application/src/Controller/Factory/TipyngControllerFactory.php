<?php

/**
 * Created by PhpStorm.
 * User: bruno.gurgel
 * Date: 18/04/17
 * Time: 13:47
 */
namespace Application\Controller\Factory;

use Application\Controller\TipyngController;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;


class TipyngControllerFactory implements FactoryInterface {
    public function __invoke(ContainerInterface $container, $requestedName = null, array $options = null) {
        return new TipyngController($container->get(\Doctrine\ORM\EntityManager::class));
    }
}
