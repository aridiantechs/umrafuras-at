<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= (($record_id > 0) ? "Update " : "Add") ?> Hotel</h5>
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
<form class="validate" method="post" action="#" id="HotelAddForm" name="HotelAddForm">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Name</label>
                    <input type="text" class="form-control" id="Name" name="Name" aria-describedby="emailHelp1"
                           placeholder="Name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">City</label>
                    <input type="text" class="form-control" id="City" name="City" aria-describedby="emailHelp1"
                           placeholder="City">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Check-In</label>
                    <input type="date" class="form-control" id="CheckIn" name="CheckIn" aria-describedby="emailHelp1"
                           placeholder="Check In">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Check-Out</label>
                    <input type="date" class="form-control" id="CheckOut" name="CheckOut" aria-describedby="emailHelp1"
                           placeholder="Check Out">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Nights</label>
                    <input type="number" class="form-control" id="Nights" name="Nights" aria-describedby="emailHelp1"
                           placeholder="Nights" min="1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Room Type</label>
                    <select class="form-control validate[required]" id="RoomType"
                             name="RoomType">
                        <option value="">Please Select</option>
                        <option value="Sharing">Sharing</option>
                        <option value="Solo">Solo</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary">Save</button>
    </div>
    .
</form>