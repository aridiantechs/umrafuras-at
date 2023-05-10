<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$SaleAgents = new SaleAgent();
$head = 'Add New';
$update_id = 0;


//$ZiyaratsLists = $records['ziyarats_list'];
//$ServicesLists = $records['services_list'];
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}
//print_r($voucher_log);
?>
<div id="RefundModal" class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Refund Voucher Services</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="VoucherRefundForm"
      name="VoucherRefundForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">

        <div class="row">
            <div class="col-md-12">
                <h6>Hotels List </h6>
                <div class="table-responsive mb-4 mt-4 datatableparentdiv" id="AccomodationDetail"
                     style="overflow: auto;max-height: 200px;">
                    <!--                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">-->
                    <!--                        <thead>-->
                    <!--                        <tr>-->
                    <!--                            <th>#</th>-->
                    <!--                            <th>Ziyarat</th>-->
                    <!--                            <th>Rate</th>-->
                    <!--                            <th>Ziyart City</th>-->
                    <!--                            <th>Ziyarat No Of Pax</th>-->
                    <!--                            <th>Action</th>-->
                    <!--                        </tr>-->
                    <!--                        </thead>-->
                    <!--                        <tbody>-->
                    <!--                        --><?php
                    //                        $cnt = 0;
                    //                        foreach ($ZiyaratsLists as $ServicesList) {
                    //                            $cnt++;
                    //                            $actions = '
                    //                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1"> Refund   </button>';
                    //                            echo '
                    //                                <tr>
                    //                                    <td>' . $cnt . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratName'] . '</td>
                    //                                    <td>' . Money($ServicesList['Rate']) . '</td>
                    //                                     <td>' . CityName($ServicesList['ZiyaratCity']) . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratNoOfPax'] . '</td>
                    //
                    //                                    <td>' . $actions . ' </td>
                    //                                </tr>
                    //                                ';
                    //                        }
                    //                        ?>
                    <!--                        </tbody>-->
                    <!--                    </table>-->
                </div>
            </div>
            <div class="col-md-12">
                <h6>Ziyarats List </h6>
                <div class="table-responsive mb-4 mt-4 datatableparentdiv" id="ZiyaratsList"
                     style="overflow: auto;max-height: 200px;">
                    <!--                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">-->
                    <!--                        <thead>-->
                    <!--                        <tr>-->
                    <!--                            <th>#</th>-->
                    <!--                            <th>Ziyarat</th>-->
                    <!--                            <th>Rate</th>-->
                    <!--                            <th>Ziyart City</th>-->
                    <!--                            <th>Ziyarat No Of Pax</th>-->
                    <!--                            <th>Action</th>-->
                    <!--                        </tr>-->
                    <!--                        </thead>-->
                    <!--                        <tbody>-->
                    <!--                        --><?php
                    //                        $cnt = 0;
                    //                        foreach ($ZiyaratsLists as $ServicesList) {
                    //                            $cnt++;
                    //                            $actions = '
                    //                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1"> Refund   </button>';
                    //                            echo '
                    //                                <tr>
                    //                                    <td>' . $cnt . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratName'] . '</td>
                    //                                    <td>' . Money($ServicesList['Rate']) . '</td>
                    //                                     <td>' . CityName($ServicesList['ZiyaratCity']) . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratNoOfPax'] . '</td>
                    //
                    //                                    <td>' . $actions . ' </td>
                    //                                </tr>
                    //                                ';
                    //                        }
                    //                        ?>
                    <!--                        </tbody>-->
                    <!--                    </table>-->
                </div>
            </div>
            <div class="col-md-12">
                <h6>Transport List </h6>
                <div class="table-responsive mb-4 mt-4 datatableparentdiv" id="TransportList"
                     style="overflow: auto;max-height: 200px;">
                    <!--                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">-->
                    <!--                        <thead>-->
                    <!--                        <tr>-->
                    <!--                            <th>#</th>-->
                    <!--                            <th>Ziyarat</th>-->
                    <!--                            <th>Rate</th>-->
                    <!--                            <th>Ziyart City</th>-->
                    <!--                            <th>Ziyarat No Of Pax</th>-->
                    <!--                            <th>Action</th>-->
                    <!--                        </tr>-->
                    <!--                        </thead>-->
                    <!--                        <tbody>-->
                    <!--                        --><?php
                    //                        $cnt = 0;
                    //                        foreach ($ZiyaratsLists as $ServicesList) {
                    //                            $cnt++;
                    //                            $actions = '
                    //                               <button type="button"  class="btn btn_customized  btn-sm" id="dropdownMenuReference1"> Refund   </button>';
                    //                            echo '
                    //                                <tr>
                    //                                    <td>' . $cnt . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratName'] . '</td>
                    //                                    <td>' . Money($ServicesList['Rate']) . '</td>
                    //                                     <td>' . CityName($ServicesList['ZiyaratCity']) . '</td>
                    //                                    <td>' . $ServicesList['ZiyaratNoOfPax'] . '</td>
                    //
                    //                                    <td>' . $actions . ' </td>
                    //                                </tr>
                    //                                ';
                    //                        }
                    //                        ?>
                    <!--                        </tbody>-->
                    <!--                    </table>-->
                </div>
            </div>
            <div class="col-md-12">
                <h6>Services List </h6>
                <div class="table-responsive mb-4 mt-4 datatableparentdiv" id="ServicesList"
                     style="overflow: auto;max-height: 200px;">
                    <!--                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">-->
                    <!--                        <thead>-->
                    <!--                        <tr>-->
                    <!--                            <th>#</th>-->
                    <!--                            <th>Service</th>-->
                    <!--                            <th width="60px">Action</th>-->
                    <!--                        </tr>-->
                    <!--                        </thead>-->
                    <!--                        <tbody>-->
                    <!--                        --><?php
                    //                        $cnt = 0;
                    //                        foreach ($ServicesLists as $ServicesList) {
                    //                            $cnt++;
                    //                            $actions = '
                    //                               <button type="button" class="btn btn_customized btn-sm" id="dropdownMenuReference1" onclick="RefundServices('.$ServicesList['UID'].');"> Refund </button>';
                    //                            echo '
                    //                                <tr>
                    //                                    <td>' . $cnt . '</td>
                    //                                    <td>' . $ServicesList['ServiceName'] . '</td>
                    //                                    <td>' . $actions . ' </td>
                    //                                </tr>
                    //                                ';
                    //                        }
                    //                        ?>
                    <!--                        </tbody>-->
                    <!--                    </table>-->
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="" id="VoucherStatusResponse"></div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            <button type="button" class="btn btn-primary" onclick="">Save</button>
        </div>

    </div>
