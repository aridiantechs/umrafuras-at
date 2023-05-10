<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Users;

class Hotel extends BaseController
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
        echo view('hotel/client', $data);
        echo view('footer', $data);
    }

    public function bookings()
    {
        $data = $this->data;

//        $data['Link'] = getSegment(3);

        echo view('header', $data);

        if($data['session']['domainid']==0){
            echo view('main/hotel/booking', $data);
        } else {
            echo view('hotel/booking', $data);
        }

        echo view('footer', $data);
    }

    public function confirm_booking()
    {
        $data = $this->data;
        //print_r($data);exit;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/confirm_booking', $data);
        } else {
            echo view('hotel/confirm_booking', $data);
        }
        echo view('footer', $data);
    }

    public function pending_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid'] == 0){
            echo view('main/hotel/pending_booking', $data);
        } else{
            echo view('hotel/pending_booking', $data);
        }
        echo view('footer', $data);
    }

    public function expire_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/expire_booking', $data);
        } else {
            echo view('hotel/expire_booking', $data);
        }
        echo view('footer', $data);
    }

    public function change_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/change_booking', $data);
        } else {
            echo view('hotel/change_booking', $data);
        }
        echo view('footer', $data);
    }

    public function cancle_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/cancle_booking', $data);
        } else {
            echo view('hotel/cancle_booking', $data);
        }
        echo view('footer', $data);
    }

    public function tomorrow_checkin()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/tomorrow_checkin', $data);
        } else {
            echo view('hotel/tomorrow_checkin', $data);

        }
        echo view('footer', $data);
    }

    public function tomorrow_checkout()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/tomorrow_checkout', $data);
        } else {
            echo view('hotel/tomorrow_checkout', $data);
        }
        echo view('footer', $data);
    }

    public function refund_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/refund_booking', $data);
        } else {
            echo view('hotel/refund_booking', $data);

        }
        echo view('footer', $data);
    }

    public function detail_report()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/detail_report', $data);
        } else {

            echo view('hotel/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function country_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/country_wise', $data);
        } else {
            echo view('hotel/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function category_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/category_wise', $data);
        } else {
            echo view('hotel/reports/category_wise', $data);
        }
        echo view('footer', $data);
    }

//    public function hotel_wise()
//    {
//        $data = $this->data;
//
//
//        echo view('header', $data);
//        if($data['session']['domainid']==0){
//            echo view('main/hotel/reports/hotel_wise', $data);
//        } else {
//            echo view('hotel/reports/hotel_wise', $data);
//
//        }
//        echo view('footer', $data);
//    }

    public function hotel_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('hotel/reports/hotel_wise', $data);
        echo view('footer', $data);
    }



    public function hotel_category_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/hotel_category_wise', $data);
        } else {
            echo view('hotel/reports/hotel_category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function hotel_month_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/hotel_month_wise', $data);
        } else {

            echo view('hotel/reports/hotel_month_wise', $data);
        }
        echo view('footer', $data);
    }


    public function hotel_year_wise()
    {
        $data = $this->data;


        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/reports/hotel_year_wise', $data);
        } else {

            echo view('hotel/reports/hotel_year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function tomorrow_vehicle_required()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('hotel/tomorrow_vehicle_required', $data);
        echo view('footer', $data);
    }

    public function visitor()
    {
        $data = $this->data;

        echo view('header', $data);
        if($data['session']['domainid']==0){
            echo view('main/hotel/visitors', $data);
        } else {

            echo view('hotel/visitors', $data);
        }
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('hotel/wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('hotel/inbox', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('hotel/query', $data);
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
        echo view('hotel/bulk_pilgrim', $data);
        echo view('footer', $data);
    }



}
