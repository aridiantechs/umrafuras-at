<?php

use App\Models\Crud;
use App\Models\Voucher;

$Crud = new Crud();
$VoucherPilgrim = new Voucher();
$page = $ActualParam = $records['ActualParam'];
$requestedView = $records['request_status'];
$voucherid = $records['voucher_id'];
$pilgrims = $records['voucher_pilgrim'];
$reference_id = $records['reference_id'];

$voucher_pilgrims = $VoucherPilgrim->VoucherPilgrimDataByID($voucherid);
$voucher_data = $VoucherPilgrim->VoucherDataByID($voucherid);
$pilgrim_ids = array();
foreach ($voucher_pilgrims as $voucher_pilgrim) {
    $pilgrim_ids[] = $voucher_pilgrim['PilgrimUID'];
}
$vouchers_id = $pilgrim_ids;
$session = session();


//$ArrivedPilgrims = array();
//$PilgrimStatusCheck = $VoucherPilgrim->PilgrimStatusInMeta('arrival-status');
////print_r($PilgrimStatusCheck);
//foreach ($PilgrimStatusCheck as $PilgrimStatus) {
//    $ArrivedPilgrims[] = $PilgrimStatus['PilgrimUID'];
//}
//if ($reference_id > 0) {
//    $AllArrivedPilgrims = $ArrivedPilgrims;
//
//} else {
//    $AllArrivedPilgrims = $vouchers_id;
//}
$AllArrivedPilgrims = $vouchers_id;
//print_r($AllArrivedPilgrims);

/** Code Start By Jawad */
$TotalVoucherActivitiesSelectedPilgrims = $VoucherPilgrim->GetTotalSubmittedVoucherPilgrimsRecord($records['reference_id'],  ['request_status']);
$CheckActivityPilgrimsRecord = $VoucherPilgrim->GetTotalActivitySubmittedPilgrimsRecord($records['voucher_id'], $records['request_status'], $records['reference_id']);
$AccommodationDetailData = $VoucherPilgrim->VoucherDataDetails($records['reference_id']);
$RoomTypeData = $Crud->LookupOptionsData( $AccommodationDetailData['RoomType'] );
$RoomType = ( ( isset($RoomTypeData['Name']) && $RoomTypeData['Name'] != '' )? trim($RoomTypeData['Name']) : '' );
/** Code Ends By Jawad */
?>
<style>
    #pilgrimgrid {
        overflow-x: scroll;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel" style="width: 100%"><span class="float-left">Change Voucher Pilgrim's Status
            to <?= $Statuses[$requestedView] ?> </span> <span
                class="float-right">Voucher Code : <?= $voucher_data['VoucherCode'] ?> </span></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button>
