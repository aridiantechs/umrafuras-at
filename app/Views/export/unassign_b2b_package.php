<?php
use App\Models\Crud;
$Crud = new Crud();
$packageCode = Code("UF/P/", $packageData[0]['UID']);
?>

<div align="center">
    <h2 style="margin-bottom: 0px"><?= ucwords($packageData[0]['Name'])  ?></h2>
    <img src="<?= BarCode($packageCode) ?>" style="width:35%">
</div>

<strong>Basic Details</strong>
<table class="table table-striped table-hover" width="100%">
    <thead>
    <tr>
        <th>Package Code</th>
        <th>Country</th>
        <th>Package Type</th>
        <th>Start Date</th>
        <th>Expire Date</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?=$packageCode?></td>
        <td><?=CountryName($packageData[0]['CountryCode'])?></td>
        <td><?=$packageData[0]['PackageType']?></td>
        <td><?=$packageData[0]['StartDate']?></td>
        <td><?=$packageData[0]['ExpireDate']?></td>
    </tr>
    </tbody>
</table>

<?php if(count($VisaDetails) > 0){ ?>
    <strong>Visa Details</strong>
    <table class="table table-striped table-hover" width="100%">
        <thead>
        <tr>
            <?php
            foreach ($VisaDetails AS $VisaDetail){
                echo'<th>'.$VisaDetail['LookupName'].'</th>';
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            foreach ($VisaDetails AS $VisaDetail){
                echo'<td>'.Money($VisaDetail['Value']).'</td>';
            }
            ?>
        </tr>
        </tbody>
    </table>
<?php    } ?>

<?php
//echo "<pre>";print_r($HotelsRecords);
if(count($HotelsRecords)>0)
    foreach ($HotelsRecords AS $CityID => $HotelsData) {
        // list($HotelUID, $CityUID, $RowID) = explode("|", $keys);

        ?>
        <strong><?= CityName($CityID) ?> Hotels</strong>
        <table class="table table-striped table-hover" width="100%">
            <thead>
            <tr>
                <th>HTL Category</th>
                <th>City</th>
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
                    $Category = $Crud->SingleRecord('packages."Hotels"', array("UID"=>$HotelUID));
//            print_r($Category);
                    ?>
                    <tr>

                    <td><?=OptionName($Category['Category'])?></td>
                    <td><?= CityName($CityID) ?></td>
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
            echo '<td>'.Money($Value).'</td>';
        }

        ?>
    </tr>
    </tbody>
</table>

