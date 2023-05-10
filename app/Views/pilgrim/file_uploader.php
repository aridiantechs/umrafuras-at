<!--  BEGIN CONTENT AREA  -->
<link href="<?= $template ?>assets/css/components/tabs-accordian/custom-tabs.css" rel="stylesheet" type="text/css"/>
<?php

use App\Models\Crud;

$Crud = new Crud();
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Upload Files
                </h4>

            </div>
            <div class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Files Uploader</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area border-tab">
                        <ul class="nav nav-tabs mt-3" id="border-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="border-home-tab" data-toggle="tab" href="#border-home"
                                   role="tab" aria-controls="border-home" aria-selected="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    Mofa</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="border-profile-tab" data-toggle="tab" href="#border-profile"
                                   role="tab" aria-controls="border-profile" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Elm</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="border-contact-tab" data-toggle="tab" href="#border-contact"
                                   role="tab" aria-controls="border-contact" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-phone">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                    Checkout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="border-city-tab" data-toggle="tab" href="#border-city"
                                   role="tab" aria-controls="border-contact" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg>
                                    City Cover Uploader</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="border-visa-tab" data-toggle="tab" href="#border-visa"
                                   role="tab" aria-controls="border-contact" aria-selected="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round" class="feather feather-user">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Visa Uploader</a>
                            </li>
                        </ul>
                        <div class="tab-content mb-4" id="border-tabsContent">
                            <div class="tab-pane fade show active" id="border-home" role="tabpanel"
                                 aria-labelledby="border-home-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="collapsed" data-toggle="collapse"
                                                 data-target="#FilterDetails" aria-expanded="false"
                                                 aria-controls="FilterDetails">
                                                Add File
                                            </div>
                                        </section>
                                    </div>
                                    <div class="card-body">
                                        <form enctype="multipart/form-data" method="post" action="#"
                                              id="MOFAIssuedFilesForm" name="MOFAIssuedFilesForm">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group pull-right">
                                                                <label for="Name">Upload File</label>
                                                                <input type="file" class= "form-control" id="UploadFiles"
                                                                       name="UploadFiles"
                                                                       placeholder="Upload File">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="" id="MOFAFileAddResponse"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="submit float-right">
                                                                <button type="button" class="btn btn_customized"
                                                                        onclick="MOFAFileFormSubmit('MOFAIssuedFilesForm');">
                                                                    Upload
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <table id="MainRecords" class="table table-responsive non-hover customized_table display nowrap"
                                           style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Operator</th>
                                            <th>Ext Agent</th>
                                            <th>Group</th>
                                            <th>Print Date</th>
                                            <th>Pilgrim Name</th>
                                            <th>Pilgrim ID</th>
                                            <th>Age</th>
                                            <th>DOB</th>
                                            <th>Group Name</th>
                                            <th>Passport No</th>
                                            <th>MOFA No</th>
                                            <th>Issue Date Time</th>
                                            <th>Embassy</th>
                                            <th>PKG Code</th>
                                            <th>Relation</th>
                                            <th>Nationality</th>
                                            <th>Address</th>
                                            <th>Sub Agent Name</th>
                                            <th>MOI Number</th>
                                            <th>Insurance Policy ID</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(isset($records))
                                        foreach ($records as $record) { ?>
                                            <tr>
                                                <td> <?php echo $record['Operator']; ?></td>
                                                <td> <?php echo $record['ExtAgent']; ?></td>
                                                <td> <?php echo $record['Group']; ?></td>
                                                <td> <?php echo $record['PrintDate']; ?></td>
                                                <td> <?php echo $record['PilgrimName']; ?></td>
                                                <td> <?php echo $record['PilgrimID']; ?></td>
                                                <td> <?php echo $record['Age']; ?></td>
                                                <td> <?php echo DATEFORMAT($record['DOB']); ?></td>
                                                <td> <?php echo $record['GroupName']; ?></td>
                                                <td> <?php echo $record['PassportNo']; ?></td>
                                                <td> <?php echo $record['MOFANumber']; ?></td>
                                                <td> <?php echo $record['IssueDateTime']; ?></td>
                                                <td> <?php echo $record['Embassy']; ?></td>
                                                <td> <?php echo $record['PKGCode']; ?></td>
                                                <td> <?php echo $record['Relation']; ?></td>
                                                <td> <?php echo $record['Nationality']; ?></td>
                                                <td> <?php echo $record['Address']; ?></td>
                                                <td> <?php echo $record['SubAgentName']; ?></td>
                                                <td> <?php echo $record['MOINumber']; ?></td>
                                                <td> <?php echo $record['INSURANCE_POLICY_ID']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="border-profile" role="tabpanel"
                                 aria-labelledby="border-profile-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="collapsed" data-toggle="collapse"
                                                 data-target="#FilterDetails" aria-expanded="false"
                                                 aria-controls="FilterDetails">
                                                Add File
                                            </div>
                                        </section>
                                    </div>
                                    <div class="card-body">
                                        <form enctype="multipart/form-data" method="post" action="#"
                                              id="WOUPilgrimIssuedFilesForm" name="WOUPilgrimIssuedFilesForm">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group pull-right">
                                                                <label for="Name">Upload File</label>
                                                                <input type="file" class="form-control" id="UploadFile"
                                                                       name="UploadFiles"
                                                                       placeholder="Upload File">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="" id="WOUPilgrimAddResponse"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="submit float-right">
                                                                <button type="button" class="btn btn_customized"
                                                                        onclick="VOUPilgrimFileFormSubmit('WOUPilgrimIssuedFilesForm');">
                                                                    Upload
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <table id="MainRecord" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Group Name</th>
                                            <th>Pilgrim ID</th>
                                            <th>Pilgrim Name</th>
                                            <th>Birth Date</th>
                                            <th>Passport No</th>
                                            <th>MOI Number</th>
                                            <th>Visa No</th>
                                            <th>Entry Date</th>
                                            <th>Entry Time</th>
                                            <th>Entry Port</th>
                                            <th>Transport Mode</th>
                                            <th>Entry Carrier</th>
                                            <th>Flight No</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $cnt = 0;
                                        if(isset($ELMDATA))
                                        foreach ($ELMDATA as $ELMData) {
                                            $cnt++;
                                            echo '
                                            <tr>
                                            <td>' . $cnt . '</td>
                                            <td>' . $ELMData['GroupName'] . '</td>
                                            <td>' . $ELMData['PilgrimID'] . '</td>
                                            <td>' . $ELMData['FirstName'] . '</td>
                                            <td>' . date("d M, Y ", strtotime($ELMData['BirthDate'])) . '</td>
                                            <td>' . $ELMData['PassportNo'] . '</td>
                                            <td>' . $ELMData['MOINumber'] . '</td>
                                            <td>' . $ELMData['VisaNo'] . '</td>
                                            <td>' . date("d M, Y ", strtotime($ELMData['EntryDate'])) . '</td>
                                            <td>' . $ELMData['EntryTime'] . '</td>
                                            <td>' . $ELMData['EntryPort'] . '</td>
                                            <td>' . $ELMData['TransportMode'] . '</td>
                                            <td>' . $ELMData['EntryCarrier'] . '</td>
                                            <td>' . $ELMData['FlightNo'] . '</td>
                                            </tr>
                                            
                                            ';
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="border-contact" role="tabpanel"
                                 aria-labelledby="border-contact-tab">
                                <p class="dropcap  dc-outline-primary">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                </p>
                            </div>
                            <div class="tab-pane fade" id="border-city" role="tabpanel"
                                 aria-labelledby="border-city-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="collapsed" data-toggle="collapse"
                                                 data-target="#FilterDetails" aria-expanded="false"
                                                 aria-controls="FilterDetails">
                                                Add Cover Image
                                            </div>
                                        </section>
                                    </div>
                                    <div class="card-body">
                                        <form enctype="multipart/form-data" method="post" action="#"
                                              id="CtyCoverAddForm" name="CtyCoverAddForm">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group pull-right">
                                                                <label for="Name">Country</label>
                                                                <select class="form-control validate[required]"
                                                                        id="Country"
                                                                        name="Country"
                                                                        onChange="LoadCitiesDropdown(this.value)">
                                                                    <option value="">Please Select</option>
                                                                    <?= Countries("html") ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group pull-right">
                                                                <label for="Name">Cities</label>
                                                                <select class="form-control" id="Cities" name="Cities">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group pull-right">
                                                                <label for="Name">Upload File</label>
                                                                <input type="file" class="form-control"
                                                                       id="UploadCoverFile"
                                                                       name="UploadCoverFile"
                                                                       placeholder="Upload Cover">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="" id="CitiesCoverAddResponse"></div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="submit float-right">
                                                                <button type="button" class="btn btn_customized"
                                                                        onclick="CityCoverFormSubmit('CtyCoverAddForm');">
                                                                    Upload
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <div id="CoverUpdateResponse"></div>
                                    <table id="MainRecords" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>City</th>
                                            <th>Cover Image</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $cnt = 0;
                                        if(isset($Cities))
                                        foreach ($Cities as $record) {
                                            if ($record['CoverImage'] > 0) {
                                                $cnt++;
                                                $actions = '<button class="btn btn_customized" onClick="ShowDiv(' . $cnt . ');">Update</button>';
                                                ?>
                                                <tr>
                                                    <td> <?= $cnt ?></td>
                                                    <td> <?= $record['Name'] ?></td>
                                                    <td>
                                                        <img src="<?= $path . 'home/load_file/' . $record['CoverImage'] ?>"
                                                             class="Image" alt="City Cover Image" width="100"></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <?= $actions ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-none" id="CoverUpload_<?= $cnt ?>">
                                                            <form enctype="multipart/form-data" method="post" action="#"
                                                                  id="CtyCoverUpdateForm" name="CtyCoverUpdateForm">
                                                                <input type="hidden" id="Cities" name="Cities"
                                                                       value="<?= $record['UID'] ?>">
                                                                <div class="row">
                                                                    <div class="form-group col-md-9">
                                                                        <label for="Name">Upload File</label>
                                                                        <input type="file" class="form-control"
                                                                               id="UploadCover"
                                                                               name="UploadCover"
                                                                               placeholder="Upload Cover">
                                                                    </div>
                                                                    <div class="form-group col-md-3 mt-4">
                                                                        <label for="Name"></label>
                                                                        <button class="btn btn_customized"
                                                                                onClick="CityCoverUpdateForm('CtyCoverUpdateForm');">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                 width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none"
                                                                                 stroke="currentColor" stroke-width="2"
                                                                                 stroke-linecap="round"
                                                                                 stroke-linejoin="round"
                                                                                 class="feather feather-activity">
                                                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                                                <polyline
                                                                                        points="17 21 17 13 7 13 7 21"></polyline>
                                                                                <polyline
                                                                                        points="7 3 7 8 15 8"></polyline>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="border-visa" role="tabpanel"
                                 aria-labelledby="border-visa-tab">
                                <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                                    <div id="CoverUpdateResponse"></div>
                                    <table id="MainRecords" class="table table-hover non-hover" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Pilgrim ID</th>
                                            <th>Pilgrim Name</th>
                                            <th>Passport Number</th>
                                            <th>Visa Number</th>
                                            <th>Type</th>
                                            <th>Issue Date</th>
                                            <th>Expiry Date</th>
                                            <th>Mofa Number</th>
                                            <th>Visa Attachment</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $cnt=0;
                                        foreach ($Pilgrims as $Pilgrim)
                                        {  $cnt++;
                                            $actions = '<button class="btn btn_customized" onClick="VisaDetailFormSubmit('.$Pilgrim['UID'].'); return false" type="submit">Add</button>';
                                            ?>
                                            <form enctype="multipart/form-data" class="section contact validate" method="post"
                                                  action="#" id="PilgrimVisaAddForm_<?=$Pilgrim['UID']?>" name="PilgrimVisaAddForm_<?=$Pilgrim['UID']?>">
                                                <tr>

                                                    <td><?=$cnt?></td>
                                                    <td><?=Code('UF/P/', $Pilgrim['UID'])?> </td>
                                                    <td><?=$Pilgrim['FirstName']?> </td>
                                                    <td><?=$Pilgrim['PassportNumber']?> </td>
                                                    <td><input type="text"class="form-control" id="VisaNumber" name="VisaNumber[<?=$Pilgrim['UID']?>]" placeholder="Visa #"></td>
                                                    <td>
                                                        <select class="form-control no-select2" id="Type[<?=$Pilgrim['UID']?>]" name="Type[<?=$Pilgrim['UID']?>]">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                                                            foreach ($data['LookupsOptions'] as $options) {
                                                                $selected = (($PilgrimVisa['Type'] == $options['UID']) ? 'selected' : '');
                                                                echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                            } ?>
                                                        </select>
                                                    </td>
                                                    <td> <input type="date" class="form-control" id="IssueDate" name="Pilgim[<?=$Pilgrim['UID']?>][IssueDate]"></td>
                                                    <td> <input type="date" class="form-control" id="ExpiryDate" name="ExpiryDate[<?=$Pilgrim['UID']?>]"></td>
                                                    <td> <input type="text" class="form-control" id="MofaNumber" name="MofaNumber[<?=$Pilgrim['UID']?>]" placeholder="MOFA #"></td>
                                                    <td> <input type="file" class="form-control" id="VisaAttachment" name="VisaAttachment[<?=$Pilgrim['UID']?>]"></td>
                                                    <td>  <div class="btn-group">
                                                            <?= $actions ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </form>
                                        <?php    }  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

    $('#MainRecords,#MainRecord').DataTable({
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });



    function VisaDetailFormSubmit(pilgrimid) {
        
        // var validate = $("form#PilgrimVisaAddForm_"+cnt).validationEngine('validate');
        // if (validate == false) {
        //     return false;
        // }

        var phpdata = new window.FormData($("form#PilgrimVisaAddForm_"+pilgrimid)[0]);
        response = AjaxUploadResponse("form_process/multi_visa_details_form_submit", phpdata);

        if (response.status == 'success') {
           setTimeout(function () {
               $("form#PilgrimVisaAddForm_" + pilgrimid).remove();
               //location.href = "";
           }, 1000)
        }



    }


    function ShowDiv(cnt) {
        $("div#CoverUpload_" + cnt).removeClass("d-none");
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#Cities").html('<option value="">Please Select</option>' + cities.html);
    }

    function MOFAFileFormSubmit(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/mofa_file_form_submit', phpdata);

        if (response.status == 'success') {
            $("#MOFAFileAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#MOFAFileAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

        return false;

    }


    function CityCoverUpdateForm(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/city_cover_update_form_submit', phpdata);

        if (response.status == 'success') {
            $("#CoverUpdateResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#CoverUpdateResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

        return false;

    }

    function CityCoverFormSubmit(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/city_cover_form_submit', phpdata);

        if (response.status == 'success') {
            $("#CitiesCoverAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#CitiesCoverAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

        return false;

    }

    function VOUPilgrimFileFormSubmit(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/vou_pilgrim_file_form_submit', phpdata);

        if (response.status == 'success') {
            $("#WOUPilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#WOUPilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

    }

</script>