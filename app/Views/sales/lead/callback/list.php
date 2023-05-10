<?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$SessionFilters = $session->get('CallBacksSearchFilter');

if (isset($SessionFilters['LeadStatus']) && $SessionFilters['LeadStatus'] != '') {
    $LeadStatus = $SessionFilters['LeadStatus'];
}

if (isset($SessionFilters['Products']) && $SessionFilters['Products'] != '') {
    $Product = $SessionFilters['Products'];
}

?>

<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"><?= str_replace("_", " ", ucwords($CallBackMonth)); ?> Call Backs

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post"
                      onsubmit="CallBacksSearchFilterFormSubmit('CallBacksSearchFilterForm'); return false;"
                      class="section contact" name="CallBacksSearchFilterForm"
                      id="CallBacksSearchFilterForm">
                    <input type="hidden" name="SessionKey" id="SessionKey"
                           value="CallBacksSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="=leadStatus">Lead Status </label>
                                                        <select class="form-control validate[required]" id="LeadStatus"
                                                                name="LeadStatus">
                                                            <option value=""> Select Lead Status</option>
                                                            <?php foreach ($LeadStatusArray as $key => $value) {
                                                                $selected = (($LeadStatus == $key) ? 'selected' : '');
                                                                if ($key == 'new') {
                                                                    echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                                } else {
                                                                    ?>
                                                                    <option value="<?= $key ?>" <?= $selected ?>><?= $value ?></option>
                                                                <?php }
                                                            } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="=leadStatus">Products</label>
                                                        <select class="form-control validate[required]" id="Products"
                                                                name="Products">
                                                            <option value=""> Select Products </option>
                                                            <?php foreach ($Products as $value) {
                                                                if ($value == 'home' || $value == 'sales') {
                                                                } else {
                                                                    $selected = (($Product == $value) ? 'selected' : '');
                                                                    ?>
                                                                    <option value="<?= $value ?>" <?= $selected ?>> <?= ucwords($value) ?></option>
                                                                <?php }
                                                            } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="CallBacksSearchFilterFormSubmit( 'CallBacksSearchFilterForm' );"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('CallBacksSearchFilter');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="CallBacksSearchFilterAjaxResult"></div>
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="callbackgrid" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref. ID</th>
                                <th>Sale Officer</th>
                                <th>Product</th>
                                <th>Call Back Date</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var call_back_month = '<?= $CallBackMonth ?>';
        var product_name = '<?= $Product ?>';

        $('#callbackgrid').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 100,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "ajax": {
                url: "<?= $path ?>lead/get_call_backs_data",
                type: 'POST',
                data: {product: product_name, call_back_month: call_back_month}
            }
        });
    });


    function CallBacksSearchFilterFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'CallBacksSearchFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('CallBacksSearchFilterForm', 'CallBacksSearchFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#CallBacksSearchFilterForm")[0].reset();
            setTimeout(function () {
                location.reload();
            }, 2000);
        }
    }

</script>

<!--<script type="application/javascript">-->
<!---->
<!---->
<!--    $('#ReportTable').DataTable({-->
<!--        "scrollX": true,-->
<!--        "oLanguage": {-->
<!--            "oPaginate": {-->
<!--                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',-->
<!--                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'-->
<!--            },-->
<!--            "sInfo": "Showing page _PAGE_ of _PAGES_",-->
<!--            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',-->
<!--            "sSearchPlaceholder": "Search...",-->
<!--            "sLengthMenu": "Results :  _MENU_",-->
<!--        },-->
<!--        "stripeClasses": [],-->
<!--        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],-->
<!--        "pageLength": 100-->
<!--    });-->
<!---->
<!--    setTimeout(function () {-->
<!--        $('<a href="#" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");-->
<!--    }, 100);-->
<!---->
<!--</script>-->
