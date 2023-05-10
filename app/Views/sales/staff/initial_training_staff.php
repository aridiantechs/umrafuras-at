        <?php

use App\Models\Crud;

$Crud = new Crud();
$session = session();
$session = $session->get();
$head = 'Add New ';
$update_id = 0;
if ($record_id > 0) {
    $head = 'Update ';
    $update_id = $record_id;


}
$TrainingData = $records['InitialTrainingData'];

?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Initial Training Staff</h5>
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
<form class="validate" method="post" action="#" name="InitialTrainingForm" id="InitialTrainingForm"
      onsubmit="TrainingFormSubmit('InitialTrainingForm'); return false;">

    <div class="modal-body pt-0">
        <input type="hidden" name="UID" id="UID" value="<?=$record_id?>">

        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive mb-4 mt-4">
                            <table id="#" class="table table-hover non-hover display nowrap"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Activity</th>
                                    <th>Perform</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $data['LookupsOptions'] = $Crud->LookupOptions('initial_training_checklist');
                                $cnt = 1;
                                foreach ($data['LookupsOptions'] as $options) {

                                    echo '<tr>
                                              <td>' . $cnt . '</td>
                                               <td style="font-size: 13px; font-weight: bold;">' . $options['Name'] . '</td>';
                                    echo '<td style="text-align: center">
                                     <select id="Performed"  name="Performed[' . $options['UID'] . ']"  class="form-control" data-style="py-0" tabindex="null">
                                                                    <option value="0">Select..</option>
                                                                    <option ' . ((isset($TrainingData['InitialTrainingData'][$options['UID']]['Performed']) && $TrainingData['InitialTrainingData'][$options['UID']]['Performed'] == 1) ? 'selected' : '') . ' value="1">Yes</option>
                                                                    <option ' . ((isset($TrainingData['InitialTrainingData'][$options['UID']]['Performed']) && $TrainingData['InitialTrainingData'][$options['UID']]['Performed'] == 0) ? 'selected' : '') . ' value="0">No</option>
                                                                  </select>
                                                            </td>';
                                    echo '<td> <textarea style="height: 40px;" class="form-control" id="Remarks" name="Remarks[' . $options['UID'] . ']" 
                                          placeholder="">' . ((isset($TrainingData['InitialTrainingData'][$options['UID']]['Remarks']) && $TrainingData['InitialTrainingData'][$options['UID']]['Remarks'] != '') ? $TrainingData['InitialTrainingData'][$options['UID']]['Remarks'] : '') . '</textarea> </td>';
                                    echo '</tr>';
                                    $cnt++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="" id="InitialTrainingAjaxResult"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Discard</button>
        <button type="button" class="btn btn-primary" onclick="TrainingFormSubmit('InitialTrainingForm')">
            Submit
        </button>
    </div>
</form>
<script>
    function TrainingFormSubmit(parent) {
        var validate = $("form#" + parent).validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('form_process/initial_training_form_submit', data);
        if (rslt.status == 'success') {
            GridMessages('InitialTrainingForm', 'InitialTrainingAjaxResult', 'alert alert-success', rslt.message, 2000);
            setTimeout(function () {
                // $('#InitialTrainingModal').modal('hide');
                location.reload();
            }, 3000);
        } else {
            GridMessages('InitialTrainingForm', 'InitialTrainingAjaxResult', 'alert alert-warning', rslt.message, 2000);
        }

    }
</script>