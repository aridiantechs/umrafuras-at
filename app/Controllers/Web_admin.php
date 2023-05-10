<?php namespace App\Controllers;
use App\Models\Crud;
use App\Models\Users;
use App\Models\Main;
class Web_admin extends BaseController
{
    var $data = array();

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());

    }

    public function index()
    {
        $data = $this->data;


        $Operators = new Users();
        $data['records'] = $Operators->ListOperators();

        list($domain_id) = explode( "-", getSegment(3));

        $Crud = new Crud();
        $table = 'websites."Settings"';
        $where = array("DomainID" => $domain_id);
        $data['AllSettings'] = $Crud->ListRecords($table, $where, array("Segment"=>"ASC","Name"=>"ASC",));

        $table = 'websites."Domains"';
        $where = array("UID" => $domain_id);
        $data['DomainData'] = $Crud->SingleRecord($table, $where);

        $pages = array();
        $table = 'websites."contents"';
        $where = array("DomainID" => $domain_id, "Archive" => 0);
        $pages['contents'] = $Crud->ListRecords($table, $where);

        $table = 'websites."contents_meta"';
        $where = array("DomainID" => $domain_id, "Archive" => 0);
        $pages['contentsMeta'] = $Crud->ListRecords($table, $where);
        $data['pages'] = $pages;
        $data['DomainID'] = $domain_id;

        //echo "<pre>"; print_r($data['pages']); exit;


        echo view('header', $data);
        echo view('websites/index', $data);
        echo view('footer', $data);
    }
}
