<?php namespace App\Controllers;

use App\Models\Groups;
use App\Models\Main;
use App\Models\Pilgrims;
use App\Models\Users;
use App\Models\Packages;
use App\Models\Crud;

class Filters extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
    }


    public
    function clear_session()
    {
        $session = session();
        $SessionName = $this->request->getVar('SessionName');

        $session->set($SessionName, array());

        $response = array();
        $response['status'] = 'success';
        $response['message'] = "Filters Updated Successfully";
        echo json_encode($response);
    }

    public
    function b2c_report_search_filters_form_submit()
    {
        $session = session();

        $Country = $this->request->getVar('Country');
        $WebReference = $this->request->getVar('WebReference');
        $BPOID = $this->request->getVar('BPOID');

        $B2CStatsFilter = array(
            'Country' => $Country,
            'GroupName' => $WebReference,
            'BPOID' => $BPOID
        );

        $session->set('B2CStatsFilter', $B2CStatsFilter);

        $response['status'] = "success";
        $response['message'] = "B2C Search Filters Updated Successfully";
        echo json_encode($response);
    }

    public
    function b2b_report_search_filters_form_submit()
    {
        $session = session();

        $Country = $this->request->getVar('Country');
        $IATA = $this->request->getVar('IATA');
        $Group = $this->request->getVar('Group');
        $Package = $this->request->getVar('Package');
        $Reference = $this->request->getVar('Reference');

        $B2CStatsFilter = array(
            'Country' => $Country,
            'IATA' => $IATA,
            'Group' => $Group,
            'Package' => $Package,
            'Reference' => $Reference
        );

        $session->set('B2CStatsFilter', $B2CStatsFilter);

        $response['status'] = "success";
        $response['message'] = "B2B Search Filters Updated Successfully";
        echo json_encode($response);
    }

    public
    function external_report_search_filters_form_submit()
    {
        $session = session();

        $Country = $this->request->getVar('Country');
        $IATA = $this->request->getVar('IATA');
        $Group = $this->request->getVar('Group');
        $Package = $this->request->getVar('Package');
        $Reference = $this->request->getVar('Reference');

        $ExternalStatsFilter = array(
            'Country' => $Country,
            'IATA' => $IATA,
            'Group' => $Group,
            'Package' => $Package,
            'Reference' => $Reference
        );

        $session->set('ExternalStatsFilter', $ExternalStatsFilter);

        $response['status'] = "success";
        $response['message'] = "External Search Filters Updated Successfully";
        echo json_encode($response);
    }
    public
    function total_pax_report_search_filters_form_submit()
    {
        $session = session();

        $Country = $this->request->getVar('Country');
        $IATA = $this->request->getVar('IATA');
        $Group = $this->request->getVar('Group');
        $Category = $this->request->getVar('Category');
        $Package = $this->request->getVar('Package');
        $Reference = $this->request->getVar('Reference');
        $PilgrimStatus = $this->request->getVar('PilgrimStatus');

        $TotalPaxStatsFilter = array(
            'Country' => $Country,
            'IATA' => $IATA,
            'Group' => $Group,
            'Category' => $Category,
            'Package' => $Package,
            'Reference' => $Reference,
            'Reference' => $PilgrimStatus
        );

        $session->set('TotalPaxStatsFilter', $TotalPaxStatsFilter);

        $response['status'] = "success";
        $response['message'] = "Total Pax Search Filters Updated Successfully";
        echo json_encode($response);
    }

}
