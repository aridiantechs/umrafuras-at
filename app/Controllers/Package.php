<?php namespace App\Controllers;

use App\Models\Agents;
use App\Models\Crud;
use App\Models\Groups;
use App\Models\Main;
use App\Models\Packages;

class Package extends BaseController
{
    var $data = array();
    var $MainModel;

    public function __construct()
    {
        $this->MainModel = new Main();
        $this->data = $this->MainModel->DefaultVariable();

        $session = session();
        $this->MainModel->CheckUser($session->get());
        $data['session'] = $session->get();
        $data['GetDomainID'] = $this->MainModel->GetWebsiteDomainID($data['session']['domainid']);

    }

    public function b2b_packages()
    {
        $data = $this->data;

        $Packages = new Packages();

        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $data['packages'] = $Packages->ListPackagesByID($data['session']['id']);
        } else {
            $data['packages'] = $Packages->ListPackages();
        }

        echo view('header', $data);
        echo view('package/b2b_package', $data);
        echo view('footer', $data);
    }


    public function sale_agent_packages()
    {
        $data = $this->data;

        $Packages = new Packages();
        $data['packages'] = $Packages->ListPackages();

        echo view('header', $data);
        echo view('package/sale_agent_packages', $data);
        echo view('footer', $data);
    }


    public function b2c_package()
    {
        $Packages = new Packages();
        $Crud = new Crud();
        $data = $this->data;

        $data['CheckPackage'] = getSegment(2);
        if ($data['CheckPackage'] == "b2c_package") {
            $table = 'packages."Packages"';
            $where = array("PackageType" => "B2C");
            $GetPackageID = $Crud->SingleRecord($table, $where);
            $data['record_id'] = $GetPackageID['UID'];

            $data['hotelsCount'] = "";
            $data['packageData'] = $Packages->PackageData($data['record_id']);
            $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
            $data['hotels'] = $Packages->ListHotels();
            $data['ziyarat'] = $Packages->ListZiyarats();
            $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
            $Agents = new Agents();
            $data['AgentID'] = $data['packageData'][0]['AgentUID'];
            $data['Agents'] = $Agents->AgentsDropDown($data['packageData'][0]['AgentUID']);
            //echo "<pre>";
            //echo "Agent ID: " .$data['packageData'][0]['AgentUID']. "< br />";
            //print_r($data['Agents']);
            //echo $data['Agents']['html']; exit;
            $aHotelData = array();
            if ($data['hotelsRate']) {
                foreach ($data['hotelsRate'] as $key => $value) {
                    $CityID = $Packages->HotelsData($value['HotelUID']);
                    $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID']. "|" . $CityID['Category'];
                    $aHotelData[$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
                }
            }
            $data['HotelsData'] = $aHotelData;

            $data['TransportTypes'] = $Packages->ListTransport();
            // echo "<pre>"; print_r($data['TransportTypes']);
            $TransportData = array();
            foreach ($data['TransportTypes'] as $thisType) {
                $TransportType = $Crud->LookupOptionsData($thisType['Type']);
                $TransportData[$thisType['UID']] = $TransportType['Name'];
            }
            $data['TransportData'] = $TransportData;

            $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
            $TransportDBData = array();
            foreach ($data['TransportDBData'] as $TD) {
                $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
            }
            $data['TransportDBData'] = $TransportDBData;
            // echo "<pre>"; print_r($data['TransportDBData']); exit;
            // echo "<pre>";
            $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
            // print_r($data['ziyaratRate']); exit;
            $aRows = array();
            $aZiyaratData = array();
            if ($data['ziyaratRate']) {
                foreach ($data['ziyaratRate'] as $key => $value) {
                    $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                    $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                    $aZiyaratData[$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
                    $aRows[$value['RowID']] = $value['RowID'];
                }
            }
            $data['ZiyaratData'] = $aZiyaratData;
            $data['ziyaratCount'] = count($aRows);
            // echo "<pre>"; print_r($data['ZiyaratData']); exit;
            $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
            $aServiceData = array();
            if ($data['ServiceRate']) {
                foreach ($data['ServiceRate'] as $key => $value) {
                    $aServiceData[$value['ServiceUID']] = $value['Rate'];
                }
            }
            $data['ServiceData'] = $aServiceData;
            // echo "<pre>"; print_r($aServiceData);

            $Crud = new Crud();
            $data['RoomTypes'] = $Crud->LookupOptions("room_types");
            $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
            // print_r($data['ExtraServices']); exit;
            $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
            //print_r($data); exit;


            echo view('header', $data);
            echo view('package/b2c_package', $data);
            echo view('footer', $data);
        }
    }

    public function un_assign_package(){

         $data = $this->data;

        $Packages = new Packages();

        $data['packages'] = $Packages->ListUnAssignPackages();


        echo view('header', $data);
        echo view('package/un_assign_package', $data);
        echo view('footer', $data);
    }

    public function b2b_external_package()
    {
        $data = $this->data;

        $Packages = new Packages();
        $data['packages'] = $Packages->ListPackagesForExternalAgents();

        echo view('header', $data);
        echo view('package/b2b_external_package', $data);
        echo view('footer', $data);
    }


    public function new_package()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();


        $Packages = new Packages();
        $Subagents = new Agents();
        $data['hotels'] = $Packages->ListHotels();
        $data['ziarat'] = $Packages->ListZiyarats();
        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportTypes'] = $Packages->ListTransport();


        $data['SubAgents'] = $Subagents->ListSubAgentss($data['session']['id']);
//        print_r($data['SubAgents']);

        $Agents = new Agents();
        $data['Agents'] = $Agents->AgentsDropDown();

//        print_r($data['Agents']);


        // echo "<pre>"; print_r($data['ExtraServices']); exit;
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($TransportData); exit;

        echo view('header', $data);
        echo view('package/new_package', $data);
        echo view('footer', $data);
    }

    public function update_package()
    {
        $data = $this->data;
        $AgentLogged = $data['AgentLogged'];
        $data['record_id'] = getSegment(3);

        $Packages = new Packages();
        $AgentsModel = new Agents();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);

        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
        $Agents = new Agents();
        $data['AgentID'] = $data['packageData'][0]['AgentUID'];

        $data['Agents'] = $Agents->AgentsDropDown($data['packageData'][0]['AgentUID']);
        //echo "<pre>"; echo "Agent ID: " .$data['packageData'][0]['AgentUID']. "< br />";
        //print_r($data['Agents']); echo $data['Agents']['html']; exit;
        $aHotelData = array();
        if ($data['hotelsRate']) {
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID']. "|" . $CityID['Category'];
                $aHotelData[$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsData'] = $aHotelData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $TransportDBData = array();
        foreach ($data['TransportDBData'] as $TD) {
            $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
        }
        $data['TransportDBData'] = $TransportDBData;
        // echo "<pre>"; print_r($data['TransportDBData']); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']); exit;
        $aRows = array();
        $aZiyaratData = array();
        if ($data['ziyaratRate']) {
            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aZiyaratData[$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
                $aRows[$value['RowID']] = $value['RowID'];
            }
        }
        $data['ZiyaratData'] = $aZiyaratData;
        $data['ziyaratCount'] = count($aRows);
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        $aServiceData = array();
        if ($data['ServiceRate']) {
            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($aServiceData);

        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        // print_r($data['ExtraServices']); exit;
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        if ($AgentLogged) {
            $data['PackageTransportSectors'] = $Packages->GetTransportSectorsByPackageID($data['record_id']);
        }

        //print_r($data['PackageTransportSectors']); exit;


        echo view('header', $data);
        echo view('package/update_package', $data);
        echo view('footer', $data);
    }

    public function new_package_for_external_agent()
    {
        $data = $this->data;

        $session = session();
        $data['session'] = $session->get();


        $Packages = new Packages();
        $Subagents = new Agents();
        $data['hotels'] = $Packages->ListHotels();
        $data['ziarat'] = $Packages->ListZiyarats();
        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        $data['TransportTypes'] = $Packages->ListTransport();


        $data['SubAgents'] = $Subagents->ListSubAgentss($data['session']['id']);
//        print_r($data['SubAgents']);

        $Agents = new Agents();
        $data['Agents'] = $Agents->AgentsDropDown();

//        print_r($data['Agents']);


        // echo "<pre>"; print_r($data['ExtraServices']); exit;
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;
        // echo "<pre>"; print_r($TransportData); exit;

        echo view('header', $data);
        echo view('package/new_package_for_external_agent', $data);
        echo view('footer', $data);
    }

    public function edit_package_for_external_agent()
    {
        $data = $this->data;
        $data['record_id'] = getSegment(3);

        $Packages = new Packages();
        $Crud = new Crud();
        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
        $Agents = new Agents();
        $data['AgentID'] = $data['packageData'][0]['AgentUID'];
        $data['Agents'] = $Agents->AgentsDropDown($data['packageData'][0]['AgentUID']);
        //echo "<pre>"; echo "Agent ID: " .$data['packageData'][0]['AgentUID']. "< br />";
        //print_r($data['Agents']); echo $data['Agents']['html']; exit;
        $aHotelData = array();
        if ($data['hotelsRate']) {
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID']. "|" . $CityID['Category'];
                $aHotelData[$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsData'] = $aHotelData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $TransportDBData = array();
        foreach ($data['TransportDBData'] as $TD) {
            $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
        }
        $data['TransportDBData'] = $TransportDBData;
        // echo "<pre>"; print_r($data['TransportDBData']); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']); exit;
        $aRows = array();
        $aZiyaratData = array();
        if ($data['ziyaratRate']) {
            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aZiyaratData[$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
                $aRows[$value['RowID']] = $value['RowID'];
            }
        }
        $data['ZiyaratData'] = $aZiyaratData;
        $data['ziyaratCount'] = count($aRows);
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        $aServiceData = array();
        if ($data['ServiceRate']) {
            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($aServiceData);

        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        // print_r($data['ExtraServices']); exit;
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        //print_r($data); exit;


        echo view('header', $data);
        echo view('package/edit_package_for_external_agent', $data);
        echo view('footer', $data);
    }


    public function b2b_general_package()
    {
        $Packages = new Packages();
        $Crud = new Crud();
        $data = $this->data;

        $data['CheckPackage'] = getSegment(2);
        if ($data['CheckPackage'] == "b2b_general_package") {
            $table = 'packages."Packages"';
            $where = array("PackageType" => "B2B_General");
            $GetPackageID = $Crud->SingleRecord($table, $where);
            $data['record_id'] = $GetPackageID['UID'];

            $data['hotelsCount'] = "";
            $data['packageData'] = $Packages->PackageData($data['record_id']);
            $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
            $data['hotels'] = $Packages->ListHotels();
            $data['ziyarat'] = $Packages->ListZiyarats();
            $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
            $Agents = new Agents();
            $data['AgentID'] = $data['packageData'][0]['AgentUID'];
            $data['Agents'] = $Agents->AgentsDropDown($data['packageData'][0]['AgentUID']);
            //echo "<pre>";
            //echo "Agent ID: " .$data['packageData'][0]['AgentUID']. "< br />";
            //print_r($data['Agents']);
            //echo $data['Agents']['html']; exit;
            $aHotelData = array();
            if ($data['hotelsRate']) {
                foreach ($data['hotelsRate'] as $key => $value) {
                    $CityID = $Packages->HotelsData($value['HotelUID']);
                    $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID']. "|" . $CityID['Category'];
                    $aHotelData[$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
                }
            }
            $data['HotelsData'] = $aHotelData;

            $data['TransportTypes'] = $Packages->ListTransport();
            // echo "<pre>"; print_r($data['TransportTypes']);
            $TransportData = array();
            foreach ($data['TransportTypes'] as $thisType) {
                $TransportType = $Crud->LookupOptionsData($thisType['Type']);
                $TransportData[$thisType['UID']] = $TransportType['Name'];
            }
            $data['TransportData'] = $TransportData;

            $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
            $TransportDBData = array();
            foreach ($data['TransportDBData'] as $TD) {
                $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
            }
            $data['TransportDBData'] = $TransportDBData;
            // echo "<pre>"; print_r($data['TransportDBData']); exit;
            // echo "<pre>";
            $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
            // print_r($data['ziyaratRate']); exit;
            $aRows = array();
            $aZiyaratData = array();
            if ($data['ziyaratRate']) {
                foreach ($data['ziyaratRate'] as $key => $value) {
                    $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                    $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                    $aZiyaratData[$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
                    $aRows[$value['RowID']] = $value['RowID'];
                }
            }
            $data['ZiyaratData'] = $aZiyaratData;
            $data['ziyaratCount'] = count($aRows);
            // echo "<pre>"; print_r($data['ZiyaratData']); exit;
            $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
            $aServiceData = array();
            if ($data['ServiceRate']) {
                foreach ($data['ServiceRate'] as $key => $value) {
                    $aServiceData[$value['ServiceUID']] = $value['Rate'];
                }
            }
            $data['ServiceData'] = $aServiceData;
            // echo "<pre>"; print_r($aServiceData);

            $Crud = new Crud();
            $data['RoomTypes'] = $Crud->LookupOptions("room_types");
            $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
            // print_r($data['ExtraServices']); exit;
            $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
            //print_r($data); exit;


            echo view('header', $data);
            echo view('package/b2b_general_package', $data);
            echo view('footer', $data);
        }
    }

    public function agent_view_package()
    {
        $Packages = new Packages();
        $Crud = new Crud();
        $data = $this->data;
        $session = session();
        $session = $session->get();
        $data['CheckPackage'] = getSegment(2);
        $table = 'packages."Packages"';
        $where = array("AgentUID" => $session['id']);
        $GetPackageID = $Crud->SingleRecord($table, $where);
        $data['record_id'] = $GetPackageID['UID'];

        $data['hotelsCount'] = "";
        $data['packageData'] = $Packages->PackageData($data['record_id']);
        $data['Cities'] = Cities($data['packageData'][0]['CountryCode']);
        $data['hotels'] = $Packages->ListHotels();
        $data['ziyarat'] = $Packages->ListZiyarats();
        $data['hotelsRate'] = $Packages->GetHotelsRateByPackageID($data['record_id']);
        $Agents = new Agents();
        $data['AgentID'] = $data['packageData'][0]['AgentUID'];
        $data['Agents'] = $Agents->AgentsDropDown($data['packageData'][0]['AgentUID']);
        //echo "<pre>";
        //echo "Agent ID: " .$data['packageData'][0]['AgentUID']. "< br />";
        //print_r($data['Agents']);
        //echo $data['Agents']['html']; exit;
        $aHotelData = array();
        if ($data['hotelsRate']) {
            foreach ($data['hotelsRate'] as $key => $value) {
                $CityID = $Packages->HotelsData($value['HotelUID']);
                $sHotelKey = $value['HotelUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aHotelData[$sHotelKey][$value['RoomTypeUID']] = $value['Rate'];
            }
        }
        $data['HotelsData'] = $aHotelData;

        $data['TransportTypes'] = $Packages->ListTransport();
        // echo "<pre>"; print_r($data['TransportTypes']);
        $TransportData = array();
        foreach ($data['TransportTypes'] as $thisType) {
            $TransportType = $Crud->LookupOptionsData($thisType['Type']);
            $TransportData[$thisType['UID']] = $TransportType['Name'];
        }
        $data['TransportData'] = $TransportData;

        $data['TransportDBData'] = $Packages->ListTransportData($data['record_id']);
        $TransportDBData = array();
        foreach ($data['TransportDBData'] as $TD) {
            $TransportDBData[$TD['TransportTypeUID'] . "_" . $TD['Routes'] . "_" . $TD['RowID']] = $TD['Rate'];
        }
        $data['TransportDBData'] = $TransportDBData;
        // echo "<pre>"; print_r($data['TransportDBData']); exit;
        // echo "<pre>";
        $data['ziyaratRate'] = $Packages->GetZiyaratRateByPackageID($data['record_id']);
        // print_r($data['ziyaratRate']); exit;
        $aRows = array();
        $aZiyaratData = array();
        if ($data['ziyaratRate']) {
            foreach ($data['ziyaratRate'] as $key => $value) {
                $CityID = $Packages->ZiyaratsData($value['ZiyaratsUID']);
                $sHotelKey = $value['ZiyaratsUID'] . "|" . $CityID['CityID'] . "|" . $value['RowID'];
                $aZiyaratData[$sHotelKey][$value['TransportTypeUID']] = $value['Rate'];
                $aRows[$value['RowID']] = $value['RowID'];
            }
        }
        $data['ZiyaratData'] = $aZiyaratData;
        $data['ziyaratCount'] = count($aRows);
        // echo "<pre>"; print_r($data['ZiyaratData']); exit;
        $data['ServiceRate'] = $Packages->GetServiceRateByPackageID($data['record_id']);
        $aServiceData = array();
        if ($data['ServiceRate']) {
            foreach ($data['ServiceRate'] as $key => $value) {
                $aServiceData[$value['ServiceUID']] = $value['Rate'];
            }
        }
        $data['ServiceData'] = $aServiceData;
        // echo "<pre>"; print_r($aServiceData);

        $Crud = new Crud();
        $data['RoomTypes'] = $Crud->LookupOptions("room_types");
        $data['ExtraServices'] = $Crud->LookupOptions("extra_services");
        // print_r($data['ExtraServices']); exit;
        $data['TransportSectors'] = $Crud->LookupOptions("transport_sectors");
        //print_r($data); exit;


        echo view('header', $data);
        echo view('package/agent_view_package', $data);
        echo view('footer', $data);

    }

    public function transport()
    {
        $data = $this->data;

        $Transport = new Packages();
        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $data['records'] = $Transport->ListTransportsByDomainID($data['GetDomainID']);
        } else {
            $data['records'] = $Transport->ListTransport();

        }

        echo view('header', $data);
        echo view('package/transport/index', $data);
        echo view('footer', $data);

    }

    public function hotel()
    {
        $data = $this->data;

        $Hotels = new Packages();
        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $data['records'] = $Hotels->ListHotelByDomainID($data['GetDomainID']);
        } else {
            $data['records'] = $Hotels->ListHotels();

        }
        echo view('header', $data);
        echo view('package/hotel/index', $data);
        echo view('footer', $data);
    }

    public function ziyarat()
    {
        $data = $this->data;

        $Packages = new Packages();
        if ($data['session']['account_type'] == 'agent' || $data['session']['account_type'] == "external_agent") {
            $data['ziyarats'] = $Packages->ListZiyaratsByDomainID($data['GetDomainID']);
        } else {
            $data['ziyarats'] = $Packages->ListZiyarats();

        }


        echo view('header', $data);
        echo view('package/ziyarat/index', $data);
        echo view('footer', $data);
    }

    public function new_ziyarat()
    {
        $data = $this->data;
        $ID = getSegment(3);
        $Packages = new Packages();
//            print_r($ID);
        $data['ziyarats_data'] = $Packages->ZiyaratsData($ID);
//        print_r($data['ziyarats_data']);
        $data['ziyarats_meta_data'] = $Packages->ZiyaratsMetaData($ID);


        echo view('header', $data);
        echo view('package/ziyarat/new_ziyarat', $data);
        echo view('footer', $data);
    }


}
