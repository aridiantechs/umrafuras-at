<?php

use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Voucher;

$Crud = new Crud();


$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];
$ActualParam = $records['ActualParam'];

$voucherid = $records['voucher_id'];
$reference_id = $PStatus[2];

$RequestedStatus = $PStatus[1];
$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaDataByReferenceID($reference_id);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec) {
    $finalMeta[$rec['Option']] = $rec['Value'];
}


$VoucherPilgrim = new Voucher();
$Voucher_pilgrim = $VoucherPilgrim->VoucherListPilgrimStatusActual($voucherid, $RequestedStatus,$reference_id);
$voucher_data = $VoucherPilgrim->VoucherDataByID($voucherid);

$VoucherData = $VoucherPilgrim->VoucherDataDetails($reference_id);
if (isset($ActualParam)) {
    $arrival = $VoucherData['CheckIn'];
    $return = $VoucherData['CheckOut'];
} else {
    $arrival = $voucher_data['ArrivalDate'];
    $return = $voucher_data['ReturnDate'];
}

$Hotels = $VoucherPilgrim->GetPackageHotel($voucherid);


$inputs = array();
$inputs['check-in-mecca-actual-arrival-time'] = array("type" => "time", 'desc' => ' Actual Arrival Time','value'=>$finalMeta['allow-htl-mecca-actual-arrival-time']);
$inputs['check-in-mecca-room-no'] = array("type" => "text", 'desc' => ' Room Number','value'=>$finalMeta['allow-htl-mecca-room-no']);
$inputs['check-in-mecca-no-of-bed'] = array("type" => "number", 'desc' => ' Actual No Of Bed (Room)','value'=>$finalMeta['allow-htl-mecca-no-of-bed']);
$inputs['check-in-mecca-no-of-bed-voucher'] = array("type" => "number", 'desc' => 'Actual No Of Bed (Voucher)','value'=>$finalMeta['allow-htl-mecca-no-of-bed-voucher']);
$inputs['check-in-mecca-in-date'] = array("type" => "date", 'desc' => ' Check In Date','value'=>$finalMeta['allow-htl-mecca-in-date']);
$inputs['check-in-mecca-out-date'] = array("type" => "date", 'desc' => ' Check Out Date','value'=>$finalMeta['allow-htl-mecca-out-date']);

echo '<input type="hidden" id="user-id" name="pilgrim-meta[check-in-mecca-user-id]" value=' . $session['id'] . '>';
echo '<input type="hidden" id="requested-status" name="pilgrim_meta[' . $RequestedStatus . '-status]" value = 1 >';


$selects = array();
//$selects['check-in-mecca-status'] = array('desc' => ' Status');
$selects['check-in-mecca-brn-no'] = array('desc' => ' BRN no/Cash');

foreach ($selects as $key => $name) {
    echo '
          
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
                 <select class="form-control validate[required]" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
                 <option value="">Kindly Select BRN Code</option>
                 ' . GetBrnList('html', 'hotel', $finalMeta['allow-htl-mecca-brn-no']) . '
          </select>
         </div>
        </div>';
}

$Hotelselect = array();
$Hotelselect['check-in-mecca-package-Hotel'] = array('desc' => ' Package Hotel','selected'=>'allow-htl-mecca-package-Hotel');
$Hotelselect['check-in-mecca-actual-Hotel'] = array('desc' => ' Actual Hotel','selected'=>'allow-htl-mecca-actual-Hotel');
$Hotelselect['check-in-mecca-accommodation'] = array('desc' => ' Accommodation','selected'=>'allow-htl-mecca-accommodation');


foreach ($Hotelselect as $key => $name) {
    echo '         
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>';
    if($key == 'check-in-mecca-package-Hotel')
    {echo '<select class="form-control ' . ((count($Hotels) > 0) ? 'validate[required]' : '') . '" id="PackageHotel"  name="pilgrim_meta[' . $key . ']">   <option value="">Kindly Select Hotel</option>';
        foreach ($Hotels as $hotel)
            $selected = (($VoucherData['Hotel'] == $hotel['HotelUID']) ? 'selected' : '');
        { echo ' <option value="'.$hotel['HotelUID'].'"'.$selected .'>' . $hotel['HotelCategoryName'] . ' - '.$hotel['HotelName'].'</option>';}
        echo'</select>';

    } if($key == 'check-in-mecca-accommodation')
    {
        {echo ' <select class="form-control" id="Accommodation"  name="pilgrim_meta[' . $key . ']"><option value="">Select Accommodation</option> ';
            echo ' <option value="Room">Room</option>
                    <option value="Beds">Beds</option>
        </select>';
        }
    }
    if($key == 'check-in-mecca-actual-Hotel')
    {echo ' <select class="form-control" id="Hotel"  name="pilgrim_meta[' . $key . ']" onchange="GetHotelName(this.value);"><option value="">Package Hotel</option> ';
        echo ' <option value="0">Same As Package Hotel</option>
        </select>';
    }

    echo '
         </div>
        </div>';
}



