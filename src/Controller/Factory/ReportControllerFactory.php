<?php 
namespace Report\Controller\Factory;

use Interop\Container\ContainerInterface;
use Midnet\Model\Uuid;
use Report\Controller\ReportController;
use Report\Form\ReportForm;
use Report\Model\ReportModel;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReportControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $adapter = $container->get('report-model-primary-adapter');
        $controller = new ReportController();
        $model = new ReportModel($adapter);
        $form = $container->get('FormElementManager')->get(ReportForm::class);
        
        $uuid = new Uuid();
        $date = new \DateTime('now',new \DateTimeZone('EDT'));
        $today = $date->format('Y-m-d H:i:s');
        
        $model->UUID = $uuid->value;
        $model->DATE_CREATED = $today;
        $model->STATUS = $model::ACTIVE_STATUS;
        
        $controller->setModel($model);
        $controller->setDbAdapter($adapter);
        $controller->setForm($form);
        return $controller;
    }
}