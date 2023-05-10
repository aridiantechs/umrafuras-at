<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Users;
use App\Models\Voucher;

class Agent extends BaseController
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
        $session = session();
        $data['session'] = $session->get();
        $Agents = new Agents();
        $data['records'] = $Agents->ListAgentsWithPackageAndReference($data['session']['domainid']);
        //print_r($data['records']);exit;

        echo view('header', $data);
        echo view('agent/index', $data);
        echo view('footer', $data);
    }

    public function external_agent()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();
        $Agents = new Agents();
        $data['records'] = $Agents->ListExternalAgentsWithPackageAndReference($data['session']['domainid']);
        //print_r($data['records']);exit;

        echo view('header', $data);
        echo view('agent/external_agent', $data);
        echo view('footer', $data);
    }

    public function booking()
    {
        $data = $this->data;

        $data['Link'] = getSegment(3);


        echo view('header', $data);
        echo view('agent/booking', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('agent/inbox', $data);
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('agent/wallet', $data);
        echo view('footer', $data);
    }

    public function query()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('agent/query', $data);
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

    public function vouchers()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->VouchersListByID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->VouchersList();
        }


        echo view('header', $data);
        echo view('agent/voucher/list_voucher', $data);
        echo view('footer', $data);
    }

    public function updated_vouchers()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->UpdatedVouchersListByID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->UpdatedVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/updated_vouchers', $data);
        echo view('footer', $data);
    }

    public function voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();


        $PilgrimsList = new Voucher();
        $data['records']['pilgrims'] = $PilgrimsList->VoucherPilgrimList($data['session']['id']);

        $Packages = new Packages();
        $Main = new Main();
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
        $data['Operators'] = $Main->GetAllUmrahOperators('Visa');

        echo view('header', $data);
        echo view('agent/voucher/add_voucher', $data);
        echo view('footer', $data);
    }

    public function add_b2c_voucher()
    {
        $Crud = new Crud();
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();
        $data['GetDomainID'] = $this->MainModel->GetWebsiteDomainID($data['session']['domainid']);

        $data['B2CPackageID'] = $Crud->SingleRecord('websites."Settings"', array("DomainID" => $data['GetDomainID'], "Key" => 'b2c_package'));

//        print_r($data['GetDomainID']);
//        echo $DomainID;
//        exit;

        $PilgrimsList = new Voucher();
        $data['records']['pilgrims'] = $PilgrimsList->VoucherPilgrimList($data['session']['id']);

        $Packages = new Packages();
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['TransportTypes'] = $Packages->ListTransport();

        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        $data['ziarat'] = $Packages->ListZiyarats();

        echo view('header', $data);
        echo view('agent/voucher/add_b2c_voucher', $data);
        echo view('footer', $data);
    }

    public function all_voucher()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllVouchersListByID($data['session']['id']);
            //$data['Vouchers'] = $VoucherList->AllVouchersList();
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/all_voucher', $data);
        echo view('footer', $data);
    }

    public function b2c_voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllB2CVouchersListByID($data['session']['id']);
            //$data['Vouchers'] = $VoucherList->AllVouchersList();
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllB2CVouchersList();
        }


        echo view('header', $data);
        echo view('agent/voucher/b2c_voucher', $data);
        echo view('footer', $data);
    }

    public function pending_voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllPendingVouchersListBYID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllPendingVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/pending_voucher', $data);
        echo view('footer', $data);
    }

    public function without_voucher_arrival()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPax($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Pilgrimslist'] = $VoucherList->AllWithoutVoucherArrivalPax();
        }


        echo view('header', $data);
        echo view('agent/voucher/without_voucher_arrival', $data);
        echo view('footer', $data);
    }

    public function approved_voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllApprovedVouchersListByID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllApprovedVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/approved_voucher', $data);
        echo view('footer', $data);
    }

    public function voucher_summary()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllVouchersListByID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllVouchersList();
        }


        echo view('header', $data);
        echo view('agent/voucher/voucher_summary', $data);
        echo view('footer', $data);
    }

    public function all_executed_voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllExecutedVouchersListID($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllExecutedVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/all_executed_voucher', $data);
        echo view('footer', $data);
    }

    public function refund_vouchers()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        /*if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllRefundVouchersListId($data['session']['id']);
        } else {
            $VoucherList = new Voucher();
            $data['Vouchers'] = $VoucherList->AllRefundVouchersList();
        }*/

        echo view('header', $data);
        echo view('agent/voucher/refund_vouchers', $data);
        echo view('footer', $data);
    }

