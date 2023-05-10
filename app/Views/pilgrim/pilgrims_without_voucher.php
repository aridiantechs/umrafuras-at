<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Without Voucher Arrvial PAX

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing <?=( ($AgentLogged) ? 'd-none' : '' )?>">
                <form class="section contact" id="PilgrimSearchFilter">
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
                                                        <label for="country">Full Name</label>
                                                       <input class="form-control" id="name" name="name" placeholder="Full Name"
                                                              value="<?=( (isset($session['PilgrimSearchFilter']['name'])) ? $session['PilgrimSearchFilter']['name'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Email</label>
                                                       <input class="form-control" id="email" name="email" placeholder="Email" type="email"
                                                              value="<?=( (isset($session['PilgrimSearchFilter']['name'])) ? $session['PilgrimSearchFilter']['name'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Nationality</label>
                                                        <input class="form-control" id="nationality" name="nationality" placeholder="Nationality"
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['nationality'])) ? $session['PilgrimSearchFilter']['nationality'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Contact Number</label>
                                                        <input class="form-control" id="contactnumber" name="contactnumber" placeholder="Contact Number"
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['nationality'])) ? $session['PilgrimSearchFilter']['nationality'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Passport Number</label>
                                                        <input class="form-control" id="passportnumber" name="passportnumber" placeholder="Passport Number"
                                                               value="<?=( (isset($session['PilgrimSearchFilter']['nationality'])) ? $session['PilgrimSearchFilter']['nationality'] : '' )?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                    <button onclick="UpdateFilters('PilgrimSearchFilter'); return false;"
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
                    <div id="AgentPilgrimAssignResponse"></div>
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Agent</th>
                                <th>Group</th>
                                <th>Full Name</th>
                                <th>Passport Number</th>
                                <th width="90">DOB</th>
                                <th>DOB In Years</th>
                                <th>Country</th>
                                <th>Current Status</th>

                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt=0;
                            foreach ($records as $record) {
                                $cnt++;
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="' . $path . 'pilgrim/new/'. $record['UID'].'">Update</a>
                                    <a class="dropdown-item" href="'.SeoUrl('exports/pilgrim/'.$record['UID']."-".$record['FirstName']).' " target="_blank">Export Pilgrim Details</a>
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'pilgrim/update_visa\', '.$record['UID'].')" >Update Visa Detail</a>

                                </div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>  
                                    <td>' . Code('UF/P/', $record['UID']) . '</td>  ';
                                if(isset($record['AgentName']))
                                {echo'<td>' . $record['AgentName'] . '</td>'; }
                                else{ echo'
                                        <td><div class="form-group">
                                            <select onchange="AgentPilgrimAssign(this.value,'.$record['UID'].');"  class="form-control" title="Agents" id="Agents" name="Agents">';
                                                 echo $AgentsDropDown['html'];
                                    echo'</select></div></td>'; }
                                echo'
                                    <td>' . $record['GroupName'] . '</td>
                                    <td>' . $record['FirstName'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . DATEFORMAT($record['DOB']) . '</td>
                                    <td>' . $record['DOBInYears'] . '</td>
                                    <td>' . CountryName($record['Country']) . '</td>
                                    <td>' . $Statuses[$record['CurrentStatus']] . '</td>
                                    
                                </tr>';
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

    $('#MainRecords').DataTable({
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
        "lengthMenu": [100, 200, 300, 400],
        "pageLength": 100
    });

    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/pilgrim_list_without_voucher" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);



    //function VOUPilgrimFileFormSubmitt(parent) {
    //
    //    var phpdata = new window.FormData($("form#" + parent)[0]);
    //    var response = AjaxUploadResponse('form_process/vou_pilgrim_file_form_submit', phpdata);
    //
    //    if (response.status == 'success') {
    //        $("#WOUPilgrimAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
    //        setTimeout(function () {
    //            location.href = "<?//=base_url('pilgrim/index')?>//";
    //        }, 2000)
    //    } else {
    //        $("#WOUPilgrimAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
    //    }
    //
    //}

    function AgentPilgrimAssign(agent_id, row_id) {
        if (agent_id > 0) {
            if (confirm("Are You Sure You Want To Assign Agent?")) {
                var response = AjaxResponse('form_process/agent_pilgrim_add_process', "agent_id=" + agent_id + "&pilgrimID=" + row_id);
                if (response.status == 'success') {
                    $("#AgentPilgrimAssignResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
                    setTimeout(function () {
                        location.reload();
                    }, 10)
                } else {
                    $("#AgentPilgrimAssignResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
                }
            }
        }
    }
</script>