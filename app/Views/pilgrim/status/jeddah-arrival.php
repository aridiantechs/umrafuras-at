<?php

use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Voucher;

$Crud = new Crud();

$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];
$Referenceid = $PStatus[2];
$voucherid = $records['voucher_id'];
$VoucherPilgrim = new Voucher();
$RequestedStatus = $PStatus[1];
$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaDataByReferenceID($Referenceid);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec) {
    $finalMeta[$rec['Option']] = $rec['Value'];
}

//print_r($finalMeta);
$VoucherPilgrim = new Voucher();
$Voucher_pilgrim = $VoucherPilgrim->VoucherListPilgrimStatus($voucherid, $RequestedStatus);
$Hotels = $VoucherPilgrim->GetPackageHotel($voucherid);

$inputs = array();
$inputs['jeddah-arrival-driver-name'] = array("type" => "text", 'desc' => 'Driver Name', 'value' => $finalMeta['allow-tpt-jeddah-driver-name']);
$inputs['jeddah-arrival-driver-number'] = array("type" => "number", 'desc' => 'Driver #', 'value' => $finalMeta['allow-tpt-jeddah-driver-contact-number']);
$inputs['jeddah-arrival-vehicle-number'] = array("type" => "text", 'desc' => 'Vehicle #', 'value' => $finalMeta['allow-tpt-jeddah-vehicle-number']);
$inputs['jeddah-arrival-actual-no-of-seats'] = array("type" => "number", 'desc' => 'Actual No Of Seats', 'value' => $finalMeta['allow-tpt-jeddah-no-of-seats']);

$inputs['jeddah-arrival-check-out-date'] = array("type" => "date", 'desc' => 'Check Out Date');
$inputs['jeddah-arrival-check-out-time'] = array("type" => "time", 'desc' => 'Check Out Time');
$inputs['jeddah-arrival-departure-time'] = array("type" => "time", 'desc' => 'Departure Time');
$inputs['jeddah-arrival-transport-destination'] = array("type" => "text", 'desc' => 'Transport Destination');
$inputs['jeddah-arrival-room-no'] = array("type" => "text", 'desc' => 'Room No');
$inputs['jeddah-arrival-pickup-point'] = array("type" => "text", 'desc' => 'Pickup Point');


echo '<input type="hidden" id="user_id" name="pilgrim_meta[jeddah-arrival-user-id]" value=' . $session['id'] . '>';
echo '<input type="hidden" id="requested_status" name="pilgrim_meta[' . $RequestedStatus . '-status]" value = 1 >';

$selects = array();
//$selects['jeddah_arrival-status'] = array('desc' => 'Status');
$selects['jeddah-arrival-brn-no'] = array('desc' => 'BRN no/Cash');

$selects['jeddah-arrival-actual-hotel'] = array('desc' => ' Actual Hotel', 'selected' => 'jeddah-arrival-actual-hotel');

foreach ($selects as $key => $name) {
    if ($key == 'jeddah-arrival-brn-no') {
        echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
                 <select class="form-control validate[required]" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
                 <option value="">Kindly Select BRN Code</option>
                 ' . GetBrnList('html', 'transport', $finalMeta['allow-tpt-jeddah-brn-no']) . '
          </select>
         </div>
        </div>';
    } else if ($key == 'jeddah-arrival-actual-hotel') {
        echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
                 <select class="form-control ' . ((count($Hotels) > 0) ? 'validate[required]' : '') . '" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
                 <option value="">Kindly Select Hotel</option>';
        foreach ($Hotels as $hotel) {
            echo ' <option value="' . $hotel['HotelUID'] . '"' . $selected . '>' . $hotel['HotelCategoryName'] . ' - ' . $hotel['HotelName'] . '</option>';
        }
        echo '
          </select>
         </div>
        </div>';
    }
}

foreach ($inputs as $key => $name) {
    echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>';
    echo '<input type="' . $name['type'] . '" class="form-control validate[required]" id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '" value=' . ((isset($name['value'])) ? $name['value'] : '') . '>';
    echo '
            </div>
        </div>';
}

