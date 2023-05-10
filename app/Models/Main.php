<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Languagetranslation;
use CodeIgniter\Model;
use App\Models\Excel;

use App\Libraries\pdf;


class Main extends Model
{
    var $data = array();
    protected $table = 'websites."Domains"';

    public function __construct()
    {
        $this->data = $this->DefaultVariable();
        define("DOMPDF_UNICODE_ENABLED", true);
    }

    public
    function DefaultVariable()
    {
        helper('main');
        $data = array();
        $session = session();
        $Crud = new Crud();
        $LanguageTranslation = new Languagetranslation();
        date_default_timezone_set("Asia/Karachi");

        if (isset($_GET['agentlogin']) && !empty($_GET['agentlogin'])) {
            $code = $_GET['agentlogin'];
            $UsersRecords = json_decode(base64_decode($code), true);
            //print_r($UsersRecords);
            $where = array("UID" => $UsersRecords['id']);
            $UsersRecords = $Crud->SingleRecord('main."Agents"', $where);

            $newdata = [
                'id' => $UsersRecords['UID'],
                'account_type' => $UsersRecords['Type'],
                'mis_type' => 'other',
                'type' => 'admin',
                'agent_id' => $UsersRecords['UID'],
                'parent_id' => $UsersRecords['ParentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_in' => TRUE
            ];

            $newdata_old = [
                'id' => $UsersRecords['UID'],
                'type' => $UsersRecords['Type'],
                'agent_id' => $UsersRecords['AgentID'],
                'parent_id' => $UsersRecords['ParentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_in' => TRUE
            ];
            $session->set($newdata);
        } else if (isset($_GET['adminlogin']) && !empty($_GET['adminlogin'])) {
            $code = $_GET['adminlogin'];
            $UsersRecords = json_decode(base64_decode($code), true);
            //print_r($UsersRecords);
            $where = array("UID" => $UsersRecords['id']);
            $UsersRecords = $Crud->SingleRecord('main."Users"', $where);

            $newdata = [
                'id' => $UsersRecords['UID'],
                'account_type' => $UsersRecords['UserType'],
                'mis_type' => 'main',
                'type' => 'admin',
                'agent_id' => $UsersRecords['AgentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_in' => TRUE
            ];

            $newdata_old = [
                'id' => $UsersRecords['UID'],
                'type' => $UsersRecords['UserType'],
                'agent_id' => $UsersRecords['AgentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_in' => TRUE
            ];
            $session->set($newdata);

        } else if (isset($_GET['saleagentlogin']) && !empty($_GET['saleagentlogin'])) {

            $code = $_GET['saleagentlogin'];
            $UsersRecords = json_decode(base64_decode($code), true);
            //print_r($UsersRecords);
            $where = array("UID" => $UsersRecords['id']);
            $UsersRecords = $Crud->SingleRecord('sale_agent."Agents"', $where);

            $newdata = [
                'id' => $UsersRecords['UID'],
                'account_type' => 'sale_agent',
                'mis_type' => 'other',
                'type' => 'admin',
                'agent_id' => $UsersRecords['UID'],
                'parent_id' => $UsersRecords['ParentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_type' => 'sale_agent',
                'logged_in' => TRUE
            ];
            $session->set($newdata);
        }

        $data['parent_mis'] = array('lalaservices.com', 'localhost');
        $data['session'] = $session->get();
        $data['hostdomain'] = str_replace("panel.", "", $_SERVER['HTTP_HOST']);
        //echo "<pre>"; print_r($data['session']);exit;

        /////////////// Language selection
        if (!isset($data['session']['lang'])) {
            $data['session']['lang'] = 'en';
        }
        if (isset($_GET['lang']) && !empty($_GET['lang'])) {
            $lang = array(
                'lang' => $_GET['lang']
            );
            $data['session']['lang'] = $_GET['lang'];
            $session->set($lang);
        }
        $language = $data['session']['lang'];
        $data['template'] = TEMPLATE;
        if ($language == 'ar') {
            $data['template'] = TEMPLATE . "rtl/";
        } else {
            $data['template'] = TEMPLATE;
        }

        //echo $data['template']; exit;

        /////////////// Theme selection
        if (!isset($data['session']['theme'])) {
            $data['session']['theme'] = 'light';
        }

        /*if (isset($_GET['theme']) && !empty($_GET['theme'])) {
            $lang = array(
                'theme' => $_GET['theme']
            );
            $data['session']['theme'] = $_GET['theme'];
            $session->set($lang);
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
            header("Content-Type: application/xml; charset=utf-8");
        }*/

        /*
         * $theme = $data['session']['theme'];
         * if ($theme == 'dark') {
            $data['template'] = TEMPLATE . "dark/";
        }*/

        /////////////// Nav selection
        if (!isset($data['session']['nav'])) {
            //$data['session']['nav'] = 'home';
            $data['session']['nav'] = 'umrah'; //// temporary setting, plz remove when live
        }
        if (isset($_GET['nav']) && !empty($_GET['nav'])) {
            $nav = array(
                'nav' => $_GET['nav']
            );
            $data['session']['nav'] = $_GET['nav'];
            $session->set($nav);
        }
        //echo $data['session']['nav'];


        if (!isset($data['session']['domain_parent'])) {
            $Crud = new Crud();
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $records = $Crud->SingleRecord($table, $where);
            $data['session']['domain_parent'] = $records['ParentID'];
            $session->set(array('domain_parent' => $records['ParentID']));
            if ($records['ParentID'] == 1) {
                $data['session']['domainid'] = 0;
                $session->set(array('domainid' => 0));
            }
        }

        /////////////// default admin
        if (isset($_GET['domainid']) && $_GET['domainid'] != '') {
            $domain = array(
                'domainid' => $_GET['domainid']
            );
            $data['session']['domainid'] = $_GET['domainid'];
            $session->set(array('domainid' => $_GET['domainid']));
        }
        //echo $data['session']['domainid'];

        if (!isset($data['session']['domainid'])) {
            $Crud = new Crud();
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $records = $Crud->SingleRecord($table, $where);
            $data['session']['domainid'] = $records['UID'];
            $session->set(array('domainid' => $records['UID']));
        }

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $data['session']['domain_parent'] = 1;
            $session->set(array('domain_parent' => 1));
        }
        // echo $data['session']['domainid'];
        //print_r($data['session']);exit;

        $data['GetDomainID'] = $this->GetWebsiteDomainID($data['session']['domainid']);
        $data['GetParentID'] = $this->GetWebsiteParentID($data['session']['domainid']);
        $data['UmrahCalendar'] = $this->ListUmrahCalendar();

        $data['path'] = PATH;
        $data['module'] = getSegment(1);
        $data['page'] = getSegment(2);
        $data['domain'] = getSegment(3);

        ///////////////////////////////////////    T H E M E    ///////////////////////////////////////
        $data['domain_themes'] = array();
        $data['domain_themes']['localhost']['logo'] = 'shield_logo_lala_services.png';
        $data['domain_themes']['localhost']['site'] = "Local Host MIS";
        $data['domain_themes']['localhost']['pdfcss'] = "dompdf-records.css";
        $data['domain_themes']['localhost']['pdflogo'] = "umrah-furas-logo.png";

        $data['domain_themes']['lalaservices.com']['logo'] = 'shield_logo_lala_services.png';
        $data['domain_themes']['lalaservices.com']['site'] = "Lala Services MIS";
        $data['domain_themes']['lalaservices.com']['pdfcss'] = "dompdf-records.css";
        $data['domain_themes']['lalaservices.com']['pdflogo'] = "v-lala-services-logo.png";

        $data['domain_themes']['tripplanner.ae']['logo'] = 'shield_logo_trip_planner.png';
        $data['domain_themes']['tripplanner.ae']['site'] = "Trip Planer MIS";
        $data['domain_themes']['tripplanner.ae']['pdfcss'] = "dompdf-records.css";
        $data['domain_themes']['tripplanner.ae']['pdflogo'] = "v-trip-planner-logo.png";

        $data['domain_themes']['umrahfuras.com']['logo'] = 'shield_logo.png';
        $data['domain_themes']['umrahfuras.com']['site'] = "Umrah Furas MIS";
        $data['domain_themes']['umrahfuras.com']['pdfcss'] = "dompdf-records.css";
        $data['domain_themes']['umrahfuras.com']['pdflogo'] = "umrah-furas-logo.png";

        $data['domain_themes']['lalaintltravel.pk']['logo'] = 'shield_logo_lala_intl_travel.png';
        $data['domain_themes']['lalaintltravel.pk']['site'] = "LALA Intl Travel MIS";
        $data['domain_themes']['lalaintltravel.pk']['pdfcss'] = "lalaintltravel.pk-dompdf-records.css";
        $data['domain_themes']['lalaintltravel.pk']['pdflogo'] = "v-lala-international-logo.png";

        $data['domain_themes']['111.68.99.227']['logo'] = 'shield_logo.png';
        $data['domain_themes']['111.68.99.227']['site'] = "Umrah Furas MIS";
        $data['domain_themes']['111.68.99.227']['pdfcss'] = "dompdf-records.css";
        $data['domain_themes']['111.68.99.227']['pdflogo'] = "umrah-furas-logo.png";

        $data['site'] = $data['domain_themes'][$data['hostdomain']]['site'];

        if ($data['session']['account_type'] == "agent" || $data['session']['account_type'] == "external_agent") {
            $data['AgentLogged'] = true;

        } else {
            $data['AgentLogged'] = false;
        }

        $data['session']['AgentLogged'] = $data['AgentLogged'];
        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array();
        $order = array("Name" => "ASC");
        $data['Domains'] = $Crud->ListRecords($table, $where, $order);

        $GroupsModel = new Groups();
        $AgentsModel = new Agents();
        $UsersModel = new Users();

        /* All Static Arrays */

        $data['HostThemes'] = array(
            'panel.lalaservices.com' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => ''),
            'panel.umrahfuras.com' => array('title' => 'Umrah Furas', 'logo' => 'shield_logo.png', 'apk' => 'Umrah_Furas_Mobile_Custom.apk'),
            'panel.tripplanner.ae' => array('title' => 'Trip Planner', 'logo' => 'shield_logo_trip_planner.png', 'apk' => 'Trip_Planner_Mobile_15746753.apk'),
            'panel.lalaintltravel.pk' => array('title' => 'Lala Intl. Travel', 'logo' => 'shield_logo_lala_intl_travel.png', 'apk' => ''),
            'localhost' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => 'Umrah_Furas_Mobile_Custom.apk'),
            'umrahfuras.test' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => 'Umrah_Furas_Mobile_15746553.apk'),
        );


        /** Language
         * Translation
         * Segment Start
         */

        $LanguageTranslation->AlterLangTranslations();
        $data['language_translation'] = $LanguageTranslation->GetLanguageTranslationData($language);

        /** Language
         * Translation
         * Segment Ends
         */

        $data['Statuses'] = $this->Status();
        $data['RoomTypes'] = $this->RoomType();
        $data['PackageTypes'] = $this->PackageType();
        $data['FoodTypes'] = $this->FoodType();
        $data['TransportTypes'] = $this->TransportType();
        $data['PassportTypes'] = $this->PassportType();
        $data['user_types'] = $this->UserType();
        $data['UmrahOperators'] = $this->ListUmrahOperator();

        $data['user_category'] = $this->UserCategory();
        $data['account_types'] = $this->AccountTypes();
        $data['relations'] = $this->Relations();
        $data['Embassies'] = $this->Embassies();
        $data['agent_types'] = $this->AgentTypes();
        $data['CheckAccess'] = $this->CheckAccessLevel();
        $data['Products'] = $this->Products();
        $data['LeaveCategory'] = $this->LeaveCategory();
        $data['HomeAccess'] = $this->CheckHomeAccess();
        $data['OrganicLookups'] = $this->ListOrganicLookups();
        $data['LeadStatusArray'] = $this->LeadStatusArray();
        $data['B2BLeadStatusArray'] = $this->B2BLeadStatusArray();
        $data['B2CLeadStatusArray'] = $this->B2CLeadStatusArray();
        $data['EmailDesign'] = $this->EmailDesign();
        $data['StatusStatsColorsArray'] = $this->StatusStatsColorsArray();
        /* All Dynamic  Arrays */

        /*Review This*/
        /*$data['Groups'] = $GroupsModel->ListGroups();*/

        if (!isset($data['session']['settings'])) {
            $data['settings'] = $this->Settings();
            $session->set(array('settings' => $data['settings']));
        } else {
            $data['settings'] = $data['session']['settings'];
        }

        if (!isset($data['session']['Languages'])) {
            $data['Languages'] = $this->ListLanguages();
            $session->set(array('Languages' => $data['Languages']));
        } else {
            $data['Languages'] = $data['session']['Languages'];
        }

        /* Arrays Loading on Administrator Login */
        //if ($data['session']['logged_type'] == 'user') {
        $data['Agents'] = $AgentsModel->ListAgents();
        $data['AllAgents'] = $AgentsModel->AllAgentList();
        $data['AgentsExceptSubAgents'] = $AgentsModel->ListAgentsExceptSubAgents();
        $data['AgentsExceptExternalAgents'] = $AgentsModel->ListAgentsExceptExternal();
        $data['AgentsDropDown'] = $AgentsModel->AgentsDropDown();
        //}

        $data['AllUsers'] = $UsersModel->ListUsers();
        $data['SubAgents'] = $AgentsModel->ListSubAgents();
        $data['DBStatuses'] = $this->StatusFromDb($data['session']['id']);
        $data['ExternalAgents'] = $AgentsModel->ListExternalAgents();


        /* Alter Database Segment */
        $Crud->AlterDatabase();


        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $Crud->AlterSalesDatabase();
        }
        $session->set($data['session']);

        return $data;
    }

