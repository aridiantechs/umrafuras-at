<?php

use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Voucher;

$Crud = new Crud();

$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];
$voucherid = $records['voucher_id'];

$RequestedStatus = $PStatus[1];
$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaData($recordid);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec) {
    $finalMeta[$rec['Option']] = $rec['Value'];
}

//print_r($finalMeta);
$VoucherPilgrim = new Voucher();
$Voucher_pilgrim = $VoucherPilgrim->VoucherListPilgrimStatus($voucherid, $RequestedStatus);


$inputs = array();
$inputs['allow-tpt-arrival-driver-name'] = array("type" => "text", 'desc' => 'Driver Name');
$inputs['allow-tpt-arrival-driver-number'] = array("type" => "number", 'desc' => 'Driver #');
$inputs['allow-tpt-arrival-vehicle-number'] = array("type" => "text", 'desc' => 'Vehicle #');
$inputs['allow-tpt-arrival-actual-no-of-seats'] = array("type" => "number", 'desc' => 'Actual No Of Seats');
$inputs['allow-tpt-arrival-pickup-location'] = array("type"=>"text", 'desc'=>'Pickup Location');
$inputs['allow-tpt-arrival-pickup-time'] = array("type"=>"time", 'desc'=>'Pickup Time');
$inputs['allow-tpt-arrival-dropoff-location'] = array("type"=>"text", 'desc'=>'Drop off location');
echo '<input type="hidden" id="user_id" name="pilgrim_meta[allow-tpt-arrival-user-id]" value=' . $session['id'] . '>';
echo '<input type="hidden" id="requested_status" name="pilgrim_meta[' . $RequestedStatus . '-status]" value = 1 >';

$selects = array();
$selects['allow-tpt-arrival-brn-no'] = array('desc' => 'BRN no/Cash');

foreach ($selects as $key => $name) {
    echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
                 <select class="form-control validate[required]" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
                 <option value="">Kindly Select BRN Code</option>
                 ' . GetBrnList('html', 'transport', $finalMeta[$key]) . '
          </select>
         </div>
        </div>';
}

foreach ($inputs as $key => $name) {
    echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>';
    echo '<input type="' . $name['type'] . '" class="form-control validate[required]" id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '" value=' . ((isset($finalMeta[$key])) ? $finalMeta[$key] : '') . '>';
    echo '
            </div>
        </div>';
}

echo ' <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="Arrival Transport Company">Transport Company</label><br> 
                 <select class="form-control validate[required]" id="allow_tpt_arrival_transport_company"  name="pilgrim_meta[allow-tpt-arrival-transport-company]">
                  <option value="">Please Select</option>';
$data['LookupsOptions'] = $Crud->LookupOptions('transportation_company');
foreach ($data['LookupsOptions'] as $options) {
    echo '<option value="' . $options['UID'] . '">' . $options['Name'] . '</option>';
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
                                    <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-driver-name'])) ? $PilgrimMeta['allow-tpt-arrival-driver-name'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-driver-number'])) ? $PilgrimMeta['allow-tpt-arrival-driver-number'] : '-') . '</td>
                                     <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-vehicle-number'])) ? $PilgrimMeta['allow-tpt-arrival-vehicle-number'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-actual-no-of-seats'])) ? $PilgrimMeta['allow-tpt-arrival-actual-no-of-seats'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-brn-no'])) ? $PilgrimMeta['allow-tpt-arrival-brn-no'] : '-') . '</td>                                 
                                 <td>' . ((isset($PilgrimMeta['allow-tpt-arrival-transport-company'])) ? OptionName($PilgrimMeta['jeddah-transport-company']) : '-') . '</td>

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