<?php

use App\Models\Crud;

?>

<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> Agent Leads Distribution Report

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentLeadsDistributionFrom">
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
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group">-->
                                                <!--                                                        <label for="country">Start Date From To</label>-->
                                                <!--                                                        <input type="text"-->
                                                <!--                                                               class="form-control multidate validate[required,future[now]]"-->
                                                <!--                                                               name="FromTo" id="FromTo" readonly-->
                                                <!--                                                               placeholder="" value="">-->
                                                <!---->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Start Date From </label>
                                                        <input type="date"
                                                               class="form-control"
                                                               name="date" id="date"
                                                               placeholder="" value="<?php
                                                        if (isset($_GET['date']) && $_GET['date'] != '') {
                                                            echo date('Y-m-d', strtotime($_GET['date']));
                                                        } else {
                                                            echo date('Y-m-d');
                                                        }
                                                        ?>"
                                                        >
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
<!--                                                        <button id="multiple-messages"-->
<!--                                                                class=" btn btn-danger float-right">Clear-->
<!--                                                        </button>-->

                                                        <button id="multiple-messages"
                                                                onclick="AgentLeadsDistributionFormSubmit()"
                                                                class="mr-2 btn btn-success float-right">Apply
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
                    <div class="table-responsive mb-4 mt-4" style="overflow: auto;">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Agents</th>
                                <?php if (isset($_GET['date']) && $_GET['date'] != '') {
                                    $SetDate = $_GET['date'];
                                } else {
                                    $SetDate = '';
                                }
                                for ($i = 0; $i < 5; $i++) {
//                                    echo "<th>" . date('d-M-Y', strtotime("+$i days")) . "</th>";
                                    echo "<th>" . date('d-M-Y', strtotime($SetDate . "+$i days")) . "</th>";
                                    $TheadLoopEnd = $i;
                                }
                                ?> <th>Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $cnt = 0;
                            foreach ($records as $value) {
                                $cnt++; ?>
                                <tr>
                                    <td><?=$cnt?></td>
                                    <td><?=ucwords($value['FullName'])?></td>
                                    <?php
                                        for ($j = 0; $j <= $TheadLoopEnd; $j++) {
                                            echo '<td>-</td>';
                                        }
                                        ?> <td>0</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

    // $("form#AgentLeadsDistributionFrom").on("submit", function (event) {
    //     event.preventDefault();
    // });
    //
    // function AgentLeadsDistributionFormSubmit(){
    //    var FinalDate = $('#date').val();
    //    alert(FinalDate);
    // }


    //$('#ReportTable').DataTable({
    //    "scrollX": true,
    //    "oLanguage": {
    //        "oPaginate": {
    //            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
    //            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
    //        },
    //        "sInfo": "Showing page _PAGE_ of _PAGES_",
    //        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    //        "sSearchPlaceholder": "Search...",
    //        "sLengthMenu": "Results :  _MENU_",
    //    },
    //    "stripeClasses": [],
    //    "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
    //    "pageLength": 100
    //});
    //
    //setTimeout(function () {
    //    $('<a href="<?//=$path?>//" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    //}, 100);
    //      ' . ucwords(str_replace("Organic Platform", "", $allLookup['Name'])) . '


    //echo date('Y-m-d',strtotime('+1 day', strtotime('2007-02-28')));

    //      $date = "2015-11-17";
    //    echo date('Y-m-d', strtotime($date. ' + 5 days'));
    //
    <!--    --><?php //echo date('Y-m-d', strtotime("+5 days"));  ?>
</script>
