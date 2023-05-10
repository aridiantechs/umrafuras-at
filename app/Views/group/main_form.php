<?php
$head = 'Create New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['group_data'];
}
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= $head ?> Group  </h5>
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
<form class="validate" method="post" action="#" id="GroupAddForm" name="GroupAddForm">
    <div class="modal-body">
        <input type="hidden" name="UID" id="UID" value="<?= $update_id ?>">
        <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Group Name</label>
                    <input type="text" class="form-control validate[required]" id="FullName" name="FullName"
                           placeholder="Full Name" value="<?= $profile['FullName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Agent">Agent</label>
                    <select class="form-control validate[required]" id="Agent" name="Agent">
                        <?php
                        if ($AgentLogged) {
                            echo '<option value="'.$session['agent_id'] .'">' . $session['agent_id'] . ' - ' . $session['name'] . '</option> </select>';
                        } else {
                            echo '<option value="">Please Select</option>';
                            foreach ($Agents as $Agent) {
                                $selected = ( ($profile['AgentID']==$Agent['UID']) ? 'selected' : '' );
                                echo '<option value="' . $Agent['UID'] . '"'.$selected.'>' . $Agent['FullName'] . '</option>';
                            }
                            echo '</select>';
                        } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="Agent">Embassy</label>
                    <select class="form-control validate[required]" id="Embassy"
                            name="Embassy">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($Embassies as $E) {
                            $selected = ( ($profile['Embassy']==$E['Title']) ? 'selected' : '' );
                            echo '<option value="' . $E['Title'] . '" '.$selected.'>' . $E['Title'] . '</option>
                            ';
                        } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Arrival Date</label>
                    <input type="date" class="form-control validate[required]" id="DepartureDate" name="DepartureDate"
                           placeholder="Departure Date" value="<?= $profile['DepartureDate'] ?>">
                </div>
            </div>
            <div class="col-md-12">
                <div class="" id="GroupAddResponse"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="GroupFormSubmit();">Save</button>
    </div>
</form>

<script>
    $("form#GroupAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function GroupFormSubmit() {

        var validate = $("form#GroupAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#GroupAddForm").serialize();
        response = AjaxResponse("form_process/group_form_submit", phpdata);

        if (response.status == 'success') {
            $("#GroupAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('group/index')?>";
            }, 2000)
        } else {
            $("#GroupAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>