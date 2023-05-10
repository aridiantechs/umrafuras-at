<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;
use mysql_xdevapi\Session;


class Activities extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;

        //$this->data['session'] = session()->get();
    }

    public function get_allow_hotel_activity_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsAllowHotelActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL);exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }


    public
    function VouchersForPilgrimsAllowHotelActivityPrevious($allow = false)
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowHotelSessionFilters'];
        // print_r($SessionFilters);exit;

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
                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID") AS "Voucher_pilgrim",
                ( CASE 
                    WHEN main."LookupsOptions"."Name" = \'Quint Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 5)
                    WHEN main."LookupsOptions"."Name" = \'Quad Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 4)
                    WHEN main."LookupsOptions"."Name" = \'Triple Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 3)
                    WHEN main."LookupsOptions"."Name" = \'Double Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 2)
                    WHEN main."LookupsOptions"."Name" = \'Single Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                    WHEN main."LookupsOptions"."Name" = \'Sharing\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                    ELSE (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                  END  ) AS "VoucherActivityPilgrims"
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

//        echo $SQL; exit();
//        echo nl2br($SQL); exit();

        return $SQL;
    }

    public
    function VouchersForPilgrimsAllowHotelActivity($allow = false)
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowHotelSessionFilters'];
        // print_r($SessionFilters);exit;

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
                
                ( CASE 
                    WHEN main."LookupsOptions"."Name" = \'Quint Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 5)
                    WHEN main."LookupsOptions"."Name" = \'Quad Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 4)
                    WHEN main."LookupsOptions"."Name" = \'Triple Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 3)
                    WHEN main."LookupsOptions"."Name" = \'Double Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 2)
                    WHEN main."LookupsOptions"."Name" = \'Single Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                    WHEN main."LookupsOptions"."Name" = \'Sharing\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                    ELSE (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
                  END  ) AS "VoucherActivityPilgrims"
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  voucher."AccommodationDetails"."Hotel" = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID"
                LEFT JOIN main."LookupsOptions" ON voucher."AccommodationDetails"."RoomType" = main."LookupsOptions"."UID"
                WHERE voucher."Master"."Archive"  = 0 
                AND voucher."AccommodationDetails"."Hotel" >=0 
                AND voucher."AccommodationDetails"."RoomType" >=0 
                /*AND voucher."AccommodationDetails"."Self" = 0 */ ';


//        if (!isset($SessionFilters['completed'])) {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
//        }

        /** Filters Start */
//


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
        if (!isset($SessionFilters['check_in_date_from']) && !isset($SessionFilters['check_in_date_to'])) {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" = CURRENT_DATE ';
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
//echo $SQL; exit();
        //     echo nl2br($SQL); exit();
//         echo $SQL; exit();

        return $SQL;
    }