</div>
<form class="validate" method="post" action="#" id="PilgrimStatusForm" name="PilgrimStatusForm">
    <input type="hidden" name="UID" id="UID" value="0">
    <input type="hidden" name="RequestedStatus" id="RequestedStatus" value="<?= $requestedView ?>">
    <input type="hidden" name="VoucherID" id="VoucherID" value="<?= $voucherid ?>">
    <input type="hidden" name="AllowReference" id="AllowReference" value="<?= $reference_id ?>">

    <div class="modal-body">

        <div class="row">
            <div class="col-md-12 mb-3">
                <h6>
                    <span style="float: left;color: #dda420">  Voucher Start Date : <?= DATEFORMAT($voucher_data['ArrivalDate']) ?> </span>
                    <span style="float: right;color: #dda420"> Voucher End Date : <?= DATEFORMAT($voucher_data['ReturnDate']) ?></span>
                </h6>
            </div>
        </div>
        <div class="row">
            <?php
            //            echo $page;
            echo '
                <div class="col-md-12 mb-3">
                    <h6>Kindly fill these fields </h6>
                    <hr>
                </div>';

            echo view("pilgrim/status/" . $requestedView);

            $allowDepended = array();
            $allowDepended['check-in-medina'] = 'allow-htl-medina-status';
            $allowDepended['check-in-mecca'] = 'allow-htl-mecca-status';
            $allowDepended['check-in-jeddah'] = 'allow-htl-jeddah-status';

            $allowDepended['check-out-jeddah'] = 'allow-tpt-jeddah-status';
            $allowDepended['check-out-mecca'] = 'allow-tpt-mecca-status';
            $allowDepended['check-out-medina'] = 'allow-tpt-medina-status';
            $allowDepended['check-out-yanbu'] = 'allow-tpt-yanbu-status';

            $allowDepended['jeddah-arrival'] = 'allow-tpt-jeddah-status';
            $allowDepended['mecca-arrival'] = 'allow-tpt-mecca-status';
            $allowDepended['medina-arrival'] = 'allow-tpt-medina-status';
            $allowDepended['yanbu-arrival'] = 'allow-tpt-yanbu-status';

            $allowDepended['departure-jeddah'] = 'allow-tpt-jeddah-status';
            $allowDepended['departure-mecca'] = 'allow-tpt-mecca-status';
            $allowDepended['departure-medina'] = 'allow-tpt-medina-status';
            $allowDepended['departure-yanbu'] = 'allow-tpt-yanbu-status';

            $AllowPilgrims = $VoucherPilgrim->GetPilgrimAllowList($allowDepended[$requestedView], $reference_id);
            $totalPilgrimcount = 0;
            foreach ($pilgrims as $pilgrim) {
                if ($pilgrim['CurrentStatus'] != $requestedView) {
                    $session = session();
                    $Pilgrimss = $session->get('PilgrimsGridIDs');
                    if (in_array($pilgrim['PilgrimUID'], $Pilgrimss)) {

                    } else {
                        if (trim($ActualParam) == 'actual') {
                            if (in_array($pilgrim['PilgrimUID'], $AllowPilgrims)) {
                                $totalPilgrimcount++;
                            }

                        } else {
                            if (in_array($pilgrim['PilgrimUID'], $AllArrivedPilgrims) && !in_array($pilgrim['PilgrimUID'], $TotalVoucherActivitiesSelectedPilgrims)) {
                                $totalPilgrimcount++;
                            }
                        }

                    }
                }

            }

            $AllHotelActivities = StatusCheckList();
            $HotelActivitiesArray = array();
            $AllowHotel1 = $AllHotelActivities['AllowHotel'];
            $AllowHotel2 = $AllHotelActivities['TotalPAXInSaudia'];
            $HotelActivitiesArray = array_merge($AllowHotel1, $AllowHotel2);
            echo '<input type="hidden" name="ActivityAllowedPilgrims" id="ActivityAllowedPilgrims" value="' . $CheckActivityPilgrimsRecord['ActivityAllowedPax'] . '">
                  <input type="hidden" name="ActivitySubmittedPilgrims" id="ActivitySubmittedPilgrims" value="' . $CheckActivityPilgrimsRecord['ActivitySubmittedPax'] . '">
                  <input type="hidden" name="ActivityAdultsSubmittedPilgrims" id="ActivityAdultsSubmittedPilgrims" value="' . $CheckActivityPilgrimsRecord['ActivityAdultsSubmittedPax'] . '">
                  <input type="hidden" name="TotalNoOfBeds" id="TotalNoOfBeds" value="'  . $CheckActivityPilgrimsRecord['TotalVoucherBeds'] . '">
                  <input type="hidden" name="TotalPilgrims" id="TotalPilgrims" value="'  . count($pilgrims) . '">
                  <input type="hidden" name="ActivityRoomType" id="ActivityRoomType" value="' . $RoomType . '">
                  <input type="hidden" name="ValidateForm" id="ValidateForm" value="1">';
            if (in_array($records['request_status'], $HotelActivitiesArray)) {
                echo '<input type="hidden" name="CheckValidate" id="CheckValidate" value="1">';
            } else {
                echo '<input type="hidden" name="CheckValidate" id="CheckValidate" value="0">';
            }
            ?>
            <div class="col-md-12 mb-3 <?= (($totalPilgrimcount > 0) ? '' : 'd-none') ?>" style="margin-top: 5px;">
                <h6>Select Pilgrims</h6>
                <hr>
            </div>
        </div>
        <div class="row <?= (($totalPilgrimcount > 0) ? '' : 'd-none') ?>"
             style="max-height: 440px;overflow-y: scroll;">
            <div class="col-md-12 mb-3  ">
                <label class="new-control new-checkbox checkbox-primary"
                       style="height: 18px; margin: 0 auto;">
                    <input onchange="CheckPilgrimsCounter();" type="checkbox"
                           class="new-control-input todochkbox"
                           id="todoAll">
                    <span class="new-control-indicator"></span><h6 style="color: #dda420">You can select
                        all <?=(($totalPilgrimcount > 0) ? $totalPilgrimcount : '')?> pilgrims at
                        once</h6>
                </label>
            </div>

            <?php
            $totalPilgrims = 0;
            $session = session();
            $PilgrimsGridIDs = $session->get('PilgrimsGridIDs');
            if (!is_array($PilgrimsGridIDs)) {
                $PilgrimsGridIDs = array();
            }
            foreach ($pilgrims as $pilgrim) {
                if ($pilgrim['CurrentStatus'] != $requestedView) {

                    if (in_array($pilgrim['PilgrimUID'], $PilgrimsGridIDs)) {

                    } else {
                        if (trim($ActualParam) == 'actual') {
                            if (in_array($pilgrim['PilgrimUID'], $AllowPilgrims)) {
                                $totalPilgrims++;
                                $leader = $pilgrim['Leader'];
                                echo '               
                                <div class="col-md-3 mb-3 ' . (($leader == 1) ? 'alert alert-success' : '') . '">           
                                <label class="new-control new-checkbox checkbox-primary">';
                                $checked = (in_array($options['UID'], $vouchers_id)) ? 'checked' : '';
                                if ($leader == 1) {
                                    $checked = 'checked';
                                }
                                $PilgrimTypeClass = (($pilgrim['PilgrimAgeYears'] < 2) ? 'infant' : (($pilgrim['PilgrimAgeYears'] >= 2 && $pilgrim['PilgrimAgeYears'] <= 10) ? 'child' : 'adult'));
                                echo '   
                                <input onchange="CheckPilgrimsCounter( ' . $pilgrim['PilgrimUID'] . ' );" id="VoucherPilgrims-' . $pilgrim['PilgrimUID'] . '" ' . $checked . ' type="checkbox" class="new-control-input todochkbox ' . $PilgrimTypeClass . ' " value="' . $pilgrim['PilgrimUID'] . '" name="VoucherPilgrims[]">
                                <span class="new-control-indicator"></span> ' . $pilgrim['FirstName'] . '              
                                </label><br>       
                                <span class="ml-4">' . $pilgrim['PassportNumber'] . '</span>      <span class="float-right" id="coloredtext">(' . $pilgrim['DOBInYears'] . ' Y )</span>            
                                  <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text" id="btnGroupAddon2">P.#</div>
                                    </div>
                                  <input type="number" class="form-control' . (($leader == 1) ? 'validate[required] ' : '') . '" placeholder="Phone Number" min="1" id="contactnumber" value="' . $pilgrim['Contact_Number'] . '" name="contact_number[' . $requestedView . '][' . $pilgrim['PilgrimUID'] . ']">
                                </div>          
                               </div> ';
                            }
                        } else {

                            if (in_array($pilgrim['PilgrimUID'], $AllArrivedPilgrims) && !in_array($pilgrim['PilgrimUID'], $TotalVoucherActivitiesSelectedPilgrims)) {
                                $totalPilgrims++;
                                $leader = $pilgrim['Leader'];
                                echo '               
                            <div class="col-md-3 mb-3 ' . (($leader == 1) ? 'alert alert-success' : '') . '">           
                            <label class="new-control new-checkbox checkbox-primary">';
                                $checked = (in_array($options['UID'], $vouchers_id)) ? 'checked' : '';
                                if ($leader == 1) {
                                    $checked = 'checked';
                                }
                                $PilgrimTypeClass = (($pilgrim['PilgrimAgeYears'] < 2) ? 'infant' : (($pilgrim['PilgrimAgeYears'] >= 2 && $pilgrim['PilgrimAgeYears'] <= 10) ? 'child' : 'adult'));
                                echo ' <input onchange="CheckPilgrimsCounter( ' . $pilgrim['PilgrimUID'] . ' );" id="VoucherPilgrims-' . $pilgrim['PilgrimUID'] . '" ' . $checked . ' type="checkbox" class="new-control-input todochkbox ' . $PilgrimTypeClass . '" value="' . $pilgrim['PilgrimUID'] . '" name="VoucherPilgrims[]">
                                        <input value="' . $PilgrimTypeClass . '" type="hidden" id="CheckPilgrimType-' . $pilgrim['PilgrimUID'] . '" name="CheckPilgrimType[]">
                                        <span class="new-control-indicator"></span> ' . $pilgrim['FirstName'] . '              
                                        </label><br>       
                                        <span class="ml-4">' . $pilgrim['PassportNumber'] . ' </span> 
                                             <span class="float-right" id="coloredtext">(' . $pilgrim['DOBInYears'] . ' Y )</span>            
                                          <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon2">P.#</div>
                                            </div>
                                          <input type="number" class="form-control ' . (($leader == 1) ? 'validate[required] ' : '') . '" placeholder="Phone Number" min="1" id="contactnumber" value="' . $pilgrim['Contact_Number'] . '" name="contact_number[' . $requestedView . '][' . $pilgrim['PilgrimUID'] . ']">
                                        </div>          
                                       </div> ';
                            }
                        }

                    }

//                    $totalPilgrims++;
//                    $leader = $pilgrim['Leader'];
//                    echo '
//                <div class="col-md-3 mb-3 ' . (($leader == 1) ? 'alert alert-success' : '') . '">
//                <label class="new-control new-checkbox checkbox-primary">';
//                    $checked = (in_array($options['UID'], $vouchers_id)) ? 'checked' : '';
//                    if ($leader == 1) {
//                        $checked = 'checked';
//                    }
//                    echo '
//                <input id="VoucherPilgrims" ' . $checked . ' type="checkbox" class="new-control-input todochkbox" value="' . $pilgrim['PilgrimUID'] . '" name="VoucherPilgrims[]">
//                <span class="new-control-indicator"></span> ' . $pilgrim['FirstName'] . '
//                </label><br>
//                <span class="ml-4">' . $pilgrim['PassportNumber'] . '</span>
//                  <div class="input-group mb-2">
//                    <div class="input-group-prepend">
//                        <div class="input-group-text" id="btnGroupAddon2">P.#</div>
//                    </div>
//                  <input type="number" class="form-control" placeholder="Phone Number" min="1" id="contactnumber" value="' . $pilgrim['ContactNumber'] . '" name="contact_number[' . $requestedView . '][' . $pilgrim['PilgrimUID'] . ']">
//                </div>
//               </div>
//                ';
                }
            }


            ?>
            <div class="col-md-12">
                <div class="" id="PilgrimStatusResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Close</button>
        <button type="button" class="btn btn-primary <?= (($totalPilgrims > 0) ? '' : 'hide d-none') ?>"
                onclick="PilgrimStatusFormSubmit()">Save
        </button>
    </div>
