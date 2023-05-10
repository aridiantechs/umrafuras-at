<?php

use App\Models\Voucher;

?>
<link href="<?= $template ?>plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/widgets/modules-widgets.css">
<style>
    .loader-position {
        margin: 50% auto;
    }
</style>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <h4>Welcome "<?= $session['name'] ?>" as <?= $user_types[$session['type']] ?></h4>
            </div>
        </div>
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing" id="MainGroupStats">
                <div class="widget widget-five widget-table-one">
                    <div class="widget-content">
                        <div class="header">
                            <div class="header-body" style="width: 100%;">
                                <h6> Vouchers </h6>
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ref.ID</th>
                                            <th>Agent</th>
                                            <th>Voucher Code</th>
                                            <th>Arrival Date</th>
                                            <th>Return Date</th>
                                            <th>Country</th>
                                            <th width="160">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $Vocuhers = new Voucher();
                                        $data['records'] = $Vocuhers->VouchersAllList();
                                        //                                      echo"<pre>";  print_r($data['records']);
                                        $cnt = 0;
                                        foreach ($data['records'] as $record) {
                                            $Pilgrim = $Vocuhers->PilgrimData($record['UID']);
                                            $Pilgrims = $Vocuhers->PilgrimsList($Pilgrim['PilgrimUID']);
                                            $cnt++;
                                            echo '
                                     <tr>
                                    <td>' . $cnt . '</td>  
                                    <td>' . Code('UF/V/', $record['UID']) . '</td>  
                                    <td>' . $record['AgentName'] . '</td>                                 
                                    <td>' . $record['VoucherCode'] . '</td>
                                    <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                    <td>' . DATEFORMAT($record['ReturnDate']) . '</td>
                                    <td>' . CountryName($record['Country']) . '</td>
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
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="height: 255px; overflow: auto;">';
                                            $ignorStatuses = array('elm-upload');
                                            foreach ($DBStatuses as $key) {
                                                if (!in_array($key, $ignorStatuses)) {
                                                    echo '<a class="dropdown-item" onclick="LoadModal(\'pilgrim/status/index\',\'' . $record['UID'] . ':' . $key['Value'] . '\',\'modal-lg\');">' . $Statuses[$key['Value']] . '</a>';
                                                }
                                            }
                                            echo '</div>
                                       </div>
                                    </td>                                
                                  </tr>';
                                        } ?>
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
    <script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>
    <script type="application/javascript">
        $('#MainRecords').DataTable({
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
