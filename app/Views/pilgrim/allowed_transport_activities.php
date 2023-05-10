<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Admin;
use App\Models\Voucher;

$VoucherPilgrim = new Voucher();
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Allow Transport Activities
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="PilgrimActivitiesSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters (in development
                                        )
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <?php
                                                        $selectedcountry = (($session['PilgrimActivitiesSearchFilter']['VoucherCountry']) ? $session['PilgrimActivitiesSearchFilter']['VoucherCountry'] : '');
                                                        ?>
                                                        <select class="form-control validate[required]"
                                                                id="VoucherCountry"
                                                                name="VoucherCountry"
                                                                data-prompt-position="bottomLeft:20,35"
                                                        >
                                                            <option value="">Please Select</option>
                                                            <?= Countries("html", $selectedcountry) ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent</label>
                                                        <?php
                                                        echo '<select class="form-control text-input" data-prompt-position="bottomLeft:20,35"  id="AgentID" name="AgentID" onChange="LoadAgentGirdByAgentID(this.value)"> <option value="">Please Select</option>';
                                                        foreach ($AllAgents as $agent) {
                                                            $selected = (($session['PilgrimActivitiesSearchFilter']['AgentID'] == $agent['UID']) ? 'selected' : '');
                                                            echo ' <option value="' . $agent['UID'] . '" ' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                        }

                                                        echo '</select>';

                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Allow Activities</label>
                                                        <select class="form-control validate[required]"
                                                                id="Activitiesxxxx"
                                                                name="Activities">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $AllowStatuses = array();
                                                            $AllowStatuses[] = 'Allow TPT Arrival';
                                                            $AllowStatuses[] = 'Allow HTL Mecca';
                                                            $AllowStatuses[] = 'Allow TPT Mecca(Chk/Out)';
                                                            $AllowStatuses[] = 'Allow HTL Medina';
                                                            $AllowStatuses[] = 'Allow TPT Medina(Chk/Out)';
                                                            $AllowStatuses[] = 'Allow HTL Jeddah';
                                                            $AllowStatuses[] = 'Allow TPT Jeddah(Chk/Out)';
                                                            $AllowStatuses[] = 'Free Bed';

                                                            foreach ($AllowStatuses as $value) {
                                                                $key = SeoUrl($value, false);
                                                                $selected = (($session['PilgrimActivitiesSearchFilter']['Activities'] == $key) ? 'selected' : '');
                                                                echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Actual Activities</label>
                                                        <select class="form-control validate[required]" id="Activities"
                                                                name="Activities">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $ignoreStatuses = array('elm-upload', 'return-to-country', 'with-transport-medina-uo', 'with-hotel-medina-uo',
                                                                'with-transport-mecca-uo', 'with-hotel-mecca-uo', 'arrival', 'with-transport-uo-arrival', 'travel-voucher-issued',
                                                                'travel-voucher-not-issued', 'visa-not-printed', 'visa-issued', 'without-mofa', 'with-mofa', 'mofa-issued', 'departure', 'exit-to-ksa', 'without-transport-arrival', 'without-hotel-arrival');
                                                            foreach ($Statuses as $key => $value) {
                                                                if (!in_array($key, $ignoreStatuses)) {
                                                                    $selected = (($session['PilgrimActivitiesSearchFilter']['Activities'] == $key) ? 'selected' : '');
                                                                    echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                                }
                                                            } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Dates</label>
                                                        <input type="date" class="form-control" name="VoucherDate"
                                                               id="VoucherDate"
                                                               placeholder="Dates"
                                                               value="<?= ((isset($session['PilgrimActivitiesSearchFilter']['VoucherDate'])) ? $session['PilgrimActivitiesSearchFilter']['VoucherDate'] : '') ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('PilgrimActivitiesSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('PilgrimActivitiesSearchFilter'); return false;"
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
                                    <table id="AllowTransportActivitiesRecord" class="table table-hover non-hover display nowrap"
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
                                        /*
                                                                                $cnt = 1;
                                                                                foreach ($records as $record) {
                                                                                    $Voucher_pilgrim = $VoucherPilgrim->CountAllowTransportVoucherListPilgrimStatus($record['VoucherID'], $record['UID']);

                                                                                    $activity_statuses = AllowTransportActivityStatuses();
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
                                                                                    $city = CityName($record['TravelCity']);

                                                                                    if ($city == 'Jeddah') {
                                                                                        $Action = '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-jeddah:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Jeddah</a>';
                                                                                    } else if ($city == 'Mecca') {
                                                                                        $Action = '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-mecca:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Mecca</a>';
                                                                                    } else if ($city == 'Medina') {
                                                                                        $Action = '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-medina:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Medina</a>';
                                                                                    } else if ($city == 'Yanbu') {
                                                                                        $Action = '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['VoucherID'] . ':allow-tpt-yanbu:' . $record['UID'] . '  \',\'modal-xl\');">Allow Transport Yanbu</a>';
                                                                                    }
                                                                                    $Action .= '<a class="dropdown-item" onclick="LoadModal(\'agent/voucher/refund_voucher_modal\',\'' .$record['UID'] .':transport \',\'modal-lg\');">Refund Voucher</a>';

                                                                                    echo '
                                                                                        <tr class="' . $class . '">
                                                                                            <td>' . $cnt . '</td>
                                                                                            <td>' . Code('UF/VAT/', $record['UID']) . '</td>
                                                                                            <td>' . Code('UF/V/', $record['VoucherID']) . '</td>
                                                                                            <td>' . $record['AgentName'] . '</td>
                                                                                            <td>' . $record['VoucherCode'] . '</td>
                                                                                            <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                                                                            <td>' . DATEFORMAT($record['ReturnDate']) . '</td>
                                                                                            <td>' . CountryName($record['Country']) . '</td>
                                                                                            <td>' . CityName($record['TravelCity']) . '</td>
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
                                                                                } */?>
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
    <!--  END CONTENT AREA  -->
    <script type="text/javascript" language="javascript">
        $(document).ready(function () {
            var dataTable = $('#AllowTransportActivitiesRecord').DataTable({
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
                    "lengthMenu": "Show _MENU_ Allow Transport Activities",
                    "info": "Showing _START_ to _END_ of _TOTAL_ Allow Transport Activities",
                },
                "ajax": {
                    url: "<?= $path ?>pilgrim/fetch_allowed_transport_activities",
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
