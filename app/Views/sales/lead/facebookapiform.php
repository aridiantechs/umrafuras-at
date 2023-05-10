<?php


?>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Facebook Forms Data </h5>
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
<div>

</div>
<form class="validate" method="post" action="#" id="facebookapiform" name="facebookapiform">
    <div class="modal-body">


        <div class="row">
            <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Facebook Forms</th>
                    <th>Products</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>Kindom Valley</td>
                    <td>
                        <div class="form-group">
                            <select class="form-control validate[required]" id="Products" name="Products">
                                <option value="" selected disabled> Select Projects</option>
                                <?php foreach ($Products as $value) {
                                    if ($value == 'home' || $value == 'sales') {
                                    } else { ?>
                                        <option value="<?= $value ?>"> <?= ucwords($value) ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Blue world City </td>
                    <td>
                        <div class="form-group">
                            <select class="form-control validate[required]" id="Products" name="Products">
                                <option value="" selected disabled> Select Projects</option>
                                <?php foreach ($Products as $value) {
                                    if ($value == 'home' || $value == 'sales') {
                                    } else { ?>
                                        <option value="<?= $value ?>"> <?= ucwords($value) ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-12 " id="Status"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Close</button>
        <button type="button" class="btn btn-primary" onclick="">Submit</button>

    </div>
</form>

<script>


</script>