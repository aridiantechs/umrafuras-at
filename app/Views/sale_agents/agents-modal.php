<style>
    .table th, td{
        padding: .30rem !important;
    }
</style>
<div class="modal fade" id="SaleAgentsReferAgentsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="min-width: 85% !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
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
            <div class="modal-body" style="padding: 15px 15px !important;">
                <div class="row">
                    <div class="col-md-12">
                        <table style="margin-bottom: 0rem !important;" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agent Ref.ID</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Contact No</th>
                                </tr>
                            </thead>
                            <tbody id="SaleAgentReferAgentsTBodyHtml"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            </div>
        </div>
    </div>
</div>
<script>
    function LoadSaleAgentReferAgentsModal(UID, FullName) {

        LoadSaleAgentReferAgentsHtml( UID );
        $("#SaleAgentsReferAgentsModal h5.modal-title").html(FullName);
        $("#SaleAgentsReferAgentsModal").modal({
            show: true,
            backdrop: "static"
        });
    }

    function LoadSaleAgentReferAgentsHtml(UID){

        var html = '';
        var rslt = AjaxResponse('Sale_agents/load_sale_agent_refer_agents', "UID=" + UID);
        if(rslt != '' && rslt != null){

            var cnt = 1;
            for(var i=0; i<rslt.length; i++){

                html += '<tr>\
                            <td><b>'+cnt+'</b></td>\
                            <td>'+rslt[i].RefCode+'</td>\
                            <td>'+rslt[i].Country+'</td>\
                            <td>'+rslt[i].City+'</td>\
                            <td>'+rslt[i].FullName+'</td>\
                            <td>'+rslt[i].ContactPersonName+'</td>\
                            <td>'+rslt[i].PhoneNumber+'</td>\
                        <tr>';
                cnt++;
            }
        }else{

            html += '<tr><td colspan="7"><div class="alert alert-danger font-weight-bold text-center">No Agents Record Found</div></td></tr>';
        }

        $("#SaleAgentsReferAgentsModal tbody#SaleAgentReferAgentsTBodyHtml").html( html );
    }
</script>