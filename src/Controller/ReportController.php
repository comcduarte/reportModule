<?php 
namespace Report\Controller;

use Midnet\Controller\AbstractBaseController;
use Report\Model\ReportModel;
use Zend\Db\ResultSet\ResultSet;
use RuntimeException;
use Report\Form\ReportRequestForm;

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
        $data = NULL;
        $i = 0;
        
        $request = $this->getRequest();
        $form = new ReportRequestForm();
        if ($request->isPost()) {
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
                );
            $form->setData($data);
            
            if ($form->isValid()) {
                $uuid = $data['UUID'];
            }
        }
        
        if (!$uuid) {
            throw new \Exception('Missing UUID');
        }
        
        $report = new ReportModel($this->adapter);
        $report->read(['UUID' => $uuid]);
        
        $revised_code = "";
        
        $vars = [];
        for ($i = 0; $i < $data['NUM_VARS']; $i++) {
            $vars[] = $data['FIELD' . $i];
            $vars[] = $data['VALUE' . $i];
        }
        $revised_code = vsprintf($report->CODE, $vars);
            
            
        
        $statement = $this->adapter->createStatement($revised_code);
        
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
