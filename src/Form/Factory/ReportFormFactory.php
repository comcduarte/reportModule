<?php
namespace Report\Form\Factory;

use Interop\Container\ContainerInterface;
use Midnet\Model\Uuid;
use Report\Form\ReportForm;
use Report\Model\ReportModel;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReportFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $uuid = new Uuid();
        $adapter = $container->get('report-model-primary-adapter');
        $form = new ReportForm($uuid->value);
        $model = new ReportModel($adapter);
        
        
        $form->setInputFilter($model->getInputFilter());
//         $form->setDbAdapter($adapter);
        $form->initialize();
        return $form;
        
        
    }
}