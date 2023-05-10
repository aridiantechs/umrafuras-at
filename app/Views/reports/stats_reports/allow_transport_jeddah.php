<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Allow TPT Jeddah
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_allow_tpt_jeddah_chk_out']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/allow_tpt_jeddah" target="_blank">Export Records
                        </a>
                    <?php } ?>
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

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">IATA</label>
                                                <input class="form-control" id="IATA" name="IATA"
                                                       placeholder="IATA" type="text"
                                                       value="<?= $IATA ?>">
                                            </div>
                                        </div>

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
                                                <label for="country">City</label>
                                                <input type="text" class="form-control" name="City"
                                                       value=""
                                                       placeholder="City">
                                            </div>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">CheckOut Date</label>
                                                <input type="text"
                                                       class="form-control multidate validate[required,future[now]]"
                                                       name="CheckOutDate" id="CheckOutDate" readonly
                                                       placeholder="" value=""
                                                >

                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group"><label for="country">Actual Hotel</label>
                                                <input type="text" class="form-control" name="Hotel" value=""
                                                       placeholder="Actual Hotel"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group"><label for="country">Destination</label>
                                                <input type="text" class="form-control" name="Destination"
                                                       value="" placeholder="Destination"></div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">TPT Type</label>
                                                <input type="text" class="form-control" name="TPTType"
                                                       value=""
                                                       placeholder="TPT Type">
                                            </div>
                                        </div>


                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Category</label>
                                                <input class="form-control" id="Category" name="Category"
                                                       placeholder="Category"
                                                       value="<?= $Category ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="country">Reference</label>
                                                <input type="text" class="form-control" name="Reference"
                                                       value=""
                                                       placeholder="Reference">
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
                                <th>Voucher No</th>
                                <th>Actual Hotel</th>
                                <th>Room Type</th>
                                <th>CHK Out Date</th>
                                <th>Pax</th>
                                <th>Seats</th>
                                <th>Destination</th>
                                <th>TPT Type</th>

                                <th>Category</th>
                                <th>Reference</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $Pilgrims = new \App\Models\Pilgrims();
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                //$PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'], 'allow-tpt-medina');
                                //echo '<pre>';print_r($PilgrimCurrentActivity);
                                if ($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-Hotel'] > 0) {

                                    $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-actual-Hotel'], 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-package-Hotel'], 'Name', 0);
                                }

                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td>
                                    <td>' . $record['VoucherCode'] . '</td>
                                    <td>' . ((isset($record['HotelName'])) ? $record['HotelName'] : '-') . '</td>
                                    <td>' . ((isset($record['RoomType'])) ? $record['RoomType'] : '-') . '</td>
                                    <td>' . ((isset($record['TravelDate'])) ? DATEFORMAT($record['TravelDate']) : '-') . '</td>
                                    <td>' . ((isset($record['TotalPilgrims'])) ? $record['TotalPilgrims'] : '-') . '</td>
                                    <td>' . ((isset($record['NoOfSeats'])) ? $record['NoOfSeats'] : '-') . '</td>
                                    <td>' . ((isset($record['SectorName'])) ? $record['SectorName'] : '-') . '</td>    
                                    <td>' . ((isset($record['TypeOFTransport'])) ? $record['TypeOFTransport'] : '-') . '</td>                      
                                                              
                                    <td>' . $Category . '</td>                           
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>
                                </tr> ';
                            }
                            ?>>
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_allow_tpt_jeddah_chk_out']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/completed_allow_tpt" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>

</script>
