<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Deleted Groups
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact">
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
                                                        <label for="country">Full Name</label>
                                                        <input type="text" class="form-control" id="FullName"
                                                               placeholder="Full Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Operators</label>
                                                        <select class="form-control select2" id="operator"
                                                                name="operator">
                                                            <option value="">Please Select</option>
                                                            <?php

                                                            use App\Models\Groups;

                                                            foreach ($Operators as $Operator) {
                                                                echo '<option value="' . $Operator['UID'] . '">' . $Operator['FullName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group <?= (($AgentLogged) ? "d-none" : '') ?>">
                                                        <label for="country">Agents</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <option value="">Please Select</option><?php
                                                            foreach ($Agents as $Agent) {
                                                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group <?= (($AgentLogged) ? "d-none" : '') ?>">
                                                        <label for="country">Sub Agents</label>
                                                        <select class="form-control" id="SubAgents"
                                                                name="SubAgents">
                                                            <option value="">Please Select</option><?php
                                                            foreach ($SubAgents as $Agent) {
                                                                echo '<option value="' . $Agent['UID'] . '">' . $Agent['FullName'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick=""
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick=""
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
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Delete Date</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent</th>
                                <th>Group Code</th>
                                <th>Group Code (wtu)</th>
                                <th>Group Name</th>
                                <th>HTL Category</th>
                                <th>Total Pax</th>
                                <th>MAK Nights</th>
                                <th>Med Nights</th>
                                <th>Jed Nights</th>
                                <th>Total Nights</th>
                                <th>Arrival Date</th>
                                <th>Dep Date</th>
                                <th>TPT Type</th>
                                <th>Sector</th>
                                <th>Other Services</th>
                                <th>Total Payment</th>
                                <th>Category</th>
                                <th>Pilgrim In Group</th>
                                <th>Reference</th>


                                <!--                                <th>#</th>-->
                                <!--                                <th>Group Code</th>-->
                                <!--                                <th>Group Name</th>-->
                                <!--                                <th>Arrival Date</th>-->
                                <!--                                <th>Pilgrim Count</th>-->
                                <!--<th style="width:  15%;" <? /*=( ($AgentLogged) ? 'class="d-none"' : '' )*/ ?>>Agent</th>-->
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            $Total = 0;
                            foreach ($records as $record) {
                                $Total = $record['totalTransportRates'] + $record['totalHotelRates'] + $record['totalServiceRates'] + $record['TotalZiyaratRate'] + $record['TotalVisaRate'];

                                $Groups = new Groups();
                                $data['records'] = $Groups->CountGroupPilgrims($record['UID']);
                                $countrecords = count($data['records']);

//                                $totalRates = $record['totalHotelRates'] + $record['totalTransportRates'] + $record['totalServiceRates']+ $record['totalZiyratRates'];

                                $cnt++;
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                echo '
                                <tr> 
                                    <td>' . $cnt . '</td>
                                    <td>' . DATEFORMAT($record['DeleteDate']) . '</td>
                                    <td>' . DATEFORMAT($record['SystemDate']) . '</td>
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['Agentname'] . '</td>
                                    <td>' . Code('UF/G/', $record['UID']) . '</td>
                                    <td>' . $record['WTUCode'] . '</td>
                                    <td>' . $record['FullName'] . '</td>
                                    <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                    <td>' . $record['NoOfPAX'] . '</td>
                                    <td>' . ((isset($record['MeccaNights'])) ? $record['MeccaNights'] : '-') . '
                                    <br>[12 Feb 2021 - 13 Feb 2021 (2 Night)]
                                    <br>[12 Feb 2021 - 13 Feb 2021 (2 Night)]
                                    <br>[12 Feb 2021 - 13 Feb 2021 (2 Night)]
                                    </td>
                                    <td>' . ((isset($record['MedinaNights'])) ? $record['MedinaNights'] : '-') . '</td>
                                    <td>' . ((isset($record['JeddahNights'])) ? $record['JeddahNights'] : '-') . '</td>
                                    <td>' . ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-') . '</td>
                                    <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                    <td>' . DATEFORMAT($record['DepartureDate']) . '</td>
                                    <td>' . ((isset($record['TransportType'])) ? $record['TransportType'] : '-') . '</td>
                                    <td>' . ((isset($record['Sector'])) ? $record['Sector'] : '-') . '</td>
                                    <td>' . ((isset($record['OtherServices'])) ? $record['OtherServices'] : '-') . '</td>
                                    <td>  ' . Money($Total) . '</td>
                                    <td>' . $Category . '</td>
                                    <td>' . $countrecords . '</td>
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>
                                 </tr>';
                            } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">


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


</script>