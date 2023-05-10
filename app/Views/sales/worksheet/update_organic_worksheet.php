<?php use App\Models\Crud; ?>


<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <form class="validate" method="post" name="WorkSheetUpdateForm" id="WorkSheetUpdateForm"
                  onsubmit="WorkSheetUpdateFormSubmit('WorkSheetUpdateForm'); return false;" style="width:100%">
                <input type="hidden" name="UID" id="UID" value="<?= $WorkSheetUID ?>">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <h4 class="page-head"> Update Organic Worksheet
                        <span>
                          <button type="button" class="btn btn-primary float-right"
                                  onclick="WorkSheetUpdateFormSubmit('WorkSheetUpdateForm');">Submit</button>
                    </span>
                    </h4>
                </div>
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div id="WorkSheetUpdateAjaxResponse"></div>
                </div>

                <?php $i = 0;
//                print_r($WorkSheetData);
//                exit;
                foreach ($OrganicLookups as $value) { ?>
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <?php if (count($OrganicLookups) > 0) { ?>
                            <h4>
                                <?php echo str_replace('Organic Platform', "", $value['Name']) ?></h4>
                            <?php
                            $Crud = new Crud();
                            $LookupsOptions = $Crud->LookupOptions($value['Key']);
                            if (count($LookupsOptions) > 0) {
                                foreach ($LookupsOptions as $newValue) {
                                    $i++;
                                    ?>
                                    <div id="toggleAccordion">
                                        <div class="card">
                                            <div class="card-header" id="...">
                                                <section class="mb-0 mt-0">
                                                    <div role="menu" class="collapsed" data-toggle="collapse"
                                                         data-target="#<?= $value['Key'] . '-' . $i ?>"
                                                         aria-expanded="true"
                                                         aria-controls="<?= $value['Key'] . '-' . $i ?>">
                                                        <?= $i ?>: <?= $newValue['Name'] ?>
                                                        <div class="icons">
                                                            <svg> ...</svg>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>

                                            <div id="<?= $value['Key'] . '-' . $i ?>" class="collapse"
                                                 aria-labelledby="..."
                                                 data-parent="#toggleAccordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mx-auto">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="country">Performed By</label>
                                                                        <select class="form-control validate[required]"
                                                                                id="performed-<?= $newValue['UID'] ?>"
                                                                                name="performed[<?= $newValue['UID'] ?>]">
                                                                            <option value="">Select....
                                                                            </option>
                                                                            <option <?=( ( isset($WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Performed']) && $WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Performed'] == 1 )? 'selected' : '' )?> value="1">Yes</option>
                                                                            <option <?=( ( isset($WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Performed']) && $WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Performed'] == 0 )? 'selected' : '' )?> value="0">No</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group">
                                                                        <label for="country">Remarks</label>
                                                                        <textarea style="height: 37px" type="text"
                                                                                  class="form-control"
                                                                                  id="remarks-<?= $newValue['UID'] ?>"
                                                                                  name="remarks[<?= $newValue['UID'] ?>]"
                                                                                  placeholder=" "><?=( ( isset($WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Remarks']) && $WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Remarks'] != '' )? $WorkSheetData['WorkSheetMeta'][$newValue['UID']]['Remarks'] : '' )?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                <?php }
                            } ?>
                        <?php } ?>


                    </div>

                <?php } ?>

            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    function WorkSheetUpdateFormSubmit(parent) {

        // var Date = $("form#WorkSheetUpdateForm input#date").val();
        // if (Date == '') {
        //     GridMessages('WorkSheetUpdateForm', 'WorkSheetUpdateAjaxResponse', 'alert-danger', 'Please Select Record Date', 2000);
        //     $("form#WorkSheetUpdateForm input#date").focus();
        //
        // } else {
        if (confirm("Do You Want To Update Work Sheet Data")) {


            var phpdata = $("form#" + parent).serialize();
            response = AjaxResponse("form_process/worksheet_form_submit", phpdata);
            if (response.status == 'success') {
                GridMessages('WorkSheetUpdateForm', 'WorkSheetUpdateAjaxResponse', 'success', response.message, 2000);
                setTimeout(function () {
                    location.href = "<?=$path?>lead/worksheet";
                }, 3000);
            } else {
                GridMessages('WorkSheetUpdateForm', 'WorkSheetUpdateAjaxResponse', 'warning', response.message, 2000);
            }
            // }
        }
    }

</script>