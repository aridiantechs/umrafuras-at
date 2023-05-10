<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;

class Packages extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $session = session();
        $this->data['session'] = $session->get();
    }

    public function TransportFormSubmit($records, $UID)
    {
        $data = $this->data;

        $dbdata = array();
        $dbdata['Type'] = $records['Type'];
        $dbdata['LuggageCapacity'] = $records['LuggageCapacity'];
        $dbdata['Description'] = $records['Description'];
        $dbdata['PAXDetail'] = $records['PAXDetail'];
        $dbdata['CoverImage'] = $records['CoverImage'];
        $dbdata['WebsiteDomain'] = $records['WebsiteDomain'];

        $Crud = new Crud();
        $table = 'packages."Transport"';
        $images = $records['Images'];
        if ($UID == 0) {
            if (count($images) > 0) {
                $UID = $Crud->AddRecord($table, $dbdata);
                $Crud->Track("Packages", 'New Transport "' . $records['Name'] . '" added in system...');
                $response['status'] = "success";
                $response['record_id'] = $UID;
                $response['message'] = "Transport Successfully Added...";
            } else {
                $response['status'] = "false";
                $response['message'] = "Please Upload at least one Image...";
            }
        } else {
            $Crud->Track("Packages", 'Transport "' . $records['Name'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $dbdata, $where);
            $response['status'] = "success";
            $response['message'] = "Transport Updated...";
        }

        if (count($images) > 0) {
            foreach ($images as $img) {
                $record = array();
                $record['TransportID'] = $UID;
                $record['FileID'] = $img;
                $Crud->AddRecord('packages."TransportImage"', $record);
            }
        }

        echo json_encode($response);
    }

    public function PackageFormSubmit($records, $VisaCharges, $UID = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $table = 'packages."Packages"';
        $where = array("AgentUID" => $records['AgentUID']);
        $Crud->UpdateRecord($table, array("AgentUID" => 0), $where);


        $Packagedata = array();
        $Packagedata['AgentUID'] = $records['AgentUID'];
        $Packagedata['GroupCode'] = $records['GroupCode'];
        $Packagedata['WebsiteDomain'] = $records['WebsiteDomain'];
        $Packagedata['Name'] = $records['Name'];
        $Packagedata['StartDate'] = $records['StartDate'];
        $Packagedata['ExpireDate'] = $records['ExpireDate'];
        $Packagedata['CountryCode'] = $records['CountryCode'];
        $Packagedata['PackageType'] = "B2B";
        if ($UID > 0) {
            $Crud->Track("Packages", 'New Package "' . $records['Name'] . '" Updated in system...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $Packagedata, $where);
            $response['message'] = "Package Successfully Updated...";
        } else {
            $Crud->Track("Packages", 'New Package "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $Packagedata);
            $response['message'] = "Package Successfully Added...";
        }

        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $UID);
        $Crud->DeleteRecord($table, $where);

        //print_r($records['RoomType']);
        if (isset($records['RoomType']) && is_array($records['RoomType']) && count($records['RoomType']) > 0) {
            foreach ($records['RoomType'] as $key => $record) {
                for ($i = 0; $i < count($records['Hotel']); $i++) {
                    $HotelRatedata = array();
                    $HotelRatedata['PackageUID'] = $UID;
                    $HotelRatedata['HotelUID'] = $records['Hotel'][$i];
                    $HotelRatedata['HotelCategory'] = $records['HotelCategory'][$i];
                    $HotelRatedata['RoomTypeUID'] = $key;
                    $HotelRatedata['Rate'] = $records['RoomType'][$key][$i];
                    $HotelRatedata['RowID'] = $i;
                    $Crud->AddRecord($table, $HotelRatedata);
                }
            }
        }

        $MetaTable = 'packages."Meta"';
        $where = array("ReferenceID" => $UID);
        $Crud->DeleteRecord($MetaTable, $where);
        foreach ($VisaCharges as $Key => $Value) {
            $ReferenceType = "Package_Visa_Rates";
            if (!empty($Value)) {
                $Crud->AddRecord($MetaTable, array("ReferenceID" => $UID, "ReferenceType" => $ReferenceType, "Option" => $Key, "Value" => $Value));

            }

        }

        if (isset($records['Ziyarat'])) {
            $table = 'packages."ZiyaratsRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            for ($i = 0; $i < count($records['Ziyarat']); $i++) {
                $ZiyaratUID = $records['Ziyarat'][$i];
                foreach ($records['ZiyaratRates'] as $TransportTypeUID => $thisRate) {
                    // print_r($thisRate);
                    $ZiyaratRatedata = array();
                    $ZiyaratRatedata['PackageUID'] = $UID;
                    $ZiyaratRatedata['ZiyaratsUID'] = $ZiyaratUID;
                    $ZiyaratRatedata['Rate'] = $thisRate[$i];
                    $ZiyaratRatedata['RowID'] = $i;
                    $ZiyaratRatedata['TransportTypeUID'] = $TransportTypeUID;
                    $Crud->AddRecord($table, $ZiyaratRatedata);
                }
            }
        }

        if (isset($records['TransportRates'])) {
            $table = 'packages."TransportRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            $cnt = 0;
            $temp = "";
            foreach ($records['TransportRates'] as $Keys => $Rate) {
                list($TrasportUID, $RouteUID, $RowID) = explode("|", $Keys);
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['TransportTypeUID'] = $TrasportUID;
                $TransportRatedata['Routes'] = $RouteUID;
                $TransportRatedata['Rate'] = $Rate;
                $TransportRatedata['RowID'] = $RowID;
                $Crud->AddRecord($table, $TransportRatedata);
                $cnt++;
            }
        }
        if (isset($records['Extra'])) {
            $table = 'packages."ServiceRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }

            foreach ($records['Extra'] as $Key => $Rate) {
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['ServiceUID'] = $Key;
                $TransportRatedata['Rate'] = $Rate;
                $Crud->AddRecord($table, $TransportRatedata);
            }
        }

        $response['status'] = "success";
        $response['record_id'] = $UID;
        //print_r($response);
        echo json_encode($response);
    }

    public
    function PackageVisaRatesByPKGID($ID)
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

    public function ExternalAgentPackageFormSubmit($records, $VisaCharges, $UID = 0)
    {
        $data = $this->data;

        $Packagedata = array();
        $Packagedata['AgentUID'] = $records['AgentUID'];
        $Packagedata['Name'] = $records['Name'];
        $Packagedata['GroupCode'] = $records['GroupCode'];
        $Packagedata['StartDate'] = $records['StartDate'];
        $Packagedata['ExpireDate'] = $records['ExpireDate'];
        $Packagedata['CountryCode'] = $records['CountryCode'];
        $Packagedata['PackageType'] = "B2B";

        $Crud = new Crud();
        $table = 'packages."Packages"';
        if ($UID > 0) {
            $Crud->Track("Packages", 'New Package "' . $records['Name'] . '" Updated in system...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $Packagedata, $where);
            $response['message'] = "Package Successfully Updated...";
        } else {
            $Crud->Track("Packages", 'New Package "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $Packagedata);
            $response['message'] = "Package Successfully Added...";
        }

        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $UID);
        $Crud->DeleteRecord($table, $where);

        //print_r($records['RoomType']);
        if (isset($records['RoomType']) && is_array($records['RoomType']) && count($records['RoomType']) > 0) {
            foreach ($records['RoomType'] as $key => $record) {
                for ($i = 0; $i < count($records['Hotel']); $i++) {
                    $HotelRatedata = array();
                    $HotelRatedata['PackageUID'] = $UID;
                    $HotelRatedata['HotelUID'] = $records['Hotel'][$i];
                    $HotelRatedata['RoomTypeUID'] = $key;
                    $HotelRatedata['Rate'] = $records['RoomType'][$key][$i];
                    $HotelRatedata['RowID'] = $i;
                    $Crud->AddRecord($table, $HotelRatedata);
                }
            }
        }

        $MetaTable = 'packages."Meta"';
        $where = array("ReferenceID" => $UID);
        $Crud->DeleteRecord($MetaTable, $where);
        foreach ($VisaCharges as $Key => $Value) {
            $ReferenceType = "Package_Visa_Rates";
            if (!empty($Value)) {
                $Crud->AddRecord($MetaTable, array("ReferenceID" => $UID, "ReferenceType" => $ReferenceType, "Option" => $Key, "Value" => $Value));

            }

        }

        if (isset($records['Ziyarat'])) {
            $table = 'packages."ZiyaratsRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            for ($i = 0; $i < count($records['Ziyarat']); $i++) {
                $ZiyaratUID = $records['Ziyarat'][$i];
                foreach ($records['ZiyaratRates'] as $TransportTypeUID => $thisRate) {
                    // print_r($thisRate);
                    $ZiyaratRatedata = array();
                    $ZiyaratRatedata['PackageUID'] = $UID;
                    $ZiyaratRatedata['ZiyaratsUID'] = $ZiyaratUID;
                    $ZiyaratRatedata['Rate'] = $thisRate[$i];
                    $ZiyaratRatedata['RowID'] = $i;
                    $ZiyaratRatedata['TransportTypeUID'] = $TransportTypeUID;
                    $Crud->AddRecord($table, $ZiyaratRatedata);
                }
            }
        }

        if (isset($records['TransportRates'])) {
            $table = 'packages."TransportRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            $cnt = 0;
            $temp = "";
            foreach ($records['TransportRates'] as $Keys => $Rate) {
                list($TrasportUID, $RouteUID, $RowID) = explode("|", $Keys);
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['TransportTypeUID'] = $TrasportUID;
                $TransportRatedata['Routes'] = $RouteUID;
                $TransportRatedata['Rate'] = $Rate;
                $TransportRatedata['RowID'] = $RowID;
                $Crud->AddRecord($table, $TransportRatedata);
                $cnt++;
            }
        }
        if (isset($records['Extra'])) {
            $table = 'packages."ServiceRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }

            foreach ($records['Extra'] as $Key => $Rate) {
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['ServiceUID'] = $Key;
                $TransportRatedata['Rate'] = $Rate;
                $Crud->AddRecord($table, $TransportRatedata);
            }
        }
        $response['status'] = "success";
        $response['record_id'] = $UID;
        //print_r($response);
        echo json_encode($response);
    }

    public function B2BGeneralPackageFormSubmit($records, $VisaCharges, $UID = 0)
    {
        $data = $this->data;

        $Packagedata = array();
        $Packagedata['AgentUID'] = $records['AgentUID'];
        $Packagedata['Name'] = $records['Name'];
        $Packagedata['StartDate'] = $records['StartDate'];
        $Packagedata['ExpireDate'] = $records['ExpireDate'];
        // $records['Fee'] = 0;
        $Packagedata['CountryCode'] = $records['CountryCode'];
        $Packagedata['PackageType'] = "B2B_General";

        $Crud = new Crud();
        $table = 'packages."Packages"';
        if ($UID > 0) {
            $Crud->Track("Packages", 'B2B General Package "' . $records['Name'] . '" Updated in system...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $Packagedata, $where);
            $response['message'] = "B2B General Package Successfully Updated...";
        } else {
            $Crud->Track("Packages", 'New B2B General  Package "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $Packagedata);
            $response['message'] = "B2B General Package Successfully Added...";
        }

        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $UID);
        $Crud->DeleteRecord($table, $where);

        //print_r($records['RoomType']);
        if (isset($records['RoomType']) && is_array($records['RoomType']) && count($records['RoomType']) > 0) {
            foreach ($records['RoomType'] as $key => $record) {
                for ($i = 0; $i < count($records['Hotel']); $i++) {
                    $HotelRatedata = array();
                    $HotelRatedata['PackageUID'] = $UID;
                    $HotelRatedata['HotelUID'] = $records['Hotel'][$i];
                    $HotelRatedata['HotelCategory'] = $records['HotelCategory'][$i];
                    $HotelRatedata['RoomTypeUID'] = $key;
                    $HotelRatedata['Rate'] = $records['RoomType'][$key][$i];
                    $HotelRatedata['RowID'] = $i;
                    $Crud->AddRecord($table, $HotelRatedata);
                }
            }
        }

        $MetaTable = 'packages."Meta"';
        $where = array("ReferenceID" => $UID);
        $Crud->DeleteRecord($MetaTable, $where);
        foreach ($VisaCharges as $Key => $Value) {
            $ReferenceType = "Package_Visa_Rates";
            if (!empty($Value)) {
                $Crud->AddRecord($MetaTable, array("ReferenceID" => $UID, "ReferenceType" => $ReferenceType, "Option" => $Key, "Value" => $Value));

            }

        }

        if (isset($records['Ziyarat'])) {
            $table = 'packages."ZiyaratsRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            for ($i = 0; $i < count($records['Ziyarat']); $i++) {
                $ZiyaratUID = $records['Ziyarat'][$i];
                foreach ($records['ZiyaratRates'] as $TransportTypeUID => $thisRate) {
                    // print_r($thisRate);
                    $ZiyaratRatedata = array();
                    $ZiyaratRatedata['PackageUID'] = $UID;
                    $ZiyaratRatedata['ZiyaratsUID'] = $ZiyaratUID;
                    $ZiyaratRatedata['Rate'] = $thisRate[$i];
                    $ZiyaratRatedata['RowID'] = $i;
                    $ZiyaratRatedata['TransportTypeUID'] = $TransportTypeUID;
                    $Crud->AddRecord($table, $ZiyaratRatedata);
                }
            }
        }

        if (isset($records['TransportRates'])) {
            $table = 'packages."TransportRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            $cnt = 0;
            $temp = "";
            foreach ($records['TransportRates'] as $Keys => $Rate) {
                list($TrasportUID, $RouteUID, $RowID) = explode("|", $Keys);
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['TransportTypeUID'] = $TrasportUID;
                $TransportRatedata['Routes'] = $RouteUID;
                $TransportRatedata['Rate'] = $Rate;
                $TransportRatedata['RowID'] = $RowID;
                $Crud->AddRecord($table, $TransportRatedata);
                $cnt++;
            }
        }
        if (isset($records['Extra'])) {
            $table = 'packages."ServiceRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }

            foreach ($records['Extra'] as $Key => $Rate) {
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['ServiceUID'] = $Key;
                $TransportRatedata['Rate'] = $Rate;
                $Crud->AddRecord($table, $TransportRatedata);
            }
        }
        $response['status'] = "success";
        $response['record_id'] = $UID;
        //print_r($response);
        echo json_encode($response);
    }

    public function B2CPackageFormSubmit($records, $VisaCharges, $UID = 0)
    {
        $data = $this->data;

        $Packagedata = array();
        $Packagedata['AgentUID'] = $records['AgentUID'];
        $Packagedata['Name'] = $records['Name'];
        $Packagedata['StartDate'] = $records['StartDate'];
        $Packagedata['ExpireDate'] = $records['ExpireDate'];
        // $records['Fee'] = 0;
        $Packagedata['CountryCode'] = $records['CountryCode'];
        $Packagedata['PackageType'] = "B2C";

        $Crud = new Crud();
        $table = 'packages."Packages"';
        if ($UID > 0) {
            $Crud->Track("Packages", 'B2C Package "' . $records['Name'] . '" Updated in system...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $Packagedata, $where);
            $response['message'] = "B2C Package Successfully Updated...";
        } else {
            $Crud->Track("Packages", 'New B2C  Package "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $Packagedata);
            $response['message'] = "B2C General Package Successfully Added...";
        }

        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $UID);
        $Crud->DeleteRecord($table, $where);

        //print_r($records['RoomType']);
        if (isset($records['RoomType']) && is_array($records['RoomType']) && count($records['RoomType']) > 0) {
            foreach ($records['RoomType'] as $key => $record) {
                for ($i = 0; $i < count($records['Hotel']); $i++) {
                    $HotelRatedata = array();
                    $HotelRatedata['PackageUID'] = $UID;
                    $HotelRatedata['HotelCategory'] = $records['HotelCategory'][$i];
                    $HotelRatedata['HotelUID'] = $records['Hotel'][$i];
                    $HotelRatedata['RoomTypeUID'] = $key;
                    $HotelRatedata['Rate'] = $records['RoomType'][$key][$i];
                    $HotelRatedata['RowID'] = $i;
                    $Crud->AddRecord($table, $HotelRatedata);
                }
            }
        }

        $MetaTable = 'packages."Meta"';
        $where = array("ReferenceID" => $UID);
        $Crud->DeleteRecord($MetaTable, $where);
        foreach ($VisaCharges as $Key => $Value) {
            $ReferenceType = "Package_Visa_Rates";
            if (!empty($Value)) {
                $Crud->AddRecord($MetaTable, array("ReferenceID" => $UID, "ReferenceType" => $ReferenceType, "Option" => $Key, "Value" => $Value));

            }

        }

        if (isset($records['Ziyarat'])) {
            $table = 'packages."ZiyaratsRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            for ($i = 0; $i < count($records['Ziyarat']); $i++) {
                $ZiyaratUID = $records['Ziyarat'][$i];
                foreach ($records['ZiyaratRates'] as $TransportTypeUID => $thisRate) {
                    // print_r($thisRate);
                    $ZiyaratRatedata = array();
                    $ZiyaratRatedata['PackageUID'] = $UID;
                    $ZiyaratRatedata['ZiyaratsUID'] = $ZiyaratUID;
                    $ZiyaratRatedata['Rate'] = $thisRate[$i];
                    $ZiyaratRatedata['RowID'] = $i;
                    $ZiyaratRatedata['TransportTypeUID'] = $TransportTypeUID;
                    $Crud->AddRecord($table, $ZiyaratRatedata);
                }
            }
        }

        if (isset($records['TransportRates'])) {
            $table = 'packages."TransportRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }
            $cnt = 0;
            $temp = "";
            foreach ($records['TransportRates'] as $Keys => $Rate) {
                list($TrasportUID, $RouteUID, $RowID) = explode("|", $Keys);
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['TransportTypeUID'] = $TrasportUID;
                $TransportRatedata['Routes'] = $RouteUID;
                $TransportRatedata['Rate'] = $Rate;
                $TransportRatedata['RowID'] = $RowID;
                $Crud->AddRecord($table, $TransportRatedata);
                $cnt++;
            }
        }
        if (isset($records['Extra'])) {
            $table = 'packages."ServiceRate"';
            if ($UID > 0) {
                $where = array("PackageUID" => $UID);
                $Crud->DeleteRecord($table, $where);
            }

            foreach ($records['Extra'] as $Key => $Rate) {
                $TransportRatedata = array();
                $TransportRatedata['PackageUID'] = $UID;
                $TransportRatedata['ServiceUID'] = $Key;
                $TransportRatedata['Rate'] = $Rate;
                $Crud->AddRecord($table, $TransportRatedata);
            }
        }
        $response['status'] = "success";
        $response['record_id'] = $UID;
        //print_r($response);
        echo json_encode($response);
    }

    public function PackageFormUpdate($records, $UID = 0)
    {
        $data = $this->data;

        $Packagedata = array();
        $Packagedata['Name'] = $records['Name'];
        $Packagedata['StartDate'] = $records['StartDate'];
        $Packagedata['ExpireDate'] = $records['ExpireDate'];
        $Packagedata['Fee'] = $records['Fee'];
        $Packagedata['VisaFee'] = $records['VisaFee'];
        $Packagedata['CountryCode'] = $records['CountryCode'];

        $Crud = new Crud();
        $table = 'packages."Packages"';
        $Crud->Track("Packages", 'New Package "' . $records['Name'] . '" added in system...');
        $UID = $Crud->AddRecord($table, $Packagedata);

        $table = 'packages."HotelsRate"';
        foreach ($records['RoomType'] as $key => $record) {
            for ($i = 0; $i < count($records['Hotel']); $i++) {
                $HotelRatedata = array();
                $HotelRatedata['PackageUID'] = $UID;
                $HotelRatedata['HotelUID'] = $records['Hotel'][$i];
                $HotelRatedata['RoomTypeUID'] = $key;
                $HotelRatedata['Rate'] = $records['RoomType'][$key][$i];
                $Crud->AddRecord($table, $HotelRatedata);
            }
        }
        $response['status'] = "success";
        $response['record_id'] = $UID;
        $response['message'] = "Package Successfully Added...";

        echo json_encode($response);
    }

    public function ZiayartFormSubmit($records, $UID, $MetaRecord)
    {
        $data = $this->data;
        $Crud = new Crud();

        $ZiyaratData = array();
        $ZiyaratData['Name'] = $records['Name'];
        $ZiyaratData['CountryID'] = $records['CountryID'];
        $ZiyaratData['CityID'] = $records['CityID'];
        $ZiyaratData['Description'] = $records['Description'];
        $ZiyaratData['NearPlaces'] = $records['NearPlaces'];
        $ZiyaratData['CoverImage'] = $records['Image'];
        $ZiyaratData['WebsiteDomain'] = $records['WebsiteDomain'];

        $table = 'packages."Ziyarats"';

        if ($UID == 0) {
            if (!empty($ZiyaratData['CoverImage']) > 0) {
                $Crud->Track("Packages", 'New Ziyarat "' . $records['Name'] . '" added in system...');
                $UID = $Crud->AddRecord($table, $ZiyaratData);
                $response['record_id'] = $UID;
                $response['status'] = "success";
                $response['message'] = "Ziyarat Successfully Added...";
            } else {
                $response['status'] = "fail";
                $response['message'] = "Kindly Upload  Cover Image...";
            }
        } else {
            if (!empty($ZiyaratData['CoverImage'])) {
                $Crud->Track("Packages", 'Ziyarat "' . $records['Name'] . '" Updated Succesfully ...');
                $where = array("UID" => $UID);
                $Crud->UpdateRecord($table, $ZiyaratData, $where);
                $response['status'] = "success";
                $response['message'] = "Ziyarat Updated...";
            } else {
                $where = array("UID" => $UID);
                $CoverImage = $Crud->SingleRecord($table, $where);
                $ZiyaratData['CoverImage'] = $CoverImage['CoverImage'];
                $Crud->Track("Packages", 'Ziyarat "' . $records['Name'] . '" Updated Succesfully ...');
                $Crud->UpdateRecord($table, $ZiyaratData, $where);
                $response['status'] = "success";
                $response['message'] = "Ziyarat Updated...";
            }
        }

        $table = 'packages."Meta"';
        foreach ($MetaRecord as $option => $value) {
            $MetaData = array();
            $MetaData['ReferenceID'] = $UID;
            $MetaData['ReferenceType'] = 'Ziyarat';
            $MetaData['Option'] = $option;
            $MetaData['Value'] = $value;
            $Crud->AddRecord($table, $MetaData);
        }

        $images = $records['MultipleImages'];
        if (count($images) > 0) {
            foreach ($images as $img) {
                $record = array();
                $record['ReferenceID'] = $UID;
                $record['ReferenceType'] = 'Ziyarat';
                $record['Option'] = 'GalleryImages';
                $record['Value'] = $img;
                $Crud->AddRecord($table, $record);
            }
        }

        echo json_encode($response);
    }

    public function HotelFormSubmit($records, $UID)
    {
        $data = $this->data;

        $dbdata = array();
        $dbdata['Name'] = $records['Name'];
        $dbdata['Category'] = $records['Category'];
        $dbdata['Distance'] = $records['Distance'];
        $dbdata['Address'] = $records['Address'];
        $dbdata['TelephoneNumber'] = $records['TelephoneNumber'];
        $dbdata['Latitude'] = $records['Latitude'];
        $dbdata['Longitude'] = $records['Longitude'];
        $dbdata['GoogleMAP'] = $records['GoogleMAP'];
        $dbdata['Description'] = $records['Description'];
        $dbdata['CountryID'] = $records['CountryID'];
        $dbdata['CityID'] = $records['CityID'];
        $dbdata['Status'] = $records['Status'];
        $dbdata['WebsiteDomain'] = $records['WebsiteDomain'];

        //print_r($dbdata);
        $Crud = new Crud();
        $table = 'packages."Hotels"';

        if ($UID == 0) {
            $Crud->Track("Packages", 'New Hotel "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $dbdata);
            if ($response['record_id'] = $UID) {
                $response['status'] = "success";
                $response['message'] = "Hotel Successfully Added...";
            } else {
                $response['status'] = "fail";
                $response['message'] = "Data Didn't Submitted Correctly";
            }

        } else {
            $Crud->Track("Packages", 'Hotel "' . $records['Name'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $dbdata, $where);
            $response['status'] = "success";
            $response['message'] = "Hotel Updated...";

        }

        //print_r($response); print_r($images);

        $images = $records['Images'];
        if (count($images) > 0) {
            foreach ($images as $img) {
                $record = array();
                $record['HotelID'] = $UID;
                $record['ImageID'] = $img;
                $Crud->AddRecord('packages."HotelImage"', $record);
            }
        }

//        print_r($records['HotelFacilites']);

        $Metass = $records['HotelAmenities'];
        if (isset($Metass)) {
            $where = array("ReferenceID" => $UID, "Option" => "Amenities");
            $Crud->DeleteRecord('packages."Meta"', $where);
        }
        foreach ($Metass as $value) {
            $recrod = array();
            $recrod['ReferenceID'] = $UID;
            $recrod['ReferenceType'] = 'Hotel';
            $recrod['Option'] = 'Amenities';
            $recrod['Value'] = $value;
            $Crud->AddRecord('packages."Meta"', $recrod);

        }

        $Metas = $records['HotelFacilites'];
        if (isset($Metas)) {
            $where = array("ReferenceID" => $UID, "Option" => "Facilities");
            $Crud->DeleteRecord('packages."Meta"', $where);
        }
        foreach ($Metas as $value) {
            $recrd = array();
            $recrd['ReferenceID'] = $UID;
            $recrd['ReferenceType'] = 'Hotel';
            $recrd['Option'] = 'Facilities';
            $recrd['Value'] = $value;
            $Crud->AddRecord('packages."Meta"', $recrd);
        }


        echo json_encode($response);
    }

    public function SelfHotelFormSubmit($records, $UID)
    {
        $data = $this->data;

        $dbdata = array();
        $dbdata['Name'] = $records['Name'];
        $dbdata['Category'] = $records['Category'];
        $dbdata['Distance'] = $records['Distance'];
        $dbdata['Address'] = $records['Address'];
        $dbdata['TelephoneNumber'] = $records['TelephoneNumber'];
        /*$dbdata['Latitude'] = $records['Latitude'];
        $dbdata['Longitude'] = $records['Longitude'];
        $dbdata['GoogleMAP'] = $records['GoogleMAP'];*/
        $dbdata['Description'] = $records['Description'];
        $dbdata['CountryID'] = $records['CountryID'];
        $dbdata['CityID'] = $records['CityID'];
        $dbdata['Status'] = $records['Status'];

        //print_r($dbdata);
        $Crud = new Crud();
        $table = 'packages."OtherHotels"';

        if ($UID == 0) {
            $Crud->Track("Packages", 'New Hotel "' . $records['Name'] . '" added in system...');
            $UID = $Crud->AddRecord($table, $dbdata);
            if ($response['record_id'] = $UID) {
                $response['status'] = "success";
                $response['message'] = "Hotel Successfully Added...";
            } else {
                $response['status'] = "fail";
                $response['message'] = "Data Didn't Submitted Correctly";
            }

        } else {
            $Crud->Track("Packages", 'Hotel "' . $records['Name'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $dbdata, $where);
            $response['status'] = "success";
            $response['message'] = "Hotel Updated...";

        }


        echo json_encode($response);
    }

    public
    function ListTransport()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT * FROM packages."Transport" WHERE "Archive" = \'0\' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }
        if ($session['AgentLogged']) {
            $SQL .= ' AND "UID" IN (SELECT  distinct packages."TransportRate"."TransportTypeUID"
            FROM packages."TransportRate"
            LEFT JOIN  packages."Packages" ON packages."Packages"."UID" = packages."TransportRate"."PackageUID" 
            WHERE packages."Packages"."AgentUID" = ' . $session['id'] . ') ';
        }
        $SQL .= 'ORDER BY packages."Transport"."Description" ASC ';
        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function GetTransportSectorsByPackageID($PackageID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT  distinct packages."TransportRate"."Routes"
            FROM packages."TransportRate"
            LEFT JOIN  packages."Packages" ON packages."Packages"."UID" = packages."TransportRate"."PackageUID" 
            WHERE packages."Packages"."AgentUID" = ' . $session['id'];

        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        $final = array();
        foreach ($records as $record) {
            $final[] = $record['Routes'];
        }
        return $final;


    }

    public
    function ListTransportsByDomainID($ID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT * FROM packages."Transport" WHERE "Archive" = \'0\' AND  "WebsiteDomain" =  ' . $ID . ' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= 'ORDER BY packages."Transport"."Description" ASC ';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function ListTransportByDomainID()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT * FROM packages."Transport" WHERE "Archive" = \'0\' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= ' ORDER BY packages."Transport"."Description" ASC ';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function ListHotelsByDomainID()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT * FROM packages."Hotels" WHERE "Archive" = \'0\' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= ' ORDER BY packages."Hotels"."Name" ASC ';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public
    function ListHotels()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $HotelSearchFilter = $session['HotelSearchFilter'];
        $SQL = 'SELECT * FROM packages."Hotels" WHERE "Archive" = \'0\' ';

        if (isset($HotelSearchFilter['name'])) {
            $SQL .= ' AND LOWER("Name") LIKE \'%' . strtolower($HotelSearchFilter['name']) . '%\' ';
        }
        if (isset($HotelSearchFilter['phone_number']) && $HotelSearchFilter['phone_number'] != '') {
            $SQL .= ' AND "TelephoneNumber" = \'' . $HotelSearchFilter['phone_number'] . '\' ';
        }
        if (isset($HotelSearchFilter['city']) && $HotelSearchFilter['city'] != '') {
            $SQL .= ' AND "CityID" = \'' . $HotelSearchFilter['city'] . '\' ';
        }

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= ' ORDER BY "packages"."Hotels"."Name" ASC ';

        //    echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public
    function ListAllHotels()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SQL = 'SELECT * FROM packages."Hotels" WHERE "Archive" = \'0\' AND "Status" = "on" ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= ' ORDER BY "packages"."Hotels"."Name" ASC ';

        //  echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListHotelsByCityID($CityID)
    {
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
//print_r($session);
        $SQL = 'SELECT * FROM packages."Hotels" WHERE "Archive" = \'0\' AND "CityID" = \'' . $CityID . '\' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }
        if ($session['AgentLogged']) {
            $SQL .= ' AND "UID" IN (SELECT  distinct packages."HotelsRate"."HotelUID"
            FROM packages."HotelsRate"
            LEFT JOIN  packages."Packages" ON packages."Packages"."UID" = packages."HotelsRate"."PackageUID" 
            WHERE packages."Packages"."AgentUID" = ' . $session['id'] . ') ';
        }
        $SQL .= ' ORDER BY "packages"."Hotels"."Name" ASC ';

        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListHotelsCategoryByCityID($CityID, $CatID)
    {
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        //print_r($session);
        $SQL = 'SELECT packages."Hotels".*,main."LookupsOptions"."Name" AS "CategoryName" ,main."LookupsOptions"."UID" AS "CategoryUID" FROM packages."Hotels" 
        LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID" = cast(packages."Hotels"."Category" AS bigint)
        WHERE packages."Hotels"."Archive" = \'0\' AND packages."Hotels"."CityID" = \'' . $CityID . '\'  AND packages."Hotels"."Category" = \'' . $CatID . '\' ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND packages."Hotels"."WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }
        if ($session['AgentLogged']) {
            $SQL .= '
            AND packages."Hotels"."UID" IN (
                SELECT  distinct packages."HotelsRate"."HotelUID"
                FROM packages."HotelsRate"
                LEFT JOIN  packages."Packages" ON packages."Packages"."UID" = packages."HotelsRate"."PackageUID" 
                WHERE packages."Packages"."AgentUID" = ' . $session['id'] . '
            ) ';
        }
        $SQL .= ' ORDER BY "packages"."Hotels"."Name" ASC ';

        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function GetHotelsRateByPackageID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $record_id);
        $order = array("HotelUID" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

//
//        $SQL = 'SELECT packages."HotelsRate".*, main."LookupsOptions"."Name" as "HotelCategoryName",main."Cities"."Name" as "CityName"
//                FROM packages."HotelsRate"
//                LEFT JOIN packages."Hotels" ON packages."HotelsRate"."HotelUID" = packages."Hotels"."UID"
//                LEFT JOIN main."LookupsOptions" ON (cast (main."LookupsOptions"."UID" as int)) = (cast (packages."Hotels"."Category" as int))
//                LEFT JOIN main."Cities" ON main."Cities"."UID" = packages."Hotels"."CityID"
//                WHERE packages."HotelsRate"."PackageUID" = '.$record_id.'
//                ORDER BY packages."HotelsRate"."HotelUID" ASC  ';
//        echo $SQL;
////        exit;
//        $records = $Crud->ExecuteSQL($SQL);
//        return $records;

    }

    public
    function GetServiceRateByPackageID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."ServiceRate"';
        $where = array("PackageUID" => $record_id);
        $order = array();
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListHotelByDomainID($ID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $HotelSearchFilter = $session['HotelSearchFilter'];
        $SQL = 'SELECT * FROM packages."Hotels" WHERE "Archive" = \'0\' AND "WebsiteDomain" = ' . $ID . ' ';

        if (isset($HotelSearchFilter['name'])) {
            $SQL .= ' AND LOWER("Name") LIKE \'%' . strtolower($HotelSearchFilter['name']) . '%\' ';
        }
        if (isset($HotelSearchFilter['phone_number']) && $HotelSearchFilter['phone_number'] != '') {
            $SQL .= ' AND "TelephoneNumber" = \'' . $HotelSearchFilter['phone_number'] . '\' ';
        }
        if (isset($HotelSearchFilter['city']) && $HotelSearchFilter['city'] != '') {
            $SQL .= ' AND "CityID" = \'' . $HotelSearchFilter['city'] . '\' ';
        }

        if ($session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }

        $SQL .= ' ORDER BY "packages"."Hotels"."Name" ASC ';

        //   echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListTransportData($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."TransportRate"';
        $where = array("PackageUID" => $record_id);
        $order = array();
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function GetZiyaratRateByPackageID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."ZiyaratsRate"';
        $where = array("PackageUID" => $record_id);
        $order = array();
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }


    public
    function ListPackages()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" = \'B2B\' AND (main."Agents"."Type" = \'agent\' OR main."Agents"."Type" = \'external_agent\' )
                ORDER BY packages."Packages"."Name" ASC  ';
//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }

    public
    function ListUnAssignPackages()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*
                FROM packages."Packages"
                WHERE packages."Packages"."AgentUID" = 0
                ORDER BY packages."Packages"."Name" ASC  ';
//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }

    public
    function ListUnAssignPackagesByID($id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*
                FROM packages."Packages"
                WHERE packages."Packages"."AgentUID" = 0 && packages."Packages"."UID" = \'' . $id . '\' 
                ORDER BY packages."Packages"."Name" ASC  ';
//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }


    public
    function ListPackagesByID($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" = \'B2B\' 
                AND (packages."Packages"."AgentUID" = ' . $ID . '  OR main."Agents"."ParentID"=' . $ID . ')
                ORDER BY packages."Packages"."Name" ASC  ';
        //echo $SQL;exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }


    public
    function LoadListPackages()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" != \'B2C\' AND main."Agents"."Type" != \'external_agent\' 
                ORDER BY packages."Packages"."Name" ASC  ';
//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function LoadAgentListPackages()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" != \'B2C\'
                AND (packages."Packages"."AgentUID" = ' . $data['session']['agent_id'] . ' OR main."Agents"."ParentID"=' . $data['session']['agent_id'] . ') 
                ORDER BY packages."Packages"."Name" ASC  ';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;


    }

    public
    function ListPackagesForExternalAgents()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" = \'B2B\' AND main."Agents"."Type" = \'external_agent\'
                ORDER BY packages."Packages"."Name" ASC ';

//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }

    public
    function ListPackagesForExternalAgentsWithGeneralPackageToo()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages"
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" != \'B2C\' AND main."Agents"."Type" = \'external_agent\'
                ORDER BY packages."Packages"."Name" ASC  ';

//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

//        $Crud = new Crud();
//        $table = 'packages."Packages"';
//        $where = array("Archive" => "0");
//        $order = array();
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;

    }

    public
    function LisGeneralPackageOnly()
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT packages."Packages".*
                FROM packages."Packages"
                WHERE packages."Packages"."PackageType" = \'B2B_General\'
                ORDER BY packages."Packages"."Name" ASC  ';
//        echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function ListB2CPackages()
    {

        $Crud = new Crud();

        $SQL = 'SELECT packages."Packages".*, main."Agents"."FullName" as agentname
                FROM packages."Packages" 
                LEFT JOIN main."Agents" ON main."Agents"."UID" = packages."Packages"."AgentUID" 
                WHERE packages."Packages"."PackageType" = \'B2C\'
                ORDER BY packages."Packages"."Name" ASC  ';


        $records = $Crud->ExecuteSQL($SQL);
        //  echo $SQL;
        return $records;


    }


    public
    function PackageData($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Packages"';
        $where = array("UID" => $record_id);
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListZiyarats()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Ziyarats"';
        $where = array("Archive" => "0");
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListZiyaratsByDomainID($ID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Ziyarats"';
        $where = array("Archive" => "0", "WebsiteDomain" => $ID);
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListPackagesByAgentID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Packages"';
        $where = array("AgentUID" => $record_id);
        $record = $Crud->SingleRecord($table, $where);

        return $record;

    }

    public
    function DefaultHotelRoomTypes()
    {
        $records = array("Double, Tripple, Quad, Quint, Sharing");
        ksort($records);
        return $records;
    }

    public
    function ListRoomTypes()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Hotels"';
        $where = array("Archive" => "0");
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function DeleteTransport($UID)
    {

        $Crud = new Crud();
        $table = 'packages."Transport"';
        $record['Archive'] = "1";
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteZiyarat($UID)
    {

        $Crud = new Crud();
        $MainTable = 'packages."Ziyarats"';
        $record['Archive'] = "1";
        $wher = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($MainTable, $wher);
        $GetZiyrtId = $data['records']['UID'];

        $table = 'packages."Meta"';
        $where = array("ReferenceID" => $GetZiyrtId);
        $imgdata['DeleteMetas'] = $Crud->ListRecords($table, $where);
        $Crud->DeleteRecord($table, $where);

        if ($Crud->UpdateRecord($MainTable, $record, $wher)) {
            $response['status'] = "success";
            $tables = 'uploads."Files"';
            foreach ($imgdata['DeleteMetas'] as $item) {
                $wheres = array("UID" => $item['Value']);
                $Crud->DeleteRecord($tables, $wheres);
            }
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteHotels($UID)
    {

        $Crud = new Crud();
        $MainTable = 'packages."Hotels"';
        $record['Archive'] = "1";
        $wher = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($MainTable, $wher);
        $GetHotelID = $data['records']['UID'];

        $table = 'packages."HotelImage"';
        $where = array("HotelID" => $GetHotelID);
        $imgdata['DeleteMetas'] = $Crud->ListRecords($table, $where);
        $Crud->DeleteRecord($table, $where);
//
//        print_r($imgdata['DeleteMetas']);

        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($MainTable, $record, $where)) {
            $response['status'] = "success";
            $tables = 'uploads."Files"';
            foreach ($imgdata['DeleteMetas'] as $item) {
                $wheres = array("UID" => $item['ImageID']);
                $Crud->DeleteRecord($tables, $wheres);
            }
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function TransportsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Transport"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function HotelsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Hotels"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function HotelsMeta($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Meta"';
        $where = array("ReferenceType" => 'Hotel', "ReferenceID" => $record_id);
        $records = $Crud->ListRecords($table, $where);

        $Final = array();
        foreach ($records as $record) {
            $Final[$record['Option']][] = $record['Value'];
        }
        return $Final;
    }

    public
    function ZiyaratsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Ziyarats"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function ZiyaratsMetaData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."Meta"';
        $where = array("ReferenceID" => $record_id);
        $records = $Crud->ListRecords($table, $where);

        $final = array();
        foreach ($records as $record) {
            if ($record['Option'] == 'GalleryImages') {
                $final['GalleryImages'][] = $record['Value'];
            } else {
                $final[$record['Option']] = $record['Value'];
            }
        }


        return $final;
    }

    public
    function HotelImages($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."HotelImage"';
        $where = array("HotelID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
//        print_r($records);
        return $records;
    }

    public
    function TransportImages($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'packages."TransportImage"';
        $where = array("TransportID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
//        print_r($records);
        return $records;
    }

    public
    function DeleteHotelImage($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."HotelImage"';
        $where = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($table, $where);

        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

            $tables = 'uploads."Files"';
            $wheres = array("UID" => $data['records']['ImageID']);
            $Crud->DeleteRecord($tables, $wheres);

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteTransportImage($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."TransportImage"';
        $where = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($table, $where);

        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";

            $tables = 'uploads."Files"';
            $wheres = array("UID" => $data['records']['FileID']);
            $Crud->DeleteRecord($tables, $wheres);

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteTransportCoverImage($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Transport"';
        $where = array("CoverImage" => $UID);
        $data['records'] = $Crud->SingleRecord($table, $where);
        $record['CoverImage'] = '0';
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
            $tables = 'uploads."Files"';
            $wheres = array("UID" => $data['records']['CoverImage']);
            $Crud->DeleteRecord($tables, $wheres);

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function DeleteZiyaratImage($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'uploads."Files"';
        $where = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($table, $where);

        if ($Crud->DeleteRecord($table, $where)) {
            $response['status'] = "success";
            $tables = 'packages."Meta"';
            $wheres = array("Value" => $data['records']['UID']);
            $Crud->DeleteRecord($tables, $wheres);

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }


    public
    function DuplicateCopyPackageForExternalAgent($PackageID, $AgentID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $view = false;

        if ($view) {
            echo "<pre>";
            echo "Package ID: " . $PackageID . "<hr>";
        }

        //////////////////////////// Package DATA
        $table = 'packages."Packages"';
        $where = array("UID" => $PackageID);
        $CurrentPackage = $Crud->SingleRecord($table, $where);
        //////////////////////////// ServiceRate DATA
        $table = 'packages."ServiceRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageServiceRates = $Crud->ListRecords($table, $where);
        //////////////////////////// HotelsRate DATA
        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageHotelsRates = $Crud->ListRecords($table, $where);
        //////////////////////////// TransportRate DATA
        $table = 'packages."TransportRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageTransportRates = $Crud->ListRecords($table, $where);
        //////////////////////////// ZiyaratsRate DATA
        $table = 'packages."ZiyaratsRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageZiyaratsRates = $Crud->ListRecords($table, $where);

        if ($view) {
            echo "Package Data: <br>" . print_r($CurrentPackage) . "<hr>";
        }

        if ($AgentID == 0) {
            echo ($view) ? "Multiple Agents : <br>" : '';
            $Agent = new Agents();
            $AllAgents = $Agent->ListExternalAgents();
            foreach ($AllAgents as $AllAgent) {
                $NewAgent = $AllAgent['UID'];
                if ($CurrentPackage['AgentUID'] != $NewAgent) {
                    echo ($view) ? "New Agent: " . $NewAgent . "<hr>" : '';
                    $Crud->UpdateRecord('packages."Packages"', array("AgentUID" => 0), array("AgentUID" => $NewAgent));


                    $NewPackge = $CurrentPackage;
                    unset($NewPackge['UID']);
                    unset($NewPackge['SystemDate']);
                    unset($NewPackge['Archive']);
                    $NewPackge['AgentUID'] = $NewAgent;
                    $NewPackge['PackageType'] = "B2B";
                    echo ($view) ? "Copy Package: <br>" . print_r($NewPackge) . "<hr>" : '';

                    $NewPackgeID = $Crud->AddRecord('packages."Packages"', $NewPackge);

                    foreach ($CurrentPackageHotelsRates as $CurrentPackageHotelsRate) {
                        $NewPackgeHotelsRate = $CurrentPackageHotelsRate;
                        unset($NewPackgeHotelsRate['UID']);
                        unset($NewPackgeHotelsRate['SystemDate']);
                        $NewPackgeHotelsRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package HotelsRate: <br>" . print_r($NewPackgeHotelsRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."HotelsRate"', $NewPackgeHotelsRate);
                    }

                    foreach ($CurrentPackageServiceRates as $CurrentPackageServiceRate) {
                        $NewPackgeServiceRate = $CurrentPackageServiceRate;
                        unset($NewPackgeServiceRate['UID']);
                        unset($NewPackgeServiceRate['SystemDate']);
                        $NewPackgeServiceRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package ServiceRate: <br>" . print_r($NewPackgeServiceRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."ServiceRate"', $NewPackgeServiceRate);
                    }

                    foreach ($CurrentPackageTransportRates as $CurrentPackageTransportRate) {
                        $NewPackgeTransportRate = $CurrentPackageTransportRate;
                        unset($NewPackgeTransportRate['UID']);
                        unset($NewPackgeTransportRate['SystemDate']);
                        $NewPackgeTransportRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package TransportRate: <br>" . print_r($NewPackgeTransportRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."TransportRate"', $NewPackgeTransportRate);
                    }

                    foreach ($CurrentPackageZiyaratsRates as $CurrentPackageZiyaratsRate) {
                        $NewPackgeZiyaratsRate = $CurrentPackageZiyaratsRate;
                        unset($NewPackgeZiyaratsRate['UID']);
                        unset($NewPackgeZiyaratsRate['SystemDate']);
                        $NewPackgeZiyaratsRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package ZiyaratsRate: <br>" . print_r($NewPackgeZiyaratsRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."ZiyaratsRate"', $NewPackgeZiyaratsRate);
                    }


                }
            }

            $response['status'] = "success";
            $response['message'] = "Package Assigned To All Existing Agents";

        } else {
            echo ($view) ? "Single Agent: " . $AgentID . "<hr>" : '';
            $NewAgent = $AgentID;
            if ($CurrentPackage['AgentUID'] != $NewAgent) {
                echo ($view) ? "New Agent: " . $NewAgent . "<hr>" : '';
                $Crud->UpdateRecord('packages."Packages"', array("AgentUID" => 0), array("AgentUID" => $NewAgent));


                $NewPackge = $CurrentPackage;
                unset($NewPackge['UID']);
                unset($NewPackge['SystemDate']);
                unset($NewPackge['Archive']);
                $NewPackge['AgentUID'] = $NewAgent;
                $NewPackge['PackageType'] = "B2B";

                echo ($view) ? "Copy Package: <br>" . print_r($NewPackge) . "<hr>" : '';

                $NewPackgeID = $Crud->AddRecord('packages."Packages"', $NewPackge);

                foreach ($CurrentPackageHotelsRates as $CurrentPackageHotelsRate) {
                    $NewPackgeHotelsRate = $CurrentPackageHotelsRate;
                    unset($NewPackgeHotelsRate['UID']);
                    unset($NewPackgeHotelsRate['SystemDate']);
                    $NewPackgeHotelsRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package HotelsRate: <br>" . print_r($NewPackgeHotelsRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."HotelsRate"', $NewPackgeHotelsRate);
                }

                foreach ($CurrentPackageServiceRates as $CurrentPackageServiceRate) {
                    $NewPackgeServiceRate = $CurrentPackageServiceRate;
                    unset($NewPackgeServiceRate['UID']);
                    unset($NewPackgeServiceRate['SystemDate']);
                    $NewPackgeServiceRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package ServiceRate: <br>" . print_r($NewPackgeServiceRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."ServiceRate"', $NewPackgeServiceRate);
                }

                foreach ($CurrentPackageTransportRates as $CurrentPackageTransportRate) {
                    $NewPackgeTransportRate = $CurrentPackageTransportRate;
                    unset($NewPackgeTransportRate['UID']);
                    unset($NewPackgeTransportRate['SystemDate']);
                    $NewPackgeTransportRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package TransportRate: <br>" . print_r($NewPackgeTransportRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."TransportRate"', $NewPackgeTransportRate);
                }

                foreach ($CurrentPackageZiyaratsRates as $CurrentPackageZiyaratsRate) {
                    $NewPackgeZiyaratsRate = $CurrentPackageZiyaratsRate;
                    unset($NewPackgeZiyaratsRate['UID']);
                    unset($NewPackgeZiyaratsRate['SystemDate']);
                    $NewPackgeZiyaratsRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package ZiyaratsRate: <br>" . print_r($NewPackgeZiyaratsRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."ZiyaratsRate"', $NewPackgeZiyaratsRate);
                }


            }

            $response['status'] = "success";
            $response['message'] = "Package Assigned To Selected Agent";
        }
        echo json_encode($response);
    }

    public
    function DuplicateCopyPackage($PackageID, $AgentID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $view = false;

        if ($view) {
            echo "<pre>";
            echo "Package ID: " . $PackageID . "<hr>";
        }

        //////////////////////////// Package DATA
        $table = 'packages."Packages"';
        $where = array("UID" => $PackageID);
        $CurrentPackage = $Crud->SingleRecord($table, $where);
        //////////////////////////// ServiceRate DATA
        $table = 'packages."ServiceRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageServiceRates = $Crud->ListRecords($table, $where);
        //////////////////////////// HotelsRate DATA
        $table = 'packages."HotelsRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageHotelsRates = $Crud->ListRecords($table, $where);
        //////////////////////////// TransportRate DATA
        $table = 'packages."TransportRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageTransportRates = $Crud->ListRecords($table, $where);
        //////////////////////////// ZiyaratsRate DATA
        $table = 'packages."ZiyaratsRate"';
        $where = array("PackageUID" => $PackageID);
        $CurrentPackageZiyaratsRates = $Crud->ListRecords($table, $where);

        if ($view) {
            echo "Package Data: <br>" . print_r($CurrentPackage) . "<hr>";
        }

        if ($AgentID == 0) {
            echo ($view) ? "Multiple Agents : <br>" : '';
            $Agent = new Agents();
            $AllAgents = $Agent->ListAgents();
            foreach ($AllAgents as $AllAgent) {
                $AgentD = $Crud->SingleRecord('main."Agents"', array("UID" => $AllAgent['UID']));
                $AgentName = $AgentD['FullName'];

                $NewAgent = $AllAgent['UID'];
                if ($CurrentPackage['AgentUID'] != $NewAgent) {
                    echo ($view) ? "New Agent: " . $NewAgent . "<hr>" : '';
                    $Crud->UpdateRecord('packages."Packages"', array("AgentUID" => 0), array("AgentUID" => $NewAgent));


                    $NewPackge = $CurrentPackage;
                    unset($NewPackge['UID']);
                    unset($NewPackge['SystemDate']);
                    unset($NewPackge['Archive']);
                    $NewPackge['Name'] = $AgentName . "-" . $NewPackge['Name'];
                    $NewPackge['AgentUID'] = $NewAgent;
                    $NewPackge['WebsiteDomain'] = $session['domainid'];
                    $NewPackge['PackageType'] = "B2B";
                    echo ($view) ? "Copy Package: <br>" . print_r($NewPackge) . "<hr>" : '';

                    $NewPackgeID = $Crud->AddRecord('packages."Packages"', $NewPackge);

                    foreach ($CurrentPackageHotelsRates as $CurrentPackageHotelsRate) {
                        $NewPackgeHotelsRate = $CurrentPackageHotelsRate;
                        unset($NewPackgeHotelsRate['UID']);
                        unset($NewPackgeHotelsRate['SystemDate']);
                        $NewPackgeHotelsRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package HotelsRate: <br>" . print_r($NewPackgeHotelsRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."HotelsRate"', $NewPackgeHotelsRate);
                    }

                    foreach ($CurrentPackageServiceRates as $CurrentPackageServiceRate) {
                        $NewPackgeServiceRate = $CurrentPackageServiceRate;
                        unset($NewPackgeServiceRate['UID']);
                        unset($NewPackgeServiceRate['SystemDate']);
                        $NewPackgeServiceRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package ServiceRate: <br>" . print_r($NewPackgeServiceRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."ServiceRate"', $NewPackgeServiceRate);
                    }

                    foreach ($CurrentPackageTransportRates as $CurrentPackageTransportRate) {
                        $NewPackgeTransportRate = $CurrentPackageTransportRate;
                        unset($NewPackgeTransportRate['UID']);
                        unset($NewPackgeTransportRate['SystemDate']);
                        $NewPackgeTransportRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package TransportRate: <br>" . print_r($NewPackgeTransportRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."TransportRate"', $NewPackgeTransportRate);
                    }

                    foreach ($CurrentPackageZiyaratsRates as $CurrentPackageZiyaratsRate) {
                        $NewPackgeZiyaratsRate = $CurrentPackageZiyaratsRate;
                        unset($NewPackgeZiyaratsRate['UID']);
                        unset($NewPackgeZiyaratsRate['SystemDate']);
                        $NewPackgeZiyaratsRate['PackageUID'] = $NewPackgeID;
                        echo ($view) ? "Current Package ZiyaratsRate: <br>" . print_r($NewPackgeZiyaratsRate) . "<hr>" : '';
                        $Crud->AddRecord('packages."ZiyaratsRate"', $NewPackgeZiyaratsRate);
                    }


                }
            }

            $response['status'] = "success";
            $response['message'] = "Package Assigned To All Existing Agents";

        } else {
            echo ($view) ? "Single Agent: " . $AgentID . "<hr>" : '';
            $NewAgent = $AgentID;
            if ($CurrentPackage['AgentUID'] != $NewAgent) {
                echo ($view) ? "New Agent: " . $NewAgent . "<hr>" : '';
                $Crud->UpdateRecord('packages."Packages"', array("AgentUID" => 0), array("AgentUID" => $NewAgent));
                $AgentD = $Crud->SingleRecord('main."Agents"', array("UID" => $AgentID));
                $AgentName = $AgentD['FullName'];

                $NewPackge = $CurrentPackage;
                unset($NewPackge['UID']);
                unset($NewPackge['SystemDate']);
                unset($NewPackge['Archive']);
                $NewPackge['Name'] = $AgentName . "-" . $NewPackge['Name'];
                $NewPackge['AgentUID'] = $NewAgent;
                $NewPackge['WebsiteDomain'] = $session['domainid'];
                $NewPackge['PackageType'] = "B2B";

                echo ($view) ? "Copy Package: <br>" . print_r($NewPackge) . "<hr>" : '';

                $NewPackgeID = $Crud->AddRecord('packages."Packages"', $NewPackge);

                foreach ($CurrentPackageHotelsRates as $CurrentPackageHotelsRate) {
                    $NewPackgeHotelsRate = $CurrentPackageHotelsRate;
                    unset($NewPackgeHotelsRate['UID']);
                    unset($NewPackgeHotelsRate['SystemDate']);
                    $NewPackgeHotelsRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package HotelsRate: <br>" . print_r($NewPackgeHotelsRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."HotelsRate"', $NewPackgeHotelsRate);
                }

                foreach ($CurrentPackageServiceRates as $CurrentPackageServiceRate) {
                    $NewPackgeServiceRate = $CurrentPackageServiceRate;
                    unset($NewPackgeServiceRate['UID']);
                    unset($NewPackgeServiceRate['SystemDate']);
                    $NewPackgeServiceRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package ServiceRate: <br>" . print_r($NewPackgeServiceRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."ServiceRate"', $NewPackgeServiceRate);
                }

                foreach ($CurrentPackageTransportRates as $CurrentPackageTransportRate) {
                    $NewPackgeTransportRate = $CurrentPackageTransportRate;
                    unset($NewPackgeTransportRate['UID']);
                    unset($NewPackgeTransportRate['SystemDate']);
                    $NewPackgeTransportRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package TransportRate: <br>" . print_r($NewPackgeTransportRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."TransportRate"', $NewPackgeTransportRate);
                }

                foreach ($CurrentPackageZiyaratsRates as $CurrentPackageZiyaratsRate) {
                    $NewPackgeZiyaratsRate = $CurrentPackageZiyaratsRate;
                    unset($NewPackgeZiyaratsRate['UID']);
                    unset($NewPackgeZiyaratsRate['SystemDate']);
                    $NewPackgeZiyaratsRate['PackageUID'] = $NewPackgeID;
                    echo ($view) ? "Current Package ZiyaratsRate: <br>" . print_r($NewPackgeZiyaratsRate) . "<hr>" : '';
                    $Crud->AddRecord('packages."ZiyaratsRate"', $NewPackgeZiyaratsRate);
                }


            }

            $response['status'] = "success";
            $response['message'] = "Package Assigned To Selected Agent";
        }
        echo json_encode($response);
    }


    public function PackageApprovalFormSubmit($CurrentDate, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Packages"';
        $where = array("AgentUID" => $UID);

        $records['ApprovalDate'] = $CurrentDate;
        $Crud->UpdateRecord($table, $records, $where);
        $response['status'] = "success";
        $response['message'] = "Package Approved Successfully ...";


        echo json_encode($response);
    }
}
