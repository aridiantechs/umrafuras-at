<link rel="stylesheet" type="text/css" href="<?= $template ?>plugins/jquery-step/jquery.steps.css">

<?php

use App\Models\Crud;

$Crud = new Crud();
$option = array();
foreach ($pilgrim_attachments as $attchmnt) {
    $option[$attchmnt['FileDescription']] = $attchmnt['FileID'];
}
//print_r($Agents);exit;

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-spacing">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4><?= (isset($pilgrim_data['UID']) ? 'Pilgrim Updation' : 'Ticket Pilgrim Registration') ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <form enctype="multipart/form-data" class="section contact validate" method="post"
                              action="#" id="PilgrimAddForm" name="PilgrimAddForm">
                            <input type="hidden" name="UID" id="UID"
                                   value="<?= (isset($pilgrim_data['UID']) ? '' . $pilgrim_data['UID'] . '' : '0') ?>">
                            <input type="hidden" name="passport_file" id="passport_file" value="">
                            <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">
                            <input type="hidden" name="DateOfIssue" id="DateOfIssue"
                                   value="<?= (($pilgrim_passport_data['DateOfIssue'] != '') ? $pilgrim_passport_data['DateOfIssue'] : '') ?>">
                            <input type="hidden" name="DateOfExpiry" id="DateOfExpiry"
                                   value="<?= (($pilgrim_passport_data['DateOfExpiry'] != '') ? $pilgrim_passport_data['DateOfExpiry'] : '') ?>">
                            <div id="PilgrimForm">
                                <h3 class="<?= (($AgentLogged) ? 'd-none' : '') ?>">Group Selection</h3>
                                <section class="<?= (($AgentLogged) ? 'd-none' : '') ?>">
                                    <div id="GroupDetails">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="country">Agents</label>
                                                            <?php
                                                            if ($session['account_type'] == "external_agent" || $session['account_type'] == "agent") {
//                                                                echo ' <span class="form-control"  id="Agent" name="Agent" placeholder="AgentName">' . $session['name'] . '</span>
//                                                                <input type="hidden" id="Agent" name="Agent" value="' . $session['id'] . '">';
                                                                echo '<select class="form-control validate[required]"  id="Agent" name="Agent" onchange="LoadGroupsByAgentID(this.value);">';
                                                                foreach ($AllAgents as $agent) {
                                                                    $selected = (($pilgrim_data['AgentUID'] == $agent['UID']) ? 'selected' : '');
                                                                    echo ' <option value="' . $agent['UID'] . '" ' . $selected . '>' . $agent['FullName'] . " (" . ucwords(str_replace("_", " ", $agent['Type'])) . ")" . '</option>  ';
                                                                }
                                                                echo '</select>';
                                                            } else {
                                                                echo '<select class="form-control validate[required]"  id="Agent" name="Agent" onchange="LoadGroupsByAgentID(this.value);">';
                                                                foreach ($AllAgents as $agent) {
                                                                    $selected = (($pilgrim_data['AgentUID'] == $agent['UID']) ? 'selected' : '');
                                                                    echo ' <option value="' . $agent['UID'] . '"' . $selected . '>' . $agent['FullName'] . '</option>  ';
                                                                }

                                                                echo '</select>';
                                                            } ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="country">Groups</label>
                                                            <select class="form-control validate[required]"
                                                                    id="Group"
                                                                    name="Group">
                                                                <option value="">Please Select</option><?php
                                                                //                                                                foreach ($Groups as $Group) {
                                                                //                                                                    $selected = (($pilgrim_data['GroupUID'] == $Group['UID']) ? 'selected' : '');
                                                                //                                                                    echo '<option value="' . $Group['UID'] . '" ' . $selected . '>' . $Group['FullName'] . '</option>';
                                                                //                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <h3>Personal </h3>
                                <section>
                                    <div id="PersonalDetails">
                                        <div class="row">
                                            <div class="col-lg-12 mx-auto">
                                                <div class="info">
                                                    <div class="row">
                                                        <div class="col-xl-2 col-lg-12 col-md-4">
                                                            <div class="upload mt-4 pr-md-4">
                                                                <input type="file" id="input-file-max-fs"
                                                                       name="UploadFile" id="UploadFile"
                                                                       class="dropify" style="height: 166px;"
                                                                       data-default-file="<?= (isset($pilgrim_data['UID']) ? '' . $path . 'home/load_file/' . $pilgrim_data['Profile'] . '' : ' ' . $path . 'home/load_file/0') ?>"/>
                                                                <p class="mt-2"><i
                                                                            class="flaticon-cloud-upload mr-1"></i>Upload
                                                                    Picture</p>
                                                                <!--                                                                        <img src="-->
                                                                <? //=$path?><!--home/load_file/-->
                                                                <? //=$pilgrim_data['Profile']?><!--" width="100">-->
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                            <div class="form">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="country">Title</label>
                                                                            <select class="form-control"
                                                                                    id="Title"
                                                                                    name="Title">
                                                                                <option value="">Please
                                                                                    Select
                                                                                </option>
                                                                                <?php
                                                                                $data['LookupsOptions'] = $Crud->LookupOptions('title_options');
                                                                                foreach ($data['LookupsOptions'] as $options) {
                                                                                    $selected = (($pilgrim_data['Title'] == $options['UID']) ? 'selected' : '');
                                                                                    echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="address">First
                                                                                Name</label>
                                                                            <input type="text"
                                                                                   class="form-control mb-4  validate[required]"
                                                                                   id="FirstName"
                                                                                   name="FirstName"
                                                                                   placeholder="First Name"
                                                                                   value="<?= $pilgrim_data['FirstName'] ?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="location">Last
                                                                                Name</label>
                                                                            <input type="text"
                                                                                   class="form-control mb-4  validate[required]"
                                                                                   id="LastName"
                                                                                   name="LastName"
                                                                                   placeholder="Last Name"
                                                                                   value="<?= $pilgrim_data['LastName'] ?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <label for="location">Gender</label>
                                                                            <select class="form-control"
                                                                                    id="Gender"
                                                                                    name="Gender">
                                                                                <option value="">Please Select</option>
                                                                                <option value="Male" <?= (($pilgrim_data['Gender'] == 'Male') ? 'selected' : '') ?> >
                                                                                    Male
                                                                                </option>
                                                                                <option value="Female" <?= (($pilgrim_data['Gender'] == 'Female') ? 'selected' : '') ?>>
                                                                                    Female
                                                                                </option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="phone">Relation </label>
                                                                            <select class="form-control"
                                                                                    id="Relation"
                                                                                    name="Relation">
                                                                                <option value="">Please Select</option>
                                                                                <?php
                                                                                foreach ($relations as $key => $value) {
                                                                                    $selected = (($pilgrim_data['Relation'] == $key) ? 'selected' : '');
                                                                                    echo '<option value="' . $key . '"' . $selected . '>' . $value . '</option>';
                                                                                }
                                                                                ?>
                                                                            </select>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="email">Country
                                                                            </label>
                                                                            <select class="form-control"
                                                                                    id="Countries"
                                                                                    name="Countries"
                                                                                    onChange="LoadCitiesDropdown(this.value)">
                                                                                <option value="">Please Select
                                                                                </option>
                                                                                <?= Countries('html', $pilgrim_data['Country']) ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="form-group">
                                                                            <label for="City">City
                                                                            </label>
                                                                            <select class="form-control" id="City"
                                                                                    name="City">
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="email">DOB
                                                                            </label>
                                                                            <input type="date"
                                                                                   class="form-control mb-4"
                                                                                   id="DOB" name="DOB"
                                                                                   placeholder="DOB"
                                                                                   value="<?= $pilgrim_data['DOB'] ?>">
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
                                </section>

                                <h3>Passport</h3>
                                <section>
                                    <div id="PassportDetail">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto">
                                                <input class="form-control float-right" id="PassportKey"
                                                       name="PassportKey" type="hidden"
                                                       style="width: 30%;margin-top: -12px;"
                                                >
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Passport Type</label>
                                                            <select class="form-control" id="PassportType"
                                                                    name="PassportType">
                                                                <option value="">Please Select</option><?php
                                                                foreach ($PassportTypes as $PT) {
                                                                    $selected = (($pilgrim_passport_data['PassportType'] == $PT) ? 'selected' : '');
                                                                    echo '<option value="' . $PT . '"' . $selected . ' >' . $PT . '</option>';
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="address">Passport No</label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="PassportNumber" name="PassportNumber"
                                                                   placeholder="Passport Number"
                                                                   value="<?= $pilgrim_passport_data['PassportNumber'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="phone">Nationality</label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="Nationality" name="Nationality"
                                                                   placeholder="Nationality "
                                                                   value="<?= $pilgrim_passport_data['Nationality'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="phone">Citizenship Number </label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="CitizenshipNumber"
                                                                   name="CitizenshipNumber"
                                                                   placeholder="Citizenship Number"
                                                                   value="<?= $pilgrim_passport_data['CitizenshipNumber'] ?>">
                                                        </div>
                                                    </div>

                                                    <?php
                                                    if ($pilgrim_data['UID'] != '') { ?>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="country">Issue Expiry</label>
                                                                <input type="text"
                                                                       class="form-control multidate validate[required,future[now]]"
                                                                       name="IssueExpiry" id="IssueExpiry" readonly
                                                                       placeholder="" value="
                                                                    <?= (($pilgrim_passport_data['DateOfIssue'] != '') ? $pilgrim_passport_data['DateOfIssue'] : date("Y-m-d")) ?> to
                                                                    <?= (($pilgrim_passport_data['DateOfExpiry'] != '') ? $pilgrim_passport_data['DateOfExpiry'] : date("Y-m-d")) ?>"
                                                                       onchange="GetIssueExpiryDate();">
                                                            </div>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="country">Issue Expiry</label>
                                                                <input type="text"
                                                                       class="form-control multidate validate[required,future[now]]"
                                                                       name="IssueExpiry" id="IssueExpiry" readonly
                                                                       placeholder="" value=" "
                                                                       onchange="GetIssueExpiryDate();">
                                                            </div>
                                                        </div>
                                                    <?php } ?>


                                                    <!--                                                    <div class="col-md-2">-->
                                                    <!--                                                        <div class="form-group">-->
                                                    <!--                                                            <label for="email">Date Of Issue</label>-->
                                                    <!--                                                            <input type="date" class="form-control mb-4"-->
                                                    <!--                                                                   id="DateOfIssue" name="DateOfIssue"-->
                                                    <!--                                                                   placeholder="Date Of Issue"-->
                                                    <!--                                                                   value="-->
                                                    <? //= $pilgrim_passport_data['DateOfIssue'] ?><!--">-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->
                                                    <!--                                                    <div class="col-md-2">-->
                                                    <!--                                                        <div class="form-group">-->
                                                    <!--                                                            <label for="email">Date Of Expiry</label>-->
                                                    <!--                                                            <input type="date" class="form-control mb-4"-->
                                                    <!--                                                                   id="DateOfExpiry" name="DateOfExpiry"-->
                                                    <!--                                                                   placeholder="Date Of Expiry"-->
                                                    <!--                                                                   value="-->
                                                    <? //= $pilgrim_passport_data['DateOfExpiry'] ?><!--">-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </div>-->
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="email">Tracking Number</label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="TrackingNumber" name="TrackingNumber"
                                                                   placeholder="Tracking Number"
                                                                   value="<?= $pilgrim_passport_data['TrackingNumber'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label for="email">Booklet Number</label>
                                                            <input type="text" class="form-control mb-4"
                                                                   id="BookletNumber" name="BookletNumber"
                                                                   placeholder="Booklet Number"
                                                                   value="<?= $pilgrim_passport_data['BookletNumber'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="email">Upload Passport</label>
                                                            <input type="file" class="form-control mb-4"
                                                                   id="UploadPassport" name="UploadPassport"
                                                                   placeholder="Upload Passport">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group" style="margin-top: 32px;">
                                                            <button id="multiple-reset" class="btn btn-primary"
                                                                    type="button"
                                                                    onclick="PassportScanSubmit()">Scan
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="email">Front Picture </label>
                                                            <input type="file"
                                                                   class="form-control mb-4  <?= (($option['PassportFrontPic'] > 0) ? '' : 'validate[required]') ?>"
                                                                   id="PassportFront" name="PassportFront"
                                                                   placeholder="Passport Front">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="email">Back Picture </label>
                                                            <input type="file"
                                                                   class="form-control mb-4  <?= (($option['PassportBackPic'] > 0) ? '' : 'validate[required]') ?>"
                                                                   id="PassportBack" name="PassportBack"
                                                                   placeholder="Passport Back">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="email">Booklet Picture</label>
                                                            <input type="file"
                                                                   class="form-control mb-4  <?= (($option['PassportBookletPic'] > 0) ? '' : 'validate[required]') ?>"
                                                                   id="PassportBooklet" name="PassportBooklet"
                                                                   placeholder="Passport Booklet">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4  <?= (isset($pilgrim_data['UID']) ? '' : 'd-none') ?>">
                                                        <?php
                                                        echo '<div class="grid-img" style="background-image: url(\'' . $path . "home/load_file/" . $option['PassportFrontPic'] . '\');">
                                                                          </div>';
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4  <?= (isset($pilgrim_data['UID']) ? '' : 'd-none') ?>">
                                                        <?php
                                                        echo '<div class="grid-img" style="background-image: url(\'' . $path . "home/load_file/" . $option['PassportBackPic'] . '\');">
                                                                          </div>';
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4  <?= (isset($pilgrim_data['UID']) ? '' : 'd-none') ?>">
                                                        <?php
                                                        echo '<div class="grid-img" style="background-image: url(\'' . $path . "home/load_file/" . $option['PassportBookletPic'] . '\');">
                                                                         </div>';
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <h3>Documents </h3>
                                <section>
                                    <div id="DocumentsDetails">
                                        <div class="row">
                                            <div class="col-md-12 mx-auto" id="Attachmnets">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-4">
                                                            <label for="Address">Description</label>
                                                            <input type="text" class="form-control"
                                                                   id="FileDescription" name="FileDescription[]"
                                                                   placeholder="File Description">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group mb-4">
                                                            <label for="Address">Attach File</label>
                                                            <input type="file" class="form-control"
                                                                   id="AttachFiles" name="AttachFiles[]"
                                                                   placeholder="Contact Person Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group mb-4">
                                                            <a href="#" id="AddPilgrimAttachmnet"
                                                               onclick="AddNewPilgrimAttachmentRow();"><span><i
                                                                            class="fa fa-plus float-right"
                                                                            title="Add More"></i></span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!--                                <h3>Account Details </h3>-->
                                <!--                                <section>-->
                                <!--                                    <div id="AccountDetails">-->
                                <!--                                        <div class="row">-->
                                <!--                                            <div class="col-md-12 mx-auto">-->
                                <!--                                                <div class="row -->
                                <? //= (isset($pilgrim_data['UID']) ? 'd-none' : '') ?><!--">-->
                                <!--                                                    <div class="col-md-6">-->
                                <!--                                                        <div class="form-group">-->
                                <!--                                                            <label for="phone">Email</label>-->
                                <!--                                                            <input type="email"-->
                                <!--                                                                   class="form-control mb-4  validate[required]"-->
                                <!--                                                                   id="Email" name="Email"-->
                                <!--                                                                   placeholder="Email"-->
                                <!--                                                                   value="">-->
                                <!--                                                        </div>-->
                                <!--                                                    </div>-->
                                <!--                                                    <div class="col-md-6">-->
                                <!--                                                        <div class="form-group">-->
                                <!--                                                            <label for="phone">Password</label>-->
                                <!--                                                            <input type="password"-->
                                <!--                                                                   class="form-control mb-4  validate[required]"-->
                                <!--                                                                   id="Password"-->
                                <!--                                                                   name="Password"-->
                                <!--                                                                   placeholder="Password"-->
                                <!--                                                                   value="">-->
                                <!--                                                        </div>-->
                                <!--                                                    </div>-->
                                <!--                                                </div>-->
                                <!--                                                <div class="row -->
                                <? //= (isset($pilgrim_data['UID']) ? '' : 'd-none') ?><!--">-->
                                <!--                                                    <div class="col-md-12">-->
                                <!--                                                        <h6> Login Details </h6>-->
                                <!--                                                        <hr>-->
                                <!--                                                    </div>-->
                                <!--                                                    <div class="table-responsive">-->
                                <!--                                                        <table class="table table-bordered table-striped">-->
                                <!--                                                            <thead>-->
                                <!--                                                            <tr>-->
                                <!--                                                                <th>#</th>-->
                                <!--                                                                <th>Domain Name</th>-->
                                <!--                                                                <th>Email</th>-->
                                <!--                                                                <th>IP Address</th>-->
                                <!--                                                                <th>Last Login Date</th>-->
                                <!--                                                                <th>Status</th>-->
                                <!--                                                                <th>Actions</th>-->
                                <!--                                                            </tr>-->
                                <!--                                                            </thead>-->
                                <!--                                                            <tbody>-->
                                <!--                                                            --><?php
                                //                                                            if (count($AccountsData) > 0) {
                                //                                                                $cnt = 0;
                                //                                                                foreach ($AccountsData as $AD) {
                                //                                                                    $cnt++;
                                //                                                                    echo '
                                //                                                                        <tr>
                                //                                                                        <td>' . $cnt . '</td>
                                //                                                                        <td>' . $AD['DomainName'] . '</td>
                                //                                                                        <td>' . $AD['Email'] . '</td>
                                //                                                                        <td>' . $AD['LastLoginIPAddress'] . '</td>
                                //                                                                        <td>' . $AD['LastLoginDateTime'] . '</td>
                                //                                                                        <td>' . (($AD['Status'] == '0') ? '<a href="#" onclick="ChangePilgrimStatus(' . $AD['Status'] . ',' . $AD['UID'] . ');" title="Change Status"> <span class="badge badge-success"> Active </span> </a>' : '<a href="#" onclick="ChangePilgrimStatus(' . $AD['Status'] . ',' . $AD['UID'] . ');" title="Change Status"> <span class="badge badge-danger"> Blocked </span> </a>') . '</td>
                                //                                                                        <td><a href="#" onclick="LoadModal(\'load_ip_api\',\'' . $AD['LastLoginIPAddress'] . '\')"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cast"><path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path><line x1="2" y1="20" x2="2.01" y2="20"></line></svg></a></td>
                                //                                                                        </tr>
                                //                                                                        ';
                                //                                                                }
                                //                                                            } else {
                                //                                                                echo '<tr> <td colspan="7" style="text-align: center; color: #dda420">No Record Found</td></tr>';
                                //                                                            }
                                //                                                            ?>
                                <!--                                                            </tbody>-->
                                <!--                                                        </table>-->
                                <!--                                                    </div>-->
                                <!--                                                </div>-->
                                <!--                                            </div>-->
                                <!--                                            <div class="col-md-12">-->
                                <!--                                                <button id="multiple-messages" class="btn btn_customized float-right" onclick="PigrimFormSubmit()">Save-->
                                <!--                                                    Changes-->
                                <!--                                                </button>-->
                                <!--                                            </div>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </section>-->

                            </div>
                        </form>


                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 layout-top-spacing">
                <div class="" id="PilgrimAddResponse"></div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script>


    setTimeout(function () {

        LoadCitiesDropdown('<?=$pilgrim_data['Country']?>');
        <?php if ($session['account_type'] == "external_agent") { ?>
        LoadGroupsByAgentID('<?=$session['id']?>');
        <?php } else { ?>
        LoadGroupsByAgentID('<?=$pilgrim_data['AgentUID']?>');
        <?php } ?>
    }, 100);

    function ChangePilgrimStatus(status, row_id) {
        if (confirm("Are You Sure You Want To Change Status?")) {
            var response = AjaxResponse('form_process/pilgrim_status_change_process', "status=" + status + "&row_id=" + row_id);
            if (response.status == 'success') {
                setTimeout(function () {
                    location.reload();
                }, 10)
            }
        }
    }

    function LoadGroupsByAgentID(id) {
        if (id > 0) {
            GroupsHtml = AjaxResponse("html/GetGroupByAgentID", "id=" + id + "&selected=<?= $pilgrim_data['GroupUID'] ?>");
            $("#Group").html(GroupsHtml.grouphtml);
        }
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$pilgrim_data['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);

    }


    function AddNewPilgrimAttachmentRow() {
        AttachmentCount = parseInt($("#AttachmentCount").val());

        HTML = PilgrimAttachmentsFormHTML(AttachmentCount);
        $("#Attachmnets").append(HTML);
        $("#AttachmentCount").val(AttachmentCount + 1);

        return false;
    }

    function GetIssueExpiryDate() {

        const IssueExpiry = $("#IssueExpiry").val();
        const words = IssueExpiry.split(' to ');
        $("#DateOfIssue").val(words[0]);
        $("#DateOfExpiry").val(words[1]);


    }

    function PilgrimAttachmentsFormHTML(cnt) {
        cnt = cnt + 1;
        var html;

        html = '<div class="row" id="AttachmentCount' + cnt + '" name="AttachmentCount">\n' +
            '                    <div class="col-md-5"> <div class="form-group mb-4"><label for="Address">Description</label>\n' +
            '                            <input type="text" class="form-control" id="Address" name="FileDescription[]" placeholder="File Description" ></div>\n' +
            '                    </div>\n' +
            '                    <div class="col-md-5">\n' +
            '                        <div class="form-group mb-4"><label for="Address">Attach File</label><input type="file" class="form-control" id="AttachFiles" name="AttachFiles[]" placeholder="Contact Person Name"> </div>\n' +
            '                    </div>\n' +
            '                    <div class="col-md-2"> <div class="form-group mb-4"> <div class="col-md-12" style="margin-top: 45px;">\n' +
            '                                <a name="rowremoveButton" href="javascript:void(0);" id="rowremoveButton"><span><i class="fa fa-trash" title="Remove" onClick="RemoveAttachmentRow(' + cnt + ')"></i></span></a>\n' +
            '                            </div></div></div></div> ';
        return html;
    }

    function RemoveAttachmentRow(cnt) {

        AttachmentCount = parseInt($("#AttachmentCount").val());
        $('#AttachmentCount' + cnt).remove();
        $("#AttachmentCount").val(AttachmentCount - 1);
    }

    function PigrimFormSubmit() {
        $("#PassportKey").removeAttr("disable");
        var validate = $("form#PilgrimAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#PilgrimAddForm")[0]);
        response = AjaxUploadResponse("form_process/pilgrim_form_submit", phpdata);

        if (response.status == 'success') {
            $("#PilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#PilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    function PassportScanSubmit() {

        var phpdata = new window.FormData($("form#PilgrimAddForm")[0]);
        response = AjaxUploadResponse("form_process/passport_scan_fom_submit", phpdata);
        //alert(response.passport.data.MRZdata.date_of_expiry);
        if (response.status == 'success') {
            $("#PassportKey").val(response.passport.data.MRZdata.MRZ);
            $("form#PilgrimAddForm #passport_file").val(response.passport_file);
            $("form#PilgrimAddForm #PassportNumber").val(response.passport.data.MRZdata.document_no);
            $("form#PilgrimAddForm #FirstName").val(response.passport.data.MRZdata.first_name);
            $("form#PilgrimAddForm #LastName").val(response.passport.data.MRZdata.last_name);
            $("form#PilgrimAddForm #CitizenshipNumber").val(response.passport.data.MRZdata.other_id);
            $("form#PilgrimAddForm #DateOfExpiry").val(response.passport.data.MRZdata.date_of_expiry);
        } else {
            $("#PassportKey").html('Something wrong with Passport Scan APIs, Please try again...')
        }
    }

</script>
<script src="<?= $template ?>plugins/jquery-step/jquery.steps.min.js"></script>

<script>
    $("#PilgrimForm").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: false,
        cssClass: 'pill wizard',
        onFinished: function (event, currentIndex) {
            PigrimFormSubmit();
        }
    });
</script>