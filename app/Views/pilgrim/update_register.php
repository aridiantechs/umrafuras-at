<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                     data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <h4 class="page-head">Update Pilgrim <small class="float-right"> <?=$record_id?> - Saad Malik </small></h4>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form class="section contact">
                                <div id="toggleAccordion">
                                    <div class="card <?=( ($AgentLogged) ? 'd-none' : '' )?>">
                                        <div class="card-header">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="" data-toggle="collapse"
                                                     data-target="#GroupDetails" aria-expanded="true"
                                                     aria-controls="GroupDetails">
                                                    Current Group
                                                </div>
                                            </section>
                                        </div>

                                        <div id="GroupDetails" class="collapse  show" aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="country">Operators : </label>
                                                                    <p> 1930 - Agency AL Qafelah AL Syahya Co. For Umrah Service </p>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="country">Agents : </label>
                                                                    <p>1922 - ARIES TRAVEL & TOURS (PVT) LTD</p>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="country">Groups : </label>
                                                                    <p>121 - New Group</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="collapsed" data-toggle="collapse"
                                                     data-target="#PersonalDetails" aria-expanded="false"
                                                     aria-controls="PersonalDetails">
                                                    Personal
                                                </div>
                                            </section>
                                        </div>

                                        <div id="PersonalDetails" class="collapse " aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="address">Upload Photo</label>
                                                                    <input type="file" class="form-control mb-4"
                                                                           id="upload_photo">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="country">Title</label>
                                                                    <select class="form-control" id="title"
                                                                            name="title">
                                                                        <option>Please Select</option>
                                                                        <option>Mr.</option>
                                                                        <option value="2">Miss</option>
                                                                        <option value="3">Mrs.</option>
                                                                        <option value="4">Dr.</option>
                                                                        <option value="5">His Excellency</option>
                                                                        <option value="6">His Royal Highness</option>
                                                                        <option value="99">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="address">First Name</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="first_name"
                                                                           placeholder="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Father Name</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="father_name"
                                                                           placeholder="Father Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="phone">Grand Father</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="grand_father"
                                                                           placeholder="Grand Father">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="email">Family Name</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="family_name"
                                                                           placeholder="Family Name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                    Passport
                                                </div>
                                            </section>
                                        </div>
                                        <div id="defaultAccordionTwo" class="collapse"
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="country">Passport Type</label>
                                                                    <select class="form-control" id="country">
                                                                        <option>Please Select</option>
                                                                        <option>Normal</option>
                                                                        <option>Diplomatic</option>
                                                                        <option>Travel Document</option>
                                                                        <option>UN Passport</option>
                                                                        <option>Others</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="address">Passport No</label>
                                                                    <input type="number" class="form-control mb-4"
                                                                           id="passport_no"
                                                                           placeholder="Passport No" value="" min="1">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="location">Issue Country</label>
                                                                    <select class="form-control" id="country">
                                                                        <option>Please Select</option>
                                                                        <option>Pakistan</option>
                                                                        <option>Saudi Arabia</option>
                                                                        <option>Turkey</option>
                                                                        <option>England</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="phone">Passport Issue City</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="passport_issue_city"
                                                                           placeholder="Passport Issue City">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="email">Passport Issue Date</label>
                                                                    <input type="date" class="form-control mb-4"
                                                                           id="passport_issue_date"
                                                                           placeholder="Passport Issue Date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="website1">Passport Expiry Date</label>
                                                                    <input type="date" class="form-control mb-4"
                                                                           id="passport_expiry_date"
                                                                           placeholder="Passport Expiry Date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                            <div class="col-md-2">
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
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="address">Birth City</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="birth_city"
                                                                           placeholder="Birth City">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Birth Date</label>
                                                                    <input type="date" class="form-control mb-4"
                                                                           id="birth_date"
                                                                           placeholder="Birth Date">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="country">Gender</label>
                                                                    <select class="form-control" id="gender">
                                                                        <option>Please Select</option>
                                                                        <option>Male</option>
                                                                        <option>Female</option>
                                                                        <option>Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="country">Nationality</label>
                                                                    <select class="form-control" id="nationality">
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
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="country">Previous Nationality</label>
                                                                    <select class="form-control"
                                                                            id="previous_nationality">
                                                                        <option>No Previous Nationality</option>
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
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="country">Education</label>
                                                                    <select class="form-control" id="Education">
                                                                        <option>Please Select</option>
                                                                        <option>Primary School</option>
                                                                        <option>High School</option>
                                                                        <option>College Edu.</option>
                                                                        <option>Higher Edu.</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Profession</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="Profession"
                                                                           placeholder="Profession">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Country</label>
                                                                    <select class="form-control" id="Country">
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
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Martial Status</label>
                                                                    <select class="form-control" id="martial_status">
                                                                        <option>Please Select</option>
                                                                        <option>Divorced</option>
                                                                        <option>Single</option>
                                                                        <option>Married</option>
                                                                        <option>Widowed</option>
                                                                        <option>Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Health Status</label>
                                                                    <select class="form-control" id="health_status">
                                                                        <option>Please Select</option>
                                                                        <option>Physical Disability</option>
                                                                        <option>Hearing Disability</option>
                                                                        <option>Mental Disability</option>
                                                                        <option>Visually Impaired</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="location">Description</label>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="Description"
                                                                           placeholder="Description">
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


                    </div>
                </div>
            </div>
            <div class="account-settings-footer">

                <div class="as-footer-container float-right">

                    <button id="multiple-reset" class="btn btn-primary">Reset All</button>
                    <button id="multiple-messages" class="btn btn-dark">Save Changes</button>

                </div>

            </div>
        </div>

    </div>
</div>
<!--  END CONTENT AREA  -->

