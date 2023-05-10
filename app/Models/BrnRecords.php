<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;

class BrnRecords extends Model
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function GetLessUsedBrn($BRNArray)
    {

        $Crud = new Crud();
        $SQL = ' SELECT "brn"."UID", "brn"."BRNCode", "brn"."ExpireDate",
                    (CASE 
                        WHEN ( "brn"."UseType" = \'Visa\' ) THEN "brn"."Beds"
                        WHEN ( "brn"."UseType" = \'visa_and_hotel\' ) THEN "brn"."Beds"
                        WHEN ( "brn"."UseType" = \'visa_and_transport\' ) THEN "brn"."Seats"
                    END ) AS "ActualBRN",
                    ( SELECT COUNT( "meta"."UID" ) FROM pilgrim."meta"
                        WHERE "meta"."Option" = \'mofa-issued-brn\' 
                          AND CAST("meta"."Value" AS INTEGER) = CAST("BRN"."brn"."UID" AS INTEGER)
                        AND "meta"."Value" != \'\' ) AS "UsedBRN"
                    FROM "BRN"."brn"
                    WHERE "BRN"."brn"."UID" IN (' . $BRNArray . ') ';
        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                WHERE ( CAST("MainQuery"."UsedBRN" AS INTEGER) < CAST("MainQuery"."ActualBRN" AS INTEGER) ) 
                ORDER BY "MainQuery"."ExpireDate" ASC 
                LIMIT 1';
        $BrnRecord = $Crud->ExecuteSQL($SQL);

        return $BrnRecord[0];
    }

    public function BRNFormSubmit($records, $UID, $Record)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."brn"';

        if ($UID == 0) {
            $Crud->Track("BRN", 'New BRN "' . $records['BRNCode'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "BRN Successfully Added...";
        } else {
            $records['ModifiedBy'] = $Record['ModifiedBy'];
            $records['ModifiedDate'] = $Record['ModifiedDate'];
            $Crud->Track("BRN", 'BRN "' . $records['BRNCode'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "BRN Updated...";
        }


        echo json_encode($response);
    }

    public function BRNPromoCodeFormSubmit($records, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."PromoCode"';

        if ($UID == 0) {
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "BRN Promo Code Successfully Added...";
        } else {
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "BRN Promo Code Updated...";
        }


        echo json_encode($response);
    }

    public
    function DeleteBRNPromoCode($UID)
    {

        $Crud = new Crud();
        $table = 'BRN."PromoCode"';
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
    function BRNPromoDataByID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."PromoCode"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function ListHotelsData()
    {

        $Crud = new Crud();
        $SQL = ' SELECT "Hotels"."UID", "Hotels"."Name", "Cities"."Name" AS "City"
                 FROM "packages"."Hotels"
                JOIN main."Cities" ON ( "Cities"."UID" = "Hotels"."CityID" ) 
                WHERE "packages"."Hotels"."Archive" = 0 
                ORDER BY "packages"."Hotels"."Name" ASC';
        $record = $Crud->ExecuteSQL($SQL);
        return $record;
    }

    public
    function ListBRNPromoCodeData()
    {
        $Crud = new Crud();

        $SQL = ' SELECT "BRN"."PromoCode".*, 
                "Agents"."FullName" AS "Agent","main"."Cities"."Name" as "CityName",
                "Hotels"."Name" AS "Hotel"
                FROM "BRN"."PromoCode"
                LEFT JOIN main."Agents" ON ( "Agents"."UID" = "PromoCode"."AgentUID" ) 
                LEFT JOIN packages."Hotels" ON ( "Hotels"."UID" = "PromoCode"."HotelUID" ) 
                LEFT JOIN main."Cities" ON (main."Cities"."UID" = packages."Hotels"."CityID") 
                WHERE "BRN"."PromoCode"."Archive" = 0  
                ';
        $SQL .= ' ORDER BY "BRN"."PromoCode"."ExpiryDate" ASC   ';
//          echo $SQL;exit;
        $Records = $Crud->ExecuteSQL($SQL);
        return $Records;

    }

    public function UseBRNFormSubmit($records, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."UseBRN"';

        if ($UID == 0) {
            $Crud->Track("BRN", 'New Use BRN "' . $records['BRNCode'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Use BRN Successfully Added...";
        } else {
            $Crud->Track("BRN", 'Use BRN "' . $records['BRNCode'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "BRN Updated...";
        }


        echo json_encode($response);
    }


    public
    function DeleteBRN($UID)
    {

        $Crud = new Crud();
        $table = 'BRN."brn"';
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
    function DeleteUseBRN($UID)
    {

        $Crud = new Crud();
        $table = 'BRN."UseBRN"';
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
    function BRNDataByID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."brn"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }


    public
    function UseBRNDataByID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."UseBRN"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function BRNVisaDataByID($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'BRN."UseBRN"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function ListHotelBRNData($Keyword = '')
    {
        $Crud = new Crud();

        $keywordInt = '';
        if (isset($Keyword) && $Keyword != '') {
            $Keyword = strtolower($Keyword);
            $keywordInt = (int)$Keyword;
        }

        $SQL = ' SELECT "BRN"."brn".*,"packages"."Hotels"."Name" as "HotelName", "BRN"."PromoCode"."PromoCode" as "PromoCodeName" ,
                "packages"."Hotels"."CityID" as "HotelCity",main."Operators"."CompanyName" as "CompanyName",main."Agents"."FullName" as "AgentName"
                FROM "BRN"."brn"
                LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID" 
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                  LEFT JOIN "BRN"."PromoCode" ON CAST("BRN"."PromoCode"."UID" as TEXT) = CAST("BRN"."brn"."PromoCode" as TEXT)
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                 WHERE "BRN"."brn"."Archive" = 0 AND "BRN"."brn"."BRNType" = \'hotel\'  ';

        /** Filters Start */

        if (isset($_POST['expire_status']) && $_POST['expire_status'] == 'yes') {
            $SQL .= ' AND  "BRN"."brn"."ExpireDate" <= \'' . date("Y-m-d") . '\' ';
        } else {
            /*$SQL.=' AND  "BRN"."brn"."ExpireDate" > \''.date("Y-m-d").'\' ';*/
        }

        if (isset($_POST['hotel_name']) && trim($_POST['hotel_name']) != '') {
            $SQL .= ' AND LOWER("packages"."Hotels"."Name") LIKE  \'%' . strtolower(trim($_POST['hotel_name'])) . '%\' ';
        }

        if (isset($_POST['brn_code']) && trim($_POST['brn_code']) != '') {
            $SQL .= ' AND "BRN"."brn"."BRNCode" = \'' . trim($_POST['brn_code']) . '\' ';
        }

        if (isset($_POST['create_date_from']) && $_POST['create_date_from'] != '' && isset($_POST['create_date_to']) && $_POST['create_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['create_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';

        /*if($Keyword != ''){

            if (is_int($keywordInt) && strlen($Keyword) == strlen($keywordInt)){
                $SQL = ' SELECT * FROM ( '.$SQL.' ) AS "MainQuery"
                        WHERE "MainQuery"."BRNCode" LIKE \'%'.$keywordInt.'%\' ';
            }else{

                $SQL = ' SELECT * FROM ( '.$SQL.' ) AS "MainQuery"
                            WHERE LOWER("MainQuery"."CompanyName") LIKE \'%'.strtolower(trim($Keyword)).'%\'
                             OR LOWER("MainQuery"."PurchaseID") LIKE \'%'.strtolower(trim($Keyword)).'%\'
                             OR "MainQuery"."BRNCode" LIKE \'%'.trim($Keyword).'%\'
                             OR LOWER( "MainQuery"."HotelName" ) LIKE \'%'.strtolower(trim($Keyword)).'%\' ';
            }

        }*/

//       echo nl2br($SQL);
        //$Records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function ListUseBRNData()
    {
        $Crud = new Crud();

        $SQL = ' SELECT "BRN"."UseBRN".*
                 FROM "BRN"."UseBRN"
                 WHERE "BRN"."UseBRN"."Archive" = 0 ';
        $SQL .= ' ORDER BY "BRN"."UseBRN"."BRNCode" ASC   ';
        // echo $SQL;
        $Records = $Crud->ExecuteSQL($SQL);
        return $Records;

    }


    public
    function ListBRNData()
    {

        $Crud = new Crud();
        $SQL = '
                SELECT  "BRN"."brn".*, main."Operators"."CompanyName" as "CompanyName",main."Agents"."FullName" as "AgentName",
                "BRN"."PromoCode"."PromoCode" as "PromoCodeName" FROM "BRN"."brn"
                LEFT JOIN main."Operators" ON (CAST("BRN"."brn"."Operator" as INTEGER) = main."Operators"."UID")
                LEFT JOIN "BRN"."PromoCode" ON CAST("BRN"."PromoCode"."UID" as TEXT) = CAST("BRN"."brn"."PromoCode" as TEXT)
                 LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                WHERE "BRN"."brn"."Archive" =  0 AND "BRN"."brn"."BRNType" = \'transport\'  ';

        /** Filters Start */
        if (isset($_POST['expire_status']) && $_POST['expire_status'] == 'yes') {
            $SQL .= ' AND  "BRN"."brn"."ExpireDate" <= \'' . date("Y-m-d") . '\' ';
        } else {
            /*$SQL.=' AND  "BRN"."brn"."ExpireDate" > \''.date("Y-m-d").'\' ';*/
        }

        if (isset($_POST['purchase_id']) && trim($_POST['purchase_id']) != '') {
            $SQL .= ' AND "BRN"."brn"."PurchaseID" = \'' . trim($_POST['purchase_id']) . '\' ';
        }

        if (isset($_POST['brn_code']) && trim($_POST['brn_code']) != '') {
            $SQL .= ' AND "BRN"."brn"."BRNCode" = \'' . trim($_POST['brn_code']) . '\' ';
        }

        if (isset($_POST['create_date_from']) && $_POST['create_date_from'] != '' && isset($_POST['create_date_to']) && $_POST['create_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['create_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC   ';

        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }


    /** Code
     * Start
     * By Jawad Sajid*/

    /** Hotel BRN Functions */

    public
    function count_hotel_brn_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListHotelBRNData();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_hotel_brn_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ListHotelBRNData();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Transport BRN Functions */

    public
    function count_transport_brn_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListBRNData();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_transport_brn_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ListBRNData();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Code
     * Ends
     * By Jawad Sajid*/


}
