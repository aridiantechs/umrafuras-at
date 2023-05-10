<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
        <!--         <div class="alert alert-info mb-4" role="alert" id="NoteResponse"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Note!</strong> Pilgrim Must Have Visa Number </div>-->

        <form class="section contact" id="VoucherPilgrimSearchFilter">
            <div id="toggleAccordion">
                <div class="card">
                    <div class="card-header">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="collapsed"
                                 data-toggle="collapse"
                                 data-target="#FilterDetails"
                                 aria-expanded="false"
                                 aria-controls="FilterDetails">
                                Filters
                            </div>
                        </section>
                    </div>
                    <div id="FilterDetails" class="collapse"
                         aria-labelledby=""
                         data-parent="#toggleAccordion">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Name</label>
                                                <input type="text"
                                                       class="form-control"
                                                       name="name" id="name"
                                                       value=""
                                                       placeholder="Full Name">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Passport
                                                    Number</label>
                                                <input type="email"
                                                       class="form-control"
                                                       name="passport_number"
                                                       value=""
                                                       placeholder="Passport Number">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="country">Visa
                                                    Number</label>
                                                <input type="number"
                                                       class="form-control"
                                                       name="visa_number"
                                                       value=""
                                                       placeholder="Visa Number"
                                                       min="1">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group float-right">
                                                <button onclick=""
                                                        class="btn btn-success">
                                                    Search
                                                </button>
                                                <button onclick=""
                                                        class="btn btn-danger">
                                                    Clear Filter
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
            <div class="table-responsive" id="pilgrimgrid" style="overflow: auto;max-height: 360px;">
                <table id="MainRecords" class="display nowrap table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                    <tr>
                        <th class="checkbox-column">
                            <label class="new-control new-checkbox checkbox-primary"
                                   style="height: 18px; margin: 0 auto;">
                                <input type="checkbox"
                                       class="new-control-input todochkbox"
                                       id="todoAll">
                                <span class="new-control-indicator"></span>
                            </label>
                        </th>
                        <th>Leader</th>
                        <th>Pilgrim ID</th>
                        <th>Pilgrim Name</th>
                        <th>Age</th>
                        <th>Passport No</th>
                        <th>MOFA No</th>
                        <th>Visa No</th>
                        <th>Visa Issue Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $cnt = 0;
                    $voucher_pilgrims = $records['voucher_pilgrims'];
                    foreach ($records['pilgrims'] as $record) {
                        $cnt++;
                        //if ($record['CurrentStatus'] == 'exit-to-ksa' || $record['CurrentStatus'] == 'elm-upload' || $record['CurrentStatus'] == NULL || $record['CurrentStatus'] == 'mofa-issued') {
                            echo '<tr> ';
                            echo '
                            <div class="Check" id="Check">
                             <td class="checkbox-column">
                                    <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                        <input type="checkbox" ' . ((in_array($record['UID'], $records['voucher_pilgrims'])) ? 'checked' : ( ( count($voucher_pilgrims) > 0 )? '' : 'checked' ) ) . ' class="new-control-input todochkbox CheckFlag" id="todo-' . $cnt . '"  name="VoucherPilgrimID[]" value="' . $record['UID'] . '" onclick="pilgrimlistchecked(' . $cnt . ');">
                                        <span class="new-control-indicator"></span>
                                    </label>
                                </td>
                             </div>';
                            echo '<td>
                                <div class="custom-control custom-radio" style="padding-left:0px">
                                    <input type="radio" id="leader' . $cnt . '" name="leader[]" ' . ((in_array($record['UID'], $records['voucher_pilgrim_leader'])) ? ' checked' : '') . ' class="custom-control-input" value="' . $record['UID'] . '" onclick="pilgrimleaderchecked(' . $cnt . ');">
                                    <label class="custom-control-label" for="leader' . $cnt . '"></label>
                                </div>
                         </td>';

                            echo '
                           <td> <a href="' . $path . 'pilgrim/new/' . $record['UID'] . '" target="_blank"> ' . Code('UF/P/', $record['UID']) . '</a></td> 
                            <td>' . $record['FirstName'] . '</td>
                             <td>' . $record['DOBInYears'] . ' Y</td>
                            <td>' . $record['PassportNumber'] . '</td>                          
                            <td>' . $record['MOFANumber'] . '</td>
                            <td>' . $record['VisaNumber'] . '</td>
                            <td>' . $record['IssueDate'] . '</td>
                       </tr>';
                      //  }
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>


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
        "lengthMenu": [[-1], ["All"]],
        "pageLength": -1
    });

    checkall('todoAll', 'todochkbox');
    $('[data-toggle="tooltip"]').tooltip()

</script>