<?php namespace App\Controllers;


use App\Models\Admins;
use App\Models\Agents;
use App\Models\BrnRecords;
use App\Models\CronModel;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\Main;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\SaleAgent;
use App\Models\Sales;
use App\Models\Users;
use App\Models\Voucher;
use PhpOffice\PhpSpreadsheet\src\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\src\PhpSpreadsheet\Reader\Xlsx;

require_once FCPATH . 'vendor/autoload.php';

class Form_process extends BaseController
{
    var $data = array();
    var $MainModel;
    protected $session;
    protected $table = 'websites."Domains"';

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->session->start();
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        $data['parent_mis'] = array('panel.lalaservices.com');

        if ($this->data['module'] != 'form_process' && $this->data['page'] != 'system_user_form_submit') {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }

        $session = session();
        $data['session'] = $session->get();
    }


    public function system_user_form_submit()
    {
        $AgentsDataSubmit = new Agents();

        $Email = $this->request->getVar('Email');
        $Password = $this->request->getVar('Password');
        $Year = $this->request->getVar('Year');


        $LoginCaptcha = $this->request->getVar('LoginCaptcha');
        $InputLoginCaptcha = $this->request->getVar('InputLoginCaptcha');


        $Captchas = array();
        $Captchas['LoginCaptcha'] = $LoginCaptcha;
        $Captchas['InputLoginCaptcha'] = $InputLoginCaptcha;

    //    print_r($Captchas);


        $AgentsDataSubmit->SystemUserFormSubmit($Email, $Password, $Captchas, $Year);

    }

    public
    function agent_form_submit()
    {
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = 0;
        }

        $AgentAddFormSubmit = new Agents();
        $Crud = new Crud();
        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $LastName = $this->request->getVar('LastName');
        $PhoneNumber = $this->request->getVar('PhoneNumber');
        $FaxNumber = $this->request->getVar('FaxNumber');
        $Email = $this->request->getVar('Email');
        $MobileNumber = $this->request->getVar('MobileNumber');
        $Password = $this->request->getVar('Password');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $ContactPersonName = $this->request->getVar('ContactPersonName');
        $Address = $this->request->getVar('Address');
        $WebsiteID = $this->request->getVar('WebsiteID');
        $Type = $this->request->getVar('Type');
        $IATALicense = $this->request->getVar('IATALicense');
        $UmrahAgreement = $this->request->getVar('UmrahAgreement');
        $Status = $this->request->getVar('Status');
        $Domain = $this->request->getVar('Domain');


        $SalesAgent = $this->request->getVar('SalesAgent');


        $records = array();
        $records['FullName'] = $FullName;
        $records['LastName'] = $LastName;
        $records['PhoneNumber'] = $PhoneNumber;
        $records['FaxNumber'] = $FaxNumber;
        $records['MobileNumber'] = $MobileNumber;
        $records['Email'] = $Email;
        $records['CityID'] = $City;
        $records['CountryID'] = $Country;
        $records['ContactPersonName'] = $ContactPersonName;
        $records['Password'] = $Password;
        $records['Address'] = $Address;
        $records['Status'] = $Status;
        $records['Domain'] = $Domain;
        $records['WebsiteDomain'] = $WebsiteID;
        $Type = $Type;
        $records['IATALicense'] = $IATALicense;
        $records['UmrahAgreement'] = $UmrahAgreement;

        $records['ParentID'] = $AgentID;
        $Logo = 0;
        $fileID = $Crud->UploadFile('AgentLogo');
        $Logo = $fileID;

        $FilesData = array();

        $fileIDs = $Crud->UploadFile('AttachFiles', false);
        $FilesData['AttachFiles'] = $fileIDs;

        $FileDescription = $this->request->getVar('FileDescription');
        $FilesData['FileDescription'] = $FileDescription;


        $AgentAddFormSubmit->AgentFormSubmit($records, $UID, $FilesData, $SalesAgent, $Type, $Logo);

    }


    public
    function sub_agent_form_submit()
    {
        $session = session();
        $data['session'] = $session->get();


        $AgentAddFormSubmit = new Agents();
        $Crud = new Crud();
        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $LastName = $this->request->getVar('LastName');
        $PhoneNumber = $this->request->getVar('PhoneNumber');
        $FaxNumber = $this->request->getVar('FaxNumber');
        $Email = $this->request->getVar('Email');
        $MobileNumber = $this->request->getVar('MobileNumber');
        $Password = $this->request->getVar('Password');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $ContactPersonName = $this->request->getVar('ContactPersonName');
        $Address = $this->request->getVar('Address');
        $WebsiteID = $this->request->getVar('WebsiteID');
        $Type = $this->request->getVar('Type');
        $IATALicense = $this->request->getVar('IATALicense');
        $UmrahAgreement = $this->request->getVar('UmrahAgreement');
        $Status = $this->request->getVar('Status');
        $AgentID = $this->request->getVar('AgentID');


        $SalesAgent = $this->request->getVar('SalesAgent');

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = $AgentID;
        }

        $records = array();
        $records['FullName'] = $FullName;
        $records['LastName'] = $LastName;
        $records['PhoneNumber'] = $PhoneNumber;
        $records['FaxNumber'] = $FaxNumber;
        $records['MobileNumber'] = $MobileNumber;
        $records['Email'] = $Email;
        $records['CityID'] = $City;
        $records['CountryID'] = $Country;
        $records['ContactPersonName'] = $ContactPersonName;
        $records['Password'] = $Password;
        $records['Address'] = $Address;
        $records['Status'] = 'Active';
        $records['WebsiteDomain'] = $WebsiteID;
        $Type = $Type;
        $records['IATALicense'] = $IATALicense;
        $records['UmrahAgreement'] = $UmrahAgreement;

        $records['ParentID'] = $AgentID;
        $Logo = 0;
        $fileID = $Crud->UploadFile('AgentLogo');
        $Logo = $fileID;

        $FilesData = array();

        $fileIDs = $Crud->UploadFile('AttachFiles', false);
        $FilesData['AttachFiles'] = $fileIDs;

        $FileDescription = $this->request->getVar('FileDescription');
        $FilesData['FileDescription'] = $FileDescription;


        $AgentAddFormSubmit->AgentFormSubmit($records, $UID, $FilesData, $SalesAgent, $Type, $Logo);

    }

    public
    function sale_agent_form_submit()
    {

        $SaleAgentAddFormSubmit = new SaleAgent();
        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $PhoneNumber = $this->request->getVar('PhoneNumber');
        $Email = $this->request->getVar('Email');
        $Password = $this->request->getVar('Password');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $Address = $this->request->getVar('Address');
        $DomainID = $this->request->getVar('DomainID');
        $EmergencyContactName = $this->request->getVar('EmergencyContactName');
        $EmergencyContactNumber = $this->request->getVar('EmergencyContactNumber');

        $records = array();
        $records['FullName'] = $FullName;
        $records['PhoneNumber'] = $PhoneNumber;
        $records['Email'] = $Email;
        $records['City'] = $City;
        $records['Country'] = $Country;
        $records['Password'] = $Password;
        $records['Address'] = $Address;
        $records['WebsiteDomain'] = $DomainID;
        $records['EmergencyContactName'] = $EmergencyContactName;
        $records['EmergencyContactNumber'] = $EmergencyContactNumber;

        $SaleAgentAddFormSubmit->SaleAgentFormSubmit($records, $UID);

    }

    public
    function B2B_registration_form_submit()
    {
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = 0;
        }

        $AgentAddFormSubmit = new Agents();
        $Crud = new Crud();

        $FullName = $this->request->getVar('FullName');
        $PhoneNumber = $this->request->getVar('PhoneNumber');
        $Email = $this->request->getVar('Email');
        $MobileNumber = $this->request->getVar('MobileNumber');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $ContactPersonName = $this->request->getVar('ContactPersonName');
        $Address = $this->request->getVar('Address');
        $IATALicense = $this->request->getVar('IATALicense');
        $UmrahAgreement = $this->request->getVar('UmrahAgreement');
        $CompanyName = $this->request->getVar('CompanyName');
        $WebsiteID = $this->request->getVar('WebsiteID');


        $RegisterCaptcha = $this->request->getVar('RegisterCaptcha');
        $ForgetRegisterCaptcha = $this->request->getVar('ForgetRegisterCaptcha');


        $records = array();
        $records['FullName'] = $FullName;
        $records['PhoneNumber'] = $PhoneNumber;
        $records['MobileNumber'] = $MobileNumber;
        $records['Email'] = $Email;
        $records['CityID'] = $City;
        $records['CountryID'] = $Country;
        $records['ContactPersonName'] = $ContactPersonName;
        $records['Address'] = $Address;
        $records['Status'] = 'InActive';
        $records['Password'] = '123456';
        $records['ParentID'] = $AgentID;
        $records['IATALicense'] = $IATALicense;
        $records['UmrahAgreement'] = $UmrahAgreement;
        $records['CompanyName'] = $CompanyName;

        if ($WebsiteID == 'localhost' || $WebsiteID == 'panel.lalaservices.com') {
            $records['WebsiteDomain'] = 0;
        } else {
            $records['WebsiteDomain'] = $WebsiteID;
        }

        $Captchas = array();
        $Captchas['RegisterCaptcha'] = $RegisterCaptcha;
        $Captchas['ForgetRegisterCaptcha'] = $ForgetRegisterCaptcha;


        $AgentAddFormSubmit->B2BRegistrationFormSubmit($records, $Captchas);

    }

    public
    function visa_form_submit()
    {

        $VisaAddFormSubmit = new MofaProcess();

        $VisaNumber = $this->request->getVar('VisaNumber');
        $VisaIssueDate = $this->request->getVar('VisaIssueDate');
        $VisaExpiryDate = $this->request->getVar('VisaExpiryDate');
        $MOFANumber = $this->request->getVar('MOFANumber');
        $PilgrimID = $this->request->getVar('PilgrimID');
        $Type = $this->request->getVar('VisaType');

        $records = array();
        $records['VisaNumber'] = $VisaNumber;
        $records['IssueDate'] = $VisaIssueDate;
        $records['ExpireDate'] = $VisaExpiryDate;
        $records['Type'] = $Type;
        $records['MOFANumber'] = $MOFANumber;
        $records['PilgrimID'] = $PilgrimID;

        $Crud = new Crud();
        $fileID = $Crud->UploadFile('UploadFile');
        $records['VisaAttachment'] = $fileID;
        $VisaAddFormSubmit->VisaFormSubmit($records);
    }

    public
    function hotel_form_submit()
    {
        $HotelAddFormSubmit = new Packages();

        $UID = $this->request->getVar('UID');

        $Name = $this->request->getVar('Name');
        $Category = $this->request->getVar('Category');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $Address = $this->request->getVar('Address');
        $TelephoneNumber = $this->request->getVar('TelephoneNumber');
        $Latitude = $this->request->getVar('Latitude');
        $Longitude = $this->request->getVar('Longitude');
        $GoogleMAP = $this->request->getVar('GoogleMAP');
        $Description = $this->request->getVar('Description');
        $Distance = $this->request->getVar('Distance');
        $HotelFacilites = $this->request->getVar('HotelFacilites');
        $HotelAmenities = $this->request->getVar('HotelAmenities');
        $Status = $this->request->getVar('Status');
        $DomainID = $this->request->getVar('DomainID');


        $records = array();
        $records['Name'] = $Name;
        $records['Category'] = $Category;
        $records['Distance'] = $Distance;
        $records['Address'] = $Address;
        $records['TelephoneNumber'] = $TelephoneNumber;
        $records['Latitude'] = $Latitude;
        $records['Longitude'] = $Longitude;
        $records['GoogleMAP'] = $GoogleMAP;
        $records['Description'] = $Description;
        $records['CountryID'] = $Country;
        $records['CityID'] = $City;
        $records['Status'] = $Status;
        $records['WebsiteDomain'] = $DomainID;

//        echo "<pre>"; print_r($_FILES['Images']);

        $Crud = new Crud();
        $fileIDs = $Crud->UploadFile('Images', false);
        $records['Images'] = $fileIDs;

        $records['HotelFacilites'] = $HotelFacilites;
        $records['HotelAmenities'] = $HotelAmenities;

        $HotelAddFormSubmit->HotelFormSubmit($records, $UID);

    }

    public
    function self_hotel_form_submit()
    {
        $HotelAddFormSubmit = new Packages();

        $UID = $this->request->getVar('UID');

        $Name = $this->request->getVar('Name');
        $Category = $this->request->getVar('Category');
        $Country = $this->request->getVar('SelfCountry');
        $City = $this->request->getVar('SelfCity');
        $Address = $this->request->getVar('Address');
        $TelephoneNumber = $this->request->getVar('TelephoneNumber');
        /*$Latitude = $this->request->getVar('Latitude');
        $Longitude = $this->request->getVar('Longitude');
        $GoogleMAP = $this->request->getVar('GoogleMAP');*/
        $Description = $this->request->getVar('Description');
        $Distance = $this->request->getVar('Distance');
        /* $HotelFacilites = $this->request->getVar('HotelFacilites');
         $HotelAmenities = $this->request->getVar('HotelAmenities');*/
        $Status = 'on';
        $DomainID = $this->request->getVar('DomainID');


        $records = array();
        $records['Name'] = $Name;
        $records['Category'] = $Category;
        $records['Distance'] = $Distance;
        $records['Address'] = $Address;
        $records['TelephoneNumber'] = $TelephoneNumber;
        /*$records['Latitude'] = $Latitude;
        $records['Longitude'] = $Longitude;
        $records['GoogleMAP'] = $GoogleMAP;*/
        $records['Description'] = $Description;
        $records['CountryID'] = $Country;
        $records['CityID'] = $City;
        $records['Status'] = $Status;
        $records['WebsiteDomain'] = $DomainID;

//        echo "<pre>"; print_r($_FILES['Images']);

        /*$Crud = new Crud();
        $fileIDs = $Crud->UploadFile('Images', false);
        $records['Images'] = $fileIDs;

        $records['HotelFacilites'] = $HotelFacilites;
        $records['HotelAmenities'] = $HotelAmenities;*/

        $HotelAddFormSubmit->SelfHotelFormSubmit($records, $UID);

    }

    public
    function user_form_submit()
    {
        $session = session();
        $data['session'] = $session->get();

        if ($data['session']['type'] == "agent") {
            $AgentID = $data['session']['agent_id'];
        } else {
            $AgentID = 0;
        }


        $UserAddFormSubmit = new Users();

        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $ContactNumber = $this->request->getVar('ContactNumber');
        $Email = $this->request->getVar('Email');
        $Password = $this->request->getVar('Password');
        $Designation = $this->request->getVar('Designation');
        $UserType = $this->request->getVar('UserType');
        $DomainID = $this->request->getVar('DomainID');
        $ParentID = $this->request->getVar('ParentID');
        $MachineCode = $this->request->getVar('machine_code');

        $UserStatuses = $this->request->getVar('UserStatuses');

        $records = array();
        $records['FullName'] = $FullName;
        $records['ContactNumber'] = $ContactNumber;
        $records['Email'] = $Email;
        $records['Password'] = $Password;
        $records['Designation'] = $Designation;
        $records['UserType'] = $UserType;
        $records['AgentID'] = $AgentID;
        $records['ParentID'] = $ParentID;
        $records['DomainID'] = $DomainID;
        $records['MachineCode'] = $MachineCode;

        $statuses['UserStatuses'] = $UserStatuses;


        $UserAddFormSubmit->UserFormSubmit($records, $UID, $statuses);

    }

    public
    function initial_training_form_submit()
    {
        $data = $this->data;
        $Training = new Sales();
        $UID = $this->request->getVar('UID');
        $Performed = $this->request->getVar('Performed');
        $Remarks = $this->request->getVar('Remarks');

        $Train = array();
        foreach ($Performed as $OptionUID => $Value) {

            $Perform = ((isset($Value) && $Value != '') ? $Value : '');
            $Remark = ((isset($Remarks[$OptionUID]) && $Remarks[$OptionUID] != '') ? $Remarks[$OptionUID] : null);

            $result = array();
            if ($Perform == 1) {

                $result['UID'] = $OptionUID;
                $result['Performed'] = $Perform;
                $result['Remarks'] = $Remark;

                $Train[] = $result;
            }
        }
        $Training::InitialTrainingFormSubmit($UID, $Train);

    }


