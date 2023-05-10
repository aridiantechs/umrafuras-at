<?php namespace App\Controllers;

use App\Models\CronModel;
use App\Models\Crud;
use App\Models\Main;
use App\Models\LeadModel;

class Cron extends BaseController
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
        $CronModel = new CronModel();
        //$CronModel->GetPilgrimByArrivalBySea();
        //$CronModel->GetPilgrimByArrivalByLand();
        //$CronModel->GetPilgrimByDepartureBySea();
        //$CronModel->GetPilgrimByDepartureByLand();
        //$CronModel->TotalArrivals();
        $CronModel->AllowTPTMeccaArrival();
        //$CronModel->TotalPaxinKSA();


    }

    public function UpdatePilgrimAge()
    {
        $Crud = $this->Crud;

        $SQL = 'SELECT * FROM pilgrim."master" WHERE "DOB" IS NOT NULL ';
        $pilgrims = $Crud->ExecuteSQL($SQL);
        foreach ($pilgrims as $pilgrim) {
            $DOB = $pilgrim['DOB'];
            $DOBInYears = AGE($DOB);
            $Crud->UpdateRecord('pilgrim."master"', ["DOBInYears" => $DOBInYears], ["UID" => $pilgrim['UID']]);
        }
    }

    public
    function UpdateGroupsVisaRate()
    {

        $Crud = $this->Crud;
        $MainModel = $this->MainModel;
        $UmrahVisaID = $MainModel->Settings('package_umrah_key');
        $UmrahVisaID = ((isset($UmrahVisaID) && $UmrahVisaID != '' && $UmrahVisaID > 0) ? $UmrahVisaID : 0);

        $GroupSQL = 'SELECT * FROM main."Groups" 
                     WHERE "Visa" = \'Yes\' AND "VisaRate" = 0 
                     AND "PackageID" > 0 AND "Archive" = 0 ';
        $GroupRecords = $Crud->ExecuteSQL($GroupSQL);
        if (count($GroupRecords) > 0 && $UmrahVisaID > 0) {
            foreach ($GroupRecords as $GroupRecord) {
                $VisaRate = $Crud->SingleRecord('packages."Meta"', array('Option' => $UmrahVisaID, 'ReferenceType' => 'Package_Visa_Rates', 'ReferenceID' => $GroupRecord['PackageID']));
                if (isset($VisaRate['Value']) && $VisaRate['Value'] > 0) {
                    $Crud->UpdateRecord('main."Groups"', array('VisaRate' => $VisaRate['Value']), array('UID' => $GroupRecord['UID']));
                }
            }
        }
    }


    public function index()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Crud = $this->Crud;
        echo "Cron Started at " . date("d M, Y h:i A") . " \n \n";

        /////////// Update Currency In DB
        $USD = CurrConvert("USD", "SAR", 1);
        $Crud->UpdateRecord('main."AdminSettings"', array("Description" => $USD), array("Key" => 'usd'));
        echo "1 USD = " . $USD . " SAR \n \n";

        $PKR = CurrConvert("PKR", "SAR", 1);
        $Crud->UpdateRecord('main."AdminSettings"', array("Description" => $PKR), array("Key" => 'pkr'));
        echo "1 PKR = " . $PKR . " SAR \n \n";

        $EUR = CurrConvert("EUR", "SAR", 1);
        $Crud->UpdateRecord('main."AdminSettings"', array("Description" => $EUR), array("Key" => 'eur'));
        echo "1 EUR = " . $EUR . " SAR \n \n";

