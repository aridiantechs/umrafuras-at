<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Use BRN
                    <button type="button" class="btn btn_customized btn-sm float-right"
                            onclick="LoadModal('brn/use_brn_main_form', 0,'modal-lg')">Create New Use BRN
                    </button>

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class=" " data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">City</label>
                                                        <input type="text" class="form-control" name="City"
                                                               placeholder="City">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Hotel Name</label>
                                                        <input type="text" class="form-control" name="Hotel Name"
                                                               value=""
                                                               placeholder="Hotel Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">BRN</label>
                                                        <input type="email" class="form-control" name="BRN"
                                                               value=""
                                                               placeholder="BRN  ">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="country">Purchased ID</label>
                                                        <input type="email" class="form-control" name="Purchase ID"
                                                               value=""
                                                               placeholder="Purchased ID">
                                                    </div>
                                                </div>


                                                <div class="col-md-4" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('AgentSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('AgentSearchFilter'); return false;"
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
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Operator</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                <th>Purchased ID</th>
                                <th>BRN Code</th>
                                <th>City</th>
                                <th>Hotel Name</th>
                                <th>Rooms</th>
                                <th>Beds</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th>Nights</th>
                                <th>Expire Date</th>
                                <th>Purchased By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $days = '';
                                $days = date_diff(date_create($record['GenerateDate']), date_create($record['ActiveDate']));
                                $days = $days->days;

                                $cnt++;
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'brn/use_brn_main_form\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>
                                    <a class="dropdown-item" href="#" onclick="DeleteUseBRN(' . $record['UID'] . ');">Delete</a>
                                </div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                     <td>' . $record['CompanyName'] . '</td>
                                    <td>' . UserNameByID($record['CreatedBy']) . '</td>
                                    <td>' . DATEFORMAT($record['CreatedDate']) . '</td>
                                    <td>' . $record['PurchaseID'] . '</td>                                      
                                    <td>' . $record['BRNCode'] . '</td>                                
                                    <td>' .CityName( $record['HotelCity']).'</td>                                
                                     <td>' . $record['HotelName'] . '</td>
                                     <td>' . $record['Rooms'] . '</td>
                                    <td>' . $record['Beds'] . '</td>                                   
                                    <td>' . DATEFORMAT($record['GenerateDate']) . '</td>
                                    <td>' . DATEFORMAT($record['ActiveDate']) . '</td>
                                    <td>'.$days.' Nights</td>
                                    <td>' . DATEFORMAT($record['ExpireDate']) . '</td>                               
                                    <td>' . UserNameByID($record['PurchasedBy']) . '</td>  
                               
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
    });


    function DeleteUseBRN(UID) {
        if (confirm("Are You Want To Remove BRN")) {
            response = AjaxResponse("form_process/remove_use_brn","UID=" + UID);
            if (response.status == 'success')
            {
                location.href = "<?=base_url('brn/use_brn')?>";
            }


        }
    }
</script>