<?php

use App\Models\Pilgrims;
use App\Models\Crud;

$Crud = new Crud();
?>

<section id="VisaUploader">
    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
        <div id="CoverUpdateResponse"></div>
        <table id="MainRecords" class="table table-hover non-hover" style="width:100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Pilgrim ID</th>
                <th>Pilgrim Name</th>
                <th>Passport Number</th>
                <th>Visa Number</th>
                <th>Type</th>
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Mofa Number</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $cnt = 0;
            if (isset($Pilgrims))
                foreach ($Pilgrims as $Pilgrim) {
                    $cnt++;
                    $actions = '<button class="btn btn_customized" onClick="VisaDetailFormSubmit(' . $Pilgrim['UID'] . '); return false" type="submit">Add</button>';
                    ?>
                    <tr id="ROW_<?=$Pilgrim['UID']?>">

                        <td><?= $cnt ?></td>
                        <td><?= Code('UF/P/', $Pilgrim['UID']) ?> </td>
                        <td><?= $Pilgrim['FirstName'] ?> </td>
                        <td><?= $Pilgrim['PassportNumber'] ?> </td>
                        <td><input type="text" class="form-control" id="VisaNumber_<?= $Pilgrim['UID'] ?>"
                                   placeholder="Visa #"></td>
                        <td>
                            <select class="form-control no-select2" id="Type_<?= $Pilgrim['UID'] ?>">
                                <option value="">Please Select</option>
                                <?php
                                $data['LookupsOptions'] = $Crud->LookupOptions('visa_types');
                                foreach ($data['LookupsOptions'] as $options) {
                                    $selected = (($PilgrimVisa['Type'] == $options['UID']) ? 'selected' : '');
                                    echo '<option value="' . $options['UID'] . '"' . $selected . '>' . $options['Name'] . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td><input type="date" class="form-control" id="IssueDate_<?= $Pilgrim['UID'] ?>"></td>
                        <td><input type="date" class="form-control" id="ExpiryDate_<?= $Pilgrim['UID'] ?>"></td>
                        <td><input type="text" class="form-control" id="MofaNumber_<?= $Pilgrim['UID'] ?>"
                                   placeholder="MOFA #"></td>
                        <td>
                            <div class="btn-group">
                                <?= $actions ?>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>
<script type="text/javascript">
    function VisaDetailFormSubmit(pilgrimid) {
        visanumber = $("section#VisaUploader #VisaNumber_" + pilgrimid).val();
        visatype = $("section#VisaUploader #Type_" + pilgrimid).val();
        visaissue = $("section#VisaUploader #IssueDate_" + pilgrimid).val();
        visaexpiry = $("section#VisaUploader #ExpiryDate_" + pilgrimid).val();
        visamofanumber = $("section#VisaUploader #MofaNumber_" + pilgrimid).val();

        var phpdata = "pilgrimid="+pilgrimid+"&visanumber="+visanumber+"&visatype="+visatype+"&visaissue="+visaissue+"&visaexpiry="+visaexpiry+"&visamofanumber="+visamofanumber;
        response = AjaxResponse("form_process/multi_visa_details_form_submit", phpdata);

        if (response.status == 'success') {
            setTimeout(function () {
                $("section#VisaUploader tr#ROW_" + pilgrimid).remove();
                //location.href = "";
            }, 1000)
        }
    }


</script>