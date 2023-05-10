<!--  BEGIN CONTENT AREA  -->
<style>
    table.cell-border thead th, table.cell-border tbody td {
        border: 0.5px solid #DDA420;
        border-collapse: collapse;
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Free Bed
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_free_bed']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?=$path?>exports/allow_bed" target="_blank">Export Records
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
                                                <div class="col-md-12 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">City</label>
                                                                <input type="text" class="form-control" name="Valid"
                                                                       value=""
                                                                       placeholder="City">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Actual Hotel</label>
                                                                <input type="text" class="form-control" name="Actual Hotel"
                                                                       value=""
                                                                       placeholder="Actual Hotel ">
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
                        </div>

                    </div>

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap cell-border" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>BRN</th>
                                <th>Hotel Name</th>
                                <th>City</th>
                                <th>Room No</th>
                                <th>Actual Bed </th>
                                <th>Used Bed </th>
                                <th>Remaining Bed </th>
                                <th>Check In </th>
                                <th>Check Out </th>
                                <th>Nights</th>
                                <th>System User</th>
                                <th>Status</th>
                                <th>Actions</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt=0;
                            foreach ($records as $record) {
                                $cnt++;
                                $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'],str_replace('-status','',$record['CurrentStatus']));
                                //echo '<pre>';print_r($PilgrimCurrentActivity);
                                if ($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'] > 0) {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'], 'Name', 1);
                                    $HotelCity = CityName(HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'], 'CityID', 1), 'Name', 1);
                                } else {
                                    $ActualHotel = HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-package-Hotel'], 'Name', 0);
                                    $HotelCity = CityName(HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-package-Hotel'], 'CityID', 0), 'Name', 0);
                                }
                                $datetime1 = new DateTime($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-in-date']);

                                $datetime2 = new DateTime($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date']);

                                $difference = $datetime1->diff($datetime2);
                                echo '
                                <tr>
                                <td>'.$cnt.'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no']) : '-' ).'</td>                             
                                <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td>  
                                <td>' . ((isset($HotelCity)) ? $HotelCity : '-') . '</td>
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'] : '-' ).'</td>
                                <td>'.$record['NoOfBed'].'</td> 
                                <td>'.$record['TotalPilgrim'].'</td>                            
                                <td>'.$record['FeeBeds'].'</td>                             
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-in-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-in-date']) : '-' ).'</td>                                                        
                                <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date']) : '-' ).'</td>                                                        
                                <td>'.$difference->d.'</td>                                                          
                                <td>'.$record['SystemUser'].'</td>                                                         
                                <td>'.( (isset($record['CurrentStatus'])) ? ucfirst(str_replace("status","",str_replace("-"," ",$record['CurrentStatus']))) : '-' ).'</td>                                                        
                                <td>N/A</td>                                                         
                                                                                        
                                  
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_free_bed']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/allow_bed" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>
</script>
