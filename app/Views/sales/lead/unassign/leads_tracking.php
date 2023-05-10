<style>
    .table th, td {
        padding: .25rem !important;
    }

    .table th {
        font-size: 10px !important;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Leads Tracking</h5>
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
<div class="modal-body pt-0">
    <div class="layout-px-spacing">
        <form class="validate" method="post" name="LeadsTrackingForm" id="LeadsTrackingForm"
              onsubmit="SearchContactNoLeadsTracking('LeadsTrackingForm'); return false;">
            <div class="row mt-3">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Keyword <small>(Name, Email Contact, Product)</small></label>
                        <input type="text" class="form-control" id="track_keyword" name="track_keyword"
                               placeholder="keyword">
                    </div>
                </div>
                <div class="col-md-3" style="margin-top: 1.9rem !important;">
                    <button type="button" id="LeadsTrackingSearchButton"
                            onclick="SearchContactNoLeadsTracking('LeadsTrackingForm');"
                            class="btn btn-success btn-sm">Search
                    </button>
                    <button type="button" onclick="ClearLeadsTrackingSearchData();" class="btn btn-danger btn-sm">
                        Clear
                    </button>
                </div>
                <div style="margin-top: 5px !important;" class="col-md-12" id="LeadsTrackingAjaxResponse"></div>
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="table-responsive">
                        <table style="margin-bottom: 0px !important;" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.ID</th>
                                <th>Created At</th>
                                <th>Distribution DateTime</th>
                                <th>Product</th>
                                <th>Agent</th>
                                <th>Full Name</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Activity Date</th>
                            </tr>
                            </thead>
                            <tbody id="LeadTrackingTableBody">
                            <tr>
                                <td colspan="10">
                                    <div style="text-align: center; font-weight: 600; margin-top: 20px;"
                                         class="alert alert-danger "><p style="color: #DC3545;">Search Contact To
                                            Track Leads...!</p>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
</div>

<script>
    function SearchContactNoLeadsTracking(parent) {

        var Keyword = $("form#LeadsTrackingForm input#track_keyword").val();
        if (Keyword == '') {

            GridMessages('LeadsTrackingForm', 'LeadsTrackingAjaxResponse', 'red', "Please Correctly Search Keyword", 3000);
            $("form#LeadsTrackingForm input#track_keyword").val('');

        } else {

            $("#LeadsTrackingSearchButton").html("Wait...");
            $("#LeadsTrackingSearchButton").removeClass("btn-success");
            $("#LeadsTrackingSearchButton").addClass("btn-danger btn-sm");
            $("#LeadsTrackingSearchButton").attr("disabled", true);

            var html = '';
            var rslt = AjaxResponse('lead/leads_tracking_data_by_contact_no', "Keyword=" + Keyword);
            if (rslt != '' && rslt != null) {

                var cnt = 1;
                for (var i = 0; i < rslt.length; i++) {

                    html += '<tr>\
                                <td>' + cnt + '</td>\
                                <td>' + rslt[i].RefID + '</td>\
                                <td>' + rslt[i].CreatedAt + '</td>\
                                <td>' + rslt[i].LeadAssignmentDate + '</td>\
                                <td><badge class="badge badge-success">' + rslt[i].ProjectName + '</badge></td>\
                                <td>' + rslt[i].Agent + '</td>\
                                <td>' + rslt[i].FullName + '</td>\
                                <td>' + rslt[i].ContactNo + '</td>\
                                <td><badge class="badge badge-success">' + rslt[i].Status + '</badge></td>\
                                <td>' + rslt[i].LastActivityDate + '</td>\
                            </tr>';

                    cnt = cnt + 1;
                }
                $("form#LeadsTrackingForm table tbody#LeadTrackingTableBody").html(html);

                $("#LeadsTrackingSearchButton").html("Search");
                $("#LeadsTrackingSearchButton").removeClass("btn-danger");
                $("#LeadsTrackingSearchButton").addClass("btn-success btn-sm");
                $("#LeadsTrackingSearchButton").attr("disabled", false);

            } else {

                $("#LeadsTrackingSearchButton").html("Search");
                $("#LeadsTrackingSearchButton").removeClass("btn-danger");
                $("#LeadsTrackingSearchButton").addClass("btn-success btn-sm");
                $("#LeadsTrackingSearchButton").attr("disabled", false);

                var html = '<tr>\
                                <td colspan="10">\
                                    <div style="text-align: center; font-weight: 600; margin-top: 20px;"\
                                        class="alert alert-danger"><p>No Record Found...!</p>\
                                    </div>\
                                </td>\
                            </tr>';
                $("form#LeadsTrackingForm table tbody#LeadTrackingTableBody").html(html);
            }
        }
    }

    function ClearLeadsTrackingSearchData() {

        var html = '<tr>\
                        <td colspan="11">\
                            <div style="text-align: center; font-weight: 600; margin-top: 20px;"\
                                class="alert alert-danger"><p style="color: #DC3545;">Search Contact No to Track Leads...!</p>\
                            </div>\
                        </td>\
                    </tr>';

        $("form#LeadsTrackingForm table tbody#LeadTrackingTableBody").html(html);
        $("form#LeadsTrackingForm input#track_keyword").val('');
        $("form#LeadsTrackingForm label.track_keyword").removeClass('active');

    }
</script>