<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">B2B Package
                    <?php
                    if ($CheckAccess['umrah_services_packages_b2b_add']) {
                        $Crud = new Crud();
                        $Page = getSegment(2);
                        $table = 'packages."Packages"';
                        $where = array("AgentUID" => $session['id'], "ApprovalDate" => NULL);
                        $records = $Crud->SingleRecord($table, $where);
                        if (count($records) > 0) {
                            echo '  <a class="btn btn_customized btn-sm float-right" href="#" onclick="LoadModal(\'package/package_approval_modal.php\', 0)">Approve Package</a>';
                        } else {
                            echo '   <a class="btn btn_customized btn-sm float-right" href="' . $path . 'package/new_package">Add New</a>';
                        }
                    }
                    ?>
                    <?php if ($CheckAccess['umrah_services_packages_b2b_copy']) { ?>
                        <a class="btn btn_customized btn-sm float-right mr-2" href="#"
                           onclick="LoadModal('package/copy_package_modal','<?= $Page ?>')">Copy Package</a>
                    <?php }
                    ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Package Reg. ID</th>
                                <th>Name</th>
                                <th>Agent Name</th>
                                <th>Group Code</th>
                                <th>Start Date</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($packages as $record) {
                                $cnt++;


                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if ($CheckAccess['umrah_services_packages_b2b_Update']) {
                                    if ($session['id'] != $record['AgentUID']) {
                                        $actions .= '<a class="dropdown-item" href="' . $path . 'package/update_package/' . $record['UID'] . '" > Update</a >';
                                    }
                                }
                                if ($CheckAccess['umrah_services_packages_b2b_download']) {
                                    $actions .= '<a class="dropdown-item"  href="' . SeoUrl('exports/b2b_package/' . $record['UID'] . "-" . $record['Name']) . '" target="_blank"> Download</a >';
                                }
                                $actions .= '</div>';


//                                $actions = '
//                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
//                                    if($session['id']!=$record['AgentUID']){
//                                        $actions.='<a class="dropdown-item" href="' . $path . 'package/update_package/' . $record['UID'] . '">Update</a>';
//                                    }
//                                    $actions.='<a class="dropdown-item" href="' . SeoUrl('exports/b2b_package/' . $record['UID'] . "-" . $record['Name']) . '" target="_blank">Download</a>
//                                </div>';
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code('UF/P/', $record['UID']) . '</td>
                                    <td>' . $record['Name'] . '</td>
                                    <td>' . $record['agentname'] . '</td>
                                    <td>' . $record['GroupCode'] . '</td>
                                    <td>' . DATEFORMAT($record['StartDate']) . '</td>
                                    <td>' . DATEFORMAT($record['ExpireDate']) . '</td>';
                                if ($CheckAccess['umrah_services_packages_b2b_Update'] || $CheckAccess['umrah_services_packages_b2b_download']) {
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
                                        </div>
                                    </td>';
                                } else {
                                    echo ' <td>-</td>';
                                }
                                echo ' </tr>';
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

    function DeleteHotel(UID) {
        if (confirm("Are You Want To Remove?")) {
            response = AjaxResponse("form_process/remove_hotel", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('package/hotel')?>";
            }


        }
    }
    <?php if ($CheckAccess['umrah_services_packages_b2b_export']) { ?>
    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/b2b_package_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);
    <?php } ?>
</script>