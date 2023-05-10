<?php


use App\Models\Users;


$userModel = new Users();

    $record_id;

    $Status = explode(':', $record_id);

    $user_id = $Status[0];
    $profileType = $Status[1];
    $userName = $Status[2];


    $Accesslevelkeys = $userModel->AccessLevelKeysType($user_id, trim($profileType," ") );

?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Current Access Level of <?=$userName ?></h5>
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
<form class="validate" method="post" action="#" id="UserKeysForm" name="UserKeysForm">
    <div class="modal-body">

        <div class="row">
            <?php if (count($Accesslevelkeys) > 0) {
                foreach ($Accesslevelkeys as $value) { ?>
                    <span class="badge badge-outline-success mt-2"><?php echo str_replace('_'," &rAarr; ",$value['AccessKey'])  ?></span></br>
                <?php }
            } else { ?>
                <span class="badge badge-outline-success mt-2">NO Record Found</span></br>
            <?php } ?>


        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <!--        <button type="button" class="btn btn-primary" >Save</button>-->
    </div>
</form>

<style>
    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>
<script>


</script>