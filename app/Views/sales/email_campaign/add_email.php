<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <h4 class="page-head">Add Email </h4>

            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <form class="section contact" method="" action="" id="AddEmail">
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
                                                        <label for="Name"> Name</label>
                                                        <input type="text" class="form-control  validate[required]" id="Name"
                                                               name="Name" placeholder=" Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Email</label>
                                                        <input type="email" name="Email" class="form-control validate[required,custom[email]]" id="Email"
                                                               placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="form-group mb-4" id="">

                                                    <label for="FullName">Assign To The List : </label> <label
                                                    >
                                                        <input class="ml-3" type="checkbox" id="checkAll"> Check
                                                        all</label>

                                                    <div class="n-chk row mt-3">
                                                        <?php foreach ($EmailLists as $value) { ?>
                                                            <label class=" new-control new-checkbox checkbox-primary">
                                                                <input id="<?= $value['UID'] ?>" type="checkbox"
                                                                       class=""
                                                                       value="1" name="group[<?= $value['UID'] ?>]" style="margin-right: 7px;">
                                                                <span></span><strong><?= ucwords($value['FullName']) ?></strong>
                                                            </label>
                                                        <?php } ?>
                                                    </div>


                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="" id="Status"></div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="multiple-messages" type="button"
                                                                class="btn btn_customized float-right ml-2"
                                                                onclick="SaveAddEmailForm()">Save
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

    function SaveAddEmailForm() {

        var validate = $("form#AddEmail").validationEngine('validate');
        if (validate == false) {
            return false;
        }

        var data = $('form#AddEmail').serialize();
        response = AjaxResponse("emailcampaign/save_email_data", data);
        if (response.status == 'success') {
            $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
            $('form#AddEmail').trigger("reset");
            location.reload();
        }else if(response.status == 'successAlert'){
            $("#Status").html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong>Sorry!</strong> ' + response.message + ' </div>')
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