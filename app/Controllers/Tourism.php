<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Main;
use App\Models\Crud;
use App\Models\Users;
use App\Models\Packages;

class Tourism extends BaseController
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

    public function client()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/client', $data);
        echo view('footer', $data);
    }

    public function bookings()
    {
        $data = $this->data;
//        echo "<pre>";
//        print_r($data);exit;
//        $data['Link'] = getSegment(3);


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/booking', $data);
        } else {

            echo view('tourism/booking', $data);
        }
        echo view('footer', $data);
    }


    public function pending_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/pending_booking', $data);
        } else {

            echo view('tourism/pending_booking', $data);
        }
        echo view('footer', $data);
    }

    public function confirm_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/confirm_booking', $data);
        } else {
            echo view('tourism/confirm_booking', $data);

        }
        echo view('footer', $data);
    }

    public function expire_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/expire_booking', $data);
        } else {

            echo view('tourism/expire_booking', $data);
        }
        echo view('footer', $data);
    }

    public function cancel_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/cancel_booking', $data);
        } else {
            echo view('tourism/cancel_booking', $data);
        }

        echo view('footer', $data);
    }

    public function change_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/change_booking', $data);
        } else {
            echo view('tourism/change_booking', $data);

        }
        echo view('footer', $data);
    }

    public function refund_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/refund_booking', $data);
        } else {

            echo view('tourism/refund_booking', $data);
        }
        echo view('footer', $data);
    }

    public function tomorrow_vehicle_required()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/tomorrow_vehicle_required', $data);
        echo view('footer', $data);
    }

    public function visitor()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/visitor', $data);
        } else{
            echo view('tourism/visitor', $data);

        }
        echo view('footer', $data);
    }

    public function users()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/users', $data);
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/inbox', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('tourism/query', $data);
        echo view('footer', $data);
    }


    public function detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/reports/detail_report', $data);
        } else{

            echo view('tourism/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }


    public function country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/reports/country_wise', $data);
        } else{

        echo view('tourism/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/reports/category_wise', $data);
        } else{

        echo view('tourism/reports/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/reports/month_wise', $data);
        } else{

        echo view('tourism/reports/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/tourism/reports/year_wise', $data);
        } else{

        echo view('tourism/reports/year_wise', $data);
        }
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
        echo view('tourism/bulk_pilgrim', $data);
        echo view('footer', $data);
    }



}
