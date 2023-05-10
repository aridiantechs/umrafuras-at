<?php namespace App\Models;

use App\Models\Crud;
use CodeIgniter\Model;

class CronModel extends Model
{
    var $data = array();

    public function __construct()
    {
        //sleep(2);
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    /** Start Function Optimization With Dashboard Counters */

    public
    function TotalArrivals()
    {
        $view = true;
        if ($view) echo " Function &raquo;  TotalArrivals() \n";
        $Crud = new Crud();
        $TotalRecords = 0;
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['CheckinKSA'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        if ($view) echo "Status Key :  (total-arrival) \n";

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT distinct pilgrim."master".* 
            FROM pilgrim."master"
            LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
            WHERE  pilgrim."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
            
            AND  pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            if ($view) echo "Records &raquo; " . count($records) . " SQL (" . $Agent['UID'] . " - " . $Agent['FullName'] . "): " . $SQL . "<br><br><br> \n";
            if ($view) echo "Domain (" . $Agent['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'total-arrival';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

            $TotalRecords += count($records);
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total-arrival'));

        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }

        return $TotalRecords;
    }

    public
    function TotalExit()
    {
        $view = true;
        if ($view) echo " Function &raquo;  TotalExit() \n";
        $Crud = new Crud();
        $TotalRecords = 0;
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Exit'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        if ($view) echo "Status Key :  (total-exit) \n";

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT distinct pilgrim."master".* 
            FROM pilgrim."master"
            LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
            WHERE  "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
            AND  pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            if ($view) echo "Total Exit... Domain (" . $Agent['Name'] . "): SQL: " . $SQL . ";\n";
            if ($view) echo "Domain (" . $Agent['Name'] . "): " . count($records) . " Pilgrims;\n";

            $temp = array();
            $temp['StatsKey'] = 'total-exit';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

            $TotalRecords += count($records);
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total-exit'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }

        return $TotalRecords;
    }

    public
    function TotalPaxinKSA()
    {
        $session = session();
        $view = true;
        if ($view) echo " Function &raquo;  TotalPaxinKSA() \n";
        $session = $session->get();
        $Counters = new Pilgrims();
        $Crud = new Crud();
        if (count($session) > 0) {

            $TotalRecords = 0;
            $InstRecords = array();
            $DomainData = $Crud->SingleRecord('websites."Domains"', array('UID' => $session['domainid']));

            if ($view) echo "Status Key :  (total-pax-in-ksa) \n";

            $InKSAPilgrimCounts = $Counters->InKSAPilgrimCount($session['domainid']);
            $TotalRecords = count($InKSAPilgrimCounts);

            $InstRecords['StatsKey'] = 'total-pax-in-ksa';
            $InstRecords['DomainID'] = $DomainData['UID'];
            $InstRecords['Value'] = $TotalRecords;
            $InstRecords['SystemDate'] = "NOW()";

            if ($view) echo "Total Pex IN KSA... \n";
            if ($view) echo "Domain (" . $DomainData['Name'] . "): " . $TotalRecords . " Records;\n";

            $table = 'websites."stats"';
            $Crud->DeleteRecord($table, array("StatsKey" => 'total-pax-in-ksa', 'DomainID' => $DomainData['UID']));
            if (count($InstRecords) > 0) {
                $Crud->AddRecord('websites."stats"', $InstRecords);
            }

            return $TotalRecords;

        } else {

            $Domaintable = 'websites."Domains"';
            $Where = array();
            $Domains = $Crud->ListRecords($Domaintable, $Where);
            foreach ($Domains as $Domain) {
                $InKSAPilgrimCounts = $Counters->InKSAPilgrimCount($Domain['UID']);
                $InKSAPilgrimsCount = count($InKSAPilgrimCounts);
                if ($view) echo "Total Pex IN KSA... \n";
                if ($view) echo "Domain (" . $Domain['Name'] . "): " . $InKSAPilgrimsCount . " Records;\n";

                $temp = array();
                $temp['StatsKey'] = 'total-pax-in-ksa';
                $temp['DomainID'] = $Domain['UID'];
                $temp['Value'] = $InKSAPilgrimsCount;
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;
            }

            $table = 'websites."stats"';
            $Crud->DeleteRecord($table, array("StatsKey" => 'total-pax-in-ksa'));
            if (count($InstRecords) > 0) {
                $db = db_connect();
                $db->db_debug = false;
                $db->table($table)->insertBatch($InstRecords, null);
                $db->close();
            }

        }
    }

    public
    function TotalAgents()
    {
        $view = true;
        if ($view) echo " Function &raquo;  TotalAgents() \n";
        $Crud = new Crud();
        $session = session();
        $session = $session->get();

        $AllDomainsAgents = 0;
        $InstRecords = array();
        $DomainData = $Crud->ListRecords('websites."Domains"', array(), array('FullName' => 'ASC'));

        if ($view) echo "Status Key :  (total_agents) \n";

        foreach ($DomainData as $DD) {

            $TotalRecords = 0;
            $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 AND "WebsiteDomain" = ' . $DD['UID'] . ' ';
            $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);
            $TotalRecords = count($AgentsRecord);
            $AllDomainsAgents += $TotalRecords;

            if ($view) echo "Domain (" . $DD['Name'] . "): " . $TotalRecords . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'total_agents';
            $temp['DomainID'] = $DD['UID'];
            $temp['Value'] = $TotalRecords;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

            $table = 'websites."stats"';
            $Crud->DeleteRecord($table, array("StatsKey" => 'total_agents', 'DomainID' => $DD['UID']));
        }

        $table = 'websites."stats"';
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }

        return $AllDomainsAgents;
    }

    public
    function TotalB2BAgents()
    {
        $session = session();
        $session = $session->get();
        $view = true;
        if ($view) echo " Function &raquo;  TotalB2BAgents() \n";
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        if ($view) echo "Status Key :  (total_b2b_agent) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $AgentSQL = ' SELECT * FROM main."Agents" 
                            WHERE "Archive" = 0 AND "Type" = \'agent\' AND "WebsiteDomain" = ' . $Domain['UID'] . ' ';
            $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);
            $TotalRecords = count($AgentsRecord);

            if ($view) echo "Domain (" . $Domain['Name'] . "): " . $TotalRecords . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'total_b2b_agent';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalRecords;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total_b2b_agent'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function TotalExternalAgents()
    {
        $session = session();
        $session = $session->get();
        $view = true;
        if ($view) echo " Function &raquo;  TotalExternalAgents() \n";
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        if ($view) echo "Status Key :  (external_agents) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $AgentSQL = ' SELECT * FROM main."Agents" 
                            WHERE "Archive" = 0 AND "Type" = \'external_agent\' AND "WebsiteDomain" = ' . $Domain['UID'] . ' ';
            $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);
            $TotalRecords = count($AgentsRecord);

            if ($view) echo "Domain (" . $Domain['Name'] . "): " . $TotalRecords . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'external_agents';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalRecords;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'external_agents'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function TotalSubAgents()
    {
        $session = session();
        $session = $session->get();
        $view = true;
        if ($view) echo " Function &raquo;  TotalSubAgents() \n";
        $Crud = new Crud();

        $AllDomainsSubAgents = 0;
        $InstRecords = array();
        $DomainData = $Crud->ListRecords('websites."Domains"', array(), array('FullName' => 'ASC'));
        if ($view) echo "Status Key :  (sub_agent) \n";

        foreach ($DomainData as $DD) {

            $TotalRecords = 0;
            $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 AND "Type" = \'sub_agent\' AND "WebsiteDomain" = ' . $DD['UID'] . '  ';
            $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);
            $TotalRecords = count($AgentsRecord);
            $AllDomainsSubAgents += $TotalRecords;

            if ($view) echo "Domain (" . $DD['Name'] . "): " . $TotalRecords . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'sub_agents';
            $temp['DomainID'] = $DD['UID'];
            $temp['Value'] = $TotalRecords;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

            $table = 'websites."stats"';
            $Crud->DeleteRecord($table, array("StatsKey" => 'total_agents', 'DomainID' => $DD['UID']));
        }

