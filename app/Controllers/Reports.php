<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Reportsprocess;
use App\Models\Users;
use App\Models\Voucher;
use DateTime;

class Reports extends BaseController
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


    public function stats()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/stats', $data);
        echo view('footer', $data);
    }


    public function hajj_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hajj_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function hotel_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/hotel_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function ticket_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/ticket_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function tourism_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/tourism_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function transport_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/transport_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function umrah_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/umrah_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function visa_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visa_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function visitor_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors/visitor_nav_vendor', $data);
        echo view('footer', $data);
    }

    public function vendors()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/vendors', $data);
        echo view('footer', $data);
    }

    public function agent_stats_reports()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/agent_stats_reports', $data);
        echo view('footer', $data);
    }

    public function passport_management_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/passport_management_report', $data);
        echo view('footer', $data);
    }

    public function trp_package()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/trp_package', $data);
        echo view('footer', $data);
    }

    public function passport_pending()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/passport_pending', $data);
        echo view('footer', $data);
    }

    public function passport_completed()
    {

        $data = $this->data;


        $MainModel = $this->MainModel;
        $Groups = new Groups();
         $data['Groups'] = $Groups->ListAllGroups();


        echo view('header', $data);
        echo view('reports/passport_completed', $data);
        echo view('footer', $data);
    }

    public function trp_use_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/trp_use_visa', $data);
        echo view('footer', $data);
    }

    public function trp_use_actual()
    {
        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->trp_use_actual();

        /*$Crud = new Crud();
        $data['sectors'] = $Crud->LookupOptions('transport_sectors');*/

        echo view('header', $data);
        echo view('reports/brn/trp_use_actual', $data);
        echo view('footer', $data);
    }

    public function actual_trp_balance()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->trp_balance_actual();
        $Crud = new Crud();
        $data['sectors'] = $Crud->LookupOptions('transport_sectors');
        echo view('header', $data);
        echo view('reports/brn/actual_trp_balance', $data);
        echo view('footer', $data);
    }

    public function vehicle_arrangement()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->vehicle_arrangement();
        print_r($data['records']);exit;*/

        echo view('header', $data);
        echo view('reports/vehicle_arrangement', $data);
        echo view('footer', $data);
    }

    public function trp_balance_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/trp_balance_visa', $data);
        echo view('footer', $data);
    }

    public function htl_purchase()
    {

        $data = $this->data;

        $Packages = new Packages();
        $data['hotels'] = $Packages->ListHotels();

        echo view('header', $data);
        echo view('reports/brn/htl_purchase', $data);
        echo view('footer', $data);
    }

    public function htl_use_visa()
    {

        $data = $this->data;

        $Packages = new Packages();
        $data['hotels'] = $Packages->ListHotels();

        echo view('header', $data);
        echo view('reports/brn/htl_use_visa', $data);
        echo view('footer', $data);
    }

    public function hotel_use_actual()
    {

        $data = $this->data;
        //$Reports = new Reportsprocess();
        //$data['records'] = $Reports->hotel_use_actual();
        $Packages = new Packages();
        $data['hotels'] = $Packages->ListHotels();

        echo view('header', $data);
        echo view('reports/brn/hotel_use_actual', $data);
        echo view('footer', $data);
    }

    public function htl_balance_actual()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/htl_balance_actual', $data);
        echo view('footer', $data);
    }

    public function htl_balance_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/htl_balance_visa', $data);
        echo view('footer', $data);
    }

    public function seat_loss()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/seat_loss', $data);
        echo view('footer', $data);
    }

    public function allow_beds()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/allow_beds', $data);
        echo view('footer', $data);
    }

    public function brn_reports()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/index', $data);
        echo view('footer', $data);
    }

    public function ppt_management_pending()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/ppt_management_pending', $data);
        echo view('footer', $data);
    }

    public function hotel_brn_use()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/hotel_brn_use', $data);
        echo view('footer', $data);
    }

    public function transport_brn_use()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/transport_brn_use', $data);
        echo view('footer', $data);
    }

    public function brn_summary_ptl()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->brn_summary_ptl();

        echo view('header', $data);
        echo view('reports/brn/brn_summary_ptl', $data);
        echo view('footer', $data);
    }

    public function brn_summary_htl()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/brn_summary_htl', $data);
        echo view('footer', $data);
    }

    public function package_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/package_summary', $data);
        echo view('footer', $data);
    }

    public function voucher_summary()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->voucher_summary();*/

        echo view('header', $data);
        echo view('reports/brn/voucher_summary', $data);
        echo view('footer', $data);
    }

    public function pilgrim_list()
    {

        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        echo view('header', $data);
        echo view('reports/pilgrim_list', $data);
        echo view('footer', $data);
    }

    public function group_stats()
    {

        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        echo view('header', $data);
        echo view('reports/group_stats', $data);
        echo view('footer', $data);
    }

    public function pilgrim_count()
    {

        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        echo view('header', $data);
        echo view('reports/pilgrim_count', $data);
        echo view('footer', $data);
    }

    public function summary_report()
    {

        $data = $this->data;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();

        echo view('header', $data);
        echo view('reports/summary_report', $data);
        echo view('footer', $data);
    }

    public function elm_report()
    {

        $data = $this->data;

        $Operators = new Users();
        $data['Operators'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('reports/elm_report', $data);
        echo view('footer', $data);
    }

    public function agent_monitor_screen()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/agent_monitor_screen', $data);
        echo view('footer', $data);
    }

    public function external_agent_monitor_screen()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/external_agent_monitor_screen', $data);
        echo view('footer', $data);
    }

    public function arrival_summary_layout()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/arrival_summary_layout', $data);
        echo view('footer', $data);
    }

    public function report_creator()
    {

        $data = $this->data;

        $Operators = new Users();
        $data['Operators'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('reports/report_creator', $data);
        echo view('footer', $data);
    }

    public function hotel()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->hotel();*/

        echo view('header', $data);
        echo view('reports/hotel', $data);
        echo view('footer', $data);
    }

    public function hotel_summary()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->hotel_summary();*/
        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');

        echo view('header', $data);
        echo view('reports/hotel_summary', $data);
        echo view('footer', $data);
    }

    public function hotel_arrangement()
    {

        $data = $this->data;
        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->hotel_arrangement();*/

        echo view('header', $data);
        echo view('reports/hotel_arrangement', $data);
        echo view('footer', $data);
    }

    public function transport()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/transport', $data);
        echo view('footer', $data);
    }


    public function transport_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/transport_summary', $data);
        echo view('footer', $data);
    }

    public function bed_loss()
    {

        $data = $this->data;
        //$Reports = new Reportsprocess();
        //$data['records'] = $Reports->bed_loss();
        echo view('header', $data);
        echo view('reports/bed_loss', $data);
        echo view('footer', $data);
    }

    public function allow_tpt_arrival()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_tpt_arrival();

        echo view('header', $data);
        echo view('reports/stats_reports/allow_tpt_arrival', $data);
        echo view('footer', $data);
    }

    public function completed_allow_tpt_arrival()
    {


        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_tpt_arrival();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_tpt_arrival', $data);
        echo view('footer', $data);
    }

    public function arrival_htl_mecca()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $finalArray = $Reports->arrival_htl_mecca();*/
        //$dataSet2 = $Reports->no_arrival_htl_mecca();
        //$finalArray = array_merge($dataSet1, $dataSet2);

