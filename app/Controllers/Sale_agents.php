<?php namespace App\Controllers;
use App\Models\Agents;
use App\Models\Main;
use App\Models\Pilgrims;
use App\Models\SaleAgent;
use App\Models\Voucher;

class Sale_agents extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
    }

    public function index()
    {
        $data = $this->data;

        $Agents = new SaleAgent();
        $data['records'] = $Agents->ListSalesAgent();
        //print_r($data['records']);exit;


        echo view('header', $data);
        echo view('sale_agents/index', $data);
        echo view('footer', $data);
    }

    public function sub_agents()
    {
        $data = $this->data;

        $Agents = new Agents();
        $data['records'] = $Agents->ListSubAgents();

        echo view('header', $data);
        echo view('agent/sub_agents', $data);
        echo view('footer', $data);
    }

    public function profile()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('agent/profile', $data);
        echo view('footer', $data);
    }

    public
    function load_sale_agent_refer_agents(){

        $SaleAgent = new SaleAgent();
        $UID = $this->request->getVar('UID');
        $ReferAgentsData = $SaleAgent->LoadSaleAgentsReferAgents($UID);

        echo json_encode($ReferAgentsData);
    }


}