</form>
<script>
    setTimeout(function () {
        LoadRefundServices();
        LoadZiyarats();
        LoadTransport();
        LoadHotel();
    }, 100);


    function LoadRefundServices() {
        ID = <?= $record_id ?>;
        AjaxRequest("form_process/get_services_list", "ID=" + ID, "ServicesList");
    }

    function LoadZiyarats() {
        ID = <?= $record_id ?>;
        AjaxRequest("form_process/get_ziyarats_list", "ID=" + ID, "ZiyaratsList");
    }

    function LoadTransport() {
        ID = <?= $record_id ?>;
        AjaxRequest("form_process/get_transport_list", "ID=" + ID, "TransportList");
    }

    function LoadHotel() {
        ID = <?= $record_id ?>;
        AjaxRequest("form_process/get_hotel_list", "ID=" + ID, "AccomodationDetail");
    }

    function RefundServices(UID) {
        if (confirm("Are You Sure You Want To Refund This Service?")) {
            var ServiceRefundReason = $("form#VoucherRefundForm input#ServiceRefundReason-" + UID).val();

            response = AjaxResponse("form_process/refund_voucher_service", "UID=" + UID+ "&ServiceRefundReason=" + ServiceRefundReason);
            if (response.status == 'success') {
                LoadRefundServices();
            }
        }
    }

    function RefundZiyarats(UID) {
        if (confirm("Are You Sure You Want To Refund This Ziyarat?")) {
            var ZiyaratRefundReason = $("form#VoucherRefundForm input#ZiyaratRefundReason-" + UID).val();
            response = AjaxResponse("form_process/refund_ziyarat_service", "UID=" + UID + "&ZiyaratRefundReason=" + ZiyaratRefundReason);
            if (response.status == 'success') {
                LoadZiyarats();
            }
        }
    }

    function RefundHotels(UID) {
        if (confirm("Are You Sure You Want To Refund This Accomodation?")) {
            var HotelRefundReason = $("form#VoucherRefundForm input#HotelRefundReason-" + UID).val();

            response = AjaxResponse("form_process/refund_accomodation_service", "UID=" + UID + "&HotelRefundReason=" + HotelRefundReason);
            if (response.status == 'success') {
                LoadHotel();
            }
        }
    }

    function RefundTransport(UID) {
        if (confirm("Are You Sure You Want To Refund This Transport?")) {
            var TransportRefundReason = $("form#VoucherRefundForm input#TransportRefundReason-" + UID).val();
            // alert(TransportRefundReason);
            // return;
            response = AjaxResponse("form_process/refund_transport", "UID=" + UID + "&TransportRefundReason=" + TransportRefundReason);
            if (response.status == 'success') {
                LoadTransport();
            }
        }
    }
</script>