        $table = 'websites."stats"';
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }

        return $AllDomainsSubAgents;
    }

    public
    function TotalActiveB2BAgents()
    {
        $session = session();
        $session = $session->get();
        $view = true;
        if ($view) echo " Function &raquo;  TotalActiveB2BAgents() \n";
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        if ($view) echo "Status Key :  (total_active_b2b_agent) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'main."Agents"';
            $where = array("WebsiteDomain" => $Domain['UID'], "Status" => 'Active', "Archive" => 0);
            $records = $Crud->ListRecords($table, $where);
            if ($view) echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'total_active_b2b_agent';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total_active_b2b_agent'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function TotalInactiveB2BAgents()
    {
        $session = session();
        $session = $session->get();

        $view = true;
        if ($view) echo " Function &raquo;  TotalInactiveB2BAgents() \n";
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        if ($view) echo "Status Key :  (total_inactive_b2b_agent) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'main."Agents"';
            $where = array("WebsiteDomain" => $Domain['UID'], "Status" => 'InActive', "Archive" => 0);
            $records = $Crud->ListRecords($table, $where);
            if ($view) echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'total_inactive_b2b_agent';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total_inactive_b2b_agent'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function GetPilgrimByActivityStatus()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  GetPilgrimByActivityStatus() \n";
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT DISTINCT "pilgrim"."meta"."Option" AS "Status",COUNT("pilgrim"."meta"."PilgrimUID") AS "TotalPilgrims" 
                    FROM "pilgrim"."meta" 
                    INNER JOIN pilgrim."master" ON  pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                    WHERE "pilgrim"."meta"."Option" LIKE \'%-status\'
                    AND pilgrim."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
                   ';

            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $SQL .= ' GROUP BY "pilgrim"."meta"."Option" ';
            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {

                if ($view) echo "Domain (" . $Agent['WebsiteDomain'] . "): " . $record['Status'] . " " . $record['TotalPilgrims'] . " Pilgrims;<hr>\n";
                $temp = array();
                $temp['StatsKey'] = "activity-" . $record['Status'];
                $temp['DomainID'] = $Agent['WebsiteDomain'];
                $temp['AgentID'] = $Agent['UID'];
                $temp['Value'] = $record['TotalPilgrims'];
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;

                $table = 'websites."stats"';
                if (count($session) > 0) {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey'], "DomainID" => $Agent['WebsiteDomain']));
                } else {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                }
            }
        }
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function GetPilgrimByArrivalByLand()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  GetPilgrimByActivityStatus() \n";
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }


            $SQL = 'SELECT  "pilgrim"."master"."AgentUID",COUNT(DISTINCT "pilgrim"."master"."UID") AS "TotalPilgrims"
                    FROM "pilgrim"."meta"
                    INNER JOIN pilgrim."master" ON  pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                    INNER JOIN  voucher."TransportRate" ON  (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference" AND voucher."TransportRate"."TravelType"=\'Arrival\') 
                    INNER JOIN voucher."Master" ON  voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
                    WHERE voucher."Master"."ArrivalType"=\'Land\'';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $SQL .= ' GROUP BY "pilgrim"."master"."AgentUID" ';

            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {

                if ($view) echo $SQL . "<hr>Arrival Domain (" . $Agent['WebsiteDomain'] . ") Agent (" . $Agent['UID'] . "): Land  " . $record['TotalPilgrims'] . " Pilgrims;<hr>\n";
                $temp = array();
                $temp['StatsKey'] = "arrival-activity-by-land";
                $temp['DomainID'] = $Agent['WebsiteDomain'];
                $temp['AgentID'] = $Agent['UID'];
                $temp['Value'] = $record['TotalPilgrims'];
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;

                $table = 'websites."stats"';
                $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                /*if (count($session) > 0) {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey'], "DomainID" => $Agent['WebsiteDomain']));
                } else {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                }*/
            }
        }
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function GetPilgrimByArrivalBySea()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  GetPilgrimByActivityStatus() \n";
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }


            $SQL = 'SELECT  "pilgrim"."master"."AgentUID",COUNT(DISTINCT "pilgrim"."master"."UID") AS "TotalPilgrims"
                    FROM "pilgrim"."meta"
                    INNER JOIN pilgrim."master" ON  pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                    INNER JOIN  voucher."TransportRate" ON  (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference" AND voucher."TransportRate"."TravelType"=\'Arrival\') 
                    INNER JOIN voucher."Master" ON  voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
                    WHERE  voucher."Master"."ArrivalType"=\'Sea\'';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $SQL .= ' GROUP BY "pilgrim"."master"."AgentUID" ';
            //$SQL .= ' GROUP BY "pilgrim"."meta"."Option" ';

            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {

                if ($view) echo "Arrival Domain (" . $Agent['WebsiteDomain'] . ") Agent (" . $Agent['UID'] . "): Sea " . $record['TotalPilgrims'] . " Pilgrims;<hr>\n";
                $temp = array();
                $temp['StatsKey'] = "arrival-activity-by-sea";
                $temp['DomainID'] = $Agent['WebsiteDomain'];
                $temp['AgentID'] = $Agent['UID'];
                $temp['Value'] = $record['TotalPilgrims'];
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;

                $table = 'websites."stats"';
                $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                /*if (count($session) > 0) {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey'], "DomainID" => $Agent['WebsiteDomain']));
                } else {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                }*/
            }
            //exit();
        }
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function GetPilgrimByDepartureByLand()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  GetPilgrimByActivityStatus() \n";
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }


            $SQL = 'SELECT "pilgrim"."master"."AgentUID",COUNT(DISTINCT "pilgrim"."master"."UID") AS "TotalPilgrims"
                    FROM "pilgrim"."meta"
                    INNER JOIN pilgrim."master" ON  pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                    INNER JOIN  voucher."TransportRate" ON  (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference" AND voucher."TransportRate"."TravelType"=\'Departure\') 
                    INNER JOIN voucher."Master" ON  voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
                    WHERE voucher."Master"."ArrivalType"=\'Land\'';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $SQL .= ' GROUP BY "pilgrim"."master"."AgentUID" ';
            // $SQL .= ' GROUP BY "pilgrim"."meta"."Option" ';

            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {

                if ($view) echo $SQL . "<hr>Departure  Domain (" . $Agent['WebsiteDomain'] . ") Agent (" . $Agent['UID'] . "): Land  " . $record['TotalPilgrims'] . " Pilgrims;<hr>\n";
                $temp = array();
                $temp['StatsKey'] = "departure-activity-by-land";
                $temp['DomainID'] = $Agent['WebsiteDomain'];
                $temp['AgentID'] = $Agent['UID'];
                $temp['Value'] = $record['TotalPilgrims'];
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;

                $table = 'websites."stats"';
                $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                /*if (count($session) > 0) {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey'], "DomainID" => $Agent['WebsiteDomain']));
                } else {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                }*/
            }
        }
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function GetPilgrimByDepartureBySea()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  GetPilgrimByActivityStatus() \n";
        $session = session();
        $session = $session->get();

        $AgentSQL = ' SELECT * FROM main."Agents" WHERE "Archive" = 0 ';
        $AgentsRecord = $Crud->ExecuteSQL($AgentSQL);

        $InstRecords = array();
        foreach ($AgentsRecord as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }


            $SQL = 'SELECT "pilgrim"."master"."AgentUID",COUNT(DISTINCT "pilgrim"."master"."UID") AS "TotalPilgrims"
                    FROM "pilgrim"."meta"
                    INNER JOIN pilgrim."master" ON  pilgrim."master"."UID"=pilgrim."meta"."PilgrimUID"
                    INNER JOIN  voucher."TransportRate" ON  (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference" AND voucher."TransportRate"."TravelType"=\'Departure\') 
                    INNER JOIN voucher."Master" ON  voucher."Master"."UID"=voucher."TransportRate"."VoucherUID"
                    WHERE  voucher."Master"."ArrivalType"=\'Sea\'';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $SQL .= ' GROUP BY "pilgrim"."master"."AgentUID" ';

            $records = $Crud->ExecuteSQL($SQL);
            foreach ($records as $record) {

                if ($view) echo "Departure Domain (" . $Agent['WebsiteDomain'] . ") Agent (" . $Agent['UID'] . "): Sea " . $record['TotalPilgrims'] . " Pilgrims;<hr>\n";
                $temp = array();
                $temp['StatsKey'] = "departure-activity-by-sea";
                $temp['DomainID'] = $Agent['WebsiteDomain'];
                $temp['AgentID'] = $Agent['UID'];
                $temp['Value'] = $record['TotalPilgrims'];
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;

                $table = 'websites."stats"';
                $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                /*if (count($session) > 0) {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey'], "DomainID" => $Agent['WebsiteDomain']));
                } else {
                    $Crud->DeleteRecord($table, array("StatsKey" => $temp['StatsKey']));
                }*/
            }
        }
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    /** Ends Function Optimization With Dashboard Counters */

    public
    function TotalB2C()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '
                SELECT COUNT("pilgrim"."master"."UID") AS "B2CCount" FROM "pilgrim"."master"  
                WHERE "pilgrim"."master"."AgentUID" IS NULL  
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0]['B2CCount'];

            $temp = array();
            $temp['StatsKey'] = 'total-b2c';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total-b2c'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivityDepartureYanbuStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-departure-yanbu-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-departure-yanbu-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivityDepartureSeaStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-departure-sea-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-departure-sea-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivityDepartureRoadStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-departure-road-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-departure-road-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivityYanbuArrivalStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-yanbu-arrival-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-yanbu-arrival-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivitySeaArrivalStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-sea-arrival-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-sea-arrival-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ActivityRoadArrivalStats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2C = 0;
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '  ';
            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2C = $b2c[0][''];

            $temp = array();
            $temp['StatsKey'] = 'activity-road-arrival-status';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2C;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'activity-road-arrival-status'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function TotalB2BPilgrim()
    {
        $Crud = new Crud();

        $Domaintable = 'main."Agents"';
        $Where = array("Type" => 'agent');
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalB2B = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '
            SELECT COUNT("pilgrim"."master"."UID") AS "B2BCount" FROM "pilgrim"."master" 
            INNER JOIN "main"."Agents" ON ("pilgrim"."master"."AgentUID" = "main"."Agents"."UID")
            WHERE "pilgrim"."master"."AgentUID" IS NOT NULL  
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['WebsiteDomain'] . '
            AND ("main"."Agents"."UID" = ' . $Domain['UID'] . ') ';

            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalB2B = $b2c[0]['B2BCount'];

            $temp = array();
            $temp['StatsKey'] = 'total-b2b-pilgrim';
            $temp['DomainID'] = $Domain['WebsiteDomain'];
            $temp['AgentID'] = $Domain['UID'];
            $temp['Value'] = $TotalB2B;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total-b2b-pilgrim'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function TotalExternalPilgrim()
    {
        $Crud = new Crud();

        $Domaintable = 'main."Agents"';
        $Where = array("Type" => 'external_agent');
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $TotalExternalPilgrim = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = '
            SELECT COUNT("pilgrim"."master"."UID") AS "ExternalAgentCount" FROM "pilgrim"."master" 
            INNER JOIN "main"."Agents" ON ("pilgrim"."master"."AgentUID" = "main"."Agents"."UID")
            WHERE  "pilgrim"."master"."AgentUID" IS NOT NULL
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['WebsiteDomain'] . '
            AND ("main"."Agents"."UID" = ' . $Domain['UID'] . ' OR "main"."Agents"."ParentID" = ' . $Domain['UID'] . ') ';

            $b2c = $Crud->ExecuteSQL($SQL);
            $TotalExternalPilgrim = $b2c[0]['ExternalAgentCount'];

            $temp = array();
            $temp['StatsKey'] = 'total-external-pilgrim';
            $temp['DomainID'] = $Domain['WebsiteDomain'];
            $temp['AgentID'] = $Domain['UID'];
            $temp['Value'] = $TotalExternalPilgrim;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'total-external-pilgrim'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function JeddahArrivals()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (jeddah-arrival) \n";

        $EntryCount = StatusCheckList();
        $EntryCount = $EntryCount['Arrival'];

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."meta"."Option" = \'jeddah-arrival-status\' 
                    AND  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . '';
            //echo $SQL;

            $records = $Crud->ExecuteSQL($SQL);
            $TotalPilgrims = $records[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $TotalPilgrims . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'jeddah-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalPilgrims;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'jeddah-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function MedinaArrivals()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (medina-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."meta"."Option" = \'medina-arrival-status\' 
                    AND  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . '';

            $records = $Crud->ExecuteSQL($SQL);
            $TotalPilgrims = $records[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $TotalPilgrims . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'medina-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalPilgrims;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'medina-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function YanbuArrivals()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (yanbu-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."meta"."Option" = \'yanbu-arrival-status\' 
                    AND  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . '';

            $records = $Crud->ExecuteSQL($SQL);
            $TotalPilgrims = $records[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $TotalPilgrims . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'yanbu-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalPilgrims;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'yanbu-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function SeaArrivals()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (sea-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."meta"."Option" = \'sea-arrival-status\' 
                    AND  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . '';

            $records = $Crud->ExecuteSQL($SQL);
            $TotalPilgrims = $records[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $TotalPilgrims . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'sea-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalPilgrims;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'sea-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function ByRoadArrivals()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (by-road-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."meta"."Option" = \'by-road-arrival-status\' 
                    AND  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . '';

            $records = $Crud->ExecuteSQL($SQL);
            $TotalPilgrims = $records[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $TotalPilgrims . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'by-road-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalPilgrims;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'by-road-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckInMecca()
    {
        $Crud = new Crud();

        $AgentTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentTable, $Where);
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['CheckInMecca'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }

        echo "Status Key :  (check-in-mecca) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT distinct pilgrim."master".* FROM pilgrim."master"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
                    AND pilgrim."meta"."Option" IN (\'' . implode("','", $ArrivalMeta) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';

            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Pilgrims;<hr>\n";

            $temp = array();
            $temp['StatsKey'] = 'check-in-mecca';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-in-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckInMedina()
    {
        $Crud = new Crud();

        $AgentsTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentsTable, $Where);
        $CheckInMedinaCount = StatusCheckList();

        $CheckInMedinaMeta = array();
        foreach ($CheckInMedinaCount['CheckInMedina'] as $CheckInMedinaCnt) {
            $CheckInMedinaMeta[] = $CheckInMedinaCnt . "-status";
        }
        echo "Status Key :  (check-in-medina) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT distinct pilgrim."master".* FROM pilgrim."master"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '                     
                    AND pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInMedinaMeta) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'check-in-medina';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-in-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckInJeddah()
    {
        $Crud = new Crud();

        $AgentTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentTable, $Where);
        $CheckInJeddahCount = StatusCheckList();

        $CheckInJeddahMeta = array();
        foreach ($CheckInJeddahCount['CheckInJeddah'] as $CheckInJeddahCnt) {
            $CheckInJeddahMeta[] = $CheckInJeddahCnt . "-status";
        }
        echo "Status Key :  (check-in-jeddah) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT Distinct pilgrim."master".* FROM pilgrim."master"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
                    AND  pilgrim."meta"."Option" IN (\'' . implode("','", $CheckInJeddahMeta) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Pilgrims;\n";

            $temp = array();
            $temp['StatsKey'] = 'check-in-jeddah';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-in-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PAXInMecca()
    {
        $Crud = new Crud();

        $AgentTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentTable, $Where);
        $PAXInMeccaCount = StatusCheckList();
        $PAXInMeccaCount = $PAXInMeccaCount['PAXInMecca'];
        echo "Status Key :  (pax-in-mecca) \n\n ";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
            WHERE  pilgrim."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '
            AND  "CurrentStatus" IN (\'' . implode("','", $PAXInMeccaCount) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Pilgrims; \n\n ";

            $temp = array();
            $temp['StatsKey'] = 'pax-in-mecca';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'pax-in-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PAXInMedina()
    {
        $Crud = new Crud();

        $AgentsTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentsTable, $Where);
        $PAXInMedinaCount = StatusCheckList();
        $PAXInMedinaCount = $PAXInMedinaCount['PAXInMedina'];
        echo "Status Key :  (pax-in-medina) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
            WHERE  "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '            
            AND  "CurrentStatus" IN (\'' . implode("','", $PAXInMedinaCount) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Pilgrims ;\n";

            $temp = array();
            $temp['StatsKey'] = 'pax-in-medina';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'pax-in-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PAXInJeddah()
    {
        $Crud = new Crud();

        $AgentTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentTable, $Where);
        $PAXInJeddahCount = StatusCheckList();
        $PAXInJeddahCount = $PAXInJeddahCount['PAXInJeddah'];
        echo "Status Key :  (pax-in-jeddah) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
            WHERE  "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'] . '            
            AND  "CurrentStatus" IN (\'' . implode("','", $PAXInJeddahCount) . '\') ';
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Agent (" . $Agent['FullName'] . "): " . count($records) . " Pilgrims;\n";

            $temp = array();
            $temp['StatsKey'] = 'pax-in-jeddah';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'pax-in-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckOutMecca()
    {
        $Crud = new Crud();
        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (check-out-mecca) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'check-out-mecca');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Pilgrims; \n";

            $temp = array();
            $temp['StatsKey'] = 'check-out-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-out-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckOutMedina()
    {
        $Crud = new Crud();
        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (check-out-medina) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'check-out-medina');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Pilgrims; \n";

            $temp = array();
            $temp['StatsKey'] = 'check-out-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-out-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CheckOutJeddah()
    {
        $Crud = new Crud();
        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (check-out-jeddah) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'check-out-jeddah');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'check-out-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'check-out-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function WithOutHotelArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (without-hotel-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'without-hotel-arrival');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'without-hotel-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'without-hotel-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function WithOutTransportArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (without-transport-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'without-transport-arrival');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'without-transport-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'without-transport-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function DepartureMecca()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (departure-mecca) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'departure-mecca');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'departure-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'departure-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function DepartureMedina()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (departure-medina) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $table = 'pilgrim."master"';
            $where = array("WebsiteDomain" => $Domain['UID'], "CurrentStatus" => 'departure-medina');
            // $where = array("CurrentStatus" => 'departure-medina');
            $records = $Crud->ListRecords($table, $where);
            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'departure-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'departure-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function DepartureJeddah()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $ExitCount = StatusCheckList();
        echo "Status Key :  (departure-jeddah) \n";

        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT pilgrim."master".* FROM pilgrim."master"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE  pilgrim."master"."WebsiteDomain" = ' . $Domain['UID'] . ' AND  pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\') ';
            $records = $Crud->ExecuteSQL($SQL);

            echo "Domain (" . $Domain['Name'] . "): " . count($records) . " Agents;\n";

            $temp = array();
            $temp['StatsKey'] = 'departure-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($records);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'departure-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function VoucherIssued()
    {
        $Crud = new Crud();
        $AgentsTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentsTable, $Where);
        $VoucherIssued = 0;
        echo "Status Key :  (travel-voucher-issued) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT count("pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
            WHERE "pilgrim"."master"."UID" IN ( SELECT "voucher"."Pilgrim"."PilgrimUID" FROM "voucher"."Pilgrim" ) 
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'];
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            $b2c = $Crud->ExecuteSQL($SQL);
            $VoucherIssued = $b2c[0]['TotPilgrims'];
            echo "Agents (" . $Agent['Name'] . "): " . $VoucherIssued . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'travel-voucher-issued';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = $VoucherIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'travel-voucher-issued'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function VoucherNotIssued()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  VoucherNotIssued() \n";

        $AgentTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentTable, $Where);

        $VoucherNotIssued = 0;
        if ($view) echo "Status Key :  (travel-voucher-not-issued) \n";

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT count("pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
            WHERE "pilgrim"."master"."UID" NOT IN ( SELECT "voucher"."Pilgrim"."PilgrimUID" FROM "voucher"."Pilgrim" ) 
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'];
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';

            $b2c = $Crud->ExecuteSQL($SQL);
            $VoucherNotIssued = $b2c[0]['TotPilgrims'];
            if ($view) echo "Agents (" . $Agent['FullName'] . "): " . $VoucherNotIssued . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'travel-voucher-not-issued';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = $VoucherNotIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'travel-voucher-not-issued'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function VisaIssued()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo; VisaIssued() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $VisaIssued = 0;
        if ($view) echo "Status Key :  (visa-issued) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count("pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
                INNER JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"  = pilgrim."master"."UID"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."MOFAPilgrimID"  = pilgrim."mofa"."MOFAPilgrimID"
                WHERE  "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';
            $b2c = $Crud->ExecuteSQL($SQL);
            $VisaIssued = $b2c[0]['TotPilgrims'];
            if ($view) echo "Domain (" . $Domain['Name'] . "): " . $VisaIssued . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'visa-issued';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $VisaIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        //echo $VisaIssued;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'visa-issued'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function VisaNotIssued()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $VisaNotIssued = 0;
        echo "Status Key :  (visa-not-printed) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
//            $SQL = 'SELECT count("pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
//            WHERE "pilgrim"."master"."UID" NOT IN ( SELECT "pilgrim"."visa"."PilgrimID" FROM "pilgrim"."visa" )
//            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';
            $SQL = 'SELECT count("pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
            WHERE "pilgrim"."master"."UID" NOT IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa" ) 
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            $b2c = $Crud->ExecuteSQL($SQL);
            $VisaNotIssued = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): " . $VisaNotIssued . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'visa-not-printed';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $VisaNotIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $VisaNotIssued;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'visa-not-printed'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function MOFAIssued()
    {
        $Crud = new Crud();

        $Domaintable = 'main."Agents"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $MOFAIssued = 0;
//        echo "Status Key :  (mofa-issued) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            //$AgentsUIDs = HierarchyUsers($Domain['UID']);
            $AgentsUIDs = $Domain['UID'];
            $SQL = 'SELECT count(Distinct "pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
            WHERE "pilgrim"."master"."UID" IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa") 
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['WebsiteDomain'];
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';
            // AND "pilgrim"."master"."AgentUID" = ' . $Domain['UID'];
//echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL);
            $MOFAIssued = $b2c[0]['TotPilgrims'];
//            echo "Domain (" . $Domain['Name'] . "): " . $MOFAIssued . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'mofa-issued';
            $temp['DomainID'] = $Domain['WebsiteDomain'];
            $temp['AgentID'] = $Domain['UID'];
            $temp['Value'] = $MOFAIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        //  echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'mofa-issued'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function MOFANotIssued()
    {
        $Crud = new Crud();

        $AgentsTable = 'main."Agents"';
        $Where = array();
        $Agents = $Crud->ListRecords($AgentsTable, $Where);

        $InstRecords = array();
        foreach ($Agents as $Agent) {

            if ($Agent['Type'] == 'sub_agent') {
                $AgentsUIDs = $Agent['UID'];
            } else {
                $AgentsUIDs = CroneHierarchyUsers($Agent['UID'], $Agent['Type'], true);
            }

            $SQL = 'SELECT count(Distinct "pilgrim"."master"."UID") as "TotPilgrims" FROM "pilgrim"."master"
            WHERE "pilgrim"."master"."UID" Not IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa") 
            AND "pilgrim"."master"."WebsiteDomain" = ' . $Agent['WebsiteDomain'];
            $SQL .= ' AND "pilgrim"."master"."AgentUID" IN   (' . $AgentsUIDs . ') ';

            $b2c = $Crud->ExecuteSQL($SQL);
            $MOFAIssued = $b2c[0]['TotPilgrims'];


            $temp = array();
            $temp['StatsKey'] = 'mofa-not-issued';
            $temp['DomainID'] = $Agent['WebsiteDomain'];
            $temp['AgentID'] = $Agent['UID'];
            $temp['Value'] = $MOFAIssued;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'mofa-not-issued'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PAXDetailsInVoucherWithoutHotel()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (pax-in-voucher-without-hotel) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count("voucher"."Pilgrim"."UID") as "TotPax","voucher"."Master"."WebsiteDomain" FROM "voucher"."Pilgrim"
             JOIN "voucher"."Master" ON "voucher"."Pilgrim"."VoucherUID"  = "voucher"."Master"."UID" 
             WHERE "voucher"."Pilgrim"."VoucherUID" NOT IN ( SELECT "voucher"."AccommodationDetails"."VoucherID" FROM "voucher"."AccommodationDetails" ) 
             AND "voucher"."Master"."WebsiteDomain" = ' . $Domain['UID'] . '   GROUP BY "WebsiteDomain" 
             ';

            //  echo $SQL;
            $TotalPax = $Crud->ExecuteSQL($SQL);
            $PaxInVoucher = $TotalPax[0]['TotPax'];
            echo "Domain (" . $Domain['Name'] . "): " . $PaxInVoucher . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'pax-in-voucher-without-hotel';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $PaxInVoucher;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'pax-in-voucher-without-hotel'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function PAXDetailsInVoucherWithoutTransport()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (pax-in-voucher-without-transport) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count("voucher"."Pilgrim"."UID") as "TotPax","voucher"."Master"."WebsiteDomain"  FROM "voucher"."Pilgrim"
             JOIN "voucher"."Master" ON "voucher"."Pilgrim"."VoucherUID"  = "voucher"."Master"."UID" 
             WHERE "voucher"."Pilgrim"."VoucherUID" NOT IN ( SELECT "voucher"."TransportRate"."VoucherUID" FROM "voucher"."TransportRate" ) 
             AND "voucher"."Master"."WebsiteDomain" = ' . $Domain['UID'] . '  GROUP BY "WebsiteDomain" ';

            $TotalPax = $Crud->ExecuteSQL($SQL);
            $PaxInVoucher = $TotalPax[0]['TotPax'];
            echo "Domain (" . $Domain['Name'] . "): " . $PaxInVoucher . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'pax-in-voucher-without-transport';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $PaxInVoucher;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'pax-in-voucher-without-transport'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PAXDetailsInVoucherOnlyVisa()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (only-visa-in-voucher) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count("voucher"."Pilgrim"."UID") as "TotPax","voucher"."Master"."WebsiteDomain" FROM "voucher"."Pilgrim"
             JOIN "voucher"."Master" ON "voucher"."Pilgrim"."VoucherUID"  = "voucher"."Master"."UID" 
             WHERE "voucher"."Pilgrim"."VoucherUID" NOT IN ( SELECT "voucher"."TransportRate"."VoucherUID" FROM "voucher"."TransportRate" )
             AND "voucher"."Pilgrim"."VoucherUID" NOT IN (SELECT "voucher"."AccommodationDetails"."VoucherID" FROM "voucher"."AccommodationDetails") 
             AND "voucher"."Master"."WebsiteDomain" = ' . $Domain['UID'] . '  GROUP BY "WebsiteDomain" ';

            // echo $SQL;
            $TotalPax = $Crud->ExecuteSQL($SQL);
            $PaxInVoucher = $TotalPax[0]['TotPax'];
            echo "Domain (" . $Domain['Name'] . "): " . $PaxInVoucher . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'only-visa-in-voucher';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $PaxInVoucher;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'only-visa-in-voucher'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowTPTArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (allow-tpt-arrival) \n";


        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") as "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        WHERE voucher."TransportRate"."TravelType"=\'Arrival\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                            SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\',\'allow-tpt-yanbu-status\') 
                            AND voucher."TransportRate"."TravelType"=\'Arrival\'
                        )  
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): SQL " . $SQL . " ;\n";
            echo "Domain (" . $Domain['Name'] . "): AllowTPTArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-tpt-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-tpt-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function AllowTPTDeparture()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (allow-tpt-departure) \n";


        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") as "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        WHERE voucher."TransportRate"."TravelType"=\'Departure\' 
                                 AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\') AND voucher."TransportRate"."TravelType"=\'Departure\'
                            )  
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTDeparture = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): SQL " . $SQL . " ;\n";
            echo "Domain (" . $Domain['Name'] . "): AllowTPTDeparture " . $AllowTPTDeparture . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-tpt-departure';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTDeparture;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-tpt-departure'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function CompletedAllowTPTDeparture()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (completed-allow-tpt-departure) \n";


        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID")  as "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        WHERE voucher."TransportRate"."TravelType"=\'Departure\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\') AND voucher."TransportRate"."TravelType"=\'Departure\'
                            ) 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'departure-jeddah-status\', \'departure-mecca-status\', \'departure-medina-status\', \'departure-yanbu-status\') 
                            AND voucher."TransportRate"."TravelType"=\'Departure\'
                            )     
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTDeparture = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): SQL " . $SQL . " ;\n";
            echo "Domain (" . $Domain['Name'] . "): CompletedAllowTPTDeparture " . $AllowTPTDeparture . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-tpt-departure';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTDeparture;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-tpt-departure'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowTPTArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (completed-allow-tpt-arrival) \n";


        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID")  as "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        WHERE voucher."TransportRate"."TravelType"=\'Arrival\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\',\'allow-tpt-mecca-status\',\'allow-tpt-medina-status\',\'allow-tpt-yanbu-status\') AND voucher."TransportRate"."TravelType"=\'Arrival\'
                            )  
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."UID"=pilgrim."meta"."AllowReference")
                            WHERE pilgrim."meta"."Option" IN ( \'jeddah-arrival-status\',\'mecca-arrival-status\',\'medina-arrival-status\',\'yanbu-arrival-status\') AND voucher."TransportRate"."TravelType"=\'Arrival\'
                            ) 
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): SQL " . $SQL . " ;\n";
            echo "Domain (" . $Domain['Name'] . "): CompletedAllowTPTArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-tpt-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-tpt-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowHTLMeccaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-htl-mecca) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                    FROM  "voucher"."AccommodationDetails" 
                    inner JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int)) AND main."Cities"."Name" = \'Mecca\' AND main."Cities"."CountryCode" = \'SA\'
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "voucher"."Pilgrim"."PilgrimUID"
                    where voucher."AccommodationDetails"."Self"=0
                    AND main."Cities"."Name" IS NOT NULL
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
 AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                                       
                    
                    )';
            //echo $SQL . "<br>";

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            echo $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "<br>Domain (" . $Domain['Name'] . "): AllowHTLMeccaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-htl-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-htl-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowHTLMeccaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-htl-mecca) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select  count(Distinct pilgrim."meta"."PilgrimUID") AS "TotPilgrims"
                    FROM  pilgrim."meta" 
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = pilgrim."meta"."PilgrimUID"
                    INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."UID"=pilgrim."meta"."AllowReference"
                    where pilgrim."meta"."Option" IN (\'allow-htl-mecca-status\') 
                    AND pilgrim."meta"."AllowReference">0                   
                    AND "pilgrim"."master"."WebsiteDomain" =' . $Domain['UID'] . '
                   
                    AND pilgrim."meta"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            
                            WHERE pilgrim."meta"."Option" IN ( \'check-in-mecca-status\')
                            AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                            )
                    ';
            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];


            echo "Domain (" . $Domain['Name'] . "): CompletedAllowHTLMeccaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-htl-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-htl-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowTPTMeccaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-tpt-mecca) \n";

        $AllowTPTMeccaArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            /*$SQL = 'SELECT sum(a."TotalPilgrim") AS "TotPilgrims"
                        FROM (SELECT count(voucher."Pilgrim"."PilgrimUID") as "TotalPilgrim"
                                FROM "voucher"."Pilgrim"
                                LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                                LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                                LEFT JOIN pilgrim."meta" ON voucher."Pilgrim"."PilgrimUID" = pilgrim."meta"."PilgrimUID"
                                WHERE voucher."Master"."CurrentStatus"=\'Executed\'
                                AND pilgrim."meta"."Option" IN (\'allow-tpt-mecca-status\')
                                AND "pilgrim"."master"."WebsiteDomain" =' . $Domain['UID'] . '
                                GROUP BY voucher."Pilgrim"."PilgrimUID"
                                HAVING count(pilgrim."meta"."Option") <2 ) a';*/
            $SQL = 'SELECT DISTINCT pilgrim."meta"."Option", count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                    LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                    WHERE voucher."TransportRate"."TravelType" = \'Checkout\'
                    AND main."Cities"."CountryCode" = \'SA\'
                    AND main."Cities"."Name" = \'Mecca\' 
                    AND pilgrim."meta"."Option" IN ( \'allow-tpt-mecca-status\')          
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
                    GROUP BY pilgrim."meta"."Option" ';
            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            //$AllowTPTMeccaArrival = $b2c[0]['TotPilgrims'];

            /*$SQL2 = 'SELECT count(voucher."Pilgrim"."PilgrimUID") as "TotPilgrims"
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN voucher."TransportRate" ON voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID"
                    WHERE voucher."TransportRate"."SelfTransport"=0
                    AND voucher."Master"."CurrentStatus"=\'Executed\'
                    AND voucher."Pilgrim"."PilgrimUID" NOT IN ( select  pilgrim."meta"."PilgrimUID" FROM  pilgrim."meta"
                    where pilgrim."meta"."Option" IN (\'allow-tpt-mecca-status\') )
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';



            $b2c2 = $Crud->ExecuteSQL($SQL2);
            $AllowTPTMeccaArrival =$AllowTPTMeccaArrival+ $b2c2[0]['TotPilgrims'];*/
            $AllowTPTMeccaArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): AllowTPTMeccaArrival " . $AllowTPTMeccaArrival . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'allow-tpt-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTMeccaArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-tpt-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowTPTMeccaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-tpt-mecca) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
           /* $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Mecca\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )              
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';*/
            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Mecca\' 
                        AND pilgrim."meta"."Option" IN ( \'allow-tpt-mecca-status\')
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-mecca-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )              
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];


            echo "Domain (" . $Domain['Name'] . "): CompletedAllowTPTMeccaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-tpt-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-tpt-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowHTLMedinaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-htl-medina) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                    FROM  "voucher"."AccommodationDetails" 
                    inner JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int)) AND main."Cities"."Name" = \'Medina\' AND main."Cities"."CountryCode" = \'SA\'
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "voucher"."Pilgrim"."PilgrimUID"
                    where voucher."AccommodationDetails"."Self"=0
                    AND main."Cities"."Name" IS NOT NULL
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
                    AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    
                    where pilgrim."meta"."Option" IN (\'allow-htl-medina-status\') 
                    AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                   
                    
                    )';
            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): AllowHTLMedinaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-htl-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-htl-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowHTLMedinaArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-htl-medina) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select  count(pilgrim."meta"."PilgrimUID") AS "TotPilgrims"
                    FROM  pilgrim."meta" 
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = pilgrim."meta"."PilgrimUID"
                    INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."UID"=pilgrim."meta"."AllowReference"
                    where pilgrim."meta"."Option" IN (\'allow-htl-medina-status\') 
                    AND pilgrim."meta"."AllowReference">0                   
                    AND "pilgrim"."master"."WebsiteDomain" =' . $Domain['UID'] . '
                    
                    AND pilgrim."meta"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            
                            WHERE pilgrim."meta"."Option" IN ( \'check-in-medina-status\')
                            AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                            )
                    
                    ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): CompletedAllowHTLMedinaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-htl-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-htl-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowTPTMedina()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-tpt-medina) \n";

        $AllowTPTMedinaArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {


            /*$SQL2 = 'SELECT count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Medina\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                        
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )           
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . ' ';*/
            $SQL2 = 'SELECT count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"

                        FROM "voucher"."Pilgrim"
                        
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Medina\' 
                        AND pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')        
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . ' ';
            //echo $SQL;

            $b2c2 = $Crud->ExecuteSQL($SQL2); //print_r($b2c);
            $AllowTPTMedinaArrival = $b2c2[0]['TotPilgrims'];

            echo "Domain (" . $Domain['Name'] . "): AllowTPTMedinaArrival " . $AllowTPTMedinaArrival . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'allow-tpt-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTMedinaArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-tpt-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowTPTMedina()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-tpt-medina) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            /*$SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                        FROM "voucher"."Pilgrim"
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Medina\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-medina-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )                 
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';*/
            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                        FROM "voucher"."Pilgrim"
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Medina\' 
                        AND pilgrim."meta"."Option" IN ( \'allow-tpt-medina-status\')
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-medina-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )                 
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . '';
            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];


            echo "Domain (" . $Domain['Name'] . "): CompletedAllowTPTMedinaArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-tpt-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-tpt-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowHTLJeddahArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-htl-jeddah) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                    FROM  "voucher"."AccommodationDetails" 
                    inner JOIN "voucher"."Pilgrim" ON "voucher"."Pilgrim"."VoucherUID"=voucher."AccommodationDetails"."VoucherID"
                    LEFT JOIN main."Cities" ON (cast(voucher."AccommodationDetails"."City" as int) = cast(main."Cities"."UID" as int)) AND main."Cities"."Name" = \'Jeddah\' AND main."Cities"."CountryCode" = \'SA\'
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "voucher"."Pilgrim"."PilgrimUID"
                    where voucher."AccommodationDetails"."Self"=0
                    AND main."Cities"."Name" IS NOT NULL
                    AND voucher."AccommodationDetails"."CheckIn" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
                    AND "voucher"."Pilgrim"."PilgrimUID" NOT IN (
                    select  Distinct pilgrim."meta"."PilgrimUID"
                    FROM  pilgrim."meta" 
                    where pilgrim."meta"."Option" IN (\'allow-htl-jeddah-status\') 
                     AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                    AND pilgrim."meta"."AllowReference">0                   
                    
                    
                    )';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): AllowHTLJeddahArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-htl-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-htl-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedAllowHTLJeddahArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-htl-jeddah) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'select  count(pilgrim."meta"."PilgrimUID") AS "TotPilgrims"
                    FROM  pilgrim."meta" 
                    INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = pilgrim."meta"."PilgrimUID"
                    INNER JOIN voucher."AccommodationDetails" ON voucher."AccommodationDetails"."UID"=pilgrim."meta"."AllowReference"
                    where pilgrim."meta"."Option" IN (\'allow-htl-jeddah-status\') 
                    AND pilgrim."meta"."AllowReference">0                   
                    AND "pilgrim"."master"."WebsiteDomain" =' . $Domain['UID'] . '
                    
                    AND pilgrim."meta"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-in-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"=voucher."AccommodationDetails"."UID"
                            )';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): Completed AllowHTLJeddahArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-htl-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-htl-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function AllowTPTJeddah()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (allow-tpt-jeddah) \n";

        $AllowTPTMedinaArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {


            $SQL2 = 'SELECT count("voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                        FROM "voucher"."Pilgrim"
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        LEFT JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Jeddah\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )           
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c2 = $Crud->ExecuteSQL($SQL2); //print_r($b2c);
            $AllowTPTMedinaArrival = $b2c2[0]['TotPilgrims'];

            echo "Domain (" . $Domain['Name'] . "): AllowTPTJeddah " . $AllowTPTMedinaArrival . " Records;\n";


            $temp = array();
            $temp['StatsKey'] = 'allow-tpt-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTMedinaArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-tpt-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function CompletedAllowTPTJeddah()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-tpt-jeddah) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(distinct "voucher"."Pilgrim"."PilgrimUID") AS "TotPilgrims"
                        FROM "voucher"."Pilgrim"
                        LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"="voucher"."Pilgrim"."VoucherUID")
                        LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                        INNER JOIN "pilgrim"."meta" ON (pilgrim."meta"."PilgrimUID" = "pilgrim"."master"."UID" AND pilgrim."meta"."AllowReference"=voucher."TransportRate"."UID") 
                        LEFT JOIN main."Cities" ON main."Cities"."UID"=voucher."TransportRate"."TravelCity"
                        WHERE voucher."TransportRate"."TravelType"=\'Checkout\'
                        AND main."Cities"."CountryCode"=\'SA\'
                        AND main."Cities"."Name"=\'Jeddah\' 
                        AND "voucher"."Pilgrim"."PilgrimUID" IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'allow-tpt-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )
                        AND "voucher"."Pilgrim"."PilgrimUID" NOT IN(
                        SELECT distinct pilgrim."meta"."PilgrimUID" FROM pilgrim."meta"
                            WHERE pilgrim."meta"."Option" IN ( \'check-out-jeddah-status\')
                            AND pilgrim."meta"."AllowReference"= voucher."TransportRate"."UID"
                            )               
                    AND voucher."TransportRate"."TravelDate" <= CURRENT_DATE +INTERVAL \'1 day\'
                    AND "pilgrim"."master"."WebsiteDomain"=' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];


            echo "Domain (" . $Domain['Name'] . "): CompletedAllowTPTJeddah " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-tpt-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-tpt-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function NotCheckInMecca()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $Counters = new Pilgrims();
        echo "Status Key :  (not-check-in-mecca) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $NotCheckinMedinaCounts = $Counters->StatusExceptCount("'check-in-mecca'", $Domain['UID']);
            echo "Domain (" . $Domain['Name'] . "): " . count($NotCheckinMedinaCounts) . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'not-check-in-mecca';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($NotCheckinMedinaCounts);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'not-check-in-mecca'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function NotCheckInJeddah()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $Counters = new Pilgrims();
        echo "Status Key :  (not-check-in-jeddah) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $NotCheckinMedinaCounts = $Counters->StatusExceptCount("'check-in-jeddah'", $Domain['UID']);
            echo "Domain (" . $Domain['Name'] . "): " . count($NotCheckinMedinaCounts) . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'not-check-in-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($NotCheckinMedinaCounts);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'not-check-in-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function NotCheckInMedina()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $Counters = new Pilgrims();
        echo "Status Key :  (not-check-in-medina) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $NotCheckinMedinaCounts = $Counters->StatusExceptCount("'check-in-medina'", $Domain['UID']);
            echo "Domain (" . $Domain['Name'] . "): " . count($NotCheckinMedinaCounts) . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'not-check-in-medina';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($NotCheckinMedinaCounts);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'not-check-in-medina'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function NotJeddahArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $Counters = new Pilgrims();
        echo "Status Key :  (not-jeddah-arrival) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $NotCheckinMedinaCounts = $Counters->StatusExceptCount("'jeddah-arrival'", $Domain['UID']);
            echo "Domain (" . $Domain['Name'] . "): " . count($NotCheckinMedinaCounts) . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'not-jeddah-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($NotCheckinMedinaCounts);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'not-jeddah-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function NotDepartureJeddahArrival()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $Counters = new Pilgrims();
        echo "Status Key :  (not-departure-jeddah) \n";

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $NotCheckinMedinaCounts = $Counters->StatusExceptCount("'departure-jeddah'", $Domain['UID']);
            echo "Domain (" . $Domain['Name'] . "): " . count($NotCheckinMedinaCounts) . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'not-departure-jeddah';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = count($NotCheckinMedinaCounts);
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

        //echo "<pre>"; print_r($InstRecords);

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'not-departure-jeddah'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Over_25_Days_Arrival()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  Over_25_Days_Arrival() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (over-25-days-arrival) \n";
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Exit'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE 
                    abs(extract(day from \'' . date('Y-m-d') . '\' - voucher."Master"."ArrivalDate"::timestamp))>= 25
                    AND pilgrim."master"."UID" NOT IN(SELECT  pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\'))
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            $SQL .= '  AND pilgrim."master"."UID" NOT IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')';

            //echo nl2br($SQL);

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            if ($view) echo "Domain (" . $Domain['Name'] . "): Over25DaysArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'over-25-days-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'over-25-days-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Complete_In_Over_25_Days_Arrival()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo;  Complete_In_Over_25_Days_Arrival() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (complete-in-over-25-days-arrival) \n";
        $ArrivalCount = StatusCheckList();
        $ArrivalMeta = array();
        foreach ($ArrivalCount['Exit'] as $ArrivalCnt) {
            $ArrivalMeta[] = $ArrivalCnt . "-status";
        }
        $ExitCount = StatusCheckList();
        $ExitMeta = array();
        foreach ($ExitCount['Exit'] as $ExitCnt) {
            $ExitMeta[] = $ExitCnt . "-status";
        }
        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(Distinct pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                    LEFT JOIN voucher."Master" ON voucher."Master"."UID"=voucher."Pilgrim"."VoucherUID"
                    LEFT JOIN pilgrim."meta" ON pilgrim."meta"."PilgrimUID" = pilgrim."master"."UID"
                    WHERE 
                    abs(extract(day from \'' . date('Y-m-d') . '\' - voucher."Master"."ArrivalDate"::timestamp))>= 25
                    AND pilgrim."master"."UID" IN(SELECT  pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" IN (\'' . implode("','", $ExitMeta) . '\'))
                   AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo nl2br($SQL);
            $SQL .= '  AND pilgrim."master"."UID" IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')';

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            if ($view) echo "Domain (" . $Domain['Name'] . "): Over25DaysArrival " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'complete-in-over-25-days-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'complete-in-over-25-days-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Voucher_Package()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (voucher-package) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") as "TotPilgrims" 
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0)
                    LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."TravelSelf"=0)
                    LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0)
                    WHERE "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): Voucher Package " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'voucher-package';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'voucher-package'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function visa_transport()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (visa-transport) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") as "TotPilgrims" 
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=1)
                    LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."TravelSelf"=1)
                    LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0)
                    WHERE "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "pilgrim"."master"."UID" IN ( SELECT "pilgrim"."mofa"."PilgrimID" FROM "pilgrim"."mofa")';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): Visa Transport " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'visa-transport';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'visa-transport'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Hotel_Package()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-package) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") as "TotPilgrims" 
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0)
                    LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."TravelSelf"=1)
                    LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=1)
                    WHERE "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): Hotel Package " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-package';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-package'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Transport_Package()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (transport-package) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT voucher."Pilgrim"."PilgrimUID") as "TotPilgrims" 
                    FROM "voucher"."Pilgrim"
                    LEFT JOIN pilgrim."master" ON pilgrim."master"."UID"=voucher."Pilgrim"."PilgrimUID"
                    LEFT JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=1)
                    LEFT JOIN voucher."Flights" ON (voucher."Flights"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."Flights"."TravelSelf"=1)
                    LEFT JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0)
                    WHERE "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'];
            echo "Domain (" . $Domain['Name'] . "): Transport Package " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'transport-package';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'transport-package'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Purchase_BRN()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        echo "Status Key :  (purchase hotel / transport) \n";


        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT DISTINCT  "BRN"."brn"."BRNType", count("BRN"."brn"."BRNCode") as "TotBRN" 
                    FROM "BRN"."brn"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    GROUP BY "BRN"."brn"."BRNType"';

            //echo $SQL;

            $purchasebrns = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            foreach ($purchasebrns as $purchasebrn) {
                $AllowTPTArrival = $purchasebrn['TotBRN'];
                echo "Domain (" . $Domain['Name'] . "): " . $purchasebrn['BRNType'] . " BRN " . $AllowTPTArrival . " Records;\n";

                $temp = array();
                $temp['StatsKey'] = 'purchase-' . $purchasebrn['BRNType'];
                $temp['DomainID'] = $Domain['UID'];
                $temp['Value'] = $AllowTPTArrival;
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;
            }

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'purchase-hotel'));
        $Crud->DeleteRecord($table, array("StatsKey" => 'purchase-transport'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Hotel_BRN_Used()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-used) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" 
                    FROM pilgrim."meta"
                    LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'hotel\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Used " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-used';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-used'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Hotel_BRN_Balance()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-balance) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" 
                    FROM pilgrim."meta"
                    LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'hotel\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Balance " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-balance';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-balance'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Hotel_BRN_Expired()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-expired) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT "BRN"."brn"."UID") as "TotBRN" 
                    FROM "BRN"."brn"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'hotel\'
                    AND "BRN"."brn"."ExpireDate" < CURRENT_DATE';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Expired " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-expired';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-expired'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Hotel_BRN_Actual_Room()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-actual-room) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT SUM("BRN"."brn"."Rooms"::int) as "TotBRN" 
                    FROM "BRN"."brn"
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'hotel\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Actual Room " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-actual-room';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-actual-room'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Hotel_BRN_Actual_Beds()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-actual-beds) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT SUM("BRN"."brn"."Beds"::int) as "TotBRN" 
                    FROM "BRN"."brn"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'hotel\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Actual Beds " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-actual-beds';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-actual-beds'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Hotel_BRN_Balance_Room()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-balance-room) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = '
            SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" FROM pilgrim."meta" 
            LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value" 
            AND "BRN"."brn"."BRNType"=\'hotel\' AND "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . '
            
            WHERE ("Option" LIKE \'%accommodation%\') AND "Value" = \'Rooms\' ';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Balance Room " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-balance-room';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-balance-room'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Hotel_BRN_Balance_Bed()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (hotel-brn-balance-bed) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = '
            SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" FROM pilgrim."meta" 
            LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value" 
            AND "BRN"."brn"."BRNType"=\'hotel\' AND "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . '
            
            WHERE ("Option" LIKE \'%accommodation%\') AND "Value" = \'Beds\' ';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): Hotel BRN Balance Bed " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'hotel-brn-balance-bed';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'hotel-brn-balance-bed'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function Transport_BRN_Used()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (transport-brn-used) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" 
                    FROM pilgrim."meta"
                    LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'transport\'  AND "BRN"."brn"."UseType"=\'visa_and_transport\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): transport BRN Used " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'transport-brn-used';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'transport-brn-used'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Transport_BRN_Balance()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (transport-brn-balance) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" 
                    FROM pilgrim."meta"
                    LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'transport\'';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): transport BRN Balance " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'transport-brn-balance';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'transport-brn-balance'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Transport_BRN_Expired()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (transport-brn-expired) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(DISTINCT "BRN"."brn"."UID") as "TotBRN" 
                    FROM "BRN"."brn"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'transport\'
                    AND "BRN"."brn"."ExpireDate" < CURRENT_DATE';

            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): transport BRN Expired " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'transport-brn-expired';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'transport-brn-expired'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Transport_BRN_Visa_Used()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (transport-brn-visa-used) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT count(DISTINCT pilgrim."meta"."Value") as "TotBRN" 
                    FROM pilgrim."meta"
                    LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"
                    
                    WHERE "BRN"."brn"."WebsiteDomain" = ' . $Domain['UID'] . ' 
                    AND "BRN"."brn"."BRNType"=\'transport\' AND "BRN"."brn"."UseType"=\'Visa\'';
            //echo $SQL;

            $hotelbrnused = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $TotalBRNUsed = $hotelbrnused[0]['TotBRN'];
            echo "Domain (" . $Domain['Name'] . "): transport BRN Visa Used " . $TotalBRNUsed . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'transport-brn-visa-used';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $TotalBRNUsed;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'transport-brn-visa-used'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function Transport_BRN_Sectors_Stats()
    {
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);
        $LookupsOptions = $Crud->LookupOptions('transport_sectors');
        foreach ($LookupsOptions as $options) {
            echo "Status Key :  (transport-brn-sector-" . $options['UID'] . ") \n";

        }

        $SQL = '
        SELECT Distinct count(Distinct pilgrim."meta"."PilgrimUID") as "TotalCNT",
        "voucher"."TransportRate"."Sectors", "BRN"."brn"."WebsiteDomain"
        FROM pilgrim."meta"
        LEFT JOIN "BRN"."brn" ON (cast("BRN"."brn"."UID" as character varying))=pilgrim."meta"."Value"
        LEFT JOIN "voucher"."TransportRate" ON "voucher"."TransportRate"."UID"=pilgrim."meta"."AllowReference"
        WHERE "BRN"."brn"."BRNType"=\'transport\'
        Group By "BRN"."brn"."WebsiteDomain", "voucher"."TransportRate"."Sectors" 
        ';
        $FINAL = array();
        $SectorsBRNs = $Crud->ExecuteSQL($SQL); //print_r($b2c);
        foreach ($SectorsBRNs as $SectorsBRN) {
            $FINAL[$SectorsBRN['WebsiteDomain']][$SectorsBRN['Sectors']] = $SectorsBRN['TotalCNT'];
        }

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($LookupsOptions as $options) {
            foreach ($Domains as $Domain) {
                $TotalBRNUsed = (isset($FINAL[$Domain['UID']][$options['UID']])) ? $FINAL[$Domain['UID']][$options['UID']] : 0;
                echo "Domain (" . $Domain['Name'] . "): Transport BRN Sector " . $options['Name'] . " : " . $TotalBRNUsed . " Records;\n";

                $temp = array();
                $temp['StatsKey'] = 'transport-brn-sector-' . $options['UID'] . ' ';
                $temp['DomainID'] = $Domain['UID'];
                $temp['Value'] = $TotalBRNUsed;
                $temp['SystemDate'] = "NOW()";
                $InstRecords[] = $temp;
            }
            ////echo "<pre>"; print_r($InstRecords);
            // echo $SQL;
        }

        $table = 'websites."stats"';
        $SQL = 'DELETE FROM websites."stats" WHERE "StatsKey" LIKE \'%transport-brn-sector-%\'';
        $Crud->ExecuteSQL($SQL);
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function PptManagement()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo; PptManagement() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (ppt-management) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                    LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                    where pilgrim."master"."AgentUID" IS NOT NULL
                    AND pilgrim."master"."UID" NOT IN(SELECT Distinct  pilgrim."attachments"."PilgrimID"
                    FROM pilgrim."attachments"
                    WHERE pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportFrontPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBackPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBookletPic\'))  
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'] + 0;


            if ($view) echo "Domain (" . $Domain['Name'] . "): PptManagement " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'ppt-management';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'ppt-management'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function CompletedPptManagement()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo; CompletedPptManagement() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (completed-ppt-management) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT count(pilgrim."master"."UID") as "TotPilgrims" 
                    FROM pilgrim."master"
                    LEFT JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN main."Groups" ON pilgrim."master"."GroupUID"  = main."Groups"."UID"
                    LEFT JOIN pilgrim."mofa" ON pilgrim."mofa"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN pilgrim."visa" ON pilgrim."visa"."PilgrimID"=pilgrim."master"."UID"
                    LEFT JOIN main."Agents" ON pilgrim."master"."AgentUID" = main."Agents"."UID"
                    LEFT JOIN main."Countries" ON (main."Agents"."CountryID" = main."Countries"."ISO2")
                    LEFT JOIN sale_agent."Meta" ON (cast(sale_agent."Meta"."Value" as int) = main."Agents"."UID" AND sale_agent."Meta"."Option"=\'Agent_ID\')
                    LEFT JOIN sale_agent."Agents" ON sale_agent."Agents"."UID" = sale_agent."Meta"."SaleAgentID"
                    where pilgrim."master"."AgentUID" IS NOT NULL
                    AND pilgrim."master"."UID" IN(SELECT Distinct  pilgrim."attachments"."PilgrimID"
                    FROM pilgrim."attachments"
                    WHERE pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportFrontPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBackPic\')
                    AND 
                    pilgrim."attachments"."PilgrimID" IN(SELECT pilgrim."attachments"."PilgrimID" FROM pilgrim."attachments" WHERE pilgrim."attachments"."FileDescription" = \'PassportBookletPic\'))  
                    AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . ' ';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival = $b2c[0]['TotPilgrims'] + 0;


            if ($view) echo "Domain (" . $Domain['Name'] . "): CompletedPptManagement " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-ppt-management';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-ppt-management'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    //////Free Bed
    public
    function allow_bed()
    {
        $Crud = new Crud();
        $view = false;

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (allow-bed) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = '
            SELECT distinct  "pilgrim"."meta"."SystemDate", "pilgrim"."meta"."Value" as "TotalBeds",
            (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate") as "TotalPilgrims",
            (
                CAST("pilgrim"."meta"."Value" AS int) - 
                (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                    WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                )            
            ) as "FreeBeds",
            (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference") as "ActivityExpireDate"
            FROM "pilgrim"."meta" 
            INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "pilgrim"."meta"."PilgrimUID"
            WHERE "pilgrim"."meta"."Option" LIKE \'%no-of-bed%\' AND "pilgrim"."master"."WebsiteDomain" = \'' . $Domain['UID'] . '\'
            AND (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference") >= \'' . date("Y-m-d") . '\'
            AND (
                    CAST("pilgrim"."meta"."Value" AS int) - 
                    (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                        WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                    )
            ) > 0';

            //echo $SQL;

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival1 = 0;
            foreach ($b2c as $purchasebrn) {
                $AllowTPTArrival1 += $purchasebrn['FreeBeds'];
            }
            $AllowTPTArrival = $AllowTPTArrival1 + 0;
            //$AllowTPTArrival = $b2c[0]['FeeBeds'] + 0;


            if ($view) echo "Domain (" . $Domain['Name'] . "): Allow Bed " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'allow-bed';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'allow-bed'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function completed_allow_bed()
    {
        return true;
        $Crud = new Crud();

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        echo "Status Key :  (completed-allow-bed) \n";

        $AllowTPTArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = '
            SELECT distinct  "pilgrim"."meta"."SystemDate", "pilgrim"."meta"."Value" as "TotalBeds",
            (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate") as "TotalPilgrims",
            (
                CAST("pilgrim"."meta"."Value" AS int) - 
                (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                    WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                )            
            ) as "FreeBeds",
            (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference") as "ActivityExpireDate"
            FROM "pilgrim"."meta" 
            INNER JOIN "pilgrim"."master" ON "pilgrim"."master"."UID" = "pilgrim"."meta"."PilgrimUID"
            WHERE "pilgrim"."meta"."Option" LIKE \'%no-of-bed%\' AND "pilgrim"."master"."WebsiteDomain" = \'' . $Domain['UID'] . '\'
            AND (SELECT "voucher"."AccommodationDetails"."CheckOut" FROM "voucher"."AccommodationDetails" WHERE "voucher"."AccommodationDetails"."UID" = "pilgrim"."meta"."AllowReference") < \'' . date("Y-m-d") . '\'
            AND (
                    CAST("pilgrim"."meta"."Value" AS int) - 
                    (SELECT COUNT("PilgrimMeta2"."Option") FROM "pilgrim"."meta" as "PilgrimMeta2" 
                        WHERE "PilgrimMeta2"."Option" LIKE \'%no-of-bed%\' AND "PilgrimMeta2"."SystemDate" = "pilgrim"."meta"."SystemDate"
                    )
            ) > 0';

            $b2c = $Crud->ExecuteSQL($SQL); //print_r($b2c);
            $AllowTPTArrival1 = 0;
            foreach ($b2c as $purchasebrn) {
                $AllowTPTArrival1 += $purchasebrn['FreeBeds'];
            }
            $AllowTPTArrival = $AllowTPTArrival1 + 0;
            // $AllowTPTArrival = $b2c[0]['FeeBeds'] + 0;

            echo "Domain (" . $Domain['Name'] . "): Completed Allow Bed " . $AllowTPTArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-allow-bed';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $AllowTPTArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

        ////echo "<pre>"; print_r($InstRecords);
        // echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-allow-bed'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public
    function without_vocuher_arrival()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo " Function &raquo; without_vocuher_arrival() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (without-vchr-arrival) \n";

        $WithoutVoucherArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {
            $SQL = 'SELECT pilgrim."master".*, pilgrim."travel".*,main."Agents"."FullName" AS "AgentName",main."Groups"."FullName" AS "GroupName",main."Groups"."UID" AS "GroupUID"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID" 
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")   AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
                AND pilgrim."master"."UID" NOT IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')
';
            $record = $Crud->ExecuteSQL($SQL);
            $WithoutVoucherArrival = count($record);


            if ($view) echo "Domain (" . $Domain['Name'] . "): Without Voucher Arrival " . $WithoutVoucherArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'without-vchr-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $WithoutVoucherArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;

        }

//         echo "<pre>"; print_r($InstRecords);
//         echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'without-vchr-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }


    public
    function completed_without_vocuher_arrival()
    {
        $Crud = new Crud();
        $view = true;
        if ($view) echo "Function &raquo; completed_without_vocuher_arrival() \n";

        $Domaintable = 'websites."Domains"';
        $Where = array();
        $Domains = $Crud->ListRecords($Domaintable, $Where);

        if ($view) echo "Status Key :  (completed-without-vchr-arrival) \n";

        $WithoutVoucherArrival = 0;

        $InstRecords = array();
        foreach ($Domains as $Domain) {

            $SQL = 'SELECT pilgrim."master".*, pilgrim."travel".*,main."Agents"."FullName" AS "AgentName",main."Groups"."FullName" AS "GroupName",main."Groups"."UID" AS "GroupUID"
                FROM pilgrim."master"
                INNER JOIN pilgrim."travel" ON pilgrim."travel"."PilgrimID"  = pilgrim."master"."UID" 
                LEFT JOIN main."Agents" ON main."Agents"."UID"  = pilgrim."master"."AgentUID" 
                LEFT JOIN main."Groups" ON main."Groups"."UID"  = pilgrim."master"."GroupUID" 
                WHERE pilgrim."master"."UID" NOT IN (SELECT voucher."Pilgrim"."PilgrimUID" FROM voucher."Pilgrim")   AND "pilgrim"."master"."WebsiteDomain" = ' . $Domain['UID'] . '
              AND pilgrim."master"."UID" IN (SELECT DISTINCT pilgrim."meta"."PilgrimUID" FROM pilgrim."meta" WHERE pilgrim."meta"."Option" = \'WithoutVoucherArrivalRemarks\')
';
            $record = $Crud->ExecuteSQL($SQL);
            $WithoutVoucherArrival = count($record);


            if ($view) echo "Domain (" . $Domain['Name'] . "): Completed Without Voucher Arrival " . $WithoutVoucherArrival . " Records;\n";

            $temp = array();
            $temp['StatsKey'] = 'completed-without-vchr-arrival';
            $temp['DomainID'] = $Domain['UID'];
            $temp['Value'] = $WithoutVoucherArrival;
            $temp['SystemDate'] = "NOW()";
            $InstRecords[] = $temp;
        }

//         echo "<pre>"; print_r($InstRecords);
//         echo $SQL;

        $table = 'websites."stats"';
        $Crud->DeleteRecord($table, array("StatsKey" => 'completed-without-vchr-arrival'));
        if (count($InstRecords) > 0) {
            $db = db_connect();
            $db->db_debug = false;
            $db->table($table)->insertBatch($InstRecords, null);
            $db->close();
        }
    }

    public function CronActivity()
    {
        $Crud = new Crud();
        $Main = new Main();
        $IgnorList = array('CronAllActivitiesRunDaily', 'CronActivity');
        $SQL = 'SELECT * FROM websites."CronActivities" WHERE "Flag" = 0 AND "FunctionName" NOT IN (\'CronAllActivitiesRunDaily\', \'CronActivity\') ORDER BY "UID" LIMIT 1';
        $Records = $Crud->ExecuteSQL($SQL);
        //print_r($Records);
        //exit;
        foreach ($Records as $Record) {
            $FunName = $Record['FunctionName'];

            $start = date("Y-m-d H:i:s");
            $this->$FunName();
            $end = date("Y-m-d H:i:s");
            $Diff = timeDiff($start, $end);

            $Crud->UpdateRecord('websites."CronActivities"', array("Flag" => 1, "LoadTime" => $Diff), array("FunctionName" => $FunName, "Flag" => 0));

            /////////////////////////////////////////////////////////////////////////////////////////////////
//            $email = \Config\Services::email();
//
//            $config['protocol'] = 'sendmail';
//            $config['mailPath'] = '/usr/sbin/sendmail';
//            $config['charset'] = 'iso-8859-1';
//            $config['mailType'] = 'html';
//            $config['wordWrap'] = true;
//
//            $email->initialize($config);
//            $email->setFrom('info@umrahfuras.com', 'Umrah Furas Cron');
//            $email->setTo('malik.shaheryar@orixestech.com');
//            $email->setSubject('Cron Function "' . $FunName . '" Successfully DONE');
//            $email->setMessage('Cron Function= ' . $FunName . '<br>Load Time=' . $Diff);
//            if ($email->send()) {
//                echo "<br>Email Send...!";
//            }
            echo "<br>Function end with load time " . $Diff;
        }
    }

    public function CronAllActivitiesRunDaily($class_methods)
    {
        foreach ($class_methods as $method_name) {
//            if ($method_name != '__construct') {
//                if ($method_name == 'UpdateCronActivity')
//                    break;
//                $this->UpdateCronActivity($method_name);
//            }
        }
    }

    public function UpdateCronActivity($FuncName)
    {
        $Crud = new Crud();
        $table = 'websites."CronActivities"';
        $Crud->AddRecord($table, array("FunctionName" => $FuncName));
    }

}