//    public function initial_training_form_submit()
//    {
//        $session = session();
//        $data['session'] = $session->get();
//
//        $initialtraining = new Sales();
//
//        $UID = $this->request->getVar('UID');
//
//        $StaffID = $this->request->getVar('StaffID');
//        $OptionUID = $this->request->getVar('OptionUID');
//        $Performed = $this->request->getVar('Performed');
//        $Remarks = $this->request->getVar('Remarks');
//        $DomainID = $this->request->getVar('DomainID');
//
//        $records = array();
//        $records['StaffID'] = $StaffID;
//        $records['OptionUID']=$OptionUID;
//        $records['Performed'] = $Performed;
//        $records['Remarks'] = $Remarks;
//        $records['DomainID'] = $DomainID;
//
//        $initialtraining->initialtrainingform($records, $UID);
//    }

    public
    function threshold_form_submit()
    {
        $data = $this->data;
        $session = session();
        $data['session'] = $session->get();

        $AddFormSubmit = new Sales();
        $UID = $this->request->getVar('UID');

        $ProjectID = $this->request->getVar('ProjectID');
        $ThresholdValue = $this->request->getVar('ThresholdValue');

//        print_r($ThresholdValue);
        $ProArray = array();
        foreach ($ProjectID as $OptionUID => $Value) {
            $Pro = ((isset($Value) && $Value != '') ? $Value : '');
            $Threshold = ((isset($ThresholdValue[$OptionUID]) && $ThresholdValue[$OptionUID] != '') ? $ThresholdValue[$OptionUID] : null);
//            print_r($Pro);
//            print_r($Threshold);
            $result = array();
            if ($Pro != '' || $Pro > 0) {
                $result['UserUID'] = $UID;
                $result['ProjectID'] = $Pro;
                $result['ThresholdValue'] = $Threshold;

                $ProArray[] = $result;
            }
//                print_r($ProArray);
//                exit;
        }
//        print_r($ProArray);exit;
        $AddFormSubmit->ThresholdFormSubmit($UID, $ProArray);

    }

    public
    function update_user_time_track()
    {
        $userid = $this->request->getVar('userid');
        $track_type = $this->request->getVar('track_type');
        $stopid = $this->request->getVar('stopid');
        $Operator = new Users();
        $Operator->UpdateUserTimeTracks($userid, $track_type, $stopid);
    }

    public function worksheet_form_submit()
    {
//        echo'<pre>';print_r( $_POST );exit;
        $Admin = new Sales();

        $UID = $this->request->getVar('UID');
        $WorksSheetDate = $this->request->getVar('date');
        $Performed = $this->request->getVar('performed');
        $Remarks = $this->request->getVar('remarks');

        $WorkSheetMetaData = array();
        foreach ($Performed as $OptionUID => $Value) {
            $Perform = ((isset($Value) && $Value != '') ? $Value : '');
            $Remark = ((isset($Remarks[$OptionUID]) && $Remarks[$OptionUID] != '') ? $Remarks[$OptionUID] : null);

            $result = array();
            if ($Perform != '') {
                $result['UID'] = $OptionUID;
                $result['Performed'] = $Perform;
                $result['Remarks'] = $Remark;

                $WorkSheetMetaData[] = $result;
            }
        }

        $Admin->WorkSheetFormSubmit($UID, $WorksSheetDate, $WorkSheetMetaData);
    }

    public
    function add_score_to_organic_platform()
    {
        $UID = $this->request->getVar('UID');
        $Score = $this->request->getVar('Score');
        $Operator = new Sales();
        $Operator->AddScoreToOrganicPlatform($UID, $Score);
    }

    public
    function city_cover_form_submit()
    {
        $CityCoverAddFormSubmit = new Main();
        $Crud = new Crud();


        $Cities = $this->request->getVar('Cities');
        $fileID = $Crud->UploadFile('UploadCoverFile');
        $CoverImage = $fileID;

        $CityCoverAddFormSubmit->CityCoverFilesFormSubmit($CoverImage, $Cities);
    }

    public
    function city_cover_update_form_submit()
    {
        $CityCoverAddFormSubmit = new Main();
        $Crud = new Crud();

        $Cities = $this->request->getVar('Cities');
        $fileID = $Crud->UploadFile('UploadCover');
        $CoverImage = $fileID;

        $CityCoverAddFormSubmit->CityCoverFilesUpdateFormSubmit($CoverImage, $Cities);
    }

    public
    function mofa_file_form_submit()
    {
        $data = $this->data;
        $Crud = new Crud();
        $BrnRecords = new BrnRecords();
        $MainModel = new Main();
        $session = session();
        $InvalidMofaArray = array();
        $Data = array(
            'Umrah Operator' => 'Operator',
            'Agent' => 'ExtAgent',
            'Group Name' => 'Group',
            'Print Date' => 'PrintDate'
        );

        $PilgrimMofaNoArray = $TempMofaNoArray = array();
        $PilgrimsMofaRecord = $MainModel->GetPilgirmsMofaNo();
        foreach ($PilgrimsMofaRecord as $PMR) {
            $PilgrimMofaNoArray[] = $PMR['PilgrimMofaNo'];
        }
        //$TempMofaRecord = $MainModel->GetTempMofaNo();
        /*foreach ($TempMofaRecord as $TMR) {
            $TempMofaNoArray[] = $TMR['TempMofaNo'];
        }*/

        $File = $_FILES['UploadFiles']['tmp_name'];
        $file = $this->request->getFile('UploadFiles');
        $BRN = $this->request->getVar('BRN');




        $Validation = $this->validate(array(
            'UploadFiles' => 'uploaded[UploadFiles]|ext_in[UploadFiles,xls,xlsx]'
        ));

        if (!$Validation) {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = $this->validator->getError('UploadFiles');
            echo json_encode($result);

        } else {

            $upload_file = $_FILES['UploadFiles']['name'];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($File);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, true, false);
            if (!empty($sheetData)) {

                $SaveFileID = $Crud->UploadFile('UploadFiles');
                $FileName = $file->getRandomName();
                $file->move(ROOTPATH . '/writable/uploads/', $FileName);

                $Array = $InstRecords = array();
                $totalDuplicateCount = $totalCount = $totalValidCount = 0;
                $HeadStartCounter = ((trim(str_replace(':', '', $sheetData[2][0])) == 'Umrah Operator') ? 2 : ((trim(str_replace(':', '', $sheetData[1][0])) == 'Umrah Operator') ? 1 : 0));
                $StartCounter = ((trim($sheetData[6][0]) == 'Pilgrim Name') ? 7 : ((trim($sheetData[7][0]) == 'Pilgrim Name') ? 8 : ((trim($sheetData[8][0]) == 'Pilgrim Name') ? 9 : 7)));

                $InvalidMofaArray[] = array('Operator', 'ExtAgent', 'Group', 'PrintDate',
                    'Pilgrim Name', 'PilgrimId', 'Age',
                    'Birth Date', 'Group Name', 'Passport No.', 'MOFA No.',
                    'Issue Date', 'Embassy', 'Package Code', 'Relation', 'Nationality', 'Address',
                    'MOI No.', 'Insurance Policy No');

                for ($b = $HeadStartCounter; $b <= ($StartCounter - 1); $b++) {
                    foreach ($Data as $Key => $Value) {
                        if (trim(str_replace(':', '', $sheetData[$b][0])) == $Key) {
                            $Array[$Value] = $sheetData[$b][2];
                        }
                    }
                }
                for ($a = $StartCounter; $a <= count($sheetData); $a++) {
                    if ($sheetData[$a][5] != '') {

                        $TEMP = array();
                        $TEMP['Operator'] = $Array['Operator'];
                        $TEMP['ExtAgent'] = $Array['ExtAgent'];
                        $TEMP['Group'] = $Array['Group'];
                        $TEMP['PrintDate'] = date("Y-m-d H:i:s", strtotime($Array['PrintDate']));

                        $TEMP['PilgrimName'] = $sheetData[$a][0];
                        $TEMP['PilgrimID'] = $sheetData[$a][1];
                        $TEMP['Age'] = $sheetData[$a][2];
                        $TEMP['DOB'] = date("Y-m-d", strtotime($sheetData[$a][3]));
                        $TEMP['GroupName'] = $sheetData[$a][4];
                        $TEMP['PassportNo'] = $sheetData[$a][5];
                        $TEMP['MOFANumber'] = $sheetData[$a][6];
                        $TEMP['IssueDateTime'] = date("Y-m-d h:i:s", strtotime($sheetData[$a][7]));
                        $TEMP['Embassy'] = $sheetData[$a][8];
                        $TEMP['PKGCode'] = $sheetData[$a][9];
                        $TEMP['Relation'] = $sheetData[$a][10];
                        $TEMP['Nationality'] = $sheetData[$a][11];
                        $TEMP['Address'] = $sheetData[$a][12];
                        $TEMP['SubAgentName'] = $sheetData[$a][13];
                        $TEMP['MOINumber'] = $sheetData[$a][14];
                        $TEMP['INSURANCE_POLICY_ID'] = $sheetData[$a][15];
                        $TEMP['HotelBrn'] = ((isset($sheetData[$a][16]) && trim($sheetData[$a][16]) != '') ? trim($sheetData[$a][16]) : null);
                        $TEMP['TransportBrn'] = ((isset($sheetData[$a][17]) && trim($sheetData[$a][17]) != '') ? trim($sheetData[$a][17]) : null);
                        $TEMP['FileID'] = ((isset($SaveFileID) && $SaveFileID != '') ? $SaveFileID : 0);

                        if (isset($BRN)) {

//                            print_r($BRN);exit;

                            $BrnUID = 0;
                            $BrnArray = array();
                            foreach ($BRN as $brn) {
                                if ($brn != '') {
                                    $BrnArray[] = $brn;
                                }
                            }
                            $BrnIDs = implode(',', $BrnArray);
                            $BrnUID = GetBrnID($BrnIDs);
                            if (isset($BrnUID) && $BrnUID != '') {
                                $table = 'pilgrim."meta"';
                                $ZiyaratRatedata = array();
                                $ZiyaratRatedata['PilgrimUID'] = $sheetData[$a][1];
                                $ZiyaratRatedata['Option'] = 'mofa-issued-brn';
                                $ZiyaratRatedata['Value'] = $BrnUID;
                                $ZiyaratRatedata['CreatedBy'] = $session->get('id');
                                $Crud->AddRecord($table, $ZiyaratRatedata);
                            }
                        }

                        if (in_array($sheetData[$a][6], $PilgrimMofaNoArray)) {
                            $totalDuplicateCount++;
                            $InvalidMofaArray[] = $TEMP;
                        } else {

                            $TempMofaRecord = $MainModel->GetTempMofaNo();
                            foreach ($TempMofaRecord as $TMR) {
                                $TempMofaNoArray[] = $TMR['TempMofaNo'];
                            }

                            $table = 'temp."mofa_file"';
                            if (in_array($sheetData[$a][6], $TempMofaNoArray)) {
                                //////  DUPLICATE IN TEMP MOFA
                                $totalDuplicateCount++;
                                $InvalidMofaArray[] = $TEMP;
                            } else {
                                $Crud->AddRecord($table, $TEMP);
                                $totalValidCount++;
                            }
                        }
                        $totalCount++;
                    }
                }

                $result = array();
                if (count($InvalidMofaArray) > 1) {
                    $result['mofa_array'] = $InvalidMofaArray;
                    $ResponseMessage = 'Total <b>\'' . $totalCount . '\'</b> Record Found, Valid Record = <b>\'' . $totalValidCount . '\'</b>, Duplicate Record = <b>\'' . $totalDuplicateCount . '\'</b> &raquo; 
                    <a style="color:red; text-decoration: underline;" target="_blank" href="' . $data['path'] . 'form_process/create_invalid_mofa_file_uploader_csv">Click To View <b>( \'' . $totalDuplicateCount . '\' )</b> Records.</a>';
                } else {
                    $result['mofa_array'] = $InvalidMofaArray;
                    $ResponseMessage = 'Total <b>\'' . $totalCount . '\'</b> Record Found, Valid Record = <b>\'' . $totalValidCount . '\'</b>, Duplicate Record = <b>\'' . $totalDuplicateCount . '\'</b>';
                }
                $result['status'] = 'success';
                $result['message'] = $ResponseMessage;
                echo json_encode($result);

                $session->set('InvalidMofaData', $result);

            } else {
                $result = array();
                $result['status'] = "fail";
                $result['message'] = "Record Not Found, File Empty";
                echo json_encode($result);
            }
        }
    }

    public
    function vou_pilgrim_file_form_submit()
    {
        $session = session();
        $data = $this->data;
        $FinalArray = array();
        $CroneModel = new CronModel();
        $CheckCount = 0;
        $File = $_FILES['UploadFiles']['tmp_name'];
        $file = $this->request->getFile('UploadFiles');
        $Flag = $this->request->getVar('Flag');
        $TotalRecord = $TotalValidRecord = $TotalInValidRecord = 0;

        $Validation = $this->validate(array(
            'UploadFiles' => 'uploaded[UploadFiles]|ext_in[UploadFiles,xls,xlsx]'
        ));

        if (!$Validation) {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = $this->validator->getError('UploadFiles');
            echo json_encode($result);

        } else {

            $upload_file = $_FILES['UploadFiles']['name'];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($File);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, true, false);
            if (!empty($sheetData)) {

                $FileName = $file->getRandomName();
                $file->move(ROOTPATH . '/writable/uploads/', $FileName);

                $InvalidElmArray[] = array('EACode', 'EA _Name', 'groupcode',
                    'GroupDesc', 'Pilgrim ID', 'Name', 'BirthDate',
                    'Passport No.', 'MOI Number', 'MOFA Number', 'Visa No.', 'Entry Date', 'Entry Time',
                    'Entry Port', 'Transport Mode', 'Entry Carrier', 'Flight No', 'Package');

                for ($a = 1; $a <= count($sheetData); $a++) {

                    if ($sheetData[$a][1] != '') {

                        $TotalRecord++;
                        $EntryDate = explode(" ", trim($sheetData[$a][12]));

                        $TEMP = array();
                        $TEMP['EACode'] = $sheetData[$a][1];
                        $TEMP['EAName'] = $sheetData[$a][2];
                        $TEMP['GroupCode'] = $sheetData[$a][3];
                        $TEMP['GroupDesc'] = $sheetData[$a][4];
                        $TEMP['PilgrimID'] = $sheetData[$a][5];
                        $TEMP['Name'] = $sheetData[$a][6];
                        $TEMP['BirthDate'] = date("Y-m-d", strtotime($sheetData[$a][7]));
                        $TEMP['PassportNo'] = trim($sheetData[$a][8]);
                        $TEMP['MOINumber'] = trim($sheetData[$a][9]);
                        $TEMP['MOFANumber'] = trim($sheetData[$a][10]);
                        $TEMP['VisaNo'] = trim($sheetData[$a][11]);
                        $EntryString = $sheetData[$a][12];
                        $TEMP['EntryDate'] = date("Y-m-d", strtotime($EntryDate[0]));
                        $TEMP['EntryTime'] = date("H:i:s", strtotime(end($EntryDate)));
                        $TEMP['EntryPort'] = $sheetData[$a][13];
                        $TEMP['TransportMode'] = $sheetData[$a][14];
                        $TEMP['EntryCarrier'] = $sheetData[$a][15];
                        $TEMP['FlightNo'] = $sheetData[$a][16];
                        $TEMP['Package'] = $sheetData[$a][17];

                        /** Jawad Code Start */
                        $Crud = new Crud();
                        $table = 'pilgrim."travel"';
                        $where = array(
                            "MOINumber" => '' . $TEMP['MOINumber'] . ''
                        );
                        $TravelRecord = $Crud->SingleRecord($table, $where, false);
                        if (!isset($TravelRecord['UID'])) {

                            $MofaTable = 'pilgrim."mofa"';
                            $InnerWhere = array(
                                'MOINumber' => '' . $TEMP['MOINumber'] . ''
                            );
                            $MofaRecord = $Crud->SingleRecord($MofaTable, $InnerWhere, false);
                            if (isset($MofaRecord['MOFAPilgrimID'])) {

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
                                $travel['Flag'] = ((isset($Flag) && $Flag != '') ? $Flag : 'Arrival');
                                $Crud->AddRecord('pilgrim."travel"', $travel);

                                $TotalValidRecord++;

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

                                $InvalidElmArray[] = $TEMP;
                                $TotalInValidRecord++;
                            }

                        } else {
                            /** Duplicate Entry*/

                            $InvalidElmArray[] = $TEMP;
                            $TotalInValidRecord++;
                        }
                        /** Jawad Code Ends */

                    }

                }

                $result = array();
                if (count($InvalidElmArray) > 0) {
                    $result['elm_array'] = $InvalidElmArray;
                    $ResponseMessage = 'Total <b>\'' . $TotalRecord . '\'</b> Record Found, Valid Record = <b>\'' . $TotalValidRecord . '\'</b>, Duplicate Record = <b>\'' . $TotalInValidRecord . '\'</b> &raquo; 
                    <a style="color:red; text-decoration: underline;" target="_blank" href="' . $data['path'] . 'form_process/create_invalid_elm_file_uploader_csv">Click To View <b>( \'' . $TotalInValidRecord . '\' )</b> Records.</a>';
                } else {
                    $result['elm_array'] = $InvalidElmArray;
                    $ResponseMessage = 'Total <b>\'' . $TotalRecord . '\'</b> Record Found, Valid Record = <b>\'' . $TotalValidRecord . '\'</b>, Duplicate Record = <b>\'' . $TotalInValidRecord . '\'</b>';
                }
                $result['status'] = 'success';
                $result['message'] = $ResponseMessage;
                $session->set('InvalidElmData', $result);

                echo json_encode($result);

            } else {

                $result = array();
                $result['status'] = "fail";
                $result['message'] = "Record Not Found, File Empty";
                echo json_encode($result);

            }
        }
    }

    public
    function create_invalid_mofa_file_uploader_csv()
    {

        $session = session();
        $SessionKey = 'InvalidMofaData';
        if (isset($SessionKey) && $SessionKey != '') {

            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=invalid_mofa_file (" . date("d M, Y") . ").csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $ElmStatusSessionData = $session->get($SessionKey);
            $InvalidFileUploaderArray = $ElmStatusSessionData['mofa_array'];
            $fp = fopen('php://output', 'w');
            foreach ($InvalidFileUploaderArray as $Array) {
                fputcsv($fp, $Array);
            }
            fclose($fp);
        }
    }

    public
    function create_invalid_elm_file_uploader_csv()
    {

        $session = session();
        $SessionKey = 'InvalidElmData';
        if (isset($SessionKey) && $SessionKey != '') {

            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename=invalid_elm_file (" . date("d M, Y") . ").csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            $ElmStatusSessionData = $session->get($SessionKey);
            $InvalidFileUploaderArray = $ElmStatusSessionData['elm_array'];
            $fp = fopen('php://output', 'w');
            foreach ($InvalidFileUploaderArray as $Array) {
                fputcsv($fp, $Array);
            }
            fclose($fp);
        }
    }

    public
    function old_mofa_file_form_submit()
    {
        $MofaFileAddFormSubmit = new MofaProcess();
        $records = array();

        $path = $this->request->getFile('UploadFiles');
        $BRN = $this->request->getVar('BRN');
        $file = json_decode(json_encode($path), true);
        $name = $path->getRandomName();
        $records['path'] = $path;

        if (isset($BRN) && empty($BRN))
            $BRN = 0;

        $MofaFileAddFormSubmit->MofaFormSubmit($records, $name, $BRN);
    }

    public
    function old_vou_pilgrim_file_form_submit()
    {
        $VOUPilgrimFileAddFormSubmit = new Pilgrims();

        $path = $this->request->getFile('UploadFiles');
        $name = $path->getRandomName();
        $records['path'] = $path;
        //echo $path; exit;

        $VOUPilgrimFileAddFormSubmit->VOUPilgrimFileFormSubmit($records, $name);
    }

    public
    function pilgrim_passport_images_form_submit()
    {
        $response = array();
        $Crud = new Crud();
        $PassportImages = $_FILES['Passport'];
        //echo "<pre>"; print_r($PassportImages);
        $Pilgrims = new Pilgrims();
        $PilgrimsRecords = $Pilgrims->ListPilgrims();
        foreach ($PilgrimsRecords as $PilgrimsRecord) {
            $pilgrimid = $PilgrimsRecord['UID'];
            if (isset($PassportImages['name'][$pilgrimid]))
                foreach ($PassportImages['name'][$pilgrimid] as $fileType => $files) {
                    $AttachmentsData = array();
                    $temp_name = $PassportImages['tmp_name'][$pilgrimid][$fileType];
                    if (!empty($temp_name)) {
                        //echo $pilgrimid . " - ".$fileType.": " . $temp_name."<br>";
                        $records = array();
                        $records['SystemDate'] = 'now()';
                        $records['Ext'] = $PassportImages['type'][$pilgrimid][$fileType];
                        $file_content = file_get_contents($PassportImages['tmp_name'][$pilgrimid][$fileType]);
                        $file_content = base64_encode($file_content);
                        $records['Content'] = $file_content;
                        //print_r($records);
                        $recordid = $Crud->AddRecord('uploads."Files"', $records);
                        $AttachmentsData["PilgrimID"] = $pilgrimid;
                        $AttachmentsData["FileID"] = $recordid;

                        if ($fileType == 'Front') {
                            $AttachmentsData["FileDescription"] = 'PassportFrontPic';
                        }
                        if ($fileType == 'Booklet') {
                            $AttachmentsData["FileDescription"] = 'PassportBookletPic';
                        }
                        if ($fileType == 'Back') {
                            $AttachmentsData["FileDescription"] = 'PassportBackPic';
                        }
                        $table = 'pilgrim."attachments"';
                        $Crud->AddRecord($table, $AttachmentsData);
                    }
                }
        }

        $response['status'] = "success";
        $response['message'] = "Passport Images Successfully Added...";
        echo json_encode($response);
    }

    public
    function pilgrim_visa_details_form_submit()
    {
        $Crud = new Crud();
        $Pilgrims = new Pilgrims();

//        $UID = $this->request->getVar('UID');
//        $VisaNumber = $this->request->getVar('VisaNumber');
//        $VisaIssueDate = $this->request->getVar('VisaIssueDate');
//        $VisaType = $this->request->getVar('VisaType');
//
//        $records = array();
//        $records['VisaNumber'] = $VisaNumber;
//        $records['IssueDate'] = $VisaIssueDate;
//        $records['Type'] = $VisaType;

        $Visa = $this->request->getVar('Visa');

        $Pilgrims->PilgrimVisaDetailForm($Visa);


    }

    public
    function GetRoomTypePackageForGroup()
    {
        $CRUD = new Crud();
        $RoomTypeID = $this->request->getVar('RoomType');
        $AgentID = $this->request->getVar('AgentID');
        $HotelID = $this->request->getVar('HotelID');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $RoomTypeName = OptionName($RoomTypeID);
        $rate = 1;

        $days = 1;
        if ($CheckIn != '' && $CheckIn != '') {
            $days = date_diff(date_create($CheckIn), date_create($CheckOut));
            $days = $days->days;
        }

        if ($HotelID > 0 && $RoomTypeID > 0) {

        }

        $Query = 'SELECT "packages"."HotelsRate"."Rate" FROM "packages"."HotelsRate" WHERE "packages"."HotelsRate"."PackageUID" IN 
        ( SELECT "packages"."Packages"."UID" FROM "packages"."Packages" WHERE "packages"."Packages"."AgentUID" = ' . $AgentID . ' ) 
        AND "packages"."HotelsRate"."HotelUID" = ' . $HotelID . ' AND "packages"."HotelsRate"."RoomTypeUID" = ' . $RoomTypeID . ' ';
        $rslt = $CRUD->ExecuteSQL($Query);
        if (isset($rslt[0]['Rate'])) $rate = $rslt[0]['Rate'];
        $response['status'] = "success";
        $response['days'] = $days;
        $response['NoOfBeds'] = $NoOfBeds;
        $response['Rate'] = $rate * $NoOfBeds * $days;
        $response['CurrentCharges'] = Money($rate * $NoOfBeds * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
        $response['CurrentChargesValue'] = $rate * $NoOfBeds;
        /*if(trim($RoomTypeName)!='Sharing'){
            $response['CurrentCharges'] = Money($rate  * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
            $response['CurrentChargesValue'] = $rate;
        }*/
        $response['xxxx'] = $rslt;
        $response['sql'] = $Query;
        $response['Charges'] = $rate * $days;
        echo json_encode($response);
    }

    public
    function GetRoomTypePackage()
    {
        $CRUD = new Crud();
        $RoomTypeID = $this->request->getVar('RoomType');
        $AgentID = $this->request->getVar('AgentID');
        $HotelID = $this->request->getVar('HotelID');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $rate = 1;
        $RoomTypeName = OptionName($RoomTypeID);
        $days = 1;
        if ($CheckIn != '' && $CheckIn != '') {
            $days = date_diff(date_create($CheckIn), date_create($CheckOut));
            $days = $days->days;
        }

        if ($HotelID > 0 && $RoomTypeID > 0) {

        }

        $Query = 'SELECT 
                    "packages"."HotelsRate"."Rate" 
                     FROM "packages"."HotelsRate" 
                     WHERE "packages"."HotelsRate"."PackageUID" IN 
        ( SELECT "packages"."Packages"."UID" FROM "packages"."Packages" WHERE "packages"."Packages"."AgentUID" = ' . $AgentID . ' ) 
        AND "packages"."HotelsRate"."HotelUID" = ' . $HotelID . ' AND "packages"."HotelsRate"."RoomTypeUID" = ' . $RoomTypeID . ' ';
        //echo nl2br($Query);exit();
        $rslt = $CRUD->ExecuteSQL($Query);
        if (isset($rslt[0]['Rate'])) $rate = $rslt[0]['Rate'];
        $response['status'] = "success";
        $response['days'] = $days;
        $response['NoOfBeds'] = $NoOfBeds;
        $response['RoomTypeName'] = $RoomTypeName;
        $response['CurrentCharges'] = Money($rate * $NoOfBeds * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
        $response['CurrentChargesValue'] = $rate * $NoOfBeds * $days;
        if (trim($RoomTypeName) != 'Sharing') {
            $response['CurrentCharges'] = Money($rate * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
            $response['CurrentChargesValue'] = $rate * $days;
        }

        $response['xxxx'] = $rslt;
        $response['sql'] = $Query;
        $response['Charges'] = $rate * $days;
        echo "<pre>";
        print_r($response);
        exit;
        echo json_encode($response);
    }

    public
    function GetRoomTypePackageForVoucher()
    {
        $CRUD = new Crud();
        $RoomTypeID = $this->request->getVar('RoomType');
        $AgentID = $this->request->getVar('AgentID');
        $HotelID = $this->request->getVar('HotelID');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $rate = 1;
        $RoomTypeName = OptionName($RoomTypeID);
        $days = 1;
        if ($CheckIn != '' && $CheckIn != '') {
            $days = date_diff(date_create($CheckIn), date_create($CheckOut));
            $days = $days->days;
        }

        if ($HotelID > 0 && $RoomTypeID > 0) {

        }

        $Query = 'SELECT 
                    "packages"."HotelsRate"."Rate" 
                     FROM "packages"."HotelsRate" 
                     WHERE "packages"."HotelsRate"."PackageUID" IN 
        ( SELECT "packages"."Packages"."UID" FROM "packages"."Packages" WHERE "packages"."Packages"."AgentUID" = ' . $AgentID . ' ) 
        AND "packages"."HotelsRate"."HotelUID" = ' . $HotelID . ' AND "packages"."HotelsRate"."RoomTypeUID" = ' . $RoomTypeID . ' ';
        //echo nl2br($Query);exit();
        $rslt = $CRUD->ExecuteSQL($Query);
        if (isset($rslt[0]['Rate'])) $rate = $rslt[0]['Rate'];
        $response['status'] = "success";
        $response['days'] = $days;
        $response['NoOfBeds'] = $NoOfBeds;
        $response['RoomTypeName'] = $RoomTypeName;
        $response['CurrentCharges'] = Money($rate * $NoOfBeds * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
        $response['CurrentChargesValue'] = $rate * $NoOfBeds * $days;
//        if (trim($RoomTypeName) != 'Sharing') {
//            $response['CurrentCharges'] = Money($rate * $days) . " / " . $days . " Nights<br><small>" . Money($rate) . " / Night</small>";
//            $response['CurrentChargesValue'] = $rate * $days;
//        }

        $response['xxxx'] = $rslt;
        $response['sql'] = $Query;
        $response['Charges'] = $rate * $days;
        echo json_encode($response);
    }

    public
    function group_form_submmary()
    {
        $GroupAddFormSubmit = new Groups();

        $UID = $this->request->getVar('UID');

        $Agent = $this->request->getVar('AgentID');
        $Package = $this->request->getVar('PackageUID');
        $Status = $this->request->getVar('Status');
        $Country = $this->request->getVar('Country');
        $FullName = $this->request->getVar('GroupName');
        $WTUCode = $this->request->getVar('WTUCode');
        $TransportType = $this->request->getVar('TransportType');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $Remarks = $this->request->getVar('Remarks');
        $DomainID = $this->request->getVar('DomainID');
        $Visa = $this->request->getVar('Visa');
        $RefundAmount = $this->request->getVar('RefundAmount');

        $NoOfPAX = $this->request->getVar('NoOfPAX');
        $ChildPax = $this->request->getVar('ChildPax');
        $InfantPax = $this->request->getVar('InfantPax');

        $City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotels');
        $BRNType = $this->request->getVar('BRNType');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AmountPayable = $this->request->getVar('AmountPayable');
        $AmountHotelPayable = $this->request->getVar('AmountHotelPayable');

        $TransportSectors = $this->request->getVar('TransportSectors');
        $Transport = $this->request->getVar('Transport');
        $TransportBRNType = $this->request->getVar('TransportBRNType');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $TransportsRates = $this->request->getVar('TransportsRates');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $ZiyaratTransport = $this->request->getVar('ZiyaratTransport');
        $ZiyaratTransportRate = $this->request->getVar('ZiyaratTransportRate');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');

        $VoucherServicesID = $this->request->getVar('VoucherServicesID');
        $VoucherServiceRate = $this->request->getVar('VoucherServiceRate');

        $records = array();
        $records['AgentID'] = $Agent;
        $records['PackageID'] = $Package;
        $records['FullName'] = $FullName;
        $records['Status'] = $Status;
        $records['Country'] = $Country;
        $records['WTUCode'] = $WTUCode;
        $records['NoOfPAX'] = $NoOfPAX;
        $records['ChildPax'] = ((isset($ChildPax) && $ChildPax != '') ? $ChildPax : 0);
        $records['InfantPax'] = ((isset($InfantPax) && $InfantPax != '') ? $InfantPax : 0);
        $records['TransportType'] = $TransportType;
        $records['ArrivalDate'] = date("Y-m-d", strtotime($ArrivalDate));
        $records['DepartureDate'] = date("Y-m-d", strtotime($DepartureDate));
        $records['Remarks'] = $Remarks;
        $records['WebsiteDomain'] = $DomainID;
        $records['Visa'] = $Visa;
        $records['RefundAmount'] = $RefundAmount;

        $HotelRecords = array();
        $HotelRecords['City'] = $City;
        $HotelRecords['Hotel'] = $Hotel;
        $HotelRecords['BRNType'] = $BRNType;
        $HotelRecords['RoomType'] = $RoomType;
        $HotelRecords['CheckIn'] = $CheckIn;
        $HotelRecords['CheckOut'] = $CheckOut;
        $HotelRecords['NoOfBeds'] = $NoOfBeds;
        $HotelRecords['AmountPayable'] = $AmountPayable;
        $HotelRecords['AmountHotelPayable'] = $AmountHotelPayable;

        $TransportRecords = array();
        $TransportRecords['TransportSectors'] = $TransportSectors;
        $TransportRecords['Transport'] = $Transport;
        $TransportRecords['TransportBRNType'] = $TransportBRNType;
        $TransportRecords['NoOfPax'] = $NoOfPax;
        $TransportRecords['NoOfSeats'] = $NoOfSeats;
        $TransportRecords['TransportsRates'] = $TransportsRates;

        $ZiyaratRecords = array();
        $ZiyaratRecords['ZiyaratCity'] = $ZiyaratCity;
        $ZiyaratRecords['Ziyarat'] = $Ziyarat;
        $ZiyaratRecords['ZiyaratTransportRate'] = $ZiyaratTransportRate;
        $ZiyaratRecords['ZiyaratTransport'] = $ZiyaratTransport;
        $ZiyaratRecords['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $ServicesID = array();
        $ServicesID['ServicesID'] = $VoucherServicesID;
        $ServicesID['VoucherServiceRate'] = $VoucherServiceRate;

        $GroupAddFormSubmit->GroupFormSummary($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID);
    }

    public
    function brn_promo_code_form_submit()
    {
        $BRNAddFormSubmit = new BrnRecords();
        $session = session();
        $DomainID = $session->get('domainid');

        $UID = $this->request->getVar('UID');

        $PromoCode = $this->request->getVar('PromoCode');
        $ActivationDate = $this->request->getVar('ActivationDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $AgentUID = $this->request->getVar('Agent');
        $HotelUID = $this->request->getVar('Hotel');
        $CareOf = $this->request->getVar('CareOf');
        $Status = $this->request->getVar('Status');

        $records = array();
        $records['PromoCode'] = $PromoCode;
        $records['ActivationDate'] = $ActivationDate;
        $records['ExpiryDate'] = $ExpiryDate;
        $records['AgentUID'] = $AgentUID;
        $records['HotelUID'] = $HotelUID;
        $records['CareOf'] = ((isset($CareOf) && $CareOf != '') ? $CareOf : null);
        $records['Status'] = $Status;

        $BRNAddFormSubmit->BRNPromoCodeFormSubmit($records, $UID);
    }

    public
    function group_form_submit()
    {
        $GroupAddFormSubmit = new Groups();

        $UID = $this->request->getVar('UID');

        $Agent = $this->request->getVar('AgentID');
        $Status = $this->request->getVar('Status');
        $Country = $this->request->getVar('Country');
        $FullName = $this->request->getVar('GroupName');
        $GroupType = $this->request->getVar('GroupType');
        $WTUCode = $this->request->getVar('WTUCode');
        $TransportType = $this->request->getVar('TransportType');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $Remarks = $this->request->getVar('Remarks');
        $DomainID = $this->request->getVar('DomainID');
        $Visa = $this->request->getVar('Visa');
        $PackageUID = $this->request->getVar('PackageUID');

        $NoOfPAX = $this->request->getVar('NoOfPAX');
        $ChildPax = $this->request->getVar('ChildPax');
        $InfantPax = $this->request->getVar('InfantPax');

        $RefundAmount = $this->request->getVar('RefundAmount');
        $GrandTotal = $this->request->getVar('GrandTotal');

        $City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotels');
        $BRNType = $this->request->getVar('BRNType');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AmountPayable = $this->request->getVar('AmountPayable');
        $AmountHotelPayable = $this->request->getVar('AmountHotelPayable');


        $TransportSectors = $this->request->getVar('TransportSectors');
        $Transport = $this->request->getVar('Transport');
        $TransportBRNType = $this->request->getVar('TransportBRNType');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $TransportsRates = $this->request->getVar('TransportsRates');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $ZiyaratTransport = $this->request->getVar('ZiyaratTransport');
        $ZiyaratTransportRate = $this->request->getVar('ZiyaratTransportRate');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');

        $VoucherServicesID = $this->request->getVar('VoucherServicesID');
        $VoucherServiceRate = $this->request->getVar('VoucherServiceRate');

        $Record = array();
        $GroupSubmittedPackageUID = $this->request->getVar('GroupSubmittedPackageUID');
        $GroupSubmittedPackageUID = ((isset($GroupSubmittedPackageUID) && $GroupSubmittedPackageUID != '') ? $GroupSubmittedPackageUID : 0);
        $Record['GroupSubmittedPackageUID'] = $GroupSubmittedPackageUID;

        $records = array();
        $records['AgentID'] = $Agent;
        $records['FullName'] = $FullName;
        if ($UID == 0) {
            $records['Status'] = 'in-complete';
        }

        $records['Country'] = $Country;
        $records['WTUCode'] = $WTUCode;
        $records['NoOfPAX'] = $NoOfPAX;
        $records['ChildPax'] = ((isset($ChildPax) && $ChildPax != '') ? $ChildPax : 0);
        $records['InfantPax'] = ((isset($InfantPax) && $InfantPax != '') ? $InfantPax : 0);
        $records['GroupType'] = $GroupType;
        $records['TransportType'] = $TransportType;
        $records['ArrivalDate'] = date("Y-m-d", strtotime($ArrivalDate));
        $records['DepartureDate'] = date("Y-m-d", strtotime($DepartureDate));
        $records['Remarks'] = $Remarks;
        $records['WebsiteDomain'] = $DomainID;
        $records['Visa'] = $Visa;
        $records['PackageID'] = $PackageUID;
        $records['RefundAmount'] = $RefundAmount;
        $records['TotalAmount'] = $GrandTotal;

        $HotelRecords = array();
        $HotelRecords['City'] = $City;
        $HotelRecords['Hotel'] = $Hotel;
        $HotelRecords['BRNType'] = $BRNType;
        $HotelRecords['RoomType'] = $RoomType;
        $HotelRecords['CheckIn'] = $CheckIn;
        $HotelRecords['CheckOut'] = $CheckOut;
        $HotelRecords['NoOfBeds'] = $NoOfBeds;
        $HotelRecords['AmountPayable'] = $AmountPayable;
        $HotelRecords['AmountHotelPayable'] = $AmountHotelPayable;

        $TransportRecords = array();
        $TransportRecords['TransportSectors'] = $TransportSectors;
        $TransportRecords['Transport'] = $Transport;
        $TransportRecords['BRNType'] = $TransportBRNType;
        $TransportRecords['NoOfPax'] = $NoOfPax;
        $TransportRecords['NoOfSeats'] = $NoOfSeats;
        $TransportRecords['TransportsRates'] = $TransportsRates;

        $ZiyaratRecords = array();
        $ZiyaratRecords['ZiyaratCity'] = $ZiyaratCity;
        $ZiyaratRecords['Ziyarat'] = $Ziyarat;
        $ZiyaratRecords['ZiyaratTransportRate'] = $ZiyaratTransportRate;
        $ZiyaratRecords['ZiyaratTransport'] = $ZiyaratTransport;
        $ZiyaratRecords['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $ServicesID = array();
        $ServicesID['ServicesID'] = $VoucherServicesID;
        $ServicesID['VoucherServiceRate'] = $VoucherServiceRate;

        //echo "<pre>";
        //print_r($_REQUEST);
        //print_r($HotelRecords);
        $GroupAddFormSubmit->GroupFormSubmit($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID, $Record);
    }

    public
    function group_bulk_pilgrim_form_submmary()
    {
        $GroupAddFormSubmit = new Groups();

        $UID = $this->request->getVar('UID');

        $Agent = $this->request->getVar('AgentID');
        $Package = $this->request->getVar('PackageUID');
        $Status = $this->request->getVar('Status');
        $Country = $this->request->getVar('Country');
        $FullName = $this->request->getVar('GroupName');
        $WTUCode = $this->request->getVar('WTUCode');
        $NoOfPAX = $this->request->getVar('NoOfPAX');
        $TransportType = $this->request->getVar('TransportType');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $Remarks = $this->request->getVar('Remarks');
        $DomainID = $this->request->getVar('DomainID');
        $Visa = $this->request->getVar('Visa');
        $Pilgrim = $this->request->getVar('Pilgrim');
        $RefundAmount = $this->request->getVar('RefundAmount');

        /*$City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotels');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AmountPayable = $this->request->getVar('AmountPayable');*/

        $City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotels');
        $BRNType = $this->request->getVar('BRNType');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AmountPayable = $this->request->getVar('AmountPayable');
        $AmountHotelPayable = $this->request->getVar('AmountHotelPayable');


        $TransportSectors = $this->request->getVar('TransportSectors');
        $Transport = $this->request->getVar('Transport');
        $TransportBRNType = $this->request->getVar('TransportBRNType');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $TransportsRates = $this->request->getVar('TransportsRates');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $ZiyaratTransport = $this->request->getVar('ZiyaratTransport');
        $ZiyaratTransportRate = $this->request->getVar('ZiyaratTransportRate');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');

        $VoucherServicesID = $this->request->getVar('VoucherServicesID');
        $VoucherServiceRate = $this->request->getVar('VoucherServiceRate');


        $records = array();
        $records['AgentID'] = $Agent;
        $records['PackageID'] = $Package;
        $records['FullName'] = $FullName;
        $records['Status'] = $Status;
        $records['Country'] = $Country;
        $records['WTUCode'] = $WTUCode;
        $records['NoOfPAX'] = $NoOfPAX;
        $records['TransportType'] = $TransportType;
        $records['ArrivalDate'] = date("Y-m-d", strtotime($ArrivalDate));
        $records['DepartureDate'] = date("Y-m-d", strtotime($DepartureDate));
        $records['Remarks'] = $Remarks;
        $records['WebsiteDomain'] = $DomainID;
        $records['Visa'] = $Visa;
        $records['Pilgrims'] = $Pilgrim;
        $records['RefundAmount'] = $RefundAmount;

        //echo "<pre>"; print_r($_REQUEST); exit;
        $HotelRecords = array();
        $HotelRecords['City'] = $City;
        $HotelRecords['Hotel'] = $Hotel;
        $HotelRecords['BRNType'] = $BRNType;
        $HotelRecords['RoomType'] = $RoomType;
        $HotelRecords['CheckIn'] = $CheckIn;
        $HotelRecords['CheckOut'] = $CheckOut;
        $HotelRecords['NoOfBeds'] = $NoOfBeds;
        $HotelRecords['AmountPayable'] = $AmountPayable;
        $HotelRecords['AmountHotelPayable'] = $AmountHotelPayable;

        $TransportRecords = array();
        $TransportRecords['TransportSectors'] = $TransportSectors;
        $TransportRecords['TransportBRNType'] = $TransportBRNType;
        $TransportRecords['Transport'] = $Transport;
        $TransportRecords['NoOfPax'] = $NoOfPax;
        $TransportRecords['NoOfSeats'] = $NoOfSeats;
        $TransportRecords['TransportsRates'] = $TransportsRates;

        $ZiyaratRecords = array();
        $ZiyaratRecords['ZiyaratCity'] = $ZiyaratCity;
        $ZiyaratRecords['Ziyarat'] = $Ziyarat;
        $ZiyaratRecords['ZiyaratTransportRate'] = $ZiyaratTransportRate;
        $ZiyaratRecords['ZiyaratTransport'] = $ZiyaratTransport;
        $ZiyaratRecords['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $ServicesID = array();
        $ServicesID['ServicesID'] = $VoucherServicesID;
        $ServicesID['VoucherServiceRate'] = $VoucherServiceRate;

        $GroupAddFormSubmit->GroupPilgrimFormSummary($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID);

    }

    public
    function group_bulk_pilgrim_form_submit()
    {
        $GroupAddFormSubmit = new Groups();

        $UID = $this->request->getVar('UID');

        $Agent = $this->request->getVar('AgentID');
        $Status = $this->request->getVar('Status');
        $Country = $this->request->getVar('Country');
        $FullName = $this->request->getVar('GroupName');
        $WTUCode = $this->request->getVar('WTUCode');
        $NoOfPAX = $this->request->getVar('NoOfPAX');
        $TransportType = $this->request->getVar('TransportType');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $Remarks = $this->request->getVar('Remarks');
        $DomainID = $this->request->getVar('DomainID');
        $Visa = $this->request->getVar('Visa');
        $Pilgrim = $this->request->getVar('Pilgrim');
        $PackageUID = $this->request->getVar('PackageUID');

        $RefundAmount = $this->request->getVar('RefundAmount');
        $GrandTotal = $this->request->getVar('GrandTotal');

        /* $City = $this->request->getVar('City');
         $Hotel = $this->request->getVar('Hotels');
         $RoomType = $this->request->getVar('RoomType');
         $CheckIn = $this->request->getVar('CheckIn');
         $CheckOut = $this->request->getVar('CheckOut');
         $NoOfBeds = $this->request->getVar('NoOfBeds');
         $AmountPayable = $this->request->getVar('AmountPayable');*/
        $City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotels');
        $BRNType = $this->request->getVar('BRNType');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AmountPayable = $this->request->getVar('AmountPayable');
        $AmountHotelPayable = $this->request->getVar('AmountHotelPayable');


        $TransportSectors = $this->request->getVar('TransportSectors');
        $Transport = $this->request->getVar('Transport');
        $TransportBRNType = $this->request->getVar('TransportBRNType');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $TransportsRates = $this->request->getVar('TransportsRates');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $ZiyaratTransport = $this->request->getVar('ZiyaratTransport');
        $ZiyaratTransportRate = $this->request->getVar('ZiyaratTransportRate');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');

        $VoucherServicesID = $this->request->getVar('VoucherServicesID');
        $VoucherServiceRate = $this->request->getVar('VoucherServiceRate');


        $records = array();
        $records['AgentID'] = $Agent;
        $records['FullName'] = $FullName;
        if ($UID == 0) {
            $records['Status'] = 'in-complete';
        }

        $records['Country'] = $Country;
        $records['WTUCode'] = $WTUCode;
        $records['NoOfPAX'] = $NoOfPAX;
        $records['TransportType'] = $TransportType;
        $records['ArrivalDate'] = date("Y-m-d", strtotime($ArrivalDate));
        $records['DepartureDate'] = date("Y-m-d", strtotime($DepartureDate));
        $records['Remarks'] = $Remarks;
        $records['WebsiteDomain'] = $DomainID;
        $records['Visa'] = $Visa;
        $records['PackageID'] = $PackageUID;
        $records['Pilgrims'] = $Pilgrim;
        $records['RefundAmount'] = $RefundAmount;
        $records['TotalAmount'] = $GrandTotal;

        /*$HotelRecords = array();
        $HotelRecords['City'] = $City;
        $HotelRecords['Hotel'] = $Hotel;
        $HotelRecords['RoomType'] = $RoomType;
        $HotelRecords['CheckIn'] = $CheckIn;
        $HotelRecords['CheckOut'] = $CheckOut;
        $HotelRecords['NoOfBeds'] = $NoOfBeds;
        $HotelRecords['AmountPayable'] = $AmountPayable;*/
        $HotelRecords = array();
        $HotelRecords['City'] = $City;
        $HotelRecords['Hotel'] = $Hotel;
        $HotelRecords['BRNType'] = $BRNType;
        $HotelRecords['RoomType'] = $RoomType;
        $HotelRecords['CheckIn'] = $CheckIn;
        $HotelRecords['CheckOut'] = $CheckOut;
        $HotelRecords['NoOfBeds'] = $NoOfBeds;
        $HotelRecords['AmountPayable'] = $AmountPayable;
        $HotelRecords['AmountHotelPayable'] = $AmountHotelPayable;

        $TransportRecords = array();
        $TransportRecords['TransportSectors'] = $TransportSectors;
        $TransportRecords['Transport'] = $Transport;
        $TransportRecords['BRNType'] = $TransportBRNType;
        $TransportRecords['NoOfPax'] = $NoOfPax;
        $TransportRecords['NoOfSeats'] = $NoOfSeats;
        $TransportRecords['TransportsRates'] = $TransportsRates;

        $ZiyaratRecords = array();
        $ZiyaratRecords['ZiyaratCity'] = $ZiyaratCity;
        $ZiyaratRecords['Ziyarat'] = $Ziyarat;
        $ZiyaratRecords['ZiyaratTransportRate'] = $ZiyaratTransportRate;
        $ZiyaratRecords['ZiyaratTransport'] = $ZiyaratTransport;
        $ZiyaratRecords['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $ServicesID = array();
        $ServicesID['ServicesID'] = $VoucherServicesID;
        $ServicesID['VoucherServiceRate'] = $VoucherServiceRate;

        $GroupAddFormSubmit->GroupPilgrimFormSubmit($records, $HotelRecords, $TransportRecords, $ZiyaratRecords, $ServicesID, $UID);

    }

    public
    function brn_form_submit()
    {
        $BRNAddFormSubmit = new BrnRecords();
        $session = session();
        $DomainID = $session->get('domainid');


        $UID = $this->request->getVar('UID');

        $PromoCode = $this->request->getVar('PromoCode');
        $Operator = $this->request->getVar('Operator');
        $Country = $this->request->getVar('Country');
        $Agent = $this->request->getVar('Agent');
        $TransportType = $this->request->getVar('TransportType');
        $TransportSectors = $this->request->getVar('TransportSectors');
        $BRNCode = $this->request->getVar('BRNCode');
        $BookingDate = $this->request->getVar('BookingDate');
        $Company = $this->request->getVar('Company');
        $HotelList = $this->request->getVar('HotelList');
        $Seats = $this->request->getVar('Seats');
        $Beds = $this->request->getVar('Beds');
        $Rooms = $this->request->getVar('Rooms');
        $GenerateDate = $this->request->getVar('GenerateDate');
        $ActiveDate = $this->request->getVar('ActiveDate');
//        $ExpireDate = $this->request->getVar('ExpireDate');
        $Type = $this->request->getVar('Type');
        $PurchaseID = $this->request->getVar('PurchaseID');
        $PurchasedBy = $this->request->getVar('PurchasedBy');
        $NoOfVehicles = $this->request->getVar('NoOfVehicles');

        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $CreatedBy = $this->request->getVar('CreatedBy');
        $CreatedDate = $this->request->getVar('CreatedDate');
        $ModifiedBy = $this->request->getVar('ModifiedBy');
        $ModifiedDate = $this->request->getVar('ModifiedDate');
        $UseType = $this->request->getVar('UseType');

//        $ExpiryDate = date('Y-m-d', strtotime($GenerateDate . ' - 1 days'));
        $records = array();
        $records['Operator'] = $Operator;
        $records['BRNCode'] = $BRNCode;
        $records['Agent'] = ((int)$Agent) + 0;
        $records['Country'] = $Country;
        $records['PromoCode'] = $PromoCode;
        $records['Company'] = $Company;
        $records['HotelsID'] = $HotelList;
        $records['Seats'] = $Seats;
        $records['Beds'] = $Beds;
        $records['TransportType'] = $TransportType;
        $records['TransportSectors'] = ( (isset($TransportSectors) && $TransportSectors != '')? $TransportSectors : 0 );
        $records['Rooms'] = $Rooms;
        $records['NoOfVehicles'] = $NoOfVehicles;
        $records['GenerateDate'] = $GenerateDate;
        $records['ActiveDate'] = $ActiveDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['WebsiteDomain'] = $DomainID;
        $records['PurchaseID'] = $PurchaseID;
        $records['PurchasedBy'] = $PurchasedBy;
        $records['BRNType'] = $Type;
        $records['UseType'] = $UseType;
        $records['BookingDate'] = $BookingDate;

        $records['CreatedBy'] = $CreatedBy;
        $records['CreatedDate'] = $CreatedDate;

        $Record['ModifiedBy'] = $ModifiedBy;
        $Record['ModifiedDate'] = $ModifiedDate;


        $BRNAddFormSubmit->BRNFormSubmit($records, $UID, $Record);

    }


    public
    function use_brn_form_submit()
    {
        $BRNAddFormSubmit = new BrnRecords();
        $session = session();
        $DomainID = $session->get('domainid');


        $UID = $this->request->getVar('UID');

        $Type = $this->request->getVar('Type');
        $BRNCode = $this->request->getVar('BRNCode');
        $Rooms = $this->request->getVar('Rooms');
        $Beds = $this->request->getVar('Beds');
        $UseID = $this->request->getVar('UseID');
        $UsedDate = $this->request->getVar('UsedDate');
        $Seats = $this->request->getVar('Seats');
        $ExpireDate = $this->request->getVar('ExpireDate');


        $records['Type'] = $Type;
        $records['BRNCode'] = $BRNCode;
        $records['Rooms'] = $Rooms;
        $records['Beds'] = $Beds;
        $records['UseID'] = $UseID;
        $records['UsedDate'] = $UsedDate;
        $records['Seats'] = $Seats;
        $records['ExpireDate'] = $ExpireDate;


        $BRNAddFormSubmit->UseBRNFormSubmit($records, $UID);

    }

    public
    function visa_details_form_submit()
    {
        $Crud = new Crud();
        $VisaDetailAddFormSubmit = new Pilgrims();

        $PilgrimID = $this->request->getVar('PilgrimID');
        $VisaID = $this->request->getVar('VisaID');
        $IssueDate = $this->request->getVar('IssueDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $Type = $this->request->getVar('Type');
        $MofaNumber = $this->request->getVar('MofaNumber');
        $VisaNumber = $this->request->getVar('VisaNumber');

        $records = array();
        $records['IssueDate'] = $IssueDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['Type'] = $Type;
        $records['MOFANumber'] = $MofaNumber;
        $records['VisaNumber'] = $VisaNumber;

        $fileID = $Crud->UploadFile('VisaAttachment');
        $records['VisaAttachment'] = $fileID;


        $VisaDetailAddFormSubmit->VisaDetailFormSubmit($records, $PilgrimID, $VisaID);

    }

    public
    function multi_visa_details_form_submit()
    {
//        echo "<pre>";
//        print_r($_REQUEST);

        $VisaDetailAddFormSubmit = new Pilgrims();

        $PilgrimID = $this->request->getVar('pilgrimid');
        $VisaNumber = $this->request->getVar('visanumber');
        $Type = $this->request->getVar('visatype');
        $IssueDate = $this->request->getVar('visaissue');
        $ExpiryDate = $this->request->getVar('visaexpiry');
        $MofaNumber = $this->request->getVar('visamofanumber');


        $records = array();
        $records['IssueDate'] = $IssueDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['Type'] = $Type;
        $records['MOFANumber'] = $MofaNumber;
        $records['VisaNumber'] = $VisaNumber;
        $records['PilgrimID'] = $PilgrimID;
        $records['VisaAttachment'] = 0;


        $VisaDetailAddFormSubmit->PilgrimVisaDetailFormSubmit($records);

    }

    public
    function duplicate_package_form_submit()
    {
        $DupliactepackageSubmit = new Packages();

        $PackageID = $this->request->getVar('PackageID');
        $AgentID = $this->request->getVar('AgentID');


        $DupliactepackageSubmit->DuplicateCopyPackage($PackageID, $AgentID);

    }

    public
    function duplicate_external_agent_package_form_submit()
    {
        $DupliactepackageSubmit = new Packages();

        $PackageID = $this->request->getVar('PackageID');
        $AgentID = $this->request->getVar('AgentID');


        $DupliactepackageSubmit->DuplicateCopyPackageForExternalAgent($PackageID, $AgentID);

    }

    public
    function pilgrim_status_form_submit()
    {
        $data = $this->data;
        $PilgrimStatusAddFormSubmit = new Pilgrims();

        //$UID = $this->request->getVar('UID');
        $RequestedStatus = $this->request->getVar('RequestedStatus');
        $VoucherID = $this->request->getVar('VoucherID');
        $VoucherPilgrims = $this->request->getVar('VoucherPilgrims');

        $pilgrimmetas = $this->request->getVar('pilgrim_meta');
        $contact_number = $this->request->getVar('contact_number');

        if ($_POST['AllowReference'] == '') {
            $AllowReference = 0;
        } else {
            $AllowReference = $this->request->getVar('AllowReference');
        }

        $records = array();
        $records['CurrentStatus'] = $RequestedStatus;
        $records['VoucherPilgrims'] = $VoucherPilgrims;
        $records['contact_number'] = $contact_number;

//        print_r($pilgrimmetas);
//        print_r($records);
//        exit;


        $PilgrimStatusAddFormSubmit->PilgrimStatusFormSubmit($records, $pilgrimmetas, $VoucherID, $AllowReference);

    }


    //    public
//    function lookup_form_submit()
//    {
//        $LookupAddFormSubmit = new Main();
//
//        $UID = $this->request->getVar('UID');
//
//        $Key = $this->request->getVar('Key');
//        $Name = $this->request->getVar('Name');
//        $Description = $this->request->getVar('Description');
//
//        $records = array();
//        $records['Key'] = $Key;
//        $records['Name'] = $Name;
//        $records['Description'] = $Description;
//
//        $LookupAddFormSubmit->LookupFormSubmit($records, $UID);
//
//    }

    public
    function language_form_submit()
    {
        $LanguageAddFormSubmit = new Main();

        $UID = $this->request->getVar('UID');

        $Code = $this->request->getVar('Code');
        $Name = $this->request->getVar('Name');

        $records = array();
        $records['Code'] = $Code;
        $records['Name'] = $Name;

        $LanguageAddFormSubmit->LanguageFormSubmit($records, $UID);

    }

    public
    function lookup_options_form_submit()
    {
        $LookupOptionAddFormSubmit = new Main();

        $LookupID = $this->request->getVar('idd');

        $UID = $this->request->getVar('UID');
        $Name = $this->request->getVar('Name');
        $OrderID = $this->request->getVar('OrderID');

        $records = array();
        $records['Name'] = $Name;
        $records['LookupID'] = $LookupID;
        $records['OrderID'] = $OrderID;

        $LookupOptionAddFormSubmit->LookupOptionFormSubmit($records, $UID);

    }


    public
    function remove_user()
    {
        $UID = $this->request->getVar('UID');
        $Sys = new Agents();
        $Sys->DeleteAgents($UID);
    }

    public
    function remove_flight_row()
    {
        $UID = $this->request->getVar('UID');
        $Sys = new Voucher();
        $Sys->DeleteFlightRow($UID);
    }

    public
    function remove_sales_agent()
    {
        $UID = $this->request->getVar('UID');
        $Sys = new SaleAgent();
        $Sys->DeleteSaleAgents($UID);
    }

    public
    function remove_hotel_image()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Packages();
        $pkg->DeleteHotelImage($UID);
    }

    public
    function remove_agent_attachments()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Agents();
        $dlt->DeleteAgentFiles($UID);
    }

    public
    function remove_travel_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Voucher();
        $dlt->DeleteTravelRows($UID);
    }

    public
    function remove_group_transport_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Groups();
        $dlt->DeleteGroupTransportRows($UID);
    }

    public
    function remove_accomodation_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Voucher();
        $dlt->DeleteAccomodationRows($UID);
    }

    public
    function remove_transport_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Voucher();
        $dlt->DeleteTransportRateRows($UID);
    }

    public
    function remove_group_accomodations_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Groups();
        $dlt->DeleteGroupAccomodationsRows($UID);
    }

    public
    function remove_ziyarat_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Voucher();
        $dlt->DeleteZiyaratRows($UID);
    }

    public
    function remove_group_ziyarat_attachments_row()
    {
        $UID = $this->request->getVar('UID');
        $dlt = new Groups();
        $dlt->DeleteGroupZiyaratRows($UID);
    }

    public
    function remove_transport_image()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Packages();
        $pkg->DeleteTransportImage($UID);
    }

    public
    function remove_transport_cover_image()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Packages();
        $pkg->DeleteTransportCoverImage($UID);
    }

    public
    function remove_agent_logo()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Agents();
        $pkg->DeleteAgentLogo($UID);
    }

    public
    function remove_operator_logo()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Users();
        $pkg->DeleteOperatorsLogo($UID);
    }


    public
    function remove_ziyarat_image()
    {
        $UID = $this->request->getVar('UID');
        $pkg = new Packages();
        $pkg->DeleteZiyaratImage($UID);
    }

    public
    function remove_system_user()
    {
        $UID = $this->request->getVar('UID');
        $Sys = new Users();
        $Sys->DeleteUser($UID);
    }

    public
    function get_services_list()
    {
        $ID = $this->request->getVar('ID');
        $Admin = new Voucher();
        $ServicesLists = Voucher::VoucherServicesList($ID);

        echo ' <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Service</th>
                            <th width="60px">Action</th>
                        </tr>
                        </thead>
                        <tbody>';
        $cnt = 0;
        foreach ($ServicesLists as $ServicesList) {
            $cnt++;
            $class = '';
            if ($ServicesList['Refund'] == 1) {
                $class = 'alert alert-danger';
            } else {
                $class = '';
            }
            $refunded = '<button type="button" class="btn btn_customized  btn-sm" id="dropdownMenuReference1">Refunded</button>';
            $actions = ' <button type="button" class="btn btn_customized btn-sm" id="dropdownMenuReference1" onclick="RefundServices(' . $ServicesList['UID'] . ');"> Refund </button>';
            echo '
                                <tr class="' . $class . '">
                                    <td>' . $cnt . '</td>         
                                    <td>' . $ServicesList['ServiceName'] . '</td>  
                                    <td>' . (($ServicesList['Refund'] == 1) ? $refunded : $actions) . '</td>
                                                         
                                </tr>
                                    <tr> 
                               <td colspan="3"> <input type="text" name="ServiceRefundReason" id="ServiceRefundReason-' . $ServicesList['UID'] . '" class="form-control validate[required]" placeholder="Reason For Refund?" value="' . $ServicesList['RefundReason'] . '" ' . ((isset($ServicesList['RefundReason'])) ? 'readonly' : ' ') . '>  </td>
                                </tr>
                                ';
        }
        echo '</tbody>
                    </table>';

    }

    public
    function refund_voucher_service()
    {
        $UID = $this->request->getVar('UID');
        $ServiceRefundReason = $this->request->getVar('ServiceRefundReason');
        $Sys = new Voucher();
        $Sys->RefundVoucherService($UID, $ServiceRefundReason);
    }

    public
    function refund_ziyarat_service()
    {
        $UID = $this->request->getVar('UID');
        $ZiyaratRefundReason = $this->request->getVar('ZiyaratRefundReason');
        $Sys = new Voucher();
        $Sys->RefundVoucherZiyarats($UID, $ZiyaratRefundReason);
    }


    public
    function refund_accomodation_service()
    {
        $UID = $this->request->getVar('UID');
        $HotelRefundReason = $this->request->getVar('HotelRefundReason');
        $Sys = new Voucher();
        $Sys->RefundVoucherAccomodations($UID, $HotelRefundReason);
    }

    public
    function refund_transport()
    {
        $UID = $this->request->getVar('UID');
        $TransportRefundReason = $this->request->getVar('TransportRefundReason');
        $Sys = new Voucher();
        $Sys->RefundVoucherTransport($UID, $TransportRefundReason);
    }

    public
    function get_ziyarats_list()
    {
        $ID = $this->request->getVar('ID');
        $Admin = new Voucher();
        $ZiyaratsLists = Voucher::VoucherZiyaratsList($ID);


        echo '  <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ziyarat</th>
                            <th>Rate</th>
                            <th>Ziyart City</th>
                            <th>Ziyarat No Of Pax</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
        $cnt = 0;
        $class = '';
        foreach ($ZiyaratsLists as $ServicesList) {
            $cnt++;
            $class = '';
            if ($ServicesList['Refund'] == 1) {
                $class = 'alert alert-danger';
            } else {
                $class = '';
            }
            $refunded = '<button type="button" class="btn btn_customized  btn-sm" id="dropdownMenuReference1">Refunded</button>';
            $actions = '
                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1" onclick="RefundZiyarats(' . $ServicesList['UID'] . ')"> Refund   </button>';
            echo '
                                <tr class="' . $class . '">
                                     <td>' . $cnt . '</td>         
                                     <td>' . $ServicesList['ZiyaratName'] . '</td>                                                           
                                     <td>' . Money($ServicesList['Rate']) . '</td>                                                           
                                     <td>' . CityName($ServicesList['ZiyaratCity']) . '</td>
                                     <td>' . $ServicesList['ZiyaratNoOfPax'] . '</td>                                                          
                                     <td>' . (($ServicesList['Refund'] == 1) ? $refunded : $actions) . '</td>
                                </tr>
                                  <tr> 
                               <td colspan="6"> <input type="text" name="ZiyaratRefundReason" id="ZiyaratRefundReason-' . $ServicesList['UID'] . '" class="form-control validate[required]" placeholder="Reason For Refund?" value="' . $ServicesList['RefundReason'] . '"  ' . ((isset($ServicesList['RefundReason'])) ? 'readonly' : ' ') . '>  </td>
                                </tr>
                                ';
        }
        echo '</tbody>
                    </table>';

    }

    public
    function get_transport_list()
    {
        $ID = $this->request->getVar('ID');
        $Admin = new Voucher();
        $ZiyaratsLists = Voucher::VoucherTransportList($ID);


        echo '  <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Transport Sector</th>
                            <th>Rate</th>
                            <th>Travel City</th>
                            <th>No Of Pax</th>
                            <th>No Of Seats</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
        $cnt = 0;
        $class = '';
        foreach ($ZiyaratsLists as $ServicesList) {
            $cnt++;
            $class = '';
            if ($ServicesList['Refund'] == 1) {
                $class = 'alert alert-danger';
            } else {
                $class = '';
            }
            $refunded = '<button type="button" class="btn btn_customized  btn-sm" id="dropdownMenuReference1">Refunded</button>';
            $actions = '
                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1" onclick="RefundTransport(' . $ServicesList['UID'] . ')"> Refund   </button>';
            echo '
                                <tr class="' . $class . '">
                                     <td>' . $cnt . '</td>         
                                     <td>' . OptionName($ServicesList['Sectors']) . '</td>                                                           
                                     <td>' . Money($ServicesList['Rate']) . '</td>                                                           
                                     <td>' . CityName($ServicesList['TravelCity']) . '</td>
                                     <td>' . $ServicesList['NoOfPax'] . '</td>                                                          
                                     <td>' . $ServicesList['NoOfSeats'] . '</td>                                                          
                                     <td>' . (($ServicesList['Refund'] == 1) ? $refunded : $actions) . '</td>
                                </tr>
                               <tr> 
                               <td colspan="7"> <input type="text" name="TransportRefundReason" id="TransportRefundReason-' . $ServicesList['UID'] . '" class="form-control validate[required]" placeholder="Reason For Refund?" value="' . $ServicesList['RefundReason'] . '"  ' . ((isset($ServicesList['RefundReason'])) ? 'readonly' : ' ') . '>  </td>
                                </tr>
                                ';
        }
        echo '</tbody>
                    </table>';

    }

    public
    function get_hotel_list()
    {
        $ID = $this->request->getVar('ID');
        $Admin = new Voucher();
        $ZiyaratsLists = Voucher::VoucherAccommodationList($ID);


        echo '  <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Hotel</th>
                            <th>Rate</th>
                            <th>Hotel City</th>
                            <th>No Of Beds</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>';
        $cnt = 0;
        $class = '';
        foreach ($ZiyaratsLists as $ServicesList) {
            $cnt++;
            $class = '';
            if ($ServicesList['Refund'] == 1) {
                $class = 'alert alert-danger';
            } else {
                $class = '';
            }
            $refunded = '<button type="button" class="btn btn_customized  btn-sm" id="dropdownMenuReference1">Refunded</button>';
            $actions = '
                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1" onclick="RefundHotels(' . $ServicesList['UID'] . ')"> Refund   </button>';
            echo '
                                <tr class="' . $class . '">
                                     <td>' . $cnt . '</td>         
                                     <td>' . $ServicesList['HotelName'] . '</td>                                                           
                                     <td>' . Money($ServicesList['AmountPayable']) . '</td>                                                           
                                     <td>' . CityName($ServicesList['City']) . '</td>
                                     <td>' . $ServicesList['NoOfBeds'] . '</td>                                                          
                                     <td>' . (($ServicesList['Refund'] == 1) ? $refunded : $actions) . '</td>
                                </tr>
                                <tr> 
                               <td colspan="6"> <input type="text" name="HotelRefundReason" id="HotelRefundReason-' . $ServicesList['UID'] . '" class="form-control validate[required]" placeholder="Reason For Refund?" value="' . $ServicesList['RefundReason'] . '"  ' . ((isset($ServicesList['RefundReason'])) ? 'readonly' : ' ') . '>  </td>
                                </tr>
                                ';
        }
        echo '</tbody>
                    </table>';

    }


    public
    function remove_operator()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Users();
        $DltOperator->DeleteOperators($UID);
    }

    public
    function remove_external_agent()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Agents();
        $DltOperator->DeleteExternalAgents($UID);
    }

    public
    function remove_group()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Groups();
        $DltOperator->DeleteGroups($UID);
    }

    public
    function remove_brn()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new BrnRecords();
        $DltOperator->DeleteBRN($UID);
    }

    public
    function remove_use_brn()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new BrnRecords();
        $DltOperator->DeleteUseBRN($UID);
    }

    public
    function remove_transport()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Packages();
        $DltOperator->DeleteTransport($UID);
    }

    public
    function remove_ziyarat()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Packages();
        $DltOperator->DeleteZiyarat($UID);
    }

    public
    function remove_pilgrim()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Pilgrims();
        $DltOperator->DeletePilgrim($UID);
    }

    public
    function remove_hotel()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Packages();
        $DltOperator->DeleteHotels($UID);
    }

    public
    function remove_language()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Main();
        $DltOperator->DeleteLanguage($UID);
    }

    public
    function remove_lookup_option()
    {
        $UID = $this->request->getVar('UID');
        $DltOperator = new Main();
        $DltOperator->DeleteLookupOption($UID);
    }

    public
    function operator_form_submit()
    {
        $OperatorDataSubmit = new Users();
        $Crud = new Crud();
        $UID = $this->request->getVar('UID');

        $CompanyName = $this->request->getVar('CompanyName');
        $DomainID = $this->request->getVar('DomainID');
        $ContactPersonName = $this->request->getVar('ContactPersonName');
        $ContactNo = $this->request->getVar('ContactNo');
        $Email = $this->request->getVar('Email');
        $OfficeCity = $this->request->getVar('OfficeCity');
        $Category = $this->request->getVar('Category');
        $Country = $this->request->getVar('Country');
        $Type = $this->request->getVar('Type');
        $Color = $this->request->getVar('Color');


        $record = array();
        $record['CompanyName'] = $CompanyName;
        $record['WebsiteDomain'] = $DomainID;
        $record['ContactPersonName'] = $ContactPersonName;
        $record['ContactNo'] = $ContactNo;
        $record['Email'] = $Email;
        $record['OfficeCity'] = $OfficeCity;
        $record['Category'] = $Category;
        $record['Country'] = $Country;
        $record['Type'] = $Type;
        $record['Color'] = $Color;


//        print_r($record);exit;

        $fileID = $Crud->UploadFile('Logo');
        $Logo = $fileID;


        $OperatorDataSubmit->OperatorFormSubmit($record, $UID, $Logo);
    }

    public
    function domains_update_form()
    {
        $OperatorDataSubmit = new Users();
        $Crud = new Crud();
        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $MobileDomainID = $this->request->getVar('MobileDomainID');

        $record = array();
        $record['Name'] = $FullName;
        $record['MobileDomainID'] = $MobileDomainID;

        $fileID = $Crud->UploadFile('Logo');
        $Logo = $fileID;


        $OperatorDataSubmit->DomainsUpdateFormSubmit($record, $UID, $Logo);
    }

    public
    function external_agent_form_submit()
    {
        $session = session();
        $session = $session->get();

        $ExternalAgentDataSubmit = new Agents();
        $UID = $this->request->getVar('UID');

        $FullName = $this->request->getVar('FullName');
        $DomainID = $session['domainid'];

        $record = array();
        $record['FullName'] = $FullName;
        $record['DomainID'] = $DomainID;

        $ExternalAgentDataSubmit->ExternalAgentFormSubmit($record, $UID);
    }

    public
    function package_approval_form_submit()
    {

        $PackageDataSubmit = new Packages();
        $UID = $this->request->getVar('UID');
        $CurrentDate = $this->request->getVar('CurrentDate');

        $PackageDataSubmit->PackageApprovalFormSubmit($CurrentDate, $UID);
    }

    public
    function update_system_settings()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $records = $this->request->getVar('setting');
        $DomainID = $this->request->getVar('DomainID');

        $Crud = new Crud();
        $fileID = $Crud->UploadFile('SettingImage');
        $DefaultImage = array();
        $DefaultImage['Image'] = $fileID;


        $MainModel->UpdateSettings($records, $DefaultImage, $DomainID);
    }

    public
    function update_website_settings()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $records = $this->request->getVar('setting');
        $DomainID = $this->request->getVar('DomainID');
        // print_r($records['Images']);

        $MainModel->UpdateWebsiteSettings($records, $DomainID);
    }

    public
    function mofa_temp_file_process()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $RecordID = $this->request->getVar('mofa');
        $Agent = $this->request->getVar('agent_id');
        $mofaids = $this->request->getVar('mofaids');
        $mofaids_array = explode(",", $mofaids);
        //$mofaids = explode(",", $mofaids);

        if (isset($RecordID) && $RecordID != '' && $RecordID > 0) {
            $MainModel->MofaTempReader($Agent, $RecordID);
        }

        if (isset($mofaids) && count($mofaids_array) > 0) {
            foreach ($mofaids_array as $MofaRecordID) {
                $MainModel->MofaTempReader($Agent, $MofaRecordID);
            }
        }

        $CroneModel = new CronModel();
        $CroneModel->UpdateCronActivity('MOFANotIssued');
        $CroneModel->UpdateCronActivity('MOFAIssued');
        $CroneModel->UpdateCronActivity('TotalB2BPilgrim');
        $CroneModel->UpdateCronActivity('TotalB2C');
        $CroneModel->UpdateCronActivity('TotalExternalPilgrim');

        $response['status'] = "success";
        $response['message'] = "MOFA Successfully Assigned...";
        echo json_encode($response);
    }

    public
    function group_status_process()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Status = $this->request->getVar('status_id');
        $groupids = $this->request->getVar('groupids');
        $groupids = explode(",", $groupids);


        if (count($groupids) > 0) {
            foreach ($groupids as $RecordID) {
                $MainModel->Bulk_update_groups($Status, $RecordID);
            }
            //print_r($mofaids); exit;
        }

        $response['status'] = "success";
        $response['message'] = "Group Updated Successfully...";
        echo json_encode($response);
    }

    public
    function pilgrim_transfer()
    {
        $data = $this->data;
        $MainModel = $this->MainModel;

        $Agent = $this->request->getVar('agent_id');
        $pilgrimids = $this->request->getVar('pilgrimids');
        $pilgrimids = explode(",", $pilgrimids);


        if (count($pilgrimids) > 0) {

            foreach ($pilgrimids as $RecordID) {
//                print_r($RecordID);
//                exit;
                $MainModel->PilgrimTransfer($Agent, $RecordID);
            }
        }

        $response['status'] = "success";
        $response['message'] = "Pilgrim Successfully Assigned...";
        echo json_encode($response);
    }


    public
    function transport_form_submit()
    {

        $TransportAddFormSubmit = new Packages();

        $UID = $this->request->getVar('UID');
        $Type = $this->request->getVar('Type');
        $LuggageCapacity = $this->request->getVar('LuggageCapacity');
        $Description = $this->request->getVar('Description');
        $PAXDetail = $this->request->getVar('PAXDetail');
        $DomainID = $this->request->getVar('DomainID');

        $records = array();
        $records['Type'] = $Type;
        $records['LuggageCapacity'] = $LuggageCapacity;
        $records['Description'] = $Description;
        $records['PAXDetail'] = $PAXDetail;
        $records['WebsiteDomain'] = $DomainID;

        $Crud = new Crud();
        $fileIDs = $Crud->UploadFile('MultiImages', false);
        $records['Images'] = $fileIDs;

        $fileID = $Crud->UploadFile('CoverImage');
        $records['CoverImage'] = $fileID;

        $TransportAddFormSubmit->TransportFormSubmit($records, $UID);

    }


    public
    function package_form_submit()
    {
        $data = $this->data;
        // echo "<pre>"; print_r($this->request->getVar()); exit;
        $PackageAgent = $this->request->getVar('PackageAgent');
        $GroupCode = $this->request->getVar('GroupCode');
        $PackageName = $this->request->getVar('PackageName');
        $StartDate = $this->request->getVar('StartDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $PackageCountyCode = $this->request->getVar('PackageCounty');
        $HotelCount = $this->request->getVar('HotelCount');
        $DomainID = $this->request->getVar('DomainID');
        $PackageID = $this->request->getVar('PackageID');


        $CityUIDs = $this->request->getVar('City');
        $HotelUIDs = $this->request->getVar('Hotel');
        $RoomTypes = $this->request->getVar('RoomType');
        $HotelCategory = $this->request->getVar('HotelCategory');


        $ZiyaratCityUIDs = $this->request->getVar('ZiaratCity');
        $ZiyaratUIDs = $this->request->getVar('Ziyarat');
        $ZiyaratRates = $this->request->getVar('ZiyaratRates');

        $TransportRates = $this->request->getVar('TransportRate');
        $ExtraService = $this->request->getVar('Extra');

        $VisaCharges = $this->request->getVar('VisaCharges');


        $PackageDataSubmit = new Packages();

        $records = array();
        $records['AgentUID'] = $PackageAgent;
        $records['Name'] = $PackageName;
        $records['GroupCode'] = $GroupCode;
        $records['StartDate'] = $StartDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['CountryCode'] = $PackageCountyCode;
        $records['WebsiteDomain'] = $DomainID;

        $records['HotelCount'] = $HotelCount;
        $records['City'] = $CityUIDs;
        $records['Hotel'] = $HotelUIDs;
        $records['RoomType'] = $RoomTypes;
        $records['HotelCategory'] = $HotelCategory;

        $records['Ziyarat'] = $ZiyaratUIDs;
        $records['ZiyaratRates'] = $ZiyaratRates;

        $records['TransportRates'] = $TransportRates;
        $records['Extra'] = $ExtraService;

        $PackageDataSubmit->PackageFormSubmit($records, $VisaCharges, $PackageID);
    }

    public
    function external_agent_package_form_submit()
    {
        $data = $this->data;
        // echo "<pre>"; print_r($this->request->getVar()); exit;
        $PackageAgent = $this->request->getVar('PackageAgent');
        $PackageName = $this->request->getVar('PackageName');
        $GroupCode = $this->request->getVar('GroupCode');
        $StartDate = $this->request->getVar('StartDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $PackageCountyCode = $this->request->getVar('PackageCounty');
        $HotelCount = $this->request->getVar('HotelCount');
        $DomainID = $this->request->getVar('DomainID');
        $PackageID = $this->request->getVar('PackageID');

        $CityUIDs = $this->request->getVar('City');
        $HotelUIDs = $this->request->getVar('Hotel');
        $RoomTypes = $this->request->getVar('RoomType');

        $ZiyaratCityUIDs = $this->request->getVar('ZiaratCity');
        $ZiyaratUIDs = $this->request->getVar('Ziyarat');
        $ZiyaratRates = $this->request->getVar('ZiyaratRates');

        $TransportRates = $this->request->getVar('TransportRate');
        $ExtraService = $this->request->getVar('Extra');

        $VisaCharges = $this->request->getVar('VisaCharges');


        $PackageDataSubmit = new Packages();

        $records = array();
        $records['AgentUID'] = $PackageAgent;
        $records['Name'] = $PackageName;
        $records['GroupCode'] = $GroupCode;
        $records['StartDate'] = $StartDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['CountryCode'] = $PackageCountyCode;
        $records['WebsiteDomain'] = $DomainID;

        $records['HotelCount'] = $HotelCount;
        $records['City'] = $CityUIDs;
        $records['Hotel'] = $HotelUIDs;
        $records['RoomType'] = $RoomTypes;

        $records['Ziyarat'] = $ZiyaratUIDs;
        $records['ZiyaratRates'] = $ZiyaratRates;

        $records['TransportRates'] = $TransportRates;
        $records['Extra'] = $ExtraService;

        $PackageDataSubmit->ExternalAgentPackageFormSubmit($records, $VisaCharges, $PackageID);
    }


    public
    function b2b_general_package_form_submit()
    {
        $data = $this->data;
        // echo "<pre>"; print_r($this->request->getVar()); exit;
        $PackageAgent = $this->request->getVar('PackageAgent');
        $PackageName = $this->request->getVar('PackageName');
        $StartDate = $this->request->getVar('StartDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $PackageCountyCode = $this->request->getVar('PackageCounty');
        $HotelCount = $this->request->getVar('HotelCount');
        $PackageID = $this->request->getVar('PackageID');

        $VisaCharges = $this->request->getVar('VisaCharges');

        $CityUIDs = $this->request->getVar('City');
        $HotelUIDs = $this->request->getVar('Hotel');
        $RoomTypes = $this->request->getVar('RoomType');
        $HotelCategory = $this->request->getVar('HotelCategory');

        $ZiyaratCityUIDs = $this->request->getVar('ZiaratCity');
        $ZiyaratUIDs = $this->request->getVar('Ziyarat');
        $ZiyaratRates = $this->request->getVar('ZiyaratRates');

        $TransportRates = $this->request->getVar('TransportRate');
        $ExtraService = $this->request->getVar('Extra');

        $PackageDataSubmit = new Packages();

        $records = array();
        $records['AgentUID'] = $PackageAgent;
        $records['Name'] = $PackageName;
        $records['StartDate'] = $StartDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['CountryCode'] = $PackageCountyCode;

        $records['HotelCount'] = $HotelCount;
        $records['City'] = $CityUIDs;
        $records['Hotel'] = $HotelUIDs;
        $records['RoomType'] = $RoomTypes;
        $records['HotelCategory'] = $HotelCategory;

        $records['Ziyarat'] = $ZiyaratUIDs;
        $records['ZiyaratRates'] = $ZiyaratRates;

        $records['TransportRates'] = $TransportRates;

        $records['Extra'] = $ExtraService;

        $PackageDataSubmit->B2BGeneralPackageFormSubmit($records, $VisaCharges, $PackageID);
    }


    public
    function b2c_package_form_submit()
    {
        $data = $this->data;
        // echo "<pre>"; print_r($this->request->getVar()); exit;
        $PackageAgent = $this->request->getVar('PackageAgent');
        $PackageName = $this->request->getVar('PackageName');
        $StartDate = $this->request->getVar('StartDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $PackageCountyCode = $this->request->getVar('PackageCounty');
        $HotelCount = $this->request->getVar('HotelCount');
        $PackageID = $this->request->getVar('PackageID');

        $VisaCharges = $this->request->getVar('VisaCharges');

        $CityUIDs = $this->request->getVar('City');
        $HotelUIDs = $this->request->getVar('Hotel');
        $RoomTypes = $this->request->getVar('RoomType');
        $HotelCategory = $this->request->getVar('HotelCategory');

        $ZiyaratCityUIDs = $this->request->getVar('ZiaratCity');
        $ZiyaratUIDs = $this->request->getVar('Ziyarat');
        $ZiyaratRates = $this->request->getVar('ZiyaratRates');

        $TransportRates = $this->request->getVar('TransportRate');
        $ExtraService = $this->request->getVar('Extra');

        $PackageDataSubmit = new Packages();

        $records = array();
        $records['AgentUID'] = $PackageAgent;
        $records['Name'] = $PackageName;
        $records['StartDate'] = $StartDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['CountryCode'] = $PackageCountyCode;

        $records['HotelCount'] = $HotelCount;
        $records['City'] = $CityUIDs;
        $records['Hotel'] = $HotelUIDs;
        $records['RoomType'] = $RoomTypes;
        $records['HotelCategory'] = $HotelCategory;

        $records['Ziyarat'] = $ZiyaratUIDs;
        $records['ZiyaratRates'] = $ZiyaratRates;

        $records['TransportRates'] = $TransportRates;

        $records['Extra'] = $ExtraService;

        $PackageDataSubmit->B2CPackageFormSubmit($records, $VisaCharges, $PackageID);
    }

    public
    function GetAgentAccordingToCountry()
    {
        $Country = $this->request->getVar('Country');
        $selected = $this->request->getVar('selected');

        $response['status'] = "success";
        $response['html'] = $this->AgentByCountry($Country, $datatype = 'html', $selected);
        echo json_encode($response);

    }

    function AgentByCountry($Country, $datatype = 'records', $selected = '')
    {

        $Crud = new Crud();

        $SQL = 'SELECT main."Agents".* 
                FROM main."Agents"
                WHERE main."Agents"."CountryID" = \'' . $Country . '\' 
                ORDER BY main."Agents"."FullName" ASC  ';


//        echo $SQL;
//        exit;
        $options = $Crud->ExecuteSQL($SQL);

        $final = array();
        $final['records'] = $options;
        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['FullName'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }

    public
    function voucher_form_submmary()
    {
        $data = $this->data;
        $AgentsModel = new Agents();

        $temp_data = $this->request->getVar('Temp');


        //echo '<pre>';
        //echo $temp_data['AgentID'];
        //print_r($temp_data);
        // print_r($_REQUEST);
        // exit();

        $ID = $this->request->getVar('UID');
        $VoucherType = $this->request->getVar('VoucherType');
        $CreatedBy = $this->request->getVar('CreatedBy');
        $CreatedDate = $this->request->getVar('CreatedDate');
        $ModifiedBy = $this->request->getVar('ModifiedBy');
        $ModifiedDate = $this->request->getVar('ModifiedDate');
        $B2CPackageID = $this->request->getVar('B2CPackageID');
        $UmrahOperator = $this->request->getVar('UmrahOperator');

        $AgentID = $this->request->getVar('AgentID');
        if ($VoucherType == 'B2C') {
            $VoucherCode = '';
        } else {
            $VoucherCode = VoucherCode($AgentID);

        }


        $VoucherArrivalDate = $this->request->getVar('VoucherArrivalDate');
        $VoucherArrivalDate = date('Y-m-d', strtotime($VoucherArrivalDate));

        $ReturnDate = $this->request->getVar('ReturnDate');
        $ReturnDate = date('Y-m-d', strtotime($ReturnDate));


        $ArrivalType = $this->request->getVar('ArrivalType');
        $Remarks = $this->request->getVar('Remarks');
        if (!isset($Remarks)) {
            $Remarks = '';
        }
        $DomainID = $this->request->getVar('DomainID');

        $VoucherCountry = $this->request->getVar('VoucherCountry');


        $TravelSelf = $this->request->getVar('TravelSelf');
        $FlightType = $this->request->getVar('FlightType');
        $SectorFrom = $this->request->getVar('SectorFrom');
        $SectorTo = $this->request->getVar('SectorTo');
        $Reference = $this->request->getVar('Reference');
        $ReferenceRemarks = $this->request->getVar('ReferenceRemarks');
        $PNR = $this->request->getVar('PNR');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $DepartureTime = $this->request->getVar('DepartureTime');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $ArrivalTime = $this->request->getVar('ArrivalTime');
        $Airline = $this->request->getVar('Airline');
        $TravelType = $this->request->getVar('Traveltype');

        $SelfTransport = $this->request->getVar('SelfTransport');
        $TravelCity = $this->request->getVar('TravelCity');
        $TransportTravelType = $this->request->getVar('TransportTravelType');
        $TravelDate = $this->request->getVar('TravelDate');
        $TransportSectors = $this->request->getVar('TransportSectors');
        $TransportType = $this->request->getVar('TransportType');
        $TransportRates = $this->request->getVar('TransportsRates');
        $TransportsBRN = $this->request->getVar('TransportsBRN');
        $AmountPayable = $this->request->getVar('AmountPayable');


        $Self = $this->request->getVar('Self');
        $City = $this->request->getVar('City');
        $Hotels = $this->request->getVar('Hotels');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AccomodationId = $this->request->getVar('AccomodationId');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $AccommodationBRN = $this->request->getVar('AccommodationBRN');

        $AccommodationUID = $this->request->getVar('AccommodationUID');
        $TransportUID = $this->request->getVar('TransportUID');


        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $NoOfPax = $this->request->getVar('NoOfPax');


        $VoucherPilgrimID = $this->request->getVar('VoucherPilgrimID');
        $LeaderID = $this->request->getVar('leader');
//print_r($LeaderID);exit();
        $VoucherServicesID = $this->request->getVar('VoucherServicesID');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $TransportRateZiyrat = $this->request->getVar('TransportRateZiyrat');
        $ZiyaratTransportsRates = $this->request->getVar('ZiyaratTransportsRates');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');
        /////Voucher Log while update


        $VoucherDataSubmit = new Voucher();
        $records = array();
        $Rec = array();
        $records['AgentUID'] = $AgentID;

        $records['VoucherType'] = $VoucherType;
        $records['VoucherCode'] = $VoucherCode;
        $records['Reference'] = $ReferenceRemarks;
        $records['ArrivalDate'] = $VoucherArrivalDate;
        $records['ReturnDate'] = $ReturnDate;
        $records['ArrivalType'] = $ArrivalType;
        $records['UmrahOperator'] = $UmrahOperator;

//        echo  $records['ArrivalDate'];
//        echo  $records['ReturnDate'];
//        exit;
//
        //$records['Remarks'] = $Remarks;
        $records['Country'] = $VoucherCountry;
        $records['WebsiteDomain'] = $DomainID;

        $Rec['CreatedBy'] = $CreatedBy;
        $Rec['CreatedDate'] = $CreatedDate;

        $Record['ModifiedBy'] = $ModifiedBy;
        $Record['ModifiedDate'] = $ModifiedDate;


        //print_r($records);exit;
        $remarks = array();
        $remarks['Remarks'] = $Remarks;

        $Transports = array();
        $Transports['SelfTransport'] = $SelfTransport;
        $Transports['TravelDate'] = $TravelDate;
        $Transports['TravelCity'] = $TravelCity;
        $Transports['TravelType'] = $TransportTravelType;
        $Transports['TransportSectors'] = $TransportSectors;
        $Transports['TransportType'] = $TransportType;
        $Transports['TransportsBRN'] = $TransportsBRN;
        $Transports['NoOfPax'] = $NoOfPax;
        $Transports['NoOfSeats'] = $NoOfSeats;
        $Transports['TransportRates'] = $TransportRates;
        $Transports['TransportUID'] = $TransportUID;
        //echo '<pre>';print_r($Transports);exit();

        $Ziyarats = array();
        $Ziyarats['ZiyaratCity'] = $ZiyaratCity;
        $Ziyarats['Ziyarat'] = $Ziyarat;
        $Ziyarats['TransportRateZiyrat'] = $TransportRateZiyrat;
        $Ziyarats['ZiyaratTransportsRates'] = $ZiyaratTransportsRates;
        $Ziyarats['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $FlightsData = array();

        $FlightsData['TravelSelf'] = $TravelSelf;
        $FlightsData['FlightType'] = $FlightType;
        $FlightsData['SectorTo'] = $SectorTo;
        $FlightsData['SectorFrom'] = $SectorFrom;
        $FlightsData['Reference'] = $Reference;
        $FlightsData['Airline'] = $Airline;
        $FlightsData['PNR'] = $PNR;
        $FlightsData['DepartureDate'] = $DepartureDate;
        $FlightsData['DepartureTime'] = $DepartureTime;
        $FlightsData['ArrivalDate'] = $ArrivalDate;
        $FlightsData['ArrivalTime'] = $ArrivalTime;
        $FlightsData['TravelType'] = $TravelType;
//echo '<pre>';print_r($FlightsData);exit();

        $AccommodationsData = array();
        $AccommodationsData['Self'] = $Self;
        $AccommodationsData['City'] = $City;
        $AccommodationsData['Hotels'] = $Hotels;
        $AccommodationsData['RoomType'] = $RoomType;
        $AccommodationsData['AccomodationId'] = $AccomodationId;
        $AccommodationsData['CheckIn'] = $CheckIn;
        $AccommodationsData['CheckOut'] = $CheckOut;
        $AccommodationsData['NoOfBeds'] = $NoOfBeds;
        $AccommodationsData['AccommodationBRN'] = $AccommodationBRN;
        $AccommodationsData['AmountPayable'] = $AmountPayable;
        $AccommodationsData['AccommodationUID'] = $AccommodationUID;

        if ($ID > 0) {
            //echo '<pre>';print_r($AccommodationsData);
            $TempAccommodation_data = $this->request->getVar('TempAccommodation');
            $TempAccommodation_data = ((isset($TempAccommodation_data) && count($TempAccommodation_data) > 0) ? $TempAccommodation_data : array());
            //echo '<pre>';print_r($TempAccommodation_data);exit();

            $ActualAccommodationCount = $this->request->getVar('ActualAccommodationCount');
            $Accommodation_array_diff = array_diff($AccommodationsData, $TempAccommodation_data);
//echo '<pre>';print_r($Accommodation_array_diff);exit();


            $newarray = array_keys($AccommodationsData);


            if (!empty($AccommodationsData)) {

                $accommodation_record_array = array();
                for ($i = 0; $i < sizeof($newarray); $i++) {
                    $currentiterationvalue = $newarray[$i];

                    $AccommodationCity = $AccommodationsData['City'];
                    if (!empty($AccommodationCity[0])) {

                        for ($a = 0; $a < count($AccommodationCity); $a++) {
                            if ($AccommodationsData[$currentiterationvalue][$a] != $TempAccommodation_data[$currentiterationvalue][$a]) {
                                $TEMPaccommodation_record_array = array();
                                $TEMPaccommodation_record_array[] = CityName($AccommodationsData['City'][$a]);
                                $TEMPaccommodation_record_array[] = HotelName($AccommodationsData['Hotels'][$a], 'Name', $AccommodationsData['Self'][$a]);
                                $TEMPaccommodation_record_array[] = OptionName($AccommodationsData['RoomType'][$a]);
                                $TEMPaccommodation_record_array[] = $AccommodationsData['CheckIn'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['CheckOut'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['NoOfBeds'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['AccommodationBRN'][$a];

                                $accommodation_record_array[] = json_encode($TEMPaccommodation_record_array);

                            }

                        }

                    }

                }

            }
            $accommodation_record_array = array_unique($accommodation_record_array);
            $html_accommodation_data = '';
            if (!empty($accommodation_record_array)) {
                foreach ($accommodation_record_array as $new_ccommodation_record_array) {
                    $DATA_new_ccommodationarray = json_decode($new_ccommodation_record_array);
                    $html_accommodation_data .= '
                                <tr><td>' . $DATA_new_ccommodationarray[0] . '</td><td>' . $DATA_new_ccommodationarray[1] . '</td><td>' . $DATA_new_ccommodationarray[2] . '</td><td>' . $DATA_new_ccommodationarray[3] . '</td><td>' . $DATA_new_ccommodationarray[4] . '</td><td>' . $DATA_new_ccommodationarray[5] . '</td><td>' . $DATA_new_ccommodationarray[6] . '</td></tr>';
                }

            }
//echo $html_accommodation_data;exit();
            /////Accommodation

            //array_push($Voucher_Activity_arr, $Country_data);


            /////Transport Update

            $TempTransport_data = $this->request->getVar('TempTransport');


            $ActualTransportCount = $this->request->getVar('ActualTransportCount');


            $newtransportarray = array_keys($Transports);


            if (!empty($Transports)) {

                $transport_record_array = array();

                for ($i = 0; $i < sizeof($newtransportarray); $i++) {
                    $currentiterationvalue = $newtransportarray[$i];


                    //echo "Actual-----".$Transports[$currentiterationvalue][$i] .'-----Temp----'. $TempTransport_data[$currentiterationvalue][$i].'<br>';
                    $Transport_TransportSectors = $Transports['TransportSectors'];
                    if (!empty($Transports[$currentiterationvalue])) {
                        for ($t = 0; $t < count($Transports[$currentiterationvalue]); $t++) {
                            if ($Transports[$currentiterationvalue][$t] != $TempTransport_data[$currentiterationvalue][$t]) {
                                $Packages = new Packages();
                                $Crud = new Crud();
                                $Transport_data = $Packages->TransportsData($Transports['TransportType'][$t]);
                                $TransportType = $Crud->LookupOptionsData($Transport_data['Type']);

                                $TEMPtransport_record_array = array();
                                $TEMPtransport_record_array[] = CityName($Transports['TravelCity'][$t]);
                                $TEMPtransport_record_array[] = $Transports['TravelDate'][$t];
                                $TEMPtransport_record_array[] = OptionName($Transports['TransportSectors'][$t]);
                                $TEMPtransport_record_array[] = $Transports['TravelType'][$t];
                                $TEMPtransport_record_array[] = $TransportType['Name'];
                                $TEMPtransport_record_array[] = $Transports['TransportsBRN'][$t];
                                $TEMPtransport_record_array[] = $Transports['NoOfPax'][$t];
                                $TEMPtransport_record_array[] = $Transports['NoOfSeats'][$t];

                                $transport_record_array[] = json_encode($TEMPtransport_record_array);
                            }
                        }
                    }
                }
            }


        }

        $PilgrimsID = array();
        $PilgrimsID['VoucherPilgrimID'] = $VoucherPilgrimID;
        $PilgrimsID['VoucherPilgrimLeaderID'] = $LeaderID;


        $ServicesID = array();
        $ServicesID['VoucherServicesID'] = $VoucherServicesID;

//        print_r($records);


        $VoucherDataSubmit->VoucherFormSummary($records, $Rec, $ID, $PilgrimsID, $FlightsData, $AccommodationsData, $Transports, $Ziyarats, $ServicesID, $remarks, $Record);
    }

    public
    function voucher_form_submit()
    {
        //echo'<pre>';print_r($_REQUEST);exit;

        $data = $this->data;
        $AgentsModel = new Agents();
        $Crud = new Crud();
        $VoucherDataSubmit = new Voucher();

        $temp_data = $this->request->getVar('Temp');

        $ID = $this->request->getVar('UID');
        $VoucherType = $this->request->getVar('VoucherType');
        $CreatedBy = $this->request->getVar('CreatedBy');
        $CreatedDate = $this->request->getVar('CreatedDate');
        $ModifiedBy = $this->request->getVar('ModifiedBy');
        $ModifiedDate = $this->request->getVar('ModifiedDate');
        $B2CPackageID = $this->request->getVar('B2CPackageID');
        $UmrahOperator = $this->request->getVar('UmrahOperator');

        $AgentPackageID = $this->request->getVar('PackageUID');
        $VoucherVisa = $this->request->getVar('Visa');

        $SubmittedAgentID = $this->request->getVar('VoucherAgentID');
        $AgentID = $this->request->getVar('AgentID');
        if ($VoucherType == 'B2C') {
            $VoucherCode = '';
        } else {
            $VoucherCode = VoucherCode($AgentID);

        }


        $VoucherArrivalDate = $this->request->getVar('VoucherArrivalDate');
        $VoucherArrivalDate = date('Y-m-d', strtotime($VoucherArrivalDate));

        $ReturnDate = $this->request->getVar('ReturnDate');
        $ReturnDate = date('Y-m-d', strtotime($ReturnDate));


        $ArrivalType = $this->request->getVar('ArrivalType');
        $Remarks = $this->request->getVar('Remarks');
        if (!isset($Remarks)) {
            $Remarks = '';
        }
        $DomainID = $this->request->getVar('DomainID');

        $VoucherCountry = $this->request->getVar('VoucherCountry');


        $TravelSelf = $this->request->getVar('TravelSelf');
        $FlightType = $this->request->getVar('FlightType');
        $SectorFrom = $this->request->getVar('SectorFrom');
        $SectorTo = $this->request->getVar('SectorTo');
        $Reference = $this->request->getVar('Reference');
        $ReferenceRemarks = $this->request->getVar('ReferenceRemarks');
        $PNR = $this->request->getVar('PNR');
        $DepartureDate = $this->request->getVar('DepartureDate');
        $DepartureTime = $this->request->getVar('DepartureTime');
        $ArrivalDate = $this->request->getVar('ArrivalDate');
        $ArrivalTime = $this->request->getVar('ArrivalTime');
        $Airline = $this->request->getVar('Airline');
        $TravelType = $this->request->getVar('Traveltype');

        $SelfTransport = $this->request->getVar('SelfTransport');
        $TravelCity = $this->request->getVar('TravelCity');
        $TransportTravelType = $this->request->getVar('TransportTravelType');
        $TravelDate = $this->request->getVar('TravelDate');
        $TransportSectors = $this->request->getVar('TransportSectors');
        $TransportType = $this->request->getVar('TransportType');
        $TransportRates = $this->request->getVar('TransportsRates');
        $TransportsBRN = $this->request->getVar('TransportsBRN');
        $AmountPayable = $this->request->getVar('AmountPayable');


        $Self = $this->request->getVar('Self');
        $City = $this->request->getVar('City');
        $Hotels = $this->request->getVar('Hotels');
        $NoOfBeds = $this->request->getVar('NoOfBeds');
        $AccomodationId = $this->request->getVar('AccomodationId');
        $RoomType = $this->request->getVar('RoomType');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $AccommodationBRN = $this->request->getVar('AccommodationBRN');

        $AccommodationUID = $this->request->getVar('AccommodationUID');
        $TransportUID = $this->request->getVar('TransportUID');


        $NoOfSeats = $this->request->getVar('NoOfSeats');
        $NoOfPax = $this->request->getVar('NoOfPax');


        $VoucherPilgrimID = $this->request->getVar('VoucherPilgrimID');
        $LeaderID = $this->request->getVar('leader');
        $VoucherServicesID = $this->request->getVar('VoucherServicesID');

        $ZiyaratCity = $this->request->getVar('ZiyaratCity');
        $Ziyarat = $this->request->getVar('Ziyarat');
        $TransportRateZiyrat = $this->request->getVar('TransportRateZiyrat');
        $ZiyaratTransportsRates = $this->request->getVar('ZiyaratTransportsRates');
        $ZiyaratNoOfPax = $this->request->getVar('ZiyaratNoOfPax');
        /////Voucher Log while update
        $Voucher_Activity_arr = array();

        if ($ID > 0) {
            /////////// AGENT Changed
            if ($AgentID != $temp_data['AgentID']) {
                $AgentProfile = $AgentsModel->AgentsProfile($AgentID);

                $TempAgentProfile = $AgentsModel->AgentsProfile($temp_data['AgentID']);

                $TEXT = "Agent Updated From <strong>" . $TempAgentProfile['FullName'] . "</strong> To <strong>" . $AgentProfile['FullName'] . "</strong>";
                $Agent_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                //array_push($Voucher_Activity_arr, $Agent_data);
                $Voucher_Activity_arr[] = $Agent_data;

            }
            if ($VoucherCountry != $temp_data['VoucherCountry']) {
                $CurrentVoucherCountryProfile = CountryName($VoucherCountry);

                $TempVoucherCountry = CountryName($temp_data['VoucherCountry']);

                $TEXT = "Country Updated From <strong>" . $TempVoucherCountry . "</strong> To <strong>" . $CurrentVoucherCountryProfile . "</strong>";
                $Country_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                //array_push($Voucher_Activity_arr, $Country_data);
                $Voucher_Activity_arr[] = $Country_data;
            }
            if ($ArrivalType != $temp_data['ArrivalType']) {
                $TEXT = "Arrival Type Updated From <strong>" . $temp_data['ArrivalType'] . "</strong> To <strong>" . $ArrivalType . "</strong>";
                $Arrival_Type_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                //array_push($Voucher_Activity_arr, $Country_data);
                $Voucher_Activity_arr[] = $Arrival_Type_data;
            }
            if ($VoucherArrivalDate != $temp_data['VoucherArrivalDate']) {
                $TEXT = "Arrival Date Updated From <strong>" . $temp_data['VoucherArrivalDate'] . "</strong> To <strong>" . $VoucherArrivalDate . "</strong>";
                $VoucherArrivalDate_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                //array_push($Voucher_Activity_arr, $Country_data);
                $Voucher_Activity_arr[] = $VoucherArrivalDate_data;
            }
            if ($ReturnDate != $temp_data['ReturnDate']) {
                $TEXT = "Return Date Updated From <strong>" . $temp_data['ReturnDate'] . "</strong> To <strong>" . $ReturnDate . "</strong>";
                $ReturnDate_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                //array_push($Voucher_Activity_arr, $Country_data);
                $Voucher_Activity_arr[] = $ReturnDate_data;
            }

            //echo '<pre>';print_r($Voucher_Activity_arr);exit();


        }

        $VoucherVisaRate = $PackageUID = 0;
        if (isset($VoucherVisa) && $VoucherVisa == 'Yes') {
            $Record['AgentPackageID'] = $AgentPackageID;
            if ($ID == 0) {
                $PackageUID = $AgentPackageID;
                $Record['SubmittedPackageID'] = $AgentPackageID;
            } else {
                if ($SubmittedAgentID == $AgentID) {
                    $PackageUID = $AgentPackageID;
                    $Record['SubmittedPackageID'] = $AgentPackageID;
                } else {
                    $PackageData = $Crud->SingleRecord('packages."Packages"', array('AgentUID' => $AgentID));
                    $PackageUID = ((isset($PackageData['UID']) && $PackageData['UID'] != '') ? $PackageData['UID'] : 0);
                    $Record['SubmittedPackageID'] = $PackageUID;
                }
            }
            $VoucherVisaRate = $VoucherDataSubmit->GetVoucherVisaRate($PackageUID, $VoucherPilgrimID, $ID);
        }

        $records = array();
        $Rec = array();
        $records['AgentUID'] = $AgentID;
        $records['VoucherType'] = $VoucherType;
        $records['VoucherCode'] = $VoucherCode;
        $records['Reference'] = $ReferenceRemarks;
        $records['ArrivalDate'] = $VoucherArrivalDate;
        $records['ReturnDate'] = $ReturnDate;
        $records['ArrivalType'] = $ArrivalType;
        $records['UmrahOperator'] = $UmrahOperator;
        $records['Country'] = $VoucherCountry;
        $records['WebsiteDomain'] = $DomainID;
        $records['Visa'] = $VoucherVisa;
        $records['VisaRate'] = $VoucherVisaRate;

        $Rec['CreatedBy'] = $CreatedBy;
        $Rec['CreatedDate'] = $CreatedDate;

        $Record['ModifiedBy'] = $ModifiedBy;
        $Record['ModifiedDate'] = $ModifiedDate;

        //print_r($records);exit;
        $remarks = array();
        $remarks['Remarks'] = $Remarks;

        $Transports = array();
        $Transports['SelfTransport'] = $SelfTransport;
        $Transports['TravelDate'] = $TravelDate;
        $Transports['TravelCity'] = $TravelCity;
        $Transports['TravelType'] = $TransportTravelType;
        $Transports['TransportSectors'] = $TransportSectors;
        $Transports['TransportType'] = $TransportType;
        $Transports['TransportsBRN'] = $TransportsBRN;
        $Transports['NoOfPax'] = $NoOfPax;
        $Transports['NoOfSeats'] = $NoOfSeats;
        $Transports['TransportRates'] = $TransportRates;
        $Transports['TransportUID'] = $TransportUID;
        //echo '<pre>';print_r($Transports);exit();

        $Ziyarats = array();
        $Ziyarats['ZiyaratCity'] = $ZiyaratCity;
        $Ziyarats['Ziyarat'] = $Ziyarat;
        $Ziyarats['TransportRateZiyrat'] = $TransportRateZiyrat;
        $Ziyarats['ZiyaratTransportsRates'] = $ZiyaratTransportsRates;
        $Ziyarats['ZiyaratNoOfPax'] = $ZiyaratNoOfPax;


        $FlightsData = array();

        $FlightsData['TravelSelf'] = $TravelSelf;
        $FlightsData['FlightType'] = $FlightType;
        $FlightsData['SectorTo'] = $SectorTo;
        $FlightsData['SectorFrom'] = $SectorFrom;
        $FlightsData['Reference'] = $Reference;
        $FlightsData['Airline'] = $Airline;
        $FlightsData['PNR'] = $PNR;
        $FlightsData['DepartureDate'] = $DepartureDate;
        $FlightsData['DepartureTime'] = $DepartureTime;
        $FlightsData['ArrivalDate'] = $ArrivalDate;
        $FlightsData['ArrivalTime'] = $ArrivalTime;
        $FlightsData['TravelType'] = $TravelType;

        $AccommodationsData = array();
        $AccommodationsData['Self'] = $Self;
        $AccommodationsData['City'] = $City;
        $AccommodationsData['Hotels'] = $Hotels;
        $AccommodationsData['RoomType'] = $RoomType;
        $AccommodationsData['AccomodationId'] = $AccomodationId;
        $AccommodationsData['CheckIn'] = $CheckIn;
        $AccommodationsData['CheckOut'] = $CheckOut;
        $AccommodationsData['NoOfBeds'] = $NoOfBeds;
        $AccommodationsData['AccommodationBRN'] = $AccommodationBRN;
        $AccommodationsData['AmountPayable'] = $AmountPayable;
        $AccommodationsData['AccommodationUID'] = $AccommodationUID;

        if ($ID > 0) {
            //echo '<pre>';print_r($AccommodationsData);
            $TempAccommodation_data = $this->request->getVar('TempAccommodation');
            $TempAccommodation_data = ((isset($TempAccommodation_data) && count($TempAccommodation_data) > 0) ? $TempAccommodation_data : array());
            //echo '<pre>';print_r($TempAccommodation_data);exit();

            $ActualAccommodationCount = $this->request->getVar('ActualAccommodationCount');
            $Accommodation_array_diff = array_diff($AccommodationsData, $TempAccommodation_data);
//echo '<pre>';print_r($Accommodation_array_diff);exit();

            if (isset($AccommodationsData['Hotels']) && count($AccommodationsData['Hotels']) > $ActualAccommodationCount) {
                // adddddd
                $TEXT = 'New Hotel Added';
                $Accommodation_added_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Accommodation_added_data;
            } else if (isset($AccommodationsData['Hotels']) && count($AccommodationsData['Hotels']) < $ActualAccommodationCount) {
                ////Remove
                $TEXT = 'Hotel Deleted';
                $Accommodation_deleted_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Accommodation_deleted_data;
            }


            $newarray = array_keys($AccommodationsData);


            if (!empty($AccommodationsData)) {

                $accommodation_record_array = array();
                for ($i = 0; $i < sizeof($newarray); $i++) {
                    $currentiterationvalue = $newarray[$i];

                    $AccommodationCity = $AccommodationsData['City'];
                    if (!empty($AccommodationCity[0])) {

                        for ($a = 0; $a < count($AccommodationCity); $a++) {
                            if ($AccommodationsData[$currentiterationvalue][$a] != $TempAccommodation_data[$currentiterationvalue][$a]) {
                                $TEMPaccommodation_record_array = array();
                                $TEMPaccommodation_record_array[] = CityName($AccommodationsData['City'][$a]);
                                $TEMPaccommodation_record_array[] = HotelName($AccommodationsData['Hotels'][$a], 'Name', $AccommodationsData['Self'][$a]);
                                $TEMPaccommodation_record_array[] = OptionName($AccommodationsData['RoomType'][$a]);
                                $TEMPaccommodation_record_array[] = $AccommodationsData['CheckIn'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['CheckOut'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['NoOfBeds'][$a];
                                $TEMPaccommodation_record_array[] = $AccommodationsData['AccommodationBRN'][$a];

                                $accommodation_record_array[] = json_encode($TEMPaccommodation_record_array);

                            }

                        }

                    }

                }

            }
            $accommodation_record_array = array_unique($accommodation_record_array);
            $html_accommodation_data = '';
            if (!empty($accommodation_record_array)) {
                foreach ($accommodation_record_array as $new_ccommodation_record_array) {
                    $DATA_new_ccommodationarray = json_decode($new_ccommodation_record_array);
                    $html_accommodation_data .= '
                                <tr><td>' . $DATA_new_ccommodationarray[0] . '</td><td>' . $DATA_new_ccommodationarray[1] . '</td><td>' . $DATA_new_ccommodationarray[2] . '</td><td>' . $DATA_new_ccommodationarray[3] . '</td><td>' . $DATA_new_ccommodationarray[4] . '</td><td>' . $DATA_new_ccommodationarray[5] . '</td><td>' . $DATA_new_ccommodationarray[6] . '</td></tr>';
                }

            }
//echo $html_accommodation_data;exit();
            /////Accommodation
            if (!empty($html_accommodation_data)) {

                $html_accommodation = '<strong>Accommodation</strong><table class="table table-bordered activity"><thead>
                                    <tr><th>City</th><th>Hotel</th><th>Room Type</th><th>Check-In</th><th>Check-Out</th><th>No Of Beds</th><th>BRN</th></tr>
                                    </thead><tbody>';
                $html_accommodation .= $html_accommodation_data;

                $html_accommodation .= '</tbody>
                                </table>';

                $TEXT = $html_accommodation;
                //exit();
                $Accommodatiomn_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Accommodatiomn_data;
            }
            //array_push($Voucher_Activity_arr, $Country_data);


            /////Transport Update

            $TempTransport_data = $this->request->getVar('TempTransport');


            $ActualTransportCount = $this->request->getVar('ActualTransportCount');


            if (isset($Transports['TransportSectors']) && count($Transports['TransportSectors']) > $ActualTransportCount) {
                // adddddd
                $TEXT = 'New Transport Added';
                $Transport_added_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Transport_added_data;
            } else if (isset($Transports['TransportSectors']) && count($Transports['TransportSectors']) < $ActualTransportCount) {
                ////Remove
                $TEXT = 'Transport Deleted';
                $Transport_deleted_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Transport_deleted_data;
            }

            $newtransportarray = array_keys($Transports);


            if (!empty($Transports)) {

                $transport_record_array = array();

                for ($i = 0; $i < sizeof($newtransportarray); $i++) {
                    $currentiterationvalue = $newtransportarray[$i];


                    //echo "Actual-----".$Transports[$currentiterationvalue][$i] .'-----Temp----'. $TempTransport_data[$currentiterationvalue][$i].'<br>';
                    $Transport_TransportSectors = $Transports['TransportSectors'];
                    if (!empty($Transports[$currentiterationvalue])) {
                        for ($t = 0; $t < count($Transports[$currentiterationvalue]); $t++) {
                            if ($Transports[$currentiterationvalue][$t] != $TempTransport_data[$currentiterationvalue][$t]) {
                                $Packages = new Packages();
                                $Crud = new Crud();
                                $Transport_data = $Packages->TransportsData($Transports['TransportType'][$t]);
                                $TransportType = $Crud->LookupOptionsData($Transport_data['Type']);

                                $TEMPtransport_record_array = array();
                                $TEMPtransport_record_array[] = CityName($Transports['TravelCity'][$t]);
                                $TEMPtransport_record_array[] = $Transports['TravelDate'][$t];
                                $TEMPtransport_record_array[] = OptionName($Transports['TransportSectors'][$t]);
                                $TEMPtransport_record_array[] = $Transports['TravelType'][$t];
                                $TEMPtransport_record_array[] = $TransportType['Name'];
                                $TEMPtransport_record_array[] = $Transports['TransportsBRN'][$t];
                                $TEMPtransport_record_array[] = $Transports['NoOfPax'][$t];
                                $TEMPtransport_record_array[] = $Transports['NoOfSeats'][$t];

                                $transport_record_array[] = json_encode($TEMPtransport_record_array);
                            }
                        }
                    }
                }
            }

            $transport_record_array = array_unique($transport_record_array);

            $html_transport_data = '';
            if (!empty($transport_record_array)) {
                foreach ($transport_record_array as $new_transportarray) {
                    $DATA_new_transportarray = json_decode($new_transportarray);
                    $html_transport_data .= '
                                <tr>
                                    <td>' . $DATA_new_transportarray[0] . '</td>
                                    <td>' . $DATA_new_transportarray[1] . '</td>
                                    <td>' . $DATA_new_transportarray[2] . '</td>
                                    <td>' . $DATA_new_transportarray[3] . '</td>
                                    <td>' . $DATA_new_transportarray[4] . '</td>
                                    <td>' . $DATA_new_transportarray[5] . '</td>
                                    <td>' . $DATA_new_transportarray[6] . '</td>
                                    <td>' . $DATA_new_transportarray[7] . '</td>
                                    </tr>';
                }
            }


            if (!empty($html_transport_data)) {

                $html_transport = '<strong>Transport</strong>
                                    <table class="table table-bordered activity">
                                    <thead>
                                        <tr>
                                            <th>City</th>
                                            <th>Travel Date</th>
                                            <th>Sectors</th>
                                            <th>Travel Type</th>
                                            <th>Transports</th>
                                            <th>BRN</th>
                                            <th>No Of Pax</th>
                                            <th>No Of Seats</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>';
                $html_transport .= $html_transport_data;

                $html_transport .= '</tbody>
                                </table>';

                $TEXT_Transport = $html_transport;
                //exit();
                $Transport_data = array(
                    'VoucherID' => $ID,
                    'Remarks' => $TEXT_Transport,
                    'CreatedBy' => session()->get('id'),
                    'CreatedDate' => date('Y-m-d H:i:s'),
                );
                $Voucher_Activity_arr[] = $Transport_data;
            }

        }

        $PilgrimsID = array();
        $PilgrimsID['VoucherPilgrimID'] = $VoucherPilgrimID;
        $PilgrimsID['VoucherPilgrimLeaderID'] = $LeaderID;


        $ServicesID = array();
        $ServicesID['VoucherServicesID'] = $VoucherServicesID;

        $VoucherDataSubmit->VoucherFormSubmit($records, $Rec, $ID, $PilgrimsID, $FlightsData, $AccommodationsData, $Transports, $Ziyarats, $ServicesID, $remarks, $Voucher_Activity_arr, $Record);
    }

    function package_form_update()
    {
        $data = $this->data;
        //echo "<pre>"; print_r($this->request->getVar());
        $PackageAgent = $this->request->getVar('PackageAgent');
        $PackageID = $this->request->getVar('PackageID');
        $GroupCode = $this->request->getVar('GroupCode');
        $PackageName = $this->request->getVar('PackageName');
        $StartDate = $this->request->getVar('StartDate');
        $ExpiryDate = $this->request->getVar('ExpiryDate');
        $PackageCountyCode = $this->request->getVar('PackageCounty');
        $HotelCount = $this->request->getVar('HotelCount');

        $CityUIDs = $this->request->getVar('City');
        $HotelUIDs = $this->request->getVar('Hotel');
        $RoomTypes = $this->request->getVar('RoomType');
        $HotelCategory = $this->request->getVar('HotelCategory');

        $ZiyaratCityUIDs = $this->request->getVar('ZiaratCity');
        $ZiyaratUIDs = $this->request->getVar('Ziyarat');
        $ZiyaratRates = $this->request->getVar('ZiyaratRates');

        $TransportRates = $this->request->getVar('TransportRate');
        $ExtraService = $this->request->getVar('Extra');


        $VisaCharges = $this->request->getVar('VisaCharges');

        // Add Package Record

        $PackageDataSubmit = new Packages();

        $records = array();
        $records['AgentUID'] = $PackageAgent;
        $records['Name'] = $PackageName;
        $records['GroupCode'] = $GroupCode;
        $records['StartDate'] = $StartDate;
        $records['ExpireDate'] = $ExpiryDate;
        $records['CountryCode'] = $PackageCountyCode;

        $records['HotelCount'] = $HotelCount;
        $records['City'] = $CityUIDs;
        $records['Hotel'] = $HotelUIDs;
        $records['RoomType'] = $RoomTypes;
        $records['HotelCategory'] = $HotelCategory;

        $records['Ziyarat'] = $ZiyaratUIDs;
        $records['ZiyaratRates'] = $ZiyaratRates;

        $records['TransportRates'] = $TransportRates;

        $records['Extra'] = $ExtraService;

        // echo "<pre>" . print_r($records); exit;
        $PackageDataSubmit->PackageFormSubmit($records, $VisaCharges, $PackageID);
    }

    public
    function ziyarat_form_submit()
    {
        $data = $this->data;
        //echo "<pre>"; print_r($_POST); exit;
        $records = array();

        $Crud = new Crud();
        $UID = $this->request->getVar('UID');

        $Name = $this->request->getVar('Name');
        $Country = $this->request->getVar('Country');
        $City = $this->request->getVar('City');
        $Description = $this->request->getVar('Description');
        $NearPlaces = $this->request->getVar('NearPlaces');
        $DomainID = $this->request->getVar('DomainID');


        $SEOTitle = $this->request->getVar('SEOTitle');
        $SEOKeywords = $this->request->getVar('SEOKeywords');
        $SEODescription = $this->request->getVar('SEODescription');
        $Latitude = $this->request->getVar('Latitude');
        $Longitude = $this->request->getVar('Longitude');
        $GoogleMAP = $this->request->getVar('GoogleMAP');

        $ZiyaratDataSubmit = new Packages();

        $records['Name'] = $Name;
        $records['CountryID'] = $Country;
        $records['CityID'] = $City;
        $records['Description'] = $Description;
        $records['NearPlaces'] = $NearPlaces;
        $records['WebsiteDomain'] = $DomainID;

        $fileID = $Crud->UploadFile('CoverImage');
        $records['Image'] = $fileID;

        $fileIDs = $Crud->UploadFile('MultipleImages', false);
        $records['MultipleImages'] = $fileIDs;

        //print_r($records['MultipleImages']);

        $MetaRecord = array();
        $MetaRecord['SEOTitle'] = $SEOTitle;
        $MetaRecord['SEOKeywords'] = $SEOKeywords;
        $MetaRecord['SEODescription'] = $SEODescription;
        $MetaRecord['Latitude'] = $Latitude;
        $MetaRecord['Longitude'] = $Longitude;
        $MetaRecord['GoogleMAP'] = $GoogleMAP;

        //print_r($_REQUEST); print_r($records); print_r($MetaRecord);exit;

        $ZiyaratDataSubmit->ZiayartFormSubmit($records, $UID, $MetaRecord);
    }


    public
    function pilgrim_form_submit()
    {
        $data = $this->data;
//        echo "<pre>"; print_r($_POST); exit;

        $Crud = new Crud();
        $UID = $this->request->getVar('UID');
        $PassportFileID = $this->request->getVar('passport_file');

//        if ($data['session']['domainid'] == 0 && in_array($_SERVER['HTTP_HOST'], $data['parent_mis'])) {
//            $WebsiteID = 0;
//        } else {
//            $WebsiteID = $data['session']['domainid'];
//        }

        $Title = $this->request->getVar('Title');
        $FirstName = $this->request->getVar('FirstName');
        $LastName = $this->request->getVar('LastName');
        $Relation = $this->request->getVar('Relation');
        $DOB = $this->request->getVar('DOB');
        $Countries = $this->request->getVar('Countries');
        $City = $this->request->getVar('City');
        $Group = $this->request->getVar('Group');
        $Agent = $this->request->getVar('Agent');
        $DomainID = $this->request->getVar('DomainID');
        $Gender = $this->request->getVar('Gender');


        $Email = $this->request->getVar('Email');
        $Password = $this->request->getVar('Password');


        $PassportType = $this->request->getVar('PassportType');
        $PassportNumber = $this->request->getVar('PassportNumber');
        $Nationality = $this->request->getVar('Nationality');
        $BookletNumber = $this->request->getVar('BookletNumber');
        $DateOfIssue = $this->request->getVar('DateOfIssue');
        $DateOfExpiry = $this->request->getVar('DateOfExpiry');
        $TrackingNumber = $this->request->getVar('TrackingNumber');
        $CitizenshipNumber = $this->request->getVar('CitizenshipNumber');


        $PassportFrontPicID = $Crud->UploadFile('PassportFront');
        $PassportBackPicID = $Crud->UploadFile('PassportBack');
        $PassportBookletPicID = $Crud->UploadFile('PassportBooklet');


        $PilgrimDataSubmit = new Pilgrims();

        $passportdata = array();

        $passportdata['PassportType'] = $PassportType;
        $passportdata['PassportNumber'] = $PassportNumber;
        $passportdata['Nationality'] = $Nationality;
        $passportdata['DateOfIssue'] = $DateOfIssue;
        $passportdata['DateOfExpiry'] = $DateOfExpiry;
        $passportdata['TrackingNumber'] = $TrackingNumber;
        $passportdata['CitizenshipNumber'] = $CitizenshipNumber;
        $passportdata['BookletNumber'] = $BookletNumber;
        $passportdata['File'] = $PassportFileID;

        $passportdata['PassportFrontPicID'] = $PassportFrontPicID;
        $passportdata['PassportBackPicID'] = $PassportBackPicID;
        $passportdata['PassportBookletPicID'] = $PassportBookletPicID;


        $records = array();
        $records['Title'] = $Title;
        $records['FirstName'] = $FirstName;
        $records['LastName'] = $LastName;
        $records['Relation'] = $Relation;
        $records['DOB'] = $DOB;
        $records['Country'] = $Countries;
        $records['CityID'] = $City;
        $records['AgentUID'] = $Agent;
        $records['GroupUID'] = $Group;
        $records['PassportNumber'] = $PassportNumber;
        $records['WebsiteDomain'] = $DomainID;
        $records['Gender'] = $Gender;


        $IPAddress = $_SERVER['REMOTE_ADDR'];
        $AccountRecords = array();
        $AccountRecords['DomainID'] = '1';
        $AccountRecords['Email'] = $Email;
        $AccountRecords['Password'] = $Password;
        $AccountRecords['LastLoginIPAddress'] = $IPAddress;

        $fileID = $Crud->UploadFile('UploadFile');
        $images['Image'] = $fileID;

        if (isset($images['Image'])) {
            $records['Profile'] = $images['Image'];
        }

        $AttachmentsData = array();

        $fileIDs = $Crud->UploadFile('AttachFiles', false);
        $AttachmentsData['AttachFiles'] = $fileIDs;
        $FileDescription = $this->request->getVar('FileDescription');
        $AttachmentsData['FileDescription'] = $FileDescription;


        $PilgrimDataSubmit->PilgrimFormSubmit($records, $UID, $passportdata, $AttachmentsData, $AccountRecords);
    }

    public
    function passport_scan_fom_submit()
    {
//        $data = $this->data;
//        echo "<pre>"; print_r($_FILES); exit;

        $Crud = new Crud();
        $fileID = $Crud->UploadFile('UploadPassport');

        $PassportDataSubmit = new Pilgrims();
        $JSON = $PassportDataSubmit->PassportFormSubmit($fileID);

//        $Api = new Api();
//        $JSON = $Api->PassportScan($file);

        $response['status'] = "success";
        $response['passport_file'] = $fileID;
        $response['message'] = "Uploaded ";
        $response['passport'] = $JSON;
        echo json_encode($response);
    }


    public
    function update_accesslevels()
    {
        $accesslevels = $this->request->getVar('check');
        $userid = $this->request->getVar('UserID');
        $UserType = $this->request->getVar('UserType');

        // echo'<pre>';print_r($accesslevels);exit;

        $Users = new Users();
        $Users->UpdateAccessLevel($userid, $accesslevels, $UserType);

        $response['status'] = "success";
        $response['message'] = "Access Level Successfully Changed...";

        echo json_encode($response);
    }

    public
    function shift_login_session()
    {
        $LoginSubmit = new User();
        $ID = $this->request->getVar('UID');
        $type = $this->request->getVar('type');

        $LoginSubmit->ShiftLoginSession($ID, $type);
    }

    public
    function update_filters()
    {
        $data = $this->data;
        $SessionName = $this->request->getVar('session_name');
        $session = session();
        $newdata = [
            $SessionName => $_POST
        ];
        $session->set($newdata);
        $responce = array();
        $responce['status'] = 'success';
        $responce['msg'] = "Filter Updated";
        echo json_encode($responce);
    }

    public
    function clear_filters()
    {
        $data = $this->data;
        $SessionName = $this->request->getVar('session_name');
        $session = session();
        $session->remove($SessionName);
        $responce = array();
        $responce['status'] = 'success';
        $responce['msg'] = "Filter Updated";
        echo json_encode($responce);


    }

    public
    function agent_pilgrim_add_process()
    {
        $PilgrimAssignAgent = new Pilgrims();

        $PilgrimID = $this->request->getVar('pilgrimID');
        $Agent = $this->request->getVar('agent_id');
        $records['AgentUID'] = $Agent;

        $PilgrimAssignAgent->PilgrimAgentAssign($records, $PilgrimID);


    }

    public
    function pilgrim_status_change_process()
    {
        $PilgrimAssignAgent = new Pilgrims();

        $Status = $this->request->getVar('status');
        $RowID = $this->request->getVar('row_id');


        $PilgrimAssignAgent->PilgrimChangeStatus($Status, $RowID);


    }

    public
    function voucher_status_form_submit()
    {
        $VoucherDataSubmit = new Voucher();

        $RecordID = $this->request->getVar('UID');
        $VoucherStatus = $this->request->getVar('VoucherStatus');
        $Remarks = $this->request->getVar('Remarks');
        $RefundTypes = $this->request->getVar('RefundTypes');
        $Voucher_Activity_arr = array();
        $TEXT = "Voucher " . $VoucherStatus;
        $Status_data = array(
            'VoucherID' => $RecordID,
            'Remarks' => $TEXT,
            'CreatedBy' => session()->get('id'),
            'CreatedDate' => date('Y-m-d H:i:s'),
        );
        //array_push($Voucher_Activity_arr, $Country_data);
        $Voucher_Activity_arr[] = $Status_data;
        $TEXT = $Remarks;
        $Remarks_data = array(
            'VoucherID' => $RecordID,
            'Remarks' => $TEXT,
            'CreatedBy' => session()->get('id'),
            'CreatedDate' => date('Y-m-d H:i:s'),
        );
        //array_push($Voucher_Activity_arr, $Country_data);
        $Voucher_Activity_arr[] = $Remarks_data;

        $RefundType['RefundTypes'] = $RefundTypes;


        $VoucherDataSubmit->VoucherStatusFormSubmit($RecordID, $VoucherStatus, $Voucher_Activity_arr, $RefundType);
        $responce = array();
        $responce['status'] = 'success';
        $responce['message'] = "Status Updated";
        echo json_encode($responce);


    }

    public
    function voucher_refund_form_submit()
    {
        $VoucherDataSubmit = new Voucher();

        $RecordID = $this->request->getVar('UID');
        $VoucherStatus = $this->request->getVar('VoucherStatus');
        $Remarks = $this->request->getVar('Remarks');
        $RefundTypes = $this->request->getVar('RefundTypes');
        $Voucher_Activity_arr = array();
        $TEXT = "Voucher " . $VoucherStatus;
        $Status_data = array(
            'VoucherID' => $RecordID,
            'Remarks' => $TEXT,
            'CreatedBy' => session()->get('id'),
            'CreatedDate' => date('Y-m-d H:i:s'),
        );
        //array_push($Voucher_Activity_arr, $Country_data);
        $Voucher_Activity_arr[] = $Status_data;
        $TEXT = $Remarks;
        $Remarks_data = array(
            'VoucherID' => $RecordID,
            'Remarks' => $TEXT,
            'CreatedBy' => session()->get('id'),
            'CreatedDate' => date('Y-m-d H:i:s'),
        );
        //array_push($Voucher_Activity_arr, $Country_data);
        $Voucher_Activity_arr[] = $Remarks_data;

        $RefundType['RefundTypes'] = $RefundTypes;


        $VoucherDataSubmit->VoucherStatusFormSubmit($RecordID, $VoucherStatus, $Voucher_Activity_arr, $RefundType);
        $responce = array();
        $responce['status'] = 'success';
        $responce['message'] = "Status Updated";
        echo json_encode($responce);


    }

    public
    function voucher_remarks_form_submit()
    {
        $VoucherDataSubmit = new Voucher();

        $UID = $this->request->getVar('UID');
        $Remarks = $this->request->getVar('Remarks');


        $VoucherDataSubmit->VoucherRemarksFormSubmit($UID, $Remarks);


    }

    public
    function refund_voucher_remarks_form_submit()
    {
        $VoucherDataSubmit = new Voucher();
        $Crud = new Crud();
        $UID = $this->request->getVar('UID');
        $RefundType = $this->request->getVar('Type');
        $Quantity = $this->request->getVar('Quantity');
        $Remarks = $this->request->getVar('Remarks');

        $records = array();
        $records['ActivityID'] = $UID;
        $records['Type'] = $RefundType;
        $records['Quantity'] = $Quantity;
        $records['Remarks'] = $Remarks;

        if ($records['Type'] == 'accommodation ') {
            $Voucher = $Crud->SingleRecord('voucher."AccommodationDetails"', array("UID" => $records['ActivityID']));
            $VoucherID = $Voucher['VoucherID'];
        } else {
            $Voucher = $Crud->SingleRecord('voucher."TransportRate"', array("UID" => $records['ActivityID']));
            $VoucherID = $Voucher['VoucherUID'];
        }

        $records['VoucherUID'] = $VoucherID;
        $VoucherDataSubmit->RefundVoucherRemarksFormSubmit($records);


    }

    public
    function remove_accomodations_attachments_all_row()
    {
        $table = 'voucher."AccommodationDetails"';
        $VoucherID = $this->request->getVar('VoucherID');
        $City = $this->request->getVar('City');
        $Hotel = $this->request->getVar('Hotel');
        $CheckIn = $this->request->getVar('CheckIn');
        $CheckOut = $this->request->getVar('CheckOut');
        $AccommodationBRN = $this->request->getVar('AccommodationBRN');
        $dlt = new Voucher();
        $dlt->DeleteAccomodationsRows($table, ["VoucherID" => $VoucherID, "City" => $City, "Hotel" => $Hotel, "CheckIn" => $CheckIn, "CheckOut" => $CheckOut, "AccommodationBRN" => $AccommodationBRN]);
    }

    public
    function remove_accomodations_attachments_row()
    {
        $table = 'voucher."AccommodationDetails"';
        $UID = $this->request->getVar('UID');
        $dlt = new Voucher();
        $dlt->DeleteAccomodationsRows($table, ["UID" => $UID]);
    }

    public
    function check_mofa_file_heads()
    {

        $MainArray = array();
        $File = $_FILES['UploadFiles']['tmp_name'];
        $MofaFileOperator = $this->request->getVar('MofaFileOperator');

        $Validation = $this->validate(array(
            'UploadFiles' => 'uploaded[UploadFiles]|ext_in[UploadFiles,xls,xlsx]'
        ));
        if (!$Validation) {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = $this->validator->getError('UploadFiles');
            echo json_encode($result);

        } else {

            $upload_file = $_FILES['UploadFiles']['name'];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($File);
            $HighestColumnString = $spreadsheet->setActiveSheetIndex(0)->getHighestColumn();
            $TotalColumns = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($HighestColumnString);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, true, false);
            if (!empty($sheetData)) {

                if (isset($TotalColumns) && $TotalColumns != '') {

                    if ($MofaFileOperator == 'way-to-umrah') {

                        $TopColumnsData = array(
                            'Umrah Operator' => 'Operator',
                            'Agent' => 'ExtAgent',
                            'Group Name' => 'Group',
                            'Print Date' => 'PrintDate'
                        );

                        $HeadStartCounter = ((trim(str_replace(':', '', $sheetData[2][0])) == 'Umrah Operator') ? 2 : ((trim(str_replace(':', '', $sheetData[1][0])) == 'Umrah Operator') ? 1 : 0));
                        $StartCounter = ((trim($sheetData[6][0]) == 'Pilgrim Name') ? 6 : ((trim($sheetData[7][0]) == 'Pilgrim Name') ? 7 : ((trim($sheetData[8][0]) == 'Pilgrim Name') ? 8 : 6)));
                        for ($a = $HeadStartCounter; $a <= ($StartCounter - 1); $a++) {
                            foreach ($TopColumnsData as $Key => $Value) {
                                if (trim(str_replace(':', '', $sheetData[$a][0])) == $Key) {
                                    $Index = str_replace(' ', '', $a . "-0");
                                    $MainArray[$Index] = trim(str_replace(':', '', $sheetData[$a][0]));
                                }
                            }
                        }
                        for ($b = 0; $b < $TotalColumns; $b++) {
                            $Index = $StartCounter . "-" . $b;
                            $MainArray[$Index] = $sheetData[$StartCounter][$b];
                        }

                    } else {

                        for ($b = 0; $b < $TotalColumns; $b++) {
                            $Index = "0-" . $b;
                            $MainArray[$Index] = $sheetData[0][$b];
                        }
                    }

                    $result = array();
                    $result['status'] = 'success';
                    $result['message'] = 'File Read Successfully';
                    $result['data'] = $MainArray;
                    $result['total_col'] = ($TotalColumns - 1);
                    echo json_encode($result);


                } else {

                    $result = array();
                    $result['status'] = 'fail';
                    $result['message'] = 'File Reader Issue, Please Try Again';
                    echo json_encode($result);

                }

            }
        }
    }


    public
    function departure_elm_form_submit()
    {
        $session = session();
        $data = $this->data;
        $FinalArray = array();
        $CroneModel = new CronModel();
        $CheckCount = 0;
        $File = $_FILES['UploadFiles']['tmp_name'];
        $file = $this->request->getFile('UploadFiles');
        $Flag = $this->request->getVar('Flag');
        $TotalRecord = $TotalValidRecord = $TotalInValidRecord = 0;

        $Validation = $this->validate(array(
            'UploadFiles' => 'uploaded[UploadFiles]|ext_in[UploadFiles,xls,xlsx]'
        ));

        if (!$Validation) {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = $this->validator->getError('UploadFiles');
            echo json_encode($result);

        } else {

            $upload_file = $_FILES['UploadFiles']['name'];
            $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($File);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, false, true, false);
            if (!empty($sheetData)) {

                $FileName = $file->getRandomName();
                $file->move(ROOTPATH . '/writable/uploads/', $FileName);

                $InvalidElmArray[] = array('EACode', 'EA _Name', 'groupcode',
                    'GroupDesc', 'Pilgrim ID', 'Name', 'BirthDate',
                    'Passport No.', 'MOI Number', 'MOFA Number', 'Visa No.', 'Entry Date', 'Entry Time',
                    'Entry Port', 'Transport Mode', 'Entry Carrier Name', 'Flight No',
                    'Exit Date', 'Exit Time', 'Exit Port', 'Exit Transport Mode', 'Exit Carrier Name',
                    'Exit Flight No', 'Package', 'Actual Staying Duration');

                for ($a = 1; $a <= count($sheetData); $a++) {

                    if ($sheetData[$a][1] != '') {

                        $TotalRecord++;
                        $EntryDate = explode(" ", trim($sheetData[$a][12]));
                        $ExitDate = explode(" ", trim($sheetData[$a][17]));
                        $EntryString = $sheetData[$a][12];

                        $TEMP = array();
                        $TEMP['EACode'] = $sheetData[$a][1];
                        $TEMP['EAName'] = $sheetData[$a][2];
                        $TEMP['GroupCode'] = $sheetData[$a][3];
                        $TEMP['GroupDesc'] = $sheetData[$a][4];
                        $TEMP['PilgrimID'] = $sheetData[$a][5];
                        $TEMP['Name'] = $sheetData[$a][6];
                        $TEMP['BirthDate'] = date("Y-m-d", strtotime($sheetData[$a][7]));
                        $TEMP['PassportNo'] = trim($sheetData[$a][8]);
                        $TEMP['MOINumber'] = trim($sheetData[$a][9]);
                        $TEMP['MOFANumber'] = trim($sheetData[$a][10]);
                        $TEMP['VisaNo'] = trim($sheetData[$a][11]);
                        $TEMP['EntryDate'] = date("Y-m-d", strtotime($EntryDate[0]));
                        $TEMP['EntryTime'] = date("H:i:s", strtotime(end($EntryDate)));
                        $TEMP['EntryPort'] = $sheetData[$a][13];
                        $TEMP['TransportMode'] = $sheetData[$a][14];
                        $TEMP['EntryCarrier'] = $sheetData[$a][15];
                        $TEMP['FlightNo'] = $sheetData[$a][16];
                        $TEMP['ExitDate'] = date("Y-m-d", strtotime($ExitDate[0]));
                        $TEMP['ExitTime'] = date("H:i:s", strtotime(end($ExitDate)));
                        $TEMP['ExitPort'] = $sheetData[$a][18];
                        $TEMP['ExitTransportMode'] = $sheetData[$a][19];
                        $TEMP['ExitCareer'] = $sheetData[$a][20];
                        $TEMP['ExitFlightNo'] = $sheetData[$a][21];
                        $TEMP['Package'] = $sheetData[$a][22];
                        $TEMP['ActualStayingDuration'] = $sheetData[$a][23];

                        /** Jawad Code Start */
                        $Crud = new Crud();
                        $table = 'pilgrim."travel"';
                        $where = array(
                            "MOINumber" => '' . $TEMP['MOINumber'] . ''
                        );
                        $TravelRecord = $Crud->SingleRecord($table, $where, false);
                        if (!isset($TravelRecord['UID'])) {

                            $MofaTable = 'pilgrim."mofa"';
                            $InnerWhere = array(
                                'MOINumber' => '' . $TEMP['MOINumber'] . ''
                            );
                            $MofaRecord = $Crud->SingleRecord($MofaTable, $InnerWhere, false);
                            if (isset($MofaRecord['MOFAPilgrimID'])) {

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
                                $travel['ExitDate'] = $TEMP['ExitDate'];
                                $travel['ExitTime'] = $TEMP['ExitTime'];
                                $travel['ExitPort'] = $TEMP['ExitPort'];
                                $travel['ExitTransportMode'] = $TEMP['ExitTransportMode'];
                                $travel['ExitCareer'] = $TEMP['ExitCareer'];
                                $travel['ExitFlightNo'] = $TEMP['ExitFlightNo'];
                                $travel['ActualStayingDuration'] = $TEMP['ActualStayingDuration'];
                                $travel['Flag'] = ((isset($Flag) && $Flag != '') ? $Flag : 'Arrival');
                                $Crud->AddRecord('pilgrim."travel"', $travel, false);

                                $TotalValidRecord++;

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

                                $InvalidElmArray[] = $TEMP;
                                $TotalInValidRecord++;
                            }

                        } else {
                            /** Duplicate Entry*/

                            $InvalidElmArray[] = $TEMP;
                            $TotalInValidRecord++;
                        }
                        /** Jawad Code Ends */

                    }

                }

                $result = array();
                if (count($InvalidElmArray) > 0) {
                    $result['elm_array'] = $InvalidElmArray;
                    $ResponseMessage = 'Total <b>\'' . $TotalRecord . '\'</b> Record Found, Valid Record = <b>\'' . $TotalValidRecord . '\'</b>, Duplicate Record = <b>\'' . $TotalInValidRecord . '\'</b> &raquo; 
                    <a style="color:red; text-decoration: underline;" target="_blank" href="' . $data['path'] . 'form_process/create_invalid_elm_file_uploader_csv">Click To View <b>( \'' . $TotalInValidRecord . '\' )</b> Records.</a>';
                } else {
                    $result['elm_array'] = $InvalidElmArray;
                    $ResponseMessage = 'Total <b>\'' . $TotalRecord . '\'</b> Record Found, Valid Record = <b>\'' . $TotalValidRecord . '\'</b>, Duplicate Record = <b>\'' . $TotalInValidRecord . '\'</b>';
                }
                $result['status'] = 'success';
                $result['message'] = $ResponseMessage;
                $session->set('InvalidElmData', $result);

                echo json_encode($result);

            } else {

                $result = array();
                $result['status'] = "fail";
                $result['message'] = "Record Not Found, File Empty";
                echo json_encode($result);

            }
        }
    }


}
