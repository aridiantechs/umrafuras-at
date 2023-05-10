<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;
use App\Models\Admin;
use App\Models\Voucher;

$Crud = new Crud();
$VoucherPilgrim = new Voucher();
$Crud = new Crud();

$session = session();
$SessionFilters = $session->get('ActualTransportSessionFilters');
$CheckOutDateTo = $CheckOutDateFrom = $CheckInDateFrom = $CheckInDateTo = '';
$Completed = 'no';
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
if (isset($SessionFilters['transport']) && $SessionFilters['transport'] != '') {
    $Transport = $SessionFilters['transport'];
}
if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
    $travel_type = $SessionFilters['travel_type'];
}
if (isset($SessionFilters['Sector']) && $SessionFilters['Sector'] != '') {
    $Sector = $SessionFilters['Sector'];
}
//if (isset($SessionFilters['travel_type']) && $SessionFilters['travel_type'] != '') {
//    $travel_type = $SessionFilters['travel_type'];
//}
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
                <h4 class="page-head">Actual Transport Activities For Pilgrims
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="ActualTransportActivitesFiltersFormSubmit('ActualTransportActivitesSearchFiltersForm'); return false;"
                      class="section contact" id="ActualTransportActivitesSearchFiltersForm">
                    <input type="hidden" name="SessionKey" id="SessionKey" value="ActualTransportSessionFilters">
                    <input type="hidden" name="arrival_date_from" id="arrival_date_from"
                           value="<?= $ArrivalDateFrom ?>">
                    <input type="hidden" name="arrival_date_to" id="arrival_date_to" value="<?= $ArrivalDateTo ?>">
                    <input type="hidden" name="return_date_from" id="return_date_from" value="<?= $ReturnDateFrom ?>">
                    <input type="hidden" name="return_date_to" id="return_date_to" value="<?= $ReturnDateTo ?>">
                    <form class="section contact" id="">
                        <div id="toggleAccordion">
                            <div class="card">
                                <div class="card-header">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="" data-toggle="collapse"
                                             data-target="#FilterDetails" aria-expanded="false"
                                             aria-controls="FilterDetails">
                                            Filters (in development
                                            )
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
                                                            >
                                                                <option value="">Please Select Country</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="transport">Transport</label>
                                                            <select class="form-control" id="transport"
                                                                    name="transport">
                                                                <option value="">Please Select</option>
                                                                <?php
                                                                $data['LookupsOptions'] = $Crud->LookupOptions('transport_types');
                                                                foreach ($data['LookupsOptions'] as $options) {
                                                                    $selected = (($Transport == $options['UID']) ? 'selected' : '');
                                                                    echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                }
                                                                ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="travel_type">Travel Type</label>

                                                            <select class="form-control" id="travel_type"
                                                                    name="travel_type">
                                                                <option value="">Please Select</option>
                                                                <option value="Arrival" <?= (($travel_type == 'Arrival') ? 'selected' : '') ?>>
                                                                    Arrival
                                                                </option>
                                                                <option value="Departure" <?= (($travel_type == 'Departure') ? 'selected' : '') ?>>
                                                                    Departure
                                                                </option>
                                                                <option value="Checkout" <?= (($travel_type == 'Checkout') ? 'selected' : '') ?>>
                                                                    Checkout
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="Sector">Sector</label>
                                                            <select class="form-control" id="Sector"
                                                                    name="Sector">
                                                                <option value="">Please Select</option>
                                                                <?php
                                                                $data['LookupsOptions'] = $Crud->LookupOptions('transport_sectors');
                                                                foreach ($data['LookupsOptions'] as $options) {
                                                                    $selected = (($Sector == $options['UID']) ? 'selected' : '');
                                                                    echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="arrival_date">Arrival Date</label>
                                                            <input onchange="GetArrivalDate();" type="text"
                                                                   class="form-control multidate"
                                                                   name="arrival_date" id="arrival_date">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="return_date">Return Date</label>
                                                            <input onchange="GetReturnDate();" type="text"
                                                                   class="form-control multidate"
                                                                   name="return_date" id="return_date">
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
                                                         id="ActualTransportActivitesAjaxResult"></div>
                                                    <div class="col-md-12" id="FilterButtons">
                                                        <div class="form-group float-right">
                                                            <button onclick="ActualTransportActivitesFiltersFormSubmit('ActualTransportActivitesSearchFiltersForm');"
                                                                    id="btnsearch" type="button"
                                                                    class="btn btn-success">
                                                                Search
                                                            </button>
                                                            <button onclick="ClearSession('ActualTransportSessionFilters');"
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

                    </form>
            </div>

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">
                        <div class="header"><?php
                            $session = session();
                            $session = $session->get();

                            $PilgrimActivitiesSearchFilter = $session['PilgrimActivitiesSearchFilter'];
                            //print_r($PilgrimActivitiesSearchFilter); ?>
                            <div class="header-body" style="width: 100%;">
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <table id="ActualTransportActivitiesRecord"
                                           class="table table-hover non-hover display nowrap"
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
                                            <th>Travel City</th>
                                            <th>Travel Type</th>
                                            <th>Travel Date</th>
                                            <th>Sector</th>
                                            <th>Transport</th>
                                            <th>No Of Seats</th>
                                            <th>PAX in Voucher</th>
                                            <th>Allowed PAX</th>
                                            <th width="160">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        /*                                        //echo"<pre>";  print_r($data['records']);
                                                                                $cnt = 1;
                                                                                foreach ($records as $record) {
                                                                                    $Voucher_pilgrim = $VoucherPilgrim->CountActualTransportVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);
                                                                                    $CityName = CityName($record['TravelCity']);

                                                                                    //print_r($activity_statuses);
                                                                                    $class = '';

                                                                                    if (isset($PilgrimActivitiesSearchFilter['Activities']) && $PilgrimActivitiesSearchFilter['Activities'] != '') {
                                                                                        if (isset($activity_statuses[$PilgrimActivitiesSearchFilter['Activities']])) {

                                                                                        } else {
                                                                                            $class = 'd-none hide';
                                                                                            $cnt--;
                                                                                        }
                                                                                    } else {

                                                                                    }
                                                                                    $Action = '';
                                                                                    if ($record['TotalPax'] == count($Voucher_pilgrim)) {
                                                                                        $class = 'alert alert-success mb-4';
                                                                                    }

                                                                                    if ($record['TravelType'] == 'Arrival') {
                                                                                        $ArrivalActivityStatuses = ArrivalActivityStatuses($CityName);
                                                                                        foreach ($ArrivalActivityStatuses as $key => $value) {
                                                                                            $Action .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':'. $record['UID'].':actual \',\'modal-xl\');">' . $value . '</a>';

                                                                                        }
                                                                                    } else if ($record['TravelType'] == 'Checkout') {
                                                                                        $CheckOutActivityStatuses = CheckOutActivityStatuses($CityName);
                                                                                        foreach ($CheckOutActivityStatuses as $key => $value) {
                                                                                            $Action .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':'. $record['UID'].':actual \',\'modal-xl\');">' . $value . '</a>';
                                                                                        }
                                                                                    } else if ($record['TravelType'] == 'Departure') {
                                                                                        $DepartureActivityStatuses = DepartureActivityStatuses($CityName);
                                                                                        foreach ($DepartureActivityStatuses as $key => $value) {
                                                                                            $Action .= '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':'. $record['UID'].':actual \',\'modal-xl\');">' . $value . '</a>';
                                                                                        }
                                                                                    }
                                                                                    $Action .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' .$record['UID'] .':transport \',\'modal-lg\');">Refund Voucher</a>';

                                                                                    echo '
                                                                                        <tr class="' . $class . '">
                                                                                            <td>' . $cnt . '</td>
                                                                                            <td>' . Code('UF/VTA/', $record['UID']) . '</td>
                                                                                            <td>' . Code('UF/V/', $record['VoucherID']) . '</td>
                                                                                            <td>' . $record['AgentName'] . '</td>
                                                                                            <td>' . $record['VoucherCode'] . '</td>
                                                                                            <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                                                                            <td>' . DATEFORMAT($record['ReturnDate']) . '</td>
                                                                                            <td>' . CountryName($record['Country']) . '</td>
                                                                                            <td>' . $CityName . '</td>
                                                                                            <td>' . $record['TravelType'] . '</td>
                                                                                            <td>' . DATEFORMAT($record['TravelDate']) . '</td>
                                                                                            <td>' . $record['SectorName'] . '</td>
                                                                                            <td>' . $record['TransportTypeName'] . '</td>
                                                                                            <td>' . $record['NoOfSeats'] . '</td>
                                                                                            <td>' . $record['TotalPax'] . '</td>
                                                                                            <td>' . count($Voucher_pilgrim) . '</td>
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
                                                                                    echo $Action;
                                        //                                            foreach ($activity_statuses as $key => $value) {
                                        //                                                echo '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':' . $key . ':'. $record['UID'] .'  \',\'modal-xl\');">' . $value . '</a>';
                                        //                                            }
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
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function () {

            var SessionReturnDateFrom = "<?= $ReturnDateFrom ?>";
            var SessionReturnlDateTo = "<?= $ReturnDateTo ?>";
            $("#return_date_from").val(SessionReturnDateFrom);
            $("#return_date_to").val(SessionReturnlDateTo);
            if (SessionReturnDateFrom != '' && SessionReturnlDateTo != '') {
                $("#return_date").val(SessionReturnDateFrom + " to " + SessionReturnlDateTo);
            }
            var SessionArrivalDateFrom = "<?= $ArrivalDateFrom ?>";
            var SessionArrivalDateTo = "<?= $ArrivalDateTo ?>";
            $("#arrival_date_from").val(SessionArrivalDateFrom);
            $("#arrival_date_to").val(SessionArrivalDateTo);
            if (SessionArrivalDateFrom != '' && SessionArrivalDateTo != '') {
                $("#arrival_date").val(SessionArrivalDateFrom + " to " + SessionArrivalDateTo);
            }
        }, 1000);

        var dataTable = $('#ActualTransportActivitiesRecord').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "responsive": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Actual Transport Activities",
                "info": "Showing _START_ to _END_ of _TOTAL_ Actual Transport Activities",
            },
            "ajax": {
                url: "<?= $path ?>pilgrim/fetch_actual_transport_activities",
                type: "POST"
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
        /*$("#btnsearch").click(function () {

            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#PilgrimSearchFilter')[0].reset();
            dataTable.ajax.reload();  //just reload table
        });*/

    });


    function ActualTransportActivitesFiltersFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('filters_session/create_filters_session', data);
        if (rslt.status == 'success') {

            GridMessages(parent, 'ActualTransportActivitesAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function ClearSession(SessionKey) {

        var rslt = AjaxResponse('filters_session/clear_filters_session', 'SessionKey=' + SessionKey);
        if (rslt.status == 'success') {
            GridMessages('ActualTransportActivitesSearchFiltersForm', 'ActualTransportActivitesAjaxResult', 'alert-success', rslt.msg, 250);
            setTimeout(function () {
                location.reload();
            }, 500);
        }
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?= $City ?>");
        $("#city").html('<option value="">Please Select</option>' + cities.html);

    }


    function LoadAgentsByCountry(country) {
        Agents = AjaxResponse("html/GetAgentsByCountry", "country=" + country + "&selected=<?= $Agents ?>");
        $("#CountryAgent").html('<option value="">Please Select</option>' + Agents.html);

    }

    function GetArrivalDate() {
        const Date = $("#arrival_date").val();
        const words = Date.split(' to ');
        $("#arrival_date_from").val(words[0]);
        $("#arrival_date_to").val(words[1]);
    }

    function GetReturnDate() {
        const Date = $("#return_date").val();
        const words = Date.split(' to ');
        $("#return_date_from").val(words[0]);
        $("#return_date_to").val(words[1]);
    }

    setTimeout(function () {
        LoadCitiesDropdown('<?=$country?>');
        LoadAgentsByCountry('<?=$country?>');
    }, 2500);


</script>
<!-- <script type="application/javascript">
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
