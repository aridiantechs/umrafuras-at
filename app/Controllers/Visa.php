<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Users;

class Visa extends BaseController
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
        echo view('visa/client', $data);
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
            echo view('main/visa/booking', $data);
        } else {
            echo view('visa/booking', $data);
        }
        echo view('footer', $data);
    }

    public function pending_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/pending_booking', $data);
        } else {
            echo view('visa/pending_booking', $data);
        }
        echo view('footer', $data);
    }

    public function confirm_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/confirm_booking', $data);
        } else {
            echo view('visa/confirm_booking', $data);
        }
        echo view('footer', $data);
    }

    public function expire_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/expire_booking', $data);
        } else {
            echo view('visa/expire_booking', $data);
        }
        echo view('footer', $data);
    }

    public function cancel_booking()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/cancel_booking', $data);
        } else {
            echo view('visa/cancel_booking', $data);
        }
        echo view('footer', $data);
    }


    public function visa_issue()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/visa_issue', $data);
        } else {
            echo view('visa/visa_issue', $data);
        }
        echo view('footer', $data);
    }

    public function visa_reject()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/visa_reject', $data);
        } else {
            echo view('visa/visa_reject', $data);
        }
        echo view('footer', $data);
    }

    public function visa_refund()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/visa_refund', $data);
        } else {
            echo view('visa/visa_refund', $data);
        }
        echo view('footer', $data);
    }

    public function detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/reports/detail_report', $data);
        } else {
            echo view('visa/reports/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/reports/country_wise', $data);
        } else {
            echo view('visa/reports/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/reports/category_wise', $data);
        } else {
            echo view('visa/reports/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/reports/month_wise', $data);
        } else {
            echo view('visa/reports/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/reports/year_wise', $data);
        } else {
            echo view('visa/reports/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function visitors()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/visa/visitors', $data);
        } else {
            echo view('visa/visitors', $data);
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
        echo view('visa/bulk_pilgrim', $data);
        echo view('footer', $data);
    }


}
