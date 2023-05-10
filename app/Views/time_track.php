<?php

$session = session();
//$session->destroy();
//exit;
$agentInfo = $session->get($NewUserData);

//print_r($agentInfo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Time Track</title>
    <link href="<?= $template ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $template ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link rel="icon" type="image/x-icon" href="<?= $template ?>shield_logo_lala_services.png"/>

    <link rel="stylesheet" href="<?= $path ?>template/jquery_validator/validationEngine.jquery.css" type="text/css"/>
    <script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
    <script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= $path ?>template/jquery_validator/jquery.validationEngine.js" type="text/javascript"
            charset="utf-8"></script>
    <script src="<?= $path ?>template/jquery_validator/jquery.validationEngine-en.js" type="text/javascript"
            charset="utf-8"></script>

    <script type="text/javascript" charset="utf-8">
        localStorage.setItem('path', '<?= $path ?>');
        localStorage.setItem('template', '<?= $template ?>');
    </script>
    <script src="<?= $path ?>template/custom.js"></script>

    <style>
        .leadsbtn {
            width: 100%;
            margin-bottom: 8px;
            font-size: 300%;
        }

        .inputfield {
            font-size: 160%;
        }
    </style>
</head>
<!--final-->
<body>
<div class="container-fluid" style="margin-top: 7%">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h2 style="font-size: 350%;"
                                             class="text-center"><?php if ($agentInfo['id'] == 0) {
                            echo "LALA Services Login";
                        } else {
                            echo 'Welcome ' . $agentInfo['name'];
                        } ?> </h2></div>
                <?php if ($agentInfo['id'] == 0) { ?>
                    <div class="card-body">
                        <form style="font-size: 200%" method="post" action="<?= $path ?>time-track-login"
                              id="TimeTrackForm">

                            <div class="form-outline mb-4">
                                <label class="form-label " for="form2Example1">Email Address</label>
                                <input type="email" name="email" id="form2Example1" class=" inputfield form-control"/>
                            </div>

                            <div class="form-outline mb-4">
                                <label class="form-label " for="form2Example2">Password</label>
                                <input type="password" name="password" id="form2Example2"
                                       class="inputfield form-control"/>
                            </div>
                            <button type="submit" style="font-size: 185%;" class="btn btn-primary btn-block mb-4">Sign
                                in
                            </button>
                        </form>
                    </div>
                <?php } ?>
                <div class="text-center" style="font-size: 345%;"><span class="text-danger"><?= $_GET['msg'] ?></span>
                </div>
            </div>
        </div>
        <?php if ($agentInfo['id'] > 0) { ?>
            <div class="col-sm-12" id="TimeTrackDiv">

                <!--                <div class="alert alert-sucess">-->
                <!---->
                <!--                </div>-->
                <?php TimeTrackActions(); ?>
            </div>
            <div class="col-sm-12">
                <a href="<?= $path ?>time-track-logout" class="btn btn-danger btn-block mt-4 leadsbtn">Sign Out</a>
            </div>
        <?php } ?>
    </div>
</div>

<script>


    function UpdateUserTimeTrack(userid, track_type, stopid) {

        $('#TimeTrackDiv').html('<div class="alert alert-danger mb-4" role="alert" style="text-align:center;font-size: 250%;">Please Hold on for a Moment.</div>');
        setTimeout(function () {
            // alert("Code Start for Time Track (" + track_type + ") for User ID (" + userid + ")");
            response = AjaxResponse("form_process/update_user_time_track", "stopid=" + stopid + "&userid=" + userid + "&track_type=" + track_type);
            if (response.status == 'success') {
                location.reload();
                // GridMessages('MatureLeadAttachmentsEditForm', 'LeadsAttachmentsEditAjaxResponse', 'alert-success', rslt.message, 2000);
            } else {
                // GridMessages('MatureLeadAttachmentsEditForm', 'LeadsAttachmentsEditAjaxResponse', 'alert-danger', rslt.message, 3000);
            }
        }, 1000);


    }

</script>

</body>
</html>