//    public
//    function VouchersForPilgrimsAllowHotelActivity($allow = false)
//    {
//        $session = session();
//        $session = $session->get();
//        $SessionFilters = $session['AllowHotelSessionFilters'];
//        // print_r($SessionFilters);exit;
//
//        $Crud = new Crud();
//        $SQL = 'SELECT 
//                voucher."AccommodationDetails".*, 
//                main."Agents"."FullName" as "AgentName", 
//                voucher."Master"."UID" as "VoucherID",
//                voucher."Master"."VoucherCode" as "VoucherCode",
//                voucher."Master"."ArrivalDate" as "ArrivalDate",
//                packages."Hotels"."Name" as "HotelName",
//                main."Countries"."Name" as "Country",
//                main."Cities"."Name" as "CityName",
//                main."LookupsOptions"."Name" AS "RoomTypeName",
//                voucher."Master"."ReturnDate" as "ReturnDate", 
//                main."Agents"."ParentID" as "AgentParentID",
//                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",
//                count(DISTINCT voucher."Pilgrim"."PilgrimUID") AS "Voucher_pilgrim",
//                ( CASE 
//                    WHEN main."LookupsOptions"."Name" = \'Quint Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 5)
//                    WHEN main."LookupsOptions"."Name" = \'Quad Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 4)
//                    WHEN main."LookupsOptions"."Name" = \'Triple Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 3)
//                    WHEN main."LookupsOptions"."Name" = \'Double Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 2)
//                    WHEN main."LookupsOptions"."Name" = \'Single Bed\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
//                    WHEN main."LookupsOptions"."Name" = \'Sharing\' THEN (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
//                    ELSE (CAST(voucher."AccommodationDetails"."NoOfBeds" AS INTEGER) * 1)
//                  END  ) AS "VoucherActivityPilgrims"
//                FROM voucher."AccommodationDetails"
//                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
//                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
//                LEFT JOIN packages."Hotels" ON  (cast(voucher."AccommodationDetails"."Hotel" as int)) = packages."Hotels"."UID"
//                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
//                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
//                LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int))
//                LEFT JOIN main."LookupsOptions" ON (cast(voucher."AccommodationDetails"."RoomType"  as int) = main."LookupsOptions"."UID")
//                LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
//                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID" 
//                WHERE voucher."Pilgrim"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND pilgrim."meta"."Option" LIKE \'%allow-htl%\' 
//                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-mecca-contact-number%\' 
//                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-medina-contact-number%\' 
//                AND pilgrim."meta"."Option" NOT LIKE \'%allow-htl-jeddah-contact-number%\'
//                AND pilgrim."meta"."AllowReference" = voucher."AccommodationDetails"."UID"
//                AND voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."Hotel" != \'\' 
//                AND voucher."AccommodationDetails"."RoomType" != \'\' 
//                /*AND voucher."AccommodationDetails"."Self" = 0 */ ';
//
//
////        if (!isset($SessionFilters['completed'])) {
////            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
////        }
//
//        /** Filters Start */
////
//
//
//        if ($session['domainid'] > 0) {
//            $SQL .= 'AND voucher."Master"."WebsiteDomain" = ' . $session['domainid'];
//        }
//        if ($allow) {
//            //////////////////// ADD ALLOWED Where condition
//            ///
//        }
//
//        if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
//            $SQL .= ' AND voucher."Master"."UID"  = ' . $SessionFilters['VoucherId'] . ' ';
//
//        }
//        if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['AgentCountry'] . '\' ';
//
//        }
//        if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
//            $SQL .= ' AND main."Agents"."UID"  = ' . $SessionFilters['Agents'] . ' ';
//
//        }
//        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
//            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
//
//        }
//        if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
//            $SQL .= ' AND voucher."AccommodationDetails"."City" = \'' . $SessionFilters['City'] . '\' ';
//
//        }
//        if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
//            $SQL .= ' AND voucher."AccommodationDetails"."Hotel" = \'' . $SessionFilters['hotel'] . '\' ';
//
//        }
//        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
//            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
//        }
//        if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '' && isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
//            $SQL .= ' AND voucher."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_out_date_to'])) . '\' ';
//        }
//        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
//        }
//        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
//            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
//        }
//
//        $SQL .= 'GROUP BY 
//        voucher."AccommodationDetails"."UID",
//        voucher."Master"."VoucherCode",
//        voucher."AccommodationDetails"."Self",
//        voucher."Master"."UID",
//        packages."Hotels"."Name",
//        main."Agents"."UID",
//        voucher."Master"."ReturnDate", 
//        main."Countries"."Name",
//        main."Cities"."Name",
//        main."LookupsOptions"."Name",
//        voucher."AccommodationDetails"."RoomType",
//        voucher."Master"."ArrivalDate" 
//        ORDER BY voucher."AccommodationDetails"."CheckIn" ASC';
//
////        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';
//
//        //echo nl2br($SQL); exit();
//        // $records = $Crud->ExecuteSQL($SQL);
////        $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
//
////        echo $SQL; exit();
////        echo nl2br($SQL); exit();
//
//        return $SQL;
//    }


    public function count_allow_hotel_activity_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsAllowHotelActivity();
//        $SQL = $this->TotalCountVouchersForPilgrimsAllowHotelActivity();
        $records = $Crud->ExecuteSQL($SQL);
        // echo'<pre>';print_r( $records );exit;
