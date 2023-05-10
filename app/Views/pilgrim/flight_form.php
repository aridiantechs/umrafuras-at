<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel"><?= (($record_id > 0) ? "Update " : "Add") ?> Flight Details</h5>
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
                    <label for="country">Airport</label>
                    <input type="text" class="form-control" id="Airport" name="Airport" aria-describedby="emailHelp1"
                           placeholder="Airport">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Flight No</label>
                    <input type="text" class="form-control" id="FlightNumber" name="FlightNumber" aria-describedby="emailHelp1"
                           placeholder="Flight Number">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Departure Date</label>
                    <input type="date" class="form-control" id="DepartureDate" name="DepartureDate" aria-describedby="emailHelp1"
                           placeholder="Departure Date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Departure Time</label>
                    <input type="time" class="form-control" id="DepartureTime" name="DepartureTime" aria-describedby="emailHelp1"
                           placeholder="Departure Time">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Arrival Date</label>
                    <input type="date" class="form-control" id="ArrivalDate" name="ArrivalDate" aria-describedby="emailHelp1"
                           placeholder="Arrival Date">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="country">Arrival Time</label>
                    <input type="time" class="form-control" id="ArrivalTime" name="ArrivalTime" aria-describedby="emailHelp1"
                           placeholder="Arrival Time">
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