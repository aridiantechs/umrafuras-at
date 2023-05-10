<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\EmailCampaignModel;
use App\Models\Groups;
use App\Models\HRModel;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Reportsprocess;
use App\Models\SaleAgent;
use App\Models\Sales;
use App\Models\Voucher;

class Exports extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
        //header("Content-type: application/pdf");

        if ($_SERVER['HTTP_HOST'] != 'localhost') {
            header("Content-type: application/pdf");
        }
    }

    public function agents_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agents = new Agents();
        $data['records'] = $Agents->ListAgents();
        $html = view('export/records/agents_list', $data);

        $header = "<strong>Agents List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function attendance_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->AllEmployees();

        $html = view('export/hr/attendance_report', $data);

        $header = "<strong>Attendance Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function employee_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $EmployeesData = new HRModel();
        $data['EmployeesData'] = $EmployeesData->AllEmployeesSummary();
        $data['DepartmentsData'] = $EmployeesData->AllDepartments();

        $html = view('export/hr/employee_summary', $data);

        $header = "<strong>Employee Summary</strong><br> Print Date:  ".date("d M, Y");

        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function employee_attendance()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $segment = getSegment(3);
        $Array = explode('-', $segment);
        $id = $Array[0];

        $AttendanceData = new HRModel();
        $data['EmployeeAttendance'] = $AttendanceData->EmployeeAttendanceCurrentMonth($id);
        $data['EmployeeInfo'] = $AttendanceData->EmployeeDataByID($id);

        $html = view('export/hr/employee_attendance', $data);

        $header = "<strong>Employee Attendance</strong><br> Print Date:  ".date("d M, Y");

        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function sales_agents_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agents = new SaleAgent();
        $data['records'] = $Agents->ListSalesAgent();

        $html = view('export/records/sales_agents_list', $data);

        $header = "<strong>Sales Agents List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotels_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Hotels = new Packages();
        $data['records'] = $Hotels->ListHotels();

        $html = view('export/records/hotels_list', $data);

        $header = "<strong>Hotels List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotel_arrangement()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->hotel_arrangement();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');

        $html = view('export/reports/hotel_arrangement', $data);

        $header = "<strong>Hotel Arrangement</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function vehicle_arrangement()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->vehicle_arrangement();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/vehicle_arrangement', $data);

        $header = "<strong>Vehicle Arrangement</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function transport_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Transport = new Packages();
        $data['records'] = $Transport->ListTransport();

        $html = view('export/records/transport_list', $data);

        $header = "<strong>Transports List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function ziyarat_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Packages = new Packages();
        $data['ziyarats'] = $Packages->ListZiyarats();

        $html = view('export/records/ziyarat_list', $data);

        $header = "<strong>Ziyarat List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function b2b_package_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Packages = new Packages();
        $data['packages'] = $Packages->ListPackages();

        $html = view('export/records/b2b_package_list', $data);

        $header = "<strong>B2B Package List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function ListUnAssignPackages()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Packages = new Packages();
        $data['packages'] = $Packages->ListUnAssignPackages();

        $html = view('export/records/list_unassign_packages', $data);

        $header = "<strong>List of Un Assign Packages </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function b2b_external_agent_package_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Packages = new Packages();
        $data['packages'] = $Packages->ListPackagesForExternalAgents();

        $html = view('export/records/b2b_external_agent_package_list', $data);

        $header = "<strong>B2B Package List<small> (External Agent)</small></strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function b2c_package_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Packages = new Packages();
        $data['packages'] = $Packages->ListB2CPackages();

        $html = view('export/records/b2c_package_list', $data);

        $header = "<strong>B2c Package List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function visa_not_printed_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $listMofa = new MofaProcess();
        $data['records'] = $listMofa->VISANotPrinted();
        $html = view('export/records/visa_not_printed_list', $data);

        $header = "<strong>Visa Not Printed</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function visa_issued_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $listMofa = new MofaProcess();
        $data['records'] = $listMofa->VisaIssued();

        $html = view('export/records/visa_issued_list', $data);

        $header = "<strong>Visa Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

//    public function mofa_upload_list()
//    {
//        $data = $this->data;
//        $MainModel = $this->MainModel;
//
//        $listMofa = new MofaProcess();
//        $data['records'] = $listMofa->MOFAlist();
//
//        $html = view('export/records/mofa_upload_list', $data);
//
//        $header = "Mofa Upload List";
//        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
//    }

    public function visa_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/records/visa_list', $data);

        $header = "<strong>Visa Not Printed</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pilgrim_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListPilgrims();


//        $Reports = new Reportsprocess();
//        $Crud = new Crud();
//        $rec = $Reports->completed_late_departure_counter_report();
//        //$rec .= ' limit 50 offset  1';
//        $data['records'] = $Crud->ExecuteSQL($rec);
//

        $html = view('export/records/pilgrim_list', $data);

        $header = "<strong>Pilgrim List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pilgrim_list_without_voucher()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListPilgrimsWithoutVoucher();

        $html = view('export/records/pilgrim_list', $data);

        $header = "<strong>Pilgrim List Without Voucher</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

//    public function elm_list()
//    {
//        $data = $this->data;
//        $MainModel = $this->MainModel;
//
//        $PilgrimData = new Pilgrims();
//        $data['ELMDATA'] = $PilgrimData->ELMlistData();
//
//
//        $html = view('export/records/elm_lists', $data);
//
//        $header = "ELM List";
//        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
//    }

    public function pilgrim_count_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->pilgrim_count();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/pilgrim_count_report', $data);

        $header = "<strong>Pilgrim Count Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function group_stats_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->group_stats();
        $data['records'] = $Crud->ExecuteSQL($rec);
//        print_r( $data['records']);exit;


        $html = view('export/reports/group_stats_report', $data);

        $header = "<strong>Group Stats Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pilgrim_list_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Groups = new Groups();
        $data['groups'] = $Groups->ListGroups();
//
//        $Reports = new Reportsprocess();
//        $data['records'] = $Reports->pilgrim_list();


        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->pilgrim_list();
        $data['records'] = $Crud->ExecuteSQL($rec);


        //        $Reports = new Reportsprocess();
