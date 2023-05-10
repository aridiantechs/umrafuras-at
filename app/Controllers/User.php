<?php namespace App\Controllers;

use App\Models\Crud;
use App\Models\Agents;
use App\Models\Main;
use App\Models\Users;

class User extends BaseController
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

        $SystemUsers = new Users();
        $data['records'] = $SystemUsers->ListUsers();

        echo view('header', $data);
        echo view('user/index', $data);
        echo view('footer', $data);
    }

    public function profile()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('user/profile', $data);
        echo view('footer', $data);
    }

    public function sales_officer()
    {
        $data = $this->data;
        $SystemUsers = new Users();
        $data['records'] = $SystemUsers->ListSalesUsers();
        echo view('header', $data);
        echo view('user/sales_officer', $data);
        echo view('footer', $data);
    }

    public
    function ShiftLoginSession($ID, $type)
    {
        $Crud = new Crud();
        $session = session();
        $response = array();

        $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
        $DomainID = $Crud->SingleRecord('websites."Domains"', $where);

        if ($type == 'sale-agent') {
//            echo " This is Sale Agent ";exit;
            $SaleAgentwhere = array("UID" => $ID);
            $SaleAgentRecords = $Crud->SingleRecord('sale_agent."Agents"', $SaleAgentwhere);
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
            $Crud->Track("Login", $SaleAgentRecords['FullName'] . ' Login as "Sale Agent" in system at "' . date("d M, Y h:i:s") . '"');
            $response['status'] = "success";
            $response['message'] = "You are successfully logged as (" . $SaleAgentRecords['FullName'] . ") Sale Agent";

        }


        $where = array("UID" => $ID, "Type" => $type);
        $Agent = $Crud->SingleRecord('main."Agents"', $where);

        $where = array("Name" => $Agent['Domain']);
        $AgentDomain = $Crud->SingleRecord('websites."Domains"', $where);

        $SQL = '';
        $SQL .= 'SELECT "main"."Agents".*
                 FROM "main"."Agents"
                 WHERE "main"."Agents"."UID" = \'' . $ID . '\' AND "main"."Agents"."Type" = \'' . $type . '\'
                 AND "main"."Agents"."Archive" = 0  ';

        if ($AgentDomain['UID']) {
            $SQL .= 'AND "main"."Agents"."WebsiteDomain" IN (' . $Agent['WebsiteDomain'] . ',' . $AgentDomain['UID'] . ')';
        } else {
            $SQL .= 'AND "main"."Agents"."WebsiteDomain" = ' . $DomainID['UID'] . ' ';
        }

        //echo $SQL;
        $AgentR = $Crud->ExecuteSQL($SQL);
        $AgentRecords = $AgentR[0];

        $UsersRecords = $Crud->SingleRecord('main."Users"', array("UID" => $ID, "UserType" => $type));
        if ($UsersRecords['UID'] == $ID && $UsersRecords['UserType'] == $type) {
//            echo " This is User ";exit;

//            print_r($UsersRecords);
//            exit;
            if (isset($UsersRecords['UID'])) {

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
                $response['status'] = "success";
                $response['message'] = "You are successfully logged";
            } else {
                $response['status'] = "fail";
            }
        } else if ($ID == $AgentRecords['UID'] && $type == $AgentRecords['Type']) {

//            echo " This is Agent";exit;

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
            $Crud->Track("Login", $AgentRecords['FullName'] . ' Login as "' . $AgentRecords['Type'] . ' Agent" in system at "' . date("d M, Y h:i:s") . '"');
            $response['status'] = "success";
            $response['logged_id'] = $AgentRecords['UID'];
            $response['message'] = "You are successfully logged as (" . $AgentRecords['FullName'] . ") Agent";
        }

        echo json_encode($response);
    }


    public function external_agent()
    {
        $data = $this->data;

        $Operators = new Users();
        $data['records'] = $Operators->ListExternalAgents();

        echo view('header', $data);
        echo view('user/external_agent/index', $data);
        echo view('footer', $data);
    }

    public function operator()
    {
        $data = $this->data;

        $Operators = new Users();
        $data['records'] = $Operators->ListOperators();

        //print_r($data['records']);

        echo view('header', $data);
        echo view('user/operator/index', $data);
        echo view('footer', $data);
    }

    public function notification()
    {
        $data = $this->data;
        $Users = new Users();
        $Crud = new Crud();
        $session = session();
        $ID = $session->get('id');

        $data['Notifications'] = $Crud->ListRecords('main."UserNotifications"', array('UserID' => $ID), array('SystemDate' => 'DESC'));
        $Crud->ExecuteSQL("UPDATE main.\"UserNotifications\" SET \"ReadFlag\" = '1' WHERE main.\"UserNotifications\".\"UserID\" = " . $ID);

        echo view('header', $data);
        echo view('user_notification', $data);
        echo view('footer', $data);
    }

}
