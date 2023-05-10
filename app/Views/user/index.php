<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">System Users<!-- --><?php /*echo PATH1*/ ?>
                    <?php if ($CheckAccess['umrah_users_system_user_add']) { ?>
                        <button type="button" class="btn btn_customized btn-sm float-right"
                                onclick="LoadModal('user/main_form', 0,'modal-lg')">Add New
                        </button>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Full Name</label>
                                                        <input type="text" class="form-control" id="FullName"
                                                               placeholder="Full Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Email</label>
                                                        <input type="email" class="form-control" id="Email"
                                                               placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Company Name</label>
                                                        <input type="text" class="form-control" id="Email"
                                                               placeholder="Company Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">User Type</label>
                                                        <select class="form-control" id="UserType"
                                                                name="UserType">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($user_types as $user_dataK => $user_dataV) {
                                                                $selected = (($profile['UserType'] == $user_dataK) ? 'selected' : '');
                                                                echo '<option value="' . $user_dataK . '" ' . $selected . '>' . $user_dataV . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">User Category</label>
                                                        <select class="form-control" id="UserCategory"
                                                                name="UserCategory">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($user_category as $user_dataK => $user_dataV) {
                                                                $selected = (($profile['UserType'] == $user_dataK) ? 'selected' : '');
                                                                echo '<option value="' . $user_dataK . '" ' . $selected . '>' . $user_dataV . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="multiple-messages"
                                                                class="btn btn_customized float-right">Search
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
                                <th>Full Name</th>
                                <th>Designation</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th>User Category</th>
                                <th>Company Name</th>
                                <th>Agent Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if ($CheckAccess['umrah_users_system_user_update']) {
                                    $actions .= '<a class="dropdown-item" href = "#" onclick = "LoadModal(\'user/main_form\', ' . $record['UID'] . ')" > Update</a >';
                                }
                                if ($CheckAccess['umrah_users_system_user_delete']) {
                                    $actions .= '<a class="dropdown-item" href = "#" onclick = "DeleteUser(' . $record['UID'] . ')"> Delete</a >';
                                }
                                if ($CheckAccess['umrah_users_system_user_current_access_level']) {
                                    $actions .= '<a class="dropdown-item" href = "#" onclick = "LoadModal(\'keys_main_form\' ,\'' . $record['UID'] . ':' . $record['UserType'] . ':' . $record['FullName'] . '  \',\'modal-lg\')" > Current Access level</a >';
                                }
                                $actions .= '</div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>                                
                                    <td>' . $record['FullName'] . '   <span>' . ShiftSession($record['UID'], $record['UserType']) . '</span> </td>
                                    <td>' . $record['Designation'] . '</td>
                                    <td>' . $record['ContactNumber'] . '</td>                               
                                    <td>' . $record['Email'] . '</td>
                                    <td>' . $user_types[$record['UserType']] . '</td>
                                    <td>N/A</td>
                                    <td>' . $record['FullName'] . '</td>
                                    <td>' . ((isset($record['AgentName'])) ? $record['AgentName'] . " (" . ucwords(str_replace('_', ' ', $record['AgentType'])) . ")" : 'Self') . '</td>
                                    <td>
                                    ';
                                if ($CheckAccess['umrah_users_system_user_update'] || $CheckAccess['umrah_users_system_user_delete'] || $CheckAccess['umrah_users_system_user_current_access_level'] ) {
                                    echo ' <div class="btn-group">
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
        "pageLength": 100
    });

    function DeleteUser(UID) {
        if (confirm("Are You Want To Remove user")) {
            response = AjaxResponse("form_process/remove_system_user", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('user/index')?>";
            }


        }
    }
</script>