</form>


<script>

    function CheckPilgrimsCounter( PilgrimID = 0 ){

        /** Check Validation
         * Applied On
         * Pilgrims OR Not
         * */
        var CheckValidate = $("form#PilgrimStatusForm input#CheckValidate").val();
        CheckValidate = ( ( CheckValidate != '' && CheckValidate != null )? CheckValidate : 1 );
        if (parseInt(CheckValidate) == 1) {

            var TotalAllowedPilgrims = $("form#PilgrimStatusForm input#ActivityAllowedPilgrims").val();
            var TotalSubmittedAllowedPilgrims = $("form#PilgrimStatusForm input#ActivitySubmittedPilgrims").val();
            var TotalAdultsSubmittedAllowedPilgrims = $("form#PilgrimStatusForm input#ActivityAdultsSubmittedPilgrims").val();
            var RemainingAllowedPilgrims = (parseInt(TotalAllowedPilgrims) - parseInt(TotalSubmittedAllowedPilgrims));
            RemainingAllowedPilgrims = ((RemainingAllowedPilgrims != '' && RemainingAllowedPilgrims != null && RemainingAllowedPilgrims < 0) ? 0 : RemainingAllowedPilgrims);

            var RemainingAdultsAllowedPilgrims = (parseInt(TotalAllowedPilgrims) - parseInt(TotalAdultsSubmittedAllowedPilgrims));
            RemainingAdultsAllowedPilgrims = ((RemainingAdultsAllowedPilgrims != '' && RemainingAdultsAllowedPilgrims != null && RemainingAdultsAllowedPilgrims < 0) ? 0 : RemainingAdultsAllowedPilgrims);

            var TotalNoOfBeds = $("form#PilgrimStatusForm input#TotalNoOfBeds").val();
            var TotalPilgrims = $("form#PilgrimStatusForm input#TotalPilgrims").val();

            var AdultsCount = $('input.adult:checkbox:checked').length;
            var ChildCount = $('input.child:checkbox:checked').length;
            var InfantCount = $('input.infant:checkbox:checked').length;

            var SelectedChild = parseInt(ChildCount) + parseInt(InfantCount);
            var TotalSelectedPilgrims = parseInt(AdultsCount) + parseInt(SelectedChild);

            var RoomType = $("form#PilgrimStatusForm input#ActivityRoomType").val();

            var Access = ($('#VoucherPilgrims-' + PilgrimID).is(":checked"))? 1 : 0;
            if( RoomType != 'Sharing' ){
                if( parseInt(TotalNoOfBeds) == parseInt(TotalPilgrims)){

                    if(parseInt(Access) == 1){

                        if( parseInt(RemainingAllowedPilgrims) == 0 && parseInt(TotalSelectedPilgrims) > 0 ){
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Pilgrims Already Submitted... ");
                        }else if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) > parseInt(RemainingAllowedPilgrims)){
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Pilgrims, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Pilgrims. ");
                        }else if( parseInt(RemainingAllowedPilgrims) ==  parseInt(TotalSelectedPilgrims)){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }

                    }else{

                        $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) == 0) {
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        } else {
                            if (parseInt(TotalSelectedPilgrims) < parseInt(TotalAllowedPilgrims)) {
                                $("form#PilgrimStatusForm input#ValidateForm").val(1);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            } else {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            }
                        }
                    }

                }else{

                    if (parseInt(Access) == 1) {
                        if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) > parseInt(RemainingAllowedPilgrims)) {
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Adults. ");

                        } else if (parseInt(RemainingAllowedPilgrims) == 0) {
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
                        }else if( parseInt(RemainingAllowedPilgrims) ==  parseInt(AdultsCount)){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }

                    } else {

                        $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) == 0) {
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        } else {
                            if (parseInt(AdultsCount) < parseInt(TotalAllowedPilgrims)) {
                                $("form#PilgrimStatusForm input#ValidateForm").val(1);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            } else {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            }
                        }
                    }
                }
            }else{

                if( parseInt(TotalNoOfBeds) == parseInt(TotalPilgrims)){
                    if(parseInt(Access) == 1){

                        if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) <= parseInt(RemainingAllowedPilgrims) ){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }else if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) > parseInt(RemainingAllowedPilgrims) ){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            alert("Total Allow (" + parseInt(RemainingAllowedPilgrims) + ") Pilgrims, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Pilgrims. ");
                        }else if (parseInt(RemainingAllowedPilgrims) == 0) {
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
                        }else if( parseInt(RemainingAllowedPilgrims) ==  parseInt(TotalSelectedPilgrims)){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }

                    }else{

                        $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) == 0) {
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        } else {
                            if (parseInt(TotalSelectedPilgrims) > 0) {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            } else {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            }
                        }
                    }

                }else{

                    if(parseInt(Access) == 1){

                        if( parseInt(RemainingAdultsAllowedPilgrims) > 0 && parseInt(AdultsCount) > 0 && parseInt(AdultsCount) <= parseInt(RemainingAdultsAllowedPilgrims) ){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }else if( parseInt(RemainingAdultsAllowedPilgrims) > 0 && parseInt(AdultsCount) > parseInt(RemainingAdultsAllowedPilgrims) ){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            alert("Total Allow (" + parseInt(RemainingAdultsAllowedPilgrims) + ") Adults, You Can Select Only (" + parseInt(RemainingAdultsAllowedPilgrims) + ") Adults. ");
                        }else if (parseInt(RemainingAdultsAllowedPilgrims) == 0) {
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
                        }else if( parseInt(RemainingAdultsAllowedPilgrims) ==  parseInt(AdultsCount)){
                            $("form#PilgrimStatusForm input#ValidateForm").val(0);
                        }

                    }else{

                        $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        if (parseInt(RemainingAdultsAllowedPilgrims) > 0 && parseInt(AdultsCount) == 0) {
                            $("form#PilgrimStatusForm input#ValidateForm").val(1);
                            $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                        } else {
                            if (parseInt(AdultsCount) > 0) {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            } else {
                                $("form#PilgrimStatusForm input#ValidateForm").val(0);
                                $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
                            }
                        }
                    }

                }
            }

        }else{
            $("form#PilgrimStatusForm input#ValidateForm").val(0);
        }
    }

    // function OldCheckPilgrimsCounter(PilgrimID = 0) {
    //
    //     /** Check Validation
    //      * Applied On
    //      * Pilgrims OR Not
    //      * */
    //     var CheckValidate = $("form#PilgrimStatusForm input#CheckValidate").val();
    //     CheckValidate = ( ( CheckValidate != '' && CheckValidate != null )? CheckValidate : 1 );
    //
    //     if (parseInt(CheckValidate) == 1) {
    //
    //         var TotalAllowedPilgrims = $("form#PilgrimStatusForm input#ActivityAllowedPilgrims").val();
    //         var TotalSubmittedAllowedPilgrims = $("form#PilgrimStatusForm input#ActivitySubmittedPilgrims").val();
    //         var RemainingAllowedPilgrims = (parseInt(TotalAllowedPilgrims) - parseInt(TotalSubmittedAllowedPilgrims));
    //         RemainingAllowedPilgrims = ((RemainingAllowedPilgrims != '' && RemainingAllowedPilgrims != null && RemainingAllowedPilgrims < 0) ? 0 : RemainingAllowedPilgrims);
    //
    //         var AdultsCount = $('input.adult:checkbox:checked').length;
    //         var ChildCount = $('input.child:checkbox:checked').length;
    //         var InfantCount = $('input.infant:checkbox:checked').length;
    //
    //         var SelectedChild = parseInt(ChildCount) + parseInt(InfantCount);
    //         var TotalSelectedPilgrims = parseInt(AdultsCount) + parseInt(SelectedChild);
    //
    //
    //         if (PilgrimID == 0) {
    //             if (parseInt(RemainingAllowedPilgrims) == 0 && parseInt(AdultsCount) > 0) {
    //                 $("[type='checkbox']:checked").prop('checked', false);
    //                 $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                 alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
    //             } else if (parseInt(AdultsCount) > parseInt(RemainingAllowedPilgrims)) {
    //                 $("[type='checkbox']:checked").prop('checked', false);
    //                 $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                 alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Adults. ");
    //             } else if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) == 0) {
    //                 $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //             } else {
    //                 if (parseInt(AdultsCount) < parseInt(TotalAllowedPilgrims)) {
    //                     $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                 } else {
    //                     $("form#PilgrimStatusForm input#ValidateForm").val(0);
    //                 }
    //             }
    //         } else {
    //             var Access = ($('#VoucherPilgrims-' + PilgrimID).is(":checked")) ? 1 : 0;
    //             if (parseInt(Access) == 1) {
    //                 if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) > parseInt(RemainingAllowedPilgrims)) {
    //                     $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
    //                     $("form#PilgrimStatusForm input#ValidateForm").val(0);
    //                     alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Adults. ");
    //
    //                 } else if (parseInt(RemainingAllowedPilgrims) == 0) {
    //                     $("input#VoucherPilgrims-" + PilgrimID).prop('checked', false);
    //                     $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                     alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
    //                 } else {
    //                     if (parseInt(AdultsCount) < parseInt(TotalAllowedPilgrims)) {
    //                         $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                     } else {
    //                         $("form#PilgrimStatusForm input#ValidateForm").val(0);
    //                     }
    //                 }
    //             } else {
    //
    //                 if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) == 0) {
    //                     $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                 } else {
    //                     if (parseInt(AdultsCount) < parseInt(TotalAllowedPilgrims)) {
    //                         $("form#PilgrimStatusForm input#ValidateForm").val(1);
    //                     } else {
    //                         $("form#PilgrimStatusForm input#ValidateForm").val(0);
    //                     }
    //                 }
    //             }
    //         }
    //
    //     } else {
    //         $("form#PilgrimStatusForm input#ValidateForm").val(0);
    //     }
    // }

    function PilgrimStatusFormSubmit() {

        var validate = $("form#PilgrimStatusForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var ValidateForm = $("form#PilgrimStatusForm input#ValidateForm").val();
        if (parseInt(ValidateForm) == 0) {

            var phpdata = $("form#PilgrimStatusForm").serialize();
            var response = AjaxResponse("form_process/pilgrim_status_form_submit", phpdata);

            if (response.status == 'success') {
                $("#PilgrimStatusResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                setTimeout(function () {
                    location.reload();
                }, 2000)
            } else {
                $("#PilgrimStatusResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
            }

        } else {

            var TotalAllowedPilgrims = $("form#PilgrimStatusForm input#ActivityAllowedPilgrims").val();
            var TotalSubmittedAllowedPilgrims = $("form#PilgrimStatusForm input#ActivitySubmittedPilgrims").val();
            var RemainingAllowedPilgrims = (parseInt(TotalAllowedPilgrims) - parseInt(TotalSubmittedAllowedPilgrims));
            RemainingAllowedPilgrims = ((RemainingAllowedPilgrims != '' && RemainingAllowedPilgrims != null && RemainingAllowedPilgrims < 0) ? 0 : RemainingAllowedPilgrims);

            var TotalNoOfBeds = $("form#PilgrimStatusForm input#TotalNoOfBeds").val();
            var TotalPilgrims = $("form#PilgrimStatusForm input#TotalPilgrims").val();

            var AdultsCount = $('input.adult:checkbox:checked').length;
            var ChildCount = $('input.child:checkbox:checked').length;
            var InfantCount = $('input.infant:checkbox:checked').length;

            var SelectedChild = parseInt(ChildCount) + parseInt(InfantCount);
            var TotalSelectedPilgrims = parseInt(AdultsCount) + parseInt(SelectedChild);
            var RoomType = $("form#PilgrimStatusForm input#ActivityRoomType").val();


            if( parseInt(TotalNoOfBeds) == parseInt(TotalPilgrims)){

                if(RoomType != 'Sharing'){
                    if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) < parseInt(RemainingAllowedPilgrims) ){
                        alert("Min (" + parseInt(RemainingAllowedPilgrims) + ") Pilgrims Selection Required, Total Selected (" + parseInt(TotalSelectedPilgrims) + ") Pilgrims. ");
                    }else if( parseInt(RemainingAllowedPilgrims) == 0 ){
                        alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Pilgrims Already Submitted... ");
                    }
                }else{

                    if( parseInt(RemainingAllowedPilgrims) == 0 ){
                        alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Pilgrims Already Submitted... ");
                    }else if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(TotalSelectedPilgrims) == 0 ){
                        alert("Min (1) Pilgrim Required To Submit Activity");
                    }

                }

            }else{

                if(RoomType != 'Sharing'){

                    if (parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) > parseInt(RemainingAllowedPilgrims)) {
                        alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults, You Can Select Only (" + parseInt(RemainingAllowedPilgrims) + ") Adults. ");
                    } else if (parseInt(RemainingAllowedPilgrims) == 0) {
                        alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
                    } else if (parseInt(AdultsCount) < parseInt(TotalAllowedPilgrims)) {
                        alert("Min (" + parseInt(RemainingAllowedPilgrims) + ") Adults Selection Required, Total Selected (" + parseInt(AdultsCount) + ") Adults. ");
                    }

                }else{

                    if( parseInt(RemainingAllowedPilgrims) == 0 ){
                        alert("Total Allow (" + parseInt(TotalAllowedPilgrims) + ") Adults Already Submitted... ");
                    }else if( parseInt(RemainingAllowedPilgrims) > 0 && parseInt(AdultsCount) == 0 ){
                        alert("Min (1) Adult Required To Submit Activity");
                    }
                }
            }

        }
    }

    checkall('todoAll', 'todochkbox');
    $('[data-toggle="tooltip"]').tooltip()
</script>