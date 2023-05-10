<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= (($record_id > 0) ? "Update " : "Add New ") ?> Operator</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button>
</div>
<div class="modal-body">
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">Full Name</label>
                    <input type="text" class="form-control" id="full_name" placeholder="Full Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="Type">Type</label>
                    <select class="form-control" id="title"
                            name="title">
                        <option>Please Select</option>
                        <option>CAB</option>
                    </select>
                </div>
            </div>
        </div>

    </form>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
    <button type="button" class="btn btn-primary">Save</button>
</div>