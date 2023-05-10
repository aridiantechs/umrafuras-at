<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Admin;
use App\Models\Voucher;
use App\Models\Agents;


$AgentsModel = new Agents();
$AllAgents = $AgentsModel->AllAgentList();
$VoucherPilgrim = new Voucher();


$session = session();
$SessionFilters = $session->get('AllowHotelSessionFilters');
$Completed = 'no';
$CheckInDateFrom = $CheckInDateTo = '';
//echo "xxxxxxxxxxxxxxxx";
//print_r($SessionFilters);
//echo "yyyyyyyyyyyyyyyyyy";exit;
//echo "xxxxxxxxxxxxxxxx";
//echo $SessionFilters['check_in_date_from']. "___________";
//echo $SessionFilters['check_in_date_to']. "___________";
//echo $SessionFilters['check_out_date_to']. "___________";
//echo $SessionFilters['arrival_date_from']. "___________";
//echo $SessionFilters['arrival_date_to']. "___________";
//echo $SessionFilters['return_date_from']. "___________";
//echo $SessionFilters['return_date_to']. "___________";
//echo "yyyyyyyyyyyyyyyyyy";

if (isset($SessionFilters['completed']) && $SessionFilters['completed'] != '') {
    $Completed = $SessionFilters['completed'];
}
if (isset($SessionFilters['VoucherId']) && $SessionFilters['VoucherId'] != '') {
    $VoucherId = $SessionFilters['VoucherId'];
}
if (isset($SessionFilters['AgentCountry']) && $SessionFilters['AgentCountry'] != '') {
    $AgentCountry = $SessionFilters['AgentCountry'];
}
if (isset($SessionFilters['Agents']) && $SessionFilters['Agents'] != '') {
    $Agents = $SessionFilters['Agents'];
}
if (isset($SessionFilters['country']) && $SessionFilters['country'] != '') {
    $country = $SessionFilters['country'];
}
if (isset($SessionFilters['City']) && $SessionFilters['City'] != '') {
    $City = $SessionFilters['City'];
}
if (isset($SessionFilters['hotel']) && $SessionFilters['hotel'] != '') {
    $hotel = $SessionFilters['hotel'];
}
if (isset($SessionFilters['check_in_date_from']) && $SessionFilters['check_in_date_from'] != '') {
    $CheckInDateFrom = $SessionFilters['check_in_date_from'];
}
if (isset($SessionFilters['check_in_date_to']) && $SessionFilters['check_in_date_to'] != '') {
    $CheckInDateTo = $SessionFilters['check_in_date_to'];
}
if (isset($SessionFilters['check_out_date_from']) && $SessionFilters['check_out_date_from'] != '') {
    $CheckOutDateFrom = $SessionFilters['check_out_date_from'];
}
if (isset($SessionFilters['check_out_date_to']) && $SessionFilters['check_out_date_to'] != '') {
    $CheckOutDateTo = $SessionFilters['check_out_date_to'];
}
if (isset($SessionFilters['arrival_date_from']) && $SessionFilters['arrival_date_from'] != '') {
    $ArrivalDateFrom = $SessionFilters['arrival_date_from'];
}
if (isset($SessionFilters['arrival_date_to']) && $SessionFilters['arrival_date_to'] != '') {
    $ArrivalDateTo = $SessionFilters['arrival_date_to'];
}
if (isset($SessionFilters['return_date_from']) && $SessionFilters['return_date_from'] != '') {
    $ReturnDateFrom = $SessionFilters['return_date_from'];
}
if (isset($SessionFilters['return_date_to']) && $SessionFilters['return_date_to'] != '') {
    $ReturnDateTo = $SessionFilters['return_date_to'];
}
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Allow Hotel Activities
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form method="post"
                      onsubmit="AllowHotelActivitiesFiltersFormSubmit('AllowHotelActivitiesSearchFiltersForm'); return false;"
                      class="section contact" id="AllowHotelActivitiesSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="AllowHotelSessionFilters">
                    <input type="hidden" name="check_in_date_from" id="check_in_date_from"
                           value="<?= $CheckInDateFrom ?>">
                    <input type="hidden" name="check_in_date_to" id="check_in_date_to" value="<?= $CheckInDateTo ?>">
                    <input type="hidden" name="check_out_date_from" id="check_out_date_from"
                           value="<?= $CheckOutDateFrom ?>">
                    <input type="hidden" name="check_out_date_to" id="check_out_date_to" value="<?= $CheckOutDateTo ?>">
                    <input type="hidden" name="arrival_date_from" id="arrival_date_from"
                           value="<?= $ArrivalDateFrom ?>">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to" value="<?= $ArrivalDateTo ?>">
                    <input type="hidden" name="return_date_from" id="return_date_from" value="<?= $ReturnDateFrom ?>">
                    <input type="hidden" name="return_date_to" id="return_date_to" value="<?= $ReturnDateTo ?>">

                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
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
                                                                <label for="VoucherId">Voucher ID</label>
                                                                <input type="text" class="form-control" id="VoucherId"
                                                                       name="VoucherId" placeholder="Voucher ID"
                                                                       value="<?= $VoucherId ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Agent Country </label>
                                                                <select class="form-control" id="AgentCountry"
                                                                        name="AgentCountry"
                                                                        onchange="LoadAgentsByCountry(this.value);">
                                                                    <option value="">Please Select</option>
                                                                    <?= Countries('html', $AgentCountry) ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="Agents">Agents</label>
                                                                <select class="form-control" id="CountryAgent"
                                                                        name="Agents">
                                                                    <option value="">Please Select Agent Country
                                                                    </option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Country </label>
                                                                <select class="form-control" id="country"
                                                                        name="country"
                                                                        onChange="LoadCitiesDropdown(this.value)">
                                                                    <option value="">Please Select</option>
                                                                    <?= Countries('html', $country) ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="City">City</label>
                                                                <select class="form-control" id="city"
                                                                        name="City"
                                                                        onChange="LoadHotelsByCity(this.value)">
                                                                    <option value="">Please Select Country</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="hotel">Hotels</label>
                                                                <select class="form-control" id="HotelsSelect"
                                                                        name="hotel">
                                                                    <option value="">Please Select City</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="arrival_date">Arrival Date</label>
                                                                <input onchange="GetArrivalDates();" type="text"
                                                                       class="form-control multidate"
                                                                       name="arrival_date" id="arrival_dates">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="return_date">Return Date</label>
                                                                <input onchange="GetReturnDates();" type="text"
                                                                       class="form-control multidate"
                                                                       name="return_date" id="return_dates">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Check In Date</label>
                                                                <input onchange="GetCheckInDates();" type="text"
                                                                       class="form-control multidate"
                                                                       name="check_in_date" id="check_in_dates">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Check Out Date</label>
                                                                <input onchange="GetCheckOutDates();" type="text"
                                                                       class="form-control multidate "
                                                                       name="check_out_date" id="check_out_dates">
                                                            </div>
                                                        </div>


                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="country">Completed</label>
                                                                <select class="form-control" id="completed"
                                                                        name="completed">
                                                                    <option value="">Please Select</option>
                                                                    <option value="yes" <?= (($Completed == 'yes') ? 'selected' : '') ?>>
                                                                        Yes
                                                                    </option>
                                                                    <option value="no" <?= (($Completed == 'no') ? 'selected' : '') ?>>
                                                                        No
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12"
                                                             id="AllowHotelActivitiesAjaxResult"></div>
                                                        <div class="col-md-12" id="FilterButtons">
                                                            <div class="form-group float-right">
                                                                <button onclick="AllowHotelActivitiesFiltersFormSubmit('AllowHotelActivitiesSearchFiltersForm');"
                                                                        id="btnsearch" type="button"
                                                                        class="btn btn-success">
                                                                    Search
                                                                </button>
                                                                <button onclick="ClearSession('AllowHotelSessionFilters');"
                                                                        id="btnreset" type="button"
                                                                        class="btn btn-danger">Clear
                                                                    Filter
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
                    <?php
                    /*                            $session = session();
                                                $session = $session->get();
                                                $PilgrimActivitiesSearchFilter = $session['PilgrimActivitiesSearchFilter'];*/ ?>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="AllowHotelActivitiesRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Voucher ID</th>
                                <th>Agent</th>
                                <th>Voucher Code</th>
                                <th>Arrival Date</th>
                                <th>Return Date</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Hotel</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Nights</th>
                                <th>No Of Beds</th>
                                <th>Room Type</th>
                                <th>PAX in Voucher</th>
                                <th>PAX in Activity</th>
                                <th>Allowed PAX</th>
                                <th width="160">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- --><?php
                            /*                                        $cnt = 1;
                                                                    foreach ($records as $record) {

                                                                        $days = '-';
                                                                        $CheckIn = ($record['CheckIn']);
                                                                        $CheckOut = ($record['CheckOut']);
                                                                        if ($CheckIn != '' && $CheckIn != '') {
                                                                            $days = date_diff(date_create($CheckIn), date_create($CheckOut));
                                                                            $days = $days->days;
                                                                        }
                                                                        //$Voucher_pilgrim = $VoucherPilgrim->CountAllowHotelVoucherListPilgrimStatus($record['VoucherID'],$record['UID']);

                                                                        $class = '';
                                                                        if (isset($PilgrimActivitiesSearchFilter['Activities']) && $PilgrimActivitiesSearchFilter['Activities']!='' ) {
                                                                            if(isset($activity_statuses[$PilgrimActivitiesSearchFilter['Activities']])){
                                                                            } else{
                                                                                $class = 'd-none hide';$cnt--;
                                                                            }
                                                                        } else {

                                                                        }
                                                                        if ($record['TotalPax'] > 0) {
                                                                            if ($record['TotalPax'] == $record['Voucher_pilgrim']) {
                                                                                $class = 'alert alert-success mb-4';
                                                                            }
                                                                        }

                                                                        echo '
                                                                            <tr class="'.$class.'">
                                                                                <td>' . $cnt . '</td>
                                                                                <td>' . Code('UF/VAH/', $record['UID']) . '</td>
                                                                                <td>' . Code('UF/V/', $record['VoucherID']) . '</td>
                                                                                <td>' . $record['AgentName'] . '</td>
                                                                                <td>' . $record['VoucherCode'] . '</td>
                                                                                <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                                                                <td>' . DATEFORMAT($record['ReturnDate']) . '</td>
                                                                                <td>' . $record['Country'] . '</td>
                                                                                <td>' . $record['CityName'] . '</td>
                                                                                <td>' . $record['HotelName'] . '</td>
                                                                                <td>' . DATEFORMAT($record['CheckIn']) . '</td>
                                                                                <td>' . DATEFORMAT($record['CheckOut']) . '</td>
                                                                                <td>' . $days.'</td>
                                                                                <td>' . $record['NoOfBeds'] . '</td>
                                                                                <td>' . $record['RoomTypeName'] . '</td>
                                                                                <td>' . $record['TotalPax'] . '</td>
                                                                                <td>' . $record['Voucher_pilgrim'] . '</td>
                                                                                     <td>
                                                                                    <div class="btn-group">
                                                                                        <button type="button"
                                                                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                                                                id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                                                                aria-expanded="false" data-reference="parent">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                                                 class="feather feather-chevron-down">
                                                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                                                            </svg>
                                                                                        </button>
                                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                                                        if($record['CityName'] == 'Mecca')  {
                                                                            echo '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-mecca:'. $record['UID'].' \',\'modal-xl\');">Allow Hotel Mecca</a>';
                                                                        }else if($record['CityName'] == 'Medina') {
                                                                            echo '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-medina:'. $record['UID'].' \',\'modal-xl\');">Allow Hotel Medina</a>';
                                                                        }else if($record['CityName'] == 'Jeddah') {
                                                                            echo '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-htl-jeddah:'. $record['UID'].' \',\'modal-xl\');">Allow Hotel Jeddah</a>';

                                                                        }
                                                                        echo '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' .$record['UID'] .':accommodation \',\'modal-lg\');">Refund Voucher</a>';

                                                                        echo '
                                                                                        </div>
                                                                                   </div>
                                                                                </td>
                                                                              </tr>';
                                                                        $cnt++;
                                                                    } */ ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$City?>");
        $("#city").html('<option value="">Please Select</option>' + cities.html);

    }

    function LoadHotelsByCity(city) {
        hotels = AjaxResponse("html/GetHotelsByCity", "city=" + city + "&selected=<?=$hotel?>");
        $("#HotelsSelect").html('<option value="">Please Select</option>' + hotels.html);

    }

    function LoadAgentsByCountry(country) {
        Agents = AjaxResponse("html/GetAgentsByCountry", "country=" + country + "&selected=<?=$Agents?>");
        $("#CountryAgent").html('<option value="">Please Select</option>' + Agents.html);

    }


    $(document).ready(function () {

        setTimeout(function () {
            var SessionCheckInDateFrom = "<?=$CheckInDateFrom?>";
            var SessionCheckInDateTo = "<?=$CheckInDateTo?>";
            $("#check_in_date_from").val(SessionCheckInDateFrom);
            $("#check_in_date_to").val(SessionCheckInDateTo);
            if (SessionCheckInDateFrom != '' && SessionCheckInDateTo != '') {
                $("#check_in_dates").val(SessionCheckInDateFrom + " to " + SessionCheckInDateTo);
            }

            var SessionCheckOutDateFrom = "<?=$CheckOutDateFrom?>";
            var SessionCheckOutDateTo = "<?=$CheckOutDateTo?>";
            $("#check_out_date_from").val(SessionCheckOutDateFrom);
            $("#check_out_date_to").val(SessionCheckOutDateTo);
            if (SessionCheckOutDateFrom != '' && SessionCheckOutDateTo != '') {
                $("#check_out_dates").val(SessionCheckOutDateFrom + " to " + SessionCheckOutDateTo);
            }

            var SessionArrivalDateFrom = "<?=$ArrivalDateFrom?>";
            var SessionArrivalDateTo = "<?=$ArrivalDateTo?>";
            $("#arrival_date_from").val(SessionArrivalDateFrom);
            $("#arrival_date_to").val(SessionArrivalDateTo);
            if (SessionArrivalDateFrom != '' && SessionArrivalDateTo != '') {
                $("#arrival_dates").val(SessionArrivalDateFrom + " to " + SessionArrivalDateTo);
            }

            var SessionReturnDateFrom = "<?=$ReturnDateFrom?>";
            var SessionReturnlDateTo = "<?=$ReturnDateTo?>";
            $("#return_date_from").val(SessionReturnDateFrom);
            $("#return_date_to").val(SessionReturnlDateTo);
            if (SessionReturnDateFrom != '' && SessionReturnlDateTo != '') {
                $("#return_dates").val(SessionReturnDateFrom + " to " + SessionReturnlDateTo);
            }
        }, 1000);

        var dataTable = $('#AllowHotelActivitiesRecord').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "responsive": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "ordering": true,
            "order": [[1, 'asc']],
            "language": {
                "lengthMenu": "Show _MENU_ Allow Hotel Activities",
                "info": "Showing _START_ to _END_ of _TOTAL_ Allow Hotel Activities",
            },
            "ajax": {
                url: "<?= $path ?>pilgrim/fetch_allow_hotel_activities",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "targets": [0, 3, 4],
                },
            ],
        });
    });


    function GetArrivalDates() {
        const Date = $("#arrival_dates").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function GetReturnDates() {
        const Date = $("#return_dates").val();
        const words = Date.split(' to ');
        $("#return_date_from").val(words[0]);
        $("#return_date_to").val(words[1]);
    }

    function GetCheckInDates() {

        var Date = $("#check_in_dates").val();
        var words = Date.split(' to ');
        $("input#check_in_date_from").val(words[0]);
        $("input#check_in_date_to").val(words[1]);
    }

    function GetCheckOutDates() {
        const Date = $("#check_out_dates").val();
        const words = Date.split(' to ');
        $("#check_out_date_from").val(words[0]);
        $("#check_out_date_to").val(words[1]);
    }

    function AllowHotelActivitiesFiltersFormSubmit(parent) {

        var dataTable = $('#AllowHotelActivitiesRecord').DataTable();
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'AllowHotelActivitiesAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                // dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var dataTable = $('#AllowHotelActivitiesRecord').DataTable();
        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('AllowHotelActivitiesSearchFiltersForm', 'AllowHotelActivitiesAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                // dataTable.ajax.reload();
                location.reload();
            }, 500);
        }
    }

    setTimeout(function () {
        LoadCitiesDropdown('<?=$country?>');
        LoadHotelsByCity('<?=$City?>');
        LoadAgentsByCountry('<?=$country?>');
    }, 2500);


</script>
<!--<script type="application/javascript">
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
</script>-->