    public function GetWebsiteDomainID($DomainID)
    {
        $Crud = new Crud();

        if ($DomainID == 0) {
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $ID = $Crud->SingleRecord($table, $where);
            $Domain = $ID['UID'];
        } else {
            $Domain = $DomainID;
        }

        return $Domain;
    }

    public function GetWebsiteParentID($DomainID)
    {
        $Crud = new Crud();

        if ($DomainID == 0) {
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $ID = $Crud->SingleRecord($table, $where);
            $Domain = $ID['ParentID'];
        } else {
            $Domain = $DomainID;
        }

        return $Domain;
    }

    public
    function ListUmrahCalendar()
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."UmrahCalender"';
        $where = array();
        $order = array("Year" => "DESC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function Status()
    {
        $data = $this->data;

        $records = array();
        $records['jeddah-arrival'] = "Jeddah Arrival";
        $records['medina-arrival'] = "Medina Arrival";
        $records['yanbu-arrival'] = " Yanbu Arrival";
        $records['sea-arrival'] = "Sea Arrival";
        $records['by-road-arrival'] = "By Road Arrival";
        $records['check-in-mecca'] = "Check In Mecca";
        $records['check-in-medina'] = "Check In Medina";
        $records['check-in-jeddah'] = "Check In Jeddah";
        $records['check-out-medina'] = "Check Out Medina";
        $records['check-out-mecca'] = "Check Out Mecca";
        $records['check-out-jeddah'] = "Check Out jeddah";
        $records['check-out-yanbu'] = "Check Out Yanbu";
        $records['without-hotel-arrival'] = "Without Hotel Arrival";
        $records['without-transport-arrival'] = "Without Transport Arrival";
        $records['departure-mecca'] = "Departure Mecca";
        $records['departure-medina'] = "Departure Medina";
        $records['departure-jeddah'] = "Departure Jeddah";
        $records['without-mofa'] = "Without Mofa";
        $records['with-mofa'] = "With Mofa";
        $records['mofa-issued'] = "Mofa Issued";
        $records['visa-not-printed'] = "Visa Not Printed";
        $records['visa-issued'] = "Visa issued";
        $records['travel-voucher-not-issued'] = "Travel Voucher Not Issued";
        $records['travel-voucher-issued'] = "Travel Voucher Issued";
        $records['with-transport-uo-arrival'] = "With Transport UO Arrival";
        $records['arrival'] = "Arrival";
        $records['allow-tpt-arrival'] = "Allow Transport Arrival";
        $records['allow-htl-mecca'] = "Allow Hotel Mecca";
        $records['allow-htl-mecca'] = "Allow Hotel Mecca";
        $records['allow-tpt-mecca'] = "Allow Transport Mecca";
        $records['allow-htl-medina'] = "Allow Hotel Medina";
        $records['allow-tpt-medina'] = "Allow Transport medina";
        $records['allow-tpt-yanbu'] = "Allow Transport Yanbu";
        $records['allow-htl-jeddah'] = "Allow Hotel Jeddah";
        $records['allow-tpt-jeddah'] = "Allow Transport Jeddah";
        $records['with-hotel-mecca-uo'] = "With Hotel Mecca UO";
        $records['with-transport-mecca-uo'] = "With Transport Mecca UO";
        $records['with-hotel-medina-uo'] = "With Hotel Medina UO";
        $records['with-transport-medina-uo'] = "With Transport Medina UO";
        $records['departure'] = "Departure";
        $records['return-to-country'] = "Return To Country";
        $records['elm-upload'] = "Elm File Upload";
        $records['exit-to-ksa'] = "Exit to KSA";
        $records['new'] = "New";

        return $records;
    }

    public
    function RoomType()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("UID" => "Double", "Title" => "Double");
        $records[] = array("UID" => "Triple", "Title" => "Triple");
        $records[] = array("UID" => "Quad", "Title" => "Quad");
        $records[] = array("UID" => "Sharing", "Title" => "Sharing");

        return $records;
    }

    public
    function PackageType()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("UID" => "1", "Title" => "Group Package");
        $records[] = array("UID" => "2", "Title" => "Individual Package");
        $records[] = array("UID" => "3", "Title" => "Budget Umrah Package");