//        $Crud = new Crud();
//        $rec = $Reports->completed_late_departure_counter_report();
//        //$rec .= ' limit 50 offset  1';
//        $data['records'] = $Crud->ExecuteSQL($rec);
//


        $html = view('export/reports/pilgrim_list_report', $data);

        $header = "<strong>Pilgrim List Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function elm_report_print()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/elm_report', $data);

        $header = "<strong>ELM  Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function agent_monitor_screen()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/agent_monitor_screen', $data);

        $header = "<strong>Agent Monitor Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function arrival_summary_layout()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->arrival_transport_summary();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/arrival_summary_layout', $data);

        $header = "<strong>Arrival Summary Layout</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function external_agent_monitor_screen()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/external_agent_monitor_screen', $data);

        $header = "<strong>External Agent Monitor Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function bed_loss()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->bed_loss();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/bed_loss', $data);

        $header = "<strong>Bed Loss</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotel_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->hotel();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/hotel', $data);

        $header = "<strong>Hotel Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function actual_hotel_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->hotel();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/hotel', $data);

        $header = "<strong>Actual Hotel Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotel_summary_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();
        $data['room_types'] = $Crud->LookupOptions('room_types');


        $Reports = new Reportsprocess();
        $rec = $Reports->hotel_summary();
        $records = $Crud->ExecuteSQL($rec);

//         print_r($records);exit;
//
        foreach ($records as $record) {
            if (!isset($FinalArray[$record['Hotel']]['RoomType'])) {
                $FinalArray[$record['Hotel']] = $record;
            }
            if ($record['RoomTypeName'] == 'Sharing') {
                $FinalArray[$record['Hotel']]['SharingPilgrims'] += $record['TotalPilgrims'];
            } else {
                $FinalArray[$record['Hotel']]['RoomsPilgrims'] += $record['TotalPilgrims'];
            }

            $FinalArray[$record['Hotel']]['RoomTypes'][$record['RoomType']]['TotalNights'] += $record['TotalNights'];
            $FinalArray[$record['Hotel']]['RoomTypes'][$record['RoomType']]['TotalBeds'] += $record['TotalBeds'];
        }

        $data['records'] = $FinalArray;

        $html = view('export/reports/hotel_summary', $data);

        // What do you suggest we should do then? yes it is wht it is.i know but still still

        $header = " <strong>Hotel Summary Report</strong> ";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function transport_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->actual_used_transport();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/transport', $data);

        $header = "<strong>Transport Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function organic_activities_stats()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Report = new Reportsprocess();

        $session = session();

        $data['Filters'] = $Filters = $session->get('OrganicActivitiesStatFilter');
        $data['OrganicActivitiesReportData'] = $Report::OrganicActivitiesReportData($data['Filters']);

