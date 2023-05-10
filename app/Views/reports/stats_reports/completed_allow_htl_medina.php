<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Allow HTL Medina Completed
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/completed_allow_htl_medina" target="_blank">Export Records
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
                                        <div class="col-md-12 mx-auto">
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
                                                        <input type="text" class="form-control" name="Agent"
                                                               value=""
                                                               placeholder="Agent Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Hotel Category</label>
                                                        <input type="text" class="form-control" name="Hotel Category"
                                                               value=""
                                                               placeholder="Hotel Category">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Hotel Name</label>
                                                        <input type="text" class="form-control" name="Hotel Name"
                                                               value=""
                                                               placeholder="Hotel Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">CheckIn Date</label>
                                                        <input type="text" class="form-control multidate validate[required,future[now]]"
                                                               name="CheckInDate" id="CheckInDate" readonly
                                                               placeholder="" value=""
                                                        >

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
                                <th>Voucher No</th>
                                <th>Chk in Date </th>
                                <th>Chk in Time</th>
                                <th>City</th>
                                <th>Hotel Name</th>
                                <th>Room Type</th>
                                <th>PAX</th>
                                <th>BEDS</th>
                                <th>Nights</th>
                                <th>Actl Hotel</th>
                                <th>Room No</th>
                                <th>Actl Bed</th>
                                <th>Actl Arrvl Time</th>
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
                            $cnt=0;
                            foreach ($records as $record) {
                                $cnt++;
                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords( $record['LeaderPilgrimUID'] );
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'],'allow-htl-medina-status');
                                //echo '<pre>';print_r($PilgrimLastActivity);
                                $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'],'allow-htl-medina');
                                //echo '<pre>';print_r($PilgrimCurrentActivity);
                                if ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-actual-Hotel'] > 0) {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-actual-Hotel'], 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-package-Hotel'], 'Name', 0);
                                }
                                $ActivityUserName = UserNameByID($PilgrimCurrentActivity['LastActivitySystemUser']);

                                $CheckInTime1=$PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-actual-arrival-time'];
                                if ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-origin']=='mecca') {
                                    $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 6 hours'));

                                }elseif ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-origin']=='yanbu'){
                                    $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 6 hours'));

                                }elseif ($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-origin']=='jeddah'){

                                    $CheckInTime = date('H:i:s',strtotime($CheckInTime1. ' + 4 hours'));
                                }
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>
                                <td>' . $record['CountryName'] . '</td> 
                                <td>' . $record['IATANAME'] . '</td> 
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-brn-no']) : '-' ).'</td> 
                                <td>' . $record['VoucherCode'] . '</td> 
                                <td>'.( (isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-' ).'</td>                              
                                <td>'.( (isset($CheckInTime)) ? TIMEFORMAT($CheckInTime) : '-' ).'</td>
                                <td>'.( (isset($record['CityName'])) ? $record['CityName'] : '-' ).'</td> 
                                <td>'.( (isset($record['HotelName'])) ? $record['HotelName'] : '-' ).'</td> 
                                <td>'.( (isset($record['RoomType'])) ? $record['RoomType'] : '-' ).'</td> 
                                <td>'.$record['TotalPilgrims'].'</td>                               
                                <td>'.((isset($record['NoOfBeds']))?$record['NoOfBeds']:'-').'</td> 
                                <td>'.((isset($record['Nights']))?$record['Nights']:'-').'</td>                             
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-room-no'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-no-of-bed'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-actual-arrival-time']) : '-' ).'</td>                           
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-origin'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-origin'] : '-' ).'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords']['allow-htl-medina-contact-number'] : '-' ).'</td>                             
                                <td>' . ( (isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-' ) . '</td>
                                <td>'.( (isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-' ).'</td>    
                                <td>' . ((isset($ActivityUserName)) ? $ActivityUserName : '-') . '</td>
                                <td>'.( (isset($record['CurrentStatus'])) ? ucfirst(str_replace("status","",str_replace("-"," ",$record['CurrentStatus']))) : '-' ).'</td>
                                                          
                                 
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
        $('<a href="<?=$path?>exports/completed_allow_htl_medina" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);


</script>
