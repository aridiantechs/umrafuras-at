<table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
    <?php
    echo '<thead>
                                   <tr> 
                                    <th>Sr.No</th>
                                    <th>Products</th>';
    $totaldates = 10;
    for ($i = $totaldates; $i > 0; $i--) {
        echo "<th>" . date('d-M-Y', strtotime("-$i days")) . "</th>";
    }
    echo '<th>Total</th></tr>
                                </thead>';

    echo '<tbody>
                                        ';
    $cnt = 0;
    foreach ($Products as $value) {

        if ($value == 'home' || $value == 'sales') {
        } else {
            $cnt++;
            echo '<tr>
                                                    <td>' . $cnt . '</td> 
                                                    <td>' . ucwords($value) . '</td>';

            for ($j = 0; $j < $totaldates; $j++) {
                echo '<td>' . $cnt . '' . $j . '0</td>';
            }
            echo '<td>4'.$cnt.'5</td></tr>';
        }
    }
    echo '</tbody>';
    ?>


</table>
