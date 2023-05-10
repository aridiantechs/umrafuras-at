<form enctype="multipart/form-data" class="validate MetaContentForm" method="post" action="#" id="MetaAboutUsForm" name="MetaAboutUsForm">
    <input type="hidden" name="Key" value="<?= $Slug ?>">
    <input type="hidden" name="DomainID" value="<?= $DomainID ?>">

    <div class="col-md-12 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">About Company</label>
                    <textarea class="form-control summernote" name="Meta[about-company]" id="about-company" rows="3"><?= $Contents['about-company'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">Mission</label>
                    <textarea class="form-control summernote" name="Meta[mission]" id="mission" rows="3"><?= $Contents['mission'] ?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">WORLDWIDE COVERAGE</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[worldwide-coverage]" id="ceo-message" rows="3"><?= $Contents['worldwide-coverage'] ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">COMPETITIVE PRICING</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[competitive-pricing]" id="competitive-pricing" rows="3"><?= $Contents['competitive-pricing'] ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group mb-4">
                    <label for="FullName">SECURE PAYMENT</label>
                    <textarea class="form-control limit" data-limit="270" name="Meta[secure-payment]" id="secure-payment" rows="3"><?= $Contents['secure-payment'] ?></textarea>
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