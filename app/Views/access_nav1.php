<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery hummingbird-treeview Demo</title>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?= $template ?>tree-view/hummingbird-treeview.css" rel="stylesheet" type="text/css">
    <style>
        body {
            background-color: #fafafa;
        }

        .container {
            margin: 150px auto;
            min-height: 100vh;
        }

        .stylish-input-group .input-group-addon {
            background: white !important;
        }

        .stylish-input-group .form-control {
        / / border-right: 0;
            box-shadow: 0 0 0;
            border-color: #ccc;
        }

        .stylish-input-group button {
            border: 0;
            background: transparent;
        }

        .h-scroll {
            background-color: #fcfdfd;
            height: 260px;
            overflow-y: scroll;
        }
    </style>
</head>

<body>

<?php

$records = array();

$records['dashboard']['tile1'] = "Tile 1";
$records['dashboard']['tile2'] = "Tile 2";

$records['navigation']['umrah']['umrah_head1'] = "Head 1";
$records['navigation']['umrah']['umrah_head2'] = "Head 2";

$records['navigation']['tickets']['ticket_head1'] = "Head 1";
$records['navigation']['tickets']['ticket_head2'] = "Head 2";

$records['navigation']['hajj']['hajj_head1'] = "Head 1";
$records['navigation']['hajj']['hajj_head2'] = "Head 2";

$records['navigation']['hotel']['hotel_head1'] = "Head 1";
$records['navigation']['hotel']['hotel_head2'] = "Head 2";

$records['navigation']['transport']['transport_head1'] = "Head 1";
$records['navigation']['transport']['transport_head2'] = "Head 2";

$records['navigation']['tourism']['tourism_head1'] = "Head 1";
$records['navigation']['tourism']['tourism_head2'] = "Head 2";

$records['navigation']['visa']['visa_head1'] = "Head 1";
$records['navigation']['visa']['visa_head2'] = "Head 2";

$records['navigation']['visitor']['visitor_head1'] = "Head 1";
$records['navigation']['visitor']['visitor_head2'] = "Head 2";

$records['reports']['pilgrim_list'] = "Pilgrim List Report";

//echo'<pre>';print_r( $AccessLevels );exit;
?>

