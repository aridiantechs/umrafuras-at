<?php

use App\Models\Crud;
use App\Models\SaleAgent;

$Crud = new Crud();
$SaleAgents = new SaleAgent();
$head = 'Add New';
$update_id = 0;


$voucher_log= $records['voucher_log'];
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;
}
//print_r($voucher_log);
?>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Voucher Update History</h5>
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
<form enctype="multipart/form-data" class="validate" method="post" action="#" id="AgentAddForm" name="AgentAddForm">
    <div class="modal-body">



        <div class="row">

            <?php if ($update_id > 0) { ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Remarks</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (count($voucher_log) > 0) {
                            $cnt = 0;
                            foreach ($voucher_log as $voucher_history) {
                                $cnt++;
                                echo '
                                <tr>
                                    <td>' . $voucher_history['Remarks'] . '</td>
                                    <td>' . $voucher_history['FullName'] . '</td>
                                    <td>' . DATEFORMAT($voucher_history['CreatedDate']) . '</td>
                                  </tr>';
                            }
                        } else {
                            echo '<tr> <td colspan="2" style="text-align: center; color: #dda420">No Record Found</td></tr>';
                        } ?>

                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>

    </div>
</form>
