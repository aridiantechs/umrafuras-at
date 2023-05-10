<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= (($record_id > 0) ? "Update " : "Add New ") ?></h5>
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
        <div class="form-group mb-3">
            <input type="email" class="form-control" id="sEmail" aria-describedby="emailHelp1"
                   placeholder="Email address">
            <small id="emailHelp1" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group mb-4">
            <input type="password" class="form-control" id="sPassword" placeholder="Password">
        </div>
        <div class="form-group form-check pl-0">
            <div class="custom-control custom-checkbox checkbox-info">
                <input type="checkbox" class="custom-control-input" id="sChkbox">
                <label class="custom-control-label" for="sChkbox">Subscribe to weekly newsletter</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
    <button type="button" class="btn btn-primary">Save</button>
</div>