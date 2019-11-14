<?php 
namespace Report\Controller\Factory;

use Report\Controller\ConfigController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ConfigControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $controller = new ConfigController();
        $controller->setDbAdapter($container->get('report-model-primary-adapter'));
        return $controller;
    }
}