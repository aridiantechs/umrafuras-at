

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">A.D.M

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
                                <th>Booking Date</th>
                                <th>Booking Time</th>
                                <th>Booking No</th>
                                <th>Agent Name</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Pax Name</th>
                                <th>PPT/ID.#</th>
                                <th>D O B</th>
                                <th>PNR</th>
                                <th>Airline</th>
                                <th>Flight No</th>
                                <th>Sector</th>
                                <th>Trip Nature</th>
                                <th>Dep Date</th>
                                <th>Vendor</th>
                                <th>Vendor Country</th>
                                <th>User ID</th>
                                <th>Reason</th>
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
                                <td>HH07H</td>
                                <td>Afwaj Travel</td>
                                <td>Pakistan</td>
                                <td>Layyah</td>
                                <td>Adil</td>
                                <td>88AA157IT</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td>4578BN</td>
                                <td>AirBlue</td>
                                <td>DDKKD123</td>
                                <td>ISB TO DXB</td>
                                <td>One Way</td>
                                <td><?= DATEFORMAT(date('19-m-Y')) ?></td>
                                <td>Qasim</td>
                                <td>Saudi Arabia </td>
                                <td>10</td>
                                <td>For Cancel Booking</td>
                                <td>Twitter</td>
                                <td>B2C</td>
                                <td>lalaservices.com</td>
                                <td>A.D.M</td>
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
                                <td>HH07H</td>
                                <td>AL Nawaz Travel</td>
                                <td>Pakistan</td>
                                <td>Layyah</td>
                                <td>Saad</td>
                                <td>KLIU157IT</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td>4578MN</td>
                                <td>Qatar AirWays</td>
                                <td>DDKKD123</td>
                                <td>DXB TO JED</td>
                                <td>Round Trip</td>
                                <td><?= DATEFORMAT(date('19-m-Y')) ?></td>
                                <td>Awais</td>
                                <td>Saudi Arabia </td>
                                <td>59</td>
                                <td>For Cancel Booking</td>
                                <td>LinkedIn</td>
                                <td>B2C</td>
                                <td>umrahfuras.com</td>
                                <td>A.D.M</td>
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