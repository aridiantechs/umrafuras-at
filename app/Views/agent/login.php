<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= $HostThemes[$_SERVER['HTTP_HOST']]['title'] ?> MIS - Login</title>
    <link rel="icon" type="image/x-icon" href="<?= $path ?>template/<?= $HostThemes[$_SERVER['HTTP_HOST']]['logo'] ?>"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= $template ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= $template ?>assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <!-- <link href="<?= $path ?>template/<?= $hostdomain ?>-custom.css" rel="stylesheet" type="text/css"/> -->
    <link href="<?= $path ?>template/custom.css" rel="stylesheet" type="text/css"/>

    <link href="<?= $template ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/forms/theme-checkbox-radio.css">
    <link rel="stylesheet" type="text/css" href="<?= $template ?>assets/css/forms/switches.css">


</head>
<?php
$code = CAPTCHA();
?>
<body class="form">
<div class="form-container">
    <div class="form-form">
        <div class="form-form-wrap">
            <div class="form-container">
                <div class="login-form" id="login">
                    <h1 class="">Log In to <a href=""><span
                                    class="brand-name"> <br> MIS <?= $HostThemes[$_SERVER['HTTP_HOST']]['title'] ?></span></a>
                    </h1>
                    <p class="signup-link d-none">New Here? <a href="<?= $path ?>home/signup">Create an account</a></p>
                    <form method="post" action="#" id="LoginForm">
                        <div class="form">
                            <input type="hidden" id="LoginCaptcha" name="LoginCaptcha" value="<?= $code ?>">
                            <div id="username-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input id="Email" name="Email" type="text" class="form-control"
                                       placeholder="Email">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input id="LoginPassword" name="Password" type="password" class="form-control"
                                       placeholder="Password">
                            </div>
                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mr-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <select class="form-control"
                                        id="Year"
                                        name="Year"
                                        data-prompt-position="bottomLeft:20,35">
                                    <?php
                                    foreach ($UmrahCalendar as $item) {
                                        echo '<option value="'.$item['UID'].'">'.$item['Title'].'</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                            <div id="captcha-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-lock">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input id="InputLoginCaptcha" name="InputLoginCaptcha" type="text" class="form-control"
                                       placeholder="Kindly write yellow text as below" style="margin-bottom: 15px;"
                                       autocomplete="off">
                                <span style="float: left">
                                    <a href="<?= PATH . 'writable/apk' . '/' . $HostThemes[$_SERVER['HTTP_HOST']]['apk'] . ''; ?>"
                                       target="_blank">


                                  <svg style="margin-top: 35px;" xmlns="http://www.w3.org/2000/svg"
                                       xmlns:xlink="http://www.w3.org/1999/xlink" width="40" zoomAndPan="magnify"
                                       viewBox="0 0 30 30.000001" height="40" preserveAspectRatio="xMidYMid meet"
                                       version="1.0"><defs><clipPath id="id1"><path
                                                      d="M 7.703125 3.199219 L 22.21875 3.199219 L 22.21875 26.421875 L 7.703125 26.421875 Z M 7.703125 3.199219 "
                                                      clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path
                                                  fill="rgb(0%, 0%, 0%)"
                                                  d="M 7.703125 18.820312 C 7.703125 22.902344 10.949219 26.207031 14.960938 26.207031 C 18.972656 26.207031 22.21875 22.902344 22.21875 18.820312 L 22.21875 14.601562 L 7.703125 14.601562 Z M 19.234375 6.550781 L 21.410156 4.332031 L 20.5625 3.457031 L 18.175781 5.894531 C 17.203125 5.398438 16.125 5.105469 14.960938 5.105469 C 13.800781 5.105469 12.722656 5.398438 11.757812 5.894531 L 9.363281 3.457031 L 8.511719 4.332031 L 10.691406 6.550781 C 8.886719 7.890625 7.703125 10.042969 7.703125 12.488281 L 7.703125 13.542969 L 22.21875 13.542969 L 22.21875 12.488281 C 22.21875 10.042969 21.039062 7.890625 19.234375 6.550781 Z M 11.851562 11.433594 C 11.28125 11.433594 10.8125 10.960938 10.8125 10.378906 C 10.8125 9.800781 11.28125 9.324219 11.851562 9.324219 C 12.421875 9.324219 12.886719 9.800781 12.886719 10.378906 C 12.886719 10.960938 12.421875 11.433594 11.851562 11.433594 Z M 18.074219 11.433594 C 17.503906 11.433594 17.035156 10.960938 17.035156 10.378906 C 17.035156 9.800781 17.503906 9.324219 18.074219 9.324219 C 18.644531 9.324219 19.109375 9.800781 19.109375 10.378906 C 19.109375 10.960938 18.644531 11.433594 18.074219 11.433594 Z M 18.074219 11.433594 "
                                                  fill-opacity="1" fill-rule="nonzero"/></g></svg>
                                 </a></span>
                                <span class="CaptchaText" id="CaptchaText"><?= $code ?></span>
                            </div>

                            <div class="" id="LoginResponse"></div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper toggle-pass">
                                    <p class="d-inline-block">Show Password</p>
                                    <label class="switch s-primary">
                                        <input type="checkbox" id="toggle-password" class="d-none"
                                               onclick="ShowPassword()">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn_customized">Log In</button>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <a onClick="ShowDiv('forget');" class="forgot-pass-link"><u>Forgot Password?</u></a>
                                <a onClick="ShowDiv('register');" class="forgot-pass-link"><u>Register As B2B
                                        Client?</u></a>
                            </div>
                        </div>
                    </form>
                    <p class="terms-conditions">© <?= date("Y") ?> All Rights Reserved. </p>
                </div>
                <div class="forget-form d-none" id="forget">
                    <h1 class="">Password Recovery</h1>
                    <p class="signup-link">Enter your email and instructions will sent to you!</p>
                    <form class="text-left">

                        <div class="form">
                            <div id="email-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-at-sign">
                                    <circle cx="12" cy="12" r="4"></circle>
                                    <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                </svg>
                                <input id="email" name="email" type="text" value="" placeholder="Email">
                            </div>
                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn_customized float-right" value="">Reset</button>
                                </div>
                            </div>
                            <div class="field-wrapper">
                                <a onClick="ShowDiv('Login');" class="forgot-pass-link"><u>Login?</u></a>
                            </div>
                        </div>
                    </form>
                    <p class="terms-conditions">
                        &copy; <?= date("Y") ?> <?= $HostThemes[$_SERVER['HTTP_HOST']]['title'] ?>, All Rights
                        Reserved.</p>
                </div>
                <div class="register-form d-none" id="register">
                    <h1 class="">Register As <a href=""><span class="brand-name"> <br> B2B Client</span></a></h1>
                    <form method="post" action="#" id="B2BRegistrationForm" name="B2BRegistrationForm">
                        <input type="hidden" id="RegisterCaptcha" name="RegisterCaptcha" value="<?= $code ?>">
                        <input type="hidden" id="WebsiteID" name="WebsiteID" value="<?= $_SERVER['HTTP_HOST'] ?>">
                        <div class="form row">
                            <div class="col-md-6">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="FullName" name="FullName" type="text" class="form-control"
                                           placeholder="Full Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-lock">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="ContactPersonName" name="ContactPersonName" type="text"
                                           class="form-control"
                                           placeholder="Contact Person">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-mail">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="Email" name="Email" type="email" class="form-control"
                                           placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-phone-call">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg>
                                    <input id="PhoneNumber" name="PhoneNumber" type="text" class="form-control"
                                           placeholder="Phone Number" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="MobileNumber" name="MobileNumber" type="text" class="form-control"
                                           placeholder="Mobile Number" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper select2 mb-2">
                                    <select id="Country" name="Country" class="form-control"
                                            onChange="LoadCitiesDropdown(this.value)">
                                        <option value="">Select Country</option>
                                        <?= Countries('html') ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper select2 mb-2">
                                    <select class="form-control" id="City" name="City"></select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="Address" name="Address" type="text" class="form-control"
                                           placeholder="Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper select2 mb-2">
                                    <select id="IATALicense" name="IATALicense" class="form-control">
                                        <option value="">IATA License</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="password-field" class="field-wrapper select2 mb-2">
                                    <select id="UmrahAgreement" name="UmrahAgreement" class="form-control"
                                            onchange="GetCompanyName(this.value)">
                                        <option value="">Umrah Agreement</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 d-none" id="Company">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="CompanyName" name="CompanyName" type="text"
                                           class="form-control"
                                           placeholder="Company Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="username-field" class="field-wrapper input">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    <input id="ForgetRegisterCaptcha" name="ForgetRegisterCaptcha" type="text"
                                           class="form-control"
                                           placeholder="Kindly write yellow text as below" style="margin-bottom: 15px;"
                                           autocomplete="off">
                                    <span class="CaptchaText" id="CaptchaText"><?= $code ?></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="" id="B2BRegistrationResponse"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="field-wrapper">
                                    <a onclick="b2bRegistrationFormSubmit();"
                                       class="forgot-pass-link"><u>Register</u></a>
                                    <a onClick="ShowDiv('Login');" class="forgot-pass-link"><u>Back To Login?</u></a>

                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="terms-conditions">
                        &copy; <?= date("Y") ?> <?= $HostThemes[$_SERVER['HTTP_HOST']]['title'] ?>, All Rights
                        Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image"
             style="background-image:url('<?= $path ?>template/<?= $HostThemes[$_SERVER['HTTP_HOST']]['logo'] ?>')"></div>
    </div>
</div>

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $template ?>assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= $template ?>bootstrap/js/popper.min.js"></script>
<script src="<?= $template ?>bootstrap/js/bootstrap.min.js"></script>

<!-- END GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $template ?>assets/js/authentication/form-1.js"></script>
<script type="text/javascript" charset="utf-8">
    localStorage.setItem('path', '<?=$path?>');
    localStorage.setItem('template', '<?=$template?>');
</script>
<script src="<?= $path ?>template/custom.js"></script>

</body>
</html>
<script type="application/javascript">

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#City").html('<option value="">Select City</option>' + cities.html);

    }

    function GetCompanyName(Option) {
        if (Option == "Yes") {
            $("div#Company").removeClass("d-none");
        } else if (Option == "No") {
            $("div#Company").addClass("d-none");
        } else {
            $("div#Company").addClass("d-none");
        }

    }

    function ShowPassword() {
        var Pass = document.getElementById("LoginPassword");
        if (Pass.type === "password") {
            Pass.type = "text";
        } else {
            Pass.type = "password";
        }
    }


    function b2bRegistrationFormSubmit() {

        var Email = $("form#B2BRegistrationForm input#Email").val();
        var RegisterCaptcha = $("form#B2BRegistrationForm input#RegisterCaptcha").val();
        var ForgetRegisterCaptcha = $("form#B2BRegistrationForm input#ForgetRegisterCaptcha").val();

        if (Email == '') {
            $("form#B2BRegistrationForm input#Email").focus();
        } else if (ForgetRegisterCaptcha == '') {
            $("form#B2BRegistrationForm input#ForgetRegisterCaptcha").focus();
        } else {
            var phpdata = new window.FormData($("form#B2BRegistrationForm")[0]);
            response = AjaxUploadResponse("form_process/B2B_registration_form_submit", phpdata);

            if (response.status == 'success') {
                $("#B2BRegistrationResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                setTimeout(function () {
                    location.reload();
                }, 2000)
            } else {
                $("#B2BRegistrationResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
            }
        }


    }

    function ShowDiv(val) {
        if (val == 'forget') {

            $("div#login").addClass("d-none");
            $("div#forget").removeClass("d-none");

        } else if (val == 'login') {

            $("div#login").removeClass("d-none");
            $("div#forget").addClass("d-none");
            $("div#register").addClass("d-none");


        } else if (val == 'register') {
            $("div#login").addClass("d-none");
            $("div#forget").addClass("d-none");
            $("div#register").removeClass("d-none");

        } else {

            $("div#login").removeClass("d-none");
            $("div#forget").addClass("d-none");
            $("div#register").addClass("d-none");
        }
    }

    $("form#LoginForm").on("submit", function (event) {
        event.preventDefault();
        LoginSubmit();
    });

    function LoginSubmit() {

        var Email = $("form#LoginForm input#Email").val();
        var Password = $("form#LoginForm input#Password").val();
        var LoginCaptcha = $("form#LoginForm input#LoginCaptcha").val();
        var InputLoginCaptcha = $("form#LoginForm input#InputLoginCaptcha").val();

        if (Email == '') {
            $("form#LoginForm input#Email").focus();
        } else if (Password == '') {
            $("form#LoginForm input#Password").focus();
        } else if (InputLoginCaptcha == '') {
            $("form#LoginForm input#InputLoginCaptcha").focus();
        } else {
            var phpdata = $("form#LoginForm").serialize();
            response = AjaxResponse("form_process/system_user_form_submit", phpdata);
            // console.log(response);
            if (response.status == 'success') {
                $("#LoginResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                <?=(($page == 'login') ? 'location.href = "' . base_url() . '";' : 'location.reload();')?>;
            } else {
                $("#LoginResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
            }
        }

    }

    function PlzWait(type) {

    }

    setTimeout(function () {
        //LoadCitiesDropdown();
    }, 1000)
</script>