        return $records;
    }

    public
    function FoodType()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("UID" => "1", "Title" => "Mutabaq");
        $records[] = array("UID" => "2", "Title" => "Basboosa");
        $records[] = array("UID" => "3", "Title" => "Shwarma");
        $records[] = array("UID" => "4", "Title" => "Baklava");
        $records[] = array("UID" => "5", "Title" => "Fool Tamees");

        return $records;
    }

    public
    function TransportType()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("UID" => "1", "Title" => "Bus");
        $records[] = array("UID" => "2", "Title" => "Hiace ");
        $records[] = array("UID" => "3", "Title" => "Coaster");
        $records[] = array("UID" => "4", "Title" => "Big Car (GMC)");
        $records[] = array("UID" => "5", "Title" => "Small Car");

        return $records;
    }

    public
    function PassportType()
    {
        $data = $this->data;

        $records = array();
        $records['Normal'] = "Normal";
//        $records[] = array("UID" => "Diplomatic", "Title" => "Diplomatic");
//        $records[] = array("UID" => "Offical", "Title" => "Offical");

        return $records;
    }

    public
    function UserType()
    {
        $data = $this->data;

        $records = array();
        $records['admin'] = "Admin";
        $records['accountant'] = "Accountant";
        $records['mofa-admin'] = "MOFA Administrator";
        $records['voucher-admin'] = "Voucher Administrator";
        $records['activity-incharge'] = "Activity In-Charge";
        $records['sub-admin'] = "Sub Admin";
        $records['sale-officer'] = "Sales Officer";
//        $records['sale_agent'] = "Sale Agent";
//        $records['external_agent'] = "External Agent";
//        $records['agent'] = "B2B Agent";


        ksort($records);
        return $records;
    }

    public
    function ListUmrahOperator()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Operators"';
        $where = array();
        $order = array("CompanyName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function UserCategory()
    {
        $data = $this->data;

        $records = array();
        $records['umrah'] = "Umrah";
        $records['visa'] = "Visa";
        $records['ticket'] = "Ticket";


        ksort($records);
        return $records;
    }

    public
    function AccountTypes()
    {
        $data = $this->data;

        $records = array();
        $records['sale_agent'] = "Sale Agent";
        $records['agent'] = "Agent";
        $records['external_agent'] = "External Agent";
        $records['sub_agent'] = "Sub Agent";
        $records['mis'] = "Users";

        ksort($records);
        return $records;
    }

    public
    function Relations()
    {
        $data = $this->data;

        $records = array();
        $records['Father'] = "Father";
        $records['Mother'] = "Mother";
        $records['Son'] = "Son";
        $records['Daughter'] = "Daughter";
        $records['Husband'] = "Husband";
        $records['Wife'] = "Wife";
        $records['Brother'] = "Brother";
        $records['Sister'] = "Sister";
        $records['Grandfather'] = "Grandfather";
        $records['Grandmother'] = "Grandmother";
        $records['Grandson'] = "Grandson";
        $records['Granddaughter'] = "Granddaughter";
        $records['Uncle'] = "Uncle";
        $records['Aunt'] = "Aunt";
        $records['Nephew'] = "Nephew";
        $records['Niece'] = "Niece";
        $records['Cousin'] = "Cousin";

        ksort($records);
        return $records;
    }

    public
    function Embassies()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("Title" => "Pakistan");
        $records[] = array("Title" => "Turkish");
        $records[] = array("Title" => "Indian");

        return $records;
    }

    public
    function AgentTypes()
    {
        $data = $this->data;

        $records = array();
        $records[] = array("UID" => "Online Travel Agent", "Type" => "Online Travel Agents");
        $records[] = array("UID" => "Inbound Tour Operators", "Type" => "Inbound Tour Operators");
        $records[] = array("UID" => "Visitor Information Centres", "Type" => "Visitor Information Centres");

        return $records;
    }

    public function CheckAccessLevel()
    {
        $data = $this->data;
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $AccessLevel = new AccessLevel();
        $table = 'main."AccessLevel"';
        $records = $Crud->ListRecords($table, array("UserID" => $data['session']['id']));
        //$records = $Crud->ListRecords($table, array("Access" => 1));
        //$records = $Crud->ListRecords($table);
        $Access = array();
        foreach ($records as $record) {
            $Access[$record['AccessKey']] = $record['Access'];
//              $Access[$record['AccessKey']] = 1;
        }

        return $Access;
    }

    public function Products()
    {
        $Products = ['home', 'ticket', 'umrah', 'hajj', 'hotel', 'transport', 'tourism', 'visa', 'visitor', 'sales', 'hr'];

        return $Products;
    }

    public function LeaveCategory()
    {
        $leaveCategory = [
            'half_day_leave' => array('name' => 'Half Day Leave', 'total' => 36),
            'short_leave' => array('name' => 'Short Leave', 'total' => 36),
            'sick_leave' => array('name' => 'Sick Leave', 'total' => 8),
            'casual_leave' => array('name' => 'Casual Leave', 'total' => 10),
            'annual_leave' => array('name' => 'Annual Leave', 'total' => 14),
            'hajj_umrah_leave' => array('name' => 'Hajj/Umrah Leave', 'total' => 20),
            'leave_without_pay' => array('name' => 'Leave Without Pay', 'total' => 10),
            'prolong_sick_leave' => array('name' => 'Prolong Sick Leave', 'total' => 90),
            'maternity_leave' => array('name' => 'Maternity Leave', 'total' => 90),
        ];

        /*
         * 3 Short = 1 Annual
         * 2 Half Days = 1 Annual
        */
        return $leaveCategory;
    }

    public
    function CheckHomeAccess()
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = 'SELECT count(main."AccessLevel"."UID") as "COUNTER"
                FROM main."AccessLevel" WHERE main."AccessLevel"."AccessKey" LIKE \'home_%\'
                AND main."AccessLevel"."UserID" = ' . $session['id'] . ' ';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function ListOrganicLookups()
    {
        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT main."Lookups".*  FROM main."Lookups"
              WHERE main."Lookups"."Key" LIKE \'organic-%\'  ';

        $SQL .= ' ORDER BY main."Lookups"."Name" ASC ';

        $Records = $Crud->ExecuteSQL($SQL);
        return $Records;
    }

    public function LeadStatusArray()
    {
        $LeadStatusArray = [
            'new' => 'New',
            'rate_issue' => 'Rate Issue',
            'follow_ups' => 'Follow Ups',
            'call_back' => 'Call Back',
            'sale' => 'Sale',
            'close' => 'Close'
        ];

        ksort($LeadStatusArray);
        return $LeadStatusArray;
    }


    public function B2CLeadStatusArray()
    {

        $LeadStatusArray = [
            'closed_clients' => 'Closed Clients',
            'followup' => 'Follow Up',
            'new' => 'New',
            'no_answer_callback' => 'No Answer/Callback',
            'sale' => 'Sale/Maturity',
            'visit_plan' => 'Visit Plan',
            'dealer' => 'Dealer',
            'interested' => 'Interested'
        ];


        ksort($LeadStatusArray);
        return $LeadStatusArray;
    }

    public function B2BLeadStatusArray()
    {
        $LeadStatusArray = [
            'closed_clients' => 'Closed Clients',
            'rate_issue' => 'Rate Issue',
            'umrah_package_issue_only_transport_visa' => 'Umrah Package issue Only Want Transport And Visa',
            'already_in_aggrement' => 'Already in Agreement',
            'past_experience' => 'Past Experience',
            'business_policy' => 'Business Policy',
            'client_busy' => 'Client Busy',
            'phone_not_responding' => 'Phone Not Responding',
            'asked_for_details' => 'Asked For Details',
            'potential_client' => 'Potential Client',
            'active_client' => 'Active Client'
        ];

        ksort($LeadStatusArray);
        return $LeadStatusArray;
    }

    public function EmailDesign()
    {
        $EmailDesignArray = ['design_1' => 'Design 1', 'design_2' => 'Design 2', 'design_3' => 'Design 3'];
        ksort($EmailDesignArray);
        return $EmailDesignArray;
    }

    public function StatusStatsColorsArray()
    {
        $ColorArray = array();

        $ColorArray = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4242e1', '#49b0a4', '#e2525d'];
        $ColorArray1 = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4242e1', '#49b0a4', '#e2525d'];
        $ColorArray2 = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4242e1', '#49b0a4', '#e2525d'];
        $ColorArray3 = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4f6cfd', '#49b0a4', '#e2525d'];
        $ColorArray4 = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4f6cfd', '#49b0a4', '#e2525d'];
        $ColorArray5 = ['#dda444', '#4f6cfd', '#8ac344', '#f77925', '#4f6cfd', '#49b0a4', '#e2525d'];

        $Merged = array_merge($ColorArray, $ColorArray1, $ColorArray2,$ColorArray3,$ColorArray4);

//        print_r($ColorArray);exit;

        return $Merged;
    }

    public
    function Settings($key = '')
    {

        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."AdminSettings"';

        if ($key == '') {

            $wheres = array('DomainID' => $data['session']['domainid']);
            $records = $Crud->ListRecords($table, $wheres);
            $settings = array();
            foreach ($records as $record) {
                $settings[$record['Key']] = $record['Description'];
            }
            return $settings;
        } else {
            $wheres = array('DomainID' => $data['session']['domainid'], 'Key' => $key);
            $records = $Crud->SingleRecord($table, $wheres);

            $settings[$key] = $records['Description'];
            return $records['Description'];
        }
    }

    public
    function ListLanguages()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Language"';
        $where = array();
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function StatusFromDb($ID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."UsersMeta"';
        $where = array("UserUID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        return $records;
    }

    public
    function DefaultAjaxVariable()
    {
        helper('main');
        $data = array();
        $session = session();
        $Crud = new Crud();

        if (isset($_GET['agentlogin']) && !empty($_GET['agentlogin'])) {
            $code = $_GET['agentlogin'];
            $UsersRecords = json_decode(base64_decode($code), true);
            //print_r($UsersRecords);
            $where = array("UID" => $UsersRecords['id']);
            $UsersRecords = $Crud->SingleRecord('main."Agents"', $where);

            $newdata = [
                'id' => $UsersRecords['UID'],
                'type' => $UsersRecords['UserType'],
                'agent_id' => $UsersRecords['AgentID'],
                'parent_id' => $UsersRecords['ParentID'],
                'name' => $UsersRecords['FullName'],
                'profile' => $UsersRecords,
                'logged_in' => TRUE
            ];
            $session->set($newdata);
        }

        $data['parent_mis'] = array('lalaservices.com', 'localhost');
        $data['session'] = $session->get();

        /////////////// Language selection
        if (!isset($data['session']['lang'])) {
            $data['session']['lang'] = 'en';
        }
        if (isset($_GET['lang']) && !empty($_GET['lang'])) {
            $lang = array(
                'lang' => $_GET['lang']
            );
            $data['session']['lang'] = $_GET['lang'];
            $session->set($lang);
        }
        $language = $data['session']['lang'];
        $data['template'] = TEMPLATE;
        if ($language == 'ar') {
            $data['template'] = TEMPLATE . "rtl/";
        }

        /////////////// Theme selection
        if (!isset($data['session']['theme'])) {
            $data['session']['theme'] = 'light';
        }
        if (isset($_GET['theme']) && !empty($_GET['theme'])) {
            $lang = array(
                'theme' => $_GET['theme']
            );
            $data['session']['theme'] = $_GET['theme'];
            $session->set($lang);
        }
        $theme = $data['session']['theme'];
        $data['template'] = TEMPLATE;
        if ($theme == 'dark') {
            $data['template'] = TEMPLATE . "dark/";
        }

        if (!isset($data['session']['domain_parent'])) {
            $Crud = new Crud();
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $records = $Crud->SingleRecord($table, $where);
            $data['session']['domain_parent'] = $records['ParentID'];
            $session->set(array('domain_parent' => $records['ParentID']));
            if ($records['ParentID'] == 1) {
                $data['session']['domainid'] = 0;
                $session->set(array('domainid' => 0));
            }
        }

        /////////////// default admin
        if (isset($_GET['domainid']) && $_GET['domainid'] != '') {
            $domain = array(
                'domainid' => $_GET['domainid']
            );
            $data['session']['domainid'] = $_GET['domainid'];
            $session->set(array('domainid' => $_GET['domainid']));
        }
        // echo $data['session']['domainid'];

        if (!isset($data['session']['domainid'])) {
            $Crud = new Crud();
            $table = 'websites."Domains"';
            $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
            $records = $Crud->SingleRecord($table, $where);
            $data['session']['domainid'] = $records['UID'];
            $session->set(array('domainid' => $records['UID']));
        }
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $data['session']['domain_parent'] = 1;
            $session->set(array('domain_parent' => 1));
        }

        //echo $data['session']['domainid'];
        //print_r($data['session']);exit;
        $data['GetDomainID'] = $this->GetWebsiteDomainID($data['session']['domainid']);

        $data['path'] = PATH;
        $data['module'] = getSegment(1);
        $data['page'] = getSegment(2);
        $data['domain'] = getSegment(3);

        $data['site'] = "Umrah Furas MIS";

        if ($data['session']['type'] == "agent") {
            $data['AgentLogged'] = true;
        } else {
            $data['AgentLogged'] = false;
        }

        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array();
        $order = array("Name" => "ASC");
        $data['Domains'] = $Crud->ListRecords($table, $where, $order);

        $AgentsModel = new Agents();
        $data['Agents'] = $AgentsModel->ListAgents();
//        $data['AllAgents'] = $AgentsModel->AllAgentList();
//        $data['AgentsDropDown'] = $AgentsModel->AgentsDropDown();
//        $data['SubAgents'] = $AgentsModel->ListSubAgents();
//
//        $GroupsModel = new Groups();
//        $data['Groups'] = $GroupsModel->ListGroups();
        $data['DBStatuses'] = $this->StatusFromDb($data['session']['id']);
//        //print_r($data['DBStatuses']);
//        $data['RoomTypes'] = $this->RoomType();
//        $data['PackageTypes'] = $this->PackageType();
//        $data['FoodTypes'] = $this->FoodType();
//        $data['TransportTypes'] = $this->TransportType();
//        $data['PassportTypes'] = $this->PassportType();
        //$data['Langauges'] = $this->ListLanguages();
        $data['user_types'] = $this->UserType();
        $data['UmrahOperators'] = $this->ListUmrahOperator();
        //$data['Embassies'] = $this->Embassies();
//        $data['agent_types'] = $this->AgentTypes();
        //$data['settings'] = $this->Settings();
        $data['CheckAccess'] = $this->CheckAccessLevel();
        $data['Products'] = $this->Products();
        $data['HomeAccess'] = $this->CheckHomeAccess();
        $data['EmailDesign'] = $this->EmailDesign();
        $data['OrganicLookups'] = $this->ListOrganicLookups();
//        $data['HostThemes'] = array(
//            'panel.lalaservices.com' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png'),
//            'panel.umrahfuras.com' => array('title' => 'Umrah Furas', 'logo' => 'shield_logo.png'),
//            'panel.tripplanner.ae' => array('title' => 'Trip Planner', 'logo' => 'shield_logo_trip_planner.png'),
//            'localhost' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png'),
//        );
        $data['HostThemes'] = array(
            'panel.lalaservices.com' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => ''),
            'panel.umrahfuras.com' => array('title' => 'Umrah Furas', 'logo' => 'shield_logo.png', 'apk' => 'Umrah_Furas_Mobile_15746553.apk'),
            'panel.tripplanner.ae' => array('title' => 'Trip Planner', 'logo' => 'shield_logo_trip_planner.png', 'apk' => 'Trip_Planner_Mobile_15746753.apk'),
            'panel.lalaintltravel.pk' => array('title' => 'Lala Intl. Travel', 'logo' => 'shield_logo_lala_intl_travel.png', 'apk' => ''),
            'localhost' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => 'Umrah_Furas_Mobile_15746553.apk'),
            '111.68.99.227' => array('title' => 'Umrah Furas', 'logo' => 'shield_logo.png', 'apk' => 'Umrah_Furas_Mobile_15746553.apk'),
            'umrahfuras.test' => array('title' => 'Lala Services', 'logo' => 'shield_logo_lala_services.png', 'apk' => 'Umrah_Furas_Mobile_15746553.apk'),
        );
        $data['Statuses'] = $this->Status();
        $Crud->AlterDatabase();
        return $data;
    }

    public
    function CheckUser($session)
    {
        if (!$session['logged_in']) {
            $data = $this->data;
            echo view('agent/login', $data);
            exit;
            //header("Location: " . base_url("home/login")); exit;
        }
    }

    public function CurrentAccessLevels($uid)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."AccessLevel"';
        $records = $Crud->ListRecords($table, array("UserID" => $uid));

        $Access = array();
        foreach ($records as $record) {
            $Access[$record['AccessKey']] = $record['Access'];
        }
        return $Access;
    }

    public
    function ListAirports()
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Airports"';
        $where = array();
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function CityCoverFilesFormSubmit($CoverImage, $CityID)
    {
        $Crud = new Crud();
        $table = 'main."Cities"';
        $record['CoverImage'] = $CoverImage;
        $where = array("UID" => $CityID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
            $response['message'] = "City Cover Successfully Updated...";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);

    }

    public
    function CityCoverFilesUpdateFormSubmit($CoverImage, $CityID)
    {
        $Crud = new Crud();
        $table = 'main."Cities"';
        $record['CoverImage'] = $CoverImage;
        $where = array("UID" => $CityID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
            $response['message'] = "City Cover Successfully Updated...";

        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function ListAirlines()
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Airlines"';
        $where = array("Status" => "Y");
        $order = array("FullName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function DashboardCounters()
    {
        $Agant = false;
        $data = $this->data;
        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $table = 'websites."stats"';
        $Counters = array();
        if ($data['session']['domainid'] == 0) {
            $SQL = 'SELECT * FROM websites."stats" WHERE 1=1';
            if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
                $AgentUIDS = HierarchyUsers($session['id']);
                $SQL .= ' AND websites."stats"."AgentID" IN (' . $AgentUIDS . ') ';
            }
            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {
                if (isset($Counters[$record['StatsKey']])) {
                    $Counters[$record['StatsKey']] += $record['Value'];
                } else {
                    $Counters[$record['StatsKey']] = $record['Value'];
                }
            }
        } else {
            $SQL = 'SELECT * FROM websites."stats" 
                    WHERE "DomainID" = ' . $data['session']['domainid'] . ' ';
            if (isset($session['mis_type']) && $session['mis_type'] == 'other' && isset($session['account_type']) && $session['account_type'] != 'admin') {
                $AgentUIDS = HierarchyUsers($session['id']);
                $SQL .= ' AND websites."stats"."AgentID" IN (' . $AgentUIDS . ') ';
            }
            //echo $SQL; exit;
            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {
                if (isset($Counters[$record['StatsKey']])) {
                    $Counters[$record['StatsKey']] += $record['Value'];
                } else {
                    $Counters[$record['StatsKey']] = $record['Value'];
                }
            }

        }
//        echo "<pre>";
//        print_r($data['session']);
//        print_r($where);
//        print_r($Counters);
//        exit;

        return $Counters;
    }

    public
    function UpdateSettings($records, $DefaultImage, $DomainID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."AdminSettings"';

//        print_r($DefaultImage['Image']);
        foreach ($records as $recordK => $recordV) {
            $Crud->UpdateRecord($table, array("Description" => $recordV), array("Key" => $recordK, "DomainID" => $DomainID));
            $Crud->UpdateRecord($table, array("Description" => $DefaultImage['Image']), array("Key" => 'default_image', "DomainID" => $DomainID));

        }

        $Crud->Track("System Setting", 'System Setting Updated.');
        $response['status'] = "success";
        $response['message'] = "Your System Settings Updated...";
        echo json_encode($response);
    }

    public
    function UpdateWebsiteSettings($records, $DomainID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'websites."Settings"';

//        print_r($DefaultImage['Image']);
        foreach ($records as $recordK => $recordV) {
            $Crud->UpdateRecord($table, array("Description" => $recordV), array("Key" => $recordK, "DomainID" => $DomainID));
        }

        $Crud->Track("System Setting", 'System Setting Updated.');

        $response['status'] = "success";
        $response['message'] = "Your System Settings Updated...";
        echo json_encode($response);
    }

    public function ActivitiesLog($limit = 0)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."AdminLog"';
        $where = array();
        $order = array("SystemDate" => "DESC");
        $records = $Crud->ListRecords($table, $where, $order, $limit);

        return $records;
    }

    public function WebsiteDomains()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array();
        $order = array("UID" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;
    }

    public
    function Origin()
    {
        $data = $this->data;

        $records = array();
        $records['mecca'] = "Mecca";
        $records['medina'] = "Medina";
        $records['yanbu'] = " Yanbu ";
        $records['jeddah'] = " Jeddah ";

        return $records;
    }

    public
    function OldAccessLevels()
    {
        $data = $this->data;
        $FinalArray = $TicketArray = $UmrahArray = array();


        $TicketArray['ticket_navigation']['ticket_home'] = 'Home';
        $TicketArray['ticket_navigation']['ticket_client']['ticket_b2c_client'] = 'B2C Client';
        $TicketArray['ticket_navigation']['ticket_booking']['ticket_all'] = 'All';
        $TicketArray['ticket_navigation']['ticket_booking']['ticket_pending'] = 'Pending';
        $TicketArray['ticket_navigation']['ticket_booking']['ticket_confirm'] = 'Confirm';
        $TicketArray['ticket_navigation']['ticket_booking']['ticket_expire'] = 'Expire';
        $TicketArray['ticket_navigation']['ticket_booking']['ticket_cancel'] = 'Cancel';
        $TicketArray['ticket_navigation']['ticket_issue'] = 'Ticket Issue';
        $TicketArray['ticket_navigation']['ticket_reissue'] = 'Ticket Re Issue';
        $TicketArray['ticket_navigation']['ticket_refund'] = 'Ticket Refund';
        $TicketArray['ticket_navigation']['ticket_traveling_tomorrow'] = 'Ticket Traveling Tomorrow';
        $TicketArray['ticket_navigation']['ticket_adm'] = 'Ticket ADM';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_detail_wise'] = 'Detail Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_country_wise'] = 'Country Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_month_wise'] = 'Month Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_year_wise'] = 'Year Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_airline_wise'] = 'Airline Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_Group_wise'] = 'Group Wise';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_international'] = 'International';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_domestic'] = 'Domestic';
        $TicketArray['ticket_navigation']['ticket_reports']['ticket_reports_vendors'] = 'Vendors';
        $TicketArray['ticket_navigation']['ticket_visitors'] = 'Visitors';
        $TicketArray['ticket_navigation']['ticket_query'] = 'Visitors';
        $TicketArray['ticket_navigation']['ticket_inbox'] = 'Inbox';
        $TicketArray['ticket_navigation']['ticket_wallet'] = 'Wallet';
        $TicketArray['ticket_navigation']['ticket_users'] = 'Users';
        $TicketArray['ticket_navigation']['ticket_logout'] = 'Logout';

        ksort($TicketArray);
        $FinalArray['ticket'] = $TicketArray;

        $UmrahArray['umrah_navigation']['umrah_home'] = 'Home';
        $UmrahArray['umrah_navigation']['umrah_dashboard'] = 'Ticket Dashboard';
        $UmrahArray['umrah_navigation']['umrah_client']['umrah_b2c_client'] = 'B2C Client';
        $UmrahArray['umrah_navigation']['umrah_client']['umrah_b2b_client'] = 'B2B Client';
        $UmrahArray['umrah_navigation']['umrah_client']['umrah_sale_agent_client'] = 'Sale Agent Client';
        $UmrahArray['umrah_navigation']['umrah_client']['umrah_external_agent']['umrah_external_agent_list'] = 'List';
        $UmrahArray['umrah_navigation']['umrah_client']['umrah_external_agent']['umrah_external_agent_sub_agents'] = 'Sub Agents';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_b2c_voucher'] = 'B2C Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_create_voucher'] = 'Create Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_all_voucher'] = 'All Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_pending_voucher'] = 'Pending Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_approved_voucher'] = 'Approved Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_updated_voucher'] = 'Updated Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_executed_voucher'] = 'Executed Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_refund_voucher'] = 'Refund Vouchers';
        $UmrahArray['umrah_navigation']['umrah_travel_check']['umrah_wdout_voucher_arrival'] = 'Wdout Voucher Arrrival';

        ksort($UmrahArray);
        $FinalArray['umrah'] = $UmrahArray;

        return $FinalArray;
    }

    public
    function OldOtherAccessLevels()
    {
        $data = $this->data;
        $records = array();

        $records['navigation']["agents"] = "Manage Agents";
        $records['navigation']["sub_agents"] = "Manage Sub Agents";
        $records['navigation']["b2c"] = "Manage B2C";
        $records['navigation']["groups"] = "Manage Groups";
        $records['navigation']["umrah_operator"] = "Manage Umrah Operators";
        $records['navigation']["visa_types"] = "Manage Visa Types";
        $records['navigation']["deleted_groups"] = "Manage Deleted Groups";
        $records['navigation']["pilgrim"] = "Manage Pilgrim";
        $records['navigation']["title_options"] = "Manage Title Options";
        $records['navigation']["add_pilgrim"] = "Add Pilgrim";
        $records['navigation']["hotels"] = "Manage Hotels";
        $records['navigation']["extra_services"] = "Manage Extra Services";
        $records['navigation']["transport"] = "Manage Transport";
        $records['navigation']["transport_types"] = "Manage Transport Types";
        $records['navigation']["transport_sectors"] = "Manage Transport Sectors";
        $records['navigation']["transport_companies"] = "Manage Transport Companies";
        $records['navigation']["land_borders"] = "Manage Land Borders";
        $records['navigation']["sea_ports"] = "Manage Sea Ports";
        $records['navigation']["ziyarats"] = "Manage Ziyarats";
        $records['navigation']["b2b_package"] = "Manage B2B Package";
        $records['navigation']["b2b_packages"] = "Manage B2B Packages For Sale Agent";
        $records['navigation']["b2c_package"] = "Manage B2C Package";
        $records['navigation']["b2b_general_package"] = "Manage B2B General Package";
        $records['navigation']["b2b_external_agent"] = "Manage B2B External Package";
        $records['navigation']["hotel_category"] = "Manage Hotel Category ";
        $records['navigation']["room_types"] = "Manage Room Types ";
        $records['navigation']["hotel_amenities"] = "Manage Hotel Amenities ";
        $records['navigation']["hotel_facilities"] = "Manage Hotel Facilities";
        $records['navigation']["pilgrim_activity"] = "Add Pilgrim Activity";
        $records['navigation']["visa_not_printed"] = "VISA Not Printed";
        $records['navigation']["visa_details"] = "Manage Visa Details";
        $records['navigation']["b2b_package"] = "Manage B2B Package";
        $records['navigation']["b2c_package"] = "Manage B2C Package";
        $records['navigation']["b2b_general_package"] = "Manage B2B General Package";
        $records['navigation']["b2b_external_agent"] = "Manage B2B External Package";
        $records['navigation']["users"] = "Manage Users";
        $records['navigation']["b2b_packages"] = "Manage B2B Packages For Sale Agent";
        $records['navigation']["access_levels"] = "Manage Access Levels";
        $records['navigation']["new_voucher"] = "Manage New Vouchers";
        $records['navigation']["executed_voucher"] = "Manage Executed Vouchers";
        $records['navigation']["without_voucher_arrival"] = "Manage Without Voucher Arrival";
        $records['navigation']["all_voucher"] = "Manage All Vouchers";
        $records['navigation']["updated_voucher"] = "Manage Updated Vouchers";
        $records['navigation']["refund_voucher"] = "Manage Refund Vouchers";
        $records['navigation']["pending_voucher"] = "Manage Pending Vouchers";
        $records['navigation']["voucher_summary"] = "Manage Voucher Summary";
        $records['navigation']["file_uploader"] = "Manage File Uploader";
        $records['navigation']["completed_passports"] = "Manage Completed Passports";
        $records['navigation']["approved_voucher"] = "Manage Approved Vouchers";
        $records['navigation']["website_domains"] = "Manage Approved Vouchers";

        $records['navigation']["pilgrim_transfer"] = "Manage Pilgrim Transfer";

        $records['navigation']["pending_passports"] = "Manage Pending Passports";
        $records['navigation']["brn_operators"] = "Manage BRN Operators";
        $records['navigation']["hotel_brn_list"] = "Manage Hotel BRN ";
        $records['navigation']["transport_brn_list"] = "Manage Transport BRN ";


        $records['reports']["stats"] = "Reports Stats";
        $records['reports']["all"] = "All Reports";

        $records['dashboard']["monthly_agent_graph"] = "Monthly Agent Graph";


        ksort($records);
        return $records;
    }

    public
    function DefaultTranslation()
    {
        $records = array();
        $records['monthly-agents-revenue'] = "Monthly Agents Revenue";
        $records['entered-today'] = "Entered Today";
        $records['exited-today'] = "Exited Today";
        $records['total-pilgrims'] = "Total Pilgrims";
        $records['total-pilgrims-data'] = "Total Pilgrims Data";
        $records['total-pilgrims-data-exits'] = "Total Pilgrims Data exists";
        $records['total-pilgrims-new'] = "Total Pilgrims New";
        ksort($records);
        return $records;
    }

    public function DefaultLookUps()
    {
        $records = array();
        $records[] = array("Key" => "hotel_category", "Name" => "Hotel Categories", "Description" => "3 star, 4 star etc.");
        $records[] = array("Key" => "agent_types", "Name" => "Agent Types", "Description" => "Agent Types like inbound Agent");
        $records[] = array("Key" => "transport_types", "Name" => "Transport Types", "Description" => "Cars , Buses, Hiace etc");
        $records[] = array("Key" => "room_types", "Name" => "Room Types", "Description" => "Double, Tripple, Quad, Quint, Sharing");
        $records[] = array("Key" => "visa_types", "Name" => "Visa Types", "Description" => "Umrah, Hajj, etc...");
        $records[] = array("Key" => "hotel_amenities", "Name" => "Hotel Amenities", "Description" => "Gym, Room Purification, Relaxation Device etc");
        $records[] = array("Key" => "hotel_facilities", "Name" => "Hotel Facilities", "Description" => "Parking, Room Service, Business Lounge etc");
        $records[] = array("Key" => "extra_services", "Name" => "Extra Services", "Description" => "You can mention extra services except Transport, Hotel & Ziyarats...");
        $records[] = array("Key" => "transport_sectors", "Name" => "Transport Sectors", "Description" => "You can add Transport Sectors as per your requirements...");
        $records[] = array("Key" => "title_options", "Name" => "Title", "Description" => "You can add Title Options as per your requirements...");
        $records[] = array("Key" => "transportation_company", "Name" => "Transportation Company", "Description" => "You can add Different Transportation Companies...");
        $records[] = array("Key" => "sea_ports", "Name" => "Sea Transport Ports", "Description" => "You can add all ports that are used to travel via Sea...");
        $records[] = array("Key" => "land_borders", "Name" => "Land/Road Transport Borders", "Description" => "You can add all borders that are used to travel via Land/Road...");
        $records[] = array("Key" => "land_border_cities", "Name" => "Land/Road Transport Border Cities", "Description" => "You can add all border Cities that are used to travel via Land/Road...");
        $records[] = array("Key" => "brn_operators", "Name" => "BRN Operators", "Description" => "You can add BRN Operators...");
        $records[] = array("Key" => "lead_tags", "Name" => "Lead Tags", "Description" => "You can add lead tags...");
        $records[] = array("Key" => "b2c_lead_close_reason", "Name" => "B2C Lead Close ", "Description" => "You can close B2C Lead with reason...");
        $records[] = array("Key" => "b2b_lead_close_reason", "Name" => "B2B Lead Close ", "Description" => "You can close B2B Lead with reason...");
        $records[] = array("Key" => "lead_followup_reason", "Name" => "Lead FollowUp ", "Description" => "You can FollowUp Lead with reason...");
        $records[] = array("Key" => "initial_training_checklist", "Name" => "Initial Training Check List", "Description" => "You can set Initial Training Check List with Sales Officers");


        $records[] = array("Key" => "organic-facebook", "Name" => "Organic Platform Facebook", "Description" => "Add Facebook Activities etc.... ");
        $records[] = array("Key" => "organic-whatsapp", "Name" => "Organic Platform WhatsApp", "Description" => "Add WhatsApp Activities etc.... ");
        $records[] = array("Key" => "organic-insta", "Name" => "Organic Platform Instagram", "Description" => "Add Instagram Activities etc.... ");
        $records[] = array("Key" => "organic-linkedIn", "Name" => "Organic Platform LinkedIn", "Description" => "Add LinkedIn Activities etc.... ");
        $records[] = array("Key" => "organic-youtube", "Name" => "Organic Platform Youtube", "Description" => "Add Youtube Activities etc.... ");
        //$records[] = array("Key" => "organic-twitter", "Name" => "Organic Platform Twitter", "Description" => "Add Twitter Activities etc.... ");
        $records[] = array("Key" => "organic-direct-sms", "Name" => "Organic Platform Direct SMS", "Description" => "Add Direct SMS Activities etc.... ");
        //$records[] = array("Key" => "organic-olx", "Name" => "Olx", "Organic Platform Description" => "Add Olx Activities etc.... ");
        //$records[] = array("Key" => "organic-zameen", "Name" => "Organic Platform Zameen", "Description" => "Add Zameen Activities etc.... ");

        return $records;
    }

    public function DefaultKeysCounter()
    {

        $records = array();
        $records[] = array("StatsKey" => "total_b2b_agent", "Value" => 0);
        $records[] = array("StatsKey" => "total_active_b2b_agent", "Value" => 0);
        $records[] = array("StatsKey" => "total_inactive_b2b_agent", "Value" => 0);
        $records[] = array("StatsKey" => "external_agents", "Value" => 0);
        $records[] = array("StatsKey" => "jeddah-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "medina-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "yanbu-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "sea-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "by-road-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "total-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "check-in-mecca", "Value" => 0);
        $records[] = array("StatsKey" => "check-in-medina", "Value" => 0);
        $records[] = array("StatsKey" => "check-in-jeddah", "Value" => 0);
        $records[] = array("StatsKey" => "check-out-mecca", "Value" => 0);
        $records[] = array("StatsKey" => "check-out-medina", "Value" => 0);
        $records[] = array("StatsKey" => "check-out-jeddah", "Value" => 0);
        $records[] = array("StatsKey" => "without-hotel-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "without-transport-arrival", "Value" => 0);
        $records[] = array("StatsKey" => "departure-mecca", "Value" => 0);
        $records[] = array("StatsKey" => "departure-medina", "Value" => 0);
        $records[] = array("StatsKey" => "departure-jeddah", "Value" => 0);

        return $records;
    }

    public function DefaultSettings()
    {
        $records = array();
        $records[] = array("Segment" => "Contact", "Key" => "contact", "Name" => "Contact");
        $records[] = array("Segment" => "Contact", "Key" => "address", "Name" => "Address");
        $records[] = array("Segment" => "Contact", "Key" => "email", "Name" => "Email");
        $records[] = array("Segment" => "Contact", "Key" => "facebook", "Name" => "	Facebook_link");
        $records[] = array("Segment" => "Basic", "Key" => "site_name", "Name" => "Name");
        $records[] = array("Segment" => "MIS", "Key" => "room_types", "Name" => "Sharing Room Type(Based on Bed)");
        $records[] = array("Segment" => "MIS", "Key" => "transport_types", "Name" => "Sharing Transport Type(Based on Seats)");
        $records[] = array("Segment" => "Support", "Key" => "support_email", "Name" => "Support Email");
        $records[] = array("Segment" => "Support", "Key" => "sales_email", "Name" => "Sales Email");
        $records[] = array("Segment" => "Default Images", "Key" => "default_image", "Name" => "	Default Image");
        $records[] = array("Segment" => "Currency", "Key" => "usd", "Name" => "1 USD to SAR");
        $records[] = array("Segment" => "Currency", "Key" => "pkr", "Name" => "1 PKR to SAR");
        $records[] = array("Segment" => "Currency", "Key" => "eur", "Name" => "1 EUR to SAR");
        $records[] = array("Segment" => "Umrah Visa Rate", "Key" => "package_umrah_key", "Name" => "Adult Umrah Visa");
        $records[] = array("Segment" => "Umrah Visa Rate", "Key" => "child_umrah_rate", "Name" => "Child Umrah Rate");
        $records[] = array("Segment" => "Umrah Visa Rate", "Key" => "infant_umrah_rate", "Name" => "Infant Umrah Rate");
        /*$records[] = array("Segment" => "Umrah Visa Rate", "Key" => "umrah_with_tranpsort_rate", "Name" => "Umrah With Transport Rate");
        $records[] = array("Segment" => "Umrah Visa Rate", "Key" => "umrah_with_package_rate", "Name" => "Umrah With Package Rate");*/
        return $records;
    }

    public function DefaultWebsiteSettings()
    {
        $records = array();
        $records[] = array("Segment" => "Contact", "Key" => "site_address", "Name" => "Address");
        $records[] = array("Segment" => "Contact", "Key" => "site_contact", "Name" => "Contact_no");
        $records[] = array("Segment" => "Contact", "Key" => "site_email", "Name" => "Email");
        $records[] = array("Segment" => "Contact", "Key" => "site_facebook", "Name" => "Facebook_link");
        $records[] = array("Segment" => "Basic Details", "Key" => "site_name", "Name" => "Name");
        $records[] = array("Segment" => "Basic Details", "Key" => "b2c_package", "Name" => "B2C Package");
        $records[] = array("Segment" => "Basic Details", "Key" => "country_code", "Name" => "Country Code");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_1", "Name" => "Contact Number 1");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_1_description", "Name" => "Contact Number 1 Description");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_2", "Name" => "Contact Number 2");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_2_description", "Name" => "Contact Number 2 Description");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_3", "Name" => "Contact Number 3");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_3_description", "Name" => "Contact Number 3 Description");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_4", "Name" => "Contact Number 4");
        $records[] = array("Segment" => "Voucher", "Key" => "contact_number_4_description", "Name" => "Contact Number 4 Description");
        $records[] = array("Segment" => "Voucher", "Key" => "terms_and_conditions", "Name" => "Terms And Conditions");

        return $records;
    }

    function GeneratePDF($html, $parms = array())
    {
        $data = $this->data;

        $options = array('enable_remote' => true);

        $dompdf = new \Dompdf\Dompdf($options);
        $cssFile = "dompdf.css";
        if ($parms['css']) {
            $cssFile = $parms['css'];
        }
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);

        $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';
        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';

        $headerIMG = $data['path'] . 'template/pdf-header.jpg';
        if ($parms['header_img']) {
            $headerIMG = $data['path'] . 'template/' . $parms['header_img'];
        }
        $header = '<header><img src="' . $headerIMG . '" width="100%" align="left" /><hr> </header>';

        $footerIMG = $data['path'] . 'template/pdf-footer.jpg';
        if ($parms['footer_img']) {
            $footerIMG = $data['path'] . 'template/' . $parms['footer_img'];
        }
        //$footerIMG = $data['path'] . 'template/pdf-records-footer.jpg';
        //$footer = '<footer><img src="' . $footerIMG . '" width="100%"/></footer>';
        $footer = '<footer>Copyright &copy; ' . date("Y") . ' by Umrah Furas All rights reserved.</footer>';

        $body = '<main>' . $html . '</main>';
        $HtmlContent = '<html> <head> <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <style>' . $CSS . '</style> </head> <body> ' . $watermark . $header . ' ' . $footer . ' ' . $body . '</body></html>';

        $dompdf->loadHtml($HtmlContent);

        $dompdf->setPaper('A4');

        $dompdf->render();
        $filename = time() . ".pdf";
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $dompdf->stream($filename, array("Attachment" => false));
        } else {
            $output = $dompdf->output();
            echo $output;
            exit;
        }
    }

    function GenerateVoucherPDF($html, $header, $agentid, $status, $UmrahOperator = 0)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("UID" => $agentid);
        $Agent = $Crud->SingleRecord($table, $where);

        $UmraOperator = $Crud->SingleRecord('main."Operators"', array("UID" => $UmrahOperator));


        $cssFile = $data['domain_themes'][$data['hostdomain']]['pdfcss'];
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);

