<?php 
namespace Report\Controller;

use Midnet\Controller\AbstractConfigController;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\DropTable;
use Zend\Db\Sql\Ddl\Column\Datetime;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Text;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;

class ConfigController extends AbstractConfigController
{
    public function clearDatabase()
    {
        $sql = new Sql($this->adapter);
        $ddl = [];
        
        $ddl[] = new DropTable('reports');
        
        foreach ($ddl as $obj) {
            $this->adapter->query($sql->buildSqlString($obj), $this->adapter::QUERY_MODE_EXECUTE);
        }
    }

    public function createDatabase()
    {
        $sql = new Sql($this->adapter);
        
        /******************************
         * REPORTS
         ******************************/
        
        $ddl = new CreateTable('reports');
        $ddl->addColumn(new Varchar('UUID', 36));
        
        $ddl->addColumn(new Varchar('NAME', 255, TRUE));
        $ddl->addColumn(new Text('CODE'));
        $ddl->addColumn(new Varchar('VIEW', 255, TRUE));
        
        $ddl->addColumn(new Integer('STATUS', TRUE));
        $ddl->addColumn(new Datetime('DATE_CREATED', TRUE));
        $ddl->addColumn(new Datetime('DATE_MODIFIED', TRUE));
        
        $ddl->addConstraint(new PrimaryKey('UUID'));
        
        $this->adapter->query($sql->buildSqlString($ddl), $this->adapter::QUERY_MODE_EXECUTE);
    }
}