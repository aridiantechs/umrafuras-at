<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> All Booking

                </h4>

            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" action="<?= $path ?>ticket/bookings" method="post">
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
                                                            <label for="country">Agent Name</label>
                                                            <input type="text" class="form-control" id="agentname"
                                                                placeholder="Agent Name" name="agent_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="country">Email</label>
                                                            <input type="email" class="form-control" id="Email"
                                                                placeholder="Email" name="email">
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-3">
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
                                                    </div> -->

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <input type="submit" id="multiple-messages" class="btn btn_customized float-right" name="search" value="Search">                                                   
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
                                <th>Airline</th>
                                <th>Flight No</th>
                                <th>Sector</th>
                                <th>Trip Nature</th>
                                <th>Dep Date</th>
                                <th>Net Amount</th>
                                <th>E-Mail</th>
                                <th>Contact No</th>
                                <th>User ID</th>
                                <th>Reference</th>
                                <th>Category</th>
                                <th>Website</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php if(isset($bookings->data)){ ?>
                            <?php foreach ($bookings->data as $key => $booking) { ?>
                            <tr>
                                <td><?php echo($booking->id); ?></td>
                                <td><?php echo( date('d-m-Y' , strtotime($booking->booking_date))); ?></td>
                                <td><?php echo( date('H:i:A' , strtotime($booking->booking_date))); ?></td>
                                <td><?php echo( $booking->booking_no); ?></td>
                                <td><?php echo( $booking->agent_name); ?></td>
                                <td><?php echo( $booking->country); ?></td>
                                <td><?php echo( $booking->city); ?></td>
                                <td><?php echo( $booking->pax_name); ?></td>
                                <td><?php echo( $booking->ppt_id); ?></td>
                                <td><?php echo( date('d-m-Y' , strtotime($booking->dob))); ?></td>
                                <td><?php echo( $booking->airline); ?></td>
                                <td><?php echo( $booking->flight_no); ?></td>
                                <td><?php echo( $booking->sector); ?></td>
                                <td><?php echo( $booking->trip_nature); ?></td>
                                <td><?php echo( date('d-m-Y' , strtotime($booking->departure_date))); ?></td>
                                <td><?php echo( $booking->net_amount); echo( $booking->currency); ?></td>
                                <td><?php echo( $booking->email); ?></td>
                                <td><?php echo( $booking->contact_no); ?></td>
                                <td><?php echo( $booking->customer_id); ?></td>
                                <td><?php echo( $booking->reference_name); ?></td>
                                <td><?php echo( $booking->category); ?></td>
                                <td><?php echo( $booking->website); ?></td>
                                <td><?php echo( $booking->status); ?></td>
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
                            <?php }} ?>
                            <!-- <tr>
                                <td>2</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td><?= date('H:i:A') ?></td>
                                <td>B507H</td>
                                <td>Al Nawaz Travel</td>
                                <td>Pakistan</td>
                                <td>Karachi</td>
                                <td>Nadeem</td>
                                <td>0096157IT</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td>Emirates</td>
                                <td>AACCD123</td>
                                <td>JED TO DXB</td>
                                <td>One Way</td>
                                <td><?= DATEFORMAT(date('11-m-Y')) ?></td>
                                <td>500 SAR</td>
                                <td>nadeem@email.com</td>
                                <td>+93125225489</td>
                                <td>13</td>
                                <td>Instagram</td>
                                <td>B2C</td>
                                <td>lalaservices.com</td>
                                <td>Booked</td>
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
                                <td>HH07H</td>
                                <td>Afwaj Travel</td>
                                <td>Pakistan</td>
                                <td>Layyah</td>
                                <td>Adil</td>
                                <td>88AA157IT</td>
                                <td><?= DATEFORMAT(date('d-m-Y')) ?></td>
                                <td>AirBlue</td>
                                <td>DDKKD123</td>
                                <td>ISB TO JED</td>
                                <td>Round Trip</td>
                                <td><?= DATEFORMAT(date('19-m-Y')) ?></td>
                                <td>700 SAE</td>
                                <td>adil@email.com</td>
                                <td>+9311445481</td>
                                <td>10</td>
                                <td>Facebook</td>
                                <td>B2C</td>
                                <td>lalainttravel.com</td>
                                <td>Booked</td>
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
                            </tr> -->

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

</script>