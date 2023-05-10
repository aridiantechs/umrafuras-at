<?php namespace App\Models;

use CodeIgniter\Model;

use App\Models\Main;
use App\Models\Crud;

class EmailCampaignModel extends Model
{

    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public function saveEmailList($records, $UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailsLists"';

        $SQL = 'SELECT * FROM "marketing"."EmailsLists" WHERE "FullName" = \'' . $records['FullName'] . '\'';

        if ($UID == 0) {

            $ValidateListName = $Crud->ExecuteSQL($SQL);

            if (count($ValidateListName) > 0) {
                $response['message'] = "List Name Already Exist...";
                $response['status'] = "Duplicate List";
                echo json_encode($response);
            } else {
                $final = $Crud->AddRecord($table, $records);
                $response['status'] = 'success';
                $response['message'] = 'List Added Successfully';
                echo json_encode($response);
            }
        } else {

            $where = array('UID' => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = 'success';
            $response['message'] = 'List Updated Successfully';
            echo json_encode($response);
        }

    }

    public function AddEmailCampaigns($records, $UpdateUID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."Campaigns"';
        if ($UpdateUID == 0) {
            $SQL = 'SELECT * FROM "marketing"."Campaigns" WHERE "Campaigns"."SenderEmail" = \'' . $records['SenderEmail'] . '\' AND  "Campaigns"."DomainID" = ' . $records['DomainID'] . ' ';
            $check = $Crud->ExecuteSQL($SQL);
            if (count($check) > 0) {
                $response['status'] = 'alert';
                $response['message'] = 'Email Already Exist...';
                echo json_encode($response);
            } else {
                $Crud->AddRecord($table, $records);
                $response = array();
                $response['status'] = 'success';
                $response['message'] = 'Record Added Successfully';
                echo json_encode($response);
            }
        }else{
            $where = array('UID'=>$UpdateUID);
            $Crud->UpdateRecord($table,$records,$where);
            $response = array();
            $response['status'] = 'success';
            $response['message'] = 'Record Updated Successfully';
            echo json_encode($response);
        }

    }

    public function EmailCamaignsList($DomainID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQl = 'SELECT * FROM "marketing"."Campaigns" WHERE "Campaigns"."Archive" = 0 AND  "Campaigns"."DomainID" = ' . $DomainID . ' ORDER BY "Campaigns"."Title" ';
        $finalArray = $Crud->ExecuteSQL($SQl);
        return $finalArray;
    }

    public function GetEmailLists($DomainID, $limit = '', $offset = '')
    {
        $data = $this->data;
        $Crud = new Crud();
//        $SQL_OLD = 'SELECT * FROM "marketing"."EmailsLists" WHERE "Archive" = 0 AND "DomainID" = ' . $DomainID . ' ';
        $SQL = '';
        $SQL .= 'SELECT    "marketing"."EmailsLists".*, (SELECT COUNT("EmailIDs"."UID") FROM "marketing"."EmailIDs" 
                WHERE "marketing"."EmailIDs"."EmailsListID" = "marketing"."EmailsLists"."UID" ) AS "TotalEmailIDs"
                FROM "marketing"."EmailsLists" 
                WHERE "marketing"."EmailsLists"."Archive" = 0 AND  "marketing"."EmailsLists"."DomainID" = ' . $DomainID . ' ORDER BY "EmailsLists"."FullName" ASC  ';

        if ($limit != '' && $limit != -1 && $offset != '') {
            $SQL .= ' LIMIT ' . $limit . ' OFFSET ' . $offset . ' ';
        }


        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }
    public function GetEmailCampaign($DomainID){
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'Select "Campaigns"."UID","Campaigns"."Title" FROM "marketing"."Campaigns" WHERE "Campaigns"."Archive" = 0 AND  "Campaigns"."DomainID" = '.$DomainID.' Order by "Campaigns"."Title" ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function DeleteEmailLists($UID, $DomainID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailsLists"';
        $record['Archive'] = 1;
        $where = array('UID' => $UID, 'DomainID' => $DomainID);
        $Crud->UpdateRecord($table, $record, $where);
        $response['status'] = 'success';
        echo json_encode($response);

    }

