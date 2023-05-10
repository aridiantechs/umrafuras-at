<?php
use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Voucher;
$Crud = new Crud();

$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];
$voucherid = $records['voucher_id'];
$reference_id = $PStatus[2];

$RequestedStatus = $PStatus[1];

$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaDataByReferenceID($reference_id);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec)
{
    $finalMeta[$rec['Option']] = $rec['Value'];
}

//print_r($finalMeta);
$VoucherPilgrim = new Voucher();
//$Voucher_pilgrim = $VoucherPilgrim->VoucherListPilgrimStatus($voucherid, $RequestedStatus);
$Voucher_pilgrim = $VoucherPilgrim->VoucherListPilgrimStatusActual($voucherid, $RequestedStatus,$reference_id);
$Hotels = $VoucherPilgrim->GetPackageHotel($voucherid);


$inputs = array();
$inputs['check-out-jeddah-time'] = array("type"=>"time", 'desc'=>'Hotel Time');
$inputs['check-out-jeddah-driver-contact-number'] = array("type"=>"number", 'desc'=>'Driver Contact Number','value'=>$finalMeta['allow-tpt-jeddah-driver-contact-number']);
$inputs['check-out-jeddah-vehicle-number'] = array("type"=>"text", 'desc'=>'Vehicle Number','value'=>$finalMeta['allow-tpt-jeddah-vehicle-number']);
$inputs['check-out-jeddah-driver-name'] = array("type"=>"text", 'desc'=>'Driver Name','value'=> $finalMeta['allow-tpt-jeddah-driver-name']);
$inputs['check-out-jeddah-no-of-seats'] = array("type"=>"number", 'desc'=>'No Of Seats ','value'=>$finalMeta['allow-tpt-jeddah-no-of-seats']);
echo '<input type="hidden" id="user_id" name="pilgrim_meta[check-out-jeddah-user-id]" value=' .$session['id'] . '>';
echo '<input type="hidden" id="requested_status" name="pilgrim_meta[' .$RequestedStatus . '-status]" value = 1 >';


$inputs['check-out-jeddah-check-out-date'] = array("type" => "date", 'desc' => 'Check Out Date');
$inputs['check-out-jeddah-check-out-time'] = array("type" => "time", 'desc' => 'Check Out Time');
$inputs['check-out-jeddah-departure-time'] = array("type" => "time", 'desc' => 'Departure Time');
$inputs['check-out-jeddah-transport-destination'] = array("type" => "text", 'desc' => 'Transport Destination');
$inputs['check-out-jeddah-room-no'] = array("type" => "text", 'desc' => 'Room No');
$inputs['check-out-jeddah-pickup-point'] = array("type" => "text", 'desc' => 'Pickup Point');



$selects = array();
//$selects['check_out_jeddah_status'] = array('desc' => 'Status');
$selects['check-out-jeddah-brn-no'] = array('desc' => ' BRN No/Cash');
$selects['check-out-jeddah-actual-hotel'] = array('desc' => ' Actual Hotel', 'selected' => 'check-out-jeddah-actual-hotel');
foreach ($selects as $key => $name) {
    if ($key == 'check-out-jeddah-brn-no') {
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
    } else if ($key == 'check-out-jeddah-actual-hotel') {
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
                <label for="'.$name['desc'].'">'.$name['desc'].'</label><br>';
    echo '<input type="'.$name['type'].'" class="form-control " id="'.$key.'" name="pilgrim_meta['.$key.']"
                       placeholder="'.$name['desc'].'" value='.( (isset($name['value'])) ? $name['value'] : '' ).'>';
    echo '
            </div>
        </div>';
}
//foreach ($selects as $key => $name) {
//    echo '
//        <div class="col-md-3">
//            <div class="form-group mb-4">
//                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
//                 <select class="form-control validate[required]" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
//                  <option value="">Please Select</option>
//                  <option value="Yes">Yes</option>
//                  <option value="No">No</option>
//          </select>
//         </div>
//        </div>';
//}
echo ' <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="Arrival Transport Company">Transport Company</label><br> 
                 <select class="form-control validate[required]" id="check-out-jeddah-transport-company"  name="pilgrim_meta[check-out-jeddah-transport-company]">
                  <option value="">Please Select</option>';
$data['LookupsOptions'] = $Crud->LookupOptions('transportation_company');
foreach ($data['LookupsOptions'] as $options) {
    $selected =(($options['UID'] == $finalMeta['allow-tpt-jeddah-transport-company']) ? 'selected' : '');

    echo '<option value="' . $options['UID'] . '"'.$selected.'>' . $options['Name'] . '</option>';
}
echo'</select> 
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
                                <th>Hotel Time</th>
                                <th>Driver Contact Number</th>
                                <th>Vehicle Number</th>
                                <th>Driver Name</th>
                                <th>No of Seats</th>
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
                                    <td>' . ((isset($PilgrimMeta['check-out-jeddah-time'])) ? TIMEFORMAT($PilgrimMeta['check-out-jeddah-time']) : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['check-out-jeddah-driver-contact-number'])) ? TIMEFORMAT($PilgrimMeta['check-out-jeddah-driver-contact-number']) : '-') . '</td>
                                     <td>' . ((isset($PilgrimMeta['check-out-jeddah-vehicle-number'])) ? $PilgrimMeta['check-out-jeddah-vehicle-number'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['check-out-jeddah-driver-name'])) ? $PilgrimMeta['check-out-jeddah-driver-name'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['check-out-jeddah-no-of-seats'])) ? $PilgrimMeta['check-out-jeddah-no-of-seats'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimMeta['check-out-jeddah-transport-company'])) ? OptionName($PilgrimMeta['check-out-jeddah-transport-company']) : '-') . '</td>
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

