<?php

use App\Models\Crud;
use App\Models\Users;

$Crud = new Crud();
$Users = new Users();


?>


<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>Sr.No</th>
        <th>Agents Name</th>
        <?php

        $LookupsOptions = $Crud->LookupOptions('initial_training_checklist');
        foreach ($LookupsOptions as $LO) {
            echo '<th align="center">' . $LO['Name'] . '</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    $StaffData = $Users->ListSalesUsers();
    foreach ($StaffData as $SD) {
        $cnt++; ?>
        <tr>
            <td><?= $cnt ?></td>
            <td><?= ucwords($SD['FullName']) ?></td>
            <?php
            foreach ($LookupsOptions as $LO) {
//                                        echo $LO['UID']."<br>";
                $Performed = ((isset($InitialTrainingData[$SD['UID']][$LO['UID']]) && $InitialTrainingData[$SD['UID']][$LO['UID']] != '') ? $InitialTrainingData[$SD['UID']][$LO['UID']] : '');
                echo '<td >' . (($Performed == 1) ? '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check" style="color:green"><polyline points="20 6 9 17 4 12"></polyline></svg>' : '') . '</td>';
            }
            ?>
        </tr>
        <?php
    } ?>
    </tbody>
</table>
