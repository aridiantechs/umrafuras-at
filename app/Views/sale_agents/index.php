<?php

use App\Models\SaleAgent;

?>
<!--  BEGIN CONTENT AREA  -->

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Sale Agents
                    <?php
                        if($CheckAccess['umrah_client_sale_agents_add_new']){?>
                            <button type="button" class="btn btn_customized  btn-sm float-right"
                                    onclick="LoadModal('sale_agents/main_form', 0)">Add New
                            </button>
                    <?php    }
                    ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="SaleAgentSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                               value="<?= ((isset($session['SaleAgentSearchFilter']['name'])) ? $session['SaleAgentSearchFilter']['name'] : '') ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
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
                                                <!--                                                    <div class="col-md-3">-->
                                                <!--                                                        <div class="form-group">-->
                                                <!--                                                            <label for="country">Email</label>-->
                                                <!--                                                            <input type="email" class="form-control" name="email"-->
                                                <!--                                                                   value="-->
                                                <? //=( (isset($session['SaleAgentSearchFilter']['email'])) ? $session['SaleAgentSearchFilter']['email'] : '' )?><!--"-->
                                                <!--                                                                   placeholder="Email">-->
                                                <!--                                                        </div>-->
                                                <!--                                                    </div>-->
                                                <!--                                                    <div class="col-md-3">-->
                                                <!--                                                        <div class="form-group">-->
                                                <!--                                                            <label for="country">Phone Number</label>-->
                                                <!--                                                            <input type="number" class="form-control" name="phone_number"-->
                                                <!--                                                                   value="-->
                                                <? //=( (isset($session['SaleAgentSearchFilter']['phone_number'])) ? $session['SaleAgentSearchFilter']['phone_number'] : '' )?><!--"-->
                                                <!--                                                                   placeholder="Phone Number" min="1">-->
                                                <!--                                                        </div>-->
                                                <!--                                                    </div>-->

                                                <div class="col-md-6">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('SaleAgentSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('SaleAgentSearchFilter'); return false;"
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

                                <th>Agent Reg. ID</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Full Name</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>No Of Agents</th>
                                <th>Emergency Contact Number</th>
                                <th>Emergency Contact Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $recordSaleAgent['UserType'] = 'sale_agent';
                                //$SaleAgents = new SaleAgent();
                                //$SaleAgentsMeta = $SaleAgents->CountSaleAgentsMeta($record['UID']);

                                $cnt++;
                                if( $CheckAccess['umrah_client_sale_agents_update'] || $CheckAccess['umrah_client_sale_agents_delete']   || $CheckAccess['umrah_client_sale_agents_current_access_level']    ){
                                    $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                                     $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'sale_agents/main_form\', ' . $record['UID'] . ')">Update</a>';
                                                     $actions .= '<a class="dropdown-item" href="#" onclick="DeleteSalesAgent(' . $record['UID'] . ');">Delete</a>';
                                    $actions .= '<a class="dropdown-item" href = "#" onclick = "LoadModal(\'keys_main_form\' ,\'' . $record['UID'] . ':' .$recordSaleAgent['UserType'].  ':' . $record['FullName'].    ' \',\'modal-lg\')" > Current Access level</a >';
                                    $actions .= '</div>';
                                }

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>     
                                    <td>' . Code('UF/A/', $record['UID']) . '</td>
                                    <td>' . $record['CountryName'] . '</td>
                                    <td>' . $record['CityName'] . '</td>                                     
                                    <td>' . $record['FullName'] . ' <span>' .ShiftSession($record['UID'], 'sale-agent') . '</span> </td>                             
                                    <td>' . $record['PhoneNumber'] . '</td>
                                    <td>' . $record['Email'] . '</td>
                                    <td><a style="color:#dda420; font-weight: bold;" onclick="LoadSaleAgentReferAgentsModal( '.$record['UID'].', \''.$record['FullName'].'\' );" href="javascript:void(0);" title="Click To View Refer Agents">' . $record['TOTALAGENTS'] . '</a></td>
                                    <td>' . $record['EmergencyContactNumber'] . '</td>
                                    <td>' . $record['EmergencyContactName'] . '</td>                                 
                                    <td>';
                                        if( $CheckAccess['umrah_client_sale_agents_update'] || $CheckAccess['umrah_client_sale_agents_delete']    || $CheckAccess['umrah_client_sale_agents_current_access_level'] ){
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
                                                        ' . $actions . '
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
<?php echo view( 'sale_agents/agents-modal' ); ?>
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
        "pageLength": 100
    });

    var ExportAccess = "<?=$CheckAccess['umrah_client_sale_agents_export']?>";
    if(ExportAccess != '' && ExportAccess != null && ExportAccess == 1){
        setTimeout(function () {
            $('<a target="_blank" href="<?=$path?>exports/sales_agents_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
        }, 100);
    }

    function DeleteSalesAgent(UID) {
        if (confirm("Are You Want To Remove Sales Agent")) {
            var response = AjaxResponse("form_process/remove_sales_agent", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('sale_agents/index')?>";
            }


        }
    }
</script>