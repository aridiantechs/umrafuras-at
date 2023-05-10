/*
=========================================
|                                       |
|           Scroll To Top               |
|                                       |
=========================================
*/
$('.scrollTop').click(function () {
    $("html, body").animate({scrollTop: 0});
});


$('.navbar .dropdown.notification-dropdown > .dropdown-menu, .navbar .dropdown.message-dropdown > .dropdown-menu ').click(function (e) {
    e.stopPropagation();
});

/*
=========================================
|                                       |
|       Multi-Check checkbox            |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });
}


/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

/*
    This MultiCheck Function is recommanded for datatable
*/

function multiCheck(tb_var) {
    tb_var.on("change", ".chk-parent", function () {
        var e = $(this).closest("table").find("td:first-child .child-chk"), a = $(this).is(":checked");
        $(e).each(function () {
            a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        })
    }),
        tb_var.on("change", "tbody tr .new-control", function () {
            $(this).parents("tr").toggleClass("active")
        })
}

/*
=========================================
|                                       |
|           MultiCheck                  |
|                                       |
=========================================
*/

function checkall(clickchk, relChkbox) {

    var checker = $('#' + clickchk);
    var multichk = $('.' + relChkbox);


    checker.click(function () {
        multichk.prop('checked', $(this).prop('checked'));
    });
}

/*
=========================================
|                                       |
|               Tooltips                |
|                                       |
=========================================
*/

$('.bs-tooltip').tooltip();

/*
=========================================
|                                       |
|               Popovers                |
|                                       |
=========================================
*/

$('.bs-popover').popover();


/*
================================================
|                                              |
|               Rounded Tooltip                |
|                                              |
================================================
*/

$('.t-dot').tooltip({
    template: '<div class="tooltip status rounded-tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
})


/*
================================================
|            IE VERSION Dector                 |
================================================
*/

function GetIEVersion() {
    var sAgent = window.navigator.userAgent;
    var Idx = sAgent.indexOf("MSIE");

    // If IE, return version number.
    if (Idx > 0)
        return parseInt(sAgent.substring(Idx + 5, sAgent.indexOf(".", Idx)));

    // If IE 11 then look for Updated user agent string.
    else if (!!navigator.userAgent.match(/Trident\/7\./))
        return 11;

    else
        return 0; //It is not IE
}


function AjaxUploadResponse(phpurl, phpdata) {

    path = localStorage.getItem("path");
    var return_val = '';
    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        async: false,
        url: path + phpurl,
        beforeSend: function () {
        },
        dataType: 'json',
        data: phpdata,
        success: function (data) {
            return_val = data;
        },
        error: function (xhr, status, text) {
            console.log('Failure! ' + text);
        }
    });

    return return_val;
}


function AjaxRequest(phpurl, phpdata, divid) {
    $('.loader1').toggle();
    path = localStorage.getItem("path");
    //alert(phpurl+phpdata);
    $.ajax({
        cache: false,
        type: "POST",
        url: path + phpurl,
        beforeSend: function () {
            $("#" + divid).html('<div class="spinner-grow text-warning align-self-center" style="width: 50px;height: 50px;margin: 50px;"></div>');
            $("#" + divid).fadeIn('fast');
        },
        dataType: "html",
        data: phpdata,
        success: function (data) {
            $("#" + divid).html(data);
            $("#" + divid).fadeIn('slow');
            $('.loader1').toggle();
        },
        error: function (xhr, status, text) {
            console.log('Failure! ' + text);
        }
    });
    return true;
}

function AjaxResponse(phpurl, phpdata) {
    path = localStorage.getItem("path");
    var return_val = '';
    $.ajax({
        cache: false,
        type: "POST",
        async: false,
        url: path + phpurl,
        beforeSend: function () {
            console.log('beforeSend! ' + phpurl + "?" + phpdata);
        },
        dataType: "json",
        data: phpdata,
        success: function (data) {
            return_val = data;
        },
        error: function (xhr, status, text) {
            console.log('Failure! ' + phpurl + "?" + phpdata);
        }
    });
    return return_val;
}

function ClearForm(modalid) {
    $("#" + modalid + " form input").val('');
    $("#" + modalid + " form select").val('');
    $("#" + modalid + " form textarea").html('');
}

function LoadModal(url, uid, sizeclass = '', divid = '') {
    divid = "MainForm" + divid;
    if ($("#" + divid).length < 1) {
        $('body').append('' +
            '<div class="modal fade" id="' + divid + '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"\n' +
            '     aria-hidden="true">\n' +
            '    <div class="modal-dialog" role="document">\n' +
            '        <div class="modal-content"></div>\n' +
            '    </div>\n' +
            '</div>');
    }

    if (sizeclass != '') {
        $("#" + divid + " .modal-dialog").addClass(sizeclass)
    }
    AjaxRequest('html/load_modal', 'url=' + url + '&record_id=' + uid, divid + " .modal-content");
    $("#" + divid).modal({
        show: true,
        backdrop: "static"
    });
}

function UpdateFilters(parent) {
    var data = $("form#" + parent).serialize();
    var rslt = AjaxResponse('form_process/update_filters', 'session_name=' + parent + '&' + data);
    if (rslt.status == 'success') {
        location.reload();
    }
}

function ClearFilters(SessionName) {

    var rslt = AjaxResponse("form_process/clear_filters", 'session_name=' + SessionName);
    if (rslt.status == 'success') {
        location.reload();
    }

}

function GridMessages(FormId, divId, cssClass, msg, timeOut) {

    var html = '<div class="alert ' + cssClass + ' " role="alert">\
                    <div style="text-align: center; color: ' + ( ( cssClass == 'alert-danger' )? 'red' : 'black' ) + '" class="iq-alert-text">\
                        <p class="text-center"><strong>' + msg + ' ...!</strong></p>\
                    </div>\
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                           <i class="ri-close-line"></i>\
                           </button>\
                </div>';

    $('#' + FormId + ' #' + divId).html(html);
    $('#' + FormId + ' #' + divId).fadeTo(2500, timeOut).slideUp(timeOut, function () {
        $('#' + FormId + ' #' + divId).slideUp(timeOut);
    });

}

