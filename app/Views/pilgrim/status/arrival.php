<?php
use App\Models\Pilgrims;
$PStatus = explode(":", $record_id);
$recordid = $PStatus[0];

$Pilgrims = new Pilgrims();
$PilgrimMetaDatas = $Pilgrims->PilgrimMetaData($recordid);
$finalMeta = array();
foreach ($PilgrimMetaDatas as $rec)
{
    $finalMeta[$rec['Option']] = $rec['Value'];
}

//print_r($finalMeta);



$inputs = array();
$inputs['arrival-driver-name'] = array("type" => "text", 'desc' => 'Driver Name');
$inputs['arrival-driver-number'] = array("type" => "number", 'desc' => 'Driver #');
$inputs['arrival-vehicle-number'] = array("type" => "text", 'desc' => 'Vehicle #');
$inputs['arrival-actual-no-of-seats'] = array("type" => "number", 'desc' => 'Actual No Of Seats');

echo '<input type="hidden" id="user-id" name="pilgrim-meta[arrival-user-id]" value=' .$session['id'] . '>';
echo '<input type="hidden" id="requested-status" name="pilgrim-meta[' .$RequestedStatus . '-status]" value = 1 >';

foreach ($inputs as $key => $name) {
        echo '
        <div class="col-md-3">
            <div class="form-group mb-4">
                <label for="'.$name['desc'].'">'.$name['desc'].'</label><br>';
                echo '<input type="'.$name['type'].'" class="form-control " id="'.$key.'" name="pilgrim_meta['.$key.']"
                       placeholder="'.$name['desc'].'" value='.( (isset($finalMeta[$key])) ? $finalMeta[$key] : '' ).'>';
                echo '
            </div>
        </div>';
} ?>