<?php namespace App\Controllers;

use App\Models\Pilgrims;
use App\Models\Agents;
use App\Models\Groups;
use App\Models\Main;
use App\Models\Dashboard;
use App\Models\CronModel;

class Dashboard_ajax extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultAjaxVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
    }

    public function pilgrims_chat()
    {
        /*$data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->pilgrims_chat();*/


        $Main=$this->MainModel;
        $DashboardCounters=$Main->DashboardCounters();

        $TotalArrival=$DashboardCounters['total-arrival'];
        $TotalExit=$DashboardCounters['total-exit'];
        $TotalPaxInKSA=$DashboardCounters['total-pax-in-ksa'];


        $Pilgrims = new Pilgrims();
        $InProcessCounters = $Pilgrims->InProcessPilgrimCount();

        $final = array();
        $final["total_enter"] = ( ( isset($TotalArrival) && $TotalArrival != '' )? $TotalArrival : 0 );
        $final["total_exit"] = ( ( isset($TotalExit) && $TotalExit != '' )? $TotalExit : 0 );
        $final["total_process"] = ( ( isset($TotalPaxInKSA) && $TotalPaxInKSA != '' )? $TotalPaxInKSA : 0 );
        $final["inprocess"] = count($InProcessCounters);

        echo json_encode($final);
    }

    public function agent_pilgrims_chat()
    {
        /*$data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->agent_pilgrims_chat();
        echo json_encode($data['records']);*/

        $CroneModel = new CronModel(); $Pilgrims = new Pilgrims();



        $TotalArrival = $CroneModel->TotalArrivals();
        $TotalExit = $CroneModel->TotalExit();
        $TotalPaxInKSA = $CroneModel->TotalPaxinKSA();
        $InProcessCounters = $Pilgrims->InProcessPilgrimCount();

        $final = array();
        $final["total_enter"] = ( ( isset($TotalArrival) && $TotalArrival != '' )? $TotalArrival : 0 );
        $final["total_exit"] = ( ( isset($TotalExit) && $TotalExit != '' )? $TotalExit : 0 );
        $final["total_process"] = ( ( isset($TotalPaxInKSA) && $TotalPaxInKSA != '' )? $TotalPaxInKSA : 0 );
        $final["inprocess"] = count($InProcessCounters);

        echo json_encode($final);
    }

    public function hotel_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $data['records'] = $Dashboard->hotels_stats();
        echo json_encode($data['records']);
    }

    public function all_counts()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $data['records'] = $Dashboard->all_count();
        echo json_encode($data['records']);
    }

    public function recent_activities()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $dateStr = $_POST['date'];
        $limit = $_POST['limit'];
        $data['records'] = $Dashboard->recent_activities($dateStr, $limit);
        echo json_encode($data['records']);
    }

    public function today_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $data['records'] = $Dashboard->today_stats();
        echo json_encode($data['records']);
    }

    public function group_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard() ;

        $DashboardCounters = new Main();
        $data['DashboardCounters'] = $DashboardCounters->DashboardCounters();


        $dateStr = $_POST['date'];
        $data['records'] = $Dashboard->group_stats($dateStr);
        echo json_encode($data['records']);
    }

    public function mofa_dashboard_group_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $dateStr = $_POST['date'];

        $data['records'] = $Dashboard->mofa_dashboard_group_stats($dateStr);

        echo json_encode($data['records']);
    }

    public function transaction_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $dateStr = $_POST['date'];
        $data['records'] = $Dashboard->transaction_stats($dateStr);
        echo json_encode($data['records']);
    }

    public function elm_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $dateStr = $_POST['date'];
        $data['records'] = $Dashboard->elm_stats($dateStr);
        echo json_encode($data['records']);
    }

    public function mofa_stats()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $dateStr = $_POST['date'];
        $data['records'] = $Dashboard->mofa_stats($dateStr);
        echo json_encode($data['records']);
    }

    public function agents_chart()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();

        $agent = $_POST['agent'];
        $data['records'] = $Dashboard->agents_chart($agent);
        echo json_encode($data['records']);
    }

    public function pilgrims_chart()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->pilgrims_chart();
        echo json_encode($data['records']);
    }

    public
    function new_monthly_pilgrims(){

        /*$FinalArray = array(
            'labels' => array('Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'),
            'data' => array(
                array(
                    'name' => '2020',
                    'data' => array(0, 25, 30, 35)
                ),
                array(
                    'name' => '2021',
                    'data' => array(15, 30, 35, 45, 55, 65, 75, 85)
                ),
                array(
                    'name' => '2022',
                    'data' => array(20, 35, 45, 55, 65, 75, 85, 95, 105, 115, 125, 135)
                )
            )
        );*/
        $Dashboard = new Dashboard(); $FinalArray = $MainArray = array();
        $MonthArray = array('1' => 'Jan', '2' => 'Feb', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July',
            '8' => 'Aug', '9' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        $MainArray['labels'] = array('Jan','Feb','March','April','May','June','July', 'Aug','Sep','Oct','Nov','Dec');
        $PilgrimsData = $Dashboard->new_monthly_pilgrims();

        foreach ($PilgrimsData as $Year => $MonthsData){
            $Data = array();
            foreach( $MonthArray as $No => $Name ){

                if(isset( $MonthsData[$No] ) && $MonthsData[$No] != ''){
                    $Data[] = $MonthsData[$No];
                }else{
                    $Data[] = 0;
                }
                $FinalArray['name'] = $Year;
                $FinalArray['data'] = $Data;
            }

            $MainArray['data'][] = $FinalArray;
        }

        return json_encode($MainArray);
    }

    public function monthly_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->monthly_pilgrims();
        echo json_encode($data['records']);
    }

    public function yearly_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->yearly_pilgrims();
        echo json_encode($data['records']);
    }

    public function country_based_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->country_based_pilgrims();
        echo json_encode($data['records']);
    }

    public function agent_based_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->agent_based_pilgrims();
        echo json_encode($data['records']);
    }

    public function company_based_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->company_based_pilgrims();
        echo json_encode($data['records']);
    }

    public function top_b2b_based_pilgrims()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->top_b2b_based_pilgrims();
        echo json_encode($data['records']);
    }

    public function agent_monthly_pilgrims_chart()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->agent_monthly_pilgrims_chart();
        echo json_encode($data['records']);
    }

    public function sale_agent_pilgrims_chart()
    {
        $data = $this->data;
        $Dashboard = new Dashboard();
        $data['records'] = $Dashboard->sale_agent_pilgrims_chart();
        echo json_encode($data['records']);
    }
}
