<!--  BEGIN CONTENT AREA  -->

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Check In Medina
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_check_in_medina']) { ?>
                        <a type="button" class="btn btn_customized  btn-sm float-right"
                           onclick="" href="<?= $path ?>exports/check_in_medina" target="_blank">Export Records
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
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">IATA</label>
                                                        <input class="form-control" id="IATA" name="IATA"
                                                               placeholder="IATA" type="text"
                                                               value="">
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


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">CheckIn Date</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="CheckInDate" id="CheckInDate" readonly
                                                               placeholder="" value=""
                                                        >

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
                                                    <div class="form-group">
                                                        <label for="country">ACTL Hotel</label>
                                                        <input type="text" class="form-control" name="ACTLHotel"
                                                               value=""
                                                               placeholder="ACTL Hotel">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Origan</label>
                                                        <input type="text" class="form-control" name="Origan"
                                                               value=""
                                                               placeholder="Origan">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Category</label>
                                                        <input class="form-control" id="Category" name="Category"
                                                               placeholder="Category"
                                                               value="">
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
                                                        <button onclick=""
                                                                class="btn btn-success">Display Records
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
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>V. No</th>
                                <th>HTL Category</th>
                                <th>City</th>
                                <th>Actl Hotel</th>
                                <th>Room Type</th>
                                <th>Room No</th>
                                <th>Pax</th>

                                <th>Actl Beds</th>
                                <th>CHK In Date</th>
                                <th>CHK In Time</th>
                                <th>Check Out Date</th>
                                <th>Nights</th>
                                <th>Actl Arrival Time</th>
                                <th>Origin</th>
                                <th>PAX Mob. No</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>System User</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $Pilgrims = new \App\Models\Pilgrims();
                            $cnt = 0;
                            $Grand = array();
                            foreach ($records as $record) {

                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'], 'check-in-medina-status');
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                if ($PilgrimMetaRecords['check-in-medina-actual-Hotel'] > 0) {

                                    $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-actual-Hotel'], 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimMetaRecords['check-in-medina-package-Hotel'], 'Name', 0);
                                }
                                $Checkintime = '';
                                $Arrivalpos = strpos($PilgrimLastActivity['LastActivity'], "arrival");
                                if ($Arrivalpos > 0) {
                                    $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['LastActivityRecordTime'] . ' + 4 hours'));
                                    // $Checkintime + 4hours
                                } else {
                                    if ($PilgrimLastActivity['LastActivity'] == 'check-out-mecca') {
                                        $Checkintime = date('H:i:s', strtotime($PilgrimLastActivity['ActivityRecords']['check-out-mecca-time'] . ' + 6 hours'));
                                        // $Checkintime + 6hours
                                    }
                                }
                                //echo $Checkintime;
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }

                                $ActivityUserName = UserNameByID($PilgrimLastActivity['ActivityRecords'][$PilgrimLastActivity['LastActivity'] . '-user-id']);

                                $Grand['TotalPax'] += $record['TotalPilgrim'];
                                $Grand['TotalBeds'] += $PilgrimMetaRecords['check-in-medina-no-of-bed'];
                                $Grand['TotalNights'] += $record['Nights'];

                                $cnt++;
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td>
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-brn-no'])) ? BRNCode($PilgrimMetaRecords['check-in-medina-brn-no']) : '-') . '</td>  
                                    <td>' . $record['VoucherCode'] . '</td>                        
                                    <td>' . $record['HotelCategory'] . '</td>                                
                                    <td>' . $record['HotelCityName'] . '</td>
                                    <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td> 
                                    <td>' . $record['RoomType'] . '</td>
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-room-no'])) ? $PilgrimMetaRecords['check-in-medina-room-no'] : '-') . '</td>    
                                    <td>' . $record['TotalPilgrim'] . '</td>
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-no-of-bed'])) ? $PilgrimMetaRecords['check-in-medina-no-of-bed'] : '-') . '</td>                             
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-in-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-medina-in-date']) : '-') . '</td>
                                    <td>' . ((isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-') . '</td>
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-out-date'])) ? DATEFORMAT($PilgrimMetaRecords['check-in-medina-out-date']) : '-') . '</td>
                                    <td>' . $record['Nights'] . '</td>    
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-medina-actual-arrival-time']) : '-') . '</td>                             
                                    <td>' . ucwords(str_replace('-', ' ', $PilgrimLastActivity['LastActivity'])) . '</td>                             
                                    <td>' . ((isset($PilgrimMetaRecords['check-in-medina-contact-number'])) ? $PilgrimMetaRecords['check-in-medina-contact-number'] : '-') . '</td>                           
                                    <td>' . ucfirst(str_replace("_", " ", $record['IATAType'])) . '</td> 
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>    
                                    <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                    <td>Check In Medina</td>
                                </tr> ';
                            }
                            ?>
                            <tfoot>
                            <tr>
                                <td colspan="10"></td>
                                <td><?= $Grand['TotalPax'] ?></td>
                                <td><?= $Grand['TotalBeds'] ?></td>
                                <td colspan="3"></td>
                                <td><?= $Grand['TotalNights'] ?></td>
                                <td colspan="7"></td>
                            </tr>
                            </tfoot>

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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_check_in_medina']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/check_in_medina" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>
</script>
