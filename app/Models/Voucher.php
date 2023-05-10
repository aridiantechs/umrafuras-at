<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;
use mysql_xdevapi\Session;


class Voucher extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;

        //$this->data['session'] = session()->get();
    }

    public function VoucherFormSubmit($records, $Rec, $UID, $PilgrimsID, $FlightsData, $AccommodationsData, $Transports, $Ziyarats, $ServicesID, $remarks, $Voucher_Activity_arr, $Record)
    {
        //echo'<pre>';print_r($_REQUEST['dlt_accomodation']);exit;
        //echo 'aaaa'.session()->get('id')."----".$data['session']['id'];exit();
        $data = $this->data;
        $CroneModel = new CronModel();
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $Main = new Main();

        $table = 'voucher."Master"';
        if ($UID == 0) {
            $records['CreatedBy'] = $Rec['CreatedBy'];
            $records['CreatedDate'] = $Rec['CreatedDate'];
            if ($recordID = $Crud->AddRecord($table, $records)) {
                $Record = BellNotificationUsers($session['id']);
                foreach ($Record as $value) {
                    BellNotification('New Voucher With Code  "' . $records['VoucherCode'] . '" Added In System', 'Voucher', $recordID, $value);
                }
                if (!empty($remarks['Remarks'])) {
                    $Remarksdata = array(
                        'VoucherID' => $recordID,
                        'Remarks' => $remarks['Remarks'],
                        'CreatedBy' => session()->get('id'),
                        'CreatedDate' => date('Y-m-d H:i:s'),
                    );
                    $Remarkstable = 'voucher."Remarks"';
                    $Crud->AddRecord($Remarkstable, $Remarksdata);


                }
                if ($records['VoucherType'] == 'B2C') {
//                    $VoucherCode = 'Uf/V/B2C/' . $recordID;
                    $B2CCounter = $Crud->ListRecords($table, array("VoucherType" => 'B2C'));
                    $VoucherCode = 'V/B2C/' . count($B2CCounter);
                    $Crud->UpdateRecord($table, array("VoucherCode" => $VoucherCode), array("UID" => $recordID));
                }

                $response['status'] = "success";
                $response['record_id'] = $recordID;
                $response['message'] = "Voucher Successfully Added...";

            } else {
                $response['status'] = "fail";
                $response['message'] = "Data Didn't Submitted Correctly...";
            }
        } else {
            $where = array("UID" => $UID);
            $GetCounter = $Crud->SingleRecord($table, $where);
            $records['UpdationCounter'] = $GetCounter['UpdationCounter'] + 1;
            $records['CurrentStatus'] = 'Pending';
            unset($records['VoucherCode']);
            $records['ModifiedBy'] = $Record['ModifiedBy'];
            $records['ModifiedDate'] = $Record['ModifiedDate'];
            if ($records['VoucherType'] == 'B2C') {
                $B2CCounter = $Crud->ListRecords($table, array("VoucherType" => 'B2C'));
                $VoucherCode = 'V/B2C/' . count($B2CCounter);
                $Crud->UpdateRecord($table, array("VoucherCode" => $VoucherCode), array("UID" => $UID));
            }
            $Crud->UpdateRecord($table, $records, $where);
            $Record = BellNotificationUsers($session['id']);
            foreach ($Record as $value) {
                BellNotification('Voucher With Code  "' . $GetCounter['VoucherCode'] . '" Updated In System', 'Voucher', $UID, $value);
            }
            $response['status'] = "success";
            $response['message'] = "Voucher Successfully Updated...";
        }

        $PilgrimIDs = $PilgrimsID['VoucherPilgrimID'];
        $VoucherPilgrimLeaderID = $PilgrimsID['VoucherPilgrimLeaderID'];
        if (!empty($PilgrimIDs)) {
            if (isset($PilgrimIDs)) {
                $where = array("VoucherUID" => $UID);
                $Crud->DeleteRecord('voucher."Pilgrim"', $where);
            }
            foreach ($PilgrimIDs as $PilgrimID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['VoucherUID'] = $recordID;
                } else {
                    $Values['VoucherUID'] = $UID;
                }
                $Values['PilgrimUID'] = $PilgrimID;
                if (in_array($PilgrimID, $VoucherPilgrimLeaderID))
                    $Values['Leader'] = 1;
                $Crud->AddRecord('voucher."Pilgrim"', $Values);
            }
        }

        $ServicesIDs = $ServicesID['VoucherServicesID'];
        if (!empty($ServicesIDs)) {
            if (isset($ServicesIDs)) {
                $where = array("VoucherUID" => $UID);
                $Crud->DeleteRecord('voucher."Services"', $where);
            }
            foreach ($ServicesIDs as $ServiceID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['VoucherUID'] = $recordID;
                } else {
                    $Values['VoucherUID'] = $UID;
                }
                $Values['ServiceID'] = $ServiceID;
                $Crud->AddRecord('voucher."Services"', $Values);
            }
        }

        if (isset($FlightsData)) {
            $table = 'voucher."Flights"';
            $where = array("VoucherID" => $UID);
            $Crud->DeleteRecord($table, $where);
            $FlightDescription = $FlightsData['FlightType'];
            //echo '<pre>';print_r($FlightsData);exit();
            if (!empty($FlightDescription[0])) {
                for ($a = 0; $a < count($FlightDescription); $a++) {
                    $FlightData = array();
                    if ($UID == 0) {
                        $FlightData['VoucherID'] = $recordID;
                    } else {
                        $FlightData['VoucherID'] = $UID;
                    }
                    $FlightData['TravelSelf'] = $FlightsData['TravelSelf'][$a];
                    $FlightData['FlightType'] = $FlightsData['FlightType'][$a];
                    $FlightData['Airline'] = ((isset($FlightsData['Airline'][$a])) ? $FlightsData['Airline'][$a] : 0);//$FlightsData['Airline'][$a];
                    $FlightData['SectorTo'] = $FlightsData['SectorTo'][$a];
                    $FlightData['SectorFrom'] = $FlightsData['SectorFrom'][$a];
                    $FlightData['Reference'] = $FlightsData['Reference'][$a];
                    $FlightData['PNR'] = $FlightsData['PNR'][$a];
                    $FlightData['DepartureDate'] = $FlightsData['DepartureDate'][$a];
                    $FlightData['DepartureTime'] = $FlightsData['DepartureTime'][$a];
                    $FlightData['ArrivalDate'] = $FlightsData['ArrivalDate'][$a];
                    $FlightData['ArrivalTime'] = $FlightsData['ArrivalTime'][$a];
                    $FlightData['TravelType'] = $FlightsData['TravelType'][$a];
                    //echo '<pre>';print_r($FlightData);
                    $Crud->AddRecord($table, $FlightData);
                }
            }
        }

        /*if (isset($AccommodationsData)) {
            $table = 'voucher."AccommodationDetails"';
            $AccommodationCity = $AccommodationsData['City'];
            if (!empty($AccommodationCity[0])) {
                if (isset($AccommodationCity)) {
                    $where = array("VoucherID" => $UID);
                    $Crud->DeleteRecord('voucher."AccommodationDetails"', $where);
                }
                for ($a = 0; $a < count($AccommodationCity); $a++) {
                    $AccommodationData = array();
                    if ($UID == 0) {
                        $AccommodationData['VoucherID'] = $recordID;
                    } else {
                        $AccommodationData['VoucherID'] = $UID;
                        if (isset($AccommodationsData['AccommodationUID'][$a])) {
                            $AccommodationData['UID'] = $AccommodationsData['AccommodationUID'][$a];
                        }
                    }

                    $AccommodationData['Self'] = $AccommodationsData['Self'][$a];
                    $AccommodationData['City'] = $AccommodationsData['City'][$a];
                    $AccommodationData['Hotel'] = $AccommodationsData['Hotels'][$a];
                    $AccommodationData['RoomType'] = $AccommodationsData['RoomType'][$a];
                    $AccommodationData['CheckIn'] = $AccommodationsData['CheckIn'][$a];
                    $AccommodationData['CheckOut'] = $AccommodationsData['CheckOut'][$a];
                    $AccommodationData['NoOfBeds'] = $AccommodationsData['NoOfBeds'][$a];
                    $AccommodationData['AmountPayable'] = ((isset($AccommodationsData['AmountPayable'][$a])) ? $AccommodationsData['AmountPayable'][$a] : 0);
                    $AccommodationData['AccommodationBRN'] = $AccommodationsData['AccommodationBRN'][$a];

                    $Crud->AddRecord($table, $AccommodationData);
                }
            }

        }*/

        /////Accommodation
        if (isset($AccommodationsData)) {

            $table = 'voucher."AccommodationDetails"';

            /** Delete Voucher Record Start */
            if(isset($_REQUEST['dlt_accomodation']) && count($_REQUEST['dlt_accomodation']) > 0){

                foreach( $_REQUEST['dlt_accomodation'] as $AccodKeys => $AccodValue ){

                    if(isset($AccodValue) &&  $AccodValue == 1){

                        $AccodKeysData = explode("_", $AccodKeys);
                        $AccodWhereArray = array(
                            'VoucherID' => trim($AccodKeysData[0]),
                            'City' => trim($AccodKeysData[1]),
                            'Hotel' => trim($AccodKeysData[2]),
                            'CheckIn' => trim($AccodKeysData[3]),
                            'CheckOut' => trim($AccodKeysData[4])
                        );
                        $Crud->DeleteRecord( $table, $AccodWhereArray );
                    }
                }
            }
            /** Delete Voucher Record Ends */

            $AccommodationCity = ((isset($AccommodationsData['City']) && count($AccommodationsData['City']) > 0) ? $AccommodationsData['City'] : array());
            foreach( $AccommodationCity as $a => $TempCity ){

                $AccommodationRoomType = (isset($AccommodationsData['RoomType'][$a])) ? $AccommodationsData['RoomType'][$a ] : array();
                $AccommodationNoOfBeds = (isset($AccommodationsData['NoOfBeds'][$a]) ? $AccommodationsData['NoOfBeds'][$a] : array());
                $AccommodationAmountPayable = (isset($AccommodationsData['AmountPayable'][$a]) ? $AccommodationsData['AmountPayable'][$a] : array());
                $AccommodationAccomodationId = (isset($AccommodationsData['AccomodationId'][$a]) ? $AccommodationsData['AccomodationId'][$a] : array());

                for ($room = 0; $room < count($AccommodationRoomType); $room++) {
                    $AccommodationData = array();
                    if ($UID == 0) {
                        $AccommodationData['VoucherID'] = $recordID;
                    } else {
                        $AccommodationData['VoucherID'] = $UID;
                    }
                    $AccommodationData['Self'] = $AccommodationsData['Self'][$a];
                    $AccommodationData['City'] = $AccommodationsData['City'][$a];
                    $AccommodationData['Hotel'] = $AccommodationsData['Hotels'][$a];
                    $AccommodationData['CheckIn'] = $AccommodationsData['CheckIn'][$a];
                    $AccommodationData['CheckOut'] = $AccommodationsData['CheckOut'][$a];
                    $AccommodationData['AccommodationBRN'] = ( ( isset($AccommodationsData['AccommodationBRN'][$a]) && $AccommodationsData['AccommodationBRN'][$a] != '' )? $AccommodationsData['AccommodationBRN'][$a] : 0 );
                    $AccommodationData['RoomType'] = $AccommodationRoomType[$room];
                    $AccommodationData['NoOfBeds'] = $AccommodationNoOfBeds[$room];
                    $AccommodationData['AmountPayable'] = ( ( isset($AccommodationAmountPayable[$room]) && $AccommodationAmountPayable[$room] != '' )? $AccommodationAmountPayable[$room] : 0 );

                    //$Crud->AddRecord($table, $AccommodationData);
                    if (isset($AccommodationAccomodationId[$room]) && $AccommodationAccomodationId[$room] != '' && $AccommodationAccomodationId[$room] > 0) {
                        $Crud->UpdateRecord($table, $AccommodationData, ["UID" => $AccommodationAccomodationId[$room]]);
                    } else {
                        $Crud->AddRecord($table, $AccommodationData);
                    }
                }
            }

            /*for ($a = 0; $a < count($AccommodationCity); $a++) {

                $AccommodationRoomType = (isset($AccommodationsData['RoomType'][$a + 1])) ? $AccommodationsData['RoomType'][$a + 1] : array();
                $AccommodationNoOfBeds = (isset($AccommodationsData['NoOfBeds'][$a + 1]) ? $AccommodationsData['NoOfBeds'][$a + 1] : array());
                $AccommodationAmountPayable = (isset($AccommodationsData['AmountPayable'][$a + 1]) ? $AccommodationsData['AmountPayable'][$a + 1] : array());
                $AccommodationAccomodationId = (isset($AccommodationsData['AccomodationId'][$a + 1]) ? $AccommodationsData['AccomodationId'][$a + 1] : array());

//                foreach($AccommodationData1['RoomType'] as $RoomType){
//                     $AccommodationsData['RoomType']=$RoomType;
//                }
                for ($room = 0; $room < count($AccommodationRoomType); $room++) {
                    $AccommodationData = array();
                    if ($UID == 0) {
                        $AccommodationData['VoucherID'] = $recordID;
                    } else {
                        $AccommodationData['VoucherID'] = $UID;
                    }
                    $AccommodationData['Self'] = $AccommodationsData['Self'][$a];
                    $AccommodationData['City'] = $AccommodationsData['City'][$a];
                    $AccommodationData['Hotel'] = $AccommodationsData['Hotels'][$a];
                    $AccommodationData['CheckIn'] = $AccommodationsData['CheckIn'][$a];
                    $AccommodationData['CheckOut'] = $AccommodationsData['CheckOut'][$a];
                    $AccommodationData['AccommodationBRN'] = $AccommodationsData['AccommodationBRN'][$a];
                    $AccommodationData['RoomType'] = $AccommodationRoomType[$room];
                    $AccommodationData['NoOfBeds'] = $AccommodationNoOfBeds[$room];
                    $AccommodationData['AmountPayable'] = $AccommodationAmountPayable[$room];

                    // $AccommodationData['AccomodationId'] = $AccommodationAccomodationId[$room];
                    if ($AccommodationAccomodationId[$room] > 0) {
                        $Crud->UpdateRecord($table, $AccommodationData, ["UID" => $AccommodationAccomodationId[$room]]);

                    } else {
                        $Crud->AddRecord($table, $AccommodationData);
                    }
                    //////////////// insert query
                    //echo '<pre>';print_r($AccommodationData);

                }
            }*/
        }

        if (isset($Transports)) {
            $table = 'voucher."TransportRate"';
            $where = array("VoucherUID" => $UID);
            $Crud->DeleteRecord($table, $where);
            $TransportSectors = $Transports['TransportSectors'];
            //echo '<pre>';print_r($Transports);exit();
            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TransportData = array();
                    if ($UID == 0) {
                        $TransportData['VoucherUID'] = $recordID;
                    } else {
                        $TransportData['VoucherUID'] = $UID;
                        if (isset($Transports['TransportUID'][$a])) {
                            $TransportData['UID'] = $Transports['TransportUID'][$a];
                        }
                    }
                    $TransportData['SelfTransport'] = $Transports['SelfTransport'][$a];
                    $TransportData['TravelDate'] = $Transports['TravelDate'][$a];
                    $TransportData['TravelCity'] = $Transports['TravelCity'][$a];
                    $TransportData['TravelType'] = $Transports['TravelType'][$a];
                    $TransportData['TransportTypeUID'] = $Transports['TransportType'][$a];
                    $TransportData['Rate'] = ((isset($Transports['TransportRates'][$a])) ? $Transports['TransportRates'][$a] : 0); //$Transports['TransportRates'][$a];
                    $TransportData['Sectors'] = $Transports['TransportSectors'][$a];
                    $TransportData['TransportsBRN'] = $Transports['TransportsBRN'][$a];
                    $TransportData['NoOfPax'] = $Transports['NoOfPax'][$a];
                    $TransportData['NoOfSeats'] = $Transports['NoOfSeats'][$a];

                    $Crud->AddRecord($table, $TransportData);
                }
            }
        }
        if (isset($Ziyarats)) {
            $table = 'voucher."ZiyaratsRate"';
            $where = array("VoucherUID" => $UID);
            $Crud->DeleteRecord('voucher."ZiyaratsRate"', $where);
            $ZiyaratCity = $Ziyarats['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    if ($UID == 0) {
                        $ZiyaratData['VoucherUID'] = $recordID;
                    } else {
                        $ZiyaratData['VoucherUID'] = $UID;
                    }
                    $ZiyaratData['ZiyaratCity'] = $Ziyarats['ZiyaratCity'][$a];
                    $ZiyaratData['TransportTypeUID'] = $Ziyarats['TransportRateZiyrat'][$a];
                    $ZiyaratData['ZiyaratsUID'] = $Ziyarats['Ziyarat'][$a];
                    $ZiyaratData['Rate'] = $Ziyarats['ZiyaratTransportsRates'][$a];
                    $ZiyaratData['ZiyaratNoOfPax'] = $Ziyarats['ZiyaratNoOfPax'][$a];
                    $Crud->AddRecord($table, $ZiyaratData);
                }
            }
        }


        /////Voucher Activity
        if (!empty($Voucher_Activity_arr)) {
            $Remarkstable = 'voucher."Remarks"';
            $Crud->AddBulkRecord($Remarkstable, $Voucher_Activity_arr);
            $VoucherStatus = array(
                'CurrentStatus' => 'Pending',

            );
            $table = 'voucher."Master"';
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $VoucherStatus, $where);

        }

        /** Voucher Visa Rates Segment Start */
        $VoucherID = 0;
        if ($UID == 0) {
            $VoucherID = $recordID;
        } else {
            $VoucherID = $UID;
        }
        if (isset($records['Visa']) && $records['Visa'] == 'Yes') {
            $this->AddVoucherVisaRate($records['WebsiteDomain'], $VoucherID, $Record['AgentPackageID'], $Record['SubmittedPackageID']);
        } else {
            $Crud->DeleteRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID));
        }
        /** Voucher Visa Rates Segment End */

        $CroneModel->UpdateCronActivity('allow_bed');
        $CroneModel->UpdateCronActivity('AllowTPTDeparture');
        $CroneModel->UpdateCronActivity('AllowTPTJeddah');
        $CroneModel->UpdateCronActivity('AllowHTLJeddahArrival');
        $CroneModel->UpdateCronActivity('AllowTPTMedina');
        $CroneModel->UpdateCronActivity('AllowHTLMeccaArrival');
        $CroneModel->UpdateCronActivity('AllowHTLMedinaArrival');
        $CroneModel->UpdateCronActivity('AllowTPTMeccaArrival');
        $CroneModel->UpdateCronActivity('AllowTPTArrival');
        $CroneModel->UpdateCronActivity('VoucherNotIssued');
        $CroneModel->UpdateCronActivity('VoucherIssued');
        $CroneModel->UpdateCronActivity('completed_allow_bed');
        echo json_encode($response);
    }

    public function VoucherFormSummary($records, $Rec, $UID, $PilgrimsID, $FlightsData, $AccommodationsData, $Transports, $Ziyarats, $ServicesID, $remarks, $Record)
    {
        //echo'<pre>';print_r($PilgrimsID);exit;
        // echo'<pre>';print_r($AccommodationsData);exit;
        //echo 'aaaa'.session()->get('id')."----".$data['session']['id'];exit();
        $data = $this->data;
        $CroneModel = new CronModel();

        $Crud = new Crud();

        $voucherRecord = array();
        $voucherRecord['VoucherData'] = $records;
        $voucherRecord['pilgrims'] = implode(',', $PilgrimsID['VoucherPilgrimID']);
        $voucherRecord['FlightsData'] = $FlightsData;
        $voucherRecord['AccommodationsData'] = $AccommodationsData;
        $voucherRecord['Transports'] = $Transports;
        $voucherRecord['Ziyarats'] = $Ziyarats;
        $voucherRecord['ServicesIDs'] = (isset($ServicesID['VoucherServicesID']) && count($ServicesID['VoucherServicesID']) > 0) ? implode(',', $ServicesID['VoucherServicesID']) : '';


        echo $html = view("group/view_voucher_summary", $voucherRecord);
    }

    public function VoucherStatusFormSubmit($RecordID, $VoucherStatus, $Voucher_Activity_arr, $RefundType)
    {
        $Crud = new Crud();
        /////Voucher Activity
        if (!empty($Voucher_Activity_arr)) {
            $Remarkstable = 'voucher."Remarks"';
            $Crud->AddBulkRecord($Remarkstable, $Voucher_Activity_arr);
        }
        $Voucher_Status = array(
            'CurrentStatus' => $VoucherStatus,
            'ModifiedBy' => session()->get('id'),
            'ModifiedDate' => date('Y-m-d H:i:s'),
        );
        $table = 'voucher."Master"';
        $where = array("UID" => $RecordID);
        $Crud->UpdateRecord($table, $Voucher_Status, $where);

        $Metas = $RefundType['RefundTypes'];
        if (isset($Metas)) {
            $where = array("VoucherID" => $RecordID);
            $Crud->DeleteRecord('voucher."RefundMeta"', $where);
            foreach ($Metas as $value) {
                $recrd = array();
                $recrd['VoucherID'] = $RecordID;
                $recrd['Option'] = 'RefundType';
                $recrd['Value'] = $value;
                $Crud->AddRecord('voucher."RefundMeta"', $recrd);
            }
        }

    }

    public
    function RefundVoucherService($UID, $ServiceRefundReason)
    {

        $Crud = new Crud();
        $table = 'voucher."Services"';
        $record['Refund'] = "1";
        $record['RefundReason'] = $ServiceRefundReason;
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function RefundVoucherZiyarats($UID, $ZiyaratRefundReason)
    {

        $Crud = new Crud();
        $table = 'voucher."ZiyaratsRate"';
        $record['Refund'] = "1";
        $record['RefundReason'] = $ZiyaratRefundReason;
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function RefundVoucherAccomodations($UID, $HotelRefundReason)
    {

        $Crud = new Crud();
        $table = 'voucher."AccommodationDetails"';
        $record['Refund'] = "1";
        $record['RefundReason'] = $HotelRefundReason;
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function RefundVoucherTransport($UID, $TransportRefundReason)
    {

        $Crud = new Crud();
        $table = 'voucher."TransportRate"';
        $record['Refund'] = "1";
        $record['RefundReason'] = $TransportRefundReason;
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public function VoucherRemarksFormSubmit($RecordID, $VoucherStatus)
    {
        $response = array();
        $session = session();
        $session = $session->get();

        $Crud = new Crud();
        $Voucher_remarks = array(
            'PilgrimUID' => $RecordID,
            'Option' => 'WithoutVoucherArrivalRemarks',
            'Value' => $VoucherStatus,
            'CreatedBy' => $session['id'],
        );


        $table = 'pilgrim."meta"';
        $where = array("PilgrimUID" => $RecordID, "Option" => 'WithoutVoucherArrivalRemarks');
        $Crud->DeleteRecord($table, $where);

        if ($Crud->AddRecord($table, $Voucher_remarks)) {
            $response['status'] = "success";
            $response['message'] = "Remarks Successfully Added...";
        } else {
            $response['status'] = "fail";
            $response['message'] = "Data Didn't Submitted Successfully...";
        }
        echo json_encode($response);
    }


    public function RefundVoucherRemarksFormSubmit($records)
    {
        $response = array();
        $Crud = new Crud();
        $session = session();
        $ActivityTable = '';
        $session = $session->get();

        $table = 'voucher."RefundMeta"';
        if ($records['Type'] == 'accommodation') {
            $ActivityTable = 'voucher."AccommodationDetails"';
        } else {
            $ActivityTable = 'voucher."TransportRate"';

        }
        $Voucher = $Crud->SingleRecord($ActivityTable, array("UID" => $records['ActivityID']));
        $VoucherID = $Voucher['VoucherID'];

        if ($Crud->AddRecord($table, $records)) {
            $Crud->UpdateRecord('voucher."Master"', array("CurrentStatus" => 'Pending'), array("UID" => $VoucherID));
            $Crud->UpdateRecord($ActivityTable, array("Refund" => 1), array("UID" => $records['ActivityID']));
            $response['status'] = "success";
            $response['message'] = "Refund Successfully Added...";
        } else {
            $response['status'] = "fail";
            $response['message'] = "Data Didn't Submitted Successfully...";
        }
        echo json_encode($response);
    }

    public
    function VoucherPilgrimList($VID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT "PilgrimUID" FROM "voucher"."Pilgrim" WHERE "Pilgrim"."VoucherUID" = ' . $VID . ' ';

        $records = $Crud->ExecuteSQL($SQL);
        $final = array();
        foreach ($records as $record) {
            $final[] = $record;
        }
        // print_r($final); exit;
        return $final;
    }

    public
    function VoucherPilgrimListByAgentID($ID, $VID = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."master".*, pilgrim."visa".*  FROM pilgrim."master"
        LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
        WHERE pilgrim."master"."AgentUID" = ' . $ID . ' AND 
        pilgrim."master"."UID"  IN ( 
            SELECT DISTINCT "meta"."PilgrimUID" FROM "pilgrim"."meta"
            WHERE "meta"."Option" = \'mofa-issued-status\'
        )';

        if ($VID == 0) {
            $SQL .= ' AND pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")';
        } else {
            $SQL .= ' AND pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim" WHERE voucher."Pilgrim"."VoucherUID" != \'' . $VID . '\' )';
        }
        // echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;
    }

    public
    function PilgrimWithoutVoucherList()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'SELECT pilgrim."master".*, pilgrim."visa".*  FROM pilgrim."master"
        LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
        WHERE 
         pilgrim."master"."UID" NOT IN ( 
            SELECT DISTINCT "meta"."PilgrimUID" FROM "pilgrim"."meta"
            WHERE "meta"."Option" = \'mofa-issued-status\'
        )';

        // echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;
    }

    public
    function VoucherListPilgrim($VID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT "PilgrimUID",pilgrim."master".* FROM "voucher"."Pilgrim" 
            LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID" 
            WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' ORDER BY pilgrim."master"."FirstName" ASC  ';

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function VoucherListPilgrimForStatus($VID, $status)
    {
        $data = $this->data;
        $Crud = new Crud();
        //echo $status;exit;
        $ReadyForExit = array('departure-jeddah', 'departure-medina', 'departure-mecca');
        if (in_array($status, $ReadyForExit)) {
            $key = 'ForExit';
        }
        $ReadyForArrival = array('jeddah-arrival', 'medina-arrival', 'yanbu-arrival', 'sea-arrival', 'by-road-arrival');
        if (in_array($status, $ReadyForArrival)) {
            $key = 'ForArrival';
        }
        $ArrivalDepended = array('check-in-mecca', 'departure-jeddah', 'departure-mecca', 'departure-medina');
        if (in_array($status, $ArrivalDepended)) {
            $key = 'Arrival';
        }
//        $AllowStatus = array("allow-tpt-arrival", "allow-htl-medina", "allow-htl-jeddah");
//        if (in_array($status, $AllowStatus)) {
//            $key = 'Allow';
//        }
        if ($status == 'check-in-medina') {
            $key = 'ForArrivalMedina';
        }
        if ($status == 'check-in-jeddah') {
            $key = 'ForArrivalJeddah';
        }
        if ($status == 'check-in-mecca') {
            $key = 'ForArrivalMecca';
        }

        if (in_array($status, array('departure-mecca', 'check-out-mecca'))) {
            $key = 'CheckInMecca';
        }
        if (in_array($status, array('departure-jeddah', 'check-out-jeddah'))) {
            $key = 'CheckInJeddah';
        }

        if (in_array($status, array('departure-medina', 'check-out-medina'))) {
            $key = 'CheckInMedina';
        }

        $StatusCheckList = StatusCheckList();
        $PilgrimMeta = array();
        if (isset($StatusCheckList[$key])) {
            foreach ($StatusCheckList[$key] as $PilgrimCnt) {
                $PilgrimMeta[] = $PilgrimCnt . "-status";
            }
        }


        $SQL = '
        SELECT DISTINCT voucher."Pilgrim"."PilgrimUID",voucher."Pilgrim"."Leader",pilgrim."master".*,
            (SELECT "MetaB"."Value" FROM "pilgrim"."meta" as "MetaB"  WHERE "MetaB"."Option" NOT LIKE \'%driver-contact-number%\'     AND "MetaB"."Option" LIKE \'%contact-number%\'  AND "MetaB"."PilgrimUID" = pilgrim."master"."UID"    ORDER BY "MetaB"."SystemDate" DESC  LIMIT 1) AS "ContactNUmber" 
         FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID" 
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
        WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID;

        if (count($PilgrimMeta) > 0) {
            $SQL .= ' AND  pilgrim."meta"."Option" IN (\'' . implode("','", $PilgrimMeta) . '\') ';
        }
        if (in_array($status, $ReadyForExit)) {
            $ReadyForExitStatusFinal = array();
            foreach ($ReadyForExit as $ReadyForExitStatus) {
                $ReadyForExitStatusFinal[] = $ReadyForExitStatus . "-status";
            }
            $SQL .= ' AND  pilgrim."master"."UID" NOT IN ( 
                SELECT DISTINCT voucher."Pilgrim"."PilgrimUID"
                FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID" 
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND 
                pilgrim."meta"."Option" IN (\'' . implode("','", $ReadyForExitStatusFinal) . '\')
            ) ';
        }
        if (in_array($status, $ReadyForArrival)) {
            $ReadyForArrivalStatusFinal = array();
            foreach ($ReadyForArrival as $ReadyForArrivalStatus) {
                $ReadyForArrivalStatusFinal[] = $ReadyForArrivalStatus . "-status";
            }
            $SQL .= ' AND  pilgrim."master"."UID" NOT IN ( 
                SELECT DISTINCT voucher."Pilgrim"."PilgrimUID"
                FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID" 
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND 
                pilgrim."meta"."Option" IN (\'' . implode("','", $ReadyForArrivalStatusFinal) . '\')
            ) ';
        }
//        $SQL .= 'ORDER BY pilgrim."master"."FirstName" ASC  ';
        $SQL .= ' ORDER BY "ContactNUmber" ASC ';

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function VoucherListPilgrimStatus($VID, $status)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID"),pilgrim."master".* FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
        WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" LIKE \'%' . $status . '%\' ';

        $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;
        return $records;
    }

    public
    function GetPilgrimAllowList($Option, $reference_id)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT distinct pilgrim."meta"."PilgrimUID" FROM "pilgrim"."meta" 
             WHERE pilgrim."meta"."Option" = \'' . $Option . '\' AND pilgrim."meta"."AllowReference" =  ' . $reference_id;

        $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;

        $final = array();
        foreach ($records as $record) {
            $final[] = $record['PilgrimUID'];
        }

        return $final;
    }

    public
    function VoucherListPilgrimWithoutStatus($VID)
    {
        $data = $this->data;
        $Crud = new Crud();

//        $SQL = '
//        SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID"),pilgrim."master".*,
//        (
//            SELECT "MetaB"."Value" FROM "pilgrim"."meta" as "MetaB"
//            WHERE "MetaB"."Option" NOT LIKE \'%driver-contact-number%\'
//            AND "MetaB"."Option" LIKE \'%contact-number%\'  AND "MetaB"."PilgrimUID" = pilgrim."master"."UID"
//            ORDER BY "MetaB"."SystemDate" DESC  LIMIT 1
//        ) AS "ContactNUmber"
//        FROM "voucher"."Pilgrim"
//        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
//        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
//        WHERE pilgrim."master"."UID" IS NOT NULL AND voucher."Pilgrim"."VoucherUID" = ' . $VID . ' ORDER BY "ContactNUmber"  ';

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID"), pilgrim."master".*,
                voucher."Pilgrim"."Leader",pilgrim."meta"."Value" AS "Contact_Number" ,
                CAST(
                        (
                            CASE 
                                WHEN pilgrim."master"."DOBInYears" IS NULL AND pilgrim."master"."DOB" IS NOT NULL THEN date_part(\'year\', Age(CAST(pilgrim."master"."DOB" AS TIMESTAMP)))
                                WHEN pilgrim."master"."DOBInYears" IS NULL AND pilgrim."master"."DOB" IS NULL THEN 0
                                ELSE pilgrim."master"."DOBInYears"
                            END
                        )
                AS INTEGER ) AS "PilgrimAgeYears"
        FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID" 
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" AND pilgrim."meta"."Option" NOT LIKE \'%driver-contact-number%\'
        AND pilgrim."meta"."Option" LIKE \'%contact-number%\'
        WHERE pilgrim."master"."UID" IS NOT NULL AND voucher."Pilgrim"."VoucherUID" = ' . $VID . ' 
        ORDER BY pilgrim."meta"."Value"  ';
        $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;exit;
        return $records;
    }

    public
    function VoucherListPilgrimStatusActual($VID, $status, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID"),pilgrim."master".* FROM "voucher"."Pilgrim" 
            LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
            LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
            WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" LIKE \'%' . $status . '%\' AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';

        $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;
        return $records;
    }

    public
    function VoucherDataDetails($reference_id)
    {

        $Crud = new Crud();
        $table = 'voucher."AccommodationDetails"';
        $where = array("UID" => $reference_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

//        $data = $this->data;
//        $Crud = new Crud();
//
//        $SQL = 'SELECT voucher."AccommodationDetails".* FROM voucher."AccommodationDetails"  WHERE voucher."AccommodationDetails"."UID" = '.$reference_id.' ';
//
//        $records = $Crud->ExecuteSQL($SQL);
//        //echo $SQL;
//        return $records;
    }


    public
    function AllowVoucherListPilgrimStatus($VID, $status, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID"),pilgrim."master".* FROM "voucher"."Pilgrim" 
            LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
            LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
           WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" = \'' . $status . '-status\' AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';


        $records = $Crud->ExecuteSQL($SQL);
        // echo $SQL;
        return $records;
    }

    public
    function VoucherTransportType($VID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."TransportRate"."TransportTypeUID") FROM "voucher"."TransportRate" WHERE voucher."TransportRate"."VoucherUID" = ' . $VID . ' ';

        $records = $Crud->ExecuteSQL($SQL);
        // echo $SQL;
        return $records;


    }

    public
    function CountAllowHotelVoucherListPilgrimStatus($VID, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
            LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
            LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
           WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" LIKE \'%allow-htl%\' 
           AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-mecca-contact-number%\' 
           AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-medina-contact-number%\' 
           AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-jeddah-contact-number%\'
           AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';


        $records = $Crud->ExecuteSQL($SQL);
        // echo $SQL;
        return $records;
    }

    public
    function CountActualHotelVoucherListPilgrimStatus($VID, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
        WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" LIKE \'%check-in%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%check-in-mecca-contact-number%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%check-in-medina-contact-number%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%check-in-jeddah-contact-number%\'
        AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';


        $records = $Crud->ExecuteSQL($SQL);
        // echo $SQL;
        return $records;
    }

    public
    function CountAllowTransportVoucherListPilgrimStatus($VID, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
        WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND pilgrim."meta"."Option" LIKE \'%allow-tpt%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-mecca-contact-number%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-medina-contact-number%\' 
        AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-jeddah-contact-number%\'
        AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';

        $records = $Crud->ExecuteSQL($SQL);
        // echo $SQL;
        return $records;
    }

    public
    function CountActualTransportVoucherListPilgrimStatus($VID, $reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT DISTINCT(voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
        LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
        WHERE voucher."Pilgrim"."VoucherUID" = ' . $VID . ' AND (pilgrim."meta"."Option" LIKE \'%check-out%\' 
        OR pilgrim."meta"."Option" LIKE \'%arrival%\'  OR pilgrim."meta"."Option" LIKE \'%departure%\')
        AND pilgrim."meta"."Option" NOT LIKE \'%contact-number%\' 
        AND pilgrim."meta"."AllowReference" = ' . $reference_id . ' ';


        $records = $Crud->ExecuteSQL($SQL);
        //  echo $SQL;
        return $records;
    }

    public
    function GetPackageHotel($VID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT "packages"."Hotels"."Name" as "HotelName","main"."LookupsOptions"."Name" as "HotelCategoryName", "packages"."Hotels"."UID" as "HotelUID"
                FROM "voucher"."Master"
                LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID" = "voucher"."Master"."UID"
                 LEFT JOIN packages."Hotels" ON CAST("voucher"."AccommodationDetails"."Hotel" as bigint) = "packages"."Hotels"."UID"
                 LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID" =  CAST("packages"."Hotels"."Category" as bigint)   
            WHERE  "packages"."Hotels"."UID" IS NOT NULL AND voucher."Master"."UID" = ' . $VID . '  ';

        //  echo $SQL;
        //  exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function PilgrimListData($ID)
    {
        $Crud = new Crud();
        $table = 'pilgrim."master"';
        $where = array("UID" => $ID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function Voucherlog($ID)
    {
        $Crud = new Crud();
        /*  $table = 'voucher."Remarks"';
          $where = array("VoucherID" => $ID);
          $order = array("UID" => "DESC");
          $records = $Crud->ListRecords($table, $where,$order);
          return $records;*/
        $SQL = 'SELECT voucher."Remarks".*, main."Users"."FullName" FROM "voucher"."Remarks"
        LEFT JOIN main."Users" ON main."Users"."UID"  = voucher."Remarks"."CreatedBy" 
        WHERE "voucher"."Remarks"."VoucherID" IN ( \'' . $ID . '\' )
        ORDER BY voucher."Remarks"."UID" DESC';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function VoucherRemarksMeta($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."meta".* FROM  pilgrim."meta"  WHERE "pilgrim"."meta"."PilgrimUID" = ' . $ID . ' AND  "pilgrim"."meta"."Option" = \'WithoutVoucherArrivalRemarks\' ';

        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function PilgrimData($ID)
    {
        $Crud = new Crud();
        $table = 'voucher."Pilgrim"';
        $where = array("VoucherUID" => $ID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function PilgrimsList($ID)
    {
        $Crud = new Crud();
        $table = 'pilgrim."master"';
        $where = array("UID" => $ID);
        $records = $Crud->SingleRecord($table, $where, array("FirstName" => "ASC"));
        return $records;

    }


    public
    function VoucherPilgrimData($VID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."master".*, pilgrim."visa".* FROM "pilgrim"."master"
        LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
        WHERE "pilgrim"."master"."UID" IN ( SELECT "voucher"."Pilgrim"."PilgrimUID" FROM "voucher"."Pilgrim" WHERE "voucher"."Pilgrim"."VoucherUID" = \'' . $VID . '\' )
        ORDER BY pilgrim."master"."FirstName" ';

        $records = $Crud->ExecuteSQL($SQL);
        $final = array();
        foreach ($records as $record) {
            $final[] = $record;
        }
        // print_r($final); exit;
        return $final;
    }


    public
    function VoucherAgentsData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("UID" => $ID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function LoadPackageIDByAgent($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Packages"';
        $where = array("AgentUID" => $ID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function ExtraGridDataByPackageID($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."ServiceRate"';
        $where = array("PackageUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function GetVoucherFlightDataByType($ID, $FlightType)
    {
        $Crud = new Crud();
        $table = 'voucher."Flights"';
        $where = array("VoucherID" => $ID, "FlightType" => $FlightType);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function VoucherFlightsData($ID)
    {

//        $data = $this->data;
//        $Crud = new Crud();
//
//        $SQL = 'SELECT voucher."Flights".*, main."Airlines"."FullName" As "AirlineName"
//        FROM voucher."Flights"
//        LEFT JOIN main."Airlines" ON main."Airlines"."UID"  = voucher."Flights"."Airline"
//        WHERE voucher."Flights"."VoucherID" = ' . $ID . ' ';
//
//        $records = $Crud->ExecuteSQL($SQL);
//       // echo $SQL;
//        return $records;


        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."Flights"';
        $where = array("VoucherID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function VoucherAccommodationDetails($ID)
    {


        $data = $this->data;
        $Crud = new Crud();
        //$table = 'voucher."AccommodationDetails"';
        // = array("VoucherID" => $ID);
        //$records = $Crud->ListRecords($table, $where);
        $SQL = 'SELECT 
                voucher."AccommodationDetails"."VoucherID",
                voucher."AccommodationDetails"."City",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."CheckIn",
                voucher."AccommodationDetails"."CheckOut",
                voucher."AccommodationDetails"."AccommodationBRN",
                voucher."AccommodationDetails"."Self" 
                FROM "voucher"."AccommodationDetails"
                WHERE "voucher"."AccommodationDetails"."VoucherID" =' . $ID . ' ';
        $SQL .= 'Group By 
                voucher."AccommodationDetails"."VoucherID",
                voucher."AccommodationDetails"."City",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."CheckIn",
                voucher."AccommodationDetails"."CheckOut",
                voucher."AccommodationDetails"."AccommodationBRN",
                voucher."AccommodationDetails"."Self"
                Order By voucher."AccommodationDetails"."CheckIn" ASC
                ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherAccommodationRoomTypeDetails($ID, $City, $Hotel, $CheckIn, $CheckOut, $AccommodationBRN)
    {


        $data = $this->data;
        $Crud = new Crud();
        //$table = 'voucher."AccommodationDetails"';
        // = array("VoucherID" => $ID);
        //$records = $Crud->ListRecords($table, $where);
        $SQL = 'SELECT 
                voucher."AccommodationDetails".*
               
                FROM "voucher"."AccommodationDetails"
                WHERE "voucher"."AccommodationDetails"."VoucherID" =' . $ID . ' 
                AND "voucher"."AccommodationDetails"."City" =\'' . $City . '\'
                AND "voucher"."AccommodationDetails"."Hotel" =\'' . $Hotel . '\'
                AND "voucher"."AccommodationDetails"."CheckIn" = \'' . $CheckIn . '\'
                AND "voucher"."AccommodationDetails"."CheckOut" =\'' . $CheckOut . '\'
                AND "voucher"."AccommodationDetails"."AccommodationBRN" =\'' . $AccommodationBRN . '\'
                ';

        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherTransportDetails($ID)
    {


        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."TransportRate"';
        $where = array("VoucherUID" => $ID);
        $order = array("TravelDate" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);
        return $records;
    }

    public
    function VoucherZiyaratDetails($ID)
    {


        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."ZiyaratsRate"';
        $where = array("VoucherUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }


    public
    function DeleteTravelRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'voucher."Flights"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteTransportRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'voucher."TransportRate"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteAccomodationRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'voucher."AccommodationDetails"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteTransportRateRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'voucher."TransportRate"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteZiyaratRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'voucher."ZiyaratsRate"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function VoucherAccommmodationData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."AccommodationDetails"';
        $where = array("VoucherID" => $ID);
        $records = $Crud->ListRecords($table, $where, array('CheckIn' => 'ASC'));
        return $records;
    }

    public
    function VoucherTransportData($ID)
    {

        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."TransportRate"';
        $where = array("VoucherUID" => $ID);
        $SQL = '
        SELECT
        voucher."TransportRate".*,
        main."LookupsOptions"."Name" AS "SectorName",
        ( SELECT main."LookupsOptions"."Name" FROM packages."Transport"
          INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" AS INTEGER) = main."LookupsOptions"."UID")
          WHERE packages."Transport"."UID" = CAST(voucher."TransportRate"."TransportTypeUID" AS INTEGER)
        ) AS "TransportTypeName"
        FROM voucher."TransportRate"
        INNER JOIN main."LookupsOptions" ON (voucher."TransportRate"."Sectors" = main."LookupsOptions"."UID")
        WHERE voucher."TransportRate"."VoucherUID" = ' . $ID . '  ORDER BY voucher."TransportRate"."TravelDate" ASC   ';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherZiyaratData($ID)
    {

        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."ZiyaratsRate"';
        $where = array("VoucherUID" => $ID);
        $SQL = '
        SELECT 
        voucher."ZiyaratsRate".*,
        main."Cities"."Name" as "CityName",
        packages."Ziyarats"."Name" as "ZiyaratName",
        main."LookupsOptions"."Name" as "TransportName",
        main."Cities"."CountryCode"
        FROM voucher."ZiyaratsRate"
        INNER JOIN main."Cities" ON (CAST(voucher."ZiyaratsRate"."ZiyaratCity" as INTEGER) = main."Cities"."UID")
        INNER JOIN packages."Ziyarats" ON (voucher."ZiyaratsRate"."ZiyaratsUID" = packages."Ziyarats"."UID")
        INNER JOIN packages."Transport" ON (CAST(voucher."ZiyaratsRate"."TransportTypeUID" as INTEGER) = packages."Transport"."UID")
        INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" as INTEGER) = main."LookupsOptions"."UID")
        WHERE voucher."ZiyaratsRate"."VoucherUID" = ' . $ID;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherServicesDatas($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."Services"';
        $where = array("VoucherUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }


    public
    function VoucherSettingsData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'websites."Settings"';
        $where = array("DomainID" => $ID, "Key" => 'terms_and_conditions');
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function VouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."ParentID" as "AgentParentID"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE voucher."Master"."UpdationCounter" = 0 
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function AllB2CVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 AND voucher."Master"."VoucherType"  LIKE \'%B2C%\'  ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  voucher."Master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        } else if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }


        //  echo nl2br($SQL);exit();

        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function VouchersAllList()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."ParentID" as "AgentParentID"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE  voucher."Master"."WebsiteDomain" = ' . $session['domainid'] . ' 
                ';


        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function VouchersForPilgrimsActivity()
    {
        $session = session();
        $session = $session->get();

        $PilgrimActivitiesSearchFilter = $session['PilgrimActivitiesSearchFilter'];

        $Crud = new Crud();
        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."ParentID" as "AgentParentID",count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax"
                FROM voucher."Master"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                WHERE voucher."Master"."CurrentStatus"  != \'Pending\'
                
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($PilgrimActivitiesSearchFilter['VoucherCountry']) && $PilgrimActivitiesSearchFilter['VoucherCountry'] > 0) {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $PilgrimActivitiesSearchFilter['VoucherCountry'] . '\' ';
        }
        if (isset($PilgrimActivitiesSearchFilter['AgentID']) && $PilgrimActivitiesSearchFilter['AgentID'] > 0) {
            $SQL .= ' AND voucher."Master"."AgentUID" = \'' . $PilgrimActivitiesSearchFilter['AgentID'] . '\' ';
        }
        if (isset($PilgrimActivitiesSearchFilter['VoucherDate']) && $PilgrimActivitiesSearchFilter['VoucherDate'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" = \'' . $PilgrimActivitiesSearchFilter['VoucherDate'] . '\' ';
        }
        $SQL .= ' GROUP BY voucher."Master"."UID",main."Agents"."UID"';
        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherServicesList($ID)
    {
        $session = session();
        $session = $session->get();


        $Crud = new Crud();
        $SQL = 'SELECT voucher."Services".*,main."LookupsOptions"."Name" as "ServiceName" FROM voucher."Services"
                LEFT JOIN packages."ServiceRate" ON packages."ServiceRate"."UID" = cast(voucher."Services"."ServiceID" AS INT )
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID" = packages."ServiceRate"."ServiceUID"
                WHERE voucher."Services"."VoucherUID"  = ' . $ID . '  
                 ';
//
//        if ($session['domainid'] > 0) {
//            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
//
//        }

        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherZiyaratsList($ID)
    {
        $session = session();
        $session = $session->get();


        $Crud = new Crud();
        $SQL = 'SELECT voucher."ZiyaratsRate".*, packages."Ziyarats"."Name" as "ZiyaratName"
                FROM voucher."ZiyaratsRate"
                LEFT JOIN packages."Ziyarats" ON packages."Ziyarats"."UID" = voucher."ZiyaratsRate"."ZiyaratsUID"
                WHERE voucher."ZiyaratsRate"."VoucherUID"  = ' . $ID . ' 
                
                ';

//        if ($session['domainid'] > 0) {
//            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
//
//        }

        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherAccommodationList($ID)
    {
        $session = session();
        $session = $session->get();


        $Crud = new Crud();
        $SQL = 'SELECT voucher."AccommodationDetails".*, packages."Hotels"."Name" as "HotelName"
                FROM voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID" = (cast(voucher."AccommodationDetails"."Hotel" as int))
                WHERE voucher."AccommodationDetails"."VoucherID"  = ' . $ID . ' 
                
                ';

//        if ($session['domainid'] > 0) {
//            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
//
//        }

        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VoucherTransportList($ID)
    {
        $session = session();
        $session = $session->get();


        $Crud = new Crud();
        $SQL = 'SELECT voucher."TransportRate".*
                FROM voucher."TransportRate"
                /*LEFT JOIN packages."TransportRate" ON packages."TransportRate"."TransportTypeUID" = voucher."ZiyaratsRate"."TransportTypeUID"*/
                WHERE voucher."TransportRate"."VoucherUID"  = ' . $ID . ' 
                
                ';

//        if ($session['domainid'] > 0) {
//            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
//
//        }

        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VouchersForPilgrimsAllowHotelActivityByID($ID)
    {
        $session = session();
        $session = $session->get();

        $Crud = new Crud();
        $SQL = 'SELECT voucher."AccommodationDetails".*, main."Agents"."FullName" as "AgentName", voucher."Master"."UID" as "VoucherID",
                voucher."Master"."VoucherCode" as "VoucherCode",voucher."Master"."ArrivalDate" as "ArrivalDate",packages."Hotels"."Name" as "HotelName",
                voucher."Master"."Country" as "Country",voucher."Master"."ReturnDate" as "ReturnDate", main."Agents"."ParentID" as "AgentParentID",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax"
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."P ilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                WHERE voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."UID"  = ' . $ID . ' 
                /*AND voucher."AccommodationDetails"."Self" = 0 */ ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        $SQL .= 'GROUP BY voucher."AccommodationDetails"."UID",voucher."Master"."VoucherCode",voucher."AccommodationDetails"."Self",voucher."Master"."UID",packages."Hotels"."Name",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate" 
                ORDER BY voucher."AccommodationDetails"."CheckIn" ASC ';
        // echo $SQL; exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE main."Agents"."UID" = ' . $ID . ' And voucher."Master"."UpdationCounter" = 0
                ';

        $records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
        return $records;

    }

    public
    function AllB2CVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."CountryID" as "AgentCountryID"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE voucher."Master"."Archive"= 0  AND voucher."Master"."VoucherType" LIKE \'%B2C%\'  ';

        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND voucher."Master"."AgentUID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['voucher_code']) && trim($_POST['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_code']) . '\' ';
        }

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        // $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;exit();
        return $SQL;

    }

    public
    function AllWithoutVoucherArrivalPaxReport($ID = '')
    {

        $data = $this->data;
        $Crud = new Crud();


        $session = session();
        $session = $session->get();
        $SQL = 'SELECT 
                    pilgrim."master".*, 
                    pilgrim."travel".*,
                    main."Agents"."FullName" AS "AgentName",
                    main."Agents"."Type" AS "AgentType",
                    main."Agents"."UID" AS "AgentUID",
                    pilgrim."master"."UID" AS "PilgrimUID",
                    main."Groups"."FullName" AS "GroupName",
                    main."Groups"."UID" AS "GroupUID",
                    main."Countries"."Name" as "CountryName",
                    sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID" 
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")
                AND pilgrim."master"."UID" NOT IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')

              ';


        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else if ($ID != '') {
            $AgentsUIDs = HierarchyUsers($ID);
            $SQL .= 'AND  pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

//        echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function PilgrimDetails($ID = '')
    {

        $data = $this->data;
        $Crud = new Crud();


        $session = session();
        $session = $session->get();
        $SQL = 'SELECT 
                    pilgrim."master".*, 
                    pilgrim."travel".*,
                    main."Agents"."FullName" AS "AgentName",
                    main."Agents"."Type" AS "AgentType",
                    main."Agents"."UID" AS "AgentUID",
                    pilgrim."master"."UID" AS "PilgrimUID",
                    main."Groups"."FullName" AS "GroupName",
                    main."Groups"."UID" AS "GroupUID",
                    main."Countries"."Name" as "CountryName",
                    sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID" 
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")
              ';

        $SQL .= 'AND  pilgrim."master"."UID" =  ' . $ID . ' ';


        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function AllCompletedWithoutVoucherArrivalPax($ID = '')
    {

        $data = $this->data;
        $Crud = new Crud();


        $SQL = 'SELECT pilgrim."master".*, pilgrim."travel".*,main."Agents"."FullName" AS "AgentName",main."Groups"."FullName" AS "GroupName",main."Groups"."UID" AS "GroupUID"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID" 
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")
                AND pilgrim."master"."UID" IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')

              ';


        if ($ID != '') {
            $AgentsUIDs = HierarchyUsers($ID);
            $SQL .= ' AND  pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

//        echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function AllExecutedVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."CountryID" as "AgentCountryID",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE voucher."Master"."CurrentStatus" = \'Executed\'
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        $records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
        return $records;

    }

    public
    function AllRefundVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."CountryID" as "AgentCountryID",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE voucher."Master"."CurrentStatus" = \'Executed\'  
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        $records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
        return $records;

    }

    public
    function VoucherDataByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."Master"';
        $where = array("UID" => $ID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function PilgrimStatusInMeta($Option)
    {


        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."meta".*  FROM pilgrim."meta" WHERE pilgrim."meta"."Option" LIKE \'%' . $Option . '%\' ';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function VoucherPilgrimDataByID($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."Pilgrim"';
        $where = array("VoucherUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function VoucherServiceData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'voucher."Services"';
        $where = array("VoucherUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function DeleteFlightRow($UID)
    {

        $Crud = new Crud();
        $table = 'voucher."Flights"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    /** Allow Hotel Activity Func */

    public function count_allow_hotel_activity_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->TotalCountVouchersForPilgrimsAllowHotelActivity();
        $records = $Crud->ExecuteSQL($SQL);
        // echo'<pre>';print_r( $records );exit;
        return $records[0]['TotalPax'];
    }

    public
    function TotalCountVouchersForPilgrimsAllowHotelActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowHotelSessionFilters'];
        // print_r($SessionFilters);exit;
        $Crud = new Crud();
        $SQL = 'SELECT 
                count(DISTINCT(voucher."AccommodationDetails"."UID")) AS "TotalPax"
               /*(SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND pilgrim."meta"."Option" LIKE \'%allow-htl%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID") AS "Voucher_pilgrim"*/
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN main."LookupsOptions" ON (cast(voucher."AccommodationDetails"."RoomType"  as int) = main."LookupsOptions"."UID")
                WHERE voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."Hotel" != \'null\' 
                AND voucher."AccommodationDetails"."RoomType" != \'null\' 
                /*AND voucher."AccommodationDetails"."Self" = 0 */ ';


        if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
            $SQL .= ' AND voucher."Master"."UID"  = ' . $SessionFilters['VoucherId'] . ' ';

        }
        if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['AgentCountry'] . '\' ';

        }
        if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
            $SQL .= ' AND main."Agents"."UID"  = ' . $SessionFilters['Agents'] . ' ';

        }
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';

        }
        if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."City" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."Hotel" = \'' . $SessionFilters['hotel'] . '\' ';

        }
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '' && isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }

        /** Filters Start */
//        if (isset($_POST['country']) && $_POST['country'] != '') {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
//        }
//
//        if (isset($_POST['agent']) && $_POST['agent'] != '') {
//            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
//        }
//
//        if (isset($_POST['voucher_code']) && trim($_POST['voucher_code']) != '') {
//            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_code']) . '\' ';
//        }
//
//        if (isset($_POST['hotel_name']) && trim($_POST['hotel_name']) != '') {
//            $SQL .= ' AND LOWER( packages."Hotels"."Name" ) LIKE \'' . strtolower(trim($_POST['hotel_name'])) . '\' ';
//        }
//
//        if (isset($_POST['arrival_date_from']) && $_POST['arrival_date_from'] != '' && isset($_POST['arrival_date_to']) && $_POST['arrival_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['arrival_date_to'])) . '\' ';
//        }
//
//        if (isset($_POST['return_date_from']) && $_POST['return_date_from'] != '' && isset($_POST['return_date_to']) && $_POST['return_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['return_date_to'])) . '\' ';
//        }
        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        /* $SQL .= 'GROUP BY
         voucher."AccommodationDetails"."UID",
         voucher."Master"."VoucherCode",
         voucher."AccommodationDetails"."Self",
         voucher."Master"."UID",
         packages."Hotels"."Name",
         main."Agents"."UID",
         voucher."Master"."ReturnDate",
         main."Countries"."Name",
         main."Cities"."Name",
         main."LookupsOptions"."Name",
         voucher."AccommodationDetails"."RoomType",
         voucher."Master"."ArrivalDate"
         ORDER BY voucher."AccommodationDetails"."CheckIn" ASC';*/
        //echo nl2br($SQL); exit();
        // $records = $Crud->ExecuteSQL($SQL);

        /*
                $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

                //echo nl2br($SQL); exit();
                // $records = $Crud->ExecuteSQL($SQL);

                if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
                    $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
                } else {
                    $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
                }*/

        return $SQL;
    }

    public function get_allow_hotel_activity_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsAllowHotelActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        // echo nl2br($SQL);exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function VouchersForPilgrimsAllowHotelActivity($allow = false)
    {

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowHotelSessionFilters'];
//         print_r($SessionFilters);exit;
        $Crud = new Crud();
        $SQL = 'SELECT 
                voucher."AccommodationDetails".*, 
                main."Agents"."FullName" as "AgentName", 
                voucher."Master"."UID" as "VoucherID",
                voucher."Master"."VoucherCode" as "VoucherCode",
                voucher."Master"."ArrivalDate" as "ArrivalDate",
                packages."Hotels"."Name" as "HotelName",
                main."Countries"."Name" as "Country",
                main."Cities"."Name" as "CityName",
                main."LookupsOptions"."Name" AS "RoomTypeName",
                voucher."Master"."ReturnDate" as "ReturnDate", 
                main."Agents"."ParentID" as "AgentParentID",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",
                (SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND pilgrim."meta"."Option" LIKE \'%allow-htl%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID") AS "Voucher_pilgrim"
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN main."LookupsOptions" ON (cast(voucher."AccommodationDetails"."RoomType"  as int) = main."LookupsOptions"."UID")
                WHERE voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."Hotel" != \'\' 
                AND voucher."AccommodationDetails"."RoomType" != \'\' 
                /*AND voucher."AccommodationDetails"."Self" = 0 */ ';


//        if (!isset($SessionFilters['completed'])) {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
//        }


        /** Filters Start */
//


//        if (isset($_POST['country']) && $_POST['country'] != '') {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
//        }
//
//        if (isset($_POST['agent']) && $_POST['agent'] != '') {
//            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
//        }
//
//        if (isset($_POST['voucher_code']) && trim($_POST['voucher_code']) != '') {
//            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_code']) . '\' ';
//        }
//
//        if (isset($_POST['hotel_name']) && trim($_POST['hotel_name']) != '') {
//            $SQL .= ' AND LOWER( packages."Hotels"."Name" ) LIKE \'' . strtolower(trim($_POST['hotel_name'])) . '\' ';
//        }
//
//        if (isset($_POST['arrival_date_from']) && $_POST['arrival_date_from'] != '' && isset($_POST['arrival_date_to']) && $_POST['arrival_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['arrival_date_to'])) . '\' ';
//        }
//
//        if (isset($_POST['return_date_from']) && $_POST['return_date_from'] != '' && isset($_POST['return_date_to']) && $_POST['return_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['return_date_to'])) . '\' ';
//        }
        /** Filters ENDS */


        if ($session['domainid'] > 0) {
            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
        }
        if ($allow) {
            //////////////////// ADD ALLOWED Where condition
            ///
        }

        if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
            $SQL .= ' AND voucher."Master"."UID"  = ' . $SessionFilters['VoucherId'] . ' ';

        }
        if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['AgentCountry'] . '\' ';

        }
        if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
            $SQL .= ' AND main."Agents"."UID"  = ' . $SessionFilters['Agents'] . ' ';

        }
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';

        }
        if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."City" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."Hotel" = \'' . $SessionFilters['hotel'] . '\' ';

        }
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '' && isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }

        $SQL .= 'GROUP BY 
        voucher."AccommodationDetails"."UID",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."Self",
        voucher."Master"."UID",
        packages."Hotels"."Name",
        main."Agents"."UID",
        voucher."Master"."ReturnDate", 
        main."Countries"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        voucher."AccommodationDetails"."RoomType",
        voucher."Master"."ArrivalDate" 
        ORDER BY voucher."AccommodationDetails"."CheckIn" ASC';

//        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        //echo nl2br($SQL); exit();
        // $records = $Crud->ExecuteSQL($SQL);
//        $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';

        //echo nl2br($SQL); exit();


        return $SQL;
    }

    public
    function count_allow_transport_activity_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->TotalCountVouchersForPilgrimsAllowTransportActivity();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPax'];

    }

    public
    function TotalCountVouchersForPilgrimsAllowTransportActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowTransportSessionFilters'];
        $Crud = new Crud();
        $SQL = 'SELECT
                count(DISTINCT(voucher."TransportRate"."UID")) AS "TotalPax",
              /*  (SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher . "TransportRate" . "VoucherUID" AND pilgrim."meta"."Option" LIKE \'%allow-tpt%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID" ) AS "Voucher_pilgrim"*/
                FROM voucher."TransportRate"
                INNER JOIN voucher."Master" ON voucher."Master"."UID" = voucher."TransportRate"."VoucherUID"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."LookupsOptions" ON (voucher."TransportRate"."Sectors" = main."LookupsOptions"."UID")
                WHERE voucher."Master"."Archive"  = 0 
                /*AND voucher."TransportRate"."SelfTransport" = 0 */
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

//        $SQL .= 'GROUP BY voucher."TransportRate"."UID",voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
//                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';
        //echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);


//        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';
//
//        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
//            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
//        } else {
//            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
//        }

//       echo nl2br($SQL);exit();

        return $SQL;
    }

    public
    function get_allow_transport_activity_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsAllowTransportActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function VouchersForPilgrimsAllowTransportActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowTransportSessionFilters'];

        $Crud = new Crud();
        $SQL = 'SELECT voucher."TransportRate".*, 
                main."Agents"."FullName" as "AgentName", 
                main."LookupsOptions"."Name" AS "SectorName", 
                voucher."Master"."UID" as "VoucherID",
                voucher."Master"."VoucherCode" as "VoucherCode",
                voucher."Master"."ArrivalDate" as "ArrivalDate",
                voucher."Master"."Country" as "Country",
                voucher."Master"."ReturnDate" as "ReturnDate", 
                main."Agents"."ParentID" as "AgentParentID",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",
                ( SELECT main."LookupsOptions"."Name" 
                FROM packages."Transport" 
                INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" AS INTEGER) = main."LookupsOptions"."UID")  
                WHERE packages."Transport"."UID" = CAST(voucher."TransportRate"."TransportTypeUID" AS INTEGER)  ) AS "TransportTypeName",
                (SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher . "TransportRate" . "VoucherUID" AND pilgrim."meta"."Option" LIKE \'%allow-tpt%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%allow-tpt-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID" ) AS "Voucher_pilgrim"
                FROM voucher."TransportRate"
                INNER JOIN voucher."Master" ON voucher."Master"."UID" = voucher."TransportRate"."VoucherUID"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."LookupsOptions" ON (voucher."TransportRate"."Sectors" = main."LookupsOptions"."UID")
                WHERE voucher."Master"."Archive"  = 0 
                /*AND voucher."TransportRate"."SelfTransport" = 0 */
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $SQL .= 'GROUP BY voucher."TransportRate"."UID",voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }


//        echo nl2br($SQL);
//        exit();
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }


    /** All Vouchers Func */

    public
    function count_all_vouchers_filtered()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent"
            || $session['account_type'] == "sub_agent" || $session['account_type'] == "sale_agent") {
            $SQL = $this->TotalCountAllVouchersListByID($session['id']);
        } else {
            $SQL = $this->TotalCountAllVouchersList();
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalVouchers'];

    }

    public
    function TotalCountAllVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE voucher."Master"."Archive"=0 AND voucher."Master"."VoucherType" != \'B2C\' ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        /* if ($session['account_type'] == 'sale_agent') {
             $AgentsUIDs = HierarchyUsers($session['id']);
             $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
         } else {
             $AgentsUIDs = HierarchyUsers($ID);
             $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
         }*/

        // $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;exit();
        return $SQL;

    }

    public
    function TotalCountAllVouchersList()
    {
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"=0 AND voucher."Master"."VoucherType" != \'B2C\' ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  voucher."Master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        //echo nl2br($SQL);exit();

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;

    }

    public
    function get_all_vouchers_datatables()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent"
            || $session['account_type'] == "sub_agent" || $session['account_type'] == "sale_agent") {
            $SQL = $this->AllVouchersListByID($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        //echo nl2br($SQL); exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function AllVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."Archive"= 0 AND voucher."Master"."VoucherType" != \'B2C\'
        ';

//        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."CountryID" as "AgentCountryID",
//                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax"
//                FROM voucher."Master"
//                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
//                WHERE voucher."Master"."Archive"= 0  AND voucher."Master"."VoucherType" != \'B2C\' ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        /*if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else {
            $AgentsUIDs = HierarchyUsers($ID);
            $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }*/


        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //$records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;exit();
        return $SQL;

    }

    public
    function AllVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."Archive"= 0 AND voucher."Master"."VoucherType" != \'B2C\'  ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  voucher."Master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        /*if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent") {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  voucher."Master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        } else if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }*/

        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        // echo $SQL;exit();

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    /** All Pending Vouchers Func */

    public
    function count_all_pending_vouchers_filtered()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->TotalCountAllPendingVouchersListBYID($session['id']);
        } else {
            $SQL = $this->TotalCountAllPendingVouchersList();
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPendingVouchers'];

    }

    public
    function TotalCountAllPendingVouchersListBYID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllPendingVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalPendingVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."CurrentStatus" =\'Pending\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function TotalCountAllPendingVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllPendingVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalPendingVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."CurrentStatus" =\'Pending\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function get_all_pending_vouchers_datatables()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllPendingVouchersListBYID($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllPendingVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        // echo $SQL; exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function AllPendingVouchersListBYID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllPendingVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Pending\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function AllPendingVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllPendingVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Pending\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    /** All Approved Vouchers Func */

    public
    function count_all_approved_vouchers_filtered()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->TotalCountAllApprovedVouchersListByID($session['id']);
        } else {
            $SQL = $this->TotalCountAllApprovedVouchersList();
        }
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalApprovedVoucher'];

    }

    public
    function TotalCountAllApprovedVouchersListByID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllApprovedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalApprovedVoucher"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy" 
                where voucher."Master"."CurrentStatus" =\'Approved\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        /*$SQL .= ' ORDER BY voucher."Remarks"."UID"';*/
        //echo nl2br($SQL);exit();

        // $records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function TotalCountAllApprovedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllApprovedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalApprovedVoucher"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy" 
                where voucher."Master"."CurrentStatus" =\'Approved\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        /*$SQL .= ' ORDER BY voucher."Remarks"."UID"';*/
        //echo nl2br($SQL);exit();

        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;


    }


    /**
     * Development Start By
     * Jawad Sajid Durrani
     */

    public
    function get_all_approved_vouchers_datatables()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllApprovedVouchersListByID($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllApprovedVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        //echo nl2br($SQL); exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function AllApprovedVouchersListByID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllApprovedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                main."Users"."FullName" as "ApproveBy",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Approved\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else {

            $AgentsUIDs = HierarchyUsers($ID);
            $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);exit();

        // $records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    /* Allow Transport Activity Func */

    public
    function AllApprovedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllApprovedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                main."Users"."FullName" as "ApproveBy",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy" 
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Approved\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);exit();

        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;


    }

    /** All Updated Vouchers Func */
    public
    function count_all_updated_vouchers_filtered()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->TotalCountUpdatedVouchersListByID($session['id']);
        } else {
            $SQL = $this->TotalUpdatedUpdatedVouchersList();
        }
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalUpdatedVouchers'];
    }

    /* Actual Hotel Activity Func */

    public
    function TotalCountUpdatedVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllUpdatedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalUpdatedVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                WHERE voucher."Master"."UpdationCounter" > 0
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        // $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;
        return $SQL;

    }

    public
    function TotalUpdatedUpdatedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllUpdatedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") As "TotalUpdatedVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy" 
                WHERE voucher."Master"."UpdationCounter" > 0
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        /*$SQL .= ' ORDER BY voucher."Remarks"."UID"';*/

        //echo $SQL;
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    /* Actual Transport Activity Func */

    public
    function get_all_updated_vouchers_datatables()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->UpdatedVouchersListByID($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->UpdatedVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        // echo $SQL; exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function UpdatedVouchersListByID($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllUpdatedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, main."Agents"."FullName" as "AgentName", main."Agents"."CountryID" as "AgentCountryID",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                WHERE voucher."Master"."UpdationCounter" > 0
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        // $records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
        return $SQL;

    }

    public
    function UpdatedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllUpdatedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                main."Agents"."CountryID" as "AgentCountryID",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                main."Users"."FullName" as "ApproveBy",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                WHERE voucher."Master"."UpdationCounter" > 0
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }

//        $SQL .= ' ORDER BY voucher."Remarks"."UID"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //echo $SQL;
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    /** All Executed Vouchers Func */

    public
    function count_all_executed_vouchers_filtered()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->TotalCountAllExecutedVouchersListID($session['id']);
        } else {
            $SQL = $this->TotalCountAllExecutedVouchersList();
        }
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalExecutedVouchers'];

    }

    public
    function TotalCountAllExecutedVouchersListID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllExecutedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalExecutedVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"  
                where voucher."Master"."CurrentStatus" =\'Executed\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        /*$SQL .= ' ORDER BY voucher."Remarks"."UID"';*/

        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    public
    function TotalCountAllExecutedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllExecutedVoucherSessionFilters'];

        $SQL = 'SELECT count(voucher."Master"."UID") AS "TotalExecutedVouchers"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"  
                where voucher."Master"."CurrentStatus" =\'Executed\'   
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        /* $SQL .= ' ORDER BY voucher."Remarks"."UID"';*/

        // echo $SQL;

        // $records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function get_all_executed_vouchers_datatables()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllExecutedVouchersListID($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllExecutedVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        // echo $SQL; exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function AllExecutedVouchersListID($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllExecutedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                main."Users"."FullName" as "ApproveBy",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Executed\' 
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else {
            $AgentsUIDs = HierarchyUsers($ID);
            $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
//        $SQL .= ' ORDER BY voucher."Remarks"."UID"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //echo $SQL;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    public
    function AllExecutedVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllExecutedVoucherSessionFilters'];

        $SQL = 'SELECT voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                main."Users"."FullName" as "ApproveBy",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                where voucher."Master"."CurrentStatus" =\'Executed\'   
                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
//        $SQL .= ' ORDER BY voucher."Remarks"."UID"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }

        // echo $SQL;

        // $records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    /** All Refund Vouchers Func */

    public
    function count_all_refund_vouchers_filtered()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllRefundVouchersListId($session['id']);
        } else {
            $SQL = $this->AllRefundVouchersList();
        }
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public
    function AllRefundVouchersListId($ID)
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllRefundVoucherSessionFilters'];

        $SQL = 'SELECT DISTINCT voucher."Master"."UID",voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                /*,
                main."Users"."FullName" as "ApproveBy",
                "Remarks1"."CreatedDate" as "RefundDate"*/
                FROM voucher."Master"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN voucher."Services" ON (voucher."Services"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."ZiyaratsRate" ON (voucher."ZiyaratsRate"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"  = voucher."Master"."UID")
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                /*LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN voucher."Remarks" AS "Remarks1" ON ("Remarks1"."VoucherID"  = voucher."Master"."UID" AND "Remarks1"."Remarks"=\'Voucher Refund\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"  */
                WHERE /*voucher."Master"."UID" IN (SELECT DISTINCT voucher."RefundMeta"."VoucherUID" FROM voucher."RefundMeta")*/ voucher."Master"."Archive" = 0    AND ( voucher."Services"."Refund"= 1 OR voucher."TransportRate"."Refund"= 1 OR voucher."AccommodationDetails"."Refund"= 1 OR voucher."ZiyaratsRate"."Refund"= 1 )
                 ';


        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
        }
        $AgentsUIDs = HierarchyUsers($ID);
        $SQL .= ' AND  main."Agents"."UID" IN   (' . $AgentsUIDs . ') ';

        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }

//        $SQL .= ' ORDER BY voucher."Master"."VoucherCode" ASC';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        // echo $SQL;exit;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function AllRefundVouchersList()
    {

        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $VoucherSearchFilter = $session['VoucherSearchFilter'];
        $SessionFilters = $session['AllRefundVoucherSessionFilters'];

        $SQL = 'SELECT DISTINCT voucher."Master"."UID",voucher."Master".*, 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."CountryID" as "AgentCountryID", 
                main."Agents"."ParentID" as "AgentParentID",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (SELECT COUNT(DISTINCT "PilgrimUID") FROM voucher."Pilgrim" WHERE "Pilgrim"."VoucherUID" = voucher."Master"."UID") AS "TotalPax",
                main."Operators"."Logo" AS "OperatorLogo", main."Operators"."CompanyName" AS "OperatorName"
                /*,
                main."Users"."FullName" as "ApproveBy",
                "Remarks1"."CreatedDate" as "RefundDate"*/
                FROM voucher."Master"
                LEFT JOIN voucher."Services" ON (voucher."Services"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."ZiyaratsRate" ON (voucher."ZiyaratsRate"."VoucherUID"  = voucher."Master"."UID")
                LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"  = voucher."Master"."UID")
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = voucher."Master"."WebsiteDomain" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN main."Operators" ON main."Operators"."UID"  = voucher."Master"."UmrahOperator"
                /*LEFT JOIN voucher."Remarks" ON (voucher."Remarks"."VoucherID"  = voucher."Master"."UID" AND voucher."Remarks"."Remarks"=\'Voucher Approved\')
                LEFT JOIN voucher."Remarks" AS "Remarks1" ON ("Remarks1"."VoucherID"  = voucher."Master"."UID" AND "Remarks1"."Remarks"=\'Voucher Refund\')
                LEFT JOIN main."Users" ON   main."Users"."UID"= voucher."Remarks"."CreatedBy"*/  
                WHERE /*voucher."Master"."UID" IN (SELECT DISTINCT voucher."RefundMeta"."VoucherUID" FROM voucher."RefundMeta")*/ voucher."Master"."Archive" = 0   AND ( voucher."Services"."Refund"= 1 OR voucher."TransportRate"."Refund"= 1 OR voucher."AccommodationDetails"."Refund"= 1 OR voucher."ZiyaratsRate"."Refund"= 1 )

                ';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
        }
        if (isset($VoucherSearchFilter['vouchercode'])) {
            $SQL .= ' AND LOWER(voucher."Master"."VoucherCode") LIKE \'%' . strtolower($VoucherSearchFilter['vouchercode']) . '%\' ';
        }
        if (isset($VoucherSearchFilter['agentname'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($VoucherSearchFilter['agentname']) . '%\' ';
        }

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
//        $SQL .= ' ORDER BY voucher."Master"."VoucherCode" ASC';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        // echo $SQL; exit;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function get_all_refund_vouchers_datatables()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllRefundVouchersListId($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllRefundVouchersList();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        // echo $SQL; exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    /** All WithOut Vouchers Arrival Func */

    public
    function count_all_without_vouchers_arrival_filtered()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllWithoutVoucherArrivalPax($session['id']);
        } else {
            $SQL = $this->AllWithoutVoucherArrivalPax();
        }
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public
    function AllWithoutVoucherArrivalPax($ID = '')
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['WithoutVouchersArrivalSessionFilters'];

        $SQL = 'SELECT 
pilgrim."master".*, 
pilgrim."travel".*,
main."Agents"."FullName" AS "AgentName",
main."Agents"."Type" AS "AgentType",
main."Agents"."UID" AS "AgentUID",
pilgrim."master"."UID" AS "PilgrimUID",
main."Groups"."FullName" AS "GroupName",
main."Groups"."UID" AS "GroupUID",
main."Countries"."Name" as "CountryName",
sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID" 
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")
              ';

        /** Filters Start*/
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['entry_port']) && trim($SessionFilters['entry_port']) != '') {
            $SQL .= ' AND LOWER(pilgrim."travel"."EntryPort") LIKE \'%' . strtolower(trim($SessionFilters['entry_port'])) . '%\' ';
        }

        if (isset($SessionFilters['ppt_no']) && trim($SessionFilters['ppt_no']) != '') {
            $SQL .= ' AND pilgrim."travel"."PassportNo" = \'' . trim($SessionFilters['ppt_no']) . '\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL .= ' AND pilgrim."travel"."MOFAPilgrimID" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL .= ' AND pilgrim."travel"."VisaNo" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }

        if (isset($SessionFilters['entry_start_date']) && $SessionFilters['entry_start_date'] != '' && isset($SessionFilters['entry_end_date']) && $SessionFilters['entry_end_date'] != '') {
            $SQL .= ' AND  pilgrim."travel"."EntryDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['entry_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['entry_end_date'])) . '\' ';
        }

        /** Filters End */

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        } else
            if ($ID != '') {
                $AgentsUIDs = HierarchyUsers($ID);
                $SQL .= ' AND  pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            }


//        echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;

    }

    public
    function get_all_without_vouchers_arrival_datatables()
    {

        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        if ($session['account_type'] == 'agent' || $session['account_type'] == "external_agent" || $session['account_type'] == "sub_agent") {
            $SQL = $this->AllWithoutVoucherArrivalPax($session['id']);
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        } else {
            $SQL = $this->AllWithoutVoucherArrivalPax();
            if ($_POST['length'] != -1)
                $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        }
        // echo $SQL ; exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function DeleteAccomodationsRows($table, $where)
    {
        $data = $this->data;

        $Crud = new Crud();

        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function GetVoucherAccommodationDetails($VoucherID)
    {

        $MainArray = array();
        $Crud = new Crud();
        $SQL = ' SELECT voucher."AccommodationDetails".*,
                    main."Cities"."Name" AS "CityName",
                    "BRN"."brn"."BRNCode"
                FROM voucher."AccommodationDetails"
                JOIN main."Cities" ON ( CAST(main."Cities"."UID" AS INTEGER) = CAST(voucher."AccommodationDetails"."City" AS INTEGER) )
                LEFT JOIN "BRN"."brn" ON 
                        ( CAST("BRN"."brn"."UID" AS INTEGER) = 
                          CASE 
                              WHEN voucher."AccommodationDetails"."AccommodationBRN" = \'\' THEN 0
                              ELSE CAST(voucher."AccommodationDetails"."AccommodationBRN" AS INTEGER) END )
                WHERE voucher."AccommodationDetails"."VoucherID" = ' . $VoucherID . ' 
                ORDER BY "AccommodationDetails"."CheckIn" ';
        $HotelsData = $Crud->ExecuteSQL($SQL);
        foreach ($HotelsData as $HD) {

            $RoomTypeName = $Type = '';

            $MainKey = $HD['Hotel'] . '_' . $HD['CheckIn'] . '_' . $HD['CheckOut'];

            $MainArray[$MainKey]['Hotel'] = $HD['Hotel'];
            $MainArray[$MainKey]['CityName'] = $HD['CityName'];
            $MainArray[$MainKey]['CheckIn'] = $HD['CheckIn'];
            $MainArray[$MainKey]['CheckOut'] = $HD['CheckOut'];
            $MainArray[$MainKey]['AccommodationBRN'] = $HD['AccommodationBRN'];
            $MainArray[$MainKey]['Self'] = $HD['Self'];
            $MainArray[$MainKey]['Refund'] = $HD['Refund'];
            $MainArray[$MainKey]['BRNCode'] = ((isset($HD['BRNCode']) && $HD['BRNCode'] != '') ? trim($HD['BRNCode']) : '');
            $MainArray[$MainKey]['AccommodationBRN'] = $HD['AccommodationBRN'];

            $RoomTypeName = OptionName($HD['RoomType']);
            if ($RoomTypeName == 'Sharing') {
                $Type = 'Bed';
            } else {
                $Type = 'Room';
            }
            $MainArray[$MainKey]['Rooms'][] = $HD['NoOfBeds'] . " " . $RoomTypeName . " " . $Type;
        }

        return $MainArray;
    }

    /* Development Ends By Jawad Sajid Durrani */

    public
    function get_actual_transport_activity_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsActualTransportActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_actual_hotel_activity_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->TotalCountVouchersForPilgrimsActualHotelActivity();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPax'];
    }

    public
    function get_actual_hotel_activity_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsActualHotelActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_actual_transport_activity_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->TotalCountVouchersForPilgrimsActualTransportActivity();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPax'];
    }

    public
    function TotalCountVouchersForPilgrimsActualHotelActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ActualHotelActivitiesSessionFilter'];
        $Crud = new Crud();
        $SQL = 'SELECT 
                count(DISTINCT(voucher."AccommodationDetails"."UID")) AS "TotalPax",
                 (SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID")FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND pilgrim."meta"."Option" LIKE \'%check-in%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID") as "Voucher_pilgrim"                
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                WHERE voucher."Master"."Archive"  = 0 
              /*  AND voucher."AccommodationDetails"."Self" = 0*/
                 AND (voucher."Master"."CurrentStatus" != \'Pending\' OR voucher."Master"."CurrentStatus" != \'Reject\')   ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }


        if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
            $SQL .= ' AND voucher."Master"."UID"  = ' . $SessionFilters['VoucherId'] . ' ';

        }
        if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['AgentCountry'] . '\' ';
        }
        if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
            $SQL .= ' AND main."Agents"."UID"  = ' . $SessionFilters['Agents'] . ' ';
        }
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }
        if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."City" = \'' . $SessionFilters['City'] . '\' ';
        }
        if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."Hotel" = \'' . $SessionFilters['hotel'] . '\' ';
        }
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '' && isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }


        $SQL .= 'GROUP BY voucher."AccommodationDetails"."UID",voucher."Master"."VoucherCode",voucher."Master"."CurrentStatus",voucher."AccommodationDetails"."Self",voucher."Master"."UID",packages."Hotels"."Name",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                ORDER BY voucher."AccommodationDetails"."CheckIn" ASC ';
        //echo $SQL; exit();
        //$records = $Crud->ExecuteSQL($SQL);


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        //echo nl2br($SQL); exit();
        // $records = $Crud->ExecuteSQL($SQL);

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }


        return $SQL;
    }

    public
    function VouchersForPilgrimsActualHotelActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ActualHotelActivitiesSessionFilter'];
