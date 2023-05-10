<?php

use App\Models\Crud;

?>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2C Vouchers
                    <?php
                        if($CheckAccess['umrah_travel_check_b2c_voucher_add_voucher']){?>
                            <a type="button" class="btn btn_customized  btn-sm float-right"
                               href="<?=SeoUrl('agent/add_b2c_voucher')?>">Add Voucher
                            </a>
                        <?php }?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="VoucherSearchFilter">
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
                                                <div class="col-md-3">
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
                                                        <label for="country">Agent Name</label>
                                                        <input type="text" class="form-control" name="agentname" id="agentname"
                                                               value="<?=( (isset($session['VoucherSearchFilter']['agentname'])) ? $session['VoucherSearchFilter']['agentname'] : '' )?>"
                                                               placeholder="Agent Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Voucher #</label>
                                                        <input type="text" class="form-control" name="vouchercode" id="vouchercode"
                                                               value="<?=( (isset($session['VoucherSearchFilter']['vouchercode'])) ? $session['VoucherSearchFilter']['vouchercode'] : '' )?>"
                                                               placeholder="Voucher Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-3" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('VoucherSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('VoucherSearchFilter'); return false;"
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
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Created Date</th>
                                <th>Voucher Reg. ID</th>
                                <th>Voucher Code</th>
                                <th>Arrival</th>
                                <th>Return</th>
                                <th>Total Nights</th>
                                <th>Arrival Mode</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($Vouchers as $voucher) {
                                $cnt++;
                                if ($voucher['AgentParentID'] > 0) {
                                    $Crud = new Crud();
                                    $table = 'main."Agents"';
                                    $where = array("UID" => $voucher['AgentUID']);
                                    $Name = $Crud->SingleRecord($table, $where);
                                    $SubAgentName = $Name['FullName'];

                                    $where = array("UID" => $voucher['AgentParentID']);
                                    $MainAgentName = $Crud->SingleRecord($table, $where);
                                    $AgentName = $MainAgentName['FullName'];

                                } else {
                                    $SubAgentName = '-';
                                    $AgentName = $voucher['AgentName'];
                                }
                                $days = '';
                                $days = date_diff(date_create($voucher['ArrivalDate']), date_create($voucher['ReturnDate']));
                                $days = $days->days;
                                echo '
                                <tr>       
                                    <td>' . $cnt . '</td>
                                    <td>' . CountryName($voucher['AgentCountryID']) . '</td>
                                    <td>' . DATEFORMAT($voucher['CreatedDate']) . '</td>
                                    <td>' . Code('UF/V/', $voucher['UID']) . '</td>
                                    <td><a href="' . SeoUrl('exports/b2c_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">' . $voucher['VoucherCode'] . '</a></td>
                                    <td>' . $voucher['ArrivalDate'] . '</td>
                                    <td>' . $voucher['ReturnDate'] . '</td>
                                    <td>' . $days . ' Nights</td>
                                    <td>' . $voucher['ArrivalType'] . '</td>
                                    <td>' . $voucher['CurrentStatus'] . '</td>
                                    <td>' . ((isset($voucher['CompanyName'])) ? $voucher['CompanyName'] : '-') . '</td>
                                    <td>' . ((isset($voucher['ReferenceName'])) ? $voucher['ReferenceName'] : '-') . '</td>
                                    <td>';
                                        if( $CheckAccess['umrah_travel_check_b2c_voucher_edit'] ||
                                            $CheckAccess['umrah_travel_check_b2c_voucher_change_status'] ||
                                            $CheckAccess['umrah_travel_check_b2c_voucher_print'] ||
                                            $CheckAccess['umrah_travel_check_b2c_voucher_update_history'] ||
                                            $CheckAccess['umrah_travel_check_b2c_voucher_add_refund']
                                        ){
                                            echo'<div class="btn-group">
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
                                                    if( $CheckAccess['umrah_travel_check_b2c_voucher_edit'] ){
                                                        echo'<a class="dropdown-item" href="' . SeoUrl('agent/edit_b2c_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '">Update</a>';
                                                    }
                                                    if($CheckAccess['umrah_travel_check_b2c_voucher_change_status']){
                                                        echo'<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/change_voucher_status_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Change Status</a>';
                                                    }
                                                    if($CheckAccess['umrah_travel_check_b2c_voucher_print']){
                                                        echo'<a class="dropdown-item" href="' . SeoUrl('exports/b2c_voucher/' . $voucher['UID'] . "-" . $voucher['VoucherCode']) . '" target="_blank">Print</a>';
                                                    }
                                                    if($CheckAccess['umrah_travel_check_b2c_voucher_update_history']){
                                                        echo'<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/log_history_modal\', ' . $voucher['UID'] . ', \'modal-xl\')" >Update History</a>';
                                                    }
                                                    if($CheckAccess['umrah_travel_check_b2c_voucher_add_refund']){
                                                        echo'<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/voucher/services_ziyarat_refund_modal\', ' . $voucher['UID'] . ', \'modal-lg\')">Add Refund</a>';
                                                    }
                                                echo'</div>
                                             </div>';
                                        }else{
                                            echo'-';
                                        }

                                    echo'</td>
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
<!--  END CONTENT AREA  -->
<script type="application/javascript">
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });

</script>