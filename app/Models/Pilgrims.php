<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Api;

class Pilgrims extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $session = session();
        $session = $session->get();
        $this->data['session'] = $session;
    }

    public
    function ListPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['PilgrimSearchFilter'];
        //echo '<pre>';print_r($_POST);

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if ($session['AgentLogged']) {
            $Agents = HierarchyUsers($data['session']['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $Agents . ') ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }

        if (isset($_POST['PassportNumber']) && $_POST['PassportNumber'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $_POST['PassportNumber'] . '\' ';
        }

        if (isset($_POST['FullName']) && $_POST['FullName'] != '') {
            $SQL .= ' AND pilgrim."master"."FirstName" = \'' . $_POST['FullName'] . '\' ';
        }

        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';
        /*if($_POST['length'] != -1)
            $SQL .= 'limit '.$_POST['length'].' offset  '.$_POST['start'].'';*/
        //$this->db->limit($_POST['length'], $_POST['start']);
        //$records = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($session);
        //echo nl2br($SQL);exit();
        //return $records;
//        echo $SQL;
//        exit;
        return $SQL;
    }

    public
    function ListB2BPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", voucher."Pilgrim"."VoucherUID" as "VoucherID", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                INNER JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"  = pilgrim."master"."UID"            
                WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."AgentUID" IS NOT NULL
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($_POST['PassportNumber']) && $_POST['PassportNumber'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $_POST['PassportNumber'] . '\' ';
        }
        if (isset($_POST['FullName']) && $_POST['FullName'] != '') {
            $SQL .= ' AND pilgrim."master"."FirstName" = \'' . $_POST['FullName'] . '\' ';
        }
        if (isset($_POST['GroupCode']) && $_POST['GroupCode'] != '') {
            $SQL .= ' AND main."Groups"."FullName" = \'' . $_POST['GroupCode'] . '\' ';
        }

        if (isset($_POST['AgentName']) && $_POST['AgentName'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['AgentName'] . '\' ';
        }

        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= 'AND pilgrim."master"."AgentUID" IN ( 
                     SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                     WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )';
        }
        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';
        //   echo $SQL; exit;
        return $SQL;
    }


    public
    function ListB2CPlgrm()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['PilgrimSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."AgentUID" IS NULL
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if ($session['AgentLogged']) {
            $Agents = HierarchyUsers($data['session']['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $Agents . ') ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }

        if (isset($_POST['PassportNumber']) && $_POST['PassportNumber'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $_POST['PassportNumber'] . '\' ';
        }

        if (isset($_POST['FullName']) && $_POST['FullName'] != '') {
            $SQL .= ' AND pilgrim."master"."FirstName" = \'' . $_POST['FullName'] . '\' ';
        }

//        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
//            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
//        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }
        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';
        // echo $SQL; exit;
        return $SQL;
    }


    public
    function ListB2CPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['PilgrimSearchFilter'];
        //echo '<pre>';print_r($_POST);

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                WHERE pilgrim."master"."FirstName" IS NOT NULL 
                AND (pilgrim."master"."AgentUID" IS NULL OR pilgrim."master"."AgentUID" = 0)
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if ($session['AgentLogged']) {
            $Agents = HierarchyUsers($data['session']['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $Agents . ') ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
        if (isset($_POST['PassportNumber']) && $_POST['PassportNumber'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $_POST['PassportNumber'] . '\' ';
        }
        if (isset($_POST['FullName']) && $_POST['FullName'] != '') {
            $SQL .= ' AND pilgrim."master"."FirstName" = \'' . $_POST['FullName'] . '\' ';
        }

//        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
//            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
//        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';


        /*if($_POST['length'] != -1)
            $SQL .= 'limit '.$_POST['length'].' offset  '.$_POST['start'].'';*/
        //$this->db->limit($_POST['length'], $_POST['start']);
        //$records = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($session);
//        echo nl2br($SQL);exit();
        //return $records;

        return $SQL;
    }


    public function get_pilgrims_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->ListPilgrims();
        if ($_POST['length'] != -1)
            $SQL .= 'limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function get_b2c_pilgrims_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->ListB2CPilgrims();
        if ($_POST['length'] != -1)
            $SQL .= 'limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function get_b2b_pilgrims_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->ListB2BPilgrims();
        if ($_POST['length'] != -1)
            $SQL .= 'limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function get_b2c_plgrm()
    {

        $Crud = new Crud();
        $SQL = $this->ListB2CPlgrm();
        if ($_POST['length'] != -1)
            $SQL .= 'limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function count_pilgrimsfiltered()
    {
        $Crud = new Crud();
        $SQL = $this->ListPilgrims();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public function count_b2b_pilgrims_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListB2BPilgrims();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public function count_b2c_plgrm()
    {
        $Crud = new Crud();
        $SQL = $this->ListB2CPlgrm();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public function count_b2c_pilgrims_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListB2CPilgrims();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public
    function TotalListPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $PilgrimSearchFilter = $session['PilgrimSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                WHERE pilgrim."master"."FirstName" IS NOT NULL
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if ($session['AgentLogged']) {
            $Agents = HierarchyUsers($data['session']['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $Agents . ') ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }
//        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
//            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
//        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';

        $records = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($session);
        //echo nl2br($SQL);
        return count($records);
    }


    public
    function ListTotalCountPilgrimsData()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT count(DISTINCT( pilgrim."master"."UID" )) AS "TotalPilgrims"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
                WHERE pilgrim."master"."FirstName" IS NOT NULL';

        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND pilgrim."master"."Country" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['group']) && $_POST['group'] != '') {
            $SQL .= ' AND pilgrim."master"."GroupUID" = \'' . $_POST['group'] . '\' ';
        }

        if (isset($_POST['passport_number']) && $_POST['passport_number'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . trim($_POST['passport_number']) . '\' ';
        }

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        //$records = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($session);
        //echo $SQL;

        return $SQL;
    }

    public
    function ListPilgrimsData()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                WHERE pilgrim."master"."FirstName" IS NOT NULL ';

        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL .= ' AND pilgrim."master"."Country" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['agent']) && $_POST['agent'] != '') {
            $SQL .= ' AND main."Agents"."UID" = \'' . $_POST['agent'] . '\' ';
        }

        if (isset($_POST['group']) && $_POST['group'] != '') {
            $SQL .= ' AND pilgrim."master"."GroupUID" = \'' . $_POST['group'] . '\' ';
        }

        if (isset($_POST['passport_number']) && $_POST['passport_number'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . trim($_POST['passport_number']) . '\' ';
        }

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND  pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."FirstName" ASC  ';

        //$records = $Crud->ExecuteSQL($SQL);
        //echo '<pre>';print_r($session);
        //echo $SQL;

        return $SQL;
    }

    public
    function ListPilgrimsWithoutVoucher()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $InKSA = StatusCheckList();
        $InKSA = $InKSA['InKSA'];

        $PilgrimSearchFilter = $session['PilgrimSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"             
                WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."master"."UID" 
                IN (
                    SELECT "travel"."PilgrimID" FROM pilgrim."travel"
                )
                AND pilgrim."master"."UID" NOT IN (Select voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($PilgrimSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PilgrimSearchFilter['nationality']) && $PilgrimSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $PilgrimSearchFilter['nationality'] . '\' ';
        }

        $SQL .= ' ORDER BY pilgrim."master"."FirstName" DESC  ';

        $records = $Crud->ExecuteSQL($SQL);
        //echo $SQL;exit();
        return $records;
    }

    public
    function ListB2C()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $B2CSearchFilter = $session['B2CSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName",
                pilgrim."auth"."Email" as "PilgrimEmail",pilgrim."auth"."Password" as "PilgrimPassword",pilgrim."auth"."DomainID" as "PilgrimDomain"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                WHERE  pilgrim."master"."WebsiteDomain" = ' . (($session['domainid'] == 0) ? '0' : $session['domainid']) . '
                 ';

        if (isset($B2CSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($B2CSearchFilter['name']) . '%\' ';
        }

        if (isset($B2CSearchFilter['nationality']) && $B2CSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $B2CSearchFilter['nationality'] . '\' ';
        }

        //   echo $SQL;
        $SQL .= 'ORDER BY pilgrim."master"."FirstName" DESC ';

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function WithoutVoucherArrivalPax()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName",
                pilgrim."auth"."Email" as "PilgrimEmail",pilgrim."auth"."Password" as "PilgrimPassword",pilgrim."auth"."DomainID" as "PilgrimDomain"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                WHERE  pilgrim."master"."WebsiteDomain" = ' . (($session['domainid'] == 0) ? '0' : $session['domainid']) . '
                 ';

        $SQL .= 'ORDER BY pilgrim."master"."FirstName" DESC ';

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function ListB2CWithEmailPassword()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $B2CSearchFilter = $session['B2CSearchFilter'];
        $SessionFilters = $session['B2CPilgrimsSessionFilters'];

        $SQL = 'SELECT pilgrim."master".*, 
                    main."Groups"."FullName" as "GroupName", main."Agents"."CountryID" as "AgentCountryID",main."Agents"."FullName" as "AgentName",websites."Domains"."FullName" as "WebsiteName",
                pilgrim."auth"."Email" as "PilgrimEmail",pilgrim."auth"."Password" as "PilgrimPassword",pilgrim."auth"."DomainID" as "PilgrimDomain"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                LEFT JOIN websites."Domains" ON pilgrim."auth"."DomainID"  = websites."Domains"."UID" 
                WHERE /*  pilgrim."auth"."Password"  IS NOT NULL AND pilgrim."auth"."Email" IS NOT NULL AND */ 
                      pilgrim."master"."AgentUID" = 0
              ';


        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        if (isset($B2CSearchFilter['name'])) {
            $SQL .= ' AND LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($B2CSearchFilter['name']) . '%\' ';
        }
        if (isset($B2CSearchFilter['nationality']) && $B2CSearchFilter['nationality'] != '') {
            $SQL .= ' AND pilgrim."master"."Nationality" = \'' . $B2CSearchFilter['nationality'] . '\' ';
        }
        if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        /** Filter With Session Start */

        if (isset($SessionFilters['pilgrim']) && trim($SessionFilters['pilgrim']) != '') {
            $SQL .= ' AND CONCAT(LOWER(pilgrim."master"."FirstName"),\' \',LOWER(pilgrim."master"."LastName")) LIKE \'%' . strtolower($SessionFilters['pilgrim']) . '%\' ';
        }

        if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $SessionFilters['ppt_no'] . '\' ';
        }

        if (isset($SessionFilters['pilgrim_status']) && trim($SessionFilters['pilgrim_status']) != '') {
            $SQL .= ' AND LOWER(REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \')) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim_status'])) . '%\' ';
        }
        /** Filter With Session Ends */

        $SQL .= '  ORDER BY pilgrim."master"."FirstName" DESC  ';
        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;
    }

    public
    function ListAllPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."CountryID" as "AgentCountryID",main."Agents"."FullName" as "AgentName",websites."Domains"."FullName" as "WebsiteName",
                pilgrim."auth"."Email" as "PilgrimEmail",pilgrim."auth"."Password" as "PilgrimPassword",pilgrim."auth"."DomainID" as "PilgrimDomain"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                LEFT JOIN websites."Domains" ON pilgrim."auth"."DomainID"  = websites."Domains"."UID" 
                WHERE pilgrim."master"."FirstName" IS NOT NULL AND pilgrim."auth"."Email" IS NOT NULL
              ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        } else if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }

        $SQL .= '  ORDER BY pilgrim."master"."FirstName" DESC  ';

        //  echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function CountAllB2BPilgrims(){

        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['B2bPilgrimsSessionFilters'];

        $SQL = 'SELECT count(pilgrim."master"."UID") AS "TotalB2bPilgrims"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                LEFT JOIN websites."Domains" ON pilgrim."auth"."DomainID"  = websites."Domains"."UID" 
                WHERE pilgrim."master"."FirstName" IS NOT NULL 
                /* AND pilgrim."auth"."Email" IS NOT NULL*/ 
                  AND pilgrim."master"."AgentUID" != 0
              ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $AgentUIDS . ') ';
        }
        /*if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        } else if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }*/

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
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

        if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $SessionFilters['ppt_no'] . '\' ';
        }

        if (isset($SessionFilters['pilgrim_status']) && trim($SessionFilters['pilgrim_status']) != '') {
            $SQL .= ' AND LOWER(REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \')) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim_status'])) . '%\' ';
        }
        /** Filter With Session Ends */

        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function ListAllB2BPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $SessionFilters = $session['B2bPilgrimsSessionFilters'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."CountryID" as "AgentCountryID",main."Agents"."FullName" as "AgentName",websites."Domains"."FullName" as "WebsiteName",
                pilgrim."auth"."Email" as "PilgrimEmail",pilgrim."auth"."Password" as "PilgrimPassword",pilgrim."auth"."DomainID" as "PilgrimDomain"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                LEFT JOIN pilgrim."auth" ON pilgrim."master"."UID"  = pilgrim."auth"."PilgrimID" 
                LEFT JOIN websites."Domains" ON pilgrim."auth"."DomainID"  = websites."Domains"."UID" 
                WHERE pilgrim."master"."FirstName" IS NOT NULL /* AND pilgrim."auth"."Email" IS NOT NULL*/ AND pilgrim."master"."AgentUID" != 0
              ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        if (isset($session['mis_type']) && $session['mis_type'] == 'other'
            && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $AgentUIDS . ') ';
        }
        /*if ($session['account_type'] == 'sale_agent') {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        } else if ($session['AgentLogged']) {
            $AgentsUIDs = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
        }*/

        /** Filter With Session Start */
        if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
            $SQL .= ' AND main."Agents"."CountryID" = \'' . $SessionFilters['country'] . '\' ';
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

        if (isset($SessionFilters['ppt_no']) && $SessionFilters['ppt_no'] != '') {
            $SQL .= ' AND pilgrim."master"."PassportNumber" = \'' . $SessionFilters['ppt_no'] . '\' ';
        }

        if (isset($SessionFilters['pilgrim_status']) && trim($SessionFilters['pilgrim_status']) != '') {
            $SQL .= ' AND LOWER(REPLACE(pilgrim."master"."CurrentStatus",\'-\',\' \')) LIKE  \'%' . strtolower(trim($SessionFilters['pilgrim_status'])) . '%\' ';
        }
        /** Filter With Session Ends */

        $SQL .= '  ORDER BY pilgrim."master"."FirstName" DESC  ';

        //$records = $Crud->ExecuteSQL($SQL);

        return $SQL;
    }

    public
    function ListCompletedPassportPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $PendingPassportPilgrimSearchFilter = $session['PendingPassportPilgrimSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName",
                ( SELECT COUNT("pilgrim"."attachments"."UID") FROM "pilgrim"."attachments" WHERE "pilgrim"."attachments"."PilgrimID" = "pilgrim"."master"."UID" AND ( "pilgrim"."attachments"."FileDescription" = \'PassportFrontPic\' OR "pilgrim"."attachments"."FileDescription" = \'PassportBackPic\' OR "pilgrim"."attachments"."FileDescription" = \'PassportBookletPic\') ) as "PassportIMGs"
                FROM pilgrim."master"
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"                 
                ORDER BY pilgrim."master"."FirstName" ASC ';
        $WhereSQL = array();
        if (isset($PendingPassportPilgrimSearchFilter['name'])) {
            $WhereSQL[] = ' LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PendingPassportPilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PendingPassportPilgrimSearchFilter['nationality']) && $PendingPassportPilgrimSearchFilter['nationality'] != '') {
            $WhereSQL[] = ' pilgrim."master"."Nationality" = \'' . $PendingPassportPilgrimSearchFilter['nationality'] . '\' ';
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function ListPendingPassportPilgrims()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();
        $PendingPassportPilgrimSearchFilter = $session['PendingPassportPilgrimSearchFilter'];

        $SQL = 'SELECT pilgrim."master".*, pilgrim."travel"."EntryPort" as "EntryPort", pilgrim."travel"."EntryDate" as "EntryDate", main."Groups"."FullName" as "GroupName", main."Agents"."FullName" as "AgentName",
                ( SELECT COUNT("pilgrim"."attachments"."UID") FROM "pilgrim"."attachments" WHERE "pilgrim"."attachments"."PilgrimID" = "pilgrim"."master"."UID" AND ( "pilgrim"."attachments"."FileDescription" = \'PassportFrontPic\' OR "pilgrim"."attachments"."FileDescription" = \'PassportBackPic\' OR "pilgrim"."attachments"."FileDescription" = \'PassportBookletPic\') ) as "PassportIMGs"
                FROM pilgrim."master"
                LEFT JOIN pilgrim."travel" ON pilgrim."master"."UID"  = pilgrim."travel"."PilgrimID" 
                LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"            
                LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID" 
                ORDER BY pilgrim."master"."FirstName" ASC  
                
                ';

        $WhereSQL = array();
        if (isset($PendingPassportPilgrimSearchFilter['name'])) {
            $WhereSQL[] = ' LOWER(pilgrim."master"."FirstName") LIKE \'%' . strtolower($PendingPassportPilgrimSearchFilter['name']) . '%\' ';
        }

        if (isset($PendingPassportPilgrimSearchFilter['nationality']) && $PendingPassportPilgrimSearchFilter['nationality'] != '') {
            $WhereSQL[] = ' pilgrim."master"."Nationality" = \'' . $PendingPassportPilgrimSearchFilter['nationality'] . '\' ';
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function VOUPilgrimFileFormSubmit($record, $name)
    {
        $response = array();
        if ($record['path']->store('', $name)) {
            $MainModel = new Main();
            $file = ROOT . '/writable/uploads' . '/' . $name . '';
            //echo $file;exit();
            $response = $MainModel->MofaELMPilgrimExcelReader($file);
        } else {
            $response['status'] = "fail";
            $response['message'] = "Error Uploading File...";
        }
        echo json_encode($response);
    }


    public function PilgrimFormSubmit($records, $UID, $passportdata, $AttachmentsData, $AccountRecords)
    {
        $data = $this->data;
        $Crud = new Crud();
        $CroneModel = new CronModel();

        $table = 'pilgrim."master"';
        if ($UID == 0) {
            if ($UID = $Crud->AddRecord($table, $records)) {
                $CroneModel->UpdateCronActivity('TotalB2C');
                $CroneModel->UpdateCronActivity('MOFAIssued');
                $CroneModel->UpdateCronActivity('MOFANotIssued');
                $CroneModel->UpdateCronActivity('VisaIssued');

                $Crud->Track("Groups", 'New Pilgrim "' . $records['FirstName'] . '" added in system...');
                $response['record_id'] = $UID;
                $response['status'] = "success";
                $response['message'] = "Pilgrim Successfully Added...";


                $PassData = array();

                $PassData['PilgrimID'] = $UID;
                $PassData['PassportType'] = $passportdata['PassportType'];
                $PassData['PassportNumber'] = $passportdata['PassportNumber'];
                $PassData['Nationality'] = $passportdata['Nationality'];
                $PassData['DateOfIssue'] = $passportdata['DateOfIssue'];
                $PassData['DateOfExpiry'] = $passportdata['DateOfExpiry'];
                $PassData['TrackingNumber'] = $passportdata['TrackingNumber'];
                $PassData['CitizenshipNumber'] = $passportdata['CitizenshipNumber'];
                $PassData['BookletNumber'] = $passportdata['BookletNumber'];
                $PassData['File'] = $passportdata['File'];
                $tables = 'pilgrim."passport"';
                $Crud->AddRecord($tables, $PassData);

                $Email = $AccountRecords['Email'];
                if (!empty($Email[0])) {
                    $table = 'pilgrim."auth"';
                    $AccountRecords['PilgrimID'] = $UID;
                    $Crud->AddRecord($table, $AccountRecords);
                }

            } else {
                $response['status'] = "fail";
                $response['message'] = "Data isn't  Submitted correctly...";

            }

        } else {

            $where = array("UID" => $UID);
            if ($Crud->UpdateRecord($table, $records, $where)) {

                $Crud->Track("Groups", 'Pilgrim "' . $records['FirstName'] . '" Updated Succesfully ...');
                $response['status'] = "success";
                $response['message'] = "Pilgrim Updated...";

            } else {
                $response['status'] = "fail";
                $response['message'] = "Data Didnt Updated...";
            }

            $PassportRecords = $Crud->SingleRecord($table, $where);
            $tabless = 'pilgrim."passport"';
            $wheress = array("PilgrimID" => $PassportRecords['UID']);
            $Crud->DeleteRecord($tabless, $wheress);
            $PassData = array();
            $PassData['PilgrimID'] = $UID;
            $PassData['PassportType'] = $passportdata['PassportType'];
            $PassData['PassportNumber'] = $passportdata['PassportNumber'];
            $PassData['Nationality'] = $passportdata['Nationality'];
            $PassData['DateOfIssue'] = $passportdata['DateOfIssue'];
            $PassData['DateOfExpiry'] = $passportdata['DateOfExpiry'];
            $PassData['TrackingNumber'] = $passportdata['TrackingNumber'];
            $PassData['CitizenshipNumber'] = $passportdata['CitizenshipNumber'];
            $PassData['BookletNumber'] = $passportdata['BookletNumber'];
            $PassData['File'] = $passportdata['File'];
            $Crud->AddRecord($tabless, $PassData);

        }

        if (isset($AttachmentsData)) {
            $table = 'pilgrim."attachments"';
            $images = $AttachmentsData['AttachFiles'];
            $FileDescription = $AttachmentsData['FileDescription'];

            if (!empty($FileDescription)) {
                for ($a = 0; $a < count($FileDescription); $a++) {
                    $record = array();
                    $record['PilgrimID'] = $UID;
                    $record['FileDescription'] = $FileDescription[$a];
                    $record['FileID'] = $images[$a];
                    $Crud->AddRecord($table, $record);
                }
            }
        }

        if (!empty($passportdata['PassportFrontPicID'])) {
            $table = 'pilgrim."attachments"';
            $where = array("PilgrimID" => $UID);
            $Crud->DeleteRecord($table, $where);
            $frontpic = $passportdata['PassportFrontPicID'];
            $Crud->AddRecord($table, array("PilgrimID" => $UID, "FileDescription" => 'PassportFrontPic', "FileID" => $frontpic));
            $backpic = $passportdata['PassportBackPicID'];
            $Crud->AddRecord($table, array("PilgrimID" => $UID, "FileDescription" => 'PassportBackPic', "FileID" => $backpic));
            $bookletpic = $passportdata['PassportBookletPicID'];
            $Crud->AddRecord($table, array("PilgrimID" => $UID, "FileDescription" => 'PassportBookletPic', "FileID" => $bookletpic));
        }


        echo json_encode($response);
    }


    public
    function PassportFormSubmit($record_id)
    {
        $Crud = new Crud();
        $table = 'uploads."Files"';
        $where = array("UID" => $record_id);
        $FileContent = $Crud->SingleRecord($table, $where);
        //$Crud->DeleteRecord($table, $where);

        $Api = new Api();
        $JSON = $Api->PassportScan($FileContent);

        return $JSON;
    }

    public function PassportImagesFormSubmit($IMGData)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'pilgrim."attachments"';

        $Crud->AddRecord($table, $IMGData);
        $response['status'] = "success";
        $response['message'] = "Passport Images Successfully Added...";

        echo json_encode($response);
    }


    public function PilgrimStatusFormSubmit($records, $pilgrimmetas, $VoucherID, $AllowReference)
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $CronModel = new CronModel();

        $RequestedStatus = $records['CurrentStatus'];
        $Pilgrimis = $records['VoucherPilgrims'];
        //print_r($records);

        $table = 'pilgrim."meta"';
        $InsertData = array();
        ///////////////////////////////////////////
        // $InsertData[] = array("PilgrimUID" => $contactsKs, "SystemDate" => date("Y-m-d H:i:s"), "AllowReference" => $AllowReference, "Option" => $RequestedStatus . "-contact-number", "Value" => $contactsV, "CreatedBy" => $session['id']);

        $ContactNo = array();
        $contacts = $records['contact_number'][$RequestedStatus];
        if (count($contacts) > 0)
            foreach ($contacts as $contactsKs => $contactsV) {
                if (isset($contactsV) && $contactsV != '') {
                    $InsertData[] = array("PilgrimUID" => $contactsKs, "SystemDate" => date("Y-m-d H:i:s"), "AllowReference" => $AllowReference, "Option" => $RequestedStatus . "-contact-number", "Value" => $contactsV, "CreatedBy" => $session['id']);
                    //print_r($InsertData);
                    $ContactNo[] = $contactsKs;
                    if (($key = array_search($contactsKs, $Pilgrimis)) !== false) {
                        unset($Pilgrimis[$key]);
                    }
                    //unset($Pilgrimis[]);
                }
            }

        $Pilgrimis = array_merge($ContactNo, $Pilgrimis);
        if (count($Pilgrimis) > 0)
            foreach ($Pilgrimis as $value) {
                foreach ($pilgrimmetas as $pilgrimmetaKs => $pilgrimmetaV) {
                    if (isset ($pilgrimmetaV) && $pilgrimmetaV != '') {
                        $InsertData[] = array("PilgrimUID" => $value, "SystemDate" => date("Y-m-d H:i:s"), "AllowReference" => $AllowReference, "Option" => $pilgrimmetaKs, "Value" => $pilgrimmetaV, "CreatedBy" => $session['id']);
                        //  print_r($InsertData);
                    }
                }
            }

//        echo "<pre>"; print_r($InsertData); exit;
        $Crud->AddBulkRecord($table, $InsertData);

        $StatusFields = array();
        $table = 'pilgrim."master"';
        foreach ($Pilgrimis as $value) {
            $where = array("UID" => $value);

            $Allow = array("allow-tpt-arrival", "allow-tpt-medina", "allow-tpt-mecca", "allow-tpt-jeddah", "allow-htl-mecca", "allow-htl-medina", "allow-htl-jeddah");

            if (!in_array($RequestedStatus, $Allow)) {
                $Crud->UpdateRecord($table, array("CurrentStatus" => $RequestedStatus), $where);
            }

            $PilgrimDetail = $Crud->SingleRecord($table, $where);
            $ActivityTable = 'pilgrim."activities"';
            $CurrentActivity = $records['CurrentStatus'];
            $Activities = array();
            $Activities['UserID'] = $session['id'];
            $Activities['PilgrimUID'] = $value;
            $Activities['Activity'] = $CurrentActivity;


            if ($CurrentActivity == 'allow-htl-mecca') {
                $CronModel->UpdateCronActivity('completed_allow_bed');
                $CronModel->UpdateCronActivity('AllowHTLMeccaArrival');
                $CronModel->UpdateCronActivity('CompletedAllowHTLMeccaArrival');

            } else if ($CurrentActivity == 'allow-htl-medina') {
                $CronModel->UpdateCronActivity('completed_allow_bed');
                $CronModel->UpdateCronActivity('AllowHTLMedinaArrival');
                $CronModel->UpdateCronActivity('CompletedAllowHTLMedinaArrival');

            } else if ($CurrentActivity == 'allow-htl-jeddah') {
                $CronModel->UpdateCronActivity('completed_allow_bed');
                $CronModel->UpdateCronActivity('AllowHTLJeddahArrival');
                $CronModel->UpdateCronActivity('CompletedAllowHTLJeddahArrival');

            } else if ($CurrentActivity == 'allow-tpt-jeddah') {
                $CronModel->UpdateCronActivity('AllowTPTJeddah');
                $CronModel->UpdateCronActivity('CompletedAllowTPTJeddah');

            } else if ($CurrentActivity == 'allow-tpt-medina') {
                $CronModel->UpdateCronActivity('AllowTPTMedina');
                $CronModel->UpdateCronActivity('CompletedAllowTPTMedina');

            } else if ($CurrentActivity == 'allow-tpt-mecca') {
                $CronModel->UpdateCronActivity('AllowTPTMeccaArrival');
                $CronModel->UpdateCronActivity('CompletedAllowTPTMeccaArrival');

            } else if ($CurrentActivity == 'check-in-mecca') {

                $CronModel->UpdateCronActivity('CheckInMecca');
                $CronModel->UpdateCronActivity('TotalArrivals');

                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " Checked in mecca At " . DATEFORMAT($StatusFields['check-in-mecca-arrival-date']) . " Time " . $StatusFields['check-in-mecca-arrival-time'] . " Check in To " . $StatusFields['check-in-mecca-hotel-name'] . " in Room Number " . $StatusFields['check-in-mecca-room-number'] . " With Hotel Booking Number " . $StatusFields['check-in-mecca-hotel-booking-no'] . " And Contact Number is " . $StatusFields['check-in-mecca-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'check-in-jeddah') {

                $CronModel->UpdateCronActivity('CheckInJeddah');
                $CronModel->UpdateCronActivity('TotalArrivals');
                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " Checked in jeddah At " . DATEFORMAT($StatusFields['check-in-jeddah-arrival-date']) . " Time " . $StatusFields['check-in-jeddah-arrival-time'] . " Check in To " . $StatusFields['check-in-jeddah-hotel-name'] . " in Room Number " . $StatusFields['check-in-jeddah-room-number'] . " With Hotel Booking Number " . $StatusFields['check-in-jeddah-hotel-booking-no'] . " And Contact Number is " . $StatusFields['check-in-jeddah-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'jeddah-arrival') {
                $CronModel->UpdateCronActivity('TotalArrivals');
                $CronModel->UpdateCronActivity('CompletedAllowTPTArrival');

            } else if ($CurrentActivity == 'mecca-arrival') {
                $CronModel->UpdateCronActivity('TotalArrivals');
                $CronModel->UpdateCronActivity('CompletedAllowTPTArrival');

            } else if ($CurrentActivity == 'medina-arrival') {

                $CronModel->UpdateCronActivity('TotalArrivals');
                $CronModel->UpdateCronActivity('CompletedAllowTPTArrival');

            } else if ($CurrentActivity == 'check-in-medina') {
                $CronModel->UpdateCronActivity('CheckInMedina');
                $CronModel->UpdateCronActivity('TotalArrivals');

                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " Checked in Medina At " . DATEFORMAT($StatusFields['check-in-medina-arrival-date']) . " Time " . $StatusFields['check-in-medina-arrival-time'] . " Check in To " . $StatusFields['check-in-medina-hotel-name'] . " in Room Number " . $StatusFields['check-in-medina-room-number'] . " With Hotel Booking Number " . $StatusFields['check-in-medina-hotel-booking-no'] . " And Contact Number is " . $StatusFields['check-in-medina-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'departure-medina') {
                $CronModel->UpdateCronActivity('TotalExit');
                $CronModel->UpdateCronActivity('PAXInMedina');

            } else if ($CurrentActivity == 'departure-mecca') {
                $CronModel->UpdateCronActivity('TotalExit');
                $CronModel->UpdateCronActivity('PAXInMecca');

            } else if ($CurrentActivity == 'departure-jeddah') {
                $CronModel->UpdateCronActivity('TotalExit');
                $CronModel->UpdateCronActivity('PAXInJeddah');

            } else if ($CurrentActivity == 'check-out-mecca') {
                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " is checking out from mecca through Vehicle Number  " . $StatusFields['check-out-mecca-vehicle-number'] . " Through " . $StatusFields['check-out-mecca-transport-company'] . " Driver Contact Number is " . $StatusFields['check-out-mecca-driver-contact-number'] . " And pilgrim account number is " . $StatusFields['check-out-mecca-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'check-out-medina') {
                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " is checking out from madina through Vehicle Number  " . $StatusFields['check-out-medina-vehicle-number'] . " Through " . $StatusFields['check-out-medina-transport-company'] . " Driver Contact Number is " . $StatusFields['check-out-medina-driver-contact-number'] . " And pilgrim account number is " . $StatusFields['check-out-medina-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'arrival') {
                $CronModel->UpdateCronActivity('TotalArrivals');

                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " Arrived at Vehicle Number  " . $StatusFields['arrival-vehicle-number'] . " Through " . $StatusFields['arrival-transport-company'] . " Driver Contact Number is " . $StatusFields['arrival-driver-contact-number'] . " And pilgrim contact number is " . $StatusFields['arrival-pilgrim-contact-number'];
            } else if ($CurrentActivity == 'jeddah-arrival') {
                $CronModel->UpdateCronActivity('PAXInJeddah');
                $Activities['ActivityDescription'] = $PilgrimDetail['FirstName'] . " Arrived In Jeddah At  " . $StatusFields['jeddah-arrival-transport-detail'] . " Driver Contact Number is " . $StatusFields['jeddah-arrival-driver-number'] . " And pilgrim contact number is " . $StatusFields['jeddah-arrival-mobile-number'];
            } else {

            }
            $Crud->AddRecord($ActivityTable, $Activities);
        }

        $Crud->UpdateRecord('voucher."Master"', array("CurrentStatus" => 'Executed'), array("UID" => $VoucherID));

        $response['status'] = "success";
        $response['message'] = "Pilgrim Status Successfully Updated...";
        echo json_encode($response);
    }

    public function VisaDetailFormSubmit($records, $PilgrimID, $VisaID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'pilgrim."visa"';
        if ($VisaID > 0) {
            $where = array("VisaNumber" => $VisaID);
            $records['PilgrimID'] = $PilgrimID;
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Visa Details Updated...";
        } else {
            $VisaNumber = $Crud->SingleRecord($table, array("VisaNumber" => $records['VisaNumber']));
            if (isset($VisaNumber['VisaNumber']) && $VisaNumber['VisaNumber'] > 0) {
                $response['status'] = "fail";
                $response['message'] = "Duplicate Visa Number...";
            } else {
                $records['PilgrimID'] = $PilgrimID;
                $Crud->AddRecord($table, $records);
                $response['status'] = "success";
                $response['message'] = "Visa Details Successfully Added...";
            }

        }


        echo json_encode($response);
    }


    public function PilgrimVisaDetailFormSubmit($records)
    {

        $Crud = new Crud();
        $table = 'pilgrim."visa"';
        if ($records['PilgrimID'] > 0) {
            $Crud->AddRecord($table, $records);
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }


        echo json_encode($response);
    }


    public function PilgrimVisaDetailForm($Visa)
    {

        $Crud = new Crud();
        $table = 'pilgrim."visa"';
        //print_r($Visa);exit;
        if (count($Visa) > 0)
            foreach ($Visa as $key => $value) {
                $where = array("VisaNumber" => $value['Number']);
                $VisaNumber = $Crud->SingleRecord($table, $where); //print_r($VisaNumber);
                if (!isset($VisaNumber['VisaNumber']) && isset($value['Number']) && $value['Number'] != '') {
                    $records['VisaNumber'] = $value['Number'];
                    $records['IssueDate'] = $value['IssueDate'];
                    $records['Type'] = $value['Type'];
                    $records['PilgrimID'] = $key;

                    $Crud->AddRecord($table, $records);
                    $PilgrimMetaRecord = array(
                        "PilgrimUID" => $key,
                        "Option" => 'visa-issued-status',
                        "Value" => 'Yes'
                    );
                    //print_r($PilgrimMetaRecord);
                    $Crud->AddRecord('pilgrim."meta"', $PilgrimMetaRecord);
                }
            }
        $response['status'] = "success";
        $response['message'] = "Visa Detail Successfully Added...";

        echo json_encode($response);
    }


    public
    function PilgrimsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'pilgrim."master"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }

    public
    function PilgrimsListWithOutVisa()
    {
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SQL = 'SELECT pilgrim."master".*, pilgrim."visa"."VisaNumber" as "VisaNumber" FROM pilgrim."master"
                LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
                WHERE "VisaNumber" IS NULL

                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND pilgrim."master"."WebsiteDomain" = ' . $session['domainid'] . ' ';

        }
        $SQL .= 'ORDER BY pilgrim."master"."FirstName" ASC';

        // echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }

    public
    function PilgrimsListWithOutVisaDetail()
    {
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SQL = 'SELECT pilgrim."master".*, pilgrim."visa"."VisaNumber" as "VisaNumber",pilgrim."mofa"."MOFANumber" as "MOFANumber" FROM pilgrim."master"
                LEFT JOIN pilgrim."visa" ON pilgrim."master"."UID"  = pilgrim."visa"."PilgrimID" 
                LEFT JOIN pilgrim."mofa" ON pilgrim."master"."UID"  = pilgrim."mofa"."PilgrimID" 
                WHERE "VisaNumber" IS NULL

                ';
        if ($session['domainid'] > 0) {
            $SQL .= ' AND pilgrim."master"."WebsiteDomain" = ' . $session['domainid'] . ' ';

        }
        $SQL .= ' ORDER BY pilgrim."master"."FirstName" ASC ';

        if (isset($_POST['country']) && $_POST['country'] != '') {
            $SQL = ' SELECT * FROM  (' . $SQL . ') AS "MainQuery"
                    WHERE "MainQuery"."Country" = \'' . $_POST['country'] . '\' ';
        }

        if (isset($_POST['full_name']) && trim($_POST['full_name']) != '') {
            $SQL = ' SELECT * FROM  (' . $SQL . ') AS "MainQuery"
                    WHERE LOWER("MainQuery"."FirstName") LIKE \'%' . strtolower(trim($_POST['full_name'])) . '%\' ';
        }

        if (isset($_POST['passport_no']) && trim($_POST['passport_no']) != '') {
            $SQL = ' SELECT * FROM  (' . $SQL . ') AS "MainQuery"
                    WHERE "MainQuery"."PassportNumber" = \'' . trim($_POST['passport_no']) . '\' ';
        }

        if (isset($_POST['mofa_no']) && trim($_POST['mofa_no']) != '') {
            $SQL = ' SELECT * FROM  (' . $SQL . ') AS "MainQuery"
                    WHERE "MainQuery"."MOFANumber" = \'' . trim($_POST['mofa_no']) . '\' ';
        }

        //echo nl2br($SQL);

        //$records = $Crud->ExecuteSQL($SQL);
        // return $records;
        return $SQL;
    }

    public function count_visa_details_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->PilgrimsListWithOutVisaDetail();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);

    }

    public function get_visa_details_datatables()
    {

        $Crud = new Crud();
        $SQL = $this->PilgrimsListWithOutVisaDetail();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL);
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function PilgrimAccountData($ID)
    {

        $Crud = new Crud();

        $sql = 'SELECT pilgrim."auth".*, websites."Domains"."FullName" as "DomainName"
                FROM pilgrim."auth"
                JOIN websites."Domains" ON pilgrim."auth"."DomainID"  = websites."Domains"."UID"
                WHERE pilgrim."auth"."PilgrimID" = ' . $ID . '
                ';

        $records = $Crud->ExecuteSQL($sql);
        return $records;

//        $data = $this->data;
//        $Crud = new Crud();
//        $table = 'pilgrim."auth"';
//        $where = array("PilgrimID" => $record_id);
//        $records = $Crud->ListRecords($table, $where);
//        return $records;

    }


    public
    function PilgrimMOFAData($ID)
    {
        $Crud = new Crud();

        $sql = 'SELECT pilgrim."mofa".*, pilgrim."visa".*
                FROM pilgrim."mofa"
                LEFT JOIN pilgrim."visa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."visa"."PilgrimID"
                WHERE pilgrim."mofa"."PilgrimID" = ' . $ID . '
                ';

        $records = $Crud->ExecuteSQL($sql);
        return $records;

    }

    public
    function PilgrimMetaData($ID)
    {
        $Crud = new Crud();
        $table = 'pilgrim."meta"';
        $where = array("PilgrimUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }

    public
    function PilgrimMetaDataByReferenceID($RefID)
    {
//        $Crud = new Crud();
//        $table = 'pilgrim."meta"';
//        $where = array("PilgrimUID" => $RefID);
//        $records = $Crud->ListRecords($table, $where);
//        return $records;

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."meta".*  FROM pilgrim."meta" WHERE pilgrim."meta"."AllowReference" = ' . $RefID . '  AND pilgrim."meta"."Option" LIKE \'%allow-%\'   ';

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;

    }

    public
    function PilgrimMetaDataWithOption($ID, $RefID)
    {


        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."meta".*  FROM pilgrim."meta" WHERE  pilgrim."meta".PilgrimUID = ' . $ID . ' AND pilgrim."meta".AllowReference = ' . $RefID . '
        
        ';

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;
//
//        $Crud = new Crud();
//        $table = 'pilgrim."meta"';
//        $where = array("PilgrimUID" => $ID);
//        $records = $Crud->ListRecords($table, $where);
//        return $records;

    }


    public
    function PilgrimMetaRecords($ID)
    {
        $Crud = new Crud();
        $table = 'pilgrim."meta"';
        $where = array("PilgrimUID" => $ID);
        $PilgrimMetaDatas = $Crud->ListRecords($table, $where);
        $finalMeta = array();
        foreach ($PilgrimMetaDatas as $rec) {
            $finalMeta[$rec['Option']] = $rec['Value'];
        }
        return $finalMeta;
    }

    public
    function DeparturePilgrimLeaderMetaRecords($ID)
    {
        $Crud = new Crud();
        $table = 'pilgrim."master"';
        $where = array("UID" => $ID);
        $pilgrimrecord = $Crud->SingleRecord($table, $where);
        $CurrentStatus = $pilgrimrecord['CurrentStatus'];

        $table = 'pilgrim."meta"';
        $where = array("PilgrimUID" => $ID);
        $PilgrimMetaDatas = $Crud->ListRecords($table, $where);
        $finalMeta = array();
        foreach ($PilgrimMetaDatas as $rec) {
            $finalMeta[$rec['Option']] = $rec['Value'];
        }
        $ActualMeta = array();
        $ActualMeta['PilgrimUID'] = $ID;
        $ActualMeta['PilgrimMobile'] = $ID;
        $ActualMeta['Status'] = $CurrentStatus;
        if ($CurrentStatus == 'departure-mecca') {
            //$ActualMeta['ActualHotel'] = HotelName($finalMeta['departure-mecca-actual-hotel']);
            //$ActualMeta['RoomNo'] = $finalMeta['departure-mecca-room-no'];
            //$ActualMeta['DepartureDate'] = $finalMeta['departure-mecca-date'];
            // $ActualMeta['DepartureTime'] = $finalMeta['departure-mecca-hotel-time'];
            //$ActualMeta['TransportType'] = OptionName($finalMeta['departure-mecca-transport-type']);
            $ActualMeta['Seats'] = $finalMeta['departure-mecca-seats'];
            //$ActualMeta['AirPorts'] = AirportName($finalMeta['departure-mecca-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($finalMeta['departure-mecca-actual-hotel'], 'CityID'));
            $ActualMeta['VehicleNumber'] = $finalMeta['departure-mecca-vehicle-number'];
            $ActualMeta['DriverName'] = $finalMeta['departure-mecca-driver-name'];
            $ActualMeta['DriverMobileNumber'] = $finalMeta['departure-mecca-driver-mobile-number'];
            $ActualMeta['PaxMobileNumber'] = $finalMeta['departure-mecca-contact-number'];
            $ActualMeta['TransportCompany'] = OptionName($finalMeta['departure-mecca-transport-company']);
            $ActualMeta['ActualHotelCategory'] = OptionName(HotelName($finalMeta['departure-mecca-actual-hotel'], 'Category'));
            $ActualMeta['SystemUser'] = UserNameByID($finalMeta['departure-mecca-user-id']);
        }
        if ($CurrentStatus == 'departure-medina') {
            //$ActualMeta['ActualHotel'] = HotelName($finalMeta['departure-medina-actual-hotel']);
            //$ActualMeta['RoomNo'] = $finalMeta['departure-medina-room-no'];
            //$ActualMeta['DepartureDate'] = $finalMeta['departure-medina-date'];
            //$ActualMeta['DepartureTime'] = $finalMeta['departure-medina-hotel-time'];
            //$ActualMeta['TransportType'] = OptionName($finalMeta['departure-medina-transport-type']);
            $ActualMeta['Seats'] = $finalMeta['departure-medina-seats'];
            //$ActualMeta['AirPorts'] = AirportName($finalMeta['departure-medina-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($finalMeta['departure-medina-actual-hotel'], 'CityID'));
            $ActualMeta['VehicleNumber'] = $finalMeta['departure-medina-vehicle-number'];
            $ActualMeta['DriverName'] = $finalMeta['departure-medina-driver-name'];
            $ActualMeta['DriverMobileNumber'] = $finalMeta['departure-medina-driver-mobile-number'];
            $ActualMeta['PaxMobileNumber'] = $finalMeta['departure-medina-contact-number'];
            $ActualMeta['TransportCompany'] = OptionName($finalMeta['departure-medina-transport-company']);
            $ActualMeta['ActualHotelCategory'] = OptionName(HotelName($finalMeta['departure-medina-actual-hotel'], 'Category'));
            $ActualMeta['SystemUser'] = UserNameByID($finalMeta['departure-medina-user-id']);
        }
        if ($CurrentStatus == 'departure-jeddah') {
            //$ActualMeta['ActualHotel'] = HotelName($finalMeta['departure-jeddah-actual-hotel']);
            //$ActualMeta['RoomNo'] = $finalMeta['departure-jeddah-room-no'];
            //$ActualMeta['DepartureDate'] = $finalMeta['departure-jeddah-date'];
            //$ActualMeta['DepartureTime'] = $finalMeta['departure-jeddah-hotel-time'];
            //$ActualMeta['TransportType'] = OptionName($finalMeta['departure-jeddah-transport-type']);
            $ActualMeta['Seats'] = $finalMeta['departure-jeddah-seats'];
            //$ActualMeta['AirPorts'] = AirportName($finalMeta['departure-jeddah-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($finalMeta['departure-jeddah-actual-hotel'], 'CityID'));
            $ActualMeta['VehicleNumber'] = $finalMeta['departure-jeddah-vehicle-number'];
            $ActualMeta['DriverName'] = $finalMeta['departure-jeddah-driver-name'];
            $ActualMeta['DriverMobileNumber'] = $finalMeta['departure-jeddah-driver-mobile-number'];
            $ActualMeta['PaxMobileNumber'] = $finalMeta['departure-jeddah-contact-number'];
            $ActualMeta['TransportCompany'] = OptionName($finalMeta['departure-jeddah-transport-company']);
            $ActualMeta['ActualHotelCategory'] = OptionName(HotelName($finalMeta['departure-jeddah-actual-hotel'], 'Category'));
            $ActualMeta['SystemUser'] = UserNameByID($finalMeta['departure-jeddah-user-id']);
        }

        $PilgrimLastActivity = PilgrimLastActivity($ID, $ActualMeta['Status'] . '-status');
//echo '<pre>';print_r($PilgrimLastActivity);
        if ($PilgrimLastActivity['LastActivity'] == 'check-in-mecca') {
            if ($PilgrimLastActivity['ActivityRecords']['check-in-mecca-actual-hotel'] > 0) {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-actual-hotel'], 'Name', 1);
            } else {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-package-Hotel'], 'Name', 0);
            }
            $ActualMeta['ActualHotel'] = $ActualHotel;
            $ActualMeta['RoomNo'] = $PilgrimLastActivity['ActivityRecords']['check-in-mecca-room-no'];
            $ActualMeta['DepartureDate'] = $PilgrimLastActivity['ActivityRecords']['check-in-mecca-out-date'];
            $ActualMeta['DepartureTime'] = $PilgrimLastActivity['ActivityRecords']['check-in-mecca-hotel-time'];
            $ActualMeta['TransportType'] = OptionName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-transport-type']);
            $ActualMeta['AirPorts'] = AirportName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-actual-hotel'], 'CityID'));
            if ($PilgrimLastActivity['ActivityRecords']['check-in-mecca-actual-hotel'] > 0) {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-actual-hotel'], 'Category', 0));
            } else {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-package-Hotel'], 'Category', 1));
            }
            $ActualMeta['ActualHotelCategory'] = $ActualHotelCategory;
            $ActualMeta['SystemUser'] = UserNameByID($PilgrimLastActivity['ActivityRecords']['check-in-mecca-user-id']);
        }
        if ($PilgrimLastActivity['LastActivity'] == 'check-in-medina') {
            if ($PilgrimLastActivity['ActivityRecords']['check-in-medina-actual-hotel'] > 0) {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-medina-actual-hotel'], 'Name', 1);
            } else {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-medina-package-Hotel'], 'Name', 0);
            }
            $ActualMeta['ActualHotel'] = $ActualHotel;
            $ActualMeta['RoomNo'] = $PilgrimLastActivity['ActivityRecords']['check-in-medina-room-no'];
            $ActualMeta['DepartureDate'] = $PilgrimLastActivity['ActivityRecords']['check-in-medina-out-date'];
            $ActualMeta['DepartureTime'] = $PilgrimLastActivity['ActivityRecords']['check-in-medina-hotel-time'];
            $ActualMeta['TransportType'] = OptionName($PilgrimLastActivity['ActivityRecords']['check-in-medina-transport-type']);
            $ActualMeta['AirPorts'] = AirportName($PilgrimLastActivity['ActivityRecords']['check-in-medina-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-medina-actual-hotel'], 'CityID'));
            if ($PilgrimLastActivity['ActivityRecords']['check-in-medina-actual-hotel'] > 0) {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-medina-actual-hotel'], 'Category', 1));
            } else {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-mecca-package-Hotel'], 'Category', 0));
            }
            $ActualMeta['ActualHotelCategory'] = $ActualHotelCategory;
            $ActualMeta['SystemUser'] = UserNameByID($PilgrimLastActivity['ActivityRecords']['check-in-medina-user-id']);
        }
        if ($PilgrimLastActivity['LastActivity'] == 'check-in-jeddah') {
            if ($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-hotel'] > 0) {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-actual-hotel'], 'Name', 1);
            } else {

                $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-package-Hotel'], 'Name', 0);
            }
            $ActualMeta['ActualHotel'] = HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-actual-hotel']);
            $ActualMeta['RoomNo'] = $PilgrimLastActivity['ActivityRecords']['check-in-jeddah-room-no'];
            $ActualMeta['DepartureDate'] = $PilgrimLastActivity['ActivityRecords']['check-in-jeddah-out-date'];
            $ActualMeta['DepartureTime'] = $PilgrimLastActivity['ActivityRecords']['check-in-jeddah-hotel-time'];
            $ActualMeta['TransportType'] = OptionName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-transport-type']);
            $ActualMeta['AirPorts'] = AirportName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-airport']);
            $ActualMeta['ActualHotelCity'] = CityName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-actual-hotel'], 'CityID'));
            if ($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-actual-hotel'] > 0) {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-actual-hotel'], 'Category', 0));
            } else {

                $ActualHotelCategory = OptionName(HotelName($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-package-Hotel'], 'Category', 1));
            }
            $ActualMeta['ActualHotelCategory'] = $ActualHotelCategory;
            $ActualMeta['SystemUser'] = UserNameByID($PilgrimLastActivity['ActivityRecords']['check-in-jeddah-user-id']);
        }


        return $ActualMeta;
    }

    public
    function ArrivalPilgrimLeaderMetaRecords($ID)
    {
        $Crud = new Crud();

        $table = 'pilgrim."meta"';
        $where = array("PilgrimUID" => $ID);
        $PilgrimMetaDatas = $Crud->ListRecords($table, $where);
        $finalMeta = array();
        foreach ($PilgrimMetaDatas as $rec) {
            $finalMeta[$rec['Option']] = $rec['Value'];
        }

        $ArrivalCount = StatusCheckList();
        $ArrivalMetas = $ArrivalCount['Arrival'];

        $ActualMeta = array();
        $ActualMeta['PilgrimUID'] = $ID;

        //$ActualMeta['PilgrimMobile'] = $ID;
        foreach ($ArrivalMetas as $ArrMeta) {

            if (isset($finalMeta[$ArrMeta . "-status"])) {
                $ActualMeta['Status'] = $ArrMeta;
                $CurrentStatus = $ArrMeta;
                if ($CurrentStatus == 'jeddah-arrival') {
                    $ActualMeta['BRN'] = $finalMeta['jeddah-arrival-brn-no'];
                    $ActualMeta['VehicleNumber'] = $finalMeta['jeddah-arrival-vehicle-number'];
                    $ActualMeta['DriverName'] = $finalMeta['jeddah-arrival-driver-name'];
                    $ActualMeta['DriverNumber'] = $finalMeta['jeddah-arrival-driver-number'];
                    $ActualMeta['Seats'] = $finalMeta['jeddah-arrival-actual-no-of-seats'];
                    $ActualMeta['PilgrimMobile'] = $finalMeta['jeddah-arrival-contact-number'];
                    $ActualMeta['TransportCompany'] = OptionName($finalMeta['jeddah-arrival-transport-company']);
                    $ActualMeta['CurrentStatus'] = 'Jeddah Arrival';
                }
                if ($CurrentStatus == 'yanbu-arrival') {
                    $ActualMeta['BRN'] = $finalMeta['yanbu-arrival-brn-no'];
                    $ActualMeta['VehicleNumber'] = $finalMeta['yanbu-arrival-vehicle-number'];
                    $ActualMeta['DriverName'] = $finalMeta['yanbu-arrival-driver-name'];
                    $ActualMeta['DriverNumber'] = $finalMeta['yanbu-arrival-driver-number'];
                    $ActualMeta['Seats'] = $finalMeta['yanbu-arrival-actual-no-of-seats'];
                    $ActualMeta['PilgrimMobile'] = $finalMeta['yanbu-arrival-contact-number'];
                    $ActualMeta['TransportCompany'] = OptionName($finalMeta['yanbu-arrival-transport-company']);
                    $ActualMeta['CurrentStatus'] = 'Yanbu Arrival';
                }
                if ($CurrentStatus == 'medina-arrival') {
                    $ActualMeta['BRN'] = $finalMeta['medina-arrival-brn-no'];
                    $ActualMeta['VehicleNumber'] = $finalMeta['medina-arrival-vehicle-number'];
                    $ActualMeta['DriverName'] = $finalMeta['medina-arrival-driver-name'];
                    $ActualMeta['DriverNumber'] = $finalMeta['medina-arrival-driver-number'];
                    $ActualMeta['Seats'] = $finalMeta['medina-arrival-actual-no-of-seats'];
                    $ActualMeta['PilgrimMobile'] = $finalMeta['medina-arrival-contact-number'];
                    $ActualMeta['TransportCompany'] = OptionName($finalMeta['medina-arrival-transport-company']);
                    $ActualMeta['CurrentStatus'] = 'Medina Arrival';
                }
            }
        }
        //print_r($finalMeta);
        //print_r($ActualMeta);

        return $ActualMeta;
    }

    public
    function PilgrimTranportData($ID)
    {

        $Crud = new Crud();
        $table = 'pilgrim."travel"';
        $where = array("PilgrimID" => $ID);
        $records = $Crud->ListRecords($table, $where);

    }

    public
    function Cities()
    {

        $Crud = new Crud();
        $table = 'main."Cities"';
        $where = array();
        $records = $Crud->ListRecords($table, $where, array("Name" => "ASC"));
        return $records;
    }

    public
    function ELMlistData()
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."travel".*, pilgrim."master".*,main."Groups"."FullName" as "GroupName"  FROM pilgrim."travel"
        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"  = pilgrim."travel"."PilgrimID" 
        LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID"
        WHERE  pilgrim."travel"."Flag" = \'Arrival\'
        ORDER BY pilgrim."master"."FirstName" ASC  ';

        //$records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $SQL;

//        $data = $this->data;
//        $Crud = new Crud();
//        $table = 'pilgrim."travel"';
//        $where = array();
//        $records = $Crud->ListRecords($table, $where);
//
//        return $records;
    }

    public
    function DepELMlistData()
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT pilgrim."travel".*, pilgrim."master".*,main."Groups"."FullName" as "GroupName"  FROM pilgrim."travel"
        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"  = pilgrim."travel"."PilgrimID" 
        LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID"
        WHERE  pilgrim."travel"."Flag" = \'Departure\'
        ORDER BY pilgrim."master"."FirstName" ASC  ';

        //$records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $SQL;

//        $data = $this->data;
//        $Crud = new Crud();
//        $table = 'pilgrim."travel"';
//        $where = array();
//        $records = $Crud->ListRecords($table, $where);
//
//        return $records;
    }

    public
    function PilgrimsPassportData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'pilgrim."passport"';
        $where = array("PilgrimID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function PilgrimsAttachmentsData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'pilgrim."attachments"';
        $where = array("PilgrimID" => $record_id);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function PilgrimPassportImages($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT COUNT("UID") AS "CNT" FROM "pilgrim"."attachments"
        WHERE "PilgrimID" = ' . $record_id . ' AND ( "FileDescription" = \'PassportFrontPic\' OR "FileDescription" = \'PassportBackPic\' OR "FileDescription" = \'PassportBookletPic\')';
        $records = $Crud->ExecuteSQL($SQL);
        return $records["CNT"];
    }


    public
    function PilgrimAgentAssign($records, $PilgrimID)
    {
        $Crud = new Crud();

        $table = 'pilgrim."master"';
        $where = array("UID" => $PilgrimID);
        $Crud->UpdateRecord($table, $records, $where);

        $response['status'] = "success";
        $response['message'] = "Pilgrim Successfully Assigned To Agent...";

        echo json_encode($response);
    }

    public
    function PilgrimChangeStatus($Status, $RowID)
    {
        $Crud = new Crud();

        $table = 'pilgrim."auth"';
        $where = array("UID" => $RowID);
        if ($Status == '0') {
            $records['Status'] = 1;
        } else {
            $records['Status'] = 0;
        }
        $Crud->UpdateRecord($table, $records, $where);
        $response['status'] = "success";
        echo json_encode($response);
    }


    public
    function InKSAPilgrimCount($Domain)
    {
        $session = session();
        $session = $session->get();
        $ArrivalCount = StatusCheckList();

        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
                WHERE pilgrim."master"."WebsiteDomain" = ' . $Domain . ' 
                AND (pilgrim."master"."CurrentStatus" IN (\'' . implode("','", $ArrivalCount['InKSA']) . '\') )';
        if ($session['mis_type'] == 'other' && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $AgentUIDS . ') ';
        }

        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function StatusExceptCount($Status, $Domain)
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
        WHERE "WebsiteDomain" = ' . $Domain . ' AND  "CurrentStatus" != ' . $Status . ' ';

        // echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function InKSAPilgrimCounts()
    {
        $session = session();
        $session = $session->get();
        $InKSA = StatusCheckList();
        $InKSA = $InKSA['InKSA'];
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
        WHERE "CurrentStatus" IN (\'' . implode("','", $InKSA) . '\') ';

        if ($session['domainid'] > 0)
            $SQL .= ' AND "WebsiteDomain" = ' . $session['domainid'];

        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }
        // echo $SQL;
//          exit;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function ExitPilgrimCount()
    {
        $session = session();
        $session = $session->get();
        $ExitCount = StatusCheckList();
        $ExitCount = $ExitCount['Exit'];
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
        WHERE "CurrentStatus" IN (\'' . implode("','", $ExitCount) . '\') ';

        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }

        if ($session['domainid'] > 0)
            $SQL .= ' AND pilgrim."master"."WebsiteDomain" = ' . $session['domainid'];

        // echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function InProcessPilgrimCount()
    {
        $session = session();
        $session = $session->get();
        $InProcess = StatusCheckList();
        $InProcess = $InProcess['InProcess'];
        $Crud = new Crud();
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['CheckinKSA'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $SQL = 'SELECT pilgrim."master".* 
                FROM pilgrim."master"
        WHERE "pilgrim"."master"."UID" IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")
        AND  "pilgrim"."master"."UID" NOT IN(SELECT Distinct  pilgrim."meta"."PilgrimUID" From pilgrim."meta"  where pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\'))
        ';
        if (isset($session['domainid']) && $session['domainid'] > 0) {
            $SQL .= ' AND "WebsiteDomain" = ' . $session['domainid'];
        }
        if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $SQL .= ' AND pilgrim."master"."AgentUID" IN (' . $AgentUIDS . ') ';
        }
        /*if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }*/
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function EnterPilgrimCount()
    {
        $session = session();
        $session = $session->get();
        $EntryCount = StatusCheckList();
        $EntryCount = $EntryCount['Entry'];
        $Crud = new Crud();
        $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
        WHERE "CurrentStatus" IN (\'' . implode("','", $EntryCount) . '\') ';

        if ($session['domainid'] > 0)
            $SQL .= ' AND "WebsiteDomain" = ' . $session['domainid'];

        if (isset($session['account_type']) && in_array($session['account_type'], array('agent', 'external_agent'))) {
            $SQL .= ' AND pilgrim."master"."AgentUID" = \'' . $session['agent_id'] . '\' ';
        }
        if (isset($session['account_type']) && $session['account_type'] == 'sale_agent') {
            $SQL .= ' AND pilgrim."master"."AgentUID" IN ( 
                        SELECT "sale_agent"."Meta"."Value" FROM "sale_agent"."Meta" 
                        WHERE "sale_agent"."Meta"."Option" = \'Agent_ID\' AND "sale_agent"."Meta"."SaleAgentID" = \'' . $session['agent_id'] . '\' 
                      )  ';
        }
        // echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function PilgrimsCountries($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT DISTINCT main."Countries"."Name" as "CountryName", 
        main."Countries"."ISO2", COUNT(pilgrim."master"."UID") AS totalpilgrims
        FROM pilgrim."master"
        LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID"  = main."Agents"."UID"
        LEFT JOIN main."Countries" ON main."Agents"."CountryID" = main."Countries"."ISO2"
        ' . (($domain > 0) ? 'WHERE pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        GROUP BY main."Countries"."Name", main."Countries"."ISO2"
        ORDER BY COUNT(pilgrim."master"."UID") DESC ';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function NewMonthlyPilgrims($domain = 0)
    {
        $data = $this->data;
        $MainArray = array();
        $Crud = new Crud();
        $CalenderRecords = $Crud->ListRecords('main."UmrahCalender"', [], ['StartDate' => 'ASC']);
        foreach ($CalenderRecords as $Calender) {


            $SQL = '
            SELECT 
             
            DATE_PART(\'month\', pilgrim."master"."RegistrationDate") as "Month", 
            count(pilgrim."master"."UID") as "TotalPilgrims"
            FROM pilgrim."master"
            WHERE pilgrim."master"."UID">0
            ' . (($domain > 0) ? ' AND pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
            AND "RegistrationDate" BETWEEN \'' . $Calender['StartDate'] . '\' AND \'' . $Calender['EndDate'] . '\'
            GROUP BY  "Month"
            ORDER BY  "Month"
            ';
            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $r) {
                $MainArray[$Calender['Title']][$r['Month']] = $r['TotalPilgrims'];
            }
        }
        return $MainArray;
    }

    public
    function MonthlyPilgrims($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = '
        SELECT DATE_PART(\'year\', pilgrim."master"."RegistrationDate") as "Year", DATE_PART(\'month\', pilgrim."master"."RegistrationDate") as "Month", count(pilgrim."master"."UID") as "TotalPilgrims"
        FROM pilgrim."master"
        ' . (($domain > 0) ? 'WHERE pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        GROUP BY "Year", "Month"
        ORDER BY "Year", "Month"
        LIMIT 12';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function YearlyPilgrims($domain = 0)
    {
        $data = $this->data;
        $MainArray = array();
        $Crud = new Crud();
        $CalenderRecords = $Crud->ListRecords('main."UmrahCalender"', [], ['StartDate' => 'ASC']);
        foreach ($CalenderRecords as $Calender) {
            $SQL = '
                        SELECT  
                        count(pilgrim."master"."UID") as "TotalPilgrims"
                        FROM pilgrim."master"
                        WHERE pilgrim."master"."UID">0
                        ' . (($domain > 0) ? ' AND pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
                        AND "RegistrationDate" BETWEEN \'' . $Calender['StartDate'] . '\' AND \'' . $Calender['EndDate'] . '\'
                        ';
            //echo $SQL;

            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $r) {
                $MainArray[$Calender['Title']] = $r['TotalPilgrims'];
            }

        }
        return $MainArray;
    }

    public
    function CompanyBasedPilgrims($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT websites."Domains"."FullName" as "CompanyName", COUNT(pilgrim."master"."UID") AS totalpilgrims
        FROM pilgrim."master"
        LEFT JOIN websites."Domains" ON (websites."Domains"."UID" = pilgrim."master"."WebsiteDomain")
		group by websites."Domains"."FullName"';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function TopB2BPilgrims($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = '
        SELECT main."Agents"."FullName" as "AgentName", COUNT(pilgrim."master"."UID") AS "totalpilgrims"
        FROM pilgrim."master"
        LEFT JOIN main."Agents" ON (main."Agents"."UID" = pilgrim."master"."AgentUID")
        WHERE main."Agents"."Archive" = 0 ' . (($domain > 0) ? 'AND pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        GROUP BY main."Agents"."FullName" ORDER BY "totalpilgrims" DESC LIMIT 5';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function B2BAgentsData($ID,$domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();
        $AgentUIDS = HierarchyUsers($ID);
        $SQL = '
        SELECT main."Agents"."FullName" as "AgentName", COUNT(pilgrim."master"."UID") AS "totalpilgrims"
        FROM pilgrim."master"
        LEFT JOIN main."Agents" ON (main."Agents"."UID" = pilgrim."master"."AgentUID")
        WHERE main."Agents"."Archive" = 0 AND main."Agents"."ParentID" IN (' . $AgentUIDS . ') ' . (($domain > 0) ? 'AND pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        GROUP BY main."Agents"."FullName" ORDER BY "totalpilgrims" DESC';
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public
    function AgentMonthlyPilgrimsCountries($domain = 0)
    {
        $data = $this->data;
        $session = session();
        $session = $session->get();

        $WhereSQL = '';
        if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
            $AgentUIDS = HierarchyUsers($session['id']);
            $WhereSQL .= ' AND pilgrim."master"."AgentUID" IN (' . $AgentUIDS . ') ';
        }

        $Crud = new Crud();
        $SQL = '
        SELECT to_date(cast(pilgrim."master"."RegistrationDate" as TEXT),\'YYYY-MM\'), COUNT(pilgrim."master"."UID") AS totalpilgrims
        FROM pilgrim."master"
        WHERE pilgrim."master"."UID" > 0 AND pilgrim."master"."RegistrationDate" IS NOT NULL
        ' . (($domain > 0) ? ' AND pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        ' . $WhereSQL . '
        GROUP BY  to_date(cast(pilgrim."master"."RegistrationDate" as TEXT),\'YYYY-MM\')
       /* ORDER BY to_date(cast("RegistrationDate" as TEXT),\'YYYY-MM\')*/
         ORDER BY COUNT(pilgrim."master"."UID") DESC ';
        //echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }


    public
    function SaleAgentPilgrims($domain = 0)
    {
        $data = $this->data;
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $AgentUIDS = HierarchyUsers($session['id']);

        $SQL = '            
        SELECT  
          main."Agents"."FullName" as "AgentName",
          COUNT(pilgrim."master"."UID") AS totalpilgrims
        FROM pilgrim."master"
        INNER JOIN main."Agents" ON (main."Agents"."UID" = pilgrim."master"."AgentUID")
        ' . (($domain > 0) ? 'WHERE pilgrim."master"."WebsiteDomain" = \'' . $domain . '\'' : '') . '
        AND main."Agents"."UID" IN (' . $AgentUIDS . ') 
        GROUP BY            
            main."Agents"."FullName"
         ORDER BY "totalpilgrims" DESC  LIMIT 10';
        //echo $SQL;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    /**
     * Development Start
     * By
     * Jawad Sajid Durrani
     */

    /** Pilgrim Transfer Func*/
    public
    function count_transfer_pilgrim_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListTotalCountPilgrimsData();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalPilgrims'];
    }

    public
    function get_transfer_pilgrim_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ListPilgrimsData();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Arrival ELM Func*/

    public
    function count_elm_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ELMlistData();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function get_elm_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ELMlistData();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Departure ELM Func*/

    public
    function count_dep_elm_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->DepELMlistData();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function get_dep_elm_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->DepELMlistData();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Functions B2B Pilgrims */

    public
    function count_all_b2b_pilgrims_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->CountAllB2BPilgrims();
        $records = $Crud->ExecuteSQL($SQL);
        return $records[0]['TotalB2bPilgrims'];
    }

    public
    function get_all_b2b_pilgrims_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ListAllB2BPilgrims();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /** Functions B2C Pilgrims */

    public
    function count_all_b2c_pilgrims_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->ListB2CWithEmailPassword();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function get_all_b2c_pilgrims_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->ListB2CWithEmailPassword();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /**
     * Development Ends
     * By
     * Jawad Sajid Durrani
     */

}
