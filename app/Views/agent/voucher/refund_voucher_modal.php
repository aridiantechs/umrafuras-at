<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$SaleAgents = new SaleAgent();
$head = 'Add New';
$update_id = 0;

$recordid = $records['recordid'];
$voucher = $records['voucher_detail'];
//$type = $records['type'];
$request_status = $records['request_status'];
$voucher_detail = $voucher[0];




$days = '-';
$CheckIn = ($voucher_detail['CheckIn']);
$CheckOut = ($voucher_detail['CheckOut']);
if ($CheckIn != '' && $CheckIn != '') {
    $days = date_diff(date_create($CheckIn), date_create($CheckOut));
    $days = $days->days;
}
//print_r($voucher_detail);
if ($record_id > 0) {
    $head = 'Update';
    $update_id = $record_id;
}
//print_r($voucher_log);
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Refund Voucher Modal</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="RefundVoucherStatusForm"
      name="RefundVoucherStatusForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $recordid ?>">
        <input type="hidden" name="Type" id="Type" value="<?= $request_status ?>">
        <div class="row">
            <div class="col-md-12">
                <h5>Voucher's Detail</h5>
                <hr>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Email"><strong>Agent :</strong> </label>
                    <span id="Agent" placeholder="Agent"><?= $voucher_detail['AgentName'] ?> </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Email">Arrival Date : </label>
                    <span id="ArrivalDate"
                          placeholder="ArrivalDate"><?= DATEFORMAT($voucher_detail['ArrivalDate']) ?></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Email">Return Date : </label>
                    <span id="ReturnDate"
                          placeholder="ReturnDate"><?= DATEFORMAT($voucher_detail['ReturnDate']) ?></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-4">
                    <label for="Email">Country : </label>
                    <span id="Country" placeholder="Country"><?= CountryName($voucher_detail['Country']) ?></span>
                </div>
            </div>
            <?php if ($request_status == 'accommodation ') { ?>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">City : </label>
                        <span id="City" placeholder="City"><?= CityName($voucher_detail['City']) ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Hotel : </label>
                        <span id="Hotel" placeholder="Hotel"><?= $voucher_detail['HotelName'] ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Check-in : </label>
                        <span id="CheckIN" placeholder="CheckIN"><?= DATEFORMAT($voucher_detail['CheckIn']) ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Check-out : </label>
                        <span id="CheckOut" placeholder="CheckOut"><?= DATEFORMAT($voucher_detail['CheckOut']) ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">No Of Nights : </label>
                        <span id="CheckOut" placeholder="CheckOut"><?= $days ?></span>
                    </div>
                </div>
            <?php }
            else if ($request_status == 'transport ') { ?>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Travel City : </label>
                        <span id="City" placeholder="TravelCity"><?= CityName($voucher_detail['TravelCity']) ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Travel Type : </label>
                        <span id="City" placeholder="TravelType"><?= $voucher_detail['TravelType'] ?></span>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Travel Date : </label>
                        <span id="City" placeholder="TravelDate"><?= $voucher_detail['TravelDate'] ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Sector : </label>
                        <span id="City" placeholder="Sector"><?= $voucher_detail['SectorName'] ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">Transport : </label>
                        <span id="City" placeholder="Sector"><?= $voucher_detail['TransportTypeName'] ?></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-4">
                        <label for="Email">No Of Seats : </label>
                        <span id="City" placeholder="NoOfSeats"><?= $voucher_detail['NoOfSeats'] ?></span>
                    </div>
                </div>


            <?php } else { } ?>


        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Refund</h5>
                <hr>
            </div>
            <!--            <div class="col-md-6">-->
            <!--                <div class="form-group mb-4">-->
            <!--                    <label for="Email">Type</label>-->
            <!--                    <select class="form-control validate[required]" id="RefundType"-->
            <!--                            name="RefundType" onclick="CheckStatus(this.value)">-->
            <!--                        <option value="full_refund">Full</option>-->
            <!--                        <option value="accommodation_refund">Accommodation</option>-->
            <!--                        <option value="transport_refund">Transport</option>-->
            <!--                        <option value="ziayart_refund">Ziyarat</option>-->
            <!--                        <option value="service_refund">Service</option>-->
            <!---->
            <!--                    </select>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Refund Quantity</label>
                    <?php if ($request_status == 'accommodation ') { ?>
                        <input class="form-control mb-4 validate[required,funcCall[checknights]]" required="required"
                               id="Quantity" name="Quantity" type="number" min="1" max="<?= $days ?>"
                               placeholder="Quantity">
                    <?php } else if ($request_status == 'transport ') { ?>
                        <input class="form-control mb-4 validate[required,funcCall[checkseats]]" required="required"
                               id="Quantity" name="Quantity" type="number" min="1"
                               max="<?= $voucher_detail['NoOfSeats'] ?>" placeholder="Quantity">
                    <?php }  else{}?>

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Email">Remarks</label>
                    <textarea class="form-control mb-4 validate[required]"
                              id="Remarks" name="Remarks"
                              placeholder="Remarks"></textarea>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="RefundVoucherStatusResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="RefundVoucherStatusFormSubmit();">Save</button>
    </div>
</form>
<script>

    function checknights(field, rules, i, options) {
        var days = '<?=$days?>';
        if (field.val() > days || field.val() < 1) return "Please enter No Of Beds upto " + days;
    }

    function checkseats(field, rules, i, options) {
        var days = '<?=$voucher_detail['NoOfSeats']?>';
        if (field.val() > days || field.val() < 1) return "Please enter No Of Seats upto " + days;
    }

    function RefundVoucherStatusFormSubmit() {


        var validate = $("form#RefundVoucherStatusForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#RefundVoucherStatusForm")[0]);
        response = AjaxUploadResponse("form_process/refund_voucher_remarks_form_submit", phpdata);

        if (response.status == 'success') {
            $("#RefundVoucherStatusResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#RefundVoucherStatusResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }
</script>
