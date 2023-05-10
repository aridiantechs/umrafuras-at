<?php

use App\Models\Crud;
use App\Models\Pilgrims;
use App\Models\Voucher;

$Crud = new Crud();
$VoucherPilgrim = new Voucher();


$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];
$voucherid = $records['voucher_id'];
$reference_id = $PStatus[2];

$RequestedStatus = $PStatus[1];

$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaData($recordid);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec) {
    $finalMeta[$rec['Option']] = $rec['Value'];
}

$Voucher_pilgrim = $VoucherPilgrim->AllowVoucherListPilgrimStatus($voucherid, $RequestedStatus, $reference_id);
$voucher_data = $VoucherPilgrim->VoucherDataByID($voucherid);

$VoucherData = $VoucherPilgrim->VoucherDataDetails($reference_id);
if (isset($VoucherData)) {
    $arrival = $VoucherData['CheckIn'];
    $return = $VoucherData['CheckOut'];
} else {
    $arrival = $voucher_data['ArrivalDate'];
    $return = $voucher_data['ReturnDate'];
}
$Hotels = $VoucherPilgrim->GetPackageHotel($voucherid);

$inputs = array();
$inputs['allow-htl-mecca-room-no'] = array("type" => "text", 'desc' => ' Room Number');
$inputs['allow-htl-mecca-no-of-bed'] = array("type" => "number", 'desc' => ' Actual No Of Bed (Room)');
$inputs['allow-htl-mecca-no-of-bed-voucher'] = array("type" => "number", 'desc' => 'Actual No Of Bed (Voucher)');

$inputs['allow-htl-mecca-in-date'] = array("type" => "date", 'desc' => ' Check In Date');
$inputs['allow-htl-mecca-actual-arrival-time'] = array("type" => "time", 'desc' => ' Actual Arrival Time');
$inputs['allow-htl-mecca-out-date'] = array("type" => "date", 'desc' => ' Check Out Date');
echo '<input type="hidden" name="pilgrim_meta[RequestedStatus]" id="RequestedStatus" value="' . $RequestedStatus . '">';
echo '<input type="hidden" id="user-id" name="pilgrim-meta[allow-htl-mecca-user-id]" value=' . $session['id'] . '>';
echo '<input type="hidden" id="requested-status" name="pilgrim_meta[' . $RequestedStatus . '-status]" value = 1>';

/** Code Setup Start By Jawad */
$RoomTypeData = $Crud->LookupOptionsData( $VoucherData['RoomType'] );
$RoomType = ( ( isset($RoomTypeData['Name']) && $RoomTypeData['Name'] != '' )? trim($RoomTypeData['Name']) : '' );
/** Code Setup Ends By Jawad */


$selects = array();
//$selects['allow-htl-mecca-status'] = array('desc' => ' Status');
$selects['allow-htl-mecca-brn-no'] = array('desc' => ' BRN no/Cash');

foreach ($selects as $key => $name) {
    echo '
          
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>
                 <select class="form-control validate[required]" id="' . $key . '"  name="pilgrim_meta[' . $key . ']">
                 <option value="">Kindly Select BRN Code</option>
                 ' . GetBrnList('html', 'hotel', $finalMeta[$key]) . '
          </select>
         </div>
        </div>';
}

$Hotelselect = array();
$Hotelselect['allow-htl-mecca-package-Hotel'] = array('desc' => ' Package Hotel');
$Hotelselect['allow-htl-mecca-actual-Hotel'] = array('desc' => ' Actual Hotel');
$Hotelselect['allow-htl-mecca-accommodation'] = array('desc' => ' Accommodation');
$Hotelselect['allow-htl-mecca-origin'] = array('desc' => ' Origin');