//        echo "<pre>";
//        print_r($dataSet1);
//        print_r($dataSet2);
//        print_r($finalArray);exit;


        /*$data['records'] = $finalArray;*/

        echo view('header', $data);
        echo view('reports/arrival_htl_mecca', $data);
        echo view('footer', $data);
    }

    public function completed_allow_htl_mecca()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_htl_mecca();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_htl_mecca', $data);
        echo view('footer', $data);
    }

    public function arrival_htl_medina()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_medina();*/

        echo view('header', $data);
        echo view('reports/arrival_htl_medina', $data);
        echo view('footer', $data);
    }

    public function completed_allow_htl_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_htl_medina();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_htl_medina', $data);
        echo view('footer', $data);
    }

    public function arrival_htl_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_jeddah();

        echo view('header', $data);
        echo view('reports/arrival_htl_jeddah', $data);
        echo view('footer', $data);
    }

    public function completed_allow_htl_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_htl_jeddah();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_htl_jeddah', $data);
        echo view('footer', $data);
    }


    public function arrival_hotel()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/arrival_hotel', $data);
        echo view('footer', $data);
    }


    public function completed_allow_tpt_mecca()
    {


        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_tpt_mecca();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_tpt_mecca', $data);
        echo view('footer', $data);
    }

    public function completed_allow_tpt_medina()
    {


        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_tpt_medina();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_tpt_medina', $data);
        echo view('footer', $data);
    }

    public function completed_allow_tpt_jeddah()
    {


        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_tpt_jeddah();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_tpt_jeddah', $data);
        echo view('footer', $data);
    }

    public function completed_allow_tpt_departure()
    {


        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_transport_departure();

        echo view('header', $data);
        echo view('reports/stats_reports/completed_allow_tpt_departure', $data);
        echo view('footer', $data);
    }

    public function arrival_airport()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/arrival_airport', $data);
        echo view('footer', $data);
    }

    public function departure_airport()
    {
        //echo "<pre>";
        $data = $this->data;
        //$Reports = new Reportsprocess();
        //$data['records'] = $Reports->departure_airport();
        //print_r($data['records']); exit;

        echo view('header', $data);
        echo view('reports/departure_airport', $data);
        echo view('footer', $data);
    }

    public function departure_hotel()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/departure_hotel', $data);
        echo view('footer', $data);
    }

    public function allow_transport_mecca()
    {

        $data = $this->data;
        $data = $this->data;
        $Reports = new Reportsprocess();
        $finalArray = $Reports->allow_transport_mecca();
        //$dataSet2 = $Reports->no_allow_transport_mecca();
        // $finalArray = array_merge($dataSet1, $dataSet2);
        // $finalArray = $dataSet2;

        $data['records'] = $finalArray;

        echo view('header', $data);
        echo view('reports/stats_reports/allow_transport_mecca', $data);
        echo view('footer', $data);
    }

    public function allow_transport_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_transport_medina();
        echo view('header', $data);
        echo view('reports/stats_reports/allow_transport_medina', $data);
        echo view('footer', $data);
    }

    public function allow_transport_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_transport_jeddah();

        echo view('header', $data);
        echo view('reports/stats_reports/allow_transport_jeddah', $data);
        echo view('footer', $data);
    }

    public function allow_transport_departure()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_transport_departure();

        echo view('header', $data);
        echo view('reports/stats_reports/allow_transport_departure', $data);
        echo view('footer', $data);
    }

    public function agent_work_report()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->agent_work_report();*/

        echo view('header', $data);
        echo view('reports/agent_work_report', $data);
        echo view('footer', $data);
    }

    public function elm_summary_daywise()
    {
        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->elm_summary_daywise();

        echo view('header', $data);
        echo view('reports/elm_data_summary_daywise', $data);
        echo view('footer', $data);
    }


    public function voucher_update_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/voucher_update_report', $data);
        echo view('footer', $data);
    }

    public function voucher_issue_report()
    {

        $data = $this->data;

        /* $Reports = new Reportsprocess();
         $data['records'] = $Reports->voucher_issue_report();*/
        //echo'<pre>';print_r( $data['records'] );exit;

        echo view('header', $data);
        echo view('reports/voucher_issue_report', $data);
        echo view('footer', $data);
    }

    public function zone_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/zone_summary', $data);
        echo view('footer', $data);
    }

    public function stats_b2c()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_b2c();
        echo view('header', $data);
        echo view('reports/stats_reports/b2c', $data);
        echo view('footer', $data);
    }

    public function stats_b2b()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_b2b();

        echo view('header', $data);
        echo view('reports/stats_reports/b2b', $data);
        echo view('footer', $data);
    }

    public function external()
    {

        $data = $this->data;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_external();


        echo view('header', $data);
        echo view('reports/stats_reports/external', $data);
        echo view('footer', $data);
    }

    public function total_pax()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_total_pax();*/

        echo view('header', $data);
        echo view('reports/stats_reports/total_pax', $data);
        echo view('footer', $data);
    }

    public function mofa_issued()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_mofa_issued();*/


        echo view('header', $data);
        echo view('reports/stats_reports/mofa_issued', $data);
        echo view('footer', $data);
    }

    public function mofa_not_issued()
    {

        $data = $this->data;

        /* $Reports = new Reportsprocess();
         $data['records'] = $Reports->stats_mofa_not_issued();*/


        echo view('header', $data);
        echo view('reports/stats_reports/mofa_not_issued', $data);
        echo view('footer', $data);
    }


    public function visa_not_issue()
    {

        $data = $this->data;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_visa_not_issued();


        echo view('header', $data);
        echo view('reports/stats_reports/visa_not_issue', $data);
        echo view('footer', $data);
    }

    public function visa_issue()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_visa_issued();*/

        echo view('header', $data);
        echo view('reports/stats_reports/visa_issue', $data);
        echo view('footer', $data);
    }


    public function voucher_not_issued()
    {
        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_voucher_not_issued();*/

        echo view('header', $data);
        echo view('reports/stats_reports/voucher_not_issued', $data);
        echo view('footer', $data);
    }

    public function voucher_issued()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->voucher_issue_report();*/

        echo view('header', $data);
        echo view('reports/stats_reports/voucher_issued', $data);
        echo view('footer', $data);
    }

    public function jeddah_arrival()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/stats_reports/jeddah_arrival', $data);
        echo view('footer', $data);
    }


    public function service_sale_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/service_sale_summary', $data);
        echo view('footer', $data);
    }

    public function transport_sale_summary()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/transport_sale_summary', $data);
        echo view('footer', $data);
    }

    public function hotel_sale_summary()
    {

        $data = $this->data;
        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');
        echo view('header', $data);
        echo view('reports/hotel_sale_summary', $data);
        echo view('footer', $data);
    }


    public function check_in_mecca()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_mecca();

        echo view('header', $data);
        echo view('reports/stats_reports/check_in_mecca', $data);
        echo view('footer', $data);
    }

    public function check_in_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_medina();

        echo view('header', $data);
        echo view('reports/stats_reports/check_in_medina', $data);
        echo view('footer', $data);
    }

    public function fetch_check_in_medina()
    {
        $Pilgrims = new \App\Models\Pilgrims();
        $Reports = new Reportsprocess();
        $records = $Reports->get_check_in_medina_datatables();
        $totalrecords = $Reports->TotalListcheck_in_medina();
        $totalfilterrecords = $Reports->count_check_in_medinafiltered();

        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-medina-status');
            //echo '<pre>';print_r($PilgrimMetaRecords);
            //echo '<pre>';print_r($PilgrimLastActivity);
            if ($PilgrimMetaRecords['check-in-medina-actual-Hotel'] > 0) {

                $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-actual-Hotel'], 'Name', 1);
            } else {
                $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-package-Hotel'], 'Name', 0);
            }
            $Checkintime = '';
            $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
            if ($Arrivalpos > 0) {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
                // $Checkintime + 4hours
            } else {
                if ($PilgrimLastActivity['LastActivity'] == 'check-out-mecca') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-mecca-time'] . ' + 6 hours'));
                    // $Checkintime + 6hours
                }
            }
            //echo $Checkintime;
            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

            $Grand['TotalPax'] += $record['TotalPilgrim'];
            $Grand['TotalBeds'] += $PilgrimMetaRecords['check-in-medina-no-of-bed'];
            $Grand['TotalNights'] += $record['Nights'];
            $sub_array = array();
            $sub_array[] = $cnt;


            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-brn-no'])) ? BRNCode($PilgrimMetaRecords['check-in-medina-brn-no']) : '-');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['HotelCityName'];
            $sub_array[] = ((isset($ActualHotel)) ? $ActualHotel : '-');
            $sub_array[] = $record['RoomType'];
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-room-no'])) ? $PilgrimMetaRecords['check-in-medina-room-no'] : '-');
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-no-of-bed'])) ? $PilgrimMetaRecords['check-in-medina-no-of-bed'] : '-');
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-in-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-medina-in-date']) : '-');
            $sub_array[] = ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-');
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-out-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-medina-out-date']) : '-');
            $sub_array[] = $record['Nights'];
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-medina-actual-arrival-time']) : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = ((isset($PilgrimMetaRecords['check-in-medina-contact-number'])) ? $PilgrimMetaRecords['check-in-medina-contact-number'] : '-');
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ((isset($ActivityUserName)) ? $ActivityUserName : '-');
            $sub_array[] = 'Check In Medina';

            $dataList[] = $sub_array;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => $totalrecords,
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public function check_in_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_jeddah();

        echo view('header', $data);
        echo view('reports/stats_reports/check_in_jeddah', $data);
        echo view('footer', $data);
    }

    public function pilgrim_exit()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pilgrim_exit();*/

        echo view('header', $data);
        echo view('reports/stats_reports/pilgrim_exit', $data);
        echo view('footer', $data);
    }

    public function pax_in_mecca()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pax_in_mecca();*/

        echo view('header', $data);
        echo view('reports/stats_reports/pax_in_mecca', $data);
        echo view('footer', $data);
    }

    public function pax_in_medina()
    {
        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pax_in_medina();*/

        echo view('header', $data);
        echo view('reports/stats_reports/pax_in_medina', $data);
        echo view('footer', $data);
    }

    public function pax_in_jeddah()
    {
        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pax_in_jeddah();*/

        echo view('header', $data);
        echo view('reports/stats_reports/pax_in_jeddah', $data);
        echo view('footer', $data);
    }

    public function pax_in_saudi_arabia()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pax_in_saudi_arabia();*/

        echo view('header', $data);
        echo view('reports/stats_reports/pax_in_saudi_arabia', $data);
        echo view('footer', $data);
    }


    public function update_voucher_list()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('reports/stats_reports/update_voucher_list', $data);
        echo view('footer', $data);
    }


    public function refund_voucher_list()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/stats_reports/refund_voucher_list', $data);
        echo view('footer', $data);
    }


    public function package_summary_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/stats_reports/package_summary_report', $data);
        echo view('footer', $data);
    }

    public function allow_bed()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_bed();

        echo view('header', $data);
        echo view('reports/allow_bed', $data);
        echo view('footer', $data);
    }

    public function free_bed_counter_report()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->free_bed_counter_report();
        echo view('header', $data);
        echo view('reports/stats_reports/free_bed_counter_report', $data);
        echo view('footer', $data);
    }

    public function ppt_management()
    {
        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->ppt_management();*/

        echo view('header', $data);
        echo view('reports/ppt_management', $data);
        echo view('footer', $data);
    }

    public function completed_ppt_management()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_ppt_management();
        echo view('header', $data);
        echo view('reports/completed_ppt_management', $data);
        echo view('footer', $data);
    }

    public function without_voucher_arrival()
    {
        $data = $this->data;

        /*$session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPax($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPax();
        }*/

        echo view('header', $data);
        echo view('reports/without_voucher_arrival', $data);
        echo view('footer', $data);
    }

    public function without_arrival_voucher()
    {

        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPaxReport($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPaxReport();
        }

        echo view('header', $data);
        echo view('reports/without_voucher_arrival', $data);
        echo view('footer', $data);
    }


    public function completed_without_voucher_arrival()
    {

        $data = $this->data;


        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllCompletedWithoutVoucherArrivalPax($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllCompletedWithoutVoucherArrivalPax();
        }
        echo view('header', $data);
        echo view('reports/completed_without_voucher_arrival', $data);
        echo view('footer', $data);
    }

    public function late_departure()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/brn/late_departure', $data);
        echo view('footer', $data);
    }

    public function Over25DaysArrivalCompleted()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_late_departure_counter_report();


        echo view('header', $data);
        echo view('reports/brn/late_departure', $data);
        echo view('footer', $data);
    }

    public function late_departure_counter_report()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->late_departure_counter_report();

        echo view('header', $data);
        echo view('reports/brn/late_departure_counter_report', $data);
        echo view('footer', $data);
    }

    public function Over25DaysArrival()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->late_departure_counter_report();

        echo view('header', $data);
        echo view('reports/brn/late_departure_counter_report', $data);
        echo view('footer', $data);
    }


    public function trp_brn_purchase()
    {

        $data = $this->data;
        //$Reports = new Reportsprocess();
        //$data['records'] = $Reports->trp_brn_purchased();

        echo view('header', $data);
        echo view('reports/brn/trp_brn_purchase', $data);
        echo view('footer', $data);
    }

    public function in_active_agent()
    {

        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();
        $Agents = new Agents();
        $data['records'] = $Agents->ListInActiveAgents();

        echo view('header', $data);
        echo view('reports/inactive_agent', $data);
        echo view('footer', $data);
    }

    public function active_agent()
    {

        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();
        $Agents = new Agents();
        $data['records'] = $Agents->ListActiveAgents();

        echo view('header', $data);
        echo view('reports/active_agent', $data);
        echo view('footer', $data);
    }

    public function external_agent()
    {

        $data = $this->data;


        $Agents = new Agents();
        $data['records'] = $Agents->ListExternalAgents();

        echo view('header', $data);
        echo view('reports/external_agent', $data);
        echo view('footer', $data);
    }

    public function b2b_agent()
    {

        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();
        $Agents = new Agents();
        $data['records'] = $Agents->ListB2BAgents();

        echo view('header', $data);
        echo view('reports/b2b_agent', $data);
        echo view('footer', $data);
    }


    public function tafeej_report()
    {

        $data = $this->data;


        echo view('header', $data);
        echo view('reports/tafeej_report', $data);
        echo view('footer', $data);
    }


    public function pending_voucher_report()
    {

        $data = $this->data;

        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->pending_voucher_report();*/

        echo view('header', $data);
        echo view('reports/pending_report', $data);
        echo view('footer', $data);
    }

    public function approved_voucher_report()
    {

        $data = $this->data;
        /*$Reports = new Reportsprocess();
        $data['records'] = $Reports->approved_voucher_report();*/

        echo view('header', $data);
        echo view('reports/approved_report', $data);
        echo view('footer', $data);
    }


    public function executed_voucher()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/executed_voucher', $data);
        echo view('footer', $data);
    }


    public function sale_umrah()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/sale_report/sale_umrah', $data);
        echo view('footer', $data);
    }

    public function hotel_brn_use_layouts()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/sale_umrah/hotel_brn_use_layouts', $data);
        echo view('footer', $data);
    }

    public function transport_brn_use_layouts()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/sale_umrah/transport_brn_use_layouts', $data);
        echo view('footer', $data);
    }

    public function group_delete_list()
    {

        $data = $this->data;
        $Groups = new Groups();
        $data['records'] = $Groups->ListDeletedGroups();

        $Operators = new Users();
        $data['Operators'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('reports/sale_umrah/group_delete_list', $data);
        echo view('footer', $data);
    }

    public function b2c_client_list()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/sale_umrah/b2c_client_list', $data);
        echo view('footer', $data);
    }


    public function sale_ticket()
    {

        $data = $this->data;


        echo view('header', $data);
        echo view('reports/sale_report/sale_ticket', $data);
        echo view('footer', $data);
    }

    public function sale_ticket_detail_report()
    {

        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/detail_report', $data);
        } else {

            echo view('reports/sale_ticket/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_country_wise()
    {

        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/country_wise', $data);
        } else {

            echo view('reports/sale_ticket/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_month_wise()
    {

        $data = $this->data;


        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/month_wise', $data);
        } else {

            echo view('reports/sale_ticket/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/year_wise', $data);
        } else {

            echo view('reports/sale_ticket/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_airline_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/airline_wise', $data);
        } else {

            echo view('reports/sale_ticket/airline_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_international()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/international', $data);
        } else {

            echo view('reports/sale_ticket/international', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_domestic()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/domestic', $data);
        } else {

            echo view('reports/sale_ticket/domestic', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_amount_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/amount_wise', $data);
        } else {

            echo view('reports/sale_ticket/amount_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_airline_month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/airline_month_wise', $data);
        } else {

            echo view('reports/sale_ticket/airline_month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_groupairline_wise_summery()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/groupairline_wise_summery', $data);
        } else {

            echo view('reports/sale_ticket/groupairline_wise_summery', $data);
        }
        echo view('footer', $data);
    }

    public function sale_ticket_group_summery()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_ticket/group_summery', $data);
        } else {

            echo view('reports/sale_ticket/group_summery', $data);
        }
        echo view('footer', $data);
    }

    public function sale_hotel_detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_hotel/detail_report', $data);
        } else {

            echo view('reports/sale_hotel/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_hotel_country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_hotel/country_wise', $data);
        } else {

            echo view('reports/sale_hotel/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_hotel_category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_hotel/category_wise', $data);
        } else {

            echo view('reports/sale_hotel/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_hotel_withmonth_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_hotel/hotel_withmonth_wise', $data);
        } else {

            echo view('reports/sale_hotel/hotel_withmonth_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_hotel_withyear_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_hotel/hotel_withyear_wise', $data);
        } else {

            echo view('reports/sale_hotel/hotel_withyear_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visa_detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visa/detail_report', $data);
        } else {

            echo view('reports/sale_visa/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visa_country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visa/country_wise', $data);
        } else {

            echo view('reports/sale_visa/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visa_month_and_countrywise_category()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visa/category_wise', $data);
        } else {

            echo view('reports/sale_visa/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visa_monthwise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visa/month_wise', $data);
        } else {

            echo view('reports/sale_visa/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visa_yearwise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visa/year_wise', $data);
        } else {

            echo view('reports/sale_visa/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/detail_report', $data);
        } else {

            echo view('reports/sale_transport/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/country_wise', $data);
        } else {

            echo view('reports/sale_transport/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/category_wise', $data);
        } else {

            echo view('reports/sale_transport/category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/month_wise', $data);
        } else {

            echo view('reports/sale_transport/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/year_wise', $data);
        } else {

            echo view('reports/sale_transport/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_transport_category_with_month_and_country()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_transport/category_with_month_and_country', $data);
        } else {

            echo view('reports/sale_transport/category_with_month_and_country', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/detail_report', $data);
        } else {

            echo view('reports/sale_tour/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/country_wise', $data);
        } else {

            echo view('reports/sale_tour/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_package_category_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/package_category_wise', $data);
        } else {

            echo view('reports/sale_tour/package_category_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/month_wise', $data);
        } else {

            echo view('reports/sale_tour/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/year_wise', $data);
        } else {

            echo view('reports/sale_tour/year_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_tour_package_category_Monthwise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_tour/package_category_Monthwise', $data);
        } else {

            echo view('reports/sale_tour/package_category_Monthwise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_detail_report()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/detail_report', $data);
        } else {

            echo view('reports/sale_visitor/detail_report', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_country_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/country_wise', $data);
        } else {

            echo view('reports/sale_visitor/country_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_successful_product_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/successful_product_wise', $data);
        } else {

            echo view('reports/sale_visitor/successful_product_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_unsuccessful_product_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/unsuccessful_product_wise', $data);
        } else {

            echo view('reports/sale_visitor/unsuccessful_product_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_month_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/month_wise', $data);
        } else {

            echo view('reports/sale_visitor/month_wise', $data);
        }
        echo view('footer', $data);
    }

    public function sale_visitor_year_wise()
    {
        $data = $this->data;

        echo view('header', $data);
        if ($data['session']['domainid'] == 0) {
            echo view('main/reports/sale_visitor/year_wise', $data);
        } else {

            echo view('reports/sale_visitor/year_wise', $data);
        }
        echo view('footer', $data);
    }

    //purshase_reports_start

    public function purchase_ticket_issue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/ticket_issue', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_reissue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/ticket_reissue', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_refund()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/refund', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_adm()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/adm', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_group_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/groupwise', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/detail_report', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/month_wise', $data);
        echo view('footer', $data);
    }


    public function purchase_ticket_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/year_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_airline_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/airline_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_international()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/international', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_domestic()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/domestic', $data);
        echo view('footer', $data);
    }

    public function purchase_ticket_detail_report_amount_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_ticket/detail_report_amount_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_cancel_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/cancel_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/confirm_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_refund()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_refund', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/change_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_allotment()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_allotment', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_detail_report', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_category_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_with_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_with_month_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel_with_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_hotel/hotel_with_year_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_issue()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/visa_issue', $data);
        echo view('footer', $data);
    }

    public function purchase_reject_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/reject_visa', $data);
        echo view('footer', $data);
    }

    public function purchase_refund_visa()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/refund_visa', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_detail()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/visa_detail', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_vendor_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/vendor_country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/visa_country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/visa_month_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_visa_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_visa/visa_year_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_confirm_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_refund_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_refund_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_change_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_detail_report', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_category_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_month_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tpt_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_transport/tpt_year_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_confirm_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_confirm_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_change_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_change_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_refund_booking()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_refund_booking', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_detail_report()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_detail_report', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_country_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_country_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_package_category_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_package_category_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_month_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_month_wise', $data);
        echo view('footer', $data);
    }

    public function purchase_tour_year_wise()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_tour/tour_year_wise', $data);
        echo view('footer', $data);
    }


    public function sale_hotel()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/sale_report/sale_hotel', $data);
        echo view('footer', $data);
    }

    public function sale_visa()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/sale_report/sale_visa', $data);
        echo view('footer', $data);
    }


    public function sale_transport()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/sale_report/sale_transport', $data);
        echo view('footer', $data);
    }

    public function sale_tours()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/sale_report/sale_tours', $data);
        echo view('footer', $data);
    }

    public function sale_visitors()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/sale_report/sale_visitors', $data);
        echo view('footer', $data);
    }

    public function purchase_umrah()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_umrah', $data);
        echo view('footer', $data);
    }

    public function hotel_brn_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_umrah/hotel_brn_vendor', $data);
        echo view('footer', $data);
    }

    public function tpt_brn_vendor()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_umrah/tpt_brn_vendor', $data);
        echo view('footer', $data);
    }

    public function visa_vendors()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_umrah/visa_vendors', $data);
        echo view('footer', $data);
    }

    public function hotel_vendors()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_umrah/hotel_vendors', $data);
        echo view('footer', $data);
    }


    public function transport_vendors()
    {

        $data = $this->data;

        echo view('header', $data);
        echo view('reports/purchase_umrah/transport_vendors', $data);
        echo view('footer', $data);
    }


    public function purchase_ticket()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_ticket', $data);
        echo view('footer', $data);
    }

    public function purchase_hotel()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_hotel', $data);
        echo view('footer', $data);
    }

    public function purchase_visa()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_visa', $data);
        echo view('footer', $data);
    }

    public function purchase_transport()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_transport', $data);
        echo view('footer', $data);
    }

    public function purchase_tours()
    {

        $data = $this->data;
        $data['Link'] = getSegment(2);

        echo view('header', $data);
        echo view('reports/purchase_report/purchase_tours', $data);
        echo view('footer', $data);
    }


    /** Development Start By Jawad Sajid Durrani */

    public
    function fetch_visa_issue()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_visa_issue_datatables();
        $totalfilterrecords = $Reports->count_visa_issue_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['UID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['VisaNumber'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_mofa_not_issued()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_mofa_not_issued_datatables();
        $totalfilterrecords = $Reports->count_mofa_not_issued_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['UID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_mofa_issued()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_mofa_issued_datatables();
        $totalfilterrecords = $Reports->count_mofa_issued_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['UID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_total_pax()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_total_pax_datatables();
        $totalfilterrecords = $Reports->count_total_pax_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['PilgrimID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $Category;
            $sub_array[] = $record['CurrentStatus'];
            $sub_array[] = $record['ReferenceName'];


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_voucher_not_issued()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_voucher_not_issued_datatables();
        $totalfilterrecords = $Reports->count_voucher_not_issued_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['UID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['VisaNumber'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_voucher_issued()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_voucher_issued_datatables();
        $totalfilterrecords = $Reports->count_voucher_issued_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = Code('UF/P/', $record['UID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['IssueDate']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['VisaNumber'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_pilgrims_exit()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $PilgrimModel = new Pilgrims();

        $records = $Reports->get_pilgrim_exit_datatables();
        $totalfilterrecords = $Reports->count_pilgrim_exit_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $PilgrimMetaRecords = $PilgrimModel->DeparturePilgrimLeaderMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'] . '-status');
            $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status']);
            $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $PilgrimMetaRecords['ActualHotel'];
            $sub_array[] = $PilgrimMetaRecords['RoomNo'];
            $sub_array[] = DATEFORMAT($PilgrimMetaRecords['DepartureDate']);
            $sub_array[] = TIMEFORMAT($PilgrimCurrentActivity['LastActivityRecordTime']);
            $sub_array[] = DATEFORMAT($record['FlightDate']);
            $sub_array[] = $record['FlightNo'];
            $sub_array[] = TIMEFORMAT($record['FlightTime']);
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = $PilgrimMetaRecords['Seats'];
            $sub_array[] = AirportName($record['SectorFrom']);
            $sub_array[] = AirportCode($record['SectorFrom']);
            $sub_array[] = $record['TransportType'];
            $sub_array[] = $PilgrimMetaRecords['VehicleNumber'];
            $sub_array[] = $PilgrimMetaRecords['DriverName'];
            $sub_array[] = $PilgrimMetaRecords['DriverMobileNumber'];
            $sub_array[] = $PilgrimMetaRecords['TransportCompany'];
            $sub_array[] = $PilgrimMetaRecords['PaxMobileNumber'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            $sub_array[] = ((isset($ActivityUserName)) ? $ActivityUserName : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimMetaRecords['Status']));

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_pilgrim_list()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_pilgrim_list_datatables();
        $totalfilterrecords = $Reports->count_pilgrim_list_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = ucwords(str_replace('-', ' ', $record['CurrentStatus']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_pilgrim_count()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_pilgrim_count_datatables();
        $totalfilterrecords = $Reports->count_pilgrim_count_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = DATEFORMAT($record['GroupCRDATE']);
            $sub_array[] = Code('UF/G/', $record['GroupCode']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['Adults'];
            $sub_array[] = $record['Child'];
            $sub_array[] = $record['Infant'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_all_agent_work_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_agent_work_report_datatables();
        $totalfilterrecords = $Reports->count_agent_work_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Category = 'B2C';
            if ($record['AgentUID'] > 0) {
                $Category = 'B2B';
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = DATEFORMAT($record['StartDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = $record['PackageName'];
            $sub_array[] = $record['Accommodation'];
            $sub_array[] = $record['SelfAccommodation'];
            $sub_array[] = $record['Visa'];
            $sub_array[] = $record['NotVisa'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_arrival_airport_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $PilgrimModel = new Pilgrims();

        $records = $Reports->get_arrival_airport_report_datatables();
        $totalfilterrecords = $Reports->count_arrival_airport_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $PilgrimID = $record['LeaderPilgrimUID'];
            $PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $PilgrimMetaRecords['Status'] . '-status');
            $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['FullName'];
            $sub_array[] = $record['PPNO'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimMetaRecords['Seats'])) ? $PilgrimMetaRecords['Seats'] : '-');
            $sub_array[] = $record['DepartureDated'];
            $sub_array[] = $record['DepartureTime'];
            $sub_array[] = $record['ArrivalDate'];
            $sub_array[] = $record['ArrivalTime'];
            $sub_array[] = $record['FlightNo'];
            $sub_array[] = $record['SectorFrom'] . ' - ' . $record['SectorTo'];
            $sub_array[] = ((isset($record['Destination'])) ? $record['Destination'] : '-');
            $sub_array[] = $record['TypeOFTransport'];
            $sub_array[] = $PilgrimMetaRecords['VehicleNumber'];
            $sub_array[] = $PilgrimMetaRecords['DriverName'];
            $sub_array[] = $PilgrimMetaRecords['DriverNumber'];
            $sub_array[] = $PilgrimMetaRecords['TransportCompany'];
            $sub_array[] = $record['SectorTo'];
            $sub_array[] = ((isset($PilgrimMetaRecords['PilgrimMobile'])) ? $PilgrimMetaRecords['PilgrimMobile'] : '-');
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = $ActivityUserName;
            $sub_array[] = ((isset($PilgrimMetaRecords['CurrentStatus'])) ? $PilgrimMetaRecords['CurrentStatus'] : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_executed_vouchers_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_executed_vouchers_report_datatables();
        $totalfilterrecords = $Reports->count_executed_vouchers_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $status = "-";
            if ($record['Departue'] > 0 && $record['InKSA'] == 0) {
                $status = "Departue";
            } elseif ($record['Departue'] == 0 && $record['InKSA'] > 0) {
                $status = "In KSA";
            } elseif ($record['Departue'] > 0 && $record['InKSA'] > 0) {
                $status = $record['Departue'] . " Departue" . " " . $record['InKSA'] . " In KSA";
            }
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = $record['UserCreatedBy'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['Adults'];
            $sub_array[] = $record['Child'];
            $sub_array[] = $record['Infant'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['DepartureDate']);
            $sub_array[] = $record['TotalNights'];
            $sub_array[] = $record['ArrivalType'];
            $sub_array[] = $status;
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_group_stats_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_group_stats_report_datatables();
        $totalfilterrecords = $Reports->count_group_stats_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = Code('UF/G/', $record['GroupCode']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['TotalPAX'];
            $sub_array[] = $record['VoucherNotIssued'];
            $sub_array[] = $record['VoucherIssued'];
            $sub_array[] = $record['Arrived'];
            $sub_array[] = $record['CheckInMecca'];
            $sub_array[] = $record['CheckInMedina'];
            $sub_array[] = $record['CheckInJeddah'];
            $sub_array[] = $record['Exit'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_hotel_purchase_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_htl_purchase_report_datatables();
        $totalfilterrecords = $Reports->count_htl_purchase_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ((isset($record['Rooms'])) ? $record['Rooms'] : '-');
            $sub_array[] = ((isset($record['Beds'])) ? $record['Beds'] : '-');
            $sub_array[] = ((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-');
            $sub_array[] = ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-');
            $sub_array[] = ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-');
            $sub_array[] = $record['PurchasedBy'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_hotel_use_visa_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_htl_use_visa_report_datatables();
        $totalfilterrecords = $Reports->count_htl_use_visa_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "Beds"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-htl%accommodation\'
                AND "PM"."Value"=\'Beds\'
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-htl%brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';
            $ResultBeds=$Crud->ExecuteSQL($SQL);
            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "Rooms"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-htl%accommodation\'
                AND "PM"."Value"=\'Room\'
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-htl%brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';
            $ResultRooms=$Crud->ExecuteSQL($SQL);
            //echo '<pre>';print_r($ResultSystemDate);
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ((isset($ResultRooms[0]['Rooms'])) ? $ResultRooms[0]['Rooms'] : '-');
            $sub_array[] = ((isset($ResultBeds[0]['Beds'])) ? $ResultBeds[0]['Beds'] : '-');
            $sub_array[] = ((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-');
            $sub_array[] = ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-');
            $sub_array[] = ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-');
            $sub_array[] = $record['PurchasedBy'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_late_departure_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_late_departure_report_datatables();
        $totalfilterrecords = $Reports->count_late_departure_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = Code('UF/G/', $record['GroupID']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = Code('UF/P/', $record['PilgrimID']);
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['VisaNo'];
            $sub_array[] = $record['MOINumber'];
            $sub_array[] = DATEFORMAT($record['EntryDate']);
            $sub_array[] = TIMEFORMAT($record['EntryTime']);
            $sub_array[] = DATEFORMAT($record['DepartureDate']);
            $sub_array[] = $record['Days'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_departure_airport_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_departure_airport_report_datatables();
        $totalfilterrecords = $Reports->count_departure_airport_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;


            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['HotelCity'];
            $sub_array[] = $record['ActualHotel'];
            $sub_array[] = $record['RoomNo'];
            $sub_array[] = $record['DepartureDate'];
            $sub_array[] = $record['DepartureHotelTime'];
            $sub_array[] = $record['AirPort'];
            $sub_array[] = $record['FlightNo'];
            $sub_array[] = $record['DepartureTime'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = $record['Seats'];
            $sub_array[] = $record['TypeOFTransport'];
            $sub_array[] = $record['VehicleNumber'];
            $sub_array[] = $record['DriverName'];
            $sub_array[] = $record['DriverContactNumber'];
            $sub_array[] = $record['LeaderPilgrimContactNumber'];
            $sub_array[] = $record['TransportCompany'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            $sub_array[] = 'N/A';

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_passport_pending_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_passport_pending_datatables();
        $totalfilterrecords = $Reports->count_passport_pending_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code("UF/A/", $record['AgentUID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FullName'];
            $sub_array[] = $record['PPNO'];
            $sub_array[] = ((isset($record['ActualArrivalDate'])) ? DATEFORMAT($record['ActualArrivalDate']) : '-');
            $sub_array[] = ((isset($record['EntryPort'])) ? $record['EntryPort'] : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_passport_complete_report()
    {

        $data = $this->data;
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_passport_complete_datatables();
        $totalfilterrecords = $Reports->count_passport_complete_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code("UF/A/", $record['AgentUID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FullName'];
            $sub_array[] = $record['PPNO'];
            $sub_array[] = ((isset($record['DOB'])) ? DATEFORMAT($record['DOB']) : '-');
            $sub_array[] = $record['Nationality'];
            $sub_array[] = ((isset($record['PassportFrontPicFileID'])) ? '<a href="' . $data['path'] . 'home/load_file/' . $record['PassportFrontPicFileID'] . '" target="_blank">Download</a>' : '-');
            $sub_array[] = ((isset($record['PassportBackPicFileID'])) ? '<a href="' . $data['path'] . 'home/load_file/' . $record['PassportBackPicFileID'] . '" target="_blank">Download</a>' : '-');
            $sub_array[] = ((isset($record['PassportBookletPicFileID'])) ? '<a href="' . $data['path'] . 'home/load_file/' . $record['PassportBookletPicFileID'] . '" target="_blank">Download</a>' : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_updated_vouchers_report()
    {

        $data = $this->data;
        $dataList = array();

        $Reports = new Reportsprocess();
        $records = $Reports->get_updated_vouchers_datatables();
        $totalfilterrecords = $Reports->count_updated_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;

            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['UserModifiedBy'];
            $sub_array[] = 'N/A';
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_voucher_issue_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_voucher_issued_datatables();
        $totalfilterrecords = $Reports->count_voucher_issued_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = 'N/A';
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = $record['MeccaNights'];
            $sub_array[] = $record['MedinaNights'];
            $sub_array[] = $record['JeddahNights'];
            $sub_array[] = $record['TotalNights'];
            $sub_array[] = $record['TypeOFTransport'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_pending_voucher_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_pending_voucher_datatables();
        $totalfilterrecords = $Reports->count_pending_voucher_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = $record['UserCreatedBy'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['Adults'];
            $sub_array[] = $record['Child'];
            $sub_array[] = $record['Infant'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['DepartureDate']);
            $sub_array[] = $record['TotalNights'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['UserCreatedBy'];
            $sub_array[] = DATEFORMAT($record['ModifiedDate']);
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_voucher_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_voucher_summary_datatables();
        $totalfilterrecords = $Reports->count_voucher_summary_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['Category'];
            $sub_array[] = $record['Vouchers'];
            $sub_array[] = $record['Pilgrims'];
            $sub_array[] = $record['Nights'];
            $sub_array[] = $record['Rooms'];
            $sub_array[] = $record['Sharing'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_without_voucher_arrival_report()
    {

        $dataList = array();
        $VoucherList = new Voucher();

        $records = $VoucherList->get_all_without_vouchers_arrival_datatables();
        $totalfilterrecords = $VoucherList->count_all_without_vouchers_arrival_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $Pilgrimlist) {

            $cnt++;
            $sub_array = array();

            $actions = '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/voucher_remarks\', ' . $Pilgrimlist['PilgrimUID'] . ', \'modal-lg\')">Add Remarks</a>';

            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/EA/', $Pilgrimlist['AgentUID']);
            $sub_array[] = $Pilgrimlist['CountryName'];
            $sub_array[] = $Pilgrimlist['AgentName'];
            $sub_array[] = $Pilgrimlist['GroupName'];
            $sub_array[] = Code('UF/G/', $Pilgrimlist['GroupUID']);
            $sub_array[] = $Pilgrimlist['FirstName'];
            $sub_array[] = $Pilgrimlist['PassportNumber'];
            $sub_array[] = DATEFORMAT($Pilgrimlist['DOB']);
            $sub_array[] = $Pilgrimlist['MOFAPilgrimID'];
            $sub_array[] = $Pilgrimlist['VisaNo'];
            $sub_array[] = DATEFORMAT($Pilgrimlist['EntryDate']);
            $sub_array[] = TIMEFORMAT($Pilgrimlist['EntryTime']);
            $sub_array[] = $Pilgrimlist['EntryPort'];
            $sub_array[] = $Pilgrimlist['TransportMode'];
            $sub_array[] = $Pilgrimlist['EntryCarrier'];
            $sub_array[] = $Pilgrimlist['FlightNo'];
            $sub_array[] = ((isset($Pilgrimlist['AgentType'])) ? ucfirst(str_replace("_", " ", $Pilgrimlist['AgentType'])) : '-');
            $sub_array[] = $Pilgrimlist['ReferenceName'];
            $sub_array[] = ' <div class="btn-group">
                                <button type="button"
                                        class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                        id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false" data-reference="parent">                                                                 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round"
                                         class="feather feather-chevron-down">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>                                                            
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                  ' . $actions . '
                                </div>
                            </div>';

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_actual_hotel_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_actual_hotel_datatables();
        $totalfilterrecords = $Reports->count_actual_hotel_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-' . strtolower($record['CityName']) . '-status');

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($record['BRN'])) ? $record['BRN'] : 'Cash');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['RoomType'];
            $sub_array[] = $record['RoomNo'];
            $sub_array[] = $record['TotalPex'];
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = $record['ActualBeds'];
            $sub_array[] = $record['CheckIn'];
            $sub_array[] = $record['CheckOut'];
            $sub_array[] = $record['Nights'];
            $sub_array[] = TIMEFORMAT(explode(',', $record['ActualArrivalTime'])[0]);
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = explode(',', $record['PaxMobileNo'])[0];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_arrival_hotel_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_arrival_hotel_datatables();
        $totalfilterrecords = $Reports->count_arrival_hotel_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'allow-htl-' . strtolower($record['CityName']) . '-status');

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($record['BRN'])) ? $record['BRN'] : 'Cash');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['HotelCategory'];
            $sub_array[] = $record['CityName'];

            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['RoomType'];

            $sub_array[] = $record['TotalPex'];
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = $record['Nights'];
            $sub_array[] = $record['Origin'];


            $sub_array[] = DATEFORMAT(explode(',', $record['ActualArrivalDate'])[0]) . ' ' . TIMEFORMAT(explode(',', $record['ActualArrivalTime'])[0]);

            $sub_array[] = explode(',', $record['PaxMobileNo'])[0];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            //$sub_array[] = $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = 'N/A';
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_actual_used_transport_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_actual_used_transport_datatables();
        $totalfilterrecords = $Reports->count_actual_used_transport_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'allow-htl-' . strtolower($record['CityName']) . '-status');

            $sub_array[] = $cnt;
            $sub_array[] = $record['IATANAME'];

            $sub_array[] = ((isset($record['BRN'])) ? $record['BRN'] : 'Cash');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-');
            $sub_array[] = ((isset($record['CheckOutTime'])) ? TIMEFORMAT($record['CheckOutTime']) : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($record['PickupPoint'])) ? $record['PickupPoint'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['RoomNo'])) ? $record['RoomNo'] : '-');
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $record['NoOfSeats'];
            $sub_array[] = ((isset($record['ActualDepartureTime'])) ? TIMEFORMAT($record['ActualDepartureTime']) : '-');;
            $sub_array[] = $record['Sector'];
            $sub_array[] = ((isset($record['TransportDestination'])) ? $record['TransportDestination'] : '-');;
            $sub_array[] = $record['TypeOFTransport'];
            $sub_array[] = explode(',', $record['VehicleNumber'])[0];
            $sub_array[] = explode(',', $record['DriverName'])[0];
            $sub_array[] = explode(',', $record['DriverNumber'])[0];
            $sub_array[] = explode(',', $record['PaxContactNumber'])[0];
            $sub_array[] = explode(',', $record['TransportCompany'])[0];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_arrival_transport_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_arrival_transport_summary_datatables();
        $totalfilterrecords = $Reports->count_arrival_transport_summary_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();


            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['ArrivalDate'];
            $sub_array[] = $record['FlightNo'];

            $sub_array[] = $record['ArrivalTime'];
            $sub_array[] = $record['TotalPex'];
            $sub_array[] = $record['TypeOFTransport'];

            $sub_array[] = $record['Airport'];
            $sub_array[] = $record['TravelType'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_passport_management_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_passport_management_datatables();
        $totalfilterrecords = $Reports->count_passport_management_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = Code('UF/G/', $record['GroupID']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PilgrimFullName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['VisaNo'];
            $sub_array[] = DATEFORMAT($record['EntryDate']);
            $sub_array[] = TIMEFORMAT($record['EntryTime']);
            $sub_array[] = $record['EntryPort'];
            $sub_array[] = $record['ArrivalMode'];
            $sub_array[] = $record['EntryCarrier'];
            $sub_array[] = $record['FlightNo'];
            $sub_array[] = $Category;
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_pax_in_mecca_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();

        $records = $Reports->get_pax_in_mecca_datatables();
        $totalfilterrecords = $Reports->count_pax_in_mecca_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $Checkintime = '';

            $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-mecca-status');
            $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'check-in-mecca');

            if ($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-actual-Hotel'] > 0) {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-actual-Hotel'], 'Name', 1);
            } else {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-package-Hotel'], 'Name', 0);
            }

            $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
            if ($Arrivalpos > 0) {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
            } else {
                if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time'] . ' + 6 hours'));
                } elseif ($PilgrimLastActivity['LastActivity'] == 'check-in-jeddah') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-arrival-time'] . ' + 6 hours'));
                }
            }

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $datetime1 = new DateTime($record['CheckINDate']);
            $datetime2 = new DateTime($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-out-date']);
            $difference = $datetime1->diff($datetime2);

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-brn-no']) : '-');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($ActualHotel)) ? $ActualHotel : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-room-no'] : '-');
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-no-of-bed'] : '-');
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-out-date']) : '-');
            $sub_array[] = $difference->d;
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-actual-arrival-time']) : '-');
            $sub_array[] = ((isset($PilgrimLastActivity['LastActivity'])) ? ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-mecca-contact-number'] : '-');
            $sub_array[] = $Category;
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ((isset($PilgrimMetaRecords[$PilgrimLastActivity['LastActivity'] . '-user-id'])) ? UserNameByID($PilgrimMetaRecords[$PilgrimLastActivity['LastActivity'] . '-user-id']) : '-');
            $sub_array[] = 'Check In Mecca';

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_pax_in_medina_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();

        $records = $Reports->get_pax_in_medina_datatables();
        $totalfilterrecords = $Reports->count_pax_in_medina_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Checkintime = '';
            $cnt++;
            $sub_array = array();

            $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-medina-status');
            $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'check-in-medina');
            if ($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-actual-Hotel'] > 0) {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-actual-Hotel'], 'Name', 1);
            } else {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-package-Hotel'], 'Name', 0);
            }

            $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
            if ($Arrivalpos > 0) {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
            } else {
                if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time'] . ' + 6 hours'));
                } elseif ($PilgrimLastActivity['LastActivity'] == 'check-in-medina') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-arrival-time'] . ' + 6 hours'));
                }
            }

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $datetime1 = new DateTime($record['CheckINDate']);
            $datetime2 = new DateTime($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-out-date']);
            $difference = $datetime1->diff($datetime2);

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no']) : '-');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($ActualHotel)) ? $ActualHotel : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-medina-room-no'] : '-');
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-medina-no-of-bed'] : '-');
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-out-date']) : '-');
            $sub_array[] = $difference->d;
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-actual-arrival-time']) : '-');
            $sub_array[] = ((isset($PilgrimLastActivity['LastActivity'])) ? ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-medina-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-medina-contact-number'] : '-');
            $sub_array[] = $Category;
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ((isset($PilgrimMetaRecords[$PilgrimLastActivity['LastActivity'] . '-user-id'])) ? UserNameByID($PilgrimMetaRecords[$PilgrimLastActivity['LastActivity'] . '-user-id']) : '-');
            $sub_array[] = 'Check In Medina';

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_pax_in_jeddah_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();

        $records = $Reports->get_pax_in_jeddah_datatables();
        $totalfilterrecords = $Reports->count_pax_in_jeddah_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Checkintime = '';
            $cnt++;
            $sub_array = array();

            $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-jeddah-status');
            $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'check-in-jeddah');
            if ($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-Hotel'] > 0) {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-Hotel'], 'Name', 1);
            } else {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-package-Hotel'], 'Name', 0);
            }

            $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
            if ($Arrivalpos > 0) {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
            } else {
                if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time'] . ' + 6 hours'));
                } elseif ($PilgrimLastActivity['LastActivity'] == 'check-out-mecca') {
                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-arrival-time'] . ' + 6 hours'));
                }
            }

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }
            $datetime1 = new DateTime($record['CheckINDate']);
            $datetime2 = new DateTime($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date']);
            $difference = $datetime1->diff($datetime2);

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no']) : '-');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($ActualHotel)) ? $ActualHotel : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-room-no'] : '-');
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-no-of-bed'] : '-');
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-out-date']) : '-');
            $sub_array[] = $difference->d;
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['check-in-jeddah-actual-arrival-time']) : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords']['jeddah-arrival-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords']['jeddah-arrival-contact-number'] : '-');
            $sub_array[] = $Category;
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ((isset($record['SystemUser'])) ? $record['SystemUser'] : '-');
            $sub_array[] = 'Check In Jeddah';

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_pax_in_saudi_arabia_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();
        /*$data['records'] = $Reports->pax_in_saudi_arabia();*/

        $records = $Reports->get_pax_in_saudi_arabia_datatables();
        $totalfilterrecords = $Reports->count_pax_in_saudi_arabia_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $Checkintime = '';
            $cnt++;
            $sub_array = array();

            $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], $record['CurrentStatus'] . '-status');
            $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], $record['CurrentStatus']);

            if ($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-actual-Hotel'] > 0) {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-actual-Hotel'], 'Name', 1);
            } else {
                $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-package-Hotel'], 'Name', 0);
            }

            $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
            if ($Arrivalpos > 0) {
                $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
            } else {
                if ($PilgrimLastActivity['LastActivity'] == 'check-out-medina') {
                    //$Checkintime = date('H:i:s',strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time']. ' + 6 hours'));
                    // $Checkintime + 6hours
                }
            }

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            $datetime1 = new DateTime($record['CheckINDate']);
            $datetime2 = new DateTime($PilgrimMetaRecords[$record['CurrentStatus'] . '-out-date']);
            $difference = $datetime1->diff($datetime2);

            if ($record['CurrentStatus'] == 'check-in-mecca') {
                $checkin = 'mecca';
            } else if ($record['CurrentStatus'] == 'check-in-medina') {
                $checkin = 'medina';
            } else if ($record['CurrentStatus'] == 'check-in-jeddah') {
                $checkin = 'jeddah';
            }

            if ($PilgrimCurrentActivity['CurrentActivity'] == 'check-in-mecca') {
                $HotelCity = 'Mecca';
            } else if ($PilgrimCurrentActivity['CurrentActivity'] == 'check-in-medina') {
                $HotelCity = 'Medina';
            } else if ($PilgrimCurrentActivity['CurrentActivity'] == 'check-in-jeddah') {
                $HotelCity = 'Jeddah';
            }

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-brn-no']) : '-');
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = ((isset($HotelCity)) ? $HotelCity : '-');
            $sub_array[] = ((isset($ActualHotel)) ? $ActualHotel : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-room-no'] : '-');
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-no-of-bed'] : '-');
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-out-date']) : '-');
            $sub_array[] = $difference->d;
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-actual-arrival-time']) : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-contact-number'] : '-');
            $sub_array[] = $Category;
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-user-id'])) ? UserNameByID($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'] . '-user-id']) : '-');
            $sub_array[] = ((isset($record['CurrentStatus'])) ? ucwords(str_replace('-', ' ', $record['CurrentStatus'])) : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_hotel_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        /*$data['records'] = $Reports->hotel_summary();*/
        $room_types = $Crud->LookupOptions('room_types');

        $records = $Reports->get_hotel_summary_datatables();
        $totalfilterrecords = $Reports->count_hotel_summary_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
            $sub_array = array();

            if (isset($record['RoomsPilgrims'])) {
                $RoomsPilgrims = $record['RoomsPilgrims'];
            }
            if (isset($record['SharingPilgrims'])) {
                $SharingPilgrims = $record['SharingPilgrims'];
            }

            $sub_array[] = $cnt;
            $sub_array[] = $record['CategoryName'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ($SharingPilgrims + $RoomsPilgrims);
            foreach ($room_types as $room_type) {
                $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
                if ($record['RoomTypeName'] != 'Sharing')
                    $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);

                $sub_array[] = (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-');
            }
            $sub_array[] = $record['SharingPilgrims'];
            $sub_array[] = $totalRooms;
            $sub_array[] = $totalNights;
            $sub_array[] = $record['RefAgentName'];
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_approved_vouchers_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        /*$data['records'] = $Reports->approved_voucher_report();*/

        $records = $Reports->get_approved_vouchers_datatables();
        $totalfilterrecords = $Reports->count_approved_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = $record['UserCreatedBy'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['Adults'];
            $sub_array[] = $record['Child'];
            $sub_array[] = $record['Infant'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['DepartureDate']);
            $sub_array[] = $record['TotalNights'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['UserCreatedBy'];
            $sub_array[] = DATEFORMAT($record['ModifiedDate']);
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_allow_hotel_mecca()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();
        /*$finalArray = $Reports->arrival_htl_mecca();*/

        $records = $Reports->get_allow_hotel_mecca_datatables();
        $totalfilterrecords = $Reports->count_allow_hotel_mecca_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($record['TotalPilgrims'])) ? $record['TotalPilgrims'] : '-');
            $sub_array[] = ((isset($record['NoOfBeds'])) ? $record['NoOfBeds'] : '-');
            $sub_array[] = ((isset($record['Nights'])) ? $record['Nights'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_allow_hotel_medina()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Pilgrims = new Pilgrims();
        /*$data['records'] = $Reports->arrival_htl_medina();*/

        $records = $Reports->get_allow_hotel_medina_datatables();
        $totalfilterrecords = $Reports->count_allow_hotel_medina_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($record['TotalPilgrims'])) ? $record['TotalPilgrims'] : '-');
            $sub_array[] = ((isset($record['NoOfBeds'])) ? $record['NoOfBeds'] : '-');
            $sub_array[] = ((isset($record['Nights'])) ? $record['Nights'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    /** Development Ends
     * By
     * Jawad Sajid Durrani
     */
    public
    function fetch_all_departure_hotel_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_departure_hotel_report_datatables();
        $totalfilterrecords = $Reports->count_departure_hotel_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;


            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['IATANAME'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['hotelcity'];
            $sub_array[] = $record['ActualHotel'];
            $sub_array[] = $record['RoomNo'];
            $sub_array[] = $record['TotalPilgrim'];
            $sub_array[] = $record['Seats'];
            $sub_array[] = $record['CheckOutDate'];
            $sub_array[] = $record['CheckOutTime'];
            $sub_array[] = $record['TransportDestination'];
            $sub_array[] = $record['TypeOFTransport'];
            $sub_array[] = $record['VehicleNumber'];
            $sub_array[] = $record['DriverName'];
            $sub_array[] = $record['DriverMobileNumber'];
            $sub_array[] = explode(',', $record['PaxContactNumber'])[0];;
            $sub_array[] = $record['TransportCompany'];

            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            $sub_array[] = 'N/A';
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public function initial_training_report()
    {
        $data = $this->data;

        $Report = new ReportsProcess();

        $data['InitialTrainingData'] = $Report->InitialTrainingReportData();
//        echo " <pre> ";print_r( $data['InitialTrainingData'][22] );exit;


        echo view('header', $data);
        echo view('sales/reports/initial_training_report', $data);
        echo view('footer', $data);
    }

    public function time_track_report()
    {
        $data = $this->data;
        $session = session();
        $Report = new ReportsProcess();
        $data['Filters'] = $Filters = $session->get('TimeTrackFilter');
        $data['TimeTrackReport'] = $Report::TimeTrackReport($data['Filters']);


        echo view('header', $data);
        echo view('sales/staff/time_track_report', $data);
        echo view('footer', $data);
    }

    public function product_based_lead_report()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/reports/product_based_lead_report', $data);
        echo view('footer', $data);
    }

    public function daily_leads_distribution()
    {
        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['DailyLeadsActivityReport'] = $Reports->DailyLeadsActivityReport();
        //echo'<pre>';print_r($data['DailyLeadsActivityReport']);exit;

        echo view('header', $data);
        echo view('sales/reports/daily_leads_distribution', $data);
        echo view('footer', $data);
    }

    public function organic_activities_stats()
    {
        $data = $this->data;

        $Report = new Reportsprocess();

        $session = session();

        $data['Filters'] = $Filters = $session->get('OrganicActivitiesStatFilter');
        $data['OrganicActivitiesReportData'] = $Report::OrganicActivitiesReportData($data['Filters']);

//        print_r($data['Filters']);exit;

        echo view('header', $data);
        echo view('sales/reports/organic_activities_stats', $data);
        echo view('footer', $data);
    }

    public function agent_leads_distribution()
    {
        $data = $this->data;

        $SystemUsers = new Users();
        $data['records'] = $SystemUsers->ListSalesUsers();

        echo view('header', $data);
        echo view('sales/reports/agent_leads_distribution', $data);
        echo view('footer', $data);
    }

    public
    function fetch_all_bed_loss_report()
    {
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_bed_loss_report_datatables();
        $totalfilterrecords = $Reports->count_bed_loss_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;


            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : 'Cash');
            $sub_array[] = $record['City'];
            $sub_array[] = $record['Hotel'];
            $sub_array[] = $record['CheckInDate'];
            $sub_array[] = $record['RoomNumber'];
            $sub_array[] = $record['BedLoss'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_used_transport_summary_report()
    {
        $Crud = new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();
        $records = $Reports->get_used_transport_summary_datatables();
        $totalfilterrecords = $Reports->count_used_transport_summary_filtered();
       //echo '<pre>';print_r($records);exit();

        $cnt = $_POST['start'];
        foreach ($records as $record) {
$SQL='SELECT string_agg(Distinct "pilgrim"."meta"."Value" , \',\') as "NoofVehicle"  
      FROM "pilgrim"."meta" 
      WHERE "pilgrim"."meta"."Option" LIKE \'%check-out%vehicle-number\' 
      AND "pilgrim"."meta"."AllowReference" = '.$record['UID'].'
      GROUP BY "pilgrim"."meta"."SystemDate"';
$ResultNoofVehicle=$Crud->ExecuteSQL($SQL);
//echo $Result[0]['NoofVehicle'];
//echo '<pre>';print_r($Result);
            $SQL='select coalesce( (SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  
                        FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%actual-no-of-seats\' 
                        AND "pilgrim"."meta"."AllowReference" = '.$record['UID'].'
                        GROUP BY "pilgrim"."meta"."SystemDate"
                    ) as "T1" ), 0) as "TotalUsedSeats"';
            $ResultTotalUsedSeats=$Crud->ExecuteSQL($SQL);
            //echo '<pre>';print_r($ResultTotalUsedSeats);
            $LossSeats=$record['NoOfSeats']-$ResultTotalUsedSeats[0]['TotalUsedSeats'];
            $cnt++;
            $sub_array = array();


            $sub_array[] = $cnt;
            $sub_array[] = ((isset($record['Sector'])) ? $record['Sector'] : '-');
            $sub_array[] = ((isset($ResultNoofVehicle[0]['NoofVehicle'])) ? $ResultNoofVehicle[0]['NoofVehicle'] : '-');
            $sub_array[] = ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-');
            $sub_array[] = ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-');
            $sub_array[] = ((isset($record['NoOfSeats'])) ? $record['NoOfSeats'] : '-');
            $sub_array[] = ((isset($ResultTotalUsedSeats[0]['TotalUsedSeats'])) ? $ResultTotalUsedSeats[0]['TotalUsedSeats'] : '-');
            $sub_array[] = ((isset($LossSeats)) ? $LossSeats : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }

    public
    function fetch_all_hotel_brn_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_brn_summary_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_brn_summary_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['VisaBRN'];
            $sub_array[] = ((isset($record['VisaRooms'])) ? $record['VisaRooms'] : '-');
            $sub_array[] = ((isset($record['VisaBeds'])) ? $record['VisaBeds'] : '-');
            $sub_array[] = ((isset($record['VisaBRNUse'])) ? $record['VisaBRNUse'] : '-');
            $sub_array[] = ((isset($record['VisaBRNLoss'])) ? $record['VisaBRNLoss'] : '-');
            $sub_array[] = ((isset($record['ActualBRN'])) ? $record['ActualBRN'] : '-');
            $sub_array[] = ((isset($record['ActualRooms'])) ? $record['ActualRooms'] : '-');
            $sub_array[] = ((isset($record['ActualBeds'])) ? $record['ActualBeds'] : '-');
            $sub_array[] = ((isset($record['ActualBRNUse'])) ? $record['ActualBRNUse'] : '-');
            $sub_array[] = ((isset($record['ActualBRNLoss'])) ? $record['ActualBRNLoss'] : '-');


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_hotel_brn_use_actual_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_brn_use_actual_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_brn_use_actual_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['BookingDate'];
            $sub_array[] = $record['BRNCode'];
            $sub_array[] = ((isset($record['BookingID'])) ? $record['BookingID'] : '-');
            $sub_array[] = ((isset($record['PurchasedBy'])) ? $record['PurchasedBy'] : '-');
            $sub_array[] = ((isset($record['Useddate'])) ? $record['Useddate'] : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['RoomUsed'])) ? $record['RoomUsed'] : '-');
            $sub_array[] = ((isset($record['BedUsed'])) ? $record['BedUsed'] : '-');
            $sub_array[] = ((isset($record['CheckIn'])) ? $record['CheckIn'] : '-');
            $sub_array[] = ((isset($record['CheckOut'])) ? $record['CheckOut'] : '-');
            $sub_array[] = ((isset($record['Nights'])) ? $record['Nights'] : '-');
            $sub_array[] = ((isset($record['UserName'])) ? $record['UserName'] : '-');


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }


    public
    function fetch_hotel_brn_balance_actual_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_brn_balance_actual_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_brn_balance_actual_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['BookingDate'];
            $sub_array[] = $record['BRNCode'];
            $sub_array[] = ((isset($record['BookingID'])) ? $record['BookingID'] : '-');
            $sub_array[] = $record['CityName'];
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['RoomBalanced'])) ? $record['RoomBalanced'] : '-');
            $sub_array[] = ((isset($record['BedBalanced'])) ? $record['BedBalanced'] : '-');
            $sub_array[] = ((isset($record['CheckIn'])) ? $record['CheckIn'] : '-');
            $sub_array[] = ((isset($record['CheckOut'])) ? $record['CheckOut'] : '-');
            $sub_array[] = ((isset($record['Nights'])) ? $record['Nights'] : '-');
            $sub_array[] = 'N/A';


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_vehicle_arrangement_report()
    {
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_vehicle_arrangement_report_datatables();
        $totalfilterrecords = $Reports->count_vehicle_arrangement_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt . '-' . $record['TRUID'];
            $sub_array[] = DATEFORMAT($record['TravelDate']);
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['PickupLocation'];
            $sub_array[] = $record['PickupTime'];
            $sub_array[] = $record['NoOfPax'];
            $sub_array[] = $record['TransportName'];
            $sub_array[] = $record['TotalVehicals'];
            $sub_array[] = $record['DropOffLocation'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_hotel_arrangement_report()
    {
        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();

        $room_types = $Crud->LookupOptions('room_types');
        $records = $Reports->get_hotel_arrangement_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_arrangement_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $RoomTypes = array();
            $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
            if (isset($record['RoomsPilgrims'])) {
                $RoomsPilgrims = $record['RoomsPilgrims'];
            }
            if (isset($record['SharingPilgrims'])) {
                $SharingPilgrims = $record['SharingPilgrims'];
            }

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CategoryName'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ($SharingPilgrims + $RoomsPilgrims);
            foreach ($room_types as $room_type) {
                $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
                if ($record['RoomTypeName'] != 'Sharing')
                    $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);

                $sub_array[] = (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-');
            }

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_seat_loss_report()
    {
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_seat_loss_report_datatables();
        $totalfilterrecords = $Reports->count_seat_loss_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['BookingDate'];
            $sub_array[] = $record['BRNCode'];
            $sub_array[] = $record['BookingID'];
            $sub_array[] = $record['VehicleType'];
            $sub_array[] = ((isset($record['SectorName'])) ? $record['SectorName'] : '-');
            $sub_array[] = $record['SeatLoss'];
            $sub_array[] = $record['CompanyName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_all_trnasport_brn_purchase_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_trnasport_brn_purchase_report_datatables();
        $totalfilterrecords = $Reports->count_trnasport_brn_purchase_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['GenerateDate'];

            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');
            $sub_array[] = ((isset($record['VehicleType'])) ? $record['VehicleType'] : '-');
            $sub_array[] = $record['NoOfVehicles'];
            $sub_array[] = ((isset($record['Seats'])) ? $record['Seats'] : '-');
            $sub_array[] = ((isset($record['ChechInDate'])) ? $record['ChechInDate'] : '-');
            $sub_array[] = ((isset($record['CompanyName'])) ? $record['CompanyName'] : '-');
            $sub_array[] = ((isset($record['PurchasedBy'])) ? $record['PurchasedBy'] : '-');

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }

    public
    function fetch_refund_voucher_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_voucher_refund_datatables();
        $totalfilterrecords = $Reports->count_voucher_refund_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['CreatedDate'];
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = Code('UF/V/', $record['UID']);
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = $record['TotalPilgrim'];


            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';

            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }
    public
    function fetch_all_hotel_balance_visa_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_htl_balance_visa_report_datatables();
        $totalfilterrecords = $Reports->count_htl_balance_visa_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "Beds"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-htl%accommodation\'
                AND "PM"."Value"=\'Beds\'
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-htl%brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';
            $ResultBeds=$Crud->ExecuteSQL($SQL);
            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "Rooms"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-htl%accommodation\'
                AND "PM"."Value"=\'Room\'
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-htl%brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';
            $ResultRooms=$Crud->ExecuteSQL($SQL);
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');
//            $sub_array[] = 'N/A';
//            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ((isset($record['Rooms'])) ? $record['Rooms']-$ResultRooms[0]['Rooms'] : '-');
            $sub_array[] = ((isset($record['Beds'])) ? $record['Beds']-$ResultBeds[0]['Beds'] : '-');
            $sub_array[] = ((isset($record['ChechInDate'])) ? DATEFORMAT($record['ChechInDate']) : '-');
            $sub_array[] = ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-');
            $sub_array[] = ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-');
            $sub_array[] = $record['PurchasedBy'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_transport_use_visa_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_trp_use_visa_report_datatables();
        $totalfilterrecords = $Reports->count_trp_use_visa_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "UsedSeats"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-tpt-%-no-of-seats\'
                
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-tpt-%-brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';

            $ResultSeats=$Crud->ExecuteSQL($SQL);

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            //$sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VehicalType'])) ? $record['VehicalType'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = ((isset($record['NoOfVehicles'])) ? $record['NoOfVehicles'] : '-');
            $sub_array[] = $record['Seats'];
            $sub_array[] = ((isset($ResultSeats[0]['UsedSeats'])) ? $ResultSeats[0]['UsedSeats'] : '-');



            $sub_array[] = ((isset($record['CompanyName'])) ? $record['CompanyName'] : '-');

            $sub_array[] = $record['PurchasedBy'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_transport_balance_visa_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_trp_balance_visa_report_datatables();
        $totalfilterrecords = $Reports->count_trp_balance_visa_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $SQL='SELECT count(Distinct "PM"."PilgrimUID") AS "UsedSeats"
                FROM pilgrim."meta" AS "PM"
                where "PM"."Option" like \'%allow-tpt-%-no-of-seats\'
                
                AND "PM"."SystemDate" IN(
                    SELECT "pilgrim"."meta"."SystemDate" 
                    FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Value" = CAST('.$record['UID'].' as character varying)
                    AND "pilgrim"."meta"."Option" LIKE \'%allow-tpt-%-brn-no\' 
                    GROUP BY "pilgrim"."meta"."SystemDate"
                    )';

            $ResultSeats=$Crud->ExecuteSQL($SQL);

            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VehicalType'])) ? $record['VehicalType'] : '-');
            $sub_array[] = ((isset($record['PurchaseID'])) ? $record['PurchaseID'] : '-');

            $sub_array[] = ((isset($record['NoOfVehicles'])) ? $record['NoOfVehicles'] : '-');
            $sub_array[] = $record['Seats'];
            $sub_array[] = ((isset($ResultSeats[0]['UsedSeats'])) ? $record['Seats']-$ResultSeats[0]['UsedSeats'] : '-');



            $sub_array[] = ((isset($record['CompanyName'])) ? $record['CompanyName'] : '-');

            $sub_array[] = $record['PurchasedBy'];

            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_visa_vendor_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_visa_vendor_report_datatables();
        $totalfilterrecords = $Reports->count_visa_vendor_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            $sub_array[] = Code("UF/A/", $record['AgentUID']);
            $sub_array[] = $record['VendorName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['GroupName'])) ? $record['GroupName'] : '-');
            $sub_array[] = ((isset($record['PilgrimID'])) ? $record['PilgrimID'] : '-');
            $sub_array[] = ((isset($record['PilgrimFullName'])) ? $record['PilgrimFullName'] : '-');
            $sub_array[] = ((isset($record['Gender'])) ? $record['Gender'] : '-');
            $sub_array[] = ((isset($record['PassportNumber'])) ? $record['PassportNumber'] : '-');
            $sub_array[] = ((isset($record['DOB'])) ? $record['DOB'] : '-');
            $sub_array[] = ((isset($record['Nationality'])) ? $record['Nationality'] : '-');
            $sub_array[] = ((isset($record['MOFANumber'])) ? $record['MOFANumber'] : '-');
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = ((isset($record['IATAType'])) ? ucfirst(str_replace("_", " ", $record['IATAType'])) : '-');
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_visa_vendor_summary_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_visa_vendor_summary_report_datatables();
        $totalfilterrecords = $Reports->count_visa_vendor_summary_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();


            $sub_array[] = $record['VendorName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['StartDate'])) ? $record['StartDate'] : '-');
            $sub_array[] = ((isset($record['EndDate'])) ? $record['EndDate'] : '-');
            $sub_array[] = ((isset($record['PackageAndVisa'])) ? $record['PackageAndVisa'] : '-');
            $sub_array[] = ((isset($record['VisaOnly'])) ? $record['VisaOnly'] : '-');
            $sub_array[] = ((isset($record['TotalVoucher'])) ? $record['TotalVoucher'] : '-');



            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_hotel_brn_vendor_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_brn_vendor_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_brn_vendor_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['AgentName'])) ? $record['AgentName'] : '-');
            $sub_array[] = ((isset($record['BookingDate'])) ? $record['BookingDate'] : '-');
            $sub_array[] = ((isset($record['ExpireDate'])) ? $record['ExpireDate'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['BookingID'])) ? $record['BookingID'] : '-');
            $sub_array[] = ((isset($record['HotelCity'])) ? $record['HotelCity'] : '-');
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['Rooms'])) ? $record['Rooms'] : '-');
            $sub_array[] = ((isset($record['Beds'])) ? $record['Beds'] : '-');
            $sub_array[] = ((isset($record['GenerateDate'])) ? $record['GenerateDate'] : '-');
            $sub_array[] = ((isset($record['ActiveDate'])) ? $record['ActiveDate'] : '-');
            $sub_array[] = ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-');
            $sub_array[] = ((isset($record['PurchasedBy'])) ? $record['PurchasedBy'] : '-');



            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_tpt_brn_vendor_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_tpt_brn_vendor_report_datatables();
        $totalfilterrecords = $Reports->count_tpt_brn_vendor_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['BookingDate'])) ? $record['BookingDate'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['BookingID'])) ? $record['BookingID'] : '-');
            $sub_array[] = ((isset($record['VehicleType'])) ? $record['VehicleType'] : '-');
            $sub_array[] = ((isset($record['NoOfVehicles'])) ? $record['NoOfVehicles'] : '-');
            $sub_array[] = ((isset($record['Seats'])) ? $record['Seats'] : '-');
            $sub_array[] = ((isset($record['GenerateDate'])) ? $record['GenerateDate'] : '-');
            $sub_array[] = ((isset($record['CompanyName'])) ? $record['CompanyName'] : '-');
            $sub_array[] = ((isset($record['AgentName'])) ? $record['AgentName'] : '-');



            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_hotel_vendor_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_vendor_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_vendor_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();
            $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-' . strtolower($record['CityName']) . '-status');
            $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VoucherCode'])) ? $record['VoucherCode'] : '-');
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');

            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');

            $sub_array[] = ((isset($record['ActualHotelName'])) ? $record['ActualHotelName'] : '-');
            $sub_array[] = ((isset($record['RoomType'])) ? $record['RoomType'] : '-');
            $sub_array[] = ((isset($record['RoomNo'])) ? $record['RoomNo'] : '-');
            $sub_array[] = ((isset($record['TotalPex'])) ? $record['TotalPex'] : '-');
            $sub_array[] = ((isset($record['NoOfBeds'])) ? $record['NoOfBeds'] : '-');
            $sub_array[] = ((isset($record['ActualBeds'])) ? $record['ActualBeds'] : '-');
            $sub_array[] = ((isset($record['CheckIn'])) ? $record['CheckIn'] : '-');
            $sub_array[] = ((isset($record['CheckOut'])) ? $record['CheckOut'] : '-');
            $sub_array[] = ((isset($record['Nights'])) ? $record['Nights'] : '-');
            $sub_array[] = ((isset($record['ActualArrivalTime'])) ? TIMEFORMAT(explode(',', $record['ActualArrivalTime'])[0]) : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity']));
            $sub_array[] = ((isset($record['PaxMobileNo'])) ? explode(',', $record['PaxMobileNo'])[0] : '-');
            $sub_array[] = ((isset($record['IATAType'])) ? ucfirst(str_replace("_", " ", $record['IATAType'])) : '-');
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');



            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_transport_vendor_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_transport_vendor_report_datatables();
        $totalfilterrecords = $Reports->count_transport_vendor_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = ((isset($record['CountryName'])) ? $record['CountryName'] : '-');
            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VoucherCode'])) ? $record['VoucherCode'] : '-');
            $sub_array[] = ((isset($record['CheckOutDate'])) ? explode(',', $record['CheckOutDate'])[0] : '-');
            $sub_array[] = ((isset($record['CheckOutTime'])) ? explode(',', $record['CheckOutTime'])[0] : '-');
            $sub_array[] = ((isset($record['CityName'])) ? $record['CityName'] : '-');
            $sub_array[] = ((isset($record['PickupPoint'])) ? $record['PickupPoint'] : '-');
            $sub_array[] = ((isset($record['ActualHotel'])) ? $record['ActualHotel'] : '-');
            $sub_array[] = ((isset($record['RoomNo'])) ? $record['RoomNo'] : '-');
            $sub_array[] = ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-');
            $sub_array[] = ((isset($record['Seats'])) ? $record['Seats'] : '-');
            $sub_array[] = ((isset($record['ActualDepartureTime'])) ? explode(',', $record['ActualDepartureTime'])[0] : '-');
            $sub_array[] = ((isset($record['Sector'])) ? $record['Sector'] : '-');
            $sub_array[] = ((isset($record['TransportDestination'])) ? $record['TransportDestination'] : '-');
            $sub_array[] = ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-');
            $sub_array[] = ((isset($record['VehicleNumber'])) ? $record['VehicleNumber'] : '-');
            $sub_array[] = ((isset($record['DriverName'])) ? $record['DriverName'] : '-');
            $sub_array[] = ((isset($record['DriverNumber'])) ? $record['DriverNumber'] : '-');
            $sub_array[] = ((isset($record['PaxContactNumber'])) ? $record['PaxContactNumber'] : '-');
            $sub_array[] = ((isset($record['TransportCompany'])) ? $record['TransportCompany'] : '-');

            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];





            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_hotel_brn_vendor_summary_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_hotel_brn_vendor_summary_report_datatables();
        $totalfilterrecords = $Reports->count_hotel_brn_vendor_summary_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            //$sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];

            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['HotelName'])) ? $record['HotelName'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VisaRooms'])) ? $record['VisaRooms'] : '-');
            $sub_array[] = ((isset($record['VisaBeds'])) ? $record['VisaBeds'] : '-');
            $sub_array[] = ((isset($record['ActualRooms'])) ? $record['ActualRooms'] : '-');
            $sub_array[] = ((isset($record['ActualBeds'])) ? $record['ActualBeds'] : '-');
            $sub_array[] = ((isset($record['ActualRooms'])) ? $record['ActualRooms']+$record['VisaRooms'] : '-');
            $sub_array[] = ((isset($record['ActualBeds'])) ? $record['ActualBeds']+$record['VisaBeds'] : '-');







            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_transport_brn_vendor_summary_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_transport_brn_vendor_summary_report_datatables();
        $totalfilterrecords = $Reports->count_transport_brn_vendor_summary_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();

            //$sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];

            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['TransportCompany'])) ? $record['TransportCompany'] : '-');
            $sub_array[] = ((isset($record['BRNCode'])) ? $record['BRNCode'] : '-');
            $sub_array[] = ((isset($record['VisaQty'])) ? $record['VisaQty'] : '-');
            $sub_array[] = ((isset($record['VisaSeats'])) ? $record['VisaSeats'] : '-');
            $sub_array[] = ((isset($record['ActualQty'])) ? $record['ActualQty'] : '-');
            $sub_array[] = ((isset($record['ActualSeats'])) ? $record['ActualSeats'] : '-');
            $sub_array[] = ((isset($record['ActualQty'])) ? $record['ActualQty']+$record['VisaQty'] : '-');
            $sub_array[] = ((isset($record['ActualSeats'])) ? $record['ActualSeats']+$record['VisaSeats'] : '-');







            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_hotel_vendor_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        /*$data['records'] = $Reports->hotel_summary();*/
        $room_types = $Crud->LookupOptions('room_types');

        $records = $Reports->get_hotel_vendor_summary_datatables();
        $totalfilterrecords = $Reports->count_hotel_vendor_summary_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
            $sub_array = array();

            if (isset($record['RoomsPilgrims'])) {
                $RoomsPilgrims = $record['RoomsPilgrims'];
            }
            if (isset($record['SharingPilgrims'])) {
                $SharingPilgrims = $record['SharingPilgrims'];
            }

           // $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = $record['VendorCity'];
            $sub_array[] = $record['CategoryName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = ($SharingPilgrims + $RoomsPilgrims);
            foreach ($room_types as $room_type) {
                $totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
                if ($record['RoomTypeName'] != 'Sharing')
                    $totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);

                $sub_array[] = (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-');
                //$sub_array[] = 'N/A';
            }
            $sub_array[] = $record['SharingPilgrims'];
            $sub_array[] = $totalRooms;
            $sub_array[] = $totalNights;
            $sub_array[] = $record['ReferenceName'];
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_all_transport_vendor_summary_report()
    {
        $Crud=new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_transport_vendor_summary_report_datatables();
        $totalfilterrecords = $Reports->count_transport_vendor_summary_report_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {


            $cnt++;
            $sub_array = array();


            $sub_array[] = $record['CompanyName'];

            $sub_array[] = ((isset($record['VendorCity'])) ? $record['VendorCity'] : '-');
            $sub_array[] = ((isset($record['Sector'])) ? $record['Sector'] : '-');
            $sub_array[] = ((isset($record['NoOfVehicles'])) ? $record['NoOfVehicles'] : '-');
            $sub_array[] = ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-');
            $sub_array[] = ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-');
            $sub_array[] = ((isset($record['Seats'])) ? $record['Seats'] : '-');






            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_hotel_sale_summary_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        /*$data['records'] = $Reports->hotel_summary();*/
        $room_types = $Crud->LookupOptions('room_types');

        $records = $Reports->get_hotel_sale_summary_datatables();
        $totalfilterrecords = $Reports->count_hotel_sale_summary_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $RoomsPilgrims = $SharingPilgrims = $totalNights = $totalRooms = 0;
            $sub_array = array();

          /*  if (isset($record['RoomsPilgrims'])) {
                $RoomsPilgrims = $record['RoomsPilgrims'];
            }
            if (isset($record['SharingPilgrims'])) {
                $SharingPilgrims = $record['SharingPilgrims'];
            }*/

            $sub_array[] = $cnt;
            $sub_array[] = $record['CategoryName'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['TotalPilgrims'];
            //$sub_array[] = ($SharingPilgrims + $RoomsPilgrims);
            foreach ($room_types as $room_type) {
                //$totalNights += (isset($record['RoomTypes'][$room_type['UID']]['TotalNights']) ? $record['RoomTypes'][$room_type['UID']]['TotalNights'] : 0);
                //if ($record['RoomTypeName'] != 'Sharing')
                    //$totalRooms += (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : 0);

                //$sub_array[] = (isset($record['RoomTypes'][$room_type['UID']]['TotalBeds']) ? $record['RoomTypes'][$room_type['UID']]['TotalBeds'] : '-');
                $sub_array[] =(isset($record[$room_type['UID']]) ? $record[$room_type['UID']] : '-');
            }
            $sub_array[] = $record['SharingPilgrims'];
            $sub_array[] = $record['RoomsPilgrims'];
            $sub_array[] = $record['TotalNights'];
            //$sub_array[] = $totalRooms;
            //$sub_array[] = $totalNights;
            $sub_array[] = $record['RefAgentName'];
            $dataList[] = $sub_array;
        }
//echo count($records);exit();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_transport_sale_summary_report()
    {
        $Crud = new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();
        $records = $Reports->get_transport_sale_summary_datatables();
        $totalfilterrecords = $Reports->count_transport_sale_summary_filtered();
        //echo '<pre>';print_r($records);exit();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();


            $sub_array[] = $cnt;
            $sub_array[] = ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-');
            $sub_array[] = ((isset($record['Sector'])) ? $record['Sector'] : '-');
            $sub_array[] = ((isset($record['NoOfVehicle'])) ? $record['NoOfVehicle'] : '-');
            $sub_array[] = ((isset($record['NoOfSeats'])) ? $record['NoOfSeats'] : '-');
            $sub_array[] = ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-');
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }
    public
    function fetch_service_sale_summary_report()
    {
        $Crud = new Crud();
        $dataList = array();
        $Reports = new Reportsprocess();
        $records = $Reports->get_service_sale_summary_datatables();
        $totalfilterrecords = $Reports->count_service_sale_summary_filtered();
        //echo '<pre>';print_r($records);exit();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();


            $sub_array[] = $cnt;
            $sub_array[] = ((isset($record['Packages'])) ? $record['Packages'] : '-');
            $sub_array[] = ((isset($record['VisaAndTransport'])) ? $record['VisaAndTransport'] : '-');
            $sub_array[] = ((isset($record['VisaAndHotel'])) ? $record['VisaAndHotel'] : '-');
            $sub_array[] = ((isset($record['OnlyVisa'])) ? $record['OnlyVisa'] : '-');
            $sub_array[] = ((isset($record['Hotels'])) ? $record['Hotels'] : '-');
            $sub_array[] = ((isset($record['Transport'])) ? $record['Transport'] : '-');
            $sub_array[] = ((isset($record['Services'])) ? $record['Services'] : '-');
            $sub_array[] = ((isset($record['TotalPax'])) ? $record['TotalPax'] : '-');
            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }
    public
    function fetch_tafeej_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();

        $records = $Reports->get_tafeej_transport_datatables();
        $totalfilterrecords = $Reports->count_tafeej_transport_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();


            $sub_array[] = $cnt;
            $sub_array[] = ((isset($record['CheckOutDate'])) ? DATEFORMAT($record['CheckOutDate']) : '-');

            $sub_array[] = ((isset($record['BRN'])) ? $record['BRN'] : 'Cash');

            $sub_array[] = ((isset($record['PickupPoint'])) ? $record['PickupPoint'] : '-');

            $sub_array[] = ((isset($record['TransportDestination'])) ? $record['TransportDestination'] : '-');
            $sub_array[] = $record['TotalPax'];

            $sub_array[] = ((isset($record['VehicleNumber'])) ? $record['VehicleNumber'] : '-');

            $sub_array[] = ((isset($record['DriverNumber'])) ? $record['DriverNumber'] : '-');
            $sub_array[] = ((isset($record['TransportCompany'])) ? $record['TransportCompany'] : '-');
            $sub_array[] = 'N/A';


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }
    public
    function fetch_agent_monitor_screen_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $records = $Reports->get_agent_monitor_screen_datatables();
        $totalfilterrecords = $Reports->count_agent_monitor_screen_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;

            $sub_array = array();



            $sub_array[] = $cnt;
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $record['Arrived'];

            $sub_array[] = $record['Exited'];
            $sub_array[] = $record['InKSA'];
            $sub_array[] = $record['AfterOneDay'];
            $sub_array[] = $record['AfterTwoDay'];
            $sub_array[] = $record['AfterThreeDay'];
            $sub_array[] = $record['AfterFourDay'];
            $sub_array[] = $record['AfterFiveDay'];
            $sub_array[] = $record['TotalPax']-$record['Arrived'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            $dataList[] = $sub_array;
        }
//echo count($records);exit();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
    public
    function fetch_external_agent_monitor_screen_report()
    {

        $dataList = array();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $records = $Reports->get_external_agent_monitor_screen_datatables();
        $totalfilterrecords = $Reports->count_external_agent_monitor_screen_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;

            $sub_array = array();



            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/A/', $record['AgentID']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $record['VoucherNotIssued'];

            $sub_array[] = $record['VoucherIssued'];
            $sub_array[] = $record['Arrived'];

            $sub_array[] = $record['Exited'];
            $sub_array[] = $record['InKSA'];

            $sub_array[] = $record['TotalPax']-$record['Arrived'];
            $sub_array[] = ucfirst(str_replace("_", " ", $record['IATAType']));
            $sub_array[] = $record['ReferenceName'];
            $dataList[] = $sub_array;
        }
//echo count($records);exit();
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);

    }
}
