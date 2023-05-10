<?php namespace App\Models;

use App\Controllers\Home;
use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;
use Faker\Guesser\Name;


class LeadModel extends Model
{
    var $data = array();
    var $MainModel;


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $session = session();
        $session = $session->get();
        $this->data['session'] = $session;
    }

    public function save_leads_data($records, $Meta, $ProductMeta, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();

        $table = 'sales."Leads"';
        if ($UID == 0) {

            $SQLContactValidate = 'SELECT * FROM "sales"."Leads"  WHERE "ContactNo" = \'' . trim($records['ContactNo']) . '\' AND "ContactNo" != \'\'';
            $SQLWhatsappValidate = 'SELECT * FROM "sales"."Leads" WHERE "WhatsAppNo" = \'' . trim($records['WhatsAppNo']) . '\' AND "ContactNo" != \'\'';

            $ValidateContact = $Crud->ExecuteSQL($SQLContactValidate);
            $ValidateWhatsApp = $Crud->ExecuteSQL($SQLWhatsappValidate);

            if (count($ValidateContact) > 0 && count($ValidateWhatsApp) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "Contact No And WhatsApp Number Already Exist";
                echo json_encode($response);
            } else if (count($ValidateContact) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "Contact Number Already Exist";
                echo json_encode($response);
            } else if (count($ValidateWhatsApp) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "WhatsApp Number Already Exist";
                echo json_encode($response);
            } else {
                $InsertUID = $Crud->AddRecord($table, $records);
                $response['status'] = "success";
                $response['message'] = "Lead Successfully Added";
                echo json_encode($response);

            }

        } else {

            $UpdateSQLContactValidate = 'SELECT "sales"."Leads".* 
                                            FROM "sales"."Leads"  
                                            WHERE "ContactNo" = \'' . trim($records['ContactNo']) . '\' AND "ContactNo" != \'\' 
                                            AND "sales"."Leads"."UID" != ' . $UID . ' LIMIT 1 ';

            $UpdateSQLWhatsappValidate = 'SELECT "sales"."Leads".* 
                                            FROM "sales"."Leads" 
                                            WHERE "WhatsAppNo" = \'' . trim($records['WhatsAppNo']) . '\' AND "ContactNo" != \'\'
                                            AND "sales"."Leads"."UID" != ' . $UID . ' LIMIT 1 ';

            $UpdateValidateContact = $Crud->ExecuteSQL($UpdateSQLContactValidate);
            $UpdateValidateWhatsApp = $Crud->ExecuteSQL($UpdateSQLWhatsappValidate);


            if (count($UpdateValidateContact) > 0 && count($UpdateValidateWhatsApp) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "Contact No And WhatsApp Number Already Assign to \"" . $UpdateValidateContact[0]['FullName'] . "\" ";
                echo json_encode($response);
            } else if (count($UpdateValidateContact) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "Contact Number Already Assign to \"" . $UpdateValidateContact[0]['FullName'] . "\" ";
                echo json_encode($response);
            } else if (count($UpdateValidateWhatsApp) > 0) {
                $response['status'] = 'fail';
                $response['message'] = "WhatsApp Number Already Assign to \"" . $UpdateValidateWhatsApp[0]['FullName'] . "\" ";
                echo json_encode($response);
            } else {

                $where = array("UID" => $UID);
                $Crud->UpdateRecord($table, $records, $where);
                $response['status'] = "success";
                $response['message'] = "Lead Updated Successfully";
                echo json_encode($response);
            }
        }

        foreach ($Meta as $MetaKs => $MetaV) {
            if ($MetaV != '') {
                $table = 'sales."LeadsMeta"';
                $where = array("LeadID" => (($UID) > 0 ? $UID : $InsertUID), "Options" => $MetaKs);
                $MetaK = $Crud->SingleRecord($table, $where);
                if (!isset($MetaK['UID'])) {
                    $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $InsertUID), "Options" => $MetaKs, "Value" => $MetaV));
                } else {
                    ///////////// update
                    $wheres = array("LeadID" => $UID, "Options" => $MetaKs);
                    $Crud->DeleteRecord($table, $wheres);
                    $Crud->AddRecord($table, array("LeadID" => $UID, "Options" => $MetaKs, "Value" => $MetaV));
                }
            }

        }

        $table = 'sales."LeadsProduct"';
        $ProductsWheres = array("LeadID" => $UID);
        $Crud->DeleteRecord($table, $ProductsWheres);
        foreach ($ProductMeta as $MetaKs => $MetaV) {
            if ($MetaV > 0) {

                $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $InsertUID), "ProductName" => $MetaKs));

                /*$where = array("LeadID" => (($UID) > 0 ? $UID : $InsertUID), "ProductName" => $MetaKs);
                $MetaK = $Crud->SingleRecord($table, $where);
                if (!isset($MetaK['UID'])) {
                    $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $InsertUID), "ProductName" => $MetaKs));
                } else {
                    $Crud->AddRecord($table, array("LeadID" => $UID, "ProductName" => $MetaKs));
                }*/
            }

        }
    }

    public function save_leads_meta($records)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."LeadsMeta"';
        $LeadMetaID = $Crud->AddRecord($table, $records);
        return $LeadMetaID;

    }

    public
    function ManualFileImporterFormSubmit($Record, $Meta)
    {

        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');
        $UploadedRecordCounter = 0;
        if (count($Record) > 0) {

            $db = db_connect();
            $builder = $db->table('sales."Leads"');
            $Category = $Record['LeadCategory'];
            /** Check Lead Exist in Table With Same Contact No **/


            $final = array();
            if ($Record['ContactNo'] != '') {
                $final[] = $Record['ContactNo'];
            }
            if ($Record['WhatsAppNo'] != '') {
                $final[] = $Record['WhatsAppNo'];
            }
            if ($Meta['MobileNumber1'] != '') {
                $final[] = $Meta['MobileNumber1'];
            }


            $CheckDuplicate = LeadDuplicateCheck($Category, $final);
            if (isset($CheckDuplicate) && $CheckDuplicate == 1) {

            } else {
                $db->transStart();
                if ($builder->insert($Record)) {
                    $LeadUID = $db->insertID();
//                    echo $db->showLastQuery();
                    $db->transComplete();
                    $db->close();
                    $UploadedRecordCounter++;
                    $table = 'sales."LeadsMeta"';
                    foreach ($Meta as $option => $value) {
                        $MetaData = array();
                        $MetaData['LeadID'] = $LeadUID;
                        $MetaData['Options'] = $option;
                        $MetaData['Value'] = $value;
                        if ($value != '') {
                            $Crud->AddRecord($table, $MetaData);
                        }
                    }

                    if ($Record['Agent'] > 0) {
                        $Activity = " New Lead Added! ";
                    } else if ($Record['Agent'] == 0) {
                        $Activity = " New \"Un-Authorized\" Lead Added With Agent 0 ";
                    }
                    $ActivityArray = array(
                        "SystemDate" => date("Y-m-d H:i:s"),
                        "LeadsUID" => $LeadUID,
                        "UserUID" => $UserUID,
                        "Activity" => $Activity,
                    );
                    $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);


                } else {
                    $result = array();
                    $result['status'] = 'fail';
                    $result['message'] = 'Data Didnt Submitted Succesfully';
                    echo json_encode($result);
                }

            }
        }
    }


    public
    function get_leads_data($DomainID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."Leads"';
        $where = array("DomainID" => $DomainID, 'Archive' => 0);
        $orderby = array("UID" => 'DESC');
        $leadData = $Crud->ListRecords($table, $where, $orderby);
        return $leadData;
    }

    public
    function get_all_organic_leads_data($DomainID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."Leads"';
        $where = array("DomainID" => $DomainID, 'Archive' => 0, "Organic" => 1);
        $orderby = array("UID" => 'DESC');
        $leadData = $Crud->ListRecords($table, $where, $orderby);
        return $leadData;
    }

    public
    function get_unassignLead_filter_data($keyword, $DomainID, $limit = '', $offset = '')

    {
//        echo $keyword;
//        exit;
        $Crud = new Crud();
        /*$SQL_OLD = 'SELECT "sales"."Leads".*
                From "sales"."Leads"
                Where "sales"."Leads"."DomainID" = \' ' . $DomainID . '  \' AND "sales"."Leads"."UserID" = 0
                AND "sales"."Leads"."Archive" = 0     ';*/


        $SQL = 'SELECT "sales"."Leads".*,
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM sales."Leads" 
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" ) 
                WHERE 1=1 AND "Leads"."Archive" = 0 AND "Leads"."DomainID" = ' . $DomainID . '  AND  ( "Leads"."UserID" = 0  OR "Leads"."UserID" IS NULL ) ';

        if (isset($keyword) && $keyword != '') {
            $KeywordInt = (int)$keyword;
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($keyword)) . '%\' ';
            }
        }

        $SQL .= ' GROUP BY "sales"."Leads"."UID" ';

        if ($limit != '' && $limit != -1 && $offset != '') {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
//        echo $SQL;
        $Allrecords = $Crud->ExecuteSQL($SQL);
        return $Allrecords;

    }

    public
    function get_organic_lead_data($limit = '', $offset = '', $Filters)
    {
        $Crud = new Crud();


        $session = session();
        $session = $session->get();
        $DomainID = $session['domainid'];
        $SessionFilters = $session['OrganicLeadsSessionFilter'];

        $SQL = 'SELECT "sales"."Leads".*,"main"."Users"."FullName" AS "AgentFullName"
                FROM "sales"."Leads" 
                LEFT JOIN "main"."Users" ON "main"."Users"."UID" = "sales"."Leads"."UserID"
                WHERE "sales"."Leads"."DomainID" = \'' . $DomainID . '\'
                AND "sales"."Leads"."Personal" = 0 AND "sales"."Leads"."Organic" = 1
                AND "sales"."Leads"."Archive" = 0  ';

        if ($session['profile']['ParentID'] > 0 &&  $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }

        if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '' &&
            isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."CreatedAt" BETWEEN \'' . $SessionFilters['create_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['create_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        if (isset($SessionFilters['status']) && $SessionFilters['status'] != '') {
            $SQL .= ' AND "sales"."Leads"."Status" = \'' . $SessionFilters['status'] . '\' ';
        }

        if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $SessionFilters['product'] . '\' ';
        }

        if ($limit != '' && $limit != -1 && $offset != '') {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

//        echo $SQL;exit;

        $Allrecords = $Crud->ExecuteSQL($SQL);
        return $Allrecords;
    }

    public
    function delete_lead_data($record, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."Leads"';
        $where = array('UID' => $UID);

        $record_id = $Crud->UpdateRecord($table, $record, $where);

        $response = array();
        $response['record_id'] = $record_id;
        $response['status'] = 'success';
        echo json_encode($response);

    }

    public
    function LeadRecordByID($UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."Leads"';
        $where = array("UID" => $UID);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public
    function GetLeadsMetas($ID)
    {
        $Crud = new Crud();
        $table = 'sales."LeadsMeta"';
        $where = array("LeadID" => $ID);
        $records = $Crud->ListRecords($table, $where);
        $final = array();
        foreach ($records as $record) {
            $final[$record['Options']] = $record['Value'];
        }

        return $final;
    }

    public
    function LeadMetaRecordByID($UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'sales."LeadsMeta"';
        $where = array("LeadID" => $UID);
        $records = $Crud->ListRecords($table, $where);

        $final = array();
        foreach ($records as $record) {
            $final[$record['Options']] = $record['Value'];
        }

        return $final;
    }

    public
    function LeadProductsRecordByID($UID)
    {
        $data = $this->data;
        $Crud = new Crud();
//        $table = 'sales."LeadsProduct"';
//        $where = array("LeadID" => $UID);
//        $records = $Crud->ListRecords($table, $where);

        $SQL = 'SELECT "sales"."LeadsProduct"."ProductName" AS "ProductName" 
                FROM "sales"."LeadsProduct" 
                WHERE "sales"."LeadsProduct"."LeadID" = \'' . $UID . '\'   ';

        $records = $Crud->ExecuteSQL($SQL);

        $final = array();
        foreach ($records as $record) {
            $final[] = $record['ProductName'];
        }

        return $final;
    }

    public
    function GetAllLeadsMetaWithOutTags($LeadID)
    {
        $Crud = new Crud();
        $LeadMetaArray = array();
        $SQL = ' SELECT "LeadsMeta".*
                        FROM sales."LeadsMeta" 
                        WHERE sales."LeadsMeta"."LeadID" = ' . $LeadID . ' 
                        AND sales."LeadsMeta"."Options" != \'tags\' ';
        $LeadsMetaData = $Crud->ExecuteSQL($SQL);
        foreach ($LeadsMetaData as $LMD) {
            $LeadMetaArray[$LMD['Options']] = $LMD['Value'];
        }

        return $LeadMetaArray;
    }

    public
    function GetAllLeadActivities($LeadID)
    {

        $Crud = new Crud();
        $SQL = ' SELECT "LeadsActivity"."SystemDate", "LeadsActivity"."Activity",
                     CASE "LeadsActivity"."Visit"
                        WHEN  0 THEN \'System\'
                        WHEN 1 THEN \'Visit\'
                        WHEN 2 THEN ( SELECT main."Users"."FullName" 
                                                                FROM  main."Users" 
                                                                WHERE main."Users"."UID" = sales."LeadsActivity"."UserUID" )
                        ELSE \'System\'
                     END AS "Type"
                 FROM sales."LeadsActivity" 
                WHERE sales."LeadsActivity"."LeadsUID" = ' . $LeadID . ' ORDER BY "LeadsActivity"."SystemDate" DESC ';
        $LeadsActivityData = $Crud->ExecuteSQL($SQL);

        return $LeadsActivityData;
    }

    public
    function LeadStatusCallBack($Data = array(), $UID)
    {
        $session = session();
        $UserUID = $session->get('id');

        $Crud = new Crud();
        $Lead = new LeadModel();
        $db = db_connect();
        $builder = $db->table('sales."Leads"');

        $PreviousLeadData = $Crud->SingleRecord('sales."Leads"', array('UID' => $UID));

        $db->transStart();
        $builder->set('Status', $Data['Status']);
        $builder->set('CallBackDateTime', $Data['CallBackDateTime']);
        $builder->where('UID', $UID);
        if ($builder->update()) {
            $db->transComplete();
            $db->close();

            if (isset($PreviousLeadData['UID']) && $PreviousLeadData['Status'] != $Data['Status']) {
                $Lead->LeadsAutoAssignToAgent($PreviousLeadData['UserID']);

                $ActivityArray = array(
                    "SystemDate" => date("Y-m-d H:i:s"),
                    "LeadsUID" => $UID,
                    "UserUID" => $UserUID,
                    "Activity" => "Lead Status Change from \"" . strtoupper(str_replace("_", " ", $PreviousLeadData['Status'])) . "\" To \"" . strtoupper(str_replace("_", " ", $Data['Status'])) . "\" ",
                    "Visit" => 0
                );
                $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
            }

            if (isset($Data['CallBackActivity']) && $Data['CallBackActivity'] != '') {
                $ActivityArray = array(
                    "SystemDate" => date("Y-m-d H:i:s"),
                    "LeadsUID" => $UID,
                    "UserUID" => $UserUID,
                    "Activity" => trim($Data['CallBackActivity']),
                    "Visit" => 2
                );
                $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
            }

            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'Lead Updated Successfully';
            echo json_encode($result);

        } else {

            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Fail To Update Lead Status, Please Tru Again';
            echo json_encode($result);
        }

    }

    public
    function FollowUpLeadForm($Data = array(), $UID)
    {

        $session = session();
        $UserUID = $session->get('id');

        $Crud = new Crud();
        $Lead = new LeadModel();
        $db = db_connect();
        $builder = $db->table('sales."Leads"');

        $PreviousLeadData = $Crud->SingleRecord('sales."Leads"', array('UID' => $UID));

        $db->transStart();
        $builder->set('Status', $Data['Status']);
        $builder->set('CallBackDateTime', $Data['CallBackDateTime']);
        $builder->set('FollowUpReason', $Data['FollowUpReason']);
        $builder->where('UID', $UID);
        if ($builder->update()) {
            $db->transComplete();
            $db->close();

            if (isset($PreviousLeadData['UID']) && $PreviousLeadData['Status'] != $Data['Status']) {
                $Lead->LeadsAutoAssignToAgent($PreviousLeadData['UserID']);

                $ActivityArray = array(
                    "SystemDate" => date("Y-m-d H:i:s"),
                    "LeadsUID" => $UID,
                    "UserUID" => $UserUID,
                    "Activity" => "Lead Status Change from \"" . strtoupper(str_replace("_", " ", $PreviousLeadData['Status'])) . "\" To \"" . strtoupper(str_replace("_", " ", $Data['Status'])) . "\" ",
                    "Visit" => 0
                );
                $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
            }

            if (isset($Data['CallBackActivity']) && $Data['CallBackActivity'] != '') {
                $ActivityArray = array(
                    "SystemDate" => date("Y-m-d H:i:s"),
                    "LeadsUID" => $UID,
                    "UserUID" => $UserUID,
                    "Activity" => trim($Data['CallBackActivity']),
                    "Visit" => 2
                );
                $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
            }

            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'Lead Updated Successfully';
            echo json_encode($result);

        } else {

            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Fail To Update Lead Status, Please Try Again';
            echo json_encode($result);
        }

    }

    public
    function ClosedLeadForm($Reason, $status, $UID, $Remarks)
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');
        $PreviousLeadData = $Crud->SingleRecord('sales."Leads"', array('UID' => $UID));

        $ActivityArray = array(
            "SystemDate" => date("Y-m-d H:i:s"),
            "LeadsUID" => $UID,
            "UserUID" => $UserUID,
            "Activity" => "Lead Status Change from \"" . strtoupper(str_replace("_", " ", $PreviousLeadData['Status'])) . "\" To \"" . strtoupper(str_replace("_", " ", $status)) . "\" ",
            "Visit" => 0
        );
        $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);


        $UpdateData = $Crud::UpdateRecord('sales."Leads"', array("LeadQuality" => $Reason, "Status" => 'close'), array('UID' => $UID));
        if (isset($UpdateData) && $UpdateData == 1) {

            $Lead = new LeadModel();
            $Lead->LeadsAutoAssignToAgent($PreviousLeadData['UserID']);
            if (isset($Remarks) && $Remarks != '') {
                $ActivityArray = array(
                    "SystemDate" => date("Y-m-d H:i:s"),
                    "LeadsUID" => $UID,
                    "UserUID" => $UserUID,
                    "Activity" => trim($Remarks),
                    "Visit" => 2
                );
                $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
            }


            $result = array();
            $result['status'] = 'success';
            $result['message'] = 'Lead Status Updated Successfully';
            echo json_encode($result);

        } else {
            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Data Didnt Submitted Successfully';
            echo json_encode($result);
        }

    }

    public
    function LeadStatusMaturityFormAdd($DataArray = array())
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');

        $ActivityArray = array(
            "SystemDate" => date("Y-m-d H:i:s"),
            "LeadsUID" => $DataArray['LeadUID'],
            "UserUID" => $UserUID,
            "Activity" => "Lead Maturity Updated! Remarks: " . trim($DataArray['Remarks']) . " ",
            "Visit" => 2
        );
        $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
        $Crud::UpdateRecord('sales."Leads"', array('Status' => $DataArray['Status']), array('UID' => $DataArray['LeadUID']));

        $result = array();
        $result['status'] = 'success';
        $result['message'] = 'Lead Maturity Updated Successfully';
        echo json_encode($result);


    }

    public
    function LeadActivityAttachmentForm($LeadUID, $Remarks, $Image)
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');
        $Crud::AddRecord('sales.LeadsActivity', array("SystemDate" => date("Y-m-d H:i:s"), "Activity" => $Remarks, "FileID" => $Image['File'],
            "LeadsUID" => $LeadUID, "UserUID" => $UserUID,
            "Visit" => 2));

        $result = array();
        $result['status'] = 'success';
        $result['message'] = 'Lead Attachment Added Successfully';
        echo json_encode($result);
    }

    public
    function GetAgentThresholdAndTotalNewAssignLeadsDataWithProjectUID($AgentUID, $ProjectUID)
    {
        $db = db_connect();
        $db->transStart();
        $SQL = ' SELECT "Users"."FullName", 
                        (SELECT "UsersProject"."ThresholdValue" FROM main."UsersProject" WHERE "ProjectID" = \'' . $ProjectUID . '\' 
                            AND "UserUID" = ' . $AgentUID . ') as "ThresholdValue",
                        (SELECT COUNT("UID") FROM sales."Leads" WHERE "Status" = \'new\' AND "Organic" IS NULL AND "ProductID" = \'' . $ProjectUID . '\'
                            AND sales."Leads"."UserID" = main."Users"."UID" ) AS "TOTALLEADS" 
                FROM main."Users"  
                WHERE "Users"."UID" = ' . $AgentUID . ' ';
        $query = $db->query($SQL);
        $UserData = $query->getRowArray();
        //echo $db->getLastQuery();
        $db->transComplete();

        return $UserData;
    }

    public
    function GetAgentProjectsUnAssignLeadsData($ProjectsAgentUID, $CreatedAtOrder = 'ASC', $Limit = 0, $Project = '')
    {
        $db = db_connect();
        $AgentUnAssignLeadsData = array();

        if (isset($Project) && $Project != '') {

            $db->transStart();
            $SQL = 'SELECT sales."Leads".*
                FROM sales."Leads" 
                WHERE sales."Leads"."ProductID" = \'' . $Project . '\'
                AND sales."Leads"."UserID" = 0 AND  sales."Leads"."Status" = \'new\' AND  sales."Leads"."Organic" IS NULL
                 ORDER BY sales."Leads"."CreatedAt" ' . $CreatedAtOrder . ' ';
            if ($Limit > 0) {
                $SQL .= ' LIMIT ' . $Limit . ' ';
            }
            $query = $db->query($SQL);
            $AgentUnAssignLeadsData = $query->getResultArray();
            $db->transComplete();
        }

        return $AgentUnAssignLeadsData;

    }

    public
    function AssignNewLeadsToTodayActiveSaleOfficers()
    {

        $Crud = new Crud();
        $SQL = ' SELECT main."Users"."UID" 
                    FROM main."Users" 
                    WHERE main."Users"."UserType" = \'sale-officer\' 
                    AND  main."Users"."LastLoginDetails" BETWEEN \'' . date("Y-m-d") . ' 00:00:01\' AND \'' . date("Y-m-d") . ' 23:59:59\' ';
        $ActiveSalesOfficersData = $Crud->ExecuteSQL($SQL);
        foreach ($ActiveSalesOfficersData as $ASOFD) {
            $this->LeadsAutoAssignToAgent($ASOFD['UID']);
        }
    }

    public
    function LeadsAutoAssignToAgent($AgentUID)
    {
        $session = session();
        $UserUID = $session->get('id');
        $Lead = new LeadModel();
        $Crud = new Crud();

        $AgentProjectsData = $Crud->ListRecords('main."UsersProject"', array('UserUID' => $AgentUID));
        if (count($AgentProjectsData) > 0) {
            foreach ($AgentProjectsData as $APD) {

                $AgentLeadsData = $Lead->GetAgentThresholdAndTotalNewAssignLeadsDataWithProjectUID($AgentUID, $APD['ProjectID']);
                if ($APD['ThresholdValue'] != '' && $APD['ThresholdValue'] > 0) {
                    $TotalAgentAssignLeads = ((isset($AgentLeadsData['TOTALLEADS']) && $AgentLeadsData['TOTALLEADS'] != '') ? $AgentLeadsData['TOTALLEADS'] : 0);
                    $RemainingLeads = (($TotalAgentAssignLeads > $APD['ThresholdValue']) ? 0 : ($APD['ThresholdValue'] - $TotalAgentAssignLeads));
                    if ($RemainingLeads != '' && $RemainingLeads > 0) {

                        $LeadsRecord = $Lead->GetAgentProjectsUnAssignLeadsData($AgentUID, 'ASC', $RemainingLeads, $APD['ProjectID']);
                        $newAssign = 0;
                        if (count($LeadsRecord) > 0) {
                            foreach ($LeadsRecord as $LD) {
                                $newAssign++;
                                $Update = $Crud->UpdateRecord('sales."Leads"', array('UserID' => $AgentUID, 'LeadAssignmentDate' => date("Y-m-d H:i:s")), array('UID' => $LD['UID']));
                                if (isset($Update) && $Update == 1) {
                                    $ActivityArray = array(
                                        "SystemDate" => date("Y-m-d H:i:s"),
                                        "LeadsUID" => $LD['UID'],
                                        "UserUID" => $UserUID,
                                        "Activity" => 'Un Assign Lead Assign To Agent \'' . $AgentLeadsData['FullName'] . '\' ',
                                        "Visit" => '0',
                                    );
                                    $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
                                    BellNotification(' New leads added in ("' . $AgentLeadsData['FullName'] . '") account', 'leads_assign', $LD['UID'], $AgentUID);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public
    function LeadsReassignFormSubmit($DataArray = array())
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');
        $InsertUID = $Crud::AddRecord('sales."LeadReassign"', $DataArray);
        if (isset($InsertUID) && $InsertUID != '') {

            $ActivityArray = array(
                "SystemDate" => date("Y-m-d H:i:s"),
                "LeadsUID" => $DataArray['LeadsUID'],
                "UserUID" => $UserUID,
                "Activity" => "Lead Reassign to \"" . UserName($DataArray['ReAssignedTo']) . "\" From \"" . ((isset($DataArray['ReAssignedFrom']) && $DataArray['ReAssignedFrom'] > 0) ? UserName($DataArray['ReAssignedFrom']) : 'Un Authorized') . "\" ",
            );
            $Crud->AddRecord('sales."LeadsActivity"', $ActivityArray);
            $Crud->UpdateRecord('sales."Leads"', array("UserID" => $DataArray['ReAssignedTo'],
                'LeadAssignmentDate' => date("Y-m-d H:i:s")),
                array("UID" => $DataArray['LeadsUID']));

            $result = array();
            $result['status'] = 'success';
            $result['message'] = ' Lead Reassign to ' . UserName($DataArray['ReAssignedTo']) . ' Successfully';
            echo json_encode($result);

        } else {

            $result = array();
            $result['status'] = 'fail';
            $result['message'] = 'Data did not Submitted Correctly';
            echo json_encode($result);
        }
    }

    public
    function GetLeadReassignLog($LeadUID)
    {

        $Crud = new Crud();
        $SQL = ' SELECT "SystemDate",
                       CASE "ReAssignedFrom"
                            WHEN 0 THEN \'Un Authorized\'
                            ELSE ( SELECT main."Users"."FullName" 
                                        FROM  main."Users" 
                                        WHERE main."Users"."UID" = sales."LeadReassign"."ReAssignedFrom"   )
                       END AS "ReAssignFrom",
                       CASE "ReAssignedTo"
                            WHEN 0 THEN \'Un Authorized\'
                            ELSE ( SELECT main."Users"."FullName" 
                                        FROM  main."Users" 
                                        WHERE main."Users"."UID" = sales."LeadReassign"."ReAssignedTo"   )
                       END AS "ReAssignedTo"
                 FROM sales."LeadReassign"
                 WHERE sales."LeadReassign"."LeadsUID" = ' . $LeadUID . '
                 ORDER BY "SystemDate" DESC';
        $LeadReAssignData = $Crud->ExecuteSQL($SQL);

        return $LeadReAssignData;
    }

    public
    function LeadsTrackingDataByContactNo($Keyword)
    {
        $Crud = new Crud();
        $FinalArray = array();
        $SQL = ' SELECT "Leads".*, "Users"."FullName" as "UserName"
                FROM sales."Leads"
                LEFT JOIN main."Users" ON "Users"."UID" = "Leads"."UserID" 
                WHERE "Leads"."Archive" = 0 ';

        if ($Keyword != '') {
            $keywordInt = (int)$Keyword;
            if (isset($keywordInt) && $keywordInt != '') {
                $SQL .= ' AND "Leads"."ContactNo" LIKE \'%' . strtolower(trim($keywordInt)) . '%\' ';
                $SQL .= ' OR "Leads"."WhatsAppNo" LIKE \'%' . strtolower(trim($keywordInt)) . '%\' ';
            } else {
                $SQL .= ' AND LOWER( "Leads"."FullName" ) LIKE \'%' . strtolower(trim($Keyword)) . '%\' ';
                $SQL .= ' OR LOWER( "Leads"."Email" ) LIKE \'%' . strtolower(trim($Keyword)) . '%\' ';
                $SQL .= ' OR LOWER( "Leads"."ProductID" ) LIKE \'%' . strtolower(trim($Keyword)) . '%\' ';
                $SQL .= ' OR LOWER( "Leads"."Status" ) LIKE \'%' . strtolower(trim($Keyword)) . '%\' ';
            }
        }
        $SQL .= ' ORDER BY "Leads"."LeadAssignmentDate" DESC';
        $Records = $Crud->ExecuteSQL($SQL);
        if (count($Records) > 0) {
            foreach ($Records as $R) {

                $result = array();

                $LastActivityData = $Crud->SingleRecord('sales."LeadsActivity"', array('LeadsUID' => $R['UID']));

                $result['UID'] = $R['UID'];
                $result['RefID'] = '<a href="' . SeoUrl('lead/activities/' . $R['UID'] . "-" . $R['FullName']) . '" target="_blank">' . Code('UF/L/', $R['UID']) . '</a>';
                $result['SystemDate'] = date("d M, Y", strtotime($R['SystemDate']));
                $result['CreatedAt'] = date("d M, Y h:i A", strtotime($R['CreatedAt']));
                $result['LeadAssignmentDate'] = (($R['LeadAssignmentDate'] != '') ? date("d M, Y h:i A", strtotime($R['LeadAssignmentDate'])) : '-');
                $result['FullName'] = ucfirst($R['FullName']);
                $result['ProjectName'] = $R['ProductID'];
                $result['ContactNo'] = '<a href="' . WhatsAppUrl($R['ContactNo']) . '" target="_blank">' . $R['ContactNo'] . '</a>';
                $result['Agent'] = ((isset($R['UserName']) && $R['UserName'] != '') ? $R['UserName'] : '-');
                $result['Status'] = ucwords(str_replace("_", " ", $R['Status']));
                $result['LastActivityDate'] = ((isset($LastActivityData['SystemDate']) ? date("d M, Y h:i A", strtotime($LastActivityData['SystemDate'])) : '-'));
                $result['LastActivity'] = ((isset($LastActivityData['Activity']) ? trim($LastActivityData['Activity']) : '-'));

                $FinalArray[] = $result;
            }
        }
        return $FinalArray;

    }

    public function GetAllLeadsRecords($DataTableSearch = '', $limit = '', $offset = '')
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['AllLeadsRecordSessionFilters'];

        $Crud = new Crud();
        $SQL = 'SELECT "sales"."Leads".*,
                CASE 
                    WHEN "sales"."Leads"."UserID" > 0 
                        THEN ( SELECT "Users"."FullName" FROM main."Users" WHERE main."Users"."UID" =  "sales"."Leads"."UserID" )
                    ELSE \'-\'
                END AS "SaleOfficer" ,
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM sales."Leads" 
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" ) 
                WHERE 1=1 AND "Leads"."Archive" = 0  ';


        if($session['profile']['ParentID'] > 0 &&  $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].' ';
        }



        if (isset($DataTableSearch) && trim($DataTableSearch) != '') {

            $DataTableSearchInt = (int)$DataTableSearch;
            if (is_int($DataTableSearchInt) && trim($DataTableSearchInt) != '' && trim($DataTableSearchInt) != 0) {

                $SQL .= '  AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($DataTableSearchInt) . '%\' 
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($DataTableSearchInt) . '%\'  ';

            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($DataTableSearch)) . '%\'
                            OR LOWER("sales"."Leads"."Email") LIKE  \'%' . strtolower(trim($DataTableSearch)) . '%\'
                             OR LOWER("sales"."Leads"."Status") LIKE  \'%' . strtolower(trim($DataTableSearch)) . '%\'
                              OR LOWER("sales"."Leads"."ProductID") LIKE  \'%' . strtolower(trim($DataTableSearch)) . '%\'
                              OR LOWER("sales"."Leads"."LeadCategory") LIKE  \'%' . strtolower(trim($DataTableSearch)) . '%\' ';
            }
        }

        if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '' &&
            isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."CreatedAt" BETWEEN \'' . $SessionFilters['create_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['create_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $SessionFilters['product'] . '\' ';
        }
        $SQL .= ' GROUP BY "sales"."Leads"."UID"  ';
        $SQL .= ' ORDER BY "sales"."Leads"."CreatedAt" DESC ';

        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function FacebookFileImporterFormSubmit($Record)
    {
        $Crud = new Crud();
        $session = session();
        $UserUID = $session->get('id');
        if (count($Record) > 0) {

            $db = db_connect();
            //$builder = $db->table('sales."Leads"');

            /** Check Lead Exist in Table With Same Contact No **/
            $where = array(
                'ContactNo' => trim($Record['ContactNo'])
            );
            $LeadContactNoExistingData = $Crud::SingleRecord('sales."Leads"', $where, array());
            if (isset($LeadContactNoExistingData['UID'])) {

                $DataArray = array(
                    'CreatedAt' => $Record['CreatedAt'],
                    'Status' => 'new'
                );
                $where = array('UID' => $LeadContactNoExistingData['UID']);
                $UpdateData = $Crud::UpdateRecord('sales."Leads"', $DataArray, $where);
                if (isset($UpdateData) && $UpdateData == 1) {

                    $Activity = " \"" . $Record['ContactNo'] . "\" Lead Status Change From \"" . ucfirst($LeadContactNoExistingData['Status']) . "\" To \"New\",
                                    Due To Lead Repeat Again on \"" . date("d M, Y h:i A", strtotime($Record['CreatedAt'])) . "\" ";

                    $ActivityArray = array(
                        "SystemDate" => date("Y-m-d H:i:s"),
                        "LeadsUID" => $LeadContactNoExistingData['UID'],
                        "UserUID" => $UserUID,
                        "Activity" => $Activity,
                    );
                    $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
                }

            } else {

                $LeadUID = $Crud::AddRecord('sales."Leads"', $Record);
                if (isset($LeadUID) && $LeadUID != '' && $LeadUID > 0) {

                    if ($Record['Agent'] > 0) {
                        $Activity = " New Lead Added! ";
                    } else if ($Record['Agent'] == 0) {
                        $Activity = " New \"Un-Authorized\" Lead Added";
                    }

                    $ActivityArray = array(
                        "SystemDate" => date("Y-m-d H:i:s"),
                        "LeadsUID" => $LeadUID,
                        "UserUID" => $UserUID,
                        "Activity" => $Activity,
                    );
                    $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);

                }
            }
        }
    }

    public
    function OrganicLeadsFormSubmit($DataArray = array(), $ProductMeta, $Meta, $UID = 0)
    {

        $session = session();
        $UserUID = $session->get('id');

        $Crud = new Crud();
        $Leads = new LeadModel();
        $FacebookCheck = $Crud::SingleRecord('sales."LeadsMeta"', array("Value" => $Meta['Facebook']));
        $LinkedlnCheck = $Crud::SingleRecord('sales."LeadsMeta"', array("Value" => $Meta['LinkedIn']));
        $InstagramCheck = $Crud::SingleRecord('sales."LeadsMeta"', array("Value" => $Meta['Instagram']));
        $TwitterCheck = $Crud::SingleRecord('sales."LeadsMeta"', array("Value" => $Meta['Twitter']));

        if ($UID == 0) {

            if ($DataArray['Email'] != '') {
                $EmailCheck = $Crud::SingleRecord('sales."Leads"', array("Email" => $DataArray['Email']));
            }
            if ($DataArray['ContactNo'] != '') {
                $ContactCheck = $Crud::SingleRecord('sales."Leads"', array("ContactNo" => $DataArray['ContactNo']));
            }
            if (isset($EmailCheck['UID'])) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Email Already Exist';
                echo json_encode($result);

            } else if (isset($ContactCheck['UID'])) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Contact No Already Exist';
                echo json_encode($result);

            } else if (isset($FacebookCheck['UID']) && $FacebookCheck['UID'] > 0) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Facebook URL Already Exist';
                echo json_encode($result);

            } else if (isset($InstagramCheck['UID']) && $InstagramCheck['UID'] > 0) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Instagram URL Already Exist';
                echo json_encode($result);

            } else if (isset($LinkedlnCheck['UID']) && $LinkedlnCheck['UID'] > 0) {

                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Linkedln URL Already Exist';
                echo json_encode($result);

            } else if (isset($TwitterCheck['UID']) && $TwitterCheck['UID'] > 0) {
                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Twitter URL Already Exist';
                echo json_encode($result);

            } else {

                $UID = $Crud::AddRecord('sales."Leads"', $DataArray);
                if (isset($UID) && $UID != '') {
                    foreach ($Meta as $MetaKs => $MetaV) {
                        if ($MetaV != '') {
                            $Crud = new Crud();
                            $table = 'sales."LeadsMeta"';
                            $where = array("LeadID" => $UID, "Options" => $MetaKs);
                            $MetaK = $Crud->SingleRecord($table, $where);
                            if (!isset($MetaK['UID'])) {
                                $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $UID), "Options" => $MetaKs, "Value" => $MetaV));
                            } else {
                                ///////////// update
                                $wheres = array("LeadID" => $UID, "Options" => $MetaKs);
                                $Crud->DeleteRecord($table, $wheres);
                                $Crud->AddRecord($table, array("LeadID" => $UID, "Options" => $MetaKs, "Value" => $MetaV));
                            }
                        }
                    }

                    foreach ($ProductMeta as $MetaKs => $MetaV) {
                        if ($MetaV > 0) {
                            $table = 'sales."LeadsProduct"';
                            $where = array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs);
                            $MetaK = $Crud->SingleRecord($table, $where);
                            if (!isset($MetaK['UID'])) {
                                $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs));
                            } else {
                                ///////////// update
                                $wheres = array("LeadID" => $UID);
                                $Crud->DeleteRecord($table, $wheres);
                                $Crud->AddRecord($table, array("LeadID" => $UID, "ProductName" => $MetaKs));
                            }
                        }

                    }

                    if ($DataArray['Status'] != '') {
                        $ActivityArray = array(
                            "SystemDate" => date("Y-m-d H:i:s"),
                            "LeadsUID" => $UID,
                            "UserUID" => $UserUID,
                            "Activity" => " New Organic Lead Added",
                        );
                        $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
                    }

                    $result = array();
                    $result['status'] = 'success';
                    $result['message'] = 'Organic Lead Added Successfully';
                    echo json_encode($result);


                    if ($DataArray['UserID'] != '') {
                        $ActivityArray = array(
                            "SystemDate" => date("Y-m-d H:i:s"),
                            "LeadsUID" => $UID,
                            "UserUID" => $UserUID,
                            "Activity" => "Organic Lead Assign To \"" . UserName($DataArray['UserID']) . "\" ",
                        );
                        $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray);
                    }
                }
            }

        } else {


            $LeadExistingData = $Crud::SingleRecord('sales."Leads"', array("UID" => $UID));
            if ($DataArray['ContactNo'] != '') {
                $ContactCheck = $Crud::SingleRecord('sales."Leads"', array("ContactNo" => $DataArray['ContactNo'], "UID !=" => $UID));
            }
            if ($DataArray['Email'] != '') {
                $EmailCheck = $Crud::SingleRecord('sales."Leads"', array("Email" => $DataArray['Email'], "UID !=" => $UID));
            }
            if (isset($EmailCheck['UID'])) {

                $result = array();
                $result['status'] = 'fail';
                $result['message'] = 'Email Already Exist';
                echo json_encode($result);

            } else {


                $where = array('UID' => $UID);
                $UpdateData = $Crud::UpdateRecord('sales."Leads"', $DataArray, $where);
                if (isset($UpdateData) && $UpdateData == 1) {


                    if ($DataArray['UserID'] != '' && $LeadExistingData['UserID'] != $DataArray['UserID']) {

                        $ActivityArray = array(
                            "SystemDate" => date("Y-m-d H:i:s"),
                            "LeadsUID" => $UID,
                            "UserUID" => $UserUID,
                            "Activity" => "Organic Lead Assign To \"" . UserName($DataArray['UserID']) . "\" ",
                        );
                        $Crud::AddRecord('sales."LeadsActivity"', $ActivityArray, 'asdasd');
                    }


                    foreach ($Meta as $MetaKs => $MetaV) {
                        if ($MetaV != '') {
                            $Crud = new Crud();
                            $wheres = array("LeadID" => $UID, "Options" => $MetaKs);
                            $ContactCheck = $Crud::SingleRecord('sales."LeadsMeta"', array("LeadID !=" => $UID, "Value" => $MetaV));

                            if (isset($ContactCheck['UID'])) {
                                $result = array();
                                $result['status'] = 'fail';
                                $result['message'] = 'This URL Already Exist In System As ' . $ContactCheck['Options'] . ' URL';
                                echo json_encode($result);
                                exit;
                            } else {
                                $Crud->DeleteRecord('sales."LeadsMeta"', array("LeadID" => $UID, "Options" => $MetaKs));
                                $Crud->AddRecord('sales."LeadsMeta"', array("LeadID" => $UID, "Options" => $MetaKs, "Value" => $MetaV));
                            }
                        }
                    }


                    $table = 'sales."LeadsProduct"';
                    $Productwheres = array("LeadID" => (($UID) > 0 ? $UID : $UID));
                    $Crud->DeleteRecord($table, $Productwheres);
                    foreach ($ProductMeta as $MetaKs => $MetaV) {
                        if ($MetaV > 0) {

                            $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs));

                            /*$where = array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs);
                            $MetaK = $Crud->SingleRecord($table, $where);
                            if (!isset($MetaK['UID'])) {
                                $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs));
                            } else {

                                $wheres = array("LeadID" => (($UID) > 0 ? $UID : $UID));
                                $Crud->DeleteRecord($table, $wheres);
                                $Crud->AddRecord($table, array("LeadID" => (($UID) > 0 ? $UID : $UID), "ProductName" => $MetaKs));
                            }*/
                        }

                    }

                    $result = array();
                    $result['status'] = 'success';
                    $result['message'] = 'Organic Lead Updated Successfully';
                    echo json_encode($result);


                }
            }
        }

    }

    public function GetFreshLeads()
    {
        $session = session();
        $session = $session->get();
        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];
