<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Users;

class Transport extends BaseController
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
        echo view('transport/client', $data);
        echo view('footer', $data);
    }

    public function bookings()
    {
        $data = $this->data;

//        $data['Link'] = getSegment(3);


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/booking', $data);
        }else{
        echo view('transport/booking', $data);
        }
        echo view('footer', $data);
    }

    public function change_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/change_booking', $data);
        }else{

        echo view('transport/change_booking', $data);
        }
        echo view('footer', $data);
    }


    public function pending_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/pending_booking', $data);
        }else{

        echo view('transport/pending_booking', $data);
        }
        echo view('footer', $data);
    }
    public function confirm_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/confirm_booking', $data);
        }else{

        echo view('transport/confirm_booking', $data);
        }
        echo view('footer', $data);
    }
    public function expire_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/expire_booking', $data);
        }else{

        echo view('transport/expire_booking', $data);
        }
        echo view('footer', $data);
    }

    public function cancel_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/cancel_booking', $data);
        }else{

        echo view('transport/cancel_booking', $data);
        }
        echo view('footer', $data);
    }

    public function refund_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/refund_booking', $data);
        }else{

        echo view('transport/refund_booking', $data);
        }
        echo view('footer', $data);
    }

    public function tomorrow_vehicle_required()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/tomorrow_vehicle_required', $data);
        }else{

        echo view('transport/tomorrow_vehicle_required', $data);
        }
        echo view('footer', $data);
    }

    public function visitor()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/visitor', $data);
        }else{

        echo view('transport/visitor', $data);
        }
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('transport/wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('transport/inbox', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('transport/query', $data);
        echo view('footer', $data);
    }


    public function detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/reports/detail_report', $data);
        }else{

        echo view('transport/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }



    public function country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/reports/country_wise', $data);
        }else{

        echo view('transport/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/reports/category_wise', $data);
        }else{

        echo view('transport/reports/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/reports/month_wise', $data);
        }else{

        echo view('transport/reports/month_wise', $data);
        }
        echo view('footer', $data);
    }
    public function year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/transport/reports/year_wise', $data);
        }else{

        echo view('transport/reports/year_wise', $data);
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
        echo view('transport/bulk_pilgrim', $data);
        echo view('footer', $data);
    }



}