foreach ($inputs as $key => $name) {
    echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>';
    if ($key == 'check-in-mecca-actual-arrival-time') {
        echo '<input type="' . $name['type'] . '" min="1"  class="form-control validate[required] "  id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '" value=' . date("H:i") . '>';
    } else {
        echo '<input type="' . $name['type'] . '" '.(($name['type'] == "number") ? "min = 1" :  "" ).' class="form-control validate[required] " id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '"   '.(($key == "check-in-mecca-in-date") ? "min = $arrival "."value = ".$arrival." "."max = $return" :  "" ).' '.(($key == "check-in-mecca-out-date") ? "min = $arrival "."value = ".$return." "."max = $return" :  "" ).' value=' . ((isset($name['value'])) ? $name['value'] : '') . ' >';
    }

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

$pilgrimHTML = '
                                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing" id="PilgrmStatusGrid">
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
                                <th>Package Hotel</th>
                                <th>Actual Hotel</th>
                                <th>Accommodation</th>
                                <th>Actual Arrival Time</th>
                                 <th>Room Number</th>
                                 <th>Actual no of bed</th>
                                 <th>Check in Date</th>
                                 <th>Check out Date</th>
                                </tr>
                                </thead>
                                <tbody>';
$cnt = 0;
$session = session();
$PilgrimsGridIDs = array();
foreach ($Voucher_pilgrim as $record) {
    if($record)
        $table = 'pilgrim."meta"';
    $where = array("PilgrimUID" => $record['PilgrimUID']);
    $Pilgrims = $Crud->ListRecords($table, $where);
    $PilgrimMeta = array();

    foreach ($Pilgrims as $pilgrim) {
        $PilgrimMeta[$pilgrim['Option']] = $pilgrim['Value'];
    }
    $PackageHotelName = $Crud->SingleRecord('packages."Hotels"', array("UID" =>$PilgrimMeta['check-in-mecca-package-Hotel']));
    $ActualHotelName = $Crud->SingleRecord('packages."Hotels"', array("UID" =>$PilgrimMeta['check-in-mecca-package-Hotel']));


    $cnt++;
    $pilgrimHTML .= '<tr>        
                                <td> ' . $cnt . '</td> 
                                <td> <a href="' . $path . 'pilgrim/new/' . $record['PilgrimUID'] . '" target="_blank"> ' . Code('UF/P/', $record['PilgrimUID']) . '</a></td> 
                                <td>' . $record['FirstName'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . ((isset($PackageHotelName['Name'])) ? $PackageHotelName['Name'] : '-') . '</td>
                                 <td>' . ((isset($ActualHotelName['Name'])) ? $ActualHotelName['Name'] : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-accommodation'])) ? $PilgrimMeta['check-in-mecca-accommodation'] : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-actual-arrival-time'])) ? $PilgrimMeta['check-in-mecca-actual-arrival-time'] : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-room-no'])) ? $PilgrimMeta['check-in-mecca-room-no'] : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-no-of-bed'])) ? $PilgrimMeta['check-in-mecca-no-of-bed'] : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-in-date'])) ? DATEFORMAT($PilgrimMeta['check-in-mecca-in-date']) : '-') . '</td>
                                <td>' . ((isset($PilgrimMeta['check-in-mecca-out-date'])) ? DATEFORMAT($PilgrimMeta['check-in-mecca-out-date']) : '-') . '</td>
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


<script>

    function GetHotelName(hotel) {
        if (hotel == 'Other') {
            LoadModal('pilgrim/self_hotel_main_form_for_activity', 258342, 'modal-lg', '_self_other_hotel');
        }
    }

    LoadSelfHotelByCites('258342');

    function LoadSelfHotelByCites(city) {
        hotels = AjaxResponse("html/GetSelfHotelDropdownByCityForActivity", "city=" + city);
        $("#Hotel").html(hotels.html);
    }
</script>