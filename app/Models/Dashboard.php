<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Packages;
use App\Models\Main;

class Dashboard extends Model
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

    public function GetDateRang($dateStr)
    {
        switch ($dateStr) {
            case 'current-week';
                $dateto = date("Y-m-d");
                $datefrom = date("Y-m-d", strtotime("-1 week"));
                $dateHtml = date("d M, Y", strtotime($datefrom)) . " - " . date("d M, Y", strtotime($dateto));
                break;
            case 'current-month';
                $dateto = date("Y-m-d");
                $datefrom = date("Y-m-1");
                $dateHtml = date("d M, Y", strtotime($datefrom)) . " - " . date("d M, Y", strtotime($dateto));
                break;
        }

        $FinalArray = array();
        $FinalArray['date_from'] = $datefrom;
        $FinalArray['date_to'] = $dateto;
        $FinalArray['date_html'] = $dateHtml;
        return $FinalArray;
    }

    public function pilgrims_chat()
    {
        $InProcessCounters = new Pilgrims();

        $ExitPilgrimCounters = $InProcessCounters->ExitPilgrimCount();
        $EnterPilgrimCounters = $InProcessCounters->EnterPilgrimCount();
        $InKSAPilgrimCounts = $InProcessCounters->InKSAPilgrimCounts();
        $InProcessCounters = $InProcessCounters->InProcessPilgrimCount();


        $final = array();
        $final["total_enter"] = count($EnterPilgrimCounters);
        $final["total_exit"] = count($ExitPilgrimCounters);
        $final["total_process"] = count($InKSAPilgrimCounts);
        $final["inprocess"] = count($InProcessCounters);

        return $final;
    }

    public function agent_pilgrims_chat()
    {
        $InProcessCounters = new Pilgrims();

        $ExitPilgrimCounters = $InProcessCounters->ExitPilgrimCount();
        $EnterPilgrimCounters = $InProcessCounters->EnterPilgrimCount();
        $InKSAPilgrimCounts = $InProcessCounters->InKSAPilgrimCounts();
        $InProcessCounters = $InProcessCounters->InProcessPilgrimCount();


        $final = array();
        $final["total_enter"] = count($EnterPilgrimCounters);
        $final["total_exit"] = count($ExitPilgrimCounters);
        $final["total_process"] = count($InKSAPilgrimCounts);
        $final["inprocess"] = count($InProcessCounters);

        return $final;
    }

    public function hotels_stats()
    {
        $HotelCounters = new Packages();
        $HotelCounters = $HotelCounters->ListHotels();
        $FiveStar = 0;
        $FourStar = 0;
        $ThreeStar = 0;
        $TwoStar = 0;
        $OneStar = 0;
        $Economy = 0;
        foreach ($HotelCounters as $hotelCounter) {
            if (OptionName($hotelCounter['Category']) == '5 Star') {
                $FiveStar++;
            } else if (OptionName($hotelCounter['Category']) == '4 Star') {
                $FourStar++;
            } else if (OptionName($hotelCounter['Category']) == '3 Star') {
                $ThreeStar++;
            } else if (OptionName($hotelCounter['Category']) == '2 Star') {
                $TwoStar++;
            } else if (OptionName($hotelCounter['Category']) == '1 Star') {
                $OneStar++;
            } else if (OptionName($hotelCounter['Category']) == 'Economy') {
                $Economy++;
            }
        }

        $final = array();
        $final["five_star"] = $FiveStar;
        $final["four_star"] = $FourStar;
        $final["three_star"] = $ThreeStar;
        $final["two_star"] = $TwoStar;
        $final["one_star"] = $OneStar;
        $final["economy"] = $Economy;

        return $final;
    }

    public function all_count()
    {
        $Crud = new Crud();
        $session = session();
        $session = $session->get();
        $final = array();

//        $b2c = $Crud->CountRecordsWithCondition('pilgrim."master"',array("WebsiteDomain" => $session['domainid'],"AgentUID" => NULL));
//        $b2b = $Crud->CountRecordsWithCondition('main."Agents"',array("WebsiteDomain" => $session['domainid']));
//        $external_agents = $Crud->CountRecordsWithCondition('main."Agents"',array("WebsiteDomain" => $session['domainid'],"Type" => 'external_agent'));


        $SQL = 'SELECT COUNT("pilgrim"."master"."UID") AS "B2CCount" FROM "pilgrim"."master"  WHERE "pilgrim"."master"."WebsiteDomain" =  ' . $session['domainid'] . ' AND "pilgrim"."master"."AgentUID" IS NULL  ';
        $Records = $Crud->ExecuteSQL($SQL);
        $final["b2c"] = $Records[0]['B2CCount'];

        $SQL = 'SELECT COUNT("pilgrim"."master"."UID") AS "B2BCount" FROM "pilgrim"."master" 
INNER JOIN "main"."Agents" ON ("pilgrim"."master"."AgentUID" = "main"."Agents"."UID")
  WHERE "pilgrim"."master"."WebsiteDomain" =  ' . $session['domainid'] . ' 
  AND "pilgrim"."master"."AgentUID" IS NOT NULL  AND "main"."Agents"."Type" !=  (\'external_agent\')  ';
        $Records = $Crud->ExecuteSQL($SQL);
        $final["b2b"] = $Records[0]['B2BCount'];


        $SQL = 'SELECT COUNT("pilgrim"."master"."UID") AS "ExternalAgentCount" FROM "pilgrim"."master" 
INNER JOIN "main"."Agents" ON ("pilgrim"."master"."AgentUID" = "main"."Agents"."UID")
  WHERE "pilgrim"."master"."WebsiteDomain" =  ' . $session['domainid'] . ' AND "pilgrim"."master"."AgentUID" IS NOT NULL
    AND "main"."Agents"."Type" =  (\'external_agent\')  ';
        $Records = $Crud->ExecuteSQL($SQL);
        $final["external_agents"] = $Records[0]['ExternalAgentCount'];

        $final["TotalPax"] = ($final["b2c"] + $final["b2b"] + $final["external_agents"]);
        //   echo $SQL;


        return $final;


//
//     $Crud = new Crud();
//        $whereSQL = 'WHERE "pilgrim"."master"."WebsiteDomain" =  '.$session['domainid'].' AND "pilgrim"."master"."AgentUID" = NULL  ';
//
//        $SQL = 'SELECT COUNT("pilgrim"."master"."UID") AS "TOTCNT" FROM "pilgrim"."master"
//        INNER JOIN "main"."Agents" ON ("pilgrim"."master"."AgentUID" = "main"."Agents"."UID")
//        '. $whereSQL . ' ';
//
//        $Records = $Crud->ExecuteSQL($SQL);
//        echo $SQL;
//        return $Records[0]['TOTCNT'];


    }

    public function recent_activities($dateStr, $limit = 0)
    {


        $data = $this->data;
        $recordHTML = '';

        $MainModel = new Main();
        $data['ActivitiesLOGs'] = $MainModel->ActivitiesLog($limit);

        $DateRange = $this->GetDateRang($dateStr);
        $dotcolor = array("primary", "success", "dark", "warning", "secondary", "danger");
        foreach ($data['ActivitiesLOGs'] as $AL) {
            $color = $dotcolor[array_rand($dotcolor)];
            $recordHTML .= '
            <div class="item-timeline timeline-' . $color . '">
                <i class="t-dot"></i>
                <div class="t-text">
                    <p><span>' . $AL['LogNotes'] . '</span></p>
                    <p class="t-time">' . date("h:i A", strtotime($AL['SystemDate'])) . '</p>
                </div>
            </div>';
        }

        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        $final["record_html"] = $recordHTML;
        return $final;
    }

    public function today_stats()
    {
        $final = array();
        $final["today_enter"] = number_format(rand(100000, 150000));
        $final["today_exit"] = number_format(rand(100000, 150000));
        return $final;
    }

    public function group_stats($dateStr)
    {
        $DateRange = $this->GetDateRang($dateStr);

        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        return $final;
    }

    public function mofa_dashboard_group_stats($dateStr)
    {
        $Crud = new Crud();
        $AgentsLink = 'agent/index';
        $GroupLink = 'group/index';
        $PilgrimLink = 'pilgrim/index';
        $MOFALink = 'mofa/index';

        $recordHTML = '';
        $DateRange = $this->GetDateRang($dateStr);

        $groupData = array($AgentsLink => "Total Agents", $GroupLink => "Total Groups", $PilgrimLink => "Total Pilgrims", $MOFALink => "Mofa Issued", "Visa Not Printed", "Visa Issued");
        foreach ($groupData as $link => $Name) {
            $Count = '';
            if ($Name == 'Total Agents') {
                $table = 'main."Agents"';
                $Count = $Crud->CountRecord($table);
            } else if ($Name == 'Total Groups') {
                $table = 'main."Groups"';
                $Count = $Crud->CountRecord($table);
            } else if ($Name == 'Total Pilgrims') {
                $table = 'pilgrim."master"';
                $Count = $Crud->CountRecord($table);

            }
            $recordHTML .= '
            <div class="transactions-list">
                <div class="t-item">
                    <div class="t-company-name">
                       
                        <div class="t-name">
                        <a class="links" href="' . $link . '"> <h4>' . $Name . '</h4></a>
                        <p class="meta-date"></p>
                        </div>
                    </div>
                    <div class="t-rate rate-inc">                      
                        <p><span>' . $Count . '</span>
                        </p>
                    </div>
                </div>
            </div>';
        }

        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        $final["record_html"] = $recordHTML;
        return $final;
    }

    public function transaction_stats($dateStr)
    {
        $DateRange = $this->GetDateRang($dateStr);


        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        return $final;
    }

    public function elm_stats($dateStr)
    {
        $data = $this->data;
        $DateRange = $this->GetDateRang($dateStr);

        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        return $final;
    }

    public function mofa_stats($dateStr)
    {
        $data = $this->data;
        $recordHTML = '';
        $DateRange = $this->GetDateRang($dateStr);

        $groupData = array("Group Processed", "Group error", "Rejected by MOFA", "Approved by MOFA", "Group Arrival", "Call up from consulate");
        foreach ($groupData as $thisData) {
            $recordHTML .= '
            <div class="transactions-list">
                <div class="t-item">
                    <div class="t-company-name">
                        
                        <div class="t-name">
                            <h4>' . ucwords($thisData) . '</h4>
                            <p class="meta-date"></p>
                        </div>

                    </div>
                    <div class="t-rate rate-inc">
                        <p><span>' . rand(15, 89) . '</span>
                        </p>
                    </div>
                </div>
            </div>';
        }

        $final = array();
        $final["date_html"] = $DateRange['date_html'];
        $final["record_html"] = $recordHTML;
        return $final;
    }

    public function agents_chart($agent)
    {
        $data = $this->data;
        $Agents = new Agents();
        $agentId = $agent;
        $AgentData = $Agents->AgentsCountries();
        $ChartData = array();
        $ChartLabel = array();
        foreach ($AgentData as $AgentD) {
            $ChartData[] = $AgentD['totalagents'];
            $ChartLabel[] = $AgentD['Name'];
        }


        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function pilgrims_chart()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->PilgrimsCountries($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = $PilgrimsD['CountryName'];
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public
    function new_monthly_pilgrims(){

        $data = $this->data;
        $Pilgrims = new Pilgrims();
        $PilgrimsData = $Pilgrims->NewMonthlyPilgrims($data['session']['domainid']);

        return $PilgrimsData;
    }

    public function monthly_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->MonthlyPilgrims($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['TotalPilgrims'];
            $ChartLabel[] = date("M Y", strtotime($PilgrimsD['Year'] . '-' . $PilgrimsD['Month'] . '-01'));
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function yearly_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->YearlyPilgrims($data['session']['domainid']);
        //echo '<pre>';print_r($PilgrimsData);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $Year =>  $PilgrimsD) {
            $ChartData[] = $PilgrimsD;
            //$ChartLabel[] = date("M Y", strtotime($PilgrimsD['Year'] . '-01'));
            $ChartLabel[] = $Year;
//            $ChartLabel[] = $PilgrimsD['Year'];
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
//        echo $final;
        return $final;
    }

    public function top_b2b_based_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->TopB2BPilgrims($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = $PilgrimsD['AgentName'];
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function agent_based_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->B2BAgentsData($data['session']['id']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = $PilgrimsD['AgentName'];
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function company_based_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->CompanyBasedPilgrims($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = $PilgrimsD['CompanyName'];
        }


        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function country_based_pilgrims()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->PilgrimsCountries($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            if ($PilgrimsD['totalpilgrims'] > 0) {
                $ChartData[] = $PilgrimsD['totalpilgrims'];
                $ChartLabel[] = ($PilgrimsD['CountryName']==null) ? 'Undefined ' : $PilgrimsD['CountryName'] ;
            }
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function agent_monthly_pilgrims_chart()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->AgentMonthlyPilgrimsCountries($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = date("M Y", strtotime($PilgrimsD['to_date']));
        }


        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function sale_agent_pilgrims_chart()
    {
        $data = $this->data;
        $Pilgrims = new \App\Models\Pilgrims();
        //$agentId = $agent;
        //print_r($data['session']);
        $PilgrimsData = $Pilgrims->SaleAgentPilgrims($data['session']['domainid']);
        $ChartData = array();
        $ChartLabel = array();
        foreach ($PilgrimsData as $PilgrimsD) {
            $ChartData[] = $PilgrimsD['totalpilgrims'];
            $ChartLabel[] = $PilgrimsD['AgentName'];
        }

        $final = array();
        $final["data"] = $ChartData;
        $final["label"] = $ChartLabel;
        return $final;
    }

    public function OnlyHotels()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $HOTELKeys = array();


        $SQL = 'SELECT DISTINCT voucher."Master"."UID",
                packages."Hotels"."Category",
                
                main."LookupsOptions"."Name",
                
                voucher."AccommodationDetails"."UID",
                ((voucher."AccommodationDetails"."CheckOut"::DATE - voucher."AccommodationDetails"."CheckIn"::DATE)) AS "NoofNights",
                
                count(distinct voucher."Pilgrim"."PilgrimUID") as "TotalVoucherPAX",
                
                (SELECT count( distinct meta."PilgrimUID")
                FROM pilgrim."meta"
                WHERE meta."Option" LIKE \'%check-in-%-room-no%\' AND meta."AllowReference" = voucher."AccommodationDetails"."UID"
                AND meta."PilgrimUID" IN(
                SELECT Voucher."Pilgrim"."PilgrimUID" FROM Voucher."Pilgrim" WHERE Voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                )) as "MetaPEX",
                
                (SELECT count( distinct meta."Value")
                FROM pilgrim."meta"
                WHERE meta."Option" LIKE \'%check-in-%-room-no%\' AND meta."AllowReference" = voucher."AccommodationDetails"."UID"
                AND meta."PilgrimUID" IN(
                SELECT Voucher."Pilgrim"."PilgrimUID" FROM Voucher."Pilgrim" WHERE Voucher."Pilgrim"."VoucherUID" = voucher."Master"."UID"
                )) as "MetaRoom"
               
                FROM voucher."AccommodationDetails"
                INNER JOIN voucher."Pilgrim" ON voucher."Pilgrim"."VoucherUID"= voucher ."AccommodationDetails"."VoucherID"
                INNER JOIN voucher."Master" ON (cast(voucher."AccommodationDetails"."VoucherID" as character varying)=cast(voucher."Master"."UID" as character varying))
                INNER JOIN packages."Hotels" ON (cast(packages."Hotels"."UID" as character varying)=cast(voucher."AccommodationDetails"."Hotel" as character varying))
                INNER JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying)=cast(packages."Hotels"."Category" as character varying))
                where voucher."AccommodationDetails"."Self"=0 ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        $SQL .= 'GROUP BY main."LookupsOptions"."Name",voucher."Master"."UID",packages."Hotels"."Category",voucher."AccommodationDetails"."UID"
        ORDER BY packages."Hotels"."Category",voucher."Master"."UID"';

        //echo nl2br($SQL);exit();

        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public function OnlyTransport()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();


        $SQL = 'SELECT 
                DISTINCT
                packages."Transport"."Type",
                main."LookupsOptions"."Name",
                
                COUNT(voucher."TransportRate"."TransportTypeUID") as "TotalTransport",
                SUM(cast(voucher."TransportRate"."NoOfSeats" as int)) AS "NoOfSeats",
                SUM(cast(voucher."TransportRate"."NoOfPax" as int)) AS "NoOfPax"
                FROM voucher."TransportRate"
                INNER JOIN voucher."Master" ON (cast(voucher."TransportRate"."VoucherUID" as character varying)=cast(voucher."Master"."UID" as character varying))
                INNER JOIN packages."Transport" ON (cast(packages."Transport"."UID" as character varying)=cast(voucher."TransportRate"."TransportTypeUID" as character varying))
                INNER JOIN main."LookupsOptions" ON (cast(main."LookupsOptions"."UID" as character varying)=cast(packages."Transport"."Type" as character varying))
                where voucher."TransportRate"."SelfTransport"=0
                
                
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }
        $SQL .= 'GROUP BY packages."Transport"."Type",main."LookupsOptions"."Name"
                 ORDER BY COUNT(voucher."TransportRate"."TransportTypeUID") DESC  ';

        //echo $SQL;exit();


        $records = $Crud->ExecuteSQL($SQL);

        return $records;
    }

    public function OnlyExtras()
    {
        $data = $this->data;
        $Crud = new Crud();

        $session = session();
        $session = $session->get();

        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "Package"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }

        //echo nl2br($SQL);exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        /////Visa And Transport
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "Visa_and_Transport"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))
               ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        /////Visa And Hotel
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "Visa_and_Hotel"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        /////Only Visa
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "OnlyVisa"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))
                
               ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        ////Only Hotel
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "OnlyHotel"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" NOT IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();
        $records[] = $Crud->ExecuteSQL($SQL);
        ////Only Transport
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "OnlyTransport"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" NOT IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))
                ';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();
        $records[] = $Crud->ExecuteSQL($SQL);
        ////Only services
        $SQL = 'Select count(Distinct pilgrim."master"."UID") AS "OnlyServices"
                FROM pilgrim."master"
                INNER JOIN voucher."Pilgrim"  ON voucher."Pilgrim"."PilgrimUID"=pilgrim."master"."UID"
                where
                pilgrim."master"."UID" NOT IN(SELECT pilgrim."mofa"."PilgrimID"
                FROM pilgrim."mofa"
                where pilgrim."mofa"."PilgrimID">0)
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."AccommodationDetails" ON (voucher."AccommodationDetails"."VoucherID"=voucher."Pilgrim"."VoucherUID" AND voucher."AccommodationDetails"."Self"=0))
                AND
                pilgrim."master"."UID" NOT IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."TransportRate" ON (voucher."TransportRate"."VoucherUID"=voucher."Pilgrim"."VoucherUID" AND voucher."TransportRate"."SelfTransport"=0))
                AND
                pilgrim."master"."UID" IN(Select voucher."Pilgrim"."PilgrimUID" AS "PilgrimUID"
                FROM voucher."Pilgrim"
                INNER JOIN voucher."Services" ON (voucher."Services"."VoucherUID"=voucher."Pilgrim"."VoucherUID"))';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  pilgrim."master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo nl2br($SQL);exit();
        $records[] = $Crud->ExecuteSQL($SQL);
        $SQL = 'Select count(voucher."Pilgrim"."VoucherUID") AS "PaxWithoutHotel"
                FROM voucher."Pilgrim" 
                where voucher."Pilgrim"."VoucherUID" IN(
                SELECT 
                Distinct
                voucher."Master"."UID"
                From voucher."Master"
                LEFT JOIN voucher."AccommodationDetails" ON (cast(voucher."AccommodationDetails"."VoucherID" as character varying)=cast(voucher."Master"."UID" as character varying) ) 
                
                where  voucher."AccommodationDetails"."VoucherID" IS NULL  OR voucher."AccommodationDetails"."Self"=1)';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo $SQL;exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        $SQL = 'Select count(voucher."Pilgrim"."VoucherUID") AS "PaxWithoutTransport"
                FROM voucher."Pilgrim" 
                where voucher."Pilgrim"."VoucherUID" IN(
                SELECT 
                Distinct
                voucher."Master"."UID"
                From voucher."Master"
                
                LEFT JOIN voucher."TransportRate" ON (cast(voucher."TransportRate"."VoucherUID" as character varying)=cast(voucher."Master"."UID" as character varying) )  
                
                where  voucher."TransportRate"."VoucherUID" IS NULL  OR voucher."TransportRate"."SelfTransport"=1)';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo $SQL;exit();

        $records[] = $Crud->ExecuteSQL($SQL);
        $SQL = 'Select count(voucher."Pilgrim"."VoucherUID") AS "OnlyVisa"
                From
                voucher."Pilgrim"
                where 
                voucher."Pilgrim"."VoucherUID" NOT IN(
                
                Select voucher."Flights"."VoucherID" AS "VoucherID"
                FROM 
                voucher."Flights"
                where voucher."Flights"."TravelSelf"=1
                
                union
                
                Select voucher."AccommodationDetails"."VoucherID" AS "VoucherID"
                From
                voucher."AccommodationDetails"
                where voucher."AccommodationDetails"."Self"=1
                union
                
                Select voucher."TransportRate"."VoucherUID" AS "VoucherID"
                From 
                voucher."TransportRate"
                where voucher."TransportRate"."SelfTransport"=1
                )';

        if ($session['domainid'] > 0) {
            $SQL .= ' AND  voucher."Master"."WebsiteDomain" =  ' . $session['domainid'] . ' ';
        }


        //echo $SQL;exit();

        $records[] = $Crud->ExecuteSQL($SQL);

        return $records;
    }


}
