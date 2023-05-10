<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-spacing">

            <!-- Content -->
            <div class="col-xl-4 col-lg-6 col-md-5 col-sm-12 layout-top-spacing">
                <div class="user-profile layout-spacing">
                    <div class="widget-content widget-content-area">
                        <div class="d-flex justify-content-between">
                            <h3 class="">Pilgrim Details</h3>
                            <a href="<?= $path ?>pilgrim/update" class="mt-2 edit-profile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-edit-3">
                                    <path d="M12 20h9"></path>
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="text-center user-info">
                            <img src="<?= $template ?>assets/img/90x90.jpg" alt="avatar">
                            <p class="">Saad Malik</p>
                        </div>
                        <div class="user-info-list">

                            <div class="">
                                <ul class="contacts-block list-unstyled">
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-coffee">
                                            <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                                            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                                            <line x1="6" y1="1" x2="6" y2="4"></line>
                                            <line x1="10" y1="1" x2="10" y2="4"></line>
                                            <line x1="14" y1="1" x2="14" y2="4"></line>
                                        </svg>
                                        Web Developer
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        Jan 20, 1989
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-map-pin">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        New York, USA
                                    </li>
                                    <li class="contacts-block__item">
                                        <a href="mailto:example@mail.com">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                 stroke-linecap="round" stroke-linejoin="round"
                                                 class="feather feather-mail">
                                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                                <polyline points="22,6 12,13 2,6"></polyline>
                                            </svg>
                                            Jimmy@gmail.com</a>
                                    </li>
                                    <li class="contacts-block__item">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="feather feather-phone">
                                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                        </svg>
                                        +1 (530) 555-12121
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-6 col-md-7 col-sm-12 layout-top-spacing">
                <div class="skills layout-spacing ">
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <h4 class="page-head">Details</h4>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <form class="section contact">
                                    <div id="toggleAccordion">
                                        <div class="card">
                                            <div class="card-header">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                                         data-target="#FilghtsDetails" aria-expanded="false"
                                                         aria-controls="FilghtsDetails">
                                                        Flight's Detail
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="FilghtsDetails" class="collapse " aria-labelledby=""
                                                 data-parent="#toggleAccordion">
                                                <div class="card-body">
                                                    <div id="FlightR" name="FlightR">
                                                        <div class="row" id="FlightRows" name="FlightRows">
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Airport</label>
                                                                    <input type="text" class="form-control" id="Airport"
                                                                           name="Airport" aria-describedby="emailHelp1"
                                                                           placeholder="Airport">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Flight No</label>
                                                                    <input type="text" class="form-control"
                                                                           id="FlightNumber" name="FlightNumber"
                                                                           aria-describedby="emailHelp1"
                                                                           placeholder="Flight Number">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Departure Date</label>
                                                                    <input type="date" class="form-control"
                                                                           id="DepartureDate" name="DepartureDate"
                                                                           aria-describedby="emailHelp1"
                                                                           placeholder="Departure Date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Departure Time</label>
                                                                    <input type="time" class="form-control"
                                                                           id="DepartureTime" name="DepartureTime"
                                                                           aria-describedby="emailHelp1"
                                                                           placeholder="Departure Time">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Arrival Date</label>
                                                                    <input type="date" class="form-control"
                                                                           id="ArrivalDate"
                                                                           name="ArrivalDate"
                                                                           aria-describedby="emailHelp1"
                                                                           placeholder="Arrival Date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Arrival Time</label>
                                                                    <input type="time" class="form-control"
                                                                           id="ArrivalTime"
                                                                           name="ArrivalTime"
                                                                           aria-describedby="emailHelp1"
                                                                           placeholder="Arrival Time">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-bottom: 20px;">
                                                        <a name="removeButton" href="javascript:void(0);"
                                                           id="removeButton"
                                                           class="float-right"><span>
                                                        <i class="fa fa-trash" title="Remove"></i></span></a>
                                                        <a href="javascript:void(0);" id="AddFlightRows"
                                                           class="float-right" style="margin-right: 10px;"
                                                           onclick="AddNewRow();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                                         data-target="#defaultAccordionTwo" aria-expanded="false"
                                                         aria-controls="defaultAccordionTwo">
                                                        Hotel's Detail
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="defaultAccordionTwo" class="collapse"
                                                 data-parent="#toggleAccordion">
                                                <div class="card-body">
                                                    <div id="HotelR" name="HotelR">
                                                        <div class="row" id="HotelRows" name="HotelRows">
                                                            <input type="hidden" name="counter" id="counter" value="1">
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Name</label>
                                                                    <input type="text" class="form-control" id="Name"
                                                                           name="Name" aria-describedby="emailHelp1"
                                                                           placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">City</label>
                                                                    <input type="text" class="form-control" id="City"
                                                                           name="City" aria-describedby="emailHelp1"
                                                                           placeholder="City">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Check-In</label>
                                                                    <input type="date" class="form-control" id="CheckIn"
                                                                           name="CheckIn" aria-describedby="emailHelp1"
                                                                           placeholder="Check In">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Check-Out</label>
                                                                    <input type="date" class="form-control"
                                                                           id="CheckOut"
                                                                           name="CheckOut" aria-describedby="emailHelp1"
                                                                           placeholder="Check Out">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Nights</label>
                                                                    <input type="number" class="form-control"
                                                                           id="Nights"
                                                                           name="Nights" aria-describedby="emailHelp1"
                                                                           placeholder="Nights" min="1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group mb-3">
                                                                    <label for="country">Room Type</label>
                                                                    <select class="form-control" id="RoomType"
                                                                            name="RoomType">
                                                                        <option value="">Please Select</option><?php
                                                                        foreach ($RoomTypes as $RT) {
                                                                            echo '<option value="' . $RT['Title'] . '">' . $RT['Title'] . '</option>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <hr>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" style="margin-bottom: 20px;">
                                                        <a name="hotelremoveButton" href="javascript:void(0);"
                                                           id="hotelremoveButton"
                                                           class="float-right d-none"><span>
                                                        <i class="fa fa-trash" title="Remove"></i></span></a>
                                                        <a href="javascript:void(0);" id="AddFlightRows"
                                                           class="float-right" style="margin-right: 10px;"
                                                           onclick="AddNewHotel();"><span>
                                                        <i class="fa fa-plus" title="Add More"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card">
                                            <div class="card-header">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                                         data-target="#defaultAccordionThree" aria-expanded="false"
                                                         aria-controls="defaultAccordionThree">
                                                        Extra
                                                    </div>
                                                </section>
                                            </div>
                                            <div id="defaultAccordionThree" class="collapse" aria-labelledby="..."
                                                 data-parent="#toggleAccordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mx-auto">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="country">Birth Country</label>
                                                                        <select class="form-control" id="country">
                                                                            <option>Please Select</option>
                                                                            <option>United States</option>
                                                                            <option>India</option>
                                                                            <option>Japan</option>
                                                                            <option>China</option>
                                                                            <option>Brazil</option>
                                                                            <option>Norway</option>
                                                                            <option>Canada</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="address">Birth City</label>
                                                                        <input type="text" class="form-control mb-4"
                                                                               id="birth_city"
                                                                               placeholder="Birth City">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="as-footer-container float-right">
                                        <button id="multiple-reset" class="btn btn-primary">Reset All</button>
                                        <button id="multiple-messages" class="btn btn-dark">Save Changes</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function AddNewRow() {
        var itm = document.getElementById("FlightRows");
        var cln = itm.cloneNode(true);
        document.getElementById("FlightR").appendChild(cln);

    }

    $('[name=removeButton]').click(function () {
        $('#FlightR #FlightRows').slice(-1).remove();
    });

    function AddNewHotel() {
        var i = $("#counter").val();
        var itm = document.getElementById("HotelRows");
        var cln = itm.cloneNode(true);
        document.getElementById("HotelR").appendChild(cln);
        $("#counter").val(i);
        i++;

        if (i > 1) {
            $("a#hotelremoveButton").removeClass("d-none");
        } else {
            $("a#hotelremoveButton").addClass("d-none");
        }
    }

    $('[name=hotelremoveButton]').click(function () {
        $('#HotelR #HotelRows').slice(-1).remove();
    });

</script>