<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <h4 class="page-head">Run Email Campaigns </h4>

            </div>

            <!--            --><?php //echo "<pre>"; print_r($Email_Camaigns);?>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <form class="validate" id="run_email_campaign_form"
                      onsubmit="RunEmailCampaignLogs(); return  false;">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Allcampaigns">Select Campaign</label>
                                                        <select class="form-control validate[required]"
                                                                id="Allcampaigns"
                                                                name="Allcampaigns">
                                                            <option value="" selected disabled>Please Select</option>
                                                            <?php foreach ($Email_Camaigns as $value) {
                                                                echo ' <option value="' . $value['UID'] . '"> ' . ucwords($value['Title']) . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="All_Email_lists">Email List</label>
                                                        <select class="form-control validate[required]"
                                                                id="All_Email_lists"
                                                                name="All_Email_lists">
                                                            <option value="" selected disabled>Please Select</option>
                                                            <?php
                                                            foreach ($EmailLists as $value) {
                                                                echo ' <option value="' . $value['UID'] . '">' . ucwords($value['FullName']) . '</option>';
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="Execute_Date">Execute Date</label>
                                                        <input type="date" name="Execute_Date" id="Execute_Date"
                                                               class="form-control validate[required]"
                                                               min="<?php echo date('Y-m-d'); ?>"
                                                               value="<?php echo date('Y-m-d'); ?>">
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="row" id="show">
                                                <div class="col-md-3" id="HTML">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-12" id="Status">
                                                </div>
                                            </div>


                                            <div class="row ">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id=""
                                                                class="btn btn_customized float-right ml-2"
                                                                type="submit">Submit
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

        </div>
    </div>
</div>


<script type="application/javascript">


    // $(document).ready(function () {
    //     $("#show").hide();
    //     $('#All_Email_lists').on('change', function () {
    //         $("#show").show();
    //     });
    // });


    $('#Allcampaigns').on('change', function () {
        $("#HTML").hide();
        $('#All_Email_lists').val('');
        // var data = '';
        // AjaxRequest('emailcampaign/HTMLDataCampaign', data, 'HTML');
        // $("#HTML").show();
    });


    $('#All_Email_lists').on('change', function () {
        var demovalue = $(this).val();
        $("#HTML").hide();
        var data = $("form#run_email_campaign_form").serialize();
        AjaxRequest('emailcampaign/HTMLDataList', data, 'HTML');
        $("#HTML").show();
    });


    function RunEmailCampaignLogs() {

        var validate = $("form#run_email_campaign_form").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var data = $("form#run_email_campaign_form").serialize();
        response = AjaxResponse("emailcampaign/run_campigns_data", data);
        if (response.status == 'success') {
            $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
            $("form#run_email_campaign_form").trigger('reset');
            location.reload();
        } else if (response.status == 'alert') {
            $('#Status').html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong>Alert!</strong> ' + response.message + ' </div>');
        }

    }


    $('#MainRecords').DataTable({
        "scrollX": true,
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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

</script>