//        print_r($SessionFilters);exit;

        $Crud = new Crud();
        $SQL = 'SELECT voucher."AccommodationDetails".*, main."Agents"."FullName" as "AgentName", voucher."Master"."UID" as "VoucherID",
                voucher."Master"."VoucherCode" as "VoucherCode",voucher."Master"."ArrivalDate" as "ArrivalDate",packages."Hotels"."Name" as "HotelName",
                voucher."Master"."Country" as "Country", voucher."Master"."CurrentStatus" as "CurrentStatus",voucher."Master"."ReturnDate" as "ReturnDate", main."Agents"."ParentID" as "AgentParentID",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",
                (SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID")FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND pilgrim."meta"."Option" LIKE \'%check-in%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-mecca-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-medina-contact-number%\' 
                AND pilgrim."meta"."Option" NOT LIKE \'%check-in-jeddah-contact-number%\'
                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID") as "Voucher_pilgrim"
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int)) 
                WHERE voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."Hotel" != \'\'
              /*  AND voucher."AccommodationDetails"."Self" = 0*/
                 AND (voucher."Master"."CurrentStatus" != \'Pending\' OR voucher."Master"."CurrentStatus" != \'Reject\')   ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }


        if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
            $SQL .= ' AND voucher."Master"."UID"  = ' . $SessionFilters['VoucherId'] . ' ';

        }
        if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['AgentCountry'] . '\' ';
        }
        if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
            $SQL .= ' AND main."Agents"."UID"  = ' . $SessionFilters['Agents'] . ' ';
        }
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }
        if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."City" = \'' . $SessionFilters['City'] . '\' ';
        }
        if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."Hotel" = \'' . $SessionFilters['hotel'] . '\' ';
        }
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '' && isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }


        $SQL .= ' GROUP BY voucher."AccommodationDetails"."UID",voucher."Master"."VoucherCode",voucher."Master"."CurrentStatus",voucher."AccommodationDetails"."Self",voucher."Master"."UID",packages."Hotels"."Name",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate" 
                ORDER BY voucher."AccommodationDetails"."CheckIn" ASC  ';

        //$records = $Crud->ExecuteSQL($SQL);