//        $this->ten_minutes();
//        $this->ten_minutes_a();
//        $this->ten_minutes_b();
//        $this->ten_minutes_c();
//        $this->ten_minutes_d();
//        $this->ten_minutes_e();
//        $this->ten_minutes_f();
//        $this->ten_minutes_g();
//        $this->ten_minutes_h();
//        $this->ten_minutes_i();
//        $this->ten_minutes_j();
//        $this->ten_minutes_k();
//        $this->ten_minutes_l();
//        $this->ten_minutes_m();
//        $this->ten_minutes_n();
//        $this->ten_minutes_o();
//        $this->ten_minutes_p();
//        $this->ten_minutes_q();
    }

    public function ten_minutes()
    {
        $Crud = $this->Crud;
        $MainModel = $this->MainModel;
        echo "Cron Started at " . date("d M, Y h:i A") . "
        \n\n";


        // Default Lookups ///
        $DefaultLookUps = $MainModel->DefaultLookUps();
        $Crud->AlterDefaultLookUps($DefaultLookUps);
        echo "AlterDefaultLookUps Executed
        \n\n";

        // Default Settings ///
        $DefaultSettings = $MainModel->DefaultSettings();
        $Crud->AlterDefaultSettings($DefaultSettings);
        echo "AlterDefaultSettings Executed
        \n\n";

        $DefaultWebsiteSettings = $MainModel->DefaultWebsiteSettings();
        $Crud->AlterDefaultWebsiteSettings($DefaultWebsiteSettings);
        echo "AlterDefaultWebsiteSettings Executed
        \n\n";

        // Default Language Translations
        $DefaultTranslation = $MainModel->DefaultTranslation();
        $Crud->AlterLangTranslations($DefaultTranslation);
        echo "AlterLangTranslations Executed
        \n\n";

        /** Lead Auto Assign to Today Login Sale Officers */
        $LeadsImport = new LeadModel();
        $LeadsImport->AssignNewLeadsToTodayActiveSaleOfficers();
        echo "AssignNewLeadsToTodayActiveSaleOfficers Executed
        \n\n";
    }

    public function ten_minutes_a()
    {
        /////////// Total B2C /////////
//        $CronModel = new CronModel();
//        $CronModel->TotalB2C();
        echo "Total B2C Are Executed
        \n\n";

        /////////// Total B2B Pilgrim /////////
//        $CronModel = new CronModel();
//        $CronModel->TotalB2BPilgrim();
//        echo "Total B2B Pilgrim Are Executed
//        \n\n";


        /////////// Total External Pilgrim /////////
        $CronModel = new CronModel();
        $CronModel->TotalExternalPilgrim();
        echo "Total External Pilgrim Are Executed
        \n\n";


        /////////// Total B2B Agents /////////
        $CronModel = new CronModel();
        $CronModel->TotalB2BAgents();
        echo "Total B2B Agents Are Executed
        \n\n";


        /////////// Total Active B2B Agents /////////
        $CronModel = new CronModel();
        $CronModel->TotalActiveB2BAgents();
        echo "Total Active B2B Agents Are Executed 
        \n\n";

    }

    public function ten_minutes_b()
    {

        /////////// Total In  Active B2B Agents /////////
        $CronModel = new CronModel();
        $CronModel->TotalInactiveB2BAgents();
        echo "Total In Active B2B Agents Are Executed
        \n\n";


        /////////// Total In  Active B2B Agents /////////
        $CronModel = new CronModel();
        $CronModel->TotalExternalAgents();
        echo "Total External B2B Agents Are Executed
        \n\n";

        /////////// Jeddah Arrival /////////
        $CronModel = new CronModel();
        $CronModel->JeddahArrivals();
        echo "Jeddah Arrivals Are Executed
        \n\n";

        /////////// Medina Arrival /////////
        $CronModel = new CronModel();
        $CronModel->MedinaArrivals();
        echo "Medina Arrivals Are Executed
        \n\n";


        /////////// Yanbu Arrival /////////
        $CronModel = new CronModel();
        $CronModel->YanbuArrivals();
        echo "Yanbu Arrivals Are Executed
        \n\n";
    }

    public function ten_minutes_c()
    {

        /////////// Sea Arrival /////////
        $CronModel = new CronModel();
        $CronModel->SeaArrivals();
        echo "Sea Arrivals Are Executed
        \n\n";

        /////////// ByRoad Arrival /////////
        $CronModel = new CronModel();
        $CronModel->ByRoadArrivals();
        echo "By Road Arrivals Are Executed
        \n\n";

        /////////// Total Arrival /////////
//        $CronModel = new CronModel();
//        $CronModel->TotalArrivals();
//        echo "Total Arrivals Are Executed
//        \n\n";
        /////////// Total Exit /////////
        $CronModel = new CronModel();
        $CronModel->TotalExit();
        echo "Total Exit Are Executed
        \n\n";
        /////////// Check In Mecca /////////
        $CronModel = new CronModel();
        $CronModel->CheckInMecca();
        echo "Check In Mecca Are Executed
        \n\n";
    }

    public function ten_minutes_d()
    {

        /////////// Check In Medina /////////
        $CronModel = new CronModel();
        $CronModel->CheckInMedina();
        echo "Check In Medina Are Executed
        \n\n";


        /////////// Check In Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->CheckInJeddah();
        echo "Check In Jeddah Are Executed
        \n\n";

        /////////// PAX In Mecca /////////
        $CronModel = new CronModel();
        $CronModel->PAXInMecca();
        echo "PAX In Mecca Are Executed
        \n\n";


        /////////// PAX In Medina /////////
        $CronModel = new CronModel();
        $CronModel->PAXInMedina();
        echo "PAX In Medina Are Executed
        \n\n";


        /////////// PAX In Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->PAXInJeddah();
        echo "PAX In Jeddah Are Executed
        \n\n";
    }

    public function ten_minutes_e()
    {
        /////////// Check Out Mecca /////////
        $CronModel = new CronModel();
        $CronModel->CheckOutMecca();
        echo "Check Out Mecca Are Executed
        \n\n";

        /////////// Check Out Medina /////////
        $CronModel = new CronModel();
        $CronModel->CheckOutMedina();
        echo "Check Out Medina Are Executed
        \n\n";

        /////////// Check Out Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->CheckOutJeddah();
        echo "Check Out Jeddah Are Executed
        \n\n";


        /////////// Without Hotel Arrival /////////
        $CronModel = new CronModel();
        $CronModel->WithOutHotelArrival();
        echo "Without Hotel Arrival Are Executed
        \n\n";


        /////////// Without Transport Arrival /////////
        $CronModel = new CronModel();
        $CronModel->WithOutTransportArrival();
        echo "Without Transport Arrival Are Executed
        \n\n";
    }

    public function ten_minutes_f()
    {
        /////////// Departure Mecca /////////
        $CronModel = new CronModel();
        $CronModel->DepartureMecca();
        echo "Departure Mecca Are Executed
        \n\n";

        /////////// Departure Medina /////////
        $CronModel = new CronModel();
        $CronModel->DepartureMedina();
        echo "Departure Medina Are Executed
        \n\n";

        /////////// Departure Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->DepartureJeddah();
        echo "Departure Jeddah Are Executed
        \n\n";

        /////////// Voucher Issued /////////
        $CronModel = new CronModel();
        $CronModel->VoucherIssued();
        echo "Voucher Issued Are Executed
        \n\n";

        /////////// Voucher Not Issued /////////
//        $CronModel = new CronModel();
//        $CronModel->VoucherNotIssued();
//        echo "Voucher Not Issued Are Executed
//        \n\n";
    }

    public function ten_minutes_g()
    {
        /////////// Not Check In Mecca /////////
        $CronModel = new CronModel();
        $CronModel->NotCheckInMecca();
        echo "Not Check In Mecca Are Executed
        \n\n";

        /////////// Not Check In Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->NotCheckInJeddah();
        echo "Not Check In Jeddah Are Executed
        \n\n";

        /////////// Not Check In Medina /////////
        $CronModel = new CronModel();
        $CronModel->NotCheckInMedina();
        echo "Not Check In Medina Are Executed
        \n\n";


        /////////// Not Jeddah Arrival /////////
        $CronModel = new CronModel();
        $CronModel->NotJeddahArrival();
        echo "Not Jeddah Arrival Are Executed
        \n\n";


        /////////// Not Departure Jeddah Arrival /////////
        $CronModel = new CronModel();
        $CronModel->NotDepartureJeddahArrival();
        echo "Not Departure Jeddah Arrival Are Executed
        \n\n";
    }

    public function ten_minutes_h()
    {
        /////////// Total Pax In Saudia Arabia /////////
        $CronModel = new CronModel();
        $CronModel->TotalPaxinKSA();
        echo "Total Pax In Saudia Arabia Are Executed
        \n\n";

        /////////// Visa Issued /////////
//        $CronModel = new CronModel();
//        $CronModel->VisaIssued();
//        echo "Visa Issued Are Executed
//        \n\n";

        /////////// Visa Not issued  /////////
        $CronModel = new CronModel();
        $CronModel->VisaNotIssued();
        echo "Visa Not issued Are Executed
        \n\n";

        /////////// Mofa issued /////////
//        $CronModel = new CronModel();
//        $CronModel->MOFAIssued();
//        echo "MOFA Issued Are Executed
//        \n\n";
/////////// Mofa Not issued /////////
//        $CronModel = new CronModel();
//        $CronModel->MOFANotIssued();
//        echo "MOFA Not Issued Are Executed
//        \n\n";
        /////////// Allow TPT Arrival /////////
//        $CronModel = new CronModel();
//        $CronModel->AllowTPTArrival();
//        echo "Allow TPT Arrival Are Executed
//        \n\n";
    }

    public function ten_minutes_i()
    {

        /////////// Allow TPT Departure /////////
//        $CronModel = new CronModel();
//        $CronModel->AllowTPTDeparture();
//        echo "Allow TPT Departure Are Executed
//        \n\n";


        /////////// Allow TPT Departure /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowTPTDeparture();
        echo "Completed Allow TPT Departure Are Executed
        \n\n";


        /////////// COMPLETED Allow TPT Arrival /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowTPTArrival();
        echo "Completed Allow TPT Arrival Are Executed
        \n\n";

        ///////////  Allow HTL Mecca /////////
        $CronModel = new CronModel();
        $CronModel->AllowHTLMeccaArrival();
        echo "Allow HTL Mecca Are Executed
        \n\n";
        ///////////  Completed Allow HTL Mecca /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowHTLMeccaArrival();
        echo "Completed Allow HTL Mecca Are Executed
        \n\n";

    }

    public function ten_minutes_j()
    {
        ///////////  Allow TPT Mecca /////////
//        $CronModel = new CronModel();
//        $CronModel->AllowTPTMeccaArrival();
//        echo "Allow TPT Mecca Are Executed
//        \n\n";
        ///////////  Completed Allow TPT Mecca /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowTPTMeccaArrival();
        echo "Completed Allow TPT Mecca Are Executed
        \n\n";
        ///////////  Allow HTL Medina /////////allow-bed
//        $CronModel = new CronModel();
//        $CronModel->AllowHTLMedinaArrival();
//        echo "Allow HTL Medina Are Executed
//        \n\n";
        ///////////  Completed Allow HTL Medina /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowHTLMedinaArrival();
        echo "Completed Allow HTL Medina Are Executed
        \n\n";
        ///////////  Allow TPT Medina /////////
//        $CronModel = new CronModel();
//        $CronModel->AllowTPTMedina();
//        echo "Allow TPT Medina Are Executed
//        \n\n";
    }

    public function ten_minutes_k()
    {
        ///////////  Completed Allow TPT Medina /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowTPTMedina();
        echo "Completed Allow TPT Medina Are Executed
        \n\n";
        ///////////  Allow HTL Jeddah /////////
//        $CronModel = new CronModel();
//        $CronModel->AllowHTLJeddahArrival();
//        echo "Allow HTL Jeddah Are Executed
//        \n\n";
        ///////////  Completed Allow HTL Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowHTLJeddahArrival();
        echo "Allow HTL Jeddah Are Executed
        \n\n";
        ///////////  Allow TPT Jeddah /////////
        $CronModel = new CronModel();
        $CronModel->AllowTPTJeddah();
        echo "Allow TPT Jeddah Are Executed
        \n\n";
        ///////////  Completed Allow TPT Medina /////////
        $CronModel = new CronModel();
        $CronModel->CompletedAllowTPTJeddah();
        echo "Completed Allow TPT Jeddah Are Executed
        \n\n";
    }

    public function ten_minutes_l()
    {
        ///////////  PPT Management /////////
//        $CronModel = new CronModel();
//        $CronModel->PptManagement();
//        echo "PPT Management Are Executed
//        \n\n";
        ///////////  Completed PPT Management /////////
//        $CronModel = new CronModel();
//        $CronModel->CompletedPptManagement();
//        echo "Completed PPT Management Are Executed
//        \n\n";
        /////////// Pax Details In Voucher Without Hotel /////////
        $CronModel = new CronModel();
        $CronModel->PAXDetailsInVoucherWithoutHotel();
        echo "Pax Details In Voucher Without Hotel Are Executed
        \n\n";

        /////////// Pax Details In Voucher Without Transport /////////
        $CronModel = new CronModel();
        $CronModel->PAXDetailsInVoucherWithoutTransport();
        echo "Pax Details In Voucher Without Transport Are Executed
        \n\n";

        /////////// Only Visa In Voucher /////////
        $CronModel = new CronModel();
        $CronModel->PAXDetailsInVoucherOnlyVisa();
        echo "Only Visa In Voucher Are Executed
        \n\n";
    }

    public function ten_minutes_m()
    {
        /////////// Over 25 Days Arrival /////////
//        $CronModel = new CronModel();
//        $CronModel->Over_25_Days_Arrival();
//        echo "Over 25 Days Arrival Are Executed
//        \n\n";
        /////////// Complete In Over 25 Days Arrival /////////
//        $CronModel = new CronModel();
//        $CronModel->Complete_In_Over_25_Days_Arrival();
//        echo "Complete In Over 25 Days Arrival Are Executed
//        \n\n";
        /////////// Voucher Package /////////
        $CronModel = new CronModel();
        $CronModel->Voucher_Package();
        echo "voucher-package Are Executed
        \n\n";
        /////////// Visa Transport /////////
        $CronModel = new CronModel();
        $CronModel->visa_transport();
        echo "visa-transport Are Executed
        \n\n";
        /////////// Hotel Package /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_Package();
        echo "hotel-package Are Executed
        \n\n";
    }

    public function ten_minutes_n()
    {
        /////////// Transport Package /////////
        $CronModel = new CronModel();
        $CronModel->Transport_Package();
        echo "transport-package Are Executed
        \n\n";
        /////////// Purchase BRN /////////
        $CronModel = new CronModel();
        $CronModel->Purchase_BRN();
        echo "purchase-brn Are Executed
        \n\n";
        /////////// Hotel BRN Used /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Used();
        echo "hotel-brn-used Are Executed
        \n\n";
        /////////// Hotel BRN Balance  /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Balance();
        echo "hotel-brn-balance Are Executed
        \n\n";
        /////////// Hotel BRN Expired  /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Expired();
        echo "hotel-brn-expired Are Executed
        \n\n";
    }

    public function ten_minutes_o()
    {
        /////////// Hotel BRN Actual Room  /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Actual_Room();
        echo "hotel-brn-actual-room Are Executed
        \n\n";
        /////////// Hotel BRN Actual Actual Beds /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Actual_Beds();
        echo "hotel-brn-actual-beds Are Executed
        \n\n";
        /////////// Hotel BRN Actual Balance Room /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Balance_Room();
        echo "hotel-brn-balance-room Are Executed
        \n\n";
        /////////// Hotel BRN Actual Balance Bed /////////
        $CronModel = new CronModel();
        $CronModel->Hotel_BRN_Balance_Bed();
        echo "hotel-brn-balance-bed Are Executed
        \n\n";
        /////////// Transport BRN Used /////////
        $CronModel = new CronModel();
        $CronModel->Transport_BRN_Used();
        echo "transport-brn-used Are Executed
        \n\n";
    }

    public function ten_minutes_p()
    {


        /////////// Transport BRN Balance Executed /////////
        $CronModel = new CronModel();
        $CronModel->Transport_BRN_Balance();
        echo "transport-brn-balance Are Executed
        \n\n";
        /////////// Transport BRN Expired Executed /////////
        $CronModel = new CronModel();
        $CronModel->Transport_BRN_Expired();
        echo "transport-brn-expired Are Executed
        \n\n";

        /////////// Transport BRN Visa Used Executed /////////
        $CronModel = new CronModel();
        $CronModel->Transport_BRN_Visa_Used();
        echo "transport-brn-visa-used Are Executed
        \n\n";

        /////////// Transport BRN Sectors Executed /////////
        $CronModel = new CronModel();
        $CronModel->Transport_BRN_Sectors_Stats();
        echo "transport-brn-sector Are Executed
        \n\n";
    }

    public function ten_minutes_q()
    {

/////////// Free Bed /////////
//        $CronModel = new CronModel();
//        $CronModel->allow_bed();
//        echo "Free Bed Are Executed
//        \n\n";

        $CronModel = new CronModel();
        $CronModel->completed_allow_bed();
        echo "Completed Free Are Executed
        \n\n";
/////////// without voucher Bed /////////
//        $CronModel = new CronModel();
//        $CronModel->without_vocuher_arrival();
//        echo "Without Voucher Arrival Are Executed
//        \n\n";
/////////// without voucher Bed /////////
//        $CronModel = new CronModel();
//        $CronModel->completed_without_vocuher_arrival();
//        echo "Completed Without Voucher Arrival Are Executed
//        \n\n";

        /////////// Get Pilgrim By Activity Status /////////
        $CronModel = new CronModel();
        $CronModel->GetPilgrimByActivityStatus();
        echo "Get Pilgrim By Activity Status
        \n\n";

    }

    public function activities()
    {
        $data = $this->data;

        $CronModel = new CronModel();
        $CronModel->CronActivity();
    }

    public function daily_activities()
    {
        $data = $this->data;

        $CroneModel = new CronModel();
        $class_methods = get_class_methods($CroneModel);
        $CroneModel->CronAllActivitiesRunDaily($class_methods);
    }

    public function dashboard_remaining_stats()
    {
        /////////// Activity Departure Yanbu Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivityDepartureYanbuStats();
        echo "Activity Departure Yanbu Status
        \n\n";

        /////////// Activity Departure Sea Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivityDepartureSeaStats();
        echo "Activity Departure Sea Status
        \n\n";


        /////////// Activity Departure Road Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivityDepartureRoadStats();
        echo "Activity Departure Road Status
        \n\n";


        /////////// Activity Yanbu Arrival Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivityYanbuArrivalStats();
        echo "Activity Yanbu Arrival Status
        \n\n";

        /////////// Activity Sea Arrival Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivitySeaArrivalStats();
        echo "Activity Sea Arrival Status
        \n\n";

        /////////// Activity Road Arrival Status /////////
        $CronModel = new CronModel();
        $CronModel->ActivityRoadArrivalStats();
        echo "Activity Road Arrival Status
        \n\n";


    }


}