echo ' <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="Arrival Transport Company">Transport Company</label><br> 
                 <select class="form-control validate[required]" id="jeddah_arrival_transport_company"  name="pilgrim_meta[jeddah-arrival-transport-company]">
                  <option value="">Please Select</option>';
$data['LookupsOptions'] = $Crud->LookupOptions('transportation_company');
foreach ($data['LookupsOptions'] as $options) {
    $selected = (($options['UID'] == $finalMeta['allow-tpt-jeddah-transport-company']) ? 'selected' : '');
    echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
}
echo '</select> 
         </div>
        </div>';

$pilgrimHTML = '
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing"  id="PilgrmStatusGrid">
              <div id="withoutSpacing" class="no-outer-spacing">
                                <div class="card">
                                <div class="card-header" id="headingOne2">
                                <section class="mb-0 mt-0">
                                <div role="menu" class="" data-toggle="collapse" data-target="#withoutSpacingAccordionOne" aria-expanded="true" aria-controls="withoutSpacingAccordionOne">
                                Pilgrims Grid  <div class="icons"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></div>
                                </div>
                                </section>
                                </div>                              
                                <div id="withoutSpacingAccordionOne" class="collapse show" aria-labelledby="headingOne2" data-parent="#withoutSpacing">
                                <div class="card-body">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive" id="pilgrimgrid">
                        <table class="table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                            <tr>                     
                                <th>#</th>
                                  <th>Pilgrim ID</th>
                                <th>Pilgrim Name</th>
                                <th>Passport No</th>
                                <th>Driver Name</th>
                                <th>Driver Number</th>
                                <th>Vehicle Number</th>
                                <th>Actual No Of Seats</th>
                                <th>Transport Company</th>
                            </tr>
                            </thead>
                            <tbody>';
$cnt = 0;
$session = session();
$PilgrimsGridIDs = array();
foreach ($Voucher_pilgrim as $record) {
    $table = 'pilgrim."meta"';
    $where = array("PilgrimUID" => $record['PilgrimUID']);
    $Pilgrims = $Crud->ListRecords($table, $where);
    $PilgrimMeta = array();

    foreach ($Pilgrims as $pilgrim) {
        $PilgrimMeta[$pilgrim['Option']] = $pilgrim['Value'];
    }
    $cnt++;
    $pilgrimHTML .= ' <tr>        
                                     <td> ' . $cnt . '</td> 
                                    <td> <a href="' . $path . 'pilgrim/new/' . $record['PilgrimUID'] . '" target="_blank"> ' . Code('UF/P/', $record['PilgrimUID']) . '</a></td> 
                                    <td>' . $record['FirstName'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . ((isset($PilgrimMeta['jeddah-arrival-driver-name'])) ? $PilgrimMeta['jeddah-arrival-driver-name'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['jeddah-arrival-driver-number'])) ? $PilgrimMeta['jeddah-arrival-driver-number'] : '-') . '</td>
                                     <td>' . ((isset($PilgrimMeta['jeddah-arrival-vehicle-number'])) ? $PilgrimMeta['jeddah-arrival-vehicle-number'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['jeddah-arrival-actual-no-of-seats'])) ? $PilgrimMeta['jeddah-arrival-actual-no-of-seats'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['jeddah-arrival-brn-no'])) ? $PilgrimMeta['jeddah-arrival-brn-no'] : '-') . '</td>                                 
                                 <td>' . ((isset($PilgrimMeta['jeddah-arrival-transport-company'])) ? OptionName($PilgrimMeta['jeddah-transport-company']) : '-') . '</td>

                                 </tr>';
    $PilgrimsGridIDs[] = $record['PilgrimUID'];

}
$session->set(array("PilgrimsGridIDs" => $PilgrimsGridIDs));

$pilgrimHTML .= '</tbody>
                        </table>
                    </div>
                </div>
            </div>
               </div>
            </div>
            </div>
            </div>
            ';

if ($cnt > 0) {
    echo $pilgrimHTML;
}


?>