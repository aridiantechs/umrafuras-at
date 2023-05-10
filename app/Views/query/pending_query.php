<?php $class = getSegment(3);
?>



<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?= $template ?>assets/css/apps/notes.css" rel="stylesheet" type="text/css"/>
<link href="<?= $template ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL STYLES -->
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <!--            <h4 class="page-head">Queries-->
            <!--            </h4>-->
            <div class="row app-notes layout-top-spacing" id="cancel-row">
                <div class="col-lg-12">
                    <div class="app-hamburger-container">
                        <div class="hamburger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none">
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <line x1="3" y1="18" x2="21" y2="18"></line>
                            </svg>
                        </div>
                    </div>

                    <div class="app-container">

                        <div class="app-note-container">

                            <div class="app-note-overlay"></div>

                            <div class="tab-title">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12 text-center">
                                        <a id="btn-add-notes" class="btn btn-success" href="javascript:void(0);">Add</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12 mt-5">
                                        <ul class="nav nav-pills d-block" id="pills-tab3" role="tablist">
                                            <li class="nav-item">
                                                <a href="<?= $path; ?>home/query" class="nav-link list-actions"
                                                   id="all-notes">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-edit">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg>
                                                    All Queries</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= $path; ?>home/query/important"
                                                   class="nav-link list-actions" id="note-fav">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                         class="feather feather-star">
                                                        <polygon
                                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                    </svg>
                                                    Importants</a>
                                            </li>
                                        </ul>
                                        <hr/>
                                        <p class="group-section">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-tag">
                                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                                <line x1="7" y1="7" x2="7" y2="7"></line>
                                            </svg>
                                            Activites
                                        </p>
                                        <ul class="nav nav-pills d-block group-list" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a href="<?= $path; ?>home/query/resolved"
                                                   class="nav-link list-actions g-dot-primary" id="note-personal">Resolved</a>
                                            </li>
                                            <li class="nav-item">  <?php if($class=="pending") {$active = "active"; } else{ $active="";} ?>
                                                <a href="<?= $path; ?>home/query/pending"
                                                   class="nav-link list-actions <?=$active?> g-dot-warning"
                                                   id="note-work">Pending</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= $path; ?>home/query/inprocess"
                                                   class="nav-link list-actions  g-dot-success" id="note-social">In
                                                    Process</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>


                            <div id="ct" class="note-container note-grid">
                                <?php foreach ($PendingQuery as $value) { ?>
                                    <div class="note-item all-notes note-work">
                                        <div class="note-inner-content">
                                            <div class="note-content">
                                                <p class="note-title" data-noteTitle="Imporant Infomation">

                                                    <?php
                                                    if (strlen($value['Subject']) > 34) {
                                                        echo substr($value['Subject'], 0, 34) . "...";
                                                    } else {
                                                        echo $value['Subject'];
                                                    }
                                                    ?>


                                                </p>
                                                <!--                                                <p class="meta-time">11/04/2019</p>-->
                                                <div class="note-description-content">
                                                    <p class="note-description"
                                                       data-noteDescription="Proin a dui malesuada, laoreet mi vel, imperdiet diam quam laoreet.">

                                                        <?php
                                                        if (strlen($value['Query']) > 84) {
                                                            echo substr($value['Query'], 0, 84) . "...";
                                                        } else {
                                                            echo $value['Query'];
                                                        }
                                                        ?>


                                                    </p>
                                                </div>
                                            </div>
                                            <div class="note-action">
                                                <span><b><?= $value['Name']; ?></b></span>
                                                <span class="ml-2">( <?= DATEFORMAT($value['SystemDate']); ?>)</span>
                                            </div>
                                            <div class="note-footer">

                                                <svg onclick="Important_query(<?= $value['UID']?>,<?= $value['Featured']?>)" xmlns="http://www.w3.org/2000/svg"
                                                     width="24" height="14"
                                                    <?php  if( $value['Featured'] == 1){ $color = "#e2a03f"; } else{ $color = ""; } ?>
                                                     style="fill: <?=$color?>"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-star fav-note">
                                                    <polygon
                                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                </svg>





                                                <div class="tags-selector btn-group">
                                                    <a class="nav-link dropdown-toggle d-icon label-group"
                                                       data-toggle="dropdown" href="#" role="button"
                                                       aria-haspopup="true"
                                                       aria-expanded="true">
                                                        <div class="tags">
                                                            <div class="g-dot-personal"></div>
                                                            <div class="g-dot-work"></div>
                                                            <div class="g-dot-social"></div>
                                                            <div class="g-dot-important"></div>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                 height="24"
                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                 stroke-width="2" stroke-linecap="round"
                                                                 stroke-linejoin="round"
                                                                 class="feather feather-more-vertical">
                                                                <circle cx="12" cy="12" r="1"></circle>
                                                                <circle cx="12" cy="5" r="1"></circle>
                                                                <circle cx="12" cy="19" r="1"></circle>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right d-icon-menu">
                                                        <a onclick="openQueryModel(<?= $value['UID'] ?>);"
                                                           class="dropdown-item position-relative g-dot-<?= $class ?>"
                                                           href="javascript:void(0);"
                                                        >View</a>
                                                        <a onclick="change_status_query(<?= $value['UID'] ?> ,'Resolved')"
                                                           class="note-personal label-group-item label-personal dropdown-item position-relative g-dot-personal"
                                                           href="javascript:void(0);"> Resolved</a>
                                                        <a onclick="change_status_query(<?= $value['UID'] ?> ,'Pending')"
                                                           class="note-work label-group-item label-work dropdown-item position-relative g-dot-work"
                                                           href="javascript:void(0);"> Pending</a>
                                                        <a onclick="change_status_query(<?= $value['UID'] ?> ,'InProgress')"
                                                           class="note-social label-group-item label-social dropdown-item position-relative g-dot-social"
                                                           href="javascript:void(0);"> In Process</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-8 col-md-8 text-center">
                                            <div id="loaderView" style="display: none" class="spinner-border text-warning" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div >
                                        </div>

                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="notesMailModal" tabindex="-1" role="dialog"
                         aria-labelledby="notesMailModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal">
                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                    </svg>
                                    <div class="notes-box">
                                        <div class="notes-content">
                                            <form action="javascript:void(0);" id="notesMailModalTitle">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="d-flex note-title">
                                                            <input type="text" id="n-title" class="form-control"
                                                                   maxlength="25" placeholder="Title">
                                                        </div>
                                                        <span class="validation-text"></span>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="d-flex note-description">
                                                            <textarea id="n-description" class="form-control"
                                                                      maxlength="60" placeholder="Description"
                                                                      rows="3"></textarea>
                                                        </div>
                                                        <span class="validation-text"></span>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button id="btn-n-save" class="float-left btn">Save</button>
                                    <button class="btn" data-dismiss="modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-trash">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Discard
                                    </button>
                                    <button id="btn-n-add" class="btn">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo view('query/inner_html/query_data'); ?>
<!--  END CONTENT AREA  -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= $template ?>assets/js/ie11fix/fn.fix-padStart.js"></script>
<script src="<?= $template ?>assets/js/apps/notes.js"></script>

<script>

    function Important_query(UID, Featured) {
        $('#loaderView').show();
        $(document).ready(function () {
            var Status = 1;
            var ID = UID;
            var Feature = Featured;
            // alert(Status);
            $.ajax({
                url: "<?= $path; ?>home/important_status_query",
                type: "POST",
                dataType: "json",
                data: {
                    Status: Status,
                    UID: ID,
                    Featured: Feature,
                },
                success: function (response) {
                    if (response.status == "success") {
                        window.location.href = '<?= $path; ?>home/query';
                        $('#loaderView').hide();
                    } else {
                        alert("Record Not Updated...");
                    }
                }
            });
        });
    }


    function openQueryModel(UID) {
        $('#QueryBoxModel').modal('show');
        $('#queryModel').hide();
        $('#loaderView').show();

        $.ajax({
            url: "<?= $path; ?>home/dialogbox_data_query",
            type: "POST",
            dataType: "json",
            data: {
                UID: UID,
            },
            success: function (response) {

                $('#QueryBoxModel form#QueryBoxform #name').val(response.Name);
                $('#QueryBoxModel form#QueryBoxform #email').val(response.Email);
                $('#QueryBoxModel form#QueryBoxform #contact').val(response.ContactNumber);
                $('#QueryBoxModel form#QueryBoxform textarea#subject').val(response.Subject);
                $('#QueryBoxModel form#QueryBoxform textarea#query').val(response.Query);
                $('#queryModel').show();
                $('#loaderView').hide();
            }
        });
    }


    function change_status_query(UID,Status) {
        $('#loaderView').show();
        $.ajax({
            url: "<?= $path; ?>home/change_status_query",
            type: "POST",
            dataType: "json",
            data: {
                Status: Status,
                UID: UID,
            },
            success: function (response) {
                if( response.status == "success" ){
                    window.location.href = '<?= $path; ?>home/query';
                    $('#loaderView').hide();
                }else {
                    alert("Record Not Updated...");
                }
            }
        });
    }


</script>
<!-- END PAGE LEVEL SCRIPTS -->