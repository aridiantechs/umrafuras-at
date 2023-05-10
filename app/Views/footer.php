</div>
<!-- END MAIN CONTAINER -->

<!-- Modal -->
<div class="modal fade" id="MainForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<style>
    .loader1 {
        display: none;
        background-color: #000000;
        width: 100% !important;
        height: 100%;
        opacity: 0.7;
        padding: 21%;
        color: white;
    }

    .spinner-border {
        color: rgb(227, 160, 17);
        width: 100px;
        height: 100px;
    }
</style>

<div class="loader1 modal ">
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="spinner-border " role="status">
                <span class="sr-only">Loading...</span>

            </div>
        </div>
        <div class="col-sm-12 text-center mb-4">
            <h2>Please Wait!!!</h2>
            <h3>We are Working on Your Request</h3>
        </div>
    </div>
</div>


<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= $template ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= $template ?>assets/js/app.js"></script>

<script src="<?= $template ?>plugins/dropify/dropify.min.js"></script>
<script src="<?= $template ?>assets/js/users/account-settings.js"></script>
<script src="<?= $template ?>plugins/font-icons/feather/feather.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();
        DefaultScripts();
        TextareaLimit();
        feather.replace();
        PlzWait();

        if ($('.airports_ajax').length) {
            $('.airports_ajax').select2({
                minimumInputLength: 3,
                ajax: {
                    url: '<?= $path ?>selects/airports',
                    dataType: 'json',
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });
        }


        if ($('input.multidate').length) {
            $('input.multidate').daterangepicker({
                showDropdowns: true,
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: " to "
                }
            }, function (start, end, label) {
                //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        }

    });

    function UpdateUserTimeTrack(userid, track_type, stopid) {
        // alert("Code Start for Time Track (" + track_type + ") for User ID (" + userid + ")");
        PlzWait('show');
        setTimeout(function () {
            response = AjaxResponse("form_process/update_user_time_track", "stopid=" + stopid + "&userid=" + userid + "&track_type=" + track_type);
            if (response.status == 'success') {
                location.reload();
                // GridMessages('MatureLeadAttachmentsEditForm', 'LeadsAttachmentsEditAjaxResponse', 'alert-success', rslt.message, 2000);
            } else {
                // GridMessages('MatureLeadAttachmentsEditForm', 'LeadsAttachmentsEditAjaxResponse', 'alert-danger', rslt.message, 3000);
            }
        }, 1000);

    }

    function PlzWait(type) {
        if (type == 'show') $('.loader1').show();
        if (type == 'hide') $('.loader1').hide();
    }

    function DefaultScripts() {
        $("select:not(.no-select2):not(.dataTables_length select)").each(function () {
            var numberOfOptions = $('option', this).length;
            // if (numberOfOptions > 500) {
            //     $(this).select2({
            //         minimumInputLength: 3,
            //         tags: true,
            //     });
            // } else {
            //     $(this).select2({
            //         tags: true,
            //     });
            // }
        });
    }

    function TextareaLimit() {
        $('textarea.limit').on('keyup keypress blur change', function (e) {
            // alert("here");
            var tval = $(this).val(),
                tlength = tval.length,
                set = $(this).data("limit"),
                remain = parseInt(set - tlength);
            $(this).parent().find("small").remove();
            $(this).parent().append("<small>" + remain + " Characters remaining...</small>");
            if (remain <= 0) {
                $(this).val((tval).substring(0, set))
            }
        })
    }

    function ShiftLoginSession(id, type) {
        response = AjaxResponse("form_process/shift_login_session", "UID=" + id + "&type=" + type);
        if (response.status == 'success') {
            <?=(($page == 'login') ? 'location.href = "' . base_url() . '";' : 'location.reload();')?>;
        } else {
        }
    }

</script>

</body>
</html>