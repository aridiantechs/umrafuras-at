<?php namespace App\Controllers;

use App\Models\Main;
use App\Models\TestingModel;


class Testing extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

    }

    public
    function index()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('server-side-datatable/index', $data);
        echo view('footer', $data);

    }

    public
    function testindex()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('server-side-datatable/test_index', $data);
        echo view('footer', $data);

    }

    public
    function fetch_all_record()
    {


        $TestingModel = new TestingModel();
        $FilteredRecord = $TestingModel->get_all_pilgrims();
        $Record = $TestingModel->get_all_pilgrims($_REQUEST['length'], $_REQUEST['start']);

        $DataArray = array();
        $cnt = $_REQUEST['start'];
        foreach ($Record as $R) {

            $cnt++;

            $raja = array();
            $raja[] = $cnt;
            $raja[] = $R['FirstName'];
            $raja[] = $R['Email'];
            $raja[] = $R['ContactNumber'];
            $raja[] = $R['Password'];

            $DataArray[] = $raja;
        }

//        for($i=1; $i<=5; $i++){
//            $cnt++;
//            $result = array();
//            $result[] = $cnt;
//            $result[] = 'Jawad g '.$cnt.'';
//            $result[] = 'jawad-'.$cnt.'@gamil.com';
//            $result[] = '0000000000';
//            $result[] = '159'.$cnt.'';
//
//            $DataArray[] = $result;
//        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($Record),
            "recordsFiltered" => count($FilteredRecord),
            "data" => $DataArray
        );
        echo json_encode($output);
    }

    public function fetch_server_side()
    {
//       echo "<pre>";print_r($_REQUEST);

        $TestingModel = new TestingModel();
        $filterRecords = $TestingModel->get_all_pilgrams_data();
        $records = $TestingModel->get_all_pilgrams_data($_REQUEST['length'], $_REQUEST['start']);

        $DataArray = array();
        $cnt = $_REQUEST['start'];
        foreach ($records as $value) {
            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = $value['FirstName'];
            $subArray[] = $value['Email'];
            $subArray[] = $value['ContactNumber'];
            $subArray[] = $value['Password'];

            $DataArray[] =  $subArray;

        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);

    }

}
