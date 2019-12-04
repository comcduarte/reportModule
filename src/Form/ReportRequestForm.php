<?php
namespace Report\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Submit;

class ReportRequestForm extends Form
{
    public $num_vars = 0;
    
    public function initialize()
    {
        $this->add([
            'name' => 'UUID',
            'type' => Hidden::class,
            'attributes' => [
                'id' => 'UUID',
                'class' => 'form-control',
                'required' => 'true',
            ],
            'options' => [
                'label' => 'UUID',
            ],
        ],['priority' => 0]);
        
        $this->add([
            'name' => 'NUM_VARS',
            'type' => Hidden::class,
            'attributes' => [
                'id' => 'NUM_VARS',
                'class' => 'form-control',
                'required' => 'true',
                'value' => $this->num_vars,
            ],
            'options' => [
                'label' => 'UUID',
            ],
        ],['priority' => 0]);
        
        for ($i = 0; $i < $this->num_vars; $i++) {
            $this->add([
                'name' => 'FIELD' . $i,
                'type' => Hidden::class,
                'attributes' => [
                    'id' => 'FIELD' . $i,
                    'class' => 'form-control',
                    'required' => 'true',
                ],
            ],['priority' => 0]);
            
            $this->add([
                'name' => 'VALUE' . $i,
                'type' => Hidden::class,
                'attributes' => [
                    'id' => 'VALUE' . $i,
                    'class' => 'form-control',
                    'required' => 'true',
                ],
            ],['priority' => 0]);
        }
        
        $this->add(new Csrf('SECURITY'),['priority' => 0]);
        
        $this->add([
            'name' => 'SUBMIT',
            'type' => Submit::class,
            'attributes' => [
                'value' => 'Submit',
                'class' => 'btn btn-primary form-control mt-4',
                'id' => 'SUBMIT',
            ],
        ],['priority' => 0]);
    }
}
