<?php namespace App\Controllers;

use App\Models\Crud;
use App\Models\Sales;
use App\Models\Main;
use App\Models\Users;
use App\Models\LeadModel;

class Lead extends BaseController
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

    public
    function test()
    {

        $Lead = new LeadModel();
        $Data = $Lead->GetAgentThresholdAndTotalNewAssignLeadsDataWithProjectUID(54, 'umrah');
        echo '<pre>';
        print_r($Data);
    }

    public function index()
    {
        $data = $this->data;
        $ProductName = getSegment(3);
        $data['product_name'] = $ProductName;


        echo view('header', $data);
        echo view('sales/lead/index', $data);
        echo view('footer', $data);

    }

    public function all_leads()
    {

        $data = $this->data;
        echo view('header', $data);
        echo view('sales/lead/all_leads', $data);
        echo view('footer', $data);
    }

    public function get_last_month_product_data()
    {
        $Sales = new Sales();

        $DataArray = array();
        $cnt = $_POST['start'];
        $productName = $_POST['product'];
        $filterRecords = $Sales->last_month_data('', '', $productName);
        $records = $Sales->last_month_data($_REQUEST['length'], $_REQUEST['start'], $productName);

        foreach ($records as $value) {
            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);
            $subArray[] = DATEFORMAT($value['CreatedAt']);
            $subArray[] = '<badge style="border-radius: 4px !important;" class="badge badge-success">' . str_replace("_", '', $value['Status']) . '</badge>';
            $subArray[] = $value['SaleOfficer'];
            $subArray[] = ((isset($value['LeadAssignmentDate']) && $value['LeadAssignmentDate'] != '') ? DATEFORMAT($value['LeadAssignmentDate']) : '-');
            $subArray[] = $value['FullName'];
            $subArray[] = ((isset($value['ContactNo']) && $value['ContactNo'] != '') ? $value['ContactNo'] : '-');
            $subArray[] = ((isset($value['WhatsappNo']) && $value['WhatsappNo'] != '') ? $value['WhatsappNo'] : '-');

            $DataArray[] = $subArray;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);
    }

    public function get_call_backs_data()
    {
        $Sales = new Sales();

        $DataArray = array();

        $session = session();
        $Filters = $session->get('CallBacksSearchFilter');
        $Filters = ((isset($Filters) && $Filters != '') ? $Filters : '');

        $cnt = $_POST['start'];
        $productName = $_POST['product'];
        $call_back_month = $_POST['call_back_month'];

//        print_r($Filters);exit;

        $filterRecords = $Sales->get_callback_data('', '', $productName, $call_back_month, $Filters);
        $records = $Sales->get_callback_data($_REQUEST['length'], $_REQUEST['start'], $productName, $call_back_month, $Filters);

        foreach ($records as $value) {
            $cnt++;


            $actions = '';
            $actions .= '<div class="btn-group"> 
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
                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="will-change: transform;">              
                
                 <a class="dropdown-item" href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) . '">Activities</a>
                </div>
            </div> ';

            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = $value['SalesOfficer'];
            $subArray[] = ucwords($value['ProductID']);
            $subArray[] = ((isset($value['CallBackDateTime'])) ? date("d M, Y h:i A", strtotime($value['CallBackDateTime'])) : '-');
            $subArray[] = $value['FullName'];
            $subArray[] = $value['Email'];
            $subArray[] = $value['ContactNo'];
            $subArray[] = str_replace("_", " ", ucwords($value['Status']));
            $subArray[] = $actions;
            $DataArray[] = $subArray;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);
    }

    public function new()
    {
        $data = $this->data;
        $ProductName = getSegment(3);
        $data['product_name'] = $ProductName;

        echo view('header', $data);
        echo view('sales/lead/new', $data);
        echo view('footer', $data);
    }

    public function get_new_product_data()
    {
        $Sales = new Sales();
        $DataArray = array();
        $cnt = $_POST['start'];
        $Product = $_POST['Product'];
        $filterRecords = $Sales->get_new_products_data('', '', $Product);
        $records = $Sales->get_new_products_data($_REQUEST['length'], $_REQUEST['start'], $Product);

        foreach ($records as $value) {

            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);
            $subArray[] = DATEFORMAT($value['CreatedAt']);
            $subArray[] = $value['SaleOfficer'];
            $subArray[] = ((isset($value['LeadAssignmentDate']) && $value['LeadAssignmentDate'] != '') ? DATEFORMAT($value['LeadAssignmentDate']) : '-');
            $subArray[] = $value['FullName'];
            $subArray[] = ((isset($value['ContactNo']) && $value['ContactNo'] != '') ? $value['ContactNo'] : '-');
            $subArray[] = ((isset($value['WhatsappNo']) && $value['WhatsappNo'] != '') ? $value['WhatsappNo'] : '-');

            $DataArray[] = $subArray;

        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);

    }

    public function fetch_all_unorganic_lead()
    {
        $LeadModel = new LeadModel();
        $DataArray = array();
        $cnt = $_POST['start'];

        $session = session();
        $Filters = $session->get('OrganicLeadsSessionFilter');
        $Filters = ((isset($Filters) && $Filters != '') ? $Filters : '');


        $filterRecords = $LeadModel->get_organic_lead_data('', '', $Filters);
        $records = $LeadModel->get_organic_lead_data($_REQUEST['length'], $_REQUEST['start'], $Filters);

        foreach ($records as $value) {
            $cnt++;
            $WhatsAppUrl = '';
            $ContactURl = WhatsAppUrl($value['ContactNo']);
            if ($value['WhatsAppNo'] != '') {
                $WhatsAppUrl = WhatsAppUrl($value['WhatsAppNo']);
            }

            $actions = '';
            $actions .= '<div class="btn-group"> 
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
                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="will-change: transform;">
               
                 <a class="dropdown-item" href="#" onclick="LoadModal(\'sales/add_organic_lead_form\',' . $value['UID'] . '  ,\'modal-lg\' )">Update</a>
                 <a class="dropdown-item" href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) . '" target="_blank">Activities</a>          
                 <a class="dropdown-item" href="#" onclick="RemoveOrganicLead(' . $value['UID'] . ')">Delete</a>
                </div>
            </div> ';

            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = (($value['SystemDate'] != '') ? wordwrap(date("d M, Y h:i A", strtotime($value['SystemDate'])), 15, '<br>', true) : '-');
            $subArray[] = (($value['CreatedAt'] != '') ? wordwrap(date("d M, Y h:i A", strtotime($value['CreatedAt'])), 15, '<br>', true) : '-');
            $subArray[] = ucwords($value['ProductID']);
            $subArray[] = (($value['AgentFullName'] != '') ? $value['AgentFullName'] : '-');
            $subArray[] = $value['FullName'];
            $subArray[] = '<a target="_blank" style="cursor:pointer;" href="' . $ContactURl . '">' . $value['ContactNo'] . '</a>';
            $subArray[] = (($WhatsAppUrl != '') ? '<a target="_blank" style="cursor:pointer;" href="' . $WhatsAppUrl . '">' . $value['WhatsAppNo'] . '</a>' : $value['WhatsAppNo']);
            $subArray[] = (($value['Facebook'] != '-') ? '<a href="' . $value['Facebook'] . '" target="_blank">Click Here</a>' : $value['Facebook']);
            $subArray[] = (($value['Instagram'] != '-') ? '<a href="' . $value['Instagram'] . '" target="_blank">Click Here</a>' : $value['Instagram']);
            $subArray[] = (($value['Twitter'] != '-') ? '<a href="' . $value['Twitter'] . '" target="_blank">Click Here</a>' : $value['Twitter']);
            $subArray[] = (($value['Linkedln'] != '-') ? '<a href="' . $value['Linkedln'] . '" target="_blank">Click Here</a>' : $value['Linkedln']);
            $subArray[] = $actions;

            $DataArray[] = $subArray;

        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);

    }

    public
    function remove_organic_lead()
    {

        $Crud = new Crud();
        $LeadUID = $this->request->getVar('LeadUID');
        $record = array('Archive' => 1);
        $where = array('UID' => $LeadUID);
        $Crud::UpdateRecord('sales."Leads"', $record, $where);
        $result = array();
        $result['status'] = 'success';
        $result['message'] = 'Lead Deleted Successfully';
        echo json_encode($result);

    }

    public
    function facebook_leads_import_form_submit()
    {
        $data = $this->data;
        $LeadsImport = new LeadModel();
        $Crud = new Crud();

        $ProjectID = $this->request->getVar('project_id');
        $FileFormat = $this->request->getVar('file_format');
        $LeadCategory = $this->request->getVar('lead_category');

        $DomainID = $data['session']['domainid'];

        $File = $_FILES['uploaded_file']['tmp_name'];

        $file = $this->request->getFile('uploaded_file');
        if (!empty($File)) {
            $Validation = $this->validate(array(
                'uploaded_file' => 'uploaded[uploaded_file]|ext_in[uploaded_file,csv,text/csv]'
            ));

            if (!$Validation) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = $this->validator->getError('uploaded_file');
                echo json_encode($result);

            } else {

                $FileName = $file->getRandomName();
                $file->move(ROOTPATH . 'uploads/facebook-importer/', $FileName);
                $file = fopen(ROOTPATH . "uploads/facebook-importer/" . $FileName, "r");
                $i = 0;
                $numberOfFields = 8;
                $ImportCount = 0;
                while (($UploadedFileData = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $num = count($UploadedFileData);
                    $FinalArray = array();

                    // Skip first row & check number of fields
                    if ($i > 0 && $num == $numberOfFields) {

                        $ContactNo = '';
                        $DateTime = explode(",", $UploadedFileData[0]);
                        //$FormattedDateTime = FBDate($DateTime[0]);
                        if ($FileFormat == 'MM/DD/YYYY') {
                            $FormattedDateTime = date("Y-m-d", strtotime($DateTime[0]));
                        } else {
                            $DateFormatted = str_replace(',', '', $DateTime[0]);
                            $date = str_replace('/', '-', $DateFormatted);
                            $FormattedDateTime = date("Y-m-d", strtotime($date));
                        }

                        /// Check Contact No Validate
                        if (isset($UploadedFileData[3]) && strpos($UploadedFileData[3], '000000') !== false ||
                            strpos($UploadedFileData[3], 'E+11') !== false) {
                            $ContactNo = '';
                        } else {
                            $ContactNo = $UploadedFileData[3];
                        }

                        if ($ContactNo != '' && trim($UploadedFileData[1]) != '') {

                            /*$where = array(
                                'CreatedAt' => $FormattedDateTime . " " . date("H:i:s", strtotime($DateTime[1])),
                                'Email' => trim($UploadedFileData[2]),
                                'ContactNo' => ContactValidate($ContactNo)
                            );
                            $LeadExistingData = $Crud::SingleRecord('sales."Leads"', $where, array());*/

                            $LeadExistingData = LeadDuplicateCheck($LeadCategory, array(ContactValidate($ContactNo)));
                            if (isset($LeadExistingData) && $LeadExistingData == 1) {
                                /// Lead Already Exist With Date, Email, ContactNo
                            } else {

                                $FinalArray['CreatedAt'] = $FormattedDateTime . " " . date("H:i:s", strtotime($DateTime[1]));
                                $FinalArray['FullName'] = ((isset($UploadedFileData[1]) && $UploadedFileData[1] != '') ? ucwords(trim($UploadedFileData[1])) : '');
                                $FinalArray['Email'] = ((isset($UploadedFileData[2]) && $UploadedFileData[2] != '') ? strtolower(trim($UploadedFileData[2])) : '');
                                $FinalArray['ContactNo'] = ContactValidate($ContactNo);
                                $FinalArray['Source'] = 'facebook import';
                                $FinalArray['ProductID'] = $ProjectID;
                                $FinalArray['SourceDesc'] = ((isset($UploadedFileData[6]) && $UploadedFileData[6] != '') ? trim($UploadedFileData[6]) : '');
                                $FinalArray['Status'] = 'new';
                                $FinalArray['UserID'] = 0;
                                $FinalArray['DomainID'] = $DomainID;
                                $FinalArray['LeadCategory'] = ((isset($LeadCategory) && $LeadCategory != '') ? $LeadCategory : '');
                                $LeadsImport::FacebookFileImporterFormSubmit($FinalArray);
                                $ImportCount++;
                            }
                        }

                    }
                    $i++;
                }
                fclose($file);

                $LeadsImport->AssignNewLeadsToTodayActiveSaleOfficers();

                $result = array();
                $result['status'] = 'success';
                $result['ImportCount'] = $ImportCount;
                $result['message'] = 'Facebook Leads File Successfully Imported';
                echo json_encode($result);

            }

        } else {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Please! Select File To Import';
            echo json_encode($result);
        }
    }

    public function personal()
    {
        $data = $this->data;
        $ProductName = getSegment(3);
        $data['product_name'] = $ProductName;

        echo view('header', $data);
        echo view('sales/lead/personal', $data);
        echo view('footer', $data);
    }

    public function all()
    {
        $data = $this->data;
        $ProductName = getSegment(3);
        $data['product_name'] = $ProductName;
//        $DomainID = $data['session']['domainid'];
//        $lead = new LeadModel();
//        $data['product_records'] = $lead->GetProductsStatsRecords($ProductName, $DomainID);

        echo view('header', $data);
        echo view('sales/lead/all', $data);
        echo view('footer', $data);
    }


    public
    function fetch_personal_data()
    {
        $Sales = new Sales();
        $DataArray = array();
        $cnt = $_POST['start'];
        $personalproductddata = $_POST['productname'];
        $filterRecords = $Sales->personal_products_data('', '', $personalproductddata);
        $records = $Sales->personal_products_data($_REQUEST['length'], $_REQUEST['start'], $personalproductddata);

        foreach ($records as $value) {

            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);
            $subArray[] = DATEFORMAT($value['CreatedAt']);
            $subArray[] = ((isset($value['SaleOfficer']) && $value['SaleOfficer'] != '') ? $value['SaleOfficer'] : '-');
            $subArray[] = ((isset($value['LeadAssignmentDate']) && $value['LeadAssignmentDate'] != '') ? DATEFORMAT($value['LeadAssignmentDate']) : '-');
            $subArray[] = $value['FullName'];
            $subArray[] = ((isset($value['ContactNo']) && $value['ContactNo'] != '') ? $value['ContactNo'] : '-');
            $subArray[] = ((isset($value['WhatsappNo']) && $value['WhatsappNo'] != '') ? $value['WhatsappNo'] : '-');
            $subArray[] = '<badge style="border-radius: 4px;" class="badge badge-success">' . ucwords(str_replace("_", ' ', $value['Status'])) . '</badge>';
            $subArray[] = $value['LeadCategory'];

            $DataArray[] = $subArray;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);
    }

