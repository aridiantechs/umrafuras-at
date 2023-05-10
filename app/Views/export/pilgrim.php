<?php
//print_r($hotel_meta);
$packageCode = Code("UF/P/", $pilgrim_data['UID']);
?>
<style>
    * {
        font-size: 12px;
    }

    .grid-img {
        width: 110px;
        height: 90px;
        background-size: cover;
        float: left;
        margin: 3px;
        background-repeat: no-repeat;
        background-position: center center;
        border: solid 4px #f2f0f0;
    }

    h1 {
        font-size: 18px;
        font-weight: normal;
    }

    h2 {
        font-size: 14px;
        font-weight: bold;
    }

    h3 {
        padding: 7px;
        font-size: 18px;
        font-weight: normal;
    }

    h5 {
        margin: 0px 0px 10px 0px;
        font-weight: normal;
    }

    p {
        line-height: 20px;
    }

</style>
<table class="pgrid">
    <tbody>
    <tr>
        <td width="80%" border="0" style="border: 0px;">
            <h5><b>Date of Birth:</b> <?= $pilgrim_data['DOB'] ?></h5>
            <h5><b>Relation:</b> <?= $pilgrim_data['Relation'] ?></h5>
            <h5><b>Nationality:</b> <?= $pilgrim_data['Nationality'] ?></h5>
            <h5><b>Country:</b> <?= CountryName($pilgrim_data['Country']) ?></h5>
        </td>
        <td valign="top" width="20%" border="0" style="border: 0px;">
            <h5 style="padding-left: 8px; "><b>Ref:</b> <?= $packageCode ?></h5>
            <img src="<?= BarCode($packageCode) ?>" style="width: 100%;" width="100%"><br><br>
            <?php
            if (isset($pilgrim_data['Profile'])) {
                echo ' <img  src="' . $path . 'home/load_file/' . $pilgrim_data['Profile'] . '" width="100%">';
            }
            ?>
        </td>
    </tr>

    <tr>
        <td border="0" colspan="2" style="border: 0px;">
            <h4>Passport Details</h4>
            <table class="pgrid">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Passport #</th>
                    <th>Nationality</th>
                    <th>Citizenship #</th>
                    <th>Issue Date</th>
                    <th>Expiry Date</th>
                    <th>Booklet #</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($pilgrim_passport_data) > 0) {
                    foreach ($pilgrim_passport_data as $pilgrim_passport_data) {
                        echo '
                        <tr>
                            <td> ' . $pilgrim_passport_data['PassportType'] . '</td>
                            <td> ' . pilgrim_passport_data['PassportNumber'] . '</td>
                            <td> ' . $pilgrim_passport_data['Nationality'] . '</td>
                            <td> ' . $pilgrim_passport_data['CitizenshipNumber'] . '</td>
                            <td> ' . DATEFORMAT($pilgrim_passport_data['DateOfIssue']) . '</td>
                            <td> ' . DATEFORMAT($pilgrim_passport_data['DateOfExpiry']). '</td>
                            <td> ' . $pilgrim_passport_data['BookletNumber']. '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td style="text-align: center;" colspan="7">No Record Found...</td></tr>';
                } ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td border="0" colspan="2" style="border: 0px;">
            <h4>Tranpsort Details</h4>
            <table class="pgrid">
                <thead>
                <tr>
                    <th>Transport Mode</th>
                    <th>Entry Carrier</th>
                    <th>Entry Port</th>
                    <th>Flight No</th>
                    <th>Entry Date</th>
                    <th>Entry Time</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($pilgrim_transport_data) > 0) {
                    foreach ($pilgrim_transport_data as $PG) {
                        echo '
                        <tr>
                            <td> ' . $PG['TransportMode'] . '</td>
                            <td> ' . $PG['EntryCarrier'] . '</td>
                            <td> ' . $PG['EntryPort'] . '</td>
                            <td> ' . $PG['FlightNo'] . '</td>
                            <td> ' . $PG['EntryDate'] . '</td>
                            <td> ' . $PG['EntryTime'] . '</td>
                        </tr>';
                    }
                } else {
                    echo '<tr><td style="text-align: center;" colspan="6">No Record Found...</td></tr>';
                } ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td border="0" colspan="2" style="border: 0px;">
            <h4>MOFA Details</h4>
            <table class="pgrid">
                <thead>
                <tr>
                    <th>MOFA #</th>
                    <th>Visa #</th>
                    <th>Visa Issue Date</th>
                    <th>Visa Expire Date</th>
                    <th>Visa Type</th>
                    <th>MOI Number</th>
                    <th>Insurance Policy ID</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($pilgrim_mofa_data) > 0) {
                    foreach ($pilgrim_mofa_data as $PGM) {
                        echo '
                    <tr>
                        <td> ' . $PGM['MOFANumber'] . '</td>
                        <td> ' . $PGM['VisaNumber'] . '</td>
                        <td> ' . DATEFORMAT($pilgrim_data['IssueDate']) . '</td>
                        <td> ' . DATEFORMAT($pilgrim_data['ExpireDate']) . '</td>
                        <td> ' . $PGM['Type'] . '</td>
                        <td> ' . $PGM['MOINumber'] . '</td>
                        <td> ' . $PGM['INSURANCE_POLICY_ID'] . '</td>
                    </tr>';
                    }
                } else {
                    echo '<tr><td style="text-align: center;" colspan="7">No Record Found...</td></tr>';
                } ?>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>