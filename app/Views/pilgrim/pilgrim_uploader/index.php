<!--  BEGIN CONTENT AREA  -->
<link href="<?= $template ?>assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css"/>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Upload Files
                </h4>
            </div>
            <div class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Files Uploader</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area border-tab">
                        <ul class="nav nav-tabs mt-3" id="border-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment == 'mofa' ? 'active' : '') ?>" id="border-home-tab"
                                   href="<?= $path ?>pilgrim/file_uploader/mofa"
                                   aria-controls="border-home" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Mofa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment == 'elm' ? 'active' : '') ?>" id="border-profile-tab"
                                   href="<?= $path ?>pilgrim/file_uploader/elm"
                                   aria-controls="border-profile" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Arrival ELM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment == 'dep_elm' ? 'active' : '') ?>" id="border-profile-tab"
                                   href="<?= $path ?>pilgrim/file_uploader/dep_elm"
                                   aria-controls="border-profile" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Departure ELM</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment == 'city' ? 'active' : '') ?>" id="border-city-tab"
                                   href="<?= $path ?>pilgrim/file_uploader/city"
                                   aria-controls="border-contact" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    City Cover Uploader</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= ($segment == 'visa' ? 'active' : '') ?>" id="border-visa-tab"
                                   href="<?= $path ?>pilgrim/file_uploader/visa"
                                   aria-controls="border-contact" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Visa Uploader</a>
                            </li>
                        </ul>
                        <div class="tab-content mb-4" id="border-tabsContent">
                            <div class="tab-pane fade  <?= ($segment == 'mofa' ? 'show active' : '') ?>"
                                 id="border-home" role="tabpanel"
                                 aria-labelledby="border-home-tab">
                                <?php if ($segment == 'mofa') {
                                    echo view('pilgrim/pilgrim_uploader/mofa');
                                } ?>
                            </div>
                            <div class="tab-pane fade  <?= ($segment == 'elm' ? 'show active' : '') ?>"
                                 id="border-profile" role="tabpanel"
                                 aria-labelledby="border-profile-tab">
                                <?php if ($segment == 'elm') {
                                    echo view('pilgrim/pilgrim_uploader/elm');
                                } ?>
                            </div>
                            <div class="tab-pane fade  <?= ($segment == 'dep_elm' ? 'show active' : '') ?>"
                                 id="border-profile" role="tabpanel"
                                 aria-labelledby="border-profile-tab">
                                <?php if ($segment == 'dep_elm') {
                                    echo view('pilgrim/pilgrim_uploader/dep-elm');
                                } ?>
                            </div>
                            <div class="tab-pane fade  <?= ($segment == 'city' ? 'show active' : '') ?>"
                                 id="border-city" role="tabpanel"
                                 aria-labelledby="border-city-tab">
                                <?php if ($segment == 'city') {
                                    echo view('pilgrim/pilgrim_uploader/city');
                                } ?>
                            </div>
                            <div class="tab-pane fade  <?= ($segment == 'visa' ? 'show active' : '') ?>"
                                 id="border-visa" role="tabpanel"
                                 aria-labelledby="border-visa-tab">
                                <?php if ($segment == 'visa') {
                                    echo view('pilgrim/pilgrim_uploader/visa');
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

    $('#MainRecords,#MainRecord').DataTable({
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