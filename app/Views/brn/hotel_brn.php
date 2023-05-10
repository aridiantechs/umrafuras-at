<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Hotel BRN
                    <?php
                        if($CheckAccess['umrah_brn_management_hotel_brn_create_new_brn']){?>
                            <button type="button" class="btn btn_customized btn-sm float-right"
                                    onclick="LoadModal('brn/hotel_brn_main_form', 0,'modal-lg')">Create New BRN
                            </button>
                        <?php }?>
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form onsubmit="return false;" class="section contact" id="HotelBrnSearchFilters">
                    <input type="hidden" name="create_date_from" id="create_date_from" value="">
                    <input type="hidden" name="create_date_to" id="create_date_to" value="">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class=" " data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Hotel Name</label>
                                                        <input type="text" class="form-control" id="hotel_name" name="hotel_name" placeholder="Hotel Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">BRN</label>
                                                        <input type="text" class="form-control" id="brn_code" name="brn_code" placeholder="BRN">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Create Date</label>
                                                        <input onchange="GetCreateDate();" type="text"
                                                               class="form-control multidate"
                                                               name="create_date" id="create_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Expired</label>
                                                        <select name="expire_status" id="expire_status" class="form-control">
                                                            <option value="">Please Select</option>
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button id="btnsearch" type="button" class="btn btn-success">
                                                            Search
                                                        </button>
                                                        <button id="btnreset" type="button" class="btn btn-danger">Clear
                                                            Filter
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
                        <table id="HotelBrnRecord" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Operator</th>
                                <th>Country</th>
                                <th>Agent Name</th>
                                <th>Promo Code</th>
                                <th>Created Date</th>
                                <th>Purchased ID</th>
                                <th>BRN Code</th>
                                <th>City</th>
                                <th>Use Type</th>
                                <th>Hotel Name</th>
                                <th>Rooms</th>
                                <th>Beds</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th>Nights</th>
                                <th>Booking Date</th>
                                <th>Expire Date</th>
                                <th>Purchased By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php /*                            $cnt = 0;
                            foreach ($records as $record) {
                                $days = '';
                                $days = date_diff(date_create($record['GenerateDate']), date_create($record['ActiveDate']));
                                $days = $days->days;

                                $cnt++;
                                $actions = '
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference1">
                                    <a class="dropdown-item" href="#" onclick="LoadModal(\'brn/hotel_brn_main_form\', ' . $record['UID'] . ',\'modal-lg\')">Update</a>
                                    <a class="dropdown-item" href="#" onclick="DeleteBRN(' . $record['UID'] . ');">Delete</a>
                                </div>';

                                echo '
                                <tr>
                                    <td>' . $cnt . '</td>
                                     <td>' . $record['CompanyName'] . '</td>
                                        <td>' . $record['PromoCode'] . '</td>
                                    <td>' . UserNameByID($record['CreatedBy']) . '</td>
                                    <td>' . DATEFORMAT($record['CreatedDate']) . '</td>
                                    <td>' . $record['PurchaseID'] . '</td>                                      
                                    <td>' . $record['BRNCode'] . '</td>                                
                                    <td>' .CityName( $record['HotelCity']).'</td>                                
                                     <td>' . $record['HotelName'] . '</td>
                                     <td>' . $record['Rooms'] . '</td>
                                    <td>' . $record['Beds'] . '</td>                                   
                                    <td>' . DATEFORMAT($record['GenerateDate']) . '</td>
                                    <td>' . DATEFORMAT($record['ActiveDate']) . '</td>
                                    <td>'.$days.' Nights</td>
                                    <td>' . DATEFORMAT($record['BookingDate']) . '</td>                               
                                    <td>' . DATEFORMAT($record['ExpireDate']) . '</td>                               
                                    <td>' . UserNameByID($record['PurchasedBy']) . '</td>  
                               
                                    <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-dark btn-sm dropdown-toggle dropdown-toggle-split"
                                                    id="dropdownMenuReference1" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" data-reference="parent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-chevron-down">
                                                    <polyline points="6 9 12 15 18 9"></polyline>
                                                </svg>
                                            </button>
                                            ' . $actions . '
                                        </div>
                                    </td>
                                </tr>';
                            } */?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
    $(document).ready(function () {

        setTimeout(function (){
            $("#create_date_from").val('');
            $("#create_date_to").val('');
        }, 1000);

        var dataTable = $('#HotelBrnRecord').DataTable({
            "processing": true,
            "searching": false,
            "responsive": true,
            "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
            "pageLength": 100,
            "lengthChange": true,
            "info": true,
            "autoWidth": true,
            "serverSide": true,
            "order": [],
            "language": {
                "lengthMenu": "Show _MENU_ Hotel BRN",
                "info": "Showing _START_ to _END_ of _TOTAL_ Hotel BRN",
            },
            "ajax": {
                url: "<?= $path ?>brn/fetch_hotel_brn_record",
                type: "POST",
                data: function (data) {
                    data.hotel_name = $('#hotel_name').val();
                    data.brn_code = $('#brn_code').val();
                    data.create_date_from = $('#create_date_from').val();
                    data.create_date_to = $('#create_date_to').val();
                    data.expire_status = $('#expire_status').val();
                }
            },
            "columnDefs": [
                {
                    "defaultContent": "-",
                    "targets": "_all",
                    "orderable": false,
                },
            ],
            "fnCreatedRow" : function(nRow, aData, iDataIndex) {
                if(aData[17] == "<?=DATEFORMAT(date('Y-m-d', strtotime("+1 day")))?>"){
                    $(nRow).css('background', '#F8D7DA');
                }
                if(aData[17] < "<?=DATEFORMAT(date('Y-m-d'))?>"){
                    $(nRow).css('background', '#E2E3E5');
                }

            },
        });
        $("#btnsearch").click(function () {
            dataTable.ajax.reload();
        });
        $('#btnreset').click(function () { //button reset event click
            $('#HotelBrnSearchFilters')[0].reset();
            $("#create_date_from").val('');
            $("#create_date_to").val('');
            dataTable.ajax.reload();  //just reload table
        });
    });

    function GetCreateDate() {
        const Date = $("#create_date").val();
        const words = Date.split(' to ');
        $("#create_date_from").val(words[0]);
        $("#create_date_to").val(words[1]);
    }
</script>
<!--  END CONTENT AREA  -->
<script type="application/javascript">


    /*$('#MainRecords').DataTable({
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
    });*/


    function DeleteBRN(UID) {
        if (confirm("Are You Want To Remove BRN")) {
            response = AjaxResponse("form_process/remove_brn","UID=" + UID);
            if (response.status == 'success')
            {
                location.href = "<?=base_url('brn/hotel_brn')?>";
            }


        }
    }
</script>