//    public function without_voucher_arrival_pax()
//    {
//        $data = $this->data;
//
//        $Pilgrims = new Pilgrims();
//        $data['records'] = $Pilgrims->WithoutVoucherArrivalPax();
//
//        echo view('header', $data);
//        echo view('agent/voucher/without_voucher_arrival_pax', $data);
//        echo view('footer', $data);
//    }

    public function refund_voucher()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('agent/voucher/refund_voucher', $data);
        echo view('footer', $data);
    }

    public function B2C()
    {
        $data = $this->data;

        /*$Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListB2CWithEmailPassword();*/

        $Operators = new Users();
        $data['OperatorsData'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('agent/B2C', $data);
        echo view('footer', $data);
    }

    public function B2B()
    {
        $data = $this->data;

        /*$Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListAllB2BPilgrims();*/

        $Operators = new Users();
        $data['OperatorsData'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('agent/B2B', $data);
        echo view('footer', $data);
    }

    public function edit_voucher()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        $id = explode("-", getSegment(3));
        $ID = $id[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        $data['VoucherFlightsDetails'] = $VouchersData->VoucherFlightsData($ID);
        $data['VoucherAccommmodationDatas'] = $VouchersData->VoucherAccommodationDetails($ID);
        $data['VoucherTransportDetails'] = $VouchersData->VoucherTransportDetails($ID);
        $data['VoucherZiyaratDetails'] = $VouchersData->VoucherZiyaratDetails($ID);
        $data['records']['pilgrims'] = $VouchersData->VoucherPilgrimList($data['session']['id']);


        $Packages = new Packages();
        $Main = new Main();
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
        $data['Operators'] = $Main->GetAllUmrahOperators('Visa');

        echo view('header', $data);
        echo view('agent/voucher/edit_voucher', $data);
        echo view('footer', $data);
    }

    public function edit_b2c_voucher()
    {
        $Crud = new Crud();

        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();
        $data['session'] = $session->get();
        $data['GetDomainID'] = $this->MainModel->GetWebsiteDomainID($data['session']['domainid']);

        $data['B2CPackageID'] = $Crud->SingleRecord('websites."Settings"', array("DomainID" => $data['GetDomainID'], "Key" => 'b2c_package'));

        $id = explode("-", getSegment(3));
        $ID = $id[0];

        $VouchersData = new Voucher();
        $data['VoucherData'] = $VouchersData->VoucherDataByID($ID);
        $data['VoucherFlightsDetails'] = $VouchersData->VoucherFlightsData($ID);
        $data['VoucherAccommmodationDatas'] = $VouchersData->VoucherAccommodationDetails($ID);
        $data['VoucherTransportDetails'] = $VouchersData->VoucherTransportDetails($ID);
        $data['VoucherZiyaratDetails'] = $VouchersData->VoucherZiyaratDetails($ID);
        $data['records']['pilgrims'] = $VouchersData->VoucherPilgrimList($data['session']['id']);


        $Packages = new Packages();
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['TransportTypes'] = $Packages->ListTransport();

        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        $data['ziarat'] = $Packages->ListZiyarats();


        echo view('header', $data);
        echo view('agent/voucher/edit_b2c_voucher', $data);
        echo view('footer', $data);
    }

    public function umrah_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/umrah_report', $data);
        echo view('footer', $data);
    }

    public function ticket_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/ticket_report', $data);
        echo view('footer', $data);
    }

    public function hotel_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/hotel_report', $data);
        echo view('footer', $data);
    }

    public function visa_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/visa_report', $data);
        echo view('footer', $data);
    }

    public function transport_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/transport_report', $data);
        echo view('footer', $data);
    }

    public function tours_report()
    {
        $data = $this->data;
        $data['Link'] = getSegment(2);
        echo view('header', $data);
        echo view('agent/reports/tours_report', $data);
        echo view('footer', $data);
    }


    /** Development Started
     * By Jawad
     */

    public
    function fetch_all_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = ''; $OperatorLogo = '-';

            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }

            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_all_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_all_voucher_change_status']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_all_voucher_print']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/vouchers_summary/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print Summary</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_all_voucher_update_history']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_all_voucher_add_refund']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/services_ziyarat_refund_modal\', ' . $voucher['UID'] . ', \'modal-lg\')">Add Refund</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = $voucher['CurrentStatus'];
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if( $data['CheckAccess']['umrah_travel_check_all_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_all_voucher_change_status'] ||
                $data['CheckAccess']['umrah_travel_check_all_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_all_voucher_update_history'] ||
                $data['CheckAccess']['umrah_travel_check_all_voucher_add_refund']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_pending_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_pending_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_pending_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = ''; $OperatorLogo = '-';

            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }
            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_pending_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if( $data['CheckAccess']['umrah_travel_check_pending_voucher_change_status'] ){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
            }
            if( $data['CheckAccess']['umrah_travel_check_pending_voucher_print'] ){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
            }
            if( $data['CheckAccess']['umrah_travel_check_pending_voucher_update_history'] ){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if( $data['CheckAccess']['umrah_travel_check_pending_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_pending_voucher_change_status'] ||
                $data['CheckAccess']['umrah_travel_check_pending_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_pending_voucher_update_history']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_approved_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_approved_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_approved_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = ''; $OperatorLogo = '-';
            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }
            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_approved_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_approved_voucher_change_status']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_approved_voucher_print']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_approved_voucher_update_history']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = ((isset($voucher['ApproveBy'])) ? $voucher['ApproveBy'] : '-');
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if($data['CheckAccess']['umrah_travel_check_approved_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_approved_voucher_change_status'] ||
                $data['CheckAccess']['umrah_travel_check_approved_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_approved_voucher_update_history']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_updated_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_updated_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_updated_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = ''; $OperatorLogo = '-';
            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }
            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_updated_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_updated_voucher_change_status']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_updated_voucher_print']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_updated_voucher_update_history']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a  href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = ((isset($voucher['ApproveBy'])) ? $voucher['ApproveBy'] : '-');
            $sub_array[] = UserNameByID($voucher['ModifiedBy']);
            $sub_array[] = DATEFORMAT($voucher['ModifiedDate']);
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if($data['CheckAccess']['umrah_travel_check_updated_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_updated_voucher_change_status'] ||
                $data['CheckAccess']['umrah_travel_check_updated_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_updated_voucher_update_history']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_executed_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_executed_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_executed_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = ''; $OperatorLogo = '-';
            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }
            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_executed_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_executed_voucher_change_status']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_executed_voucher_print']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_executed_voucher_update_history']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a  href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = ((isset($voucher['ApproveBy'])) ? $voucher['ApproveBy'] : '-');
            $sub_array[] = UserNameByID($voucher['ModifiedBy']);
            $sub_array[] = DATEFORMAT($voucher['ModifiedDate']);
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if($data['CheckAccess']['umrah_travel_check_executed_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_executed_voucher_change_status'] ||
                $data['CheckAccess']['umrah_travel_check_executed_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_executed_voucher_update_history']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_refund_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_refund_vouchers_datatables();
        $totalfilterrecords = $Vocuhers->count_all_refund_vouchers_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $voucher) {

            $sub_array = array();
            $cnt++;
            $actions = '';
            if ($voucher['AgentParentID'] > 0) {
                $Crud = new Crud();
                $table = 'main."Agents"';
                $where = array("UID" => $voucher['AgentUID']);
                $Name = $Crud->SingleRecord($table, $where);
                $SubAgentName = $Name['FullName'];

                $where = array("UID" => $voucher['AgentParentID']);
                $MainAgentName = $Crud->SingleRecord($table, $where);
                $AgentName = $MainAgentName['FullName'];

            } else {
                $SubAgentName = '-';
                $AgentName = $voucher['AgentName'];
            }
            $days = '';
            $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
            $days = $days->days;

            if($data['CheckAccess']['umrah_travel_check_refund_voucher_edit']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('agent/edit_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_refund_voucher_print']){
                $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
            }
            if($data['CheckAccess']['umrah_travel_check_refund_voucher_update_history']){
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
            }

            if( isset( $voucher['OperatorLogo'] ) && $voucher['OperatorLogo'] != '' && $voucher['OperatorLogo'] > 0 ){
                $OperatorLogo = '<img style="width: 150px !important" src="'.$data['path'].'home/load_file/'.$voucher['OperatorLogo'].'">';
            }

            $sub_array[] = $cnt;
            $sub_array[] = CountryName($voucher['AgentCountryID']);
            $sub_array[] = DATEFORMAT($voucher['CreatedDate']);
            $sub_array[] = Code('UF/V/', $voucher['UID']);
            $sub_array[] = '<a  href="' . SeoUrl('exports/voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">' . $voucher['VoucherCode'] . '</a>';
            $sub_array[] = $AgentName;
            $sub_array[] = $voucher['ArrivalDate'];
            $sub_array[] = $voucher['ReturnDate'];
            $sub_array[] = $days;
            $sub_array[] = $voucher['TotalPax'];
            $sub_array[] = $voucher['ArrivalType'];
            $sub_array[] = ucwords(str_replace('_', ' ', $voucher['AgentCategory']));
            $sub_array[] = ((isset($voucher['ApproveBy'])) ? $voucher['ApproveBy'] : '-');
            $sub_array[] = 'N/A';
            $sub_array[] = DATEFORMAT($voucher['RefundDate']);
            $sub_array[] = UserNameByID($voucher['ModifiedBy']);
            $sub_array[] = DATEFORMAT($voucher['ModifiedDate']);
            $sub_array[] = ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-');
            $sub_array[] = ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-');
            $sub_array[] = ( ( isset($voucher['OperatorName']) && $voucher['OperatorName'] != '' )? $voucher['OperatorName'] : '-' );
            if($data['CheckAccess']['umrah_travel_check_refund_voucher_edit'] ||
                $data['CheckAccess']['umrah_travel_check_refund_voucher_print'] ||
                $data['CheckAccess']['umrah_travel_check_refund_voucher_update_history']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_all_without_vouchers()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_all_without_vouchers_arrival_datatables();
        $totalfilterrecords = $Vocuhers->count_all_without_vouchers_arrival_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $Pilgrimlist) {

            $sub_array = array();
            $cnt++;
            $actions = '';

            if($data['CheckAccess']['umrah_travel_check_wdout_voucher_arrival_add_remarks']){
                $actions .= ' <a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/voucher_remarks\', ' . $Pilgrimlist['PilgrimUID'] . ', \'modal-lg\')">Add Remarks</a>';
            }

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
            if($data['CheckAccess']['umrah_travel_check_wdout_voucher_arrival_add_remarks']){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_b2b_pilgrims(){

        $data = $this->data;
        $dataList = array(); $Pilgrims = new Pilgrims();
        /* $data['records'] = $Pilgrims->ListAllB2BPilgrims();*/
        $records = $Pilgrims->get_all_b2b_pilgrims_datatables();
        $totalfilterrecords = $Pilgrims->count_all_b2b_pilgrims_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';

            if($data['CheckAccess']['umrah_groups_pilgrim_b2b_update']){
                $actions.=' <a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_groups_pilgrim_b2b_export']){
                $actions.='<a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>';
            }
            if($data['CheckAccess']['umrah_groups_pilgrim_b2b_update_b2b_visa_detail']){
                $actions.='<a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>';
            }

            $sub_array[] = $cnt;
            $sub_array[] = 'N/A';
            $sub_array[] = CountryName($record['AgentCountryID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = CityName($record['City']);
            $sub_array[] = 'N/A';
            $sub_array[] = $record['GroupName'];
            $sub_array[] = 'N/A';
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = CountryName($record['Nationality']);
            $sub_array[] = $record['Relation'];
            $sub_array[] = $record['ContactNumber'];
            $sub_array[] = $record['Email'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $data['Statuses'][$record['CurrentStatus']];
            if($data['CheckAccess']['umrah_groups_pilgrim_b2b_update'] ||
                $data['CheckAccess']['umrah_groups_pilgrim_b2b_export'] ||
                $data['CheckAccess']['umrah_groups_pilgrim_b2b_update_b2b_visa_detail']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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
    function fetch_b2c_pilgrims(){

        $data = $this->data;
        $dataList = array(); $Pilgrims = new Pilgrims();
        /*$data['records'] = $Pilgrims->ListB2CWithEmailPassword();*/
        $records = $Pilgrims->get_all_b2c_pilgrims_datatables();
        $totalfilterrecords = $Pilgrims->count_all_b2c_pilgrims_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';

            if($data['CheckAccess']['umrah_groups_pilgrim_b2c_update']){
                $actions.='<a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>';
            }
            if($data['CheckAccess']['umrah_groups_pilgrim_b2c_export']){
                $actions.='<a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>';
            }
            if($data['CheckAccess']['umrah_groups_pilgrim_b2c_update_b2c_visa_detail']){
                $actions.='<a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>';
            }

            $sub_array[] = $cnt;
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['GroupName'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = CountryName($record['Nationality']);
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $record['PilgrimEmail'];
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = 'N/A';
            $sub_array[] = $data['Statuses'][$record['CurrentStatus']];
            if($data['CheckAccess']['umrah_groups_pilgrim_b2c_update'] ||
                $data['CheckAccess']['umrah_groups_pilgrim_b2c_export'] ||
                $data['CheckAccess']['umrah_groups_pilgrim_b2c_update_b2c_visa_detail']
            ){
                $sub_array[] = '<div class="btn-group">
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
            }else{
                $sub_array[] = '-';
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

    /** Development Ends
     * By Jawad
     */
}