    public function GetEmailListDataByID($recordid)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailsLists"';
        $where = array('UID' => $recordid);
        $records = $Crud->SingleRecord($table, $where);
        return $records;
    }

    public function saveEmailwithGroups($record)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailIDs"';
        $returnId = $Crud->AddRecord($table, $record);
        return $returnId;

    }

    public function ViewAllEmailList($DomainID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailsLists"';
//        $SQL_old = 'SELECT DISTINCT "EmailIDs"."Email", "EmailIDs"."FullName","EmailIDs"."Status"
//                FROM "marketing"."EmailIDs" WHERE "EmailIDs"."DomainID" =   ' . $DomainID . '
//                Group BY   "EmailIDs"."FullName" , "EmailIDs"."Email" ,"EmailIDs"."Status"    ';
//        $SQL_old2 = 'SELECT DISTINCT("marketing"."EmailIDs"."Email"),
//                    string_agg("marketing"."EmailsLists"."FullName", \',\') AS "List",
//                    "marketing"."EmailIDs"."Status" AS "Status",
//                    "marketing"."EmailIDs"."FullName" AS "UserFullName"
//                    FROM "marketing"."EmailsLists"
//                    LEFT JOIN "marketing"."EmailIDs" ON "marketing"."EmailIDs"."EmailsListID" = "marketing"."EmailsLists"."UID"
//                    GROUP BY "marketing"."EmailIDs"."Email","marketing"."EmailIDs"."Status","marketing"."EmailIDs"."FullName"';

        $SQL = ' SELECT DISTINCT("marketing"."EmailIDs"."Email"),                
                "marketing"."EmailIDs"."FullName" AS "UserFullName"
                FROM "marketing"."EmailIDs" 
                GROUP BY "marketing"."EmailIDs"."Email","marketing"."EmailIDs"."FullName"  
                order by "UserFullName" 
                 ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function SetEmailStatus($Email)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT "marketing"."EmailIDs".* ,"marketing"."EmailsLists"."FullName" AS "listName" FROM "marketing"."EmailIDs" 
                LEFT JOIN   "marketing"."EmailsLists" ON "marketing"."EmailsLists"."UID"  = "marketing"."EmailIDs"."EmailsListID"
                WHERE  "EmailIDs"."Email" = \'' . $Email . '\'  AND "marketing"."EmailsLists"."Archive" = 0     
                order by "listName"
                ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
//        echo "<pre>";
//        print_r($FinalArray);
//        exit;
        return $FinalArray;
    }

    public function ListStatusChange($UID, $Status)
    {
        $data = $this->data;
        $Crud = new Crud();
        $table = 'marketing."EmailIDs"';
        $where = array('UID' => $UID);
        $record['Status'] = $Status;
        $Final = $Crud->UpdateRecord($table, $record, $where);
        $response['status'] = 'success';
        $response['message'] = 'Status Updated Successfully';
        echo json_encode($response);
    }

    public function UpdateEmailLists($Email)
    {

        $data = $this->data;
        $Crud = new Crud();

        $SQL = 'SELECT "marketing"."EmailIDs".* ,"marketing"."EmailsLists"."FullName" AS "listName" FROM "marketing"."EmailIDs" 
                LEFT JOIN   "marketing"."EmailsLists" ON "marketing"."EmailsLists"."UID"  = "marketing"."EmailIDs"."EmailsListID"
                WHERE  "EmailIDs"."Email" = \'' . $Email . '\'  AND "marketing"."EmailsLists"."Archive" = 0     
                order by "listName"
                ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
//        echo "<pre>";
//        print_r($FinalArray);
//        exit;
        return $FinalArray;
    }

    public function ListOFAllEmailByID($UID)
    {
        $data = $this->data;
        $Crud = new Crud();
//        $SQL_old = 'SELECT "marketing"."EmailsLists"."UID", "marketing"."EmailsLists"."FullName" AS "ListName" ,
//                    "marketing"."EmailsLists"."DomainID",
//                    "marketing"."EmailsLists"."Archive", "marketing"."EmailIDs"."FullName", "marketing"."EmailIDs"."Email"
//                     FROM  "marketing"."EmailsLists"
//                    LEFT JOIN  "marketing"."EmailIDs" ON "marketing"."EmailsLists"."UID" =  "marketing"."EmailIDs"."EmailsListID"
//                    Where "marketing"."EmailsLists"."UID" =  '.$UID.'  AND "marketing"."EmailsLists"."Archive" = 0';


        $SQL = 'SELECT "marketing"."EmailIDs"."FullName", "marketing"."EmailIDs"."Email"
                FROM  "marketing"."EmailsLists" 
                LEFT JOIN  "marketing"."EmailIDs" ON "marketing"."EmailsLists"."UID" =  "marketing"."EmailIDs"."EmailsListID" 
                Where "marketing"."EmailsLists"."UID" = ' . $UID . '  AND "marketing"."EmailsLists"."Archive" = 0 ';

        $FinalArray = $Crud->ExecuteSQL($SQL);
//        echo "<pre>";
//        print_r($FinalArray);
//        exit;
        return $FinalArray;

    }

    public function GetListNameByID($UID)
    {
        $data = $this->data;
        $Crud = new Crud();
        $SQL = 'SELECT * FROM  "marketing"."EmailsLists" Where  "marketing"."EmailsLists"."UID" = ' . $UID . '   AND  "marketing"."EmailsLists"."Archive"  = 0 ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }

    public function ListEmailAndName($FinalArray)
    {

        $Crud = new Crud();
        $table = 'marketing."EmailIDs"';
        $Array = $Crud->AddRecord($table, $FinalArray);
        return $Array;
    }

    public function DeleteEmailCamapignRecord($UID)
    {
        $Crud = new Crud();
        $table = 'marketing."Campaigns"';
        $record['Archive'] = 1;
        $where = array('UID' => $UID);
        $Array = $Crud->UpdateRecord($table, $record, $where);
        $response = array();
        $response['status'] = 'success';
        echo json_encode($response);
    }

    public function GetEmailCampaignsDataByID($UID)
    {
        $Crud = new Crud();
        $table = 'marketing."Campaigns"';
        $where = array('UID' => $UID);
        $Array = $Crud->SingleRecord($table, $where);
        return $Array;
    }
    public function GetTotalEmailListsData($ListID){
        $Crud = new Crud();
        $SQL = 'SELECT count(*) FROM "marketing"."EmailIDs" WHERE "EmailsListID" =  '.$ListID.'  ';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }
    public function GetRemainingEmailListsData($ListID,$CampaignID){
        $Crud = new Crud();
        $SQL = 'SELECT count(*) FROM "marketing"."InfoLog" WHERE "InfoLog"."LoggedCampaignID" = '.$CampaignID.' AND "InfoLog"."LoggedEmail" IN ( SELECT  "marketing"."EmailIDs"."Email" 
                FROM "marketing"."EmailIDs" WHERE "EmailIDs"."EmailsListID" = '.$ListID.' )';
        $FinalArray = $Crud->ExecuteSQL($SQL);
        return $FinalArray;
    }
    public function RunEmailCampaignsData($records){
        $Crud = new Crud();

        $SQL = 'SELECT * FROM "marketing"."NewsletterCrone" WHERE  "NewsletterCrone"."CampaignID" = '.$records['CampaignID'].'
                AND "NewsletterCrone"."ListID" = '.$records['ListID'].' AND "NewsletterCrone"."DomainID" = '.$records['DomainID'].' ';

        $FinalArray = $Crud->ExecuteSQL($SQL);
        if(count($FinalArray)>0){
            $response = array();
            $response['status'] = 'alert';
            $response['message'] = 'Campaign Already Exists...';
            echo json_encode($response);
        }else{
            $table = 'marketing."NewsletterCrone"';
            $Crud->AddRecord($table,$records);
            $response = array();
            $response['status'] = 'success';
            $response['message'] = 'Email Campaigns Successfully Added';
            echo json_encode($response);
        }



    }




}