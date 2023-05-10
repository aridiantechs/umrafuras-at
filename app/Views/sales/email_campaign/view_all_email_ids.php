<?php

use App\Models\EmailCampaignModel;

?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">

                <h4 class="page-head">View All Email Ids </h4>

            </div>



            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <a href="<?= $path ?>emailcampaign/add_email"
                       class="btn btn-lg btn-primary btn-success" style="float: right;">Add
                    </a>

                    <div class="table-responsive mb-4 mt-5 ">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th width="2px">SR.No</th>
                                <th> Name</th>
                                <th>Email</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php $cnt = 0;
                            foreach ($AllEmailLists as $value) {
                                $cnt++; $UpdateCode = base64_encode($value['Email']); ?>
                                <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?= ucwords($value['UserFullName']) ?></td>
                                    <td><?= $value['Email'] ?></td>
                                    <td>
                                        <?php
                                        $EmailStatus = new EmailCampaignModel();
                                        $name['data'] = $EmailStatus->SetEmailStatus($value['Email']);

                                        foreach ($name['data'] as $record) {
                                            $class = 'success';
                                            if ($record['Status'] == 'block') {
                                                $class = 'danger';
                                            }

                                            echo '<badge style="cursor: pointer;" class="badge badge-' . $class . ' badge-mini" onclick="StatusChange(' . $record['UID'] . ', \''.$record['Status'].'\' )">' . ucwords($record['listName']) . '</badge>';
                                        }

                                        ?>
                                    </td>
                                    <td width="2px">
                                        <a  class="badge badge-success badge-mini" href="<?=$path?>emailcampaign/update_email/<?=$UpdateCode?>">
                                            Update
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="cover-spin"></div>
        </div>
    </div>
</div>


<script type="application/javascript">

    function StatusChange(id,status){
        $('#cover-spin').show();
        response = AjaxResponse("emailcampaign/list_stats_change","UID=" + id  + "&Status=" + status );
        if(response.status=='success'){
            location.reload();
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

<style>
    #cover-spin {
        position:fixed;
        width:100%;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display : none;

    }

    @-webkit-keyframes spin {
        from {-webkit-transform:rotate(0deg);}
        to {-webkit-transform:rotate(360deg);}
    }

    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }

    #cover-spin::after {
        content:'';
        display:block;
        position:absolute;
        left:48%;top:40%;
        width:40px;height:40px;
        border-style:solid;
        border-color:#ffc107;
        border-top-color:transparent;
        border-width: 4px;
        border-radius:50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }


</style>