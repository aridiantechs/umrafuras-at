
<?php
$session = session();
$session = $session->get();
$profile = $records['Users_record'];
//echo "<pre>";
//print_r($profile);exit;
?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Today Follow</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button>
</div>
<div class="modal-body ">
    <div class="">
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="table-responsive" style="overflow: auto">
                <table style="margin-bottom: 0px !important;" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ref.ID</th>
                        <th>Created At</th>
                        <th>Full Name</th>

                        <th>CallBack DateTime</th>
                        <th>Product</th>
                        <th>Agent</th>
                        <th>Status</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $cnt = 0; foreach ($profile  as $value) { $cnt++;




                        ?>
                        <tr>
                            <td><?=$cnt;?></td>
                            <td><?php echo '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                                    '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>'; ?></td>
                            <td><?=DATEFORMAT($value['CreatedAt'])?></td>
                            <td><?=ucwords($value['FullName'])?></td>

                            <td><?php if($value['CallBackDateTime'] != NULL && $value['CallBackDateTime'] != ''  ){ echo date("d M, Y h:i A", strtotime($value['CallBackDateTime'])); } else{ echo "-" ;}       ?></td>
                            <td><?php $array = explode(",", $value['ProductName']);
                                foreach ( $array as $Record) {
                                    echo '<badge class="badge badge-success">'.ucwords($Record).'</badge>';
                                }
                                ?>
                            </td>
                            <td><?=ucwords($value['AgentName'])?></td>
                            <td> <badge class="badge badge-success"><?=ucwords(str_replace('_', ' ', $value['Status']))?></badge>  </td>

                        </tr>
                    <?php } ?>



                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Close</button>
</div>
<style>
    .table th, td {
        padding: .25rem !important;
    }

    .table th {
        font-size: 10px !important;
    }
</style>
<script>

</script>