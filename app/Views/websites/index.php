<?php
$domains = explode( " ", getSegment(3));
$domain = $domains[0];
?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">
                    Manage: <?= ucwords($DomainData['FullName']) . " (" . $DomainData['Name'] . ")" ?>
                </h4>

            </div>

            <div class="col-xl-12 col-lg-12 col-md-12">

                <div class="row">
                    <div class="col-xl-12  col-md-12">

                        <div class="row mb-4 mt-3">
                            <div class="col-sm-1 col-12">
                                <?php echo view("websites/navigation"); ?>
                            </div>

                            <div class="col-sm-11 col-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                         aria-labelledby="v-pills-home-tab">
                                        <?php echo view("websites/pages", $pages); ?>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-settings" role="tabpanel"
                                         aria-labelledby="v-pills-settings-tab">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                                <form class="section contact" id="SettingForm" action=""
                                                      onsubmit="SettingFormSubmit(); return false;">
                                                    <input type="hidden" name="DomainID" value="<?= $DomainID ?>">
                                                    <div id="toggleAccordion"><?php
                                                        $settings = array();
                                                        foreach ($AllSettings as $record) {
                                                            $settings[$record['Segment']][] = $record;
                                                        }
                                                        foreach ($settings as $head => $records) { ?>
                                                            <div class="card">
                                                            <div class="card-header">
                                                                <section class="mb-0 mt-0">
                                                                    <div role="menu" class="collapsed"
                                                                         data-toggle="collapse"
                                                                         data-target="#<?= $head ?>"
                                                                         aria-expanded="true"
                                                                         aria-controls="<?= $head ?>">
                                                                        <?= $head ?>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            <div id="<?= $head ?>" class="collapse show"
                                                                 aria-labelledby=""
                                                                 data-parent="#toggleAccordion">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mx-auto">
                                                                            <div class="row">
                                                                                <?php
                                                                                foreach ($records as $record) {
                                                                                    if($record['Key'] == 'terms_and_conditions')
                                                                                    {
                                                                                        echo '
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                            <textarea class="form-control mb-4" id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']" placeholder="' . $record['Name'] . '">' . nl2br($record['Description']) . '</textarea>
                                                                        </div>
                                                                    </div>';
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                            <input type="text" class="form-control mb-4"
                                                                                   id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']"
                                                                                   placeholder="' . $record['Name'] . '" value="' . $record['Description'] . '">
                                                                        </div>
                                                                    </div>';
                                                                                } } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div><?php
                                                        } ?>
                                                    </div>
                                                </form>
                                                <div class="as-footer-container float-right">
                                                    <button id="multiple-reset" class="btn btn-primary">Reset All
                                                    </button>
                                                    <button id="multiple-messages" class="btn btn-dark"
                                                            onclick="SettingFormSubmit()">Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing"
                                                 id="SettingFormResponse"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<script type="application/javascript">
    function SettingFormSubmit() {
        var phpdata = $("form#SettingForm").serialize(); //alert( phpdata ); return false;
        response = AjaxResponse("form_process/update_website_settings", phpdata);
        if (response.status == 'success') {
            $("#SettingFormResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                 location.href = "<?=base_url('web_admin/index/'.$domain)?>";

            }, 2000)
        } else {
            $("#SettingFormResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }
</script>