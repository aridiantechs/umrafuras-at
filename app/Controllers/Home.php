<?php namespace App\Controllers;

use App\Models\AccessLevel;
use App\Models\Agents;
use App\Models\Api;
use App\Models\CronModel;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\HRModel;
use App\Models\Main;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\Reportsprocess;
use App\Models\Users;
use App\Models\Voucher;
use App\Models\Dashboard;
use App\Models\Website;
use Spatie\DbDumper\Databases\PostgreSql;
use App\Models\Sales;

use \Mpdf\Mpdf;

class Home extends BaseController
{
    var $data = array();

    var $MainModel;
    var $validation;
    var $helpers = ['url', 'form' , 'user_agent'];

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();
        $this->validation = \Config\Services::validation();
        $session = session();
        if ($this->data['page'] != 'login' && $this->data['page'] != 'load_file') {

            $this->MainModel->CheckUser($session->get());
        }
    }

    public
    function pilgrim_test()
    {

        $Main = new Main();
        $PilgrimsArray = array(44064, 44058, 44038, 26560, 45485, 26683, 24396, 56032, 56030, 9259);
        //$PilgrimsData = $Main->GetPilgrimTypeDetails($PilgrimsArray);
        $PilgrimsData = $Main->AddVoucherVisaRate(543, 105);
        echo '<pre>';
        print_r($PilgrimsData);
        echo '<pre>';
        print_r($PilgrimsData);

        /*$Voucher = new Voucher();
        $HotelsData = $Voucher->GetVoucherAccommodationDetails(355);
        echo'<pre>';print_r($HotelsData);*/
    }

    public
    function brn()
    {

        $BRNType = getSegment(3);
        if ($BRNType == 'Visa') {

            $SQL = ' SELECT *,
                    ( SELECT COUNT( "meta"."UID" ) FROM pilgrim."meta"
                        WHERE "meta"."Option" = \'mofa-issued-brn\' 
                          AND CAST("meta"."Value" AS INTEGER) = CAST("BRN"."brn"."UID" AS INTEGER)
                        AND "meta"."Value" != \'\' ) AS "VisaUsedBRN"
                    FROM "BRN"."brn"
                    WHERE "BRN"."brn"."UseType" = \'' . $BRNType . '\' 
                    AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\'
                    ORDER BY "BRN"."brn"."ExpireDate" ';

        } else if ($BRNType == 'visa_and_hotel') {

            $MainArray = $MetaKeys = array();
            $ALlMetaKeys = '';
            $AllowHotel = StatusCheckList();
            $CheckInMecca = StatusCheckList();
            $CheckInMedina = StatusCheckList();
            $CheckInJeddah = StatusCheckList();

            $MainArray = array_merge(
                $AllowHotel['AllowHotel'], $CheckInMecca['CheckInMecca'], $CheckInMedina['CheckInMedina'], $CheckInJeddah['CheckInJeddah']
            );
            foreach ($MainArray as $Array) {
                $MetaKeys[] = "'" . $Array . "-brn-no'";
            }
            $MetaKeys[] = "'mofa-issued-brn'";
            $ALlMetaKeys = implode(',', $MetaKeys);
            $SQL = ' SELECT "brn"."UID", "brn"."BRNCode", "brn"."Beds", "brn"."GenerateDate", "brn"."ActiveDate", 
                    "brn"."ExpireDate", "brn"."BRNType", "brn"."UseType", 
                    ( SELECT COUNT( "meta"."UID" ) 
                        FROM pilgrim."meta"
                        JOIN pilgrim."master" ON ("master"."UID" = "meta"."PilgrimUID")
                        WHERE "meta"."Option" IN (' . $ALlMetaKeys . ') 
                          AND CAST("meta"."Value" AS INTEGER) = CAST("BRN"."brn"."UID" AS INTEGER) 
                          AND pilgrim."master"."DOBInYears" >= 8 AND pilgrim."master"."DOBInYears" IS NOT NULL
                          ) AS "VisaAndHotelUsedBRN"
                    FROM "BRN"."brn"
                    WHERE "BRN"."brn"."UseType" = \'' . $BRNType . '\' 
                    AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\'
                    ORDER BY "BRN"."brn"."ExpireDate" ';

        } else if ($BRNType == 'visa_and_transport') {

            $MainArray = $MetaKeys = array();
            $ALlMetaKeys = '';
            $AllowTransport = StatusCheckList();
            $CheckOutMecca = StatusCheckList();
            $CheckOutMedina = StatusCheckList();
            $CheckOutJeddah = StatusCheckList();

            $MainArray = array_merge(
                $AllowTransport['AllowTransport'], $CheckOutMecca['CheckOutMecca'], $CheckOutMedina['CheckOutMedina'], $CheckOutJeddah['CheckOutJeddah']
            );
            foreach ($MainArray as $Array) {
                $MetaKeys[] = "'" . $Array . "-brn-no'";
            }
            $MetaKeys[] = "'mofa-issued-brn'";
            $ALlMetaKeys = implode(',', $MetaKeys);

            $SQL = ' SELECT "brn"."UID", "brn"."BRNCode", "brn"."Seats", "brn"."GenerateDate", "brn"."ActiveDate", 
                    "brn"."ExpireDate", "brn"."BRNType", "brn"."UseType", 
                    ( SELECT COUNT( "meta"."UID" ) 
                        FROM pilgrim."meta"
                        JOIN pilgrim."master" ON ("master"."UID" = "meta"."PilgrimUID")
                        WHERE "meta"."Option" IN (' . $ALlMetaKeys . ') 
                          AND CAST("meta"."Value" AS INTEGER) = CAST("BRN"."brn"."UID" AS INTEGER) 
                          AND pilgrim."master"."DOBInYears" >= 2 AND pilgrim."master"."DOBInYears" IS NOT NULL
                          ) AS "VisaAndHotelUsedBRN"
                    FROM "BRN"."brn"
                    WHERE "BRN"."brn"."UseType" = \'' . $BRNType . '\' 
                    AND "BRN"."brn"."ExpireDate" >= \'' . date("Y-m-d", strtotime("-2 days")) . '\'
                    ORDER BY "BRN"."brn"."ExpireDate" ';
        }


        echo nl2br($SQL);

    }


    public function Accesslvelsssssss($id, $userType)
    {
        $data = $this->data;
        $Users = new Users();
        //$id = $data['session']['id'];
        $Accesslevel = new AccessLevel();
        switch ($userType) {
            case "accountant":
                $test = $Accesslevel->accountantAgentAccessLevel();
                break;
            case "activity-incharge":
                $test = $Accesslevel->activityInchargeAgentAccessLevel();
                break;
            case "admin":
                $test = $Accesslevel->adminAgentAccessLevel();
                break;
            case "sub-admin":
                $test = $Accesslevel->subadminAccessLevel();
                break;
//            case "agent":
//                $test = $Accesslevel->agentAccessLevel();
//                break;
//            case "external_agent":
//                $test = $Accesslevel->externalAgentAccessLevel();
//                break;
            case "mofa-admin":
                $test = $Accesslevel->mofaAdminAgentAccessLevel();
                break;
//            case "sale_agent":
//                $test = $Accesslevel->saleAgentAccessLevel();
//                break;
            case "voucher-admin":
                $test = $Accesslevel->voucherAdminAgentAccessLevel();
                break;
            case "sale-officer":
                $test = $Accesslevel->SalesOfficerPreDefinedAccessLevel();
                break;
            default:
                break;
        }
        $Users->AgentsAccessLevel($id, $test, $userType);


    }


    public function saad_test()
    {
//        $test = ShiftSession('7', 'admin');
//        echo $test;

//        $session = $data['session'];
//        print_r(BellNotificationUsers('111'));
//        $Record = BellNotificationUsers('22');
//        foreach($Record as $value)
//        {
//            echo $value;
//        }
//
//        LeadDuplicateCheck('B2B','923005550339');
//        $final = array();
//        $final[] = '923005550339';
//        $final[] = '923007550339';
//        $final[] = '923005350339';
//        $final = array_unique($final);
//        $ContactNumbers = implode("','", $final);
//        $ContactNumbers = "'" . $ContactNumbers . "'";
//        echo $ContactNumbers;
//        exit;


//        $Report = new ReportsProcess();
//
//        $data['InitialTrainingData'] = $Report::InitialTrainingReportData();
//        print_r($data['InitialTrainingData']);

//        BellNotification('New Voucher With Code wow code  Added In System', 'Voucher', '234', GetParentIDOfUser('22'));
//        BellNotification('This Is Test Notifications', 'This is the segment where you are putting it in', 'test3', $session['id']);
//        echo $test;
        $data = $this->data;

      print_r($data['StatusStatsColorsArray']['5']);
    }

    public function temp_email()
    {
        echo "<pre>";
        $data = $this->data;
        $Crud = new Crud();
//        $rslt = $Crud->CountRecordsWithCondition('"pilgrim"."master"',array('Nationality'=>'Pakistan'));
//        print_r($rslt);

        $Counters = new Pilgrims();
        $NotCheckinMeccaCounts = $Counters->StatusExceptCount("'departure-jeddah'");
//        print_r($NotCheckinMeccaCounts);
        echo count($NotCheckinMeccaCounts);

    }

    public function SendEmail2()
    {
        echo "<pre>";
        $data = $this->data;
        $Crud = new Crud();

        ini_set("SMTP", "mail.umrahfuras.com");
        ini_set('smtp_port', 465);
        ini_set('username', "accounts@umrahfuras.com");
        ini_set('password', "Accounts@LALA");
        ini_set("sendmail_from", "accounts@umrahfuras.com");


        return mail($to, $subject, $Text);


    }


    function SendEmail($view = false)
    {
        $data = array();
        $data['template'] = TEMPLATE;
        $data['path'] = PATH;


        $subject = 'Test Subject';
        $html = 'This is test Email';
        $to = 'p146057@nu.edu.pk';

        $email = \Config\Services::email();
        $config['protocol'] = 'sendmail';

        $config['charset'] = 'iso-8859-1';
        $config['wordWrap'] = true;
        $config['priority'] = 1;
        $config['mailType'] = 'html';
        $config['userAgent'] = 'UmrahFuras';

        $config['SMTPHost'] = 'mail.umrahfuras.com';
        $config['SMTPUser'] = 'accounts@umrahfuras.com';
        $config['SMTPPass'] = 'Accounts@LALA';
        $config['SMTPPort'] = '465';

        $data['subject'] = $subject;
        $email->initialize($config);
        $email->setFrom('accounts@umrahfuras.com', 'Test Umrah Email');
        $email->setTo($to);

        $email->setBCC('p146057@nu.edu.pk');
        $email->setSubject($subject . ' :: ' . date("d M, Y h:i:s a"));


        if ($view) {
            echo $html;
            exit;
        }

        $email->setMessage($html);
        return $email->send();
    }


    public function umrah_testing()
    {
        echo "<pre>";
        $data = $this->data;
//        print_r($data['session']); exit;
//        //print_r($data);
//        $FunName = 'ListAirlines';
//
//        $Main = new Main();
//        $settings = $Main->$FunName();
//        print_r($settings);

        $dateOfBirth = "1986-07-05";
        echo AGE($dateOfBirth);


//        $CroneModel = new CronModel();
//        $class_methods = get_class_methods($CroneModel);
//        foreach ($class_methods as $method_name) {
//            if ($method_name != '__construct') {
//                if ($method_name == 'UpdateCronActivity')
//                    break;
//            }
//        }

//        $CroneModel->CronActivity();
//        $start = date("Y-m-d H:i:s");
//        sleep(68);
//        $end = date("Y-m-d H:i:s");

//        echo "<br> Start: " . $start;
//        echo "<br> End: " . $end;
//        echo timeDiff($start, $end);


        exit;
    }

    public function testing()
    {
//        $data = $this->data;
//        $session = $data['session'];
//        HierarchyUsers($session['id']);
        //echo ROOT;
//        echo "<pre>";
//        GetWebsiteDomainIDs();
//        $VoucherCode = VoucherCode('153');
//        print_r($VoucherCode);
//        exit;
        $Crud = new Crud();
        $table = 'hr."leaves"';
        $where = array('Archive' => 0);
        $EmployeeLeaves = $Crud->ListRecords($table, $where);
//        echo "<pre>";
//        print_r($EmployeeLeaves);
//        exit;
        $FinalArray = array();

        foreach ($EmployeeLeaves as $value) {
//            $FinalArray[$value['UID']][$value['']] = $value['LeaveCategory'];

            $From = date('Y-m-d', strtotime($value['From']));
            $To = date('Y-m-d', strtotime($value['To']));
//            $To =  date('Y-m-d',strtotime($To . "+1 days"));
//            echo $To;

            for ($i = $From; $i <= $To; $i = date('Y-m-d', strtotime($i . "+1 days"))) {
                $FinalArray[$value['EmployeeID']][$i] = $value['LeaveCategory'];
            }


        }
        echo "<pre>";
        print_r($FinalArray);
        exit;


        exit;


        $Reports = new Reportsprocess();
        $Crud = new Crud();
        $rec = $Reports->htl_brn_purchase();
        $data['records'] = $Crud->ExecuteSQL($rec);

        echo "<pre>";
        print_r($data['records']);
        exit;

    }

    public function cron_activities()
    {

        $data = $this->data;
        $Main = new Main();
        $data['CronActivities'] = $Main->ListCronActivities();

//        print_r($data['CronActivities']);exit;

        echo view('header', $data);
        echo view('cron_activities', $data);
        echo view('footer', $data);

    }

    public function access_nav()
    {
        $data = $this->data;

        $AccessLevels = new Main();
        $Access = new AccessLevel();
        $data['AccessLevels'] = $AccessLevels->AccessLevels();
        $data['OtherAccessLevels'] = $Access->OtherAccessLevels();
        $data['CurrentAccessLevels'] = $AccessLevels->CurrentAccessLevels($data['userID']); //print_r($data['CurrentAccessLevels']);
        $SystemUsers = new Users();
        $data['Users'] = $SystemUsers->ListUsers();
        $data['Agentss'] = $SystemUsers->ListAgents($data['userID']);
        $data['SaleAgents'] = $SystemUsers->ListSaleAgents($data['userID']);
//        print_r($data['Agentss']);


        $data['CurUser'] = $SystemUsers->GetUser($data['userID']);
        echo view('access_nav1', $data);

    }

    public function truncate()
    {
        $data = $this->data;
        $Crud = new Crud();
        $Crud->TruncateRecord('main."Operators"');
        $Crud->TruncateRecord('main."Agents"');
        $Crud->TruncateRecord('main."ExternalAgent"');
        $Crud->TruncateRecord('pilgrim."master"');
        $Crud->TruncateRecord('pilgrim."mofa"');
        $Crud->TruncateRecord('pilgrim."visa"');
        $Crud->TruncateRecord('temp."mofa_file"');

        exit;
    }

    public function logout()
    {
        $data = $this->data;
        $session = session();
        $session->destroy();
        header("Location: " . base_url("home/login"));
        exit;
    }

    public function login()
    {
        $data = $this->data;
        echo view('agent/login', $data);
    }

    public function load_file()
    {
        $data = $this->data;
        ini_set('memory_limit', '512M');
        ob_start();
        $UID = (getSegment(3) == '') ? 0 : getSegment(3);
        $Crud = new Crud();
        $File = $Crud->SingleRecord('uploads."Files"', array("UID" => $UID));
        //echo "Load File Details: " . $File['UID']; echo $File['Ext']; exit;
        if (!isset($File['UID'])) {
            $File = $Crud->SingleRecord('uploads."Files"', array("UID" => 0));
        }

        // send headers then display image
        header('Content-Type: ' . $File['Ext']);
        header("Last-Modified: " . gmdate('D, d M Y H:i:s', $File['SystemDate']) . " GMT");
        header("Cache-Control: max-age=9999");
        header("Expires: " . gmdate("D, d M Y H:i:s", time() + 99999) . "GMT");
        echo base64_decode($File['Content']);
        exit;
    }


    public function signup()
    {
        $data = $this->data;
        echo view('agent/signup', $data);
    }

    public function index()
    {
        $data = $this->data;
        $session = $data['session'];
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();
//        echo "<pre>";print_r($data['DashboardCounters']);exit;
//        print_r($session);
//        exit;

//        echo "<pre>";
//        print_r($session);
//        exit;


        echo view('header', $data);

        if ($session['mis_type'] == "main") {


            if ($session['type'] == "admin") {
                if ($session['domain_parent'] == 1) {
                    echo view('dashboard/lala_services_dashboard', $data);
                } else {
                    echo view('dashboard/admin', $data);
                }
            } else if ($session['type'] == "mofa-admin") {
                echo view('dashboard/mofa-admin', $data);
            } else if ($session['type'] == "accountant") {
                echo view('dashboard/accountant', $data);
            } else if ($session['type'] == "voucher-admin") {
                echo view('dashboard/voucher-admin', $data);
            } else if ($session['type'] == "activity-incharge") {
                echo view('dashboard/activity-incharge', $data);
            } else if ($session['type'] == "sale-officer") {
                echo view('dashboard/sales_dashboard', $data);
            } else {
                echo view('dashboard/default', $data);
            }

        } else {
            echo view('dashboard/umrah_dashboard', $data);
//            $loadview = 'dashboard/' . $session['account_type'] . '-dashboard';
//            echo view($loadview, $data);
        }

        echo view('footer', $data);
    }


    public function ticket()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/ticket_dashboard', $data);
        echo view('footer', $data);
    }

    public function b2c()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/b2c_dashboard', $data);
        echo view('footer', $data);
    }

    public function tourism()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/tourism_dashboard', $data);
        echo view('footer', $data);
    }

    public function hotel()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/hotels_dashboard', $data);
        echo view('footer', $data);
    }

    public function transport()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/transports_dashboard', $data);
        echo view('footer', $data);
    }

    public function visa()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/visa_dashboard', $data);
        echo view('footer', $data);
    }

    public function umrah()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();

