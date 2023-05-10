<link href="<?= $template ?>summernote/summernote-lite.min.css" rel="stylesheet">
<script src="<?= $template ?>summernote/summernote-lite.min.js"></script>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll"
                     data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <h4 class="page-head"><?= (isset($ziyarats_data['UID']) ? 'Update' : 'Add New') ?>
                                Ziyarat</h4>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form enctype="multipart/form-data" class="section contact validate" method="post"
                                  action="#" id="ZiyaratAddForm"
                                  name="ZiyaratAddForm">
                                <input type="hidden" name="UID" id="UID"
                                       value="<?= (isset($ziyarats_data['UID']) ? '' . $ziyarats_data['UID'] . '' : '0') ?>">
                                <input type="hidden" name="DomainID" id="DomainID" value="<?= $GetDomainID ?>">

                                <div id="toggleAccordion">
                                    <div class="card">
                                        <div class="card-header">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="" data-toggle="collapse"
                                                     data-target="#SeoDetail" aria-expanded="true"
                                                     aria-controls="SeoDetail">
                                                    SEO Details
                                                </div>
                                            </section>
                                        </div>
                                        <div id="SeoDetail" class="collapse  show" aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="SEOTitle">Title</label>
                                                                    <input type="text"
                                                                           class="form-control mb-4 validate[required]"
                                                                           id="SEOTitle" name="SEOTitle"
                                                                           value="<?= $ziyarats_meta_data['SEOTitle'] ?>"
                                                                           placeholder="Title">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="Keywords">Keywords</label><small
                                                                            class="float-right" id="coloredtext"> (Add
                                                                        more with comma "," seprator)</small>
                                                                    <input type="text" class="form-control mb-4"
                                                                           id="SEOKeywords" name="SEOKeywords"
                                                                           value="<?= $ziyarats_meta_data['SEOKeywords'] ?>"
                                                                           placeholder="Keywords">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="country">Description</label><small
                                                                            class="float-right" id="coloredtext">(Not
                                                                        More Than 200 Characters)</small>
                                                                    <input type="text"
                                                                           class="form-control mb-4"
                                                                           value="<?= $ziyarats_meta_data['SEODescription'] ?>"
                                                                           id="SEODescription" name="SEODescription"
                                                                           placeholder="Description" maxlength="200">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="" data-toggle="collapse"
                                                     data-target="#BasicDetail" aria-expanded="true"
                                                     aria-controls="#BasicDetail">
                                                    Basic Details
                                                </div>
                                            </section>
                                        </div>
                                        <div id="BasicDetail" class="collapse" aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-4">
                                                                    <label for="FullName">Name</label>
                                                                    <input type="text" class="form-control" id="Name"
                                                                           name="Name" placeholder="Name"
                                                                           value="<?= $ziyarats_data['Name'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-4">
                                                                    <label for="country">Country</label>
                                                                    <select class="form-control validate[required]"
                                                                            id="Country"
                                                                            name="Country"
                                                                            onChange="LoadCitiesDropdown(this.value)">
                                                                        <option value="">Please Select</option>
                                                                        <?= Countries('html', $ziyarats_data['CountryID']) ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-4">
                                                                    <label for="Type">Cities</label>
                                                                    <select class="form-control validate[required]"
                                                                            id="City"
                                                                            name="City">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mb-4">
                                                                    <label for="FullName">Cover Image</label>
                                                                    <input type="file" class="form-control"
                                                                           id="CoverImage"
                                                                           name="CoverImage" placeholder="CoverImage">
                                                                </div>
                                                                <div class="image <?= (isset($ziyarats_data['UID']) ? '' : 'd-none') ?>">
                                                                    <?php
                                                                    if (isset($ziyarats_data['CoverImage'])) {
                                                                        echo '<img src="' . $path . 'home/load_file/' . $ziyarats_data['CoverImage'] . '"
                                                                         class="Image float-right" alt=""
                                                                         width="150px;">';
                                                                    }
                                                                    ?>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-4">
                                                                    <label for="FullName">Description</label>
                                                                    <textarea id="Description"
                                                                              name="Description"><?= $ziyarats_data['Description'] ?></textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <section class="mb-0 mt-0">
                                                <div role="menu" class="" data-toggle="collapse"
                                                     data-target="#Location" aria-expanded="true"
                                                     aria-controls="#Location">
                                                    Location
                                                </div>
                                            </section>
                                        </div>
                                        <div id="Location" class="collapse" aria-labelledby=""
                                             data-parent="#toggleAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="row">
                                                            <div class="col-md-5">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="SEOTitle">Latitude</label>
                                                                            <input type="text" class="form-control mb-4 validate[required]"
                                                                                   id="Latitude" name="Latitude"
                                                                                   value="<?= $ziyarats_meta_data['Latitude'] ?>"
                                                                                   placeholder="Latitude">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="Keywords">Longitude</label>
                                                                            <input type="text" class="form-control mb-4 validate[required]"
                                                                                   id="Longitude" name="Longitude"
                                                                                   value="<?= $ziyarats_meta_data['Longitude'] ?>"
                                                                                   placeholder="Longitude">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div class="form-group mb-4">
                                                                    <label for="FullName">Google MAP<small> (Kindly add
                                                                            iframe of ziyarat)</small></label>
                                                                    <textarea type="text" class="form-control"
                                                                              id="GoogleMAP" name="GoogleMAP"
                                                                              placeholder="Google MAP" rows="3"
                                                                              style="height: 145px;"><?= $ziyarats_meta_data['GoogleMAP'] ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-4">
                                                                    <label for="FullName">Near By Places</label>
                                                                    <textarea id="NearPlaces"
                                                                              name="NearPlaces"><?= $ziyarats_data['NearPlaces'] ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <section class="mb-0 mt-0">
                                            <div role="menu" class="" data-toggle="collapse"
                                                 data-target="#Gallery" aria-expanded="true"
                                                 aria-controls="#Gallery">
                                                Gallery
                                            </div>
                                        </section>
                                    </div>
                                    <div id="Gallery" class="collapse" aria-labelledby=""
                                         data-parent="#toggleAccordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mx-auto">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-4">
                                                                <label for="FullName">Multiple Images</label>
                                                                <input type="file"
                                                                       class="form-control validate[required]"
                                                                       id="MultipleImages" name="MultipleImages[]"
                                                                       placeholder="Multiple Images" multiple>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12  <?= (isset($ziyarats_data['UID']) ? '' : 'd-none') ?>">
                                                            <?php
                                                            if (isset($ziyarats_meta_data['GalleryImages'])) {
                                                                foreach ($ziyarats_meta_data['GalleryImages'] as $val) {
                                                                    echo '<div class="grid-img" style="background-image: url(\'' . $path . "home/load_file/" . $val . '\');">
                                                                          <a href="javascript:void(0)" onclick="DeleteZiyaratImage(' . $val . ');" ><i class="fas fa-window-close"></i></a></div>';
                                                                }
                                                            }
                                                            ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="" id="ZiaratAddResponse"></div>
        </div>
        <div class="account-settings-footer">
            <div class="as-footer-container float-right">
                <button onclick="ZiaratFormSubmit()" class="btn btn_customized">Save Changes</button>
            </div>
        </div>
    </div>

