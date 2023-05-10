<!--  BEGIN CONTENT AREA  -->
<style>
    .fa-minus {
        color: black !important;
    }

    .fa-plus {
        color: black !important;
    }

    .hummingbird-treeview, .hummingbird-treeview * {
        font-size: 17px !important;
    }

</style>
<?php

use App\Models\Main;

$MainModel = new Main();

$Array = array();
$AdminKeys = $Type = $UserType = '';
$AdminType = $MainModel->UserType();
foreach ($AdminType as $Key => $Value) {
    $Array[] = $Key;
}
if (isset($_GET['type']) && $_GET['type'] != '') {
    $Type = $_GET['type'];
}
if ($Type != '') {
    if (in_array($Type, $Array)) {
        $UserType = 'mis';
    } else {
        $UserType = $Type;
    }
}
?>
<link href="<?= $template ?>tree-view/hummingbird-treeview.css" rel="stylesheet" type="text/css">
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Access Levels List
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AccessLevelFilters">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="false"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show" aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">Account
                                                            Type </label>
                                                        <select class="form-control" id="AccountType"
                                                                name="AccountType"
                                                                onchange="LoadSystemUsersDropdown(this.value)">
                                                            <option value="">Please Select</option>
                                                            <?php
                                                            foreach ($account_types as $account_typeK => $account_typesV) {
                                                                if (isset($session['AccessLevelFilters']['AccountType'])) {
                                                                    $selected = (($session['AccessLevelFilters']['AccountType'] == $account_typeK) ? 'selected' : '');
                                                                } else {

                                                                    if (isset($UserType) && $UserType != '') {
                                                                        $selected = (($UserType == $account_typeK) ? 'selected' : '');
                                                                    } else {
                                                                        $selected = (($session['account_type'] == $account_typeK) ? 'selected' : '');
                                                                    }

                                                                }
                                                                echo '<option value="' . $account_typeK . '" ' . $selected . '>' . $account_typesV . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">System Users</label>
                                                        <select class="form-control" id="SystemUsers"
                                                                name="SystemUsers">
                                                            <?php
                                                            if (isset($session['AccessLevelFilters']['SystemUsers'])) {
                                                                $select = $session['AccessLevelFilters']['SystemUsers'];
                                                            } else {
                                                                //$select = $session['id'];
                                                                $select = $userID;
                                                            }
                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3" style="margin-top: 30px;">
                                                    <div class="form-group float-right">
                                                        <button onclick="UpdateFilter('AccessLevelFilters'); return false;"
                                                                class="btn btn-success">Search
                                                        </button>
                                                        <button onclick="ClearFilter('AccessLevelFilters'); return false;"
                                                                class="btn btn-danger">Clear Filter
                                                        </button>
                                                    </div>
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
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <form onsubmit="UpdateAccessLevels('AccessLevelForm'); return false;" method="post" id="AccessLevelForm"
                      name="AccessLevelForm">
                    <input type="hidden" name="UserID" value="<?= $userID ?>">

                    <div class="widget-content widget-content-area br-6">
                        <div class="form-group row">
                            <?php
                            $Crud = new \App\Models\Crud();
                            $type = '';
                            if (isset($session['AccessLevelFilters']['AccountType'])) {
                                $AccountType = '';

                                if ($session['AccessLevelFilters']['AccountType'] == 'sale_agent') {
                                    echo '<div class="col-md-8"> <h5>' . GetIDwithTable($session['AccessLevelFilters']['SystemUsers'], 'sale_agent."Agents"') . '  as ' . $account_types[$session['AccessLevelFilters']['AccountType']] . '</h5></div>';
                                    $type = 'sale_agent';
                                } else if ($session['AccessLevelFilters']['AccountType'] == 'mis') {
                                    echo '<div class="col-md-8"> <h5>' . GetIDwithTable($session['AccessLevelFilters']['SystemUsers'], 'main."Users"') . '  as ' . $account_types[$session['AccessLevelFilters']['AccountType']] . '</h5></div>';
                                    $UsersRSLT = $Crud->SingleRecord('main."Users"', ['UID' => $session['AccessLevelFilters']['SystemUsers']]);
                                    $type = $UsersRSLT['UserType'];
                                } else {
                                    echo '<div class="col-md-8"> <h5>' . GetIDwithTable($session['AccessLevelFilters']['SystemUsers'], 'main."Agents"') . '  as ' . $account_types[$session['AccessLevelFilters']['AccountType']] . '</h5></div>';
                                    $UsersRSLT = $Crud->SingleRecord('main."Agents"', ['UID' => $session['AccessLevelFilters']['SystemUsers']]);
                                    $type = $UsersRSLT['Type'];
                                }
//                                echo "xxxxxxxxxxxxxxxxxxxxxxxx0";

                            } else {
                                if (isset($SaleAgents['UID'])) {
                                    echo '<div class="col-md-8"> <h5>' . $SaleAgents['FullName'] . ' as "Sale Agent"</h5></div>';
                                    $type = 'sale_agent';
                                }
                                if (isset($CurUser['UID'])) {
                                    echo '
                                    <div class="col-md-8">
                                        <h5>' . $CurUser['FullName'] . ' as ' . $user_types[$CurUser['UserType']] . '</h5>
                                    </div>';
                                    $type = $CurUser['UserType'];
                                }
                                if (isset($Agentss['UID'])) {
                                    echo '<div class="col-md-8"> <h5>' . $Agentss['FullName'] . ' as "' . ucwords(str_replace("_", " ", $Agentss['Type'])) . '"</h5></div>';
                                    $type = $Agentss['Type'];
                                }

                            }
                            echo '<input type="hidden" name="UserType" id="UserType" value="' . $type . '">';
                            $sale_agents_parent = array('travel', 'umrah');
                            $mis = array('travel', 'umrah', 'hotel');


                            ?>

                            <div class="col-md-4" style="text-align: right;">
                                <button type="button" onclick="UpdateAccessLevels('AccessLevelForm');"
                                        class="btn btn-success btn-mini">Update Record
                                </button>
                            </div>
                            <div class="col-md-12 mt-2" id="AccessLevelResponse"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php //echo'<pre>';print_r($AccessLevels); ?>
                                <?php if (count($AccessLevels) > 0) { ?>
                                    <div id="treeview_container" class="hummingbird-treeview">
                                        <ul style="padding-left: 10px !important;" id="treeview"
                                            class="hummingbird-base">
                                            <?php
                                            $cnt = 1;
                                            $access_link = '';
                                            foreach ($AccessLevels as $ParentKey => $FirstLevelData) {
                                                $access_link = $ParentKey;
                                                $level1 = $ParentKey ?>

                                                <li>
                                                    <?php if (is_array($FirstLevelData) && count($FirstLevelData) > 0) { ?>
                                                        <i class="fa fa-plus"></i>
                                                    <?php } ?>

                                                    <label>
                                                        <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                onchange="CheckOptions(this);"
                                                                class="checkedall <?= $level1 ?>"
                                                                id="<?= $access_link ?>"
                                                                type="checkbox"/>
                                                        <input type="hidden"
                                                               value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                               class="checkedall_input <?= $level1 ?>_input"
                                                               name="check[<?= $access_link ?>]"
                                                               id="check_<?= $access_link ?>">
                                                        <?= ucwords($ParentKey) ?> <b style="color: red;">Key
                                                            &raquo;</b> ( <?= $access_link ?> )
                                                    </label>
                                                    <?php if (is_array($FirstLevelData) && count($FirstLevelData) > 0) { ?>

                                                        <ul>
                                                            <?php
                                                            $subcnt = 1;
                                                            foreach ($FirstLevelData as $SubParentKey => $SecondLevelData) {
                                                                $SubParentKeyHtml = str_replace("_", " ", $SubParentKey);
                                                                $access_link = str_replace(' ', '_', $ParentKey . " " . $SubParentKey);
                                                                $level2 = $access_link;

                                                                if (is_array($SecondLevelData) && count($SecondLevelData) > 0) { ?>

                                                                    <li>
                                                                        <i class="fa fa-plus"></i>
                                                                        <label>
                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                    onchange="CheckOptions(this);"
                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?>"
                                                                                    id="<?= $access_link ?> "
                                                                                    type="checkbox"/>
                                                                            <input type="hidden"
                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input"
                                                                                   name="check[<?= $access_link ?>]"
                                                                                   id="check_<?= $access_link ?>">
                                                                            <?= ucwords($SubParentKeyHtml) ?> <b
                                                                                    style="color: red;">Key &raquo;</b>
                                                                            ( <?= $access_link ?> )
                                                                        </label>
                                                                        <ul>
                                                                            <?php foreach ($SecondLevelData as $Key => $ThirdLevel) {

                                                                                $KeyHtml = str_replace("_", " ", $Key);
                                                                                $access_link = str_replace(' ', '_', $ParentKey . " " . $Key);
                                                                                $level3 = $access_link;

                                                                                if (is_array($ThirdLevel) && count($ThirdLevel) > 0) { ?>

                                                                                    <li data-id="<?= $subcnt ?>">
                                                                                        <i class="fa fa-plus"></i>
                                                                                        <label>
                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                    onchange="CheckOptions(this);"
                                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?>"
                                                                                                    id="<?= $access_link ?>"
                                                                                                    type="checkbox"/>
                                                                                            <input type="hidden"
                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input"
                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                   id="check_<?= $access_link ?>">
                                                                                            <?= ucwords($KeyHtml) ?> <b
                                                                                                    style="color: red;">Key
                                                                                                &raquo;</b>
                                                                                            ( <?= $access_link ?> )
                                                                                        </label>
                                                                                        <ul>
                                                                                            <?php foreach ($ThirdLevel as $SubKey => $FourthLevel) {

                                                                                                $SubKeyHtml = str_replace("_", " ", $SubKey);
                                                                                                $access_link = str_replace(' ', '_', $ParentKey . " " . $Key . " " . $SubKey);
                                                                                                $level4 = $access_link;

                                                                                                if (is_array($FourthLevel) && count($FourthLevel) > 0) { ?>

                                                                                                    <li data-id="<?= $subcnt ?>">
                                                                                                        <i class="fa fa-plus"></i>
                                                                                                        <label>
                                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                    onchange="CheckOptions(this);"
                                                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?>"
                                                                                                                    id="<?= $access_link ?>"
                                                                                                                    type="checkbox"/>
                                                                                                            <input type="hidden"
                                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input"
                                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                                   id="check_<?= $access_link ?>">
                                                                                                            <?= ucwords($SubKeyHtml) ?>
                                                                                                            <b style="color: red;">Key
                                                                                                                &raquo;</b>
                                                                                                            ( <?= $access_link ?>
                                                                                                            )
                                                                                                        </label>
                                                                                                        <ul>
                                                                                                            <?php foreach ($FourthLevel as $SubInnerKey => $Value) {

                                                                                                                $SubInnerKeyHtml = str_replace("_", " ", $SubInnerKey);
                                                                                                                $access_link = str_replace(' ', '_', $ParentKey . " " . $Key . " " . $SubKey . " " . $SubInnerKey);
                                                                                                                $level5 = $access_link;
                                                                                                                if (is_array($Value) && count($Value) > 0) { ?>

                                                                                                                    <li data-id="<?= $subcnt ?>">
                                                                                                                        <i class="fa fa-plus"></i>
                                                                                                                        <label>
                                                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                                    onchange="CheckOptions(this);"
                                                                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?> <?= $level5 ?>"
                                                                                                                                    id="<?= $access_link ?>"
                                                                                                                                    type="checkbox"/>
                                                                                                                            <input type="hidden"
                                                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input <?= $level5 ?>_input"
                                                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                                                   id="check_<?= $access_link ?>">
                                                                                                                            <?= ucwords($SubInnerKeyHtml) ?>
                                                                                                                            <b style="color: red;">Key
                                                                                                                                &raquo;</b>
                                                                                                                            ( <?= $access_link ?>
                                                                                                                            )
                                                                                                                        </label>
                                                                                                                        <ul>
                                                                                                                            <?php
                                                                                                                            foreach ($Value as $lastKey => $LastValue) {
                                                                                                                                $SubInnerLastKeyHtml = str_replace("_", " ", $lastKey);
                                                                                                                                $access_link = str_replace(' ', '_', $ParentKey . " " . $Key . " " . $SubKey . " " . $SubInnerKey . " " . $lastKey);
                                                                                                                                $level6 = $access_link;
                                                                                                                                if (is_array($LastValue) && count($LastValue) > 0) {

                                                                                                                                    foreach ($LastValue as $LastInnerKey => $LastInnerValue) { ?>

                                                                                                                                        <li>
                                                                                                                                            <label>
                                                                                                                                                <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                                                        onchange="ChangeCheckboxStatus(this);"
                                                                                                                                                        class="hummingbird-end-node checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?> <?= $level5 ?> <?= $level6 ?>"
                                                                                                                                                        id="<?= $access_link ?>"
                                                                                                                                                        type="checkbox"/>
                                                                                                                                                <input type="hidden"
                                                                                                                                                       value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                                                       class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input <?= $level5 ?>_input <?= $level6 ?>_input"
                                                                                                                                                       name="check[<?= $access_link ?>]"
                                                                                                                                                       id="check_<?= $access_link ?>">
                                                                                                                                                <?= ucwords($LastInnerValue) ?>
                                                                                                                                                <b style="color: red;">Key
                                                                                                                                                    &raquo;</b>
                                                                                                                                                ( <?= $access_link ?>
                                                                                                                                                )
                                                                                                                                            </label>
                                                                                                                                        </li>

                                                                                                                                    <?php } ?>

                                                                                                                                <?php } else { ?>

                                                                                                                                    <li>
                                                                                                                                        <label>
                                                                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                                                    onchange="ChangeCheckboxStatus(this);"
                                                                                                                                                    class="hummingbird-end-node checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?> <?= $level5 ?> <?= $level6 ?>"
                                                                                                                                                    id="<?= $access_link ?>"
                                                                                                                                                    type="checkbox"/>
                                                                                                                                            <input type="hidden"
                                                                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input <?= $level5 ?>_input <?= $level6 ?>_input"
                                                                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                                                                   id="check_<?= $access_link ?>">
                                                                                                                                            <?= ucwords($LastValue) ?>
                                                                                                                                            <b style="color: red;">Key
                                                                                                                                                &raquo;</b>
                                                                                                                                            ( <?= $access_link ?>
                                                                                                                                            )
                                                                                                                                        </label>
                                                                                                                                    </li>

                                                                                                                                <?php } ?>

                                                                                                                            <?php } ?>
                                                                                                                        </ul>
                                                                                                                    </li>

                                                                                                                <?php } else { ?>

                                                                                                                    <li>
                                                                                                                        <label>
                                                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                                    onchange="ChangeCheckboxStatus(this);"
                                                                                                                                    class="hummingbird-end-node checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?> <?= $level5 ?>"
                                                                                                                                    id="<?= $access_link ?>"
                                                                                                                                    type="checkbox"/>
                                                                                                                            <input type="hidden"
                                                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input <?= $level5 ?>_input"
                                                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                                                   id="check_<?= $access_link ?>">
                                                                                                                            <?= ucwords($Value) ?>
                                                                                                                            <b style="color: red;">Key
                                                                                                                                &raquo;</b>
                                                                                                                            ( <?= $access_link ?>
                                                                                                                            )
                                                                                                                        </label>
                                                                                                                    </li>

                                                                                                                <?php } ?>

                                                                                                            <?php } ?>
                                                                                                        </ul>
                                                                                                    </li>

                                                                                                <?php } else { ?>

                                                                                                    <li>
                                                                                                        <label>
                                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                                    onchange="ChangeCheckboxStatus(this);"
                                                                                                                    class="hummingbird-end-node checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?> <?= $level4 ?>"
                                                                                                                    id="<?= $access_link ?>"
                                                                                                                    type="checkbox"/>
                                                                                                            <input type="hidden"
                                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input <?= $level4 ?>_input"
                                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                                   id="check_<?= $access_link ?>">
                                                                                                            <?= ucwords($FourthLevel) ?>
                                                                                                            <b style="color: red;">Key
                                                                                                                &raquo;</b>
                                                                                                            ( <?= $access_link ?>
                                                                                                            )
                                                                                                        </label>
                                                                                                    </li>

                                                                                                <?php } ?>

                                                                                            <?php } ?>
                                                                                        </ul>
                                                                                    </li>

                                                                                <?php } else {
                                                                                    $access_link = str_replace("_navigation", "", $access_link);
                                                                                    ?>

                                                                                    <li data-id="<?= $subcnt ?>">
                                                                                        <label>
                                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                                    onchange="ChangeCheckboxStatus(this);"
                                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?> <?= $level3 ?>"
                                                                                                    id="<?= $access_link ?>"
                                                                                                    type="checkbox"/>
                                                                                            <input type="hidden"
                                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input <?= $level3 ?>_input"
                                                                                                   name="check[<?= $access_link ?>]"
                                                                                                   id="check_<?= $access_link ?>">
                                                                                            <?= $ThirdLevel ?> <b
                                                                                                    style="color: red;">Key
                                                                                                &raquo;</b>
                                                                                            ( <?= $access_link ?> )
                                                                                        </label>
                                                                                    </li>

                                                                                <?php } ?>

                                                                            <?php } ?>

                                                                        </ul>
                                                                    </li>

                                                                <?php } else { ?>

                                                                    <li>
                                                                        <label>
                                                                            <input <?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 'checked' : '') ?>
                                                                                    onchange="ChangeCheckboxStatus(this);"
                                                                                    class="checkedall <?= $level1 ?> <?= $level2 ?>"
                                                                                    id="<?= $access_link ?>"
                                                                                    type="checkbox"/>
                                                                            <input type="hidden"
                                                                                   value="<?= ((isset($CurrentAccessLevels[$access_link]) && $CurrentAccessLevels[$access_link] == 1) ? 1 : '') ?>"
                                                                                   class="checkedall_input <?= $level1 ?>_input <?= $level2 ?>_input"
                                                                                   name="check[<?= $access_link ?>]"
                                                                                   id="check_<?= $access_link ?>">
                                                                            <?= $SecondLevelData ?> <b
                                                                                    style="color: red;">Key &raquo;</b>
                                                                            ( <?= $access_link ?> )
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
                </form>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="<?= $template ?>tree-view/hummingbird-treeview.js"></script>

<script>
    $("#treeview").hummingbird();

    setTimeout(function () {
        var Type = $("#AccountType").val();
        LoadSystemUsersDropdown(Type);
    }, 500)


    function UpdateFilter(parent) {
        var data = $("form#" + parent).serialize();
        var rslt = AjaxResponse('form_process/update_filters', 'session_name=' + parent + '&' + data);
        if (rslt.status == 'success') {
            var SystemUser = $('form#AccessLevelFilters #SystemUsers').val();
            window.location = '<?= $path ?>setting/access_levels/' + SystemUser;
        }
    }

    function ClearFilter(SessionName) {

        var rslt = AjaxResponse("form_process/clear_filters", 'session_name=' + SessionName);
        if (rslt.status == 'success') {
            window.location = '<?= $path ?>setting/access_levels';
        }
    }

    function LoadSystemUsersDropdown(type) {

        mis = AjaxResponse("html/GetSystemUsersDropdownByAccountType", "type=" + type + "&selected=<?= $select ?>");
        $("#SystemUsers").html('<option value="">Please Select</option>' + mis.html);

    }

    function ChangeCheckboxStatus(obj) {

        var parent = $(obj).parent().parent().html();
        var key = $(obj).attr('id');
        var accessValue = ($('#' + key).prop('checked')) ? 1 : 0;

        if (accessValue == 1) {
            $('#' + key).prop('checked', true);
            $('#check_' + key).val('1');
        } else {
            $('#check_' + key).val('0');
            $('#' + key).prop('checked', false);
        }
    }

    function CheckOptions(obj) {
        var key = $(obj).attr('id');
        var accessValue = ($(obj).prop('checked')) ? 1 : 0;

        //alert( key + " || " + accessValue );

        var parentChild = $("li", $(obj).parent().parent()).length;
        $("li input[type=checkbox]", $(obj).parent().parent()).each(function () {
            var input_checked = $(this).attr('id');
            if (accessValue == 1) {
                $('#' + input_checked).prop('checked', true);
            } else {
                $('#' + input_checked).prop('checked', false);
            }
        });

        $("li input[type=hidden]", $(obj).parent().parent()).each(function () {
            var input_hidden = $(this).attr('id');
            if (accessValue == 1) {
                $('#' + input_hidden).val('1');
            } else {
                $('#' + input_hidden).val('0');
            }
        });


        if (accessValue == 1) {
            $('.' + key).prop('checked', true);
            $('.' + key + "_input").val('1');
        } else {
            $('.' + key + "_input").val('0');
            $('.' + key).prop('checked', false);
        }
    }

    /* function CheckAllOptions(opt) {
         var userId = <?= $userID ?>;
        $('form #userId').val(userId);
        if (opt == 'on') {
            $('.checkedall').prop('checked', true);
            $('.checkedall_input').val('1');
        }
        if (opt == 'off') {
            $('.checkedall').prop('checked', false);
            $('.checkedall_input').val('0');
        }
    }

   */

    function UpdateAccessLevels() {
        PlzWait('show');
        var phpdata = $("form#AccessLevelForm").serialize();
        var response = AjaxResponse("form_process/update_accesslevels", phpdata);
        if (response.status == 'success') {
            $("#AccessLevelResponse").html('<div class="alert alert-success mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Success!</strong> ' + response.message + ' </div>')
            PlzWait('hide');
        } else {
            $("#AccessLevelResponse").html('<div class="alert alert-danger mb-4" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x close" data-dismiss="alert"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button> <strong>Error!</strong> ' + response.message + ' </div>')
        }
    }


</script>