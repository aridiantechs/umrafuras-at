<?php namespace App\Controllers;

use App\Models\HRModel;
use App\Models\LeadModel;
use App\Models\Sales;
use App\Models\Agents;
use App\Models\BrnRecords;
use App\Models\Crud;
use App\Models\Main;
use App\Models\Groups;
use App\Models\MofaProcess;
use App\Models\Packages;
use App\Models\Pilgrims;
use App\Models\SaleAgent;
use App\Models\Users;
use App\Models\Api;
use App\Models\Voucher;
use App\Models\EmailCampaignModel;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;

class Html extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {


        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        $this->MainModel = new Main();
        //$this->data = $default = $this->MainModel->DefaultAjaxVariable();
        $this->data['path'] = PATH;
        $this->data['module'] = getSegment(1);
        $this->data['page'] = getSegment(2);
        $this->data['domain'] = getSegment(3);

        $SessionIgnor = array('GetCitiesDropdownByCountryCode');
        if (!in_array($this->data['page'], $SessionIgnor)) {
            $session = session();
            $this->MainModel->CheckUser($session->get());
        }
        helper('main');
    }

    public function load_modal()
    {
        $data = $this->data;
        $data['url'] = $this->request->getVar('url');
        $data['record_id'] = $this->request->getVar('record_id');

        $data['records'] = $this->modal_records($data['url'], $data['record_id']);
        echo view($data['url'], $data);
    }

    public function modal_records($url, $recordid)
    {
        $Records = array();

        switch ($url) {
            case 'agent/main_form';
                $Agents = new Agents();
                $Records['agent_profile'] = $Agents->AgentsProfile($recordid);
                $Records['agent_files'] = $Agents->AgentsProfileFiles($recordid);

                $SaleAgents = new SaleAgent();
                $Records['SaleAgents'] = $SaleAgents->ListSalesAgent();
                break;
            case 'user/main_form';
                $UsersData = new Users();
                $Records['user_profile'] = $UsersData->UsersProfile($recordid);
                $Records['user_meta'] = $UsersData->UsersMeta($recordid);
                break;

            case 'sales/main_form';
                $Saleofficer = new Sales();
                $Records['Users_record'] = $Saleofficer->getsaleofficer();
                break;
            case 'sales/lead/all_dashboard_models/fresh_leads_model';
                $lead = new LeadModel();
                $Records['Users_record'] = $lead->GetFreshLeads();
                break;

            case 'sales/lead/all_dashboard_models/today_follow_model';
                $lead = new LeadModel();
                $Records['Users_record'] = $lead->GetTodayFollowLeads();
                break;
            case 'human_resource/add_leave_model';
                $HrModel = new HRModel();
                $Records['Application_record'] = $HrModel->GetApplicationRecords($recordid);
                break;
            case 'sales/lead/all_dashboard_models/pending_followup_model';
                $lead = new LeadModel();
                $Records['Users_record'] = $lead->GetPendingFollowLeads();
                break;

            case 'sales/lead/all_dashboard_models/upcoming_followup_model';
                $lead = new LeadModel();
                $Records['Users_record'] = $lead->GetUpComingFollowUpLeads();
                break;

            case 'sales/lead/all_dashboard_models/leads_stats_model';
                $lead = new LeadModel();
                $Records['Users_record'] = $lead->GetLeadstatusByPram($recordid);
                $Records['Status_name'] = $recordid;
                break;

            case 'sales/staff/initial_training_staff';
                $initialtrainingdata = new Sales();
                $Records['InitialTrainingData'] = $initialtrainingdata::GetInitialTrainingDataByUID($recordid);
                break;

            case 'keys_main_form';
                $UsersData = new Users();
                $Records['user_profile'] = $UsersData->UsersProfile($recordid);
                $Records['user_meta'] = $UsersData->UsersMeta($recordid);
                $Records['saleagent_user_type'] = $UsersData->SaleAgentUsersType($recordid);
                $Records['externalagent_user_type'] = $UsersData->ExternalAgentUsersType($recordid);

                break;
            case 'group/main_form';
                $Group = new Groups();
                $Records['group_data'] = $Group->GroupsData($recordid);
                break;
            case 'user/operator/main_form';
                $Operator = new Users();
                $Records['operator_data'] = $Operator->OperatorsData($recordid);
                break;
            case 'setting/edit_websites_domain';
                $Operator = new Users();
                $Records['domains_data'] = $Operator->DomainsData($recordid);
                break;
            case 'lookups/main_form';
                $LookupData = new Main();
                $Records['lookups_data'] = $LookupData->LookupsData($recordid);
                break;
            case 'sales/email_campaign/all_email_models/manage_email_campaign_form';
                $Records['UID'] = $recordid;
                $EmailCampaigns = new EmailCampaignModel();
                $Records['email_campaigns_data'] = $EmailCampaigns->GetEmailCampaignsDataByID($recordid);
                break;
            case 'pilgrim/update_visa';
                //  $PilgrimData = new Pilgrims();
                //$Records['pilgrim_data'] = $PilgrimData->PilgrimsData($recordid);
                break;
            case 'agent/voucher/refund_voucher_modal';
                $PStatus = explode(":", $recordid);
                $recordid = $PStatus[0];
                $Vocuhers = new Voucher();
                $Records['recordid'] = $recordid;
                $Records['request_status'] = $PStatus[1];
                if ($Records['request_status'] == 'accommodation ') {
                    $Records['voucher_detail'] = $Vocuhers->VouchersForPilgrimsAllowHotelActivityByID($recordid);
                } else {
                    $Records['voucher_detail'] = $Vocuhers->VouchersForPilgrimsAllowTransportActivity($recordid);
                }
                break;
            case 'agent/voucher/services_ziyarat_refund_modal';

                $Vocuhers = new Voucher();
//                 $Records['services_list'] = $Vocuhers->VoucherServicesList($recordid);
//                $Records['ziyarats_list'] = $Vocuhers->VoucherZiyaratsList($recordid);
                break;
            case 'agent/sub_agent_main_form';
                $Agents = new Agents();
                $Records['agent_profile'] = $Agents->AgentsProfile($recordid);
                $Records['agent_files'] = $Agents->AgentsProfileFiles($recordid);
                $Records['AllAgents'] = $Agents->AllAgentList();


                $SaleAgent = new SaleAgent();
                $Records['SaleAgents'] = $SaleAgent->ListSalesAgent();
                break;
            case 'sales/staff/project_threshold';
                $Users = new Sales();
                $Main = new Main();
                $Records['StaffProjectsData'] = $Users->GetStaffProjectsDataByUID($recordid);
                $Records['ProjectsList'] = $Main->Products();

                $SaleAgent = new SaleAgent();
                $Records['SaleAgents'] = $SaleAgent->ListSalesAgent();
                break;

            case 'sales/lead/unassign/add_lead';
                $Records['UID'] = $recordid;
                $LeadsInfo = new LeadModel();
                $Records['leads_records'] = $LeadsInfo->LeadRecordByID($recordid);
                $Records['leads_meta'] = $LeadsInfo->LeadMetaRecordByID($recordid);
                $Records['leads_products'] = $LeadsInfo->LeadProductsRecordByID($recordid);
                break;

            case 'sales/add_organic_lead_form';
                $Records['UID'] = $recordid;
                $LeadsInfo = new LeadModel();
                $Records['OrganicLeads'] = $LeadsInfo->LeadRecordByID($recordid);
                $Records['LeadsMeta'] = $LeadsInfo->GetLeadsMetas($recordid);
                $Records['leads_products'] = $LeadsInfo->LeadProductsRecordByID($recordid);

                break;

            case 'sales/email_campaign/all_email_models/list_form';
                $Records['UID'] = $recordid;
                $EmailCampaigns = new EmailCampaignModel();
                $Records['email_list_records'] = $EmailCampaigns->GetEmailListDataByID($recordid);
                break;


            case 'lookups/lookup_options_form';
                $LookupOptionData = new Main();

                $Lookup = explode(":", $recordid);
                $Records['lookups_key'] = $Lookup[0];
                $Records['lookups_option_data'] = $LookupOptionData->LookupsOptionData($Lookup[1]);
                break;
            case 'languages/main_form';
                $LanguageData = new Main();
                $Records['language_data'] = $LanguageData->LanguagesData($recordid);
                break;
            case 'user/external_agent/main_form';
                $Agents = new Agents();
                $Records['agent_profile'] = $Agents->AgentsProfile($recordid);
                $Records['agent_files'] = $Agents->AgentsProfileFiles($recordid);

                $SaleAgent = new SaleAgent();
                $Records['SaleAgents'] = $SaleAgent->ListSalesAgent();

//                $ExternalData = new Agents();
//                $Records['external_agent_data'] = $ExternalData->ExternalAgentsData($recordid);
                break;
            case 'package/transport/main_form';
                $transportData = new Packages();
                $Records['transport_data'] = $transportData->TransportsData($recordid);
                $Records['transport_images'] = $transportData->TransportImages($recordid);
                break;
            case 'brn/use_brn_main_form';
                $AgentsModel = new Agents();
                $BRN = new BrnRecords();
                $Records['AllAgents'] = $AgentsModel->AllAgentList();
                $Records['BRNData'] = $BRN->BRNVisaDataByID($recordid);

                break;
            case 'brn/add_promo_code';
                $BRN = new BrnRecords();
                $Records['BRNPromoData'] = $BRN->BRNPromoDataByID($recordid);
                break;
            case 'package/hotel/main_form';
                $hotelData = new Packages();
                $Records['hotel_data'] = $hotelData->HotelsData($recordid);
                $Records['hotel_meta'] = $hotelData->HotelsMeta($recordid);
                $Records['hotel_images'] = $hotelData->HotelImages($recordid);
                break;
            case 'agent/voucher/log_history_modal';
                $Voucher = new Voucher();
                $Records['voucher_log'] = $Voucher->Voucherlog($recordid);
                break;
            case 'agent/voucher/change_voucher_status_modal';
                $Voucher = new Voucher();
                $Records['voucher_log'] = $Voucher->Voucherlog($recordid);
                break;
            case 'agent/voucher/voucher_remarks';
                $Voucher = new Voucher();
                $Records['UID'] = $recordid;
                $Records['voucher_remarks'] = $Voucher->VoucherRemarksMeta($recordid);
                $Records['PilgrimDetails'] = $Voucher->PilgrimDetails($recordid);

                break;
            case 'brn/transport_brn_main_form';
                $Packages = new Packages();
                $BRN = new BrnRecords();
                $Records['transports'] = $Packages->ListTransportByDomainID();
                $Records['hotels'] = $Packages->ListHotelsByDomainID();
                $Records['BRNData'] = $BRN->BRNDataByID($recordid);
                $Records['BRNPromoData'] = $BRN->ListBRNPromoCodeData();

                break;
            case 'mofa/upload_visa_form';
                $visaUpload = new MofaProcess();
                $Records['visa_upload_data'] = $visaUpload->VisaUploadData($recordid);
                break;
            case 'pilgrim/status/index';
                $PStatus = explode(":", $recordid);
                $recordid = $PStatus[0];
                $Records['request_status'] = $PStatus[1];
                $Records['reference_id'] = $PStatus[2];
                $Records['ActualParam'] = $PStatus[3];
                $Records['voucher_id'] = $recordid;

                $VoucherPilgrim = new Voucher();
                if ($Records['ActualParam'] == 'actual') {
                    $Records['voucher_pilgrim'] = $VoucherPilgrim->VoucherListPilgrimForStatus($recordid, $Records['request_status']);
                } else {
                    $Records['voucher_pilgrim'] = $VoucherPilgrim->VoucherListPilgrimWithoutStatus($recordid);
                }
                break;
            case 'load_ip_api';
                $Api = new Api();
                //$Records['JSON'] = $Api->TrackIP('101.50.109.1');
                $Records['JSON'] = $Api->TrackIP($recordid);
                break;
            case 'sale_agents/main_form';
                $SaleAgents = new SaleAgent();
                $Records['agent_profile'] = $SaleAgents->SaleAgentsProfile($recordid);
                break;

            case 'brn/hotel_brn_main_form';
                $Packages = new Packages();
                $BRN = new BrnRecords();
                $Records['transports'] = $Packages->ListTransportByDomainID();
                $Records['hotels'] = $Packages->ListHotelsByDomainID();
                $Records['BRNData'] = $BRN->BRNDataByID($recordid);
                $Records['BRNPromoData'] = $BRN->ListBRNPromoCodeData();
                break;
            case'setting/calender/add';
                $Main = new Main();
                $Records['CalenderData'] = $Main->GetCalenderDataByID($recordid);
                break;
            case'sales/lead/callback/lead_status';
                $Crud = new Crud();
                $Records['LeadRecord'] = $Crud->SingleRecord('sales."Leads"', array('UID' => $recordid));
                break;
            case'sales/lead/callback/lead_assignment';
                $Crud = new Crud();
                $Records['LeadRecord'] = $Crud->SingleRecord('sales."Leads"', array('UID' => $recordid));
                break;

        }
        return $Records;
    }

    public function GetCitiesDropdownByCountryCode()
    {
        helper('main');
        $CountryCode = $this->request->getVar('country');
        $selected = $this->request->getVar('selected');
        $response['status'] = "success";
        $response['html'] = Cities($CountryCode, $datatype = 'html', $selected);
        echo json_encode($response);
    }


    public function GetHotelsByCity()
    {
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $response['status'] = "success";
        $response['html'] = $this->HotelsByCity($city, $datatype = 'html', $selected);
        echo json_encode($response);
    }

    function HotelsByCity($city, $datatype = 'records', $selected = '')
    {
        $Crud = new Crud();
        $table = 'packages."Hotels"';
        $options = $Crud->ListRecords($table, array("CityID" => $city), array("Name" => 'ASC'));
        $final = array();
        $final['records'] = $options;
        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['Name'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }

    public function GetAgentsByCountry()
    {
        $CountryCode = $this->request->getVar('country');
        $selected = $this->request->getVar('selected');
        $response['status'] = "success";
        $response['html'] = $this->AgentsByCountry($CountryCode, $datatype = 'html', $selected);
        echo json_encode($response);
    }

    function AgentsByCountry($CountryCode, $datatype = 'records', $selected = '')
    {
        $Crud = new Crud();
        $table = 'main."Agents"';
        $options = $Crud->ListRecords($table, array("CountryID" => $CountryCode), array("FullName" => 'ASC'));
        $final = array();
        $final['records'] = $options;
        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '" ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['FullName'] . '</option>';
        }
        $final['html'] = $HTML;

        return $final[$datatype];
    }

    public function GetStartEndDates()
    {
        helper('main');
        $ArrivalReturn = $this->request->getVar('ArrivalReturn');

        $Date = MultiDate($ArrivalReturn);
        $StartDate = $Date['start'];
        $EndDate = $Date['end'];


        $response['StartDate'] = date('Y-m-d', strtotime($StartDate));
        $response['EndDate'] = date('Y-m-d', strtotime($EndDate));
        echo json_encode($response);
    }

    public function GetSystemUsersDropdownByAccountType()
    {
        $Crud = new Crud();
        helper('main');
        $session = session();
        $session = $session->get();

        $type = $this->request->getVar('type');
        $selected = $this->request->getVar('selected');

        if ($type == 'mis') {
            $table = 'main."Users"';
            if ($session['type'] == 'admin' && $session['logged_type'] == 'user') {
                $WhereArray = array('DomainID' => $session['domainid'], 'Archive' => 0);
            } else {
                $WhereArray = array('UserType !=' => 'admin', 'DomainID' => $session['domainid'], 'Archive' => 0);
            }
            $options = $Crud->ListRecords($table, $WhereArray, array("FullName" => 'ASC'));
        } else if ($type == 'external_agent') {
            $table = 'main."Agents"';
            $options = $Crud->ListRecords($table, array("WebsiteDomain" => $session['domainid'], "Archive" => 0, "Type" => 'external_agent'), array("FullName" => 'ASC'));
        } else if ($type == 'sub_agent') {
            $table = 'main."Agents"';
            $options = $Crud->ListRecords($table, array("WebsiteDomain" => $session['domainid'], "Archive" => 0, "Type" => 'sub_agent'), array("FullName" => 'ASC'));
            //  print_r($options);exit;
        } else if ($type == 'agent') {
            $table = 'main."Agents"';
            $options = $Crud->ListRecords($table, array("WebsiteDomain" => $session['domainid'], "Archive" => 0, "Type" => 'agent'), array("FullName" => 'ASC'));
        } else if ($type == 'sale_agent') {
            $table = 'sale_agent."Agents"';
            $options = $Crud->ListRecords($table, array("WebsiteDomain" => $session['domainid'], "Archive" => 0), array("FullName" => 'ASC'));
        }

        $HTML = '';
        foreach ($options as $option) {
            $HTML .= '<option value="' . $option['UID'] . '"  ' . (($selected == $option['UID']) ? 'selected' : '') . '>' . $option['FullName'] . '</option>';
        }


        $response['status'] = "success";
        $response['html'] = $HTML;

        echo json_encode($response);
    }


    public function GetHotelDropdownByCity()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $Packages = new Packages();
        $hotels = $Packages->ListHotelsByCityID($city);

