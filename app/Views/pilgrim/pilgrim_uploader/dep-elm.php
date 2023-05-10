<?php
$session = session();
$ElmStatusSessionData =  $session->get('InvalidElmData');
$LastElmUploadStatus = $ElmStatusSessionData['message'];
?>
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
              id="WOUDepPilgrimIssuedFilesForm" name="WOUDepPilgrimIssuedFilesForm">
            <input type="hidden" name="Flag" id="Flag" value="Departure">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group pull-right">
                                <label for="Name">Upload File</label>
                                <input type="file" class="form-control" id="UploadFile"
                                       name="UploadFiles"
                                       placeholder="Upload File">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="submit float-right">
                                <button style="margin-top: 30px !important;" type="button" class="btn btn_customized"
                                        onclick="VOUDepPilgrimFileFormSubmit('WOUDepPilgrimIssuedFilesForm');">
                                    Upload
                                </button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php
                                if( isset($LastElmUploadStatus) && $LastElmUploadStatus != '' ){
                                    echo'<div id="WOUDepPilgrimAddResponse"><b>Last Upload Status &raquo;</b> <div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> '.$LastElmUploadStatus.'</div></div>';
                                }else{
                                    echo'<div id="WOUDepPilgrimAddResponse"></div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive mb-4 mt-4 datatableparentdiv">
    <table id="DepElmRecord" class="table table-hover non-hover" style="width:100%">
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
            <th>Exit Date</th>
            <th>Exit Time</th>
            <th>Exit Port</th>
            <th>Exit Transport Mode</th>
            <th>Exit Carrier</th>
            <th>Exit Flight No</th>
            <th>Actual Staying Duration</th>
        </tr>
        </thead>
        <tbody>
        <?php
/*        $cnt = 0;
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
            } */?>
        </tbody>
    </table>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function () {
        var dataTable = $('#DepElmRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ All Departure ELM",
                "info": "Showing _START_ to _END_ of _TOTAL_ All Departure ELM",
            },
            "ajax": {
                url: "<?= $path ?>pilgrim/fetch_all_dep_melm",
                type: "POST",
                data: function (data) {}
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ],
        });
    });
</script>
<script type="text/javascript">

    function VOUDepPilgrimFileFormSubmit(parent) {

        PlzWait('show');
        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/departure_elm_form_submit', phpdata);
        $("#WOUDepPilgrimAddResponse").html(' ');
        if (response.status == 'success') {
            $("#WOUDepPilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            PlzWait('hide');
            setTimeout(function () {
                var DepElmDataTable = $('#DepElmRecord').DataTable();
                DepElmDataTable.ajax.reload();
            }, 2000)
        } else {
            PlzWait('hide');
            $("#WOUDepPilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }
</script>