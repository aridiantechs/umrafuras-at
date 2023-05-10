<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Voucher Issue Report
                    <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_issue_export']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/voucher_issue_report" target="_blank">Export Records
                    </a> <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="VoucherIssueSearchFilter">
                    <input type="hidden" name="create_date_from" id="create_date_from" value="">
                    <input type="hidden" name="create_date_to" id="create_date_to" value="">
                    <input type="hidden" name="issue_date_from" id="issue_date_from" value="">
                    <input type="hidden" name="issue_date_to" id="issue_date_to" value="">
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
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Voucher#</label>
                                                        <input type="text" class="form-control" id="voucher_code"
                                                               name="voucher_code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Create Date</label>
                                                        <input onchange="GetCreateDate();" type="text"
                                                               class="form-control multidate"
                                                               name="create_date" id="create_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Issue Date</label>
                                                        <input onchange="GetIssueDate();" type="text"
                                                               class="form-control multidate"
                                                               name="issue_date" id="issue_date">
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="VouchersIssueRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Voucher Ref.ID</th>
                                <th>V. No</th>
                                <th>Issue Date</th>
                                <th>Issue Time</th>
                                <th>HTL Category</th>
                                <th>HTL Name</th>

                                <th>PAX</th>
                                <th>No Of beds</th>
                                <th>MAK Nights</th>
                                <th>MED Nights</th>
                                <th>JED Nights</th>
                                <th>TOTAL Nights</th>

                                <th>TPT Type</th>
                                <th>Category</th>
                                <th>Reference</th>



                            </tr>
                            </thead>
                            <tbody>
                            <?php /*                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                echo '
                                <tr>
                                <td>' . $cnt . '</td>
                             <!--   <td>' . Code('UF/P/', $record['UID']) . '</td>
                                 <td>' . Code('UF/A/', $record['AgentID']) . '</td>                              
                                 <td>N/A</td>
                                <td>' . $record['VoucherCode'] . '</td>
                                 <td>' . DATEFORMAT($record['IssueDate']) . '</td>
                                <td>' . $record['GroupName'] . '</td>      
                                <td>' . $record['PilgrimFullName'] . '</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>                            
                                <td>' . $record['Nationality'] . '</td>                             
                                <td>' . $record['PackageName'] . '</td>                            
                                <td>' . $record['CityName'] . '</td> 
                                <td>N/A</td> 
                                <td>' . $record['MOFANumber'] . '</td>                            
                                <td>' . $record['VisaNumber'] . '</td> 
                                   -->
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>' . $record['CountryName'] . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>'.Code('UF/V/', $record['UID']).'</td>
                                <td>'.$record['VoucherCode'].'</td>
                                <td>'.DATEFORMAT($record['CreatedDate']).'</td>
                                <td>N/A</td>
                                <td>'.$record['HotelCategory'].'</td>
                                <td>'.$record['HotelName'].'</td>
                                <td>'.$record['TotalPilgrim'].'</td>
                                <td>'.$record['NoOfBeds'].'</td>
                                <td>'.$record['MeccaNights'].'</td>
                                <td>'.$record['MedinaNights'].'</td>
                                <td>'.$record['JeddahNights'].'</td>
                                <td>'.$record['TotalNights'].'</td>
                                <td>'.$record['TypeOFTransport'].'</td>                                                    
                                <td>' . ucfirst(str_replace("_"," ",$record['IATAType'])). '</td>
                                <td>' . $record['ReferenceName'] . '</td>                             
                                 
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

        setTimeout(function (){
            $("#create_date_from").val('');
            $("#create_date_to").val('');
            $("#issue_date_from").val('');
            $("#issue_date_to").val('');
        }, 1000);

        var dataTable = $('#VouchersIssueRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Vouchers Issue Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Vouchers Issue Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_voucher_issue_report",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.voucher_code = $('#voucher_code').val();
                    data.create_date_from = $('#create_date_from').val();
                    data.create_date_to = $('#create_date_to').val();
                    data.issue_date_from = $('#issue_date_from').val();
                    data.issue_date_to = $('#issue_date_to').val();
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
            $('#VoucherIssueSearchFilter')[0].reset();
            $("#create_date_from").val('');
            $("#create_date_to").val('');
            $("#issue_date_from").val('');
            $("#issue_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetCreateDate() {
        const Date = $("#create_date").val();
        const words = Date.split(' to ');
        $("#create_date_from").val(words[0]);
        $("#create_date_to").val(words[1]);
    }

    function GetIssueDate() {
        const Date = $("#issue_date").val();
        const words = Date.split(' to ');
        $("#issue_date_from").val(words[0]);
        $("#issue_date_to").val(words[1]);
    }
</script>
<script type="application/javascript">


    /*$('#ReportTable').DataTable({
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

    <?php if ($CheckAccess['umrah_reports_stats_voucher_voucher_issue_export']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/voucher_issue_report" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100); <?php } ?>

</script>
