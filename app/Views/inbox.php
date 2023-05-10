<!--  BEGIN CONTENT AREA  -->
<link rel="stylesheet" type="text/css" href="<?=$template?>plugins/editors/quill/quill.snow.css">
<link href="<?=$template?>assets/css/apps/mailbox.css" rel="stylesheet" type="text/css" />
<script src="<?=$template?>plugins/sweetalerts/promise-polyfill.js"></script>
<link href="<?=$template?>plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$template?>plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
<link href="<?=$template?>plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Inbox

                </h4>
                <div class="row" class="text-center">
                    <div class="col-md-12">
                        <?php echo session()->getFlashdata('msg'); ?>
                    </div>
                </div>
                <div class="row">

                    <div class="col-xl-12  col-md-12">

                        <div class="mail-box-container">
                            <div class="mail-overlay"></div>

                            <div class="tab-title">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-12 text-center mail-btn-container">
                                        <a id="btn-compose-mail" class="btn btn-block btn_customized" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg></a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12 mail-categories-container">

                                        <div class="mail-sidebar-scroll">

                                            <ul class="nav nav-pills d-block" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions active" id="mailInbox"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg> <span class="nav-names">Inbox</span>
                                                    <span class="mail-badge badge">
                                                        <?php 
                                                            if(isset($inbox->data)  && isset($inbox->data->general)){ 
                                                                count($inbox->data->general);
                                                            }
                                                        ?>
                                                    </span></a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="important"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> <span class="nav-names">Important</span></a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="sentmail"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg> <span class="nav-names"> Sent Mail</span></a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link list-actions" id="trashed"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg> <span class="nav-names">Trash</span></a>
                                                </li>
                                            </ul>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="mailbox-inbox" class="accordion mailbox-inbox">

                                <div class="search">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu mail-menu d-lg-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    <input type="text" class="form-control input-search" placeholder="Search Here...">
                                </div>

                                <div class="action-center">
                                    <div class="">
                                        <div class="n-chk">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox" class="new-control-input" id="inboxAll">
                                                <span class="new-control-indicator"></span><span>Check All</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" data-toggle="tooltip" data-placement="top" data-original-title="Important" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star action-important"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" data-toggle="tooltip" data-placement="top" data-original-title="Revive Mail" stroke-linejoin="round" class="feather feather-activity revive-mail"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-toggle="tooltip" data-placement="top" data-original-title="Delete Permanently" class="feather feather-trash permanent-delete"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        <div class="dropdown d-inline-block more-actions">
                                            <a class="nav-link dropdown-toggle" id="more-actions-btns-dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="more-actions-btns-dropdown">
                                                <a class="dropdown-item action-mark_as_read" href="javascript:void(0);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg> Mark as Read
                                                </a>
                                                <a class="dropdown-item action-mark_as_unRead" href="javascript:void(0);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg> Mark as Unread
                                                </a>
                                                <a class="dropdown-item action-delete" href="javascript:void(0);">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-toggle="tooltip" data-placement="top" data-original-title="Delete" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Trash
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="message-box">
                                    <form id="inboxform" action="<?= $path ?>home/deleteEmail" method="post">
                                        <div class="message-box-scroll" id="ct">

                                            <?php if(isset($inbox->data) && isset($inbox->data->general)){ 
                                                foreach ($inbox->data->general as $key => $value) { ?>

                                            <div id="unread-promotion-page<?php echo($value->id);?>" class="mail-item mailInbox">
                                                <div class="animated animatedFadeInUp fadeInUp" id="mailHeading<?php echo($value->id);?>">
                                                    <div class="mb-0">
                                                        <div class="mail-item-heading social collapsed"  data-toggle="collapse" role="navigation" data-target="#mailCollapse<?php echo($value->id);?>" aria-expanded="false">
                                                            <div class="mail-item-inner">

                                                                <div class="d-flex">
                                                                    <div class="n-chk text-center">
                                                                        <label class="new-control new-checkbox checkbox-primary">
                                                                            <input type="checkbox" class="new-control-input inbox-chkbox" id="mailcheckbox_<?php echo($value->id); ?>" name="mailcheckbox_<?php echo($value->id); ?>">
                                                                            <span class="new-control-indicator"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="f-head">
                                                                        <!-- <img src="assets/img/90x90.jpg" class="user-profile" alt="avatar"> -->
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                    <div class="f-body">
                                                                        <div class="meta-mail-time">
                                                                            <p class="user-email" data-mailTo="<?php echo($value->from_email); ?>"><?php echo($value->from_email); ?></p>
                                                                        </div>
                                                                        <div class="meta-title-tag">
                                                                            <p class="mail-content-excerpt" data-mailDescription='{"ops":[{"insert":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. \n"}]}'>
                                                                                <?php if(isset($value->attachments) && count($value->attachments) > 0) { ?>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip attachment-indicator">
                                                                                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                                                    </svg>
                                                                                <?php } ?>
                                                                                <span class="mail-title" data-mailTitle="<?php echo($value->subject); ?>"><?php echo($value->subject); ?> - <small><?php echo(strip_tags(substr(preg_replace("/<img[^>]+\>/i", " (image) ", $value->message), 0, 100))); ?> ...</small></span> 
                                                                            </p>
                                                                            <!-- <div class="tags">
                                                                                <span class="g-dot-primary"></span>
                                                                                <span class="g-dot-warning"></span>
                                                                                <span class="g-dot-success"></span>
                                                                                <span class="g-dot-danger"></span>
                                                                            </div> -->
                                                                            <p class="meta-time align-self-center"><?php echo(date('h:i A',strtotime($value->created_at))); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php if(isset($value->attachments) && count($value->attachments) > 0) { ?>
                                                            <div class="attachments">
                                                                <?php foreach($value->attachments as $index => $file){?>
                                                                <span class=""><?php echo($file->original_name); ?></span>
                                                                <?php }?>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php }} ?>

                                            <?php if(isset($inbox->data) && isset($inbox->data->deleted)){ 
                                                foreach ($inbox->data->deleted as $key => $value) { 
                                                    
                                                    // echo('<pre>');
                                                    // print_r($value);
                                                    // die();
                                                    ?>

                                            <div id="unread-promotion-page<?php echo($value->id);?>" class="mail-item trashed">
                                                <div class="animated animatedFadeInUp fadeInUp" id="mailHeading<?php echo($value->id);?>">
                                                    <div class="mb-0">
                                                        <div class="mail-item-heading social collapsed"  data-toggle="collapse" role="navigation" data-target="#mailCollapse<?php echo($value->id);?>" aria-expanded="false">
                                                            <div class="mail-item-inner">

                                                                <div class="d-flex">
                                                                    <div class="n-chk text-center">
                                                                        <label class="new-control new-checkbox checkbox-primary">
                                                                            <input type="checkbox" class="new-control-input inbox-chkbox" id="mailcheckbox_<?php echo($value->id); ?>" name="mailcheckbox_<?php echo($value->id); ?>">
                                                                            <span class="new-control-indicator"></span>
                                                                        </label>
                                                                    </div>
                                                                    <div class="f-head">
                                                                        <!-- <img src="assets/img/90x90.jpg" class="user-profile" alt="avatar"> -->
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                    <div class="f-body">
                                                                        <div class="meta-mail-time">
                                                                            <p class="user-email" data-mailTo="<?php echo($value->from_email); ?>"><?php echo($value->from_email); ?></p>
                                                                        </div>
                                                                        <div class="meta-title-tag">
                                                                            <p class="mail-content-excerpt" data-mailDescription='{"ops":[{"insert":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. \n"}]}'>
                                                                                <?php if(isset($value->attachments) && count($value->attachments) > 0) { ?>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip attachment-indicator">
                                                                                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
                                                                                    </svg>
                                                                                <?php } ?>
                                                                                <span class="mail-title" data-mailTitle="<?php echo($value->subject); ?>"><?php echo($value->subject); ?> - <small><?php echo(strip_tags(substr(preg_replace("/<img[^>]+\>/i", " (image) ", $value->message), 0, 100))); ?> ...</small></span> 
                                                                            </p>
                                                                            <!-- <div class="tags">
                                                                                <span class="g-dot-primary"></span>
                                                                                <span class="g-dot-warning"></span>
                                                                                <span class="g-dot-success"></span>
                                                                                <span class="g-dot-danger"></span>
                                                                            </div> -->
                                                                            <p class="meta-time align-self-center"><?php echo(date('h:i A',strtotime($value->created_at))); ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php if(isset($value->attachments) && count($value->attachments) > 0) { ?>
                                                            <div class="attachments">
                                                                <?php foreach($value->attachments as $index => $file){?>
                                                                <span class=""><?php echo($file->original_name); ?></span>
                                                                <?php }?>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php }} ?>

                                        </div>
                                    </form>
                                </div>

                                <div class="content-box">
                                    <div class="d-flex msg-close">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left close-message"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                                        <h2 class="mail-title" data-selectedMailTitle=""></h2>
                                    </div>

                                    <?php if(isset($inbox->data) && isset($inbox->data->general)){ ?>
                                        <?php foreach ($inbox->data->general as $key => $value) { ?>
                                            
                                    <div id="mailCollapse<?php echo($value->id);?>" class="collapse" aria-labelledby="mailHeading<?php echo($value->id);?>" data-parent="#mailbox-inbox">
                                        <div class="mail-content-container mailInbox" data-mailfrom="info@mail.com" data-mailto="linda@mail.com" data-mailcc="">

                                            <div class="d-flex justify-content-between">

                                                <div class="d-flex user-info">
                                                    <div class="f-head">
                                                        <!-- <img src="assets/img/90x90.jpg" class="user-profile" alt="avatar"> -->
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="f-body">
                                                        <div class="meta-title-tag">
                                                            <h4 class="mail-usr-name" data-mailtitle="<?php echo($value->subject);?>"><?php echo($value->from_email);?></h4>
                                                        </div>
                                                        <div class="meta-mail-time">
                                                            <p class="user-email" data-mailto="<?php echo($value->from_email);?>"><?php echo($value->from_email);?></p>
                                                            <p class="mail-content-meta-date current-recent-mail"><?php echo(date('d/m/Y' , strtotime($value->created_at)));?> -</p>
                                                            <p class="meta-time align-self-center"><?php echo(date('h:i A' , strtotime($value->created_at)));?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="action-btns">
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Reply">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-left reply"><polyline points="9 14 4 9 9 4"></polyline><path d="M20 20v-7a4 4 0 0 0-4-4H4"></path></svg>
                                                    </a>
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Forward">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-right forward"><polyline points="15 14 20 9 15 4"></polyline><path d="M4 20v-7a4 4 0 0 1 4-4h12"></path></svg>
                                                    </a>
                                                </div>
                                            </div>

                                            <p class="mail-content" data-mailTitle="<?php echo($value->subject); ?>" data-maildescription='{"ops":[{"insert":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pulvinar feugiat consequat. Duis lacus nibh, sagittis id varius vel, aliquet non augue. Vivamus sem ante, ultrices at ex a, rhoncus ullamcorper tellus. Nunc iaculis eu ligula ac consequat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum mattis urna neque, eget posuere lorem tempus non. Suspendisse ac turpis dictum, convallis est ut, posuere sem. Etiam imperdiet aliquam risus, eu commodo urna vestibulum at. Suspendisse malesuada lorem eu sodales aliquam.\n"}]}'> 
                                                <?php echo($value->message); ?>
                                            </p>

                                            <!-- <div class="gallery text-center">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                            </div> -->

                                            <!-- <p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p> -->

                                            <p>Best Regards,</p>
                                            <p><?php echo($value->from_email);?></p>


                                            <div class="attachments">
                                                <h6 class="attachments-section-title">Attachments</h6>

                                                <?php if(isset($value->attachments) && count($value->attachments) > 0) { 
                                                     foreach($value->attachments as $index => $file){?>
                                                    <div class="attachment file-pdf">
                                                        <div class="media">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                            <div class="media-body">
                                                                <p class="file-name"><?php echo($file->original_name); ?></p>
                                                                <!-- <p class="file-size">450kb</p> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }} ?>
                                                <!-- <div class="attachment file-folder">
                                                    <div class="media">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                        <div class="media-body">
                                                            <p class="file-name">Important Docs.xml</p>
                                                            <p class="file-size">2.1MB</p>
                                                        </div>
                                                    </div>
                                                </div> -->

                                            </div>

                                        </div>
                                    </div>

                                    <?php }} ?>

                                    <?php if(isset($inbox->data) && isset($inbox->data->deleted)){ ?>
                                        <?php foreach ($inbox->data->deleted as $key => $value) { ?>
                                            
                                    <div id="mailCollapse<?php echo($value->id);?>" class="collapse" aria-labelledby="mailHeading<?php echo($value->id);?>" data-parent="#mailbox-inbox">
                                        <div class="mail-content-container trashed" data-mailfrom="info@mail.com" data-mailto="linda@mail.com" data-mailcc="">

                                            <div class="d-flex justify-content-between">

                                                <div class="d-flex user-info">
                                                    <div class="f-head">
                                                        <!-- <img src="assets/img/90x90.jpg" class="user-profile" alt="avatar"> -->
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div class="f-body">
                                                        <div class="meta-title-tag">
                                                            <h4 class="mail-usr-name" data-mailtitle="<?php echo($value->subject);?>"><?php echo($value->from_email);?></h4>
                                                        </div>
                                                        <div class="meta-mail-time">
                                                            <p class="user-email" data-mailto="<?php echo($value->from_email);?>"><?php echo($value->from_email);?></p>
                                                            <p class="mail-content-meta-date current-recent-mail"><?php echo(date('d/m/Y' , strtotime($value->created_at)));?> -</p>
                                                            <p class="meta-time align-self-center"><?php echo(date('h:i A' , strtotime($value->created_at)));?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="action-btns">
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Reply">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-left reply"><polyline points="9 14 4 9 9 4"></polyline><path d="M20 20v-7a4 4 0 0 0-4-4H4"></path></svg>
                                                    </a>
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-original-title="Forward">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-right forward"><polyline points="15 14 20 9 15 4"></polyline><path d="M4 20v-7a4 4 0 0 1 4-4h12"></path></svg>
                                                    </a>
                                                </div>
                                            </div>

                                            <p class="mail-content" data-mailTitle="<?php echo($value->subject); ?>" data-maildescription='{"ops":[{"insert":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi pulvinar feugiat consequat. Duis lacus nibh, sagittis id varius vel, aliquet non augue. Vivamus sem ante, ultrices at ex a, rhoncus ullamcorper tellus. Nunc iaculis eu ligula ac consequat. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vestibulum mattis urna neque, eget posuere lorem tempus non. Suspendisse ac turpis dictum, convallis est ut, posuere sem. Etiam imperdiet aliquam risus, eu commodo urna vestibulum at. Suspendisse malesuada lorem eu sodales aliquam.\n"}]}'> 
                                                <?php echo($value->message); ?>
                                            </p>

                                            <!-- <div class="gallery text-center">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                                <img alt="image-gallery" src="assets/img/350x250.jpg" class="img-fluid mb-4 mt-4" style="width: 250px; height: 180px;">
                                            </div> -->

                                            <!-- <p>Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.</p> -->

                                            <p>Best Regards,</p>
                                            <p><?php echo($value->from_email);?></p>


                                            <div class="attachments">
                                                <h6 class="attachments-section-title">Attachments</h6>

                                                <?php if(isset($value->attachments) && count($value->attachments) > 0) { 
                                                     foreach($value->attachments as $index => $file){?>
                                                    <div class="attachment file-pdf">
                                                        <div class="media">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                            <div class="media-body">
                                                                <p class="file-name"><?php echo($file->original_name); ?></p>
                                                                <!-- <p class="file-size">450kb</p> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }} ?>
                                                <!-- <div class="attachment file-folder">
                                                    <div class="media">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                        <div class="media-body">
                                                            <p class="file-name">Important Docs.xml</p>
                                                            <p class="file-size">2.1MB</p>
                                                        </div>
                                                    </div>
                                                </div> -->

                                            </div>

                                        </div>
                                    </div>

                                    <?php }} ?>

                                </div>

                            </div>

                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="composeMailModal" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="modal"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        <div class="compose-box">
                                            <div class="compose-content">
                                                <form id="emailform" method="post" action="<?= $path ?>home/saveEmail" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-flex mb-4 mail-form">
                                                                <p>From:</p>
                                                                <select class="" id="m-form" name="from_email">
                                                                    <option value="info@mail.com">Info &lt;info@mail.com&gt;</option>
                                                                    <option value="shaun@mail.com">Shaun Park &lt;shaun@mail.com&gt;</option>
                                                                    <option value="tjraja97@gmail.com">Tallal Jamshed &lt;tjraja97@gmail.com&gt;</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="d-flex mb-4 mail-to">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                                <div class="">
                                                                    <input type="email" id="m-to" placeholder="To" class="form-control" name="to_email">
                                                                    <span class="validation-text"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="d-flex mb-4 mail-cc">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                                                <div>
                                                                    <input type="text" id="m-cc" placeholder="Cc" class="form-control" name="cc_email">
                                                                    <span class="validation-text"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex mb-4 mail-subject">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                                        <div class="w-100">
                                                            <input type="text" id="m-subject" placeholder="Subject" class="form-control" name="subject">
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex">
                                                        <input type="file" class="form-control-file" id="mail_File_attachment" multiple="multiple" name="email_attachments[]">
                                                    </div>
                                                    <textarea name="message" style="display:none" id="hiddenMessageArea"></textarea>
                                                    <div id="editor-container">

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button id="btn-save" class="btn float-left"> Save</button>
                                                        <button id="btn-reply-save" class="btn float-left"> Save Reply</button>
                                                        <button id="btn-fwd-save" class="btn float-left"> Save Fwd</button>

                                                        <button class="btn" data-dismiss="modal"> <i class="flaticon-delete-1"></i> Discard</button>

                                                        <button id="btn-reply" class="btn"> Reply</button>
                                                        <button id="btn-fwd" class="btn"> Forward</button>
                                                        <button id="btn-send" class="btn"> Send</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=$template?>assets/js/ie11fix/fn.fix-padStart.js"></script>
<script src="<?=$template?>plugins/editors/quill/quill.js"></script>
<script src="<?=$template?>plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="<?=$template?>plugins/notification/snackbar/snackbar.min.js"></script>
<script src="<?=$template?>assets/js/apps/custom-mailbox.js"></script>