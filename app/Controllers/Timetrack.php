<?php namespace App\Controllers;

use App\Models\Crud;
use App\Models\Main;

class Timetrack extends BaseController
{
    var $data = array();
    var $MainModel;
    var $Crud;

    public function __construct()
    {
        date_default_timezone_set('Asia/Karachi');
        helper('main');
        $this->MainModel = new Main();
        $this->Crud = new Crud();
        $this->data['path'] = PATH;
        $this->data['template'] = TEMPLATE;
        //$this->data = $this->MainModel->DefaultVariable();

        /*if ($this->data['page'] != 'login') {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }*/
        // Alter Database
        // $this->Crud->AlterDatabase();
        //echo "<pre>";
        //echo "Path:" . PATH . "<br>";
        //exit;
    }


    public function test()
    {
        $data = $this->data;
        //$MainModel = $this->MainModel;

        //HierarchyUsers(178);

//        $input = "Lala International";
//        $pass = PassWord($input, 'hide');
//        echo "<pre>";
//        echo "<h3>" . $input . " after enycrpt >> " . $pass . '<br />and after decrypt >>> ' . PassWord($pass, 'show') . "</h3>";

        /////////// Total External Pilgrim /////////

    }

    public function index()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;
        echo view('time_track', $data);


    }

    public function get_login_form_data()
    {
        $data = $this->data;
        $Crud = new Crud();
        $session  = session();
        $host = str_replace("panel.", "", $_SERVER['HTTP_HOST']);
        $table = 'websites."Domains"';
        $where = array('Name' => $host);
        $domain_ID = $Crud->SingleRecord($table, $where);
        $DomainID = $domain_ID['UID'];



        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $SQL = 'SELECT * FROM "main"."Users" Where "Users"."Email" = \'' . $email . '\'  AND "Users"."Password" = \'' . $password . '\' 
                 AND "Users"."UserType" = \'sale-officer\'     AND  "Users"."DomainID" = ' . $DomainID . ' ';

        $userdata = $Crud->ExecuteSQL($SQL);

        if (count($userdata)>0) {

            $NewUserData = [
                'id' => $userdata[0]['UID'],
                'name' => $userdata[0]['FullName'],
                'user_email' => 'Saleofficer@gmail.com',
                'user_type' => $userdata[0]['UserType'],
                'account_type' => 'sale-officer',
                'contact_number' => '03473288984',
                'mis_type' => 'other',
                'agent_id' => $userdata[0]['AgentID'],
                'parent_id' => $userdata[0]['ParentID'],
                'logged_type' => 'sale-officer',
                'logged_in' => TRUE
            ];
            $session->set($NewUserData);
            return redirect()->to(''.PATH.'time-track');
//             view('time_track',$data);
//            header("Location: ".PATH."/timetrack");

        }
        else {
            return redirect()->to(''.PATH.'time-track?msg=Invalid Login Details');
//            $data['message'] = 'Invalid Login Details';
//            echo view('time_track',$data);
        }
    }

    public function logout(){
        $data = $this->data;
        $session = session();
        $session->destroy();
        return redirect()->to(''.PATH.'time-track');
    }



}
