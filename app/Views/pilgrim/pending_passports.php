<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Crud;
$Crud = new Crud();
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Pending Passports
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing <?= (($AgentLogged) ? 'd-none' : '') ?>">
                <form class="section contact" id="PendingPassportSearchFilter" name="PendingPassportSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Country</label>
                                                        <input class="form-control" id="Country" name="Country" type="text"
                                                               placeholder="Country"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <input class="form-control" id="name" name="name" type="text"
                                                               placeholder="Agent Name"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">From</label>
                                                        <input class="form-control" id="From" name="From" type="date"
                                                               placeholder="From"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">To</label>
                                                        <input class="form-control" id="To" name="To" type="date"
                                                               placeholder="To"
                                                               value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('PendingPassportSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('PilgrimSearchFilter'); return false;"
                                                                class="btn btn-danger">Clear Filter
                                                        </button>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form enctype="multipart/form-data" class="validate" method="post" action="#"
                          id="UploadPassportImagesForm" name="UploadPassportImagesForm">
                        <div id="PassportPicturesUploadResponse"></div>
                        <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                            <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ref.ID</th>
                                    <th>Country</th>
                                    <th>Agent Name</th>
                                    <th>Group</th>
                                    <th>Full Name</th>
                                    <th>Passport Number</th>
                                    <th>Actual Arrival Date</th>
                                    <th>Arrival Port</th>
                                    <th>Front</th>
                                    <th>Back</th>
                                    <th>Booklet</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody><?php
                                $cnt = 0;
                                foreach ($records as $record) {
                                    $Voucher = $Crud->SingleRecord('voucher."Pilgrim"', array("PilgrimUID" => $record['UID']));
                                    if(!isset($Voucher['UID']))
                                    { $Text =' <span style="color:red">(Without Voucher)</span> ';  }else
                                    { $Text =''; }

                                    if ($record['PassportIMGs'] < 3) {
                                        $Pictures = $Crud->ListRecords('pilgrim."attachments"', array("PilgrimID" => $record['UID']));
                                        $PassportPics = array();
                                        foreach ($Pictures as $picture) {
                                            $PassportPics[$picture['FileDescription']] = $picture['FileID'];
                                        }
                                        $cnt++;
                                        if(CurrentStatus($record['UID']) == 'departure-jeddah')
                                        {$Name = $record['FirstName'].'<svg color="red" style="margin-left: 5px; margin-bottom: 10px;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line><title>Pilgrim Exited</title></svg>'."<br>".$Text;}
                                        else
                                        {$Name = $record['FirstName']."<br>".$Text;}
                                        echo '
                                        <tr>
                                            <td>' . $cnt . '</td>                                    
                                            <td>' . Code('UF/P/', $record['UID']) . '</td>  
                                            <td>N/A</td>  
                                            <td>' . $record['AgentName'] . '</td>
                                            <td>' . $record['GroupName'] . '</td>
                                            <td>' . $Name . '</td>
                                            <td>' . $record['PassportNumber'] . '</td>
                                            <td>' . DATEFORMAT($record['EntryDate']) . '</td>
                                            <td>' . $record['EntryPort'] . '</td>
                                            ';
                                            if ($PassportPics['PassportFrontPic'] > 0) {
                                                echo '<td style="text-align: center"><a href="' . $path . 'home/load_file/' . $PassportPics['PassportFrontPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>';
                                            } else {
                                                echo '<td><div class="form-group"><input type="file" class="form-control" id="PassportFrontPic" name="Passport[' . $record['UID'] . '][Front]" style="width: 240px;"></div></td>';
                                            }
                                            if ($PassportPics['PassportBackPic'] > 0) {
                                                echo '<td style="text-align: center"><a href="' . $path . 'home/load_file/' . $PassportPics['PassportBackPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>';
                                            } else {
                                                echo '<td><div class="form-group"><input type="file" class="form-control" id="PassportBackPic" name="Passport[' . $record['UID'] . '][Back]" style="width: 240px;"></div></td>';
                                            }
                                            if ($PassportPics['PassportBookletPic'] > 0) {
                                                echo '<td style="text-align: center"><a href="' . $path . 'home/load_file/' . $PassportPics['PassportBookletPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>';
                                            } else {
                                                echo '<td><div class="form-group"><input type="file" class="form-control" id="PassportBookletPic" name="Passport[' . $record['UID'] . '][Booklet]" style="width: 240px;"></div></td>';
                                            }
                                            echo '<td><button id="multiple-reset" class="btn btn-primary" type="button" onclick="PassportPicturesSubmit(\'UploadPassportImagesForm\');">Upload </button> </td>
        
                                        </tr>';
                                    }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });

    function PassportPicturesSubmit(parent) {
        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/pilgrim_passport_images_form_submit', phpdata);

        if (response.status == 'success') {
            $("#PassportPicturesUploadResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#PassportPicturesUploadResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }
</script>