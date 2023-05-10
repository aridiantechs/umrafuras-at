<?php namespace App\Models;

use App\Models\Main;
use App\Models\Crud;
use CodeIgniter\Model;



class MofaProcess extends Model
{
    var $data = array();
    protected $session;
    protected $table = 'websites."Domains"';

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function MOFAlist()
    {
        $data = $this->data;

        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $MOFASearchFilter = $session['MOFASearchFilter'];

        $SQL = 'SELECT * FROM "temp"."mofa_file" ORDER BY "temp"."mofa_file"."Group" ASC  ';

        if(isset($MOFASearchFilter['passport_number']) && $MOFASearchFilter['passport_number']!=''){
            $SQL .= ' AND "temp"."mofa_file"."PassportNo" = \''.$MOFASearchFilter['passport_number'].'\' ';
        }

        if(isset($MOFASearchFilter['name'])){
            $SQL .= ' AND LOWER("temp"."mofa_file"."PilgrimName") LIKE \'%'.strtolower($MOFASearchFilter['name']).'%\' ';
        }



//     echo $SQL;exit;

        //$records = $Crud->ExecuteSQL($SQL);
        return $SQL;


//        $data = $this->data;
//
//        $Crud = new Crud();
//        $table = 'temp."mofa_file"';
//        $where = array();
//        $order = array("ExtAgent" => "ASC");
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;
    }


    public
    function GetMOFAlist()
    {
        $data = $this->data;

        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $MOFASearchFilter = $session['MOFASearchFilter'];

        $SQL = 'SELECT * FROM "temp"."mofa_file" 
                WHERE 1=1';

        if(isset($MOFASearchFilter['passport_number']) && $MOFASearchFilter['passport_number']!=''){
            $SQL .= ' AND "temp"."mofa_file"."PassportNo" = \''.$MOFASearchFilter['passport_number'].'\' ';
        }

        if(isset($MOFASearchFilter['name'])){
            $SQL .= ' AND LOWER("temp"."mofa_file"."PilgrimName") LIKE \'%'.strtolower($MOFASearchFilter['name']).'%\' ';
        }

        /** Filters Start */
        if (isset($_POST['group']) && trim($_POST['group']) != '') {
            $SQL .= ' AND "temp"."mofa_file"."GroupName" = \'' . trim($_POST['group']) . '\' ';
        }

        if (isset($_POST['pkg_code']) && trim($_POST['pkg_code']) != '') {
            $SQL .= ' AND "temp"."mofa_file"."PKGCode" = \'' . trim($_POST['pkg_code']) . '\' ';
        }

        if (isset($_POST['pilgrim_name']) && trim($_POST['pilgrim_name']) != '') {
            $SQL .= ' AND LOWER("temp"."mofa_file"."PilgrimName") LIKE \'%' . strtolower(trim($_POST['pilgrim_name'])) . '%\' ';
        }

        if (isset($_POST['pilgrim_id']) && trim($_POST['pilgrim_id']) != '') {
            $SQL .= ' AND "temp"."mofa_file"."PilgrimID" =  \'' . trim($_POST['pilgrim_id']) . '\' ';
        }

        if (isset($_POST['mofa_no']) && trim($_POST['mofa_no']) != '') {
            $SQL .= ' AND "temp"."mofa_file"."MOFANumber" =  \'' . trim($_POST['mofa_no']) . '\' ';
        }

        if (isset($_POST['issue_date_from']) && $_POST['issue_date_from'] != '' && isset($_POST['issue_date_to']) && $_POST['issue_date_to'] != '') {
            $SQL .= ' AND  "temp"."mofa_file"."IssueDateTime" BETWEEN \'' . date("Y-m-d", strtotime($_POST['issue_date_from'])) . ' 00:00:00\'  AND \'' . date("Y-m-d", strtotime($_POST['issue_date_to'])) . ' 23:59:59\'  ';
        }
        /** Filters ENDS */

        $SQL.='ORDER BY "temp"."mofa_file"."Group" ASC';

        //$records = $Crud->ExecuteSQL($SQL);
//       echo $SQL;exit;

        //$records = $Crud->ExecuteSQL($SQL);
//        return $SQL;
        return $SQL;


//        $data = $this->data;
//
//        $Crud = new Crud();
//        $table = 'temp."mofa_file"';
//        $where = array();
//        $order = array("ExtAgent" => "ASC");
//        $records = $Crud->ListRecords($table, $where, $order);
//
//        return $records;
    }
    public
    function VISANotPrinted()
    {
        $data = $this->data;

        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $VisaNotPrintedSearchFilter = $session['VisaNotPrintedSearchFilter'];

        $SQL = 'SELECT "pilgrim"."master".*, "pilgrim"."mofa".*, "main"."Groups"."FullName" as "GroupFullName", "main"."Agents"."FullName" as "AgentFullName"  FROM "pilgrim"."master"
        INNER JOIN "pilgrim"."mofa"  ON mofa."PilgrimID" = master."UID" 
        INNER JOIN "main"."Groups" ON "main"."Groups"."UID" = "pilgrim"."master"."GroupUID" 
        INNER JOIN "main"."Agents" ON "main"."Agents"."UID" = "pilgrim"."master"."AgentUID" 
        ORDER BY  "pilgrim"."master"."FirstName" ASC
        WHERE "pilgrim"."mofa"."MOFANumber" NOT IN (SELECT "pilgrim"."visa"."MOFANumber" FROM "pilgrim"."visa")';

        if(isset($VisaNotPrintedSearchFilter['name'])){
            $SQL .= ' AND LOWER("pilgrim"."master"."FirstName") LIKE \'%'.strtolower($VisaNotPrintedSearchFilter['name']).'%\' ';
        }
//        if(isset($VisaNotPrintedSearchFilter['Group'])){
//            $SQL .= ' AND "pilgrim"."master"."GroupUID" =  \''.$VisaNotPrintedSearchFilter['Group'].'\' ';
//        }

        if(isset($VisaNotPrintedSearchFilter['passport_number']) && $VisaNotPrintedSearchFilter['passport_number']!=''){
            $SQL .= ' AND "pilgrim"."master"."PassportNumber" = \''.$VisaNotPrintedSearchFilter['passport_number'].'\' ';
        }


//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;
    }

