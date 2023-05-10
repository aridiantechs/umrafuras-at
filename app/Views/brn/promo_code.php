<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">BRN Promo Code
                    <?php
                        if($CheckAccess['umrah_brn_management_promo_code_create_new_promo']){?>
                            <button type="button" class="btn btn_customized btn-sm float-right"
                                    onclick="LoadModal('brn/add_promo_code', 0, 'modal-lg')">Create New Promo
                            </button>
                        <?php }?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Agent</th>
                                <th>Hotel</th>
                                <th>City</th>
                                <th>Promo Code</th>
                                <th>Activation Date</th>
                                <th>Expiry Date</th>
                                <th>Care Of</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($records as $record) {

                                $cnt++;

                                $actions = ' <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if($CheckAccess['umrah_brn_management_promo_code_update']){
                                    $actions.=' <a class="dropdown-item" href="#" onclick="LoadModal(\'brn/add_promo_code\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>';
                                }
                                if($CheckAccess['umrah_brn_management_promo_code_delete']){
                                    $actions.='<a class="dropdown-item" href="#" onclick="DeleteBRNPromo(' . $record['UID'] . ');">Delete</a>';
                                }
                                $actions.='</div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . ( ( isset($record['Agent']) && $record['Agent'] != '' )? $record['Agent'] : '-' ) . '</td>
                                    <td>' . ( ( isset($record['Hotel']) && $record['Hotel'] != '' )? $record['Hotel'] : '-' ) . '</td>
                                    <td>' . ( ( isset($record['CityName']) && $record['CityName'] != '' )? $record['CityName'] : '-' ) . '</td>
                                    <td>' . $record['PromoCode'] . '</td>
                                    <td>' . DATEFORMAT($record['ActivationDate']) . '</td>
                                    <td>' . DATEFORMAT($record['ExpiryDate']) . '</td>
                                    <td>' . ucwords($record['CareOf']) . '</td>
                                    <td><badge class="badge badge-mini badge-'.( ( $record['Status'] == 'Block' )? 'danger' : 'success' ).'">'.$record['Status'].'</badge></td>
                                     <td>';
                                        if($CheckAccess['umrah_brn_management_promo_code_update'] || $CheckAccess['umrah_brn_management_promo_code_delete']){
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
<!--  END CONTENT AREA  -->
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });


    function DeleteBRNPromo(UID) {
        if (confirm("Are You Want To Remove BRN Promo Code")) {
            response = AjaxResponse("form_process/remove_promo_code_brn", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('brn/promo_code')?>";
            }


        }
    }
</script>