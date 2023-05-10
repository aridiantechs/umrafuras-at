<?php namespace App\Controllers;

use App\Models\AccessLevel;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Users;

class Setting extends BaseController
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


    public function settings()
    {
        $data = $this->data;

        list($domain_id) = explode("-", getSegment(3));

        $Crud = new Crud();
        $table = 'main."AdminSettings"';
        $data['AllSettings'] = $Crud->ListRecords($table, array("DomainID" => $domain_id), array("Segment" => "ASC", "Name" => "ASC"));
        //echo'<pre>';print_r($data['AllSettings']);exit;

        $data['DomainID'] = $domain_id;

        echo view('header', $data);
        echo view('setting/settings', $data);
        echo view('footer', $data);
    }

    public function access_levels()
    {
        $data = $this->data;


        $Crud = new Crud();
        $data['userID'] = (getSegment(3) == '') ? $data['session']['id'] : getSegment(3);

        $AccessLevels = new Main();
        $Access = new AccessLevel();

        $data['AccessLevels']['home'] = $Access->HomeNavigationAccessLevel();
        $data['AccessLevels']['ticket'] = $Access->TicketNavigationAccessLevel();
        $data['AccessLevels']['umrah'] = $Access->UmrahNavigationAccessLevel();
        $data['AccessLevels']['hotel'] = $Access->HotelNavigationAccessLevel();
        $data['AccessLevels']['transport'] = $Access->TransportNavigationAccessLevel();
        $data['AccessLevels']['tourism'] = $Access->TourismNavigationAccessLevel();
        $data['AccessLevels']['hajj'] = $Access->HajjNavigationAccessLevel();
        $data['AccessLevels']['visa'] = $Access->VisaNavigationAccessLevel();
        $data['AccessLevels']['visitor'] = $Access->VisitorNavigationAccessLevel();
        $data['AccessLevels']['sales'] = $Access->SalesNavigationAccessLevel();
        $data['AccessLevels']['hr'] = $Access->HumanResourceNavigationAccessLevel();


//      echo"<pre>";print_r( $data['AccessLevels']);exit;
        $data['OtherAccessLevels'] = $Access->OtherAccessLevels();
        $data['CurrentAccessLevels'] = $AccessLevels->CurrentAccessLevels($data['userID']); //print_r($data['CurrentAccessLevels']);
        $SystemUsers = new Users();
        $data['Users'] = $SystemUsers->ListUsers();
        $data['Agentss'] = $SystemUsers->ListAgents($data['userID']);
        $data['SaleAgents'] = $SystemUsers->ListSaleAgents($data['userID']);
//        print_r($data['Agentss']);


        $data['CurUser'] = $SystemUsers->GetUser($data['userID']);
        $data['NewUserData'] = $SystemUsers->GetAllUsersData($data['userID']);

        echo view('header', $data);
        echo view('setting/access_levels', $data);
        echo view('footer', $data);
    }

    public function activity_log()
    {
        $data = $this->data;

        $MainModel = $this->MainModel;
        $data['ActivitiesLOGs'] = $MainModel->ActivitiesLog();

        echo view('header', $data);
        echo view('setting/activity_log', $data);
        echo view('footer', $data);
    }

    public function websites_domains()
    {
        $data = $this->data;

        $MainModel = $this->MainModel;
        $data['ActivitiesLOGs'] = $MainModel->WebsiteDomains();

        echo view('header', $data);
        echo view('setting/websites_domains', $data);
        echo view('footer', $data);
    }

    public function download_database()
    {
        $data = $this->data;
        helper('filesystem');
        $MainModel = $this->MainModel;
        $data['ActivitiesLOGs'] = $MainModel->ActivitiesLog();

        $data['FilesName'] = get_dir_file_info(ROOT . "/db/auto_backup/");


        echo view('header', $data);
        echo view('setting/database_download', $data);
        echo view('footer', $data);
    }

    public function lookups()
    {
        $data = $this->data;

        $Groups = new Main();
        $data['records'] = $Groups->ListLookups();


        echo view('header', $data);
        echo view('lookups/index', $data);
        echo view('footer', $data);
    }

    public function lookup_options()
    {
        $data = $this->data;
        $Crud = new Crud();

        $data['lookup_key'] = getSegment(3);

        $table = 'main."Lookups"';
        $where = array("Key" => $data['lookup_key']);
        $data['lookup'] = $Crud->SingleRecord($table, $where);
//        print_r($data['lookup']);

        $table = 'main."LookupsOptions"';
        $where = array("LookupID" => $data['lookup']['UID'], "Archive" => "0");
        $data['records'] = $Crud->ListRecords($table, $where, array("OrderID" => "ASC"));

        echo view('header', $data);
        echo view('lookups/lookups_options', $data);
        echo view('footer', $data);
    }


    public function language()
    {
        $data = $this->data;

        $Language = new Main();
        $data['records'] = $Language->ListLanguages();

        echo view('header', $data);
        echo view('languages/index', $data);
        echo view('footer', $data);
    }

    public function translations()
    {
        $data = $this->data;

        $Language = new Main();
        $data['translations'] = $Language->ListTranslations();
        $data['languages'] = $Language->ListLanguages();
        $data['DefaultKeys'] = $Language->DefaultTranslation();
        //     echo "<pre>";
        // print_r($data['translations']); exit;
        echo view('header', $data);
        echo view('languages/translations', $data);
        echo view('footer', $data);
    }


    public function cron_activities()
    {
        $data = $this->data;

//        $Language = new Main();
//        $data['translations'] = $Language->ListTranslations();

        echo view('header', $data);
        echo view('setting/cron_activities', $data);
        echo view('footer', $data);
    }


    public function umrah_calender()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('setting/calender/index', $data);
        echo view('footer', $data);
    }

    public
    function fetch_calender_records()
    {
        $data = $this->data;
        $dataList = array();
        $Main = new Main();

        $records = $Main->get_umrah_calender_datatables();
        $totalfilterrecords = $Main->count_umrah_calender_filtered();

        $cnt = $_POST['start'];
        foreach ($records as $record) {

            $cnt++;
            $sub_array = array();
            $actions = ' <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                            <a class="dropdown-item" href="#" onclick="LoadModal(\'setting/calender/add\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>
                        </div>';
            $sub_array[] = $cnt;
            $sub_array[] = $record['Year'];
            $sub_array[] = $record['Title'];
            $sub_array[] = DATEFORMAT($record['StartDate']);
            $sub_array[] = DATEFORMAT($record['EndDate']);
            if ($data['CheckAccess']['umrah_settings_umrah_calender_update']) {
                $sub_array[] = '<div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            ' . $actions . '
                                        </div>';
            } else {
                $sub_array[] = '-';
            }


            $dataList[] = $sub_array;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => $totalfilterrecords,
            "data" => $dataList
        );
        echo json_encode($output);
    }
//    public function okay(){
////        $data= $this->data;
//        $data['userID'] = (getSegment(3) == '') ? $data['session']['id'] : getSegment(3);
////        echo "<pre>";
////        print_r($data['userID']);
////        exit;
//        $user = New Users();
//        $user->HomeNavigationTest($data['userID']);
//    }
}
