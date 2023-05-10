
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Ticket Re Issue

                </h4>

            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Full Name</label>
                                                        <input type="text" class="form-control" id="FullName"
                                                               placeholder="Full Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Email</label>
                                                        <input type="email" class="form-control" id="Email"
                                                               placeholder="Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Company Name</label>
                                                        <input type="text" class="form-control" id="Email"
                                                               placeholder="Company Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">User Type</label>
                                                        <select class="form-control" id="UserType"
                                                                name="UserType">
                                                            <option value="">Please Select</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">User Category</label>
                                                        <select class="form-control" id="UserCategory"
                                                                name="UserCategory">
                                                            <option value="">Please Select</option>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button id="multiple-messages"
                                                                class="btn btn_customized float-right">Search
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
                                <th>S.NO</th>
                                <th>Ticket Reissue Date</th>
                                <th>Approve Time</th>
                                <th>Ticket Reissue Time</th>
                                <th>Booking No</th>
                                <th>Agent Name</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Ticket #</th>
                                <th>PNR</th>
                                <th>Pax Name</th>
                                <th>PPT/ID.#</th>
                                <th>Airline</th>
                                <th>Flight No</th>
                                <th>Sector</th>
                                <th>Trip Nature</th>
                                <th>Dep Date</th>
                                <th>Amount</th>
                                <th>E-Mail</th>
                                <th>Contact No</th>
                                <th>Vendor</th>
                                <th>Vendor Country</th>
                                <th>Approve By</th>
                                <th>User ID</th>
                                <th>Reference</th>
                                <th>Category</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td>9090B</td>
                                <td>AL Nawaz Travel</td>
                                <td>Pakistan</td>
                                <td>Layyah</td>
                                <td>LKIP78ITU</td>
                                <td>1245OP</td>
                                <td>Awais</td>
                                <td>FGH45D3</td>
                                <td>PIA</td>
                                <td>FGH45D3</td>
                                <td>ISB TO JED</td>
                                <td>Round Trip</td>
                                <td><?= DATEFORMAT(date('10-m-Y')) ?></td>
                                <td>850 SAR</td>
                                <td>Awais@email.com</td>
                                <td>+9310444578</td>
                                <td>Qasim</td>
                                <td>Saudi Arabia </td>
                                <td>Saad (Accountant)</td>
                                <td>12</td>
                                <td>Twitter</td>
                                <td>B2C</td>
                                <td>umrahfuras.com</td>
                                <td>Re Issue</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                id="dropdownMenuReference1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1"
                                             style="will-change: transform;">
                                            <a class="dropdown-item" href="#"
                                               onclick="">Update</a>
                                            <a class="dropdown-item" href="#"
                                               onclick="">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td>LK88B</td>
                                <td>AL Abbas Travel</td>
                                <td>Pakistan</td>
                                <td>Islamabad</td>
                                <td>LKIP78ITU</td>
                                <td>BJM128</td>
                                <td>Saad</td>
                                <td>FGH45D3</td>
                                <td>Air Blue</td>
                                <td>FGH45D3</td>
                                <td>DXB TO ISB</td>
                                <td>One Way</td>
                                <td><?= DATEFORMAT(date('15-m-Y')) ?></td>
                                <td>850 SAR</td>
                                <td>Saad@email.com</td>
                                <td>+9310444578</td>
                                <td>Hammad</td>
                                <td>Saudi Arabia </td>
                                <td>Ali (Accountant)</td>
                                <td>12</td>
                                <td>Qasim (Sale Agent)</td>
                                <td>B2B</td>
                                <td>Tripplanner.pk</td>
                                <td>Re Issue</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                id="dropdownMenuReference1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1"
                                             style="will-change: transform;">
                                            <a class="dropdown-item" href="#"
                                               onclick="">Update</a>
                                            <a class="dropdown-item" href="#"
                                               onclick="">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td>LK88B</td>
                                <td>AL Abbas Travel</td>
                                <td>Pakistan</td>
                                <td>Karachi</td>
                                <td>LKIP78ITU</td>
                                <td>MLOP33</td>
                                <td>Fahad</td>
                                <td>FGH45D3</td>
                                <td>Qatar Airline</td>
                                <td>FGH45D3</td>
                                <td>DXB TO ISB</td>
                                <td>One Way</td>
                                <td><?= DATEFORMAT(date('15-m-Y')) ?></td>
                                <td>850 SAR</td>
                                <td>Fahad@email.com</td>
                                <td>+93101254789</td>
                                <td>Hammad</td>
                                <td>Saudi Arabia </td>
                                <td>Saad (Accountant)</td>
                                <td>66</td>
                                <td>Instagram</td>
                                <td>B2C</td>
                                <td>lalaservices.com</td>
                                <td>Re Issue</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                id="dropdownMenuReference1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false" data-reference="parent">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-chevron-down">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1"
                                             style="will-change: transform;">
                                            <a class="dropdown-item" href="#"
                                               onclick="">Update</a>
                                            <a class="dropdown-item" href="#"
                                               onclick="">Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>



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

    function DeleteUser(UID) {
        if (confirm("Are You Want To Remove user")) {
            response = AjaxResponse("form_process/remove_system_user","UID=" + UID);
            if (response.status == 'success')
            {
                location.href = "<?=base_url('user/index')?>";
            }


        }
    }
</script>