<style>
    .customized_table #custom {
        width: 100% !important;
    }
</style>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">MOFA File Process
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="ManageMOFASearchFilter">
                    <input type="hidden" name="issue_date_from" id="issue_date_from" value="">
                    <input type="hidden" name="issue_date_to" id="issue_date_to" value="">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="Agents">Agents</label>
                                                        <select class="form-control" id="agents"
                                                                name="agents">
                                                           <option value=""></option>
                                                        </select>
                                                    </div>
                                                </div>



                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group</label>
                                                        <input class="form-control" id="group" name="group"
                                                               placeholder="Group">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">PKG Code</label>
                                                        <input class="form-control" id="pkg_code" name="pkg_code"
                                                               placeholder="PKG Code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Pilgrim Name</label>
                                                        <input class="form-control" id="pilgrim_name"
                                                               name="pilgrim_name"
                                                               placeholder="Pilgrim Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Pilgrim ID</label>
                                                        <input class="form-control" id="pilgrim_id" name="pilgrim_id"
                                                               placeholder="Pilgrim ID">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Mofa No</label>
                                                        <input class="form-control" id="mofa_no" name="mofa_no"
                                                               placeholder="Mofa No">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="Embassy">Embassy</label>
                                                        <input class="form-control" id="Embassy" name="Embassy"
                                                               placeholder="Embassy">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="Nationality">Nationality</label>
                                                        <input class="form-control" id="Nationality" name="Nationality"
                                                               placeholder="Nationality">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Issue Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="issue_date" id="issue_date"
                                                               placeholder="Issue Date" value=""
                                                               onchange="GetIssueDate();">
                                                    </div>
                                                </div>



                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
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
            <!--            <div class="col-xl-4 col-lg-4 col-md-4 layout-spacing">-->
            <!--                <div id="toggleAccordion">-->
            <!--                    <div class="card">-->
            <!--                        <div class="card-header">-->
            <!--                            <section class="mb-0 mt-0">-->
            <!--                                <div role="menu" class="collapsed" data-toggle="collapse"-->
            <!--                                     data-target="#FilterDetails" aria-expanded="false"-->
            <!--                                     aria-controls="FilterDetails">-->
            <!--                                    Add File-->
            <!--                                </div>-->
            <!--                            </section>-->
            <!--                        </div>-->
            <!--                        <div id="FilterDetails" class="collapse show " aria-labelledby=""-->
            <!--                             data-parent="#toggleAccordion">-->
            <!--                            <div class="card-body">-->
            <!--                                <form enctype="multipart/form-data" method="post" action="#"-->
            <!--                                      id="MOFAIssuedFilesForm" name="MOFAIssuedFilesForm">-->
            <!--                                    <div class="row">-->
            <!--                                        <div class="col-md-12 mx-auto">-->
            <!--                                            <div class="row">-->
            <!--                                                <div class="col-md-12">-->
            <!--                                                    <div class="form-group pull-right">-->
            <!--                                                        <label for="Name">Upload File</label>-->
            <!--                                                        <input type="file" class="form-control" id="UploadFiles"-->
            <!--                                                               name="UploadFiles"-->
            <!--                                                               placeholder="Upload File">-->
            <!--                                                    </div>-->
            <!--                                                </div>-->
            <!--                                                <div class="col-md-12">-->
            <!--                                                    <div class="" id="MOFAFileAddResponse"></div>-->
            <!--                                                </div>-->
            <!--                                                <div class="col-md-12">-->
            <!--                                                    <div class="submit float-right">-->
            <!--                                                        <button type="button" class="btn btn_customized"-->
            <!--                                                                onclick="MOFAFileFormSubmit('MOFAIssuedFilesForm');">-->
            <!--                                                            Upload-->
            <!--                                                        </button>-->
            <!--                                                    </div>-->
            <!--                                                </div>-->
            <!--                                            </div>-->
            <!--                                        </div>-->
            <!--                                    </div>-->
            <!--                                </form>-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!---->
            <!--                </div>-->
            <!--            </div>-->
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <?php
                    $Temp = array();
                    foreach ($AgentsExceptSubAgents['records'] as $AgentsRecord) {
                        $Temp[$AgentsRecord['UID']] = $AgentsRecord['FullName'] . " - " . ucwords(str_replace("_", " ", $AgentsRecord['Type']));
                    }
                    $AgentListJSONFormat = json_encode($Temp);
                    ?>
                    <div id="MOFAFileAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv ">
                        <table id="ManageMofaRecord" class="table table-hover non-hover display nowrap"
                               style="width:100%">

                            <thead>
                            <tr>
                                <th class="checkbox-column">
                                    <label class="new-control new-checkbox checkbox-primary"
                                           style="height: 18px; margin: 0 auto;">
                                        <input type="checkbox" class="new-control-input "
                                               onclick="CheckAll(this, 'todochkbox')">
                                        <span class="new-control-indicator"></span>
                                    </label>
                                </th>
                                <th id="custom" width="350">Agent</th>
                                <th>Operator</th>
                                <th>Ext Agent</th>
                                <th>Group</th>
                                <th>PKG Code</th>
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
                            /*                            foreach ($records as $record) { */ ?><!--
                                <tr>
                                    <td class="checkbox-column">
                                        <label class="new-control new-checkbox checkbox-primary"
                                               style="height: 18px; margin: 0 auto;">
                                            <input type="checkbox" class="new-control-input todochkbox"
                                                   id="chk<? /*= $record['UID'] */ ?>" data-mufaid="<? /*= $record['UID'] */ ?>">
                                            <span class="new-control-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="form-group pull-right">
                                            <select onchange="MOFAFileAssign(this.value,<? /*= $record['UID'] */ ?>);"
                                                    class="form-control" title="Agents" id="Agents<? /*= $record['UID'] */ ?>"
                                                    name="Agents">
                                                <?php /*echo $AgentsExceptSubAgents['html']; */ ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td> <?php /*echo $record['Operator']; */ ?></td>
                                    <td> <?php /*echo $record['ExtAgent']; */ ?></td>
                                    <td> <?php /*echo $record['GroupName']; */ ?></td>
                                    <td> <?php /*echo $record['PKGCode']; */ ?></td>
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
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">

    $(document).ready(function () {

        setTimeout(function () {
            $("#issue_date_from").val('');
            $("#issue_date_to").val('');
        }, 1000);

        var dataTable = $('#ManageMofaRecord').DataTable({
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
                "lengthMenu": "Show _MENU_ Manage Mofa",
                "info": "Showing _START_ to _END_ of _TOTAL_ Manage Mofa",
            },
            "ajax": {
                url: "<?= $path ?>mofa/fetch_manage_mofa_record",
                type: "POST",
                data: function (data) {
                    data.group = $('#group').val();
                    data.pkg_code = $('#pkg_code').val();
                    data.pilgrim_name = $('#pilgrim_name').val();
                    data.pilgrim_id = $('#pilgrim_id').val();
                    data.mofa_no = $('#mofa_no').val();
                    data.issue_date_from = $('#issue_date_from').val();
                    data.issue_date_to = $('#issue_date_to').val();
                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#ManageMOFASearchFilter')[0].reset();
            $("#issue_date_from").val('');
            $("#issue_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetIssueDate() {
        const IssueDate = $("#issue_date").val();
        const words = IssueDate.split(' to ');
        $("#issue_date_from").val(words[0]);
        $("#issue_date_to").val(words[1]);
    }
</script>
<script>
    /*$('#MainRecords').DataTable({
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
        "lengthMenu": [15, 20, 30, 50],
        "pageLength": 15
    });*/

    setTimeout(function () {
        $('<label class="ml-5">Multi Assign Agent to Checked MOFA:  ' +
            '<select name="Agent" class="form-control" style="width:150px;" onChange="MultiMOFAFileAssign(this.value)">' +
            '<?=addslashes($AgentsExceptSubAgents['html'])?>' +
            '</select></label>').appendTo(".dataTables_wrapper .dataTables_length");
    }, 100);


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

    function MOFAFileAssign(agent_id, row_id) {
        var Agent = '<?=$AgentListJSONFormat?>';
        var result = $.parseJSON(Agent);

        if (agent_id > 0) {
            if (confirm("Are your Sure You Want To Assign To (" + result[agent_id] + ") ?")) {
                var response = AjaxResponse('form_process/mofa_temp_file_process', "agent_id=" + agent_id + "&mofa=" + row_id);
                if (response.status == 'success') {
                    $("#MOFAFileAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                    setTimeout(function () {
                        location.reload();
                    }, 10)
                } else {
                    $("#MOFAFileAssignResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
                }
            }
        }
    }

    function MultiMOFAFileAssign(agent_id) {
        var Agent = '<?=$AgentListJSONFormat?>';
        var result = $.parseJSON(Agent);

        if (agent_id > 0) {
            if (confirm("Are your Sure to process multiple records to (" + result[agent_id] + ")? it will take time as well...?")) {
                cnt = 0;
                const mofaids = [];
                // Adds "Kiwi"
                $(".todochkbox").each(function () {
                    inp = $(this).attr("id");
                    mofaid = $(this).data("mufaid");
                    if ($("#" + inp).prop('checked')) {
                        mofaids.push(mofaid);
                        cnt++;
                    }
                })
                var response = AjaxResponse('form_process/mofa_temp_file_process', "agent_id=" + agent_id + "&mofaids=" + mofaids);
                $("#MOFAFileAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> ' +
                    '<strong style="font-size: 150%">Total ' + cnt + '</strong> MOFAs Successfully Assigned... </div>')
                setTimeout(function () {
                    location.reload();
                }, 10)
            }
        }
    }

    function CheckAll(obj, targetclass) {
        if ($(obj).prop('checked')) {
            $("." + targetclass).each(function () {
                inp = $(this).attr("id");
                $("#" + inp).prop('checked', true);
            })
        } else {
            $("." + targetclass).each(function () {
                inp = $(this).attr("id");
                $("#" + inp).prop('checked', false);
            })
        }
    }

    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>excel_export/mofa_temp_upload_list" class="dt-filter-btn">Excel Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);

</script>