//        $SQL_olc = 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" FROM "sales"."Leads"
//                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"
//                Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '  AND "Leads"."UserID" > 0   AND "Leads"."Status" = \'new\'';
        $SQL = '';
        $SQL .= 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" ,
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM "sales"."Leads"  
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"             
                JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )              
                WHERE "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '  AND "Leads"."UserID" > 0   AND "Leads"."Status" = \'new\'   ';

        if($session['profile']['ParentID'] > 0 &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].' ';
        }

            $SQL .= ' GROUP BY "Leads"."UID","main"."Users"."FullName"  ';

        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray;
    }

    public function GetTodayFollowLeads()
    {
        $session = session();
        $session = $session->get();
        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];
        /*$SQL_old = 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" FROM "sales"."Leads"    , "sales"."LeadsProduct"."ProductName",
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"

                JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )

                Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '
                AND "Leads"."CallBackDateTime"  BETWEEN  \'' . date("Y-m-d") . ' 00:00:01\' AND  \'' . date("Y-m-d") . ' 23:59:59\'
               ';*/
        $SQL = '';
        $SQL .= 'SELECT "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName", 
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM "sales"."Leads"   
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"    
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" ) 
                WHERE "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' 
                AND "Leads"."CallBackDateTime"  BETWEEN  \'' . date("Y-m-d") . ' 00:00:01\' AND  \'' . date("Y-m-d") . ' 23:59:59\'   ';

        if($session['profile']['ParentID'] > 0  &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].' ';
        }

        $SQL .= '   GROUP BY "Leads"."UID","main"."Users"."FullName"  ';
        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray;
    }

    public function GetPendingFollowLeads()
    {
        $session = session();
        $session = $session->get();
        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];

        /*$SQL_Old = 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" FROM "sales"."Leads"    , "sales"."LeadsProduct"."ProductName",
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"

                 JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )

                Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '
                 AND "Leads"."CallBackDateTime"  <  \'' . date("Y-m-d") . ' 00:00:01\'
                  ';*/
        $SQL = '';
        $SQL .= 'SELECT "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName", 
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM "sales"."Leads"   
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"    
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" ) 
                WHERE "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' 
                AND "Leads"."CallBackDateTime"  <  \'' . date("Y-m-d") . ' 00:00:01\'     ';

        if($session['profile']['ParentID'] > 0  &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].' ';
        }

        $SQL .= 'GROUP BY "Leads"."UID","main"."Users"."FullName" ';



        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray;
    }

    public function GetUpComingFollowUpLeads()
    {
        $session = session();
        $session = $session->get();
        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];

        /*$SQL_old = 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" FROM "sales"."Leads"    , "sales"."LeadsProduct"."ProductName",
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"

                 JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )

                Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '
                 AND "Leads"."CallBackDateTime"  >  \'' . date("Y-m-d") . ' 23:59:59\'
                  ';*/
        $SQL = '';
        $SQL .= 'SELECT "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName", 
                string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                FROM "sales"."Leads"   
                LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"    
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" ) 
                WHERE "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' 
                AND "Leads"."CallBackDateTime"  >  \'' . date("Y-m-d") . ' 23:59:59\'   ';
        if($session['profile']['ParentID'] > 0  &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].' ';
        }
        $SQL .= ' GROUP BY "Leads"."UID","main"."Users"."FullName" ';

        $FinalArray = $Crud->ExecuteSQL($SQL);

        return $FinalArray;
    }


    public function GetLeadstatusByPram($record_status)
    {
        $session = session();
        $session = $session->get();
        $data = $this->data;
        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];


        /* $SQL = 'Select "sales"."Leads".* , "main"."Users"."FullName" AS "AgentName" FROM "sales"."Leads"
                 LEFT JOIN "main"."Users" ON  "sales"."Leads"."UserID" =  "main"."Users"."UID"
                 Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '  AND "Leads"."Status" = \''.$record_status.'\' ';*/
        /* $SQL_old = 'Select "sales"."Leads".*, "sales"."LeadsProduct"."ProductName",
                     (
                    CASE
                      WHEN "sales"."Leads"."UserID" IS NOT NULL AND "sales"."Leads"."UserID" > 0
                       THEN ( SELECT main."Users"."FullName" FROM main."Users" WHERE main."Users"."UID" = "sales"."Leads"."UserID" )
                      ELSE \'N/A\'
                    END
                 ) AS "AgentName"
                  FROM "sales"."Leads"

                 JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )

                  Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' AND "Leads"."Status" = \'' . $record_status . '\' ';*/

        $SQL = '';
        $SQL .= 'Select "sales"."Leads".*, 
                    (
                   CASE  
                     WHEN "sales"."Leads"."UserID" IS NOT NULL AND "sales"."Leads"."UserID" > 0
                      THEN ( SELECT main."Users"."FullName" FROM main."Users" WHERE main."Users"."UID" = "sales"."Leads"."UserID" )
                     ELSE \'N/A\'
                   END  ) AS "AgentName", 
                    string_agg("sales"."LeadsProduct"."ProductName", \',\') AS "ProductName"
                    FROM "sales"."Leads"    
                     JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )   
                       Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' AND "Leads"."Status" = \'' . $record_status . '\' ';

        if($session['profile']['ParentID'] > 0 &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].'  ';
        }

        $SQL .=  '  GROUP BY "Leads"."UID" ';

        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function GetProductsStatsRecords($keyword, $ProductName, $DomainID, $limit = '', $offset = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL .= ' Select "sales"."Leads".*,
                    (
                   CASE  
                     WHEN "sales"."Leads"."UserID" IS NOT NULL AND "sales"."Leads"."UserID" > 0
                      THEN ( SELECT "main"."Users"."FullName" FROM "main"."Users" WHERE "main"."Users"."UID" = "sales"."Leads"."UserID" )
                     ELSE \'N/A\'
                   END 
                ) AS "AgentName"
                 FROM "sales"."Leads"
                 Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '   
                 AND "Leads"."UID" IN (SELECT "sales"."LeadsProduct"."LeadID"
                  FROM "sales"."LeadsProduct" 
                   WHERE "LeadsProduct"."ProductName" = \'' . $ProductName . '\'  ) ';

        if($session['profile']['ParentID'] > 0 &&  $session['type'] == 'sale-officer'){
            $SQL .= ' AND "Leads"."UserID" = '.$session['profile']['UID'].'  ';
        }


        ///         Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . ' AND "Leads"."UID"  IN (SELECT "LeadID", "UID" FROM "LeadsProduct" WHERE "ProductName" = \'' . $ProductName . '\') ';


        if (isset($keyword) && $keyword != '') {
            $keywordInt = (int)$keyword;
            if (is_int($keywordInt) && trim($keywordInt) != '' && trim($keywordInt) != 0) {
                $SQL .= ' AND "sales"."Leads"."ContactNo" LIKE \'%' . trim($keywordInt) . '%\' 
                 OR  "sales"."Leads"."WhatsAppNo"  LIKE  \'%' . trim($keywordInt) . '%\'  ';
            } else {
                $SQL .= ' AND LOWER("sales"."Leads"."FullName") LIKE \'%' . strtolower(trim($keyword)) . '%\' ';
            }
        }

        if ($limit != '' && $limit != -1 && $offset != '') {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }


}