//
//        $watherIMG = $data['path'] . 'template/not_approved_voucher_pdf_water_mark.jpg';
//        if ($status == 'Approved' || $status == 'Group')
//            $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';

        $watherIMG = $data['path'] . 'template/not_approved_voucher_pdf_water_mark.jpg';

        if ($status == 'Approved' || $status == 'Group' || $status == 'Executed' || $status == 'Refund') {
            $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';

        }


        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';

        //$headerIMG = $data['path'] . 'template/pdf-records-header.jpg';
        $headerIMG = $data['path'] . 'home/load_file/' . $UmraOperator['Logo'] . '';
//        $headerIMG = $data['path'] . 'template/' . $data['domain_themes'][$data['hostdomain']]['pdflogo'];

        $file_imagelogo = LoadFileTemp($Agent['Logo']);

        //$barcode = '<br><img src="'.BarCode(($header)).'" style="max-height: 20px;">';
        $header = '<header><table width="100%"><tr><td style="margin: 0; padding: 10px;border-bottom: 0px;">
        <img src="' . $headerIMG . '" align="left" style="height: 50px;" />
        <div class="top-right-header">
            <div class="heading"   style="width:250px;padding-left: 80px;">
            <div style="float:left;width: 50px;"><img src="' . $file_imagelogo['url'] . '" align="left" style="height: 50px;" /></div>
            <div style="float:left;width: 200px;padding-left: 30px;"><strong>' . $Agent['FullName'] . ' (' . CountryName($Agent['CountryID']) . ')</strong></div>
            </div>
        ' . $header . '
        </div>
        </td></tr></table></header>';
