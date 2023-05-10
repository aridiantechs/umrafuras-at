<?php

use App\Models\Crud;
$Crud = new Crud();
$AllGroup = $Crud->ListRecords('main."Groups"', array("Archive" => 0), array('FullName' => 'ASC'));

?>
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
                <h4 class="page-head">Transfer Pilgrim
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="PilgrimTransferFilter">
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
                                                        <label for="country">Country</label>
                                                        <select class="form-control " id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agents</label>
                                                        <select class="form-control " id="agent"
                                                                name="agent">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($AllAgents as $AgentsRecord) {
                                                                echo '<option value="' . $AgentsRecord['UID'] . '">' . $AgentsRecord['FullName'] . " - " . ucwords(str_replace("_", " ", $AgentsRecord['Type'])) . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group</label>
                                                        <select class="form-control" id="group"
                                                                name="group">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($AllGroup as $group) {
                                                                echo' <option value="' . $group['UID'] . '">' . $group['FullName'] . '</option>  ';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">P/P Number</label>
                                                        <input style="height: 45px;" class="form-control" id="passport_number"
                                                               name="passport_number" placeholder="Passport Number"
                                                               value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group float-right">
                                                        <button type="button" id="btnsearch" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button type="button" id="btnreset" class="btn btn-danger">Clear
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
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <?php
                    $Temp = array();
                    foreach ($AllAgents as $AgentsRecord) {
                        $Temp[$AgentsRecord['UID']] = str_replace("'", "", $AgentsRecord['FullName']) . " - " . ucwords(str_replace("_", " ", $AgentsRecord['Type']));
                    }
                    $AgentListJSONFormat = json_encode($Temp);
                    ?>
                    <div id="PilgrimTransferResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv ">
                        <table id="PilgrimTransferRecord" class="table table-hover non-hover display nowrap"
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
                                <th id="custom" width="10%">Agent</th>
                                <th>Assigned Agent</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Group</th>
                                <th>Pilgrim Name</th>
                                <th>Gender</th>
                                <th>P/P Number</th>
                                <th>D.O.B</th>
                                <th>Age</th>
                                <th>Nationality</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Current Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*foreach ($records as $record) { */ ?><!--
                                <tr>
                                    <td class="checkbox-column">
                                        <label class="new-control new-checkbox checkbox-primary"
                                               style="height: 18px; margin: 0 auto;">
                                            <input type="checkbox" class="new-control-input todochkbox"
                                                   id="chk<? /*= $record['UID'] */ ?>" data-pilgrimid="<? /*= $record['UID'] */ ?>">
                                            <span class="new-control-indicator"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="form-group pull-right">
                                            <select onchange="PilgrimTransfer(this.value,<? /*= $record['UID'] */ ?>);"
                                                    class="form-control no-select2" title="Agents"
                                                    id="Agents<? /*= $record['UID'] */ ?>"
                                                    name="Agents">
                                                <option value="">Please select</option>
                                                <?php
                            /*                                                foreach ($AllAgents as $agent) {
                                                                                echo ' <option value="' . $agent['UID'] . '">' . ucwords($agent['FullName']) . ' - (' . ucwords(str_replace("_", " ", $agent['Type'])) . ')</option>  ';
                                                                            } */ ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td> <?php /*echo $record['AgentName']; */ ?></td>
                                    <td> <?php /*echo $record['Country']; */ ?></td>
                                    <td> <?php /*echo CityName($record['CityID']); */ ?></td>
                                    <td> <?php /*echo $record['GroupName']; */ ?></td>
                                    <td> <?php /*echo $record['FirstName']; */ ?></td>
                                    <td> <?php /*echo $record['Gender']; */ ?></td>
                                    <td> <?php /*echo $record['PassportNumber']; */ ?></td>
                                    <td> <?php /*echo DATEFORMAT($record['DOB']); */ ?></td>
                                    <td> <?php /*echo $record['DOBInYears']; */ ?></td>
                                    <td> <?php /*echo $record['Nationality']; */ ?></td>
                                    <td> <?php /*echo $record['ContactNumber']; */ ?></td>
                                    <td> <?php /*echo $record['Email']; */ ?></td>
                                    <td> <?php /*echo $Statuses[$record['CurrentStatus']]; */ ?></td>
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
<?php
$Text = $Group = '';
foreach ($AllAgents as $agent) {
    $Text .= ' <option value="' . $agent['UID'] . '">' . ucwords($agent['FullName']) . ' - (' . ucwords(str_replace("_", " ", $agent['Type'])) . ')</option>  ';
}

foreach ($AllGroup as $group) {
    $Group .= ' <option value="' . SeoUrl($group['FullName'], false) . '">' . $group['FullName'] . '</option>  ';
}
?>
<!--  END CONTENT AREA  -->
<!--  END CONTENT AREA  -->
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function (){
            $("form#PilgrimTransferFilter select#country").select2();
            $("form#PilgrimTransferFilter select#agent").select2();
            $("form#PilgrimTransferFilter select#group").select2();
        }, 1000);

        var dataTable = $('#PilgrimTransferRecord').DataTable({
            "processing": true,
            "searching": false,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "responsive": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Transfer Pilgrim",
                "info": "Showing _START_ to _END_ of _TOTAL_ Transfer Pilgrim",
            },
            "ajax": {
                url: "<?= $path ?>pilgrim/fetch_pilgrim_transfer",
                type: "POST",
                data: function (data) {
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.group = $('#group').val();
                    data.passport_number = $('#passport_number').val();
                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    //"targets":[0, 3, 4],
                    "orderable": false,
                },
            ]/*,
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                var Group = aData[5].replace(/ /g,'-');
                Group = Group.toLowerCase();
                $(nRow).addClass(Group);
            }*/
        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () {

            $("form#PilgrimTransferFilter select#country").val('');
            $("form#PilgrimTransferFilter select#country").trigger('change');
            $("form#PilgrimTransferFilter select#agent").val('');
            $("form#PilgrimTransferFilter select#agent").trigger('change');
            $("form#PilgrimTransferFilter select#group").val('');
            $("form#PilgrimTransferFilter select#group").trigger('change');

            $('#PilgrimTransferFilter')[0].reset();
            dataTable.ajax.reload();
        });
    });








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
        $('<label class="ml-5">Multi Assign Pilgrims to Checked Agent:  ' +
            '<select name="Agent" class="form-control" style="width:150px;" onChange="MultiPilgrimTransfer(this.value)"><option>Kindly select</option>' +
            '<?= addslashes($Text) ?>' +
            '</select>' +
            '<select onchange="CheckGroupPilgrim( this.value );" name="Group" class="form-control" style="width:175px;"><option value="">Kindly select group</option>' +
            '<?= addslashes($Group) ?>' +
            '</select></label>').appendTo(".dataTables_wrapper .dataTables_length");
    }, 100);

    function CheckGroupPilgrim(Group){

        $("tr input").prop('checked', false);
        if( Group != '' ){
            $("tr input."+Group+"").prop('checked', true);
        }
    }

    function PilgrimTransfer(agent_id, row_id) {

        var Agent = '<?= $AgentListJSONFormat ?>';
        var result = $.parseJSON(Agent);

        if (agent_id > 0) {
            if (confirm("Are your Sure You Want To Assign To (" + result[agent_id] + ") ?")) {
                var response = AjaxResponse('form_process/pilgrim_transfer', "agent_id=" + agent_id + "&pilgrimids=" + row_id);
                if (response.status == 'success') {
                    $("#PilgrimTransferResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                    setTimeout(function () {
                        location.reload();
                    }, 10)
                } else {
                    $("#PilgrimTransferResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
                }
            }
        }
    }

    function MultiPilgrimTransfer(agent_id) {

        var Agent = '<?= $AgentListJSONFormat ?>';
        var result = $.parseJSON(Agent);

        if (agent_id > 0) {
            if (confirm("Are your Sure to process multiple records to (" + result[agent_id] + ")? it will take time as well...?")) {
                cnt = 0;
                const pilgrimids = [];
                // Adds "Kiwi"
                $(".todochkbox").each(function () {
                    inp = $(this).attr("id");
                    pilgrimid = $(this).data("pilgrimid");
                    if ($("#" + inp).prop('checked')) {
                        pilgrimids.push(pilgrimid);
                        cnt++;
                    }
                })
                var response = AjaxResponse('form_process/pilgrim_transfer', "agent_id=" + agent_id + "&pilgrimids=" + pilgrimids);
                $("#PilgrimTransferResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> ' +
                    '<strong style="font-size: 150%">Total ' + cnt + '</strong> Pilgrim Successfully Assigned... </div>')
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

    //setTimeout(function () {
    //    $('<a target="_blank" href="<? //=$path?>//" class="dt-filter-btn">Excel Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    //}, 100);
</script>