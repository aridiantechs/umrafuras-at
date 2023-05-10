<?php

use App\Models\Crud;

$Crud = new Crud();

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pilgrims Without Visa
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="ManageVisaSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="full_name">Full Name</label>
                                                        <input class="form-control" id="full_name"
                                                               name="full_name"
                                                               placeholder="Full Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="passport_no">Passport No</label>
                                                        <input class="form-control" id="passport_no" name="passport_no"
                                                               placeholder="Passport No">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="mofa_no">Mofa No</label>
                                                        <input class="form-control" id="mofa_no" name="mofa_no"
                                                               placeholder="Mofa No">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="VisaNo">Visa No</label>
                                                        <input class="form-control" id="VisaNo" name="VisaNo"
                                                               placeholder="Visa No">
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="visaissue_date">Visa Issue Date</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="visaissue_date" id="visaissue_date" readonly
                                                               placeholder="" value=""
                                                        >

                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="visa_type">Visa Type</label>
                                                        <select class="form-control" id="visa_type"
                                                                name="visa_type">
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                </div>




                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form enctype="multipart/form-data" class="validate" method="post" action="#"
                          id="PilgrimVisaAssignForm" name="PilgrimVisaAssignForm">
                        <div id="PilgrimVisaAssignResponse"></div>
                        <div class="table-responsive mb-4 mt-4 datatableparentdiv ">
                            <table id="MainRecords" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref.ID</th>
                                    <th>Full Name</th>
                                    <th>Passport Number</th>
                                    <th>MOFA Number</th>
                                    <th width="90">DOB</th>
                                    <th>Country</th>
                                    <th>Current Status</th>
                                    <th>Visa Number</th>
                                    <th>Visa Issue Date</th>

                                    <th>Visa Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var dataTable = $('#MainRecords').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "responsive": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Pilgrims",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pilgrims",
            },
            "ajax": {
                url: "<?= $path ?>mofa/fetch_visa_details",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.full_name = $('#full_name').val();
                    data.passport_no = $('#passport_no').val();
                    data.mofa_no = $('#mofa_no').val();
                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],

        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#ManageVisaSearchFilter')[0].reset();
            dataTable.ajax.reload();  //just reload table
        });

    });
</script>
<script type="application/javascript">


    function VisaDetailsSubmit(parent, cnt) {
        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/pilgrim_visa_details_form_submit', phpdata);

        if (response.status == 'success') {
            $("#PilgrimVisaAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                $("#PilgrimVisaAssignResponse").hide();
                $("#RowNo_" + cnt).remove();
                // location.reload();
            }, 100)
        } else {
            $("#PilgrimVisaAssignResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    /*$('#MainRecords').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [100, 200, 300, 400],
        "pageLength": 100
    });*/


</script>