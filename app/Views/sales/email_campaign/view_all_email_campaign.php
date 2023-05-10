<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <h4 class="page-head">View All Email Campaigns </h4>

            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <button type="button" onclick="LoadModal('sales/email_campaign/all_email_models/manage_email_campaign_form', 0,'modal-lg')"
                            class="btn btn-lg btn-primary btn-success" style="float: right;">Add
                    </button>

<!--                    --><?php //echo "<pre>" ; print_r($all_campaigns_list);?>

                    <div class="table-responsive mb-4 mt-5 ">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>SR.No</th>
                                <th>Create Date </th>
                                <th>Title</th>
                                <th>Subject </th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 0; foreach ($all_campaigns_list as $value) {  $cnt++; ?>
                            <tr>
                                <td><?=$cnt?></td>
                                <td><?=DATEFORMAT($value['SystemDate'])?></td>
                                <td><?=ucwords($value['Title'])?></td>
                                <td><?=$value['EmailSubject']?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                id="dropdownMenuReference1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1" style="will-change: transform;">
                                            <a class="dropdown-item" href="#" onclick="LoadModal('sales/email_campaign/all_email_models/manage_email_campaign_form', <?=$value['UID']?> ,'modal-lg')">Update</a>
                                            <a class="dropdown-item" href="#" onclick="DeleteEmailCampaign( <?=$value['UID']?>)">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script type="application/javascript">


    function DeleteEmailCampaign(id) {

        if (confirm('Are You Sure You Want To Delete This Record...')) {
            response = AjaxResponse("emailcampaign/delete_campaign_record", "UID=" + id);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }




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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });

</script>