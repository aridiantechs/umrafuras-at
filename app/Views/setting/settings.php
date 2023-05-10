<?php
use App\Models\Crud;

$Crud = new Crud();
$domains = explode( " ", getSegment(3));
$domain = $domains[0];
?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                     data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <h4 class="page-head">Settings</h4>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form class="section contact" id="SettingForm" method="post" action="#"
                                  enctype="multipart/form-data"
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
                                                <div role="menu" class="collapsed" data-toggle="collapse"
                                                     data-target="#<?= $head ?>" aria-expanded="true"
                                                     aria-controls="<?= $head ?>">
                                                    <?= $head ?>
                                                </div>
                                            </section>
                                        </div>
                                        <div id="<?= $head ?>" class="collapse show" aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <?php
                                                            foreach ($records as $record) {

                                                                if ($record['Key'] == 'room_types') {
                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                             <select class="form-control validate[required]" id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']">
                                                                           <option value="">Please Select</option>';
                                                                                          $data['LookupsOptions'] = $Crud->LookupOptions('room_types');
                                                                                          foreach ($data['LookupsOptions'] as $options) {
                                                                                              $selected = (($record['Description'] == $options['UID']) ? 'selected' : '');
                                                                                              echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                                          }
                                                                             echo'</select>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                else if ($record['Key'] == 'transport_types') {
                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                             <select class="form-control validate[required]" id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']">
                                                                           <option value="">Please Select</option>';
                                                                                          $data['LookupsOptions'] = $Crud->LookupOptions('transport_types');
                                                                                          foreach ($data['LookupsOptions'] as $options) {
                                                                                              $selected = (($record['Description'] == $options['UID']) ? 'selected' : '');
                                                                                              echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                                          }
                                                                             echo'</select>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                else if ($record['Key'] == 'package_umrah_key' || $record['Key'] == 'child_umrah_rate' || $record['Key'] == 'infant_umrah_rate'
                                                                    || $record['Key'] == 'umrah_with_tranpsort_rate' || $record['Key'] == 'umrah_with_package_rate') {
                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                             <select class="form-control validate[required]" id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']">
                                                                           <option value="">Please Select</option>';
                                                                                          $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                                                                                          foreach ($data['LookupsOptions'] as $options) {
                                                                                              $selected = (($record['Description'] == $options['UID']) ? 'selected' : '');
                                                                                              echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                                                                          }
                                                                             echo'</select>
                                                                        </div>
                                                                    </div>';
                                                                }
                                                                else if ($record['Key'] == 'default_image') {
                                                                    $imgHTML = '';
                                                                    if ($record['Description'] != '') {
                                                                        $imgHTML = '<img src="' . $path . 'home/load_file/' . $record['Description'] . '" class="Image" width="100">';
                                                                    }
                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                            <input type="file" class="form-control mb-4"
                                                                                   id="' . $record['Key'] . '" name="SettingImage"
                                                                                   placeholder="' . $record['Name'] . '" value="">
                                                                             ' . $imgHTML . '      
                                                                        </div>
                                                                    </div>';
                                                                } else {
                                                                    echo '
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="' . $record['Key'] . '">' . $record['Name'] . '</label>
                                                                            <input type="text" class="form-control mb-4"
                                                                                   id="' . $record['Key'] . '" name="setting[' . $record['Key'] . ']"
                                                                                   placeholder="' . $record['Name'] . '" value="' . $record['Description'] . '">
                                                                        </div>
                                                                    </div>';
                                                                }
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <?php
                                    } ?>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" id="SettingFormResponse"></div>


                    </div>
                </div>
            </div>

            <div class="account-settings-footer">

                <div class="as-footer-container float-right">

                    <button id="multiple-reset" class="btn btn-primary">Reset All</button>
                    <button id="multiple-messages" class="btn btn-dark" onclick="SettingFormSubmit()">Save Changes
                    </button>

                </div>

            </div>
        </div>

    </div>
</div>
<!--  END CONTENT AREA  -->

<script type="application/javascript">

    function SettingFormSubmit() {

        var validate = $("form#SettingForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#SettingForm")[0]);
        response = AjaxUploadResponse("form_process/update_system_settings", phpdata);

        if (response.status == 'success') {
            $("#SettingFormResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                //location.href = "<?//=base_url('setting/settings')?>//";
            }, 2000)
        } else {
            $("#SettingFormResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }


</script>