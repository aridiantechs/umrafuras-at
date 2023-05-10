<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Hotels
                    <?php if ($CheckAccess['umrah_services_hotel_add_new']) { ?>
                        <button type="button" class="btn btn_customized btn-sm float-right"
                                onclick="LoadModal('package/hotel/main_form', 0, 'modal-xl')">Add New
                        </button>
                    <?php } ?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="HotelSearchFilter">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Name</label>
                                                        <input type="text" class="form-control" name="name"
                                                               value="<?= ((isset($session['HotelSearchFilter']['name'])) ? $session['HotelSearchFilter']['name'] : '') ?>"
                                                               placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Telephone Number</label>
                                                        <input type="number" class="form-control" name="phone_number"
                                                               value="<?= ((isset($session['HotelSearchFilter']['phone_number'])) ? $session['HotelSearchFilter']['phone_number'] : '') ?>"
                                                               placeholder="Telephone Number" min="1">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilters('HotelSearchFilter'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilters('HotelSearchFilter'); return false;"
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
                                <th>#</th>
                                <th>Hotel Ref. ID</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Telephone No</th>
                                <th>Contact Person</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody><?php
                            $cnt = 0;
                            foreach ($records as $record) {
                                $cnt++;

                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">';
                                if ($CheckAccess['umrah_services_hotel_update']) {
                                    $actions .= '<a class="dropdown-item" href="#" onclick="LoadModal(\'package/hotel/main_form\', ' . $record['UID'] . ', \'modal-xl\')">Update</a>';
                                }
                                if ($CheckAccess['umrah_services_hotel_delete']) {
                                    $actions .= '  <a class="dropdown-item" href="#" onclick="DeleteHotel(' . $record['UID'] . ');">Delete</a>';
                                }
                                if ($CheckAccess['umrah_services_hotel_print_download']) {
                                    $actions .= '  <a class="dropdown-item" href="' . SeoUrl('exports/hotel/' . $record['UID'] . "-" . $record['Name']) . '" target="_blank">Print/Download</a>';
                                }
                                $actions .= '</div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                     <td>' . Code('UF/H/', $record['UID']) . '</td>
                                     <td>' . CountryName($record['CountryID']) . '</td>
                                    <td>' . CityName($record['CityID']) . '</td>
                                    <td>' . OptionName($record['Category']) . '</td>                                          
                                    <td>' . $record['Name'] . '</td>         
                                      <td>' . $record['TelephoneNumber'] . '</td>                    
                                      <td>N/A   </td>                    
                                    <td>' . $record['Address'] . '</td>';
                                if ($CheckAccess['umrah_services_hotel_update'] || $CheckAccess['umrah_services_hotel_delete'] || $CheckAccess['umrah_services_hotel_print_download']) {
                                    echo '                                   
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
                                    </td>';
                                } else {
                                    echo '<td>-</td>';
                                }
                                echo '
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
        "lengthMenu": [[100,500,1000,-1],[100,500,1000,'All']],
        "pageLength": 100
    });

    function DeleteHotel(UID) {
        if (confirm("Are You Want To Remove?")) {
            response = AjaxResponse("form_process/remove_hotel", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('package/hotel')?>";
            }


        }
    }
    <?php if ($CheckAccess['umrah_services_hotel_export']) { ?>
    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>exports/hotels_list" class="dt-filter-btn">Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);
    <?php } ?>
</script>