//        $footerIMG = $data['path'] . 'template/Final-Hotel-Voucher-Urdu.jpg';
//        $footer = '<footer style="margin-bottom: 370px; margin-top: 20px;"><img src="' . $footerIMG . '" width="100%"/></footer>';
        $footer = '<footer> Copyright &copy; ' . date("Y") . ' by ' . $data['domain_themes'][$data['hostdomain']]['site'] . ' All rights reserved.</footer> ';


//        $VocuherUrduImage = $data['path'] . 'template/Final-Hotel-Voucher-Urdu.jpg';
//        $VoucherUrduTextImage = '<div style="margin-top: 30px; margin-bottom: 370px; text-align: right"><img src="' . $VocuherUrduImage . '" height="250px" style="text-align: right"/></div>';

        $body = '<main><style>* { font-family: DejaVu Sans, sans-serif;} ' . $CSS . '</style>' . $html . ' </main>';
        $HtmlContent = '<!DOCTYPE html><html lang="en"><head><title>' . $header . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>* { font-family: DejaVu Sans, sans-serif;} ' . $CSS . '</style> </head> <body> 
        ' . $watermark . $header . ' ' . $footer . ' ' . $body . '</body></html>';
        //echo $HtmlContent;exit;
        $options = array('enable_remote' => true);
        //define("DOMPDF_UNICODE_ENABLED", true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($HtmlContent);

        $dompdf->setPaper('A4');

        $dompdf->render();
        $filename = time() . ".pdf";
        @unlink($file_imagelogo['file']);
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $dompdf->stream($filename, array("Attachment" => false));
        } else {
            $output = $dompdf->output();

            echo $output;

            exit;
        }
    }

    function GenerateB2CVoucherPDF($html, $header, $status)
    {
        $data = $this->data;


        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array("UID" => $session['profile']['DomainID']);
        $DomainData = $Crud->SingleRecord($table, $where);


        $cssFile = $data['domain_themes'][$data['hostdomain']]['pdfcss'];
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);


        $watherIMG = $data['path'] . 'template/not_approved_voucher_pdf_water_mark.jpg';

        if ($status == 'Approved' || $status == 'Group' || $status == 'Executed' || $status == 'Refund') {
            $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';
        }


        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';

        $headerIMG = $data['path'] . 'template/umrah-furas-logo.png';
        $headerIMG = $data['path'] . 'template/' . $data['domain_themes'][$data['hostdomain']]['pdflogo'];


        $DomainLogo = $data['path'] . 'home/load_file/' . $DomainData['Logo'];
        $header = '<header><table width="100%"><tr><td style="margin: 0; padding: 10px;border-bottom: 0px;">
        <img src="' . $headerIMG . '" align="left" style="height: 50px;" />
        
          
        <div class="top-right-header">
            <div class="heading" style="width:250px;padding-left: 80px;">
             <div style="float:right; width: 50px;"><img src="' . $DomainLogo . '" align="right" style="height: 70px;"></div>
           </div>
        ' . $header . '
        </div>
        </td></tr></table></header>';
        $footer = '<footer> Copyright &copy; ' . date("Y") . ' by ' . $data['domain_themes'][$data['hostdomain']]['site'] . ' All rights reserved.</footer> ';


        $body = '<main>' . $html . ' </main>';
        $HtmlContent = '<!DOCTYPE html><html lang="en"><head><title>' . $header . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>* { font-family: DejaVu Sans, sans-serif; } ' . $CSS . '</style> </head> <body style="font-family:Arial"> 
        ' . $watermark . $header . ' ' . $footer . ' ' . $body . '</body></html>';
        $options = array('enable_remote' => true);
        define("DOMPDF_UNICODE_ENABLED", true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($HtmlContent);

        $dompdf->setPaper('A4');

        $dompdf->render();
        $filename = time() . ".pdf";
        @unlink($file_imagelogo['file']);
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $dompdf->stream($filename, array("Attachment" => false));
        } else {
            $output = $dompdf->output();

            echo $output;

            exit;
        }
    }

    function GeneratePortraitPDF($html, $header)
    {
        $data = $this->data;

        $cssFile = "dompdf-records.css";
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);

        $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';
        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';

        //$headerIMG = $data['path'] . 'template/pdf-records-header.jpg';
        $headerIMG = $data['path'] . 'template/umrah-furas-logo.png';
        //$barcode = '<br><img src="'.BarCode(($header)).'" style="max-height: 20px;">';
        $header = '<header><table class="worksheet_head" width="100%"><tr class="worksheet_head_row"><td style="margin: 0; padding: 10px;border-bottom: 0px;">
        <img src="' . $headerIMG . '" align="left" style="height: 50px;" />
        <div class="top-right-header">' . $header . '</div>
        </td></tr></table></header>';

        //$footerIMG = $data['path'] . 'template/pdf-records-footer.jpg';
        //$footer = '<footer><img src="' . $footerIMG . '" width="100%"/></footer>';
        $footer = '<footer>Copyright &copy; ' . date("Y") . ' by Umrah Furas All rights reserved.</footer>';

        $body = '<main>' . $html . '</main>';
        $HtmlContent = '<!DOCTYPE html><html lang="en"><head><title>' . $header . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>* { font-family: DejaVu Sans, sans-serif; } ' . $CSS . '</style> </head> <body style="font-family:Arial"> 
        ' . $watermark . $header . ' ' . $footer . ' ' . $body . '</body></html>';
        //echo $HtmlContent;exit;
        $options = array('enable_remote' => true);
        define("DOMPDF_UNICODE_ENABLED", true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($HtmlContent);

        $dompdf->setPaper('A4');

        $dompdf->render();
        $filename = time() . ".pdf";
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $dompdf->stream($filename, array("Attachment" => false));
        } else {
            $output = $dompdf->output();
            echo $output;
            exit;
        }
    }

    function GenerateReportPDF($html, $header)
    {
        $data = $this->data;

        $cssFile = "dompdf-records.css";
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);

        $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';
        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';

        $headerIMG = $data['path'] . 'template/pdf-records-header.jpg';
        $headerIMG = $data['path'] . 'template/umrah-furas-logo.png';
        $barcode = '<br><img src="' . BarCode(($header)) . '" style="max-height: 20px;">';
        $header = '<header><table width="100%"><tr><td style="margin: 0; padding: 10px;border-bottom: 0px;">
        <img src="' . $headerIMG . '" align="left" style="height: 50px;" />
        <div class="top-right-header">' . $header . '</div>
        </td></tr></table></header>';

        //$footerIMG = $data['path'] . 'template/pdf-records-footer.jpg';
        //$footer = '<footer><img src="' . $footerIMG . '" width="100%"/></footer>';
        $footer = '<footer>Copyright &copy; ' . date("Y") . ' by Umrah Furas All rights reserved.</footer>';

        $body = '<main>' . $html . '</main>';
        $HtmlContent = '<!DOCTYPE html><html lang="en"><head><title>' . $header . '</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>* { font-family: DejaVu Sans, sans-serif; } ' . $CSS . '</style> </head> <body style="font-family:Arial"> 
        ' . $watermark . $header . ' ' . $footer . ' ' . $body . '</body></html>';
        //echo $HtmlContent;exit;
        $options = array('enable_remote' => true);
        define("DOMPDF_UNICODE_ENABLED", true);
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($HtmlContent);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();
        $filename = time() . ".pdf";
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $dompdf->stream($filename, array("Attachment" => false));
        } else {
            $output = $dompdf->output();
            echo $output;
            exit;
        }
    }

    function Bulk_update_groups($Status, $RecordID)
    {
        $Crud = new Crud();
        $table = 'main."Groups"';
        $Records = array(
            "Status" => $Status,
        );
        $where = array("UID" => $RecordID);
        $Crud->UpdateRecord($table, $Records, $where);
    }

    function MofaTempReader($Agent, $RecordID)
    {
        $session = session();
        $session = $session->get();
        $view = false;

        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
        $records = $Crud->SingleRecord($table, $where);
        $domainid = $records['UID'];

        //$Crud = new Crud();
        $table = 'temp."mofa_file"';
        $where = array("UID" => $RecordID);
        $record = $Crud->SingleRecord($table, $where);

        if ($view) "Agent: " . $Agent . "<br>";
        if ($view) "Mofa File ID: " . $RecordID . "<br>";
        if ($view) print_r($record);

        //echo'<pre>';print_r($record);exit;

        //////// Add Operator
//        $Operator = explode(" -", $record['Operator']);
//        $OperatorUID = trim($Operator[0]);
//        $Operator = trim($Operator[1]);
//        $OprRecord = $Crud->SingleRecord('main."Operators"', array("UID" => $OperatorUID));
//        if ($OprRecord['UID']) {
//            $OperatorUID = $OprRecord['UID'];
//        } else {
//            $OprRecord = $Crud->AddRecord('main."Operators"', array("UID" => $OperatorUID, "FullName" => $Operator, "WebsiteDomain" => $domainid));
//            $OperatorUID = $OprRecord;
//        }
//        if ($view) echo "Operator ID: " . $OperatorUID . "<br>";
        //////// Add ExtAgent
//        $ExtAgent = explode(" - ", $record['ExtAgent']);
//        $ExtAgentUID = trim($ExtAgent[1]);
//        $ExtAgent = trim($ExtAgent[0]);
//        $ExtAgentRecord = $Crud->SingleRecord('main."Agents"', array("UID" => $ExtAgentUID));
//        if ($ExtAgentRecord['UID']) {
//            $ExtAgentRecordUID = $ExtAgentRecord['UID'];
//        } else {
//            $ExtAgentRecord = $Crud->AddRecord('main."Agents"', array("UID" => $ExtAgentUID, "FullName" => $ExtAgent, "Type" => 'external_agent', "WebsiteDomain" => $domainid));
//            $ExtAgentRecordUID = $ExtAgentRecord;
//        }
//        if ($view) echo "ExtAgent ID: " . $ExtAgentRecordUID . "<br>";

        //////// Add GROUP
        $GroupRecordUID = $GroupID = 0;
        $GroupUID = trim($record['PKGCode']);
        $Group = trim($record['GroupName']);
        $GroupRecord = $Crud->SingleRecord('main."Groups"', array("WTUCode" => trim($GroupUID)));
        $GroupID = ((isset($GroupRecord['UID']) && $GroupRecord['UID'] != '') ? $GroupRecord['UID'] : 0);
        /* if (!isset($GroupRecord['UID'])) {
             $GroupRecord = $Crud->AddRecord('main."Groups"', array("UID" => $GroupUID, "FullName" => $Group, "AgentID" => $Agent, "WTUCode" => $record['PKGCode'], "WebsiteDomain" => $domainid));
             $GroupID = $GroupUID;
         }*/
        $GroupRecordUID = $GroupID;
        if ($view) echo "Group ID: " . $GroupRecordUID . "<br>";

        //////// Add Sub Agent
//        $SubAgentName = $record['SubAgentName'];
//        $SubAgentRecord = $Crud->SingleRecord('main."Agents"', array("FullName" => $SubAgentName, "Type" => 'sub_agent', "WebsiteDomain" => $domainid));
//        if ($SubAgentRecord['UID']) {
//            $SubAgentRecordUID = $SubAgentRecord['UID'];
//        } else {
//            $SubAgentRecord = $Crud->AddRecord('main."Agents"', array("FullName" => $SubAgentName, "ParentID" => $Agent, "Type" => 'sub_agent', "WebsiteDomain" => $domainid));
//            $SubAgentRecordUID = $SubAgentRecord;
//        }
//        if ($view) echo "SUB Agent ID: " . $SubAgentRecordUID . "<br>";
        //////// Add Pilgram
        $MOFANumb = $record['MOFANumber'];
        $PilgrimRecord = $Crud->SingleRecord('pilgrim."mofa"', array("MOFANumber" => $MOFANumb));
        if ($PilgrimRecord['UID']) {
            $PilgrimRecordUID = $PilgrimRecord['UID'];

        } else {

            $Country = CountryCode($record['Nationality']);
            $PilgrimRecord = array(
                "GroupUID" => $GroupRecordUID,
                "AgentUID" => $Agent,
                "FirstName" => $record['PilgrimName'],
                "Relation" => $record['Relation'],
                "CurrentStatus" => "mofa-issued",
                "DOB" => $record['DOB'],
                "DOBInYears" => preg_replace('/[^0-9\-]/', '', $record['Age']),
                "PassportNumber" => $record['PassportNo'],
                "Nationality" => $record['Nationality'],
                "Country" => $Country,
                "RegistrationDate" => date('Y-m-d', strtotime($record['IssueDateTime'])),
                "WebsiteDomain" => $domainid,
            );

            if ($view) print_r($PilgrimRecord);
            $PilgrimRecordUID = $Crud->AddRecord('pilgrim."master"', $PilgrimRecord);
            $userid = $session['id'];

            ///////////////////////////////// MOFA ///////////////
            $PilgrimMofaRecord = array(
                "PilgrimUID" => $PilgrimRecordUID,
                "Option" => 'mofa-upload-status',
                "CreatedBy" => $userid,
                "Value" => 'Yes'
            );
            $Crud->AddRecord('pilgrim."meta"', $PilgrimMofaRecord);
            $PilgrimMofaRecord = array(
                "PilgrimUID" => $PilgrimRecordUID,
                "Option" => 'mofa-upload-user-id',
                "CreatedBy" => $userid,
                "Value" => $userid
            );
            $Crud->AddRecord('pilgrim."meta"', $PilgrimMofaRecord);
            $PilgrimMofaRecord = array(
                "PilgrimUID" => $PilgrimRecordUID,
                "Option" => 'mofa-issued-status',
                "CreatedBy" => $userid,
                "Value" => 'Yes'
            );
            $Crud->AddRecord('pilgrim."meta"', $PilgrimMofaRecord);
            $PilgrimMofaRecord = array(
                "PilgrimUID" => $PilgrimRecordUID,
                "Option" => 'mofa-issued-user-id',
                "CreatedBy" => $userid,
                "Value" => $userid
            );
            $Crud->AddRecord('pilgrim."meta"', $PilgrimMofaRecord);

            $MofaRecord = array(
                "MOFANumber" => $record['MOFANumber'],
                "MOFAPilgrimID" => $record['PilgrimID'],
                "IssueDateTime" => $record['IssueDateTime'],
                "MOINumber" => $record['MOINumber'],
                "INSURANCE_POLICY_ID" => (int)$record['INSURANCE_POLICY_ID'],
                "PilgrimID" => $PilgrimRecordUID,
                "Embassy" => $record['Embassy'],
                "BRN" => $record['Brn'],
                "FileID" => $record['FileID'],
                "Operator" => $record['Operator']
            );
            $PilgrimMofaRecordUID = $Crud->AddRecord('pilgrim."mofa"', $MofaRecord);

            if ($view) echo "Pilgrim MOFA ID: " . $PilgrimMofaRecordUID . "<br>";

        }

        if ($view) echo "Pilgrim ID: " . $PilgrimRecordUID . "<br>";

        $Crud->DeleteRecord('temp."mofa_file"', array("UID" => $RecordID));
    }

    function PilgrimTransfer($Agent, $RecordID)
    {

        $Crud = new Crud();
        $table = 'pilgrim."master"';
        $record = array("AgentUID" => $Agent);
        $where = array("UID" => $RecordID);
        $Crud->UpdateRecord($table, $record, $where);

    }

    function DurationExcelReader($file)
    {
        $Excel = new Excel($file);
        $xlsx = $Excel->parse($file);
        $response = array();
        if ($xlsx) {
            $ROWS = $xlsx->rows();
            $Final = array();
            print_r($ROWS);
            for ($a = 7; $a <= count($ROWS); $a++) {
                $tempArray = array();
                if ($ROWS[$a][1] != '') {
                    $TEMP = array();
                    $TEMP['Operator'] = $ROWS[2][2];
                    $TEMP['ExtAgent'] = $ROWS[3][2];
                    $TEMP['Group'] = $ROWS[4][2];
                    $TEMP['PrintDate'] = $ROWS[5][2];
                    $TEMP['PilgrimName'] = $ROWS[$a][0];
                    $TEMP['PilgrimID'] = $ROWS[$a][1];
                    $TEMP['Age'] = $ROWS[$a][2];
                    $TEMP['DOB'] = date("Y-m-d", strtotime($ROWS[$a][3]));
                    $TEMP['GroupName'] = $ROWS[$a][4];
                    $TEMP['PassportNo'] = $ROWS[$a][5];
                    $TEMP['MOFANumber'] = $ROWS[$a][6];
                    $TEMP['IssueDateTime'] = date("Y-m-d h:i:s", strtotime($ROWS[$a][7]));
                    $TEMP['Embassy'] = $ROWS[$a][8];
                    $TEMP['PKGCode'] = $ROWS[$a][9];
                    $TEMP['Relation'] = $ROWS[$a][10];
                    $TEMP['Nationality'] = $ROWS[$a][11];
                    $TEMP['Address'] = $ROWS[$a][12];
                    $TEMP['SubAgentName'] = $ROWS[$a][13];
                    $TEMP['MOINumber'] = $ROWS[$a][14];
                    $TEMP['INSURANCE_POLICY_ID'] = $ROWS[$a][15];

                    print_r($TEMP);
//                    $Crud = new Crud();
//                    $table = 'pilgrim."mofa"';
//                    $where = array("MOFANumber" => $ROWS[$a][6]);
//                    $MOFArecordID = $Crud->SingleRecord($table, $where);
//                    if (!isset($MOFArecordID['MOFANumber'])) {
//                        $table = 'temp."mofa_file"';
//                        $recordID = $Crud->AddRecord($table, $TEMP);
//                        $Final[$recordID][] = $TEMP;
//                    }
                }
            }
            $response['status'] = "success";
            $response['message'] = "File Process Successfully...";
        } else {
            $response['status'] = "fail";
            $response['message'] = $Excel->parseError();
        }
        return $response;
    }

    public
    function GetPilgirmsMofaNo()
    {

        $Crud = new Crud();
        $SQL = ' SELECT DISTINCT( pilgrim."mofa"."MOFANumber" ) AS "PilgrimMofaNo"
                 FROM pilgrim."mofa" ';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function GetTempMofaNo()
    {
        $Crud = new Crud();
        $SQL = ' SELECT DISTINCT( temp."mofa_file"."MOFANumber" ) AS "TempMofaNo"
                 FROM temp."mofa_file" ';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }


//    public function LookupFormSubmit($records, $UID)
//    {
//        $data = $this->data;
//
//        $Crud = new Crud();
//        $table = 'main."Lookups"';
//
//        if ($UID == 0) {
//            $Crud->Track("Lookups", 'New Lookup "' . $records['Name'] . '" added in system...');
//            $recordID = $Crud->AddRecord($table, $records);
//            $response['status'] = "success";
//            $response['record_id'] = $recordID;
//            $response['message'] = "Lookup Successfully Added...";
//        } else {
//            $Crud->Track("Lookups", 'Lookup "' . $records['Name'] . '" Updated Succesfully ...');
//            $where = array("UID" => $UID);
//            $Crud->UpdateRecord($table, $records, $where);
//            $response['status'] = "success";
//            $response['message'] = "Lookup Updated...";
//        }
//
//
//        echo json_encode($response);
//    }

    function MofaExcelReader($file, $BRN)
    {
        //echo $file;
        $Excel = new Excel($file);
        $xlsx = $Excel->parse($file);
        //print_r($xlsx); echo json_encode($xlsx); echo $xlsx; exit;
        $response = array();
        $Data = array(
            'Umrah Operator' => 'Operator',
            'Agent' => 'ExtAgent',
            'Group Name' => 'Group',
            'Print Date' => 'PrintDate'
        );
        if ($xlsx) {
            $ROWS = $xlsx->rows();
            $Final = $InstRecords = array();
            $Array = array();
            $totalCount = 0;
            $totalDuplicateCount = 0;
            $StartCounter = ((trim($ROWS[7][2]) == 'Pilgrim Name') ? 8 : ((trim($ROWS[8][2]) == 'Pilgrim Name') ? 9 : 8));
            for ($b = 2; $b <= ($StartCounter - 2); $b++) {
                foreach ($Data as $Key => $Value) {
                    if (trim(str_replace(':', '', $ROWS[$b][0])) == $Key) {
                        $Array[$Value] = $ROWS[$b][2];
                    }
                }
            }
            //print_r($Array);


            for ($a = $StartCounter; $a <= count($ROWS); $a++) {
                $tempArray = array();
                if ($ROWS[$a][5] != '') {
                    $TEMP = array();

                    $TEMP['Operator'] = $Array['Operator'];
                    $TEMP['ExtAgent'] = $Array['ExtAgent'];
                    $TEMP['Group'] = $Array['Group'];
                    $TEMP['PrintDate'] = $Array['PrintDate'];

                    $TEMP['PilgrimName'] = $ROWS[$a][0];
                    $TEMP['PilgrimID'] = $ROWS[$a][1];
                    $TEMP['Age'] = $ROWS[$a][2];
                    $TEMP['DOB'] = date("Y-m-d", strtotime($ROWS[$a][3]));
                    $TEMP['GroupName'] = $ROWS[$a][4];
                    $TEMP['PassportNo'] = $ROWS[$a][5];
                    $TEMP['MOFANumber'] = $ROWS[$a][6];
                    $TEMP['IssueDateTime'] = date("Y-m-d h:i:s", strtotime($ROWS[$a][7]));
                    $TEMP['Embassy'] = $ROWS[$a][8];
                    $TEMP['PKGCode'] = $ROWS[$a][9];
                    $TEMP['Relation'] = $ROWS[$a][10];
                    $TEMP['Nationality'] = $ROWS[$a][11];
                    $TEMP['Address'] = $ROWS[$a][12];
                    $TEMP['SubAgentName'] = $ROWS[$a][13];
                    $TEMP['MOINumber'] = $ROWS[$a][14];
                    //if (isset($ROWS[$a][15]) && $ROWS[$a][15] != '')
                    $TEMP['INSURANCE_POLICY_ID'] = $ROWS[$a][15];
                    $TEMP['Brn'] = $BRN;

                    $Crud = new Crud();
                    $where = array("MOFANumber" => $ROWS[$a][6]);
                    $MOFArecordID = $Crud->SingleRecord('pilgrim."mofa"', $where);
                    if (isset($MOFArecordID['MOFANumber'])) {
                        $totalDuplicateCount++;
                    } else {
                        $table = 'temp."mofa_file"';
                        $where = array("MOFANumber" => $ROWS[$a][6]);
                        $MOFATempIDs = $Crud->ListRecords($table, $where);
                        if (count($MOFATempIDs) > 0) {
                            //////  DUPLICATE IN TEMP MOFA
                        } else {
                            $InstRecords[] = $TEMP;
                            //echo "MOFA Number: " . $ROWS[$a][6] . "<br>";
                            $recordID = $Crud->AddRecord($table, $TEMP);
                            //echo print_r($TEMP) . "<hr>";
                            $Final[$recordID][] = $TEMP;
                            $totalCount++;
                        }
                    }
                }
            }

//            $table = 'temp."mofa_file"';
//            if (count($InstRecords) > 0) {
//                $db = db_connect();
//                $db->db_debug = false;
//                $db->table($table);
//                $db->insertBatch($InstRecords);
//                $db->close();
//            }

            $response['status'] = "success";
            $response['message'] = "File Process Successfully, " . $totalCount . " Records Inserted, " . $totalDuplicateCount . " Records Duplicate...";
            //$response['records_ids'] = json_encode($Final);
        } else {
            $response['status'] = "fail";
            $response['message'] = $Excel->parseError();
        }
        return $response;
    }

    function MofaELMPilgrimExcelReader($file)
    {
        $Crud = new Crud();
        $table = 'websites."Domains"';
        $where = array("Name" => str_replace("panel.", "", $_SERVER['HTTP_HOST']));
        $records = $Crud->SingleRecord($table, $where);
        $domainid = $records['UID'];
        $CroneModel = new CronModel();

        $Excel = new Excel($file);
        $xlsx = $Excel->parse($file);
        if ($xlsx) {
            $ROWS = $xlsx->rows();
            $Final = array();
            for ($a = 1; $a <= count($ROWS); $a++) {
                //for ($a = 1; $a <= 3; $a++) {
                $tempArray = array();
                if ($ROWS[$a][1] != '') {
                    $EntryDate = explode(" ", trim($ROWS[$a][12]));
                    //print_r($EntryDate);

                    $TEMP = array();
                    $TEMP['EACode'] = $ROWS[$a][1];
                    $TEMP['EAName'] = $ROWS[$a][2];
                    $TEMP['GroupCode'] = $ROWS[$a][3];
                    $TEMP['GroupDesc'] = $ROWS[$a][4];
                    $TEMP['PilgrimID'] = $ROWS[$a][5];
                    $TEMP['Name'] = $ROWS[$a][6];
                    $TEMP['BirthDate'] = date("Y-m-d", strtotime($ROWS[$a][7]));
                    $TEMP['PassportNo'] = $ROWS[$a][8];
                    $TEMP['MOINumber'] = $ROWS[$a][9];
                    $MOFANumber = $ROWS[$a][10];
                    $TEMP['VisaNo'] = $ROWS[$a][11];
                    $EntryString = $ROWS[$a][12];
                    $TEMP['EntryDate'] = date("Y-m-d", strtotime($EntryDate[0]));
                    $TEMP['EntryTime'] = date("H:i:s", strtotime(end($EntryDate)));
                    $TEMP['EntryPort'] = $ROWS[$a][13];
                    $TEMP['TransportMode'] = $ROWS[$a][14];
                    $TEMP['EntryCarrier'] = $ROWS[$a][15];
                    $TEMP['FlightNo'] = $ROWS[$a][16];
                    $TEMP['Package'] = $ROWS[$a][17];

                    /** Jawad Code Start */
                    $Crud = new Crud();
                    $table = 'pilgrim."travel"';
                    $where = array(
                        "PassportNo" => $TEMP['PassportNo'],
                        "MOINumber" => $TEMP['MOINumber'],
                        "VisaNo" => $TEMP['VisaNo']
                    );
                    $TravelRecord = $Crud->SingleRecord($table, $where);
                    if (!isset($TravelRecord['UID'])) {

                        $MofaTable = 'pilgrim."mofa"';
                        $InnerWhere = array(
                            'MOINumber' => $TEMP['MOINumber']
                        );
                        $MofaRecord = $Crud->SingleRecord($MofaTable, $InnerWhere);
                        if (isset($MofaRecord['UID'])) {

                            $travel = array();
                            $travel['PilgrimID'] = $MofaRecord['PilgrimID'];
                            $travel['MOFAPilgrimID'] = $MofaRecord['MOFAPilgrimID'];
                            $travel['PassportNo'] = $TEMP['PassportNo'];
                            $travel['MOINumber'] = $TEMP['MOINumber'];
                            $travel['VisaNo'] = $TEMP['VisaNo'];
                            $travel['EntryDate'] = $TEMP['EntryDate'];
                            $travel['EntryTime'] = $TEMP['EntryTime'];
                            $travel['EntryPort'] = $TEMP['EntryPort'];
                            $travel['TransportMode'] = $TEMP['TransportMode'];
                            $travel['EntryCarrier'] = $TEMP['EntryCarrier'];
                            $travel['FlightNo'] = $TEMP['FlightNo'];
                            $Crud->AddRecord('pilgrim."travel"', $travel);

                            $CroneModel->UpdateCronActivity('Complete_In_Over_25_Days_Arrival');
                            $CroneModel->UpdateCronActivity('Over_25_Days_Arrival');
                            $CroneModel->UpdateCronActivity('completed_without_vocuher_arrival');
                            $CroneModel->UpdateCronActivity('without_vocuher_arrival');
                            $CroneModel->UpdateCronActivity('CompletedPptManagement');
                            $CroneModel->UpdateCronActivity('PptManagement');
                            $CroneModel->UpdateCronActivity('VisaIssued');
                            $CroneModel->UpdateCronActivity('VoucherNotIssued');
                        } else {

                            /** Uploaded File
                             * Pilgrim ID
                             * Not Available in
                             * Mofa Pilgrim ID
                             */
                        }

                    } else {
                        /** Duplicate Entry*/
                    }
                    /** Jawad Code Ends */

                }
            }
            $response['status'] = "success";
            $response['message'] = "File Process Successfully...";
        } else {
            $response['status'] = "fail";
            $response['message'] = $Excel->parseError();
        }
        return $response;
    }

    function SendEmail($to, $subject, $html)
    {
        $data = $this->data;
        $email = \Config\Services::email();
        $config['protocol'] = 'sendmail';
        //$config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordWrap'] = true;
        $config['priority'] = 1;
        $config['mailType'] = 'html';
        $config['userAgent'] = 'Umrah Furas - MIS';

//        $config['SMTPHost']  = '161.97.83.219';
//        $config['SMTPUser']  = 'developer@umrahfuras.com';
//        $config['SMTPPass']  = 'zg1}Rs7Q3+NQ';
//        $config['SMTPPort']  = '465';

        $email->initialize($config);
        $email->setFrom('info@umrahfuras.com', 'Umrah Furas - MIS');
        $email->setTo($to);
        $email->setBCC('shaheryar.lala@gmail.com');
        $email->setSubject($subject);

        $header = view("email/header", $data);
        $footer = view("email/footer", $data);
        $email->setMessage($header . $html . $footer);
        return $email->send();
    }

    public function LanguageFormSubmit($records, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Language"';

        if ($UID == 0) {
            $Crud->Track("Languages", 'New Langauge "' . $records['Name'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Langauge Successfully Added...";
        } else {
            $Crud->Track("Langauges", 'Langauge "' . $records['Name'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Langauge Updated...";
        }

        echo json_encode($response);
    }

    public function LookupOptionFormSubmit($records, $UID)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."LookupsOptions"';

        if ($UID == 0) {
            $Crud->Track("Lookups", 'Lookup Option "' . $records['Name'] . '" added in system...');
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Lookup Option Successfully Added...";
        } else {
            $Crud->Track("Lookups", 'Lookup Option "' . $records['Name'] . '" Updated Successfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Lookup Option Updated...";
        }


        echo json_encode($response);
    }

    public
    function ListLookups()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Lookups"';
        $where = array();
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function GetAllUmrahOperators($Type = '')
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Operators"';
        if ($Type != '') {
            $where = array('Category' => $Type, 'Archive' => 0);
        } else {
            $where = array('Archive' => 0);
        }
        $order = array("CompanyName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListTranslations()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."LanguageTranslations"';
        $where = array();
        $order = array();
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function ListCronActivities()
    {
        $Crud = new Crud();
//        $SQL = '
//        SELECT DISTINCT websites."CronActivities"."FunctionName", AVG(websites."CronActivities"."LoadTime") AS "AverageTime"
//        FROM websites."CronActivities"
//        GROUP BY websites."CronActivities"."FunctionName"
//        ORDER BY AVG(websites."CronActivities"."LoadTime") DESC
//        ';


        $SQL = '
        SELECT DISTINCT websites."CronActivities"."FunctionName",
            COUNT(websites."CronActivities"."FunctionName") AS "TotalCount",
            MAX(websites."CronActivities"."SystemDate") AS "LastExectued", 
            AVG(websites."CronActivities"."LoadTime") AS "AverageTime"
        FROM websites."CronActivities" WHERE websites."CronActivities"."Flag" = 1 
        GROUP BY websites."CronActivities"."FunctionName"
        ORDER BY AVG(websites."CronActivities"."LoadTime") DESC
        
        ';

        $records = $Crud->ExecuteSQL($SQL);

        return $records;

    }

    public
    function DeleteLanguage($UID)
    {

        $Crud = new Crud();
        $table = 'main."Language"';
        $record['Archive'] = "1";
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }


//    public
//    function LookupsData($record_id)
//    {
//        $data = $this->data;
//        $Crud = new Crud();
//        $table = 'main."Lookups"';
//        $where = array("UID" => $record_id);
//        $records = $Crud->SingleRecord($table, $where);
//        return $records;
//    }

    public
    function DeleteLookupOption($UID)
    {

        $Crud = new Crud();
        $table = 'main."LookupsOptions"';
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
    function LookupsOptionData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."LookupsOptions"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function LanguagesData($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."Language"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function ListLookupOptions()
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."LookupsOptions"';
        $where = array("Archive" => "0");
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function LoadOperators($Category)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Operators"';
        $where = array("Archive" => "0", "Category" => $Category);
        $order = array("CompanyName" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);

        return $records;

    }

    public
    function CitiesByCountryDropDown($CountryISO2)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Cities"';
        $where = array("CountryCode" => $CountryISO2);
        $order = array("Name" => "ASC");
        $records = $Crud->ListRecords($table, $where, $order);
        // echo "<pre>"; print_r($records); exit;
        $FinalData = array();
        $FinalData['records'] = $records;

        // Select Dropdown Options
        $DataHTML = "";
        $DataHTML .= "<option value=''>Please Select</option>";
        foreach ($records as $thisOpt) {
            $DataHTML .= '<option value="' . $thisOpt['UID'] . '">' . $thisOpt['Name'] . '</option>';
        }

        $FinalData['html'] = $DataHTML;
        return $FinalData;
    }

    public
    function GetCalenderDataByID($record_id)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."UmrahCalender"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public function CalenderFormSubmit($records, $UID)
    {
        $Crud = new Crud();
        $table = 'main."UmrahCalender"';

        if ($UID == 0) {
            $recordID = $Crud->AddRecord($table, $records);
            $response['status'] = "success";
            $response['record_id'] = $recordID;
            $response['message'] = "Calender Successfully Added...";
        } else {
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Calender Updated...";
        }

        echo json_encode($response);
    }

    /** Approved Vouchers
     * Report Functions
     */

    public
    function count_umrah_calender_filtered()
    {
        $Crud = new Crud();
        $SQL = ' SELECT * FROM main."UmrahCalender" ORDER BY "Year" ASC ';
        $records = $Crud->ExecuteSQL($SQL);

        return count($records);
    }

    public
    function get_umrah_calender_datatables()
    {
        $Crud = new Crud();
        $SQL = ' SELECT * FROM main."UmrahCalender" ORDER BY "Year" ASC';
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL); exit;
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public function FBPages()
    {
        $PAGES = [];
        $PAGES[] = ['page' => 'Lala International FB Page', 'url' => 'http://fetchrss.com/rss/632037cfc6507e40c164f8b3632037a828e73e6286538322.xml'];

        return $PAGES;

    }


    public
    function GenerateVoucherMPDF($head, $html, $filename, $agentid, $status, $umrahoperator = 0)
    {
        $output = 'I';
        $data = $this->data;

        $Crud = new Crud();
        $table = 'main."Agents"';
        $where = array("UID" => $agentid);
        $Agent = $Crud->SingleRecord($table, $where);

        $UmraOperator = $Crud->SingleRecord('main."Operators"', array("UID" => $umrahoperator));
        $cssFile = $data['domain_themes'][$data['hostdomain']]['pdfcss'];
        $CSS = file_get_contents(ROOT . "/template/" . $cssFile);

        $watherIMG = $data['path'] . 'template/not_approved_voucher_pdf_water_mark.jpg';
        if ($status == 'Approved' || $status == 'Group' || $status == 'Executed' || $status == 'Refund') {
            $watherIMG = $data['path'] . 'template/pdf_water_mark.jpg';

        }
        $watermark = '<div id="watermark"><img src="' . $watherIMG . '" align="center" /></div>';
        $headerIMG = $data['path'] . 'home/load_file/' . $UmraOperator['Logo'] . '';
        //$file_imagelogo = LoadFileTemp($Agent['Logo']);

        $header = '<header>
                        <table width="100%" >
                            <tr>
                                <td style="margin: 0; padding: 10px;border-bottom: 0px;" width="50%" ><img src="' . $headerIMG . '" align="left" style="height: 50px;" /></td>
                                 <td style="margin: 0; padding: 10px;border-bottom: 0px; float: right;" class="header" width="25%" valign="top"></td> 
                                <td style="margin: 0; padding: 10px;border-bottom: 0px; float: right;" class="top-right-header" width="25%" valign="top">
                                    ' . $head . '
                                </td>
                            </tr>
                            <tr>
                              <td colspan=3><hr style="color: #dda420;"></td>
                            </tr>
                        </table>
                 </header>';

        $footer = '<footer> Copyright &copy; ' . date("Y") . ' by ' . $data['domain_themes'][$data['hostdomain']]['site'] . ' All rights reserved.</footer> ';

        $body = '<main style="padding-top: 100px;"><style>* { font-family: DejaVu Sans, sans-serif;} ' . $CSS . '</style>' . $html . ' </main>';
        $HtmlContent = '<!DOCTYPE html><html lang="en"><head><title>aaaaa</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>* { font-family: DejaVu Sans, sans-serif;} ' . $CSS . '</style> </head> <body> 
        ' . $header . ' ' . $body . '  ' . $footer . '</body></html>';

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'setAutoTopMargin' => 'pad'
        ]);

        $mpdf->mirrorMargins = 0;
        $mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;
        $mpdf->autoVietnamese = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;

        $mpdf->WriteHTML($HtmlContent);

        $mpdf->use_kwt = true;
        $mpdf->autoPageBreak = false;

        if ($output == "I") {
            $pdfFilePath = $filename;
            return redirect()->to($mpdf->Output($pdfFilePath, 'I'));
        }
        if ($output == "D") {
            $pdfFilePath = $filename;
            return redirect()->to($mpdf->Output($pdfFilePath, 'D'));
        }
        if ($output == "F") {
            $pdfFilePath = UPLOADPATH . $filename;
            return redirect()->to($mpdf->Output($pdfFilePath, 'F'));
        }
    }


}
