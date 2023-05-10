<?php namespace App\Models;

use App\Controllers\Home;
use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;

class Agents extends Model
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {

        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $this->data['parent_mis'] = array('lalaservices.com');

    }

    public
    function ListAgents($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $AgentSearchFilter = $session['AgentSearchFilter'];
        $SQL = 'SELECT * FROM main."Agents" WHERE "ParentID" = \'0\' AND "Archive" = \'0\' AND "Type" = \'agent\'';

        if (isset($session) && count($session) > 0) {
            $Agents = GetAllAgents($data['session']['agent_id']);
            $SQL .= ' AND "UID" IN (' . $Agents . ') ';
        }

        if ($domain > 0) {
            $SQL .= ' AND "WebsiteDomain" = \'' . $domain . '\' ';
        }
        if (isset($AgentSearchFilter['name'])) {
            $SQL .= ' AND LOWER("FullName") LIKE \'%' . strtolower($AgentSearchFilter['name']) . '%\' ';
        }
        if (isset($AgentSearchFilter['email']) && $AgentSearchFilter['email'] != '') {
            $SQL .= ' AND "Email" = \'' . $AgentSearchFilter['email'] . '\' ';
        }
        if (isset($AgentSearchFilter['phone_number']) && $AgentSearchFilter['phone_number'] != '') {
            $SQL .= ' AND "PhoneNumber" = \'' . $AgentSearchFilter['phone_number'] . '\' ';
        }
        $SQL .= ' ORDER BY "FullName" ASC ';

        //  echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function ListAgentsWithPackageAndReference($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        //print_r($session);

        $AgentSearchFilter = $session['AgentSearchFilter'];
        $SQL = 'SELECT main."Agents".*,sale_agent."Agents"."FullName" as "SaleAgentName" ,packages."Packages"."Name" as "PackageName" FROM main."Agents" 
        LEFT JOIN sale_agent."Meta" ON (CAST(sale_agent."Meta"."Value" AS INTEGER)= main."Agents"."UID")
        LEFT JOIN sale_agent."Agents" ON (sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID")
        LEFT JOIN packages."Packages" ON (packages."Packages"."AgentUID" = main."Agents"."UID")
        WHERE main."Agents"."ParentID" = \'0\' AND main."Agents"."Archive" = \'0\' AND main."Agents"."Type" = \'agent\' ';

        if ($domain > 0) {
            $SQL .= ' AND main."Agents"."WebsiteDomain" = \'' . $domain . '\' ';
        }
        if (isset($AgentSearchFilter['name'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($AgentSearchFilter['name']) . '%\' ';
        }
        if (isset($AgentSearchFilter['email']) && $AgentSearchFilter['email'] != '') {
            $SQL .= ' AND main."Agents"."Email" = \'' . $AgentSearchFilter['email'] . '\' ';
        }
        if (isset($AgentSearchFilter['phone_number']) && $AgentSearchFilter['phone_number'] != '') {
            $SQL .= ' AND main."Agents"."PhoneNumber" = \'' . $AgentSearchFilter['phone_number'] . '\' ';
        }
        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }


        $SQL .= ' ORDER BY main."Agents"."FullName" ASC ';
//    echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function ListExternalAgentsWithPackageAndReference($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        //print_r($session);

        $AgentSearchFilter = $session['AgentSearchFilter'];
        $SQL = 'SELECT main."Agents".*,sale_agent."Agents"."FullName" as "SaleAgentName" ,packages."Packages"."Name" as "PackageName" FROM main."Agents" 
        LEFT JOIN sale_agent."Meta" ON (CAST(sale_agent."Meta"."Value" AS INTEGER)= main."Agents"."UID")
        LEFT JOIN sale_agent."Agents" ON (sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID")
        LEFT JOIN packages."Packages" ON (packages."Packages"."AgentUID" = main."Agents"."UID")
        WHERE main."Agents"."ParentID" = \'0\' AND main."Agents"."Archive" = \'0\' AND main."Agents"."Type" = \'external_agent\' ';

        if ($domain > 0) {
            $SQL .= ' AND main."Agents"."WebsiteDomain" = \'' . $domain . '\' ';
        }
        if (isset($AgentSearchFilter['name'])) {
            $SQL .= ' AND LOWER(main."Agents"."FullName") LIKE \'%' . strtolower($AgentSearchFilter['name']) . '%\' ';
        }
        if (isset($AgentSearchFilter['email']) && $AgentSearchFilter['email'] != '') {
            $SQL .= ' AND main."Agents"."Email" = \'' . $AgentSearchFilter['email'] . '\' ';
        }
        if (isset($AgentSearchFilter['phone_number']) && $AgentSearchFilter['phone_number'] != '') {
            $SQL .= ' AND main."Agents"."PhoneNumber" = \'' . $AgentSearchFilter['phone_number'] . '\' ';
        }

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= 'AND sale_agent."Agents"."UID" IN   (' . $AgentsUIDs . ') ';
        }

        $SQL .= ' ORDER BY main."Agents"."FullName" ASC ';
        //     echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function AgentsCountries($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();
        if ($domain == 0) {
            $WhereSQL = ' main."Agents"."ParentID" = \'0\' AND main."Agents"."Archive" = \'0\' AND main."Agents"."Type" = "agent" ';
        } else if ($domain > 0) {
            $WhereSQL = ' main."Agents"."ParentID" = \'0\' AND main."Agents"."Archive" = \'0\' AND main."Agents"."Type" = "agent" AND main."Agents"."WebsiteDomain" = ' . $domain . ' ';
        }
        $SQL = '
        SELECT DISTINCT 
          main."Countries"."Name",
          main."Countries"."ISO2",
          COUNT(main."Agents"."UID") AS totalagents
        FROM main."Agents"
        INNER JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
        GROUP BY
          main."Countries"."Name",
          main."Countries"."ISO2"
        ORDER BY
          main."Countries"."Name"';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function AgentsDropDown($selected = 0)
    {

        $data = $this->data;
        $FinalData = $records = array();

        $Crud = new Crud();
        $SQL = 'WITH RECURSIVE agents AS (
	SELECT
		"UID",
		"FullName",
		"ParentID",
		0 as level,
		"UID" AS "UID_ParentID"
	FROM
		main."Agents"
	WHERE
		"Archive" = 0 AND "ParentID" = 0
	UNION ALL
		SELECT
			e."UID",
		e."FullName",
		e."ParentID",
		s.level+ 1,
		coalesce(s."UID", e."ParentID") AS "UID_ParentID"
		FROM
			main."Agents" e
		INNER JOIN agents s ON s."UID" = e."ParentID"
		WHERE "Archive" = 0
) SELECT
	"UID",
		TRIM("FullName") AS "FullName",
		"ParentID",
		"UID_ParentID"
FROM
	agents ORDER BY "UID_ParentID", "level", "FullName" ASC';

        $records = $Crud->ExecuteSQL($SQL);

        $FinalData['records'] = $records;

        $selected = (int)$selected + 0;
        // Select Dropdown Options
        $DataHTML = "";
        $DataHTML .= "<option value=''>Please Select</option>";
        foreach ($records as $record) {
            $OptText = ($record['ParentID'] > 0) ? "&raquo; " . $record['FullName'] : $record['FullName'];
            $DataHTML .= '<option value="' . $record['UID'] . '" ' . (($selected == (int)$record['UID']) ? "selected" : "") . '>' . ucwords($OptText) . '</option>';
        }

        $FinalData['html'] = $DataHTML;

        return $FinalData;
    }

    /* Function Changed By Jawad Sajid Durrani ( 12 May  2022 ) */
    public
    function OLDAgentsDropDown($selected = 0)
    {
        $data = $this->data;
        $FinalData = $Data = array();

        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("Archive" => "0", "ParentID" => "0");
        $order = array("FullName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        if ($records) {
            foreach ($records as $thisResult) {
                $Data[] = $thisResult;
                $where = array("Archive" => "0", "ParentID" => $thisResult['UID']);
                $SubAgents = $Crud->ListRecords($table, $where, $order);
                foreach ($SubAgents as $thisSubAgent) {
                    $Data[] = $thisSubAgent;
                }
            }
        }

        $FinalData['records'] = $Data;

        $selected = (int)$selected + 0;
        // Select Dropdown Options
        $DataHTML = "";
        $DataHTML .= "<option value=''>Please Select</option>";
        foreach ($Data as $thisOpt) {
            $OptText = ($thisOpt['ParentID'] > 0) ? "&raquo; " . $thisOpt['FullName'] : $thisOpt['FullName'];
            $DataHTML .= '<option value="' . $thisOpt['UID'] . '" ' . (($selected == (int)$thisOpt['UID']) ? "selected" : "") . '>' . ucwords($OptText) . '</option>';
        }

        $FinalData['html'] = $DataHTML;
        return $FinalData;

    }


    public
    function ListAgentsExceptSubAgents($selected = 0)
    {
        $data = $this->data;
        // echo "<pre>";
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("Archive" => "0", "ParentID" => "0");
        $order = array("FullName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        $FinalData = array();
        $FinalData['records'] = $records;

        $selected = (int)$selected + 0;
        // Select Dropdown Options
        $DataHTML = "";
        $DataHTML .= "<option value=''>Please Select</option>";
        foreach ($records as $thisOpt) {
            if ($thisOpt['Type'] != 'sub_agent') {
                $OptText = $thisOpt['FullName'];
                $DataHTML .= '<option value="' . $thisOpt['UID'] . '" ' . (($selected == (int)$thisOpt['UID']) ? "selected" : "") . '>' . ucwords($OptText) . ' - (' . ucwords(str_replace("_", " ", $thisOpt['Type'])) . ')</option>';

            }
        }


        $FinalData['html'] = $DataHTML;
        return $FinalData;

    }

    public
    function ListSubAgents()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $data['session'] = $session->get();

        $SQL = 'SELECT main."Agents".*,sale_agent."Agents"."FullName" as "SaleAgentName",packages."Packages"."Name" as "PackageName" FROM main."Agents"
        LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as BIGINT)=cast(main."Agents"."UID" as BIGINT))
        LEFT JOIN sale_agent."Agents" ON (sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID")
        LEFT JOIN packages."Packages" ON (packages."Packages"."AgentUID" = main."Agents"."ParentID")
 
        WHERE main."Agents"."Archive" = \'0\' AND main."Agents"."Type" = \'sub_agent\' AND sale_agent."Meta"."Option" = \'Agent_ID\' ';
        if ($data['session']['account_type'] == "agent" || $data['session']['account_type'] == "external_agent") {
            $SQL .= ' AND main."Agents"."ParentID" = ' . $data['session']['id'] . ' ';
        }

        if ($data['session']['domainid'] == 0) {
            $SQL .= '';
        } else {
            $SQL .= ' AND main."Agents"."WebsiteDomain" = ' . $data['session']['domainid'] . ' ';
        }
        $SQL .= '  ORDER BY main."Agents"."FullName" ASC ';


//        if ($data['session']['type'] == "agent") {
//            $where = array("Archive" => "0", "Type" => "agent","ParentID" => $data['session']['id']);
//        } else {
//            $where = array("Archive" => "0", "Type" => "sub_agent");
//        }
//        $Crud = new Crud();
//
//        $table = 'main."Agents"';
//        $order = array("FullName" => "ASC");
//        $records = $Crud->ListRecords($table, $where, $order);

//         echo $SQL; exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListAgentsExceptExternal()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT * FROM main."Agents" WHERE "ParentID" = \'0\' AND "Archive" = \'0\' AND "Type" != \'external_agent\'';
        if ($session['domainid'] == 0) {
            $SQL .= '';
        } else {
            $SQL .= ' AND "WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        }


        $SQL .= ' ORDER BY "FullName"  ASC';

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public
    function ListExternalAgents()
    {
        /*$Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $table = 'main."Agents"';
        $order = array("FullName" => "ASC");
        if ($data['session']['domainid'] == 0) {
            $where = array("Archive" => "0", "Type" => "external_agent");
        } else {
            $where = array("Archive" => "0", "Type" => "external_agent", "WebsiteDomain" => $data['session']['domainid']);
        }

        $records = $Crud->ListRecords($table, $where, $order);

        return $records;*/

        $data = $this->data;
        $session = session();
        $session = $session->get();

        //$Agents = HierarchyUsers($session['id']);

        $SQL = '';
        $Crud = new Crud();
        $SQL .= 'SELECT main."Agents".* 
                FROM main."Agents" WHERE main."Agents"."Archive" = 0 AND  main."Agents"."Type" = \'external_agent\' 
                 ';
        //$SQL .= 'AND main."Agents"."ParentID" IN (' . $Agents . ') ';
        if ($session['domainid'] != 0) {
            $SQL .= 'AND main."Agents"."WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        } else {
        }
        $SQL .= 'ORDER BY main."Agents"."FullName" ASC  ';
        // echo $SQL;exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListExternalAgentsAndB2B()
    {
        /*$Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $table = 'main."Agents"';
        $order = array("FullName" => "ASC");
        if ($data['session']['domainid'] == 0) {
            $where = array("Archive" => "0", "Type" => "external_agent");
        } else {
            $where = array("Archive" => "0", "Type" => "external_agent", "WebsiteDomain" => $data['session']['domainid']);
        }

        $records = $Crud->ListRecords($table, $where, $order);

        return $records;*/

        $data = $this->data;
        $session = session();
        $session = $session->get();

        //$Agents = HierarchyUsers($session['id']);

        $SQL = '';
        $Crud = new Crud();
        $SQL .= 'SELECT main."Agents".* 
                FROM main."Agents" WHERE main."Agents"."Archive" = 0 
                AND (main."Agents"."Type" = \'external_agent\' OR main."Agents"."Type" = \'agent\') 
                
                 ';
        //$SQL .= 'AND main."Agents"."ParentID" IN (' . $Agents . ') ';
        if ($session['domainid'] != 0) {
            $SQL .= 'AND main."Agents"."WebsiteDomain" = \'' . $session['domainid'] . '\' ';
        } else {
        }
        $SQL .= 'ORDER BY main."Agents"."FullName" ASC  ';
        // echo $SQL;exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListB2BAgents()
    {
        $Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $table = 'main."Agents"';
        $order = array("FullName" => "ASC");
        if ($data['session']['domainid'] == 0) {
            $where = array("Archive" => "0", "Type" => "agent");
        } else {
            $where = array("Archive" => "0", "Type" => "agent", "WebsiteDomain" => $data['session']['domainid']);
        }

        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListInActiveAgents()
    {
        $Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $table = 'main."Agents"';
        $order = array("FullName" => "ASC");
        if ($data['session']['domainid'] == 0) {
            $where = array("Archive" => "0", "Status" => "InActive");
        } else {
            $where = array("Archive" => "0", "Status" => "InActive", "WebsiteDomain" => $data['session']['domainid']);
        }

        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListActiveAgents()
    {
        $Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $table = 'main."Agents"';
        $order = array("FullName" => "ASC");
        if ($data['session']['domainid'] == 0) {
            $where = array("Archive" => "0", "Status" => "Active");
        } else {
            $where = array("Archive" => "0", "Status" => "Active", "WebsiteDomain" => $data['session']['domainid']);
        }

        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListSubAgentssssssss($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("ParentID" => $ID);
        $order = array("FullName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }


    public
    function ListSubAgentss($ID)
    {
        $data = $this->data;
        $session = session();
        $session = $session->get();

        $SQL = '';
        $Crud = new Crud();
        $SQL .= 'SELECT main."Agents".* 
                FROM main."Agents"
                 ';

        $Agents = HierarchyUsers($session['id']);
        $SQL .= ' WHERE main."Agents"."ParentID" IN (' . $Agents . ') ';


        $SQL .= 'ORDER BY main."Agents"."FullName" ASC  ';
        // echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function AgentsProfile($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }


    public
    function GetPackage($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'packages."Packages"';
        $where = array("AgentUID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function AgentsProfileFiles($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."AgentFiles"';
        $where = array("AgentID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }

    public
    function AllAgentList()
    {
        $data = $this->data;
        $Crud = new Crud();
        $session = session();
        $data['session'] = $session->get();

        $SQL = 'SELECT * FROM main."Agents" WHERE "Archive" = \'0\' ';

//        $Agents = GetAllAgents($data['session']['agent_id']);
//        $SQL .= ' AND "UID" IN (' . $Agents . ') ';


        if ($data['session']['account_type'] == 'mis') {
        } else {
            $AgentUIDS = HierarchyUsers($data['session']['id']);
            $SQL .= '  AND "UID" IN (' . $AgentUIDS . ') ';
        }

        if ($data['session']['domainid'] == 0) {
            //$SQL .= ' AND "Archive" = 0 ';
        } else {
            $SQL .= ' AND "WebsiteDomain" = \'' . $data['session']['domainid'] . '\' ';
        }
        $SQL .= ' ORDER BY "FullName" ASC ';
        //echo $SQL;exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

//    public
//    function DeleteHotels($UID)
//    {
//
//
//        $table = 'packages."HotelImage"';
//        $where = array("HotelID" => $GetHotelID);
//        $imgdata['DeleteMetas'] = $Crud->ListRecords($table, $where);
//        $Crud->DeleteRecord($table, $where);
////
////        print_r($imgdata['DeleteMetas']);
//
//        $where = array("UID" => $UID);
//        if ($Crud->UpdateRecord($MainTable, $record, $where)) {
//            $response['status'] = "success";
//            $tables = 'uploads."Files"';
//            foreach ($imgdata['DeleteMetas'] as $item) {
//                $wheres = array("UID" => $item['ImageID']);
//                $Crud->DeleteRecord($tables, $wheres);
//            }
//        } else {
//            $response['status'] = "fail";
//        }
//        echo json_encode($response);
//    }

    public
    function DeleteAgents($UID)
    {

        $Crud = new Crud();
        $MainTable = 'main."Agents"';
        $record['Archive'] = "1";
        $wher = array("UID" => $UID);
        $data['records'] = $Crud->SingleRecord($MainTable, $wher);
        $GetAgentID = $data['records']['UID'];

        $table = 'main."AgentFiles"';
        $where = array("AgentID" => $GetAgentID);
        $imgdata['Delete'] = $Crud->ListRecords($table, $where);
        $Crud->DeleteRecord($table, $where);

        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($MainTable, $record, $where)) {
            $response['status'] = "success";
            $tables = 'uploads."Files"';
            foreach ($imgdata['Delete'] as $item) {
                $wheres = array("UID" => $item['FileID']);
                $Crud->DeleteRecord($tables, $wheres);
            }
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function SystemUserFormSubmit($Email, $Password, $Captchas, $Year)
    {
        $MainModel = new Main();
        $user_types = $MainModel->UserType(); //print_r($user_types);

        $session = session();
        $response = array();
        $Crud = new Crud();

        $where = array("UID" => $Year);
        $Dates = $Crud->SingleRecord('main."UmrahCalender"', $where);

        $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
        $DomainID = $Crud->SingleRecord('websites."Domains"', $where);

        $where = array("Email" => $Email, "Password" => $Password, "Archive" => "0");
        $Agent = $Crud->SingleRecord('main."Agents"', $where);

        $where = array("Name" => $Agent['Domain']);
        $AgentDomain = $Crud->SingleRecord('websites."Domains"', $where);

        $SQL = '';
        $SQL .= 'SELECT "main"."Agents".*
                 FROM "main"."Agents"
                 WHERE "main"."Agents"."Email" = \'' . $Email . '\' AND "main"."Agents"."Password" = \'' . $Password . '\'
                 AND "main"."Agents"."Archive" = 0  ';

        if ($AgentDomain['UID']) {
            $SQL .= 'AND "main"."Agents"."WebsiteDomain" IN (' . $Agent['WebsiteDomain'] . ',' . $AgentDomain['UID'] . ')';
        } else {
            $SQL .= 'AND "main"."Agents"."WebsiteDomain" = ' . $DomainID['UID'] . ' ';
        }

        //echo $SQL;
        $AgentR = $Crud->ExecuteSQL($SQL);
        $AgentRecords = $AgentR[0];

        $where = array("Email" => $Email, "Password" => $Password, "Archive" => "0", "DomainID" => $DomainID['UID']);
        $UsersRecords = $Crud->SingleRecord('main."Users"', $where);

        $SaleAgentwhere = array("Email" => $Email, "Password" => $Password, "Archive" => "0", "WebsiteDomain" => $DomainID['UID']);
        $SaleAgentRecords = $Crud->SingleRecord('sale_agent."Agents"', $SaleAgentwhere);

        if ($Captchas['LoginCaptcha'] == $Captchas['InputLoginCaptcha']) {

            //echo json_encode($UsersRecords); exit;
            if ($Email == $UsersRecords['Email'] && $Password == $UsersRecords['Password']) {
                $newdata = array(
                    'id' => $UsersRecords['UID'],
                    'account_type' => 'mis',
                    'mis_type' => 'main',
                    'type' => $UsersRecords['UserType'],
                    'agent_id' => $UsersRecords['AgentID'],
                    'parent_id' => '0',
                    'name' => $UsersRecords['FullName'],
                    'profile' => $UsersRecords,
                    'start_date' => $Dates['StartDate'],
                    'end_date' => $Dates['EndDate'],
                    'logged_type' => 'user',
                    'logged_in' => TRUE
                );
                $session->set($newdata);
                $Crud->UpdateRecord('main."Users"', array('LastLoginDetails' => date("Y-m-d H:i:s")), array('UID' => $UsersRecords['UID']));
                $Crud->Track("Login", $UsersRecords['FullName'] . ' Login as "' . $user_types[$UsersRecords['UserType']] . '" in system at "' . date("d M, Y h:i:s") . '"');
                $response['status'] = "success";
                $response['message'] = "You are successfully logged as " . $user_types[$UsersRecords['UserType']];

            } else if ($Email == $AgentRecords['Email'] && $Password == $AgentRecords['Password']) {

                $newdata = array(
                    'id' => $AgentRecords['UID'],
                    'account_type' => $AgentRecords['Type'],
                    'mis_type' => 'other',
                    'type' => 'admin',
                    'agent_id' => $AgentRecords['UID'],
                    'parent_id' => $AgentRecords['ParentID'],
                    'name' => $AgentRecords['FullName'],
                    'profile' => $AgentRecords,
                    'start_date' => $Dates['StartDate'],
                    'end_date' => $Dates['EndDate'],
                    'logged_type' => 'agent',
                    'logged_in' => TRUE
                );
                $session->set($newdata);
                $Crud->UpdateRecord('main."Agents"', array('LastLoginDetails' => date("Y-m-d H:i:s")), array('UID' => $AgentRecords['UID']));
                $Crud->Track("Login", $AgentRecords['FullName'] . ' Login as "' . $AgentRecords['Type'] . ' Agent" in system at "' . date("d M, Y h:i:s") . '"');
                $response['status'] = "success";
                $response['logged_id'] = $AgentRecords['UID'];
                $response['message'] = "You are successfully logged as (" . $AgentRecords['FullName'] . ") Agent";
            } else if ($Email == $SaleAgentRecords['Email'] && $Password == $SaleAgentRecords['Password']) {
                $newdata = array(
                    'id' => $SaleAgentRecords['UID'],
                    'account_type' => 'sale_agent',
                    'mis_type' => 'other',
                    'type' => 'admin',
                    'agent_id' => $SaleAgentRecords['UID'],
                    'parent_id' => $SaleAgentRecords['ParentID'],
                    'name' => $SaleAgentRecords['FullName'],
                    'profile' => $SaleAgentRecords,
                    'start_date' => $Dates['StartDate'],
                    'end_date' => $Dates['EndDate'],
                    'logged_type' => 'sale_agent',
                    'logged_in' => TRUE
                );
                $session->set($newdata);
                $Crud->UpdateRecord('sale_agent."Agents"', array('LastLoginDetails' => date("Y-m-d H:i:s")), array('UID' => $SaleAgentRecords['UID']));
                $Crud->Track("Login", $SaleAgentRecords['FullName'] . ' Login as "Sale Agent" in system at "' . date("d M, Y h:i:s") . '"');
                $response['status'] = "success";
                $response['message'] = "You are successfully logged as (" . $SaleAgentRecords['FullName'] . ") Sale Agent";
            } else {
                $response['status'] = "fail";
                $response['message'] = "Invalid Login and Password, Please Try again...";
                $response['SQL'] = $SQL;
            }
            //print_r($response);exit;
        } else {
            $response['status'] = "fail";
            $response['message'] = "Kindly Type Captcha Again..";

        }

        echo json_encode($response);
    }


    public function AgentFormSubmit($records, $UID, $FilesData, $SalesAgent, $Type, $Logo)
    {
        $data = $this->data;
        $Accesslevel = new AccessLevel();
        $Crud = new Crud();
        $Users = new Users();
        $table = 'main."Agents"';

        ////////////////// Duplicate Email Check
        if ($UID == 0) {
            $email = $Crud->SingleRecord($table, array("Email" => $records['Email']));
            if (isset($email['UID']) && $email['UID'] > 0) {
                $response['status'] = "fail";
                $response['message'] = "Duplicate Agent's Email...";
            } else {

                $Crud->Track("Agent", 'New Agent "' . $records['FullName'] . '" added in system...');
                $records['Type'] = $Type;
                $records['Logo'] = $Logo;
                $recordID = $Crud->AddRecord($table, $records);
                $response['status'] = "success";
                $response['record_id'] = $recordID;
                $response['message'] = "Agent Successfully Added...";

                if ($Type == 'agent') {
                    $AgentAccessLevel = $Accesslevel->agentAccessLevel();
                } else if ($Type == 'external_agent') {
                    $AgentAccessLevel = $Accesslevel->externalAgentAccessLevel();
                } else if ($Type == 'sub_agent') {
                    $AgentAccessLevel = $Accesslevel->subagentAccessLevel();
                }
                $Users->AgentsAccessLevel($response['record_id'], $AgentAccessLevel, $Type);

                if (isset($FilesData)) {
                    $table = 'main."AgentFiles"';
                    $images = $FilesData['AttachFiles'];
                    $FileDescription = $FilesData['FileDescription'];

                    if (!empty($images[0])) {
                        for ($a = 0; $a < count($FileDescription); $a++) {
                            $record = array();
                            $record['AgentID'] = $recordID;
                            $record['FileDescription'] = $FileDescription[$a];
                            $record['FileID'] = $images[$a];
                            $Crud->AddRecord($table, $record);
                        }
                    }
                }
                if (isset($SalesAgent)) {
                    $table = 'sale_agent."Meta"';
                    $record = array();
                    $record['SaleAgentID'] = $SalesAgent;
                    $record['Option'] = 'Agent_ID';
                    $record['Value'] = $recordID;
                    $Crud->AddRecord($table, $record);
                }


            }
        } else {

            $Crud->Track("Agent", 'Agent "' . $records['FullName'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            if ($Logo != 0) {
                $records['Logo'] = $Logo;
            }
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Agent Updated...";

            if (isset($FilesData)) {
                $table = 'main."AgentFiles"';
                $images = $FilesData['AttachFiles'];
                $FileDescription = $FilesData['FileDescription'];
                if (!empty($images[0])) {
                    for ($a = 0; $a < count($FileDescription); $a++) {
                        $record = array();
                        $record['AgentID'] = $UID;
                        $record['FileDescription'] = $FileDescription[$a];
                        $record['FileID'] = $images[$a];
                        $Crud->AddRecord($table, $record);
                    }
                }
            }

            if (isset($SalesAgent)) {
                $table = 'sale_agent."Meta"';
                $where = array("Value" => $UID);
                $Crud->DeleteRecord($table, $where);

                $record = array();
                $record['SaleAgentID'] = $SalesAgent;
                $record['Option'] = 'Agent_ID';
                $record['Value'] = $UID;
                $Crud->AddRecord($table, $record);
            }

        }


        echo json_encode($response);
    }


    public function B2BRegistrationFormSubmit($records, $Captchas)
    {
        $Crud = new Crud();
        $this->MainModel = new Main();
        $MainMODEL = $this->MainModel;

        if ($Captchas['RegisterCaptcha'] == $Captchas['ForgetRegisterCaptcha']) {

            $AdminSettingsTable = 'main."AdminSettings"';
            $where = array();
            $AdminSetting = $Crud->ListRecords($AdminSettingsTable, $where);
            $settings = array();
            foreach ($AdminSetting as $val) {
                $settings[$val['Key']][] = $val;
                if ($val['Key'] == 'sales_email') {
                    $SalesEmail = $val['Description'];
                }
                if ($val['Key'] == 'site_name') {
                    $SiteName = $val['Description'];
                }
            }


            $table = 'main."Agents"';
            if (isset($records['Email'])) {
                $email = $Crud->SingleRecord($table, array("Email" => $records['Email']));
                if (isset($email['UID']) && $email['UID'] > 0) {
                    $response['status'] = "fail";
                    $response['message'] = "Email Already Taken...";
                } else {
                    $Crud->Track("Agent", 'New B2B "' . $records['FullName'] . '" requested to be added in system...');
                    $Crud->AddRecord($table, $records);
                    $response['status'] = "success";
                    $response['message'] = "Kindly Check Your Email For Further Process.";

                    $html = '
                        <h3>B2B Account Registration</h3>
                         <p>Hi <b>' . $records['FullName'] . '</b><br>
                         We got your details and our team will look into it and we will get back to you soon. <br>
                         After confirmation we will send you an email with credentials so you will be able to login in your account.<br>                                                 
                         Thank You For Choosing Us. <br>                                            
                         Best Regards<br>
                         ' . $SiteName . ' Team<br>         
                         </p>';
                    $MainMODEL->SendEmail($records['Email'], "Account Details", $html);

                    $htmls = '
                        <h3>Request For B2B Account Registration</h3>
                         <p>' . $records['FullName'] . ' Requested for B2B registration with Email : ' . $records['Email'] . ' And Phone Number: ' . $records['PhoneNumber'] . ' <br>
                         From Country : ' . CountryName($records['CountryID']) . ' And City : ' . CityName($records['CityID']) . '  <br>
                         Kindly Review it and if it is approved kindly generate password. And send him back valid credentials. <br>  
                         
                         Thankyou!<br>                                     
                         </p>';

                    $MainMODEL->SendEmail($SalesEmail, "Account Registration Request", $htmls);
                }
            } else {
                $response['status'] = "fail";
                $response['message'] = "Kindly Enter Valid Email...";
            }
        } else {
            $response['status'] = "fail";
            $response['message'] = "Kindly Type Captcha Again..";
        }
        echo json_encode($response);
    }

    public function ExternalAgentFormSubmit($records, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."ExternalAgent"';

        if ($UID == 0) {
            $Crud->Track("Agent", 'External Agent "' . $records['Name'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "External Agent Successfully Added...";
        } else {
            $Crud->Track("Agent", 'External Agent "' . $records['Name'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "External Agent Updated...";
        }

        echo json_encode($response);
    }

    public
    function ExternalAgentsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."ExternalAgent"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function AllExternalAgentsWithChildData()
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("Type" => 'external_agent');
        $EXTrecords = $Crud->ListRecords($table, $where);
        $final = array();
        foreach ($EXTrecords as $EXTrecord) {
            $final[] = $EXTrecord['UID'];
            $SUBrecords = $this->ListSubAgentss($EXTrecord['UID']);
            foreach ($SUBrecords as $SUBrecord) {
                $final[] = $SUBrecord['UID'];
            }
        }

        return array_unique($final);
    }

    public
    function DeleteExternalAgents($UID)
    {
        $Crud = new Crud();
        $table = 'main."ExternalAgent"';
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
    function DeleteAgentFiles($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."AgentFiles"';
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
    function DeleteAgentLogo($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("Logo" => $UID);
        $data['records'] = $Crud->SingleRecord($table, $where);
        $record['Logo'] = '0';
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
            $tables = 'uploads."Files"';
            $wheres = array("UID" => $data['records']['Logo']);
            $Crud->DeleteRecord($tables, $wheres);

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function CountAgents($Type = 'all', $Status = '')
    {

        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $DomainData = $Crud->SingleRecord('websites."Domains"', array('UID' => $session['domainid']));

        $SQL = ' SELECT COUNT( main."Agents"."UID" ) AS "TotalAgents" 
                FROM main."Agents" WHERE  main."Agents"."Archive" = 0 ';
        if (isset($DomainData['UID']) && $DomainData['UID'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = ' . $DomainData['UID'] . ' ';
        }
        if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND main."Agents"."UID" IN (' . $AgentUIDS . ') ';
        }
        if ($Type != 'all') {
            $SQL .= ' AND main."Agents"."Type" = \'' . $Type . '\' ';
        }
        if ($Status != '') {
            $SQL .= ' AND main."Agents"."Status" = \'' . $Status . '\' ';
        }
        $AgentsRecord = $Crud->ExecuteSQL($SQL);

        return $AgentsRecord[0]['TotalAgents'];
    }

}
