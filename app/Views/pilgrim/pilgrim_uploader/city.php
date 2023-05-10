<div class="card">
    <div class="card-header">
        <section class="mb-0 mt-0">
            <div role="menu" class="collapsed" data-toggle="collapse"
                 data-target="#FilterDetails" aria-expanded="false"
                 aria-controls="FilterDetails">
                Add Cover Image
            </div>
        </section>
    </div>
    <div class="card-body">
        <form enctype="multipart/form-data" method="post" action="#"
              id="CtyCoverAddForm" name="CtyCoverAddForm">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group pull-right">
                                <label for="Name">Country</label>
                                <select class="form-control validate[required]"
                                        id="Country"
                                        name="Country"
                                        onChange="LoadCitiesDropdown(this.value)">
                                    <option value="">Please Select</option>
                                    <?= Countries("html") ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group pull-right">
                                <label for="Name">Cities</label>
                                <select class="form-control" id="Cities" name="Cities">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group pull-right">
                                <label for="Name">Upload File</label>
                                <input type="file" class="form-control"
                                       id="UploadCoverFile"
                                       name="UploadCoverFile"
                                       placeholder="Upload Cover">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="" id="CitiesCoverAddResponse"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="submit float-right">
                                <button type="button" class="btn btn_customized"
                                        onclick="CityCoverFormSubmit('CtyCoverAddForm');">
                                    Upload
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<div class="table-responsive mb-4 mt-4 datatableparentdiv">
    <div id="CoverUpdateResponse"></div>
    <table id="MainRecords" class="table table-hover non-hover" style="width:100%">
        <thead>
        <tr>
            <th>#</th>
            <th>City</th>
            <th>Cover Image</th>
            <th>Action</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cnt = 0;
        if(isset($Cities))
            foreach ($Cities as $record) {
                if ($record['CoverImage'] > 0) {
                    $cnt++;
                    $actions = '<button class="btn btn_customized" onClick="ShowDiv(' . $cnt . ');">Update</button>';
                    ?>
                    <tr>
                        <td> <?= $cnt ?></td>
                        <td> <?= $record['Name'] ?></td>
                        <td>
                            <img src="<?= $path . 'home/load_file/' . $record['CoverImage'] ?>"
                                 class="Image" alt="City Cover Image" width="100"></td>
                        <td>
                            <div class="btn-group">
                                <?= $actions ?>
                            </div>
                        </td>
                        <td>
                            <div class="d-none" id="CoverUpload_<?= $cnt ?>">
                                <form enctype="multipart/form-data" method="post" action="#"
                                      id="CtyCoverUpdateForm" name="CtyCoverUpdateForm">
                                    <input type="hidden" id="Cities" name="Cities"
                                           value="<?= $record['UID'] ?>">
                                    <div class="row">
                                        <div class="form-group col-md-9">
                                            <label for="Name">Upload File</label>
                                            <input type="file" class="form-control"
                                                   id="UploadCover"
                                                   name="UploadCover"
                                                   placeholder="Upload Cover">
                                        </div>
                                        <div class="form-group col-md-3 mt-4">
                                            <label for="Name"></label>
                                            <button class="btn btn_customized"
                                                    onClick="CityCoverUpdateForm('CtyCoverUpdateForm');">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none"
                                                     stroke="currentColor" stroke-width="2"
                                                     stroke-linecap="round"
                                                     stroke-linejoin="round"
                                                     class="feather feather-activity">
                                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                    <polyline
                                                        points="17 21 17 13 7 13 7 21"></polyline>
                                                    <polyline
                                                        points="7 3 7 8 15 8"></polyline>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </td>
                    </tr>
                <?php }
            }
        ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">



    function ShowDiv(cnt) {
        $("div#CoverUpload_" + cnt).removeClass("d-none");
    }

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country);
        $("#Cities").html('<option value="">Please Select</option>' + cities.html);
    }
    function CityCoverUpdateForm(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/city_cover_update_form_submit', phpdata);

        if (response.status == 'success') {
            $("#CoverUpdateResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#CoverUpdateResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

        return false;

    }

    function CityCoverFormSubmit(parent) {

        var phpdata = new window.FormData($("form#" + parent)[0]);
        var response = AjaxUploadResponse('form_process/city_cover_form_submit', phpdata);

        if (response.status == 'success') {
            $("#CitiesCoverAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.reload();
            }, 2000)
        } else {
            $("#CitiesCoverAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }

        return false;

    }
</script>