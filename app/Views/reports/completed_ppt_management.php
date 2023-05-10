<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Completed Passport Management Report
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/ppt_management" target="_blank">Export Records
                    </a>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Agent Name</label>
                                                <input type="text" class="form-control" name="AgentName"
                                                       value=""
                                                       placeholder="Agent Name ">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">From</label>
                                                <input type="date" class="form-control" name="From"
                                                       value=""
                                                       placeholder="From">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">To</label>
                                                <input type="date" class="form-control" name="To"
                                                       value=""
                                                       placeholder="To">
                                            </div>
                                        </div>

                                        <div class="col-md-6" id="FilterButtons">
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

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>Agent Name</th>
                                <th>Group Code</th>
                                <th>Group Name</th>
                                <th>PAX Name</th>
                                <th>PPT No.</th>
                                <th>DOB </th>
                                <th>MOFA No </th>
                                <th>VISA No. </th>
                                <th>Entry Date </th>
                                <th>Entry Time </th>
                                <th>Entry Port </th>
                                <th>Arrival Mode</th>
                                <th>Entry Carrier</th>
                                <th>Flight No.</th>
                                <th>Category</th>
                                <th>Reference </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php


                            $cnt=0;
                            foreach ($records as $record) {
                                $cnt++;


                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>                             
                                <td>' . Code('UF/A/', $record['AgentID']) . '</td>                             
                                <td>' . $record['IATANAME'] . '</td> 
                                <td>' . Code('UF/G/', $record['GroupID']) . '</td> 
                                <td>' . $record['GroupName'] . '</td> 
                                <td>' . $record['PilgrimFullName'] . '</td> 
                                <td>' . $record['PassportNumber'] . '</td>                            
                                <td>' . DATEFORMAT($record['DOB']) . '</td>                                                         
                                <td>' . $record['MOFANumber'] . '</td>                                                         
                                <td>' . $record['VisaNo'] . '</td>                                                         
                                <td>' . DATEFORMAT($record['EntryDate']) . '</td>                                                         
                                <td>' . TIMEFORMAT($record['EntryTime']) . '</td>                                                         
                                <td>' . $record['EntryPort'] . '</td>                                                         
                                <td>' . $record['ArrivalMode'] . '</td>                                                         
                                <td>' . $record['EntryCarrier'] . '</td>                                                         
                                <td>' . $record['FlightNo'] . '</td>       
                                <td>' . $Category . '</td>
                                                 
                                <td>' . $record['ReferenceName'] . '</td>                                                        
                                  </tr> ';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">


    $('#ReportTable').DataTable({
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
    });

    setTimeout(function () {
        $('<a href="<?=$path?>exports/ppt_management" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
