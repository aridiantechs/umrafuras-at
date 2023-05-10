<!--  BEGIN CONTENT AREA  -->
<?php

use App\Models\Groups;

?>
<style>
    .CellWithComment {
        position: relative;
    }

    .CellComment {
        display: none;
        position: absolute;
        z-index: 100;
        border: 1px;
        background-color: white;
        border-style: solid;
        border-width: 1px;
        border-color: #dda420;
        padding: 3px;
        color: #dda420;
        top: 20px;
        left: 20px;
    }

    .CellWithComment:hover span.CellComment {
        display: block;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"><?= ucwords(str_replace("-", " ", $type)) ?> Groups
                    <!--                    <button type="button" class="btn btn_customized btn-sm float-right"-->
                    <!--                            onclick="LoadModal('group/main_form', 0)">Create New Group-->
                    <!--                    </button>-->
                    <?php
                    if ($type == 'in-complete' && $CheckAccess['umrah_groups_manage_incomplete_create_group_new'] || $type == 'complete' && $CheckAccess['umrah_groups_manage_complete_create_group_new']) {
                        ?>
                        <a type="button" class="btn btn_customized btn-sm float-right"
                           href="<?= $path ?>group/add_group" style="margin-right: 5px;">Create Group ( New )
                        </a>
                    <?php } ?>

                    <!--                    <a type="button" class="btn btn_customized btn-sm float-right"-->
                    <!--                            onclick="" href="-->
                    <? //=$path?><!--exports/voucher" target="_blank" style="margin-right: 5px;">Print Voucher-->
                    <!--                    </a>-->
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="GroupsSearchFilter">
                    <input type="hidden" name="create_start_date" id="create_start_date" value="">
                    <input type="hidden" name="create_end_date" id="create_end_date" value="">
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
                                                        <label for="country">Country </label>
                                                        <select class="form-control" id="country"
                                                                name="country">
                                                            <option value="">Please Select</option>
                                                            <?= Countries('html') ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Agent Name</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <?= $AgentsDropDown['html'] ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Code (WTU)</label>
                                                        <input type="text" class="form-control" id="group_code"
                                                               name="group_code"
                                                               placeholder="Group Code">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Group Name</label>
                                                        <input type="text" class="form-control" id="group_name"
                                                               name="group_name"
                                                               placeholder="Group Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Create Date</label>
                                                        <input type="text" class="form-control multidate"
                                                               name="create_date" id="create_date"
                                                               placeholder="Create Dates" value=""
                                                               onchange="GetCreateDate();">
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
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div id="StatusAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="GroupRecord" class="table table-hover non-hover display nowrap" style="width:100%">
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
                                <th>#</th>
                                <th>Create Date</th>
                                <th>Country</th>
                                <th>Agent</th>
                                <th>Category</th>
                                <th>Group Code</th>
                                <th>Group Code (wtu)</th>
                                <th>Group Name</th>
                                <th>HTL Category</th>
                                <th>Beds/Rooms</th>
                                <th>Total Pax</th>
                                <th>MAK Nights</th>
                                <th>Med Nights</th>
                                <th>Jed Nights</th>
                                <th>Total Nights</th>
                                <th>Arrival Date</th>
                                <th>Dep Date</th>
                                <th>TPT Type</th>
                                <th>Sector</th>
                                <th>Other Services</th>
                                <th>Refund Amount</th>
                                <th>Total Payment</th>
                                <th>Pilgrim In Group</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th <?= (($type == 'in-complete') ? 'class="d-none"' : '') ?>>Complete Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            /*                            $cnt = 0;
                                                        $Total = 0;
                                                        foreach ($records as $record) {

                                                            //$Total = $record['totalTransportRates'] + $record['totalHotelRates'] + $record['totalServiceRates'] + $record['TotalZiyaratRate'] + $record['TotalVisaRate'];
                                                            //$totalRates = $record['totalHotelRates'] + $record['totalTransportRates'] + $record['totalServiceRates']+ $record['totalZiyratRates'];

                                                            $Groups = new Groups();
                                                            $data['records'] = $Groups->CountGroupPilgrims($record['UID']);
                                                            $countrecords = count($data['records']);

                                                            $cnt++;
                                                            $Category = 'B2B';
                                                            if ($record['IATAType'] == 'external_agent') {
                                                                $Category = 'External Agent';
                                                            }
                                                            $Status == ucwords(str_replace('-', ' ', $type));
                                                            $hotelname = '';
                                                            $numberofbeds = 0;
                                                            $numberofrooms = 0;
                                                            $ToolTipHTML = '';
                                                            $ROOMSHTMLSTRING = explode("$", $record['ROOMSHTMLSTRING']);
                                                            $cnt = 1;
                                                            foreach ($ROOMSHTMLSTRING as $ROOMSHOTEL) {
                                                                $ROOMSHOTEL = trim($ROOMSHOTEL);
                                                                $hotelname .= $ROOMSHOTEL . "<hr>";
                                                                $ROOMSHOTELS = explode("|", $ROOMSHOTEL);
                                                                $ToolTipHTML .= '<strong style="color: black; font-weight: bolder;">' . $ROOMSHOTELS[0] . '</strong>' . '<br>' . $ROOMSHOTELS[1] . "<hr>";
                                                                $numberofbeds += $ROOMSHOTELS[2];
                                                                $numberofrooms += $ROOMSHOTELS[3];
                                                                $cnt++;
                                                            }
                                                            $roombedHTML = array();
                            //                                if ($numberofbeds > 0 || $numberofrooms > 0)
                            //                                    $roombedHTML = $numberofbeds . ' Beds & ' . $numberofrooms . ' Rooms';
                                                            if ($numberofbeds > 0) {
                                                                $roombedHTML[] = $numberofbeds . ' Beds';
                                                            }
                                                            if ($numberofrooms > 0) {
                                                                $roombedHTML[] = $numberofrooms . ' Rooms';
                                                            }
                                                            $actions = '
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                                                <a class="dropdown-item" href="' . SeoUrl('exports/groups/' . $record['UID'] . "-" . $record['FullName']) . '" target="_blank">Export</a>
                                                                <a class="dropdown-item" href="' . $path . 'group/edit_group/' . $record['UID'] . '">Update</a>
                                                              <a  class="dropdown-item ' . (($session['mis_type'] == 'other') ? 'd-none' : '') . '" href="#" onclick="DeleteGroup(' . $record['UID'] . ');">Delete</a>
                                                            </div>';

                                                            echo '
                                                            <tr>
                                                            <td class="checkbox-column">
                                                                    <label class="new-control new-checkbox checkbox-primary"
                                                                           style="height: 18px; margin: 0 auto;">
                                                                        <input type="checkbox" class="new-control-input todochkbox"
                                                                               id="chk' . $record['UID'] . '" data-groupsid="' . $record['UID'] . '">
                                                                        <span class="new-control-indicator"></span>
                                                                    </label>
                                                                </td>
                                                                <td>' . $cnt . '</td>
                                                                <td>' . DATEFORMAT($record['SystemDate']) . '</td>
                                                                <td>' . $record['CountryName'] . '</td>
                                                                <td>' . $record['Agentname'] . '</td>
                                                                <td>' . Code('UF/G/', $record['UID']) . '</td>
                                                                <td>' . $record['WTUCode'] . '</td>
                                                                <td>' . $record['FullName'] . '</td>
                                                                <td>' . ((isset($record['HotelCategory'])) ? $record['HotelCategory'] : '-') . '</td>
                                                                <td ' . ((count($roombedHTML) > 0) ? 'class="CellWithComment"' : '') . ' >' . ((count($roombedHTML) > 0) ? implode(" & ", $roombedHTML) : '-') . '
                                                                    ' . (($ToolTipHTML != '') ? '<span class="CellComment">' . $ToolTipHTML . '</span>' : '') . '
                                                                </td>
                                                                <td>' . $record['NoOfPAX'] . '</td>
                                                                <td>' . ((isset($record['MeccaNights'])) ? $record['MeccaNights'] : '-') . '</td>
                                                                <td>' . ((isset($record['MedinaNights'])) ? $record['MedinaNights'] : '-') . '</td>
                                                                <td>' . ((isset($record['JeddahNights'])) ? $record['JeddahNights'] : '-') . '</td>
                                                                <td>' . ((isset($record['TotalNights'])) ? $record['TotalNights'] : '-') . '</td>
                                                                <td>' . DATEFORMAT($record['ArrivalDate']) . '</td>
                                                                <td>' . DATEFORMAT($record['DepartureDate']) . '</td>
                                                                <td>' . ((isset($record['TransportType'])) ? $record['TransportType'] : '-') . '</td>
                                                                <td>' . ((isset($record['Sector'])) ? $record['Sector'] : '-') . '</td>
                                                                <td>' . ((isset($record['OtherServices'])) ? $record['OtherServices'] : '-') . '</td>
                                                                <td>' . Money($record['GrandTotal']) . '</td>
                                                                <td>' . $Category . '</td>
                                                                <td>' . $countrecords . '</td>
                                                                <td>' . ((isset($record['ReferenceName'])) ? $record['ReferenceName'] : '-') . '</td>
                                                                <td>' . ucwords(str_replace('-', ' ', $type)) . '</td>
                                                                <td ' . (($type == 'in-complete') ? 'class="d-none"' : '') . '>N/A</td>
                                                                <td>
                                                                    <div class="btn-group">
                                                                        <button type="button"
                                                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                                                id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                                                aria-expanded="false" data-reference="parent">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                                                 stroke-linecap="round" stroke-linejoin="round"
                                                                                 class="feather feather-chevron-down">
                                                                                <polyline points="6 9 12 15 18 9"></polyline>
                                                                            </svg>
                                                                        </button>
                                                                        ' . $actions . '
                                                                    </div>
                                                                </td>
                                                            </tr>';
                                                        } */ ?>
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
            $("#create_start_date").val('');
            $("#create_end_date").val('');
        }, 1000);

        var dataTable = $('#GroupRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, 'All']],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ <?= ucwords(str_replace("-", " ", $type)) ?> Group Record",
                "info": "Showing _START_ to _END_ of _TOTAL_ <?= ucwords(str_replace("-", " ", $type)) ?> Group Record",
            },
            "ajax": {
                url: "<?= $path ?>group/fetch_groups_record",
                type: "POST",
                data: function (data) {
                    data.type = "<?=$type?>";
                    data.country = $('#country').val();
                    data.agent = $('#agent').val();
                    data.group_code = $('#group_code').val();
                    data.group_name = $('#group_name').val();
                    data.create_start_date = $('#create_start_date').val();
                    data.create_end_date = $('#create_end_date').val();
                }
            },
            "fnRowCallback": function (nRow, aData) {
                if (aData[9] != "-") {
                    $(nRow).find('td:eq(9)')
                        .addClass('CellWithComment');
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
            $('#GroupsSearchFilter')[0].reset();
            $("#create_start_date").val('');
            $("#create_end_date").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetCreateDate() {
        const CreateDate = $("#create_date").val();
        const words = CreateDate.split(' to ');
        $("#create_start_date").val(words[0]);
        $("#create_end_date").val(words[1]);
    }
</script>
<script type="application/javascript">

    setTimeout(function () {
        $('<label class="float-right mr-3" id="coloredtext"> <span class=""><?=(($type == "in-complete") ? 'Complete' : 'In Complete')?> / Delete:  ' +
            '<select id="Status" name="Status" class="form-control" style="width:150px;" onChange="ChangeGroupStatus(this.value)">' +
            '<option value="">Select</option><option class="<?=(($type == 'in-complete') ? 'd-none' : '')?>" value="in-complete">In Complete</option><option class="<?=(($type == 'complete') ? 'd-none' : '')?>" value="complete">Complete</option><option class="" value="delete">Delete</option>' +
            '</select></label>').appendTo(".table-responsive");
    }, 100);


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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });*/

    //setTimeout(function () {
    //    $('<label class="ml-5"> <span class=""><?//=(($type == "in-complete") ?  'Complete' : 'In Complete' )?>// / Delete:  ' +
    //        '<select id="Status" name="Status" class="form-control" style="width:150px;" onChange="ChangeGroupStatus(this.value)">' +
    //        '<option value="">Select</option><option class="<?//=(($type == 'in-complete') ?  'd-none' : '' )?>//" value="in-complete">In Complete</option><option class="<?//=(($type == 'complete') ?  'd-none' : '' )?>//" value="complete">Complete</option><option class="" value="delete">Delete</option>' +
    //        '</select></label>').appendTo(".dataTables_wrapper .dataTables_length");
    //}, 100);

    function DeleteGroup(UID) {
        if (confirm("Are You Want To Remove Group")) {
            response = AjaxResponse("form_process/remove_group", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

    function ChangeGroupStatus(status_id) {
        if (status_id != '') {
            if (confirm("Are your Sure to process multiple records, it will take time as well...?")) {
                cnt = 0;
                const groupids = [];
                // Adds "Kiwi"
                $(".todochkbox").each(function () {
                    inp = $(this).attr("id");
                    groupid = $(this).data("groupsid");
                    if ($("#" + inp).prop('checked')) {
                        groupids.push(groupid);
                        cnt++;
                    }
                })
                var response = AjaxResponse('form_process/group_status_process', "status_id=" + status_id + "&groupids=" + groupids);

                $("#StatusAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> ' +
                    '<strong style="font-size: 150%">Total ' + cnt + '</strong> Group(s) Updated Successfully... </div>')
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
</script>