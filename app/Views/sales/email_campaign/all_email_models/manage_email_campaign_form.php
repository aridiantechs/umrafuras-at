<?php

$head = 'Add  ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
    $profile = $records['email_campaigns_data'];


}

?>

<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Manage Email Campaigns  </h5>
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

<form class="validate" method="post" action="#" id="EmailCampaignsForm" name="EmailCampaignsForm">
    <input type="hidden" name="UID" value="<?= $profile['UID'] ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Title">Title</label>
                    <input type="text" class="form-control validate[required]" id="title" name="title"
                           placeholder="Title" value="<?= $profile['Title'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="fname">Sender First Name </label>
                    <input type="text" class="form-control validate[required]" id="senderfirstname"
                           name="senderfirstname"
                           placeholder="Sender First Name" value="<?= $profile['SenderFirstName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="lname">Sender Last Name </label>
                    <input type="text" class="form-control validate[required]" id="senderlastname" name="senderlastname"
                           placeholder="Sender Last Name" value="<?= $profile['SenderLastName'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="email">Sender Email </label>
                    <input type="text" class="form-control validate[required]" id="senderemail" name="senderemail"
                           placeholder="Sender Email" value="<?= $profile['SenderEmail'] ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="design">Email Design</label>
                    <select class="form-control validate[required]" id="emaildesign"
                            name="emaildesign">
                        <option value="" selected disabled>Please Select</option>
                        <?php foreach ($EmailDesign as $key => $value) {
                            $selected = (($profile['EmailTemplate'] == $key ?  'Selected' : '' ));
                            echo ' <option value="' . $key . '"  '.$selected.'  >' . $value . '</option>';
                        } ?>
                    </select>
                </div>
            </div>



            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="execute_email">Execute Date </label>
                    <input type="date" class="form-control validate[required]" id="execute_email" name="execute_email"
                           placeholder="Execute Date" value="<?php if($update_id == 0){  echo date('Y-m-d'); } else {  echo $profile['ExecDate'];  } ?>"
                           min="<?php echo date("Y-m-d"); ?>">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="email_subject"> Email Subject</label>
                    <input type="text" class="form-control validate[required]" id="email_subject" name="email_subject"
                           placeholder=" Email  Subject" value="<?= $profile['EmailSubject'] ?>">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="email_body"> Body</label>
                    <textarea class="form-control validate[required]" name="email_body" rows="8"
                              id="email_body"><?= $profile['EmailBody'] ?></textarea>
                </div>
            </div>


            <div class="col-md-12 ">
                <div class="" id="Status"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="button" class="btn btn-primary" onclick="SaveEmailCampaignForm()">Save</button>
    </div>
</form>

<script>


    function SaveEmailCampaignForm() {
        var validate = $("form#EmailCampaignsForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = $("form#EmailCampaignsForm").serialize();
        response = AjaxResponse('emailcampaign/save_email_campaign_log', phpdata)
        if (response.status == 'success') {
            $("#Status").html('<div class="text-center alert alert-success mb-4" role="alert">  <strong>Success!</strong> ' + response.message + ' </div>')
            $("form#EmailCampaignsForm").trigger("reset");
            location.reload();
        } else if (response.status == 'alert') {
            $("#Status").html('<div class="text-center alert alert-danger mb-4" role="alert">  <strong>Sorry!</strong> ' + response.message + ' </div>')
        }
    }

</script>