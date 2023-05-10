<?php
$session = session();
$SessionFilters = $session->get('PaxInSaudiArabiaSessionFilters');
$Country = $Agent = $VoucherNo = $HTLCategory = $CheckInStartDate = $CheckInEndDate = '';
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $Country = $SessionFilters['country'];
}

if (isset($SessionFilters['agent']) && $SessionFilters['agent'] != '') {
    $Agent = $SessionFilters['agent'];
}

if( isset($SessionFilters['voucher_no']) && trim($SessionFilters['voucher_no']) != '' ){
    $VoucherNo = $SessionFilters['voucher_no'];
}

if( isset($SessionFilters['htl_category']) && trim($SessionFilters['htl_category']) != '' ){
    $HTLCategory = $SessionFilters['htl_category'];
}

if( isset($SessionFilters['checkin_start_date']) && $SessionFilters['checkin_start_date'] != '' ){
    $CheckInStartDate = $SessionFilters['checkin_start_date'];
}

if( isset($SessionFilters['checkin_end_date']) && $SessionFilters['checkin_end_date'] != '' ){
    $CheckInEndDate = $SessionFilters['checkin_end_date'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">PAX In Saudi Arabia
                    <?php if ($CheckAccess['umrah_reports_status_stats_export_pax_in_saudiarabia']) { ?>
                    <a type="button" class="btn btn_customized  btn-sm float-right"
                       onclick="" href="<?= $path ?>exports/pax_in_saudi_arabia" target="_blank">Export Records
                    </a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="PaxInSaudiArabiaSearchFilter">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="PaxInSaudiArabiaSessionFilters">
                    <input type="hidden" name="checkin_start_date" id="checkin_start_date" value="<?=$CheckInStartDate?>">
                    <input type="hidden" name="checkin_end_date" id="checkin_end_date" value="<?=$CheckInEndDate?>">
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
                                                <label for="">Country</label>
                                                <select class="form-control" id="country"
                                                        name="country">
                                                    <option value="">Please Select</option>
                                                    <?= Countries('html', $Country) ?>
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
                                                <label for="">V.No</label>
                                                <input value="<?=$VoucherNo?>" type="text" class="form-control" id="voucher_no"
                                                       name="voucher_no"
                                                       placeholder="Voucher NO">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Hotel Category</label>
                                                <input value="<?=$HTLCategory?>" type="text" class="form-control" id="htl_category"
                                                       name="htl_category"
                                                       placeholder="Hotel Category">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">CheckIn Date</label>
                                                <input type="text" class="form-control multidate"
                                                       name="checkin_date" id="checkin_date"
                                                       placeholder="CheckIn Dates" value=""
                                                       onchange="GetCheckInDate();">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="FilterButtons">
                                            <div class="form-group float-right">
                                                <button onclick="PaxInSaudiArabiaFiltersFormSubmit( 'PaxInSaudiArabiaSearchFilter' );" id="btnsearch" type="button" class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick="ClearSession('PaxInSaudiArabiaSessionFilters');" id="btnreset" type="button" class="btn btn-danger">Clear
                                                    Filter
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
                        <table id="PaxInSaudiArabiaRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>BRN</th>
                                <th>V. No</th>
                                <th>Hotel Category</th>

                                <th>City</th>
                                <th>Actl Hotel</th>
                                <th>Room Type</th>
                                <th>Room No</th>
                                <th>PAX</th>
                                <th>Actl BEDS</th>
                                <th>Chk in Date</th>
                                <th>Chk in Time</th>

                                <th>Chk Out Date</th>
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
                            <?php /*
                            $Pilgrims = new \App\Models\Pilgrims();
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
                                $PilgrimMetaRecords = $Pilgrims->PilgrimMetaRecords($record['LeaderPilgrimUID']);
                                //echo '<pre>';print_r($PilgrimMetaRecords);
                                $PilgrimLastActivity = PilgrimLastActivity($record['LeaderPilgrimUID'],$record['CurrentStatus'].'-status');
                                 //echo '<pre>';print_r($PilgrimLastActivity);
                                $PilgrimCurrentActivity = PilgrimCurrentActivity($record['LeaderPilgrimUID'],$record['CurrentStatus']);
                                //echo '<pre>';print_r($PilgrimCurrentActivity);
                                if($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel']>0){

                                    $ActualHotel= HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-Hotel'],'Name',1);
                                }else{
                                    $ActualHotel= HotelName($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-package-Hotel'],'Name',0);
                                }
                                $Checkintime='';
                                $Arrivalpos= strpos($PilgrimLastActivity['LastActivity'],"arrival");
                                if($Arrivalpos>0){
                                    $Checkintime=date('H:i:s',strtotime($PilgrimLastActivity['LastActivityRecordTime']. ' + 4 hours'));

                                    // $Checkintime + 4hours
                                }else{
                                    if($PilgrimLastActivity['LastActivity']=='check-out-medina'){
                                        //$Checkintime = date('H:i:s',strtotime($PilgrimLastActivity['ActivityRecords']['check-out-medina-time']. ' + 6 hours'));
                                        // $Checkintime + 6hours
                                    }
                                }
                                $Category = 'B2B';
                                if ($record['IATAType'] == 'external_agent') {
                                    $Category = 'External Agent';
                                }
                                $datetime1 = new DateTime($record['CheckINDate']);

                                $datetime2 = new DateTime($PilgrimMetaRecords[$record['CurrentStatus'].'-out-date']);

                                $difference = $datetime1->diff($datetime2);
                                if ($record['CurrentStatus'] == 'check-in-mecca') {
                                    $checkin = 'mecca';
                                } else if ($record['CurrentStatus'] == 'check-in-medina') {
                                    $checkin = 'medina';
                                } else if ($record['CurrentStatus'] == 'check-in-jeddah') {
                                    $checkin = 'jeddah';
                                }
                                if($PilgrimCurrentActivity['CurrentActivity']=='check-in-mecca'){
                                    $HotelCity = 'Mecca';
                                }else if ($PilgrimCurrentActivity['CurrentActivity'] == 'check-in-medina') {
                                    $HotelCity = 'Medina';
                                } else if ($PilgrimCurrentActivity['CurrentActivity'] == 'check-in-jeddah') {
                                    $HotelCity = 'Jeddah';
                                }

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                 
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['IATANAME'] . '</td> 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no'])) ? BRNCode($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-brn-no']) : '-') . '</td>                            
                                      <td>' . $record['VoucherCode'] . '</td> 
                                      <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                  
                                    <td>' . ((isset($HotelCity)) ? $HotelCity : '-') . '</td> 
                                    <td>' . ((isset($ActualHotel)) ? $ActualHotel : '-') . '</td>     
                                    <td>' . ((isset($record['RoomType'])) ? $record['RoomType'] : '-') . '</td>     
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-room-no'] : '-') . '</td>                                
                                    <td>' . $record['TotalPilgrim']. '</td>                                                                          
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-no-of-bed'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-no-of-bed'] : '-') . '</td> 
                                    <td>' . ((isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-') . '</td>               
                                    <td>'.( (isset($Checkintime)) ? TIMEFORMAT($Checkintime) : '-' ).'</td>    
                                    <td>'.( (isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date'])) ? DATEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-out-date']) : '-' ).'</td>                                      
                                    <td>'.$difference->d.'</td>                                                                           
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-arrival-time'])) ? TIMEFORMAT($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-actual-arrival-time']) : '-') . '</td>               
                                    <td>'.ucwords(str_replace('-',' ',$PilgrimLastActivity['LastActivity'])).'</td>         
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-contact-number'])) ? $PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-contact-number'] : '-') . '</td>             
                                    <td>'.$Category.'</td>             
                                    <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>                                 
                                    <td>' . ((isset($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id'])) ? UserNameByID($PilgrimCurrentActivity['ActivityRecords'][$PilgrimCurrentActivity['CurrentActivity'].'-user-id']) : '-') . '</td>
                                    <td>' . ((isset($record['CurrentStatus'])) ? ucwords(str_replace('-',' ',$record['CurrentStatus'])) : '-') . '</td>                                 
                                </tr> ';


//                                echo '
//                                <tr>
//                                <td>'.$cnt.'</td>
//                                <td>' . $record['CountryName'] . '</td>
//                                <td>' . $record['IATANAME'] . '</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-brn-no'])) ? $PilgrimMetaRecords['check-in-'.$checkin.'-brn-no'] : '-' ).'</td>
//                                <td>' . ( (isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-' ) . '</td>
//                                <td>' . $record['PilgrimUID'] . '</td>
//                                <td>'.( (isset($record['CheckINDate'])) ? DATEFORMAT($record['CheckINDate']) : '-' ).'</td>
//                                <td>N/A</td>
//                                <td>' . $record['CityName'] . '</td>
//                                <td>'.( (isset($record['HotelName'])) ? $record['HotelName'] : '-' ).'</td>
//                                <td>'.( (isset($record['RoomType'])) ? $record['RoomType'] : '-' ).'</td>
//                                <td>'.$record['FullName'].'</td>
//                                <td>'.((isset($record['NoOfBeds']))?$record['NoOfBeds']:'-').'</td>
//                                <td>'.((isset($record['Nights']))?$record['Nights']:'-').'</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-actual-Hotel'])) ? HotelName($PilgrimMetaRecords['check-in-'.$checkin.'-actual-Hotel']) : '-' ).'</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-room-no'])) ? $PilgrimMetaRecords['check-in-'.$checkin.'-room-no'] : '-' ).'</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-no-of-bed'])) ? $PilgrimMetaRecords['check-in-'.$checkin.'-no-of-bed'] : '-' ).'</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-actual-arrival-time'])) ? TIMEFORMAT($PilgrimMetaRecords['check-in-'.$checkin.'-actual-arrival-time']) : '-' ).'</td>
//                                <td>N/A</td>
//                                <td>'.( (isset($PilgrimMetaRecords[$checkin.'-arrival-contact-number'])) ? $PilgrimMetaRecords[$checkin.'-arrival-contact-number'] : '-' ).'</td>
//                                <td>N/A</td>
//                                <td>'.( (isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-' ).'</td>
//                                <td>' . ((isset($record['SystemUser']))? $record['SystemUser']: '-'). '</td>
//                                <td>'.( (isset($PilgrimMetaRecords['check-in-'.$checkin.'-status'])) ? $PilgrimMetaRecords['check-in-'.$checkin.'-status'] : '-' ).'</td>
//
//
//                                </tr> ';
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

        setTimeout(function () {
            $("#checkin_start_date").val('');
            $("#checkin_end_date").val('');
        }, 1000);

        var dataTable = $('#PaxInSaudiArabiaRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Pax In Saudi Arabia Report",
                "info": "Showing _START_ to _END_ of _TOTAL_ Pax In Saudi Arabia Report",
            },
            "ajax": {
                url: "<?= $path ?>reports/fetch_pax_in_saudi_arabia_report",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
    });

    function GetCheckInDate() {
        const CheckInDate = $("#checkin_date").val();
        const words = CheckInDate.split(' to ');
        $("#checkin_start_date").val(words[0]);
        $("#checkin_end_date").val(words[1]);
    }

    function PaxInSaudiArabiaFiltersFormSubmit(parent){

        var dataTable = $('#PaxInSaudiArabiaRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if(rslt.status == 'success'){
            dataTable.ajax.reload();
        }
    }

    function ClearSession(SessionKey){

        var dataTable = $('#PaxInSaudiArabiaRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey );
        if(rslt.status == 'success'){
            $("form#PaxInSaudiArabiaSearchFilter")[0].reset();
            $("form#PaxInSaudiArabiaSearchFilter input#checkin_start_date").val('');
            $("form#PaxInSaudiArabiaSearchFilter input#checkin_end_date").val('');
            dataTable.ajax.reload();
        }
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

    <?php if ($CheckAccess['umrah_reports_status_stats_export_pax_in_saudiarabia']) { ?>
    setTimeout(function () {
        $('<a href="<?=$path?>exports/pax_in_saudi_arabia" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);
    <?php } ?>
</script>