//        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        //  echo nl2br($SQL); exit();
        // $records = $Crud->ExecuteSQL($SQL);

//        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
//            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
//        } else {
//            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
//        }
        //echo $SQL; exit();


        return $SQL;
    }


    public
    function TotalCountVouchersForPilgrimsActualTransportActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ActualTransportSessionFilters'];
        $Crud = new Crud();
        $SQL = 'SELECT count(DISTINCT(voucher."TransportRate"."UID")) AS "TotalPax",
               ,(SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."TransportRate"."VoucherUID" AND (pilgrim."meta"."Option" LIKE \'%check-out%\' 
                OR pilgrim."meta"."Option" LIKE \'%arrival%\'  OR pilgrim."meta"."Option" LIKE \'%departure%\')
                AND pilgrim."meta"."Option" NOT LIKE \'%contact-number%\' 
                AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID") AS "Voucher_pilgrim" 
                FROM voucher."TransportRate"
                INNER JOIN voucher."Master" ON voucher."Master"."UID" = voucher."TransportRate"."VoucherUID"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."LookupsOptions" ON (voucher."TransportRate"."Sectors" = main."LookupsOptions"."UID")
                WHERE voucher."Master"."Archive"  = 0
                 /*AND voucher."TransportRate"."SelfTransport" = 0 */
                AND (voucher."Master"."CurrentStatus" != \'Pending\' OR voucher."Master"."CurrentStatus" != \'Reject\')
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        /*$SQL .= 'GROUP BY voucher."TransportRate"."UID",voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",voucher."Master"."CurrentStatus",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';*/
        //echo $SQL;exit();
        //  $records = $Crud->ExecuteSQL($SQL);


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }

        return $SQL;

    }


    public
    function VouchersForPilgrimsActualTransportActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ActualTransportSessionFilters'];

        $Crud = new Crud();
        $SQL = 'SELECT voucher."TransportRate".*, main."Cities"."Name" as "CityName", main."Agents"."FullName" as "AgentName", main."LookupsOptions"."Name" AS "SectorName", voucher."Master"."UID" as "VoucherID",
                voucher."Master"."VoucherCode" as "VoucherCode",voucher."Master"."ArrivalDate" as "ArrivalDate",voucher."Master"."CurrentStatus" as "CurrentStatus",
                voucher."Master"."Country" as "Country",voucher."Master"."ReturnDate" as "ReturnDate", main."Agents"."ParentID" as "AgentParentID",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",( SELECT main."LookupsOptions"."Name" FROM packages."Transport" INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" AS INTEGER) = main."LookupsOptions"."UID")  WHERE packages."Transport"."UID" = CAST(voucher."TransportRate"."TransportTypeUID" AS INTEGER)  ) AS "TransportTypeName"
                ,(SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim" 
                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
                WHERE voucher."Pilgrim"."VoucherUID" = voucher."TransportRate"."VoucherUID" AND (pilgrim."meta"."Option" LIKE \'%check-out%\' 
                OR pilgrim."meta"."Option" LIKE \'%arrival%\'  OR pilgrim."meta"."Option" LIKE \'%departure%\')
                AND pilgrim."meta"."Option" NOT LIKE \'%contact-number%\' 
                AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID") AS "Voucher_pilgrim" FROM voucher."TransportRate"
                INNER JOIN voucher."Master" ON voucher."Master"."UID" = voucher."TransportRate"."VoucherUID"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."LookupsOptions" ON (voucher."TransportRate"."Sectors" = main."LookupsOptions"."UID")
                LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"

                WHERE voucher."Master"."Archive"  = 0
                 /*AND voucher."TransportRate"."SelfTransport" = 0 */
                AND (voucher."Master"."CurrentStatus" != \'Pending\' OR voucher."Master"."CurrentStatus" != \'Reject\')
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];

        }

        $SQL .= 'GROUP BY voucher."TransportRate"."UID", main."Cities"."Name", voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",voucher."Master"."CurrentStatus",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }


        //echo $SQL;exit();
        //  $records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    function GetPackageRateVisaRateByOption($RefID, $Option)
    {

        if ($RefID != '' && $RefID > 0) {

            $Crud = new Crud();
            $SQL = ' SELECT * FROM packages."Meta" WHERE CAST("ReferenceID" AS INTEGER) = ' . $RefID . ' AND CAST("Option" AS INTEGER) = ' . $Option . ' LIMIT 1 ';
            $VisaRateData = $Crud->ExecuteSQL($SQL);
        }
        $VisaRate = ((isset($VisaRateData[0]['Value']) && $VisaRateData[0]['Value'] != '') ? $VisaRateData[0]['Value'] : 0);

        return $VisaRate;
    }

    public
    function GetVoucherVisaRateByOption($VoucherID, $Option, $PackageID)
    {

        $Crud = new Crud();
        $data = $this->data;
        $SQL = ' SELECT * FROM voucher."VisaRate" 
                 WHERE CAST("VoucherID" AS INTEGER) = ' . $VoucherID . '
                 AND CAST("Option" AS INTEGER) = ' . $Option . ' AND  voucher."VisaRate"."DomainID" = ' . $data['GetDomainID'] . '
                 LIMIT 1 ';
        $VisaRateData = $Crud->ExecuteSQL($SQL);
        if (isset($VisaRateData[0]['UID'])) {
            $VisaRate = ((isset($VisaRateData[0]['Rate']) && $VisaRateData[0]['Rate'] != '') ? $VisaRateData[0]['Rate'] : 0);
        } else {
            $VisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $Option);
        }
        return $VisaRate;
    }

    public
    function GetPilgrimTypeDetails($Pilgrims = array())
    {

        $Crud = new Crud();
        $Infant = $Child = $Adult = 0;
        $MainArray = array();
        if (count($Pilgrims) > 0) {
            $PilgrimIDs = implode(',', $Pilgrims);
            $SQL = ' SELECT CAST(
                                (
                                    CASE 
                                        WHEN "master"."DOBInYears" IS NULL AND "master"."DOB" IS NOT NULL THEN date_part(\'year\', Age(CAST("master"."DOB" AS TIMESTAMP)))
                                        WHEN "master"."DOBInYears" IS NULL AND "master"."DOB" IS NULL THEN 0
                                        ELSE "master"."DOBInYears"
                                    END
                                )
                        AS INTEGER ) AS "Age"
                    FROM pilgrim."master"
                 WHERE pilgrim."master"."UID" IN (' . $PilgrimIDs . ') 
                 ORDER BY "master"."DOBInYears" ASC';
            $PilgrimsData = $Crud->ExecuteSQL($SQL);
            foreach ($PilgrimsData as $PD) {
                if ($PD['Age'] < 2) {
                    $Infant += 1;
                } else if ($PD['Age'] >= 2 && $PD['Age'] <= 10) {
                    $Child += 1;
                } else if ($PD['Age'] > 10) {
                    $Adult += 1;
                }
            }
        }

        $MainArray['Infant'] = $Infant;
        $MainArray['Child'] = $Child;
        $MainArray['Adult'] = $Adult;

        return $MainArray;
    }

    public
    function GetVoucherVisaRate($PackageID, $PilgrimsArray = array(), $UID)
    {

        $Main = new Main();
        $Crud = new Crud();
        $AdultVisaID = $ChildVisaID = $InfantVisaID = 0;
        $AdultVisaRate = $ChildVisaRate = $InfantVisaRate = 0;
        $VoucherInfants = $VoucherChilds = $VoucherAdults = 0;
        $PilgrimsTypeBaseRecord = $this->GetPilgrimTypeDetails($PilgrimsArray);
        $VoucherAdults = ((isset($PilgrimsTypeBaseRecord['Adult']) && $PilgrimsTypeBaseRecord['Adult'] != '') ? $PilgrimsTypeBaseRecord['Adult'] : 0);
        $VoucherChilds = ((isset($PilgrimsTypeBaseRecord['Child']) && $PilgrimsTypeBaseRecord['Child'] != '') ? $PilgrimsTypeBaseRecord['Child'] : 0);
        $VoucherInfants = ((isset($PilgrimsTypeBaseRecord['Infant']) && $PilgrimsTypeBaseRecord['Infant'] != '') ? $PilgrimsTypeBaseRecord['Infant'] : 0);


        $AdultVisa = $Main->Settings('package_umrah_key');
        $AdultVisaID = ((isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0) ? $AdultVisa : 0);
        if ($AdultVisaID > 0) {
            if ($UID == 0) {
                $AdultVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $AdultVisaID);
            } else {
                $AdultVisaRate = $this->GetVoucherVisaRateByOption($UID, $AdultVisaID, $PackageID);
            }
            $AdultVisaRate = ($AdultVisaRate * $VoucherAdults);
        }

        $ChildVisa = $Main->Settings('child_umrah_rate');
        $ChildVisaID = ((isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0) ? $ChildVisa : 0);
        if ($ChildVisaID > 0) {
            if ($UID == 0) {
                $ChildVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $ChildVisaID);
            } else {
                $ChildVisaRate = $this->GetVoucherVisaRateByOption($UID, $ChildVisaID, $PackageID);
            }
            $ChildVisaRate = ($ChildVisaRate * $VoucherChilds);
        }

        $InfantVisa = $Main->Settings('infant_umrah_rate');
        $InfantVisaID = ((isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0) ? $InfantVisa : 0);
        if ($InfantVisaID > 0) {
            if ($UID == 0) {
                $InfantVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $InfantVisaID);
            } else {
                $InfantVisaRate = $this->GetVoucherVisaRateByOption($UID, $InfantVisaID, $PackageID);
            }
            $InfantVisaRate = ($InfantVisaRate * $VoucherInfants);
        }

        $VoucherVisaRate = ($AdultVisaRate + $ChildVisaRate + $InfantVisaRate);

        return $VoucherVisaRate;
    }

    public
    function AddVoucherVisaRate($DomainID, $VoucherID, $AgentPackageID, $SubmittedPackageID)
    {

        $data = $this->data;
        $Main = new Main();
        $Crud = new Crud();
        $AdultVisa = $Main->Settings('package_umrah_key');
        $ChildVisa = $Main->Settings('child_umrah_rate');
        $InfantVisa = $Main->Settings('infant_umrah_rate');

        $PackageID = $AgentPackageID;
        if ($AgentPackageID != $SubmittedPackageID) {
            $Crud->DeleteRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID));
            $PackageID = $SubmittedPackageID;
        }

        $AdultVisaID = ((isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0) ? $AdultVisa : 0);
        if ($AdultVisaID > 0) {

            $AdultVoucherVisaRateRecord = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, "Option" => $AdultVisaID));
            if (!isset($AdultVoucherVisaRateRecord['UID'])) {
                $AdultVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $AdultVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'VoucherID' => $VoucherID,
                    'Option' => $AdultVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $AdultVisaRate
                );
                $Crud->AddRecord('voucher."VisaRate"', $Record);
            }
        }
        $ChildVisaID = ((isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0) ? $ChildVisa : 0);
        if ($ChildVisaID > 0) {
            $ChildVoucherVisaRateRecord = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, "Option" => $ChildVisaID));
            if (!isset($ChildVoucherVisaRateRecord['UID'])) {
                $ChildVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $ChildVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'VoucherID' => $VoucherID,
                    'Option' => $ChildVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $ChildVisaRate
                );
                $Crud->AddRecord('voucher."VisaRate"', $Record);
            }
        }
        $InfantVisaID = ((isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0) ? $InfantVisa : 0);
        if ($InfantVisaID > 0) {
            $InfantVoucherVisaRateRecord = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, "Option" => $InfantVisaID));
            if (!isset($InfantVoucherVisaRateRecord['UID'])) {
                $InfantVisaRate = $this->GetPackageRateVisaRateByOption($PackageID, $InfantVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'VoucherID' => $VoucherID,
                    'Option' => $InfantVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $InfantVisaRate
                );
                $Crud->AddRecord('voucher."VisaRate"', $Record);
            }
        }
    }

    public
    function GetVoucherPilgrimsAppliedVisaRate($VoucherID)
    {

        $session = session();
        $session = $session->get();
        $Main = new Main();
        $Crud = new Crud();
        $AdultVisaRate = $ChildVisaRate = $InfantVisaRate = 0;
        $MainArray = array();

        $AdultVisa = $Main->Settings('package_umrah_key');
        $AdultVisaID = ((isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0) ? $AdultVisa : 0);
        if ($AdultVisaID > 0) {
            $AdultVisaRateData = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, 'Option' => $AdultVisaID, 'DomainID' => $session['domainid']));
            $AdultVisaRate = ((isset($AdultVisaRateData['Rate']) && $AdultVisaRateData['Rate'] != '') ? $AdultVisaRateData['Rate'] : 0);
        }

        $ChildVisa = $Main->Settings('child_umrah_rate');
        $ChildVisaID = ((isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0) ? $ChildVisa : 0);
        if ($ChildVisaID > 0) {
            $ChildVisaRateData = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, 'Option' => $ChildVisaID, 'DomainID' => $session['domainid']));
            $ChildVisaRate = ((isset($ChildVisaRateData['Rate']) && $ChildVisaRateData['Rate'] != '') ? $ChildVisaRateData['Rate'] : 0);
        }

        $InfantVisa = $Main->Settings('infant_umrah_rate');
        $InfantVisaID = ((isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0) ? $InfantVisa : 0);
        if ($InfantVisaID > 0) {
            $InfantVisaRateData = $Crud->SingleRecord('voucher."VisaRate"', array('VoucherID' => $VoucherID, 'Option' => $InfantVisaID, 'DomainID' => $session['domainid']));
            $InfantVisaRate = ((isset($InfantVisaRateData['Rate']) && $InfantVisaRateData['Rate'] != '') ? $InfantVisaRateData['Rate'] : 0);
        }

        $MainArray['Infant'] = $InfantVisaRate;
        $MainArray['Child'] = $ChildVisaRate;
        $MainArray['Adult'] = $AdultVisaRate;

        return $MainArray;
    }

    public
    function GetTotalSubmittedVoucherPilgrimsRecord($AccommodationUID, $RequestedStatus)
    {

        $Crud = new Crud();
        $PilgrimsArray = array();

        $SQL = ' SELECT DISTINCT( "meta"."PilgrimUID" ) AS "Pilgrims"
                 FROM pilgrim."meta"
                 WHERE pilgrim."meta"."Option" = \'' . $RequestedStatus . '-status\' 
                 AND pilgrim."meta"."AllowReference" IN 
                 ( SELECT voucher."AccommodationDetails"."UID" AS "AccommodationID"
                    FROM voucher."AccommodationDetails"
                     WHERE voucher."AccommodationDetails"."UID" IN 
                     ( SELECT voucher."AccommodationDetails"."UID"
                         FROM voucher."AccommodationDetails" SubTable
                        WHERE SubTable."Hotel" = voucher."AccommodationDetails"."Hotel"
                        AND SubTable."City" = voucher."AccommodationDetails"."City"
                        AND SubTable."CheckIn" = voucher."AccommodationDetails"."CheckIn" 
                        AND SubTable."VoucherID" = voucher."AccommodationDetails"."VoucherID" 
                        AND SubTable."UID" = ' . $AccommodationUID . '
                     )
                 ) ';
        $PilgrimsData = $Crud->ExecuteSQL($SQL);
        foreach ($PilgrimsData as $PD) {
            $PilgrimsArray[] = $PD['Pilgrims'];
        }

        return $PilgrimsArray;
    }

    public
    function GetTotalActivitySubmittedPilgrimsRecord($VoucherUID, $RequestedStatus, $AllowReference)
    {
        $Crud = new Crud();
        $PilgrimsArray = array();

        $ActivityAllowedPilgrimsSQL = ' SELECT CASE
                                                   WHEN "LookupsOptions"."Name" = \'Quint Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 5 )
                                                   WHEN "LookupsOptions"."Name" = \'Quad Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 4 )
                                                   WHEN "LookupsOptions"."Name" = \'Triple Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 3 )
                                                   WHEN "LookupsOptions"."Name" = \'Double Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 2 )
                                                   WHEN "LookupsOptions"."Name" = \'Single Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 1 )
                                                   WHEN "LookupsOptions"."Name" = \'Sharing\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 1 )
                                                END  AS "TotalAllowedActivityPilgrims"
                                         FROM voucher."AccommodationDetails"
                                         JOIN main."LookupsOptions" ON ( CAST("LookupsOptions"."UID" AS INTEGER) = CAST("AccommodationDetails"."RoomType" AS INTEGER) )
                                         WHERE voucher."AccommodationDetails"."VoucherID" = ' . $VoucherUID . '
                                         AND voucher."AccommodationDetails"."UID" = ' . $AllowReference . ' ';
        $AllowedPilgrimsData = $Crud->ExecuteSQL($ActivityAllowedPilgrimsSQL);
        $TotalAllowedPax = ((isset($AllowedPilgrimsData[0]['TotalAllowedActivityPilgrims']) && $AllowedPilgrimsData[0]['TotalAllowedActivityPilgrims'] != '') ? $AllowedPilgrimsData[0]['TotalAllowedActivityPilgrims'] : 0);

        $SubmittedPilgrimsSQL = ' SELECT COUNT( DISTINCT("meta"."PilgrimUID") ) AS "TotalPax" 
                 FROM pilgrim."meta"
                 JOIN voucher."AccommodationDetails" ON ( voucher."AccommodationDetails"."UID" = pilgrim."meta"."AllowReference" ) 
                 WHERE voucher."AccommodationDetails"."VoucherID" = ' . $VoucherUID . ' 
                 AND pilgrim."meta"."Option" = \'' . $RequestedStatus . '-status\'
                 AND pilgrim."meta"."AllowReference" = ' . $AllowReference . ' ';
        $SubmittedPilgrimsData = $Crud->ExecuteSQL($SubmittedPilgrimsSQL);
        $TotalSubmittedPax = ((isset($SubmittedPilgrimsData[0]['TotalPax']) && $SubmittedPilgrimsData[0]['TotalPax'] != '') ? $SubmittedPilgrimsData[0]['TotalPax'] : 0);

        $AdultsSubmittedPilgrimsSQL = ' SELECT COUNT( DISTINCT("meta"."PilgrimUID") ) AS "TotalAdultPax" 
                 FROM pilgrim."meta"
                 JOIN voucher."AccommodationDetails" ON ( voucher."AccommodationDetails"."UID" = pilgrim."meta"."AllowReference" ) 
                 WHERE voucher."AccommodationDetails"."VoucherID" = ' . $VoucherUID . ' 
                 AND pilgrim."meta"."Option" = \'' . $RequestedStatus . '-status\'
                 AND pilgrim."meta"."AllowReference" = ' . $AllowReference . ' 
                 AND ( SELECT 
                        CAST(
                                (
                                    CASE 
                                        WHEN pilgrim."master"."DOBInYears" IS NULL AND pilgrim."master"."DOB" IS NOT NULL THEN date_part(\'year\', Age(CAST(pilgrim."master"."DOB" AS TIMESTAMP)))
                                        WHEN pilgrim."master"."DOBInYears" IS NULL AND pilgrim."master"."DOB" IS NULL THEN 0
                                        ELSE pilgrim."master"."DOBInYears"
                                    END
                                )
                        AS INTEGER )
                        FROM pilgrim."master" WHERE pilgrim."master"."UID" = pilgrim."meta"."PilgrimUID"
                      ) > 10 ';
        $AdultsSubmittedPilgrimsData = $Crud->ExecuteSQL($AdultsSubmittedPilgrimsSQL);
        $TotalAdultsSubmittedPax = ((isset($AdultsSubmittedPilgrimsData[0]['TotalAdultPax']) && $AdultsSubmittedPilgrimsData[0]['TotalAdultPax'] != '') ? $AdultsSubmittedPilgrimsData[0]['TotalAdultPax'] : 0);

        $TotalNoOfBedsSQL = ' SELECT SUM( 
                                       CASE
                                           WHEN "LookupsOptions"."Name" = \'Quint Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 5 )
                                           WHEN "LookupsOptions"."Name" = \'Quad Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 4 )
                                           WHEN "LookupsOptions"."Name" = \'Triple Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 3 )
                                           WHEN "LookupsOptions"."Name" = \'Double Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 2 )
                                           WHEN "LookupsOptions"."Name" = \'Single Bed\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 1 )
                                           WHEN "LookupsOptions"."Name" = \'Sharing\' THEN ( CAST("AccommodationDetails"."NoOfBeds" AS INTEGER) * 1 )
                                       END
                                        ) AS "TotalVoucherBeds" 
                             FROM voucher."AccommodationDetails"
                             JOIN main."LookupsOptions" ON ( CAST("LookupsOptions"."UID" AS INTEGER) = CAST("AccommodationDetails"."RoomType" AS INTEGER) )
                             WHERE voucher."AccommodationDetails"."VoucherID" = ' . $VoucherUID . ' 
                              AND voucher."AccommodationDetails"."UID" IN 
                             ( SELECT voucher."AccommodationDetails"."UID"
                                 FROM voucher."AccommodationDetails" SubTable
                                WHERE SubTable."Hotel" = voucher."AccommodationDetails"."Hotel"
                                AND SubTable."City" = voucher."AccommodationDetails"."City"
                                AND SubTable."CheckIn" = voucher."AccommodationDetails"."CheckIn" 
                                AND SubTable."VoucherID" = voucher."AccommodationDetails"."VoucherID" 
                                AND SubTable."UID" = ' . $AllowReference . '
                             )';
        $TotalNoOfBedsData = $Crud->ExecuteSQL($TotalNoOfBedsSQL);
        $TotalNoOfBeds = ((isset($TotalNoOfBedsData[0]['TotalVoucherBeds']) && $TotalNoOfBedsData[0]['TotalVoucherBeds'] != '') ? $TotalNoOfBedsData[0]['TotalVoucherBeds'] : 0);

        $PilgrimsArray['ActivityAllowedPax'] = $TotalAllowedPax;
        $PilgrimsArray['ActivitySubmittedPax'] = $TotalSubmittedPax;
        $PilgrimsArray['ActivityAdultsSubmittedPax'] = $TotalAdultsSubmittedPax;
        $PilgrimsArray['TotalVoucherBeds'] = $TotalNoOfBeds;

        return $PilgrimsArray;
    }

    public
    function CheckVoucherAccommodationActivity($MainArray = array()){

        $Crud = new Crud(); $VoucherAccommodationIDS = '';
        $VoucherAccommodationIDSArray = $AccommodationActivitiesDataArray = array();

        $CityName = CityName($MainArray['City']);
        $RequestedStatus = ( ( trim($CityName) == 'Mecca' )? 'allow-htl-mecca' : ( ( trim($CityName) == 'Medina' )? 'allow-htl-medina' : 'allow-htl-jeddah' ) );

        $AccommodationSQL = ' SELECT voucher."AccommodationDetails"."UID"
                                   FROM voucher."AccommodationDetails"
                                WHERE "VoucherID" = '.$MainArray['VoucherID'].'
                                AND CAST("City" AS INTEGER) = CAST('.$MainArray['City'].' AS INTEGER)
                                AND CAST("Hotel" AS INTEGER) = CAST('.$MainArray['Hotel'].' AS INTEGER)
                                AND "CheckIn" = \''.date("Y-m-d", strtotime($MainArray['CheckIn'])).'\'
                                AND "CheckOut" = \''.date("Y-m-d", strtotime($MainArray['CheckOut'])).'\' ';
        $VoucherAccommodationData = $Crud->ExecuteSQL($AccommodationSQL);
        foreach ($VoucherAccommodationData as $VAD){
            $VoucherAccommodationIDSArray[] = $VAD['UID'];
        }
        $VoucherAccommodationIDSArray[] = 0;
        $VoucherAccommodationIDS = implode(',', $VoucherAccommodationIDSArray);

        if(count($VoucherAccommodationIDSArray) > 0){

            $SubmittedAccommodationActivitiesSQL = ' SELECT pilgrim."meta".* 
                 FROM pilgrim."meta"
                 WHERE pilgrim."meta"."AllowReference" IN ('.$VoucherAccommodationIDS.')
                  AND pilgrim."meta"."Option" = \'' . $RequestedStatus . '-status\'';
            $AccommodationActivitiesDataArray = $Crud->ExecuteSQL($SubmittedAccommodationActivitiesSQL);
        }

        return $AccommodationActivitiesDataArray;
    }

}
