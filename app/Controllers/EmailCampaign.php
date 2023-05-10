<?php namespace App\Controllers;

use App\Models\Crud;
use App\Models\EmailCampaignModel;
use App\Models\Main;

class EmailCampaign extends BaseController
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


        echo view('header', $data);
        echo view('sales/email_campaign/email_listing', $data);
        echo view('footer', $data);
    }

    public function add_email()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $EmailCampaigns = new EmailCampaignModel();
        $data['EmailLists'] = $EmailCampaigns->GetEmailLists($DomainID);
        echo view('header', $data);
        echo view('sales/email_campaign/add_email', $data);
        echo view('footer', $data);
    }

    public function update_email()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $EmailCampaigns = new EmailCampaignModel();
        $GetURLEmail = getSegment(3);
        $email = base64_decode($GetURLEmail);

        $data['EmailLists'] = $EmailCampaigns->GetEmailLists($DomainID);
        $data['UpdateEmailLists'] = $EmailCampaigns->UpdateEmailLists($email);

        $itemsName = array();
        foreach ($data['UpdateEmailLists'] as $key => $value) {
            $itemsName['Email'] = $value['Email'];
            $itemsName['FullName'] = $value['FullName'];
            $itemsName['EmailListIDs'][] = $value['EmailsListID'];
        }
        $data['FinalArray'] = $itemsName;

        echo view('header', $data);
        echo view('sales/email_campaign/update_email', $data);
        echo view('footer', $data);
    }

    public function import_email_ids()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $EmailCampaigns = new EmailCampaignModel();
        $data['EmailLists'] = $EmailCampaigns->GetEmailLists($DomainID);
        echo view('header', $data);
        echo view('sales/email_campaign/import_email_ids', $data);
        echo view('footer', $data);
    }

    public function save_import_email_ids()
    {

        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];
        $EmailCampaigns = new EmailCampaignModel();
        $Group = $this->request->getVar('group');
        $File = $_FILES['csvfile']['tmp_name'];

        // echo'<pre>';print_r($Group);exit;

        $file = $this->request->getFile('csvfile');
        $FileName = $file->getRandomName();
        $file->move(ROOTPATH . 'uploads/manual-importer/', $FileName);
        $file = fopen(ROOTPATH . "uploads/manual-importer/" . $FileName, "r");


        if (isset($Group)) {

            $i = 0;
            $numberOfFields = 2;
            while (($UploadedFileData = fgetcsv($file, 1000, ",")) !== FALSE) {

                $MainArray = array();
                $num = count($UploadedFileData);
                if ($i > 0 && $num == $numberOfFields) {

                    foreach ($Group as $GroupID => $Value) {

                        $CheckRecord = $Crud->SingleRecord('marketing."EmailIDs"', array("EmailsListID" => $GroupID, "Email" => trim($UploadedFileData[1]), "DomainID" => $DomainID));
                        if (isset($CheckRecord['UID'])) {
                            /** Duplicate case*/
                        } else {
                            $MainArray['EmailsListID'] = $GroupID;
                            $MainArray['FullName'] = $UploadedFileData[0];
                            $MainArray['Email'] = $UploadedFileData[1];
                            $MainArray['Status'] = 'active';
                            $MainArray['DomainID'] = $DomainID;

                            $EmailCampaigns::ListEmailAndName($MainArray);
                        }
                    }
                }
                $i++;
            }
            fclose($file);

            /*success message*/
            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'File Successfully Imported';
            echo json_encode($result);

        } else {
            /* error group (list is empty)*/
            $result = array();
            $result['status'] = 'successAlert';
            $result['message'] = 'Select List Please';
            echo json_encode($result);


        }

    }

    public function view_all_email_ids()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $EmailCampaigns = new EmailCampaignModel();

        $data['AllEmailLists'] = $EmailCampaigns->ViewAllEmailList($DomainID);

        echo view('header', $data);
        echo view('sales/email_campaign/view_all_email_ids', $data);
        echo view('footer', $data);
    }

    public function run_email_campaign()
    {
        $data = $this->data;

        $DomainID = $data['session']['domainid'];

        $EmailCampaigns = new EmailCampaignModel();
        $data['EmailLists'] = $EmailCampaigns->GetEmailLists($DomainID);
        $data['Email_Camaigns'] = $EmailCampaigns->GetEmailCampaign($DomainID);

        echo view('header', $data);
        echo view('sales/email_campaign/run_email_campaign', $data);
        echo view('footer', $data);
    }

    public function save_email_campaign_log()
    {
        $data = $this->data;
        $EmailCampaigns = new EmailCampaignModel();
        $DomainID = $data['session']['domainid'];
        $records = array();

        $Title = $this->request->getVar('title');
        $UpdateUID = $this->request->getVar('UID');
        $SenderFirstName = $this->request->getVar('senderfirstname');
        $SenderLastName = $this->request->getVar('senderlastname');
        $SenderEmail = $this->request->getVar('senderemail');
        $EmailDesign = $this->request->getVar('emaildesign');
        $Execute_email_Date = $this->request->getVar('execute_email');
        $EmailSubject = $this->request->getVar('email_subject');
        $EmailBody = $this->request->getVar('email_body');

        $records['Title'] = $Title;
        $records['SenderFirstName'] = $SenderFirstName;
        $records['SenderLastName'] = $SenderLastName;
        $records['SenderEmail'] = $SenderEmail;
        $records['EmailSubject'] = $EmailSubject;
        $records['EmailTemplate'] = $EmailDesign;
        $records['EmailBody'] = $EmailBody;
        $records['ExecDate'] = $Execute_email_Date;
        $records['Status'] = 'scheduled';
        if ($UpdateUID == 0) {
            $records['DomainID'] = $DomainID;
        }
//        echo "<pre>";
//        print_r($records);
//        exit;


        $EmailCampaigns->AddEmailCampaigns($records, $UpdateUID);

//        echo "<pre>"; print_r($records);

    }

    public function delete_campaign_record()
    {
        $data = $this->data;
        $EmailCampaigns = new EmailCampaignModel();
        $UID = $this->request->getVar('UID');
        $EmailCampaigns->DeleteEmailCamapignRecord($UID);

    }

    public function view_all_campaign_logs()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/email_campaign/view_all_campaign_logs', $data);
        echo view('footer', $data);
    }

    public function view_all_email_campaign()
    {
        $data = $this->data;

        $EmailCampaigns = new EmailCampaignModel();
        $DomainID = $data['session']['domainid'];
        $data['all_campaigns_list'] = $EmailCampaigns->EmailCamaignsList($DomainID);

        echo view('header', $data);
        echo view('sales/email_campaign/view_all_email_campaign', $data);
        echo view('footer', $data);
    }

    public function save_email_list_record()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $UID = $this->request->getVar('UID');
        $listname = $this->request->getVar('listname');
        $createdate = $this->request->getVar('createDate');
        $records = array();
        $records['FullName'] = $listname;


        if ($UID == 0) {
            $records['CreatedAt'] = $createdate;
            $records['DomainID'] = $DomainID;
        }