//        return $records[0]['TotalPax'];
        return count($records);
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
                WHERE packages."Transport"."UID" = CAST(voucher."TransportRate"."TransportTypeUID" AS INTEGER)  ) AS "TransportTypeName"
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
            $SQL .= ' AND voucher."TransportRate"."TravelCity" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['transport']) && $SessionFilters['transport'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TransportTypeUID" = \'' . $SessionFilters['transport'] . '\' ';

        }
        if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TravelType" = \'' . $SessionFilters['travel_type'] . '\' ';

        }
        if (isset($SessionFilters['Sector']) && $SessionFilters['Sector'] != '') {
            $SQL .= ' AND voucher."TransportRate"."Sectors" = \'' . $SessionFilters['Sector'] . '\' ';

        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }
        if (!isset($SessionFilters['arrival_date_from']) && !isset($SessionFilters['arrival_date_to'])) {
            $SQL .= ' AND voucher."TransportRate"."TravelDate"= CURRENT_DATE';
        }
        $SQL .= ' GROUP BY 
        voucher."TransportRate"."UID",
        voucher."Master"."VoucherCode", 
        voucher."TransportRate"."SelfTransport",
        main."LookupsOptions"."Name",
        voucher."Master"."UID",
        main."Agents"."UID",
        voucher."Master"."ReturnDate", 
        voucher."Master"."Country",
        voucher."Master"."ArrivalDate"
        ORDER BY voucher."TransportRate"."TravelDate" ASC ';
        //echo $SQL;exit();

        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }
        //echo $SQL;exit();

