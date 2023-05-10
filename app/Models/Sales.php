<?php namespace App\Models;

use App\Controllers\Home;
use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;
use Faker\Guesser\Name;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use phpDocumentor\Reflection\Types\Array_;


class Sales extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
        $session = session();
        $session = $session->get();
        $this->data['session'] = $session;
    }

    public
    function AddScoreToOrganicPlatform($UID, $Score)
    {

        $Crud = new Crud();
        $table = 'main."LookupsOptions"';
        $record['OtherDescription'] = $Score;
        $where = array("UID" => $UID);
        if ($Crud->UpdateRecord($table, $record, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }

    public
    function GetStaffProjectsDataByUID($ID)
    {

        $FinalArray = array();
        $Crud = new Crud();

        /** projects Record Segment **/
        $SQL = 'SELECT main."UsersProject".*
                    FROM main."UsersProject"
                    WHERE main."UsersProject"."UserUID" = ' . $ID . ' ';

        $ProjectsDataRecords = $Crud->ExecuteSQL($SQL);

        return $ProjectsDataRecords;
    }

    public function ThresholdFormSubmit($UID, $ProArray = array())
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'main."UsersProject"';
        $this->MainModel = new Main();
        $main = $this->MainModel;
        if (count($ProArray) > 0) {
            $recordID = $UID;
            $Crud->DeleteRecord('main."UsersProject"', array("UserUID" => $recordID));
            foreach ($ProArray as $WSMD) {
                if ($WSMD['ProjectID'] != '0') {
                    $TrainingData = array(
                        'UserUID' => $recordID,
                        'ProjectID' => $WSMD['ProjectID'],
                        'ThresholdValue' => $WSMD['ThresholdValue'],
                    );
                    $RecordID = $Crud::AddRecord('main."UsersProject"', $TrainingData);
                }
            }
            if ($RecordID > 0) {
                $response['status'] = "success";
                $response['message'] = "Threshold Succesfully Added";
            } else {
                $response['status'] = "fail";
                $response['message'] = "Data Didnt added Successfully";
            }
        }

        echo json_encode($response);
    }

    public
    function WorkSheetFormSubmit($UID, $WorksSheetDate = null, $WorkSheetMetaData = array())
    {

        $session = session();
        $UserUID = $session->get('id');
        $Crud = new Crud();
        $DomainID = $session->get('domainid');
        // echo'<pre>';print_r( $WorkSheetMetaData );exit;
        if ($UID == 0) {

            $CheckWorkSheetDataByDate = $Crud::SingleRecord('sales."Worksheet"', array('CreatedAt' => date("Y-m-d", strtotime($WorksSheetDate)), 'UserID' => $UserUID));
            if (isset($CheckWorkSheetDataByDate['UID'])) {

                if (count($WorkSheetMetaData) > 0) {
                    foreach ($WorkSheetMetaData as $WSMD) {

                        $GetWorkSheetMetaData = $Crud::SingleRecord('sales."WorksheetMeta"', array('WorkSheetUID' => $CheckWorkSheetDataByDate['UID'], 'OptionUID' => $WSMD['UID']));
                        if (isset($GetWorkSheetMetaData['UID'])) {

                            $WorkSheetMeta = array(
                                'Performed' => $WSMD['Performed'],
                                'Remarks' => trim($WSMD['Remarks'])
                            );
                            $UpdateResponse = $Crud::UpdateRecord('sales."WorksheetMeta"', $WorkSheetMeta, array('UID' => $GetWorkSheetMetaData['UID']));

                        } else {

                            $WorkSheetMeta = array(
                                'SystemDate' => date("Y-m-d H:i:s"),
                                'WorkSheetUID' => $CheckWorkSheetDataByDate['UID'],
                                'OptionUID' => $WSMD['UID'],
                                'Performed' => $WSMD['Performed'],
                                'Remarks' => trim($WSMD['Remarks'])
                            );
                            $MetaInsertUID = $Crud::AddRecord('sales."WorksheetMeta"', $WorkSheetMeta);
                        }
                    }
                }

                $result = array();
                $result['status'] = 'success';
                $result['message'] = 'Work Sheet Updated Successfully';
                echo json_encode($result);

            } else {

                $WorkSheet = array(
                    'SystemDate' => date("Y-m-d H:i:s"),
                    'UserID' => $UserUID,
                    'DomainID' => $DomainID,
                    'CreatedAt' => ((isset($WorksSheetDate) && $WorksSheetDate != '') ? date("Y-m-d", strtotime($WorksSheetDate)) : date("Y-m-d"))
                );
                $InsertUID = $Crud::AddRecord('sales."Worksheet"', $WorkSheet);
                if (isset($InsertUID) && $InsertUID != '') {
                    if (count($WorkSheetMetaData) > 0) {
                        foreach ($WorkSheetMetaData as $WSMD) {
                            $WorkSheetMeta = array(
                                'SystemDate' => date("Y-m-d H:i:s"),
                                'WorkSheetUID' => $InsertUID,
                                'OptionUID' => $WSMD['UID'],
                                'Performed' => $WSMD['Performed'],
                                'Remarks' => $WSMD['Remarks']
                            );
                            $MetaInsertUID = $Crud::AddRecord('sales."WorksheetMeta"', $WorkSheetMeta);
                        }
                    }

                    $result = array();
                    $result['status'] = 'success';
                    $result['message'] = 'Work Sheet Added Successfully';
                    echo json_encode($result);

                } else {

                    $result = array();
                    $result['status'] = 'fail';
                    $result['message'] = 'Failed To Add Work Sheet, Please Try Again';
                    echo json_encode($result);

                }
            }

        } else {

            $WorkSheet = array(
                'UserID' => $UserUID,
                'CreatedAt' => ((isset($WorksSheetDate) && $WorksSheetDate != '') ? date("Y-m-d", strtotime($WorksSheetDate)) : date("Y-m-d"))
            );
            $UpdateResponse = $Crud::UpdateRecord('sales."Worksheet"', $WorkSheet, array('UID' => $UID));
            if (isset($UpdateResponse) && $UpdateResponse == 1) {

                if (count($WorkSheetMetaData) > 0) {
                    foreach ($WorkSheetMetaData as $WSMD) {

                        $GetWorkSheetMetaData = $Crud::SingleRecord('sales."WorksheetMeta"', array('WorkSheetUID' => $UID, 'OptionUID' => $WSMD['UID']));
                        if (isset($GetWorkSheetMetaData['UID'])) {

                            $WorkSheetMeta = array(
                                'Performed' => $WSMD['Performed'],
                                'Remarks' => trim($WSMD['Remarks'])
                            );
                            $UpdateResponse = $Crud::UpdateRecord('sales."WorksheetMeta"', $WorkSheetMeta, array('UID' => $GetWorkSheetMetaData['UID']));

                        } else {

                            $WorkSheetMeta = array(
                                'SystemDate' => date("Y-m-d H:i:s"),
                                'WorkSheetUID' => $UID,
                                'OptionUID' => $WSMD['UID'],
                                'Performed' => $WSMD['Performed'],
                                'Remarks' => trim($WSMD['Remarks'])
                            );
                            $MetaInsertUID = $Crud::AddRecord('sales."WorksheetMeta"', $WorkSheetMeta);
                        }
                    }
                }

                $result = array();
                $result['status'] = 'success';
                $result['message'] = 'Work Sheet Updated Successfully';
                echo json_encode($result);

            } else {

                $result = array();
                $result['status'] = 'success';
                $result['message'] = 'Failed To Update Work Sheet, Please Try Again';
                echo json_encode($result);
            }

        }
    }

    public
    function GetWorkSheetDataByUID($WorkSheetUID)
    {

        $FinalArray = array();
        $Crud = new Crud();

        $Records = $Crud::SingleRecord('sales."Worksheet"', array('UID' => $WorkSheetUID));
        if (isset($Records['UID'])) {

            /** Work Sheet Single Record Array **/
            $FinalArray['Sheet']['UID'] = $Records['UID'];
            $FinalArray['Sheet']['SystemDate'] = $Records['SystemDate'];
            $FinalArray['Sheet']['UserUID'] = $Records['UserUID'];
            $FinalArray['Sheet']['CreatedAt'] = $Records['CreatedAt'];

            /** Work Sheet MetaData Record Segment **/
            $SQL = 'SELECT sales."WorksheetMeta".*
                    FROM sales."WorksheetMeta"
                    WHERE sales."WorksheetMeta"."WorkSheetUID" = ' . $WorkSheetUID . ' ';
            $WorkSheetMetaDataRecords = $Crud->ExecuteSQL($SQL);
            foreach ($WorkSheetMetaDataRecords as $WSMDR) {

                $FinalArray['WorkSheetMeta'][$WSMDR['OptionUID']]['Performed'] = $WSMDR['Performed'];
                $FinalArray['WorkSheetMeta'][$WSMDR['OptionUID']]['Remarks'] = $WSMDR['Remarks'];
                $FinalArray['WorkSheetMeta'][$WSMDR['OptionUID']]['OptionUID'] = $WSMDR['OptionUID'];
            }

        }

        return $FinalArray;
    }


    public
    function GetAllWorkSheetDataWithLimit()
    {
        $Crud = new Crud();
        $Admin = new Sales();
        $FinalArray = array();

        $session = session();
        $UserUID = $session->get('id');
        $HierarchyUsers = HierarchyUsers($UserUID);

        $session = $session->get();
        $SessionFilters = $session['WorkSheetSessionFilters'];

        $SQL = '
        SELECT sales."Worksheet"."UID", sales."Worksheet"."UserID", sales."Worksheet"."CreatedAt", sales."Worksheet"."SystemDate", main."Users"."FullName" as "UserName",
               ROUND( 
                   ( 
                       SUM(main."LookupsOptions"."OtherDescription") 
                       / (SELECT SUM(main."LookupsOptions"."OtherDescription") AS "TotalScore" FROM main."LookupsOptions" 
                       WHERE main."LookupsOptions"."LookupID" IN ( SELECT main."Lookups"."UID" FROM  main."Lookups" WHERE  main."Lookups"."Key" LIKE \'%organic%\' )) ) 
                       * 100 , 2) AS "TotalPercent"
        FROM sales."Worksheet"
        INNER JOIN sales."WorksheetMeta" ON (sales."Worksheet"."UID" = sales."WorksheetMeta"."WorkSheetUID")
        INNER JOIN main."Users" ON (sales."Worksheet"."UserID" = main."Users"."UID")
        INNER JOIN main."LookupsOptions" ON (main."LookupsOptions"."UID" = sales."WorksheetMeta"."OptionUID")
        WHERE sales."Worksheet"."Archive" = 0 AND sales."Worksheet"."UserID" IN (' . $HierarchyUsers . ') ';

        if (isset($SessionFilters['worksheet_start_date']) && $SessionFilters['worksheet_start_date'] != '' &&
            isset($SessionFilters['worksheet_end_date']) && $SessionFilters['worksheet_end_date'] != '') {
            $SQL .= ' AND "sales"."Worksheet"."CreatedAt" Between \'' . $SessionFilters['worksheet_start_date'] . '\' AND \'' . $SessionFilters['worksheet_end_date'] . '\' ';
        }

        if (isset($SessionFilters['submitted_by']) && $SessionFilters['submitted_by'] != '') {
            $SQL .= ' AND "sales"."Worksheet"."UserID" = \'' . $SessionFilters['submitted_by'] . '\' ';
        }


        $SQL .= 'GROUP BY sales."WorksheetMeta"."WorkSheetUID",sales."Worksheet"."UID",main."Users"."FullName" ORDER BY sales."Worksheet"."SystemDate" DESC ';
        // echo $SQL; exit;
        $Records = $Crud->ExecuteSQL($SQL);
        foreach ($Records as $R) {

            $WorkSheetPlatForms = $Admin::GetAllPlatFormDataByWorkSheetUID($R['UID']);

//            print_r($WorkSheetPlatForms);exit;
            $result = array();
            $result['UID'] = $R['UID'];
            $result['SystemDate'] = $R['SystemDate'];
            $result['UserID'] = $R['UserID'];
            $result['UserName'] = $R['UserName'];
            $result['CreatedAt'] = $R['CreatedAt'];
            $result['TotalPercent'] = $R['TotalPercent'];
            $result['PlatForms'] = $WorkSheetPlatForms;

            $FinalArray[] = $result;
        }

        return $FinalArray;
    }

    public
    function GetAllPlatFormDataByWorkSheetUID($WorkSheetUID)
    {
        $Crud = new Crud();
        $PlatFormDataArray = array();
        $SQL = '
        SELECT DISTINCT main."Lookups"."Name" FROM main."Lookups" 
        JOIN main."LookupsOptions" ON main."LookupsOptions"."LookupID" = main."Lookups"."UID" 
        JOIN sales."WorksheetMeta" ON sales."WorksheetMeta"."OptionUID" = main."LookupsOptions"."UID"
        WHERE sales."WorksheetMeta"."WorkSheetUID" = ' . $WorkSheetUID . ' ORDER BY main."Lookups"."Name" ASC 
    
        ';
        $PlatFormData = $Crud->ExecuteSQL($SQL);
        foreach ($PlatFormData as $PFD) {
            $PlatFormDataArray[] = str_replace("Organic Platform ", "", $PFD['Name']);
        }
        $PlatFormDataArray = implode(", ", $PlatFormDataArray);
        return $PlatFormDataArray;
    }

/////////////////

    public function getsaleofficer()
    {

        $Crud = new Crud();

        $SQL = 'SELECT * FROM main."Users" WHERE main."Users"."UserType" = \'sale-officer\' ';
        $record2 = $Crud->ExecuteSQL($SQL);
        return $record2;

    }

    public
    function InitialTrainingFormSubmit($UID, $Training = array())
    {

        $session = session();
        $Crud = new Crud();

//        print_r($Training);
//        exit;
        if (count($Training) > 0) {
            foreach ($Training as $WSMD) {
                if ($WSMD['Remarks'] != '') {
                    $GetTrainingData = $Crud::SingleRecord('sales."InitialTraining"', array('StaffID' => $UID, 'OptionUID' => $WSMD['UID']));
                    if (isset($GetTrainingData['UID'])) {
                        $TrainingData = array(
                            'Performed' => $WSMD['Performed'],
                            'Remarks' => trim($WSMD['Remarks'])
                        );
                        $UpdateResponse = $Crud::UpdateRecord('sales."InitialTraining"', $TrainingData, array('UID' => $GetTrainingData['UID']));
                    } else {
                        $TrainingData = array(
                            'SystemDate' => date("Y-m-d H:i:s"),
                            'StaffID' => $UID,
                            'OptionUID' => $WSMD['UID'],
                            'Performed' => $WSMD['Performed'],
                            'Remarks' => trim($WSMD['Remarks'])
                        );
                        $MetaInsertUID = $Crud::AddRecord('sales."InitialTraining"', $TrainingData);
                    }
                }
            }
        }

        $result = array();
        $result['status'] = 'success';
        $result['message'] = 'Initial Training Form Submitted Successfully';
        echo json_encode($result);
    }

    public
    function GetInitialTrainingDataByUID($ID)
    {

        $FinalArray = array();
        $Crud = new Crud();

        /** initial_training Record Segment **/
        $SQL = 'SELECT sales."InitialTraining".*
                    FROM sales."InitialTraining"
                    WHERE sales."InitialTraining"."StaffID" = ' . $ID . ' ';
        $InitialDataRecords = $Crud->ExecuteSQL($SQL);
        foreach ($InitialDataRecords as $IDR) {

            $FinalArray['InitialTrainingData'][$IDR['OptionUID']]['Performed'] = $IDR['Performed'];
            $FinalArray['InitialTrainingData'][$IDR['OptionUID']]['Remarks'] = $IDR['Remarks'];
            $FinalArray['InitialTrainingData'][$IDR['OptionUID']]['OptionUID'] = $IDR['OptionUID'];
        }


        return $FinalArray;
    }

    public function FetchLeadsDetails($UID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT * FROM sales."Leads" WHERE sales."Leads"."UID" =' . $UID . ' ';
        $LeadsDetails = $Crud->ExecuteSQL($SQL);
        return $LeadsDetails[0];
    }

    public function GetTotalLeads($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'Select count("sales"."Leads".*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '    ';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }
        $TotalLeads = $Crud->ExecuteSQL($SQL);
        return $TotalLeads[0]['count'];
    }

    public function GetFreshLeads($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL = 'Select Count(*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '  AND "Leads"."UserID" > 0   AND "Leads"."Status" = \'new\'';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }
        $FreshLeads = $Crud->ExecuteSQL($SQL);
        return $FreshLeads[0]['count'];
    }

    public function GetProductBasedLeadStatus($DomainID, $product, $status, $LeadCategory = '') // hammad product based stats get
    {
        $session = session();
        $session = $session->get();

        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'SELECT "sales"."LeadsProduct"."ProductName",COUNT("sales"."Leads"."UID") AS "TOTAL"
               FROM "sales"."Leads"
               LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )
               WHERE  "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . '
               AND   "LeadsProduct"."ProductName" =  \'' . $product . '\' 
               AND   "Leads"."Status" = \'' . $status . '\'  ';
        if($LeadCategory != '' ){
            $SQL .= '  AND  "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }

        $SQL .= ' GROUP BY "sales"."LeadsProduct"."ProductName"';

        $record = $Crud->ExecuteSQL($SQL);
        $finalarray = array_column($record, 'TOTAL', 'ProductName');
        return $finalarray;

    }

    public function GetUnAssignLeads($DomainID, $LeadCategory = '')
    {
        $Crud = new Crud();
        $SQL = 'Select Count(*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" = ' . $DomainID . '    AND ( "Leads"."UserID" IS NULL OR "Leads"."UserID" = 0 )';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        $UnAssignLeads = $Crud->ExecuteSQL($SQL);
        return $UnAssignLeads[0]['count'];
    }

    public function GetTodayFollowUpLeads($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'Select Count(*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . '
           AND "Leads"."CallBackDateTime"  BETWEEN  \'' . date("Y-m-d") . ' 00:00:01\' AND  \'' . date("Y-m-d") . ' 23:59:59\'
           ';

        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }

        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }

        $TodayFollowUpLeads = $Crud->ExecuteSQL($SQL);
        return $TodayFollowUpLeads[0]['count'];
    }


    public function GetPendingFollowUpLeads($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'Select Count(*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . ' AND "Leads"."CallBackDateTime"  <  \'' . date("Y-m-d") . ' 00:00:01\' ';

        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }

        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }
        $PendingFollowUpLeads = $Crud->ExecuteSQL($SQL);
        return $PendingFollowUpLeads[0]['count'];
    }

    public function GetUpComingFollowUpLeads($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
        $SQL = '';
        $SQL .= 'Select Count(*) FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . ' AND "Leads"."CallBackDateTime"  >  \'' . date("Y-m-d") . ' 23:59:59\'';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }

        $UpComingFollowUpLeads = $Crud->ExecuteSQL($SQL);
        return $UpComingFollowUpLeads[0]['count'];
    }


    public
    function AddPropertyOption($TagID, $LeadUID, $Value)
    {

        $Crud = new Crud();
        if ($Value == 1) {
            $Crud->AddRecord('sales."LeadsMeta"',
                array('SystemDate' => date("Y-m-d H:i:s"),
                    'LeadID' => $LeadUID,
                    'Options' => 'tags',
                    'Value' => $TagID)
            );
        } else {
            $Crud->DeleteRecord('sales."LeadsMeta"', array('LeadID' => $LeadUID, 'Options' => 'tags', 'Value' => $TagID));
        }
    }


    public function get_lead_comments_data($limit = '', $offset = '')
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['LeadsCommentsSessionFilters'];

        $Crud = new Crud();
        $SQL = 'SELECT sales."Leads".*, main."Users"."FullName" AS "SaleOfficer",
                        ( 
                          SELECT "SystemDate" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."LeadsUID" = sales."Leads"."UID" ORDER BY sales."LeadsActivity"."SystemDate" DESC Limit 1
                        ) as "LastCommentDateTime",
                        (
                        SELECT "Activity" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."LeadsUID" = sales."Leads"."UID" ORDER BY sales."LeadsActivity"."SystemDate" DESC Limit 1
                        ) as "LastComment" 
                 FROM sales."Leads"
                 LEFT JOIN main."Users" ON sales."Leads"."UserID"= main."Users"."UID"
                WHERE ( 
                  SELECT "SystemDate" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."LeadsUID" = sales."Leads"."UID" ORDER BY sales."LeadsActivity"."SystemDate" DESC Limit 1
                ) IS NOT NULL
                ORDER BY ( 
                  SELECT "SystemDate" FROM sales."LeadsActivity" WHERE sales."LeadsActivity"."LeadsUID" = sales."Leads"."UID" ORDER BY sales."LeadsActivity"."SystemDate" DESC Limit 1
                ) DESC ';

        $SQL = ' SELECT * FROM (' . $SQL . ') AS "MainQuery" WHERE 1=1 ';

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "MainQuery"."UserID" = ' . $SessionFilters['sale_officer'] . ' ';
        }

        if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
            $SQL .= ' AND "MainQuery"."ProductID" = \'' . $SessionFilters['product'] . '\' ';
        }

        if (isset($SessionFilters['comments_start_date']) && $SessionFilters['comments_start_date'] != '' && isset($SessionFilters['comments_end_date']) && $SessionFilters['comments_end_date'] != '') {
            $SQL .= ' AND "MainQuery"."LastCommentDateTime" BETWEEN \'' . date("Y-m-d", strtotime($SessionFilters['comments_start_date'])) . ' 00:00:01\' AND \'' . date("Y-m-d", strtotime($SessionFilters['comments_end_date'])) . ' 23:59:59\' ';
        }


        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }
        $leadsrecords = $Crud->ExecuteSQL($SQL);
        return $leadsrecords;
    }

    public function CountLeadStatus($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();

        /*$SQL1 = 'SELECT "sales"."Leads"."Status",COUNT("sales"."Leads"."UID") AS "TOTAL"
                FROM "sales"."Leads"
                JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )
                WHERE  "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . '
                GROUP BY "sales"."Leads"."Status" ';*/

        $SQL = '';
        $SQL .= 'Select "Leads"."Status", Count(*) AS "TOTAL" FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . '  ';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }
        $SQL .= ' Group By  "Leads"."Status"';

        $record = $Crud->ExecuteSQL($SQL);
        $finalarray = array_column($record, 'TOTAL', 'Status');
        return $finalarray;
    }

    public function CountLeadProducts($DomainID, $LeadCategory = '')
    {
        $session = session();
        $session = $session->get();
        $Crud = new Crud();
//        $SQL_old = 'Select "Leads"."ProductID", Count(*) AS "TOTAL" FROM "sales"."Leads" Where "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . ' Group By  "Leads"."ProductID"';
        $SQL = '';
        $SQL .= ' SELECT "sales"."LeadsProduct"."ProductName",COUNT("sales"."Leads"."UID") AS "TOTAL"
                FROM "sales"."Leads"
                LEFT JOIN "sales"."LeadsProduct" ON ( "sales"."LeadsProduct"."LeadID" = "sales"."Leads"."UID" )
                WHERE  "Leads"."Archive"  = 0  AND   "Leads"."DomainID" =  ' . $DomainID . ' ';
        if ($LeadCategory != '') {
            $SQL .= '  AND   "Leads"."LeadCategory" = \'' . $LeadCategory . '\' ';
        }
        if ($session['profile']['ParentID'] > 0 && $session['type'] == 'sale-officer') {
            $SQL .= ' AND "Leads"."UserID" = ' . $session['profile']['UID'] . ' ';
        }

        $SQL .= ' GROUP BY "sales"."LeadsProduct"."ProductName"';
        $record = $Crud->ExecuteSQL($SQL);
//        $finalarray = array_column($record, 'TOTAL', 'ProductID');
        $finalarray = array_column($record, 'TOTAL', 'ProductName');
        return $finalarray;
    }

    public function get_new_products_data($limit = '', $offset = '', $product = '')
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['NewLeadsSessionFilters'];
        $Crud = new Crud();
        $SQL = 'SELECT "sales"."Leads".*,
                CASE 
                    WHEN "sales"."Leads"."UserID" > 0 
                        THEN ( SELECT "Users"."FullName" FROM main."Users" WHERE main."Users"."UID" =  "sales"."Leads"."UserID" )
                    ELSE \'-\'
                END AS "SaleOfficer"
                FROM sales."Leads" 
                WHERE sales."Leads"."Status" = \'new\' ';
        if ($product != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $product . '\' ';
        }

        if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '' &&
            isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."CreatedAt" BETWEEN \'' . $SessionFilters['create_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['create_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['distribution_start_date']) && $SessionFilters['distribution_start_date'] != '' &&
            isset($SessionFilters['distribution_end_date']) && $SessionFilters['distribution_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."LeadAssignmentDate" BETWEEN \'' . $SessionFilters['distribution_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['distribution_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\'
                            OR LOWER("sales"."Leads"."Email") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        $SQL .= ' ORDER BY "sales"."Leads"."CreatedAt" DESC ';

        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }

        // echo $SQL; exit;
        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public function last_month_data($limit = '', $offset = '', $product = '')
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['LastThirtyDaysLeadsSessionFilters'];
        $Crud = new Crud();
        $SQL = ' SELECT "sales"."Leads".*,
                        CASE 
                            WHEN "sales"."Leads"."UserID" > 0 
                                THEN ( SELECT "Users"."FullName" FROM main."Users" WHERE main."Users"."UID" =  "sales"."Leads"."UserID" )
                            ELSE \'-\'
                        END AS "SaleOfficer"
                FROM "sales"."Leads" WHERE 1=1';
        if ($product != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $product . '\' ';
        }

        if (isset($SessionFilters['old_record']) && $SessionFilters['old_record'] == 'yes') {
            //$SQL .= 'AND leads.CreatedAt  > CURRENT_DATE - INTERVAL 30 DAY  ';
        } else {
            $SQL .= ' AND  DATE("sales"."Leads"."CreatedAt") >= (DATE(NOW()) - INTERVAL \'30\' DAY)';
        }

        if (isset($SessionFilters['distribution_start_date']) && $SessionFilters['distribution_start_date'] != '' &&
            isset($SessionFilters['distribution_end_date']) && $SessionFilters['distribution_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."LeadAssignmentDate" BETWEEN \'' . $SessionFilters['distribution_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['distribution_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\'
                            OR LOWER("sales"."Leads"."Email") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['status']) && $SessionFilters['status'] != '') {
            $SQL .= ' AND "sales"."Leads"."Status" = \'' . $SessionFilters['status'] . '\' ';
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        $SQL .= ' ORDER BY "sales"."Leads"."CreatedAt" DESC ';

        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . '';
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function get_callback_data($limit = '', $offset = '', $product = '', $call_back_month = '', $Filters = array())
    {
        $Crud = new Crud();
        $SQL = ' SELECT "sales"."Leads".*,"main"."Users"."FullName" AS "SalesOfficer" 
                        FROM "sales"."Leads" 
                        LEFT JOIN main."Users" ON (main."Users"."UID" = sales."Leads"."UserID")
                        WHERE "sales"."Leads"."Archive" = 0 ';

        if ($product != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $product . '\' ';
        }

        if ($call_back_month == 'current_month') {
            if (isset($Filters['LeadStatus']) && $Filters['LeadStatus'] != '') {
                $SQL .= ' AND "sales"."Leads"."Status" = \'' . $Filters['LeadStatus'] . '\' ';
            }
            $SQL .= 'AND "sales"."Leads"."CallBackDateTime"  BETWEEN \'' . date("Y-m-1") . ' 00:00:01 \' AND \'' . date("Y-m-d") . ' 23:59:59 \' ';

        } else if ($CallBackStatus == 'previous') {
            if (isset($Filters['LeadStatus']) && $Filters['LeadStatus'] != '') {
                $SQL .= ' AND "sales"."Leads"."Status" = \'' . $Filters['LeadStatus'] . '\' ';
            }

            $SQL .= 'AND "sales"."Leads"."CallBackDateTime" <  \'' . date("Y-m-1") . ' 00:00:01 \' ';
        }

        if (isset($Filters['Products']) && $Filters['Products'] != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $Filters['Products'] . '\' ';
        }


        if ($call_back_month != '') {
            $SQL .= ' ORDER BY "sales"."Leads"."CallBackDateTime" DESC ';
        }

        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . '';
        }

        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function personal_products_data($limit = '', $offset = '', $PersonalProduct = '')
    {
        $data = $this->data;
        $session = session();
        $session = $session->get();
        $UserID = $session['id'];

        $Crud = new Crud();
        $DomainID = $data['session']['domainid'];
        $SessionFilters = $session['PersonalLeadsSessionFilters'];

        $SQL = '';
        $SQL .= 'SELECT "sales"."Leads".*,
                        CASE 
                            WHEN "sales"."Leads"."UserID" > 0 
                                THEN ( SELECT "Users"."FullName" FROM main."Users" WHERE main."Users"."UID" =  "sales"."Leads"."UserID" )
                            ELSE \'-\'
                        END AS "SaleOfficer"
                FROM sales."Leads" 
                WHERE sales."Leads"."Personal" = 1 
                AND sales."Leads"."UserID" = \'' . $UserID . '\'';
        $SQL .= ' AND sales."Leads"."DomainID" = \'' . $DomainID . '\' ';
        $SQL .= ' AND sales."Leads"."Archive" = 0 ';
        if ($PersonalProduct != '') {
            $SQL .= ' AND "sales"."Leads"."ProductID" = \'' . $PersonalProduct . '\' ';
        }

        if (isset($SessionFilters['create_start_date']) && $SessionFilters['create_start_date'] != '' &&
            isset($SessionFilters['create_end_date']) && $SessionFilters['create_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."CreatedAt" BETWEEN \'' . $SessionFilters['create_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['create_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['distribution_start_date']) && $SessionFilters['distribution_start_date'] != '' &&
            isset($SessionFilters['distribution_end_date']) && $SessionFilters['distribution_end_date'] != '') {
            $SQL .= ' AND "sales"."Leads"."LeadAssignmentDate" BETWEEN \'' . $SessionFilters['distribution_start_date'] . ' 00:00:01\' 
                        AND \'' . $SessionFilters['distribution_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $SQL .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          AND  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $SQL .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\'
                            AND LOWER("sales"."Leads"."Email") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $SQL .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        $SQL .= ' ORDER BY "sales"."Leads"."CreatedAt" ASC';
        if ($limit != '' && $offset != '' && $limit != -1) {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . '';
        }
        $records = $Crud->ExecuteSQL($SQL);
        return $records;
    }

    public function get_exports_leads_data($limit = '', $offset = '')
    {
        $session = session();
        $session = $session->get();
        $SessionFilters = $session['LeadsExportsSessionFilters'];

        $Crud = new Crud();
        $sql = 'SELECT * FROM "sales"."Leads" WHERE 1=1';

        if (isset($SessionFilters['exports_start_date']) && $SessionFilters['exports_start_date'] != '' &&
            isset($SessionFilters['exports_end_date']) && $SessionFilters['exports_end_date'] != '') {
            $sql .= ' AND "sales"."Leads"."CreatedAt" Between \'' . $SessionFilters['exports_start_date'] . ' 00:00:01\' AND \'' . $SessionFilters['exports_end_date'] . ' 23:59:59\' ';
        }

        if (isset($SessionFilters['keyword']) && $SessionFilters['keyword'] != '') {

            $KeywordInt = (int)$SessionFilters['keyword'];
            if (is_int($KeywordInt) && trim($KeywordInt) != '' && trim($KeywordInt) != 0) {

                $sql .= ' AND  "sales"."Leads"."ContactNo" LIKE  \'%' . trim($KeywordInt) . '%\'
                          OR  "sales"."Leads"."WhatsAppNo" LIKE  \'%' . trim($KeywordInt) . '%\'  ';
            } else {

                $sql .= ' AND  LOWER("sales"."Leads"."FullName") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\'
                     OR LOWER("sales"."Leads"."Email") LIKE  \'%' . strtolower(trim($SessionFilters['keyword'])) . '%\' ';
            }
        }

        if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
            $sql .= ' AND "sales"."Leads"."UserID" = \'' . $SessionFilters['sale_officer'] . '\' ';
        }

        if (isset($SessionFilters['statusname']) && $SessionFilters['statusname'] != '') {
            $sql .= 'AND sales."Leads"."Status" =\'' . $SessionFilters['statusname'] . '\' ';
        }
        if (isset($SessionFilters['productname']) && $SessionFilters['productname'] != '') {
            $sql .= 'AND LOWER(sales."Leads"."ProductID") = \'' . strtolower(trim($SessionFilters['productname'])) . '\' ';
        }

        if ($limit != '' && $offset != '' && $limit != -1) {
            $sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . '';
        }

        $records = $Crud->ExecuteSQL($sql);
        return $records;
    }


    public
    function GetWorkSheetDataForPrintByUID($WorkSheetUID)
    {
        $FinalArray = array();
        $Crud = new Crud();

        $Records = $Crud::SingleRecord('sales."Worksheet"', array('UID' => $WorkSheetUID));
        if (isset($Records['UID'])) {
            $Users = $Crud::SingleRecord('main."Users"', array('UID' => $Records['UserID']));

            /** Work Sheet Single Record Array **/
            $FinalArray['Sheet']['UID'] = $Records['UID'];
            $FinalArray['Sheet']['SystemDate'] = $Records['SystemDate'];
            $FinalArray['Sheet']['UserUID'] = $Records['UserID'];
            $FinalArray['Sheet']['UserName'] = $Users['FullName'];
            $FinalArray['Sheet']['CreatedAt'] = $Records['CreatedAt'];

            /** Work Sheet MetaData Record Segment **/
            $SQL = 'SELECT "Lookups"."Key", "Lookups"."Name" AS "LookUpName" , 
                            "LookupsOptions"."Name" , "WorksheetMeta"."Performed" , "WorksheetMeta"."Remarks" 
                    FROM sales."WorksheetMeta"
                    JOIN main."LookupsOptions" ON ("WorksheetMeta"."OptionUID" = "LookupsOptions"."UID")
                    JOIN main."Lookups" ON ("LookupsOptions"."LookupID" = "Lookups"."UID")
                    WHERE ("WorksheetMeta"."WorkSheetUID" = ' . $WorkSheetUID . ')
                    ORDER BY "Lookups"."Key" , "Lookups"."Name" , "LookupsOptions"."Name" ';
            $WorkSheetMetaDataRecords = $Crud->ExecuteSQL($SQL);

            foreach ($WorkSheetMetaDataRecords as $WSMDR) {
                $temp = array();
                $temp['title'] = $WSMDR['Name'];
                $temp['remarks'] = $WSMDR['Remarks'];

                $FinalArray['WorkSheetMeta'][$WSMDR['LookUpName']][] = $temp;
            }
        }

        return $FinalArray;
    }

    public function AgentsLoginDetails($DomainID)
    {
        $Crud = new Crud();
        $SQL = 'SELECT * FROM "main"."Users" WHERE "Users"."UserType" = \'sale-officer\' AND "Users"."Archive" = 0 
                AND "Users"."DomainID" = ' . $DomainID . ' AND "Users"."LastLoginDetails"  BETWEEN  \'' . date("Y-m-d") . ' 00:00:01\' AND  \'' . date("Y-m-d") . ' 23:59:59\'';
        $Finalarray = $Crud->ExecuteSQL($SQL);

        return $Finalarray;
    }

}