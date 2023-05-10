<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Voucher;

class Groups extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public function GroupFormSummary($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $Main = new Main();
        $groupRecord = array();
        $groupRecord['GroupData'] = $records;

       /* $UmrahVisa = 0;
        if($records['Visa'] == 'Yes'){
            $UmrahVisa = $Main->Settings('package_umrah_key');
            $UmrahVisa = ( ( isset($UmrahVisa) && $UmrahVisa != '' && $UmrahVisa > 0 )? $UmrahVisa : 0 );
        }
        $SQL = 'SELECT packages."Meta"."Value"
                FROM  packages."Meta"
                WHERE packages."Meta"."Option" = \'' . $UmrahVisa . '\'
                AND "ReferenceType" = \'Package_Visa_Rates\'
                AND "ReferenceID" = \'' . $records['PackageID'] . '\' Limit 1';
        $visarecords = $Crud->ExecuteSQL($SQL);
        $groupRecord['VisaR'] = $visarecords[0]['Value'];*/

        $GroupVisaRate = 0;
        if($records['Visa'] == 'Yes'){
            $PilgrimsRecord = array(
                'Adults' => $records['NoOfPAX'],
                'Child' => $records['ChildPax'],
                'Infant' => $records['InfantPax']
            );
            $GroupVisaRate = $this->GetGroupVisaRateByPackageIDAndPax($records['PackageID'], $PilgrimsRecord, $UID);
        }
        $groupRecord['VisaR'] = ( ( isset($GroupVisaRate) && $GroupVisaRate != '' )? $GroupVisaRate : 0 );

        $SQL = 'SELECT packages."Packages"."Name"
                FROM  packages."Packages" 
                WHERE packages."Packages"."UID" = \'' . $records['PackageID'] . '\' 
                ';
        //echo $SQL;
        $Packagerecords = $Crud->ExecuteSQL($SQL);
        $groupRecord['Package'] = $Packagerecords[0]['Name'];


//       echo"<pre>"; print_r($HotelRecords); exit;

        if (isset($HotelRecords)) {

            $HotelCity = ((isset($HotelRecords['City']) && $HotelRecords['City'] != '') ? $HotelRecords['City'] : array());
            if (count($HotelCity) > 0) {

                //for ($a = 0; $a < count($HotelCity); $a++) {
                foreach ($HotelRecords['AmountPayable'] as $GroupHotels => $GroupHotelCity) {
                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }

                    $HotelRecord['City'] = $HotelRecords['City'][$GroupHotels];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$GroupHotels];
                    $HotelRecord['BRNType'] = $HotelRecords['BRNType'][$GroupHotels];
                    //$HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels][0];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$GroupHotels];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$GroupHotels];
                    //$HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels][0];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$GroupHotels])) ? $HotelRecords['AmountPayable'][$GroupHotels] : 0);
                    //echo '<pre>';print_r($HotelRecord);

                    $AmountHotelPayable = $HotelRecords['AmountHotelPayable'];

                    $NoOfBeds = $HotelRecords['NoOfBeds'];
                    $RoomType = $HotelRecords['RoomType'];

                    ///////////////// MULIT HOTEL
                    //echo "<pre>"; print_r($AmountHotelPayable); print_r($RoomType);
                    $MultiHotel = '';
                    foreach ($AmountHotelPayable[$GroupHotels] as $GroupHotelID => $GroupHotelRooms) {
                        $RoomTypeOption = $RoomType[$GroupHotels][$GroupHotelID];
                        $RoomQTY = $NoOfBeds[$GroupHotels][$GroupHotelID];
                        $AmountPayable = $AmountHotelPayable[$GroupHotels][$GroupHotelID];
                        if ($RoomType > 0)
                            $MultiHotel .= $RoomQTY . ' ' . OptionName($RoomTypeOption) . ' (' . Money($AmountPayable) . ')<br>';
                    }
                    //echo $MultiHotel.'<br>';
                    $HotelRecord['MultiHotelHTML'] = $MultiHotel;
                    $groupRecord['GroupAccommmodationDatas'][] = $HotelRecord;
                }
            }
        }
        //echo $html = view("group/view_group_summary", $groupRecord);exit();

        if (isset($TransportRecords)) {

            $TransportSectors = $TransportRecords['TransportSectors'];
            //echo '<pre>';print_r($TransportRecords);exit();
            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TransportData = array();
                    if ($UID == 0) {
                        $TransportData['GroupID'] = $recordID;
                    } else {
                        $TransportData['GroupID'] = $UID;
                    }
                    $TransportData['TransportSectors'] = $TransportRecords['TransportSectors'][$a];

                    $TransportData['Transport'] = TransportName($TransportRecords['Transport'][$a]);
                    $TransportData['BRNType'] = $TransportRecords['TransportBRNType'][$a];
                    $TransportData['NoOfPax'] = $TransportRecords['NoOfPax'][$a];
                    $TransportData['NoOfSeats'] = $TransportRecords['NoOfSeats'][$a];
                    $TransportData['TransportsRates'] = ((isset($TransportRecords['TransportsRates'][$a])) ? $TransportRecords['TransportsRates'][$a] : 0); //$TransportRecords['TransportRates'][$a];

                    $groupRecord['GroupTransportDatas'][] = $TransportData;
                }
            }
        }

        if (isset($ZiyaratRecords)) {

            $ZiyaratCity = $ZiyaratRecords['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    if ($UID == 0) {
                        $ZiyaratData['GroupID'] = $recordID;
                    } else {
                        $ZiyaratData['GroupID'] = $UID;
                    }
                    $ZiyaratData['ZiyaratCity'] = CityName($ZiyaratRecords['ZiyaratCity'][$a]);
                    $ZiyaratData['TransportRateZiyrat'] = $ZiyaratRecords['ZiyaratTransportRate'][$a];
                    $ZiyaratData['Ziyarat'] = ZiyaratName($ZiyaratRecords['Ziyarat'][$a]);
                    $ZiyaratData['ZiyaratTransport'] = TransportName($ZiyaratRecords['ZiyaratTransport'][$a]);
                    $ZiyaratData['ZiyaratNoOfPax'] = $ZiyaratRecords['ZiyaratNoOfPax'][$a];
                    $groupRecord['GroupZiyaratDatas'][] = $ZiyaratData;
                }
            }
        }

        $ServicesIDs = $ServicesID['ServicesID'];
        $VoucherServiceRate = $ServicesID['VoucherServiceRate'];
        if (!empty($ServicesIDs)) {

            foreach ($ServicesIDs as $ServiceID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['GroupID'] = $recordID;
                } else {
                    $Values['GroupID'] = $UID;
                }
                $Values['ServiceID'] = $ServiceID;
                if ($VoucherServiceRate > 0) {
                    $Values['ServiceRate'] = $VoucherServiceRate;
                }
//                else {
//                    $Values['ServiceRate'] = 0;
//                }

                $groupRecord['GroupServicesDatas'][] = $Values;
            }
        }


        echo $html = view("group/view_group_summary", $groupRecord);
    }

    public function GroupFormSubmit($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID, $Record)
    {

        $data = $this->data;

        $Crud = new Crud();
        $Main = new Main();
        $table = 'main."Groups"';

        /*$UmrahVisa = 0;
        if($records['Visa'] == 'Yes'){
            $UmrahVisa = $Main->Settings('package_umrah_key');
            $UmrahVisa = ( ( isset($UmrahVisa) && $UmrahVisa != '' && $UmrahVisa > 0 )? $UmrahVisa : 0 );
        }
        $SQL = 'SELECT packages."Meta"."Value"
                FROM  packages."Meta" 
                WHERE packages."Meta"."Option" = \'' . $UmrahVisa . '\' 
                AND "ReferenceType" = \'Package_Visa_Rates\' 
                AND "ReferenceID" = \'' . $records['PackageID'] . '\' Limit 1';
        $visarecords = $Crud->ExecuteSQL($SQL);
        if ($visarecords[0]['Value'] > 0) {
            $records['VisaRate'] = $visarecords[0]['Value'];
        } else {
            $records['VisaRate'] = 0;
        }*/
        $GroupVisaRate = 0;
        if($records['Visa'] == 'Yes'){
            $PilgrimsRecord = array(
                'Adults' => $records['NoOfPAX'],
                'Child' => $records['ChildPax'],
                'Infant' => $records['InfantPax']
            );
            $GroupVisaRate = $this->GetGroupVisaRateByPackageIDAndPax($records['PackageID'], $PilgrimsRecord, $UID);
        }
        $records['VisaRate'] = ( ( isset($GroupVisaRate) && $GroupVisaRate != '' )? $GroupVisaRate : 0 );


        if ($UID == 0) {
            $Crud->Track("Group", 'New Group "' . $records['FullName'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Group Successfully Added...";
        } else {
            $Crud->Track("Group", 'Group "' . $records['FullName'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Group Updated...";
        }



        if (isset($HotelRecords)) {
            $table = 'main."GroupHotel"';
            $HotelCity = ((isset($HotelRecords['City']) && $HotelRecords['City'] != '') ? $HotelRecords['City'] : array());

            if (count($HotelCity) > 0) {
                if (isset($HotelCity)) {
                    $SQL = 'DELETE FROM main."GroupHotelRooms"
                    WHERE "GroupHotelID" IN ( SELECT "UID" FROM main."GroupHotel" WHERE "GroupID" = \'' . $UID . '\' )';
                    //echo nl2br($SQL);
                    $Crud->ExecuteSQL($SQL);
                    $where = array("GroupID" => $UID);
                    $Crud->DeleteRecord('main."GroupHotel"', $where);

                }

                foreach ($HotelRecords['AmountPayable'] as $GroupHotels => $GroupHotelCity) {
                    $table = 'main."GroupHotel"';

                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }
                    //echo "---".$HotelRecords['City'][$GroupHotels];
                    $HotelRecord['City'] = $HotelRecords['City'][$GroupHotels];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$GroupHotels];
                    $HotelRecord['BRNType'] = $HotelRecords['BRNType'][$GroupHotels];
                    //$HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels][0];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$GroupHotels];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$GroupHotels];
                    //$HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels][0];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$GroupHotels])) ? $HotelRecords['AmountPayable'][$GroupHotels] : 0);

                    $HotelsGroupID = $Crud->AddRecord($table, $HotelRecord);
                    /////Add Group Hotel Rooms Type

                    $table = 'main."GroupHotelRooms"';
                    $AmountHotelPayable = $HotelRecords['AmountHotelPayable'];

                    $NoOfBeds = $HotelRecords['NoOfBeds'];
                    $RoomType = $HotelRecords['RoomType'];
                    foreach ($AmountHotelPayable[$GroupHotels] as $GroupHotelID => $GroupHotelRooms) {

                        $GroupHotelRoom = array();
                        $GroupHotelRoom['GroupHotelID'] = $HotelsGroupID;
                        $GroupHotelRoom['RoomType'] = $RoomType[$GroupHotels][$GroupHotelID];
                        $GroupHotelRoom['RoomQTY'] = $NoOfBeds[$GroupHotels][$GroupHotelID];
                        $GroupHotelRoom['AmountPayable'] = $AmountHotelPayable[$GroupHotels][$GroupHotelID];
                        $Crud->AddRecord($table, $GroupHotelRoom);
                    }


                }
                //exit();
            }


            // exit;
        }
        if (isset($TransportRecords)) {
            $table = 'main."GroupTransport"';
            $where = array("GroupID" => $UID);
            $Crud->DeleteRecord($table, $where);
            $TransportSectors = $TransportRecords['TransportSectors'];
            //echo '<pre>';print_r($TransportRecords);exit();
            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TransportData = array();
                    if ($UID == 0) {
                        $TransportData['GroupID'] = $recordID;
                    } else {
                        $TransportData['GroupID'] = $UID;
                    }
                    $TransportData['TransportSectors'] = $TransportRecords['TransportSectors'][$a];
                    $TransportData['Transport'] = $TransportRecords['Transport'][$a];
                    $TransportData['BRNType'] = $TransportRecords['BRNType'][$a];
                    $TransportData['NoOfPax'] = $TransportRecords['NoOfPax'][$a];
                    $TransportData['NoOfSeats'] = $TransportRecords['NoOfSeats'][$a];
                    $TransportData['TransportsRates'] = ((isset($TransportRecords['TransportsRates'][$a])) ? $TransportRecords['TransportsRates'][$a] : 0); //$TransportRecords['TransportRates'][$a];

                    $Crud->AddRecord($table, $TransportData);
                }
            }
        }
        if (isset($ZiyaratRecords)) {
            $table = 'main."GroupZiyarat"';
            $where = array("GroupID" => $UID);
            $Crud->DeleteRecord('main."GroupZiyarat"', $where);
            $ZiyaratCity = $ZiyaratRecords['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    if ($UID == 0) {
                        $ZiyaratData['GroupID'] = $recordID;
                    } else {
                        $ZiyaratData['GroupID'] = $UID;
                    }
                    $ZiyaratData['ZiyaratCity'] = $ZiyaratRecords['ZiyaratCity'][$a];
                    $ZiyaratData['TransportRateZiyrat'] = $ZiyaratRecords['ZiyaratTransportRate'][$a];
                    $ZiyaratData['Ziyarat'] = $ZiyaratRecords['Ziyarat'][$a];
                    $ZiyaratData['ZiyaratTransport'] = $ZiyaratRecords['ZiyaratTransport'][$a];
                    $ZiyaratData['ZiyaratNoOfPax'] = $ZiyaratRecords['ZiyaratNoOfPax'][$a];
                    $Crud->AddRecord($table, $ZiyaratData);
                }
            }
        }

        $ServicesIDs = $ServicesID['ServicesID'];
        $VoucherServiceRate = $ServicesID['VoucherServiceRate'];
        if (!empty($ServicesIDs)) {
            if (isset($ServicesIDs)) {
                $where = array("GroupID" => $UID);
                $Crud->DeleteRecord('main."GroupServices"', $where);
            }
            foreach ($ServicesIDs as $ServiceID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['GroupID'] = $recordID;
                } else {
                    $Values['GroupID'] = $UID;
                }
                $Values['ServiceID'] = $ServiceID;
                if ($VoucherServiceRate > 0) {
                    $Values['ServiceRate'] = $VoucherServiceRate;
                }
//                else {
//                    $Values['ServiceRate'] = 0;
//                }

                $Crud->AddRecord('main."GroupServices"', $Values);
            }
        }

        /** Group Visa Rates Segment Start */
        $GroupUID = 0;
        if($UID == 0){
            $GroupUID = $recordID;
        }else{
            $GroupUID = $UID;
        }
        if( isset($records['Visa']) && $records['Visa'] == 'Yes' ){
            $this->AddGroupVisaRate( $records['WebsiteDomain'], $GroupUID, $records['PackageID'], $Record['GroupSubmittedPackageUID'] );
        }else{
            $Crud->DeleteRecord('main."GroupVisaRate"', array('GroupUID' => $GroupUID));
        }
        /** Group Visa Rates Segment End */


        echo json_encode($response);
    }

    public function GroupPilgrimFormSummary($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $groupRecord = array();
        $groupRecord['GroupData'] = $records;

        $SQL = 'SELECT packages."Meta"."Value"
                FROM  packages."Meta" 
                WHERE packages."Meta"."Option" = \'' . $records['Visa'] . '\' 
                AND "ReferenceType" = \'Package_Visa_Rates\' 
                AND "ReferenceID" = \'' . $records['PackageID'] . '\' Limit 1';
        //echo $SQL;
        $visarecords = $Crud->ExecuteSQL($SQL);

        $groupRecord['VisaR'] = $visarecords[0]['Value'];
        $SQL = 'SELECT packages."Packages"."Name"
                FROM  packages."Packages" 
                WHERE packages."Packages"."UID" = \'' . $records['PackageID'] . '\' 
                ';
        //echo $SQL;
        $Packagerecords = $Crud->ExecuteSQL($SQL);
        $groupRecord['Package'] = $Packagerecords[0]['Name'];


        /*if (isset($HotelRecords)) {

            $HotelCity = $HotelRecords['City'];
            if (!empty($HotelCity[0])) {

                for ($a = 0; $a < count($HotelCity); $a++) {
                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }

                    $HotelRecord['City'] = $HotelRecords['City'][$a];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$a];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$a];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$a];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$a];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$a];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$a])) ? $HotelRecords['AmountPayable'][$a] : 0);
                    $groupRecord['GroupAccommmodationDatas'][] = $HotelRecord;
                }
            }


        }*/
        if (isset($HotelRecords)) {

            $HotelCity = ((isset($HotelRecords['City']) && $HotelRecords['City'] != '') ? $HotelRecords['City'] : array());
            if (count($HotelCity) > 0) {

                //for ($a = 0; $a < count($HotelCity); $a++) {
                foreach ($HotelRecords['AmountPayable'] as $GroupHotels => $GroupHotelCity) {
                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }

                    $HotelRecord['City'] = $HotelRecords['City'][$GroupHotels];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$GroupHotels];
                    $HotelRecord['BRNType'] = $HotelRecords['BRNType'][$GroupHotels];
                    //$HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels][0];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$GroupHotels];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$GroupHotels];
                    //$HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels][0];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$GroupHotels])) ? $HotelRecords['AmountPayable'][$GroupHotels] : 0);
                    //echo '<pre>';print_r($HotelRecord);

                    $AmountHotelPayable = $HotelRecords['AmountHotelPayable'];

                    $NoOfBeds = $HotelRecords['NoOfBeds'];
                    $RoomType = $HotelRecords['RoomType'];

                    ///////////////// MULIT HOTEL
                    //echo "<pre>"; print_r($AmountHotelPayable); print_r($RoomType);
                    $MultiHotel = '';
                    foreach ($AmountHotelPayable[$GroupHotels] as $GroupHotelID => $GroupHotelRooms) {
                        $RoomTypeOption = $RoomType[$GroupHotels][$GroupHotelID];
                        $RoomQTY = $NoOfBeds[$GroupHotels][$GroupHotelID];
                        $AmountPayable = $AmountHotelPayable[$GroupHotels][$GroupHotelID];
                        if ($RoomType > 0)
                            $MultiHotel .= $RoomQTY . ' ' . OptionName($RoomTypeOption) . ' (' . Money($AmountPayable) . ')<br>';
                    }
                    //echo $MultiHotel.'<br>';
                    $HotelRecord['MultiHotelHTML'] = $MultiHotel;
                    $groupRecord['GroupAccommmodationDatas'][] = $HotelRecord;
                }
            }
        }
        //echo $html = view("group/view_group_summary", $groupRecord);exit();

        if (isset($TransportRecords)) {

            $TransportSectors = $TransportRecords['TransportSectors'];
            //echo '<pre>';print_r($TransportRecords);exit();
            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TransportData = array();
                    if ($UID == 0) {
                        $TransportData['GroupID'] = $recordID;
                    } else {
                        $TransportData['GroupID'] = $UID;
                    }
                    $TransportData['TransportSectors'] = $TransportRecords['TransportSectors'][$a];

                    $TransportData['Transport'] = TransportName($TransportRecords['Transport'][$a]);
                    $TransportData['BRNType'] = $TransportRecords['TransportBRNType'][$a];
                    $TransportData['NoOfPax'] = $TransportRecords['NoOfPax'][$a];
                    $TransportData['NoOfSeats'] = $TransportRecords['NoOfSeats'][$a];
                    $TransportData['TransportsRates'] = ((isset($TransportRecords['TransportsRates'][$a])) ? $TransportRecords['TransportsRates'][$a] : 0); //$TransportRecords['TransportRates'][$a];

                    $groupRecord['GroupTransportDatas'][] = $TransportData;
                }
            }
        }

        if (isset($ZiyaratRecords)) {

            $ZiyaratCity = $ZiyaratRecords['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    if ($UID == 0) {
                        $ZiyaratData['GroupID'] = $recordID;
                    } else {
                        $ZiyaratData['GroupID'] = $UID;
                    }
                    $ZiyaratData['ZiyaratCity'] = CityName($ZiyaratRecords['ZiyaratCity'][$a]);
                    $ZiyaratData['TransportRateZiyrat'] = $ZiyaratRecords['ZiyaratTransportRate'][$a];
                    $ZiyaratData['Ziyarat'] = ZiyaratName($ZiyaratRecords['Ziyarat'][$a]);
                    $ZiyaratData['ZiyaratTransport'] = TransportName($ZiyaratRecords['ZiyaratTransport'][$a]);
                    $ZiyaratData['ZiyaratNoOfPax'] = $ZiyaratRecords['ZiyaratNoOfPax'][$a];
                    $groupRecord['GroupZiyaratDatas'][] = $ZiyaratData;
                }
            }
        }

        $ServicesIDs = $ServicesID['ServicesID'];
        $VoucherServiceRate = $ServicesID['VoucherServiceRate'];
        if (!empty($ServicesIDs)) {

            foreach ($ServicesIDs as $ServiceID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['GroupID'] = $recordID;
                } else {
                    $Values['GroupID'] = $UID;
                }
                $Values['ServiceID'] = $ServiceID;
                if ($VoucherServiceRate > 0) {
                    $Values['ServiceRate'] = $VoucherServiceRate;
                }
//                else {
//                    $Values['ServiceRate'] = 0;
//                }

                $groupRecord['GroupServicesDatas'][] = $Values;
            }
        }


        echo $html = view("pilgrim/view_group_pilgrim_summary", $groupRecord);
    }

    public function GroupPilgrimFormSubmit($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID)
    {
        $data = $this->data;
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $table = 'main."Groups"';
        $PilgrimsRecords = $records['Pilgrims'];
//echo '<pre>';print_r($PilgrimsRecords);
//echo count($PilgrimsRecords['FirstName']);
//exit();
        unset($records['Pilgrims']);
        $SQL = 'SELECT packages."Meta"."Value"
                FROM  packages."Meta" 
                WHERE packages."Meta"."Option" = \'' . $records['Visa'] . '\' 
                AND "ReferenceType" = \'Package_Visa_Rates\' 
                AND "ReferenceID" = \'' . $records['PackageID'] . '\' Limit 1';
        //echo $SQL;
        $visarecords = $Crud->ExecuteSQL($SQL); //print_r($visarecords);
        $records['VisaRate'] = $visarecords[0]['Value'];

        if ($UID == 0) {
            $Crud->Track("Group", 'New Group "' . $records['FullName'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Group Successfully Added...";
        } else {
            $Crud->Track("Group", 'Group "' . $records['FullName'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Group Updated...";
        }
        /////Pilgrim
        if (isset($PilgrimsRecords)) {
            if (!empty($PilgrimsRecords)) {
                for ($a = 0; $a < count($PilgrimsRecords['FirstName']); $a++) {
                    $PilgrimRecord = array();
                    $table = 'pilgrim."master"';
                    if ($UID == 0) {
                        $PilgrimRecord['GroupUID'] = $recordID;
                    } else {
                        $PilgrimRecord['GroupUID'] = $UID;
                    }
                    $AgentID = $records['AgentID'];
                    if ($PilgrimsRecords['FirstName'][$a] != '') {
                        //echo $PilgrimsRecords['FirstName'][$a];
                        $PilgrimRecord['AgentUID'] = $AgentID;
                        $PilgrimRecord['Title'] = $PilgrimsRecords['Title'][$a];
                        $PilgrimRecord['FirstName'] = $PilgrimsRecords['FirstName'][$a];
                        $PilgrimRecord['MiddleName'] = $PilgrimsRecords['MiddleName'][$a];
                        $PilgrimRecord['LastName'] = $PilgrimsRecords['LastName'][$a];
                        $PilgrimRecord['Gender'] = $PilgrimsRecords['Gender'][$a];
                        $PilgrimRecord['Relation'] = $PilgrimsRecords['Relation'][$a];
                        $PilgrimRecord['DOB'] = $PilgrimsRecords['DOB'][$a];
                        $PilgrimRecord['Country'] = $PilgrimsRecords['Countries'][$a];
                        $PilgrimRecord['PassportNumber'] = $PilgrimsRecords['PassportNumber'][$a];
                        $PilgrimRecord['Nationality'] = $PilgrimsRecords['Nationality'][$a];
                        $PilgrimRecord['PassportExpiryDate'] = $PilgrimsRecords['PassportExpiryDate'][$a];
                        $PilgrimRecord['CitizenShipNumber'] = $PilgrimsRecords['CitizenShipNumber'][$a];
                        $PilgrimRecord['WebsiteDomain'] = $session['domainid'];
                        $Crud->AddRecord($table, $PilgrimRecord);
                    }
                }
            }
        }

        ///
        /*if (isset($HotelRecords)) {
            $table = 'main."GroupHotel"';
            $HotelCity = $HotelRecords['City'];
            if (!empty($HotelCity[0])) {
                if (isset($HotelCity)) {
                    $where = array("GroupID" => $UID);
                    $Crud->DeleteRecord('main."GroupHotel"', $where);
                }
                for ($a = 0; $a < count($HotelCity); $a++) {
                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }

                    $HotelRecord['City'] = $HotelRecords['City'][$a];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$a];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$a];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$a];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$a];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$a];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$a])) ? $HotelRecords['AmountPayable'][$a] : 0);
                    $Crud->AddRecord($table, $HotelRecord);
                }
            }

        }*/
        if (isset($HotelRecords)) {
            $table = 'main."GroupHotel"';
            $HotelCity = ((isset($HotelRecords['City']) && $HotelRecords['City'] != '') ? $HotelRecords['City'] : array());

            if (count($HotelCity) > 0) {
                if (isset($HotelCity)) {
                    $SQL = 'DELETE FROM main."GroupHotelRooms"
                    WHERE "GroupHotelID" IN ( SELECT "UID" FROM main."GroupHotel" WHERE "GroupID" = \'' . $UID . '\' )';
                    //echo nl2br($SQL);
                    $Crud->ExecuteSQL($SQL);
                    $where = array("GroupID" => $UID);
                    $Crud->DeleteRecord('main."GroupHotel"', $where);

                }

                foreach ($HotelRecords['AmountPayable'] as $GroupHotels => $GroupHotelCity) {
                    $table = 'main."GroupHotel"';

                    $HotelRecord = array();
                    if ($UID == 0) {
                        $HotelRecord['GroupID'] = $recordID;
                    } else {
                        $HotelRecord['GroupID'] = $UID;
                    }
                    //echo "---".$HotelRecords['City'][$GroupHotels];
                    $HotelRecord['City'] = $HotelRecords['City'][$GroupHotels];
                    $HotelRecord['Hotel'] = $HotelRecords['Hotel'][$GroupHotels];
                    $HotelRecord['BRNType'] = $HotelRecords['BRNType'][$GroupHotels];
                    //$HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels];
                    $HotelRecord['RoomType'] = $HotelRecords['RoomType'][$GroupHotels][0];
                    $HotelRecord['CheckIn'] = $HotelRecords['CheckIn'][$GroupHotels];
                    $HotelRecord['CheckOut'] = $HotelRecords['CheckOut'][$GroupHotels];
                    //$HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels];
                    $HotelRecord['NoOfBeds'] = $HotelRecords['NoOfBeds'][$GroupHotels][0];
                    $HotelRecord['AmountPayable'] = ((isset($HotelRecords['AmountPayable'][$GroupHotels])) ? $HotelRecords['AmountPayable'][$GroupHotels] : 0);

                    $HotelsGroupID = $Crud->AddRecord($table, $HotelRecord);
                    /////Add Group Hotel Rooms Type

                    $table = 'main."GroupHotelRooms"';
                    $AmountHotelPayable = $HotelRecords['AmountHotelPayable'];

                    $NoOfBeds = $HotelRecords['NoOfBeds'];
                    $RoomType = $HotelRecords['RoomType'];
                    foreach ($AmountHotelPayable[$GroupHotels] as $GroupHotelID => $GroupHotelRooms) {

                        $GroupHotelRoom = array();
                        $GroupHotelRoom['GroupHotelID'] = $HotelsGroupID;
                        $GroupHotelRoom['RoomType'] = $RoomType[$GroupHotels][$GroupHotelID];
                        $GroupHotelRoom['RoomQTY'] = $NoOfBeds[$GroupHotels][$GroupHotelID];
                        $GroupHotelRoom['AmountPayable'] = $AmountHotelPayable[$GroupHotels][$GroupHotelID];
                        $Crud->AddRecord($table, $GroupHotelRoom);
                    }


                }
                //exit();
            }


            // exit;
        }

        if (isset($TransportRecords)) {
            $table = 'main."GroupTransport"';
            $where = array("GroupID" => $UID);
            $Crud->DeleteRecord($table, $where);
            $TransportSectors = $TransportRecords['TransportSectors'];
            //echo '<pre>';print_r($TransportRecords);exit();
            if (!empty($TransportSectors[0])) {
                for ($a = 0; $a < count($TransportSectors); $a++) {
                    $TransportData = array();
                    if ($UID == 0) {
                        $TransportData['GroupID'] = $recordID;
                    } else {
                        $TransportData['GroupID'] = $UID;
                    }
                    $TransportData['TransportSectors'] = $TransportRecords['TransportSectors'][$a];
                    $TransportData['Transport'] = $TransportRecords['Transport'][$a];
                    $TransportData['BRNType'] = $TransportRecords['BRNType'][$a];
                    $TransportData['NoOfPax'] = $TransportRecords['NoOfPax'][$a];
                    $TransportData['NoOfSeats'] = $TransportRecords['NoOfSeats'][$a];
                    $TransportData['TransportsRates'] = ((isset($TransportRecords['TransportsRates'][$a])) ? $TransportRecords['TransportsRates'][$a] : 0); //$TransportRecords['TransportRates'][$a];

                    $Crud->AddRecord($table, $TransportData);
                }
            }
        }

        if (isset($ZiyaratRecords)) {
            $table = 'main."GroupZiyarat"';
            $where = array("GroupID" => $UID);
            $Crud->DeleteRecord('main."GroupZiyarat"', $where);
            $ZiyaratCity = $ZiyaratRecords['ZiyaratCity'];
            if (!empty($ZiyaratCity[0])) {
                for ($a = 0; $a < count($ZiyaratCity); $a++) {
                    $ZiyaratData = array();
                    if ($UID == 0) {
                        $ZiyaratData['GroupID'] = $recordID;
                    } else {
                        $ZiyaratData['GroupID'] = $UID;
                    }
                    $ZiyaratData['ZiyaratCity'] = $ZiyaratRecords['ZiyaratCity'][$a];
                    $ZiyaratData['TransportRateZiyrat'] = $ZiyaratRecords['ZiyaratTransportRate'][$a];
                    $ZiyaratData['Ziyarat'] = $ZiyaratRecords['Ziyarat'][$a];
                    $ZiyaratData['ZiyaratTransport'] = $ZiyaratRecords['ZiyaratTransport'][$a];
                    $ZiyaratData['ZiyaratNoOfPax'] = $ZiyaratRecords['ZiyaratNoOfPax'][$a];
                    $Crud->AddRecord($table, $ZiyaratData);
                }
            }
        }

        $ServicesIDs = $ServicesID['ServicesID'];
        $VoucherServiceRate = $ServicesID['VoucherServiceRate'];
        if (!empty($ServicesIDs)) {
            if (isset($ServicesIDs)) {
                $where = array("GroupID" => $UID);
                $Crud->DeleteRecord('main."GroupServices"', $where);
            }
            foreach ($ServicesIDs as $ServiceID) {
                $Values = array();
                if ($UID == 0) {
                    $Values['GroupID'] = $recordID;
                } else {
                    $Values['GroupID'] = $UID;
                }
                $Values['ServiceID'] = $ServiceID;
                if ($VoucherServiceRate > 0) {
                    $Values['ServiceRate'] = $VoucherServiceRate;
                }
//                else {
//                    $Values['ServiceRate'] = 0;
//                }

                $Crud->AddRecord('main."GroupServices"', $Values);
            }
        }


        echo json_encode($response);
    }

    public
    function  ListGroups($Status = '')
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $SQL = '';
        $SQL .= 'SELECT "main"."Groups".*,
"main"."Agents"."FullName" AS "Agentname",
main."Countries"."Name" as "CountryName",
main."Agents"."Type" AS "IATAType",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupHotel"
LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")

LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
where main."GroupHotel"."GroupID" = "main"."Groups"."UID"

) AS "HotelCategory",
(select string_agg(
 concat(

main."GroupHotelRooms"."RoomQTY",
(case when main."LookupsOptions"."Name"= \'Sharing\' then \' Beds\' end),
(case when main."LookupsOptions"."Name"!= \'Sharing\' then \' Rooms\' end)
), 
\',\'
)
FROM main."GroupHotelRooms"
LEFT JOIN main."GroupHotel" ON (main."GroupHotel"."UID" = main."GroupHotelRooms"."GroupHotelID")
LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")

LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=main."GroupHotelRooms"."RoomType"
where main."GroupHotel"."GroupID" = "main"."Groups"."UID"

) AS "NoOfRoomsBeds",

( 
select string_agg("RoomData", \'$\') from (
select
    concat(
        packages."Hotels"."Name", \'|\',
        string_agg(
        concat(
            main."GroupHotelRooms"."RoomQTY", \' \', main."LookupsOptions"."Name",
            (case when main."LookupsOptions"."Name"= \'Sharing\' then \' Beds\' end),
            (case when main."LookupsOptions"."Name"!= \'Sharing\' then \' Rooms\' end)
        ), \', \')
        , \'|\',
        
        sum(case 
        when main."LookupsOptions"."Name"= \'Sharing\' then main."GroupHotelRooms"."RoomQTY"
        when main."LookupsOptions"."Name"!= \'Sharing\' then 0 
        end )::numeric, \'|\',
        
        sum(case 
        when main."LookupsOptions"."Name"= \'Sharing\' then 0 
        when main."LookupsOptions"."Name"!= \'Sharing\' then main."GroupHotelRooms"."RoomQTY" 
        end )::numeric 
    ) as "RoomData"
FROM main."GroupHotelRooms"
LEFT JOIN main."GroupHotel" ON (main."GroupHotel"."UID" = main."GroupHotelRooms"."GroupHotelID")
LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=main."GroupHotelRooms"."RoomType"
where main."GroupHotel"."GroupID" = "main"."Groups"."UID" 
Group by packages."Hotels"."Name" ) as "SubQuery1"

) AS "ROOMSHTMLSTRING",

(select
string_agg(concat(TO_CHAR(main."GroupHotel"."CheckIn" :: DATE, \'dd Mon yyyy\'),\' - \', TO_CHAR(main."GroupHotel"."CheckOut" :: DATE, \'dd Mon yyyy\'),\' (\',main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date,\' Nights)\' ), \'<br>\')
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Mecca\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
) AS "MeccaNights",

(select
string_agg(concat(TO_CHAR(main."GroupHotel"."CheckIn" :: DATE, \'dd Mon yyyy\'),\' - \', TO_CHAR(main."GroupHotel"."CheckOut" :: DATE, \'dd Mon yyyy\'),\' (\',main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date,\' Nights)\' ), \'<br>\')
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Medina\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
) AS "MedinaNights",

(select
string_agg(concat(TO_CHAR(main."GroupHotel"."CheckIn" :: DATE, \'dd Mon yyyy\'),\' - \', TO_CHAR(main."GroupHotel"."CheckOut" :: DATE, \'dd Mon yyyy\'),\' (\',main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date,\' Nights)\' ), \'<br>\')
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Jeddah\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
) AS "JeddahNights",

(select
sum(main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date) as "TotalNights"
FROM main."GroupHotel"

where main."GroupHotel"."GroupID" = "main"."Groups"."UID"
) AS "TotalNights",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupTransport"
LEFT JOIN packages."Transport" ON (packages."Transport"."UID" = main."GroupTransport"."Transport")
LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Transport"."Type"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID") AS "TransportType",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupTransport"
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=main."GroupTransport"."TransportSectors"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID") AS "Sector",

(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON (packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=packages."ServiceRate"."ServiceUID"
where main."GroupServices"."GroupID" = "main"."Groups"."UID") AS "OtherServices",

sale_agent."Agents"."FullName" as "ReferenceName",

(SELECT sum( (main."GroupTransport"."TransportsRates")) AS "totalTransportRates"
FROM main."GroupTransport"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID"
group by main."GroupTransport"."GroupID"),

(SELECT sum(main."GroupHotel"."AmountPayable") AS "totalHotelRates"
FROM main."GroupHotel"
where main."GroupHotel"."GroupID"="main"."Groups"."UID"
group by main."GroupHotel"."GroupID" ),



(SELECT sum(main."Groups"."NoOfPAX" * packages."ServiceRate"."Rate") AS "totalServiceRates"
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON ( packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON ( main."LookupsOptions"."UID" = packages."ServiceRate"."ServiceUID")
where main."GroupServices"."GroupID"="main"."Groups"."UID"
group by main."GroupServices"."GroupID" ),

(SELECT sum(main."GroupZiyarat"."TransportRateZiyrat" * main."GroupZiyarat"."ZiyaratNoOfPax") AS "TotalZiyaratRate"
FROM main."GroupZiyarat"

where main."GroupZiyarat"."GroupID"="main"."Groups"."UID"
group by main."GroupZiyarat"."GroupID" ),
(select (select sum(transportselect.transportratetotal) as outertransport from  
(

SELECT COALESCE(sum( (main."GroupTransport"."TransportsRates")), 0) as transportratetotal
FROM main."GroupTransport"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID"
group by main."GroupTransport"."GroupID"
union
select -0)  as transportselect)+

(select sum(hotelselect.hoteltotal) as outerhotel from  
(SELECT sum(main."GroupHotel"."AmountPayable")  as hoteltotal
FROM main."GroupHotel"
where main."GroupHotel"."GroupID"="main"."Groups"."UID"
group by main."GroupHotel"."GroupID"
union
select -0)  as hotelselect )+
(select sum(servicerateselect.servicerateratetotal) as outerservicerate from  
(

SELECT COALESCE(sum(main."Groups"."NoOfPAX" * packages."ServiceRate"."Rate"), 0) as servicerateratetotal
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON ( packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON ( main."LookupsOptions"."UID" = packages."ServiceRate"."ServiceUID")
where main."GroupServices"."GroupID"="main"."Groups"."UID"
group by main."GroupServices"."GroupID"
union
select -0)  as servicerateselect )
+

(select sum(TransportRateZiyratselect.TransportRateZiyrattotal) as outerTransportRateZiyrat from  
(

SELECT sum(main."GroupZiyarat"."TransportRateZiyrat" * main."GroupZiyarat"."ZiyaratNoOfPax") as TransportRateZiyrattotal
FROM main."GroupZiyarat"

where main."GroupZiyarat"."GroupID"="main"."Groups"."UID"
group by main."GroupZiyarat"."GroupID" 
union all
select -0)  as TransportRateZiyratselect
)
+(SELECT main."Groups"."NoOfPAX" * main."Groups"."VisaRate" AS "TotalVisaRate")) AS "GrandTotal"




FROM "main"."Groups"
LEFT JOIN "main"."Agents" ON "main"."Agents"."UID" = "main"."Groups"."AgentID"
LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"

WHERE "main"."Groups"."Archive" = 0
AND "main"."Groups"."Status"=\'' . $Status . '\' ';

        /** Filters Start */
        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['group_code']) && trim($_POST['group_code']) != '') {
            $SQL .= ' AND main."Groups"."WTUCode" = \'' . trim($_POST['group_code']) . '\' ';
        }

        if (isset($_POST['group_name']) && trim($_POST['group_name']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE \'%' . strtolower(trim($_POST['group_name'])) . '%\' ';
        }

        if (isset($_POST['create_start_date']) && $_POST['create_start_date'] != '' && isset($_POST['create_end_date']) && $_POST['create_end_date'] != '') {
            $SQL .= ' AND  main."Groups"."SystemDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['create_start_date'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($_POST['create_end_date'])) . ' 23:59:59\' ';
        }
        /** Filters End */

        if (isset($session['mis_type']) && $session['mis_type'] == 'other'
            && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND main."Agents"."UID" IN (' . $AgentUIDS . ') ';
        }
        $SQL .= ' ORDER BY "main"."Groups"."FullName" ASC';

        //echo nl2br($SQL);exit();
        // $records = $Crud->ExecuteSQL($SQL);
        return $SQL;


    }

    public
    function ListDeletedGroups()
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $SQL = '';
        $SQL .= 'SELECT "main"."Groups".*,
"main"."Agents"."FullName" AS "Agentname",
main."Countries"."Name" as "CountryName",
main."Agents"."Type" AS "IATAType",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupHotel"
LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")

LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
where main."GroupHotel"."GroupID" = "main"."Groups"."UID"

) AS "HotelCategory",
(select
sum(main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date) as "TotalNights"
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Mecca\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
group by main."Cities"."Name") AS "MeccaNights",

(select
sum(main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date) as "TotalNights"
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Medina\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
group by main."Cities"."Name") AS "MedinaNights",

(select
sum(main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date) as "TotalNights"
FROM main."GroupHotel"
LEFT JOIN main."Cities" ON (cast(main."GroupHotel"."City" as int) = cast(main."Cities"."UID" as int))
WHERE main."Cities"."Name" = \'Jeddah\'
and main."GroupHotel"."GroupID" = "main"."Groups"."UID"
group by main."Cities"."Name") AS "JeddahNights",

(select
sum(main."GroupHotel"."CheckOut"::date - main."GroupHotel"."CheckIn"::date) as "TotalNights"
FROM main."GroupHotel"

where main."GroupHotel"."GroupID" = "main"."Groups"."UID"
) AS "TotalNights",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupTransport"
LEFT JOIN packages."Transport" ON (packages."Transport"."UID" = main."GroupTransport"."Transport")
LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Transport"."Type"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID") AS "TransportType",
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupTransport"
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=main."GroupTransport"."TransportSectors"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID") AS "Sector",

(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON (packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=packages."ServiceRate"."ServiceUID"
where main."GroupServices"."GroupID" = "main"."Groups"."UID") AS "OtherServices",

sale_agent."Agents"."FullName" as "ReferenceName",

(SELECT sum( (main."GroupTransport"."TransportsRates")) AS "totalTransportRates"
FROM main."GroupTransport"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID"
group by main."GroupTransport"."GroupID"),

(SELECT sum(main."GroupHotel"."AmountPayable") AS "totalHotelRates"
FROM main."GroupHotel"
where main."GroupHotel"."GroupID"="main"."Groups"."UID"
group by main."GroupHotel"."GroupID" ),


(SELECT sum(main."Groups"."NoOfPAX" * packages."ServiceRate"."Rate") AS "totalServiceRates"
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON ( packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON ( main."LookupsOptions"."UID" = packages."ServiceRate"."ServiceUID")
where main."GroupServices"."GroupID"="main"."Groups"."UID"
group by main."GroupServices"."GroupID" ),

(SELECT sum(main."GroupZiyarat"."TransportRateZiyrat" * main."GroupZiyarat"."ZiyaratNoOfPax") AS "TotalZiyaratRate"
FROM main."GroupZiyarat"

where main."GroupZiyarat"."GroupID"="main"."Groups"."UID"
group by main."GroupZiyarat"."GroupID" ),
(select (SELECT sum( (main."GroupTransport"."TransportsRates"))
FROM main."GroupTransport"
where main."GroupTransport"."GroupID" = "main"."Groups"."UID"
group by main."GroupTransport"."GroupID")+

(SELECT sum(main."GroupHotel"."AmountPayable")
FROM main."GroupHotel"
where main."GroupHotel"."GroupID"="main"."Groups"."UID"
group by main."GroupHotel"."GroupID" )+


(SELECT sum(main."Groups"."NoOfPAX" * packages."ServiceRate"."Rate")
FROM main."GroupServices"
LEFT JOIN packages."ServiceRate" ON ( packages."ServiceRate"."UID" = main."GroupServices"."ServiceID")
LEFT JOIN main."LookupsOptions" ON ( main."LookupsOptions"."UID" = packages."ServiceRate"."ServiceUID")
where main."GroupServices"."GroupID"="main"."Groups"."UID"
group by main."GroupServices"."GroupID" )+

(SELECT sum(main."GroupZiyarat"."TransportRateZiyrat" * main."GroupZiyarat"."ZiyaratNoOfPax")
FROM main."GroupZiyarat"

where main."GroupZiyarat"."GroupID"="main"."Groups"."UID"
group by main."GroupZiyarat"."GroupID" )+(SELECT main."Groups"."NoOfPAX" * main."Groups"."VisaRate" AS "TotalVisaRate")) AS "GrandTotal"





FROM "main"."Groups"
LEFT JOIN "main"."Agents" ON "main"."Agents"."UID" = "main"."Groups"."AgentID"
LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"

WHERE "main"."Groups"."Archive" = 1 ';

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }
        $SQL .= 'ORDER BY "main"."Groups"."FullName" ASC';

//        echo nl2br($SQL);
//        exit();
        $recordss = $Crud->ExecuteSQL($SQL);
        return $recordss;

//        $Crud = new Crud();
//        $table = 'main."Groups"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;


    }

    public
    function ListDeletedGroupsssssssss()
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."Groups".*, "main"."Agents"."FullName" as agentname
                FROM "main"."Groups"
                LEFT JOIN "main"."Agents" ON "main"."Agents"."UID" = "main"."Groups"."AgentID"
                WHERE "main"."Groups"."Archive" = 1 
                ORDER BY  "main"."Groups"."FullName" ASC
                ';
//        echo $SQL;
        $recordss = $Crud->ExecuteSQL($SQL);
        return $recordss;

//        $Crud = new Crud();
//        $table = 'main."Groups"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }

    public
    function ListGroupPilgrims($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT "main"."Groups".*, "pilgrim"."master"."FirstName" as PilgrimName, "pilgrim"."mofa"."MOFANumber" as MofaNumber, "pilgrim"."visa"."VisaNumber" as VisaNumber
                FROM "main"."Groups"
                INNER JOIN "pilgrim"."master"  ON "pilgrim"."master"."GroupUID" = "main"."Groups"."UID"
                INNER JOIN "pilgrim"."mofa"  ON "pilgrim"."mofa"."PilgrimID" = "pilgrim"."master"."UID"
                LEFT JOIN "pilgrim"."visa"  ON "pilgrim"."visa"."PilgrimID" = "pilgrim"."master"."UID"
                WHERE "main"."Groups"."UID" = ' . $ID . ' ';

//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;

    }

    public
    function CountGroupPilgrims($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT "main"."Groups".*, "pilgrim"."master"."FirstName" as PilgrimName
                FROM "main"."Groups"
                INNER JOIN "pilgrim"."master"  ON "pilgrim"."master"."GroupUID" = "main"."Groups"."UID"
                WHERE "main"."Groups"."UID" = ' . $ID . ' ';

//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;

    }

    public
    function ListGroupDetail($ID)
    {
//        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT "main"."Groups".*, "main"."Agents"."FullName" as agentname
                FROM "main"."Groups"
                JOIN "main"."Agents" ON "main"."Agents"."UID" = "main"."Groups"."AgentID"
                WHERE "main"."Groups"."UID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }
    public
    function ListAllGroups()
    {
//        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT "main"."Groups".*
                FROM "main"."Groups"
                 WHERE "main"."Groups"."Archive" = 0 ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
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
    function GroupServiceData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."GroupServices"';
        $where = array("GroupID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }


    public
    function ListGroupHotelDetail($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."GroupHotel".* FROM "main"."GroupHotel"
                WHERE "main"."GroupHotel"."GroupID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListGroupHotels($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."GroupHotelRooms".* FROM "main"."GroupHotelRooms"
                WHERE "main"."GroupHotelRooms"."GroupHotelID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListGroupTransportDetail($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."GroupTransport".* FROM "main"."GroupTransport"
                WHERE "main"."GroupTransport"."GroupID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListGroupZiyaratDetail($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."GroupZiyarat".* FROM "main"."GroupZiyarat"
                WHERE "main"."GroupZiyarat"."GroupID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public
    function ListGroupExtras($ID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT "main"."GroupServices".* FROM "main"."GroupServices"
                WHERE "main"."GroupServices"."GroupID" =' . $ID . ' ';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function DeleteGroupAccomodationsRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."GroupHotel"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteGroupZiyaratRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."GroupZiyarat"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteGroupTransportRows($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."GroupTransport"';
        $where = array("UID" => $UID);
        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function GroupsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Groups"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function PackageVisaRatesByPKGID($ID, $VisaID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT packages."Meta".*,main."LookupsOptions"."Name" AS "LookupName",main."LookupsOptions"."UID" AS "LookupOptionID"
                FROM packages."Meta"
                INNER JOIN main."LookupsOptions" ON (CAST(packages."Meta"."Option" AS INTEGER) = main."LookupsOptions"."UID")
                WHERE CAST(packages."Meta"."ReferenceID" AS INTEGER) = \'' . $ID . '\' AND packages."Meta"."ReferenceType" = \'Package_Visa_Rates\' AND CAST(packages."Meta"."Option" AS INTEGER)  = ' . $VisaID . '
                AND CAST(packages."Meta"."Value" AS INTEGER) > 0  ';

        $records = $Crud->ExecuteSQL($SQL);
        //  echo $SQL;
        return $records;

    }

    public
    function GroupAccommmodationData($ID)
    {


        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."GroupHotel"';
        $where = array("GroupID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function GroupTransportData($ID)
    {

        $Crud = new Crud();
        $SQL = '
        SELECT
        main."GroupTransport".*,
        main."LookupsOptions"."Name" AS "SectorName",
        ( SELECT main."LookupsOptions"."Name" FROM packages."Transport"
          INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" AS INTEGER) = main."LookupsOptions"."UID")
          WHERE packages."Transport"."UID" = CAST(main."GroupTransport"."Transport" AS INTEGER)
        ) AS "TransportTypeName"
        FROM main."GroupTransport"
        INNER JOIN main."LookupsOptions" ON (main."GroupTransport"."TransportSectors" = main."LookupsOptions"."UID")
        WHERE main."GroupTransport"."GroupID" = ' . $ID;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function GroupPilgrimData($GID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."master".*, pilgrim."visa".* FROM "pilgrim"."master"
        LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
        WHERE "pilgrim"."master"."GroupUID"  = ' . $GID . '
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
    function PackageVisaRates($ID)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT packages."Meta".*,main."LookupsOptions"."Name" AS "LookupName",main."LookupsOptions"."UID" AS "LookupOptionID"
                FROM packages."Meta"
                INNER JOIN main."LookupsOptions" ON (CAST(packages."Meta"."Option" AS INTEGER)= main."LookupsOptions"."UID")
                WHERE packages."Meta"."ReferenceID" = \'' . $ID . '\' AND packages."Meta"."ReferenceType" = \'Package_Visa_Rates\'
                AND CAST(packages."Meta"."Value" AS INTEGER) > 0  ';

        $records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
        return $records;

    }


    public
    function GroupZiyaratData($ID)
    {

        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."GroupZiyarat"';
        $where = array("GroupID" => $ID);
        $SQL = '
        SELECT 
        main."GroupZiyarat".*,
        main."Cities"."Name" as "CityName",
        packages."Ziyarats"."Name" as "ZiyaratName",
        main."LookupsOptions"."Name" as "TransportName",
        main."Cities"."CountryCode"
        FROM main."GroupZiyarat"
        INNER JOIN main."Cities" ON (CAST(main."GroupZiyarat"."ZiyaratCity" as INTEGER) = main."Cities"."UID")
        INNER JOIN packages."Ziyarats" ON (main."GroupZiyarat"."Ziyarat" = packages."Ziyarats"."UID")
        INNER JOIN packages."Transport" ON (CAST(main."GroupZiyarat"."ZiyaratTransport" as INTEGER) = packages."Transport"."UID")
        INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" as INTEGER) = main."LookupsOptions"."UID")
        WHERE main."GroupZiyarat"."GroupID" = ' . $ID;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function GroupServicesDatas($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."GroupServices"';
        $where = array("GroupID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function GroupByAgentId($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Groups"';
        $where = array("AgentID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }


    public
    function GroupSettingsData($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'websites."Settings"';
        $where = array("DomainID" => $ID, "Key" => 'terms_and_conditions');
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }


    public
    function DeleteGroups($UID)
    {

        $Crud = new Crud();
        $table = 'main."Groups"';
        $record['Archive'] = "1";
        $record['DeleteDate'] = date("Y-m-d");
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }



    /** Code Start By Jawad */

    /** Groups
     * Record Functions
     */

    public
    function count_groups_filtered($Type)
    {
        $Crud = new Crud();
        $SQL = $this->ListGroups($Type);
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_groups_datatables($Type)
    {
        $Crud = new Crud();
        $SQL = $this->ListGroups($Type);
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function GetGroupVisaRateByPackageIDAndPax($PackageID, $PaxRecord = array(), $UID){

        $Main = new Main(); $Crud = new Crud(); $Voucher = new Voucher();
        $AdultVisaID = $ChildVisaID = $InfantVisaID = $GroupVisaRate = 0;

        $TotalAdults = ( ( isset($PaxRecord['Adults']) && $PaxRecord['Adults'] != '' )? $PaxRecord['Adults'] : 0 );
        $TotalChilds = ( ( isset($PaxRecord['Child']) && $PaxRecord['Child'] != '' )? $PaxRecord['Child'] : 0 );
        $TotalInfants = ( ( isset($PaxRecord['Infant']) && $PaxRecord['Infant'] != '' )? $PaxRecord['Infant'] : 0 );

        $AdultVisa = $Main->Settings('package_umrah_key');
        $AdultVisaID = ( ( isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0 )? $AdultVisa : 0 );
        if($AdultVisaID > 0){
            if($UID == 0){
                $AdultVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $AdultVisaID);
            }else{
                $AdultVisaRate = $this->GetGroupVisaRateByOption($UID, $AdultVisaID, $PackageID);
            }
            $AdultVisaRate = ( $AdultVisaRate * $TotalAdults );
        }

        $ChildVisa = $Main->Settings('child_umrah_rate');
        $ChildVisaID = ( ( isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0 )? $ChildVisa : 0 );
        if($ChildVisaID > 0){
            if($UID == 0){
                $ChildVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $ChildVisaID);
            }else{
                $ChildVisaRate = $this->GetGroupVisaRateByOption($UID, $ChildVisaID, $PackageID);
            }
            $ChildVisaRate = ($ChildVisaRate * $TotalChilds );
        }

        $InfantVisa = $Main->Settings('infant_umrah_rate');
        $InfantVisaID = ( ( isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0 )? $InfantVisa : 0 );
        if($InfantVisaID > 0){
            if($UID == 0){
                $InfantVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $InfantVisaID);
            }else{
                $InfantVisaRate = $this->GetGroupVisaRateByOption($UID, $InfantVisaID, $PackageID);
            }
            $InfantVisaRate = ( $InfantVisaRate * $TotalInfants );
        }

       $GroupVisaRate = ($AdultVisaRate + $ChildVisaRate + $InfantVisaRate);

        return $GroupVisaRate;
    }


    public
    function AddGroupVisaRate($DomainID, $GroupUID, $GroupPackageID, $SubmittedPackageID){

        $data = $this->data;
        $Main = new Main(); $Crud = new Crud(); $Voucher = new Voucher();
        $AdultVisa = $Main->Settings('package_umrah_key');
        $ChildVisa = $Main->Settings('child_umrah_rate');
        $InfantVisa = $Main->Settings('infant_umrah_rate');

        $PackageID = $GroupPackageID;
        $SubmittedPackageID = ( ( isset($SubmittedPackageID) && $SubmittedPackageID > 0 )? $SubmittedPackageID : $GroupPackageID );
        if( $GroupPackageID != $SubmittedPackageID ){
            $Crud->DeleteRecord('main."GroupVisaRate"', array('GroupUID' => $GroupUID));
            $PackageID = $SubmittedPackageID;
        }

        $AdultVisaID = ( ( isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0 )? $AdultVisa : 0 );
        if($AdultVisaID > 0){

            $AdultGroupVisaRateRecord = $Crud->SingleRecord( 'main."GroupVisaRate"', array('GroupUID' => $GroupUID, "Option" => $AdultVisaID) );
            if(!isset($AdultGroupVisaRateRecord['UID'])){
                $AdultVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $AdultVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'GroupUID' => $GroupUID,
                    'Option' => $AdultVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $AdultVisaRate
                );
                $Crud->AddRecord('main."GroupVisaRate"', $Record);
            }
        }
        $ChildVisaID = ( ( isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0 )? $ChildVisa : 0 );
        if($ChildVisaID > 0){
            $ChildGroupVisaRateRecord = $Crud->SingleRecord( 'main."GroupVisaRate"', array('GroupUID' => $GroupUID, "Option" => $ChildVisaID) );
            if(!isset($ChildGroupVisaRateRecord['UID'])){
                $ChildVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $ChildVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'GroupUID' => $GroupUID,
                    'Option' => $ChildVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $ChildVisaRate
                );
                $Crud->AddRecord('main."GroupVisaRate"', $Record);
            }
        }
        $InfantVisaID = ( ( isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0 )? $InfantVisa : 0 );
        if($InfantVisaID > 0){
            $InfantGroupVisaRateRecord = $Crud->SingleRecord( 'main."GroupVisaRate"', array('GroupUID' => $GroupUID, "Option" => $InfantVisaID) );
            if(!isset($InfantGroupVisaRateRecord['UID'])){
                $InfantVisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $InfantVisaID);
                $Record = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'GroupUID' => $GroupUID,
                    'Option' => $InfantVisaID,
                    'DomainID' => $DomainID,
                    'Rate' => $InfantVisaRate
                );
                $Crud->AddRecord('main."GroupVisaRate"', $Record);
            }
        }
    }

    public
    function GetGroupVisaRateByOption( $GroupID, $Option, $PackageID ){

        $Crud = new Crud();  $data = $this->data; $Voucher = new Voucher();
        $SQL = ' SELECT * FROM main."GroupVisaRate" 
                 WHERE CAST("GroupUID" AS INTEGER) = '.$GroupID.'
                 AND CAST("Option" AS INTEGER) = '.$Option.' AND  main."GroupVisaRate"."DomainID" = '.$data['GetDomainID'].'
                 LIMIT 1 ';
        $VisaRateData = $Crud->ExecuteSQL($SQL);
        if( isset($VisaRateData[0]['UID']) ){
            $VisaRate = ( ( isset($VisaRateData[0]['Rate']) && $VisaRateData[0]['Rate'] != '' )? $VisaRateData[0]['Rate'] : 0 );
        }else{
            $VisaRate = $Voucher->GetPackageRateVisaRateByOption($PackageID, $Option);
        }
        return $VisaRate;
    }

    public
    function GetGroupPilgrimsAppliedVisaRate($GroupUID){

        $session = session(); $session = $session->get();
        $Main = new Main(); $Crud = new Crud();
        $AdultVisaRate = $ChildVisaRate = $InfantVisaRate = 0; $MainArray = array();

        $AdultVisa = $Main->Settings('package_umrah_key');
        $AdultVisaID = ( ( isset($AdultVisa) && $AdultVisa != '' && $AdultVisa > 0 )? $AdultVisa : 0 );
        if($AdultVisaID > 0){
            $AdultVisaRateData = $Crud->SingleRecord('main."GroupVisaRate"', array('GroupUID' => $GroupUID, 'Option' => $AdultVisaID, 'DomainID' => $session['domainid']));
            $AdultVisaRate = ( ( isset($AdultVisaRateData['Rate']) && $AdultVisaRateData['Rate'] != '' )? $AdultVisaRateData['Rate'] : 0 );
        }

        $ChildVisa = $Main->Settings('child_umrah_rate');
        $ChildVisaID = ( ( isset($ChildVisa) && $ChildVisa != '' && $ChildVisa > 0 )? $ChildVisa : 0 );
        if($ChildVisaID > 0){
            $ChildVisaRateData = $Crud->SingleRecord('main."GroupVisaRate"', array('GroupUID' => $GroupUID, 'Option' => $ChildVisaID, 'DomainID' => $session['domainid']));
            $ChildVisaRate = ( ( isset($ChildVisaRateData['Rate']) && $ChildVisaRateData['Rate'] != '' )? $ChildVisaRateData['Rate'] : 0 );
        }

        $InfantVisa = $Main->Settings('infant_umrah_rate');
        $InfantVisaID = ( ( isset($InfantVisa) && $InfantVisa != '' && $InfantVisa > 0 )? $InfantVisa : 0 );
        if($InfantVisaID > 0){
            $InfantVisaRateData = $Crud->SingleRecord('main."GroupVisaRate"', array('GroupUID' => $GroupUID, 'Option' => $InfantVisaID, 'DomainID' => $session['domainid']));
            $InfantVisaRate = ( ( isset($InfantVisaRateData['Rate']) && $InfantVisaRateData['Rate'] != '' )? $InfantVisaRateData['Rate'] : 0 );
        }

        $MainArray['Infant'] = $InfantVisaRate;
        $MainArray['Child'] = $ChildVisaRate;
        $MainArray['Adult'] = $AdultVisaRate;

        return $MainArray;
    }
}
