<div class="table-responsive mb-4 mt-4" style="overflow: auto;">
    <table id="MainRecords" class="table table-hover non-hover display nowrap"
           style="width:100%">
        <thead>
        <tr>
            <td><h2><?= ucwords($EmployeeInfo['emp_firstname'] . " " . $EmployeeInfo['emp_lastname']) ?></h2></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="width: 50%">
                <b> City: </b>
                <?= ((isset($EmployeeInfo['emp_city']) && $EmployeeInfo['emp_city'] != '') ? $EmployeeInfo['emp_city'] : '-') ?>
            </td>
            <td style="width: 49%">
                <b>Email: </b> <?= ((isset($EmployeeInfo['emp_email']) && $EmployeeInfo['emp_email'] != '') ? $EmployeeInfo['emp_email'] : '-') ?>
            </td>

        </tr>
        <tr>

            <td style="width: 50%">
                <b>Emergency Contact
                    No: </b> <?= ((isset($EmployeeInfo['emp_emergencyphone1']) && $EmployeeInfo['emp_emergencyphone1'] != '') ? '<a target="_blank" href="' . WhatsAppUrl($EmployeeInfo['emp_emergencyphone1']) . '">' . $EmployeeInfo['emp_emergencyphone1'] . '</a>' : '-') ?>
            </td>
            <td style="width: 49%">
                <b>Contact
                    No:</b> <?= ((isset($EmployeeInfo['emp_phone']) && $EmployeeInfo['emp_phone'] != '') ? '<a target="_blank" href="' . WhatsAppUrl($EmployeeInfo['emp_phone']) . '">' . $EmployeeInfo['emp_phone'] . '</a>' : '-') ?>
            </td>
        </tr>
        <tr>
            <td>
                <b>Address: </b> <?= ((isset($EmployeeInfo['emp_address']) && $EmployeeInfo['emp_address'] != '') ? $EmployeeInfo['emp_address'] : '-') ?>
            </td>
        </tr>

        </tbody>
    </table>
<br><br>
    <div class="table-responsive mb-4">
        <table id="EmployeeAttendance" class="table table-hover non-hover display nowrap"
               style="width:100%">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Date</th>
                <th>FingerPrint CheckIN</th>
                <th>FingerPrint CheckOUT</th>
                <th>AccessDoor CheckIN</th>
                <th>AccessDoor CheckOUT</th>
                <th>Late</th>
                <th>Short Leave</th>
                <th>Half Day</th>
                <th>Roaster</th>
                <th>Leave</th>
                <th>Absent</th>
            </tr>
            </thead>
            <tbody>
            <?php $cnt = 0;
            foreach ($EmployeeAttendance as $record) {
                $cnt++; ?>
                <tr>
                    <td><?= $cnt ?></td>
                    <td><?= $record['PunchDate'] ?></td>
                    <td><?= $record['FingerPrintCheckIn'] ?></td>
                    <td><?= $record['FingerPrintCheckOut'] ?></td>
                    <td><?= $record['AccessDoorCheckIn'] ?></td>
                    <td><?= $record['AccessDoorCheckOut'] ?></td>
                    <td><?= (isset($record['LateTimeSeconds']) && $record['LateTimeSeconds'] > 0 ? $record['LateTime'] : '-') ?></td>
                    <td><?= (isset($record['WorkedTimeDiff']) && ($record['WorkedTimeDiff'] > 2700 && $record['WorkedTimeDiff'] <11700) ? 'Yes' : '-') ?></td>
                    <td><?= (isset($record['WorkedTimeDiff']) && ($record['WorkedTimeDiff'] > 11700 && $record['WorkedTimeDiff'] <17100) ? 'Yes' : '-') ?></td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            <?php }
            ?>
            </tbody>
        </table>
    </div>
</div>