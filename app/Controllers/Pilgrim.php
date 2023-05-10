<?php namespace App\Controllers;

use App\Models\Activities;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Agents;
use App\Models\Groups;
use App\Models\Main;
use App\Models\Users;
use App\Models\Voucher;
use App\Models\Crud;

class Pilgrim extends BaseController
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

        $Pilgrims = new Pilgrims();
        //$data['records'] = $Pilgrims->ListPilgrims();

        $Operators = new Users();
        $data['OperatorsData'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('pilgrim/index', $data);
        echo view('footer', $data);
    }

    public function b2b_pilgrims()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('pilgrim/b2b_pilgrim_list', $data);
        echo view('footer', $data);
    }

    public function b2c()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('pilgrim/b2c', $data);
        echo view('footer', $data);
    }

    public function b2c_pilgrims()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('pilgrim/b2c_pilgrim_list', $data);
        echo view('footer', $data);
    }

    function fetch_pilgrims()
    {
        $data = $this->data;
        $AgentsDropDown = $data['AgentsDropDown'];
        $Pilgrims = new Pilgrims();
        $records = $Pilgrims->get_pilgrims_datatables();
        $totalrecords = $Pilgrims->TotalListPilgrims();
        $totalfilterrecords = $Pilgrims->count_pilgrimsfiltered();

        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/P/', $record['UID']);
            if (isset($record['AgentName'])) {
                $Agent = $record['AgentName'];

            } else {
                $Agent = '<div class="form-group"><select onchange="AgentPilgrimAssign(this.value,\'.$record[\'UID\'].\');"  class="form-control" title="Agents" id="Agents" name="Agents">\';
                                                 ' . $AgentsDropDown['html'] . ';
                                    </select></div>';
            }
            $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>
                                    <a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>
                        </div>';
            $sub_array[] = $Agent;
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $record['CurrentStatus'];
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
                                            ' . $actions . '
                                        </div>';
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

    function fetch_b2b_pilgrims()
    {
        $data = $this->data;
        $AgentsDropDown = $data['AgentsDropDown'];
        $Pilgrims = new Pilgrims();
        $records = $Pilgrims->get_b2b_pilgrims_datatables();
        $totalfilterrecords = $Pilgrims->count_b2b_pilgrims_filtered();

        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/P/', $record['UID']);
            if (isset($record['AgentName'])) {
                $Agent = $record['AgentName'];

            } else {
                $Agent = '<div class="form-group"><select onchange="AgentPilgrimAssign(this.value,\'.$record[\'UID\'].\');"  class="form-control" title="Agents" id="Agents" name="Agents">\';
                                                 ' . $AgentsDropDown['html'] . ';
                                    </select></div>';
            }

            $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>
                                    <a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>
                        </div>';

            $sub_array[] = $Agent;
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $record['CurrentStatus'];
            $sub_array[] = $record['VoucherID'];
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
                                            ' . $actions . '
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

    function fetch_b2c()
    {
        $data = $this->data;
        $AgentsDropDown = $data['AgentsDropDown'];
        $Pilgrims = new Pilgrims();
        $records = $Pilgrims->get_b2c_plgrm();
        $totalfilterrecords = $Pilgrims->count_b2c_plgrm();

        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/P/', $record['UID']);
            if (isset($record['AgentName'])) {
                $Agent = $record['AgentName'];

            } else {
                $Agent = '<div class="form-group"><select onchange="AgentPilgrimAssign(this.value,\'.$record[\'UID\'].\');"  class="form-control" title="Agents" id="Agents" name="Agents">\';
                                                 ' . $AgentsDropDown['html'] . ';
                                    </select></div>';
            }
            $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>
                                    <a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>
                        </div>';
            $sub_array[] = $Agent;
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $record['CurrentStatus'];
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
                                            ' . $actions . '
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

    function fetch_b2c_pilgrims()
    {
        $data = $this->data;
        $AgentsDropDown = $data['AgentsDropDown'];
        $Pilgrims = new Pilgrims();
        $records = $Pilgrims->get_b2c_pilgrims_datatables();
        $totalfilterrecords = $Pilgrims->count_b2c_pilgrims_filtered();

        $dataList = array();
        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $cnt++;
            $sub_array = array();
            $sub_array[] = $cnt;
//            $sub_array[] = Code('UF/P/', $record['UID']);

            if (isset($record['AgentName'])) {
                $Agent = $record['AgentName'];

            } else {
                $Agent = '<div class="form-group">
                              <select onchange="AgentPilgrimAssign(this.value,\'.$record[\'UID\'].\');"  class="form-control" title="Agents" id="Agents" name="Agents">\';
                                                 ' . $AgentsDropDown['html'] . ';
                                    </select></div>';
            }
            $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $data['path'] . 'pilgrim/new/' . $record['UID'] . '">Update</a>
                                    <a class="dropdown-item" href="' . SeoUrl('exports/pilgrim/' . $record['UID'] . "-" . $record['FirstName']) . ' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', ' . $record['UID'] . ')" >Update Visa Detail</a>
                        </div>';
            $sub_array[] = 'N/A';
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = CityName($record['CityID']);
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['Email'];
            $sub_array[] = $record['ContactNumber'];
            $sub_array[] = DomainName($record['WebsiteDomain']);
            $sub_array[] = 'N/A';
            //            $sub_array[] = '<div class="btn-group">
//                                            <button type="button"
//                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
//                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
//                                                    aria-expanded="false" data-reference="parent">
//                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
//                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
//                                                     stroke-linecap="round" stroke-linejoin="round"
//                                                     class="feather feather-chevron-down">
//                                                    <polyline points="6 9 12 15 18 9"></polyline>
//                                                </svg>
//                                            </button>
//                                            ' . $actions . '
//                                        </div>';
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

    public function without_voucher_arrival_pax()
    {
        $data = $this->data;

        $Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListPilgrimsWithoutVoucher();

        $Operators = new Users();
        $data['OperatorsData'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('pilgrim/pilgrims_without_voucher', $data);
        echo view('footer', $data);
    }

    public function pilgrim_transfer()
    {
        $data = $this->data;
        $AgentsModel = new Agents();
        $data['AllAgents'] = $AgentsModel->AllAgentList();

        /*$Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListPilgrimsData();*/

        echo view('header', $data);
        echo view('pilgrim/pilgrim_transfer', $data);
        echo view('footer', $data);
    }

    public function profile()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('pilgrim/profile', $data);
        echo view('footer', $data);
    }

    public function file_uploader()
    {
        $data = $this->data;
        $data['segment'] = getSegment(3);
        if (!$data['segment']) {
            $data['segment'] = 'mofa';
        }
        //echo $data['segment'];

        switch ($data['segment']) {
            case 'mofa';
                /*$listMofa = new MofaProcess();
                $data['records'] = $listMofa->MOFAlist();*/
                break;
            case 'visa';
                $Pilgrims = new Pilgrims();
                $data['Pilgrims'] = $Pilgrims->PilgrimsListWithOutVisa();
                break;
            case 'elm';
                /*$PilgrimData = new Pilgrims();
                $data['ELMDATA'] = $PilgrimData->ELMlistData();*/
                break;
            case 'dep_elm';
                /*$PilgrimData = new Pilgrims();
                $data['ELMDATA'] = $PilgrimData->ELMlistData();*/
                break;
            case 'city';
                $CitiesData = new Pilgrims();
                $data['Cities'] = $CitiesData->Cities();
                break;
        }


        echo view('header', $data);
        echo view('pilgrim/pilgrim_uploader/index', $data);
        echo view('footer', $data);
    }

    public function new()
    {
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
        echo view('pilgrim/main_form', $data);
        echo view('footer', $data);


    }

    public function new_bulk()
    {
        $data = $this->data;
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
//        print_r($data['AccountsData']);

        echo view('header', $data);
        echo view('pilgrim/bulk_form', $data);
        echo view('footer', $data);


    }

    public function new_b2c()
    {
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
        echo view('agent/new_b2c', $data);
        echo view('footer', $data);


    }

    public function voucher()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('pilgrim/pilgrim_voucher', $data);
        echo view('footer', $data);
    }

    public function update()
    {
        $data = $this->data;
        $data['record_id'] = getSegment(3);

        echo view('header', $data);
        echo view('pilgrim/update_register', $data);
        echo view('footer', $data);
    }

    public function pilgrim_activity()
    {
        $data = $this->data;
        $data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsActivity();

        echo view('header', $data);
        echo view('pilgrim/pilgrim_activity', $data);
        echo view('footer', $data);
    }

    public function allow_hotel_activities()
    {
        $data = $this->data;
        /*$data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsAllowHotelActivity();*/

        $Packages = new Packages();
        $data['Hotels'] = $Packages->ListAllHotels();
        $session = session();
        $data['session'] = $session->get();

        echo view('header', $data);
        echo view('pilgrim/allow_hotel_activities', $data);
        echo view('footer', $data);
    }


    public function allowed_hotel_activities()
    {
        $data = $this->data;
        /*$data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsAllowHotelActivity();*/

        echo view('header', $data);
        echo view('pilgrim/allowed_hotel_activities', $data);
        echo view('footer', $data);
    }


    public function actual_hotel_activities()
    {
        $data = $this->data;
        /* $data['record_id'] = getSegment(3);
         $Vocuhers = new Voucher();
         $data['records'] = $Vocuhers->VouchersForPilgrimsActualHotelActivity();*/

        echo view('header', $data);
        echo view('pilgrim/actual_hotel_activities', $data);
        echo view('footer', $data);
    }

    public function actual_transport_activities()
    {
        $data = $this->data;
        /*$data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsActualTransportActivity();*/

        echo view('header', $data);
        echo view('pilgrim/actual_transport_activities', $data);
        echo view('footer', $data);
    }

    public function allow_transport_activities()
    {
        $data = $this->data;

        /*$data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsAllowTransportActivity();*/

        echo view('header', $data);
        echo view('pilgrim/allow_transport_activities', $data);
        echo view('footer', $data);
    }

    public function allowed_transport_activities()
    {
        $data = $this->data;

        /*$data['record_id'] = getSegment(3);
        $Vocuhers = new Voucher();
        $data['records'] = $Vocuhers->VouchersForPilgrimsAllowTransportActivity();*/

        echo view('header', $data);
        echo view('pilgrim/allowed_transport_activities', $data);
        echo view('footer', $data);
    }


    public function pending_passports()
    {
        $data = $this->data;
        $Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListPendingPassportPilgrims();

        echo view('header', $data);
        echo view('pilgrim/pending_passports', $data);
        echo view('footer', $data);
    }

    public function completed_passports()
    {
        $data = $this->data;
        $Pilgrims = new Pilgrims();
        $data['records'] = $Pilgrims->ListCompletedPassportPilgrims();

        echo view('header', $data);
        echo view('pilgrim/completed_passports', $data);
        echo view('footer', $data);
    }

    public function elm_list()
    {
        $data = $this->data;

        $PilgrimData = new Pilgrims();
        $data['ELMDATA'] = $PilgrimData->ELMlistData();
//        print_r($data['ELMDATA']);

        echo view('header', $data);
        echo view('pilgrim/elm_list', $data);
        echo view('footer', $data);
    }


    /* Development Start By Jawad Sajid Durrani */

    public
    function fetch_allow_hotel_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Activities();
        $records = $Vocuhers->get_allow_hotel_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_allow_hotel_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $days = '-';
            $actions = '';
            if ($record['CheckIn'] != '' && $record['CheckOut'] != '') {
                $days = date_diff(date_create($record['CheckIn']), date_create($record['CheckOut']));
                $days = $days->days;
            }

            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_manage']) {
                if ($record['CityName'] == 'Mecca') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-mecca:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Mecca</a>';
                } else if ($record['CityName'] == 'Medina') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-medina:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Medina</a>';
                } else if ($record['CityName'] == 'Jeddah') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-jeddah:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Jeddah</a>';
                }
            }
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':accommodation \',\'modal-lg\');">Refund Voucher</a>';
            }
            $OptionArray = array('allow-htl');
            $Voucher_pilgrim = Get_Pilgrim_On_Activity_Based($record['UID'], $OptionArray);
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VAH/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = $record['Country'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = DATEFORMAT($record['CheckIn']);
            $sub_array[] = DATEFORMAT($record['CheckOut']);
            $sub_array[] = $days;
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = $record['RoomTypeName'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $record['VoucherActivityPilgrims'];
            // $sub_array[] = $record['Voucher_pilgrim'];
            $sub_array[] = $Voucher_pilgrim;
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_refund_voucher']
            ) {
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

            } else {
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
    function fetch_allowed_hotel_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_allow_hotel_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_allow_hotel_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $days = '-';
            $actions = '';
            if ($record['CheckIn'] != '' && $record['CheckOut'] != '') {
                $days = date_diff(date_create($record['CheckIn']), date_create($record['CheckOut']));
                $days = $days->days;
            }

            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_hotel_activities_manage']) {
                if ($record['CityName'] == 'Mecca') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-mecca:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Mecca</a>';
                } else if ($record['CityName'] == 'Medina') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-medina:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Medina</a>';
                } else if ($record['CityName'] == 'Jeddah') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-jeddah:' . $record['UID'] . ' \',\'modal-xl\');">Allow Hotel Jeddah</a>';
                }
            }
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_hotel_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':accommodation \',\'modal-lg\');">Refund Voucher</a>';
            }

            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VAH/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = $record['Country'];
            $sub_array[] = $record['CityName'];
            $sub_array[] = $record['HotelName'];
            $sub_array[] = DATEFORMAT($record['CheckIn']);
            $sub_array[] = DATEFORMAT($record['CheckOut']);
            $sub_array[] = $days;
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = $record['RoomTypeName'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = $record['Voucher_pilgrim'];
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_hotel_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_hotel_activities_refund_voucher']
            ) {
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
            } else {
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
    function fetch_allow_transport_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Activities();
        $records = $Vocuhers->get_allow_transport_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_allow_transport_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';
//            $Voucher_pilgrim = $Vocuhers->CountAllowTransportVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);

            $City = CityName($record['TravelCity']);

            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_transport_activities_manage']) {
                if ($City == 'Jeddah') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-jeddah:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Jeddah</a>';
                } else if ($City == 'Mecca') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-mecca:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Mecca</a>';
                } else if ($City == 'Medina') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-medina:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Medina</a>';
                } else if ($City == 'Yanbu') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-yanbu:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Yanbu</a>';
                }
            }
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_transport_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':transport \',\'modal-lg\');">Refund Voucher</a>';
            }
            $OptionArray = array('allow-tpt');
            $Voucher_pilgrim = Get_Pilgrim_On_Activity_Based($record['UID'], $OptionArray);
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VAT/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $City;
            $sub_array[] = $record['TravelType'];
            $sub_array[] = DATEFORMAT($record['TravelDate']);
            $sub_array[] = $record['SectorName'];
            $sub_array[] = $record['TransportTypeName'];
            $sub_array[] = $record['NoOfSeats'];
            $sub_array[] = $record['TotalPax'];
            //$sub_array[] = $record['Voucher_pilgrim'];
            $sub_array[] = $Voucher_pilgrim;
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_transport_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allow_transport_activities_refund_voucher']
            ) {
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
            } else {
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
    function fetch_allowed_transport_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Voucher();
        $records = $Vocuhers->get_allow_transport_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_allow_transport_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';
            $Voucher_pilgrim = $Vocuhers->CountAllowTransportVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);

            $City = CityName($record['TravelCity']);

            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_transport_activities_manage']) {
                if ($City == 'Jeddah') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-jeddah:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Jeddah</a>';
                } else if ($City == 'Mecca') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-mecca:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Mecca</a>';
                } else if ($City == 'Medina') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-medina:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Medina</a>';
                } else if ($City == 'Yanbu') {
                    $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-yanbu:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Yanbu</a>';
                }
            }
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_transport_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':transport \',\'modal-lg\');">Refund Voucher</a>';
            }


            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VAT/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $City;
            $sub_array[] = $record['TravelType'];
            $sub_array[] = DATEFORMAT($record['TravelDate']);
            $sub_array[] = $record['SectorName'];
            $sub_array[] = $record['TransportTypeName'];
            $sub_array[] = $record['NoOfSeats'];
            $sub_array[] = $record['TotalPax'];
            $sub_array[] = count($Voucher_pilgrim);
            if ($data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_transport_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_allow_pilgrim_activity_allowd_transport_activities_refund_voucher']
            ) {
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
            } else {
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
    function fetch_actual_hotel_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Activities();
        $records = $Vocuhers->get_actual_hotel_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_actual_hotel_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {
            $CheckActual = $Vocuhers->CheckActualActivity($record['UID']);
//             print_r($CheckActual);exit;
            $sub_array = array();
            $cnt++;
            $actions = '';
            $days = '-';
            if ($record['CheckIn'] != '' && $record['CheckOut'] != '') {
                $days = date_diff(date_create($record['CheckIn']), date_create($record['CheckOut']));
                $days = $days->days;
            }

            $City = CityName($record['City']);
            $Voucher_pilgrim = $Vocuhers->CountActualHotelVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);

            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_manage']) {
                if (count($CheckActual) > 0) {
                    if ($City == 'Mecca') {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':check-in-mecca:' . $record['UID'] . ':actual \',\'modal-xl\');">Check In Mecca</a>';
                    } else if ($City == 'Medina') {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':check-in-medina:' . $record['UID'] . ':actual \',\'modal-xl\');">Check In Medina</a>';

                    } else if ($City == 'Jeddah') {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':check-in-jeddah:' . $record['UID'] . ':actual  \',\'modal-xl\');">Check In Jeddah</a>';
                    }
                }

            }
            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':accommodation \',\'modal-lg\');">Refund Voucher</a>';
            }
            $OptionArray = array('check-in');
            $Voucher_pilgrim = Get_Pilgrim_On_Activity_Based($record['UID'], $OptionArray);
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VHA/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $City;
            $sub_array[] = $record['HotelName'];
            $sub_array[] = DATEFORMAT($record['CheckIn']);
            $sub_array[] = DATEFORMAT($record['CheckOut']);
            $sub_array[] = $days;
            $sub_array[] = $record['NoOfBeds'];
            $sub_array[] = OptionName($record['RoomType']);
            $sub_array[] = $record['TotalPax'];
            //$sub_array[] = $record['Voucher_pilgrim'];
            $sub_array[] = $Voucher_pilgrim;
            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_refund_voucher']
            ) {
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
            } else {
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
    function fetch_actual_transport_activities()
    {
        $data = $this->data;
        $dataList = array();
        $Vocuhers = new Activities();
        $records = $Vocuhers->get_actual_transport_activity_datatables();
        $totalfilterrecords = $Vocuhers->count_actual_transport_activity_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';
            $CityName = $record['CityName'];
//            if ($CityName == 'mecca' || $CityName == 'medina' || $CityName == 'jeddah') {
//            $CityName = CityName($record['TravelCity']);
//            } else {
//                $CityName = 'other';
//            }
            //$Voucher_pilgrim = $Vocuhers->CountActualTransportVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);

            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_transport_activities_manage']) {
                if ($record['TravelType'] == 'Arrival') {
                    $ArrivalActivityStatuses = ArrivalActivityStatuses($CityName);
                    foreach ($ArrivalActivityStatuses as $key => $value) {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':' . $record['UID'] . ':actual \',\'modal-xl\');">' . $value . '</a>';

                    }
                } else if ($record['TravelType'] == 'Checkout') {
                    $CheckOutActivityStatuses = CheckOutActivityStatuses($CityName);
                    foreach ($CheckOutActivityStatuses as $key => $value) {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':' . $record['UID'] . ':actual \',\'modal-xl\');">' . $value . '</a>';
                    }
                } else if ($record['TravelType'] == 'Departure') {
                    $DepartureActivityStatuses = DepartureActivityStatuses($CityName);
                    foreach ($DepartureActivityStatuses as $key => $value) {
                        $actions .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':' . $record['UID'] . ':actual \',\'modal-xl\');">' . $value . '</a>';
                    }
                }
            }
            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_transport_activities_refund_voucher']) {
                $actions .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' . $record['UID'] . ':transport \',\'modal-lg\');">Refund Voucher</a>';
            }
            $OptionArray = array('check-out', 'arrival', 'departure');
            $Voucher_pilgrim = Get_Pilgrim_On_Activity_Based($record['UID'], $OptionArray);
            $sub_array[] = $cnt;
            $sub_array[] = Code('UF/VTA/', $record['UID']);
            $sub_array[] = Code('UF/V/', $record['VoucherID']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['VoucherCode'];
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['ReturnDate']);
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $CityName;
            $sub_array[] = $record['TravelType'];
            $sub_array[] = DATEFORMAT($record['TravelDate']);
            $sub_array[] = $record['SectorName'];
            $sub_array[] = $record['TransportTypeName'];
            $sub_array[] = $record['NoOfSeats'];
            $sub_array[] = $record['TotalPax'];
            //$sub_array[] = $record['Voucher_pilgrim'];
            $sub_array[] = $Voucher_pilgrim;
            if ($data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_transport_activities_manage'] ||
                $data['CheckAccess']['umrah_activity_actual_pilgrim_activity_actual_transport_activities_refund_voucher']
            ) {
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
            } else {
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
    function fetch_pilgrim_transfer()
    {

        $data = $this->data;
        $dataList = array();
        $Pilgrims = new Pilgrims();
        $AgentsModel = new Agents();
        $data['AllAgents'] = $AgentsModel->AllAgentList();

        $records = $Pilgrims->get_transfer_pilgrim_datatables();
        $totalfilterrecords = $Pilgrims->count_transfer_pilgrim_filtered();

        //$cnt = $_POST['start'];
        foreach ($records as $record) {

            $AgentSelectHtml = '<div class="form-group pull-right">
                                    <select onchange="PilgrimTransfer(this.value, ' . $record['UID'] . ');"
                                            class="form-control no-select2" title="Agents"
                                            id="Agents' . $record['UID'] . '"
                                            name="Agents">
                                            <option value="">Please select</option>';
            foreach ($data['AllAgents'] as $agent) {
                $AgentSelectHtml .= ' <option value="' . $agent['UID'] . '">' . ucwords($agent['FullName']) . ' - (' . ucwords(str_replace("_", " ", $agent['Type'])) . ')</option>  ';
            }
            $AgentSelectHtml .= '</select>
                                </div>';

            $sub_array = array();
            $sub_array[] = '<label class="new-control new-checkbox checkbox-primary"
                                               style="height: 18px; margin: 0 auto;">
                                            <input type="checkbox" class="new-control-input todochkbox ' . SeoUrl($record['GroupName'], false) . '"
                                                   id="chk' . $record['UID'] . '" data-pilgrimid="' . $record['UID'] . '">
                                            <span class="new-control-indicator"></span>
                                        </label>';
            $sub_array[] = $AgentSelectHtml;
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['Country'];
            $sub_array[] = CityName($record['CityID']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['FirstName'];
            $sub_array[] = $record['Gender'];
            $sub_array[] = $record['PassportNumber'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['DOBInYears'];
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['ContactNumber'];
            $sub_array[] = $record['Email'];
            $sub_array[] = $data['Statuses'][$record['CurrentStatus']];

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
    function fetch_all_mofa()
    {

        $dataList = array();
        $listMofa = new MofaProcess();
        $records = $listMofa->get_mofa_datatables();
        $totalfilterrecords = $listMofa->count_mofa_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;

            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $record['Operator'];
            $sub_array[] = $record['ExtAgent'];
            $sub_array[] = $record['Group'];
            $sub_array[] = $record['PrintDate'];
            $sub_array[] = $record['PilgrimName'];
            $sub_array[] = $record['PilgrimID'];
            $sub_array[] = $record['Age'];
            $sub_array[] = DATEFORMAT($record['DOB']);
            $sub_array[] = $record['GroupName'];
            $sub_array[] = $record['PassportNo'];
            $sub_array[] = $record['MOFANumber'];
            $sub_array[] = $record['IssueDateTime'];
            $sub_array[] = $record['Embassy'];
            $sub_array[] = $record['PKGCode'];
            $sub_array[] = $record['Relation'];
            $sub_array[] = $record['Nationality'];
            $sub_array[] = $record['Address'];
            $sub_array[] = $record['SubAgentName'];
            $sub_array[] = $record['MOINumber'];
            $sub_array[] = $record['INSURANCE_POLICY_ID'];
            $sub_array[] = ((isset($record['HotelBrn']) && $record['HotelBrn'] != '') ? $record['HotelBrn'] : '-');
            $sub_array[] = ((isset($record['TransportBrn']) && $record['TransportBrn'] != '') ? $record['TransportBrn'] : '-');

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
    function fetch_all_melm()
    {

        $dataList = array();
        $PilgrimData = new Pilgrims();
        $records = $PilgrimData->get_elm_datatables();
        $totalfilterrecords = $PilgrimData->count_elm_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $ELMData) {

            $cnt++;

            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $ELMData['GroupName'];
            $sub_array[] = $ELMData['PilgrimID'];
            $sub_array[] = $ELMData['FirstName'];
            $sub_array[] = date("d M, Y ", strtotime($ELMData['BirthDate']));
            $sub_array[] = $ELMData['PassportNo'];
            $sub_array[] = $ELMData['MOINumber'];
            $sub_array[] = $ELMData['VisaNo'];
            $sub_array[] = date("d M, Y ", strtotime($ELMData['EntryDate']));
            $sub_array[] = $ELMData['EntryTime'];
            $sub_array[] = $ELMData['EntryPort'];
            $sub_array[] = $ELMData['TransportMode'];
            $sub_array[] = $ELMData['EntryCarrier'];
            $sub_array[] = $ELMData['FlightNo'];

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
    function fetch_all_dep_melm()
    {

        $dataList = array();
        $PilgrimData = new Pilgrims();
        $records = $PilgrimData->get_dep_elm_datatables();
        $totalfilterrecords = $PilgrimData->count_dep_elm_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $ELMData) {

            $cnt++;

            $sub_array = array();
            $sub_array[] = $cnt;
            $sub_array[] = $ELMData['GroupName'];
            $sub_array[] = $ELMData['PilgrimID'];
            $sub_array[] = $ELMData['FirstName'];
            $sub_array[] = date("d M, Y ", strtotime($ELMData['BirthDate']));
            $sub_array[] = $ELMData['PassportNo'];
            $sub_array[] = $ELMData['MOINumber'];
            $sub_array[] = $ELMData['VisaNo'];
            $sub_array[] = date("d M, Y ", strtotime($ELMData['EntryDate']));
            $sub_array[] = $ELMData['EntryTime'];
            $sub_array[] = $ELMData['EntryPort'];
            $sub_array[] = $ELMData['TransportMode'];
            $sub_array[] = $ELMData['EntryCarrier'];
            $sub_array[] = $ELMData['FlightNo'];
            $sub_array[] = date("d M, Y ", strtotime($ELMData['ExitDate']));
            $sub_array[] = $ELMData['ExitTime'];
            $sub_array[] = ((isset($ELMData['ExitPort']) && $ELMData['ExitPort'] != '') ? $ELMData['ExitPort'] : '-');
            $sub_array[] = ((isset($ELMData['ExitTransportMode']) && $ELMData['ExitTransportMode'] != '') ? $ELMData['ExitTransportMode'] : '-');
            $sub_array[] = ((isset($ELMData['ExitCareer']) && $ELMData['ExitCareer'] != '') ? $ELMData['ExitCareer'] : '-');
            $sub_array[] = ((isset($ELMData['ExitFlightNo']) && $ELMData['ExitFlightNo'] != '') ? $ELMData['ExitFlightNo'] : '-');
            $sub_array[] = ((isset($ELMData['ActualStayingDuration']) && $ELMData['ActualStayingDuration'] != '') ? $ELMData['ActualStayingDuration'] : '-');

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

    /* Development Ends By Jawad Sajid Durrani */


}