//        echo "<pre>";print_r($data['DashboardCounters']);exit;

        echo view('header', $data);
        echo view('dashboard/umrah_dashboard', $data);
        echo view('footer', $data);
    }

    public function visitor()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        echo view('header', $data);
        echo view('dashboard/visitor_dashboard', $data);
        echo view('footer', $data);
    }

    public function sales()
    {
        $data = $this->data;
        // echo "<pre>"; print_r($data);  exit;
        $DomainID = $data['session']['domainid'];

        /*$sales = new Sales();
        $data['total_leads'] = $sales->GetTotalLeads($DomainID);
        $data['fresh_leads'] = $sales->GetFreshLeads($DomainID);
        $data['un_assign_leads'] = $sales->GetUnAssignLeads($DomainID);
        $data['today_followup_leads'] = $sales->GetTodayFollowUpLeads($DomainID);
        $data['pending_followup_leads'] = $sales->GetPendingFollowUpLeads($DomainID);
        $data['upcoming_followup_leads'] = $sales->GetUpComingFollowUpLeads($DomainID);


        $data['count_leads_status'] = $sales->CountLeadStatus($DomainID);
        $data['count_leads_products'] = $sales->CountLeadProducts($DomainID);
        $data['agents_login_details'] = $sales->AgentsLoginDetails($DomainID);*/


        echo view('header', $data);
        echo view('dashboard/sales_dashboard', $data);
        echo view('footer', $data);
    }

    public function B2BSalesDashboard()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('dashboard/b2b_sales_dashboard', $data);
        echo view('footer', $data);
    }

    public function B2CSalesDashboard()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('dashboard/b2c_sales_dashboard', $data);
        echo view('footer', $data);
    }

    public function HumanResourceHR()
    {

        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $EmployeesData = new HRModel();

        echo view('header', $data);
        echo view('dashboard/human_resource_hr_dashboard', $data);
        echo view('footer', $data);
    }

    public function hajj()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();

        echo view('header', $data);
        echo view('dashboard/hajj_dashboard', $data);
        echo view('footer', $data);
    }

    public function stats()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $Dashboard = new Dashboard();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();
        /*echo "Dashboard Counter Array <br>";
        echo'<pre>';print_r($data['DashboardCounters']);echo'<br>'; exit;*/
        $data['OnlyHotels'] = $Dashboard->OnlyHotels();
        $data['OnlyTransport'] = $Dashboard->OnlyTransport();
        $data['OnlyExtras'] = $Dashboard->OnlyExtras();


        echo view('header', $data);
        echo view('dashboard/stats', $data);
        echo view('footer', $data);
    }

    public function agent_status_stats()
    {
        $data = $this->data;
        $DashboardCounters = new Main();
        $Dashboard = new Dashboard();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();
        $data['OnlyHotels'] = $Dashboard->OnlyHotels();
        $data['OnlyTransport'] = $Dashboard->OnlyTransport();
        $data['OnlyExtras'] = $Dashboard->OnlyExtras();


        echo view('header', $data);
        echo view('dashboard/agent_status_stats', $data);
        echo view('footer', $data);
    }

    public function activities()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('dashboard/activities', $data);
        echo view('footer', $data);
    }


    public function agent()
    {
        $data = $this->data;
        switch ($data['page']) {
            case "index";
                $loadview = "index";
                break;
        }

        echo view('header', $data);
        echo view('agent/' . $loadview, $data);
        echo view('footer', $data);
    }

    public function bookings()
    {
        $data = $this->data;

//        $data['Link'] = getSegment(3);

        echo view('header', $data);
        echo view('booking', $data);
        echo view('footer', $data);
    }

    public function pending_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('pending_booking', $data);
        echo view('footer', $data);
    }

    public function confirm_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('confirm_booking', $data);
        echo view('footer', $data);
    }

    public function expire_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('expire_booking', $data);
        echo view('footer', $data);
    }

    public function cancel_booking()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('cancel_booking', $data);
        echo view('footer', $data);
    }

    public function wallet()
    {
        $data = $this->data;


        echo view('header', $data);
        echo view('wallet', $data);
        echo view('footer', $data);
    }

    public function inbox()
    {
        $userprofile = session()->get('profile');
        $data = $this->data;

        helper(['curl']);
		$post_endpoint = '/inbox/getdata?email='.$userprofile['Email'];
		$response = perform_http_request('GET', $post_endpoint);
		

		$inbox = json_decode($response['body']);
        $data['inbox'] = $inbox;

        // echo('<pre>');
        // print_r($data['inbox']->data->deleted);
        // die();

        echo view('header', $data);
        echo view('inbox', $data);
        echo view('footer', $data);
    }

    public function saveEmail()
    {
        $filenames = array();
        if ($attachments = $this->request->getFiles()) {
            foreach ($attachments['email_attachments'] as $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'email_attachments', $newName);

                    $filenames[] = [
                        'filename' => WRITEPATH.$newName,
                        'originalname' => $file->getClientName(),
                    ];
                }
            }
        }

        $data = array(
            'from_email' => $this->request->getVar('from_email'),
            'to_email' => $this->request->getVar('to_email'),
            'cc_email' => $this->request->getVar('cc_email'),
            'email_attachments' => json_encode($filenames),
            'subject' => $this->request->getVar('subject'),
            'message' => $this->request->getVar('message'),
            'status' => 'new',
            'website' => 'umrahfuras.com',
        );

        helper(['curl']);
		$post_endpoint = '/inbox/save';
		$response = perform_http_request('POST', $post_endpoint , $data);
		

		$data = json_decode($response['body']);
        if ($response['httpcode'] == 200)
        {
            session()->setFlashdata('msg','<div class="alert alert-success text-center">New message is saved successfully!!!</div>');
            return redirect()->to(base_url('/home/inbox'));
        }
        else
        {
            session()->setFlashdata('msg','<div class="alert alert-danger text-center">Oops! Some Error.  Please try again later!!!</div>');
            return redirect()->to(base_url('/home/inbox'));
        }
    }

    public function deleteEmail()
    {
        if($this->request->getVar()){
            $data = array();
            foreach ($this->request->getVar() as $key => $value) {
                $inputs=explode("_",$key);
                $data[] = $inputs[1];
            }

            if(count($data) > 0){
                helper(['curl']);
                $post_endpoint = '/inbox/delete';
                $response = perform_http_request('POST', $post_endpoint , $data);
                
        
                $data = json_decode($response['body']);

                if ($response['httpcode'] == 200)
                {
                    session()->setFlashdata('msg','<div class="alert alert-success text-center">'.$data->data.'!!!</div>');
                    return redirect()->to(base_url('/home/inbox'));
                }
                else
                {
                    session()->setFlashdata('msg','<div class="alert alert-danger text-center">'.$data->data.'!!!</div>');
                    return redirect()->to(base_url('/home/inbox'));
                }
            }
        }else{
            session()->setFlashdata('msg','<div class="alert alert-danger text-center">Select email to delete!!!</div>');
            return redirect()->to(base_url('/home/inbox'));
        }
    }

    public function query($link = NULL)
    {
        $data = $this->data;
        $Query = new Website();
        $DomainId = $data['session']['domainid'];
        $navProducts = $data['session']['nav'];

        echo view('header', $data);

        switch ($link) {
            case 'important':
                $data['ImportantQuery'] = $Query->CustomerImportantQuery($DomainId, $navProducts);
                echo view('query/important_query', $data);
                break;
            case "resolved":
                $data['ResolvedQuery'] = $Query->CustomerStatusQuery($DomainId, $navProducts, "Resolved");
                echo view('query/resolved_query', $data);
                break;
            case "pending":
                $data['PendingQuery'] = $Query->CustomerStatusQuery($DomainId, $navProducts, "Pending");
                echo view('query/pending_query', $data);
                break;
            case "inprocess":
                $data['InProgressQuery'] = $Query->CustomerStatusQuery($DomainId, $navProducts, "InProgress");
                echo view('query/inprocess_query', $data);
                break;
            default:
                $data['CustomerSupportInfo'] = $Query->CustomerSupportDetails($DomainId, $navProducts);
                echo view('query', $data);
        }


        echo view('footer', $data);
    }

    public function change_status_query()
    {


        $Status = $this->request->getPost('Status');
        $Id = $this->request->getPost('UID');
        $change_status = new Website();
        $change_status->Status_query_record($Id, $Status);
    }


    public function dialogbox_data_query()
    {

        $data = $this->data;
        $Query = new Website();
        $Id = $this->request->getPost('UID');
        $DomainId = $data['session']['domainid'];
        $navProducts = $data['session']['nav'];

        $QueryData = $Query->fetch_All_QueryData($Id, $DomainId, $navProducts);

        echo json_encode($QueryData);
    }


    public function important_status_query()
    {
        $data = $this->data;
        $status_query = new Website();

        $Status = $this->request->getPost('Status');
        $Id = $this->request->getPost('UID');

        $Feature = $this->request->getPost('Featured');

        if ($Feature == 0) {
            $Feature = 1;
        } else {
            $Feature = 0;
        }
        $status_query->status_important_query($Status, $Id, $Feature);


    }

    public function delete_status_query()
    {

        $Id = $this->request->getPost('UID');

        $delete_query = new Website();
        $delete_query->delete_query_record($Id);
    }


    public function email_design()
    {
        $data = $this->data;
        echo view("email/body", $data);
    }

    public function mpdf_test()
    {
        $Main = new Main();

        $filename = 'test.pdf';
        $html = '<table width="100%" class="report">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Full Name</th>
                            <th>Contact</th>
                            <th style="width: 50% !important;">Description</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <td>1</td>
                            <td><b>جواد ساجد درانی</b></td>
                            <td>03165573588</td>
                            <td>یہ ایک طویل عرصے سے قائم حقیقت ہے کہ ایک قاری کسی صفحے کے پڑھنے کے قابل مواد سے اس کی ترتیب کو دیکھ کر پریشان ہو جائے گا۔</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><b>شہریار ملک</b></td>
                            <td>03165573588</td>
                            <td>یہ ایک طویل عرصے سے قائم حقیقت ہے کہ ایک قاری کسی صفحے کے پڑھنے کے قابل مواد سے اس کی ترتیب کو دیکھ کر پریشان ہو جائے گا۔</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><b>سعد ملک</b></td>
                            <td>03165573588</td>
                            <td>یہ ایک طویل عرصے سے قائم حقیقت ہے کہ ایک قاری کسی صفحے کے پڑھنے کے قابل مواد سے اس کی ترتیب کو دیکھ کر پریشان ہو جائے گا۔</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><b>اچھو جی</b></td>
                            <td>03165573588</td>
                            <td>یہ ایک طویل عرصے سے قائم حقیقت ہے کہ ایک قاری کسی صفحے کے پڑھنے کے قابل مواد سے اس کی ترتیب کو دیکھ کر پریشان ہو جائے گا۔</td>
                        </tr>
                    </thead>
                </table>';

        $footer = ' Testing MPDF Footer ';
        $head = 'Date: ' . date("d M, Y") . ' ';
        $Main->PDF($head, $html, $footer, $filename);
    }

}
