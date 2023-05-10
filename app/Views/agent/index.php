<!--  BEGIN CONTENT AREA  -->

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2B Client
                    <?php
                    if ($CheckAccess['umrah_client_b2b_add_new']) { ?>
                        <button type="button" class="btn btn_customized  btn-sm float-right"
                                onclick="LoadModal('agent/main_form', 0,'modal-lg')">Add New
                        </button>
                    <?php } ?>


                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class=" " data-toggle="collapse"
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
                                                        <label for="country">Agent Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                               value="<?= ((isset($session['AgentSearchFilter']['name'])) ? $session['AgentSearchFilter']['name'] : '') ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <input type="email" class="form-control" name="Country"
                                                               value=""
                                                               placeholder="Country">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">IATA License</label>
                                                        <input type="email" class="form-control" name="IATALicense"
                                                               value=""
                                                               placeholder="IATA License">
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group">-->
                                                <!--                                                        <label for="country">Email</label>-->
                                                <!--                                                        <input type="email" class="form-control" name="email"-->
                                                <!--                                                               value="-->
                                                <? //= ((isset($session['AgentSearchFilter']['email'])) ? $session['AgentSearchFilter']['email'] : '') ?><!--"-->
                                                <!--                                                               placeholder="Email">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="col-md-3">-->
                                                <!--                                                    <div class="form-group">-->
                                                <!--                                                        <label for="country">Phone Number</label>-->
                                                <!--                                                        <input type="number" class="form-control" name="phone_number"-->
                                                <!--                                                               value="-->
                                                <? //= ((isset($session['AgentSearchFilter']['phone_number'])) ? $session['AgentSearchFilter']['phone_number'] : '') ?><!--"-->
                                                <!--                                                               placeholder="Phone Number" min="1">-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->

                                                <div class="col-md-3" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('AgentSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('AgentSearchFilter'); return false;"
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
                                <th>Agent Ref. ID</th>

                                <th>Country</th>
                                <th>City</th>
                                <th>Agent Name</th>
                                <th>IATA License</th>
                                <th>Umrah Agreement</th>
                                <th>Package</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Website Domain</th>
                                <th>Reference</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $Agentname = $record['FullName'] . ' ' . $record['LastName'];
                                $Color = '';
                                $cnt++;

                                if ($CheckAccess['umrah_client_b2b_update'] || $CheckAccess['umrah_client_b2b_delete'] || $CheckAccess['umrah_client_b2b_current_access_level']) {

                                    $actions = '<div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                    if ($CheckAccess['umrah_client_b2b_update']) {
                                        $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'agent/main_form\', ' . $record['UID'] . ', \'modal-lg\')">Update</a>';
                                    }
                                    if ($CheckAccess['umrah_client_b2b_delete']) {
                                        $actions .= ' <a class="dropdown-item" href="#" onclick="DeleteAgent(' . $record['UID'] . ');">Delete</a>';
                                    }
                                    if ($CheckAccess['umrah_client_b2b_current_access_level']) {
                                        $actions .= '<a class="dropdown-item" href = "#" onclick = "LoadModal(\'keys_main_form\' ,\'' . $record['UID'] . ':' . $record['Type'] . ':' . $Agentname . '  \',\'modal-lg\')" > Current Access level</a >';
                                    }
                                    $actions .= '</div>';
                                }


                                if ($record['Status'] == 'InActive') {
                                    $Color = 'class="alert-danger"';
                                }
                                echo '
                                <tr ' . $Color . '>
                                    <td>' . $cnt . '</td>         
                                      <td>' . Code('UF/A/', $record['UID']) . '</td>                  
                                      <td>' . CountryName($record['CountryID']) . '</td>  
                                      <td>' . CityName($record['CityID']) . '</td>       
                                 
                                      <td>' . $record['FullName'] . ' ' . $record['LastName'] . ' <span>' . ShiftSession($record['UID'], $record['Type']) . '</span> </td>
                                      <td>' . $record['IATALicense'] . '</td>   
                                      <td>' . $record['UmrahAgreement'] . '</td>   
                                      <td>' . $record['PackageName'] . '</td>   
               
                                     <td>' . $record['ContactPersonName'] . '</td>
                                     <td>' . $record['PhoneNumber'] . '</td>
                                     <td>' . $record['Email'] . '</td>                          
                                     <td>' . DomainName($record['WebsiteDomain']) . '</td>                        
                                     <td>' . $record['SaleAgentName'] . '</td>                        
                                    <td>';
                                if ($CheckAccess['umrah_client_b2b_update'] || $CheckAccess['umrah_client_b2b_delete'] || $CheckAccess['umrah_client_b2b_current_access_level']) {
                                    echo '<div class="btn-group">
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
                                } else {
                                    echo '-';
                                }

                                echo '</td>
                                    </tr>';
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
        "lengthMenu": [[100, 500, 1000, -1],[100, 500, 1000, 'All']],
        "pageLength": 100,
    });

    var ExportAccess = "<?=$CheckAccess['umrah_client_b2b_export']?>";
    if (ExportAccess != '' && ExportAccess != null && ExportAccess == 1) {
        setTimeout(function () {
            $('<a target="_blank" href="<?=$path?>exports/agents_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
        }, 100);
    }

    function DeleteAgent(UID) {
        if (confirm("Are You Want To Remove Agent")) {
            var response = AjaxResponse("form_process/remove_user", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('agent/index')?>";
            }


        }
    }
</script>