//        print_r($records);
//        exit;

        $EmailCampaigns = new EmailCampaignModel();
        $EmailCampaigns->saveEmailList($records, $UID);
    }

    public function updateEmailListArchive()
    {
        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $UID = $this->request->getVar('UID');
        $EmailCampaigns = new EmailCampaignModel();
        $EmailCampaigns->DeleteEmailLists($UID, $DomainID);

    }

    public function save_email_data()
    {
        $data = $this->data;
        $EmailCampaigns = new EmailCampaignModel();
        $Crud = new Crud();
        $table = 'marketing."EmailIDs"';


        $DomainID = $data['session']['domainid'];

        $Name = $this->request->getVar('Name');
        $Email = $this->request->getVar('Email');

//        // test
//         $col_name = "Email";
//
//        $dataaa = Form_Field_Check($table,$col_name,$Email);
//
//
//        if($dataaa != ''){
//            echo " found";
//        }else{
//            echo "Not found";
//        }
//
//        exit;


        $Group = $this->request->getVar('group');
        $OldEmail = $this->request->getVar('Old_Email');


        if ($OldEmail == $Email) { // for hidden field in (update Email case)


//            $SQL = 'SELECT * FROM "marketing"."EmailIDs" Where  "Email" = \'' . $Email . '\' ';
//            $validate = $Crud->ExecuteSQL($SQL);
//            if (isset($validate) && $validate['UID'] > 0) {
//                $response['status'] = 'successAlert';
//                $response['message'] = 'Email Already Exist...';
//                echo json_encode($response);
//            } else {
            $Crud->DeleteRecord($table, array("Email" => $OldEmail));  // delete for update case
            foreach ($Group as $key => $value) {
                $record = array();
                $record['FullName'] = $Name;
                $record['Email'] = $Email;
                $record['EmailsListID'] = $key;
                $record['DomainID'] = $DomainID;
                $counterId = $EmailCampaigns->saveEmailwithGroups($record);
            }
            if (isset($counterId)) {
                $response['status'] = 'success';
                $response['message'] = 'Email Updated Successfully...';
                echo json_encode($response);
            }
        } else {
            $SQL = 'SELECT * FROM "marketing"."EmailIDs" Where  "Email" = \'' . $Email . '\' ';
            $validate = $Crud->ExecuteSQL($SQL);

            if ($validate[0]['UID'] > 0) {

                $response['status'] = 'successAlert';
                $response['message'] = 'Email Already Exist...';
                echo json_encode($response);
            } else {
                $Crud->DeleteRecord($table, array("Email" => $Email));
                $Crud->DeleteRecord($table, array("Email" => $OldEmail));
                foreach ($Group as $key => $value) {
                    $SQL = 'SELECT * FROM "marketing"."EmailIDs" Where "EmailsListID" = \'' . $key . '\' AND "Email" = \'' . $Email . '\' ';
                    $validate = $Crud->ExecuteSQL($SQL);

                    if (isset($validate['UID']) && $validate['UID'] > 0) {
                        $response['status'] = 'successAlert';
                        $response['message'] = 'Email Already Exist...';
                        echo json_encode($response);

                    } else {

                        $record = array();
                        $record['FullName'] = $Name;
                        $record['Email'] = $Email;
                        $record['EmailsListID'] = $key;
                        $record['DomainID'] = $DomainID;
                        $counterId = $EmailCampaigns->saveEmailwithGroups($record);
                    }
                }
            }
            if (isset($counterId)) {
                $response['status'] = 'success';
                $response['message'] = 'Record Added Successfully...';
                echo json_encode($response);
            }


        }


    }

    public
    function fetch_email_list_record()
    {


        $data = $this->data;
        $DomainID = $data['session']['domainid'];

        $EmailCampaigns = new EmailCampaignModel();

        $filterRecords = $EmailCampaigns->GetEmailLists($DomainID);
        $records = $EmailCampaigns->GetEmailLists($DomainID, $_REQUEST['length'], $_REQUEST['start']);
        $DataArray = array();
        $cnt = $_REQUEST['start'];
        foreach ($records as $value) {
            $actions = '';
            $actions = '
            <div class="btn-group"> 
                <button type="button"
                        class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                        id="dropdownMenuReference1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" data-reference="parent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-chevron-down">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1"
                     style="will-change: transform;">
                     <a class="dropdown-item" href="#"
                        onclick="LoadModal(\'sales/email_campaign/all_email_models/list_form\', ' . $value['UID'] . '  ,\'modal-sm\')">Update</a>
                        <a class="dropdown-item" href="' . PATH . 'emailcampaign/emaillisting/' . $value['UID'] . '">Export </a>
                        <a class="dropdown-item" href="#"
                   onclick="DeleteEmailList( ' . $value['UID'] . ' )">Delete</a>
                </div>
            </div> ';
            $cnt++;
            $subArray = array();

            $subArray[] = $cnt;
            $subArray[] = ucwords($value['FullName']);
            $subArray[] = NUMBER($value['TotalEmailIDs']);
            $subArray[] = $actions;
            $DataArray[] = $subArray;

        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray,
        );
        echo json_encode($output);


    }

    public
    function list_stats_change()
    {
        $data = $this->data;

        $UID = $this->request->getVar('UID');
        $Status = $this->request->getVar('Status');


        if ($Status == 'block') {
            $Status = 'active';
        } else {
            $Status = 'block';
        }

        $EmailCampaigns = new EmailCampaignModel();
        $EmailCampaigns->ListStatusChange($UID, $Status);

    }

    public function emaillisting()
    {
        $data = $this->data;
        $UID = getSegment(3);

        $MainModel = $this->MainModel;
        $EmailCampaigns = new EmailCampaignModel();
        $data['All_Email_Name'] = $EmailCampaigns->ListOFAllEmailByID($UID);
        $data['All_list_Name'] = $EmailCampaigns->GetListNameByID($UID);
        $ListName = ucwords($data['All_list_Name'][0]['FullName']);


//        echo "<pre>";
//        print_r($inputArray);
//        exit;

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=$ListName-(" . date("d M, Y") . ").csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $fp = fopen('php://output', 'w');

        echo "Name  ,Emails  \n";
        foreach ($data['All_Email_Name'] as $inputArray) {
            fputcsv($fp, $inputArray);
        }
        fclose($fp);

    }

    public function run_campigns_data()
    {

        $data = $this->data;
        $DomainID = $data['session']['domainid'];
        $CampaignID = $this->request->getVar('Allcampaigns');
        $ListID = $this->request->getVar('All_Email_lists');
        $ExecuteDate = $this->request->getVar('Execute_Date');
        $records = array();
        $records['CampaignID'] = $CampaignID;
        $records['ListID'] = $ListID;
        $records['ExecDate'] = $ExecuteDate;
        $records['DomainID'] = $DomainID ;

        $EmailCampaigns = new EmailCampaignModel();
        $EmailCampaigns->RunEmailCampaignsData($records);

    }

//    public function HTMLDataCampaign()
//    {
//        echo '<div class="form-group">
//                <label for="Name"> Email Subscribers: </label></br>
//                   <strong class="text-danger">Remaining : 0 </strong>
//                   <strong class="text-success ml-3">Total Records : 0</strong>
//               </div>';
//    }

    public function HTMLDataList()
    {
//        echo "<pre>";
//        print_r($_REQUEST);
//        exit;
        $data = $this->data;
        $ListID = $this->request->getVar('All_Email_lists');
        $CampaignID = $this->request->getVar('Allcampaigns');
        $EmailCampaigns = new EmailCampaignModel();
        $Totalrecords = $EmailCampaigns->GetTotalEmailListsData($ListID);
        $Remainingrecords = $EmailCampaigns->GetRemainingEmailListsData($ListID,$CampaignID);
        echo '<div class="form-group">
                <label for="Name"> Email Subscribers: </label></br>
                   <strong class="text-danger">Remaining : '.$Remainingrecords[0]['count'].' </strong>
                   <strong class="text-success ml-3">Total Records : '.$Totalrecords[0]['count'].'</strong>
               </div>';
    }




}