<table style="width:100%">
    <thead>
    <tr>
        <th>#</th>
        <th>Agent</th>
        <th>Group</th>
        <th>MOFA Pilgrim ID</th>
        <th>Full Name</th>
        <th>Nationality</th>
        <th>Passport Number</th>
        <th>MOFA Number</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody><?php
    for($a=1; $a<=66 ; $a++){
        ?><tr>
            <td>1</td>
            <td>ALI TRAVEL</td>
            <td>131478 - WAHEED </td>
            <td>1120890</td>
            <td>ABID HUSSAIN</td>
            <td>Pakistan</td>
            <td>ZY6902221</td>
            <td>ZY6902221</td>
            <td><a class="dropdown-item" href="#" onclick="LoadModal('mofa/upload_visa_form', 1)">Upload Visa</a></td>
        </tr><?php
    }?>

    </tbody>
</table>