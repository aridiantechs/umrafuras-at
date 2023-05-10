<form enctype="multipart/form-data" class="validate MetaContentForm" method="post" action="#" id="MetaAboutUsForm" name="MetaAboutUsForm">
    <input type="hidden" name="Key" value="<?= $Slug ?>">
    <input type="hidden" name="DomainID" value="<?= $DomainID ?>">

    <div class="col-md-12 mx-auto">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">CEO Message</label>
                    <textarea class="form-control limit" data-limit="550" name="Meta[ceo-message]" id="ceo-message" rows="3"><?= $Contents['ceo-message'] ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">OUR VISION</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[our-vision]" id="our-vision" rows="3"><?= $Contents['our-vision'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">OUR PURPOSE</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[our-purpose]" id="our-purpose" rows="3"><?= $Contents['our-purpose'] ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">5 YEARS OF SUCCESS</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[5-years-of-success]" id="5-years-of-success" rows="3"><?= $Contents['5-years-of-success'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">A NEW BEGINNING</label>
                    <textarea class="form-control summernote" name="Meta[a-new-beginning]" id="a-new-beginning" rows="3"><?= $Contents['a-new-beginning'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">IMAGINE WHERE TRAVEL COULD TAKE US</label>
                    <textarea class="form-control limit" data-limit="300" name="Meta[imagine-where-travel-could-take-us]" id="imagine-where-travel-could-take-us" rows="3"><?= $Contents['imagine-where-travel-could-take-us'] ?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mb-4">
                    <label for="FullName">THE POWER OF TRAVEL</label>
                    <textarea class="form-control limit" data-limit="300" name="Meta[the-power-of-travel]" id="the-power-of-travel" rows="3"><?= $Contents['the-power-of-travel'] ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="" id="MetaContentResponse"></div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
        <button type="button" class="btn btn-primary" onclick="MetaContentFormSubmit();">Save</button>
    </div>
</form>