<div class="container-fluid" style="padding: 10px;">
    <h4 style="text-align: center; font-weight: bold">Dynamic Tree View</h4>
    <div class="row">
        <div class="col-md-12">

            <?php if (count($AccessLevels) > 0) { ?>

                <div id="treeview_container" class="hummingbird-treeview">
                    <ul id="treeview" class="hummingbird-base">
                        <?php
                        $cnt = 1;
                        foreach ($AccessLevels as $ParentKey => $FirstLevelData) {
                            $headkey = strtolower(str_replace(" ", "_", $ParentKey));
                            $ParentKey = str_replace("_", " ", $ParentKey);
                            ?>

                            <li data-id="<?= $cnt ?>">
                                <?php if (is_array($FirstLevelData) && count($FirstLevelData) > 0) { ?>
                                    <i class="fa fa-plus"></i>
                                <?php } ?>

                                <label>
                                    <input id="<?= $ParentKey ?>"
                                           type="checkbox"/> <?= ucwords($ParentKey) ?>
                                </label>
                                <?php if (is_array($FirstLevelData) && count($FirstLevelData) > 0) { ?>

                                    <ul>
                                        <?php
                                        $subcnt = 1;
                                        foreach ($FirstLevelData as $SubParentKey => $SecondLevelData) {

                                            $subheadkey = strtolower(str_replace(" ", "_", $SubParentKey));
                                            $SubParentKey = str_replace("_", " ", $SubParentKey);

                                            if (is_array($SecondLevelData) && count($SecondLevelData) > 0) { ?>

                                                <li data-id="<?= $subcnt ?>">
                                                    <i class="fa fa-plus"></i>
                                                    <label>
                                                        <input class="checkedall"
                                                               id="<?= $subheadkey ?>"
                                                               type="checkbox"/>
                                                        <?= ucwords($SubParentKey) ?>
                                                    </label>
                                                    <ul>
                                                        <?php foreach ($SecondLevelData as $Key => $ThirdLevel) {

                                                            $Key = str_replace("_", " ", $Key);

                                                            if (is_array($ThirdLevel) && count($ThirdLevel) > 0) { ?>

                                                                <li data-id="<?= $subcnt ?>">
                                                                    <i class="fa fa-plus"></i>
                                                                    <label>
                                                                        <input class="checkedall "
                                                                               id="<?= $subheadkey ?>"
                                                                               type="checkbox"/>
                                                                        <?= ucwords($Key) ?>
                                                                    </label>
                                                                    <ul>
                                                                        <?php foreach ($ThirdLevel as $SubKey => $Value) {

                                                                            $SubKey = str_replace("_", " ", $SubKey);

                                                                            if (is_array($Value) && count($Value) > 0) { ?>

                                                                                <li data-id="<?= $subcnt ?>">
                                                                                    <i class="fa fa-plus"></i>
                                                                                    <label>
                                                                                        <input class="checkedall "
                                                                                               id="<?= $subheadkey ?>"
                                                                                               type="checkbox"/>
                                                                                        <?= ucwords($SubKey) ?>
                                                                                    </label>
                                                                                    <ul>
                                                                                        <?php foreach ($Value as $SubInnerKey => $V) { ?>

                                                                                            <li>
                                                                                                <label>
                                                                                                    <input class="hummingbird-end-node"
                                                                                                           id="<?= $SubInnerKey ?>"
                                                                                                           type="checkbox"/>
                                                                                                    <?= ucwords($V) ?>
                                                                                                </label>
                                                                                            </li>

                                                                                        <?php } ?>
                                                                                    </ul>
                                                                                </li>


                                                                            <?php } else { ?>

                                                                                <li>
                                                                                    <label>
                                                                                        <input class="hummingbird-end-node"
                                                                                               id="<?= $SubKey ?>"
                                                                                               type="checkbox"/>
                                                                                        <?= ucwords($Value) ?>
                                                                                    </label>
                                                                                </li>

                                                                            <?php } ?>

                                                                        <?php } ?>
                                                                    </ul>
                                                                </li>


                                                            <?php } else { ?>

                                                                <li data-id="<?= $subcnt ?>">
                                                                    <label>
                                                                        <input class="checkedall"
                                                                               id="<?= $Key ?>"
                                                                               type="checkbox"/>
                                                                        <?= $ThirdLevel ?>
                                                                    </label>
                                                                </li>

                                                            <?php } ?>

                                                        <?php } ?>

                                                    </ul>
                                                </li>


                                            <?php } else { ?>

                                                <li data-id="<?= $subcnt ?>">
                                                    <label>
                                                        <input class="checkedall"
                                                               id="<?= $SubParentKey ?>"
                                                               type="checkbox"/>
                                                        <?= $SecondLevelData ?>
                                                    </label>
                                                </li>

                                            <?php } ?>

                                            <?php
                                            $subcnt++;
                                        } ?>
                                    </ul>

                                <?php }
                                ?>
                            </li>

                            <?php $cnt++;
                        }
                        ?>

                    </ul>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<?php
echo '<pre>';
print_r($AccessLevels);
?>
<script type="text/javascript">

    function ChangeCheckboxStatus(obj) {

        var key = $(obj).attr('id');
        var accessValue = ($('#' + key).is(":checked")) ? 1 : 0;

        if (accessValue == 1) {
            $('#check_' + key).val('1');
        } else {
            $('#check_' + key).val('0');
        }
    }

    function CheckOptions(obj) {

        var key = $(obj).attr('id');
        var accessValue = ($('#' + key).is(":checked")) ? 1 : 0;

        if (accessValue == 1) {

            $('.' + key).prop('checked', true);
            $('.' + key + '_input').val('1');

        } else {

            $('.' + key).prop('checked', false);
            $('.' + key + '_input').val('0');

        }
    }

    function CheckSubOptions(obj) {

        var key = $(obj).attr('id');
        var accessValue = ($('#' + key).is(":checked")) ? 1 : 0;

        if (accessValue == 1) {

            $('.' + key).prop('checked', true);
            $('.' + key + '_input').val('1');

        } else {

            $('.' + key).prop('checked', false);
            $('.' + key + '_input').val('0');

        }
    }

</script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="<?= $template ?>tree-view/hummingbird-treeview.js"></script>
<script>
    $("#treeview").hummingbird();

</script>
</body>
</html>
