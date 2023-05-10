<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Ref.ID</th>
        <th>Agent</th>
        <th>Group</th>
        <th>Full Name</th>
        <th>PPT Number</th>
        <th>Actual Arrival Date</th>
        <th>Arrival Port</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $cnt = 0;
    foreach ($records as $record) {
        $cnt++;
        echo '
                                <tr>
                                <td>' . $cnt . '</td>
                                <td>' . Code("UF/A/",$record['AgentUID']) . '</td>
                                <td>' . $record['AgentName'] . '</td>
                                <td>' . $record['GroupName'] . '</td>
                                <td>' . $record['FullName'] . '</td>
                                <td>' . $record['PPNO'] . '</td>
                                <td>' . ((isset($record['ActualArrivalDate'])) ? DATEFORMAT($record['ActualArrivalDate']) : '-') . '</td>
                                <td>' . ((isset($record['EntryPort'])) ? $record['EntryPort'] : '-') . '</td>
                                                                                    
                                  
                                </tr> ';
    }
    ?>
    </tbody>
</table>