foreach ($Hotelselect as $key => $name) {
    echo '         
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="' . $name['desc'] . '">' . $name['desc'] . '</label><br>';
    if ($key == 'allow-htl-mecca-package-Hotel') {
        echo '<select class="form-control ' . ((count($Hotels) > 0) ? 'validate[required]' : '') . '" id="PackageHotel"  name="pilgrim_meta[' . $key . ']">      
         <option="">Kindly Select Hotel</option>';
        foreach ($Hotels as $hotel) {
            $selected = (($VoucherData['Hotel'] == $hotel['HotelUID']) ? 'selected' : '');
            echo ' <option value="' . $hotel['HotelUID'] . '"' . $selected . '>' . $hotel['HotelCategoryName'] . ' - ' . $hotel['HotelName'] . '</option>';
        }
        echo '</select>';
    }
    if ($key == 'allow-htl-mecca-origin') {
        {
            echo '<select class="form-control" id="Origin"  name="pilgrim_meta[' . $key . ']"><option value="">Select Origin</option> ';
            echo ' <option value="allow-htl-medina-origin">Medina</option>
                 <option value="allow-htl-jeddah-origin">Jeddah</option>
                 <option value="allow-htl-yanbu-origin">Yanbu</option>
        </select>';
        }
    }
    if ($key == 'allow-htl-mecca-accommodation') {
        {
            echo ' <select disabled class="form-control" id="Accommodation"  name="pilgrim_meta[' . $key . ']"><option value="">'.$RoomType.' Select Accommodation</option> ';
            echo ' <option '.( ( $RoomType == 'Quint Bed' || $RoomType == 'Quad Bed' || $RoomType == 'Triple Bed' || $RoomType == 'Double Bed' || $RoomType == 'Single Bed' )? 'selected' : '' ).' value="Room">Room</option>
                    <option '.( ( $RoomType == 'Sharing' )? 'selected' : '' ).' value="Beds">Beds</option>
        </select>
        <input value="'.( ( $RoomType == 'Sharing' )? 'Beds' : 'Room' ).'" type="hidden" id="Accommodation" name="pilgrim_meta[' . $key . ']">';
        }
    }
    if ($key == 'allow-htl-mecca-actual-Hotel') {
        echo '
        <select class="form-control" id="Hotel"  name="pilgrim_meta[' . $key . ']" onchange="GetHotelName(this.value);">
        <option value="0">Same As Package Hotel</option>
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
    if ($key == 'allow-htl-mecca-actual-arrival-time') {
        echo '<input type="' . $name['type'] . '" min="1"  class="form-control validate[required] "  id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '" value=' . date("H:i") . '>';
    } else {
        echo '<input type="' . $name['type'] . '" ' . (($name['type'] == "number") ? "min = 1" : "") . ' class="form-control validate[required] " id="' . $key . '" name="pilgrim_meta[' . $key . ']"
                       placeholder="' . $name['desc'] . '"   ' . (($key == "allow-htl-mecca-in-date") ? "min = $arrival " . "value = " . $arrival . " " . "max = $return" : "") . ' ' . (($key == "allow-htl-mecca-out-date") ? "min = $arrival " . "value = " . $return . " " . "max = $return" : "") . ' value=' . ((isset($finalMeta[$key])) ? $finalMeta[$key] : '') . ' >';
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
    if ($record)
        $table = 'pilgrim."meta"';
    $where = array("PilgrimUID" => $record['PilgrimUID']);
    $Pilgrims = $Crud->ListRecords($table, $where);
    $PilgrimMeta = array();


    foreach ($Pilgrims as $pilgrim) {
        $PilgrimMeta[$pilgrim['Option']] = $pilgrim['Value'];

    }
    $PackageHotelName = $Crud->SingleRecord('packages."Hotels"', array("UID" => $PilgrimMeta['allow-htl-mecca-package-Hotel']));
    $ActualHotelName = $Crud->SingleRecord('packages."Hotels"', array("UID" => $PilgrimMeta['allow-htl-mecca-package-Hotel']));

    $cnt++;

    $pilgrimHTML .= '
    <tr>        
        <td> ' . $cnt . '</td> 
        <td> <a href="' . $path . 'pilgrim/new/' . $record['PilgrimUID'] . '" target="_blank"> ' . Code('UF/P/', $record['PilgrimUID']) . '</a></td> 
        <td>' . $record['FirstName'] . '</td>
        <td>' . $record['PassportNumber'] . '</td>
        <td>' . ((isset($PackageHotelName['Name'])) ? $PackageHotelName['Name'] : '-') . '</td>
        <td>' . ((isset($ActualHotelName['Name'])) ? $ActualHotelName['Name'] : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-accommodation'])) ? $PilgrimMeta['allow-htl-mecca-accommodation'] : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-actual-arrival-time'])) ? $PilgrimMeta['allow-htl-mecca-actual-arrival-time'] : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-room-no'])) ? $PilgrimMeta['allow-htl-mecca-room-no'] : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-no-of-bed'])) ? $PilgrimMeta['allow-htl-mecca-no-of-bed'] : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-in-date'])) ? DATEFORMAT($PilgrimMeta['allow-htl-mecca-in-date']) : '-') . '</td>
        <td>' . ((isset($PilgrimMeta['allow-htl-mecca-out-date'])) ? DATEFORMAT($PilgrimMeta['allow-htl-mecca-out-date']) : '-') . '</td>
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