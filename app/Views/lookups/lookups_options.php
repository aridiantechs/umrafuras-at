<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"><?= $lookup['Name'] ?> Options
                    <button type="button" class="btn btn_customized btn-sm float-right"
                            onclick="LoadModal('lookups/lookup_options_form', '<?= $lookup['UID'] ?>:0')">Add options
                    </button>
                </h4>
                <p><?= $lookup['Description'] ?></p>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <?php
                            $OrganicOpt = strpos($lookup['Key'], 'rganic'); ?>
                            <tr>
                                <th width="1%">#</th>
                                <th>Name</th>
                                <th <?= (($OrganicOpt !== false) ? '' : 'class="d-none"') ?> width="100px">
                                    Score
                                </th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'lookups/lookup_options_form\', \'' . $lookup['UID'] . ":" . $record['UID'] . '\')">Update</a>
                                    <a class="dropdown-item" href="#" onclick="DeleteLookupOption(' . $record['UID'] . ');">Delete</a>
                                </div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                    <td>' . $record['Name'] . '</td>
                                    <td ' . (($OrganicOpt !== false) ? '' : 'class="d-none"') . '> 
                                    <input class="form-control" onchange="AddOrganicPlatformScore(this.value,\'' . $record['UID'] . '\');" type="number" min="1" maxlength="3" id="Score" name="Score" placeholder="Score" value="' . $record['OtherDescription'] . '">
                                       </td>
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


    function DeleteLookupOption(UID) {
        if (confirm("Are You Want To Remove Lookup Option")) {
            response = AjaxResponse("form_process/remove_lookup_option", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }


        }
    }

    function AddOrganicPlatformScore(Score, UID) {
        response = AjaxResponse("form_process/add_score_to_organic_platform", "UID=" + UID + "&Score=" + Score);
        if (response.status == 'success') {
            // location.reload();
        }
    }

</script>