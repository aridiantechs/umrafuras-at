<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Ref.ID</th>
        <th>Agent</th>
        <th>Group</th>
        <th>Full Name</th>
        <th>PPT Number</th>
        <th>DOB</th>
        <th>Nationality</th>
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
                                    <td>' . Code("UF/A/", $record['AgentUID']) . '</td>
                                    <td>' . $record['AgentName'] . '</td>
                                    <td>' . $record['GroupName'] . '</td>
                                    <td>' . $record['FullName'] . '</td>
                                    <td>' . $record['PPNO'] . '</td>
                                    <td>' . ((isset($record['DOB'])) ? DATEFORMAT($record['DOB']) : '-') . '</td>
                                    <td>' . $record['Nationality'] . '</td>
                                   </tr> ';
    }
    ?>
    </tbody>
</table>
