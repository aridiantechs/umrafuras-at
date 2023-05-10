<?php namespace App\Controllers;

use App\Models\Groups;
use App\Models\Main;
use App\Models\Pilgrims;
use App\Models\Users;
use App\Models\Packages;
use App\Models\Crud;

class Group extends BaseController
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
        $data['type'] = getSegment(3);
        $Status= getSegment(3);

        $Groups = new Groups();
        $data['records'] = $Groups->ListGroups($Status);

        $Operators = new Users();
        $data['Operators'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('group/index', $data);
        echo view('footer', $data);
    }


    public function deleted_groups()
    {
        $data = $this->data;

        $Groups = new Groups();
        $data['records'] = $Groups->ListDeletedGroups();

        $Operators = new Users();
        $data['Operators'] = $Operators->ListOperators();

        echo view('header', $data);
        echo view('group/deleted_groups', $data);
        echo view('footer', $data);
    }


//    public function export_groups()
//    {
//        $data = $this->data;
//
//
//        echo view('header', $data);
//        echo view('group/export_groups', $data);
//        echo view('footer', $data);
//    }

    public function profile()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('group/profile', $data);
        echo view('footer', $data);
    }
    public function add_group()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        $Packages = new Packages();
        $Crud = new Crud();
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['TransportTypes'] = $Packages->ListTransport();

        $TransportData = array();
        foreach($data['TransportTypes'] AS $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        $data['ziarat'] = $Packages->ListZiyarats();

        echo view('header', $data);
        echo view('group/add_group', $data);
        echo view('footer', $data);
    }

    public function edit_group()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        $ID = getSegment(3);
        
        
        $Groups = new Groups();
        $data['records'] = $Groups->ListGroupDetail($ID);
        $data['Hotels'] = $Groups->ListGroupHotelDetail($ID);
        $data['Transports'] = $Groups->ListGroupTransportDetail($ID);
        $data['Ziyarats'] = $Groups->ListGroupZiyaratDetail($ID);
        $data['Extras'] = $Groups->ListGroupExtras($ID);





        $Packages = new Packages();
        $Crud = new Crud();
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['TransportTypes'] = $Packages->ListTransport();

        $TransportData = array();
        foreach($data['TransportTypes'] AS $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        $data['ziarat'] = $Packages->ListZiyarats();

        echo view('header', $data);
        echo view('group/edit_group', $data);
        echo view('footer', $data);
    }



    /** Code Start By Jawad */

    public
    function fetch_groups_record(){

        $data = $this->data;
        $dataList = array();
        $Groups = new Groups();

        $Type = $_POST['type'];
        $records = $Groups->get_groups_datatables($Type);
        $totalfilterrecords = $Groups->count_groups_filtered($Type);

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++; $sub_array = array(); $roombedHTML = array(); $actions = '';

            $GroupPilgrims = $Groups->CountGroupPilgrims($record['UID']);
            $countrecords = count($GroupPilgrims);

            $hotelname = ''; $numberofbeds = 0; $numberofrooms = 0; $ToolTipHTML = '';
            $ROOMSHTMLSTRING = explode("$", $record['ROOMSHTMLSTRING']);
            foreach ($ROOMSHTMLSTRING as $ROOMSHOTEL) {
                $ROOMSHOTEL = trim($ROOMSHOTEL);
                $hotelname .= $ROOMSHOTEL . "<hr>";
                $ROOMSHOTELS = explode("|", $ROOMSHOTEL);
                $ToolTipHTML .= (( $ROOMSHOTELS[0] != '' )? '<strong style="color: black; font-weight: bolder;">' . $ROOMSHOTELS[0] . '</strong>' : '').( ( $ROOMSHOTELS[1] != '' )? '<br>'.$ROOMSHOTELS[1].'<hr>' : '' );
                $numberofbeds += $ROOMSHOTELS[2];
                $numberofrooms += $ROOMSHOTELS[3];
            }
            if ($numberofbeds > 0) {
                $roombedHTML[] = $numberofbeds . ' Beds';
            }
            if ($numberofrooms > 0) {
                $roombedHTML[] = $numberofrooms . ' Rooms';
            }

            $Category = 'B2B';
            if ($record['IATAType'] == 'external_agent') {
                $Category = 'External Agent';
            }

            if($Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_export'] || $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_export']){
                $actions .='<a class="dropdown-item" href="' . SeoUrl('exports/groups/' . $record['UID'] . "-" . $record['FullName']) . '" target="_blank">Export</a>';
            }
            if($Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_update'] || $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_update']){
                $actions .='<a target="_blank" class="dropdown-item" href="' . $data['path'] . 'group/edit_group/' . $record['UID'] . '">Update</a>';
            }
            if($Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_delete'] || $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_delete']){
                $actions .=' <a  class="dropdown-item ' . (($data['session']['mis_type'] == 'other') ? 'd-none' : '') . '" href="#" onclick="DeleteGroup(' . $record['UID'] . ');">Delete</a>';
            }

            $sub_array[] = '<td class="checkbox-column">
                                <label class="new-control new-checkbox checkbox-primary"
                                       style="height: 18px; margin: 0 auto;">
                                    <input type="checkbox" class="new-control-input todochkbox"
                                           id="chk' . $record['UID'] . '" data-groupsid="' . $record['UID'] . '">
                                    <span class="new-control-indicator"></span>
                                </label>
                            </td>';
            $sub_array[] = $cnt;
            $sub_array[] = DATEFORMAT($record['SystemDate']);
            $sub_array[] = $record['CountryName'];
            $sub_array[] = $record['Agentname'];
            $sub_array[] = $Category;
            $sub_array[] ='<a href="' . SeoUrl('exports/groups/' . $record['UID'] . "-" .$record['FullName']) .
                '" target="_blank">'. Code('UF/G/',$record['UID']).'</a>';
            $sub_array[] = $record['WTUCode'];
            $sub_array[] = $record['FullName'];
            $sub_array[] = ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-');
            $sub_array[] = ((count($roombedHTML) > 0) ? implode(" & ", $roombedHTML) : '-').' '.(($ToolTipHTML != '') ? '<span class="CellComment">'.$ToolTipHTML.'</span>' : ' ');
            $sub_array[] = $record['NoOfPAX'];
            $sub_array[] = ((isset($record['MeccaNights'])) ? $record['MeccaNights'] : '-');
            $sub_array[] = ((isset($record['MedinaNights'])) ? $record['MedinaNights'] : '-');
            $sub_array[] = ((isset($record['JeddahNights'])) ? $record['JeddahNights'] : '-');
            $sub_array[] = ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-');
            $sub_array[] = DATEFORMAT($record['ArrivalDate']);
            $sub_array[] = DATEFORMAT($record['DepartureDate']);
            $sub_array[] = ((isset($record['TransportType'])) ? $record['TransportType'] : '-');
            $sub_array[] = ((isset($record['Sector'])) ? $record['Sector'] : '-');
            $sub_array[] = ((isset($record['OtherServices'])) ? $record['OtherServices'] : '-');
            $sub_array[] = Money($record['RefundAmount']);
            $sub_array[] = Money($record['GrandTotal'] + $record['RefundAmount']);

            $sub_array[] = $countrecords;
            $sub_array[] = ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-');
            $sub_array[] = ucwords(str_replace('-', ' ', $Type));
            ( ( $Type != 'in-complete' )? $sub_array[] = 'N/A' : '' );
            if($Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_export'] ||
                $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_export'] ||
                $Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_update'] ||
                $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_update'] ||
                $Type == 'in-complete' && $data['CheckAccess']['umrah_groups_manage_incomplete_delete'] ||
                $Type == 'complete' && $data['CheckAccess']['umrah_groups_manage_complete_delete']
            ){
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

}
