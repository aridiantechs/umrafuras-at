<?php
//print_r($hotel_meta);
$packageCode = Code("UF/H/", $hotel_data['UID']);
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
<div align="center">
    <h1><?= $hotel_data['Name'] ?></h1>
</div>

<table class="pgrid" width="100%">
    <tbody>
    <tr>
        <td width="80%" border="0" style="border: 0px;">
            <h5><b>Category:</b> <?= OptionName($hotel_data['Category']) ?></h5>
            <h5><b>Location:</b> <?= CountryName($hotel_data['CountryID']) ?> - <?= CityName($hotel_data['CityID']) ?>
            </h5>
        </td>
        <td valign="top" width="20%" border="0" style="border: 0px;">
            <h5 style="padding-left: 8px; "><b>Ref:</b> <?= $packageCode ?></h5>
            <img src="<?= BarCode($packageCode) ?>" style="width: 100%;" width="100%">
        </td>
    </tr>
    <tr>
        <td border="0" colspan="2" style="border: 0px;">
            <h2>Description</h2>
            <p><?= nl2br($hotel_data['Description']) ?></p>
        </td>
    </tr>
    <tr style="border: 0px;">
        <td style="border: 0px;padding: 0px;" colspan="2" valign="top">
            <table width="100%">
                <tbody>
                <tr>
                    <td style="border: 0px;" width="50%" align="left" valign="top">
                        <h2>Facilities:</h2><?php
                        if (isset($hotel_meta['Facilities']))
                            foreach ($hotel_meta['Facilities'] as $Facilities) {
                                echo '<span><img src="' . $template . 'tick-mark.png" alt=""/> ' . ucwords(OptionName($Facilities)) . '&nbsp;&nbsp;</span>';
                            } ?>
                    </td>
                    <td valign="top" style="border: 0px;">
                        <h2>Amenities:</h2><?php
                        if (isset($hotel_meta['Amenities']))
                            foreach ($hotel_meta['Amenities'] as $Amenities) {
                                echo '<span><img src="' . $template . 'tick-mark.png" alt=""/> ' . ucwords(OptionName($Amenities)) . '&nbsp;&nbsp;</span>';
                            } ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="border: 0px;">
            <h2>Gallery:</h2>
            <div style="width: 100%"><?php
                $cnt = 1;
                foreach ($hotel_images as $image) {
                    echo '<div class="grid-img" style="background-image: url(\'' . $path . 'home/load_file/' . $image['ImageID'] . '\');"></div>';
                    if (($cnt % 6) == 0) {
                        echo '<div style="width: 100%; clear: both;"><br></div>';
                    }
                    $cnt++;
                    //if ($cnt > 6) break;
                } ?>
            </div>
        </td>
    </tr>
    </tbody>
</table>