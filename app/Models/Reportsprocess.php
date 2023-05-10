<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Api;
use App\Models\Agents;
use App\Models\Main;

class Reportsprocess extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $Main = new Main();
        $this->data['settings'] = $Main->Settings();
    }

    public
    function stats_b2b()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Relation",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) as "PilgrimAge",
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."Embassy" as "Embassy"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND main."Agents"."Type"=\'agent\' 
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function stats_b2c()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT pilgrim."master"."UID",
                pilgrim."master"."RegistrationDate",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                voucher."Master"."VoucherCode",
                main."Groups"."FullName" as "GroupName",
                pilgrim."master"."Gender",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                (CASE WHEN pilgrim."master"."DOB"= \'\' THEN \'0\'
                ELSE
                date_part(\'year\',AGE(CURRENT_DATE,date(pilgrim."master"."DOB"))) 
                END)
                 as "PilgrimAge",
                pilgrim."master"."Nationality",
                pilgrim."master"."Relation",
                pilgrim."master"."ContactNumber",
                pilgrim."master"."Email",              
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                packages."Packages"."Name" as "PackageName",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."Embassy" as "Embassy"
                    FROM "pilgrim"."master"
                    LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"  
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                    LEFT JOIN voucher."Master" ON  voucher."Master"."UID" = voucher."Pilgrim"."VoucherUID"            
                    LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                    LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                    LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                    LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                    LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                    WHERE pilgrim."master"."FirstName" IS NOT NULL 
                    AND "pilgrim"."master"."AgentUID" IS NULL  
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function stats_external()
    {
        $data = $this->data;
        $Crud = new Crud();
        $Agent = new Agents();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['ExternalStatsReportSearchFilter'];
        $ExternalWithSub = $Agent->AllExternalAgentsWithChildData();
        $SessionFilters = $session['ExternalStatsReportSessionFilters'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                 pilgrim."master"."Relation",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) as "PilgrimAge",
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."Embassy" as "Embassy"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND main."Agents"."UID" IN (' . implode(",", $ExternalWithSub) . ') 
                ';

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['package']) && trim($SessionFilters['package']) != '') {
            $SQL .= ' AND LOWER(packages."Packages"."Name") LIKE \'%' . strtolower(trim($SessionFilters['package'])) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        /** Filter With Session Ends */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';

        //echo $SQL; exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function stats_visa_not_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VisaNotIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                (CASE WHEN pilgrim."master"."DOB"= \'\' THEN \'0\'
                ELSE
                date_part(\'year\',AGE(CURRENT_DATE,date(pilgrim."master"."DOB"))) 
                END)
                 as "PilgrimAge",
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                 LEFT JOIN packages."HotelsRate" ON packages."HotelsRate"."HotelUID"=packages."Hotels"."UID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID"=packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                pilgrim."mofa"."IssueDateTime" as "IssueDate"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."UID" NOT IN(SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                ';
//// NOT IN(Select pilgrim."visa"."PilgrimID" FROM pilgrim."visa")
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function total_count_stats_visa_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VisaIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT count(DISTINCT( pilgrim."master"."UID" )) AS "TotalVisaIssued"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                INNER JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"  = pilgrim."master"."UID"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."MOFAPilgrimID"  = pilgrim."mofa"."MOFAPilgrimID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';
///// AND pilgrim."master"."UID" IN(SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /* $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';*/
        //echo $SQL;exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function hotel_use_actual()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['HotelUseActualSessionFilters'];

        $SQL = 'SELECT 
                "BRN"."brn"."UID",
                 TO_CHAR("BRN"."brn"."CreatedDate" :: DATE, \'dd Mon, yyyy\') AS "BookingDate",
                 TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",
                 "BRN"."brn"."BRNCode",
                 "BRN"."brn"."PurchaseID" AS "BookingID", 
                  main."Users"."FullName" AS "PurchasedBy",  
                 TO_CHAR("voucher"."AccommodationDetails"."SystemDate" :: DATE, \'dd Mon, yyyy\') AS "Useddate",
                 "main"."Cities"."Name" as "CityName",
                 "packages"."Hotels"."Name" as "HotelName",
                 "voucher"."AccommodationDetails"."NoOfBeds",
                 TO_CHAR("voucher"."AccommodationDetails"."CheckIn" :: DATE, \'dd Mon, yyyy\') AS "CheckIn",
                 TO_CHAR("voucher"."AccommodationDetails"."CheckOut" :: DATE, \'dd Mon, yyyy\') AS "CheckOut",
                 DATE_PART(\'day\', AGE(min("voucher"."AccommodationDetails"."CheckOut"), min("voucher"."AccommodationDetails"."CheckIn"))) AS "Nights",
                 "BRN"."brn"."BRNType", 
                 "pilgrim"."meta"."AllowReference",
                 COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
                 (SELECT 
                    SUM(distinct cast("PM"."Value" as int))  
                    FROM "pilgrim"."meta" AS "PM" 
                    WHERE "PM"."Option" LIKE \'%check-in-%-room-no%\' AND "PM"."AllowReference" = "pilgrim"."meta"."AllowReference") AS "RoomUsed",
                    (SELECT 
                    SUM(distinct cast("PM"."Value" as int)) 
                    FROM "pilgrim"."meta" AS "PM" 
                    WHERE "PM"."Option" LIKE \'%check-in-%-no-of-bed%\' AND "PM"."AllowReference" = "pilgrim"."meta"."AllowReference") AS "BedUsed",
                "pilgrim"."meta"."CreatedBy",
                "USER"."FullName" AS "UserName"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" ON CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
                INNER JOIN "voucher"."AccommodationDetails" ON "voucher"."AccommodationDetails"."UID"="pilgrim"."meta"."AllowReference"
                LEFT JOIN "voucher"."Master" ON "voucher"."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                INNER JOIN  "main"."Cities" ON (cast("voucher"."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int))
                INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
                INNER JOIN  "main"."Users" ON (cast("main"."Users"."UID" as character varying))=(cast("BRN"."brn"."PurchasedBy"  as character varying))
                INNER JOIN  "main"."Users" AS "USER" ON (cast("USER"."UID" as int) = cast("pilgrim"."meta"."CreatedBy" as int))
                LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions" ."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%check-in%brn%\' AND "BRN"."brn"."BRNType"=\'hotel\'';
        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" = ' . $session['domainid'] . '';
        }

        if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '' && isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['used_date_from']) && $SessionFilters['used_date_to'] != '' && isset($SessionFilters['used_date_to']) && $SessionFilters['used_date_to'] != '') {
            $SQL .= ' AND "voucher"."AccommodationDetails"."SystemDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['used_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['used_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['booking_id']) && trim($SessionFilters['booking_id']) != '') {
            $SQL .= ' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%' . strtolower(trim($SessionFilters['booking_id'])) . '%\' ';
        }
        if (isset($SessionFilters['Country']) && trim($SessionFilters['Country']) != '') {
            $SQL .= ' AND "BRN"."brn"."Country" = \'' . $SessionFilters['Country'] . '\' ';
        }
        if (isset($SessionFilters['City']) && trim($SessionFilters['City']) != '') {
            $SQL .= ' AND "voucher"."AccommodationDetails"."City" = ' . $SessionFilters['City'] . ' ';
        }
        if (isset($SessionFilters['Hotel']) && trim($SessionFilters['Hotel']) != '') {
            $SQL .= ' AND "packages"."Hotels"."UID" = ' . $SessionFilters['Hotel'] . '  AND "voucher"."AccommodationDetails"."Hotel" != \'\' ';
        }
        $SQL .= 'GROUP BY 
                "BRN"."brn"."UID",
                "voucher"."AccommodationDetails"."SystemDate", 
                "main"."Cities"."Name",
                "packages"."Hotels"."Name",
                "voucher"."AccommodationDetails"."NoOfBeds",
                "voucher"."AccommodationDetails"."CheckIn",
                "voucher"."AccommodationDetails"."CheckOut",
                "BRN"."brn"."BRNCode", 
                "BRN"."brn"."BRNType", 
                "pilgrim"."meta"."AllowReference",
                "pilgrim"."meta"."CreatedBy",
                "main"."Users"."FullName",
                "main"."LookupsOptions"."Name",
                "USER"."FullName"';


//        echo nl2br($SQL);exit();
        return $SQL;

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        //$records = $Crud->ExecuteSQL($SQL);

        //return $records;
    }

    public
    function trp_use_actual()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportBrnUseActualReportSessionFilters'];

        $SQL = '
        SELECT
            "BRN"."brn"."UID",
            TO_CHAR("BRN"."brn"."CreatedDate" :: DATE, \'dd Mon, yyyy\') AS "BookingDate",
            TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",
            "BRN"."brn"."BRNCode",
            "LUO"."Name" AS "VehicleType",
            "BRN"."brn"."PurchaseID",
            "main"."LookupsOptions"."Name" AS "BookingID",
            TO_CHAR("voucher"."TransportRate"."TravelDate" :: DATE, \'dd Mon, yyyy\') AS "Useddate",
            "main"."Cities"."Name" as "CityName",
            "voucher"."TransportRate"."Sectors",
            "voucher"."TransportRate"."NoOfSeats",
            "voucher"."TransportRate"."TravelType",
            "BRN"."brn"."NoOfVehicles",
            "BRN"."brn"."Seats",
            "BRN"."brn"."BRNType",
            "pilgrim"."meta"."AllowReference",
            COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
            (SELECT count(distinct "PM"."Value") FROM "pilgrim"."meta" AS "PM" WHERE  "PM"."AllowReference" = "pilgrim"."meta"."AllowReference") AS "SeatUsed",
            "pilgrim"."meta"."CreatedBy",
            "main"."Users"."FullName" AS "UserName"
        FROM "BRN"."brn"
        LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
        LEFT JOIN main."LookupsOptions" AS "LUO"  ON (cast("LUO"."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
        INNER JOIN "pilgrim"."meta" ON CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
        INNER JOIN "voucher"."TransportRate" ON "voucher"."TransportRate"."UID"="pilgrim"."meta"."AllowReference"
        LEFT JOIN "voucher"."Master" ON "voucher"."Master"."UID"=voucher."TransportRate"."VoucherUID"
        INNER JOIN "main"."Cities" ON (cast("voucher"."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
        INNER JOIN "main"."Users" ON (cast("main"."Users"."UID" as int) = cast("pilgrim"."meta"."CreatedBy" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions" ."UID" as character varying))=(cast("BRN"."brn"."Company" as character varying))
        WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%allow-tpt%brn-no%\'';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" = ' . $session['domainid'] . '';
        }

        if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '' && isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['use_date_from']) && $SessionFilters['use_date_from'] != '' && isset($SessionFilters['use_date_to']) && $SessionFilters['use_date_to'] != '') {
            $SQL .= ' AND "voucher"."TransportRate"."TravelDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['use_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['use_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['booking_id']) && trim($SessionFilters['booking_id']) != '') {
            $SQL .= ' AND LOWER("main"."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['booking_id'])) . '%\' ';
        }

        if (isset($SessionFilters['company']) && trim($SessionFilters['company']) != '') {
            $SQL .= ' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%' . strtolower(trim($SessionFilters['company'])) . '%\' ';
        }

        if (isset($SessionFilters['system_users']) && trim($SessionFilters['system_users']) != '') {
            $SQL .= ' AND LOWER("main"."Users"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['system_users'])) . '%\' ';
        }

        $SQL .= ' GROUP BY
        "BRN"."brn"."UID",
        "voucher"."TransportRate"."TravelDate",
        "LUO"."Name",
        "main"."Cities"."Name",
        "voucher"."TransportRate"."Sectors",
        "voucher"."TransportRate"."NoOfSeats",
        "voucher"."TransportRate"."TravelType",
        "BRN"."brn"."BRNCode",
        "BRN"."brn"."BRNType",
        "pilgrim"."meta"."AllowReference",
        "pilgrim"."meta"."CreatedBy",
        "main"."Users"."FullName",
        "main"."LookupsOptions"."Name"';

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';

//        echo $SQL; exit();
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
        foreach ($records as $record) {
            if (!isset($FinalArray[$record['UID']]['sectors']))
                $FinalArray[$record['UID']] = $record;

            $FinalArray[$record['UID']]['sectors'][$record['Sectors']]['NoOfSeats'] += $record['NoOfSeats'];
            $FinalArray[$record['UID']]['sectors'][$record['Sectors']]['BRNUsed'] += $record['BRNUsed'];
        }

        //print_r($FinalArray); echo "<hr>"; print_r($records);

        return $FinalArray;
    }

    public
    function elm_summary_daywise()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['ELMDataSummaryDayWiseSessionFilters'];

        $SQL = '
        SELECT DISTINCT 
        "pilgrim"."meta"."SystemDate",
        "pilgrim"."master"."AgentUID",
        "main"."Agents"."FullName" AS "AgentName",
        "main"."Agents"."Type" AS "AgentCategory",
        sale_agent."Agents"."FullName" as "ReferenceName",
        "main"."Countries"."Name" AS "CountryName",
        TO_CHAR("pilgrim"."meta"."SystemDate" :: DATE, \'dd Mon, yyyy\') AS "SystemDate",
        "pilgrim"."meta"."Option",
        COUNT("pilgrim"."meta"."Value") AS "TotalActivity"
        
        FROM "pilgrim"."meta" 
        INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "pilgrim"."meta"."PilgrimUID"
        INNER JOIN "main"."Agents" ON "main"."Agents"."UID" = "pilgrim"."master"."AgentUID"
        INNER JOIN "main"."Countries" ON "main"."Countries"."ISO2" = "main"."Agents"."CountryID"
        LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
        LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
        
        WHERE "pilgrim"."meta"."Option" LIKE \'%-status\' ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "main"."Agents"."WebsiteDomain" = ' . $session['domainid'] . '';
        }


        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '' && isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
            $SQL .= ' AND "pilgrim"."meta"."SystemDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['to'])) . '\' ';
        }

        if (isset($SessionFilters['Country']) && trim($SessionFilters['Country']) != '') {
            $SQL .= ' AND "main"."Countries"."ISO2" = \'' . $SessionFilters['Country'] . '\' ';
        }
        if (isset($SessionFilters['AgentName']) && trim($SessionFilters['AgentName']) != '') {
            $SQL .= ' AND "main"."Agents"."UID" = ' . $SessionFilters['AgentName'] . ' ';
        }

        $SQL .= '
        GROUP BY "pilgrim"."master"."AgentUID",
        "main"."Agents"."FullName",
        "pilgrim"."meta"."SystemDate",
        "main"."Agents"."Type",
        sale_agent."Agents"."FullName",
        "main"."Countries"."Name",
        TO_CHAR("pilgrim"."meta"."SystemDate" :: DATE, \'dd Mon, yyyy\'),
        "pilgrim"."meta"."Option"
        
        ORDER BY "pilgrim"."meta"."SystemDate" DESC, "main"."Agents"."FullName" ';

//        echo $SQL;
//        exit();
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
        foreach ($records as $record) {
            $FinalArray[date("Y-m-d", strtotime($record['SystemDate']))][$record['AgentUID']]['AgentName'] = $record['AgentName'];
            $FinalArray[date("Y-m-d", strtotime($record['SystemDate']))][$record['AgentUID']]['CountryName'] = $record['CountryName'];
            $FinalArray[date("Y-m-d", strtotime($record['SystemDate']))][$record['AgentUID']]['AgentCategory'] = $record['AgentCategory'];
            $FinalArray[date("Y-m-d", strtotime($record['SystemDate']))][$record['AgentUID']]['ReferenceName'] = $record['ReferenceName'];
            $FinalArray[date("Y-m-d", strtotime($record['SystemDate']))][$record['AgentUID']]['keys'][$record['Option']] = 0 + $record['TotalActivity'];
        }

        //echo "<pre>"; print_r($FinalArray); echo "<hr>"; print_r($records); exit;
        return $FinalArray;
    }

    public
    function hotel_arrangement()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['HotelArrangementReportSessionFilters'];

        // $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];

        $SQL = '
        SELECT distinct
        "main"."Cities"."Name" AS "CityName",
        cast("voucher"."AccommodationDetails"."Hotel" as int),
        "packages"."Hotels"."Name" as "HotelName",
        "main"."LookupsOptions"."Name" AS "CategoryName",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name" AS "RoomTypeName",
        SUM(DATE_PART(\'day\', AGE("voucher"."AccommodationDetails"."CheckOut", "voucher"."AccommodationDetails"."CheckIn"))) AS "TotalNights",
        SUM( cast("voucher"."AccommodationDetails"."NoOfBeds" as int) ) as "TotalBeds",
        
        (
            SELECT count( distinct "PilgrimUID" ) FROM "pilgrim"."meta" 
            WHERE "Option" LIKE \'%allow-%-room%\' AND "AllowReference" = "voucher"."AccommodationDetails"."UID"
        ) as "TotalPilgrims",
                        
        "voucher"."AccommodationDetails"."UID" as "AllowRefID",
                        
        (
            SELECT sale_agent."Agents"."FullName" as "ReferenceName" FROM voucher."Master"
            LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
            LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
            LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
            WHERE voucher."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        ) as "RefAgentName"
    
        FROM "voucher"."AccommodationDetails"
        INNER JOIN "pilgrim"."meta" ON "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "pilgrim"."meta"."Option" LIKE \'allow%-room-no\'
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions"."UID" as character varying))=(cast("packages"."Hotels"."Category"  as character varying))
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."AccommodationDetails"."City"  as int))
        LEFT JOIN "main"."LookupsOptions" as "LO2" ON (cast("LO2"."UID" as character varying))=(cast("voucher"."AccommodationDetails"."RoomType"  as character varying))
        
        WHERE cast("voucher"."AccommodationDetails"."Hotel" as int) > 0
        AND "voucher"."AccommodationDetails"."Self" = 0';

        //// 4650

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        /** Filters
         * Start
         */
        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL .= ' AND LOWER("main"."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }

        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER("packages"."Hotels"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER("main"."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }
        /** Filters
         * ENDS
         */

        $SQL .= '
        GROUP BY 
        "voucher"."AccommodationDetails"."UID",
        "main"."Cities"."Name",
        "voucher"."AccommodationDetails"."Hotel", 
        "packages"."Hotels"."Name",
        "main"."LookupsOptions"."Name",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name"
        
        ORDER BY
        "voucher"."AccommodationDetails"."UID", 
        "main"."Cities"."Name",
        "packages"."Hotels"."Name",
        "voucher"."AccommodationDetails"."RoomType"';

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);
        //exit();
//        echo $SQL;exit;
        //$records = $Crud->ExecuteSQL($SQL);

        /*$FinalArray = array();
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
        }*/

        return $SQL;
    }

    public
    function vehicle_arrangement()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['VehicleArrangementSessionFilters'];

        //$PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT distinct
            "voucher"."TransportRate"."UID" AS "TRUID",
            "voucher"."TransportRate"."TravelDate",
            main."LookupsOptions"."Name" as "TransportName",
            "main"."Cities"."Name" AS "CityName",
            "voucher"."TransportRate"."NoOfPax",
            "voucher"."TransportRate"."TransportTypeUID",
            count( distinct "pilgrim"."meta"."AllowReference" ) as "TotalVehicals"
        
        FROM "pilgrim"."meta"
        
        INNER JOIN "voucher"."TransportRate" ON "voucher"."TransportRate"."UID" = "pilgrim"."meta"."AllowReference"
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."TransportRate"."TravelCity"  as int))
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."TransportRate"."VoucherUID"
        Left JOIN packages."Transport" ON (cast(voucher."TransportRate"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
        LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
        
        WHERE "pilgrim"."meta"."Option" LIKE \'allow-%\'   ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        /** Filters
         * Start
         */
        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER("main"."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }

        if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
            $SQL .= ' AND LOWER(main."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['tpt_type'])) . '%\' ';
        }

        if (isset($SessionFilters['travel_date_from']) && $SessionFilters['travel_date_from'] != '' && isset($SessionFilters['travel_date_to']) && $SessionFilters['travel_date_to'] != '') {
            $SQL .= ' AND  "voucher"."TransportRate"."TravelDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['travel_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['travel_date_to'])) . '\' ';
        }
        /** Filters
         * ENDS
         */

        $SQL .= '
        GROUP BY 
        "voucher"."TransportRate"."UID", 
        "voucher"."TransportRate"."TravelDate", 
        main."LookupsOptions"."Name",
        "main"."Cities"."Name", 
        "voucher"."TransportRate"."NoOfPax", 
        "voucher"."TransportRate"."TransportTypeUID" 
        
        ORDER BY "voucher"."TransportRate"."TravelDate"';

        /*echo nl2br($SQL); exit();
        $records = $Crud->ExecuteSQL($SQL);
        echo "<hr>"; print_r($records);*/
        /* $SQL .= ' LEFT JOIN LATERAL (
     SELECT distinct "PML"."Value" as "PickupLocation"
 FROM "pilgrim"."meta" AS "PML"
     WHERE  VT."TRUID"= "PML"."AllowReference"
 AND "PML"."Option" LIKE \'%pickup-location\' Limit 1
    ) PML ON true
 LEFT JOIN LATERAL (
     SELECT distinct "PMT"."Value" as "PickupTime"
 FROM "pilgrim"."meta" AS "PMT"
     WHERE  VT."TRUID"= "PMT"."AllowReference"
 AND "PMT"."Option" LIKE \'%pickup-time\' Limit 1
    ) PMT ON true
 LEFT JOIN LATERAL (
     SELECT distinct "PMD"."Value" as "DropOffLocation"
 FROM "pilgrim"."meta" AS "PMD"
     WHERE  VT."TRUID"= "PMD"."AllowReference"
 AND "PMD"."Option" LIKE \'%dropoff-location\' Limit 1
    ) PMD ON true';*/
        return $SQL;
    }

    public
    function vehicle_arrangement_count()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['VehicleArrangementSessionFilters'];

        //$PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT distinct
            "voucher"."TransportRate"."UID" AS "TRUID",
            "voucher"."TransportRate"."TravelDate",
            main."LookupsOptions"."Name" as "TransportName",
            "main"."Cities"."Name" AS "CityName",
            "voucher"."TransportRate"."NoOfPax",
            "voucher"."TransportRate"."TransportTypeUID"
        
        FROM "pilgrim"."meta"
        
        INNER JOIN "voucher"."TransportRate" ON "voucher"."TransportRate"."UID" = "pilgrim"."meta"."AllowReference"
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."TransportRate"."TravelCity"  as int))
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."TransportRate"."VoucherUID"
        Left JOIN packages."Transport" ON (cast(voucher."TransportRate"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
        LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
        
        WHERE "pilgrim"."meta"."Option" LIKE \'allow-%\'   ';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        /** Filters
         * Start
         */
        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER("main"."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }

        if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
            $SQL .= ' AND LOWER(main."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['tpt_type'])) . '%\' ';
        }

        if (isset($SessionFilters['travel_date_from']) && $SessionFilters['travel_date_from'] != '' && isset($SessionFilters['travel_date_to']) && $SessionFilters['travel_date_to'] != '') {
            $SQL .= ' AND  "voucher"."TransportRate"."TravelDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['travel_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['travel_date_to'])) . '\' ';
        }
        /** Filters
         * ENDS
         */

        $SQL .= '
        GROUP BY 
        "voucher"."TransportRate"."UID", 
        "voucher"."TransportRate"."TravelDate", 
        main."LookupsOptions"."Name",
        "main"."Cities"."Name", 
        "voucher"."TransportRate"."NoOfPax", 
        "voucher"."TransportRate"."TransportTypeUID" 
        
        ORDER BY "voucher"."TransportRate"."TravelDate"';

        //echo $SQL; exit();
        /*$records = $Crud->ExecuteSQL($SQL);
        echo "<hr>"; print_r($records);*/

        return $SQL;
    }

    public function get_check_in_medina_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->check_in_medina();
        if ($_POST['length'] != -1)
            $SQL .= 'limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function check_in_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $CheckInMedinaCount = StatusCheckList();

        $CheckInMedinaMeta = array();
        foreach ($CheckInMedinaCount['CheckInMedina'] as $CheckInMedinaCnt) {
            $CheckInMedinaMeta[] = $CheckInMedinaCnt . "-status";
        }
        $SQL = 'SELECT 
                Distinct
                "PilgrimMeta"."SystemDate",
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID", 
                voucher."Master"."VoucherCode",
                voucher."Master"."UID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                (select  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\') 
                    AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
                    AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID"           
                  ),
                  
                (select string_agg(Distinct main."Cities"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelCityName",
                
                (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelName",
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                 LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelCategory",
                
                (SELECT Distinct  voucher."AccommodationDetails"."CheckIn"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\' Limit 1
                ) AS "CheckINDate",
                
                (select DATE_PART(\'day\', AGE(voucher."AccommodationDetails"."CheckOut", voucher."AccommodationDetails"."CheckIn"))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\' Limit 1
                )  AS "Nights",
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "RoomType",
                
                (select  pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                            FROM  voucher."Pilgrim"
                            LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                            where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\')
                            AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1           
                  ),
                
                sale_agent."Agents"."FullName" as "ReferenceName",
                main."Users"."FullName" as "SystemUser"
                
                
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim".  = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where "PilgrimMeta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\')

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= 'Group By 
                    voucher."Pilgrim"."VoucherUID",
                    voucher."Master"."VoucherCode",
                    voucher."Master"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    main."Countries"."Name",
                    main."Cities"."Name",
                    pilgrim."master"."AgentUID",
                    sale_agent."Agents"."FullName",
                    main."Users"."FullName",
                    "PilgrimMeta"."SystemDate"';
        //echo $SQL;exit();
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
        //return $SQL;
    }

    public function count_check_in_medinafiltered()
    {
        $Crud = new Crud();
        $SQL = $this->check_in_medina();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public
    function TotalListcheck_in_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $CheckInMedinaCount = StatusCheckList();

        $CheckInMedinaMeta = array();
        foreach ($CheckInMedinaCount['CheckInMedina'] as $CheckInMedinaCnt) {
            $CheckInMedinaMeta[] = $CheckInMedinaCnt . "-status";
        }
        $SQL = 'SELECT 
                Distinct
                "PilgrimMeta"."SystemDate",
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID", 
                voucher."Master"."VoucherCode",
                voucher."Master"."UID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                (select  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\') 
                    AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
                    AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID"           
                  ),
                  
                (select string_agg(Distinct main."Cities"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelCityName",
                
                (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelName",
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                 LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelCategory",
                
                (SELECT Distinct  voucher."AccommodationDetails"."CheckIn"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\' Limit 1
                ) AS "CheckINDate",
                
                (select DATE_PART(\'day\', AGE(voucher."AccommodationDetails"."CheckOut", voucher."AccommodationDetails"."CheckIn"))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\' Limit 1
                )  AS "Nights",
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "RoomType",
                
                (select  pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                            FROM  voucher."Pilgrim"
                            LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                            where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\')
                            AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1           
                  ),
                
                sale_agent."Agents"."FullName" as "ReferenceName",
                main."Users"."FullName" as "SystemUser"
                
                
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where "PilgrimMeta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\')

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= 'Group By 
                    voucher."Pilgrim"."VoucherUID",
                    voucher."Master"."VoucherCode",
                    voucher."Master"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    main."Countries"."Name",
                    main."Cities"."Name",
                    pilgrim."master"."AgentUID",
                    sale_agent."Agents"."FullName",
                    main."Users"."FullName",
                    "PilgrimMeta"."SystemDate"';
        //echo $SQL;exit();
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);

    }

    public
    function check_in_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['CheckInMeccaSessionFilters'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $CheckInMeccaCount = StatusCheckList();
        $CheckInMeccaMeta = array();
        foreach ($CheckInMeccaCount['CheckInMecca'] as $CheckInMeccaCnt) {
            $CheckInMeccaMeta[] = $CheckInMeccaCnt . "-status";
        }
        $SQL = 'SELECT 
                Distinct
                
                "PilgrimMeta"."SystemDate",
                voucher."Pilgrim"."VoucherUID",
                voucher."Master"."VoucherCode",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                pilgrim."master"."AgentUID",
                
                (select  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMeccaMeta) . '\') 
                    AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
                  ),
                
                (select string_agg(Distinct main."Cities"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                ) AS "HotelCityName",
                
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")                
                ) AS "HotelCategory",
                
                
                (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                ) AS "HotelName",
                
                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                ) AS "RoomType",
                
                
                (SELECT Distinct  max(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                
                ) AS "CheckINDate",
                
                
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                AND voucher."AccommodationDetails"."CheckIn"<=DATE("PilgrimMeta"."SystemDate")
                )  AS "Nights",
                

                (select  pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                            FROM  voucher."Pilgrim"
                            LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                            where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMeccaMeta) . '\') 
                            AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1           
                  ),
                sale_agent."Agents"."FullName" as "ReferenceName"
                
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID")
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where "PilgrimMeta"."Option" IN (\'' . implode("','", $CheckInMeccaMeta) . '\')

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Session Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER(main."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }
        /** Filters END */

        $SQL .= 'Group By 
                 
                 voucher."Pilgrim"."VoucherUID",
                 voucher."Master"."VoucherCode",
                 main."Agents"."FullName",
                 main."Countries"."Name",
                 main."Cities"."Name",
                 pilgrim."master"."AgentUID",
                 sale_agent."Agents"."FullName",
                 main."Agents"."Type",
                 "PilgrimMeta"."SystemDate"';

        /** Session Filters Start */
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        /** Filters END */
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function check_in_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['CheckInJeddahSessionFilters'];
        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $CheckInJeddahCount = StatusCheckList();

        $CheckInJeddahMeta = array();
        foreach ($CheckInJeddahCount['CheckInJeddah'] as $CheckInJeddahCnt) {
            $CheckInJeddahMeta[] = $CheckInJeddahCnt . "-status";
        }
        $SQL = 'SELECT 
                Distinct
                "PilgrimMeta"."SystemDate",
                voucher."Pilgrim"."VoucherUID",
                voucher."Master"."VoucherCode",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                pilgrim."master"."AgentUID",
                (select  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInJeddahMeta) . '\') 
                    AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
                  ),
                (select string_agg(Distinct main."Cities"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "HotelCityName",
                (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "RoomType",
(SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "CheckINDate",
(select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                )  AS "Nights",

                
                (select  pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                            FROM  voucher."Pilgrim"
                            LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                            where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInJeddahMeta) . '\') 
                            AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1           
                  ),
                sale_agent."Agents"."FullName" as "ReferenceName"
                
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where "PilgrimMeta"."Option" IN (\'' . implode("','", $CheckInJeddahMeta) . '\')

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Session Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER(main."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }
        /** Filters END */

        $SQL .= 'Group By voucher."Pilgrim"."VoucherUID",
                          voucher."Master"."VoucherCode",
                          main."Agents"."FullName",
                          main."Countries"."Name",
                          main."Cities"."Name",
                          pilgrim."master"."AgentUID",
                          "VP1"."PilgrimUID",
                           sale_agent."Agents"."FullName",
                           
                           main."Agents"."Type",
                           "PilgrimMeta"."SystemDate"';

        /** Session Filters Start */
        if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '' && isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['check_in_date_to'])) . '\' ';
        }
        /** Filters END */

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function allow_tpt_arrival_OLD()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $SQL = 'SELECT 
                 Distinct
                    "PilgrimMeta"."SystemDate",
                    voucher."Pilgrim"."VoucherUID",
                    pilgrim."master"."AgentUID",
                    main."Countries"."Name" as "CountryName",
                    main."Agents"."UID" as "AgentID",
                    main."Agents"."FullName" AS "IATANAME",
                    main."Agents"."Type" AS "IATAType",
                    voucher."Master"."VoucherCode" AS "VoucherCode",
                    count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
(select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM voucher."Pilgrim"
LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
),
(select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
                         AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
(select pilgrim."master"."PassportNumber" AS "PPNO"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
                         AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
(select voucher."Flights"."DepartureDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."DepartureTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select voucher."Flights"."ArrivalDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."ArrivalTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select voucher."Flights"."Reference"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

) AS "FlightNo",
(select main."Airlines"."FullName" AS "Airlines"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports1"."Code" AS "SectorFrom"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports2"."Code" AS "SectorTo"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Look3"."Name" AS "TypeOFTransport"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
Left JOIN voucher."TransportRate" AS "TR1" ON "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Jeddah\'

) AS "HotelCategory",


                  sale_agent."Agents"."FullName" as "ReferenceName",
                   main."Users"."FullName" as "SystemUser"
                 FROM "voucher"."Pilgrim"
                 LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                 
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID" AND pilgrim."master"."UID" NOT IN(SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'allow-tpt-arrival-status\')

                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                 LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                                   
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 WHERE  voucher."Flights"."FlightType"=\'Departure\'
                 AND voucher."Flights"."ArrivalDate" >= CURRENT_DATE 

                 ';
        /*AND voucher."Flights"."FlightType"='Departure'
        AND voucher."Flights"."ArrivalDate" = CURRENT_DATE + INTERVAL '1 day'*/
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' Group By
                    "PilgrimMeta"."SystemDate",
                     voucher."Pilgrim"."VoucherUID",
                     pilgrim."master"."AgentUID",
                     main."Countries"."Name",
                     main."Agents"."UID",
                     main."Agents"."FullName",
                     main."Agents"."Type",
                     voucher."Master"."VoucherCode",
                     sale_agent."Agents"."FullName",
                     main."Users"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function allow_tpt_arrival()
    {
        $data = $this->data;
        $Crud = new Crud();
        $settings_days = $data['settings']['activity_days'];
        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }

        $SQL = 'SELECT
Distinct
voucher."TransportRate"."UID",
voucher."Pilgrim"."VoucherUID",
voucher."Master"."VoucherCode" AS "VoucherCode",
pilgrim."master"."AgentUID",
main."Agents"."UID" as "AgentID",
main."Agents"."FullName" AS "IATANAME",
main."Agents"."Type" AS "IATAType",
main."Countries"."Name" as "CountryName",
count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
sale_agent."Agents"."FullName" as "ReferenceName",
(select "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
FROM voucher."Pilgrim" AS "VP1"
LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
(select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
(select pilgrim."master"."PassportNumber" AS "PPNO"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
voucher."Flights"."DepartureDate",
voucher."Flights"."DepartureTime",
voucher."Flights"."ArrivalDate",
voucher."Flights"."ArrivalTime",
concat(main."Airlines"."Code",\'-\',voucher."Flights"."Reference") AS "FlightNo",
(select "Airports1"."Code" AS "SectorFrom"
FROM voucher."Flights"
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
AND voucher."Flights"."FlightType"=\'Departure\' limit 1),
(select "Airports1"."Code" AS "SectorTo"
FROM voucher."Flights"
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorTo"
where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
AND voucher."Flights"."FlightType"=\'Departure\' limit 1
),
(select "Look3"."Name" AS "TypeOFTransport"
FROM voucher."TransportRate" AS "TR1"

Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where "TR1"."UID"=voucher."TransportRate"."UID" limit 1
)

FROM "voucher"."Pilgrim"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID")
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"  AND voucher."Flights"."ArrivalDate"=voucher."TransportRate"."TravelDate")
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying)=voucher."Flights"."Airline")
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"

LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"

LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID")
WHERE voucher."TransportRate"."TravelType"=\'Arrival\'
AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\',\'allow-tpt-yanbu-status\') 
AND voucher."TransportRate"."TravelType"=\'Arrival\'

)
AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'';
        /*AND voucher."Flights"."FlightType"='Departure'
        AND voucher."Flights"."ArrivalDate" = CURRENT_DATE + INTERVAL '1 day'*/
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta"
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\'
                      )  ';
        }

        $SQL .= 'Group By
        voucher."TransportRate"."UID",
voucher."Pilgrim"."VoucherUID",
voucher."Master"."VoucherCode",
pilgrim."master"."AgentUID",
main."Agents"."UID",
main."Agents"."FullName",
main."Agents"."Type",
main."Countries"."Name",
sale_agent."Agents"."FullName",
voucher."Flights"."DepartureDate",
voucher."Flights"."DepartureTime",
voucher."Flights"."ArrivalDate",
voucher."Flights"."ArrivalTime",
voucher."Flights"."Reference",
main."Airlines"."Code"
                ';
        //echo nl2br($SQL);exit();

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_tpt_arrival()
    {
        $data = $this->data;
        $Crud = new Crud();
        $settings_days = $data['settings']['activity_days'];
        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $SQL = 'SELECT
                Distinct
                voucher."TransportRate"."UID" AS "RID",
                "PilgrimMeta"."SystemDate",
                "PilgrimMeta"."Option",
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                sale_agent."Agents"."FullName" as "ReferenceName",
                
                (select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                FROM voucher."Pilgrim"
                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                ),
                (select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
(select pilgrim."master"."PassportNumber" AS "PPNO"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
                (select voucher."Flights"."DepartureDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."DepartureTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select voucher."Flights"."ArrivalDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."ArrivalTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select concat(main."Airlines"."Code",\'-\',voucher."Flights"."Reference")
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying)=voucher."Flights"."Airline")
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

) AS "FlightNo",
(select main."Airlines"."FullName" AS "Airlines"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports1"."Code" AS "SectorFrom"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports2"."Code" AS "SectorTo"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Look3"."Name" AS "TypeOFTransport"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
Left JOIN voucher."TransportRate" AS "TR1" ON "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
)
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN "pilgrim"."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID" = "pilgrim"."master"."UID" AND "PilgrimMeta"."AllowReference"=voucher."TransportRate"."UID") 
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN main."Users" ON voucher."Master"."CreatedBy" = main."Users"."UID"
                
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                WHERE voucher."TransportRate"."TravelType"=\'Arrival\' 
                AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\',\'allow-tpt-yanbu-status\') AND voucher."TransportRate"."TravelType"=\'Arrival\'
                            )
                 AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'jeddah-arrival-status\',\'mecca-arrival-status\',\'medina-arrival-status\',\'yanbu-arrival-status\') AND voucher."TransportRate"."TravelType"=\'Arrival\'
                            )
                 AND "PilgrimMeta"."Option" like \'%-status\'              
                 AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                 ';
        /*AND voucher."Flights"."FlightType"='Departure'
        AND voucher."Flights"."ArrivalDate" = CURRENT_DATE + INTERVAL '1 day'*/
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' Group By
        voucher."TransportRate"."UID",
                    "PilgrimMeta"."SystemDate",
                    "PilgrimMeta"."Option",
                    voucher."Pilgrim"."VoucherUID",
                    pilgrim."master"."AgentUID",
                    main."Countries"."Name",
                    main."Agents"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    voucher."Master"."VoucherCode",
                    sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function allow_transport_departure()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];
        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }

        $SQL = 'SELECT
Distinct
voucher."TransportRate"."UID",
voucher."Pilgrim"."VoucherUID",
voucher."Master"."VoucherCode" AS "VoucherCode",
pilgrim."master"."AgentUID",
main."Agents"."UID" as "AgentID",
main."Agents"."FullName" AS "IATANAME",
main."Agents"."Type" AS "IATAType",
main."Countries"."Name" as "CountryName",
count("voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
sale_agent."Agents"."FullName" as "ReferenceName",
(select "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
FROM voucher."Pilgrim" AS "VP1"
LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
(select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
(select pilgrim."master"."PassportNumber" AS "PPNO"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
order by "VP1"."PilgrimUID" ASC Limit 1
),
voucher."Flights"."DepartureDate",
voucher."Flights"."DepartureTime",
voucher."Flights"."ArrivalDate",
voucher."Flights"."ArrivalTime",
voucher."Flights"."Reference" AS "FlightNo",
(select "Airports1"."Code" AS "SectorFrom"
FROM voucher."Flights"
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
AND voucher."Flights"."FlightType"=\'Departure\' limit 1),
(select "Airports1"."Code" AS "SectorTo"
FROM voucher."Flights"
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorTo"
where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
AND voucher."Flights"."FlightType"=\'Departure\' limit 1
),
(select "Look3"."Name" AS "TypeOFTransport"
FROM voucher."TransportRate" AS "TR1"

Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where "TR1"."UID"=voucher."TransportRate"."UID" limit 1
)

FROM "voucher"."Pilgrim"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID")
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"  AND voucher."Flights"."ArrivalDate"=voucher."TransportRate"."TravelDate")
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"

LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"

LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID")
WHERE voucher."TransportRate"."TravelType"=\'Departure\'
AND voucher."Flights"."FlightType"=\'Return\'
AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\') AND voucher."TransportRate"."TravelType"=\'Departure\'
)
AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'';
        /*AND voucher."Flights"."FlightType"='Departure'
        AND voucher."Flights"."ArrivalDate" = CURRENT_DATE + INTERVAL '1 day'*/
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta"
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\'
                      )  ';
        }

        $SQL .= 'Group By
        voucher."TransportRate"."UID",
voucher."Pilgrim"."VoucherUID",
voucher."Master"."VoucherCode",
pilgrim."master"."AgentUID",
main."Agents"."UID",
main."Agents"."FullName",
main."Agents"."Type",
main."Countries"."Name",
sale_agent."Agents"."FullName",
voucher."Flights"."DepartureDate",
voucher."Flights"."DepartureTime",
voucher."Flights"."ArrivalDate",
voucher."Flights"."ArrivalTime",
voucher."Flights"."Reference"
                ';
        //echo nl2br($SQL);exit();

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_transport_departure()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];
        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $SQL = 'SELECT
                Distinct
                voucher."TransportRate"."UID" AS "RID",
                "PilgrimMeta"."SystemDate",
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                sale_agent."Agents"."FullName" as "ReferenceName",
                
                (select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                FROM voucher."Pilgrim"
                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                ),
                (select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
(select pilgrim."master"."PassportNumber" AS "PPNO"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                         LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                         where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
                   ),
                (select voucher."Flights"."DepartureDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."DepartureTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select voucher."Flights"."ArrivalDate"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select voucher."Flights"."ArrivalTime"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

),
(select voucher."Flights"."Reference"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1

) AS "FlightNo",
(select main."Airlines"."FullName" AS "Airlines"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports1"."Code" AS "SectorFrom"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Airports2"."Code" AS "SectorTo"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
),
(select "Look3"."Name" AS "TypeOFTransport"
FROM pilgrim."master"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
LEFT JOIN main."Airports" AS "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
LEFT JOIN main."Airports" AS "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
Left JOIN voucher."TransportRate" AS "TR1" ON "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where  pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
)
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN "pilgrim"."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID" = "pilgrim"."master"."UID" AND "PilgrimMeta"."AllowReference"=voucher."TransportRate"."UID") 
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN main."Users" ON voucher."Master"."CreatedBy" = main."Users"."UID"
                
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                WHERE voucher."TransportRate"."TravelType"=\'Departure\' 
                                 AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\') AND voucher."TransportRate"."TravelType"=\'Departure\'
                            )
                            AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                    SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'departure-jeddah-status\', \'departure-mecca-status\', \'departure-medina-status\', \'departure-yanbu-status\') AND voucher."TransportRate"."TravelType"=\'Departure\'
                            )  
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
 ';
        /*AND voucher."Flights"."FlightType"='Departure'
        AND voucher."Flights"."ArrivalDate" = CURRENT_DATE + INTERVAL '1 day'*/

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' Group By
        voucher."TransportRate"."UID",
                    "PilgrimMeta"."SystemDate",
                    voucher."Pilgrim"."VoucherUID",
                    pilgrim."master"."AgentUID",
                    main."Countries"."Name",
                    main."Agents"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    voucher."Master"."VoucherCode",
                    sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function arrival_htl_mecca_old()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                  voucher."Pilgrim"."VoucherUID",
                  
                                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                  (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                     FROM  voucher."Pilgrim" AS "VP1"
                     LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                     Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                     order by  "VP1"."PilgrimUID" ASC Limit 1           
                       ),
                       (SELECT sum(a."TotalPilgrim") AS "TotalPilgrims"
FROM (select  count("VP1"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim" AS "VP1"
                    LEFT JOIN pilgrim."meta" ON "VP1"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                    AND "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
GROUP BY
	"VP1"."PilgrimUID"
HAVING
	count("VP1"."PilgrimUID") <2) a),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    
                    ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    )  AS "Nights",
                (select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" AND main."Cities"."Name" = \'Mecca\' AND main."Cities"."CountryCode" = \'SA\'
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."AccommodationDetails"."Self"=0 
                  AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  AND (SELECT sum(a."TotalPilgrim") AS "TP"
                        FROM (select  count("VP1"."PilgrimUID") AS "TotalPilgrim"
                        FROM  voucher."Pilgrim" AS "VP1"
                        LEFT JOIN pilgrim."meta" ON "VP1"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                        where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                        AND "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                        GROUP BY "VP1"."PilgrimUID"
                        HAVING count("VP1"."PilgrimUID") <2) a) IS NOT NULL
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function no_arrival_htl_mecca_old()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                  voucher."Pilgrim"."VoucherUID",
                  
                                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  ( SELECT count("VP5"."UID")
                    FROM voucher."Pilgrim" as "VP5"
                    WHERE "VP5"."VoucherUID" = voucher."Pilgrim"."VoucherUID" AND "VP5"."PilgrimUID" NOT IN ( select pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') )) AS "TotalPilgrims",
                  (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                     FROM  voucher."Pilgrim" AS "VP1"
                     LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                     Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                     order by  "VP1"."PilgrimUID" ASC Limit 1           
                       ),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    
                    ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    )  AS "Nights",
                (select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" AND main."Cities"."Name" = \'Mecca\' AND main."Cities"."CountryCode" = \'SA\'
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."AccommodationDetails"."Self"=0 
                  AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\' 
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function no_arrival_htl_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'select
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") as "TotalPilgrimsInVoucher",
                ( SELECT count("VP5"."UID")
                    FROM voucher."Pilgrim" as "VP5"
                    WHERE "VP5"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND "VP5"."PilgrimUID" NOT IN ( select pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') )) AS "TotalPilgrims"

                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where  main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Mecca\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    AND ( SELECT count("VP5"."UID")
                    FROM voucher."Pilgrim" as "VP5"
                    WHERE "VP5"."VoucherUID" = voucher."AccommodationDetails"."VoucherID" AND "VP5"."PilgrimUID" NOT IN ( select pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') )) > 0
                    
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_htl_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];


        $SQL = 'select
                "PilgrimMeta"."SystemDate",
                voucher."AccommodationDetails"."VoucherID",
                "PilgrimMeta"."AllowReference",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                (SELECT pilgrim."meta"."PilgrimUID"  AS "LeaderPilgrimUID" FROM pilgrim."meta" 
                WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                AND "Option" = \'allow-htl-mecca-status\' LIMIT 1
                ),
                (SELECT pilgrim."meta"."Option"
                    FROM pilgrim."meta"
                    WHERE pilgrim."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                    AND pilgrim."meta"."PilgrimUID" IN (SELECT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" 
                    WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                    AND "Option" = \'allow-htl-mecca-status\' LIMIT 1) 
                    AND pilgrim."meta"."Option" LIKE \'%-status%\'
                    order by pilgrim."meta"."SystemDate" DESC
                    limit 1)   AS "CurrentStatus"



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID" 
                    AND "PilgrimMeta"."Option" IN (\'allow-htl-mecca-status\')
                    AND "PilgrimMeta"."AllowReference">0)
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where voucher."AccommodationDetails"."UID"="PilgrimMeta"."AllowReference" 
                    AND main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Mecca\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    AND voucher."Master"."CurrentStatus"=\'Executed\'

                    AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                        
                        WHERE pilgrim."meta"."Option" IN ( \'check-in-mecca-status\')
                        AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                        )
                  
             ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
        "PilgrimMeta"."SystemDate",
        "PilgrimMeta"."AllowReference",
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName"';

        //echo nl2br($SQL);exit();
        ///$records = $Crud->ExecuteSQL($SQL . " UNION " . $SQL2);
        $records = $Crud->ExecuteSQL($SQL);
//print_r($records);exit();
        return $records;
    }

    public
    function completed_allow_htl_mecca_old()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                  voucher."Pilgrim"."VoucherUID",
                  
                                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                  (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                     FROM  voucher."Pilgrim" AS "VP1"
                     LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                     Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                     order by  "VP1"."PilgrimUID" ASC Limit 1           
                       ),
                       (SELECT sum(a."TotalPilgrim") AS "TotalPilgrims"
FROM (select  count("VP1"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim" AS "VP1"
                    LEFT JOIN pilgrim."meta" ON "VP1"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                    AND "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
GROUP BY
	"VP1"."PilgrimUID"
HAVING
	count("VP1"."PilgrimUID") >1) a),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    
                    ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    )  AS "Nights",
                (select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Mecca\'
                    ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" AND main."Cities"."Name" = \'Mecca\' AND main."Cities"."CountryCode" = \'SA\'
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."AccommodationDetails"."Self"=0 
                  AND voucher."AccommodationDetails"."CheckIn" >= CURRENT_DATE 
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  AND (SELECT sum(a."TotalPilgrim") AS "TP"
                        FROM (select  count("VP1"."PilgrimUID") AS "TotalPilgrim"
                        FROM  voucher."Pilgrim" AS "VP1"
                        LEFT JOIN pilgrim."meta" ON "VP1"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                        where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                        AND "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                        GROUP BY "VP1"."PilgrimUID"
                        HAVING count("VP1"."PilgrimUID") >1) a) IS NOT NULL
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function arrival_htl_medina_old()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                    Distinct
                    voucher."Pilgrim"."VoucherUID",
                    main."Countries"."Name" as "CountryName",
                    main."Agents"."FullName" AS "IATANAME",
                    main."Agents"."Type" AS "IATAType",
                    voucher."Master"."VoucherCode" AS "VoucherCode",
                    count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                          (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                             FROM  voucher."Pilgrim" AS "VP1"
                             LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                             Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                             order by  "VP1"."PilgrimUID" ASC Limit 1           
                               ),
                       
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    
                    ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    )  AS "Nights",
                (select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" AND main."Cities"."Name" = \'Medina\' AND main."Cities"."CountryCode" = \'SA\'
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."AccommodationDetails"."Self"=0 
                  AND voucher."AccommodationDetails"."CheckIn">= CURRENT_DATE 
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  AND voucher."Pilgrim"."PilgrimUID" NOT IN (SELECT pilgrim."meta"."PilgrimUID"
                  FROM pilgrim."meta"
                  where pilgrim."meta"."Option" IN (\'allow-htl-medina-status\'))
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_htl_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];


        $SQL = 'select
                Distinct
                "PilgrimMeta"."SystemDate",
                voucher."AccommodationDetails"."VoucherID",
                "PilgrimMeta"."AllowReference",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",

          (SELECT pilgrim."meta"."PilgrimUID"  AS "LeaderPilgrimUID" FROM pilgrim."meta" 
                WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                AND "Option" = \'allow-htl-medina-status\' LIMIT 1
                ),
                (SELECT pilgrim."meta"."Option"
                    FROM pilgrim."meta"
                    WHERE pilgrim."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                    AND pilgrim."meta"."PilgrimUID" IN (SELECT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" 
                    WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                    AND "Option" = \'allow-htl-medina-status\' LIMIT 1) 
                    AND pilgrim."meta"."Option" LIKE \'%-status%\'
                    order by pilgrim."meta"."SystemDate" DESC
                    limit 1)   AS "CurrentStatus"



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID" 
                    AND "PilgrimMeta"."Option" IN (\'allow-htl-medina-status\')
                    AND "PilgrimMeta"."AllowReference">0
                    AND "PilgrimMeta"."SystemDate" IS NOT NULL
                    )
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where voucher."AccommodationDetails"."UID"="PilgrimMeta"."AllowReference" 
                    AND main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Medina\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    AND voucher."Master"."CurrentStatus"=\'Executed\'
                    
                    
                    AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            
                            WHERE pilgrim."meta"."Option" IN ( \'check-in-medina-status\')
                            AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                            )
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= '
        GROUP BY "PilgrimMeta"."SystemDate",
        "PilgrimMeta"."AllowReference",
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName",
        main."Agents"."Type"
        
        ORDER BY  voucher."AccommodationDetails"."VoucherID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_htl_medina_old()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                    Distinct
                    voucher."Pilgrim"."VoucherUID",
                    main."Countries"."Name" as "CountryName",
                    main."Agents"."FullName" AS "IATANAME",
                    main."Agents"."Type" AS "IATAType",
                    voucher."Master"."VoucherCode" AS "VoucherCode",
                    count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                          (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                             FROM  voucher."Pilgrim" AS "VP1"
                             LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                             Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                             order by  "VP1"."PilgrimUID" ASC Limit 1           
                               ),
                       
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "HotelName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    
                    ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    )  AS "Nights",
                (select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    AND main."Cities"."CountryCode"=\'SA\'
                    AND main."Cities"."Name"=\'Medina\'
                    ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID" AND main."Cities"."Name" = \'Medina\' AND main."Cities"."CountryCode" = \'SA\'
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."AccommodationDetails"."Self"=0 
                  AND voucher."AccommodationDetails"."CheckIn">= CURRENT_DATE 
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  AND voucher."Pilgrim"."PilgrimUID" IN (SELECT pilgrim."meta"."PilgrimUID"
                  FROM pilgrim."meta"
                  where pilgrim."meta"."Option" IN (\'allow-htl-medina-status\'))
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function arrival_htl_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'select
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims"



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where  main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Jeddah\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    

AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    
                    where pilgrim."meta"."Option" IN (\'allow-htl-jeddah-status\') 
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                
                    
                    )
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_htl_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'select
                "PilgrimMeta"."SystemDate",
                voucher."AccommodationDetails"."VoucherID",
                "PilgrimMeta"."AllowReference",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",

                       (SELECT pilgrim."meta"."PilgrimUID"  AS "LeaderPilgrimUID" FROM pilgrim."meta" 
                WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                AND "Option" = \'allow-htl-jeddah-status\' LIMIT 1
                ),
                (SELECT pilgrim."meta"."Option"
                    FROM pilgrim."meta"
                    WHERE pilgrim."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                    AND pilgrim."meta"."PilgrimUID" IN (SELECT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" 
                    WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" 
                    AND "Option" = \'allow-htl-jeddah-status\' LIMIT 1) 
                    AND pilgrim."meta"."Option" LIKE \'%-status%\'
                    order by pilgrim."meta"."SystemDate" DESC
                    limit 1)   AS "CurrentStatus"



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID" 
                    AND "PilgrimMeta"."Option" IN (\'allow-htl-jeddah-status\')
                    AND "PilgrimMeta"."AllowReference">0)
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where  voucher."AccommodationDetails"."UID"="PilgrimMeta"."AllowReference" 
                    AND main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Jeddah\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    AND voucher."Master"."CurrentStatus"=\'Executed\'

                    AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                    SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                    
                    WHERE pilgrim."meta"."Option" IN ( \'check-in-jeddah-status\')
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    )
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
        "PilgrimMeta"."SystemDate",
        "PilgrimMeta"."AllowReference",
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function trp_brn_purchased()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SessionFilters = $session['TransportBrnPurchaseReportSessionFilters'];

        $SQL = 'SELECT
                    TO_CHAR("BRN"."brn"."GenerateDate" :: DATE, \'dd Mon, yyyy\') AS "GenerateDate",
                    TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",                  
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                    "BRN"."brn"."NoOfVehicles",
                     main."LookupsOptions"."Name" AS "VehicleType",
                    "LUO"."Name"  AS "CompanyName",
                    "BRN"."brn"."Seats",
                    TO_CHAR("BRN"."brn"."GenerateDate" :: DATE, \'dd Mon, yyyy\') AS "ChechInDate",
                    TO_CHAR("BRN"."brn"."ActiveDate" :: DATE, \'dd Mon, yyyy\') AS "CheckOutDate",
                    "BRN"."brn"."ActiveDate"::date - "BRN"."brn"."GenerateDate"::date AS "TotalNights",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                    LEFT JOIN main."LookupsOptions"  ON (cast(main."LookupsOptions" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                    LEFT JOIN main."LookupsOptions" AS "LUO"  ON (cast("LUO" ."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying))
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                    where "BRN"."brn"."BRNType"=\'transport\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '' && isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."GenerateDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."GenerateDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['booking_id']) && trim($SessionFilters['booking_id']) != '') {
            $SQL .= ' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%' . strtolower(trim($SessionFilters['booking_id'])) . '%\' ';
        }

        if (isset($SessionFilters['company']) && trim($SessionFilters['company']) != '') {
            $SQL .= ' AND LOWER("LUO"."Name") LIKE \'%' . strtolower(trim($SessionFilters['company'])) . '%\' ';
        }

        if (isset($SessionFilters['system_users']) && trim($SessionFilters['system_users']) != '') {
            $SQL .= ' AND LOWER(main."Users"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['system_users'])) . '%\' ';
        }

        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';
//        echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
        //return $records;
    }

    public
    function allow_transport_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                voucher."TransportRate"."TravelDate",
                voucher."Pilgrim"."VoucherUID",
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                count("voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select "Look3"."Name" AS "SectorName"
                FROM  voucher."TransportRate"  AS  "TR1"
                LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast("TR1"."Sectors"  as character varying))
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "TR1"."NoOfSeats" AS "NoOfSeats"
                FROM  voucher."TransportRate"  AS  "TR1"
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "Look3"."Name" AS "TypeOFTransport"
                   FROM  voucher."TransportRate"  AS  "TR1"
                  Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                  LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                   where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                   ),
                   (select Distinct "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                    FROM voucher."Pilgrim" AS "VP1"
                    LEFT JOIN pilgrim."meta" ON "VP1"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'allow-tpt-mecca-status\')
                    AND "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                     Limit 1),
                  
                (select packages."Hotels"."Name"
                        FROM  packages."Hotels"
                        where packages."Hotels"."UID" = voucher."AccommodationDetails"."Hotel"
                        ) AS "HotelName",
                (select main."LookupsOptions"."Name"
                    FROM  main."LookupsOptions"
                    where main."LookupsOptions"."UID" = voucher."AccommodationDetails"."RoomType"
                ) AS "RoomType"
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Mecca\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )           
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                voucher."TransportRate"."TravelDate", 
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",                
                voucher."Pilgrim"."VoucherUID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                voucher."Master"."VoucherCode",
                sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function no_allow_transport_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                 
                  voucher."Pilgrim"."VoucherUID",
                  
                                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  ( SELECT count("VP5"."UID")
                    FROM voucher."Pilgrim" as "VP5"
                    WHERE "VP5"."VoucherUID" = voucher."Pilgrim"."VoucherUID" AND 
                    "VP5"."PilgrimUID" NOT IN ( select pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-tpt-mecca-status\') )
                    ) AS "TotalPilgrims",
                    count(voucher."Pilgrim"."PilgrimUID") as "TotalVoucherPilgrims",
                  (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                     FROM  voucher."Pilgrim" AS "VP1"
                     LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                     Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                     order by  "VP1"."PilgrimUID" ASC Limit 1           
                       ),
               
                

                
              
                    (select "Look3"."Name" AS "TypeOFTransport"
                   FROM  voucher."TransportRate"  AS  "TR1"
                  Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                  LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                   where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                   ),
                   
                   (select "Look3"."Name" AS "SectorName"
                        FROM  voucher."TransportRate"  AS  "TR1"
                        LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast("TR1"."Sectors"  as character varying))
                        where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                   (select "TR1"."NoOfSeats" AS "NoOfSeats"
                        FROM  voucher."TransportRate"  AS  "TR1"
                        where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                  sale_agent."Agents"."FullName" as "ReferenceName"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN voucher."TransportRate" ON voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                  
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE voucher."TransportRate"."SelfTransport"=0 
                  AND voucher."Master"."CurrentStatus"=\'Executed\'
                  AND voucher."Pilgrim"."PilgrimUID" NOT IN ( select  pilgrim."meta"."PilgrimUID" FROM  pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-tpt-mecca-status\') ) 
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"
                 ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_tpt_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
pilgrim."meta"."SystemDate",
voucher."TransportRate"."UID" AS "RID", 
voucher."TransportRate"."TravelDate",
voucher."AccommodationDetails"."UID" AS "AID",
voucher."Pilgrim"."VoucherUID",
main."Countries"."Name" as "CountryName",
main."Agents"."FullName" AS "IATANAME",
main."Agents"."Type" AS "IATAType",
voucher."Master"."VoucherCode" AS "VoucherCode",
count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
sale_agent."Agents"."FullName" as "ReferenceName",
(SELECT "PilgrimMeta"."PilgrimUID" AS "LeaderPilgrimUID"
         FROM pilgrim."meta" AS "PilgrimMeta"
         WHERE "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
         AND "PilgrimMeta"."Option" = \'allow-tpt-mecca-status\' LIMIT 1
         ),
(select string_agg(Distinct packages."Hotels"."Name", \',\')
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Mecca\'
) AS "HotelName",
(select "Look3"."Name" AS "TypeOFTransport"
                   FROM  voucher."TransportRate"  AS  "TR1"
                  Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                  LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                   where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                   )

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"                        
LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                          
LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Mecca\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )               
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY
                 pilgrim."meta"."SystemDate", 
                 voucher."TransportRate"."UID",
                 voucher."AccommodationDetails"."UID",
                 voucher."TransportRate"."TravelDate",
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function allow_transport_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                voucher."TransportRate"."TravelDate",
                voucher."Pilgrim"."VoucherUID",
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                count("voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select "Look3"."Name" AS "SectorName"
                FROM voucher."TransportRate" AS "TR1"
                LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast("TR1"."Sectors" as character varying))
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "TR1"."NoOfSeats" AS "NoOfSeats"
                FROM voucher."TransportRate" AS "TR1"
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "Look3"."Name" AS "TypeOFTransport"
                FROM voucher."TransportRate" AS "TR1"
                Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
                LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                ),
                (select packages."Hotels"."Name"
                        FROM  packages."Hotels"
                        where packages."Hotels"."UID" = voucher."AccommodationDetails"."Hotel"
                        ) AS "HotelName",
                (select main."LookupsOptions"."Name"
                    FROM  main."LookupsOptions"
                    where main."LookupsOptions"."UID" = voucher."AccommodationDetails"."RoomType"
                ) AS "RoomType"
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID")
                LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
                
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')
                AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                )
                AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY
                voucher."TransportRate"."TravelDate",
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",
                voucher."Pilgrim"."VoucherUID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                voucher."Master"."VoucherCode",
                sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_tpt_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
pilgrim."meta"."SystemDate",
voucher."TransportRate"."UID" AS "RID",
voucher."AccommodationDetails"."UID" AS "AID",
voucher."TransportRate"."TravelDate",
voucher."TransportRate"."NoOfSeats",
voucher."Pilgrim"."VoucherUID",
main."Countries"."Name" as "CountryName",
main."Agents"."FullName" AS "IATANAME",
main."Agents"."Type" AS "IATAType",
voucher."Master"."VoucherCode" AS "VoucherCode",
count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
sale_agent."Agents"."FullName" as "ReferenceName",

(SELECT "PilgrimMeta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM pilgrim."meta" AS "PilgrimMeta"
WHERE "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
AND "PilgrimMeta"."Option" = \'allow-tpt-medina-status\' LIMIT 1
),
(select string_agg(Distinct packages."Hotels"."Name", \',\')
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Medina\'
) AS "HotelName",
(select "Look3"."Name" AS "TypeOFTransport"
FROM voucher."TransportRate" AS "TR1"
Left JOIN packages."Transport" ON (cast("TR1"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" AS "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
)

FROM "voucher"."Pilgrim"

LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID")
LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Medina\'
AND "voucher"."Pilgrim"."PilgrimUID" IN(
SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')
AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
)
AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
WHERE pilgrim."meta"."Option" IN ( \'check-out-medina-status\')
AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
)
AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY
                pilgrim."meta"."SystemDate",
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."UID",
                voucher."TransportRate"."TravelDate",
                voucher."Pilgrim"."VoucherUID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                voucher."Master"."VoucherCode",
                sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function allow_transport_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                voucher."TransportRate"."TravelDate",
                voucher."Pilgrim"."VoucherUID",
                voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                count("voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select "Look3"."Name" AS "SectorName"
                FROM  voucher."TransportRate"  AS  "TR1"
                LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast("TR1"."Sectors"  as character varying))
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "TR1"."NoOfSeats" AS "NoOfSeats"
                FROM  voucher."TransportRate"  AS  "TR1"
                where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1),
                (select "Look3"."Name" AS "TypeOFTransport"
                   FROM  voucher."TransportRate"  AS  "TR1"
                  Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                  LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                   where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                   ),
                (select packages."Hotels"."Name"
                        FROM  packages."Hotels"
                        where packages."Hotels"."UID" = voucher."AccommodationDetails"."Hotel"
                        ) AS "HotelName",
                (select main."LookupsOptions"."Name"
                    FROM  main."LookupsOptions"
                    where main."LookupsOptions"."UID" = voucher."AccommodationDetails"."RoomType"
                ) AS "RoomType"
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
                LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Jeddah\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )           
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                 voucher."TransportRate"."TravelDate",
                 voucher."TransportRate"."UID",
                voucher."AccommodationDetails"."Hotel",
                voucher."AccommodationDetails"."RoomType",                 
                voucher."Pilgrim"."VoucherUID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                voucher."Master"."VoucherCode",
                sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_allow_tpt_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
pilgrim."meta"."SystemDate",
voucher."TransportRate"."UID" AS "RID",
voucher."AccommodationDetails"."UID" AS "AID", 
voucher."TransportRate"."TravelDate",
voucher."TransportRate"."NoOfSeats",
voucher."Pilgrim"."VoucherUID",
main."Countries"."Name" as "CountryName",
main."Agents"."FullName" AS "IATANAME",
main."Agents"."Type" AS "IATAType",
voucher."Master"."VoucherCode" AS "VoucherCode",
count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
sale_agent."Agents"."FullName" as "ReferenceName",

(SELECT "PilgrimMeta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM pilgrim."meta" AS "PilgrimMeta"
WHERE "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
AND "PilgrimMeta"."Option" = \'allow-tpt-jeddah-status\' LIMIT 1
),
(select string_agg(Distinct packages."Hotels"."Name", \',\')
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Mecca\'
) AS "HotelName",
(select "Look3"."Name" AS "TypeOFTransport"
                   FROM  voucher."TransportRate"  AS  "TR1"
                  Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                  LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                   where "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" limit 1
                   )

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"                        
LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                          
LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."TransportRate"."VoucherUID" AND voucher."AccommodationDetails"."CheckOut" = voucher."TransportRate"."TravelDate" AND (cast(voucher."AccommodationDetails"."City" as character varying)) =(cast(voucher."TransportRate"."TravelCity" as character varying)))
LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Jeddah\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )               
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'GROUP BY 
                  pilgrim."meta"."SystemDate",
                 voucher."TransportRate"."UID",
                 voucher."AccommodationDetails"."UID",
                 voucher."TransportRate"."TravelDate",
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function completed_ppt_management()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                pilgrim."master"."UID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Groups"."UID" as "GroupID",
                main."Groups"."FullName" as "GroupName",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."mofa"."MOFANumber",
                pilgrim."travel"."VisaNo",
                pilgrim."travel"."EntryDate",
                pilgrim."travel"."EntryTime",
                pilgrim."travel"."EntryPort",
                pilgrim."travel"."TransportMode" AS "ArrivalMode",
                pilgrim."travel"."EntryCarrier",
                pilgrim."travel"."FlightNo",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where pilgrim."master"."AgentUID" IS NOT NULL
                AND pilgrim."master"."UID" IN(SELECT Distinct  pilgrim."attachments"."PilgrimID"
                    FROM pilgrim."attachments"
                    WHERE pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportFrontPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBackPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBookletPic\'))
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY  pilgrim."master"."UID" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function late_departure_counter_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['Over25DaysArrivalSessionFilters'];

        $SQL = 'SELECT
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."UID" AS "PilgrimID",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Groups"."UID" as "GroupID",
                main."Groups"."FullName" as "GroupName",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."Nationality",
                pilgrim."master"."DOB",
                pilgrim."mofa"."MOFANumber",
                pilgrim."travel"."VisaNo",
                pilgrim."travel"."MOINumber",
                pilgrim."travel"."EntryDate",
                pilgrim."travel"."EntryTime",
                pilgrim."travel"."EntryPort",
                pilgrim."travel"."TransportMode" AS "ArrivalMode",
                pilgrim."travel"."EntryCarrier",
                pilgrim."travel"."FlightNo",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select voucher."Flights"."DepartureDate"
                    FROM pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                    where voucher."Flights"."FlightType"=\'Return\'  limit 1
                    ) AS "DepartureDate",
                (select DATE_PART(\'day\', AGE(CURRENT_DATE, min(voucher."Flights"."DepartureDate")))
                    FROM pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                    where voucher."Flights"."FlightType"=\'Return\'  limit 1
                    ) AS "Days",
                (select main."LookupsOptions"."Name"
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID" ORDER BY voucher."AccommodationDetails"."UID" DESC Limit 1
                                  
                    ) AS "HotelCategory"
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where abs(extract(day from CURRENT_DATE - voucher."Master"."ArrivalDate"::timestamp))>= 25
                AND pilgrim."master"."UID" NOT IN(SELECT  pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\'))
                AND pilgrim."master"."AgentUID" IS NOT NULL
                  
             ';
        $SQL .= '  AND pilgrim."master"."UID" NOT IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')';


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower(trim($SessionFilters['pilgrim'])) . '%\' ';
        }

        if (isset($SessionFilters['ppt_no']) && trim($SessionFilters['ppt_no']) != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . trim($SessionFilters['ppt_no']) . '\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL .= ' AND pilgrim."mofa"."MOFANumber" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL .= ' AND pilgrim."travel"."VisaNo" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }

        if (isset($SessionFilters['entry_date_from']) && $SessionFilters['entry_date_from'] != '' && isset($SessionFilters['entry_date_to']) && $SessionFilters['entry_date_to'] != '') {
            $SQL .= ' AND  pilgrim."travel"."EntryDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['entry_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['entry_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' ORDER BY  pilgrim."master"."UID" ASC';

        if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '' && isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                    WHERE "MainQuery"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_to'])) . '\' ';
        }


        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function free_bed_counter_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];


        $SQL = 'SELECT 
Distinct
                "PilgrimMeta"."SystemDate",
				"PilgrimMeta"."Option",
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID", 
                voucher."Master"."VoucherCode",
                voucher."Master"."UID" as "VoucherID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                (SELECT pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM pilgrim."meta"
WHERE pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"
AND pilgrim."meta"."Option" LIKE \'%no-of-bed%\' LIMIT 1
),
(SELECT distinct cast(pilgrim."meta"."Value" as integer) as "NoOfBed" FROM pilgrim."meta" 
WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" AND pilgrim."meta"."Option" LIKE \'%no-of-bed%\'),
(select  count(distinct voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
					FROM  voucher."Pilgrim"
					LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
					where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
					AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID" ),

(
(SELECT distinct cast(pilgrim."meta"."Value" as integer) as "NoOfBed" FROM pilgrim."meta" 
WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" AND pilgrim."meta"."Option" LIKE \'%no-of-bed%\')-
(select  count(distinct voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
					FROM  voucher."Pilgrim"
					LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
					where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
					AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID" )
) as "FeeBeds",
sale_agent."Agents"."FullName" as "ReferenceName",
                main."Users"."FullName" as "SystemUser",

					(SELECT distinct pilgrim."meta"."Option" as "CurrentStatus" FROM pilgrim."meta" 
					WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" AND pilgrim."meta"."Option" LIKE \'%-status\') AS "CurrentStatus"
                
                	
				
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
              LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE "PilgrimMeta"."Option" LIKE \'%no-of-bed%\'  
                AND (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "PilgrimMeta"."AllowReference") >= \'' . date("Y-m-d") . '\'
                AND
( ((SELECT distinct cast(pilgrim."meta"."Value" as integer) as "NoOfBed" FROM pilgrim."meta" 
WHERE pilgrim."meta"."SystemDate" = "PilgrimMeta"."SystemDate" AND pilgrim."meta"."Option" LIKE \'%no-of-bed%\'))-((select  count(distinct voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
					FROM  voucher."Pilgrim"
					LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
					where pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
					AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID" )) ) >0
                  
             ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'Group By 
                    voucher."Pilgrim"."VoucherUID",
					"PilgrimMeta"."Option",
                    voucher."Master"."VoucherCode",
                    voucher."Master"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    main."Countries"."Name",
                    main."Cities"."Name",
                    pilgrim."master"."AgentUID",
                    sale_agent."Agents"."FullName",
                    main."Users"."FullName",
                    "PilgrimMeta"."SystemDate"';

        //echo nl2br($SQL);exit();
        ///$records = $Crud->ExecuteSQL($SQL . " UNION " . $SQL2);
        $records = $Crud->ExecuteSQL($SQL);
//print_r($records);exit();
        return $records;
    }

    public
    function allow_bed()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];


        $SQL = 'SELECT 
distinct  
"pilgrim"."meta"."SystemDate",
voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."AgentUID", 
                voucher."Master"."VoucherCode",
                voucher."Master"."UID" as "VoucherID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName", 
"pilgrim"."meta"."Value" as "NoOfBed",
            (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate") as "TotalPilgrims",
            (
                CAST("pilgrim"."meta"."Value" AS int) - 
                (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                    WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                )            
            ) as "FreeBeds",
            (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference") as "ActivityExpireDate",

(select  "PilgrimMeta"."PilgrimUID" AS "LeaderPilgrimUID" FROM  voucher."Pilgrim"
					LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
					where "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate" Limit 1 ),
                
                sale_agent."Agents"."FullName" as "ReferenceName",
                main."Users"."FullName" as "SystemUser",
                (SELECT "PilgrimMeta2"."Option" FROM "pilgrim"."meta" as "PilgrimMeta2" 
WHERE  "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate" AND "PilgrimMeta2"."Option" LIKE \'%-status\'  Limit 1) as "CurrentStatus"
            FROM "pilgrim"."meta" 
            INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "pilgrim"."meta"."PilgrimUID"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"

LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
            WHERE  (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference")   < \'' . date("Y-m-d") . '\'
            AND (
                    CAST("pilgrim"."meta"."Value" AS int) - 
                    (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                        WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                    )
            ) > 0
AND "pilgrim"."meta"."Option" LIKE \'%no-of-bed%\'
                  
             ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /*$SQL .= 'Group By
                    voucher."Pilgrim"."VoucherUID",
					"PilgrimMeta"."Option",
                    voucher."Master"."VoucherCode",
                    voucher."Master"."UID",
                    main."Agents"."FullName",
                    main."Agents"."Type",
                    main."Countries"."Name",
                    main."Cities"."Name",
                    pilgrim."master"."AgentUID",
                    sale_agent."Agents"."FullName",
                    main."Users"."FullName",
                    "PilgrimMeta"."SystemDate"';*/

        //echo nl2br($SQL);exit();
        ///$records = $Crud->ExecuteSQL($SQL . " UNION " . $SQL2);
        $records = $Crud->ExecuteSQL($SQL);
//print_r($records);exit();
        return $records;
    }

    /** Visa Issue
     * Report Functions
     */
    public
    function count_visa_issue_filtered()
    {
        $Crud = new Crud();
        //$SQL = $this->total_count_stats_visa_issued();
        $SQL = $this->stats_visa_issued();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function stats_visa_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VisaIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['VisaIssuedSessionFilters'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                 (CASE WHEN pilgrim."master"."DOB"= \'\' THEN \'0\'
                ELSE
                date_part(\'year\',AGE(CURRENT_DATE,date(pilgrim."master"."DOB"))) 
                END)
                 as "PilgrimAge",
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID",  
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                 LEFT JOIN packages."HotelsRate" ON packages."HotelsRate"."HotelUID"=packages."Hotels"."UID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID"=packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                pilgrim."mofa"."IssueDateTime" as "IssueDate",
                pilgrim."travel"."VisaNo" as "VisaNumber",
                pilgrim."visa"."IssueDate" as "VisaIssueDate"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                INNER JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"  = pilgrim."master"."UID"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."MOFAPilgrimID"  = pilgrim."mofa"."MOFAPilgrimID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';
///// AND pilgrim."master"."UID" IN(SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }
        /** Filter With Session Ends */

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';

        /** Filter With Session Start*/
        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."GroupName") LIKE \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."PassportNumber" = \'' . trim($SessionFilters['pp_no']) . '\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."PilgrimFullName") LIKE \'%' . strtolower(trim($SessionFilters['pilgrim'])) . '%\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."MOFANumber" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."VisaNumber" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }

        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."HotelCategory") LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }
        /** Filter With Session Ends */

        return $SQL;
    }

    public
    function get_visa_issue_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->stats_visa_issued();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    /** Mofa Not
     * Issue Report
     * Functions
     */
    public
    function count_mofa_not_issued_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->stats_total_count_mofa_not_issued();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalMofaNotIssued'];

    }

    public
    function stats_total_count_mofa_not_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['MofaIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT count(DISTINCT(  pilgrim."master"."UID" )) AS "TotalMofaNotIssued"
                FROM pilgrim."master"
                LEFT JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"   AND packages."Packages"."AgentUID">0)
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND "pilgrim"."master"."UID" Not IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                AND "pilgrim"."master"."AgentUID" > 0
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /*$SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';*/
        //echo nl2br($SQL);exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_mofa_not_issued_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->stats_mofa_not_issued();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function stats_mofa_not_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['MofaIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                 LEFT JOIN packages."HotelsRate" ON packages."HotelsRate"."HotelUID"=packages."Hotels"."UID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID"=packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                pilgrim."mofa"."IssueDateTime" as "IssueDate"
                FROM pilgrim."master"
                LEFT JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"   AND packages."Packages"."AgentUID">0)
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND "pilgrim"."master"."UID" Not IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                AND "pilgrim"."master"."AgentUID" > 0
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo nl2br($SQL);exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    /** Mofa Issue
     * Report Functions
     */

    public
    function count_mofa_issued_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->stats_total_count_mofa_issued();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalMofaIssued'];

    }

    public
    function stats_total_count_mofa_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['MofaIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['MofaIssuedStatsReportSessionFilters'];

        $SQL = 'SELECT count(DISTINCT(pilgrim."master"."UID")) AS "TotalMofaIssued"
                FROM pilgrim."master"
                INNER JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"                
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND "pilgrim"."master"."UID" IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim'])) . '%\' ';
        }

        if (isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" =  \'' . trim($SessionFilters['pp_no']) . '\' ';
        }

        if (isset($SessionFilters['nationality']) && trim($SessionFilters['nationality']) != '') {
            $SQL .= ' AND LOWER(pilgrim."master"."Nationality") LIKE  \'%' . strtolower(trim($SessionFilters['nationality'])) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        /** Filter With Session Ends */

        /*$SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';*/
        //echo nl2br($SQL);exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_mofa_issued_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->stats_mofa_issued();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function stats_mofa_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['MofaIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['MofaIssuedStatsReportSessionFilters'];

        $SQL = 'SELECT 
                pilgrim."master"."UID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                 LEFT JOIN packages."HotelsRate" ON packages."HotelsRate"."HotelUID"=packages."Hotels"."UID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID"=packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                pilgrim."mofa"."IssueDateTime" as "IssueDate"
                FROM pilgrim."master"
                INNER JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND "pilgrim"."master"."UID" IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim'])) . '%\' ';
        }

        if (isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" =  \'' . trim($SessionFilters['pp_no']) . '\' ';
        }

        if (isset($SessionFilters['nationality']) && trim($SessionFilters['nationality']) != '') {
            $SQL .= ' AND LOWER(pilgrim."master"."Nationality") LIKE  \'%' . strtolower(trim($SessionFilters['nationality'])) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        /** Filter With Session Ends */

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo nl2br($SQL);exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    /** Total Pax
     * Report Functions
     */

    public
    function count_total_pax_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->stats_total_count_total_pax();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
        //return $records[0]['TotalPax'];

    }

    public
    function stats_total_count_total_pax()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['TotalPaxStatsReportSearchFilter'];
        $SessionFilters = $session['TotalPaxStatsReportSessionFilters'];

        $SQL = 'SELECT 
                Distinct 
                pilgrim."master"."UID" AS "PilgrimID"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast( main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"  AND packages."Packages"."AgentUID">0)
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';
        ////AND pilgrim."master"."AgentUID" IS NOT NULL
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($SessionFilters['pilgrim']) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim_status']) && trim($SessionFilters['pilgrim_status']) != '') {
            $SQL .= ' AND LOWER(REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \')) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim_status'])) . '%\' ';
        }
        /** Filter With Session Ends */

        //$SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        /** Filter With Session Ends */

        /*  $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';*/
        //echo $SQL;exit();
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_total_pax_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->stats_total_pax();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function stats_total_pax()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['TotalPaxStatsReportSearchFilter'];
        $SessionFilters = $session['TotalPaxStatsReportSessionFilters'];

        $SQL = 'SELECT
                Distinct 
                pilgrim."master"."UID" AS "PilgrimID",
                pilgrim."master"."AgentUID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                
                 
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                 main."Agents"."Type" as "AgentType",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."UID",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                
                 (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                LEFT JOIN packages."HotelsRate" ON (packages."HotelsRate"."HotelUID" = packages."Hotels"."UID")
                
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID" = packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                pilgrim."master"."RegistrationDate"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast( main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"  AND packages."Packages"."AgentUID" > 0)
                
               
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';
        ////AND pilgrim."master"."AgentUID" IS NOT NULL
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER(main."Groups"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($SessionFilters['pilgrim']) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }

        if (isset($SessionFilters['pilgrim_status']) && trim($SessionFilters['pilgrim_status']) != '') {
            $SQL .= ' AND LOWER(REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \')) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim_status'])) . '%\' ';
        }
        /** Filter With Session Ends */

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';
        //echo $SQL;exit();
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    /** Voucher Not
     * Issued Report
     * Functions
     */

    public
    function count_voucher_not_issued_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->stats_total_count_voucher_not_issued();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalVoucherNotIssued'];
    }

    public
    function stats_total_count_voucher_not_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['VoucherNotIssuedSessionFilters'];

        $SQL = 'Select
                count(DISTINCT pilgrim."master"."UID") AS "TotalVoucherNotIssued"                
                FROM pilgrim."master"
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                 

                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"   AND packages."Packages"."AgentUID">0)
                 LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")';

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL .= ' AND LOWER( main."Groups"."FullName" ) LIKE \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . trim($SessionFilters['pp_no']) . '\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($SessionFilters['pilgrim']) . '%\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL .= ' AND pilgrim."mofa"."MOFANumber" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL .= ' AND pilgrim."visa"."VisaNumber" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }
        /** Filter With Session Ends */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /* $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';*/
        //echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_voucher_not_issued_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->stats_voucher_not_issued();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function stats_voucher_not_issued()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['VoucherNotIssuedSessionFilters'];

        $SQL = 'Select
                Distinct
                pilgrim."master".*,
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName", 
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                pilgrim."mofa"."IssueDateTime" as "IssueDateTime",
                pilgrim."visa"."VisaNumber" as "VisaNumber",
                pilgrim."visa"."IssueDate" as "IssueDate",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
                packages."Packages"."Name" as "PackageName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  packages."Hotels"
                 LEFT JOIN packages."HotelsRate" ON packages."HotelsRate"."HotelUID"=packages."Hotels"."UID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where packages."HotelsRate"."PackageUID"=packages."Packages"."UID"
                              
                ) AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email"
                
                FROM pilgrim."master"
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID"   AND packages."Packages"."AgentUID">0)
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                AND pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")';

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }
        /** Filter With Session Ends */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."RegistrationDate" DESC';


        /** Filter With Session Start*/
        if (isset($SessionFilters['group']) && trim($SessionFilters['group']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."GroupName") LIKE \'%' . strtolower(trim($SessionFilters['group'])) . '%\' ';
        }

        if (isset($SessionFilters['pp_no']) && trim($SessionFilters['pp_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."PassportNumber" = \'' . trim($SessionFilters['pp_no']) . '\' ';
        }

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."PilgrimFullName") LIKE \'%' . strtolower(trim($SessionFilters['pilgrim'])) . '%\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."MOFANumber" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."VisaNumber" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }
        /** Filter With Session Ends */

        return $SQL;
    }

    /** Voucher Issued
     * Report Functions
     */

    public
    function count_voucher_issued_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->voucher_issue_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function voucher_issue_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['VoucherIssuedSessionFilters'];

        $SQL = 'SELECT 
                voucher."Master"."CreatedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                voucher."Master"."SystemDate" AS "IssueDate",
                main."Groups"."FullName" as "GroupName", 
                main."Countries"."Name" as "CountryName",
                voucher."Pilgrim"."VoucherUID",
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                pilgrim."master"."UID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                main."Cities"."Name" AS "CityName",
                pilgrim."mofa"."MOFANumber",
                pilgrim."visa"."VisaNumber",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                 FROM  voucher."AccommodationDetails"
                 LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                 LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                 where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                 ) AS "HotelCategory",
       
                (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                ) AS "HotelName",
       
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
       
                (select SUM("Mecca"."Nights") AS "MeccaNights"
from (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Mecca\'
GROUP BY voucher."AccommodationDetails"."UID") as "Mecca"),
       
(select SUM("Medina"."Nights") AS "MedinaNights"
from (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Medina\'
GROUP BY voucher."AccommodationDetails"."UID") as "Medina"),
       
(select SUM("Jeddah"."Nights") AS "JeddahNights"
from (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Jeddah\'
GROUP BY voucher."AccommodationDetails"."UID") as "Jeddah"),

(select
(select 
CASE WHEN SUM("Mecca"."Nights") >0 THEN SUM("Mecca"."Nights") ELSE 0 END AS "MeccaNights" from (
select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM  voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Mecca\'
GROUP BY voucher."AccommodationDetails"."UID") as "Mecca")
+
(select 
CASE WHEN SUM("Medina"."Nights") >0 THEN SUM("Medina"."Nights") ELSE 0 END AS "MedinaNights" from (
select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM  voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Medina\'
GROUP BY voucher."AccommodationDetails"."UID") as "Medina")
+
(select 
CASE WHEN SUM("Jeddah"."Nights") >0 THEN SUM("Jeddah"."Nights") ELSE 0 END AS "JeddahNights" from (
select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
FROM  voucher."AccommodationDetails"
LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
AND main."Cities"."CountryCode"=\'SA\'
AND main."Cities"."Name"=\'Jeddah\'
GROUP BY voucher."AccommodationDetails"."UID") as "Jeddah")
)  AS "TotalNights",
       
(select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM voucher."TransportRate"
Left JOIN packages."Transport" ON (cast(voucher."TransportRate"."TransportTypeUID" as character varying))=(cast(packages."Transport"."UID" as character varying))
LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=(cast(packages."Transport"."Type" as character varying))
where voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
)  AS "TypeOFTransport",
(select SUM(cast(voucher."AccommodationDetails"."NoOfBeds"  as int))
FROM  voucher."AccommodationDetails"
where voucher."AccommodationDetails"."VoucherID" =voucher."Pilgrim"."VoucherUID")  AS "NoOfBeds"

                
                FROM voucher."Master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"="VP1"."PilgrimUID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN websites."Domains" ON websites."Domains"."UID" = voucher."Master"."WebsiteDomain"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 AND voucher."Master"."VoucherType" != \'B2C\'  ';


        /** POST Filters Start */
        /*if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['voucher_code']) && trim($_POST['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_code']) . '\' ';
        }

        if (isset($_POST['create_date_from']) && $_POST['create_date_from'] != '' && isset($_POST['create_date_to']) && $_POST['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['create_date_to'])) . '\' ';
        }

        if (isset($_POST['issue_date_from']) && $_POST['issue_date_from'] != '' && isset($_POST['issue_date_to']) && $_POST['issue_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['issue_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['issue_date_to'])) . '\' ';
        }*/
        /** POST Filters END */

        /** Session Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }
        /** Session Filters Ends */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        $SQL .= 'GROUP BY 
                 pilgrim."master"."UID",
                 voucher."Master"."CreatedDate",
                 voucher."Master"."UID",
                 main."Countries"."Name",
                 main."Cities"."Name",
                 main."Groups"."FullName", 
                 voucher."Pilgrim"."VoucherUID",
                 voucher."Master"."SystemDate",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 main."Agents"."Type",
                 sale_agent."Agents"."FullName",
                 websites."Domains"."FullName",
                 pilgrim."mofa"."MOFANumber",
                 pilgrim."visa"."VisaNumber"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE LOWER("MainQuery"."HotelCategory") LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\'  ';
        }

        return $SQL;
    }

    public
    function get_voucher_issued_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->voucher_issue_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pilgrim Exit
     * Report Functions
     */

    public
    function count_pilgrim_exit_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->pilgrim_exit();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pilgrim_exit()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PilgrimsExitSessionFilters'];

        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Exit'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }

        $SQL = 'SELECT 
                Distinct
                voucher."Pilgrim"."VoucherUID",
                voucher."Master"."VoucherCode",
                pilgrim."master"."AgentUID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                count(distinct pilgrim."meta"."PilgrimUID") AS "TotalPilgrim",
                voucher."Flights"."DepartureDate" AS "FlightDate",
                voucher."Flights"."DepartureTime" AS "FlightTime",
                concat(main."Airlines"."CountryISO2",voucher."Flights"."Reference") AS "FlightNo",
                voucher."Flights"."SectorFrom" AS "SectorFrom",
                "VP1"."PilgrimUID" AS "LeaderPilgrimUID",
                sale_agent."Agents"."FullName" as "ReferenceName",
                main."LookupsOptions"."Name" As "TransportType"
                
                  FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN voucher."TransportRate" ON voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                
                LEFT JOIN packages."Transport" ON (cast(packages."Transport"."UID" as character varying))=voucher."TransportRate"."TransportTypeUID"
                
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Transport"."Type"
                
                LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                Where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                AND voucher."Flights"."FlightType"=\'Return\'  ';

        /** Session Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= 'Group By voucher."Pilgrim"."VoucherUID",
                          voucher."Master"."VoucherCode",
                          main."Agents"."FullName",
                          main."Countries"."Name",
                          "VP1"."PilgrimUID",
                          pilgrim."master"."AgentUID",
                          voucher."Flights"."DepartureDate",
                          voucher."Flights"."DepartureTime",
                          voucher."Flights"."SectorFrom",
                          main."Airlines"."CountryISO2",
                          voucher."Flights"."Reference",
                          sale_agent."Agents"."FullName",
                          main."Agents"."Type",
                          main."LookupsOptions"."Name"';

        /** Session Filters Start */

        if (isset($SessionFilters['flight_date_from']) && $SessionFilters['flight_date_from'] != '' && isset($SessionFilters['flight_date_to']) && $SessionFilters['flight_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."FlightDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['flight_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['flight_date_to'])) . '\' ';
        }
        /** Filters END */

        return $SQL;
    }

    public
    function get_pilgrim_exit_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->pilgrim_exit();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pilgrim List
     * Report Functions
     */

    public
    function count_pilgrim_list_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->total_count_pilgrim_list();
        //echo nl2br($SQL);
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPilgrimList'];
    }

    public
    function total_count_pilgrim_list()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT count( pilgrim."master"."UID" ) AS "TotalPilgrimList"
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (pilgrim."master"."Country" = main."Countries"."ISO2")             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                 ';

        /** Filters Start */
        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['passport_no']) && trim($_POST['passport_no']) != '') {
            $SQL .= ' AND LOWER( pilgrim."master"."PassportNumber" ) LIKE \'%' . strtolower(trim($_POST['passport_no'])) . '%\' ';
        }

        if (isset($_POST['reference']) && trim($_POST['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($_POST['reference'])) . '%\' ';
        }
        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        //echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_pilgrim_list_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->pilgrim_list();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL);
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function pilgrim_list()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['PilgrimListSessionFilters'];

        $SQL = 'SELECT
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."Pilgrim"."VoucherUID", 
                pilgrim."master"."UID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."master"."Nationality",
                pilgrim."master"."Relation",
                REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \') as "CurrentStatus",
                
                main."Groups"."UID" as "GroupCode",
                main."Groups"."FullName" as "GroupName", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."Type" AS "IATAType",
                main."Agents"."FullName" AS "IATANAME",
                main."Countries"."Name" as "CountryName",
                 (CASE 
                        WHEN pilgrim."master"."CityID" != \'\' AND pilgrim."master"."CityID" IS NOT NULL 
                            THEN ( SELECT main."Cities"."Name" 
                                FROM main."Cities"
                                JOIN pilgrim."master" ON (CAST(pilgrim."master"."CityID" AS character varying) = CAST(main."Cities"."UID" AS character varying))
                            LIMIT 1
                            )
                        ELSE \'-\'
                 END) AS "CityName",
                packages."Packages"."Name" as "PackageName",
                sale_agent."Agents"."FullName" as "ReferenceName",
                pilgrim."auth"."Email" as "Email",
                pilgrim."mofa"."Embassy",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=cast(voucher."AccommodationDetails"."Hotel" as bigint)
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                             
                ) AS "HotelCategory",
                pilgrim."master"."AgentUID",
                pilgrim."master"."CurrentStatus"
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (pilgrim."master"."Country" = main."Countries"."ISO2")             
                LEFT JOIN packages."Packages" ON (pilgrim."master"."AgentUID" = packages."Packages"."AgentUID")
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL

                 ';


        /** Filters Start */
        if (isset($SearchFilter['country']) && $SearchFilter['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SearchFilter['country'] . '\' ';
        }

        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }

        if (isset($SearchFilter['passport_no']) && trim($SearchFilter['passport_no']) != '') {
            $SQL .= ' AND LOWER( pilgrim."master"."PassportNumber" ) LIKE \'%' . strtolower(trim($SearchFilter['passport_no'])) . '%\' ';
        }

        if (isset($SearchFilter['reference']) && trim($SearchFilter['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SearchFilter['reference'])) . '%\' ';
        }
        /** Filters Start */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

//        if (isset($PilgrimSearchFilter['name'])) {
//            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
//        }
//
//        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
//            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
//        }
//        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
//            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
//        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY  pilgrim."master"."UID" DESC';
     //  echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    /** Pilgrim Count
     * Report Functions
     */

    public
    function count_pilgrim_count_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pilgrim_count();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pilgrim_count()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['PilgrimCountSessionFilters'];

        $SQL = 'SELECT
                Distinct  
                count(pilgrim."master"."UID") AS "TotalPilgrim",
                main."Groups"."SystemDate" as "GroupCRDATE",
                main."Groups"."UID" as "GroupCode",
                main."Groups"."FullName" as "GroupName",
                main."Agents"."UID" as "AgentID", 
                main."Agents"."FullName" as "AgentName",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Countries"."Name" as "CountryName",
                (SELECT count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) >10
                    and "GroupUID" = main."Groups"."UID" AND "AgentUID" = main."Agents"."UID"
                    ) AS "Adults",
                    (SELECT count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) between 3 and 10
                    and "GroupUID" = main."Groups"."UID" AND "AgentUID" = main."Agents"."UID"
                    ) AS "Child",
                    (SELECT count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) <=2
                    and "GroupUID" = main."Groups"."UID" AND "AgentUID" = main."Agents"."UID"
                    ) AS "Infant",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
FROM main."GroupHotel"
LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")

LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
where main."GroupHotel"."GroupID" = "main"."Groups"."UID"

) AS "HotelCategory"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                            
                LEFT JOIN pilgrim."auth" ON pilgrim."auth"."PilgrimID"  = pilgrim."master"."UID"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL 
                  AND main."Groups"."FullName" IS NOT NULL

                 ';


        /** Filters Start */
        if (isset($SearchFilter['country']) && $SearchFilter['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SearchFilter['country'] . '\' ';
        }

        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }

        if (isset($SearchFilter['group']) && trim($SearchFilter['group']) != '') {
            $SQL .= ' AND LOWER( main."Groups"."FullName" ) LIKE \'%' . strtolower(trim($SearchFilter['group'])) . '%\' ';
        }

        if (isset($SearchFilter['reference']) && trim($SearchFilter['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SearchFilter['reference'])) . '%\' ';
        }
        /** Filters Start */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

//        if (isset($PilgrimSearchFilter['name'])) {
//            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
//        }
//
//        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
//            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
//        }
//        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
//            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
//        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= 'Group By 
                main."Groups"."UID",
                main."Groups"."FullName",
                main."Agents"."FullName",
                main."Countries"."Name",
                sale_agent."Agents"."FullName",
                main."Groups"."SystemDate",
                main."Agents"."UID"
                
                ORDER BY  count(pilgrim."master"."UID") DESC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_pilgrim_count_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pilgrim_count();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Agent Work
     * Report Functions
     */

    public
    function count_agent_work_report_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->agent_work_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function agent_work_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                  Distinct
                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."UID" as "AgentID",
                  main."Agents"."FullName" AS "AgentName",
                  packages."Packages"."Name" AS "PackageName",
                  packages."Packages"."StartDate" AS "StartDate",
                  packages."Packages"."ExpireDate" AS "ExpireDate",

(select sum( cast(voucher."AccommodationDetails"."NoOfBeds"  as int))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                    
                    where voucher."Master"."AgentUID" = main."Agents"."UID"


                    AND voucher."AccommodationDetails"."Self"=0
                    
                    ) AS "Accommodation",
(select sum( cast(voucher."AccommodationDetails"."NoOfBeds"  as int))
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID" = voucher."AccommodationDetails"."VoucherID"
                    
                    where voucher."Master"."AgentUID" = main."Agents"."UID"


                    AND voucher."AccommodationDetails"."Self"=1
                    
                    ) AS "SelfAccommodation",
(select  count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    
                    where pilgrim."master"."AgentUID" = main."Agents"."UID"
                    ) AS "TotalPax",
(select  count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    
                    where pilgrim."master"."AgentUID" = main."Agents"."UID"
                    AND pilgrim."master"."UID" IN(SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                    ) AS "Visa",
                   (select  count(pilgrim."master"."UID")
                    FROM pilgrim."master"
                    
                    where pilgrim."master"."AgentUID" = main."Agents"."UID"
                    AND pilgrim."master"."UID" NOT IN(SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
                    ) AS "NotVisa",
                    sale_agent."Agents"."FullName" as "ReferenceName"

                 FROM "voucher"."Pilgrim"
                 
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                 LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                                 
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                 LEFT JOIN packages."Packages" ON packages."Packages"."AgentUID"  = main."Agents"."UID" 
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 WHERE pilgrim."master"."FirstName" IS NOT NULL
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filters Start */
        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['reference']) && trim($_POST['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($_POST['reference'])) . '%\' ';
        }

        if (isset($_POST['start_date_from']) && $_POST['start_date_from'] != '' && isset($_POST['start_date_to']) && $_POST['start_date_to'] != '') {
            $SQL .= ' AND  packages."Packages"."StartDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['start_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['start_date_to'])) . '\' ';
        }

        if (isset($_POST['end_date_from']) && $_POST['end_date_from'] != '' && isset($_POST['end_date_to']) && $_POST['end_date_to'] != '') {
            $SQL .= ' AND  packages."Packages"."ExpireDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['end_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['end_date_to'])) . '\' ';
        }
        /** Filters Start */


        $SQL .= 'Group By
                    
                    pilgrim."master"."AgentUID",
                    main."Countries"."Name",
                    main."Agents"."UID",
                    main."Agents"."FullName",
                    packages."Packages"."Name",
                    packages."Packages"."StartDate",
                    packages."Packages"."ExpireDate",
                    sale_agent."Agents"."FullName"';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_agent_work_report_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->agent_work_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo $SQL; exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Arrival Airport
     * Report Functions
     */

    public
    function count_arrival_airport_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->arrival_airport();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function arrival_airport()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['ArrivalAirportSessionFilters'];

        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            $ArrivalMeta[] = $ArrivalCnt . "-contact-number";
        }
        $SQL = 'SELECT
                  Distinct
                  
                  voucher."Pilgrim"."VoucherUID",
                  main."Agents"."UID" as "AgentID",
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."FullName" AS "IATANAME",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  (select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim"  AS "VP1" ON ( "VP1"."PilgrimUID"  = pilgrim."master"."UID" AND  "VP1"."Leader"=1)
                         where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1
                   ),
(select pilgrim."master"."PassportNumber" AS "PPNO"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim"  AS "VP1" ON ( "VP1"."PilgrimUID"  = pilgrim."master"."UID" AND  "VP1"."Leader"=1)
                         where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1
                   ),
(select  count("VP1"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim" AS "VP1"
                    where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"         
                  ),
(select pilgrim."master"."UID" AS "LeaderPilgrimUID"
                         FROM  pilgrim."master"
                         LEFT JOIN voucher."Pilgrim"  AS "VP1" ON ( "VP1"."PilgrimUID"  = pilgrim."master"."UID" AND  "VP1"."Leader"=1)
                         where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1
                   ),
voucher."Flights"."DepartureDate",
to_char( voucher."Flights"."DepartureDate"::DATE, \'DD Mon, YYYY\') AS "DepartureDated",
                  
(select to_char( voucher."Flights"."DepartureTime"::TIME, \'HH12:MI AM\') AS "DepartureTime"
                   FROM  voucher."Flights"
                  LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"  = voucher."Flights"."VoucherID" AND voucher."Flights"."FlightType"=\'Departure\')
                  
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"="VP1"."VoucherUID"
                  
                  where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1),
(select to_char( voucher."Flights"."ArrivalDate"::DATE, \'DD Mon, YYYY\') AS "ArrivalDate"
                   FROM  voucher."Flights"
                  LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"  = voucher."Flights"."VoucherID" AND voucher."Flights"."FlightType"=\'Departure\')
                  
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"="VP1"."VoucherUID"
                  
                  where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1),
                  
(select to_char( voucher."Flights"."ArrivalTime"::TIME, \'HH12:MI AM\') AS "ArrivalTime"
                   FROM  voucher."Flights"
                  LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"  = voucher."Flights"."VoucherID" AND voucher."Flights"."FlightType"=\'Departure\')
                  
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"="VP1"."VoucherUID"
                  
                  where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1),
(select concat(main."Airlines"."Code",\'-\',voucher."Flights"."Reference")
                   FROM  voucher."Flights"
                  LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"  = voucher."Flights"."VoucherID" AND voucher."Flights"."FlightType"=\'Departure\')
                  
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"="VP1"."VoucherUID"
                  LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying)=voucher."Flights"."Airline")
                  where  "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                          Limit 1)  AS "FlightNo",
(select main."Airports"."Code" AS "SectorFrom"
       FROM voucher."Flights"
LEFT JOIN main."Airports" ON (voucher."Flights"."SectorFrom"=(cast(main."Airports" ."UID" as character varying)) AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Flights"."VoucherID"
where  voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID" Limit 1),

(select main."Airports"."Code" AS "SectorTo"
       FROM voucher."Flights"
LEFT JOIN main."Airports" ON (voucher."Flights"."SectorTo"=(cast(main."Airports" ."UID" as character varying)) AND voucher."Flights"."FlightType"=\'Departure\')
LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Flights"."VoucherID"
where  voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID" Limit 1),
(SELECT main."Cities"."Name"
        FROM "voucher"."AccommodationDetails"
        INNER JOIN main."Cities" ON  voucher."AccommodationDetails"."City"=main."Cities"."UID"
        WHERE "voucher"."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
        ORDER BY "voucher"."AccommodationDetails"."CheckIn"
        LIMIT 1) as "Destination",
(select "Look3"."Name" AS "TypeOFTransport"
From voucher."TransportRate"
INNER JOIN packages."Transport"   ON ((cast(voucher."TransportRate"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying)) AND voucher."TransportRate"."TravelType"=\'Arrival\')
INNER JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
AND voucher."TransportRate"."VoucherUID"= voucher."Pilgrim"."VoucherUID"
Limit 1),
                  main."Agents"."Type" AS "IATAType",
                  
                  
                   sale_agent."Agents"."FullName" as "ReferenceName",
                   main."Users"."FullName" as "SystemUser"

                 FROM "voucher"."Pilgrim"
                 INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                 LEFT JOIN voucher."Flights" ON ("VP1"."VoucherUID"  = voucher."Flights"."VoucherID" AND voucher."Flights"."FlightType"=\'Departure\')
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                                   
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 where  voucher."Pilgrim"."VoucherUID" IS NOT NULL 

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }


        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        if (!isset($SessionFilters['arrival_date_from']) && !isset($SessionFilters['arrival_date_to'])) {
            $SQL .= ' AND voucher."Flights"."DepartureDate" >= CURRENT_DATE';
        }
        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Flights"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }
        if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '' && isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
            $SQL .= ' AND voucher."Flights"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' Group By
                    voucher."Pilgrim"."VoucherUID", 
                    main."Countries"."Name",
                    main."Agents"."UID",
                    main."Agents"."FullName",
                    voucher."Master"."VoucherCode",
                    sale_agent."Agents"."FullName",
                    main."Agents"."Type",
                    "VP1"."PilgrimUID",
                    main."Users"."FullName",
                    voucher."Flights"."DepartureDate"';
        $SQL .= ' Order By voucher."Flights"."DepartureDate" ASC';
        /*if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
                        WHERE "MainQuery"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '' && isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
                        WHERE "MainQuery"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_to'])) . '\' ';
        }*/

        if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
                    WHERE LOWER( "MainQuery"."TypeOFTransport" ) = \'' . strtolower(trim($SessionFilters['tpt_type'])) . '\' ';
        }
//echo $SQL;exit;

        return $SQL;
    }


    /** Development Start By Jawad Sajid Durrani */

    public
    function get_arrival_airport_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->arrival_airport();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Executed Vouchers
     * Report Functions
     */

    public
    function count_executed_vouchers_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->executed_voucher();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function executed_voucher()
    {
        $data = $this->data;
        $Crud = new Crud();
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $KSAMeta = array();
        foreach ($ExitCount['InKSA'] as $InKSACnt) {
            $KSAMeta[] = $InKSACnt . "-status";
        }
        $session = session();
        $session = $session->get();

        $SearchFilter = $session['ExecutedVoucherSessionFilters'];

        $SQL = 'SELECT
                voucher."Master"."CreatedDate",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" as "SubAgentName",
                main."Agents"."ParentID",
                voucher."Master"."CreatedBy",
                voucher."Master"."ModifiedBy",
                voucher."Master"."ModifiedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                voucher."Master"."ArrivalType",
                voucher."Pilgrim"."VoucherUID",
                
                main."Agents"."Type" AS "IATAType",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "AgentName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "UserCreatedBy",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."ModifiedBy"
                ) AS "UserModifiedBy",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) >10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Adults",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) between 3 and 10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Child",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) <=2
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Infant",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Departure\'
                 limit 1
                ) AS "ArrivalDate",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Return\'
                 limit 1
                ) As "DepartureDate",
                (select
                (select 
                CASE WHEN SUM("Mecca"."Nights") >0 THEN SUM("Mecca"."Nights") ELSE 0 END AS "MeccaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Mecca")
                +
                (select 
                CASE WHEN SUM("Medina"."Nights") >0 THEN SUM("Medina"."Nights") ELSE 0 END AS "MedinaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Medina")
                +
                (select 
                CASE WHEN SUM("Jeddah"."Nights") >0 THEN SUM("Jeddah"."Nights") ELSE 0 END AS "JeddahNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Jeddah")
                )  AS "TotalNights",
                (select 
                count(Distinct pilgrim."meta"."PilgrimUID")
                From pilgrim."meta"
                INNER JOIN voucher."Pilgrim" ON (voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID" AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID")
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\')) AS "Departue",
                (select 
                count( Distinct pilgrim."meta"."PilgrimUID")
                From pilgrim."meta"
                INNER JOIN voucher."Pilgrim" ON (voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID" AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID")
                where pilgrim."meta"."Option" IN(\'' . implode("','", $KSAMeta) . '\')
                AND pilgrim."meta"."PilgrimUID" NOT IN(select 
                Distinct
                pilgrim."meta"."PilgrimUID"
                From pilgrim."meta"
                INNER JOIN voucher."Pilgrim" ON (voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID" AND voucher."Pilgrim"."VoucherUID"=voucher."Master"."UID")
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\'))) AS "InKSA"

                
                FROM voucher."Master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN websites."Domains" ON websites."Domains"."UID" = voucher."Master"."WebsiteDomain"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 
                AND voucher."Master"."VoucherType" != \'B2C\' 
                AND voucher."Master"."CurrentStatus"=\'Executed\'';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                                SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                                WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                              )  ';
        }

        /** Filter Starts */
        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }
        /** Filter ENDS */

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        $SQL .= 'GROUP BY 
                 voucher."Master"."CreatedDate",
                 voucher."Master"."UID",
                 main."Countries"."Name",
                 voucher."Pilgrim"."VoucherUID",
                 main."Agents"."FullName",
                 main."Agents"."ParentID",
                 main."Agents"."Type",
                 main."Agents"."Type",
                 sale_agent."Agents"."FullName",
                 websites."Domains"."FullName"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        if (isset($SearchFilter['arrival_date_from']) && $SearchFilter['arrival_date_from'] != '' && isset($SearchFilter['arrival_date_to']) && $SearchFilter['arrival_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['arrival_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['departure_date_from']) && $SearchFilter['departure_date_from'] != '' && isset($SearchFilter['departure_date_to']) && $SearchFilter['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['departure_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['voucher_no']) && trim($SearchFilter['voucher_no']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."VoucherCode" LIKE \'%' . trim($SearchFilter['voucher_no']) . '%\' ';
        }
//echo $SQL;exit();
        // $records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_executed_vouchers_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->executed_voucher();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Group Stats
     * Report Functions
     */

    public
    function count_group_stats_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->group_stats();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function group_stats()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SearchFilter = $session['GroupStatsSessionFilters'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $CheckInMeccaCount = StatusCheckList();
        $CheckInMeccaMeta = array();
        foreach ($CheckInMeccaCount['CheckInMecca'] as $CheckInMeccaCnt) {
            $CheckInMeccaMeta[] = $CheckInMeccaCnt . "-status";
        }
        $CheckInMedinaCount = StatusCheckList();
        $CheckInMedinaMeta = array();
        foreach ($CheckInMedinaCount['CheckInMedina'] as $CheckInMedinaCnt) {
            $CheckInMedinaMeta[] = $CheckInMedinaCnt . "-status";
        }
        $CheckInJeddahCount = StatusCheckList();

        $CheckInJeddahMeta = array();
        foreach ($CheckInJeddahCount['CheckInJeddah'] as $CheckInJeddahCnt) {
            $CheckInJeddahMeta[] = $CheckInJeddahCnt . "-status";
        }

        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }

        $SQL = 'SELECT

                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" AS "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Agents"."Type" AS "IATAType",
                main."Groups"."UID" AS "GroupCode",
                pilgrim."master"."GroupUID",
                main."Groups"."FullName" as "GroupName",
                count(pilgrim."master"."GroupUID") AS "TotalPAX",
                (select count(pilgrim."mofa"."PilgrimID") 
                FROM  pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" )) AS "MofaIssued",
                count(pilgrim."master"."GroupUID")- (select count(pilgrim."mofa"."PilgrimID") 
                FROM  pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" )) AS "MofaNotIssued",
                
                (select count(pilgrim."visa"."PilgrimID") 
                FROM  pilgrim."visa"
                where pilgrim."visa"."PilgrimID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" ) AND  pilgrim."visa"."IssueDate" IS NOT NULL) AS "VisaIssued",
                
                count(pilgrim."master"."GroupUID")- (select count(pilgrim."visa"."PilgrimID") 
                FROM  pilgrim."visa"
                where pilgrim."visa"."PilgrimID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" ) AND  pilgrim."visa"."IssueDate" IS NOT NULL) AS "VisaNotIssued",
                (select count(voucher."Pilgrim"."PilgrimUID") 
                FROM  voucher."Pilgrim"
                where voucher."Pilgrim"."PilgrimUID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" )) AS "VoucherIssued",
                count(pilgrim."master"."GroupUID")-(select count(voucher."Pilgrim"."PilgrimUID") 
                FROM  voucher."Pilgrim"
                where voucher."Pilgrim"."PilgrimUID" IN (select pilgrim."master"."UID"
                From pilgrim."master"
                where pilgrim."master"."GroupUID"=main."Groups"."UID" )) AS "VoucherNotIssued",
                sale_agent."Agents"."FullName" as "ReferenceName",
                
                (select count(voucher."Pilgrim"."PilgrimUID") 
                FROM  pilgrim."master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
                AND pilgrim."master"."GroupUID"=main."Groups"."UID") AS "Arrived",
                
                (select  count(voucher."Pilgrim"."PilgrimUID") 
                    FROM  pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMeccaMeta) . '\') 
                    AND pilgrim."master"."GroupUID"=main."Groups"."UID"
                      ) AS "CheckInMecca",
                (select  count(voucher."Pilgrim"."PilgrimUID") 
                    FROM  pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\') 
                    AND pilgrim."master"."GroupUID"=main."Groups"."UID"
                      ) AS "CheckInMedina",
                (select  count(voucher."Pilgrim"."PilgrimUID") 
                    FROM  pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInJeddahMeta) . '\') 
                    AND pilgrim."master"."GroupUID"=main."Groups"."UID"
                      ) AS "CheckInJeddah",
                (select  count(voucher."Pilgrim"."PilgrimUID") 
                    FROM  pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\') 
                    AND pilgrim."master"."GroupUID"=main."Groups"."UID"
                      ) AS "Exit",
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                    FROM main."GroupHotel"
                    LEFT JOIN packages."Hotels" ON (packages."Hotels"."UID" = main."GroupHotel"."Hotel")
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where main."GroupHotel"."GroupID" = "main"."Groups"."UID"

                ) AS "HotelCategory"
                 
                
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON main."Agents"."CountryID" = main."Countries"."ISO2" 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where pilgrim."master"."GroupUID">0

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filters Start */
        if (isset($SearchFilter['country']) && $SearchFilter['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SearchFilter['country'] . '\' ';
        }

        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' Group By pilgrim."master"."GroupUID",
        main."Groups"."UID",
                  main."Groups"."FullName",
                  main."Agents"."FullName",
                  main."Countries"."Name",
                  main."Agents"."UID",
                  sale_agent."Agents"."FullName"
                  ORDER BY  count(pilgrim."master"."GroupUID") DESC';

        /** Filters Start */
        if (isset($SearchFilter['group']) && trim($SearchFilter['group']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."GroupName" LIKE \'%' . trim($SearchFilter['group']) . '%\'  ';
        }

        if (isset($SearchFilter['reference']) && trim($SearchFilter['reference']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ReferenceName" LIKE \'%' . trim($SearchFilter['reference']) . '%\'  ';
        }
        /** Filters ENDS */

        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_group_stats_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->group_stats();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Hotel Purchase
     * Report Functions
     */

    public
    function count_htl_purchase_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_purchase();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function htl_brn_purchase()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['HotelPurchaseSessionFilters'];

        $SQL = 'SELECT
                    "BRN"."brn"."GenerateDate",
                    "BRN"."brn"."ExpireDate",
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                    main."Cities"."Name" as "CityName",
                    packages."Hotels"."Name" as "HotelName",
                    packages."Hotels"."UID" as "HotelUID",
                    "BRN"."brn"."Rooms",
                    "BRN"."brn"."Beds",
                    "BRN"."brn"."GenerateDate" AS "ChechInDate",
                    "BRN"."brn"."ActiveDate" AS "CheckOutDate",
                    "BRN"."brn"."ActiveDate"::date - "BRN"."brn"."GenerateDate"::date AS "TotalNights",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"="BRN"."brn"."HotelsID"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                    where "BRN"."brn"."BRNType"=\'hotel\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */
        if (isset($SearchFilter['booking_date_from']) && $SearchFilter['booking_date_from'] != '' && isset($SearchFilter['booking_date_to']) && $SearchFilter['booking_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."GenerateDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['booking_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['check_in_date_from']) && $SearchFilter['check_in_date_from'] != '' && isset($SearchFilter['check_in_date_to']) && $SearchFilter['check_in_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ChechInDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['check_in_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['booking_id']) && trim($SearchFilter['booking_id']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."PurchaseID" LIKE \'%' . trim($SearchFilter['booking_id']) . '%\' ';
        }

//        if (isset($_POST['hotel_name']) && trim($_POST['hotel_name']) != '') {
//            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
//                        WHERE "MainQuery"."HotelName" LIKE \'%' . trim($SearchFilter['hotel_name']) . '%\' ';
//        }
//


        if (isset($SearchFilter['hotel_name']) && trim($SearchFilter['hotel_name']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."HotelUID" = ' . $SearchFilter['hotel_name'] . ' ';
        }

        if (isset($SearchFilter['city']) && trim($SearchFilter['city']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."CityName" LIKE \'%' . trim($SearchFilter['city']) . '%\' ';
        }
        /** Filters
         * ENDS
         */

        //$records = $Crud->ExecuteSQL($SQL);

//        echo $SQL;
        return $SQL;
    }

    public
    function get_htl_purchase_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_purchase();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Hotel Use
     * Visa Report
     * Functions
     */

    public
    function count_htl_use_visa_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_use_visa();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function htl_brn_use_visa()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['HotelUseVisaSessionFilters'];

        $SQL = 'SELECT
                    "BRN"."brn"."UID",
                    "BRN"."brn"."GenerateDate",
                    "BRN"."brn"."ExpireDate",
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                    main."Cities"."Name" as "CityName",
                    packages."Hotels"."Name" as "HotelName",
                    packages."Hotels"."UID" as "HotelUID",
                    "BRN"."brn"."Rooms",
                    "BRN"."brn"."Beds",
                    "BRN"."brn"."GenerateDate" AS "ChechInDate",
                    "BRN"."brn"."ActiveDate" AS "CheckOutDate",
                    "BRN"."brn"."ActiveDate"::date - "BRN"."brn"."GenerateDate"::date AS "TotalNights",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"="BRN"."brn"."HotelsID"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                    where "BRN"."brn"."BRNType"=\'hotel\'
                    AND "BRN"."brn"."Archive"=0

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }


        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */
        if (isset($SearchFilter['booking_date_from']) && $SearchFilter['booking_date_from'] != '' && isset($SearchFilter['booking_date_to']) && $SearchFilter['booking_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."GenerateDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['booking_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['expiry_date_from']) && $SearchFilter['expiry_date_from'] != '' && isset($SearchFilter['expiry_date_to']) && $SearchFilter['expiry_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ExpireDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['expiry_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['expiry_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['check_in_date_from']) && $SearchFilter['check_in_date_from'] != '' && isset($SearchFilter['check_in_date_to']) && $SearchFilter['check_in_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ChechInDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['check_in_date_to'])) . '\' ';
        }

        if (isset($SearchFilter['booking_id']) && trim($SearchFilter['booking_id']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."PurchaseID" LIKE \'%' . trim($SearchFilter['booking_id']) . '%\' ';
        }

        if (isset($SearchFilter['hotel_name']) && trim($SearchFilter['hotel_name']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."HotelUID" = ' . $SearchFilter['hotel_name'] . ' ';
        }

        if (isset($SearchFilter['city']) && trim($SearchFilter['city']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."CityName" LIKE \'%' . trim($SearchFilter['city']) . '%\' ';
        }
        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_htl_use_visa_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_use_visa();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Late Departure
     * Report Functions
     */

    public
    function count_late_departure_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->completed_late_departure_counter_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function completed_late_departure_counter_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }

        $SearchFilter = $session['LateDepartureSessionFilters'];

        $SQL = 'SELECT
                voucher."Pilgrim"."VoucherUID",
                pilgrim."master"."UID" AS "PilgrimID",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Groups"."UID" as "GroupID",
                main."Groups"."FullName" as "GroupName",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."Nationality",
                pilgrim."master"."DOB",
                pilgrim."mofa"."MOFANumber",
                pilgrim."travel"."VisaNo",
                pilgrim."travel"."MOINumber",
                pilgrim."travel"."EntryDate",
                pilgrim."travel"."EntryTime",
                pilgrim."travel"."EntryPort",
                pilgrim."travel"."TransportMode" AS "ArrivalMode",
                pilgrim."travel"."EntryCarrier",
                pilgrim."travel"."FlightNo",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName",
                (select voucher."Flights"."DepartureDate"
                    FROM pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                    where voucher."Flights"."FlightType"=\'Return\'  limit 1
                    ) AS "DepartureDate",
                (select DATE_PART(\'day\', AGE(CURRENT_DATE, min(voucher."Flights"."DepartureDate")))
                    FROM pilgrim."master"
                    LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN voucher."Flights" ON voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                    where voucher."Flights"."FlightType"=\'Return\'  limit 1
                    ) AS "Days",
                (select main."LookupsOptions"."Name"
                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                    where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID" ORDER BY voucher."AccommodationDetails"."UID" DESC Limit 1
                                  
                    ) AS "HotelCategory"
                FROM "voucher"."Pilgrim"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"=voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where abs(extract(day from CURRENT_DATE - voucher."Master"."ArrivalDate"::timestamp))>= 25
                AND pilgrim."master"."UID" IN(SELECT  pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\'))
                AND pilgrim."master"."AgentUID" IS NOT NULL
                  
             ';
        $SQL .= '  AND pilgrim."master"."UID" IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')';


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filters Start */
        if (isset($SearchFilter['country']) && $SearchFilter['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SearchFilter['country'] . '\' ';
        }

        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }

        if (isset($SearchFilter['entry_date_from']) && $SearchFilter['entry_date_from'] != '' && isset($SearchFilter['entry_date_to']) && $SearchFilter['entry_date_to'] != '') {
            $SQL .= ' AND  pilgrim."travel"."EntryDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['entry_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['entry_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        $SQL .= ' ORDER BY  pilgrim."master"."UID" ASC';


        if (isset($SearchFilter['departure_date_from']) && $SearchFilter['departure_date_from'] != '' && isset($SearchFilter['departure_date_to']) && $SearchFilter['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['departure_date_to'])) . '\' ';
        }

        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_late_departure_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->completed_late_departure_counter_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_departure_airport_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->departure_airport();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function departure_airport()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['DepartureAirportReportSessionFilters'];

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Exit'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            $ArrivalMeta[] = $ArrivalCnt . "-contact-number";
            $ArrivalMeta[] = $ArrivalCnt . "-driver-contact-number";
            $ArrivalMeta[] = $ArrivalCnt . "-driver-mobile-number";
            $ArrivalMeta[] = $ArrivalCnt . "-driver-name";
        }
        ///print_r($ArrivalMeta);

        $SQL = 'SELECT
                  Distinct
                  "PilgrimMeta"."SystemDate",
                  voucher."Pilgrim"."VoucherUID",
                  voucher."TransportRate"."UID" AS "TransportRateUID",
                  voucher."Flights"."UID" AS "FlightsUID",
                  voucher."Flights"."SectorFrom",
                  pilgrim."master"."AgentUID",
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."UID" as "AgentID",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  (SELECT main."Cities"."Name"
                    FROM "voucher"."AccommodationDetails"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."AccommodationDetails"."City"
                    WHERE "voucher"."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                    ORDER BY "voucher"."AccommodationDetails"."CheckIn"
                    LIMIT 1) as "Destination",
(select  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM  voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
                    AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate"           
                  ),
                  (SELECT s."HotelCity" FROM (

select Distinct main."Cities"."Name" AS "HotelCity"
FROM main."Cities"
INNER JOIN packages."OtherHotels" ON packages."OtherHotels"."CityID"=main."Cities"."UID"
AND packages."OtherHotels"."UID" IN(cast((select (SELECT Distinct pilgrim."meta"."Value"
FROM pilgrim."meta"
WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
AND pilgrim."meta"."Option" LIKE \'departure-%-actual-hotel\'
AND pilgrim."meta"."PilgrimUID" IN((select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM voucher."Pilgrim"
LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
ORDER BY pilgrim."meta"."Option" Limit 1
))

)) as int))

UNION ALL
select Distinct main."Cities"."Name" AS "HotelCity"
FROM main."Cities"
INNER JOIN packages."Hotels" ON packages."Hotels"."CityID"=main."Cities"."UID"
AND packages."Hotels"."UID" IN(cast((select (SELECT Distinct pilgrim."meta"."Value"
FROM pilgrim."meta"
WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
AND pilgrim."meta"."Option" LIKE \'departure-%-package-hotel\'

AND pilgrim."meta"."PilgrimUID" IN((select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
FROM voucher."Pilgrim"
LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
ORDER BY pilgrim."meta"."Option" Limit 1
))
)) as int))
Limit 1
) s
),

(

SELECT AH."ActualHotel" FROM (

                select Distinct packages."OtherHotels"."Name" AS "ActualHotel"
                FROM packages."OtherHotels" 
                where packages."OtherHotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                FROM pilgrim."meta"
                WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                AND pilgrim."meta"."Option" LIKE \'departure-%-actual-hotel\'
                AND pilgrim."meta"."PilgrimUID" IN((select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                FROM voucher."Pilgrim"
                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                 AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                ORDER BY pilgrim."meta"."Option" Limit 1
                ))
                )) as int))

                UNION ALL
                select Distinct packages."OtherHotels"."Name" AS "ActualHotel"
                FROM packages."OtherHotels" 
                where packages."OtherHotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                FROM pilgrim."meta"
                WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                AND pilgrim."meta"."Option" LIKE \'departure-%-package-hotel\'
                AND pilgrim."meta"."PilgrimUID" IN((select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                FROM voucher."Pilgrim"
                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                 AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                ORDER BY pilgrim."meta"."Option" Limit 1
                ))
                )) as int))
Limit 1
) AH
),
                  (SELECT string_agg(Distinct "meta"."Value", \',\') 
                    FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "Option"  LIKE \'departure-%-room-no\'
                    
                    ) AS "RoomNo",
                     (SELECT string_agg(Distinct to_char( "meta"."Value"::TIME, \'HH12:MI AM\'), \',\') 
                    FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "Option"  LIKE \'departure-%-hotel-time\'
                    
                    ) AS "DepartureHotelTime",
                    (SELECT string_agg(Distinct "meta"."Value", \',\') 
                    FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "Option"  LIKE \'departure-%-vehicle-number\'
                    AND pilgrim."meta"."PilgrimUID" IN(select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
                    FROM voucher."Pilgrim"
                    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                     AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                    
                    ) 
                    ) AS "VehicleNumber",
            voucher."TransportRate"."NoOfSeats" AS "Seats",
            (select CONCAT(main."Airports"."Code", \' - \',main."Airports"."Name")
            From main."Airports"
            where (cast(main."Airports"."UID" as character varying))=(cast(voucher."Flights"."SectorFrom" as character varying))
            
            )  AS "AirPort",

        (select concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName"
             FROM  pilgrim."master"
             LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
             LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
             where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
             AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
        ),
                   
(select pilgrim."master"."PassportNumber" AS "PPNO"
   FROM  pilgrim."master"
   LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
   LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
   where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
   AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
   ),
                   
   (
        select pilgrim."meta"."Value" AS "LeaderPilgrimContactNumber"
        FROM  pilgrim."master"
        LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
        where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
        AND pilgrim."meta"."Option" like \'%contact-number\'
        AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
   ),
                   
                   
   (SELECT string_agg(Distinct "meta"."Value", \',\') 
    FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
    AND "Option"  LIKE \'departure-%-driver-mobile-number\'
    AND pilgrim."meta"."PilgrimUID" IN(select pilgrim."meta"."PilgrimUID" AS "LeaderPilgrimUID"
    FROM voucher."Pilgrim"
    LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
    where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
     AND pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
    
    )) AS "DriverContactNumber",
   (
        SELECT pilgrim."meta"."Value" AS "DriverName"
        FROM  pilgrim."master"
        LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
        where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') 
        AND pilgrim."meta"."Option" like \'%driver-name\'
        AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" Limit 1
   ),
                   
   (
        select to_char( voucher."Flights"."DepartureDate"::DATE, \'DD Mon, YYYY\') as "DepartureDate"
        FROM  pilgrim."master"
        LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
        LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
        LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
        where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
        AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
   ),
                   
   (
        select to_char( voucher."Flights"."DepartureTime"::TIME, \'HH12:MI AM\') as "DepartureTime"
        FROM  pilgrim."master"
        LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
        LEFT JOIN pilgrim."meta"  ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
        LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
        LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
        where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
        AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
   ),(
                select concat(main."Airlines"."Code",\'-\',voucher."Flights"."Reference")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
                LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying)=voucher."Flights"."Airline")
                where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
            ) AS "FlightNo",(
                        select "Look3"."Name" AS "TypeOFTransport"
                        FROM  pilgrim."master"
                        LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                        LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                        LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                        LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
                        LEFT JOIN main."Airlines" ON (cast(main."Airlines"."UID" as character varying))=voucher."Flights"."Airline"
                        LEFT JOIN main."Airports" AS  "Airports1" ON (cast("Airports1" ."UID" as character varying)) =voucher."Flights"."SectorFrom"
                        LEFT JOIN main."Airports" AS  "Airports2" ON (cast("Airports2" ."UID" as character varying)) =voucher."Flights"."SectorTo"
                        Left JOIN voucher."TransportRate"  AS  "TR1" ON "TR1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                        Left JOIN packages."Transport"   ON (cast("TR1"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                        LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                        where  pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                        AND pilgrim."meta"."SystemDate"="PilgrimMeta"."SystemDate" limit 1
                   ),
                   (SELECT string_agg(Distinct main."LookupsOptions"."Name", \',\') AS "TransportCompany"
                    FROM "main"."LookupsOptions"
                    LEFT JOIN "pilgrim"."meta"  ON (cast("main"."LookupsOptions"."UID" as character varying))="pilgrim"."meta"."Value"
                    WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "pilgrim"."meta"."Option" LIKE \'departure-%-transport-company\'
                   ),
                   sale_agent."Agents"."FullName" as "ReferenceName",
                   main."Users"."FullName" as "SystemUser"

                 FROM "voucher"."Pilgrim"
                 LEFT JOIN voucher."Pilgrim" AS "VP1" ON ("VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND "VP1"."Leader"=1)
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                 LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."FlightType"=\'Return\')
                 LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."TravelType"=\'Departure\')
                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                 LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                                   
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 where "PilgrimMeta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        /** Filters ENDS */
        $SQL .= ' Group By
                    voucher."Pilgrim"."VoucherUID", 
                    voucher."Flights"."UID",
                    voucher."TransportRate"."UID",
                    voucher."TransportRate"."NoOfSeats",
                    pilgrim."master"."AgentUID",
                    main."Countries"."Name",
                    main."Agents"."UID",
                    main."Agents"."FullName",
                    voucher."Master"."VoucherCode",
                    sale_agent."Agents"."FullName",
                    main."Agents"."Type",
                    "VP1"."PilgrimUID",
                    main."Users"."FullName",
                    "PilgrimMeta"."SystemDate"';

        if (isset($SessionFilters['departure_date_from']) && $SessionFilters['departure_date_from'] != '' && isset($SessionFilters['departure_date_to']) && $SessionFilters['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE to_char( "MainQuery"."DepartureDate"::DATE, \'YYYY-mm-dd\') BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['departure_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
                    WHERE LOWER( "MainQuery"."TypeOFTransport" ) LIKE \'%' . strtolower(trim($SessionFilters['tpt_type'])) . '%\' ';
        }


//        echo nl2br($SQL); exit();
//        echo $SQL; exit();
        //$records = $Crud->ExecuteSQL($SQL);

        //return $records;
        return $SQL;
    }

    public
    function get_departure_airport_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->departure_airport();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Passport Pending
     * Report Functions
     */

    public
    function count_passport_pending_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->passport_pending();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function passport_pending()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['PassportPendingSessionFilters'];

        $SQL = 'SELECT 
                  pilgrim."master"."UID",
                  pilgrim."master"."AgentUID",
                  main."Agents"."FullName" AS "AgentName",
                  main."Groups"."FullName" as "GroupName",
                  concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName",
                  pilgrim."master"."PassportNumber" AS "PPNO",
                  pilgrim."travel"."EntryDate" AS "ActualArrivalDate",
                  pilgrim."travel"."EntryPort" AS "EntryPort"
                  
                  FROM pilgrim."master"
                  LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID"
                   LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"                 
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."UID" NOT IN ( SELECT pilgrim."attachments"."PilgrimID"
                  FROM pilgrim."attachments"
                  WHERE pilgrim."attachments"."FileDescription" IN( \'PassportFrontPic\' , \'PassportBackPic\' , \'PassportBookletPic\'))

                 ';

        /** Filters Start */
        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }

        if (isset($SearchFilter['group']) && trim($SearchFilter['group']) != '') {
            $SQL .= ' AND  LOWER(main."Groups"."FullName") LIKE \'%' . strtolower(trim($SearchFilter['group'])) . '%\' ';
        }

        if (isset($SearchFilter['ppt_number']) && trim($SearchFilter['ppt_number']) != '') {
            $SQL .= ' AND  pilgrim."master"."PassportNumber" = \'' . trim($SearchFilter['ppt_number']) . '\' ';
        }

        if (isset($SearchFilter['arrival_date_from']) && $SearchFilter['arrival_date_from'] != '' && isset($SearchFilter['arrival_date_to']) && $SearchFilter['arrival_date_to'] != '') {
            $SQL .= ' AND  pilgrim."travel"."EntryDate" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['arrival_date_to'])) . '\' ';
        }
        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

//        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
//            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
//        }
//        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
//            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
//        }
//        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
//            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
//        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY  pilgrim."master"."UID" DESC';


        /** Filters Start */
        if (isset($_POST['full_name']) && trim($_POST['full_name']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE LOWER("MainQuery"."FullName") LIKE \'%' . strtolower(trim($_POST['full_name'])) . '%\' ';
        }
        /** Filters ENDS */

        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_passport_pending_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->passport_pending();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Passport Complete
     * Report Functions
     */

    public
    function count_passport_complete_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->passport_completed();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function passport_completed()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SearchFilter = $session['PassportCompleteSessionFilters'];
//        print_r($SearchFilter);

        $SQL = 'SELECT 
                  pilgrim."master"."UID",
                  pilgrim."master"."AgentUID",
                  main."Agents"."FullName" AS "AgentName",
                  main."Groups"."FullName" as "GroupName",
                  concat(pilgrim."master"."FirstName",pilgrim."master"."LastName") AS "FullName",
                  pilgrim."master"."PassportNumber" AS "PPNO",
                  pilgrim."master"."DOB",
                  pilgrim."master"."Nationality",
                  pilgrim."travel"."EntryDate" AS "ActualArrivalDate",
                  pilgrim."travel"."EntryPort" AS "EntryPort",
                  (select pilgrim."attachments"."FileID"
                   FROM  pilgrim."attachments"

                   where pilgrim."attachments"."PilgrimID" = pilgrim."master"."UID" 
                   AND pilgrim."attachments"."FileDescription"=\'PassportFrontPic\') AS "PassportFrontPicFileID",
                  (select pilgrim."attachments"."FileID"
                   FROM  pilgrim."attachments"

                   where pilgrim."attachments"."PilgrimID" = pilgrim."master"."UID" 
                   AND pilgrim."attachments"."FileDescription"=\'PassportBackPic\') AS "PassportBackPicFileID",
                   (select pilgrim."attachments"."FileID"
                   FROM  pilgrim."attachments"

                   where pilgrim."attachments"."PilgrimID" = pilgrim."master"."UID" 
                   AND pilgrim."attachments"."FileDescription"=\'PassportBookletPic\') AS "PassportBookletPicFileID"
                  FROM pilgrim."master"
                  LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID"
                   LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"                 
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                  WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."UID" IN ( SELECT pilgrim."attachments"."PilgrimID"
                  FROM pilgrim."attachments"
                  WHERE pilgrim."attachments"."FileDescription" IN( \'PassportFrontPic\' , \'PassportBackPic\' , \'PassportBookletPic\'))

                 ';

        /** Filters Start */
        if (isset($SearchFilter['agent']) && $SearchFilter['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SearchFilter['agent'] . '\' ';
        }

        if (isset($SearchFilter['group']) && trim($SearchFilter['group']) != '') {
            $SQL .= ' AND  main."Groups"."UID" = '.$SearchFilter['group'].' ';
        }

        if (isset($SearchFilter['ppt_number']) && trim($SearchFilter['ppt_number']) != '') {
            $SQL .= ' AND  pilgrim."master"."PassportNumber" = \'' . trim($SearchFilter['ppt_number']) . '\' ';
        }

        if (isset($SearchFilter['dob_from']) && $SearchFilter['dob_from'] != '' && isset($SearchFilter['dob_to']) && $SearchFilter['dob_to'] != '') {
            $SQL .= ' AND  pilgrim."master"."DOB" BETWEEN \'' . date("Y-m-d", strtotime($SearchFilter['dob_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SearchFilter['dob_to'])) . '\' ';
        }
        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
//
//        if (isset($PilgrimSearchFilter['name'])) {
//            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
//        }
//
//        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
//            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
//        }
//        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
//            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
//        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY  pilgrim."master"."UID" DESC';


        /** Filters Start */
        if (($SearchFilter['full_name']) && trim($SearchFilter['full_name']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE LOWER("MainQuery"."FullName") LIKE \'%' . strtolower(trim($SearchFilter['full_name'])) . '%\' ';
        }
        /** Filters ENDS */

        //echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_passport_complete_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->passport_completed();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Updated Vouchers
     * Report Functions
     */

    public
    function count_updated_vouchers_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->update_voucher_list();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function update_voucher_list()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['UpdateVoucherSessionFilters'];

        $SQL = 'SELECT
                voucher."Master"."CreatedDate",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" as "SubAgentName",
                main."Agents"."ParentID",
                voucher."Master"."CreatedBy",
                voucher."Master"."ModifiedBy",
                voucher."Master"."ModifiedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                
                voucher."Pilgrim"."VoucherUID",
                
                main."Agents"."Type" AS "IATAType",                
                sale_agent."Agents"."FullName" as "ReferenceName",                
                (select  main."Agents"."FullName"
                FROM main."Agents"                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "AgentName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "UserCreatedBy",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."ModifiedBy"
                ) AS "UserModifiedBy",
                
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                
                
                FROM voucher."Master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN websites."Domains" ON websites."Domains"."UID" = voucher."Master"."WebsiteDomain"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 
                AND voucher."Master"."VoucherType" != \'B2C\' 
                AND voucher."Master"."UpdationCounter">0';


        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
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
        /** Filters ENDS */


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN
                    ( 
                                SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                                WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                    )  ';
        }

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        $SQL .= 'GROUP BY 
                 voucher."Master"."CreatedDate",
                 voucher."Master"."UID",
                 main."Countries"."Name",
                 voucher."Pilgrim"."VoucherUID",
                 main."Agents"."FullName",
                 main."Agents"."ParentID",
                 main."Agents"."Type",
                 main."Agents"."Type",
                 sale_agent."Agents"."FullName",
                 websites."Domains"."FullName"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_updated_vouchers_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->update_voucher_list();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pending Vouchers
     * Report Functions
     */

    public
    function count_pending_voucher_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pending_voucher_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pending_voucher_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];

        $SQL = 'SELECT
                voucher."Master"."CreatedDate",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" as "SubAgentName",
                main."Agents"."ParentID",
                voucher."Master"."CreatedBy",
                voucher."Master"."ModifiedBy",
                voucher."Master"."ModifiedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                
                voucher."Pilgrim"."VoucherUID",
                
                main."Agents"."Type" AS "IATAType",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "AgentName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "UserCreatedBy",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."ModifiedBy"
                ) AS "UserModifiedBy",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) >10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Adults",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) between 3 and 10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Child",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) <=2
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Infant",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Departure\'
                 limit 1
                ) AS "ArrivalDate",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Return\'
                 limit 1
                ) As "DepartureDate",
                (select
                (select 
                CASE WHEN SUM("Mecca"."Nights") >0 THEN SUM("Mecca"."Nights") ELSE 0 END AS "MeccaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Mecca")
                +
                (select 
                CASE WHEN SUM("Medina"."Nights") >0 THEN SUM("Medina"."Nights") ELSE 0 END AS "MedinaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Medina")
                +
                (select 
                CASE WHEN SUM("Jeddah"."Nights") >0 THEN SUM("Jeddah"."Nights") ELSE 0 END AS "JeddahNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Jeddah")
                )  AS "TotalNights"
                
                FROM voucher."Master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN websites."Domains" ON websites."Domains"."UID" = voucher."Master"."WebsiteDomain"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 
                AND voucher."Master"."VoucherType" != \'B2C\' 
                AND voucher."Master"."CurrentStatus"=\'Pending\'';

        /** Filters Start */
        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }


        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['voucher_code']) && trim($_POST['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_code']) . '\' ';
        }

        if (isset($_POST['create_date_from']) && $_POST['create_date_from'] != '' && isset($_POST['create_date_to']) && $_POST['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                                SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                                WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                              )  ';
        }

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        $SQL .= 'GROUP BY 
                 voucher."Master"."CreatedDate",
                 voucher."Master"."UID",
                 main."Countries"."Name",
                 voucher."Pilgrim"."VoucherUID",
                 main."Agents"."FullName",
                 main."Agents"."ParentID",
                 main."Agents"."Type",
                 main."Agents"."Type",
                 sale_agent."Agents"."FullName",
                 websites."Domains"."FullName"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        if (isset($_POST['arrival_date_from']) && $_POST['arrival_date_from'] != '' && isset($_POST['arrival_date_to']) && $_POST['arrival_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['arrival_date_to'])) . '\' ';
        }

        if (isset($_POST['departure_date_from']) && $_POST['departure_date_from'] != '' && isset($_POST['departure_date_to']) && $_POST['departure_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['departure_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['departure_date_to'])) . '\' ';
        }


        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_pending_voucher_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pending_voucher_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Vouchers Summary
     * Report Functions
     */

    public
    function count_voucher_summary_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->voucher_summary();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function voucher_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SearchFilter = $session['VoucherSummarrySessionFilters'];

        $SQL = 'SELECT DISTINCT 
                "FinalRslt"."Name" as "Category",
                SUM("FinalRslt"."TotalRooms") as "Rooms",
                SUM("FinalRslt"."Totalbeds") as "Sharing",
                SUM("FinalRslt"."TotalNight") as "Nights",
                SUM("FinalRslt"."TotalVoucher") as "Vouchers",
                SUM("FinalRslt"."TotalPilgrim") as "Pilgrims"
                FROM (
                SELECT DISTINCT 
                "FinalQuery"."Name",
                (CASE When "FinalQuery"."RoomType"=\'Rooms\' then SUM("FinalQuery"."TotalBedRooms") ELSE 0 end) as "TotalRooms" ,
                (CASE When "FinalQuery"."RoomType"=\'Sharing\' then SUM("FinalQuery"."TotalBedRooms") ELSE 0 end) as "Totalbeds" ,
                SUM("FinalQuery"."TotalNights") as "TotalNight",
                SUM("FinalQuery"."TotalVouchers") as "TotalVoucher",
                SUM("FinalQuery"."TotalPilgrims") as "TotalPilgrim"
                FROM (
                        SELECT distinct
                        "LU2"."Name",
                        (CASE When "LookupsOptions"."Name"=\'Sharing\' then \'Sharing\' ELSE \'Rooms\' end) as "RoomType", 
                        (
                            SELECT sum(cast("VA0"."NoOfBeds" as int))
                            FROM voucher."AccommodationDetails" AS "VA0"
                            LEFT JOIN packages."Hotels" ON (CAST("VA0"."Hotel" as int) = packages."Hotels"."UID")
                            LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                            WHERE "VA0"."VoucherID"  = "voucher"."AccommodationDetails"."VoucherID" AND main."LookupsOptions"."Name" = "LU2"."Name"
                            GROUP BY main."LookupsOptions"."Name"
                        ) AS "TotalBedRooms",
                        (
                            SELECT SUM("TotalNight"."Nights") 
                            FROM (
                                SELECT DATE_PART(\'day\', AGE(min("VA0"."CheckOut"), min("VA0"."CheckIn"))) AS "Nights"
                                FROM voucher."AccommodationDetails" AS "VA0"
                                WHERE "VA0"."VoucherID" = "voucher"."AccommodationDetails"."VoucherID" 
                                GROUP BY "VA0"."UID"
                            ) as "TotalNight"
                    ) as "TotalNights",
                    count(distinct "voucher"."AccommodationDetails"."VoucherID") as "TotalVouchers",
                    count(distinct "voucher"."Pilgrim"."PilgrimUID") as "TotalPilgrims"
                    FROM "voucher"."AccommodationDetails"
                    INNER JOIN "voucher"."Master" ON ("voucher"."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID")
                    INNER JOIN "main"."LookupsOptions" on "main"."LookupsOptions"."UID" = cast("voucher"."AccommodationDetails"."RoomType" as int)
                    INNER JOIN "voucher"."Pilgrim" ON ("voucher"."AccommodationDetails"."VoucherID"="voucher"."Pilgrim"."VoucherUID")
                    INNER JOIN packages."Hotels" ON (CAST("voucher"."AccommodationDetails"."Hotel" as int) = packages."Hotels"."UID")
                    INNER JOIN main."LookupsOptions" as "LU2" ON (cast("LU2"."UID" as character varying))=packages."Hotels"."Category"
                    WHERE "voucher"."AccommodationDetails"."Self" = 0';
        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" = ' . $session['domainid'] . '';
        }
        $SQL .= 'GROUP BY "LU2"."Name", (CASE When "LookupsOptions"."Name" = \'Sharing\' then \'Sharing\' ELSE \'Rooms\' end), "voucher"."AccommodationDetails"."VoucherID"
                    ORDER BY "LU2"."Name", (CASE When "LookupsOptions"."Name" = \'Sharing\' then \'Sharing\' ELSE \'Rooms\' end)
                ) as "FinalQuery"
                GROUP BY "FinalQuery"."Name", "FinalQuery"."RoomType"
                ORDER BY "FinalQuery"."Name"
            ) AS "FinalRslt"
            GROUP BY "FinalRslt"."Name"
            ORDER BY "FinalRslt"."Name"';

        /** POST
         * Filters Start
         */

        if (isset($SearchFilter['htl_category']) && trim($SearchFilter['htl_category']) != '') {

            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                    WHERE LOWER( "MainQuery"."Category" ) LIKE \'%' . strtolower(trim($SearchFilter['htl_category'])) . '%\'  ';
        }
        /** POST
         * Filters Start
         */

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_voucher_summary_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->voucher_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Actual Hotel
     * Report Functions
     */

    public
    function count_actual_hotel_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->hotel();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function hotel()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT 
"voucher"."AccommodationDetails"."UID",
main."Countries"."Name" as "CountryName",
main."Agents"."FullName" AS "IATANAME",
(SELECT Distinct "BRN"."brn"."BRNCode"
FROM "BRN"."brn"
LEFT JOIN "pilgrim"."meta"  ON (cast("BRN"."brn"."UID" as character varying))="pilgrim"."meta"."Value"
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-brn-no\') 
) AS "BRN",
voucher."Master"."VoucherCode" AS "VoucherCode",
main."Cities"."Name" AS "CityName",
"LUO"."Name" AS "HotelCategory",
packages."Hotels"."Name" AS "HotelName",
main."LookupsOptions"."Name" AS "RoomType",
(SELECT count( distinct "pilgrim"."meta"."PilgrimUID") FROM "pilgrim"."meta"
WHERE "pilgrim"."meta"."Option" LIKE \'check-in%\' AND "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID")  as "TotalPex",
"voucher"."AccommodationDetails"."NoOfBeds", 
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-room-no\') 
) AS "RoomNo",

(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-no-of-bed\') 

) AS "ActualBeds",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-actual-arrival-time\') 

) AS "ActualArrivalTime",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-contact-number\') 

) AS "PaxMobileNo",
(SELECT Distinct "meta"."PilgrimUID"
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower(main."Cities"."Name"),\'-status\') Limit 1

) AS "LeaderPilgrimUID",
TO_CHAR("voucher"."AccommodationDetails"."CheckIn" :: DATE, \'dd Mon, yyyy\') AS "CheckIn",
TO_CHAR("voucher"."AccommodationDetails"."CheckOut" :: DATE, \'dd Mon, yyyy\') AS "CheckOut",
DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
main."Agents"."Type" AS "IATAType",
sale_agent."Agents"."FullName" as "ReferenceName"
FROM "voucher"."AccommodationDetails"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID"
LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID"
LEFT JOIN  packages."Hotels" ON packages."Hotels"."UID" = voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
where  (SELECT count( distinct "pilgrim"."meta"."PilgrimUID") FROM "pilgrim"."meta"
WHERE "pilgrim"."meta"."Option" LIKE \'check-in%\' AND "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID")>0';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        /** Filters Start */
        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['voucher_no']) && trim($_POST['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($_POST['voucher_no']) . '\' ';
        }

        if (isset($_POST['city']) && trim($_POST['city']) != '') {
            $SQL .= ' AND LOWER(main."Cities"."Name") LIKE \'%' . strtolower(trim($_POST['city'])) . '%\' ';
        }

        if (isset($_POST['htl_category']) && trim($_POST['htl_category']) != '') {
            $SQL .= ' AND LOWER("LUO"."Name") LIKE \'%' . strtolower(trim($_POST['htl_category'])) . '%\' ';
        }

        if (isset($_POST['checkin_date_from']) && $_POST['checkin_date_from'] != '' && isset($_POST['checkin_date_to']) && $_POST['checkin_date_to'] != '') {
            $SQL .= ' AND  "voucher"."AccommodationDetails"."CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($_POST['checkin_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['checkin_date_to'])) . '\' ';
        }

        if (isset($_POST['checkout_date_from']) && $_POST['checkout_date_from'] != '' && isset($_POST['checkout_date_to']) && $_POST['checkout_date_to'] != '') {
            $SQL .= ' AND  "voucher"."AccommodationDetails"."CheckOut" BETWEEN \'' . date("Y-m-d", strtotime($_POST['checkout_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['checkout_date_to'])) . '\' ';
        }
        /** Filters ENDS */


        $SQL .= 'Group By
                "voucher"."AccommodationDetails"."UID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                sale_agent."Agents"."FullName",
                voucher."Master"."VoucherCode",
                main."Cities"."Name",
                "LUO"."Name",
                packages."Hotels"."Name",
                main."LookupsOptions"."Name",
                "voucher"."AccommodationDetails"."NoOfBeds",
                "voucher"."AccommodationDetails"."CheckIn", 
                "voucher"."AccommodationDetails"."CheckOut"';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_actual_hotel_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->hotel();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_arrival_hotel_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_hotel();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function arrival_hotel()
    {
        $data = $this->data;

        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ArrivalHotelReportSessionFilters'];

        // $PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT 
                "voucher"."AccommodationDetails"."UID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" AS "IATANAME",
                (SELECT Distinct "BRN"."brn"."BRNCode"
                FROM "BRN"."brn"
                LEFT JOIN "pilgrim"."meta"  ON (cast("BRN"."brn"."UID" as character varying))="pilgrim"."meta"."Value"
                WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-brn-no\') 
                ) AS "BRN",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                "LUO"."Name" AS "HotelCategory",
                main."Cities"."Name" AS "CityName",
                packages."Hotels"."Name" AS "HotelName",
                main."LookupsOptions"."Name" AS "RoomType",
                (SELECT count( distinct "pilgrim"."meta"."PilgrimUID") FROM "pilgrim"."meta"
                WHERE "pilgrim"."meta"."Option" LIKE \'allow-htl%\' AND "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID")  as "TotalPex",
                "voucher"."AccommodationDetails"."NoOfBeds", 
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                
                (SELECT string_agg(Distinct INITCAP(REPLACE(REPLACE("meta"."Value",\'allow-htl-\',\'\'),\'-origin\',\'\')), \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
                AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-origin\') 
                
                ) AS "Origin",
                
                
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
                AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-in-date\') 
                
                ) AS "ActualArrivalDate",
                
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
                AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-actual-arrival-time\') 
                
                ) AS "ActualArrivalTime",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
                AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-contact-number\') 
                
                ) AS "PaxMobileNo",
                (SELECT Distinct "meta"."PilgrimUID"
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
                AND "Option" = CONCAT(\'allow-htl-\',lower(main."Cities"."Name"),\'-status\') Limit 1
                
                ) AS "LeaderPilgrimUID",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"
                FROM "voucher"."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON voucher."AccommodationDetails"."City" = main."Cities"."UID"
                LEFT JOIN  packages."Hotels" ON packages."Hotels"."UID" = voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where  (SELECT count( distinct "pilgrim"."meta"."PilgrimUID") FROM "pilgrim"."meta"
                WHERE "pilgrim"."meta"."Option" LIKE \'allow-htl%\' AND "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID")>0';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER(main."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }

        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER(packages."Hotels"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }
        /** Filters ENDS */


        $SQL .= 'Group By
                "voucher"."AccommodationDetails"."UID",
                main."Countries"."Name",
                main."Agents"."FullName",
                main."Agents"."Type",
                sale_agent."Agents"."FullName",
                voucher."Master"."VoucherCode",
                main."Cities"."Name",
                "LUO"."Name",
                packages."Hotels"."Name",
                main."LookupsOptions"."Name",
                "voucher"."AccommodationDetails"."NoOfBeds",
                "voucher"."AccommodationDetails"."CheckIn", 
                "voucher"."AccommodationDetails"."CheckOut"';


        if (isset($SessionFilters['checkin_date_from']) && $SessionFilters['checkin_date_from'] != '' && isset($SessionFilters['checkin_date_to']) && $SessionFilters['checkin_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" WHERE  "MainQuery"."ActualArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_date_from'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_date_to'])) . ' 23:59:59\' ';
        }
//       echo $SQL; exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_arrival_hotel_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_hotel();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_actual_used_transport_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->actual_used_transport();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function actual_used_transport()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ActualUsedTransportReportSessionFilters'];


        $PilgrimSearchFilter = $session['B2CReportSearchFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            //$ArrivalMeta[] = $ArrivalCnt . "-contact-number";
        }
        $SQL = 'SELECT
                Distinct 
                "voucher"."TransportRate"."UID",
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" AS "CityName",
                main."Agents"."FullName" AS "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                (SELECT Distinct "BRN"."brn"."BRNCode"
                FROM "BRN"."brn"
                LEFT JOIN "pilgrim"."meta"  ON (cast("BRN"."brn"."UID" as character varying))="pilgrim"."meta"."Value"
                WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-brn-no\') 
                ) AS "BRN",
                count(Distinct voucher."Pilgrim"."PilgrimUID") As "TotalPax",
                "voucher"."TransportRate"."NoOfSeats",
                main."LookupsOptions"."Name" AS "Sector",
                (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                From main."LookupsOptions"
                Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-check-out-date\') 
                ) AS "CheckOutDate",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-check-out-time\') 
                ) AS "CheckOutTime",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-departure-time\') 
                ) AS "ActualDepartureTime",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-transport-destination\') 
                ) AS "TransportDestination",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-room-no\') 
                ) AS "RoomNo",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-pickup-point\') 
                ) AS "PickupPoint",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-actual-hotel\') 
                ) AS "ActualHotel",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-vehicle-number\') 
                ) AS "VehicleNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-name\') 
                ) AS "DriverName",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-number\') 
                ) AS "DriverNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-contact-number\') 
                ) AS "PaxContactNumber",
                (SELECT string_agg(Distinct main."LookupsOptions"."Name", \',\') 
                FROM "main"."LookupsOptions"
                LEFT JOIN "pilgrim"."meta"  ON (cast("main"."LookupsOptions"."UID" as character varying))="pilgrim"."meta"."Value"
                
                WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" AND "pilgrim"."meta"."Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-transport-company\')
                 
                ) AS "TransportCompany",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"
                FROM "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
                
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"  = voucher."Master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID"  = voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where "voucher"."TransportRate"."UID"=pilgrim."meta"."AllowReference"
                
                AND"pilgrim"."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER(main."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }

        /*if (isset($_POST['htl_category']) && trim($_POST['htl_category']) != '') {
            $SQL .= ' AND LOWER("LUO"."Name") LIKE \'%' . strtolower(trim($_POST['htl_category'])) . '%\' ';
        }*/

        /** Filters ENDS */


        $SQL .= 'Group By
                voucher."TransportRate"."UID",
                main."Countries"."Name",
                main."Cities"."Name",
                main."LookupsOptions"."Name",
                main."Agents"."FullName",
                voucher."Master"."VoucherCode",
                main."Agents"."Type",
                sale_agent."Agents"."FullName"';

        if (isset($SessionFilters['checkout_date_from']) && $SessionFilters['checkout_date_from'] != '' && isset($SessionFilters['checkout_date_to']) && $SessionFilters['checkout_date_to'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" WHERE "MainQuery"."CheckOutDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkout_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkout_date_to'])) . '\' ';
        }

//        echo $SQL;exit();
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_actual_used_transport_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->actual_used_transport();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_arrival_transport_summary_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_transport_summary();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function arrival_transport_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['ArrivalSummaryReportSessionFilters'];

        //$PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT 
                "voucher"."TransportRate"."UID",
                "voucher"."TransportRate"."VoucherUID",
                "voucher"."TransportRate"."TransportTypeUID",
                "voucher"."Flights"."SectorTo",
                main."Countries"."Name" as "CountryName",
                to_char( voucher."Flights"."ArrivalDate"::DATE, \'DD Mon, YYYY\') as "ArrivalDate",
                voucher."Flights"."Airline",
                (
                 select concat(main."Airlines"."Code",\'-\',voucher."Flights"."Reference")
                  FROM main."Airlines" 
                where (cast(main."Airlines"."UID" as character varying)=voucher."Flights"."Airline")
                                       
                 ) AS "FlightNo",
                to_char( voucher."Flights"."ArrivalTime"::TIME, \'HH12:MI AM\') as "ArrivalTime",
                (SELECT count( distinct "voucher"."Pilgrim"."PilgrimUID") FROM "voucher"."Pilgrim"
                WHERE "voucher"."Pilgrim"."VoucherUID" = "voucher"."TransportRate"."VoucherUID")  as "TotalPex",
                (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                 From main."LookupsOptions"
                 Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                 where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
                (
                 select concat(main."Airports"."Code",\'-\',main."Airports"."Name") AS "Airport"
                 From main."Airports"
                 where (cast(main."Airports"."UID" as character varying)="voucher"."Flights"."SectorTo")
                ),
                CONCAT(\'By\', \' \', voucher."Flights"."TravelType") AS "TravelType"
                From "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = "voucher"."TransportRate"."VoucherUID"
                LEFT JOIN voucher."Flights" ON (voucher."Master"."UID"  = "voucher"."Flights"."VoucherID" AND "voucher"."Flights"."FlightType"=\'Departure\')
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                where "voucher"."TransportRate"."TravelType"=\'Arrival\'';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '' && isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
            $SQL .= ' AND voucher."Flights"."ArrivalDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['arrival_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['flight']) && trim($SessionFilters['flight']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" WHERE  "MainQuery"."FlightNo" LIKE \'%' . trim($SessionFilters['flight']) . '%\' ';
        }

        if (isset($SessionFilters['airport']) && trim($SessionFilters['airport']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" WHERE  "MainQuery"."Airport" LIKE \'%' . trim($SessionFilters['airport']) . '%\' ';
        }

        /** Filters ENDS */
        //echo nl2br($SQL);exit();
//        echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_arrival_transport_summary_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_transport_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Passport Management
     * Report Functions
     */

    public
    function count_passport_management_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ppt_management();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function ppt_management()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PassportManagementStatsReportSessionFilters'];

        $SQL = 'SELECT
                pilgrim."master"."UID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."UID" as "AgentID",
                main."Agents"."FullName" AS "IATANAME",
                main."Groups"."UID" as "GroupID",
                main."Groups"."FullName" as "GroupName",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."PassportNumber",
                pilgrim."master"."DOB",
                pilgrim."mofa"."MOFANumber",
                pilgrim."travel"."VisaNo",
                pilgrim."travel"."EntryDate",
                pilgrim."travel"."EntryTime",
                pilgrim."travel"."EntryPort",
                pilgrim."travel"."TransportMode" AS "ArrivalMode",
                pilgrim."travel"."EntryCarrier",
                pilgrim."travel"."FlightNo",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID" = pilgrim."master"."UID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where pilgrim."master"."AgentUID" IS NOT NULL
                AND pilgrim."master"."UID" NOT IN(SELECT Distinct  pilgrim."attachments"."PilgrimID"
                    FROM pilgrim."attachments"
                    WHERE pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportFrontPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBackPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBookletPic\'))
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }


        /** Filters Start */
        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['pax_name']) && trim($SessionFilters['pax_name']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($SessionFilters['pax_name']) . '%\' ';
        }

        if (isset($SessionFilters['ppt_no']) && trim($SessionFilters['ppt_no']) != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . trim($SessionFilters['ppt_no']) . '\' ';
        }

        if (isset($SessionFilters['mofa_no']) && trim($SessionFilters['mofa_no']) != '') {
            $SQL .= ' AND pilgrim."mofa"."MOFANumber" = \'' . trim($SessionFilters['mofa_no']) . '\' ';
        }

        if (isset($SessionFilters['visa_no']) && trim($SessionFilters['visa_no']) != '') {
            $SQL .= ' AND pilgrim."travel"."VisaNo" = \'' . trim($SessionFilters['visa_no']) . '\' ';
        }

        if (isset($SessionFilters['entry_start_date']) && $SessionFilters['entry_start_date'] != '' && isset($SessionFilters['entry_end_date']) && $SessionFilters['entry_end_date'] != '') {
            $SQL .= ' AND  pilgrim."travel"."EntryDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['entry_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['entry_end_date'])) . '\' ';
        }
        /** Filters ENDS */


        $SQL .= ' ORDER BY  pilgrim."master"."UID" ASC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        if (isset($_POST['pax_name']) && trim($_POST['pax_name']) != '') {
            $SQL = ' SELECT * FROM  ( ' . $SQL . ' ) AS "MainQuery"
                        WHERE LOWER("MainQuery"."PilgrimFullName") LIKE  \'%' . strtolower(trim($_POST['pax_name'])) . '%\'  ';
        }

        return $SQL;
    }

    public
    function get_passport_management_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ppt_management();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pax In Mecca
     * Report Functions
     */

    public
    function count_pax_in_mecca_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_mecca();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pax_in_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PaxInMeccaSessionFilters'];

        $SQL = 'SELECT
                    Distinct
                    pilgrim."meta"."SystemDate",
                    voucher."Pilgrim"."VoucherUID",
                    main."Countries"."Name" as "CountryName",
                    main."Cities"."Name" as "CityName",
                    main."Agents"."FullName" AS "IATANAME",
                    main."Agents"."Type" AS "IATAType",
                    voucher."Master"."VoucherCode" AS "VoucherCode",
                    count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
(select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
         FROM  voucher."Pilgrim" AS "VP1"
         LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
         LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID"="VP1"."PilgrimUID" AND "PilgrimMeta"."Option" IN (\'check-in-mecca-status\'))
         Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
         AND "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
         order by  "VP1"."PilgrimUID" ASC Limit 1           
         ),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                ) AS "HotelName",
 (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                )  AS "Nights",
(select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName",
                  main."Users"."FullName" as "SystemUser",
                  pilgrim."master"."AgentUID"

                  FROM voucher."Pilgrim"
                  LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN pilgrim."meta" ON (pilgrim."meta"."PilgrimUID"=voucher."Pilgrim"."PilgrimUID" AND pilgrim."meta"."Option" IN (\'check-in-mecca-status\'))
                  LEFT JOIN main."Users" ON voucher."Master"."CreatedBy" = main."Users"."UID"
                  
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                   Where pilgrim."master"."CurrentStatus"=\'check-in-mecca\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Session Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }
        /** Filters END */


        $SQL .= ' GROUP BY 
                  pilgrim."meta"."SystemDate",
                  voucher."Pilgrim"."VoucherUID",
                  main."Countries"."Name",
                  main."Cities"."Name",
                  main."Agents"."FullName",
                  main."Agents"."Type",
                  voucher."Master"."VoucherCode",
                  sale_agent."Agents"."FullName",
                  main."Users"."FullName",
                  pilgrim."master"."AgentUID"
                  ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        /** Session Filters Start */

        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                     WHERE LOWER( "MainQuery"."HotelCategory" ) LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }

        if (isset($SessionFilters['checkin_start_date']) && $SessionFilters['checkin_start_date'] != '' && isset($SessionFilters['checkin_end_date']) && $SessionFilters['checkin_end_date'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_end_date'])) . '\' ';
        }
        /** Filters END */

        return $SQL;
    }

    public
    function get_pax_in_mecca_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_mecca();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pax In Medina
     * Report Functions
     */

    public
    function count_pax_in_medina_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_medina();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pax_in_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PaxInMedinaSessionFilters'];

        $SQL = 'SELECT
                  pilgrim."meta"."SystemDate",
                  voucher."Pilgrim"."VoucherUID",
                                 
                  main."Countries"."Name" as "CountryName",
                  main."Cities"."Name" as "CityName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                (select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                    FROM  voucher."Pilgrim" AS "VP1"
                    LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                    LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID"="VP1"."PilgrimUID" AND "PilgrimMeta"."Option" IN (\'check-in-medina-status\'))
                    Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                    AND "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
                    order by  "VP1"."PilgrimUID" ASC Limit 1           
                 ),
                  
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "HotelName",
 (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                )  AS "Nights",
(select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName",
                  main."Users"."FullName" as "SystemUser",
                  pilgrim."master"."AgentUID"

                  FROM voucher."Pilgrim"
                  LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN pilgrim."meta" ON (pilgrim."meta"."PilgrimUID"=voucher."Pilgrim"."PilgrimUID" AND pilgrim."meta"."Option" IN (\'check-in-medina-status\'))
                  LEFT JOIN main."Users" ON voucher."Master"."CreatedBy" = main."Users"."UID"
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                   Where pilgrim."master"."CurrentStatus"=\'check-in-medina\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }


        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }
        /** Filters END */

        $SQL .= 'GROUP BY
        pilgrim."meta"."SystemDate", 
        voucher."Pilgrim"."VoucherUID",
        main."Countries"."Name",
        main."Cities"."Name",
        main."Agents"."FullName",
        main."Agents"."Type",
        voucher."Master"."VoucherCode",
        sale_agent."Agents"."FullName",
        main."Users"."FullName",
        pilgrim."master"."AgentUID"
        ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';

        /** Filters Start */

        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                     WHERE LOWER( "MainQuery"."HotelCategory" ) LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }

        if (isset($SessionFilters['checkin_start_date']) && $SessionFilters['checkin_start_date'] != '' && isset($SessionFilters['checkin_end_date']) && $SessionFilters['checkin_end_date'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_end_date'])) . '\' ';
        }
        /** Filters END */

        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_pax_in_medina_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_medina();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pax In Jeddah
     * Report Functions
     */

    public
    function count_pax_in_jeddah_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_jeddah();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pax_in_jeddah()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PaxInJeddahSessionFilters'];

        $SQL = 'SELECT
                 Distinct
                  pilgrim."meta"."SystemDate",
                  voucher."Pilgrim"."VoucherUID",
                                 
                  main."Countries"."Name" as "CountryName",
                  main."Cities"."Name" as "CityName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                (select "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                FROM voucher."Pilgrim" AS "VP1"
                LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON ("PilgrimMeta"."PilgrimUID"="VP1"."PilgrimUID" AND "PilgrimMeta"."Option" IN (\'check-in-jeddah-status\'))
                Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                AND "PilgrimMeta"."SystemDate"=pilgrim."meta"."SystemDate"
                order by "VP1"."PilgrimUID" ASC Limit 1           
                         ),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "HotelName",
 (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                )  AS "Nights",
(select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName",
                  main."Users"."FullName" as "SystemUser",
                  pilgrim."master"."AgentUID"

                  FROM pilgrim."master"
                  LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN pilgrim."meta" ON (pilgrim."meta"."PilgrimUID"=voucher."Pilgrim"."PilgrimUID" AND pilgrim."meta"."Option" IN (\'check-in-jeddah-status\'))
                  LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                   Where pilgrim."master"."CurrentStatus"=\'check-in-jeddah\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }
        /** Filters END */

        $SQL .= '
        GROUP BY
        pilgrim."meta"."SystemDate", 
        voucher."Pilgrim"."VoucherUID",                                 
        main."Countries"."Name",
        main."Cities"."Name",
        main."Agents"."FullName",
        main."Agents"."Type",
        sale_agent."Agents"."FullName",
        main."Users"."FullName",
        pilgrim."master"."AgentUID",
        voucher."Master"."VoucherCode"
        
        ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        /** Filters Start */
        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                     WHERE LOWER( "MainQuery"."HotelCategory" ) LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }

        if (isset($SessionFilters['checkin_start_date']) && $SessionFilters['checkin_start_date'] != '' && isset($SessionFilters['checkin_end_date']) && $SessionFilters['checkin_end_date'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_end_date'])) . '\' ';
        }
        /** Filters END */

        return $SQL;
    }

    public
    function get_pax_in_jeddah_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_jeddah();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Pax In Saudi Arabia
     * Report Functions
     */

    public
    function count_pax_in_saudi_arabia_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_saudi_arabia();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function pax_in_saudi_arabia()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $statuses = StatusCheckList();
        $CheckinKSA = $statuses['CheckinKSA'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['PaxInSaudiArabiaSessionFilters'];

        $SQL = 'SELECT
                 Distinct
                 pilgrim."meta"."SystemDate",
                  voucher."Pilgrim"."VoucherUID",
                                  
                  main."Countries"."Name" as "CountryName",
                  main."Cities"."Name" as "CityName",
                  main."Agents"."FullName" AS "IATANAME",
                  main."Agents"."Type" AS "IATAType",
                  voucher."Master"."VoucherCode" AS "VoucherCode",
                  count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
(select  "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
         FROM  voucher."Pilgrim" AS "VP1"
         LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
         Where "VP1"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
         order by  "VP1"."PilgrimUID" ASC Limit 1           
         ),
                 (select string_agg(Distinct packages."Hotels"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                ) AS "HotelName",
 (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying))=packages."Hotels"."Category"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                
                ) AS "HotelCategory",

                
                (select string_agg(Distinct main."LookupsOptions"."Name", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                ) AS "RoomType",
                (SELECT Distinct  min(voucher."AccommodationDetails"."CheckIn")
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                ) AS "CheckINDate",
               (select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn")))
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                )  AS "Nights",
(select string_agg(Distinct voucher."AccommodationDetails"."NoOfBeds", \',\')
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name" IN(\'Mecca\',\'Medina\',\'Jeddah\')
                ) AS "NoOfBeds",
                  sale_agent."Agents"."FullName" as "ReferenceName",
                  pilgrim."master"."CurrentStatus",
                  main."Users"."FullName" as "SystemUser"

                  FROM voucher."Pilgrim"
                  LEFT JOIN pilgrim."master" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"
                  LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                  LEFT JOIN pilgrim."meta" ON (pilgrim."meta"."PilgrimUID"=voucher."Pilgrim"."PilgrimUID" AND pilgrim."meta"."Option" IN (\'check-in-jeddah-status\',\'check-in-medina-status\',\'check-in-mecca-status\'))
                  LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                  LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")                  
                  LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                  LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                  LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                  LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                   Where pilgrim."master"."CurrentStatus" IN(\'' . implode('\',\'', $CheckinKSA) . '\')
                   ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_no']) . '\' ';
        }
        /** Filters END */

        $SQL .= 'GROUP BY
                 pilgrim."meta"."SystemDate", 
                 voucher."Pilgrim"."VoucherUID",
                 main."Countries"."Name",
                 main."Cities"."Name",
                 main."Agents"."FullName",
                 main."Agents"."Type",
                 voucher."Master"."VoucherCode",
                 sale_agent."Agents"."FullName",
                 pilgrim."master"."CurrentStatus",
                 main."Users"."FullName"
                  ORDER BY  voucher."Pilgrim"."VoucherUID" ASC';


        /** Filters Start */
        if (isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                     WHERE LOWER( "MainQuery"."HotelCategory" ) LIKE \'%' . strtolower(trim($SessionFilters['htl_category'])) . '%\' ';
        }

        if (isset($SessionFilters['checkin_start_date']) && $SessionFilters['checkin_start_date'] != '' && isset($SessionFilters['checkin_end_date']) && $SessionFilters['checkin_end_date'] != '') {
            $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery"
                        WHERE "MainQuery"."CheckINDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_start_date'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_end_date'])) . '\' ';
        }
        /** Filters END */


        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_pax_in_saudi_arabia_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->pax_in_saudi_arabia();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Hotel Summary
     * Report Functions
     */

    public
    function count_hotel_summary_filtered()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_summary();
        $records = $Crud->ExecuteSQL($SQL);
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

        return count($FinalArray);
    }

    public
    function hotel_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['HotelSummarySessionFilters'];

        $SQL = '
        SELECT distinct
        "main"."Cities"."Name" AS "CityName",
        cast("voucher"."AccommodationDetails"."Hotel" as int),
        "packages"."Hotels"."Name" as "HotelName",
        "main"."LookupsOptions"."Name" AS "CategoryName",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name" AS "RoomTypeName",
        SUM(DATE_PART(\'day\', AGE("voucher"."AccommodationDetails"."CheckOut", "voucher"."AccommodationDetails"."CheckIn"))) AS "TotalNights",
        SUM( cast("voucher"."AccommodationDetails"."NoOfBeds" as int) ) as "TotalBeds",
        
        (
            SELECT count( distinct "PilgrimUID" ) FROM "pilgrim"."meta" 
            WHERE "Option" LIKE \'%check-in-%-room%\' AND "AllowReference" = "voucher"."AccommodationDetails"."UID"
        ) as "TotalPilgrims",
                        
        "voucher"."AccommodationDetails"."UID" as "AllowRefID",
                        
        (
            SELECT sale_agent."Agents"."FullName" as "ReferenceName" FROM voucher."Master"
            LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
            LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
            LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
            WHERE voucher."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        ) as "RefAgentName"
    
        FROM "voucher"."AccommodationDetails"
        INNER JOIN "pilgrim"."meta" ON "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "pilgrim"."meta"."Option" LIKE \'check-in%-room-no\'
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions"."UID" as character varying))=(cast("packages"."Hotels"."Category"  as character varying))
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."AccommodationDetails"."City"  as int))
        LEFT JOIN "main"."LookupsOptions" as "LO2" ON (cast("LO2"."UID" as character varying))=(cast("voucher"."AccommodationDetails"."RoomType"  as character varying))
        
        WHERE cast("voucher"."AccommodationDetails"."Hotel" as int) > 0
        AND "voucher"."AccommodationDetails"."Self" = 0';

        /** Filters Start */
        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER("main"."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }
        if (isset($SessionFilters['hotel_category']) && trim($SessionFilters['hotel_category']) != '') {
            $SQL .= ' AND LOWER("main"."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel_category'])) . '%\' ';
        }
        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER("packages"."Hotels"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }
        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        $SQL .= '
        GROUP BY 
        "voucher"."AccommodationDetails"."UID",
        "main"."Cities"."Name",
        "voucher"."AccommodationDetails"."Hotel", 
        "packages"."Hotels"."Name",
        "main"."LookupsOptions"."Name",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name"
        
        ORDER BY
        "voucher"."AccommodationDetails"."UID", 
        "main"."Cities"."Name",
        "packages"."Hotels"."Name",
        "voucher"."AccommodationDetails"."RoomType"';

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);
        //exit();
        //$records = $Crud->ExecuteSQL($SQL);

        /*$FinalArray = array();
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
        }*/

        //echo "<pre>"; print_r($FinalArray); exit;
        //echo "<hr>"; print_r($records);

        return $SQL;
    }

    public
    function get_hotel_summary_datatables()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

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

        return $FinalArray;
    }

    /** Approved Vouchers
     * Report Functions
     */

    public
    function count_approved_vouchers_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->approved_voucher_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function approved_voucher_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['ApprovedVoucherSessionFilters'];

        $SQL = 'SELECT
                voucher."Master"."CreatedDate",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" as "SubAgentName",
                main."Agents"."ParentID",
                voucher."Master"."CreatedBy",
                voucher."Master"."ModifiedBy",
                voucher."Master"."ModifiedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                
                voucher."Pilgrim"."VoucherUID",
                
                main."Agents"."Type" AS "IATAType",
                main."Agents"."Type" as "AgentCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                websites."Domains"."FullName" as "CompanyName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "AgentName",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."CreatedBy"
                ) AS "UserCreatedBy",
                (select  main."Agents"."FullName"
                FROM main."Agents"
                
                where main."Agents"."UID" = voucher."Master"."ModifiedBy"
                ) AS "UserModifiedBy",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) >10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Adults",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) between 3 and 10
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Child",
                (SELECT count(pilgrim."master"."UID")
                FROM pilgrim."master"
                LEFT JOIN voucher."Pilgrim" AS "VP1" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                where date_part(\'year\',age(CURRENT_DATE,date(pilgrim."master"."DOB"))) <=2
                and "VP1"."VoucherUID" = voucher."Pilgrim"."VoucherUID"
                ) AS "Infant",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Departure\'
                 limit 1
                ) AS "ArrivalDate",
                (select voucher."Flights"."DepartureDate"
                FROM voucher."Flights"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                where voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID"
                AND voucher."Flights"."FlightType"=\'Return\'
                 limit 1
                ) As "DepartureDate",
                (select
                (select 
                CASE WHEN SUM("Mecca"."Nights") >0 THEN SUM("Mecca"."Nights") ELSE 0 END AS "MeccaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Mecca\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Mecca")
                +
                (select 
                CASE WHEN SUM("Medina"."Nights") >0 THEN SUM("Medina"."Nights") ELSE 0 END AS "MedinaNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Medina\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Medina")
                +
                (select 
                CASE WHEN SUM("Jeddah"."Nights") >0 THEN SUM("Jeddah"."Nights") ELSE 0 END AS "JeddahNights" from (
                select DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights"
                FROM  voucher."AccommodationDetails"
                LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                where voucher."AccommodationDetails"."VoucherID" = voucher."Pilgrim"."VoucherUID"
                AND main."Cities"."CountryCode"=\'SA\'
                AND main."Cities"."Name"=\'Jeddah\'
                GROUP BY voucher."AccommodationDetails"."UID") as "Jeddah")
                )  AS "TotalNights"
                
                FROM voucher."Master"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN websites."Domains" ON websites."Domains"."UID" = voucher."Master"."WebsiteDomain"
                LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                where voucher."Master"."Archive"= 0 
                AND voucher."Master"."VoucherType" != \'B2C\' 
                AND voucher."Master"."CurrentStatus"=\'Approved\'';

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND voucher."Master"."AgentUID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."UID" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['create_date_from']) && $SessionFilters['create_date_from'] != '' && isset($SessionFilters['create_date_to']) && $SessionFilters['create_date_to'] != '') {
            $SQL .= ' AND voucher."Master"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['create_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['create_date_to'])) . '\' ';
        }
        /** Filters END */

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }
        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $AgentsUIDs = HierarchyUsers($session['agent_id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ')';
            //$SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                                SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                                WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                              )  ';
        }

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        $SQL .= 'GROUP BY 
                 voucher."Master"."CreatedDate",
                 voucher."Master"."UID",
                 main."Countries"."Name",
                 voucher."Pilgrim"."VoucherUID",
                 main."Agents"."FullName",
                 main."Agents"."ParentID",
                 main."Agents"."Type",
                 main."Agents"."Type",
                 sale_agent."Agents"."FullName",
                 websites."Domains"."FullName"';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_approved_vouchers_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->approved_voucher_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Allow Hotel Mecca
     * Report Functions
     */

    public
    function count_allow_hotel_mecca_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_htl_mecca();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function arrival_htl_mecca()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['AllowHotelMeccaStatsReportSessionFilters'];


        $SQL = 'select
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims",
                (select "VP1"."PilgrimUID" AS "LeaderPilgrimUID"
                    FROM voucher."Pilgrim" AS "VP1"
                    LEFT JOIN pilgrim."master" ON "VP1"."PilgrimUID" = pilgrim."master"."UID"
                    Where "VP1"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    order by "VP1"."PilgrimUID" ASC Limit 1
                    )



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where  main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Mecca\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    

AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                
                    
                    )
                  
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER(packages."Hotels"."Name") LIKE  \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }
        /** Filters END */

        $SQL .= 'GROUP BY 
        voucher."AccommodationDetails"."VoucherID",
        main."Countries"."Name", 
        main."Agents"."FullName",
        voucher."Master"."VoucherCode",
        voucher."AccommodationDetails"."CheckIn",
        voucher."AccommodationDetails"."NoOfBeds",
        packages."Hotels"."Name",
        main."Cities"."Name",
        main."LookupsOptions"."Name",
        "LUO"."Name",
        sale_agent."Agents"."FullName"';

        //echo nl2br($SQL);exit();
        ///$records = $Crud->ExecuteSQL($SQL . " UNION " . $SQL2);
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_allow_hotel_mecca_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_htl_mecca();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Allow Hotel Medina
     * Report Functions
     */

    public
    function count_allow_hotel_medina_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_htl_medina();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function arrival_htl_medina()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        $SessionFilters = $session['AllowHotelMedinaStatsReportSessionFilters'];


        $SQL = 'select
                Distinct
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name" as "CountryName", 
                main."Agents"."FullName" as "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                voucher."AccommodationDetails"."CheckIn" AS "CheckINDate",
                voucher."AccommodationDetails"."NoOfBeds" AS "NoOfBeds",
                packages."Hotels"."Name" AS "HotelName",
                main."Cities"."Name" AS "CityName",
                main."LookupsOptions"."Name" AS "RoomType",
                DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
                "LUO"."Name" AS "HotelCategory",
                sale_agent."Agents"."FullName" as "ReferenceName",
                count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotalPilgrims"



                    FROM  voucher."AccommodationDetails"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"=voucher."AccommodationDetails"."Hotel"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
    
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (voucher."Master"."Country" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"

                    where  main."Cities"."CountryCode"=\'SA\' AND main."Cities"."Name"=\'Medina\'
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'' . $settings_days . ' day\'
                    

AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    
                    where pilgrim."meta"."Option" IN (\'allow-htl-medina-status\') 
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                
                    
                    )
             ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['voucher_code']) && trim($SessionFilters['voucher_code']) != '') {
            $SQL .= ' AND voucher."Master"."VoucherCode" = \'' . trim($SessionFilters['voucher_code']) . '\' ';
        }

        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER(packages."Hotels"."Name") LIKE  \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }
        /** Filters END */

        $SQL .= 'GROUP BY 
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name", 
                main."Agents"."FullName",
                voucher."Master"."VoucherCode",
                voucher."AccommodationDetails"."CheckIn",
                voucher."AccommodationDetails"."NoOfBeds",
                packages."Hotels"."Name",
                main."Cities"."Name",
                main."LookupsOptions"."Name",
                "LUO"."Name",
                sale_agent."Agents"."FullName",
                main."Agents"."Type"
                ORDER BY  voucher."AccommodationDetails"."VoucherID" ASC';
        //echo nl2br($SQL);exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_allow_hotel_medina_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->arrival_htl_medina();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_bed_loss_report_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->bed_loss();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    /** Development Ends By Jawad Sajid Durrani */

    public
    function bed_loss()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['B2CReportSearchFilter'];

        $SQL = 'SELECT DISTINCT "PilgrimMeta"."AllowReference",
                (select
                (
                    SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%check-in%no-of-bed\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                        GROUP BY "SystemDate"
                    ) as "T1"	
                )-
                (
                    SELECT SUM( "T2"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%check-in%no-of-bed-voucher\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                        GROUP BY "SystemDate"
                    ) as "T2"	
                )) as "BedLoss",
                (
                SELECT string_agg(Distinct "pilgrim"."meta"."Value" , \',\') 
                FROM "pilgrim"."meta" 
                WHERE "pilgrim"."meta"."Option" LIKE \'%check-in-%-room-no\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                ) as "RoomNumber",
                
                (SELECT "main"."Cities"."Name"
                FROM "packages"."Hotels"
                INNER JOIN "main"."Cities" ON "main"."Cities"."UID" = "packages"."Hotels"."CityID"
                WHERE "packages"."Hotels"."UID" IN (
                SELECT distinct cast("Value" as int)  FROM "pilgrim"."meta" 
                WHERE "pilgrim"."meta"."Option" LIKE \'%check-in-%-package-Hotel\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                ) ) as "City",
                
                (SELECT "packages"."Hotels"."Name"
                FROM "packages"."Hotels"
                WHERE "packages"."Hotels"."UID" IN (
                SELECT distinct cast("Value" as int)  FROM "pilgrim"."meta" 
                WHERE "pilgrim"."meta"."Option" LIKE \'%check-in-%-package-Hotel\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                ) ) as "Hotel",
                
                (
                SELECT "BRN"."brn"."BRNCode" FROM "BRN"."brn" WHERE "BRN"."brn"."UID" IN (
                SELECT distinct cast("Value" as int)  FROM "pilgrim"."meta" 
                WHERE "pilgrim"."meta"."Option" LIKE \'%check-in-%-brn-no\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                )
                ) as "BRNCode",
                
                ( 
                    SELECT TO_CHAR("pilgrim"."meta"."Value" :: DATE, \'dd Mon, yyyy\')  FROM "pilgrim"."meta" 
                    WHERE "pilgrim"."meta"."Option" LIKE \'%check-in-%-in-date\' 
                    AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                    ORDER BY "SystemDate" LIMIT 1
                    ) as "CheckInDate"
                
                FROM "pilgrim"."meta" as "PilgrimMeta"
                INNER JOIN pilgrim."master" ON pilgrim."master"."UID" = "PilgrimMeta"."PilgrimUID"
                WHERE "PilgrimMeta"."Option" LIKE \'%check-in%no-of-bed-voucher\' OR "PilgrimMeta"."Option" LIKE \'%check-in%no-of-bed\'
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        $SQL .= ' GROUP BY "PilgrimMeta"."AllowReference"';
        $SQL .= 'HAVING (select
                (
                    SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%check-in%no-of-bed\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                        GROUP BY "SystemDate"
                    ) as "T1"	
                )-
                (
                    SELECT SUM( "T2"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%check-in%no-of-bed-voucher\' AND "pilgrim"."meta"."AllowReference" = "PilgrimMeta"."AllowReference"
                        GROUP BY "SystemDate"
                    ) as "T2"	
                )) > 0';
        $SQL .= ' ORDER BY "PilgrimMeta"."AllowReference" DESC';
        //echo $SQL;exit();
        // $records = $Crud->ExecuteSQL($SQL);
        //return $records;
        return $SQL;
    }

    public
    function get_bed_loss_report_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->bed_loss();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_departure_hotel_report_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->departure_hotel();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function departure_hotel()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $settings_days = $data['settings']['activity_days'];

        $PilgrimSearchFilter = $session['AgentSearchFilter'];
        //$SessionFilters = $session['AllowHotelMedinaStatsReportSessionFilters'];
        $SessionFilters = $session['DepartureHotelReportSessionFilters'];


        $SQL = 'SELECT
                Distinct
                "voucher"."AccommodationDetails"."UID",
                main."Countries"."Name" as "CountryName",
                main."Agents"."FullName" AS "IATANAME",
                voucher."Master"."VoucherCode" AS "VoucherCode",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName",
                "Look3"."Name" AS "TypeOFTransport",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-room-no\'
                
                ) AS "RoomNo",
                (select count(Distinct voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim"
                    FROM voucher."Pilgrim"
                    INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                    AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID"),
                voucher."TransportRate"."NoOfSeats" AS "Seats",
                (SELECT string_agg(Distinct to_char(pilgrim."meta"."Value"::DATE, \'DD Mon, YYYY\'), \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-check-out-date\'
                ) AS "CheckOutDate",
                
                (SELECT string_agg(Distinct to_char(pilgrim."meta"."Value"::TIME, \'HH12:MI AM\'), \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-check-out-time\'
                ) AS "CheckOutTime",
                (SELECT string_agg(Distinct "meta"."Value", \',\')  
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-transport-destination\'
                
                ) AS "TransportDestination",
                (SELECT string_agg(Distinct "meta"."Value", \',\')  
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-vehicle-number\'
                
                ) AS "VehicleNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\')  
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-driver-name\'
                
                ) AS "DriverName",
                (SELECT string_agg(Distinct "meta"."Value", \',\')  
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-driver-mobile-number\'
                
                ) AS "DriverMobileNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\')  
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-contact-number\'
                ) AS "PaxContactNumber",
                (SELECT string_agg(Distinct main."LookupsOptions"."Name", \',\') AS "TransportCompany"
                    FROM "main"."LookupsOptions"
                    LEFT JOIN "pilgrim"."meta"  ON (cast("main"."LookupsOptions"."UID" as character varying))="pilgrim"."meta"."Value"
                    WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "pilgrim"."meta"."Option" LIKE \'departure-%-transport-company\'
                   ),
                   (select  coalesce ((select Act."HotelCityName" 
                        from (  
                                select string_agg(Distinct main."Cities"."Name", \',\') AS "HotelCityName"
                        FROM main."Cities"
                        INNER JOIN packages."OtherHotels" ON packages."OtherHotels"."CityID"=main."Cities"."UID"
                        AND packages."OtherHotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                        FROM pilgrim."meta"
                        WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID" 
                        AND pilgrim."meta"."Option" LIKE \'departure-%-actual-hotel\' order by pilgrim."meta"."Value" DESC Limit 1)) as int))
                        )
                         Act),
                        
                        (select Pct."HotelCityName" 
                        from (  
                                select Distinct main."Cities"."Name" AS "HotelCityName"
                        FROM main."Cities"
                        INNER JOIN packages."Hotels" ON packages."Hotels"."CityID"=main."Cities"."UID"
                        AND packages."Hotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                        FROM pilgrim."meta"
                        WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID" 
                        AND pilgrim."meta"."Option" LIKE \'departure-%-package-hotel\'  order by pilgrim."meta"."Value" DESC Limit 1)) as int))
                        )
                         Pct)
                        ) 
                        HotelCity),
                        (
                        SELECT AH."ActualHotel" FROM (
                        select Distinct packages."OtherHotels"."Name" AS "ActualHotel"
                        FROM packages."OtherHotels" 
                        where packages."OtherHotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                        FROM pilgrim."meta"
                        WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                        AND pilgrim."meta"."Option" LIKE \'departure-%-actual-hotel\'  order by pilgrim."meta"."Value" DESC Limit 1
                        
                        )) as int))

                UNION ALL
                    select Distinct packages."Hotels"."Name" AS "ActualHotel"
                    FROM packages."Hotels" 
                    where packages."Hotels"."UID" IN(cast((select   (SELECT Distinct pilgrim."meta"."Value"
                    FROM pilgrim."meta"
                    WHERE pilgrim."meta"."AllowReference" = voucher."TransportRate"."UID"
                    AND pilgrim."meta"."Option" LIKE \'departure-%-package-hotel\'  order by pilgrim."meta"."Value" DESC Limit 1
                    
                    )) as int))
                    Limit 1
                    ) AH
                )
                FROM "voucher"."AccommodationDetails"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID"
                LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"  = voucher."Master"."UID"  AND  voucher."TransportRate"."TravelType"=\'Departure\')
                Left JOIN packages."Transport"   ON (cast(voucher."TransportRate"."TransportTypeUID"  as character varying))=(cast(packages."Transport"."UID"  as character varying))
                LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                where voucher."AccommodationDetails"."CheckOut"=voucher."TransportRate"."TravelDate"
                AND (select count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID")>0
                AND (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" ="voucher"."TransportRate"."UID"
                AND "Option"  LIKE \'departure-%-room-no\'
                
                ) IS NOT NULL
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }
        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        /** Filters Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Countries"."ISO2" = \'' . $SessionFilters['country'] . '\' ';
        }

        if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $SessionFilters['agent'] . '\' ';
        }

        if (isset($SessionFilters['checkout_date_from']) && $SessionFilters['checkout_date_from'] != '' && isset($SessionFilters['checkout_date_to']) && $SessionFilters['checkout_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE to_char( "MainQuery"."CheckOutDate"::DATE, \'YYYY-mm-dd\') BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkout_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkout_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['tpt_type']) && trim($SessionFilters['tpt_type']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery"
                    WHERE LOWER( "MainQuery"."TypeOFTransport" ) LIKE \'%' . strtolower(trim($SessionFilters['tpt_type'])) . '%\' ';
        }

        if (isset($SessionFilters['reference']) && trim($SessionFilters['reference']) != '') {
            $SQL .= ' AND LOWER(sale_agent."Agents"."FullName") LIKE \'%' . strtolower(trim($SessionFilters['reference'])) . '%\' ';
        }
        /** Filters END */

        /*$SQL .= 'GROUP BY
                voucher."AccommodationDetails"."VoucherID",
                main."Countries"."Name",
                main."Agents"."FullName",
                voucher."Master"."VoucherCode",
                voucher."AccommodationDetails"."CheckIn",
                voucher."AccommodationDetails"."NoOfBeds",
                packages."Hotels"."Name",
                main."Cities"."Name",
                main."LookupsOptions"."Name",
                "LUO"."Name",
                sale_agent."Agents"."FullName",
                main."Agents"."Type"
                ORDER BY  voucher."AccommodationDetails"."VoucherID" ASC';*/
        //echo nl2br($SQL);exit();
//         echo $SQL;exit();
        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }


    public
    function get_departure_hotel_report_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->departure_hotel();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public function InitialTrainingReportData($Filters = array())
    {
        $session = session();
        $session = $session->get();
        $FinalArray = array();
        $Crud = new Crud();

        $SQL = '
        SELECT DISTINCT(sales."InitialTraining"."StaffID"),sales."InitialTraining"."OptionUID" AS "OptionUID", 
        sales."InitialTraining"."Performed" AS "Performed", 
        sales."InitialTraining"."Remarks" AS "Remarks"
        FROM sales."InitialTraining" 
        LEFT JOIN main."Users" ON sales."InitialTraining"."StaffID" = main."Users"."UID" WHERE main."Users"."DomainID" = ' . $session['domainid'] . '  
        ';

//        $SQL = 'SELECT sales."InitialTraining".*
//                FROM sales."InitialTraining"
//                LEFT JOIN main."Users" ON sales."InitialTraining"."StaffID"  = main."Users"."UID"
//                WHERE main."Users"."DomainID"  = ' . $session['domainid'] . '  ';


        $ReportData = $Crud->ExecuteSQL($SQL);
//        print_r($ReportData);
//        exit;
        foreach ($ReportData as $RD) {

            $FinalArray[$RD['StaffID']][$RD['OptionUID']] = $RD['Performed'];
        }

        return $FinalArray;
    }


    public function TimeTrackReport($Filters = array())
    {
        $session = session();
        $session = $session->get();


        if (!isset($Filters['StartDate']) || $Filters['StartDate'] == '') {
            $StartDate = date("Y-m-d", strtotime("-7 days"));
        } else {
            $StartDate = $Filters['StartDate'];
        }
        if (!isset($Filters['EndDate']) || $Filters['EndDate'] == '') {
            $EndDate = date("Y-m-d");
        } else {
            $EndDate = $Filters['EndDate'];
        }

        $ActivityDuration = 'sales."LeadsActivity"."SystemDate" 
            BETWEEN \'' . date("Y-m-d", strtotime($StartDate)) . '\' AND \'' . date("Y-m-d", strtotime($EndDate)) . '\' ';

        $Duration = ' BETWEEN \'' . date("Y-m-d", strtotime($StartDate)) . '\' AND \' ' . date("Y-m-d", strtotime($EndDate)) . '\'  ';

        $db = db_connect();
        $FinalArray = $FinalTitlesArray = $FinalStatusArray = array();
//        $SQL = 'SELECT DISTINCT main."UserTimetrack"."UserID", main."Users"."FullName", main."UserTimetrack"."ActivityType", SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(main."UserTimetrack"."ActivityStop", main."UserTimetrack"."ActivityStart")))) as "Duration"
//        FROM main."UserTimetrack"
//        INNER JOIN main."Users" ON (main."Users"."UID" = main."UserTimetrack"."UserID")
//        WHERE  main."UserTimetrack"."TrackDate"  ' . $Duration . '
//        GROUP BY main."UserTimetrack"."UserID", main."Users"."FullName", main."UserTimetrack"."ActivityType"
//
//        ';

        $SQL = 'SELECT
	DISTINCT main."UserTimetrack"."UserID", main."Users"."FullName", main."UserTimetrack"."ActivityType",
	SUM(main."UserTimetrack"."ActivityStop" - main."UserTimetrack"."ActivityStart") as "Duration"
    FROM main."UserTimetrack"
    INNER JOIN main."Users" ON (main."Users"."UID" = main."UserTimetrack"."UserID")
    WHERE main."UserTimetrack"."TrackDate"  ' . $Duration . ' AND main."UserTimetrack"."ActivityStop" IS NOT NULL AND main."UserTimetrack"."ActivityStart" IS NOT NULL
    GROUP BY main."UserTimetrack"."UserID", main."Users"."FullName", main."UserTimetrack"."ActivityType"    
        ';


        //echo $SQL;
        $ReportData = $db->query($SQL)->getResultArray();
        $db->transComplete();
//        echo "<pre>"; echo $SQL; print_r($ReportData); echo "<hr>";

        foreach ($ReportData as $SRD) {
            $FinalArray[$SRD['UserID']][$SRD['ActivityType']] = $SRD['Duration'];
        }
        $FinalStatusArray[] = 'dialing';
        $FinalStatusArray[] = 'followups';
        $FinalStatusArray[] = 'organic';
        $FinalStatusArray[] = 'training';

        $SQL = 'SELECT * FROM main."Users" WHERE main."Users"."Archive" = 0 AND main."Users"."UserType" = \'sale-officer\' ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND main."Users"."DomainID" =  ' . $session['domainid'] . ' ';
        }

        $UsersData = $db->query($SQL)->getResultArray();
        foreach ($UsersData as $UserData) {
            $FinalTitlesArray[$UserData['UID']] = $UserData['FullName'] . " (" . ucwords(str_replace("-", " ", $UserData['UserType'])) . ")";
        }

        asort($FinalTitlesArray);
        asort($FinalStatusArray);
        $final = array(
            "heads" => $FinalTitlesArray,
            "status" => array_unique($FinalStatusArray),
            "stats" => $FinalArray,
            "duration" => date("d M, Y", strtotime($StartDate)) . ' to ' . date("d M, Y", strtotime($EndDate))
        );
        return $final;
    }

    public
    function used_transport_summary()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];

        $SQL = 'SELECT
                Distinct 
                "voucher"."TransportRate"."UID",
                 count(Distinct voucher."Pilgrim"."PilgrimUID") As "TotalPax",
                 "voucher"."TransportRate"."NoOfSeats",main."LookupsOptions"."UID" AS "LookupID",
                 main."LookupsOptions"."Name" AS "Sector",packages."Transport"."Type" AS "TransportType","LookupOptions2"."UID" AS "LookupName2",
                (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                 From main."LookupsOptions"
                 Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                 where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                )	
                
                FROM "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"  = voucher."Master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID"  = voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN packages."Transport" ON cast(packages."Transport"."UID" as int) = cast(voucher."TransportRate"."TransportTypeUID" as int)
                LEFT JOIN main."LookupsOptions" AS "LookupOptions2" ON (cast("LookupOptions2"."UID" as int)=cast(packages."Transport"."Type" as int))
                
                where "voucher"."TransportRate"."UID"=pilgrim."meta"."AllowReference"
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

//        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '' && isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
//            $SQL .= ' AND voucher."Flights"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['to'])) . '\' ';
//        }
        if (isset($SessionFilters['sector']) && $SessionFilters['sector'] != '') {
            $SQL .= ' AND main."LookupsOptions"."UID" = \'' . $SessionFilters['sector'] . '\' ';
        }
        if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
            $SQL .= ' AND "LookupOptions2"."UID" = \'' . $SessionFilters['tpt_type'] . '\' ';
        }


        $SQL .= ' GROUP BY 
                  "voucher"."TransportRate"."UID",main."LookupsOptions"."UID",packages."Transport"."Type",
                   main."LookupsOptions"."Name","LookupOptions2"."UID" ';
       /* $SQL .= ' HAVING (select
                (
                    (0 || "voucher"."TransportRate"."NoOfSeats")::int
                )-
                (
                coalesce( (SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta"
                        WHERE "pilgrim"."meta"."Option" LIKE \'%actual-no-of-seats\' AND "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID"
                        GROUP BY "pilgrim"."meta"."SystemDate"
                    ) as "T1" ), 0)

                )) != 0';*/
        //$SQL .= ' ORDER BY pilgrim."meta"."AllowReference" DESC';
//        echo $SQL;exit();
        // $records = $Crud->ExecuteSQL($SQL);
        //return $records;
        return $SQL;
    }

    public
    function used_transport_summary_count()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['TransportSummarySessionsFilter'];

        $SQL = 'SELECT
                Distinct 
                "voucher"."TransportRate"."UID",
                 count(Distinct voucher."Pilgrim"."PilgrimUID") As "TotalPax",
                 "voucher"."TransportRate"."NoOfSeats",
                 main."LookupsOptions"."Name" AS "Sector"
                
               
               
                FROM "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
                
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"  = voucher."Master"."UID"
                LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID"  = voucher."Pilgrim"."PilgrimUID"
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                LEFT JOIN packages."Transport" ON cast(packages."Transport"."UID" as int) = cast(voucher."TransportRate"."TransportTypeUID" as int)
                LEFT JOIN main."LookupsOptions" AS "LookupOptions2" ON (cast("LookupOptions2"."UID" as int)=cast(packages."Transport"."Type" as int))
                where "voucher"."TransportRate"."UID"=pilgrim."meta"."AllowReference"
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($SessionFilters['sector']) && $SessionFilters['sector'] != '') {
            $SQL .= ' AND main."LookupsOptions"."UID" = \'' . $SessionFilters['sector'] . '\' ';
        }
        if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
            $SQL .= ' AND "LookupOptions2"."UID" = \'' . $SessionFilters['tpt_type'] . '\' ';
        }

        $SQL .= ' GROUP BY 
                  "voucher"."TransportRate"."UID",main."LookupsOptions"."UID",packages."Transport"."Type",
                   main."LookupsOptions"."Name","LookupOptions2"."UID" ';
        /*$SQL .= ' HAVING (select
                (
                    (0 || "voucher"."TransportRate"."NoOfSeats")::int	
                )-
                (
                coalesce( (SELECT SUM( "T1"."Value") as "Value" FROM (
                        SELECT SUM( DISTINCT cast("pilgrim"."meta"."Value"  as int) ) as "Value"  FROM "pilgrim"."meta" 
                        WHERE "pilgrim"."meta"."Option" LIKE \'%actual-no-of-seats\' AND "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID"
                        GROUP BY "pilgrim"."meta"."SystemDate"
                    ) as "T1" ), 0)
                        
                )) != 0';*/
        //$SQL .= ' ORDER BY pilgrim."meta"."AllowReference" DESC';
        //echo $SQL;exit();
        // $records = $Crud->ExecuteSQL($SQL);
        //return $records;
        return $SQL;
    }

    public
    function count_used_transport_summary_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->used_transport_summary_count();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_used_transport_summary_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->used_transport_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function DailyLeadsActivityReport()
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['DailyLeadDistributionSessionFilters'];
        $StartDate = $EndDate = $StartTime = $EndTime = '';
        if (isset($SessionFilters['start_date']) && $SessionFilters['start_date'] != '') {
            $StartDate = $SessionFilters['start_date'];
        } else {
            $StartDate = date("Y-m-d");
        }

        if (isset($SessionFilters['end_date']) && $SessionFilters['end_date'] != '') {
            $EndDate = $SessionFilters['end_date'];
        } else {
            $EndDate = date("Y-m-d");
        }

        if (isset($SessionFilters['start_time']) && $SessionFilters['start_time'] != '') {
            $StartTime = $SessionFilters['start_time'];
        } else {
            $StartTime = "00:00";
        }

        if (isset($SessionFilters['end_time']) && $SessionFilters['end_time'] != '') {
            $EndTime = $SessionFilters['end_time'];
        } else {
            $EndTime = "23:59";
        }

        $ActivityDuration = ' sales."LeadsActivity"."SystemDate" 
            BETWEEN \'' . date("Y-m-d", strtotime($StartDate)) . ' ' . $StartTime . ':00\' 
                AND \'' . date("Y-m-d", strtotime($EndDate)) . ' ' . $EndTime . ':59\' ';

        $Duration = ' BETWEEN \'' . date("Y-m-d", strtotime($StartDate)) . ' ' . $StartTime . ':00\'
            AND \'' . date("Y-m-d", strtotime($EndDate)) . ' ' . $EndTime . ':59\' ';

        $db = db_connect();
        $FinalArray = $FinalTitlesArray = $FinalStatusArray = array();
        $SQL = '
        SELECT DISTINCT sales."Leads"."UserID", main."Users"."FullName",            
            ( SELECT COUNT("L_2"."UID")  FROM sales."Leads" AS "L_2" WHERE "L_2"."UserID" = sales."Leads"."UserID" 
                   AND "L_2"."LeadAssignmentDate" ' . $Duration . ' AND "L_2"."Archive" = 0 AND "L_2"."Status" = \'new\' ) as "AssignLeads",            
            ( SELECT COUNT(sales."LeadsActivity"."UID") FROM sales."LeadsActivity" WHERE "SystemDate" ' . $Duration . ' 
                AND sales."LeadsActivity"."Activity" LIKE \'Detail send via SMS:%\' AND "UserUID" = sales."Leads"."UserID"  ) as "SMSDetails",        
        sales."Leads"."Status", COUNT(sales."Leads"."UID") as "TotalLeads" FROM sales."Leads"
        JOIN main."Users" ON (main."Users"."UID" = sales."Leads"."UserID")
        WHERE sales."Leads"."Status" != \'new\'  ';
        $SQL .= ' AND sales."Leads"."UID" IN (
                    SELECT DISTINCT "LeadsUID" FROM sales."LeadsActivity" WHERE ' . $ActivityDuration . '
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%Lead Status Change from%\' AND ' . $ActivityDuration . ' ) 
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%Un Assign Lead Assign To Agent%\' AND ' . $ActivityDuration . ' ) 
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%New Lead Added With Status%\' AND ' . $ActivityDuration . ' ) 
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%New Lead Added in System%\' AND ' . $ActivityDuration . ' ) 
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%New "Un-Authorized" Lead Added%\' AND ' . $ActivityDuration . ' ) 
                        AND sales."LeadsActivity"."UID" NOT IN ( SELECT "UID" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."Activity" LIKE \'%Lead Assign To%\' AND ' . $ActivityDuration . ' ) 
                    )';

        if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
            $SQL .= ' AND sales."Leads"."ProductID" =  \'' . $SessionFilters['product'] . '\' ';
        }
        $SQL .= ' GROUP BY sales."Leads"."UserID", main."Users"."FullName", sales."Leads"."Status" 
                    ORDER BY sales."Leads"."Status" ';

        //echo nl2br($SQL);exit;
        $ReportData = $db->query($SQL)->getResultArray();
        $db->transComplete();
        $FinalStatusArray[] = 'new';
        $FinalStatusArray[] = 'sms';
        foreach ($ReportData as $SRD) {
            $FinalArray[$SRD['UserID']]['new'] = $SRD['AssignLeads'];
            $FinalArray[$SRD['UserID']]['sms'] = $SRD['SMSDetails'];
            $FinalArray[$SRD['UserID']][$SRD['Status']] = $SRD['TotalLeads'];

            $FinalTitlesArray[$SRD['UserID']] = $SRD['FullName'];
            $FinalStatusArray[] = $SRD['Status'];
        }
        asort($FinalTitlesArray);
        return array("heads" => $FinalTitlesArray, "status" => array_unique($FinalStatusArray), "stats" => $FinalArray);
    }

    public
    function get_hotel_brn_summary_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_hotel_brn_summary_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_summary();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function hotel_brn_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['BRNHotelSummaryReportSessionFilters'];


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                    
                    main."Cities"."Name" as "CityName",
                    packages."Hotels"."Name" as "HotelName",
                    "BRN"."brn"."HotelsID",
                    
                    (select  count("brn1"."BRNCode") AS "VisaBRN"
                    FROM  "BRN"."brn" AS  "brn1"
                     where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'Visa\')
                     ),
                    (select  SUM(CAST("brn1"."Rooms" AS Int)) AS "VisaRooms"
                     FROM  "BRN"."brn" AS  "brn1"
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'Visa\')
                    ),
                    (select  SUM(CAST("brn1"."Beds" AS Int)) AS "VisaBeds"
                    FROM  "BRN"."brn" AS  "brn1"
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID" AND "brn1"."UseType"=\'Visa\')
                    ),
                    
                    (select  count(Distinct "brn1"."UID") AS "VisaBRNUse"
                    FROM  "BRN"."brn" AS  "brn1"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."Value"=(cast("brn1"."UID"  as character varying))
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'Visa\')
                    ),
                    (select  count("brn1"."UID") AS "VisaBRNLoss"
                    FROM  "BRN"."brn" AS  "brn1"
                     where  "brn1"."UID" NOT IN(select  "brn2"."UID"
                    FROM  "BRN"."brn" AS  "brn2"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."Value"=(cast("brn2"."UID"  as character varying))
                    where ("brn2"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn2"."UseType"=\'Visa\')
                    )
                    AND "brn1"."HotelsID"="BRN"."brn"."HotelsID"  
                    AND "brn1"."UseType"=\'Visa\' 
                    AND "brn1"."ExpireDate"< CURRENT_DATE
                    ),
                    (select  count("brn1"."BRNCode") AS "ActualBRN"
                    FROM  "BRN"."brn" AS  "brn1"
                     where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'visa_and_hotel\')
                     ),
                    (select  SUM(CAST("brn1"."Rooms" AS Int)) AS "ActualRooms"
                     FROM  "BRN"."brn" AS  "brn1"
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'visa_and_hotel\')
                    ),
                    (select  SUM(CAST("brn1"."Beds" AS Int)) AS "ActualBeds"
                    FROM  "BRN"."brn" AS  "brn1"
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID" AND "brn1"."UseType"=\'visa_and_hotel\')
                    ),
                    (select  count(Distinct "brn1"."UID") AS "ActualBRNUse"
                    FROM  "BRN"."brn" AS  "brn1"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."Value"=(cast("brn1"."UID"  as character varying))
                    where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'visa_and_hotel\')
                    ),
                    (select  count("brn1"."UID") AS "ActualBRNLoss"
                    FROM  "BRN"."brn" AS  "brn1"
                     where  "brn1"."UID" NOT IN(select  "brn2"."UID"
                    FROM  "BRN"."brn" AS  "brn2"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."Value"=(cast("brn2"."UID"  as character varying))
                    where ("brn2"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn2"."UseType"=\'visa_and_hotel\')
                    )
                    AND "brn1"."HotelsID"="BRN"."brn"."HotelsID"  
                    AND "brn1"."UseType"=\'visa_and_hotel\' 
                    AND "brn1"."ExpireDate"< CURRENT_DATE
                    )
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"="BRN"."brn"."HotelsID"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    
                    where "BRN"."brn"."BRNType"=\'hotel\'

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }

        $SQL .= 'Group By 
        main."Cities"."Name",
        packages."Hotels"."Name",
        "BRN"."brn"."HotelsID"';

        //$SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */
        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE LOWER("MainQuery"."HotelName") LIKE \'%' . trim($SessionFilters['hotel']) . '%\' ';
        }

        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE LOWER("MainQuery"."CityName") LIKE \'%' . trim($SessionFilters['city']) . '%\' ';
        }
        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

//        echo $SQL; exit;
        return $SQL;
    }

    public
    function get_hotel_brn_use_actual_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_use_actual();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_hotel_brn_use_actual_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_use_actual();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_hotel_brn_balance_actual_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_balance_actual();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_hotel_brn_balance_actual_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_balance_actual();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function hotel_brn_balance_actual()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['HTLBalanceActualSessionFilter'];

//        print_r($PilgrimSearchFilter);exit;

        $SQL = 'SELECT 
                "BRN"."brn"."UID",
                 TO_CHAR("BRN"."brn"."CreatedDate" :: DATE, \'dd Mon, yyyy\') AS "BookingDate",
                 TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",
                 "BRN"."brn"."BRNCode",
                 "BRN"."brn"."PurchaseID" AS "BookingID", 
                  main."Users"."FullName" AS "PurchasedBy",  
                 TO_CHAR("voucher"."AccommodationDetails"."SystemDate" :: DATE, \'dd Mon, yyyy\') AS "Useddate",
                 "main"."Cities"."Name" as "CityName",
                 "packages"."Hotels"."Name" as "HotelName",
                 
                 TO_CHAR("voucher"."AccommodationDetails"."CheckIn" :: DATE, \'dd Mon, yyyy\') AS "CheckIn",
                 TO_CHAR("voucher"."AccommodationDetails"."CheckOut" :: DATE, \'dd Mon, yyyy\') AS "CheckOut",
                 DATE_PART(\'day\', AGE(min("voucher"."AccommodationDetails"."CheckOut"), min("voucher"."AccommodationDetails"."CheckIn"))) AS "Nights",
                 "BRN"."brn"."BRNType", 
                 "pilgrim"."meta"."AllowReference",
                 COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
                 (cast("BRN"."brn"."Rooms" as int)-
                    (SELECT 
                    SUM(distinct cast("PM"."Value" as int)) 
                    FROM "pilgrim"."meta" AS "PM" 
                    WHERE "PM"."Option" LIKE \'%check-in-%-room-no%\' AND "PM"."AllowReference" = "pilgrim"."meta"."AllowReference")) AS "RoomBalanced",
                 (cast("BRN"."brn"."Beds" as int)-
                 (SELECT 
                    SUM(distinct cast("PM"."Value" as int)) 
                    FROM "pilgrim"."meta" AS "PM" 
                    WHERE "PM"."Option" LIKE \'%check-in-%-no-of-bed%\' AND "PM"."AllowReference" = "pilgrim"."meta"."AllowReference")) AS "BedBalanced",
                "pilgrim"."meta"."CreatedBy",
                "USER"."FullName" AS "UserName"
                FROM "BRN"."brn"
                INNER JOIN "pilgrim"."meta" ON CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
                INNER JOIN "voucher"."AccommodationDetails" ON "voucher"."AccommodationDetails"."UID"="pilgrim"."meta"."AllowReference"
                LEFT JOIN "voucher"."Master" ON "voucher"."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
                INNER JOIN  "main"."Cities" ON (cast("voucher"."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int))
                INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
                INNER JOIN  "main"."Users" ON (cast("main"."Users"."UID" as character varying))=(cast("BRN"."brn"."PurchasedBy"  as character varying))
                INNER JOIN  "main"."Users" AS "USER" ON (cast("USER"."UID" as int) = cast("pilgrim"."meta"."CreatedBy" as int))
                LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions" ."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying))
                WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%check-in%brn%\' AND "BRN"."brn"."BRNType"=\'hotel\'';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND "voucher"."Master"."WebsiteDomain" = ' . $session['domainid'] . '';
        }


        if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '' && isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['checkin_date_from']) && $SessionFilters['checkin_date_from'] != '' && isset($SessionFilters['checkin_date_to']) && $SessionFilters['checkin_date_to'] != '') {
            $SQL .= ' AND "CheckIn" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['checkin_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['checkin_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['booking_id']) && trim($SessionFilters['booking_id']) != '') {
            $SQL .= ' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%' . strtolower(trim($SessionFilters['booking_id'])) . '%\' ';
        }

//        if( isset($SessionFilters['Status']) && trim($SessionFilters['Status']) != '' ){
//            $SQL.=' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%'.strtolower(trim($SessionFilters['Status']) ).'%\' ';
//        }


        $SQL .= 'GROUP BY 
                "BRN"."brn"."UID",
                "voucher"."AccommodationDetails"."SystemDate", 
                "main"."Cities"."Name",
                "packages"."Hotels"."Name",
                "voucher"."AccommodationDetails"."NoOfBeds",
                "voucher"."AccommodationDetails"."CheckIn",
                "voucher"."AccommodationDetails"."CheckOut",
                "BRN"."brn"."BRNCode", 
                "BRN"."brn"."BRNType", 
                "pilgrim"."meta"."AllowReference",
                "pilgrim"."meta"."CreatedBy",
                "main"."Users"."FullName",
                "main"."LookupsOptions"."Name",
                "USER"."FullName"';


//        echo $SQL;
//        exit;

        return $SQL;
    }


    public
    function get_vehicle_arrangement_report_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->vehicle_arrangement();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_vehicle_arrangement_report_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->vehicle_arrangement_count();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }


    public
    function get_hotel_arrangement_report_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->hotel_arrangement();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
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

        return $FinalArray;
    }

    public
    function count_hotel_arrangement_report_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->hotel_arrangement();
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
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

        return count($FinalArray);
    }

    public
    function get_seat_loss_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_seat_loss();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_seat_loss_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_seat_loss();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }


    public
    function OrganicActivitiesReportData($Filters = array())
    {
//        $OrganicActivityReportFilter = $Filters['OrganicActivitiesStatFilter'];

//        print_r($Filters);
//        exit;

        $db = db_connect();
        $FinalArray = $FinalTitlesArray = array();

        $db->transStart();
        $SQL = 'SELECT main."Lookups"."Key" ,main."Lookups"."Name" ,main."LookupsOptions"."UID" ,main."LookupsOptions"."Name" ,sales."Worksheet"."CreatedAt"
        ,COUNT(sales."WorksheetMeta"."UID") AS "TotalActivities" FROM main."LookupsOptions"
        INNER JOIN sales."WorksheetMeta" ON (main."LookupsOptions"."UID" = sales."WorksheetMeta"."OptionUID")
        INNER JOIN main."Lookups" ON (main."LookupsOptions"."LookupID" = main."Lookups"."UID")
        INNER JOIN sales."Worksheet" ON (sales."WorksheetMeta"."WorkSheetUID" = sales."Worksheet"."UID")';

        //echo $SQL;

        if (isset($Filters['checkin_date_from']) && $Filters['checkin_date_from'] != '' && isset($Filters['checkin_date_to']) && $Filters['checkin_date_to'] != '') {
            $SQL .= ' WHERE sales."Worksheet"."CreatedAt" BETWEEN \'' . date("Y-m-d", strtotime($Filters['checkin_date_from'])) . ' 00:00:01 \'
            AND \'' . date("Y-m-d", strtotime($Filters['checkin_date_to'])) . ' 23:59:59\' ';
        }

        $SQL .= ' GROUP BY sales."Worksheet"."CreatedAt", main."LookupsOptions"."Name", main."Lookups"."Key", main."Lookups"."Name", main."LookupsOptions"."UID"
        ORDER BY main."Lookups"."Name" ,main."LookupsOptions"."Name"  ';

//       echo $SQL;
//       exit;

        $ReportData = $db->query($SQL)->getResultArray();
        $db->transComplete();
        foreach ($ReportData as $SRD) {
            $FinalArray[$SRD['UID']][date("U", strtotime($SRD['CreatedAt']))] = $SRD['TotalActivities'];
            $FinalTitlesArray[$SRD['Key']]['Name'] = $SRD['Name'];
            $FinalTitlesArray[$SRD['Key']]['options'][$SRD['UID']] = $SRD['Name'];

        }


//        echo"<pre>";
//        print_r($FinalTitlesArray);
//        print_r($FinalArray);
//        print_r($ReportData);

        return array("heads" => $FinalTitlesArray, "stats" => $FinalArray);
    }


    public
    function hotel_seat_loss()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['SeatLossReportSessionFilters'];

        $SQL = 'SELECT 
                "BRN"."brn"."UID",
                 TO_CHAR("BRN"."brn"."CreatedDate" :: DATE, \'dd Mon, yyyy\') AS "BookingDate",
                 TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",
                 "BRN"."brn"."BRNCode",
                 "BRN"."brn"."PurchaseID" AS "BookingID",
                 "Look3"."Name" AS "VehicleType",
                 main."LookupsOptions"."Name" AS "CompanyName",
                (cast("BRN"."brn"."Seats" as int)
                -(SELECT coalesce(SUM(T."Value"),0) From(SELECT Distinct cast("PM2"."Value" as int),"PM2"."SystemDate"
                FROM pilgrim."meta" AS "PM2"
                WHERE "PM2"."AllowReference" IN(
                SELECT Distinct pilgrim."meta"."AllowReference"
                FROM pilgrim."meta"
                WHERE cast(pilgrim."meta"."Value" as int) ="BRN"."brn"."UID"
                AND pilgrim."meta"."Option" Like \'allow-tpt-%-brn-no\'
                )
                AND "PM2"."Option" Like \'allow-tpt-%-no-of-seats\'
                Group By
                "PM2"."SystemDate",
                "PM2"."Value") AS T)
                )  AS "SeatLoss",
                "LUO1"."Name" AS "SectorName"
                
                
                 FROM "BRN"."brn"
                 LEFT JOIN main."LookupsOptions" AS  "Look3" ON (cast("Look3" ."UID" as character varying))=(cast("BRN"."brn"."TransportType"  as character varying))
                 LEFT JOIN main."LookupsOptions" ON(cast(main."LookupsOptions"."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying))
                 LEFT JOIN main."LookupsOptions" AS "LUO1"  ON (cast("LUO1"."UID" as character varying))=(cast("BRN"."brn"."TransportSectors"  as character varying))
                 WHERE "BRN"."brn"."BRNType"=\'transport\'';
        if ($session['domainid'] > 0) {
            $SQL .= 'AND "BRN"."brn"."WebsiteDomain" = ' . $session['domainid'] . '';
        }

        /** Filters Start */

        if (isset($SessionFilters['booking_date_from']) && $SessionFilters['booking_date_from'] != '' && isset($SessionFilters['booking_date_to']) && $SessionFilters['booking_date_to'] != '') {
            $SQL .= ' AND "BRN"."brn"."CreatedDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['booking_date_to'])) . '\' ';
        }

        if (isset($SessionFilters['booking_id']) && trim($SessionFilters['booking_id']) != '') {
            $SQL .= ' AND LOWER("BRN"."brn"."PurchaseID") LIKE \'%' . strtolower(trim($SessionFilters['booking_id'])) . '%\' ';
        }

        if (isset($SessionFilters['vehicle_type']) && trim($SessionFilters['vehicle_type']) != '') {
            $SQL .= ' AND "Look3"."UID" = ' . $SessionFilters['vehicle_type'] . ' ';
        }

        if (isset($SessionFilters['company']) && trim($SessionFilters['company']) != '') {
            $SQL .= ' AND LOWER(main."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['company'])) . '%\' ';
        }

        /** Filters End */

        return $SQL;
    }

    public
    function get_trnasport_brn_purchase_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_purchased();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_trnasport_brn_purchase_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_purchased();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function brn_summary_ptl()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilter = $session['TransportBrnSummaryReportSessionFilters'];

        $SQL = '
        SELECT
            "LUO"."UID" AS "VehicleTypeID",
            "LUO1"."UID" AS "SectorID",
            "BRN"."brn"."TransportType",
            "LUO"."Name" AS "VehicleType",
            "BRN"."brn"."BRNCode",
            
(select  coalesce(SUM(CAST("brn1"."NoOfVehicles" AS Int)),0) AS "VisaQty"
 FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."UID"="BRN"."brn"."UID"  
AND "brn1"."UseType"=\'Visa\'
AND "brn1"."TransportType"="BRN"."brn"."TransportType")
),
(select  coalesce(SUM(CAST("brn1"."Seats" AS Int)),0) AS "VisaSeats"
 FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."UID"="BRN"."brn"."UID"  
AND "brn1"."UseType"=\'Visa\'
AND "brn1"."TransportType"="BRN"."brn"."TransportType")
),
(
SELECT coalesce(count(Distinct pilgrim."meta"."PilgrimUID"),0) AS "VisaBRNUse"
FROM pilgrim."meta"
WHERE pilgrim."meta"."Value" IN(select  cast("BRN"."brn"."UID"  as character varying)
 FROM  "BRN"."brn" 
where "BRN"."brn"."TransportType"="BRN"."brn"."TransportType"
AND "BRN"."brn"."UseType"=\'Visa\')
AND pilgrim."meta"."Option" Like \'allow-tpt-%-brn-no\'
), 
(
(select  coalesce(SUM(CAST("brn1"."Seats" AS Int)),0) AS "VisaSeats"
 FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."UID"="BRN"."brn"."UID"  
AND "brn1"."UseType"=\'Visa\'
AND "brn1"."TransportType"="BRN"."brn"."TransportType")
)
-
(
SELECT coalesce(count(Distinct pilgrim."meta"."PilgrimUID"),0) AS "VisaBRNUse"
FROM pilgrim."meta"
WHERE pilgrim."meta"."Value" IN(select  cast("BRN"."brn"."UID"  as character varying)
 FROM  "BRN"."brn" 
where "BRN"."brn"."TransportType"="BRN"."brn"."TransportType"
AND "BRN"."brn"."UseType"=\'Visa\')
AND pilgrim."meta"."Option" Like \'allow-tpt-%-brn-no\'
)
)  AS "VisaBRNLoss" ,
(select  coalesce(SUM(CAST("brn1"."NoOfVehicles" AS Int)),0) AS "ActualQty"
 FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."UID"="BRN"."brn"."UID"  
AND "brn1"."UseType"=\'visa_and_transport\'
AND "BRN"."brn"."TransportSectors"="LUO1"."UID"
AND "brn1"."TransportType"="BRN"."brn"."TransportType")
),
(select  coalesce(SUM(CAST("brn1"."Seats" AS Int)),0) AS "ActualSeats"
 FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."UID"="BRN"."brn"."UID"  
AND "brn1"."UseType"=\'visa_and_transport\'
AND "BRN"."brn"."TransportSectors"="LUO1"."UID"
AND "brn1"."TransportType"="BRN"."brn"."TransportType")
),
(SELECT coalesce(count(Distinct pilgrim."meta"."PilgrimUID"),0) AS "VisaBRNUse"
FROM pilgrim."meta"
WHERE pilgrim."meta"."Value" IN(select  cast("BRN"."brn"."UID"  as character varying)
 FROM  "BRN"."brn" 
where "BRN"."brn"."TransportType"="BRN"."brn"."TransportType"
AND "BRN"."brn"."TransportSectors"="LUO1"."UID"
AND "BRN"."brn"."UseType"=\'visa_and_transport\')
AND pilgrim."meta"."Option" Like \'allow-tpt-%-brn-no\')  AS "ActualSeatsUsed",
            "BRN"."brn"."PurchaseID",
            "main"."LookupsOptions"."Name" AS "BookingID"
        FROM "BRN"."brn"
        LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
        LEFT JOIN main."LookupsOptions" AS "LUO"  ON (cast("LUO"."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions" ."UID" as character varying))=(cast("BRN"."brn"."Company" as character varying))
        LEFT JOIN main."LookupsOptions" AS "LUO1"  ON (cast("LUO1"."UID" as character varying))=(cast("BRN"."brn"."TransportSectors"  as character varying))
        WHERE "BRN"."brn"."BRNType"=\'transport\'';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "BRN"."brn"."WebsiteDomain" = ' . $session['domainid'] . '';
        }

        /*if(isset($SessionFilter['tpt_type']) && $SessionFilter['tpt_type'] != ''){
            $SQL.=' AND "BRN"."brn"."TransportType" = '.$SessionFilter['tpt_type'].' ';
        }*/

        $SQL .= 'ORDER BY "BRN"."brn"."UID" DESC';

        //echo nl2br($SQL); exit();
//        echo $SQL; exit();
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
        foreach ($records as $record) {
            if (!isset($record['VehicleTypeID']))
                $record['VehicleTypeID'] = 0;

            $FinalArray[$record['VehicleTypeID']]['visa']['qty'] += $record['VisaQty'];


            $FinalArray[$record['VehicleTypeID']]['visa']['seat'] += $record['VisaSeats'];
            $FinalArray[$record['VehicleTypeID']]['visa']['use'] += $record['VisaBRNUse'];
            $FinalArray[$record['VehicleTypeID']]['visa']['loss'] += $record['VisaBRNLoss'];
            $FinalArray[$record['VehicleTypeID']]['actual']['actualqty'] += $record['ActualQty'];
            $FinalArray[$record['VehicleTypeID']]['actual']['actualseats'] += $record['ActualSeats'];
            $FinalArray[$record['VehicleTypeID']][$record['SectorID']]['use'] += $record['ActualSeatsUsed'];


        }
        //echo '<pre>';print_r($FinalArray);exit();
        //echo $FinalArray[53][61]['use'];exit();
        //print_r($FinalArray); //echo "<hr>"; print_r($records);

        return $FinalArray;
    }

    public
    function trp_balance_actual()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];

        $SQL = '
        SELECT
            "BRN"."brn"."UID",
            TO_CHAR("BRN"."brn"."CreatedDate" :: DATE, \'dd Mon, yyyy\') AS "BookingDate",
            TO_CHAR("BRN"."brn"."ExpireDate" :: DATE, \'dd Mon, yyyy\') AS "ExpireDate",
            "BRN"."brn"."BRNCode",
            "LUO"."Name" AS "VehicleType",
            "BRN"."brn"."PurchaseID",
            "main"."LookupsOptions"."Name" AS "BookingID",
            TO_CHAR("voucher"."TransportRate"."TravelDate" :: DATE, \'dd Mon, yyyy\') AS "Useddate",
            "main"."Cities"."Name" as "CityName",
            "voucher"."TransportRate"."Sectors",
            "voucher"."TransportRate"."NoOfSeats",
            "voucher"."TransportRate"."TravelType",
            "BRN"."brn"."NoOfVehicles",
            "BRN"."brn"."Seats",
            "BRN"."brn"."BRNType",
            "pilgrim"."meta"."AllowReference",
            COUNT("pilgrim"."meta"."Value") AS "BRNUsed",
            (SELECT count(distinct "PM"."Value") FROM "pilgrim"."meta" AS "PM" WHERE  "PM"."AllowReference" = "pilgrim"."meta"."AllowReference") AS "SeatUsed",
            "pilgrim"."meta"."CreatedBy",
            "main"."Users"."FullName" AS "UserName"
        FROM "BRN"."brn"
        LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
        LEFT JOIN main."LookupsOptions" AS "LUO"  ON (cast("LUO"."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
        INNER JOIN "pilgrim"."meta" ON CAST("pilgrim"."meta"."Value" as int) = "BRN"."brn"."UID"
        INNER JOIN "voucher"."TransportRate" ON "voucher"."TransportRate"."UID"="pilgrim"."meta"."AllowReference"
        LEFT JOIN "voucher"."Master" ON "voucher"."Master"."UID"=voucher."TransportRate"."VoucherUID"
        INNER JOIN "main"."Cities" ON (cast("voucher"."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
        INNER JOIN "main"."Users" ON (cast("main"."Users"."UID" as int) = cast("pilgrim"."meta"."CreatedBy" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions" ."UID" as character varying))=(cast("BRN"."brn"."Company" as character varying))
        WHERE "pilgrim"."meta"."Value" != \'0\' AND "pilgrim"."meta"."Option" LIKE \'%allow-tpt%brn-no%\'';

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" = ' . $session['domainid'] . '';
        }

        $SQL .= ' GROUP BY
        "BRN"."brn"."UID",
        "voucher"."TransportRate"."TravelDate",
        "LUO"."Name",
        "main"."Cities"."Name",
        "voucher"."TransportRate"."Sectors",
        "voucher"."TransportRate"."NoOfSeats",
        "voucher"."TransportRate"."TravelType",
        "BRN"."brn"."BRNCode",
        "BRN"."brn"."BRNType",
        "pilgrim"."meta"."AllowReference",
        "pilgrim"."meta"."CreatedBy",
        "main"."Users"."FullName",
        "main"."LookupsOptions"."Name"';

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';

        //echo nl2br($SQL); exit();
//        echo $SQL; exit();
        $records = $Crud->ExecuteSQL($SQL);

        $FinalArray = array();
        foreach ($records as $record) {
            if (!isset($FinalArray[$record['UID']]['sectors']))
                $FinalArray[$record['UID']] = $record;

            $FinalArray[$record['UID']]['sectors'][$record['Sectors']]['NoOfSeats'] += $record['NoOfSeats'];
            $FinalArray[$record['UID']]['sectors'][$record['Sectors']]['BRNUsed'] += $record['BRNUsed'];
        }

        //print_r($FinalArray); echo "<hr>"; print_r($records);

        return $FinalArray;
    }

    public
    function get_voucher_refund_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->voucher_refund_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_voucher_refund_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->voucher_refund_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function voucher_refund_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['VoucherIssuedSessionFilters'];

        $SQL = 'SELECT 
                distinct
                to_char(voucher."Master"."CreatedDate"::DATE, \'DD Mon, YYYY\') AS "CreatedDate",
                
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                main."Agents"."FullName" as "AgentName",
                main."Countries"."Name" as "CountryName",
                count(voucher."Pilgrim"."PilgrimUID") AS "TotalPilgrim",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"   
                FROM voucher."Master"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                LEFT JOIN "voucher"."AccommodationDetails" ON ("voucher"."AccommodationDetails"."VoucherID" = voucher."Master"."UID")
                LEFT JOIN "voucher"."TransportRate" ON ("voucher"."TransportRate"."VoucherUID" = voucher."Master"."UID")
                LEFT JOIN "voucher"."Services" ON ("voucher"."Services"."VoucherUID" = voucher."Master"."UID")
                LEFT JOIN "voucher"."ZiyaratsRate" ON ("voucher"."ZiyaratsRate"."VoucherUID" = voucher."Master"."UID")
                LEFT JOIN main."Agents" ON voucher."Master"."AgentUID" = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID" 
                WHERE  ("voucher"."AccommodationDetails"."Refund"=1 
                OR "voucher"."TransportRate"."Refund"=1
                OR "voucher"."Services"."Refund"=1  
                OR "voucher"."ZiyaratsRate"."Refund"=1)  ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';


        $SQL .= 'GROUP BY
                voucher."Master"."CreatedDate",
                voucher."Master"."UID",
                voucher."Master"."VoucherCode",
                main."Agents"."FullName",
                main."Countries"."Name",
                sale_agent."Agents"."FullName",
                main."Agents"."Type" ';
        $SQL .= 'ORDER BY voucher."Master"."UID" DESC';
//echo $SQL;exit();


        return $SQL;
    }
    public
    function get_htl_balance_visa_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_balance_visa();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_htl_balance_visa_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->htl_brn_balance_visa();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function htl_brn_balance_visa()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                    "BRN"."brn"."UID",
                    "BRN"."brn"."GenerateDate",
                    "BRN"."brn"."ExpireDate",
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                    main."Cities"."Name" as "CityName",
                    packages."Hotels"."Name" as "HotelName",
                    "BRN"."brn"."Rooms",
                    "BRN"."brn"."Beds",
                    "BRN"."brn"."GenerateDate" AS "ChechInDate",
                    "BRN"."brn"."ActiveDate" AS "CheckOutDate",
                    "BRN"."brn"."ActiveDate"::date - "BRN"."brn"."GenerateDate"::date AS "TotalNights",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Hotels" ON packages."Hotels"."UID"="BRN"."brn"."HotelsID"
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID"
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                    where "BRN"."brn"."BRNType"=\'hotel\'
                    AND "BRN"."brn"."Archive"=0

                 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['UID']) && $PilgrimSearchFilter['UID'] != '') {
            $SQL .= ' AND pilgrim."master"."UID" = \'' . $PilgrimSearchFilter['UID'] . '\' ';
        }
        if (isset($PilgrimSearchFilter['Group']) && $PilgrimSearchFilter['Group'] != '') {
            $SQL .= ' AND main."Groups"."UID" = \'' . $PilgrimSearchFilter['Group'] . '\' ';
        }


        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */
        if (isset($_POST['booking_date_from']) && $_POST['booking_date_from'] != '' && isset($_POST['booking_date_to']) && $_POST['booking_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."GenerateDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['booking_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['booking_date_to'])) . '\' ';
        }

        if (isset($_POST['expiry_date_from']) && $_POST['expiry_date_from'] != '' && isset($_POST['expiry_date_to']) && $_POST['expiry_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ExpireDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['expiry_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['expiry_date_to'])) . '\' ';
        }

        if (isset($_POST['check_in_date_from']) && $_POST['check_in_date_from'] != '' && isset($_POST['check_in_date_to']) && $_POST['check_in_date_to'] != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."ChechInDate" BETWEEN \'' . date("Y-m-d", strtotime($_POST['check_in_date_from'])) . '\' AND \'' . date("Y-m-d", strtotime($_POST['check_in_date_to'])) . '\' ';
        }

        if (isset($_POST['booking_id']) && trim($_POST['booking_id']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."PurchaseID" LIKE \'%' . trim($_POST['booking_id']) . '%\' ';
        }

        if (isset($_POST['hotel_name']) && trim($_POST['hotel_name']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."HotelName" LIKE \'%' . trim($_POST['hotel_name']) . '%\' ';
        }

        if (isset($_POST['city']) && trim($_POST['city']) != '') {
            $SQL = ' SELECT * FROM ( ' . $SQL . ' ) AS "MainQuery" 
                        WHERE "MainQuery"."CityName" LIKE \'%' . trim($_POST['city']) . '%\' ';
        }
        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_trp_use_visa_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_use_visa();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_trp_use_visa_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_use_visa();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function trp_brn_use_visa()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                    "BRN"."brn"."UID",
                    "BRN"."brn"."GenerateDate",
                    "BRN"."brn"."ExpireDate",
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                     main."LookupsOptions"."Name" AS "VehicalType",
                    "BRN"."brn"."NoOfVehicles",
                    "BRN"."brn"."Seats",
                    "BRN"."brn"."GenerateDate" AS "ChechInDate",
                    "LUO"."Name" AS "CompanyName",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Transport" ON cast(packages."Transport"."Type" as int)="BRN"."brn"."TransportType"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=cast(packages."Transport"."Type" as int)
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON "LUO"."UID"=cast("BRN"."brn"."Company" as int)
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"                    
                    where "BRN"."brn"."BRNType"=\'transport\'
                    AND "BRN"."brn"."Archive"=0';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_trp_balance_visa_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_balance_visa();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_trp_balance_visa_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->trp_brn_balance_visa();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function trp_brn_balance_visa()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                    "BRN"."brn"."UID",
                    "BRN"."brn"."GenerateDate",
                    "BRN"."brn"."ExpireDate",
                    "BRN"."brn"."BRNCode",
                    "BRN"."brn"."PurchaseID",
                     main."LookupsOptions"."Name" AS "VehicalType",
                    "BRN"."brn"."NoOfVehicles",
                    "BRN"."brn"."Seats",
                    "BRN"."brn"."GenerateDate" AS "ChechInDate",
                    "LUO"."Name" AS "CompanyName",
                    main."Users"."FullName" AS "PurchasedBy"
                    FROM "BRN"."brn"
                    LEFT JOIN packages."Transport" ON cast(packages."Transport"."Type" as int)="BRN"."brn"."TransportType"
                    LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=cast(packages."Transport"."Type" as int)
                    LEFT JOIN main."LookupsOptions" AS "LUO" ON "LUO"."UID"=cast("BRN"."brn"."Company" as int)
                    LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"                    
                    where "BRN"."brn"."BRNType"=\'transport\'
                    AND "BRN"."brn"."Archive"=0';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function get_visa_vendor_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->visa_vendor_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_visa_vendor_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->visa_vendor_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function visa_vendor_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
                pilgrim."master"."AgentUID",
                main."Operators"."ContactPersonName" AS "VendorName",
                main."Operators"."OfficeCity" AS "VendorCity",
                main."Countries"."Name" as "CountryName",
                main."Groups"."FullName" as "GroupName",
                pilgrim."master"."UID" AS "PilgrimID",
                CONCAT(pilgrim."master"."FirstName", \' \', pilgrim."master"."LastName") as "PilgrimFullName",
                pilgrim."master"."Gender",
                pilgrim."master"."PassportNumber",
                to_char( pilgrim."master"."DOB"::DATE, \'DD Mon, YYYY\') AS "DOB",
                pilgrim."master"."Nationality",
                pilgrim."mofa"."MOFANumber" as "MOFANumber",
                main."Cities"."Name" as "CityName",
                main."Agents"."Type" AS "IATAType",
                sale_agent."Agents"."FullName" as "ReferenceName"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN main."Operators" ON main."Operators"."UID"=voucher."Master"."UmrahOperator"
                INNER JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                LEFT JOIN main."Countries" ON (main."Operators"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Cities" ON (cast(main."Agents"."CityID" as int) = cast(main."Cities"."UID" as int)) 
                LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        //$SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_visa_vendor_summary_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->visa_vendor_summary_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_visa_vendor_summary_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->visa_vendor_summary_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function visa_vendor_summary_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
main."Operators"."UID",
main."Operators"."ContactPersonName" AS "VendorName",
main."Operators"."OfficeCity" AS "VendorCity",
main."Countries"."Name" as "CountryName",

(
SELECT to_char(min(Distinct voucher."Master"."CreatedDate")::DATE, \'DD Mon, YYYY\') AS "StartDate"
FROM voucher."Master"
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
),
(
SELECT to_char(max(Distinct voucher."Master"."CreatedDate")::DATE, \'DD Mon, YYYY\') AS "EndDate"
FROM voucher."Master"
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
),
(
SELECT coalesce(count(Distinct voucher."Master"."UID"),0) AS "TotalVoucher"
FROM voucher."Master"
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
),
(
SELECT coalesce(count(Distinct voucher."AccommodationDetails"."VoucherID"),0) AS "PackageAndVisa"
FROM voucher."AccommodationDetails"
INNER JOIN voucher."Master" ON (voucher."AccommodationDetails"."VoucherID" = voucher."Master"."UID" AND voucher."AccommodationDetails"."Self"=0)
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
),

(
SELECT coalesce(count(Distinct voucher."AccommodationDetails"."VoucherID"),0) AS "VisaOnly"
FROM voucher."AccommodationDetails"
INNER JOIN voucher."Master" ON (voucher."AccommodationDetails"."VoucherID" = voucher."Master"."UID" AND voucher."AccommodationDetails"."Self"=1)
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
AND voucher."AccommodationDetails"."VoucherID" NOT IN(
SELECT Distinct voucher."AccommodationDetails"."VoucherID"
FROM voucher."AccommodationDetails"
INNER JOIN voucher."Master" ON (voucher."AccommodationDetails"."VoucherID" = voucher."Master"."UID" AND voucher."AccommodationDetails"."Self"=0)
WHERE voucher."Master"."UmrahOperator" =main."Operators"."UID"
)
)
FROM main."Operators"

LEFT JOIN main."Countries" ON (main."Operators"."Country" = main."Countries"."ISO2") ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  main."Operators"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        //$SQL .= ' ORDER BY  "BRN"."brn"."UID" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_hotel_brn_vendor_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_vendor_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_hotel_brn_vendor_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_vendor_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function hotel_brn_vendor_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                main."Agents"."FullName" as "AgentName",
                to_char("BRN"."brn"."BookingDate"::DATE, \'DD Mon, YYYY\') AS "BookingDate",
                to_char("BRN"."brn"."ExpireDate"::DATE, \'DD Mon, YYYY\') AS "ExpireDate",
                "BRN"."brn"."BRNCode",
                "BRN"."brn"."PurchaseID" AS "BookingID",
                main."Cities"."Name" as "HotelCity",
                "packages"."Hotels"."Name" as "HotelName", 
                "BRN"."brn"."Rooms",
                "BRN"."brn"."Beds",
                to_char("BRN"."brn"."GenerateDate"::DATE, \'DD Mon, YYYY\') AS "GenerateDate",
                to_char("BRN"."brn"."ActiveDate"::DATE, \'DD Mon, YYYY\') AS "ActiveDate",
                "BRN"."brn"."ActiveDate"::date - "BRN"."brn"."GenerateDate"::date AS "TotalNights",
                main."Users"."FullName" AS "PurchasedBy"
                FROM "BRN"."brn"
                LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID"
                LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID" 
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'hotel\'';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_tpt_brn_vendor_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->tpt_brn_vendor_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_tpt_brn_vendor_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->tpt_brn_vendor_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function tpt_brn_vendor_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                
                main."Agents"."FullName" as "AgentName",
                to_char("BRN"."brn"."BookingDate"::DATE, \'DD Mon, YYYY\') AS "BookingDate",
                to_char("BRN"."brn"."ExpireDate"::DATE, \'DD Mon, YYYY\') AS "ExpireDate",
                "BRN"."brn"."BRNCode",
                "BRN"."brn"."PurchaseID" AS "BookingID",
                main."LookupsOptions"."Name" AS "VehicleType",
                "BRN"."brn"."NoOfVehicles",
                "BRN"."brn"."Seats",
                to_char("BRN"."brn"."GenerateDate"::DATE, \'DD Mon, YYYY\') AS "GenerateDate",
                
                "LUO"."Name"  AS "CompanyName",
                main."Users"."FullName" AS "PurchasedBy"
                FROM "BRN"."brn"
                LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                LEFT JOIN main."LookupsOptions"  ON (cast(main."LookupsOptions" ."UID" as character varying))=(cast(packages."Transport"."Type"  as character varying))
                LEFT JOIN main."LookupsOptions" AS "LUO"  ON (cast("LUO" ."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying))
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'transport\'';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';


        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_hotel_vendor_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_vendor_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_hotel_vendor_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_vendor_count_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function hotel_vendor_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
"voucher"."AccommodationDetails"."UID",  

main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode" AS "VoucherCode",
"AccCity"."Name" AS "CityName",
"LUO"."Name" AS "HotelCategory",
"PacgHotel"."Name" AS "ActualHotelName",
main."LookupsOptions"."Name" AS "RoomType",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower("AccCity"."Name"),\'-room-no\') 
) AS "RoomNo",
(SELECT count( distinct "pilgrim"."meta"."PilgrimUID") 
FROM "pilgrim"."meta"
WHERE "pilgrim"."meta"."Option" LIKE \'check-in%\' 
AND "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID")  as "TotalPex",
"voucher"."AccommodationDetails"."NoOfBeds",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower("AccCity"."Name"),\'-no-of-bed\') 

) AS "ActualBeds",
TO_CHAR("voucher"."AccommodationDetails"."CheckIn" :: DATE, \'dd Mon, yyyy\') AS "CheckIn",
TO_CHAR("voucher"."AccommodationDetails"."CheckOut" :: DATE, \'dd Mon, yyyy\') AS "CheckOut",
DATE_PART(\'day\', AGE(min(voucher."AccommodationDetails"."CheckOut"), min(voucher."AccommodationDetails"."CheckIn"))) AS "Nights",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower("AccCity"."Name"),\'-actual-arrival-time\') 

) AS "ActualArrivalTime",
(SELECT Distinct "meta"."PilgrimUID"
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower("AccCity"."Name"),\'-status\') Limit 1

) AS "LeaderPilgrimUID",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" 
AND "Option" = CONCAT(\'check-in-\',lower("AccCity"."Name"),\'-contact-number\') 

) AS "PaxMobileNo",
"Agent"."Type" AS "IATAType",
sale_agent."Agents"."FullName" as "ReferenceName"
                
FROM "BRN"."brn"
INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."AccommodationBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID" 
LEFT JOIN main."Agents" AS "Agent" ON voucher."Master"."AgentUID"  = "Agent"."UID"               
LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID"
LEFT JOIN  packages."Hotels" AS "PacgHotel" ON "PacgHotel"."UID" = voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID" 
LEFT JOIN main."Cities" AS "AccCity" ON voucher."AccommodationDetails"."City" = "AccCity"."UID"
LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"               
LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = "Agent"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
WHERE "BRN"."brn"."Archive" = 0 
AND "BRN"."brn"."BRNType" = \'hotel\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        $SQL .= 'Group By
                "voucher"."AccommodationDetails"."UID",
                main."Operators"."CompanyName",
                main."Countries"."Name",
                main."Operators"."OfficeCity",
                "BRN"."brn"."BRNCode",
                voucher."Master"."VoucherCode",
                "AccCity"."Name",
                "LUO"."Name",
                "PacgHotel"."Name",
                main."LookupsOptions"."Name",
                "Agent"."Type",
                sale_agent."Agents"."FullName",
                "BRN"."brn"."CreatedDate"';

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function hotel_vendor_count_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
"voucher"."AccommodationDetails"."UID",  

main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode" AS "VoucherCode",
"AccCity"."Name" AS "CityName",
"LUO"."Name" AS "HotelCategory",
"PacgHotel"."Name" AS "ActualHotelName",
main."LookupsOptions"."Name" AS "RoomType",

"Agent"."Type" AS "IATAType",
sale_agent."Agents"."FullName" as "ReferenceName"
                
FROM "BRN"."brn"
INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."AccommodationBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID" 
LEFT JOIN main."Agents" AS "Agent" ON voucher."Master"."AgentUID"  = "Agent"."UID"               
LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID"
LEFT JOIN  packages."Hotels" AS "PacgHotel" ON "PacgHotel"."UID" = voucher."AccommodationDetails"."Hotel"
LEFT JOIN main."Cities" ON main."Cities"."UID"=packages."Hotels"."CityID" 
LEFT JOIN main."Cities" AS "AccCity" ON voucher."AccommodationDetails"."City" = "AccCity"."UID"
LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
LEFT JOIN main."LookupsOptions" AS "LUO" ON (cast("LUO"."UID" as character varying))=packages."Hotels"."Category"
LEFT JOIN main."LookupsOptions" ON main."LookupsOptions"."UID"=voucher."AccommodationDetails"."RoomType"               
LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = "Agent"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
WHERE "BRN"."brn"."Archive" = 0 
AND "BRN"."brn"."BRNType" = \'hotel\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        $SQL .= 'Group By
                "voucher"."AccommodationDetails"."UID",
                main."Operators"."CompanyName",
                main."Countries"."Name",
                main."Operators"."OfficeCity",
                "BRN"."brn"."BRNCode",
                voucher."Master"."VoucherCode",
                "AccCity"."Name",
                "LUO"."Name",
                "PacgHotel"."Name",
                main."LookupsOptions"."Name",
                "Agent"."Type",
                sale_agent."Agents"."FullName",
                "BRN"."brn"."CreatedDate"';

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_transport_vendor_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->transport_vendor_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_transport_vendor_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->transport_vendor_count_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function transport_vendor_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
voucher."Master"."UID" as "VUID", 
"voucher"."TransportRate"."UID", 
"voucher"."TransportRate"."TransportTypeUID",               
main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                "BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode" AS "VoucherCode",
                main."Cities"."Name" AS "CityName",
(SELECT string_agg(Distinct to_char("meta"."Value" :: DATE, \'dd Mon, yyyy\'), \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-check-out-date\') 
) AS "CheckOutDate",
(SELECT string_agg(Distinct to_char("meta"."Value"::TIME, \'HH12:MI AM\'), \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-check-out-time\') 
) AS "CheckOutTime",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-pickup-point\') 
) AS "PickupPoint",
(SELECT string_agg(Distinct packages."Hotels"."Name", \',\') 
                FROM "pilgrim"."meta" 
INNER JOIN packages."Hotels" ON packages."Hotels"."UID"  = cast("pilgrim"."meta"."Value" as int)
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-actual-hotel\') 
                ) AS "ActualHotel",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-room-no\') 
) AS "RoomNo",


(select  count(voucher."Pilgrim"."PilgrimUID")
FROM voucher."Pilgrim"
 where voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
) AS "TotalPax",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-actual-no-of-seats\') 
) AS "Seats",
(SELECT string_agg(Distinct to_char("meta"."Value"::TIME, \'HH12:MI AM\'), \',\') 
                FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-departure-time\') 
                ) AS "ActualDepartureTime",
                main."LookupsOptions"."Name" AS "Sector",
                (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                From main."LookupsOptions"
                Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
                 (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-transport-destination\') 
                ) AS "TransportDestination",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-vehicle-number\') 
                ) AS "VehicleNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-name\') 
                ) AS "DriverName",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-number\') 
                ) AS "DriverNumber",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-contact-number\') 
                ) AS "PaxContactNumber",
                (SELECT string_agg(Distinct main."LookupsOptions"."Name", \',\') 
                FROM "main"."LookupsOptions"
                LEFT JOIN "pilgrim"."meta"  ON (cast("main"."LookupsOptions"."UID" as character varying))="pilgrim"."meta"."Value"
                
                WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" AND "pilgrim"."meta"."Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-transport-company\')
                 
                ) AS "TransportCompany",
main."Agents"."Type" AS "IATAType",
sale_agent."Agents"."FullName" as "ReferenceName"
                FROM "BRN"."brn"
INNER JOIN voucher."TransportRate" ON voucher."TransportRate"."TransportsBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID" 
LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
               
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"

LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'transport\'

';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        $SQL .= 'Group By
                voucher."Master"."UID",
"voucher"."TransportRate"."UID",
main."Operators"."ContactPersonName",
main."Operators"."CompanyName",
main."Countries"."Name",
main."Cities"."Name",
main."Operators"."OfficeCity",
"BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode",
main."Agents"."Type",
sale_agent."Agents"."FullName",
"BRN"."brn"."CreatedDate",
main."LookupsOptions"."Name"';

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function transport_vendor_count_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
"voucher"."TransportRate"."UID",                
main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                "BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode" AS "VoucherCode"
                FROM "BRN"."brn"
INNER JOIN voucher."TransportRate" ON voucher."TransportRate"."TransportsBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID" 
                LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'transport\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        $SQL .= 'Group By
                "voucher"."TransportRate"."UID",
main."Operators"."ContactPersonName",
main."Operators"."CompanyName",
main."Countries"."Name",
main."Operators"."OfficeCity",
"BRN"."brn"."BRNCode",
voucher."Master"."VoucherCode",
"BRN"."brn"."CreatedDate"';

        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_hotel_brn_vendor_summary_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_vendor_summary_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_hotel_brn_vendor_summary_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->hotel_brn_vendor_summary_count_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function hotel_brn_vendor_summary_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                
main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",
"packages"."Hotels"."CityID" as "HotelCity",
"packages"."Hotels"."Name" as "HotelName", 
"BRN"."brn"."HotelsID",
"BRN"."brn"."Rooms",
"BRN"."brn"."Beds",
(select  coalesce(SUM(CAST("brn1"."Rooms" AS Int)),0) AS "VisaRooms"
FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'Visa\')
),
(select  coalesce(SUM(CAST("brn1"."Beds" AS Int)),0) AS "VisaBeds"
FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."HotelsID"="BRN"."brn"."HotelsID" AND "brn1"."UseType"=\'Visa\')
),
(select  coalesce(SUM(CAST("brn1"."Rooms" AS Int)),0) AS "ActualRooms"
FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."HotelsID"="BRN"."brn"."HotelsID"  AND "brn1"."UseType"=\'visa_and_hotel\')
),
(select  coalesce(SUM(CAST("brn1"."Beds" AS Int)),0) AS "ActualBeds"
FROM  "BRN"."brn" AS  "brn1"
where ("brn1"."HotelsID"="BRN"."brn"."HotelsID" AND "brn1"."UseType"=\'visa_and_hotel\')
)
               
                FROM "BRN"."brn"
                INNER JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID" 
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                
                
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'hotel\'

';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function hotel_brn_vendor_summary_count_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT 
                
main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",
"packages"."Hotels"."CityID" as "HotelCity",
"packages"."Hotels"."Name" as "HotelName", 
"BRN"."brn"."HotelsID",
"BRN"."brn"."Rooms",
"BRN"."brn"."Beds"
                 FROM "BRN"."brn"
                INNER JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN "packages"."Hotels" ON "packages"."Hotels"."UID" = "BRN"."brn"."HotelsID" 
                LEFT JOIN "main"."Agents" ON "BRN"."brn"."Agent" = "main"."Agents"."UID" 
                
                
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'hotel\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_transport_brn_vendor_summary_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->transport_brn_vendor_summary_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_transport_brn_vendor_summary_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->transport_brn_vendor_summary_count_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function transport_brn_vendor_summary_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
main."Operators"."ContactPersonName" as "VendorName",
main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",

"LUO1"."Name" AS "TransportType",
main."LookupsOptions"."Name" AS "TransportCompany",
 coalesce((CASE WHEN "BRN"."brn"."UseType"=\'Visa\' THEN CAST("BRN"."brn"."NoOfVehicles" AS Int) END),0) AS "VisaQty",
 coalesce((CASE WHEN "BRN"."brn"."UseType"=\'Visa\' THEN CAST("BRN"."brn"."Seats" AS Int) END),0) AS "VisaSeats",



coalesce((CASE WHEN "BRN"."brn"."UseType"=\'visa_and_transport\' THEN CAST("BRN"."brn"."NoOfVehicles" AS Int) END),0) as "ActualQty",

coalesce((CASE WHEN "BRN"."brn"."UseType"=\'visa_and_transport\' THEN coalesce(CAST("BRN"."brn"."Seats" AS Int),0) END),0) as "ActualSeats"

FROM "BRN"."brn"
INNER JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2")
LEFT JOIN main."LookupsOptions"  ON (cast(main."LookupsOptions"."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying)) 
LEFT JOIN main."LookupsOptions" AS "LUO1"  ON (cast("LUO1"."UID" as character varying))=(cast("BRN"."brn"."TransportType"  as character varying))
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'transport\'

';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function transport_brn_vendor_summary_count_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
main."Operators"."ContactPersonName" as "VendorName",
main."Operators"."CompanyName" as "CompanyName",
main."Countries"."Name" as "CountryName",
main."Operators"."OfficeCity" AS "VendorCity",
"BRN"."brn"."BRNCode",

"LUO1"."Name" AS "TransportType",
main."LookupsOptions"."Name" AS "TransportCompany"

FROM "BRN"."brn"
INNER JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2")
LEFT JOIN main."LookupsOptions"  ON (cast(main."LookupsOptions"."UID" as character varying))=(cast("BRN"."brn"."Company"  as character varying)) 
LEFT JOIN main."LookupsOptions" AS "LUO1"  ON (cast("LUO1"."UID" as character varying))=(cast("BRN"."brn"."TransportType"  as character varying))
                WHERE "BRN"."brn"."Archive" = 0 
                AND "BRN"."brn"."BRNType" = \'transport\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }



        $SQL .= ' ORDER BY "BRN"."brn"."CreatedDate" DESC';
//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_hotel_vendor_summary_datatables()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_vendor_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

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

        return $FinalArray;
    }
    public
    function count_hotel_vendor_summary_filtered()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_vendor_summary();
        $records = $Crud->ExecuteSQL($SQL);
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

        return count($FinalArray);
    }
    public
    function hotel_vendor_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['HotelSummarySessionFilters'];

        $SQL = '
       SELECT
"voucher"."AccommodationDetails"."UID",  
cast("voucher"."AccommodationDetails"."Hotel" as int),
main."Operators"."CompanyName" as "CompanyName",

main."Operators"."OfficeCity" AS "VendorCity",
"main"."LookupsOptions"."Name" AS "CategoryName",
"packages"."Hotels"."Name" as "HotelName",
(
SELECT count( distinct "PilgrimUID" ) 
FROM "pilgrim"."meta" 
WHERE "Option" LIKE \'%check-in-%-room%\' AND "AllowReference" = "voucher"."AccommodationDetails"."UID"
) as "TotalPilgrims",
SUM(DATE_PART(\'day\', AGE("voucher"."AccommodationDetails"."CheckOut", "voucher"."AccommodationDetails"."CheckIn"))) AS "TotalNights",
SUM( cast("voucher"."AccommodationDetails"."NoOfBeds" as int) ) as "TotalBeds",
"voucher"."AccommodationDetails"."RoomType",
"LO2"."Name" AS "RoomTypeName",
sale_agent."Agents"."FullName" as "ReferenceName"
FROM "BRN"."brn"
INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."AccommodationBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."AccommodationDetails"."VoucherID" 
LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions"."UID" as character varying))=(cast("packages"."Hotels"."Category"  as character varying))
LEFT JOIN "main"."LookupsOptions" as "LO2" ON (cast("LO2"."UID" as character varying))=(cast("voucher"."AccommodationDetails"."RoomType"  as character varying))
LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
WHERE "BRN"."brn"."Archive" = 0 
AND "BRN"."brn"."BRNType" = \'hotel\'
AND cast("voucher"."AccommodationDetails"."Hotel" as int) > 0
        AND "voucher"."AccommodationDetails"."Self" = 0';

        /** Filters Start */

        /** Filters ENDS */

        if ($session['domainid'] > 0) {
            $SQL .= 'AND "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        $SQL .= '
        GROUP BY 
        "voucher"."AccommodationDetails"."UID",
        main."Operators"."CompanyName",
        main."Operators"."OfficeCity",
        "main"."LookupsOptions"."Name",
        "packages"."Hotels"."Name",
        "LO2"."Name",
        sale_agent."Agents"."FullName"';

        //$SQL .= 'ORDER BY voucher."Master"."UID" DESC';
        //echo nl2br($SQL);
        //exit();
        //$records = $Crud->ExecuteSQL($SQL);



        return $SQL;
    }
    public
    function get_transport_vendor_summary_report_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->transport_vendor_summary_report();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function count_transport_vendor_summary_report_filtered()
    {

        $Crud = new Crud();
        $SQL = $this->transport_vendor_summary_count_report();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function transport_vendor_summary_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
voucher."Master"."UID" as "VUID", 
"voucher"."TransportRate"."UID", 
"voucher"."TransportRate"."TransportTypeUID",               
main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                


(select  count(voucher."Pilgrim"."PilgrimUID")
FROM voucher."Pilgrim"
 where voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
) AS "TotalPax",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
FROM "pilgrim"."meta" 
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-actual-no-of-seats\') 
) AS "Seats",
main."LookupsOptions"."Name" AS "Sector",
                (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                From main."LookupsOptions"
                Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
"BRN"."brn"."NoOfVehicles"

                FROM "BRN"."brn"
INNER JOIN voucher."TransportRate" ON voucher."TransportRate"."TransportsBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID" 

LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
               
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"


WHERE "BRN"."brn"."Archive" = 0 
AND "BRN"."brn"."BRNType" = \'transport\'

';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function transport_vendor_summary_count_report()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $PilgrimSearchFilter = $session['AgentSearchFilter'];

        $SQL = 'SELECT
voucher."Master"."UID" as "VUID", 
"voucher"."TransportRate"."UID", 
"voucher"."TransportRate"."TransportTypeUID",               
main."Operators"."ContactPersonName" as "VendorName",
                main."Operators"."CompanyName" as "CompanyName",
                main."Countries"."Name" as "CountryName",
                main."Operators"."OfficeCity" AS "VendorCity",
                


main."LookupsOptions"."Name" AS "Sector",
                
"BRN"."brn"."NoOfVehicles"

                FROM "BRN"."brn"
INNER JOIN voucher."TransportRate" ON voucher."TransportRate"."TransportsBRN"  = cast("BRN"."brn"."UID" as character varying)
INNER JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID" 

LEFT JOIN main."Cities" ON (cast(voucher."TransportRate"."TravelCity" as int) = cast(main."Cities"."UID" as int))
                LEFT JOIN packages."Transport" ON packages."Transport"."UID"="BRN"."brn"."TransportType"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
               
                
                LEFT JOIN main."Operators" ON "BRN"."brn"."Operator"= (CAST("main"."Operators"."UID" as TEXT))
                LEFT JOIN main."Countries" ON ("BRN"."brn"."Country" = main."Countries"."ISO2") 
                LEFT JOIN main."Users" ON main."Users"."UID"  = "BRN"."brn"."PurchasedBy"


WHERE "BRN"."brn"."Archive" = 0 
AND "BRN"."brn"."BRNType" = \'transport\'
';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  "BRN"."brn"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


//echo $SQL;exit();

        /** Filters
         * Start
         */

        /** Filters
         * ENDS
         */


        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }
    public
    function get_hotel_sale_summary_datatables()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_sale_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        /*foreach ($records as $record) {
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
        }*/
//echo count($FinalArray);//exit();
        return $records;
    }
    public
    function count_hotel_sale_summary_filtered()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->hotel_sale_summary();
        $records = $Crud->ExecuteSQL($SQL);
        /*foreach ($records as $record) {
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
        }*/
//echo count($FinalArray);exit();
        return count($records);
    }
    public
    function hotel_sale_summary()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['VoucherNotIssuedStatsReportSearchFilter'];
        $SessionFilters = $session['HotelSummarySessionFilters'];

        /*$SQL = '
        SELECT distinct
        "main"."Cities"."Name" AS "CityName",
        cast("voucher"."AccommodationDetails"."Hotel" as int),
        "packages"."Hotels"."Name" as "HotelName",
        "main"."LookupsOptions"."Name" AS "CategoryName",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name" AS "RoomTypeName",
        SUM(DATE_PART(\'day\', AGE("voucher"."AccommodationDetails"."CheckOut", "voucher"."AccommodationDetails"."CheckIn"))) AS "TotalNights",
        SUM( cast("voucher"."AccommodationDetails"."NoOfBeds" as int) ) as "TotalBeds",
        
        (
            SELECT count( distinct "PilgrimUID" ) FROM "pilgrim"."meta" 
            WHERE "Option" LIKE \'%check-in-%-room%\' AND "AllowReference" = "voucher"."AccommodationDetails"."UID"
        ) as "TotalPilgrims",
                        
        "voucher"."AccommodationDetails"."UID" as "AllowRefID",
                        
        (
            SELECT sale_agent."Agents"."FullName" as "ReferenceName" FROM voucher."Master"
            LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
            LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
            LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
            WHERE voucher."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        ) as "RefAgentName"
    
        FROM "voucher"."AccommodationDetails"
        INNER JOIN "pilgrim"."meta" ON "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "pilgrim"."meta"."Option" LIKE \'check-in%-room-no\'
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions"."UID" as character varying))=(cast("packages"."Hotels"."Category"  as character varying))
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."AccommodationDetails"."City"  as int))
        LEFT JOIN "main"."LookupsOptions" as "LO2" ON (cast("LO2"."UID" as character varying))=(cast("voucher"."AccommodationDetails"."RoomType"  as character varying))
        
        WHERE cast("voucher"."AccommodationDetails"."Hotel" as int) > 0
        AND "voucher"."AccommodationDetails"."Self" = 0';*/
        $SQL = 'SELECT 
MQ."CategoryName",
MQ."CityName",
MQ."HotelName",
SUM(MQ."TotalPilgrims") AS "TotalPilgrims",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Sharing\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "9",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Double Bed\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "4",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Quad Bed\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "7",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Quint Bed\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "8",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Single Bed\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "3",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Triple Bed\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "6",
SUM(CASE
    WHEN MQ."RoomTypeName" = \'Sharing\' THEN MQ."TotalPilgrims"
    ELSE 0
  END) AS "SharingPilgrims",
SUM(CASE
    WHEN MQ."RoomTypeName" != \'Sharing\' THEN MQ."TotalPilgrims"
    ELSE 0
  END) AS "RoomsPilgrims",
SUM(CASE
    WHEN MQ."RoomTypeName" != \'Sharing\' THEN MQ."TotalBeds"
    ELSE 0
  END) AS "totalRooms",
SUM(CASE
    WHEN MQ."RoomType" > 0  THEN MQ."TotalNights"
    ELSE 0
  END) AS "TotalNights",
(Select CASE WHEN MQ."RefAgentName" IS NOT NULL THEN MQ."RefAgentName" ELSE \'-\' END) AS "RefAgentName"
From
(
SELECT distinct
"main"."LookupsOptions"."Name" AS "CategoryName",
        "main"."Cities"."Name" AS "CityName",
"packages"."Hotels"."Name" as "HotelName",
        cast("voucher"."AccommodationDetails"."Hotel" as int),
        
        
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name" AS "RoomTypeName",
        SUM(DATE_PART(\'day\', AGE("voucher"."AccommodationDetails"."CheckOut", "voucher"."AccommodationDetails"."CheckIn"))) AS "TotalNights",
        SUM( cast("voucher"."AccommodationDetails"."NoOfBeds" as int) ) as "TotalBeds",
        
        (
            SELECT count( distinct "PilgrimUID" ) FROM "pilgrim"."meta" 
            WHERE "Option" LIKE \'%check-in-%-room%\' AND "AllowReference" = "voucher"."AccommodationDetails"."UID"
        ) as "TotalPilgrims",
                        
        "voucher"."AccommodationDetails"."UID" as "AllowRefID",
                        
        (
            SELECT sale_agent."Agents"."FullName" as "ReferenceName" FROM voucher."Master"
            LEFT JOIN main."Agents" ON voucher."Master"."AgentUID"  = main."Agents"."UID"
            LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
            LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
            WHERE voucher."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        ) as "RefAgentName"
    
        FROM "voucher"."AccommodationDetails"
        INNER JOIN "pilgrim"."meta" ON "pilgrim"."meta"."AllowReference" = "voucher"."AccommodationDetails"."UID" AND "pilgrim"."meta"."Option" LIKE \'check-in%-room-no\'
        INNER JOIN "voucher"."Master" ON "voucher"."Master"."UID" = "voucher"."AccommodationDetails"."VoucherID"
        INNER JOIN "packages"."Hotels" ON (cast("packages"."Hotels"."UID" as int)=cast("voucher"."AccommodationDetails"."Hotel" as int))
        LEFT JOIN "main"."LookupsOptions" ON (cast("main"."LookupsOptions"."UID" as character varying))=(cast("packages"."Hotels"."Category"  as character varying))
        LEFT JOIN "main"."Cities" ON (cast("main"."Cities"."UID" as int))=(cast("voucher"."AccommodationDetails"."City"  as int))
        LEFT JOIN "main"."LookupsOptions" as "LO2" ON (cast("LO2"."UID" as character varying))=(cast("voucher"."AccommodationDetails"."RoomType"  as character varying))
        
        WHERE cast("voucher"."AccommodationDetails"."Hotel" as int) > 0
        AND "voucher"."AccommodationDetails"."Self" = 0';
        if (isset($SessionFilters['city']) && trim($SessionFilters['city']) != '') {
            $SQL .= ' AND LOWER("main"."Cities"."Name") LIKE \'%' . strtolower(trim($SessionFilters['city'])) . '%\' ';
        }
        if (isset($SessionFilters['hotel_category']) && trim($SessionFilters['hotel_category']) != '') {
            $SQL .= ' AND LOWER("main"."LookupsOptions"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel_category'])) . '%\' ';
        }
        if (isset($SessionFilters['hotel']) && trim($SessionFilters['hotel']) != '') {
            $SQL .= ' AND LOWER("packages"."Hotels"."Name") LIKE \'%' . strtolower(trim($SessionFilters['hotel'])) . '%\' ';
        }
        if ($session['domainid'] > 0) {
            $SQL .= 'AND "voucher"."Master"."WebsiteDomain" =  ' . $session['domainid'] . '';
        }

        $SQL .= 'GROUP BY 
        "voucher"."AccommodationDetails"."UID",
        "main"."Cities"."Name",
        "voucher"."AccommodationDetails"."Hotel", 
        "packages"."Hotels"."Name",
        "main"."LookupsOptions"."Name",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name"
        
        ORDER BY
        "voucher"."AccommodationDetails"."UID", 
        "main"."Cities"."Name",
        "packages"."Hotels"."Name",
        "voucher"."AccommodationDetails"."RoomType"
) AS MQ
';
        /** Filters Start */

        /** Filters ENDS */



        /*$SQL .= '
        GROUP BY 
        "voucher"."AccommodationDetails"."UID",
        "main"."Cities"."Name",
        "voucher"."AccommodationDetails"."Hotel", 
        "packages"."Hotels"."Name",
        "main"."LookupsOptions"."Name",
        "voucher"."AccommodationDetails"."RoomType",
        "LO2"."Name"
        
        ORDER BY
        "voucher"."AccommodationDetails"."UID", 
        "main"."Cities"."Name",
        "packages"."Hotels"."Name",
        "voucher"."AccommodationDetails"."RoomType"';*/
        //echo $SQL;exit();
$SQL.='Group By
MQ."CategoryName",
MQ."CityName",
MQ."HotelName",
MQ."RefAgentName"';

        return $SQL;
    }
    public
    function count_transport_sale_summary_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->transport_sale_summary_count();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_transport_sale_summary_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->transport_sale_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function transport_sale_summary()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];

        $SQL = 'SELECT
                Distinct 
                 (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                 From main."LookupsOptions"
                 Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                 where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
                main."LookupsOptions"."Name" AS "Sector",
                count("voucher"."TransportRate"."UID") AS "NoOfVehicle",
                SUM(NULLIF("voucher"."TransportRate"."NoOfSeats", \'\')::numeric) AS "NoOfSeats",
                SUM(CAST("voucher"."TransportRate"."NoOfPax" AS Int)) As "TotalPax",
                "voucher"."TransportRate"."TransportTypeUID",
                main."LookupsOptions"."UID" AS "LookupID"
                FROM "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                where "voucher"."TransportRate"."SelfTransport"=0
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

//        if (isset($SessionFilters['from']) && $SessionFilters['from'] != '' && isset($SessionFilters['to']) && $SessionFilters['to'] != '') {
//            $SQL .= ' AND voucher."Flights"."DepartureDate" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['from'])) . '\' AND \'' . date("Y-m-d", strtotime($SessionFilters['to'])) . '\' ';
//        }
        if (isset($SessionFilters['sector']) && $SessionFilters['sector'] != '') {
            $SQL .= ' AND main."LookupsOptions"."UID" = \'' . $SessionFilters['sector'] . '\' ';
        }
        if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
            $SQL .= ' AND "LookupOptions2"."UID" = \'' . $SessionFilters['tpt_type'] . '\' ';
        }


        $SQL .= ' GROUP BY 
                  "voucher"."TransportRate"."TransportTypeUID",
                  main."LookupsOptions"."UID",
                  main."LookupsOptions"."Name" ';

        return $SQL;
    }

    public
    function transport_sale_summary_count()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['TransportSummarySessionsFilter'];

        $SQL = 'SELECT
                Distinct 
                 (
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                 From main."LookupsOptions"
                 Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                 where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
                main."LookupsOptions"."Name" AS "Sector",
                count("voucher"."TransportRate"."UID") AS "NoOfVehicle",
                SUM(NULLIF("voucher"."TransportRate"."NoOfSeats", \'\')::numeric) AS "NoOfSeats",
                SUM(CAST("voucher"."TransportRate"."NoOfPax" AS Int)) As "TotalPax",
                "voucher"."TransportRate"."TransportTypeUID",
                main."LookupsOptions"."UID" AS "LookupID"
                FROM "voucher"."TransportRate"
                LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
                LEFT JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID"  as int)=cast(voucher."TransportRate"."Sectors" as int))
                where "voucher"."TransportRate"."SelfTransport"=0
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if (isset($SessionFilters['sector']) && $SessionFilters['sector'] != '') {
            $SQL .= ' AND main."LookupsOptions"."UID" = \'' . $SessionFilters['sector'] . '\' ';
        }
        if (isset($SessionFilters['tpt_type']) && $SessionFilters['tpt_type'] != '') {
            $SQL .= ' AND "LookupOptions2"."UID" = \'' . $SessionFilters['tpt_type'] . '\' ';
        }

        $SQL .= ' GROUP BY 
                  "voucher"."TransportRate"."TransportTypeUID",
                  main."LookupsOptions"."UID",
                  main."LookupsOptions"."Name" ';

        return $SQL;
    }
    public
    function count_service_sale_summary_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->service_sale_summary();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_service_sale_summary_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->service_sale_summary();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function service_sale_summary()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];

        $SQL = 'SELECT Distinct
(
SELECT coalesce(count(Distinct voucher."Master"."UID"),0) AS "Packages"
FROM voucher."Master"
Where voucher."Master"."Visa"=\'Yes\'
AND voucher."Master"."UID" IN(
SELECT Distinct voucher."TransportRate"."VoucherUID"
FROM voucher."TransportRate"
WHERE voucher."TransportRate"."SelfTransport" = \'0\'
AND voucher."TransportRate"."VoucherUID" IN(SELECT voucher."Master"."UID" FROM voucher."Master" WHERE voucher."Master"."Visa" = \'Yes\')
AND voucher."TransportRate"."VoucherUID" NOT IN(SELECT voucher."AccommodationDetails"."VoucherID" FROM voucher."AccommodationDetails" WHERE voucher."AccommodationDetails"."Self" = \'1\')
)
AND voucher."Master"."UID" IN(
SELECT Distinct voucher."AccommodationDetails"."VoucherID"
FROM voucher."AccommodationDetails"
WHERE voucher."AccommodationDetails"."Self" = \'0\'
AND voucher."AccommodationDetails"."VoucherID" IN(SELECT voucher."Master"."UID" FROM voucher."Master" WHERE voucher."Master"."Visa" = \'Yes\')
AND voucher."AccommodationDetails"."VoucherID" NOT IN(SELECT voucher."TransportRate"."VoucherUID" FROM voucher."TransportRate" WHERE voucher."TransportRate"."SelfTransport" = \'1\')
)
),
(
SELECT coalesce(count(Distinct voucher."TransportRate"."VoucherUID"),0) AS "VisaAndTransport"
FROM voucher."TransportRate"
WHERE voucher."TransportRate"."SelfTransport" = \'0\'
AND voucher."TransportRate"."VoucherUID" IN(SELECT voucher."Master"."UID" FROM voucher."Master" WHERE voucher."Master"."Visa" = \'Yes\')
AND voucher."TransportRate"."VoucherUID" IN(SELECT voucher."AccommodationDetails"."VoucherID" FROM voucher."AccommodationDetails" WHERE voucher."AccommodationDetails"."Self" = \'1\')
),
(
SELECT coalesce(count(Distinct voucher."AccommodationDetails"."VoucherID"),0) AS "VisaAndHotel"
FROM voucher."AccommodationDetails"
WHERE voucher."AccommodationDetails"."Self" = \'0\'
AND voucher."AccommodationDetails"."VoucherID" IN(SELECT voucher."Master"."UID" FROM voucher."Master" WHERE voucher."Master"."Visa" = \'Yes\')
AND voucher."AccommodationDetails"."VoucherID" IN(SELECT voucher."TransportRate"."VoucherUID" FROM voucher."TransportRate" WHERE voucher."TransportRate"."SelfTransport" = \'1\')
),
(
SELECT coalesce(count(Distinct voucher."Master"."UID"),0) AS "OnlyVisa"
FROM voucher."Master"
Where voucher."Master"."Visa"=\'Yes\'
AND voucher."Master"."UID" IN(
SELECT Distinct voucher."TransportRate"."VoucherUID"
FROM voucher."TransportRate"
WHERE voucher."TransportRate"."SelfTransport" = \'1\'
AND voucher."TransportRate"."VoucherUID" NOT IN(SELECT voucher."AccommodationDetails"."VoucherID" FROM voucher."AccommodationDetails" WHERE voucher."AccommodationDetails"."Self" = \'0\')

)
AND voucher."Master"."UID" IN(
SELECT Distinct voucher."AccommodationDetails"."VoucherID"
FROM voucher."AccommodationDetails"
WHERE voucher."AccommodationDetails"."Self" = \'1\'
AND voucher."AccommodationDetails"."VoucherID" NOT IN(SELECT voucher."TransportRate"."VoucherUID" FROM voucher."TransportRate" WHERE voucher."TransportRate"."SelfTransport" = \'0\')

)
),
(
SELECT coalesce(count(voucher."AccommodationDetails"."Hotel"),0) AS "Hotels"
FROM voucher."AccommodationDetails"
INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."AccommodationDetails"."VoucherID"
WHERE voucher."AccommodationDetails"."Self" = \'0\'

),
(
SELECT coalesce(count(voucher."TransportRate"."TransportTypeUID"),0) AS "Transport"
FROM voucher."TransportRate"
INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
WHERE voucher."TransportRate"."SelfTransport" = \'0\'

),
(
SELECT coalesce(SUM(CAST(voucher."TransportRate"."NoOfPax" AS Int)),0) AS "TotalPax"
FROM voucher."TransportRate"
INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
WHERE voucher."TransportRate"."SelfTransport" = \'0\'

),
(
SELECT coalesce(count(voucher."Services"."ServiceID"),0) AS "Services"
FROM voucher."Services"
INNER JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Services"."VoucherUID"


)

FROM voucher."Master"
                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' where  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

//echo $SQL;exit();



        return $SQL;
    }
    public
    function count_tafeej_transport_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->tafeej_transport();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_tafeej_transport_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->tafeej_transport();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }
    public
    function tafeej_transport()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            //$ArrivalMeta[] = $ArrivalCnt . "-contact-number";
        }
        $SQL = 'SELECT
Distinct 
"voucher"."TransportRate"."UID",
main."Cities"."Name" AS "CityName",
(SELECT Distinct "BRN"."brn"."BRNCode"
FROM "BRN"."brn"
LEFT JOIN "pilgrim"."meta"  ON (cast("BRN"."brn"."UID" as character varying))="pilgrim"."meta"."Value"
WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-brn-no\') 
                ) AS "BRN",
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-check-out-date\') 
                ) AS "CheckOutDate",
 (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-pickup-point\') 
                ) AS "PickupPoint",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-transport-destination\') 
                ) AS "TransportDestination",
count(Distinct voucher."Pilgrim"."PilgrimUID") As "TotalPax",
(SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-vehicle-number\') 
                ) AS "VehicleNumber",
                
                (SELECT string_agg(Distinct "meta"."Value", \',\') 
                FROM "pilgrim"."meta" WHERE "pilgrim"."meta"."AllowReference" = "voucher"."TransportRate"."UID" 
                AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-number\') 
                ) AS "DriverNumber",
(
                 select main."LookupsOptions"."Name" AS "TypeOFTransport"
                From main."LookupsOptions"
                Left JOIN packages."Transport"   ON (cast(packages."Transport"."Type"  as character varying))=(cast(main."LookupsOptions"."UID"  as character varying))
                where (cast(packages."Transport"."UID" as character varying)="voucher"."TransportRate"."TransportTypeUID")
                ),
(SELECT string_agg(Distinct main."LookupsOptions"."Name", \',\') AS "TransportCompany"
                    FROM "main"."LookupsOptions"
                    LEFT JOIN "pilgrim"."meta"  ON (cast("main"."LookupsOptions"."UID" as character varying))="pilgrim"."meta"."Value"
                    WHERE "pilgrim"."meta"."AllowReference" =voucher."TransportRate"."UID"
                    AND "Option" = CONCAT(lower(main."Cities"."Name"),\'-arrival-driver-number\') 
AND "pilgrim"."meta"."Option" LIKE \'departure-%-transport-company\'
                   )
FROM "voucher"."TransportRate"
LEFT JOIN voucher."Master" ON voucher."Master"."UID"  = voucher."TransportRate"."VoucherUID"
LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"  = voucher."Master"."UID"

LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID"  = voucher."Pilgrim"."PilgrimUID"
LEFT JOIN main."Cities" ON voucher."TransportRate"."TravelCity"=main."Cities"."UID"
where "voucher"."TransportRate"."UID"=pilgrim."meta"."AllowReference"
AND "pilgrim"."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
$SQL.=' Group By
voucher."TransportRate"."UID",
main."Cities"."Name"';
//echo $SQL;exit();



        return $SQL;
    }
    public
    function get_agent_monitor_screen_datatables()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->agent_monitor_screen();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);


        return $records;
    }
    public
    function count_agent_monitor_screen_filtered()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->agent_monitor_screen();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function agent_monitor_screen()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            //$ArrivalMeta[] = $ArrivalCnt . "-contact-number";
        }
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $SQL = '
WITH RECURSIVE parents AS
(
  SELECT
  main."Agents"."UID" AS id,
  main."Agents"."ParentID"  AS parent,
  main."Agents"."Type" AS type
  FROM main."Agents"
  WHERE main."Agents"."ParentID"=0 AND main."Agents"."Type"=\'agent\'
  UNION
  SELECT
    "child"."UID" AS id,
    "child"."ParentID" AS parent,
    "child"."Type" AS type
 
    FROM main."Agents" AS "child"
    INNER JOIN parents p ON p.id = "child"."ParentID"
)
SELECT 
                MQ."CountryName",
                MQ."AgentID",
                MQ."AgentName",
                MQ."IATAType",
                MQ."ReferenceName",
                (select  count(Distinct "PM"."UID")
                FROM pilgrim."master" AS "PM"
                 where "PM"."AgentUID" = MQ."AgentID"
                ) AS "TotalPax",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                ) AS "Arrived",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\')
                ) AS "Exited",
                (Select (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                ) -
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\')
                )) AS "InKSA",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                AND "VM"."ReturnDate"::DATE=CURRENT_DATE + INTERVAL \'1 day\'
                ) AS "AfterOneDay",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                AND "VM"."ReturnDate"::DATE=CURRENT_DATE + INTERVAL \'2 day\'
                ) AS "AfterTwoDay",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                AND "VM"."ReturnDate"::DATE=CURRENT_DATE + INTERVAL \'3 day\'
                ) AS "AfterThreeDay",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                AND "VM"."ReturnDate"::DATE=CURRENT_DATE + INTERVAL \'4 day\'
                ) AS "AfterFourDay",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                AND "VM"."ReturnDate"::DATE=CURRENT_DATE + INTERVAL \'5 day\'
                ) AS "AfterFiveDay"

                From (SELECT
                  Distinct
                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."UID" as "AgentID",
                  main."Agents"."FullName" AS "AgentName",
                  main."Agents"."Type" AS "IATAType",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                 FROM "voucher"."Pilgrim"
                 
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                 LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 WHERE pilgrim."master"."FirstName" IS NOT NULL
                 AND main."Agents"."UID"IN(SELECT id FROM parents)) MQ';
//echo $SQL;exit();



        return $SQL;
    }
    public
    function get_external_agent_monitor_screen_datatables()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->external_agent_monitor_screen();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);


        return $records;
    }
    public
    function count_external_agent_monitor_screen_filtered()
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = $this->external_agent_monitor_screen();
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }
    public
    function external_agent_monitor_screen()
    {
        $data = $this->data;


        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SessionFilters = $session['TransportSummarySessionsFilter'];
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Arrival'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
            //$ArrivalMeta[] = $ArrivalCnt . "-contact-number";
        }
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $SQL = '
WITH RECURSIVE parents AS
(
  SELECT
  main."Agents"."UID" AS id,
  main."Agents"."ParentID"  AS parent,
  main."Agents"."Type" AS type
  FROM main."Agents"
  WHERE main."Agents"."ParentID"=0 AND main."Agents"."Type"=\'external_agent\'
  UNION
  SELECT
    "child"."UID" AS id,
    "child"."ParentID" AS parent,
    "child"."Type" AS type
 
    FROM main."Agents" AS "child"
    INNER JOIN parents p ON p.id = "child"."ParentID"
)


SELECT 
                MQ."CountryName",
                MQ."AgentID",
                MQ."AgentName",
                MQ."IATAType",
                MQ."ReferenceName",
               (select  count(Distinct "PM"."UID")
                FROM pilgrim."master" AS "PM"
                 where "PM"."AgentUID" = MQ."AgentID"
                ) AS "TotalPax",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                ) AS "VoucherIssued",
                (SELECT (select  count(Distinct "PM"."UID")
                FROM pilgrim."master" AS "PM"
                 where "PM"."AgentUID" = MQ."AgentID"
                ) -
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                 where "VM"."AgentUID" = MQ."AgentID"
                ) 
                
                
                ) AS "VoucherNotIssued",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                ) AS "Arrived",
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\')
                ) AS "Exited",
                (Select (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\')
                ) -
                (select  count(Distinct voucher."Pilgrim"."PilgrimUID")
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Master" AS "VM" ON  "VM"."UID"=voucher."Pilgrim"."VoucherUID"
                INNER JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                where "VM"."AgentUID" = MQ."AgentID"
                AND pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\')
                )) AS "InKSA"
                

                From (SELECT
                  Distinct
                  
                  main."Countries"."Name" as "CountryName",
                  main."Agents"."UID" as "AgentID",
                  main."Agents"."FullName" AS "AgentName",
                  main."Agents"."Type" AS "IATAType",
                  sale_agent."Agents"."FullName" as "ReferenceName"

                 FROM "voucher"."Pilgrim"
                 
                 LEFT JOIN pilgrim."master"  ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                 LEFT JOIN pilgrim."meta" AS "PilgrimMeta" ON "PilgrimMeta"."PilgrimUID" = pilgrim."master"."UID"
                 LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                 LEFT JOIN main."Users" ON voucher."Master"."CreatedBy"  = main."Users"."UID"
                 LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                 LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2") 
                 LEFT JOIN sale_agent."Meta" ON  (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                 LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID"  = sale_agent."Meta"."SaleAgentID"
                 WHERE pilgrim."master"."FirstName" IS NOT NULL
                 AND main."Agents"."UID" IN(SELECT id FROM parents)) MQ';
//echo $SQL;exit();



        return $SQL;
    }
}
