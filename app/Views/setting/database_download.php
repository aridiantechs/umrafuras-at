<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Database Backups</h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover dispaly nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th width="20px;">#</th>
                                <th width="160px;">File Name</th>
                                <th width="160px;">Created Date</th>
                                <th width="110px;">File Size</th>
                                <th width="110px;">Download</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($FilesName as $FileName) {
                                $fileExt = pathinfo($FileName['server_path'], PATHINFO_EXTENSION);
                                if ($fileExt == 'gz') {
                                    $size = round($FileName['size'] / 1024 / 1024, 2) . " MB";
                                    $cnt++; ?>
                                    <tr>
                                        <td><?= $cnt ?></td>
                                        <td><?= $FileName['name'] ?></td>
                                        <td><?= date("F d Y h:i: A", filemtime($FileName['server_path'])) ?></td>
                                        <td><?= $size ?></td>
                                        <td><a
                                            href="<?= $path ?>db/auto_backup/<?= $FileName['name'] ?>"
                                            target="_blank"
                                            data-toggle="tooltip" data-placement="top" title="Download">
                                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor"
                                                 stroke-width="2" fill="none" stroke-linecap="round"
                                                 stroke-linejoin="round"
                                                 class="css-i6dzq1">
                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                <polyline points="7 10 12 15 17 10"></polyline>
                                                <line x1="12" y1="15" x2="12" y2="3"></line>
                                            </svg>
                                            </a></td>
                                    </tr>
                                <?php }
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
        "pageLength": 100,
    });
</script>
