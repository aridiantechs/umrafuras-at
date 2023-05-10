<?php namespace App\Controllers;

use App\Models\Admin;
use App\Models\Api;
use App\Models\BrnRecords;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\SaleAgent;
use App\Models\Users;
use App\Models\Agents;
use App\Models\Voucher;

use DateTime;

class Filters_session extends BaseController
{
    protected $session;
    protected $table = 'websites."Domains"';

    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();

        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        $data['parent_mis'] = array('panel.lalaservices.com');

        if ($this->data['module'] != 'filters_session' && $this->data['page'] != 'system_user_form_submit') {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }

        $session = session();
        $data['session'] = $session->get();
    }

    public
    function create_filters_session()
    {
//        echo "<pre>";
//        print_r($_REQUEST);
//        exit;
        $session = session();
        $SessionKey = $this->request->getVar('SessionKey');
        $session->set($SessionKey, '');
        $session->set($SessionKey, $_REQUEST);

        $response = array();
        $response['status'] = 'success';
        $response['msg'] = 'Session Filters Created Successfully';
        $response['session'] = $session->get($SessionKey);

        echo json_encode($response);
    }

    public
    function clear_filters_session()
    {

        $session = session();
        $SessionKey = $this->request->getVar('SessionKey');
        $session->set($SessionKey, '');

        $response = array();
        $response['status'] = 'success';
        $response['msg'] = 'Session Filters Clear Successfully';
        echo json_encode($response);
    }

}