    public
    function VisaIssued()
    {
        $data = $this->data;
        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $VisaIssuedSearchFilter = $session['VisaIssuedSearchFilter'];

        $SQL = 'SELECT "pilgrim"."master".*, "pilgrim"."mofa".*, "main"."Groups"."FullName" as "GroupFullName", "pilgrim"."visa"."VisaAttachment" as "VisaID" , "main"."Agents"."FullName" as "AgentFullName"  FROM "pilgrim"."master"
        INNER JOIN "pilgrim"."mofa"  ON mofa."PilgrimID" = master."UID" 
        INNER JOIN "main"."Groups" ON "main"."Groups"."UID" = "pilgrim"."master"."GroupUID" 
        INNER JOIN "main"."Agents" ON "main"."Agents"."UID" = "pilgrim"."master"."AgentUID" 
        INNER JOIN "pilgrim"."visa" ON "pilgrim"."visa"."PilgrimID" = "pilgrim"."master"."UID" 
        ORDER BY  "pilgrim"."master"."FirstName" ASC
        WHERE "pilgrim"."mofa"."MOFANumber" IN (SELECT "pilgrim"."visa"."MOFANumber" FROM "pilgrim"."visa")';

        if(isset($VisaIssuedSearchFilter['name'])){
            $SQL .= ' AND LOWER("pilgrim"."master"."FirstName") LIKE \'%'.strtolower($VisaIssuedSearchFilter['name']).'%\' ';
        }
//        if(isset($VisaIssuedSearchFilter['Group'])){
//            $SQL .= ' AND "pilgrim"."master"."GroupUID" =  \''.$VisaIssuedSearchFilter['Group'].'\' ';
//        }

        if(isset($VisaIssuedSearchFilter['passport_number']) && $VisaIssuedSearchFilter['passport_number']!=''){
            $SQL .= ' AND "pilgrim"."master"."PassportNumber" = \''.$VisaIssuedSearchFilter['passport_number'].'\' ';
        }
//
//        echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        // print_r($records); exit;
        return $records;
    }

    public
    function MofaFormSubmit($record,$name, $BRN)
    {
        $response = array();
        if ($record['path']->store('', $name)) {
            $MainModel = new Main();
            $file = ROOT.'/writable/uploads' . '/'.$name;

            $response = $MainModel->MofaExcelReader($file,$BRN);
        }
        else
        {
            $response['status'] = "fail";
            $response['message'] = "Error Uploading File...";
        }
        echo json_encode($response);
    }

    public
    function VisaUploadData($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $BaseTable = 'pilgrim."mofa"';
        $JoinTable = 'pilgrim."master"';
        $JoinCondtion = 'mofa."PilgrimID" = master."UID"';
        $where = array("UID" => $record_id);
        $order = array();
        $records = $Crud->ListJoinRecords($BaseTable, $JoinTable, $JoinCondtion, $where, $order);
        return $records;
    }

    public
    function VisaFormSubmit($records)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'pilgrim."visa"';
        $Crud->Track("Visa", 'Visa Number "' . $records['VisaNumber'] . '" added in system...');
        $recordID = $Crud->AddRecord($table, $records);
        $Crud->UpdateRecord('pilgrim."master"', array("CurrentStatus" => "visa-issued"), array("UID" => $records['PilgrimID']));
        $response['status'] = "success";
        $response['record_id'] = $recordID;
        $response['message'] = "Visa File Successfully Added...";

        echo json_encode($response);
    }


    /**
     * Development Start
     * By
     * Jawad Sajid Durrani
    */

    public
    function count_mofa_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->MOFAlist();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function get_mofa_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->MOFAlist();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public
    function count_manage_mofa_filtered()
    {
        $Crud = new Crud();
        $SQL = $this->GetMOFAlist();
        $records = $Crud->ExecuteSQL($SQL);
        return count($records);
    }

    public
    function get_manage_mofa_datatables()
    {
        $Crud = new Crud();
        $SQL = $this->GetMOFAlist();
        if ($_POST['length'] != -1)
            $SQL .= ' limit ' . $_POST['length'] . ' offset  ' . $_POST['start'] . '';
        //echo nl2br($SQL);
        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    /**
     * Development ENDS
     * By
     * Jawad Sajid Durrani
    */


}
