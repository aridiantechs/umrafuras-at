<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">WhatsApp Grabber</h4>
            </div>


            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <form class="section contact"
                      onsubmit="WhatsAppDataGrabberFormSubmit('WhatsAppDataGrabberForm'); return false;"
                      id="WhatsAppDataGrabberForm" name="WhatsAppDataGrabberForm">
                    <div class="card">
                        <div class="card-header">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="" data-toggle="collapse"
                                     data-target="#FilterDetails" aria-expanded="false"
                                     aria-controls="FilterDetails">
                                    HTML Code
                                </div>
                            </section>
                        </div>
                        <div id="FilterDetails" class="collapse show" aria-labelledby=""
                             data-parent="#toggleAccordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mx-auto">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="exampleFormControlTextarea1"
                                                       class="form-label">WhatsApp</label>
                                                <textarea class="form-control" id="WhatsAppField"
                                                          name="WhatsAppField"
                                                          rows="5"></textarea>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="" id="Status"></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <button id="multiple-messages" type="button"
                                                            class="btn btn_customized float-right ml-2 mt-3"
                                                            onclick="WhatsAppDataGrabberFormSubmit('WhatsAppDataGrabberForm');">
                                                        Proceed
                                                    </button>

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
                <div id="">
                    <div class="card">
                        <div class="card-header">
                            <section class="mb-0 mt-0">
                                <div role="menu" class="" data-toggle="collapse"
                                     data-target="#FilterDetails" aria-expanded="false"
                                     aria-controls="FilterDetails">
                                    HTML Code
                                </div>
                            </section>
                        </div>
                        <div id="FilterDetails" class="collapse show" aria-labelledby=""
                             data-parent="#toggleAccordion">
                            <div class="card-body">
                                <div class="row" id="GrabberHTML">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<script type="application/javascript">

    function WhatsAppDataGrabberFormSubmit(parent) {

        var data = $("form#" + parent).serialize();
        AjaxRequest('lead/testdata', data, 'GrabberHTML')
    }


</script>