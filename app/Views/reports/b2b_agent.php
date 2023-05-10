<!--  BEGIN CONTENT AREA  -->

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2B Agents
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/b2b_agent" target="_blank"> Export Record
                    </a>
                </h4>

            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class=" " data-toggle="collapse"
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
                                                    <div class="form-group">
                                                        <label for="country">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                               value=""
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Email</label>
                                                        <input type="email" class="form-control" name="email"
                                                               value=""
                                                               placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Phone Number</label>
                                                        <input type="number" class="form-control" name="phone_number"
                                                               value=""
                                                               placeholder="Phone Number" min="1">
                                                    </div>
                                                </div>

                                                <div class="col-md-3" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters(); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('AgentSearchFilter'); return false;"
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
                        <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent Reg. ID</th>
                                <th>Full Name</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>IATA</th>
                                <th>Umrah Agreement</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Website Domain</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                
                                    <td>' . Code('UF/A/', $record['UID']) . '</td> 
                                    <td>' . $record['FullName'] . ' ' . $record['LastName'] . '</td>
                                    <td>' . $record['ContactPersonName'] . '</td>
                                    <td>' . $record['PhoneNumber'] . '</td>
                                    <td>' . $record['Email'] . '</td>                            
                                    <td>' . $record['IATALicense'] . '</td>                              
                                    <td>' . $record['UmrahAgreement'] . '</td>
                                    <td>' . CountryName($record['CountryID']) . '</td>                    
                                    <td>' . CityName($record['CityID']) . '</td>
                                    <td>' . DomainName($record['WebsiteDomain']) . '</td>                        
                                
                                </tr>';
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
<!--  END CONTENT AREA  -->
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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });


    setTimeout(function () {
        $('<a href="<?=$path?>exports/b2b_agent" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>