//        echo nl2br($SQL);
//        exit();
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    public
    function count_allow_transport_activity_filtered()
    {

        $Crud = new Crud();
//        $SQL = $this->TotalCountVouchersForPilgrimsAllowTransportActivity();
        $SQL = $this->VouchersForPilgrimsAllowTransportActivity();
        $records = $Crud->ExecuteSQL($SQL);
//        return $records[0]['TotalPax'];
        return count($records);

    }

    public
    function TotalCountVouchersForPilgrimsAllowTransportActivity()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllowTransportSessionFilters'];
        $Crud = new Crud();
        $SQL = 'SELECT
                count(DISTINCT(voucher."TransportRate"."UID")) AS "TotalPax"
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
            $SQL .= ' AND voucher."TransportRate"."TravelCity" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['transport']) && $SessionFilters['transport'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TransportTypeUID" = \'' . $SessionFilters['transport'] . '\' ';

        }
        if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TravelType" = \'' . $SessionFilters['travel_type'] . '\' ';

        }
        if (isset($SessionFilters['Sector']) && $SessionFilters['Sector'] != '') {
            $SQL .= ' AND voucher."TransportRate"."Sectors" = \'' . $SessionFilters['Sector'] . '\' ';

        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }

        /*$SQL .= 'GROUP BY voucher."TransportRate"."UID",voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';*/


        //echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            $SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            $SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }

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
    function CheckActualActivity($reference_id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = '
        SELECT DISTINCT (pilgrim."meta"."PilgrimUID") AS "PilgrimUID" FROM pilgrim."meta" 
         WHERE pilgrim."meta"."Option" LIKE \'allow-%\' AND pilgrim."meta"."AllowReference" = ' . $reference_id . '

        ';

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
//        $SQL = $this->TotalCountVouchersForPilgrimsActualHotelActivity();
        $SQL = $this->VouchersForPilgrimsActualHotelActivity();
        $records = $Crud->ExecuteSQL($SQL);
//        return $records[0]['TotalPax'];
        return count($records);
    }

    public
    function get_actual_hotel_activity_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->VouchersForPilgrimsActualHotelActivity();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_actual_transport_activity_filtered()
    {

        $Crud = new Crud();
//        $SQL = $this->TotalCountVouchersForPilgrimsActualTransportActivity();
        $SQL = $this->VouchersForPilgrimsActualTransportActivity();
        $records = $Crud->ExecuteSQL($SQL);
//        return $records[0]['TotalPax'];
        return count($records);
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
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax"
                FROM voucher."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN packages."Hotels" ON  voucher."AccommodationDetails"."Hotel" = packages."Hotels"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" 
                WHERE voucher."Master"."Archive"  = 0 AND voucher."AccommodationDetails"."Hotel" >0
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
        if (!isset($SessionFilters['check_in_date_from']) && !isset($SessionFilters['check_in_date_to'])) {
            $SQL .= ' AND voucher."AccommodationDetails"."CheckIn"=CURRENT_DATE ';
        }

        $SQL .= ' GROUP BY voucher."AccommodationDetails"."UID",voucher."Master"."VoucherCode",voucher."Master"."CurrentStatus",voucher."AccommodationDetails"."Self",voucher."Master"."UID",packages."Hotels"."Name",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate" 
                ORDER BY voucher."AccommodationDetails"."CheckIn" ASC LIMIT 200 ';
        //echo $SQL; exit();
        //$records = $Crud->ExecuteSQL($SQL);


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';
        //echo $SQL; exit();
        //  echo nl2br($SQL); exit();
        // $records = $Crud->ExecuteSQL($SQL);

        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }


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
            $SQL .= ' AND voucher."TransportRate"."TravelCity" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['transport']) && $SessionFilters['transport'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TransportTypeUID" = \'' . $SessionFilters['transport'] . '\' ';

        }
        if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TravelType" = \'' . $SessionFilters['travel_type'] . '\' ';

        }
        if (isset($SessionFilters['Sector']) && $SessionFilters['Sector'] != '') {
            $SQL .= ' AND voucher."TransportRate"."Sectors" = \'' . $SessionFilters['Sector'] . '\' ';

        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
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
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPax",
                ( SELECT main."LookupsOptions"."Name" FROM packages."Transport" 
                INNER JOIN main."LookupsOptions" ON (CAST(packages."Transport"."Type" AS INTEGER) = main."LookupsOptions"."UID")  
                WHERE packages."Transport"."UID" = CAST(voucher."TransportRate"."TransportTypeUID" AS INTEGER)  ) AS "TransportTypeName"
                FROM voucher."TransportRate"
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
            $SQL .= ' AND voucher."TransportRate"."TravelCity" = \'' . $SessionFilters['City'] . '\' ';

        }
        if (isset($SessionFilters['transport']) && $SessionFilters['transport'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TransportTypeUID" = \'' . $SessionFilters['transport'] . '\' ';

        }
        if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
            $SQL .= ' AND voucher."TransportRate"."TravelType" = \'' . $SessionFilters['travel_type'] . '\' ';

        }
        if (isset($SessionFilters['Sector']) && $SessionFilters['Sector'] != '') {
            $SQL .= ' AND voucher."TransportRate"."Sectors" = \'' . $SessionFilters['Sector'] . '\' ';

        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '' && isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."ReturnDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['return_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['return_date_to'])) . '\' ';
        }
        if (!isset($SessionFilters['arrival_date_from']) && !isset($SessionFilters['arrival_date_to'])) {
            $SQL .= ' AND voucher."TransportRate"."TravelDate"=CURRENT_DATE ';
        }
        $SQL .= 'GROUP BY voucher."TransportRate"."UID", main."Cities"."Name", voucher."Master"."VoucherCode", voucher."TransportRate"."SelfTransport",voucher."Master"."CurrentStatus",main."LookupsOptions"."Name",voucher."Master"."UID",main."Agents"."UID",voucher."Master"."ReturnDate", voucher."Master"."Country",voucher."Master"."ArrivalDate"
                    ORDER BY voucher."TransportRate"."TravelDate" ASC ';


        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" ';
        if (isset($SessionFilters['completed']) && $SessionFilters['completed'] == 'yes') {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" = "MainQuery"."Voucher_pilgrim" ';
        } else {
            //$SQL .= ' WHERE "MainQuery"."TotalPax" != "MainQuery"."Voucher_pilgrim" ';
        }


        // echo $SQL;exit();
        //  $records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

}
