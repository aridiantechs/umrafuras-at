<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Groups;
use App\Models\Main;
use App\Models\Pilgrims;
use App\Models\Reportsprocess;
use App\Models\Users;
use App\Models\Voucher;
use App\Models\Crud;

class Vendor_reports extends BaseController
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

        echo view('header', $data);
        echo view('reports/index', $data);
        echo view('footer', $data);
    }

    public function hotel_brn_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel_brn_vendor', $data);
        echo view('footer', $data);
    }


    public function tpt_brn_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tpt_brn_vendor', $data);
        echo view('footer', $data);
    }

    public function visa_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa_vendor', $data);
        echo view('footer', $data);
    }

    public function hotel_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel_vendor', $data);
        echo view('footer', $data);
    }


    public function transport_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport_vendor', $data);
        echo view('footer', $data);
    }

    public function hotel_brn_vendor_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel_brn_vendor_summary', $data);
        echo view('footer', $data);
    }


    public function tpt_brn_vendor_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tpt_brn_vendor_summary', $data);
        echo view('footer', $data);
    }

    public function visa_vendor_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa_vendor_summary', $data);
        echo view('footer', $data);
    }

    public function hotel_vendor_summary()
    {

        $data = $this->data;
        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');
        echo view('header', $data);
        echo view('reports/vendors/hotel_vendor_summary', $data);
        echo view('footer', $data);
    }


    public function tpt_vendor_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tpt_vendor_summary', $data);
        echo view('footer', $data);
    }

    public function ticket_issue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/ticket_issue', $data);
        echo view('footer', $data);
    }


    public function ticket_reissue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/ticket_reissue', $data);
        echo view('footer', $data);
    }

    public function refund()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/refund', $data);
        echo view('footer', $data);
    }

    public function adm()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/adm', $data);
        echo view('footer', $data);
    }

    public function groupwise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/groupwise', $data);
        echo view('footer', $data);
    }

    public function detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/detail_report', $data);
        echo view('footer', $data);
    }

    public function country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/country_wise', $data);
        echo view('footer', $data);
    }

    public function month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/month_wise', $data);
        echo view('footer', $data);
    }

    public function year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/year_wise', $data);
        echo view('footer', $data);
    }

    public function airline_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/airline_wise', $data);
        echo view('footer', $data);
    }

    public function international()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/international', $data);
        echo view('footer', $data);
    }


    public function domestic()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/domestic', $data);
        echo view('footer', $data);
    }

    public function detail_report_amount_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket/detail_report_amount_wise', $data);
        echo view('footer', $data);
    }

    public function reject_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/reject_visa', $data);
        echo view('footer', $data);
    }

    public function visa_issue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/visa_issue', $data);
        echo view('footer', $data);
    }

    public function refund_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/refund_visa', $data);
        echo view('footer', $data);
    }


    public function visa_detail()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/visa_detail', $data);
        echo view('footer', $data);
    }


    public function vendor_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/vendor_country_wise', $data);
        echo view('footer', $data);
    }

    public function visa_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/visa_country_wise', $data);
        echo view('footer', $data);
    }

    public function visa_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/visa_month_wise', $data);
        echo view('footer', $data);
    }


    public function visa_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa/visa_year_wise', $data);
        echo view('footer', $data);
    }

    public function cancel_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/cancel_booking', $data);
        echo view('footer', $data);
    }

    public function confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/confirm_booking', $data);
        echo view('footer', $data);
    }

    public function hotel_refund()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_refund', $data);
        echo view('footer', $data);
    }

    public function change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/change_booking', $data);
        echo view('footer', $data);
    }

    public function hotel_allotment()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_allotment', $data);
        echo view('footer', $data);
    }

    public function hotel_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_detail_report', $data);
        echo view('footer', $data);
    }

    public function hotel_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_country_wise', $data);
        echo view('footer', $data);
    }

    public function hotel_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_category_wise', $data);
        echo view('footer', $data);
    }

    public function hotel_with_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_with_month_wise', $data);
        echo view('footer', $data);
    }

    public function hotel_with_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel/hotel_with_year_wise', $data);
        echo view('footer', $data);
    }

    public function tpt_confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_confirm_booking', $data);
        echo view('footer', $data);
    }

    public function tpt_refund_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_refund_booking', $data);
        echo view('footer', $data);
    }

    public function tpt_change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_change_booking', $data);
        echo view('footer', $data);
    }

    public function tpt_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_detail_report', $data);
        echo view('footer', $data);
    }


    public function tpt_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_country_wise', $data);
        echo view('footer', $data);
    }

    public function tpt_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_category_wise', $data);
        echo view('footer', $data);
    }

    public function tpt_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_month_wise', $data);
        echo view('footer', $data);
    }


    public function tpt_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport/tpt_year_wise', $data);
        echo view('footer', $data);
    }


    public function tour_confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_confirm_booking', $data);
        echo view('footer', $data);
    }

    public function tour_change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_change_booking', $data);
        echo view('footer', $data);
    }

    public function tour_refund_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_refund_booking', $data);
        echo view('footer', $data);
    }


    public function tour_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_detail_report', $data);
        echo view('footer', $data);
    }

    public function tour_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_country_wise', $data);
        echo view('footer', $data);
    }

    public function tour_package_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_package_category_wise', $data);
        echo view('footer', $data);
    }


    public function tour_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_month_wise', $data);
        echo view('footer', $data);
    }

    public function tour_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tours/tour_year_wise', $data);
        echo view('footer', $data);
    }

    public function visitor_vendor_reports()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/visitors', $data);
        echo view('footer', $data);
    }

    public function unique_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/unique_visitor', $data);
        echo view('footer', $data);
    }

    public function old_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/old_visitor', $data);
        echo view('footer', $data);
    }

    public function confirm_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/confirm_visitor', $data);
        echo view('footer', $data);
    }

    public function not_interested_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/not_interested_visitor', $data);
        echo view('footer', $data);
    }

    public function visitor_subscriber()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/subscribers', $data);
        echo view('footer', $data);
    }

    public function visitor_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/detail_report', $data);
        echo view('footer', $data);
    }

    public function visitor_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/country_wise', $data);
        echo view('footer', $data);
    }

    public function unsuccessful_product_wise_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/unsuccessful_product_wise', $data);
        echo view('footer', $data);
    }

    public function successful_product_wise_visitor_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/successful_product_wise', $data);
        echo view('footer', $data);
    }

    public function visitor_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/month_wise', $data);
        echo view('footer', $data);
    }

    public function visitor_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor/year_wise', $data);
        echo view('footer', $data);
    }
}