//        $CRUD = new Crud();
//        $hotels = $CRUD->ListRecords('packages."Hotels"', array("CityID" => $city), array("Name" => 'ASC'));
        $HTML = '';
        foreach ($hotels as $hotel) {
            $HTML .= '<option value="' . $hotel['UID'] . '"' . (($selected == $hotel['UID']) ? 'selected' : '') . ' >' . $hotel['Name'] . '</option>';
        }

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }

    public function GetHotelCategoryDropdownByCity()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $CatID = $this->request->getVar('CatID');
        $selected = $this->request->getVar('selected');
        $Packages = new Packages();
        $hotels = $Packages->ListHotelsCategoryByCityID($city, $CatID);

//        $CRUD = new Crud();
//        $hotels = $CRUD->ListRecords('packages."Hotels"', array("CityID" => $city), array("Name" => 'ASC'));
        $HTML = '';
        foreach ($hotels as $hotel) {
            $HTML .= '<option value="' . $hotel['UID'] . '"' . (($selected == $hotel['UID']) ? 'selected' : '') . ' >' . $hotel['Name'] . '</option>';
        }

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }

    public function GetBRNAccordingToType()
    {
        helper('main');
        $type = $this->request->getVar('type');
        $selected = $this->request->getVar('selected');
        $CRUD = new Crud();
        $BRNS = $CRUD->ListRecords('BRN."brn"', array("BRNType" => $type), array("BRNCode" => 'ASC'));
        $HTML = '';
        foreach ($BRNS as $BRN) {
            $HTML .= '<option value="' . $BRN['UID'] . '"' . (($selected == $BRN['UID']) ? 'selected' : '') . ' >' . $BRN['BRNCode'] . '</option>';
        }

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }

    public function GetHotelDropdownByCityByPackageId()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $CRUD = new Crud();

        $SQL = 'SELECT DISTINCT "main"."LookupsOptions"."Name" as "HotelCategory", "packages"."Hotels".*
                FROM "packages"."Hotels"
                LEFT JOIN "packages"."HotelsRate" ON "packages"."HotelsRate"."HotelUID" = "packages"."Hotels"."UID"
                LEFT JOIN "main"."LookupsOptions" ON "main"."LookupsOptions"."UID" = CAST("packages"."Hotels"."Category" as INT)
                WHERE "packages"."Hotels"."CityID" = ' . $city . ' AND "packages"."HotelsRate"."PackageUID" = ' . $PackagesUID . '
                ORDER BY "packages"."Hotels"."Name" ';

        // echo $SQL;
        $hotels = $CRUD->ExecuteSQL($SQL);

        $HTML = '';
        foreach ($hotels as $hotel) {
            $HTML .= '<option value="' . $hotel['UID'] . '"' . (($selected == $hotel['UID']) ? 'selected' : '') . ' >' . $hotel['Name'] . ' (' . $hotel['HotelCategory'] . ')</option>';
        }

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);


    }


    public function GetSelfHotelDropdownByCity()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $CRUD = new Crud();
        $hotels = $CRUD->ListRecords('packages."OtherHotels"', array("CityID" => $city), array("Name" => 'ASC'));
        $HTML = '<option value="">Please Select</option>';
        foreach ($hotels as $hotel) {
            $HTML .= '<option value="' . $hotel['UID'] . '"' . (($selected == $hotel['UID']) ? 'selected' : '') . ' >' . $hotel['Name'] . '</option>';
        }
        $HTML .= '<option value="Other">Other</option>';

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }

    public function GetSelfHotelDropdownByCityForActivity()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $CRUD = new Crud();
        $hotels = $CRUD->ListRecords('packages."OtherHotels"', array("CityID" => $city), array("Name" => 'ASC'));
        $HTML = '<option value="0">Same As Package Hotel</option>';
        foreach ($hotels as $hotel) {
            $HTML .= '<option value="' . $hotel['UID'] . '"' . (($selected == $hotel['UID']) ? 'selected' : '') . ' >' . $hotel['Name'] . '</option>';
        }
        $HTML .= '<option value="Other">Other</option>';

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }


    public function GetHotelDropdownByPackageCity()
    {
        $city = $this->request->getVar('city');
        $agentid = $this->request->getVar('agentid');
        $CRUD = new Crud();
        $data['pkgid'] = $CRUD->SingleRecord('packages."Packages"', array("AgentUID" => $agentid));

        $records = $CRUD->ListRecords('packages."HotelsRate"', array("PackageUID" => $data['pkgid']['UID']));

        $AvavilableHotel = array();
        foreach ($records as $record) {
            //$ids[] = $record;
            $hotels = $CRUD->SingleRecord('packages."Hotels"', array("UID" => $record['HotelUID']));
            $AvavilableHotel[$record['HotelUID']] = $hotels['Name'];

        }

        $HTML = '';
        foreach ($AvavilableHotel as $hotelK => $hotelV) {
            $HTML .= '<option value="' . $hotelK . '">' . $hotelV . '</option>';
        }
        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }


    public function GetZiaratDropdownByCity()
    {
        helper('main');
        $city = $this->request->getVar('city');
        $selected = $this->request->getVar('selected');
        $CRUD = new Crud();
        $ziarats = $CRUD->ListRecords('packages."Ziyarats"', array("CityID" => $city), array("Name" => 'ASC'));
        $HTML = '';
        foreach ($ziarats as $ziarat) {
            $HTML .= '<option value="' . $ziarat['UID'] . '"' . (($selected == $ziarat['UID']) ? 'selected' : '') . '>' . $ziarat['Name'] . '</option>';
        }

        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }


    public function GetTransportRatesByPackageID()
    {
        helper('main');
        $TransportID = $this->request->getVar('TransportID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."TransportRate"', array("PackageUID" => $PackagesUID, "TransportTypeUID" => $TransportID));
        $TransportRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $HTML = Money($TransportRate);
        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $TransportRate;
        echo json_encode($response);
    }

    public function GetTransportRatesByPackageUpdate()
    {
        helper('main');
        $TransportRate = 0;
        $TransportID = $this->request->getVar('TransportID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $NoOfSeat = $this->request->getVar('NoOfSeat');
        $NoOfSeat = ((isset($NoOfSeat) && $NoOfSeat != '') ? $NoOfSeat : 0);

        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."TransportRate"', array("PackageUID" => $PackagesUID, "TransportTypeUID" => $TransportID));
        $TransportRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $Ra = $TransportRate * $NoOfSeat;
        $HTML = Money($Ra) . "<br>" . Money($TransportRate) . " / Individual Amount";
        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $TransportRate;
        echo json_encode($response);
    }

    public function GetTransportRatesByPackageIDForGroup()
    {
        helper('main');
        $TransportRate = 0;
        $TransportID = $this->request->getVar('TransportID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $NoOfSeat = $this->request->getVar('NoOfSeat');
        $NoOfSeat = ((isset($NoOfSeat) && $NoOfSeat != '') ? $NoOfSeat : 0);

        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."TransportRate"', array("PackageUID" => $PackagesUID, "TransportTypeUID" => $TransportID));
        //$HTML = Money($Rate['Rate']);
        //$Ra = $Rate['Rate'] * $NoOfSeat;

        $TransportRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);
        $Ra = $TransportRate * $NoOfSeat;
        $HTML = Money($Ra) . "<br>" . Money($TransportRate) . " / Individual Amount";
        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $TransportRate;
        echo json_encode($response);
    }

    public function GetZiyaratRatesByPackageID()
    {
        helper('main');
        $ZiyaratRate = 0;
        $Ziyarat = $this->request->getVar('Ziarat');
        $TransportsID = $this->request->getVar('TransportsID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."ZiyaratsRate"', array("PackageUID" => $PackagesUID, "ZiyaratsUID" => $Ziyarat, "TransportTypeUID" => $TransportsID));
        $ZiyaratRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $HTML = Money($ZiyaratRate);
        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $ZiyaratRate;
        echo json_encode($response);
    }

    public function GetZiyaratRatesByPackageUpdate()
    {
        helper('main');
        $Ziyarat = $this->request->getVar('Ziarat');
        $TransportsID = $this->request->getVar('TransportsID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfPax = ((isset($NoOfPax) && $NoOfPax != '') ? $NoOfPax : 0);

        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."ZiyaratsRate"', array("PackageUID" => $PackagesUID, "ZiyaratsUID" => $Ziyarat, "TransportTypeUID" => $TransportsID));
        $ZiyaratRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $Ra = $ZiyaratRate * $NoOfPax;
        $HTML = Money($Ra) . "<br>" . Money($ZiyaratRate) . " / Individual Amount";
//        $HTML = Money($Rate['Rate']);
        // $Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $ZiyaratRate;
        echo json_encode($response);
    }

    public function GetZiyaratRatesByPackageIDForGroup()
    {
        helper('main');
        $ZiyaratRate = 0;
        $Ziyarat = $this->request->getVar('Ziarat');
        $TransportsID = $this->request->getVar('TransportsID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfPax = ((isset($NoOfPax) && $NoOfPax != '') ? $NoOfPax : 0);

        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."ZiyaratsRate"', array("PackageUID" => $PackagesUID, "ZiyaratsUID" => $Ziyarat, "TransportTypeUID" => $TransportsID));
        $ZiyaratRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $Ra = $ZiyaratRate * $NoOfPax;

        $HTML = Money($Ra) . "<br>" . Money($ZiyaratRate) . " / Individual Amount";
        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $ZiyaratRate;
        echo json_encode($response);
    }

    public function GetZiyaratRatesByPackageIDForGroupUpdate()
    {
        helper('main');
        $Ziyarat = $this->request->getVar('Ziarat');
        $TransportsID = $this->request->getVar('TransportsID');
        $PackagesUID = $this->request->getVar('PackagesUID');
        $NoOfPax = $this->request->getVar('NoOfPax');
        $NoOfPax = ((isset($NoOfPax) && $NoOfPax != '') ? $NoOfPax : 0);

        $CRUD = new Crud();
        $Rate = $CRUD->SingleRecord('packages."ZiyaratsRate"', array("PackageUID" => $PackagesUID, "ZiyaratsUID" => $Ziyarat, "TransportTypeUID" => $TransportsID));
        $ZiyaratRate = ((isset($Rate['Rate']) && $Rate['Rate'] != '') ? $Rate['Rate'] : 0);

        $Ra = $ZiyaratRate * $NoOfPax;
        $HTML = Money($Ra) . "<br>" . Money($ZiyaratRate) . " / Individual Amount";
        //$HTML = Money($Rate['Rate']);

        //$Rate = $Rate['Rate'];
        $response['status'] = "success";
        $response['html'] = $HTML;
        $response['rate'] = $ZiyaratRate;
        echo json_encode($response);
    }

    public function GetContentUpdateTab()
    {
        helper('main');
        $UID = $this->request->getVar('UID');
        $segment = $this->request->getVar('segment');
        $ReadOnly = ($segment > 0) ? "readonly" : "";
        $CRUD = new Crud();
        $Contents = array();
        $Contents = $CRUD->SingleRecord('websites."contents"', array("UID" => $UID));
        $HTML = '';
        if (count($Contents) > 0) {
            $FooterYes = ($Contents['ShowOnFooter'] == 1) ? "selected" : "";
            $FooterNo = ($Contents['ShowOnFooter'] == 0) ? "selected" : "";
            $HTML .= '<form enctype="multipart/form-data" class="validate" method="post" action="#" id="PagesUpdateForm" name="PagesUpdateForm">
                <input type="hidden" name="UID" value="' . $Contents['UID'] . '">
                <input type="hidden" name="DomainID" value="' . $Contents['DomainID'] . '">
                <div class="col-md-12 mx-auto">
                    <h3 class="mb-4">SEO</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="FullName">Page Physical</label>
                                <input ' . $ReadOnly . ' type="text" class="form-control" id="Name"
                                       name="physical" placeholder="Page Physical"
                                       value="' . $Contents['PagePhysical'] . '">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="SeoTitle"
                                       name="SeoTitle" placeholder="SEO Title"
                                       value="' . $Contents['SeoTitle'] . '">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="FullName">Meta Description</label>
                                <textarea class="form-control" name="MetaDesc" id="MetaDesc" rows="3">' . $Contents['SeoDescription'] . '</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label for="FullName">Meta Keywords</label>
                                <textarea class="form-control" name="MetaKeywords" id="MetaKeywords" rows="3">' . $Contents['SeoMetaKeywords'] . '</textarea>
                            </div>
                        </div>
                    </div>
                    <h3 class="mb-4">Content</h3>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group mb-4">
                                <label for="FullName">Title</label>
                                <input type="text" class="form-control" id="contentTitle"
                                       name="contentTitle" placeholder="Title"
                                       value="' . $Contents['Title'] . '">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="country">Show On Footer</label>
                                <select class="form-control select2" id="showOnFooter"
                                        name="showOnFooter">
                                    <option value="">Please Select</option>
                                    <option value="0" ' . $FooterNo . '>No</option>
                                    <option value="1" ' . $FooterYes . '>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label for="FullName">Description</label>
                                <textarea id="Description"
                                          name="Description">' . $Contents['Description'] . '</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="" id="PagesUpdateResponse"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button type="button" class="btn btn-primary" onclick="PagesUpdateFormSubmit();">Update</button>
                </div>
            </form>';
            $response['status'] = "success";
            $response['html'] = $HTML;
        } else {
            $response['status'] = "fail";
            $response['html'] = "";
        }
        echo json_encode($response);
    }

    public function GetVoucherPilgrimGrid()
    {
        helper('main');
        $data = $this->data;


        $id = $this->request->getVar('id');
        $vid = $this->request->getVar('vid');
        //echo 'VID------'.$vid;
        $VouchersData = new Voucher();
        $Group = new Groups();
        $data['records']['pilgrims'] = $VouchersData->VoucherPilgrimListByAgentID($id, $vid);

        $voucher_pilgrims = $VouchersData->VoucherPilgrimDataByID($vid);
        $pilgrim_ids = array();
        $pilgrim_leader = array();
        foreach ($voucher_pilgrims as $voucher_pilgrim) {
            $pilgrim_ids[] = $voucher_pilgrim['PilgrimUID'];
            if ($voucher_pilgrim['Leader'] == 1) {
                $pilgrim_leader[] = $voucher_pilgrim['PilgrimUID'];
            }
        }
        //echo '<pre>'; print_r($pilgrim_ids);
        $data['records']['voucher_pilgrims'] = $pilgrim_ids;
        $data['records']['voucher_pilgrim_leader'] = $pilgrim_leader;

        $data['PackageID'] = $VouchersData->LoadPackageIDByAgent($id);
//        print_r($data['PackageID']);


        $HTML = view('agent/voucher/voucher_pilgrim_grid', $data);
        $PackageID = $data['PackageID']['UID'];
        $PackageName = $data['PackageID']['Name'];

        if (isset($PackageID)) {
            $Button = '<a class="btn btn_customized  btn-sm float-right" href="' . SeoUrl('exports/b2b_package/' . $PackageID . "-" . $PackageName) . '" target="_blank">Export Package   </a>';

        } else {
            $Button = '';
        }

        $extra_services = $VouchersData->VoucherServiceData($vid);
        $ServiceID = array();
        foreach ($extra_services as $extra_service) {
            $ServiceID[] = $extra_service['ServiceID'];
        }
        $data['records']['extra_services'] = $ServiceID;

        $Extra = new Voucher();
        $data['ExtrasGrid'] = $Extra->ExtraGridDataByPackageID($PackageID);

        $ServicesGrid = view('agent/voucher/voucher_service_grid', $data);;
        $Vouchercode = VoucherCode('UF/V/A' . $id . '/', $id);

        $VisaDetails = $Group->PackageVisaRates($PackageID);

        $Visa = '';
        foreach ($VisaDetails as $VisaDetail) {
            $Visa .= '<option value="' . $VisaDetail['LookupOptionID'] . '">' . $VisaDetail['LookupName'] . '  </option>';
        }


        $response['status'] = "success";
        $response['total_pilgrim'] = count($data['records']['pilgrims']);
        $response['html'] = $HTML;
        $response['services_html'] = $ServicesGrid;
        $response['package_id'] = $PackageID;
        $response['VoucherCode'] = $Vouchercode;
        $response['export_button'] = $Button;
        $response['Visa'] = $Visa;

        echo json_encode($response);
    }


    public function GetB2CVoucherPilgrimGrid()
    {
        helper('main');
        $data = $this->data;


        $B2CPakageID = $this->request->getVar('B2CPakageID');
//        $id = $this->request->getVar('id');
        $vid = $this->request->getVar('vid');
        //echo 'VID------'.$vid;
        $VouchersData = new Voucher();
        $CRUD = new Crud();
        $Group = new Groups();
        $data['records']['pilgrims'] = $VouchersData->PilgrimWithoutVoucherList();

        $voucher_pilgrims = $VouchersData->VoucherPilgrimDataByID($vid);
        $pilgrim_ids = array();
        $pilgrim_leader = array();
        foreach ($voucher_pilgrims as $voucher_pilgrim) {
            $pilgrim_ids[] = $voucher_pilgrim['PilgrimUID'];
            if ($voucher_pilgrim['Leader'] == 1) {
                $pilgrim_leader[] = $voucher_pilgrim['PilgrimUID'];
            }
        }
        //echo '<pre>'; print_r($pilgrim_ids);
        $data['records']['voucher_pilgrims'] = $pilgrim_ids;
        $data['records']['voucher_pilgrim_leader'] = $pilgrim_leader;


        $data['PackageID'] = $CRUD->SingleRecord('packages."Packages"', array("UID" => $B2CPakageID));

//

        $HTML = view('agent/voucher/voucher_pilgrim_grid', $data);
        $PackageID = $data['PackageID']['UID'];
        $PackageName = $data['PackageID']['Name'];

        if (isset($PackageID)) {
            $Button = '<a class="btn btn_customized  btn-sm float-right" href="' . SeoUrl('exports/b2c_package/' . $PackageID . "-" . $PackageName) . '" target="_blank">Export Package   </a>';

        } else {
            $Button = '';
        }

        $extra_services = $VouchersData->VoucherServiceData($vid);
        $ServiceID = array();
        foreach ($extra_services as $extra_service) {
            $ServiceID[] = $extra_service['ServiceID'];
        }
        $data['records']['extra_services'] = $ServiceID;

        $Extra = new Voucher();
        $data['ExtrasGrid'] = $Extra->ExtraGridDataByPackageID($PackageID);

        $ServicesGrid = view('agent/voucher/voucher_service_grid', $data);;
        $Vouchercode = 'UF/V/B2C/' . $B2CPakageID;

        $VisaDetails = $Group->PackageVisaRates($PackageID);

        $Visa = '';
        foreach ($VisaDetails as $VisaDetail) {
            $Visa .= '<option value="' . $VisaDetail['LookupOptionID'] . '">' . $VisaDetail['LookupName'] . '  </option>';
        }


        $response['status'] = "success";
        $response['total_pilgrim'] = count($data['records']['pilgrims']);
        $response['html'] = $HTML;
        $response['services_html'] = $ServicesGrid;
        $response['package_id'] = $PackageID;
        $response['VoucherCode'] = $Vouchercode;
        $response['export_button'] = $Button;
        $response['Visa'] = $Visa;

        echo json_encode($response);
    }


    public function GetGroupByAgentID()
    {
        helper('main');
        $data = $this->data;

        $id = $this->request->getVar('id');
        $selected = $this->request->getVar('selected');

        $Group = new Groups();
        $Groups = $Group->GroupByAgentId($id);

        $GroupHtml = '';
        foreach ($Groups as $Group) {
            $GroupHtml .= '<option value="' . $Group['UID'] . '"' . (($selected == $Group['UID']) ? 'selected' : '') . '>' . $Group['FullName'] . '  </option>';
        }


        $response['status'] = "success";
        $response['grouphtml'] = $GroupHtml;

        echo json_encode($response);
    }

    public function GetGroupPilgrimGrid()
    {
        helper('main');
        $data = $this->data;

        $id = $this->request->getVar('id');
        $GroupId = $this->request->getVar('GroupId');
        $Selectedvisa = $this->request->getVar('Selectedvisa');
        $GroupsData = new Groups();

        $VouchersData = new Voucher();

        $data['PackageID'] = $VouchersData->LoadPackageIDByAgent($id);

        $PackageID = $data['PackageID']['UID'];
        $PackageName = $data['PackageID']['Name'];

        if (isset($PackageID)) {
            $Button = '<a class="btn btn_customized  btn-sm float-right" href="' . SeoUrl('exports/b2b_package/' . $PackageID . "-" . $PackageName) . '" target="_blank">Export Package   </a>';
        } else {
            $Button = '';
        }
        $extra_services = $GroupsData->GroupServiceData($GroupId);
        $ServiceID = array();
        foreach ($extra_services as $extra_service) {
            $ServiceID[] = $extra_service['ServiceID'];
        }
        $data['records']['extra_services'] = $ServiceID;

        $VisaDetails = $GroupsData->PackageVisaRates($PackageID);

        $Visa = '<option value="" >Please Select</option>';
        foreach ($VisaDetails as $VisaDetail) {
            $Visa .= '<option value="' . $VisaDetail['LookupOptionID'] . '"  ' . (($Selectedvisa == $VisaDetail['LookupOptionID']) ? 'selected' : '') . '>' . $VisaDetail['LookupName'] . '  </option>';
        }

        $Extra = new Voucher();
        $data['ExtrasGrid'] = $Extra->ExtraGridDataByPackageID($PackageID);

        $ServicesGrid = view('group/group_services_grid', $data);

        $response['status'] = "success";
        $response['services_html'] = $ServicesGrid;
        $response['package_id'] = $PackageID;
        $response['export_button'] = $Button;
        $response['Visa'] = $Visa;

        echo json_encode($response);
    }


    public function GetContentMetaTab()
    {
        helper('main');
        $data = $this->data;
        $Contents = array();
        $data['Slug'] = $this->request->getVar('key');
        $data['DomainID'] = $this->request->getVar('domain');
        $CRUD = new Crud();
        $Contents = $CRUD->ListRecords('websites."contents_meta"', array("PagePhysical" => $data['Slug']));
        if (count($Contents) > 0) {
            foreach ($Contents as $ThisData) {
                $Contents[$ThisData['Key']] = $ThisData['Description'];
            }
        }
        $data['Contents'] = $Contents;
        $HTML = view('websites/cms/Meta_' . strtolower($data['Slug']), $data);
        $response['status'] = "success";
        $response['html'] = $HTML;
        echo json_encode($response);
    }

    public function GetBRNDropdownByType()
    {
        helper('main');
        $brntype = $this->request->getVar('brntype');

        $response = array();
        $response['status'] = "success";
        $response['html'] = GetBrnListByType($datatype = 'html', $brntype);
        echo json_encode($response);
    }


}
