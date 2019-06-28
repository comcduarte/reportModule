<?php 
namespace Report\Controller;

use Midnet\Controller\AbstractBaseController;
use Report\Model\ReportModel;
use Zend\Db\ResultSet\ResultSet;
use RuntimeException;

class ReportController extends AbstractBaseController
{
    public function createAction()
    {
        $view = parent::createAction();
        $view->setTemplate('report/report/create.phtml');
        return $view;
    }
    
    public function updateAction()
    {
        $view = parent::updateAction();
        $view->setTemplate('report/report/create.phtml');
        return $view;
    }
    
    public function viewAction()
    {
        $this->layout('report/layouts/report.phtml');
        
        $uuid = $this->params()->fromRoute('uuid',0);
        if (!$uuid) {
            throw new \Exception('Missing UUID');
        }
        
        $report = new ReportModel($this->adapter);
        $report->read(['UUID' => $uuid]);
        
        $statement = $this->adapter->createStatement($report->CODE);
        
        try {
            $resultSet = new ResultSet();
            $data = $statement->execute();
            $resultSet->initialize($data);
        } catch (RuntimeException $e) {
            return $e;
        }
        
        return ([
            'data' => $resultSet->toArray(),
            'view' => $report->VIEW,
            'title' => $report->NAME,
        ]);
    }
}
