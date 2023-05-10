

<div class="modal fade" id="QueryBoxModel"    data-backdrop="static" data-keyboard="false"  tabindex="-1" role="dialog"
     aria-labelledby="QueryBoxModel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">


        <div id="queryModel" class="modal-content">
            <div class="modal-body">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                     viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-x close"
                     data-dismiss="modal">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <div class="notes-box">
                    <div class="notes-content">
                        <form action="javascript:void(0);" id="QueryBoxform">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="name" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="email" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Contact No</label>
                                <div class="col-sm-9">
                                    <input type="text" readonly class="form-control-plaintext" id="contact" value="">
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-md-12">
                                    <label style="margin-top: 15px;">Subject</label>
                                    <div class="d-flex note-description " style="padding-top: 5px;">
                                                                     <textarea id="subject" class="form-control"
                                                                                placeholder="Description"
                                                                               rows="5" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label style="margin-top: 15px;">Query</label>
                                    <div class="d-flex note-description" style="padding-top: 5px;">
                                                                     <textarea id="query" class="form-control"
                                                                                placeholder="Description"
                                                                               rows="5" readonly></textarea>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>