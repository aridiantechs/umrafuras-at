<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Operators
                    <?php if ($CheckAccess['umrah_services_operator_add']) { ?>
                        <button type="button" class="btn btn_customized btn-sm float-right"
                                onclick="LoadModal('user/operator/main_form','modal-xl', 0)">Add New
                        </button>
                    <?php } ?>
                </h4>

            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover  dispaly nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Company Name</th>
                                <th>Contact person</th>
                                <th>Contact No</th>
                                <th>Email</th>
                                <th>Office City</th>
                                <th>Type</th>
                                <th>Logo</th>
                                <!--                                <th>Contact Number</th>-->
                                <!--                                <th>Email</th>-->
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if ($CheckAccess['umrah_services_operator_update']) {
                                    $actions .= '<a class="dropdown-item" href = "#" onclick ="LoadModal(\'user/operator/main_form\', ' . $record['UID'] . ', \'modal-lg\')" > Update</a >';
                                }
                                if ($CheckAccess['umrah_services_operator_delete']) {
                                    $actions .= '<a class="dropdown-item" href = "#" onclick ="DeleteOperator(' . $record['UID'] . ')"> Delete</a >';
                                }
                                $actions .= '</div>';

//                              <td>' . $record['ContactNumber'] . '</td><td>' . $record['Email'] . '</td>

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . CountryName($record['Country']) . '</td>
                                    <td>' . $record['Category'] . '</td>
                                    <td>' . $record['CompanyName'] . '</td>
                                    <td>' . $record['ContactPersonName'] . '</td>
                                    <td>' . $record['ContactNo'] . '</td>
                                    <td>' . $record['Email'] . '</td>
                                    <td>' . $record['OfficeCity'] . '</td>
                                    <td>' . $record['Type'] . '</td>
                                    <td>'.( ( isset($record['Logo']) && $record['Logo'] != '' )? '<img style="width:150px;" src="'.$path.'home/load_file/'.$record['Logo'].'">' : '-' ).'</td>';
                                if ($CheckAccess['umrah_services_operator_update'] || $CheckAccess['umrah_services_operator_delete']) {
                                    echo ' 
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
                                            ' . $actions . '
                                        </div></td>';
                                } else {
                                    echo ' <td>-</td>';
                                }
                                echo '
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
        "lengthMenu": [[100,500,1000,-1],[100,500,1000,'All']],
        "pageLength": 100
    });


    function DeleteOperator(UID) {
        if (confirm("Are You Want To Remove operator")) {
            response = AjaxResponse("form_process/remove_operator", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('user/operator')?>";
            }


        }
    }
</script>