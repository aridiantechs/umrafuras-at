<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Tafeej Report
                    <?php if ($CheckAccess['umrah_reports_stats_extras_tafeej_report_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/tafeej_report" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
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
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">TPT Company</label>
                                                        <input type="text" class="form-control" name="TPT Company"
                                                               value=""
                                                               placeholder="TPT Company ">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">BRN</label>
                                                        <input type="text" class="form-control" name="BRN"
                                                               value=""
                                                               placeholder="BRN ">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">From  To</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="FromTo" id="FromTo" readonly
                                                               placeholder="" value=""
                                                        >

                                                    </div>
                                                </div>

                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('B2CReportSearchFilter'); return false;"
                                                                class="btn btn-success">Display Record
                                                        </button>
                                                        <button onclick="ClearFilters('B2CReportSearchFilter'); return false;"
                                                                class="btn btn-danger">Clear Filter
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>BRN</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Total PAX</th>
                                <th>Bus No</th>
                                <th>Driver #</th>
                                <th>TPT Company</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
/*                            for ($i = 1; $i < 12; $i++) {
                                echo '
                            <tr>
                            <td>' . $i . '</td>
                            <td>12 Jan, 2021</td>
                              <td>Dummy BRN Number</td>
                            <td>From</td>
                            <td>To</td>
                            <td>40</td>
                            <td>Bus No</td>
                            <td>Driver #</td> 
                            <td>TPT Company</td> 
                             <td>';

                                if($CheckAccess['umrah_reports_stats_export_tafeej_reports_print']){
                                    echo '<div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                <a class="dropdown-item" href="' . $path . 'exports/tafeej_report" target="_blank" onclick="">Print</a>
                                            </div>
                                        </div>';

                                }else{
                                    echo'-';
                                }

                                    echo ' </td>
                            </tr> ';
                            }

                            */?>


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


        //setTimeout(function () {
        //    var From = "<?//=$From?>//";
        //    var To = "<?//=$To?>//";
        //    $("#from").val(From);
        //    $("#to").val(To);
        //    if (From != '' && To != '') {
        //        $("#FromTo").val(From + " to " + To);
        //    }
        //}, 1000);

        var dataTable = $('#ReportTable').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Tafeej Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Tafeej Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_tafeej_report",
                type: "POST",
                data: function (data) {
                    //data.country = $('#country').val();
                    //data.agent = $('#agent').val();

                    //data.city = $('#city').val();


                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $("#from").val('');
            $("#to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetFromToDate() {

        const EntryDate = $("#FromTo").val();
        const words = EntryDate.split(' to ');
        $("#from").val(words[0]);
        $("#to").val(words[1]);
    }


    function TransportSummaryFormSubmit(parent) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'TransportSummaryAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                //dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        //var dataTable = $('#SeatLossRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {

            GridMessages('TransportSummaryForm', 'TransportSummaryAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                $("form#TransportSummaryForm input#from").val('');
                $("form#TransportSummaryForm input#to").val('');
                $("form#TransportSummaryForm")[0].reset();

                location.reload();
                //dataTable.ajax.reload();
            }, 500);
        }
    }
</script>
<script type="application/javascript">


   /* $('#ReportTable').DataTable({
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });*/

    <?php if ($CheckAccess['umrah_reports_stats_extras_tafeej_report_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/tafeej_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
