<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\BrnRecords;
use App\Models\Groups;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Pilgrims;
use App\Models\Users;

class Brn extends BaseController
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

    public function promo_code()
    {
        $data = $this->data;

        $BRNData = new BrnRecords();
        $data['records'] = $BRNData->ListBRNPromoCodeData();

        echo view('header', $data);
        echo view('brn/promo_code', $data);
        echo view('footer', $data);
    }

    public function index()
    {
        $data = $this->data;

        $BRNData = new BrnRecords();
        $data['records'] = $BRNData->ListBRNData();


        echo view('header', $data);
        echo view('brn/index', $data);
        echo view('footer', $data);
    }

    public function transport_brn()
    {
        $data = $this->data;

        /*$BRNData = new BrnRecords();
        $data['records'] = $BRNData->ListBRNData();*/


        echo view('header', $data);
        echo view('brn/transport_brn', $data);
        echo view('footer', $data);
    }

    public function hotel_brn()
    {
        $data = $this->data;

        /* $BRNData = new BrnRecords();
         $data['records'] = $BRNData->ListHotelBRNData();*/


        echo view('header', $data);
        echo view('brn/hotel_brn', $data);
        echo view('footer', $data);
    }


    public function use_brn()
    {
        $data = $this->data;

        $BRNData = new BrnRecords();
        $data['records'] = $BRNData->ListUseBRNData();


        echo view('header', $data);
        echo view('brn/use_brn', $data);
        echo view('footer', $data);
    }

    public function brn_operator()
    {
        $data = $this->data;

        $Operators = new Users();
        $data['records'] = $Operators->ListOperators();


        echo view('header', $data);
        echo view('brn/brn_operator', $data);
        echo view('footer', $data);
    }

    /** Code
     * Start
     * By Jawad Sajid*/

    public
    function fetch_hotel_brn_record()
    {

        $data = $this->data;
        $dataList = array();
        $BRNData = new BrnRecords();

        $records = $BRNData->get_hotel_brn_datatables();
        $totalfilterrecords = $BRNData->count_hotel_brn_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';

            $days = '';
            $days = date_diff(date_create($record['GenerateDate']), date_create($record['ActiveDate']));
            $days = $days->days;

            if ($data['CheckAccess']['umrah_brn_management_hotel_brn_brn_update']) {
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'brn/hotel_brn_main_form\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>';
            }
            if ($data['CheckAccess']['umrah_brn_management_hotel_brn_brn_delete']) {
                $actions .= ' <a class="dropdown-item" href="#" onclick="DeleteBRN(' . $record['UID'] . ');">Delete</a>';
            }

            $sub_array[] = $cnt;
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = $record['PromoCodeName'];
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['PurchaseID'];
            $sub_array[] = $record['BRNCode'];
            $sub_array[] = CityName($record['HotelCity']);
            $sub_array[] = ucwords(str_replace("_", " ", $record['UseType']));
            $sub_array[] = $record['HotelName'];
            $sub_array[] = $record['Rooms'];
            $sub_array[] = $record['Beds'];
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = DATEFORMAT($record['ActiveDate']);
            $sub_array[] = $days . " Nights";
            $sub_array[] = DATEFORMAT($record['BookingDate']);
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = UserNameByID($record['PurchasedBy']);
            if ($data['CheckAccess']['umrah_brn_management_hotel_brn_brn_update'] ||
                $data['CheckAccess']['umrah_brn_management_hotel_brn_brn_delete']
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
    function fetch_transport_brn_record()
    {

        $data = $this->data;
        $dataList = array();
        $BRNData = new BrnRecords();

        $records = $BRNData->get_transport_brn_datatables();
        $totalfilterrecords = $BRNData->count_transport_brn_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $sub_array = array();
            $cnt++;
            $actions = '';

            if ($data['CheckAccess']['umrah_brn_management_transport_brn_update']) {
                $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'brn/transport_brn_main_form\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>';
            }
            if ($data['CheckAccess']['umrah_brn_management_transport_brn_delete']) {
                $actions .= '<a class="dropdown-item" href="#" onclick="DeleteBRN(' . $record['UID'] . ');">Delete</a>';
            }

            $sub_array[] = $cnt;
            $sub_array[] = date('Y-m-d', strtotime($record['ExpireDate']));
            $sub_array[] = $record['CompanyName'];
            $sub_array[] = CountryName($record['Country']);
            $sub_array[] = $record['AgentName'];
            $sub_array[] = ucwords(str_replace("_", " ", $record['UseType']));
            $sub_array[] = $record['PromoCodeName'];
            $sub_array[] = DATEFORMAT($record['CreatedDate']);
            $sub_array[] = $record['PurchaseID'];
            $sub_array[] = $record['BRNCode'];
            $sub_array[] = DATEFORMAT($record['GenerateDate']);
            $sub_array[] = $record['NoOfVehicles'];
            $sub_array[] = $record['Seats'];
            $sub_array[] = DATEFORMAT($record['ExpireDate']);
            $sub_array[] = DATEFORMAT($record['BookingDate']);
            $sub_array[] = OptionName($record['Company']);
            $sub_array[] = OptionName($record['TransportType']);
            $sub_array[] = OptionName($record['TransportSectors']);
            $sub_array[] = UserNameByID($record['PurchasedBy']);
            if ($data['CheckAccess']['umrah_brn_management_transport_brn_update'] ||
                $data['CheckAccess']['umrah_brn_management_transport_brn_delete']
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

    /** Code
     * Ends
     * By Jawad Sajid*/


}
