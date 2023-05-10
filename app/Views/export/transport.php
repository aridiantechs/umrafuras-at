<?php
//print_r($hotel_meta);
$packageCode = Code("UF/T/", $transport_data['UID']);
?>
<style>
    .grid-img {
        width: 110px;
        height: 90px;
        background-size: cover;
        float: left;
        margin: 5px;
        background-repeat: no-repeat;
        background-position: center center;
    }

    h3 {
        margin-top: 0px;
    }
</style>
<div align="center">
    <h2><?= OptionName($transport_data['Type']) ?></h2>
</div>

<table class="table table-striped table-hover no-border" width="100%">
    <tbody>
    <tr style="border: 0px;">
        <td valign="top" style="border: 0px;">
            <h3>Luggage Capacity: <?=$transport_data['LuggageCapacity'] ?></h3>
            <h3>PAX Detail: <?= $transport_data['PAXDetail'] ?> </h3>
        </td>
        <td valign="top" width="30%" style="border: 0px;">
            <h3 style="padding-left: 10px; ">Ref.: <?= $packageCode ?></h3>
            <img src="<?= BarCode($packageCode) ?>" style="width: 100%;" width="100%">
        </td>
    </tr>
    <tr style="border: 0px;">
        <td colspan="2" style="border: 0px;">
            <h3><strong>Description:</strong>
                <p><?= $transport_data['Description'] ?></p></h3>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 0px;">
