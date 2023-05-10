<?php
$session = session();
$MofaStatusSessionData = $session->get('InvalidMofaData');
$LastMofaUploadStatus = $MofaStatusSessionData['message'];

$MofaFileDatabaseColumns = array(
    'Operator', 'ExtAgent', 'Group', 'PrintDate', 'PilgrimName', 'PilgrimID', 'Age', 'DOB', 'GroupName', 'PassportNo',
    'MOFANumber', 'IssueDateTime', 'Embassy', 'PKGCode', 'Relation', 'Nationality', 'Address', 'SubAgentName', 'MOINumber',
    'INSURANCE_POLICY_ID', 'Hotel_BRN', 'Transport BRN'
);
?>
<div class="card">
    <div class="card-header">
        <section class="mb-0 mt-0">
            <div role="menu" class="collapsed" data-toggle="collapse"
                 data-target="#FilterDetails" aria-expanded="false"
                 aria-controls="FilterDetails">
                Add File
                <span>
                      <button type="button" onclick="AddNewBRNOptions()"
                              class="btn btn-success btn-sm float-right"> + </button>
                </span>
            </div>
        </section>
    </div>
    <div class="card-body">
        <form enctype="multipart/form-data" method="post" action="#"
              id="MOFAIssuedFilesForm" name="MOFAIssuedFilesForm">
            <input type="hidden" id="BRNCount" name="BRNCount" value="0">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div id="BRNOptionsR">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-4"><label for="FullName">BRN Use Type</label> <select
                                            class="form-control" id="UseType" name="UseType"
                                            onchange="LoadBRNDropdownagain(this.value ,0);">
                                        <option value="">Please Select</option>
                                        <option value="Visa">Visa</option>
                                        <option value="visa_and_transport">Visa And Transport</option>
                                        <option value="visa_and_hotel">Visa And Hotel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group pull-right "><label for="Name">BRN</label>
                                    <select class="form-control basic" id="BRN0" name="BRN[]">
                                        <option value="">Kindly Select BRN Code</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group pull-right">
                                <label for="Name">Mofa File Operator</label>
                                <select onchange="CheckMofaOperatorFile(this.value);" class="form-control " id="MofaFileOperator"
                                        name="MofaFileOperator">
                                    <option value="">Select Option</option>
                                    <option value="way-to-umrah">Way to Umrah</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group pull-right">
                                <label for="Name">Upload File</label>
                                <input type="file" class="form-control" id="UploadFiles"
                                       name="UploadFiles"
                                       placeholder="Upload File">
                            </div>
                        </div>
                    </div>
                    <div class="card d-none" id="MofaFileUploadDefineColumnsDiv">
                        <div class="card-header" style="background: #dda420;">
                            <section class="mb-0 mt-0">
                                <div style="color: black; font-weight: bold;" role="menu" class="collapsed"
                                     data-toggle="collapse"
                                     data-target="#FilterDetails" aria-expanded="false"
                                     aria-controls="FilterDetails">
                                    Select All Options To Save File Record <b style="font-weight: bold; color: red;">( UNDER PROCESS & Not Linked With File Processing )</b>
                                </div>
                            </section>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php
                                foreach ($MofaFileDatabaseColumns as $Column) {
                                    $key = strtolower($Column);
                                    echo '<div class="col-md-3 mb-3">
                                        <label for="Name">' . $Column . '</label>
                                        <select class="form-control column-select" id="column-' . $key . '"
                                                name="column[' . $Column . ']">
                                                <option value="">Select Option</option>
                                        </select>
                                    </div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <?php
                            if (isset($LastMofaUploadStatus) && $LastMofaUploadStatus != '') {
                                echo '<div id="MOFAFileAddResponse"><b>Last Upload Status &raquo;</b> <div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' . $LastMofaUploadStatus . '</div></div>';
                            } else {
                                echo '<div id="MOFAFileAddResponse"></div>';
                            }
                            ?>
                        </div>
                        <div class="col-md-12">
                            <div class="submit float-right">
                                <button id="MofaFileUploadButton" type="button" class="btn btn_customized d-none"
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
    <table id="MofaRecord" class="table table-responsive non-hover customized_table"
           style="width:100%">
        <thead>
        <tr>
            <th>Sr. #</th>
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
            <th>Hotel Brn</th>
            <th>Transport brn</th>
        </tr>
        </thead>
        <tbody>
        <?php
        /*        $cnt=0;
                if(isset($records))
                    foreach ($records as $record) { $cnt++; */ ?><!--
                <tr>
                    <td> <?php /*echo $cnt; */ ?></td>
                    <td> <?php /*echo $record['Operator']; */ ?></td>
                    <td> <?php /*echo $record['ExtAgent']; */ ?></td>
                    <td> <?php /*echo $record['Group']; */ ?></td>
                    <td> <?php /*echo $record['PrintDate']; */ ?></td>
                    <td> <?php /*echo $record['PilgrimName']; */ ?></td>
                    <td> <?php /*echo $record['PilgrimID']; */ ?></td>
                    <td> <?php /*echo $record['Age']; */ ?></td>
                    <td> <?php /*echo DATEFORMAT($record['DOB']); */ ?></td>
                    <td> <?php /*echo $record['GroupName']; */ ?></td>
                    <td> <?php /*echo $record['PassportNo']; */ ?></td>
                    <td> <?php /*echo $record['MOFANumber']; */ ?></td>
                    <td> <?php /*echo $record['IssueDateTime']; */ ?></td>
                    <td> <?php /*echo $record['Embassy']; */ ?></td>
                    <td> <?php /*echo $record['PKGCode']; */ ?></td>
                    <td> <?php /*echo $record['Relation']; */ ?></td>
                    <td> <?php /*echo $record['Nationality']; */ ?></td>
                    <td> <?php /*echo $record['Address']; */ ?></td>
                    <td> <?php /*echo $record['SubAgentName']; */ ?></td>
                    <td> <?php /*echo $record['MOINumber']; */ ?></td>
                    <td> <?php /*echo $record['INSURANCE_POLICY_ID']; */ ?></td>
                </tr>
            --><?php /*} */ ?>
        </tbody>
    </table>
</div>

<script type="text/javascript" language="javascript">

    // $(document).ready(function() {
    //     $(".basic").select2({
    //         tags: true,
    //     });
    // }

    $(document).ready(function(){
        brnselect2(0);
    });

    function brnselect2(cnt) {
        $("select#BRN"+cnt+"").select2();
    }

    function CheckMofaOperatorFile(Value){
        if(Value != ''){
            $("input#UploadFiles").val(null);
            $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');
        }

        $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html(' ');
        $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
    }

    $('input#UploadFiles').on('change', function () {
        var MofaFileOperator = $("form#MOFAIssuedFilesForm select#MofaFileOperator").val();
        if (MofaFileOperator == '') {

            $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").removeClass('d-none');

            /*$("input#UploadFiles").val(null);
            GridMessages('MOFAIssuedFilesForm', 'MOFAFileAddResponse', 'alert-success', 'Select Mofa File Operator', 4000);

            $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html('<option value="">Select Option</option>');
            $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
            $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');*/

        } else {

            PlzWait('show');
            var OptionsHtml = '';
            var phpdata = new window.FormData($("form#MOFAIssuedFilesForm")[0]);
            var rslt = AjaxUploadResponse('form_process/check_mofa_file_heads', phpdata);
            if (rslt.status == 'success') {

                var data = rslt.data;
                var total_col = rslt.total_col;
                if (total_col != '' && total_col != null) {
                    OptionsHtml += '<option value="">Select Option</option>';
                    jQuery.each(data, function (index, item) {
                        OptionsHtml += '<option value="' + index + '">' + item + '</option>';
                    });
                    $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html(OptionsHtml);

                    $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").removeClass('d-none');
                    $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").removeClass('d-none');

                } else {

                    $("input#UploadFiles").val(null);
                    GridMessages('MOFAIssuedFilesForm', 'MOFAFileAddResponse', 'alert-success', rslt.message, 4000);

                    $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html('<option value="">Select Option</option>');
                    $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
                    $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');
                }
                PlzWait('hide');
            } else {

                $("input#UploadFiles").val(null);
                GridMessages('MOFAIssuedFilesForm', 'MOFAFileAddResponse', 'alert-success', rslt.message, 4000);

                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html('<option value="">Select Option</option>');
                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
                $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');
                PlzWait('hide');
            }
        }
    });

    $(document).ready(function () {



        var dataTable = $('#MofaRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ All MOFA",
                "info": "Showing _START_ to _END_ of _TOTAL_ All MOFA",
            },
            "ajax": {
                url: "<?= $path ?>pilgrim/fetch_all_mofa",
                type: "POST",
                data: function (data) {
                }
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
    function LoadBRNDropdownagain(brntype, cnt) {
        PlzWait('show');
        setTimeout(function () {
            var brn = AjaxResponse("html/GetBRNDropdownByType", "brntype=" + brntype);
            $("#BRN" + cnt).html('<option value="">Please Select</option>' + brn.html);
            DefaultScripts();
            PlzWait('hide');
        }, 10);
    }

    function MOFAFileFormSubmit(parent) {

        $("form#" + parent).validationEngine('attach', {promptPosition : "topLeft", scroll: false});
        var validate = $("form#" + parent).validationEngine('validate');
        if (validate == false) {
            return false;
        }

        PlzWait('show');
        setTimeout(function () {
            var phpdata = new window.FormData($("form#" + parent)[0]);
            var response = AjaxUploadResponse('form_process/mofa_file_form_submit', phpdata);

            $("#MOFAFileAddResponse").html(' ');
            if (response.status == 'success') {
                $("#MOFAFileAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                PlzWait('hide');

                $("form#MOFAIssuedFilesForm select#MofaFileOperator").val('');
                $("input#UploadFiles").val(null);
                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html(' ');
                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
                $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');

                setTimeout(function () {
                    var MofaDataTable = $('#MofaRecord').DataTable();
                    MofaDataTable.ajax.reload();
                }, 2500);
            } else {
                $("#MOFAFileAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>');

                $("form#MOFAIssuedFilesForm select#MofaFileOperator").val('');
                $("input#UploadFiles").val(null);
                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv select.column-select").html(' ');
                $("form#MOFAIssuedFilesForm div#MofaFileUploadDefineColumnsDiv").addClass('d-none');
                $("form#MOFAIssuedFilesForm button#MofaFileUploadButton").addClass('d-none');

                setTimeout(function () {
                    PlzWait('hide');
                }, 2000);
            }
        }, 100);
        return false;
    }

    function AddNewBRNOptions() {
        BRNCount = parseInt($("#BRNCount").val());

        HTML = DefaultBRNOptionsRowHTML(BRNCount);
        $("#BRNOptionsR").append(HTML);
        $("#BRNCount").val(BRNCount + 1);

        brnselect2(parseInt(BRNCount) + 1);
        return false;
    }

    function DefaultBRNOptionsRowHTML(cnt) {
        cnt = cnt + 1;
        var html;

        html = '<div class="row" id="BRNCount' + cnt + '" name="BRNCount"> ' +
            '<div class="col-md-3">  <div class="form-group mb-4"> <label for="FullName">BRN Use Type</label>  <select class="form-control" id="UseType" name="UseType"   onchange="LoadBRNDropdownagain(this.value,\'' + cnt + '\');">  <option value="">Please Select</option>  <option value="Visa">Visa</option> <option value="Hotel">Hotel</option>  <option value="visa_and_transport">Visa And Transport</option>  <option value="visa_and_hotel">Visa And Hotel</option>  </select>  </div>   </div>\n' +
            ' <div class="col-md-8">  <div class="form-group pull-right"> <label for="Name">BRN</label>  <select class="form-control   validate[required]" id="BRN' + cnt + '" name="BRN[]">  <option value="">Kindly Select BRN Code</option>  </select>  </div>  </div>\n' +
            ' <div class="col-md-1"> <button type="button" onclick="RemoveBRNOptionsRow(' + cnt + ')" class="btn btn-danger btn-sm" style="margin: 29px;"> - </button> </div>   ' +
            '</div>          ';

        return html;
    }

    function RemoveBRNOptionsRow(id) {
        BRNCount = parseInt($("#BRNCount").val());
        $("#BRNCount" + id).remove();
        $("#BRNCount").val(BRNCount - 1);
    }

    // setTimeout(function () {
    //     AddNewBRNOptions();
    // }, 1000)

</script>