</div>
</div>
<script type="application/javascript">

    $(document).ready(function () {
        $('#Description,#NearPlaces').summernote(
            {
                height: 250,
                minHeight: null,
                maxHeight: null,
                focus: true
            }
        );
    });


    $("form#ZiyaratAddForm").on("submit", function (event) {
        event.preventDefault();
    });

    function LoadCitiesDropdown(country) {
        cities = AjaxResponse("html/GetCitiesDropdownByCountryCode", "country=" + country + "&selected=<?=$ziyarats_data['CityID']?>");
        $("#City").html('<option value="">Please Select</option>' + cities.html);
    }

    function ZiaratFormSubmit() {
        var validate = $("form#ZiyaratAddForm").validationEngine('validate');
        if (validate == false) {
            return false;
        }
        var phpdata = new window.FormData($("form#ZiyaratAddForm")[0]);
        response = AjaxUploadResponse("form_process/ziyarat_form_submit", phpdata);

        if (response.status == 'success') {
            $("#ZiaratAddResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            setTimeout(function () {
                location.href = "<?=base_url('package/ziyarat')?>";
            }, 2000)
        } else {
            $("#ZiaratAddResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }

    function DeleteZiyaratImage(UID) {
        if (confirm("Are You Want To Remove Image")) {
            response = AjaxResponse("form_process/remove_ziyarat_image", "UID=" + UID);
            if (response.status == 'success') {
                location.reload();
            }
        }
    }

    setTimeout(function () {
        LoadCitiesDropdown('<?=$ziyarats_data['CountryID']?>');
    }, 1000)

</script>
