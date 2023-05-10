<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Api;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Voucher;
use App\Models\Dashboard;

class Selects extends BaseController
{
    var $data = array();

    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        if ($this->data['page'] != 'login') {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }
    }

    public function default()
    {
        //echo "<pre>";
        $data = $this->data;
        $Crud = new Crud();
        $q = strtolower($_GET['q']);

        $SQL = 'SELECT * FROM main."Airports" WHERE LOWER("Name") LIKE \'%'.$q.'%\' OR LOWER("Code") LIKE \'%'.$q.'%\' LIMIT 50';
        $Airports = $Crud->ExecuteSQL($SQL);
        $final = array();
        foreach ($Airports as $Airport) {
            $temp = array();
            $temp['id'] = $Airport['UID'];
            $temp['name'] = $Airport['Code'] . " - " . $Airport['Name'];
            $final[] = $temp;
        }
        echo json_encode($final);
    }

    public function airports()
    {
        $data = $this->data;
        $Crud = new Crud();
        $q = strtolower($_GET['q']);

        $SQL = 'SELECT * FROM main."Airports" WHERE LOWER("Name") LIKE \'%'.$q.'%\' OR LOWER("Code") LIKE \'%'.$q.'%\' LIMIT 50';
        $Airports = $Crud->ExecuteSQL($SQL);
        $final = array();
        foreach ($Airports as $Airport) {
            $temp = array();
            $temp['id'] = $Airport['UID'];
            $temp['name'] = $Airport['Code'] . " - " . $Airport['Name'];
            $final[] = $temp;
        }
        echo json_encode($final);

    }

}
