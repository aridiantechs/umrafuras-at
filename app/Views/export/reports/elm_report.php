<table id="ReportTable" style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Date</th>
        <th>Entry Count</th>
        <th>Adult</th>
        <th>Child</th>
        <th>Infant</th>
        <th>Exited From Entry</th>
        <th>Inside KSA from Entry</th>
        <th>Exit Count</th>
        <th>Exit Count Summary</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for($i=1;$i<10;$i++)
    {
        echo '
                                <tr>
                                <td>'.$i.'</td>
                                <td>3/02/2020</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>3</td>
                                <td>7</td>
                                <td>5</td>
                                <td>12</td>
                                <td>14</td>
                             
                                </tr> ';
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" style="text-align: center"> Total : </td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>
        <td> 50</td>

    </tr>
    </tfoot>
</table>