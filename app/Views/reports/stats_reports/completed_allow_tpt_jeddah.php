<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Allow Transport Jeddah Completed
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/completed_allow_tpt_jeddah" target="_blank">Export Records
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
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group"><label for="country">Hotel Category</label>
                                                        <input type="text" class="form-control" name="Hotel Category"
                                                               value="" placeholder="Hotel Category"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group"><label for="country">Actual Hotel</label>
                                                        <input type="text" class="form-control" name="Hotel" value=""
                                                               placeholder="Actual Hotel"></div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group"><label for="country">Destination</label>
                                                        <input type="date" class="form-control" name="Destination"
                                                               value="" placeholder="Destination"></div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">CheckOut Date</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="CheckOutDate" id="CheckOutDate" readonly
                                                               placeholder="" value=""
                                                        >

                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="" class="btn btn-success">Display Records
                                                        </button>
                                                        <button onclick="" class="btn btn-danger">Clear Filter</button>
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
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>Voucher No</th>
                                <th>Actual Hotel</th>
                                <th>Room No</th>
                                <th>CHK Out Date</th>
                                <th>CHK Out Time</th>

                                <th>Pax</th>
                                <th>Seats</th>
                                <th>Actual Seats</th>
                                <th>Destination</th>
                                <th>TPT Type</th>
                                <th>Vehicle No</th>
                                <th>Driver Name</th>
                                <th>Driver Mob.</th>
                                <th>TPT Company</th>
                                <th>PAX Mob. No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>System User</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            $Pilgrims = new \App\Models\Pilgrims();
                            foreach ($records as $record) {
                                $cnt++;
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                $PilgrimID = $record['LeaderPilgrimUID'];
                                //$PilgrimMetaRecords = $PilgrimModel->ArrivalPilgrimLeaderMetaRecords($PilgrimID);
                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimMetaRecords);

                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'allow-tpt-jeddah-status');
                                //echo "<pre>";print_r($PilgrimLastActivity);
                                $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'check-in-jeddah',  $record['AID']);
                                //echo "<pre>";print_r($PilgrimCurrentActivity);
                                $PilgrimTransportActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'allow-tpt-jeddah',  $record['RID']);
                               // echo "<pre>";print_r($PilgrimTransportActivity);

                                if ($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'] > 0) {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'], 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-package-Hotel'], 'Name', 0);
                                }

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td>
                                    <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no']) : '-' ).'</td> 
                                    <td>' . $record['VoucherCode'] . '</td> 
                                    <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'] : '-') . '</td>
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date']) : '-') . '</td>
                                    <td>N/A</td>
                                    <td>' . $record['TotalPilgrims'] . '</td>
                                    <td>' . $record['NoOfSeats'] . '</td>
                                    
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-no-of-seats'])) ? $PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-no-of-seats'] : '-') . '</td>
                                    <td>Jeddah</td>
                                    <td>' . $record['TypeOFTransport'] . '</td>
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-vehicle-number'])) ? $PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-vehicle-number'] : '-') . '</td> 
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-driver-name'])) ? $PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-driver-name'] : '-') . '</td>                               
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-driver-contact-number'])) ? $PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-driver-contact-number'] : '-') . '</td> 
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-transport-company'])) ? OptionName($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-transport-company']) : '-') . '</td>                             
                                    <td>' . ((isset($PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-contact-number'])) ? $PilgrimTransportActivity['ActivityRecords'][$PilgrimTransportActivity['CurrentActivity'].'-contact-number'] : '-') . '</td> 
                                    <td>' . $Category . '</td>
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id'])) ? UserNameByID($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id']) : '-') . '</td>    
                                    <td>Allow TPT Medina</td>
                                    
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
        $('<a href="<?=$path?>exports/departure_hotel" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
