<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Visa Not Issue
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/visa_not_issue" target="_blank"> Export Record
                    </a>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="VisaNotIssuedStatsReportSearchFilter">
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
                                                <label for="country">Country</label>
                                                <select class="form-control validate[required]" id="Country"
                                                        name="Country">
                                                    <option value="">Please Select</option>
                                                    <?= Countries('html') ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Agent Name</label>
                                                <input class="form-control" id="Agent" name="Agent"
                                                       placeholder="Agent Name" type="text"
                                                       value="">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Group Name</label>
                                                <input class="form-control" id="Group" name="Group"
                                                       placeholder="Group Name"
                                                       value="<?= ((isset($session['B2CReportSearchFilter']['Group'])) ? $session['B2CReportSearchFilter']['Group'] : '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Category</label>
                                                <input class="form-control" id="Group" name="Categroy"
                                                       placeholder="Category"
                                                       value="<?= ((isset($session['B2CReportSearchFilter']['Categroy'])) ? $session['B2CReportSearchFilter']['Categroy'] : '') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">From</label>
                                                <input type="date" class="form-control" name="From"
                                                       value=""
                                                       placeholder="From">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">To</label>
                                                <input type="date" class="form-control" name="To"
                                                       value=""
                                                       placeholder="To">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
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
                                <th>EA Code </th>
                                <th>Country</th>
                                <th>Pilgrim. ID </th>

                                <th>Agent Name </th>
                                <th>Group Name </th>
                                <th>Pilgrim Name </th>
                                <th>Gender </th>
                                <th>P/p No </th>
                                <th>D.O.B</th>
                                <th>Nationality</th>
                                <th>HTL Category</th>
                                <th>City</th>

                                <th>Mofa No </th>
<!--                                <th>Mofa Issue Date</th>-->
                                <th>Category </th>
                                <th>Reference</th>


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
                                <td>' . $cnt . '</td>
                                  <td>' . Code('UF/A/', $record['AgentID']) . '</td>
                                    <td>' . $record['CountryName'] . '</td> 
                                <td>' . Code('UF/P/', $record['UID']) . '</td>                              
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['GroupName'] . '</td>   
                                <td>' . $record['PilgrimFullName'] .'</td>
                                <td>' . $record['Gender'] . '</td>
                                <td>' . $record['PassportNumber'] . '</td>
                                <td>' . DATEFORMAT($record['DOB']) . '</td>
                                <td>' . $record['Nationality'] . '</td>
                                <td>' . $record['HotelCategory'] .'</td>  
                                <td>' . $record['CityName'] . '</td>                             
                                <td>' . $record['MOFANumber'] . '</td>
                             <!--   <td>' . DATEFORMAT($record['IssueDate']) . '</td> -->
                                <td>'.$Category.'</td>
                                <td>' . $record['ReferenceName'] .'</td>
                                             
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
        $('<a href="<?=$path?>exports/visa_not_issue" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
