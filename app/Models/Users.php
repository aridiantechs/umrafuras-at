<?php namespace App\Models;

use App\Controllers\Home;
use App\Models\Main;
use App\Models\Crud;
use CodeIgniter\Model;
use Faker\Guesser\Name;
use phpDocumentor\Reflection\Types\Array_;


class Users extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;




    }

    public function GetUser($uid)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Users"';
        $where = array("Archive" => "0", "UID" => $uid);
        $record = $Crud->SingleRecord($table, $where);

        return $record;

    }

    public function GetAllUsersData($uid)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Users"';
        $where = array("Archive" => "0", "UID" => $uid);
        $record = $Crud->SingleRecord($table, $where);

        return $record;

    }

    public
    function ListUsers()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = 0;

        }
        $Crud = new Crud();
        /*$table = 'main."Users"';
        $where = array("Archive" => "0", "AgentID" => $AgentID);
        if($data['session']['domainid']>0){
            $where['DomainID'] = $data['session']['domainid'];
        }

         $records = $Crud->ListRecords($table, $where, array("FullName" => "ASC"));*/

        $SQL = 'SELECT "main"."Users".*,
                        websites."Domains"."FullName" AS "WebsiteName",
                        main."Agents"."FullName" AS "AgentName",
                        main."Agents"."Type" AS "AgentType"
        
                FROM "main"."Users"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = "main"."Users"."DomainID"
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = main."Users"."AgentID"
                WHERE "main"."Users"."Archive"=0';
        if ($data['session']['domainid'] > 0) {
            $SQL .= ' AND  "main"."Users"."DomainID" =  ' . $data['session']['domainid'] . ' ';
        }
        if ($data['session']['type'] != 'admin' || $data['session']['logged_type'] != 'user') {
            $SQL .= ' AND  "main"."Users"."UserType" != \'admin\' ';
        }
        $SQL .= ' ORDER BY "main"."Users"."FullName" ASC';
        // echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListSalesUsers()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = 0;

        }
        $Crud = new Crud();
        /*$table = 'main."Users"';
        $where = array("Archive" => "0", "AgentID" => $AgentID);
        if($data['session']['domainid']>0){
            $where['DomainID'] = $data['session']['domainid'];
        }

         $records = $Crud->ListRecords($table, $where, array("FullName" => "ASC"));*/

        $SQL = 'SELECT "main"."Users".*,
                        websites."Domains"."FullName" AS "WebsiteName",
                        main."Agents"."FullName" AS "AgentName",
                        main."Agents"."Type" AS "AgentType"
        
                FROM "main"."Users"
                LEFT JOIN websites."Domains" ON websites."Domains"."UID"  = "main"."Users"."DomainID"
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = main."Users"."AgentID"
                WHERE "main"."Users"."Archive"= 0 AND "main"."Users"."UserType" = \'sale-officer\'  ';
        if ($data['session']['domainid'] > 0) {
            $SQL .= ' AND  "main"."Users"."DomainID" =  ' . $data['session']['domainid'] . ' ';
        }
        if ($data['session']['type'] != 'admin' || $data['session']['logged_type'] != 'user') {
            $SQL .= ' AND  "main"."Users"."UserType" != \'admin\' ';
        }
        $SQL .= ' ORDER BY "main"."Users"."FullName" ASC';
        // echo $SQL;exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }
    public
    function ListNotifications()
    {
        $data = $this->data;

        $session = session();
        $session = $session->get();
        $Domain = $session['domainid'];

        $Crud = new Crud();

        $SQL = 'SELECT "main"."UserNotifications".*        
                FROM  "main"."UserNotifications"  ';
        if ($Domain > 0) {
            $SQL .= ' WHERE  "main"."UserNotifications"."DomainID" =  ' . $Domain . ' AND "main"."UserNotifications"."ReadFlag" = 0 ';
        }
        $SQL .= ' ORDER BY "main"."UserNotifications"."SystemDate" DESC LIMIT 15';
         $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function ListAgents()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == "agent" || $data['session']['account_type'] == "external_agent" || $data['session']['account_type'] == "sub_agent") {
            $AgentID = $data['session']['id'];
        } else {
            $AgentID = 0;

        }
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("Archive" => "0", "UID" => $AgentID);
        $records = $Crud->SingleRecord($table, $where);

        return $records;

    }


    public
    function UpdateUserTimeTracks($userid, $track_type, $stopid)
    {
//        echo date("h:i:s");
//        exit;
        $Crud = new Crud();

        $record['UserID'] = $userid;
        $record['TrackDate'] = date("Y-m-d");
        $record['ActivityType'] = $track_type;
        $record['ActivityStart'] = date("Y-m-d H:i:s");
        $record['ActivityStop'] = null;
        //echo $stopid; print_r($record);
        $table = 'main."UserTimetrack"';
        if ($stopid > 0) {
            $Crud->UpdateRecord($table, array("ActivityStop" => date("Y-m-d H:i:s")), array("UID" => $stopid));
            $response['status'] = "success";
            $response['message'] = "Activity Closed Successfully";
        } else {
            $Crud->AddRecord($table, $record);
            $response['status'] = "success";
            $response['message'] = "Activity Started Successfully";
        }
        echo json_encode($response);
    }


    public
    function ListSaleAgents()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['account_type'] == "sale_agent") {
            $AgentID = $data['session']['id'];
        } else {
            $AgentID = 0;

        }
        $Crud = new Crud();
        $table = 'sale_agent."Agents"';
        $where = array("Archive" => "0", "UID" => $AgentID);
        $records = $Crud->SingleRecord($table, $where);

        return $records;

    }

    public
    function UsersProfile($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Users"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function UsersMeta($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."UsersMeta"';
        $where = array("UserUID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }

    public
    function SaleAgentUsersType($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sale_agent."Agents"';
        $where = array("UserUID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }

    public
    function ExternalAgentUsersType($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("UserUID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }


    public
    function DeleteUser($UID)
    {

        $Crud = new Crud();
        $table = 'main."Users"';
        $record['Archive'] = "1";
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public function UserFormSubmit($records, $UID, $statuses)
    {
        $data = $this->data;
        $Accesslevel = new AccessLevel();
        $Crud = new Crud();
        $Home = new Home();
        $table = 'main."Users"';

        ////////////////// Duplicate Email Check
        if ($UID == 0) {
            $email = $Crud->SingleRecord($table, array("Email" => $records['Email']));
            if (isset($email['UID']) && $email['UID'] > 0) {
                $response['status'] = "fail";
                $response['message'] = "Duplicate User's Email...";
            } else {
                $Crud->Track("System Users", 'New user "' . $records['FullName'] . '" added in system...');
                $UID = $Crud->AddRecord($table, $records);

                if ($response['record_id'] = $UID) {
                    $userType = $records['UserType'];
                    $Home->Accesslvelsssssss($UID, $userType);
                    $response['status'] = "success";
                    $response['message'] = "User Successfully Added...";
                    $response['user_insert_id'] = $UID;
                    $response['user_type'] = $userType;

                } else {
                    $response['status'] = "fail";
                    $response['message'] = "Data Didn't Submitted Correctly";
                }

            }
        } else {

            $Crud->Track("System Users", 'User "' . $records['FullName'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "User Updated...";
        }

        $Metas = $statuses['UserStatuses'];
        if (isset($Metas)) {
            $where = array("UserUID" => $UID);
            $Crud->DeleteRecord('main."UsersMeta"', $where);
            foreach ($Metas as $value) {
                $recrd = array();
                $recrd['UserUID'] = $UID;
                $recrd['Option'] = $records['UserType'];
                $recrd['Value'] = $value;
                $Crud->AddRecord('main."UsersMeta"', $recrd);
            }
        }

        echo json_encode($response);
    }

    public function OperatorFormSubmit($record, $UID, $Logo)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Operators"';

        if ($UID == 0) {
            ////////////////// Duplicate Email Check
            $email = $Crud->SingleRecord($table, array("Email" => $record['Email']));
            if (isset($email['UID']) && $email['UID'] > 0) {
                $response['status'] = "fail";
                $response['message'] = "Duplicate Operator's Email...";
            } else {

                $Crud->Track("Operator", 'New Operator "' . $record['FullName'] . '" added in system...');
                $record['Logo'] = $Logo;
                $recordID = $Crud->AddRecord($table, $record);
                $response['status'] = "success";
                $response['record_id'] = $recordID;
                $response['message'] = "Operator Successfully Added...";
            }
        } else {

            $Crud->Track("Operator", 'Operator "' . $record['FullName'] . '" Updated in system...');
            $where = array("UID" => $UID);
            if ($Logo != 0) {
                $record['Logo'] = $Logo;
            }
            $Crud->UpdateRecord($table, $record, $where);

            $response['status'] = "success";
            $response['message'] = "Operator Successfully Updated...";
        }

        echo json_encode($response);
    }

    public function DomainsUpdateFormSubmit($record, $UID, $Logo)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'websites."Domains"';

        $where = array("UID" => $UID);
        if ($Logo != 0) {
            $record['Logo'] = $Logo;
        }
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
            $response['message'] = "Domains Successfully Updated...";
        } else {
            $response['status'] = "fail";
            $response['message'] = "Data Didn't Submitted Successfully...";
        }


        echo json_encode($response);
    }

    public
    function DeleteOperators($UID)
    {
        $Crud = new Crud();
        $table = 'main."Operators"';
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
    function ListOperators()
    {

        $data = $this->data;

        $session = session();
        $session = $session->get();
        $DomainID = $session['domainid'];

        $Crud = new Crud();
        $table = 'main."Operators"';
        if ($DomainID > 0) {
            $where = array("Archive" => "0");
        } else //        {$where = array("Archive" => "0","WebsiteDomain" => $session['domainid']);}
        {
            $where = array("Archive" => "0");
        }
        $order = array("CompanyName" => 'ASC');
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;


    }

    public
    function DeleteOperatorsLogo($UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Operators"';
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
    function OperatorsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Operators"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function DomainsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }


    public
    function ListExternalAgents()
    {
        $data = $this->data;

        $session = session();
        $session = $session->get();
        $DomainID = $session['domainid'];

        $Crud = new Crud();
        /*$table = 'main."Agents"';

        if ($DomainID > 0) {
            $where = array("Archive" => "0", "WebsiteDomain" => $DomainID, "Type" => "external_agent");
        } else {
            $where = array("Archive" => "0", "Type" => "external_agent");
        }
        $order = array("FullName" => 'ASC');
        $records = $Crud->ListRecords($table, $where, $order);*/
        $SQL = 'Select 
                main."Agents"."UID",
                main."Agents"."CountryID",
                main."Agents"."Type",
                main."Agents"."CityID",
                main."Agents"."FullName",
                main."Agents"."LastName",
                main."Agents"."IATALicense",
                main."Agents"."UmrahAgreement",
                main."Agents"."ContactPersonName",
                main."Agents"."PhoneNumber",
                main."Agents"."Email",
                main."Agents"."WebsiteDomain",
                packages."Packages"."Name" AS "PackageName",
                sale_agent."Agents"."FullName" as "ReferenceName" 
        FROM main."Agents"
        LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
        LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
        LEFT JOIN packages."Packages" ON packages."Packages"."AgentUID" = main."Agents"."UID"
        where main."Agents"."FullName" IS NOT NULL
        ';
        if ($DomainID > 0) {

            $SQL .= ' AND main."Agents"."Archive"=0 AND  main."Agents"."WebsiteDomain" =  ' . $DomainID . ' AND  main."Agents"."Type" =  \'external_agent\'';
        } else {
            $SQL .= ' AND main."Agents"."Archive"=0 AND  main."Agents"."Type" =  \'external_agent\'';
        }
        $SQL .= ' ORDER BY  main."Agents"."FullName" ASC';
        //echo nl2br($SQL);exit();
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function UpdateAccessLevel($userid, $accesslevels, $UserType)
    {
        $table = 'main."AccessLevel"';
        $CRUD = new Crud();
        $CRUD->DeleteRecord($table, array("UserID" => $userid));

        $DBRecords = array();
        foreach ($accesslevels as $accesslevelK => $accesslevelV) {
            if ($accesslevelV == 1) {
                $TEMP = array();
                $TEMP['SystemDate'] = date("Y-m-d H:i:s");
                $TEMP['UserID'] = $userid;
                $TEMP['AccessKey'] = $accesslevelK;
                $TEMP['Access'] = $accesslevelV;
                $TEMP['AccountType'] = $UserType;
                $DBRecords[] = $TEMP;
            }
        }

        //echo "<pre>"; print_r($DBRecords); exit;

        $db = db_connect();
        $db->db_debug = false;
        $db->table($table)->insertBatch($DBRecords, true);
        $db->close();
    }

    public function AgentsAccessLevel($id, $Agentdata = array(), $userType)
    {
        $db = db_connect();
        $table = 'main."AccessLevel"';
        $DBRecords = array();

        foreach ($Agentdata as $key) {
            $temp = array();
            $temp['SystemDate'] = date("Y-m-d H:i:s");
            $temp['UserID'] = $id;
            $temp['AccountType'] = $userType;
            $temp['AccessKey'] = $key;
            $temp['Access'] = 1;
            $DBRecords[] = $temp;

        }
        $db->db_debug = false;
        $db->table($table)->insertBatch($DBRecords, true);
        $db->close();
    }

    public function HomeNavigationCheck($id)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT * FROM "main"."AccessLevel" Where "UserID" = \'' . $id . '\' AND  "AccessKey" LIKE \'home%\'';
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public function AccessLevelKeysType($id, $usertype)
    {
        $Crud = new Crud();
        $sql = 'SELECT "AccessLevel"."AccessKey" FROM "main"."AccessLevel" WHERE "UserID" = \'' . $id . '\' AND "AccountType" = \'' . $usertype . '\'ORDER BY "AccessKey"';
        $records = $Crud->ExecuteSQL($sql);
        return $records;
    }


}
