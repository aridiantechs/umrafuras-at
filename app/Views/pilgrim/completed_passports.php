<?php

use App\Models\Crud;

?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Completed Passports
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing <?= (($AgentLogged) ? 'd-none' : '') ?>">
                <form class="section contact" id="CompletedPassportPilgrimSearchFilter">
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
                                                        <label for="agent">Agent</label>
                                                        <select class="form-control" id="agent"
                                                                name="agent">
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                </div>

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
                                                        <label for="Name">Full Name</label>
                                                        <input class="form-control" id="name" name="name" type="text"
                                                               placeholder="Agent Name"
                                                               value="">
                                                    </div>
                                                </div>


                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="passportNo">Passport No</label>
                                                        <input class="form-control" id="passportNo" name="passportNo" type="text"
                                                               placeholder="passportNo"
                                                               value="">
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
                                                        <label for="Nationality">Nationality</label>
                                                        <input class="form-control" id="Nationality" name="Nationality"
                                                               placeholder="Nationality">
                                                    </div>
                                                </div>



<!--                                                <div class="col-md-2">-->
<!--                                                    <div class="form-group">-->
<!--                                                        <label for="country">From</label>-->
<!--                                                        <input class="form-control" id="From" name="From" type="date"-->
<!--                                                               placeholder="From"-->
<!--                                                               value="">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                                <div class="col-md-2">-->
<!--                                                    <div class="form-group">-->
<!--                                                        <label for="country">To</label>-->
<!--                                                        <input class="form-control" id="To" name="To" type="date"-->
<!--                                                               placeholder="To"-->
<!--                                                               value="">-->
<!--                                                    </div>-->
<!--                                                </div>-->



                                                <div class="col-md-12">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('CompletedPassportPilgrimSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('CompletedPassportPilgrimSearchFilter'); return false;"
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
                                <th width="90">DOB</th>
                                <th>Nationality</th>
                                <th>Front</th>
                                <th>Back</th>
                                <th>Booklet</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                if ($record['PassportIMGs'] == 3) {
                                    $Crud = new Crud();
                                    $table = 'pilgrim."attachments"';
                                    $where = array("PilgrimID" => $record['UID']);
                                    $Pictures = $Crud->ListRecords($table, $where);
                                    $PassportPics = array();
                                    foreach ($Pictures as $picture) {
                                        $PassportPics[$picture['FileDescription']] = $picture['FileID'];
                                    }
                                    $cnt++;
                                    echo '
                                    <tr>
                                        <td>' . $cnt . '</td>  
                                        <td>' . Code('UF/P/', $record['UID']) . '</td>  
                                        <td>N/A</td>  
                                        <td>' . $record['AgentName'] . '</td>
                                        <td>' . $record['GroupName'] . '</td>
                                        <td>' . $record['FirstName'] . '</td>
                                        <td>' . $record['PassportNumber'] . '</td>
                                        <td>' . DATEFORMAT($record['DOB']) . '</td>
                                        <td>' . $record['Nationality'] . '</td>  
                                       <td><a href="' . $path . 'home/load_file/' . $PassportPics['PassportFrontPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>  
                                       <td><a href="' . $path . 'home/load_file/' . $PassportPics['PassportBackPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>  
                                       <td><a href="' . $path . 'home/load_file/' . $PassportPics['PassportBookletPic'] . '" target="_blank" data-toggle="tooltip" data-placement="top" title="Download"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg></a></td>  
                                                                         
                                    </tr>';
                                }
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


</script>