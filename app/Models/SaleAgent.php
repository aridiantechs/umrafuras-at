<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Crud;
use App\Models\Main;


class SaleAgent extends Model
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;

    }

    public
    function LoadSaleAgentsReferAgents($UID)
    {

        $Crud = new Crud();
        $FinalArray = array();
        $SQL = ' SELECT "Agents"."UID", "Agents"."FullName", "Agents"."PhoneNumber", "Agents"."ContactPersonName",
                    "Cities"."Name" AS "City", "Countries"."Name" AS "Country"
                    FROM main."Agents"
                    JOIN sale_agent."Meta" ON ( CAST("Meta"."Value" AS INTEGER) = CAST("Agents"."UID" AS INTEGER) )
                    JOIN main."Cities" ON ( CAST("Cities"."UID" AS INTEGER) = CAST("Agents"."CityID" AS INTEGER) )
                    JOIN main."Countries" ON ( "Countries"."ISO2" = "Agents"."CountryID" )
                    WHERE "Meta"."Option" = \'Agent_ID\' AND "Meta"."SaleAgentID" = ' . $UID . ' AND "Agents"."Archive" = 0';
        $records = $Crud->ExecuteSQL($SQL);
        foreach ($records as $record) {

            $result = array();
            $result['UID'] = $record['UID'];
            $result['RefCode'] = Code('UF/A/', $record['UID']);
            $result['Country'] = $record['Country'];
            $result['City'] = $record['City'];
            $result['FullName'] = $record['FullName'];
            $result['PhoneNumber'] = $record['PhoneNumber'];
            $result['ContactPersonName'] = $record['ContactPersonName'];

            $FinalArray[] = $result;
        }

        return $FinalArray;
    }

    public function SaleAgentFormSubmit($records, $UID)
    {
        $Users = new Users();
        $data = $this->data;
        $Accesslevel = new AccessLevel();
        $Crud = new Crud();
        $table = 'sale_agent."Agents"';

        ////////////////// Duplicate Email Check
        if ($UID == 0) {
            $email = $Crud->SingleRecord($table, array("Email" => $records['Email']));
            if (isset($email['UID']) && $email['UID'] > 0) {
                $response['status'] = "fail";
                $response['message'] = "Duplicate Sales Agent's Email...";
            } else {
                $Crud->Track("Agent", 'New Sales  Agent "' . $records['FullName'] . '" added in system...');
                if ($recordID = $Crud->AddRecord($table, $records)) {
                    $response['status'] = "success";
                    $response['record_id'] = $recordID;
                    $response['message'] = "Sales Agent Successfully Added...";

                    $SaleAgentAccessLevel = $Accesslevel->saleAgentAccessLevel();
                    $Users->AgentsAccessLevel($response['record_id'], $SaleAgentAccessLevel, 'sale_agent');

                } else {
                    $response['status'] = "fail";
                    $response['message'] = "Data Didn't Submitted Correctly...";

                }
            }
        } else {

            $Crud->Track("Agent", 'Sales Agent "' . $records['FullName'] . '" Updated Succesfully ...');
            $where = array("UID" => $UID);
            $Crud->UpdateRecord($table, $records, $where);
            $response['status'] = "success";
            $response['message'] = "Sales Agent Updated...";

        }


        echo json_encode($response);
    }

    public
    function ListSalesAgent()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SaleAgentSearchFilter = $session['SaleAgentSearchFilter'];

        $SQL = 'SELECT *,
                main."Countries"."Name" as "CountryName",
                main."Cities"."Name" as "CityName",
            sale_agent."Agents"."UID",
            (
            SELECT COUNT("main"."Agents"."UID")  FROM "sale_agent"."Meta"
            INNER JOIN "main"."Agents" ON "main"."Agents"."UID" = cast("sale_agent"."Meta"."Value" as int)
            WHERE "main"."Agents"."Archive" = 0 AND "sale_agent"."Meta"."SaleAgentID"=sale_agent."Agents"."UID") AS "TOTALAGENTS"  
                FROM sale_agent."Agents" 
                LEFT JOIN main."Countries" ON (sale_agent."Agents"."Country" = main."Countries"."ISO2")
                LEFT JOIN main."Cities" ON (cast(sale_agent."Agents"."City" as int) = cast(main."Cities"."UID" as int))
                WHERE "Archive" = \'0\' 
                ORDER BY sale_agent."Agents"."FullName" ASC';

        if (isset($SaleAgentSearchFilter['name'])) {
            $SQL .= ' AND LOWER("FullName") LIKE \'%' . strtolower($SaleAgentSearchFilter['name']) . '%\' ';
        }
        if (isset($SaleAgentSearchFilter['email']) && $SaleAgentSearchFilter['email'] != '') {
            $SQL .= ' AND "Email" = \'' . $SaleAgentSearchFilter['email'] . '\' ';
        }
        if (isset($SaleAgentSearchFilter['phone_number']) && $SaleAgentSearchFilter['phone_number'] != '') {
            $SQL .= ' AND "PhoneNumber" = \'' . $SaleAgentSearchFilter['phone_number'] . '\' ';
        }
        //  echo $SQL;

        $records = $Crud->ExecuteSQL($SQL);
        return $records;

    }


    public
    function DeleteSaleAgents($UID)
    {

        $Crud = new Crud();
        $table = 'sale_agent."Agents"';
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
    function SaleAgentsMeta()
    {

        $Crud = new Crud();
        $table = 'sale_agent."Meta"';
        $where = array();
        $records = $Crud->ListRecords($table, $where);
        return $records;

    }

    public
    function CountSaleAgentsMeta($ID)
    {

        $Crud = new Crud();

        $sql = 'SELECT COUNT("main"."Agents"."UID") AS "TOTALAGENTS" FROM "sale_agent"."Meta"
        INNER JOIN "main"."Agents" ON "main"."Agents"."UID" = cast("sale_agent"."Meta"."Value" as int)
        WHERE "main"."Agents"."Archive" = 0 AND "sale_agent"."Meta"."SaleAgentID" = ' . $ID;
        $records = $Crud->ExecuteSQL($sql);

        return $records;

    }


    public
    function SaleAgentsProfile($record_id)
    {
        $data = $this->data;

        $Crud = new Crud();
        $table = 'sale_agent."Agents"';
        $where = array("UID" => $record_id);
        $records = $Crud->SingleRecord($table, $where);
        return $records;

    }


}
