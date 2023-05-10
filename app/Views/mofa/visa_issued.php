<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Visa Issued</h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="VisaIssuedSearchFilter">
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
                            <div id="FilterDetails" class="collapse " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
<!--                                                <div class="col-md-3">-->
<!--                                                    <div class="form-group">-->
<!--                                                        <label for="country">Group</label>-->
<!--                                                        <select class="form-control validate[required]" id="Group"-->
<!--                                                                name="Group">-->
<!--                                                            <option value="">Please Select</option>-->
<!--                                                            --><?php
//                                                            foreach ($groups as $options)
//                                                            {
//                                                                echo'<option value="'.$options['UID'].'">'.$options['FullName'].'</option>';
//                                                            }
//                                                            ?>
<!--                                                        </select>-->
<!--                                                    </div>-->
<!--                                                </div>-->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                               value="<?=( (isset($session['VisaIssuedSearchFilter']['name'])) ? $session['VisaIssuedSearchFilter']['name'] : '' )?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Passport Number</label>
                                                        <input type="text" class="form-control" name="passport_number"
                                                               value="<?=( (isset($session['VisaIssuedSearchFilter']['passport_number'])) ? $session['VisaIssuedSearchFilter']['passport_number'] : '' )?>"
                                                               placeholder="Passport Number">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('VisaIssuedSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('VisaIssuedSearchFilter'); return false;"
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
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover  display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Ref. ID</th>
                                <th>Agent</th>
                                <th>Group</th>
                                <th>MOFA Pilgrim ID</th>
                                <th>Full Name</th>
                                <th>Nationality</th>
                                <th>Passport Number</th>
                                <th>MOFA Number</th>
                                <th>Download</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            foreach ($records as $record) {
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="#" onclick=""></a>
                                </div>';
                                echo '
                                <tr>
                                    <td>' . Code('UF/VI/',$record['UID']) . '</td>                              
                                    <td>' . $record['AgentFullName'] . '</td>
                                    <td>' . $record['GroupFullName'] . '</td>
                                    <td>' . $record['MOFAPilgrimID'] . '</td>
                                    <td>' . $record['FirstName'] . '</td>
                                    <td>' . $record['Nationality'] . '</td>
                                    <td>' . $record['PassportNumber'] . '</td>
                                    <td>' . $record['MOFANumber'] . '</td>
                                   <td style="text-align: center;"><a href="'.$path.'home/load_file/' . $record['VisaID'] . '" target="_blank"> <i class="fas fa-download"></i></a></td>

                                    
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
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });

    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/visa_issued_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);

</script>