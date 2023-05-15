<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Users;

class Ticket extends BaseController
{
    var $data = array();
    var $MainModel;
    var $helpers = ['Curl_Helper'];

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        //echo "<pre>"; print_r($this->data); exit;

        $session = session();
        $this->MainModel->CheckUser($session->get());
    }

    public function client()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('ticket/client', $data);
        echo view('footer', $data);
    }
    public function bulk_pilgrim(){
        $data = $this->data;

        //start
        $session = session();
        $data['session'] = $session->get();
        $Packages = new Packages();
        $Crud = new Crud();
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['TransportTypes'] = $Packages->ListTransport();

        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        $data['ziarat'] = $Packages->ListZiyarats();
        //end

        echo view('header', $data);
        echo view('ticket/bulk_pilgrim', $data);
        echo view('footer', $data);
    }


    public function bookings()
    {
        $data = $this->data;
        helper(['curl','Curl_Helper']);
        // echo('<pre>');
        // print_r($this->request->getVar('agent_name'));
        // print_r($this->request->getMethod());
        // die();
        if($this->request->getMethod() == "post"){
            $agentname = $this->request->getVar('agent_name');
            $email = $this->request->getVar('email');

            $get_endpoint = '/booking/all?agent_name='.$agentname.'&email='.$email;
            $response = perform_http_request('GET', $get_endpoint);
            
            $data['bookings'] = json_decode($response['body']);
        }else{
            $get_endpoint = '/booking/all';
            
            $response = perform_http_request('GET', $get_endpoint);
            
            $data['bookings'] = json_decode($response['body']);
        }
		

        echo view('header', $data);
        
        // if ($data['session']['domainid'] == 0) {
        //     echo view('main/ticket/booking', $data); // umrahfuras panel
        // } else {
            echo view('ticket/booking', $data); // lalaservices panel and localhost
        // }
        echo view('footer', $data);
    }

    public function pending_booking()
    {
        $data = $this->data;
        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/pending_booking', $data);
        } else {
            echo view('ticket/pending_booking', $data);
        }
        echo view('footer', $data);
    }

    public function confirm_booking()
    {
        $data = $this->data;
        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/confirm_booking', $data);
        } else {

            echo view('ticket/confirm_booking', $data);
        }
        echo view('footer', $data);
    }

    public function expire_booking()
    {
        $data = $this->data;
        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/expire_booking', $data);
        } else {

            echo view('ticket/expire_booking', $data);
        }
        echo view('footer', $data);
    }

    public function cancel_booking()
    {
        $data = $this->data;
        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/cancel_booking', $data);
        } else {

            echo view('ticket/cancel_booking', $data);
        }
        echo view('footer', $data);
    }


    public function change_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/change_booking', $data);
        } else {
            echo view('ticket/change_booking', $data);

        }
        echo view('footer', $data);
    }

    public function refund_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('ticket/refund_booking', $data);
        echo view('footer', $data);
    }

    public function tomorrow_vehicle_required()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('ticket/tomorrow_vehicle_required', $data);
        echo view('footer', $data);
    }

    public function visitor()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/visitor', $data);
        } else {

            echo view('ticket/visitor', $data);
        }
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('ticket/wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('ticket/inbox', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('ticket/query', $data);
        echo view('footer', $data);
    }

    public function detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/detail_report', $data);
        } else {

            echo view('ticket/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/country_wise', $data);
        } else {

            echo view('ticket/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function airline_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/airline_wise', $data);
        } else {

            echo view('ticket/reports/airline_wise', $data);
        }
        echo view('footer', $data);
    }

    public function group_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/group_wise', $data);
        } else {

            echo view('ticket/reports/group_wise', $data);
        }
        echo view('footer', $data);
    }

    public function domestic()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/domestic', $data);
        } else {

            echo view('ticket/reports/domestic', $data);
        }
        echo view('footer', $data);
    }

    public function ticket_issue()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/ticket_issue', $data);
        } else {

            echo view('ticket/ticket_issue', $data);
        }
        echo view('footer', $data);
    }

    public function ticket_reissue()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/ticket_reissue', $data);
        } else {

            echo view('ticket/ticket_reissue', $data);
        }
        echo view('footer', $data);
    }

    public function ticket_refund()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/ticket_refund', $data);
        } else {
            echo view('ticket/ticket_refund', $data);
        }
        echo view('footer', $data);
    }

    public function traveling_tomorrow()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/traveling_tomorrow', $data);
        } else {

            echo view('ticket/traveling_tomorrow', $data);
        }
        echo view('footer', $data);
    }

    public function adm()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/adm', $data);
        } else {

            echo view('ticket/adm', $data);
        }
        echo view('footer', $data);
    }

    public function international()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/international', $data);
        } else {

            echo view('ticket/reports/international', $data);
        }
        echo view('footer', $data);
    }

    public function category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('ticket/reports/category_wise', $data);
        echo view('footer', $data);
    }

    public function month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/month_wise', $data);
        } else {

            echo view('ticket/reports/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/ticket/reports/year_wise', $data);
        } else {

            echo view('ticket/reports/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function accounts()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('ticket/reports/accounts', $data);
        echo view('footer', $data);
    }
    public function add_new_pilgrim(){
        $data = $this->data;

        $ID = getSegment(3);
        $Pilgrims = new Pilgrims();
        $data['pilgrim_data'] = $Pilgrims->PilgrimsData($ID);
        $data['pilgrim_passport_data'] = $Pilgrims->PilgrimsPassportData($ID);
        $data['pilgrim_attachments'] = $Pilgrims->PilgrimsAttachmentsData($ID);

        $Operators = new Users();
        $data['OperatorsData'] = $Operators->ListOperators();


        $data['AccountsData'] = $Pilgrims->PilgrimAccountData($ID);
//        print_r($data['AccountsData']);

        echo view('header', $data);
        echo view('ticket/pilgrim/main_form', $data);
        echo view('footer', $data);
    }


}
