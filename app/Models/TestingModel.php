<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Crud;


class TestingModel extends Model
{
    var $data = array();
    var $MainModel;


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function get_all_pilgrims($limit = '', $start = '')
    {

        $Crud = new Crud();
        $SQl = ' SELECT * FROM pilgrim."master"';
        if ($limit != '' && $start != '' && $limit != -1) {
            $SQl .= ' LIMIT ' . $limit . ' OFFSET ' . $start . ' ';
        }
        $PilgrimsData = $Crud->ExecuteSQL($SQl);

        return $PilgrimsData;
    }

    public function get_all_pilgrams_data($limit = '', $offset = '')
    {
        $Crud = new Crud();
        $sql = 'SELECT * FROM pilgrim."master"';
        if ($limit != '' && $offset != '' && $limit != -1) {
            $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $pilgramsrecords = $Crud->ExecuteSQL($sql);
        return $pilgramsrecords;

    }


}
