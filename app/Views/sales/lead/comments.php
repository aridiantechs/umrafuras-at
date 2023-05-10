<?php

use App\Models\Crud;

$Crud = new Crud();
$SalesOfficersRecord = $Crud->ListRecords('main."Users"', array('UserType' => 'sale-officer', 'Archive' => 0), array('FullName' => 'ASC'));

$session = session();
$SessionFilters = $session->get('LeadsCommentsSessionFilters');
$SalesOfficer = $Product = $CommentStartDate = $CommentEndDate = '';
if (isset($SessionFilters['sale_officer']) && $SessionFilters['sale_officer'] != '') {
    $SalesOfficer = $SessionFilters['sale_officer'];
}

if (isset($SessionFilters['product']) && $SessionFilters['product'] != '') {
    $Product = $SessionFilters['product'];
}

if (isset($SessionFilters['comments_start_date']) && $SessionFilters['comments_start_date'] != '') {
    $CommentStartDate = $SessionFilters['comments_start_date'];
}

if (isset($SessionFilters['comments_end_date']) && $SessionFilters['comments_end_date'] != '') {
    $CommentEndDate = $SessionFilters['comments_end_date'];
}
?>
<style>
    #FilterButtons {
        margin-top: 30px !important;
    }
</style>
<h4 class="page-head"></h4>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Leads Comments

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
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
                        <div id="FilterDetails" class="collapse show " data-parent="#toggleAccordion">
                            <div class="card-body">
                                <form onsubmit="LeadsCommentsFiltersFormSubmit( 'LeadsCommentsSearchFilterForm' ); return false;"
                                      class="section contact" name="LeadsCommentsSearchFilterForm"
                                      id="LeadsCommentsSearchFilterForm">
                                    <input type="hidden" name="SessionKey" id="SessionKey"
                                           value="LeadsCommentsSessionFilters">
                                    <input type="hidden" name="comments_start_date" id="comments_start_date"
                                           value="<?= $CommentStartDate ?>">
                                    <input type="hidden" name="comments_end_date" id="comments_end_date"
                                           value="<?= $CommentEndDate ?>">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Sale Officer</label>
                                                        <select class="form-control" id="sale_officer"
                                                                name="sale_officer">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($SalesOfficersRecord as $SO) {
                                                                echo '<option ' . (($SalesOfficer == $SO['UID']) ? 'selected' : '') . ' value="' . $SO['UID'] . '">' . $SO['FullName'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Product</label>
                                                        <select class="form-control" id="product"
                                                                name="product">
                                                            <option value="">Select Product</option>
                                                            <?php
                                                            foreach ($Products as $product) {
                                                                if ($product != 'home' && $product != 'sales' && $product != 'visitor')
                                                                echo '<option ' . (($Product == $product) ? 'selected' : '') . ' value="' . $product . '">' . ucwords($product) . '</option>';
                                                            } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-none">
                                                    <div class="form-group">
                                                        <label for="country">Leads Form</label>
                                                        <select class="form-control" id="SystemUsers"
                                                                name="SystemUsers">
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Comment Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="lead_comment_date" id="lead_comment_date"
                                                               placeholder="Comments Dates" value=""
                                                               onchange="GetLeadCommentsDate();">
                                                    </div>
                                                </div>
                                                <div class="col-md-6" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="LeadsCommentsFiltersFormSubmit( 'LeadsCommentsSearchFilterForm' );"
                                                                id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button onclick="ClearSession('LeadsCommentsSessionFilters');"
                                                                id="btnreset" type="button" class="btn btn-danger">Clear
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="LeadCommentsFilterAjaxResult"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="CommentsRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Ref.ID</th>
                                <th>Leads Name</th>
                                <th>Sale Officer</th>
                                <th>Product Name</th>
                                <th>Status</th>
                                <th>Commented On</th>
                                <th>Activity</th>
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

        setTimeout(function () {
            var SessionCommentStartDate = "<?=$CommentStartDate?>";
            var SessionCommentEndDate = "<?=$CommentEndDate?>";
            $("#comments_start_date").val(SessionCommentStartDate);
            $("#comments_end_date").val(SessionCommentEndDate);
            if (SessionCommentStartDate != '' && SessionCommentEndDate != '') {
                $("#lead_comment_date").val(SessionCommentStartDate + " to " + SessionCommentEndDate);
            }
        }, 1000);

        $('#CommentsRecord').DataTable({
            "searching": false,
            "processing": true,
            "pageLength": 100,
            "serverSide": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "ajax": {
                url: "<?= $path ?>lead/get_comments_data",
                type: 'POST'
            }
        });
    });

    function GetLeadCommentsDate() {
        const LeadCommentsDate = $("#lead_comment_date").val();
        const words = LeadCommentsDate.split(' to ');
        $("#comments_start_date").val(words[0]);
        $("#comments_end_date").val(words[1]);
    }

    function LeadsCommentsFiltersFormSubmit(parent) {

        var dataTable = $('#CommentsRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {
            GridMessages(parent, 'LeadCommentsFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#CommentsRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('LeadsCommentsSearchFilterForm', 'LeadCommentsFilterAjaxResult', 'alert-success', rslt.msg, 1500);
            $("form#LeadsCommentsSearchFilterForm input#comments_start_date").val('');
            $("form#LeadsCommentsSearchFilterForm input#comments_end_date").val('');
            $("form#LeadsCommentsSearchFilterForm")[0].reset();
            setTimeout(function () {
                dataTable.ajax.reload();
            }, 2000);
        }
    }
</script>