//    public function callback()
//    {
//        $data = $this->data;
//        $ProductName = getSegment(3);
//        $data['product_name'] = $ProductName;
//
//        echo view('header', $data);
//        echo view('sales/lead/callback', $data);
//        echo view('footer', $data);
//    }

    public function comments()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/lead/comments', $data);
        echo view('footer', $data);
    }

    public function get_comments_data()
    {

        $Sales = new Sales();
        $DataArray = array();
        $cnt = $_POST['start'];
        $filterRecords = $Sales->get_lead_comments_data();
        $leadsrecords = $Sales->get_lead_comments_data($_REQUEST['length'], $_REQUEST['start']);

        foreach ($leadsrecords as $value) {

            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = $value['FullName'];
            $subArray[] = $value['SaleOfficer'];
            $subArray[] = $value['ProductID'];
            $subArray[] = $value['Status'];
            $subArray[] = date("d M, Y h:i A", strtotime($value['LastCommentDateTime']));
            $subArray[] = $value['LastComment'];

            $DataArray[] = $subArray;

        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($leadsrecords),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);
    }

    public function un_assign()
    {
        $data = $this->data;
        $LeadsInfo = new LeadModel();
        $DomainID = $data['session']['domainid'];
        $data['LeadData'] = $LeadsInfo->get_leads_data($DomainID);

        echo view('header', $data);
        echo view('sales/lead/unassign/index', $data);
        echo view('footer', $data);
    }

    public function export_leads()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('sales/lead/export_leads', $data);
        echo view('footer', $data);
    }

    public function get_exports_leads_data()
    {
        $Sales = new Sales();
        $DataArray = array();
        $cnt = $_POST['start'];
        $filterRecords = $Sales->get_exports_leads_data();
        $leadsrecords = $Sales->get_exports_leads_data($_REQUEST['length'], $_REQUEST['start']);

        foreach ($leadsrecords as $value) {
            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = $value['CreatedAt'];
            $subArray[] = ((isset($value['FullName']) && $value['FullName'] != '') ? $value['FullName'] : '-');
            $subArray[] = ((isset($value['ProductID']) && $value['ProductID'] != '') ? '<badge class="badge badge-primary">' . $value['ProductID'] . '</badge>' : '-');
            $subArray[] = ((isset($value['Email']) && $value['Email'] != '') ? $value['Email'] : '-');
            $subArray[] = ((isset($value['Status']) && $value['Status'] != '') ? '<badge class="badge badge-success">' . $value['Status'] . '</badge>' : '-');
            $subArray[] = ((isset($value['ContactNo']) && $value['ContactNo'] != '') ? $value['ContactNo'] : '-');
            $subArray[] = ((isset($value['WhatsAppNo']) && $value['WhatsAppNo'] != '') ? $value['WhatsAppNo'] : '-');
            $DataArray[] = $subArray;
        }
        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($leadsrecords),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);
    }


    public function organic_leads()
    {
        $data = $this->data;
        $LeadModel = new LeadModel();
//        $session = session();
//        $DomainID = $session->get('domainid');
//
//        $data['OrganicLeads'] = $LeadModel->get_all_organic_leads_data($DomainID);

        echo view('header', $data);
        echo view('sales/lead/organic_leads', $data);
        echo view('footer', $data);
    }

    public
    function organic_leads_form_submit()
    {
        $session = session();
        $UserID = $session->get('id');
        $DomainID = $session->get('domainid');
        $DataArray = array();
        $Meta = array();
        $LeadsImport = new LeadModel();


        $UID = $this->request->getVar('UID');
        $CreateDate = $this->request->getVar('CreateDate');
        $SalesOfficer = $this->request->getVar('SalesOfficer');
        $FullName = $this->request->getVar('FullName');
        $ContactNumber = $this->request->getVar('ContactNumber');
        $WhatsAppNo = $this->request->getVar('WhatsAppNo');
        $Email = $this->request->getVar('Email');
//        $Product = $this->request->getVar('Product');


        $LeadCategory = $this->request->getVar('lead_category');

        $B2BLeadStatus = $this->request->getVar('b2b_leadStatus');
        $B2CLeadStatus = $this->request->getVar('b2c_leadStatus');
        $LeadStatus = ((isset($B2BLeadStatus) && $B2BLeadStatus != '') ? $B2BLeadStatus : ((isset($B2CLeadStatus) && $B2CLeadStatus != '') ? $B2CLeadStatus : ''));

        $B2BCloseReason = $this->request->getVar('b2b_close_reason');
        $B2CCloseReason = $this->request->getVar('b2c_close_reason');
        $CloseReason = ((isset($B2BCloseReason) && $B2BCloseReason != '') ? $B2BCloseReason : ((isset($B2CCloseReason) && $B2CCloseReason != '') ? $B2CCloseReason : 0));


        $Facebook = $this->request->getVar('Facebook');
        $Linkedln = $this->request->getVar('LinkedIn');
        $Instagram = $this->request->getVar('Instagram');
        $Twitter = $this->request->getVar('Twitter');

        $Meta['Facebook'] = $Facebook;
        $Meta['LinkedIn'] = $Linkedln;
        $Meta['Instagram'] = $Instagram;
        $Meta['Twitter'] = $Twitter;

        $DataArray['CreatedAt'] = date("Y-m-d", strtotime($CreateDate)) . " " . date("H:i:s");
        $DataArray['FullName'] = $FullName;
        $DataArray['ContactNo'] = ContactValidate($ContactNumber);
        $DataArray['WhatsAppNo'] = $WhatsAppNo;
        $DataArray['Email'] = $Email;
        $DataArray['Personal'] = 0;
        $DataArray['DomainID'] = $DomainID;
        $DataArray['Source'] = 'Organic';
        $DataArray['ProductID'] = $Product;
        $DataArray['Organic'] = 1;
        $DataArray['UserID'] = $SalesOfficer;
        //$DataArray['CallBackDateTime'] = $CallBackDateTime;
        if ($UID == 0) {
            $DataArray['LeadAssignmentDate'] = date("Y-m-d H:i:s");
            $DataArray['SystemDate'] = date("Y-m-d H:i:s");
        }

        $DataArray['Status'] = $LeadStatus;
        $DataArray['LeadCategory'] = $LeadCategory;
        if ($_SERVER["HTTP_HOST"] != "localhost") {
            $records['CloseReason'] = (($LeadStatus == 'closed_clients' && $CloseReason > 0) ? $CloseReason : 0);
        }


        $ProductMeta = array();

        $Products = $this->request->getVar('Products');
        $ProductMeta = $Products;

//        $DataArray['CloseReason'] = (($LeadStatus == 'closed_clients' && $CloseReason > 0) ? $CloseReason : 0);

//        if ($_POST['FullName'] == '') {
//            $result = array();
//            $result['status'] = 'fail';
//            $result['message'] = 'Full Name Cannot be Empty';
//            echo json_encode($result);
//        }else {
        $LeadsImport::OrganicLeadsFormSubmit($DataArray, $ProductMeta, $Meta, $UID);
//        }
    }

    public function worksheet()
    {
        $data = $this->data;


        $Admin = new Sales();
        $data['WorkSheetData'] = $Admin::GetAllWorkSheetDataWithLimit();

//        print_r($data['WorkSheetData']);exit;

        echo view('header', $data);
        echo view('sales/worksheet/worksheet', $data);
        echo view('footer', $data);
    }

    public function add_organic_worksheet()
    {
        $data = $this->data;
        echo view('header', $data);
        echo view('sales/worksheet/add_organic_worksheet', $data);
        echo view('footer', $data);
    }

    public function update_organic_worksheet()
    {
        $data = $this->data;
        $Admin = new Sales();

        $data['WorkSheetUID'] = $WorkSheetUID = getSegment(3);

        if (isset($WorkSheetUID) && $WorkSheetUID != '' && $WorkSheetUID > 0) {

            if (!WorkSheetAccess($WorkSheetUID)) {
                return redirect()->to($data['path'] . '/lead/worksheet');
                exit;
            }

            $data['WorkSheetData'] = $Admin::GetWorkSheetDataByUID($WorkSheetUID);
            // if (isset($data['WorkSheetData']['Sheet']['UID']) && date("Y-m-d", strtotime($data['WorkSheetData']['Sheet']['CreatedAt'])) == date("Y-m-d")) {
            echo view('header', $data);
            echo view('sales/worksheet/update_organic_worksheet', $data);
            echo view('footer', $data);

            /*  } else {
                  return redirect()->to($data['path'] . '/lead/worksheet');
                  exit;
              }*/

        } else {
            return redirect()->to($data['path'] . '/lead/worksheet');
            exit;
        }

    }


    public function close_lead_quality()
    {
        $data = $this->data;
        $Crud = new Crud();
//        $data['lookup_key'] = getSegment(3);
        $data['lookup_key'] = 'b2c_lead_close_reason';

        $table = 'main."Lookups"';
        $where = array("Key" => $data['lookup_key']);
        $data['lookup'] = $Crud->SingleRecord($table, $where);

        $table = 'main."LookupsOptions"';
        $where = array("LookupID" => $data['lookup']['UID'], "Archive" => "0");
        $data['records'] = $Crud->ListRecords($table, $where, array("OrderID" => "ASC"));
//        echo "<pre>";
//        print_r($data['records']);
//        exit;
        $SystemUsers = new Users();
        $data['sale_officers'] = $SystemUsers->ListSalesUsers();


        echo view('header', $data);
        echo view('sales/staff/close_lead_quality', $data);
        echo view('footer', $data);
    }


    public function save_lead_record()
    {
        $data = $this->data;
        $LeadsInfo = new LeadModel();

        $DomainID = $data['session']['domainid'];
        $UID = $this->request->getVar('UID');
        $FullName = $this->request->getVar('FullName');
        $ContactNumber = $this->request->getVar('ContactNumber');
        $WhatsAppNo = $this->request->getVar('WhatsAppNo');
        $Email = $this->request->getVar('Email');
        $Personal = $this->request->getVar('Personal');
        $saleOfficer = $this->request->getVar('saleOfficer');
        $createDate = $this->request->getVar('createDate');
        $Source = $this->request->getVar('Source');
        $LeadCategory = $this->request->getVar('lead_category');

        $B2BLeadStatus = $this->request->getVar('b2b_leadStatus');
        $B2CLeadStatus = $this->request->getVar('b2c_leadStatus');
        $LeadStatus = ((isset($B2BLeadStatus) && $B2BLeadStatus != '') ? $B2BLeadStatus : ((isset($B2CLeadStatus) && $B2CLeadStatus != '') ? $B2CLeadStatus : ''));

        $B2BCloseReason = $this->request->getVar('b2b_close_reason');
        $B2CCloseReason = $this->request->getVar('b2c_close_reason');
        $CloseReason = ((isset($B2BCloseReason) && $B2BCloseReason != '') ? $B2BCloseReason : ((isset($B2CCloseReason) && $B2CCloseReason != '') ? $B2CCloseReason : 0));


        $records = array();
        $Meta = array();
        $records['FullName'] = $FullName;
        $records['ContactNo'] = ContactValidate($ContactNumber);
        $records['WhatsAppNo'] = ContactValidate($WhatsAppNo);
        $records['Email'] = $Email;
        $records['Personal'] = $Personal;
        $records['UserID'] = $saleOfficer;
        $records['Source'] = $Source;
//        $records['ProductID'] = $Products;
        $records['Status'] = $LeadStatus;
        $records['LeadCategory'] = $LeadCategory;
        if ($_SERVER["HTTP_HOST"] != "localhost") {
            $records['CloseReason'] = (($LeadStatus == 'closed_clients' && $CloseReason > 0) ? $CloseReason : 0);
        }

        if ($UID == 0) {
            $records['DomainID'] = $DomainID;
            $records['CreatedAt'] = $createDate;
        }

        $PersonalRelation = $this->request->getVar('PersonalRelation');
        $CompanyAgent = $this->request->getVar('CompanyAgent');
        $MobileNo1 = $this->request->getVar('MobileNo1');
        $PhoneNo1 = $this->request->getVar('PhoneNo1');
        $PhoneNo2 = $this->request->getVar('PhoneNo2');
        $City = $this->request->getVar('City');
        $Zone = $this->request->getVar('Zone');


        $Meta['PersonalRelation'] = $PersonalRelation;
        $Meta['CompanyAgentName'] = $CompanyAgent;
        $Meta['MobileNumber1'] = $MobileNo1;
        $Meta['Phone1'] = $PhoneNo1;
        $Meta['Phone2'] = $PhoneNo2;
        $Meta['City'] = $City;
        $Meta['Zone'] = $Zone;


        $ProductMeta = array();

        $Products = $this->request->getVar('Products');
        $ProductMeta = $Products;

        $LeadsInfo->save_leads_data($records, $Meta, $ProductMeta, $UID);

        //        $RecordMeta = array();
//        $RecordMeta['Options'] = 'lead_pr';
//        $RecordMeta['Value'] = $PersonalRelation;
//        $RecordMeta['LeadID'] = $LeadID;
//        if ($UID > 0) {
//            $RecordMeta['LeadID'] = $UID;
//            $table = 'sales."LeadsMeta"';
//            $where = array('LeadID' => $UID);
//            $Crud = new Crud();
//            $Crud->DeleteRecord($table, $where);
//        }
//
//        $LeadsInfo->save_leads_meta($RecordMeta);

    }

    public function fetch_all_unassign_lead()
    {
        //        echo '<pre>';
//        echo $_POST['start'];
//        echo $_POST['length'];
//        echo $_POST['search']['value'];
//        print_r($_POST['search']['value']);
//        exit;

        $data = $this->data;
        $LeadsInfo = new LeadModel();
        $DomainID = $data['session']['domainid'];
        $filterRecords = $LeadsInfo->get_unassignLead_filter_data($_POST['search']['value'], $DomainID, '', '');
        $records = $LeadsInfo->get_unassignLead_filter_data($_POST['search']['value'], $DomainID, $_POST['length'], $_POST['start']);

        $DataArray = array();
        $cnt = $_POST['start'];

        foreach ($records as $value) {
            $actions = '';
            $actions .= '<div class="btn-group"> 
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
                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="will-change: transform;">
                
                 <a class="dropdown-item" href="#" onclick="LoadModal(\'sales/lead/unassign/add_lead\',' . $value['UID'] . '  ,\'modal-lg\' )">Update</a>          
                 <a class="dropdown-item" href="#" onclick="DeleteLead(' . $value['UID'] . ')">Delete</a>
                </div>
            </div> ';

            $cnt++;
            $subArray = array();
            /* $WhatsAppUrl = '';
             $ContactUrl = '';
             if ($value['WhatsAppNo'] != '') {
                 $WhatsAppUrl = WhatsAppUrl($value['WhatsAppNo']);
             }
             if ($value['ContactNo'] != '') {
                 $ContactUrl = WhatsAppUrl($value['ContactNo']);
             }*/

            $array = explode(",", $value['ProductName']);
            $ProductNameData = '';
            foreach ($array as $Record) {
                $ProductNameData .= '<badge class="badge badge-success">' . ucwords($Record) . '</badge>';
            }


            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);

            $subArray[] = $ProductNameData;
            $subArray[] = ucwords($value['FullName']);
            //$subArray[] = ((isset($ContactUrl) && $ContactUrl != '') ? '<a target="_blank" style="cursor:pointer;" href="' . $ContactUrl . '">' . $value['ContactNo'] . '</a>' : '-');
            //$subArray[] = ((isset($WhatsAppUrl) && $WhatsAppUrl != '') ? '<a target="_blank" style="cursor:pointer;" href="' . $WhatsAppUrl . '">' . $value['WhatsAppNo'] . '</a>' : '-');
            $subArray[] = '<badge class="badge badge-primary">' . $value['LeadCategory'] . '</badge>';
            $subArray[] = '<badge class="badge badge-success">' . ucwords(str_replace('_', ' ', $value['Status'])) . '</badge>';
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

    public function delete_lead_record()
    {
        $UID = $this->request->getVar('UID');
        $record['Archive'] = 1;
        $LeadsInfo = new LeadModel();
        $LeadsInfo->delete_lead_data($record, $UID);
    }

    public
    function manual_leads_import_form_submit()
    {
        $data = $this->data;
        $LeadsImport = new LeadModel();
        $Crud = new Crud();
        $UIDArrays = array();
        $ProjectID = $this->request->getVar('project_id');
        $FileFormat = $this->request->getVar('file_format');
        $LeadCategory = $this->request->getVar('lead_category');
        $DomainID = $data['session']['domainid'];

        /// Check Submitted File Empty or Not
        $File = $_FILES['uploaded_file']['tmp_name'];

        $file = $this->request->getFile('uploaded_file');
        if (!empty($File)) {
            $Validation = $this->validate(array(
                'uploaded_file' => 'uploaded[uploaded_file]|ext_in[uploaded_file,csv,text/csv]'
            ));

            if (!$Validation) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = $this->validator->getError('uploaded_file');
                echo json_encode($result);

            } else {

                $FileName = $file->getRandomName();
                $file->move(ROOTPATH . 'uploads/manual-importer/', $FileName);
                $file = fopen(ROOTPATH . "uploads/manual-importer/" . $FileName, "r");
                $i = 0;
                $numberOfFields = 9;
                while (($UploadedFileData = fgetcsv($file, 1000, ",")) !== FALSE) {

                    $num = count($UploadedFileData);
                    $FinalArray = array();
                    $Meta = array();

                    if ($i > 0 && $num == $numberOfFields) {

                        $MobileNo1 = ContactValidate($UploadedFileData[2]);
                        $MobileNo2 = ContactValidate($UploadedFileData[3]);
                        $Whatsapp = ContactValidate($UploadedFileData[6]);


                        if ($MobileNo2 != '' || $MobileNo1 != '' || $Whatsapp != '') {

                            $final = array();
                            if ($MobileNo1 != '') {
                                $final[] = $MobileNo1;
                            }
                            if ($MobileNo2 != '') {
                                $final[] = $MobileNo2;
                            }
                            if ($Whatsapp != '') {
                                $final[] = $Whatsapp;
                            }
                            $CheckDuplicate = LeadDuplicateCheck($LeadCategory, $final);

                            if (isset($CheckDuplicate) && $CheckDuplicate == 1) {
                            } else {

                                $FinalArray['CreatedAt'] = date("Y-m-d H:i:s");
                                $FinalArray['FullName'] = ((isset($UploadedFileData[1]) && $UploadedFileData[1] != '') ? ucwords(trim($UploadedFileData[1])) : '');
                                $FinalArray['WhatsAppNo'] = ((isset($Whatsapp) && $Whatsapp != '') ? $Whatsapp : '');
                                $FinalArray['ContactNo'] = $MobileNo2;
                                $FinalArray['Source'] = ((isset($UploadedFileData[7]) && $UploadedFileData[7] != '') ? strtolower(trim($UploadedFileData[7])) : 'manual file import');
                                $FinalArray['ProductID'] = $ProjectID;
                                $FinalArray['UserID'] = '0';
                                $FinalArray['Status'] = 'new';
                                $FinalArray['LeadCategory'] = $LeadCategory;
                                $FinalArray['DomainID'] = $DomainID;
                                $FinalArray['Country'] = ((isset($UploadedFileData[8]) && $UploadedFileData[8] != '') ? $UploadedFileData[8] : '');

                                $Meta['MobileNumber1'] = $MobileNo1;
                                $Meta['CompanyAgentName'] = ((isset($UploadedFileData[0]) && $UploadedFileData[0] != '') ? ucwords(trim($UploadedFileData[0])) : '');
                                $Meta['Phone1'] = ((isset($UploadedFileData[4]) && $UploadedFileData[4] != '') ? $UploadedFileData[4] : '');
                                $Meta['Phone2'] = ((isset($UploadedFileData[5]) && $UploadedFileData[5] != '') ? $UploadedFileData[5] : '');

                                /*echo '<pre>';
                                echo "Final contact: " . $FinalArray['ContactNo'];
                                echo '<br></br>';*/
                                $LeadsImport::ManualFileImporterFormSubmit($FinalArray, $Meta);
                            }
                        }
                    }
                    $i++;
                }
                fclose($file);

                $LeadsImport->AssignNewLeadsToTodayActiveSaleOfficers();

                $result = array();
                $result['status'] = 'success';
                $result['total_records_in_file'] = $i;
                $result['message'] = 'Manual Leads File Successfully Imported';
                //$result['message'] = 'Total Uploaded Records Are  From '.$i.' Records  <br> Manual Leads File Successfully Imported';
                echo json_encode($result);
            }

        } else {

            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Please! Select File To Import';
            echo json_encode($result);
        }
    }

    public function facebook_api()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/lead/facebook_api', $data);
        echo view('footer', $data);

    }

    public function product_based_lead_report()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/reports/product_based_lead_report', $data);
        echo view('footer', $data);
    }

    public function callback()
    {
        $data = $this->data;

        $data['CallBackMonth'] = $CallBackMonth = getSegment(3);
        $data['Product'] = $Product = getSegment(4);

        echo view('header', $data);
        echo view('sales/lead/callback/list', $data);
        echo view('footer', $data);
    }

    public function activities()
    {
        $data = $this->data;
        $sales = new Sales();
        $Lead = new LeadModel();

        $mobile = getSegment(3);
        $UID = explode("-", $mobile);
        $UID = $UID[0];
        $data['record'] = $LeadRecord = $sales->FetchLeadsDetails($UID);
        if (isset($LeadRecord['UID']) && $LeadRecord['UID'] != '' && $LeadRecord['UID'] > 0) {
            echo view('header', $data);
            echo view('sales/lead/callback/activities', $data);
            echo view('footer', $data);
        } else {
            return redirect()->to($data['path'] . 'lead/un_assign');
            exit;
        }
    }

    public
    function add_property_tags_option()
    {

        $Tags = new Sales();
        $TagID = $this->request->getVar('Tag');
        $Value = $this->request->getVar('Value');
        $LeadUID = $this->request->getVar('LeadID');
        $Tags->AddPropertyOption($TagID, $LeadUID, $Value);
    }


    /** Leads Activity
     * Code Start
     * By jawad
     */

    public
    function leads_status_callback_form_submit()
    {

        // echo'<pre>';print_r($_REQUEST);exit;

        $Data = array();
        $Lead = new LeadModel();
        $CallBackDateTime = null;
        $CallBackDate = $this->request->getVar('call_back_date');
        $CallBackTime = $this->request->getVar('call_back_time');

        $CallBackActivity = $this->request->getVar('callback_activity');
        $UID = $this->request->getVar('LeadUID');

        if ($CallBackDate != '' && $CallBackTime != '') {
            $CallBackDateTime = date("Y-m-d", strtotime($CallBackDate)) . " " . date("H:i:s", strtotime($CallBackTime));
        }

        $DataArray['Status'] = (($this->request->getVar('status') != '') ? $this->request->getVar('status') : null);
        $DataArray['CallBackDateTime'] = $CallBackDateTime;
        $DataArray['CallBackActivity'] = ((isset($CallBackActivity) && $CallBackActivity != '') ? $CallBackActivity : '');

        $Lead::LeadStatusCallBack($DataArray, $UID);

    }

    public
    function followup_leads_form_submit()
    {

        //echo'<pre>';print_r($_REQUEST);exit;

        $Data = array();
        $Lead = new LeadModel();
        $CallBackDateTime = null;
        $CallBackDate = $this->request->getVar('call_back_date_followup');
        $CallBackTime = $this->request->getVar('call_back_time_followup');

        $CallBackActivity = $this->request->getVar('callback_activity_followup');
        $FollowUpReason = $this->request->getVar('FollowUpReason');

        $UID = $this->request->getVar('LeadUID');

        if ($CallBackDate != '' && $CallBackTime != '') {
            $CallBackDateTime = date("Y-m-d", strtotime($CallBackDate)) . " " . date("H:i:s", strtotime($CallBackTime));
        }

        $DataArray['Status'] = (($this->request->getVar('status') != '') ? $this->request->getVar('status') : null);
        $DataArray['CallBackDateTime'] = $CallBackDateTime;
        $DataArray['FollowUpReason'] = $FollowUpReason;
        $DataArray['CallBackActivity'] = ((isset($CallBackActivity) && $CallBackActivity != '') ? $CallBackActivity : '');

        $Lead::FollowUpLeadForm($DataArray, $UID);

    }

    public
    function closed_leads_form_submit()
    {

        //echo'<pre>';print_r($_REQUEST);exit;

        $Data = array();
        $Lead = new LeadModel();
        $status = $this->request->getVar('status');
        $Reason = $this->request->getVar('Reason');
        $UID = $this->request->getVar('LeadUID');
        $Remarks = $this->request->getVar('Remarks');


        $Lead::ClosedLeadForm($Reason, $status, $UID, $Remarks);

    }

    public
    function leads_status_maturity_form_submit()
    {

        //echo'<pre>';print_r( $_REQUEST );exit;

        $DataArray = array();
        $Lead = new LeadModel();

        $LeadUID = $this->request->getVar('LeadUID');
        $Status = $this->request->getVar('status');
        $Remarks = $this->request->getVar('maturity_remarks');

        $DataArray['LeadUID'] = $LeadUID;
        $DataArray['Status'] = $Status;
        $DataArray['Remarks'] = (($Remarks != '') ? $Remarks : null);

        $Lead::LeadStatusMaturityFormAdd($DataArray);
    }

    public
    function activity_attachments_form_submit()
    {
        $Crud = new Crud();
        $Lead = new LeadModel();
        $LeadUID = $this->request->getVar('LeadUID');
        $Remarks = $this->request->getVar('remarks');

        $Image = array();
        $Image['File'] = 0;

        if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
            $size = $_FILES['file']['size'] / 1024;
            if ($size > 2048) {
                $response['status'] = "fail";
                $response['message'] = "File must be less then 2MB...";
                echo json_encode($response);
                exit;
            } else {
                $fileID = $Crud->UploadFile('file');
                $Image['File'] = $fileID;
            }
        }
        $Lead->LeadActivityAttachmentForm($LeadUID, $Remarks, $Image);
    }

    public
    function leads_reassign_form_submit()
    {

        $data = $this->data;
        $DataArray = array();
        $LeadsImport = new LeadModel();

        $ReAssignedFrom = $this->request->getVar('ReAssignedFrom');

        $DataArray['SystemDate'] = date("Y-m-d H:i:s");
        $DataArray['LeadsUID'] = $this->request->getVar('LeadsUID');
        $DataArray['ReAssignedFrom'] = ((isset($ReAssignedFrom) && $ReAssignedFrom != '') ? $ReAssignedFrom : 0);
        $DataArray['ReAssignedTo'] = $this->request->getVar('ReAssignedTo');

        $LeadsImport::LeadsReassignFormSubmit($DataArray);

    }

    public
    function leads_tracking_data_by_contact_no()
    {
        $Leads = new LeadModel();
        $LeadsData = array();
        $Keyword = $this->request->getVar('Keyword');
        $LeadsData = $Leads->LeadsTrackingDataByContactNo($Keyword);
        echo json_encode($LeadsData);
    }

    public
    function un_assign_leads_form_submit()
    {

        $session = session();
        $UserUID = $session->get('id');
        $Lead = new LeadModel();
        $Crud = new Crud();
        $AgentUID = $this->request->getVar('agent_uid');
        $LeadCounter = $this->request->getVar('leads_counter');

        $AgentProjectsData = $Crud->ListRecords('main."UsersProject"', array('UserUID' => $AgentUID));
        if (count($AgentProjectsData) > 0) {
            $newleads = 0;
            foreach ($AgentProjectsData as $APD) {
                $AgentLeadsData = $Lead->GetAgentThresholdAndTotalNewAssignLeadsDataWithProjectUID($AgentUID, $APD['ProjectID']);
                $ThresholdValue = ((isset($AgentLeadsData['ThresholdValue']) && $AgentLeadsData['ThresholdValue'] != '') ? $AgentLeadsData['ThresholdValue'] : 0);
                if ($ThresholdValue != '' && $ThresholdValue > 0) {
                    $TotalAgentAssignLeads = ((isset($AgentLeadsData['TOTALLEADS']) && $AgentLeadsData['TOTALLEADS'] != '') ? $AgentLeadsData['TOTALLEADS'] : 0);
                    $RemainingLeads = (($TotalAgentAssignLeads > $ThresholdValue) ? 0 : ($ThresholdValue - $TotalAgentAssignLeads));
                    $RemainingLeads = (($LeadCounter > $RemainingLeads) ? $RemainingLeads : $LeadCounter);
                    if ($RemainingLeads > 0) {
                        $LeadsRecord = $Lead->GetAgentProjectsUnAssignLeadsData($AgentUID, 'ASC', $RemainingLeads, $APD['ProjectID']);
                        if (count($LeadsRecord) > 0) {
                            foreach ($LeadsRecord as $LD) {
                                $newleads++;
                                $Update = $Crud->UpdateRecord('sales."Leads"', array('UserID' => $AgentUID, 'LeadAssignmentDate' => date("Y-m-d H:i:s")), array('UID' => $LD['UID']));
                                if (isset($Update) && $Update == 1) {

                                    $ActivityArray = array(
                                        "SystemDate" => date("Y-m-d H:i:s"),
                                        "LeadsUID" => $LD['UID'],
                                        "UserUID" => $UserUID,
                                        "Activity" => 'Un Assign Lead Assign To Agent \'' . $AgentLeadsData['FullName'] . '\' ',
                                        "Visit" => '0'
                                    );
                                    $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
                                    BellNotification('New UnAssign added in (' . $AgentLeadsData['FullName'] . ') account', 'leads_unassign', $LD['UID'], $AgentUID);
                                }
                            }
                        }
                    }
                }
                $AgentName = $AgentLeadsData['FullName'];
            }

            if ($newleads > 0) {
                $result = array();
                $result['status'] = 'success';
                $result['message'] = ' \'' . $newleads . '\' Leads Successfully Assign to \'' . $AgentName . '\' ';
                echo json_encode($result);

            } else {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = ' \'' . $AgentName . '\' New Leads Already Assign, Please Select Another Agent ';
                echo json_encode($result);
            }

        } else {
            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'Project not assign to user ';
            echo json_encode($result);
        }

    }

    public function whatsapp_grabber()
    {
        $data = $this->data;

        echo view('header', $data);
        echo view('sales/lead/whatsapp_grabber', $data);
        echo view('footer', $data);

    }

    public function fetch_all_leads_record()
    {
        $Lead = new LeadModel();
        $DataArray = array();
        $cnt = $_POST['start'];
        $DataTableSearch = $_POST['search']['value'];
        $filterRecords = $Lead->GetAllLeadsRecords($DataTableSearch);
        $records = $Lead->GetAllLeadsRecords($DataTableSearch, $_POST['length'], $_POST['start']);

        foreach ($records as $value) {

            $actions = '';
            $actions .= '<a class="dropdown-item" href="javascript:void(0);" onclick="LoadModal(\'sales/lead/unassign/add_lead\',' . $value['UID'] . '  ,\'modal-lg\' )">Update</a>
                         <a class="dropdown-item" href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) . '" target="_blank">Activities</a>';

            $array = explode(",", $value['ProductName']);
            $ProductNameData = '';
            foreach ($array as $Record) {
                $ProductNameData .= '<badge class="badge badge-success">' . ucwords($Record) . '</badge>';
            }

            $cnt++;
            $subArray = array();
            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) . '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);
            $subArray[] = ucwords($value['SaleOfficer']);
            $subArray[] = DATEFORMAT($value['LeadAssignmentDate']);


            $subArray[] = ucwords($value['FullName']);
            $subArray[] = $ProductNameData;

            $subArray[] = ((isset($value['LeadCategory']) && $value['LeadCategory'] != '') ? '<badge class="badge badge-primary">' . $value['LeadCategory'] . '</badge>' : '-');
            $subArray[] = ((isset($value['Status']) && $value['Status'] != '') ? '<badge class="badge badge-success">' . ucwords(str_replace("_", ' ', $value['Status'])) . '</badge>' : '-');
            $subArray[] = '<div class="btn-group"> 
                                <button type="button" class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference1" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="will-change: transform;">' . $actions . '</div>
                        </div>';

            $DataArray[] = $subArray;
        }

        $output = array(
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => count($records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);

    }

    public function testdata()
    {
        $WhatsAppFieldData = $this->request->getVar('WhatsAppField');
        echo '<pre>';
        print_r($WhatsAppFieldData);
        exit;

        /*echo ' <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="table-responsive">
                        <table style="margin-bottom: 0px !important;" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Number</th>

                            </tr>
                            </thead>
                            <tbody id="LeadTrackingTableBody">
                            <tr>
                                <td>1</td>
                                <td>' . $name . '  </td>
                                <td>0345245615</td>


                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>';*/


    }

    public function fetch_product_based_lead()
    {
        $data = $this->data;
        $ProductName = $this->request->getVar('segment');


        $DomainID = $data['session']['domainid'];
        $lead = new LeadModel();

        $filterRecords = $lead->GetProductsStatsRecords($_REQUEST['search']['value'], $ProductName, $DomainID);
        $Records = $lead->GetProductsStatsRecords($_REQUEST['search']['value'], $ProductName, $DomainID, $_REQUEST['length'], $_REQUEST['start']);
//        echo "<pre>";
//        print_r($Records);exit;
        $cnt = $_REQUEST['start'];
        $DataArray = array();
        foreach ($Records as $value) {
            $cnt++;


            $subArray = array();

            $subArray[] = $cnt;
            $subArray[] = '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) . '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>';
            $subArray[] = DATEFORMAT($value['SystemDate']);
            $subArray[] = ucwords($value['FullName']);
            $subArray[] = ucwords($value['AgentName']);

            $subArray[] = '<badge class="badge badge-primary">' . $value['LeadCategory'] . '</badge>';
            $subArray[] = '<badge class="badge badge-success">' . ucwords(str_replace('_', ' ', $value['Status'])) . '</badge>';

            $DataArray[] = $subArray;

        }
        $output = array(
            "draw" => intval($_REQUEST["draw"]),
            "recordsTotal" => count($Records),
            "recordsFiltered" => count($filterRecords),
            "data" => $DataArray
        );
        echo json_encode($output);

    }


}