//        print_r($data['OrganicActivitiesReportData']);

        $html = view('export/reports/organic_activities_stats', $data);
        $getDate = date(' h:i:A   d-M-Y ');
        $header = "<strong>Organic Activities Stats</strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }


    public function approved_voucher_report()
    {
        $data = $this->data;
        $Crud = new Crud();
        $MainModel = $this->MainModel;


        $Reports = new Reportsprocess();
        $rec = $Reports->approved_voucher_report();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/approved_voucher_report', $data);

        $header = "<strong>Approved Voucher Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function arrival_airports()
    {
        $data = $this->data;
        $Crud = new Crud();

        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $rec = $Reports->arrival_airport();
        $data['records'] = $Crud->ExecuteSQL($rec);


//        $Reports = new Reportsprocess();
//        $rec = $Reports->pax_in_saudi_arabia();
//        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/arrival_airports', $data);

        $header = "<strong>Arrival Airport Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function pax_in_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $Reports = new Reportsprocess();
        $rec = $Reports->pax_in_mecca();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $MainModel = $this->MainModel;
        $html = view('export/reports/pax_in_mecca', $data);

        $header = "<strong>Pax In Mecca Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pax_in_medina()
    {
        $data = $this->data;
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->pax_in_medina();
        $data['records'] = $Crud->ExecuteSQL($rec);
        $MainModel = $this->MainModel;
        $html = view('export/reports/pax_in_medina', $data);

        $header = "<strong>Pax In Medina Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pax_in_jeddah()
    {
        $data = $this->data;
        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->pax_in_jeddah();
        $data['records'] = $Crud->ExecuteSQL($rec);
        $MainModel = $this->MainModel;
        $html = view('export/reports/pax_in_jeddah', $data);

        $header = "<strong>Pax In Jeddah Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pax_in_saudi_arabia()
    {
        $data = $this->data;
        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->pax_in_saudi_arabia();
        $data['records'] = $Crud->ExecuteSQL($rec);

//        print_r($data['records']);exit;

        $MainModel = $this->MainModel;
        $html = view('export/reports/pax_in_saudi_arabia', $data);

        $header = "<strong>Pax In Saudi Arabia Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_tpt_arrival()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_tpt_arrival();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_tpt_arrival', $data);

        $header = "<strong>Allow Transport Arrival</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function allow_transport_departure()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->allow_transport_departure();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_tpt_departure', $data);

        $header = "<strong>Allow Transport Departure Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt_arrival()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_tpt_arrival();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_tpt_arrival', $data);

        $header = "<strong>Completed Allow Transport Arrival Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt_departure()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_transport_departure();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_tpt_departure', $data);

        $header = "<strong>Completed Allow Transport Departure</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_tpt_jeddah', $data);

        $header = "<strong>Completed Allow Transport Jeddah</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt_mecca()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_tpt_mecca', $data);

        $header = "<strong>Completed Allow Transport Mecca</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_tpt_medina', $data);

        $header = "<strong>Completed Allow Transport Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function arrival_htl_mecca()
    {

        $data = $this->data;
        $data = $this->data;
        $Reports = new Reportsprocess();
        $dataSet1 = $Reports->arrival_htl_mecca();
        $dataSet2 = $Reports->no_arrival_htl_mecca();
        $finalArray = array_merge($dataSet1, $dataSet2);


        $data['records'] = $finalArray;


        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/arrival_htl_mecca', $data);

        $header = "<strong>Allow Hotel Mecca</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_htl_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_medina();


        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_htl_medina', $data);

        $header = "<strong>Allow Hotel Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_arrival_htl_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_medina();


        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_arrival_htl_medina', $data);

        $header = "<strong>Completed Allow Hotel Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_htl_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_jeddah();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_htl_jeddah', $data);

        $header = "<strong>Allow Hotel Jeddah</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function arrival_htl_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_medina();

        $MainModel = $this->MainModel;
        $html = view('export/arrival_htl_medina', $data);

        $header = "<strong>Allow Hotel Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_htl_medina()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_htl_medina();

        $MainModel = $this->MainModel;
        $html = view('export/completed_allow_htl_medina', $data);

        $header = "<strong>Completed Allow Hotel Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_htl_jeddah()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_jeddah();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_htl_jeddah', $data);

        $header = "<strong>Compelted Allow Hotel Jeddah</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_htl_mecca()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->arrival_htl_mecca();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_htl_mecca', $data);

        $header = "<strong>Allow Hotel Mecca Completed</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_htl_mecca()
    {

        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->completed_allow_htl_mecca();

        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/completed_allow_htl_mecca', $data);

        $header = "<strong>Completed Allow Hotel Mecca </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function arrival_hotel()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->arrival_hotel();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/arrival_hotel', $data);

        $header = "<strong>Arrival Hotel Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function departure_hotel()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/departure_hotel', $data);

        $header = "<strong>Departure Hotel Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function completed_allow_tpt()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/completed_allow_tpt', $data);

        $header = "<strong>Completed Allow Tranpsort</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_tpt_mecca()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_tpt_mecca', $data);

        $header = "<strong>Allow Tranpsort Mecca</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_tpt_medina()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_tpt_medina', $data);

        $header = "<strong>Allow Tranpsort Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function allow_tpt_jeddah()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/stats_reports/allow_tpt_jeddah', $data);

        $header = "<strong>Allow Tranpsort Jeddah</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function agent_work_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->agent_work_report();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/agent_work_report', $data);

        $header = "<strong>Agent Work Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function elm_summary_daywise()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->elm_summary_daywise();
        $html = view('export/reports/elm_summary_daywise', $data);

        $header = "<strong>ELM Summary DayWise Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function voucher_update_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/voucher_update_report', $data);

        $header = "<strong>Voucher Update Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function zone_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/zone_summary', $data);

        $header = "<strong>Zone Summary Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function voucher_issue_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->voucher_issue_report();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/voucher_issue_report', $data);

        $header = "<strong>Voucher Issue Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function departure_airport()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->departure_airport();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/departure_airport', $data);
        $header = "<strong>Departure Airport Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }


    public function transport_summary_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
         $rec = $Reports->used_transport_summary();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/transport_summary', $data);

        $header = "<strong>Transport Summary Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function summary_list_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/summary_list_report', $data);

        $header = "<strong>Summary List Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function group_pilgrim_list()
    {
        $data = $this->data;

        $MainModel = $this->MainModel;

        $code = explode("-", getSegment(3));
        $data['group_id'] = $code[0];


        $Groups = new Groups();
        $data['records'] = $Groups->ListGroupPilgrims($data['group_id']);

        $GroupData = $Groups->ListGroupDetail($data['group_id']);
        $data['GroupData'] = $GroupData[0];

        $html = view('export/records/group_pilgrim_list_report', $data);

        $header = "<strong>Group Pilgrims List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public
    function vouchers_summary()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['voucher_id'] = $ID = $code[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        $UmrahOperator = $data['VoucherData']['UmrahOperator'];
        $data['AgentUID'] = $AgentUID = $data['VoucherData']['AgentUID'];
        $data['VoucherPilgrimsData'] = $VouchersData->VoucherPilgrimData($ID);
        $data['FlightsData'] = $VouchersData->VoucherFlightsData($ID);
        $data['AccommmodationDetails'] = $VouchersData->VoucherAccommmodationData($ID);
        $data['TransportDetails'] = $VouchersData->VoucherTransportData($ID);
        $data['ZiyaratDetails'] = $VouchersData->VoucherZiyaratData($ID);
        $data['ServicesDetails'] = $VouchersData->VoucherServicesDatas($ID);


        $MainModel = $this->MainModel;
        $width = "style = width : 100px";
        $html = view('export/voucher-summary', $data);
        $header = "<small>Voucher Summary</small><br><strong>" . Code('UF/V/', $data['voucher_id']) . "</strong><br><br><img src=" . BarCode($data['voucher_id']) . ".$width>";
        $STATUS = $data['VoucherData']['CurrentStatus'];
        $MainModel->GenerateVoucherPDF($html, $header, $AgentUID, $STATUS, $UmrahOperator);
    }

    public function voucher()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['voucher_id'] = $ID = $code[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        //$data['VoucherFlightsDetails'] = $VouchersData->VoucherFlightsData($ID);
        $data['VoucherFlightsDeparture'] = $VouchersData->GetVoucherFlightDataByType($ID, 'Departure');
        $data['VoucherFlightsReturn'] = $VouchersData->GetVoucherFlightDataByType($ID, 'Return');

        // $data['VoucherAccommmodationDatas'] = $VouchersData->VoucherAccommmodationData($ID);
        $data['VoucherAccommodationData'] = $VouchersData->GetVoucherAccommodationDetails($ID);

        $data['VoucherTransportDatas'] = $VouchersData->VoucherTransportData($ID);

        $data['VoucherZiyaratDatas'] = $VouchersData->VoucherZiyaratData($ID);

        $data['VoucherServicesDatas'] = $VouchersData->VoucherServicesDatas($ID);

        $AgentUID = $data['VoucherData']['AgentUID'];
        $UmrahOperator = $data['VoucherData']['UmrahOperator'];
        $AgentModal = new Agents();
        $data['AgentData'] = $AgentModal->AgentsProfile($AgentUID);

        $PackageModal = new Packages();
        $data['PackageData'] = $PackageModal->ListPackagesByAgentID($AgentUID);

        $data['VoucherSettings'] = $VouchersData->VoucherSettingsData($data['AgentData']['WebsiteDomain']);


        $data['pilgrims'] = $VouchersData->VoucherPilgrimData($ID);
        //print_r($data);exit;

        $ChildCounter = 1;
        $AdultCounter = 1;
        $InfantCounter = 1;
        foreach ($data['pilgrims'] as $pilgrim) {
            if (AGE($pilgrim['DOB']) <= 2) {
                $data['Infants'] = $InfantCounter++;
            } else if (AGE($pilgrim['DOB']) <= 12) {
                $data['Childs'] = $ChildCounter++;
            } else if (AGE($pilgrim['DOB']) >= 13) {
                $data['Adults'] = $AdultCounter++;
            }
        }

        $MainModel = $this->MainModel;
        $width = "style = width : 100px";
        $html = view('export/voucher', $data);
        $header = "<small>Voucher</small><br><strong>" . Code('UF/V/', $data['voucher_id']) . "</strong><br><br><img src=" . BarCode($data['voucher_id']) . ".$width>";
        $agentid = $data['AgentData']['UID'];
        $STATUS = $data['VoucherData']['CurrentStatus'];
        $MainModel->GenerateVoucherPDF($html, $header, $agentid, $STATUS, $UmrahOperator);
    }

    public function new_voucher()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['voucher_id'] = $ID = $code[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        $data['VoucherFlightsDeparture'] = $VouchersData->GetVoucherFlightDataByType($ID, 'Departure');
        $data['VoucherFlightsReturn'] = $VouchersData->GetVoucherFlightDataByType($ID, 'Return');

        $data['VoucherAccommodationData'] = $VouchersData->GetVoucherAccommodationDetails($ID);
        $data['VoucherTransportDatas'] = $VouchersData->VoucherTransportData($ID);
        $data['VoucherZiyaratDatas'] = $VouchersData->VoucherZiyaratData($ID);
        $data['VoucherServicesDatas'] = $VouchersData->VoucherServicesDatas($ID);

        $AgentUID = $data['VoucherData']['AgentUID'];
        $UmrahOperator = $data['VoucherData']['UmrahOperator'];
        $AgentModal = new Agents();
        $data['AgentData'] = $AgentModal->AgentsProfile($AgentUID);

        $PackageModal = new Packages();
        $data['PackageData'] = $PackageModal->ListPackagesByAgentID($AgentUID);
        $data['VoucherSettings'] = $VouchersData->VoucherSettingsData($data['AgentData']['WebsiteDomain']);
        $data['pilgrims'] = $VouchersData->VoucherPilgrimData($ID);

        $ChildCounter = 1;
        $AdultCounter = 1;
        $InfantCounter = 1;
        foreach ($data['pilgrims'] as $pilgrim) {
            if (AGE($pilgrim['DOB']) <= 2) {
                $data['Infants'] = $InfantCounter++;
            } else if (AGE($pilgrim['DOB']) <= 12) {
                $data['Childs'] = $ChildCounter++;
            } else if (AGE($pilgrim['DOB']) >= 13) {
                $data['Adults'] = $AdultCounter++;
            }
        }

        $MainModel = $this->MainModel;
        $width = "style = width : 100px";
        $html = view('export/voucher', $data);
        $head = "<small>Voucher</small><br><strong>" . Code('UF/V/', $data['voucher_id']) . "</strong><br><br><img src=" . BarCode($data['voucher_id']) . ".$width>";
        $AgentID = $data['AgentData']['UID'];
        $Status = $data['VoucherData']['CurrentStatus'];
        $MainModel->GenerateVoucherMPDF($head, $html, 'test.pdf', $AgentID, $Status, $UmrahOperator);
    }

    public function b2c_voucher()
    {

        helper('main');
        //echo "<pre>";
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['voucher_id'] = $ID = $code[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        //print_r($data['VoucherData']);
        $data['VoucherFlightsDetails'] = $VouchersData->VoucherFlightsData($ID);
        //print_r($data['VoucherFlightsDetails']);

        $data['VoucherAccommmodationDatas'] = $VouchersData->VoucherAccommmodationData($ID);
        //print_r($data['VoucherAccommmodationDatas']);

        $data['VoucherTransportDatas'] = $VouchersData->VoucherTransportData($ID);
        //print_r($data['VoucherTransportDatas']);

        $data['VoucherZiyaratDatas'] = $VouchersData->VoucherZiyaratData($ID);
        //print_r($data['VoucherZiyaratDatas']);

        $data['VoucherServicesDatas'] = $VouchersData->VoucherServicesDatas($ID);
        //print_r($data['VoucherZiyaratDatas']);

        $AgentUID = $data['VoucherData']['AgentUID'];
//        $AgentModal = new Agents();
//        $data['AgentData'] = $AgentModal->AgentsProfile($AgentUID);

        $PackageModal = new Packages();
        $data['PackageData'] = $PackageModal->ListPackagesByAgentID($AgentUID);

//        $data['VoucherSettings'] = $VouchersData->VoucherSettingsData($data['AgentData']['WebsiteDomain']);

        $data['pilgrims'] = $VouchersData->VoucherPilgrimData($ID);
        //print_r($data);exit;
        $ChildCounter = 1;
        $AdultCounter = 1;
        $InfantCounter = 1;
        $PilgrimDom = '';
        foreach ($data['pilgrims'] as $pilgrim) {
            $PilgrimDom = $pilgrim['WebsiteDomain'];
            if (AGE($pilgrim['DOB']) <= 2) {
                $data['Infants'] = $InfantCounter++;
            } else if (AGE($pilgrim['DOB']) <= 12) {
                $data['Childs'] = $ChildCounter++;
            } else if (AGE($pilgrim['DOB']) >= 13) {
                $data['Adults'] = $AdultCounter++;
            }
        }

        $data['VoucherSettings'] = $VouchersData->VoucherSettingsData($PilgrimDom);


        $MainModel = $this->MainModel;
        $width = "style = width : 100px";
        $html = view('export/b2c_voucher', $data);
        $header = "<small>Voucher</small><br><strong>" . Code('UF/V/', $data['voucher_id']) . "</strong><br><br><img src=" . BarCode($data['voucher_id']) . ".$width>";
        $agentid = $data['AgentData']['UID'];
        $STATUS = $data['VoucherData']['CurrentStatus'];
        $MainModel->GenerateB2CVoucherPDF($html, $header, $STATUS);
    }

    public function groups()
    {

        helper('main');
        //echo "<pre>";
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['group_id'] = $ID = $code[0];

        $GroupsData = new Groups();

        $data['GroupData'] = $GroupsData->GroupsData($ID);
        //print_r($data['GroupData']);exit;


        $data['GroupAccommmodationDatas'] = $GroupsData->GroupAccommmodationData($ID);
        //print_r($data['VoucherAccommmodationDatas']);

        $data['GroupTransportDatas'] = $GroupsData->GroupTransportData($ID);
        //print_r($data['VoucherTransportDatas']);

        $data['GroupZiyaratDatas'] = $GroupsData->GroupZiyaratData($ID);
        //print_r($data['VoucherZiyaratDatas']);

        $data['GroupServicesDatas'] = $GroupsData->GroupServicesDatas($ID);
        //print_r($data['VoucherZiyaratDatas']);


        $data['pilgrims'] = $GroupsData->GroupPilgrimData($ID);


        $AgentUID = $data['GroupData']['AgentID'];
        $AgentModal = new Agents();
        $data['AgentData'] = $AgentModal->AgentsProfile($AgentUID);
        $data['PackageData'] = $AgentModal->GetPackage($AgentUID);


        $MainModel = $this->MainModel;
        $width = "style = width : 100px";
        $html = view('export/group', $data);
        $header = "<small>Group</small><br><strong>" . Code('UF/G/', $data['group_id']) . "</strong><br><br><img src=" . BarCode($data['group_id']) . ".$width>";
        $agentid = $data['AgentData']['UID'];
        $STATUS = 'Group';
        $MainModel->GenerateVoucherPDF($html, $header, $agentid, $STATUS);
    }


    public function voucher_invoice()
    {

        helper('main');
        //echo "<pre>";
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['voucher_id'] = $ID = $code[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        //print_r($data['VoucherData']);
        $data['VoucherFlightsDetails'] = $VouchersData->VoucherFlightsData($ID);
        //print_r($data['VoucherFlightsDetails']);

        $data['VoucherAccommmodationDatas'] = $VouchersData->VoucherAccommmodationData($ID);
        //print_r($data['VoucherAccommmodationDatas']);

        $data['VoucherTransportDatas'] = $VouchersData->VoucherTransportData($ID);
        //print_r($data['VoucherTransportDatas']);

        $data['VoucherZiyaratDatas'] = $VouchersData->VoucherZiyaratData($ID);
        //print_r($data['VoucherZiyaratDatas']);

        $data['VoucherServicesDatas'] = $VouchersData->VoucherServicesDatas($ID);
        //print_r($data['VoucherZiyaratDatas']);

        $AgentUID = $data['VoucherData']['AgentUID'];
        $AgentModal = new Agents();
        $data['AgentData'] = $AgentModal->AgentsProfile($AgentUID);
        $PackageModal = new Packages();
        $data['PackageData'] = $PackageModal->ListPackagesByAgentID($AgentUID);

        $data['pilgrims'] = $VouchersData->VoucherPilgrimData($ID);
        //print_r($data);exit;

        $ChildCounter = 1;
        $AdultCounter = 1;
        $InfantCounter = 1;
        foreach ($data['pilgrims'] as $pilgrim) {
            if (AGE($pilgrim['DOB']) <= 2) {
                $data['Infants'] = $InfantCounter++;
            } else if (AGE($pilgrim['DOB']) <= 12) {
                $data['Childs'] = $ChildCounter++;
            } else if (AGE($pilgrim['DOB']) >= 13) {
                $data['Adults'] = $AdultCounter++;
            }
        }

        $MainModel = $this->MainModel;

        $html = view('export/voucher_invoice', $data);
        $header = "<small>Voucher Inovice</small><br><strong>" . Code('UF/V/', $data['voucher_id']) . "</strong>";
        $agentid = $data['AgentData']['UID'];
        $MainModel->GenerateVoucherPDF($html, $header, $agentid);
    }

    public function b2b_package()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['record_id'] = $code[0];

        $Packages = new Packages();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
//         echo "<pre>"; print_r($data['hotelsRate']);
//         exit;
        $aData = array();
        if ($data['hotelsRate']) {
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsRecords'] = $aData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($data['TransportData']); exit;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $TransportDBData = array();
        if ($data['TransportDBData']) {
            foreach ($data['TransportDBData'] as $TD) {
                $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
            }
        }

        $data['TransportDBData'] = $TransportDBData;
        //echo "<pre>"; print_r($data); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']);
        $aData = array();
        if ($data['ziyaratRate']) {

            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
            }
        }


        $data['ZiyaratRecords'] = $aData;
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        $aServiceData = array();
        if ($data['ServiceRate']) {

            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($data['ServiceData']); exit;


        $data['VisaDetails'] = $Packages->PackageVisaRatesByPKGID($data['record_id']);


        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        // print_r($data['RoomTypes']);
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        // echo "<pre>"; print_r($data['HotelsRecords']);

        $MainModel = $this->MainModel;
        $html = view('export/b2b_package', $data);
//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>B2B Package</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function unassign_b2b_package()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['record_id'] = $code[0];

        $Packages = new Packages();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
//         echo "<pre>"; print_r($data['hotelsRate']);
//         exit;
        $aData = array();
        if ($data['hotelsRate']) {
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsRecords'] = $aData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($data['TransportData']); exit;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $TransportDBData = array();
        if ($data['TransportDBData']) {
            foreach ($data['TransportDBData'] as $TD) {
                $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
            }
        }

        $data['TransportDBData'] = $TransportDBData;
        //echo "<pre>"; print_r($data); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']);
        $aData = array();
        if ($data['ziyaratRate']) {

            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
            }
        }


        $data['ZiyaratRecords'] = $aData;
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        $aServiceData = array();
        if ($data['ServiceRate']) {

            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($data['ServiceData']); exit;


        $data['VisaDetails'] = $Packages->PackageVisaRatesByPKGID($data['record_id']);


        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        // print_r($data['RoomTypes']);
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        // echo "<pre>"; print_r($data['HotelsRecords']);

        $MainModel = $this->MainModel;
        $html = view('export/unassign_b2b_package', $data);
//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>Un assign B2B Package</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function un_assign_b2b_package()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['record_id'] = $code[0];
        $Packages = new Packages();
        $data['packages'] = $Packages->ListUnAssignPackagesByID($data['record_id']);

        $MainModel = $this->MainModel;
        $html = view('export/b2b_package', $data);
//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>Un Assign B2B Package</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }


    public function b2c_package()
    {

        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['record_id'] = $code[0];

        $Packages = new Packages();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
        // echo "<pre>"; print_r($data['hotelsRate']);
        if ($data['hotelsRate']) {
            $aData = array();
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsRecords'] = $aData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($data['TransportData']); exit;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $Data = array();
        foreach ($data['TransportDBData'] as $TD) {
            $Data[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
        }
        $data['TransportDBData'] = $Data;
        //echo "<pre>"; print_r($data); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']);
        if ($data['ziyaratRate']) {
            $aData = array();
            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aData[$CityID['CityID']][$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
            }
        }
        $data['ZiyaratRecords'] = $aData;
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        if ($data['ServiceRate']) {
            $aServiceData = array();
            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($data['ServiceData']); exit;

        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        // print_r($data['RoomTypes']);
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        // echo "<pre>"; print_r($data['HotelsRecords']);

        $MainModel = $this->MainModel;
        $html = view('export/b2c_package', $data);
//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>B2c Package</strong>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);

    }

    public function ziyarat()
    {
        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['ziyarat_id'] = $code[0];

        $Ziyarats = new Packages();
        $data['ziyarat_data'] = $Ziyarats->ZiyaratsData($data['ziyarat_id']);
        $data['ziyarat_meta'] = $Ziyarats->ZiyaratsMetaData($data['ziyarat_id']);


        $MainModel = $this->MainModel;
        $html = view('export/ziyarat', $data);

//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>Ziyarat</strong>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);


    }

    public function transport()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $code = explode("-", getSegment(3));
        $data['transport_id'] = $code[0];

        $Transports = new Packages();
        $data['transport_data'] = $Transports->TransportsData($data['transport_id']);
        $data['transport_images'] = $Transports->TransportImages($data['transport_id']);


        $html = view('export/transport', $data);
        $header = "<strong>" . $data['records']['Name'] . "</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotel()
    {
        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['package_id'] = 19;
        $data['hotel_id'] = $code[0];

        $hotelData = new Packages();
        $data['hotel_data'] = $hotelData->HotelsData($data['hotel_id']);
        $data['hotel_meta'] = $hotelData->HotelsMeta($data['hotel_id']);
        $data['hotel_images'] = $hotelData->HotelImages($data['hotel_id']);
        $MainModel = $this->MainModel;
        $html = view('export/hotel', $data);
//        $parms = array("header_img" => "pdf-package-header.jpg","footer_img" => "pdf-package-footer.jpg","css" => "dompdf-pacakge.css",);
        $header = "<strong>Hotel</strong>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function pilgrim()
    {
        helper('main');
        $data = $this->data;
        $code = explode("-", getSegment(3));
        $data['pilgrim_id'] = $code[0];

        $Pilgrims = new Pilgrims();
        $data['pilgrim_data'] = $Pilgrims->PilgrimsData($data['pilgrim_id']);
        $data['pilgrim_mofa_data'] = $Pilgrims->PilgrimMOFAData($data['pilgrim_id']);
        $data['pilgrim_transport_data'] = $Pilgrims->PilgrimTranportData($data['pilgrim_id']);
        $data['pilgrim_passport_data'] = $Pilgrims->PilgrimsPassportData($data['pilgrim_id']);

        $MainModel = $this->MainModel;
        $html = view('export/pilgrim', $data);
        $header = "<small>Pilgrim Profile</small><br><strong>" . $data['pilgrim_data']['FirstName'] . "</strong>";
        $MainModel->GeneratePortraitPDF($html, $header);
    }


    public function stats_b2c()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/stats_reports/b2c', $data);

        $header = "<strong>B2C</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function stats_b2b()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_b2b();

        $html = view('export/stats_reports/b2b', $data);

        $header = "<strong>B2B</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function external()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->stats_external();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/stats_reports/external', $data);

        $header = "<strong>External</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function total_pax()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_total_pax();


        $html = view('export/stats_reports/total_pax', $data);

        $header = "<strong>Total Pax</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function mofa_issued()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->stats_mofa_issued();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/stats_reports/mofa_issued', $data);

        $header = "<strong>MOFA Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function visa_not_issue()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Reports = new Reportsprocess();
        $data['records'] = $Reports->stats_visa_not_issued();

        $html = view('export/stats_reports/visa_not_issue', $data);

        $header = "<strong>Visa Not Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function visa_issue()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->stats_visa_issued();
        $data['records'] = $Crud->ExecuteSQL($rec);
        $html = view('export/stats_reports/visa_issue', $data);

        $header = "<strong>Visa Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function voucher_not_issued()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();

        $Reports = new Reportsprocess();
        $rec = $Reports->stats_voucher_not_issued();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/stats_reports/voucher_not_issued', $data);

        $header = "<strong>Voucher Not Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function voucher_issued()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->voucher_issue_report();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/stats_reports/voucher_issued', $data);

        $header = "<strong>Voucher Issued</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function jeddah_arrival()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/stats_reports/jeddah_arrival', $data);

        $header = "<strong>Jeddah Arrival</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function check_in_mecca()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_mecca();

        $html = view('export/stats_reports/check_in_mecca', $data);

        $header = "<strong>Check In Mecca</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function check_in_medina()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_medina();

        $html = view('export/stats_reports/check_in_medina', $data);

        $header = "<strong>Check In Medina</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function check_in_jeddah()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->check_in_jeddah();


        $html = view('export/stats_reports/check_in_jeddah', $data);

        $header = "<strong>Check In Jeddah</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function pilgrim_exit()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->pilgrim_exit();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/stats_reports/pilgrim_exit', $data);

        $header = "<strong>Pilgrim Exit</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function update_voucher_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Crud = new Crud();
        $Reports = new Reportsprocess();
        $rec = $Reports->update_voucher_list();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/stats_reports/update_voucher_list', $data);

        $header = "<strong>Update Voucher List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function refund_voucher_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/stats_reports/refund_voucher_list', $data);

        $header = "<strong>Refund Voucher List</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function package_summary_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/stats_reports/package_summary_report', $data);

        $header = "<strong>Package Summary Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function allow_bed()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/records/allow_bed', $data);

        $header = "<strong>Free Bed Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function free_bed_completed()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/records/free_bed_completed', $data);

        $header = "<strong>Free Bed Completed Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function hotel_sale_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/reports/hotel_sale_summary', $data);

        $header = "<strong>Hotel Sale Summary</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function transport_sale_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/reports/transport_sale_summary', $data);

        $header = "<strong>Transport Sale Summary</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function service_sale_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/reports/service_sale_summary', $data);

        $header = "<strong>Service Sale Summary</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function passport_completed()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->passport_completed();
        //$rec .= ' limit 50 offset  1';
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/reports/passport_completed', $data);

        $header = "<strong>Passport Completed</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function passport_pending()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();

        $Reports = new Reportsprocess();
        $rec = $Reports->passport_pending();
        $data['records'] = $Crud->ExecuteSQL($rec);
        $html = view('export/reports/passport_pending', $data);

        $header = "<strong>Passport Pending</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function ppt_management()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();

        $Reports = new Reportsprocess();
        $rec = $Reports->ppt_management();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/records/ppt_management', $data);

        $header = "<strong>Passport Management Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }

    public function passport_management_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/passport_management_report', $data);

        $header = "<strong>Passport Management Report</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function trp_package()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/trp_package', $data);

        $header = "<strong>TRP Package</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function trp_use_visa()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/trp_use_visa', $data);

        $header = "<strong>TRP BRN Use Visa</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function trp_use_actual()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $data['records'] = $Reports->trp_use_actual();

        $Crud = new Crud();

        $session = session();
        $SessionFilters = $session->get('TransportBrnUseActualReportSessionFilters');
        $TransportSector = '';

        if (isset($SessionFilters['tpt_sector']) && $SessionFilters['tpt_sector'] != '') {
            $TransportSector = $SessionFilters['tpt_sector'];
        }

        /** Transport Sectors Data For Report*/
        $TransportSectorSql = ' SELECT main."LookupsOptions".*
                        FROM main."LookupsOptions" 
                        JOIN main."Lookups" ON ( main."Lookups"."UID" = main."LookupsOptions"."LookupID" )
                        WHERE main."Lookups"."Key" = \'transport_sectors\' AND main."LookupsOptions"."Archive" = 0
                     ';

        if ($TransportSector != '') {
            $TransportSectorSql .= ' AND main."LookupsOptions"."UID" = ' . $TransportSector . ' ';
        }

        $TransportSectorSql .= ' ORDER BY main."LookupsOptions"."Name" ASC';
        $data['sectors'] = $Crud->ExecuteSQL($TransportSectorSql);


        $html = view('export/brn/trp_use_actual', $data);

        $header = "<strong>TRP Use Actual</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function actual_trp_balance()
    {

        $data = $this->data;
        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->trp_balance_actual();
        $Crud = new Crud();
        $data['sectors'] = $Crud->LookupOptions('transport_sectors');
        $html = view('export/brn/actual_trp_balance', $data);

        $header = "<strong>Actual TRP Balance</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function trp_balance_visa()
    {

        $data = $this->data;
        $MainModel = $this->MainModel;


        $html = view('export/brn/trp_balance_visa', $data);


        $header = "<strong>TRP Balance Visa</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function htl_purchase()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->htl_brn_purchase();
        //$rec .= ' limit 50 offset  1';
        $data['HtlPurchase'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/htl_purchase', $data);

        $header = "<strong>HTL Purchase</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function htl_use_visa()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->htl_brn_use_visa();
        // $rec .= ' limit 50 offset 1';
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/brn/htl_use_visa', $data);
//        echo $html;
//        exit;

        $header = "<strong>HTL Use Visa</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function hotel_use_actual()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->hotel_use_actual();
        // $rec .= ' limit 50 offset 1';
        $data['records'] = $Crud->ExecuteSQL($rec);
//        print_r($data['records']);
//        exit;

        $html = view('export/brn/hotel_use_actual', $data);

        $header = "<strong>HTL Use Actual</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);

    }

    public function htl_balance_visa()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/htl_balance_visa', $data);

        $header = "<strong>HTL Balance Visa</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function htl_balance_actual()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->hotel_brn_balance_actual();
        // $rec .= ' limit 50 offset 1';
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/brn/htl_balance_actual', $data);

        $header = "<strong>HTL Balance Actual</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function hotel_brn_use()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/hotel_brn_use', $data);

        $header = "<strong>Hotel BRN Use</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function transport_brn_use()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/transport_brn_use', $data);

        $header = "<strong>Transport BRN Use</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function seat_loss()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->hotel_seat_loss();
        // $rec .= ' limit 50 offset 1';
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/seat_loss', $data);

        $header = "<strong>Seat Loss</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function allow_beds()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/allow_beds', $data);

        $header = "<strong>Allow Beds</strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function ppt_management_pending()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/ppt_management_pending', $data);

        $header = "<strong>PPT Management Pending </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function brn_summary_ptl()
    {

        $data = $this->data;
        $MainModel = $this->MainModel;
        $data = $this->data;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->brn_summary_ptl();


        $html = view('export/brn/brn_summary_ptl', $data);

        $header = "<strong> </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function brn_summary_htl()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->hotel_brn_summary();
        // $rec .= ' limit 50 offset 1';
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/brn_summary_htl', $data);

        $header = "<strong>BRN Summary HTL </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function without_voucher_arrival()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $session = session();
        $session = $session->get();
        $Reports = new Voucher();
        $Crud = new Crud();

        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent") {
            $rec = $Reports->AllWithoutVoucherArrivalPax($session['id']);

        } else {
            $rec = $Reports->AllWithoutVoucherArrivalPax();

        }
        //$rec .= ' limit 50 offset  1';
        $data['Pilgrimslist'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/without_voucher_arrival', $data);

        $header = "<strong>Without Voucher Arrival </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function completed_without_voucher_arrival()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/brn/completed_without_voucher_arrival', $data);

        $header = "<strong>Completed Without Voucher Arrival </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function late_departure()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->completed_late_departure_counter_report();
        //$rec .= ' limit 50 offset  1';
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/late_departure', $data);

        $header = "<strong>Late Departure </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function Over25DaysArrival()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $data['records'] = $Reports->late_departure_counter_report();

        $html = view('export/brn/Over25DaysArrival', $data);

        $header = "<strong>Over 25 Days Arrival Report </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function Over25DaysArrivalCompleted()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
//        $data['records'] = $Reports->completed_late_departure_counter_report();

        $html = view('export/brn/Over25DaysArrivalCompleted', $data);

        $header = "<strong>Over 25 Days Arrival Report Completed </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }


    public function trp_brn_purchase()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Crud = new Crud();

        $Reports = new Reportsprocess();
        $rec = $Reports->trp_brn_purchased();
        $data['records'] = $Crud->ExecuteSQL($rec);

        $html = view('export/brn/trp_brn_purchase', $data);

        $header = "<strong>Transport BRN Purchase </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function active_agent()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agents = new Agents();
        $data['records'] = $Agents->ListActiveAgents();

        $html = view('export/active_agent', $data);

        $header = "<strong>Active Agents </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function b2b_agent()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agents = new Agents();
        $data['records'] = $Agents->ListB2BAgents();

        $html = view('export/b2b_agent', $data);

        $header = "<strong>B2B Agents </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function executed_voucher()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Crud = new Crud();

        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $rec = $Reports->executed_voucher();
        $data['records'] = $Crud->ExecuteSQL($rec);


//        print_r($data['records']);
//        exit;

        $html = view('export/reports/executed_voucher', $data);

        $header = "<strong>Executed Voucher </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function voucher_summary()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;


        $Crud = new Crud();

        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $rec = $Reports->voucher_summary();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/voucher_summary', $data);

        $header = "<strong>Voucher Summary </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function approved_voucher()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $html = view('export/reports/approved_voucher', $data);

        $header = "<strong>Approved Voucher </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function pending_voucher()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = new Crud();

        $MainModel = $this->MainModel;
        $Reports = new Reportsprocess();
        $rec = $Reports->pending_voucher_report();
        $data['records'] = $Crud->ExecuteSQL($rec);


        $html = view('export/reports/pending_voucher', $data);

        $header = "<strong>Pending Voucher </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }


    public function external_agent()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Agents = new Agents();
        $data['records'] = $Agents->ListExternalAgents();

        $html = view('export/external_agent', $data);

        $header = "<strong>External Agents </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }


    public function inactive_agent()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agents = new Agents();
        $data['records'] = $Agents->ListInActiveAgents();

        $html = view('export/inactive_agent', $data);

        $header = "<strong>In Active Agents </strong>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);


    }

    public function tafeej_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $html = view('export/tafeej_report', $data);

        $header = "<strong>Tafeej Report </strong>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);


    }

    public function time_track_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $session = session();
        $Report = new ReportsProcess();
        $data['Filters'] = $Filters = $session->get('TimeTrackFilter');
        $data['TimeTrackReport'] = $Report->TimeTrackReport($data['Filters']);

        $html = view('export/sales/reports/time_track_report', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>Time Track Report </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);

    }


    public function emaillisting()
    {
        $data = $this->data;
        $UID = getSegment(3);

        $MainModel = $this->MainModel;
        $EmailCampaigns = new EmailCampaignModel();
        $data['All_Email_Name'] = $EmailCampaigns->ListOFAllEmailByID($UID);


        $html = view('export/sales/reports/testCSV', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>reports CSV </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);

    }

    public function product_based_lead_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $session = session();

        $html = view('export/sales/reports/product_based_lead_report', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>Product Base Leads Reports </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function daily_leads_distribution()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $session = session();
        $Reports = new Reportsprocess();
        $data['DailyLeadsActivityReport'] = $Reports->DailyLeadsActivityReport();

        $html = view('export/sales/reports/daily_leads_distribution', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>Leads Distribution Report </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function close_lead_quality()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $session = session();

        $html = view('export/sales/reports/close_lead_quality', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>Close Leads Quality Report  </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GenerateReportPDF($html, $header);
    }


    public function initial_training_report()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $session = session();

        $Report = new ReportsProcess();
        $data['InitialTrainingData'] = $Report->InitialTrainingReportData();

        $html = view('export/sales/reports/initial_training_report', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>Initial Training Reports  </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);


    }

    public function worksheet_list()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Sales = new Sales();
        $data['WorkSheetData'] = $Sales::GetAllWorkSheetDataWithLimit();

        $html = view('export/sales/reports/worksheet_list_report', $data);
        $getDate = date(' h:i:A   d-M-Y ');

        $header = "<strong>WorkSheet List Reports  </strong><br><small>Print Date: $getDate</small>";
        $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);
    }

    public function worksheet()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        $Sales = new Sales();
        $data['WorkSheetID'] = $WorkSheetID = getSegment(3);
        if (isset($WorkSheetID) && $WorkSheetID != '' && $WorkSheetID > 0) {

            $data['WorkSheetData'] = $Sales::GetWorkSheetDataForPrintByUID($WorkSheetID);

            $html = view('export/sales/reports/worksheet_report', $data);
            $getDate = date(' h:i:A   d-M-Y ');

            $header = "<strong>WorkSheet Reports  </strong><br><small>Print Date: $getDate</small>";
            $HtmlContent = $MainModel->GeneratePortraitPDF($html, $header);

        } else {
            return redirect()->to($data['path'] . 'lead/worksheet');
            exit;
        }

    }


}
