<link href="<?= $template ?>summernote/summernote-lite.min.css" rel="stylesheet">
<script src="<?= $template ?>summernote/summernote-lite.min.js"></script>
<style>
    .note-editable { background-color: #1b2e4b!important; color: white!important; }
</style>
<h4 class="mb-4">Manage Pages Content</h4>
<ul class="nav nav-tabs  mb-3 mt-3 justify-content-center" id="justifyCenterTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="justify-center-home-tab" data-toggle="tab" href="#justify-center-content-home" role="tab" aria-controls="justify-center-home" aria-selected="true">Pages</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="justify-center-profile-tab" data-toggle="tab" href="#justify-center-content-profile" role="tab" aria-controls="justify-center-profile" aria-selected="false">Add New</a>
    </li>
    <li class="nav-item UpdateTab" style="display: none">
        <a class="nav-link" id="justify-center-update-tab" data-toggle="tab" href="#justify-center-content-update" role="tab" aria-controls="justify-center-update" aria-selected="false">Update</a>
    </li>
</ul>

<div class="tab-content" id="justifyCenterTabContent">
    <div class="tab-pane fade show active" id="justify-center-content-home" role="tabpanel" aria-labelledby="justify-center-home-tab">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                    <table id="MainContentRecords" class="table table-hover non-hover"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Page Slug</th>
                            <th>Content Title</th>
                            <th>Content</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody><?php
                        $cnt = 0;
                        foreach ($pages['contentsMeta'] as $record) {
                            $cnt++;
                            $actions = '
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                        <a class="dropdown-item" href="#" onclick="LoadUpdateTab(' . $record['UID'] . ')">Update</a>
                        <a class="dropdown-item" href="#" onclick="DeletePageContent(' . $record['UID'] . ');">Delete</a>
                    </div>';

                            echo '
                    <tr>
                        <td>' . $cnt . '</td>                                
                        <td>' . $record['PagePhysical']. '</td>                                
                        <td>' . $record['Key'] . '</td>
                        <td>' . $record['Description'] . '</td>
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
    <div class="tab-pane fade" id="justify-center-content-profile" role="tabpanel" aria-labelledby="justify-center-profile-tab">
        <form enctype="multipart/form-data" class="validate" method="post" action="#" id="ContentUpdateForm" name="ContentUpdateForm">
            <input type="hidden" name="UID" value="0">
            <input type="hidden" name="DomainID" value="<?= $DomainID ?>">
            <div class="col-md-12 mx-auto">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="FullName">Page Physical</label>
                            <input type="text" class="form-control" id="Name"
                                   name="physical" placeholder="Page Physical"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="contentTitle"
                                   name="contentTitle" placeholder="Content Title"
                                   value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label for="FullName">Description</label>
                            <textarea id="ContentDescription"
                                      name="ContentDescription"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="ContentAddResponse"></div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="button" class="btn btn-primary" onclick="ContentFormSubmit();">Update</button>
            </div>
        </form>
    </div>
    <div class="tab-pane fade" id="justify-center-content-update" role="tabpanel" aria-labelledby="justify-center-update-tab">

    </div>
</div>

<script type="application/javascript">
    $('#MainContentRecords').DataTable({
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
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });

    function DeletePageContent(UID) {
        if (confirm("Are You Want To Remove This Content")) {
            response = AjaxResponse("web_form_process/remove_page_content", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=SeoUrl("web_admin/index/".$DomainID."-".$DomainData['FullName'])?>";
            }
        }
    }

    $(document).ready(function () {
        $('#ContentDescription').summernote(
            {
                height: 250,
                minHeight: null,
                maxHeight: null,
                focus: true,
                background: '#1b2e4b'
            }
        );
    });

    $("form#ContentAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function ContentFormSubmit() {
        var validate = $("form#ContentAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#ContentAddForm")[0]);
        response = AjaxUploadResponse("web_form_process/content_form_submit", phpdata);

        if (response.status == 'success') {
            $("#ContentAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=SeoUrl("web_admin/index/".$DomainID."-".$DomainData['FullName'])?>";
            }, 2000)
        } else {
            $("#ContentAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    $("form#PagesUpdateForm").on("submit", function (event) {
        event.preventDefault();
    });

    function ContentFormUpdateSubmit() {
        var validate = $("form#ContentUpdateForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#ContentUpdateForm")[0]);
        response = AjaxUploadResponse("web_form_process/content_form_submit", phpdata);

        if (response.status == 'success') {
            $("#ContentUpdateResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=SeoUrl("web_admin/index/".$DomainID."-".$DomainData['FullName'])?>";
            }, 2000)
        } else {
            $("#ContentUpdateResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    function LoadUpdateTab(id) {
        tabData = AjaxResponse("html/GetPageContentUpdateTab", "UID=" + id);

        if (tabData.status == 'success') {
            $("#justify-center-update").html(tabData.html);
            $('#justify-center-update #Description').summernote(
                {
                    height: 250,
                    minHeight: null,
                    maxHeight: null,
                    focus: true
                }
            );
            $(".UpdateTab").show();
            $(".UpdateTab a").click();
        }
    }

</script>