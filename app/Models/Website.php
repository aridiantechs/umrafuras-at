<?php namespace App\Models;

use App\Models\Crud;
use App\Models\Main;
use CodeIgniter\Model;



class Website extends Model
{
    var $data = array();


    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public function ContentFormSubmit($records, $UID = 0)
    {
        $data = $this->data;
        $Crud = new Crud();

        $table = 'websites."contents"';
        if ($UID == 0) {
            if ($UID = $Crud->AddRecord($table, $records)) {
                $Crud->Track("Website", 'New Content "' . $records['Title'] . '" added in system...');

                $response['record_id'] = $UID;
                $response['status'] = "success";
                $response['message'] = "Content Successfully Added...";

            } else {
                $response['status'] = "fail";
                $response['message'] = "Data isn't  Submitted correctly...";

            }

        } else {

            $where = array("UID" => $UID);
            if ($Crud->UpdateRecord($table, $records, $where)) {

                $Crud->Track("Website", 'Content "' . $records['Title'] . '" updated in system...');
                $response['status'] = "success";
                $response['message'] = "Content Updated Successfully...";

            } else {
                $response['status'] = "fail";
                $response['message'] = "Content Didnt Updated...";
            }

        }

        echo json_encode($response);
    }

    public function MetaContentFormSubmit($records)
    {
        $data = $this->data;
        $Crud = new Crud();
        // $Contents = array();
        // $Contents = $Crud->ListRecords('websites."contents_meta"', array("Key" => $records['PagePhysical']));
        $table = 'websites."contents_meta"';
        $where = array("PagePhysical" => $records['PagePhysical']);
        $Crud->DeleteRecord($table, $where);
        foreach ($records['MetaContent'] AS $thisKey => $thisData) {
            $record = array();
            $record['PagePhysical'] = $records['PagePhysical'];
            $record['DomainID'] = $records['DomainID'];
            $record['Key'] = $thisKey;
            $record['Description'] = $thisData;
            $record['OrderID'] = 0;
            $Crud->AddRecord($table, $record);
        }
        $Crud->Track("Website", 'Meta Content for page "' . $records['PagePhysical'] . '" Added in system...');
        $response['status'] = "success";
        $response['message'] = "Content Successfully Added...";

        echo json_encode($response);
    }

    public
    function DeleteContent($UID)
    {

        $Crud = new Crud();
        $table = 'websites."contents"';
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
    function DeletePageContent($UID)
    {

        $Crud = new Crud();
        $table = 'websites."contents_meta"';
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
    function CustomerSupportDetails($DomainId,$navProducts)
    {
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("Product" => $navProducts,"DomainID" => $DomainId);
        $order = array("SystemDate" => "DESC");
        $records = $Crud->ListRecords($table, $where,$order);
        return $records;
    }

    public function fetch_All_QueryData($id,$DomainId,$navProducts){

        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("Product" => $navProducts,"DomainID" => $DomainId,"UID"=>$id);
        $records = $Crud->SingleRecord($table, $where);

        return $records;
    }



    public function CustomerImportantQuery($DomainId,$navProducts){
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("Product" => $navProducts,"DomainID" => $DomainId,"Featured"=>'1');
        $order = array("SystemDate" => "DESC");
        $records = $Crud->ListRecords($table, $where,$order);
        return $records;
    }

    public function CustomerStatusQuery($DomainId,$navProducts,$Status){
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("Product" => $navProducts,"DomainID" => $DomainId,"Status" => $Status);
        $order = array("SystemDate" => "DESC");
        $records = $Crud->ListRecords($table, $where,$order);
        return $records;
    }


    public function Status_query_record($UID,$Status){
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("UID"=>$UID);
        $update = array("Status" => $Status);
        if ($Crud->UpdateRecord($table, $update, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }




    public function status_important_query($Status,$UID,$Feature){
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("UID"=>$UID);
        $update = array("Featured" => $Feature);

        if ($Crud->UpdateRecord($table, $update, $where)) {
            $response['status'] = "success";
        } else {
            $response['status'] = "fail";
        }
        echo json_encode($response);

    }


    public function delete_query_record($UID){
        $Crud = new Crud();
        $table = 'websites."CustomerSupport"';
        $where = array("UID"=>$UID);
        if($Crud->DeleteRecord($table, $where)){
            $response['status'] = "success";
        }else {
            $response['status'] = "fail";
        }
        echo json_encode($response);
    }


}
