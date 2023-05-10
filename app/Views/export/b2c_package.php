<?php
$packageCode = Code("UF/P/", $packageData[0]['UID']);
?>

<div align="center">
    <h2 style="margin-bottom: 0px"><?= ucwords($packageData[0]['Name'])  ?></h2>
    <small><?= $packageCode  ?></small><br />
    <img src="<?= BarCode($packageCode) ?>" style="width:35%">
</div>

<table class="table table-striped table-hover no-border" width="100%">
    <tbody>
    <tr>
        <td valign="top">
            <h3>Country: <?= CountryName($packageData[0]['CountryCode']); ?> </h3>
            <h3>Visa: <?=Money($packageData[0]['VisaFee'])?> / PAX</h3>
            <h3>Food: <?=Money($packageData[0]['FoodCharges'])?> / PAX</h3>
        </td>
        <td valign="top" width="30%">
            <h3>Start Date: <?= $packageData[0]['StartDate'] ?></h3>
            <h3>Expire Date: <?= $packageData[0]['ExpireDate'] ?></h3>
            <h3>Assigned Agent: <?= ucwords(AgentName($packageData[0]['AgentUID'])) ?></h3>
        </td>
    </tr>
    </tbody>
</table>
<?php
foreach ($HotelsRecords AS $CityID => $HotelsData) {
    // list($HotelUID, $CityUID, $RowID) = explode("|", $keys);
    ?>
    <strong><?= CityName($CityID) ?> Hotels</strong>
    <table class="table table-striped table-hover" width="100%">
        <thead>
        <tr>
            <th>Hotel Name</th>
            <?php
            foreach ($RoomTypes as $RoomType) {
                echo "<th>" . $RoomType['Name'] . "</th>";
            }
            ?>
        </tr>
        </thead>
        <tbody><?php
        if(count($HotelsData) > 0)
        {
            $i = 0;
            foreach ($HotelsData as $HotelUIDs => $thisData) {
                list($HotelUID, $CityUID) = explode("|", $HotelUIDs);
                ?>
                <tr>

                <td><?= HotelName($HotelUID) ?></td>
                <?php
                foreach ($RoomTypes as $RoomType) {
                    $sRate = ($thisData[$RoomType['UID']] > 0) ? Money($thisData[$RoomType['UID']]) . " / PAX" : "-";
                    echo "<td>" . $sRate . "</td>";
                }
                ?>

                </tr><?php
                $i++;
            }
        }
        else
        {
            echo '<tr><td style="text-align: center;" colspan="2">No Record Found...</td></tr>';

        }
        ?>

        </tbody>
    </table>
<?php } ?>

<strong> Transport </strong>
<table id="MainRecords" class="table table-hover non-hover"
       style="width:100%">
    <thead>
    <tr>
        <th>Sectors</th>
        <?php
        foreach ($TransportData AS $thisType) {
            echo '<th>'.$thisType.'</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    if (count($TransportSectors) > 0) {
        for ($i = 0; $i < count($TransportSectors); $i++) {
            $Sector = strtolower(str_ireplace(" ", "_", $TransportSectors[$i]["UID"]));
            echo '<tr>';
            echo '<td>' . $TransportSectors[$i]["Name"] . '</td>';
            foreach ($TransportData as $TransportUID => $thisType) {
                $value = "-";
                if (isset($TransportDBData[$TransportUID . "_" . $Sector . "_" . $i])) {
                    $value = $TransportDBData[$TransportUID . "_" . $Sector . "_" . $i];
                }

                echo '<td>' . Money($value) . '</td>';
            }

            echo '</tr>';
        }
    }
    else{
        echo '<tr><td style="text-align: center;" colspan="2">No Record Found...</td></tr>';
    }
    ?>
    </tbody>
</table>

<?php
foreach ($ZiyaratRecords AS $CityID => $ZiyaratData) {
    // list($HotelUID, $CityUID, $RowID) = explode("|", $keys);
    ?>
    <strong><?= CityName($CityID) ?> Ziyarat</strong>
    <table class="table table-striped table-hover" width="100%">
        <thead>
        <tr>
            <th>City</th>
            <th>Ziyarat</th>
            <?php
            foreach ($TransportData AS $key => $thisType) {
                echo "<th>" . $thisType . "</th>";
            }
            ?>
        </tr>
        </thead>
        <tbody><?php
        if (count($ZiyaratData) > 0) {
            $i = 0;
            foreach ($ZiyaratData as $ZiyaratUIDs => $thisData) {
                list($ZiyartUID, $CityUID) = explode("|", $ZiyaratUIDs);
                ?>
                <tr>

                <td><?= CityName($CityUID) ?></td>
                <td><?= ZiyaratName($ZiyartUID) ?></td>
                <?php
                foreach ($TransportData AS $key => $thisType) {
                    $sRate = ($thisData[$key] > 0) ? Money($thisData[$key]) . " / PAX" : "-";
                    echo "<td>" . $sRate . "</td>";
                }
                ?>

                </tr><?php
                $i++;
            }
        }
        else{
            echo '<tr><td style="text-align: center;" colspan="2">No Record Found...</td></tr>';
        }
        ?>

        </tbody>
    </table>
<?php } ?>

<strong> Other Services </strong>
<table class="table table-striped table-hover" width="100%">
    <thead>
    <tr>
        <?php
        foreach ($ExtraServices AS $key => $thisService) {
            echo '<th>'.$thisService['Name'].'</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        foreach ($ExtraServices AS $key => $thisService) {
            $Value = (isset($ServiceData[$thisService['UID']])) ? $ServiceData[$thisService['UID']] : '';
            echo '<td>'.$Value.'</td>';
        }

        ?>
    </tr>
    </tbody>
</table>

