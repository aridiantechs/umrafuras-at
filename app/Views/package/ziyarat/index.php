<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">All Ziyarats
                    <?php if ($CheckAccess['umrah_services_ziyarat_add']) { ?>
                        <a class="btn btn_customized btn-sm float-right" href="<?= $path ?>package/new_ziyarat"
                           class="btn btn-outline-success btn-sm float-right">Add New</a>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ziyarat Reg. ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($ziyarats as $record) {
                                $cnt++;


                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if ($CheckAccess['umrah_services_ziyarat_update']) {
                                    $actions .= '<a class="dropdown-item" href="' . $path . 'package/new_ziyarat/' . $record['UID'] . '" > Update</a >';
                                }
                                if ($CheckAccess['umrah_services_ziyarat_delete']) {
                                    $actions .= '<a class="dropdown-item"href="#" onclick="DeleteZiyarat(' . $record['UID'] . ');"> Delete</a >';
                                }
                                if ($CheckAccess['umrah_services_ziyarat_print_download']) {
                                    $actions .= '<a class="dropdown-item" href="' . SeoUrl('exports/ziyarat/' . $record['UID'] . "-" . $record['Name']) . '" target="_blank"> Print/Download</a >';
                                }
                                $actions .= '</div>';

//                                $actions = '
//                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
//                                    <a class="dropdown-item" href="'.$path.'package/new_ziyarat/'.$record['UID'].'">Update</a>
//                                    <a class="dropdown-item" href="#" onclick="DeleteZiyarat('.$record['UID'].');">Delete</a>
//                                 <a class="dropdown-item" href="'.SeoUrl('exports/ziyarat/'.$record['UID']."-".$record['Name']).'" target="_blank">Print/Download</a>
//
//                                </div>';
                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . Code('UF/Z/', $record['UID']) . '</td>
                                    <td><img src="' . $path . 'home/load_file/' . $record['CoverImage'] . '" class="Image" alt="Hotel Image" width="100"></td>
                                    <td>' . $record['Name'] . '</td>
                                    <td>' . CityName($record['CityID']) . '</td>';
                                if ($CheckAccess['umrah_services_ziyarat_update'] || $CheckAccess['umrah_services_ziyarat_delete'] || $CheckAccess['umrah_services_ziyarat_print_download']) {
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

    function DeleteZiyarat(UID) {
        if (confirm("Are You Want To Remove?")) {
            response = AjaxResponse("form_process/remove_ziyarat", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('package/ziyarat')?>";
            }
        }
    }

    <?php if ($CheckAccess['umrah_services_ziyarat_export']) { ?>
    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/ziyarat_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);
    <?php } ?>
</script>