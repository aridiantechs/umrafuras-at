<style>
    #BorderTable th, #BorderTable td {
        border: 1px solid black;
    }

    #BorderTable {
        border-spacing: 1px 12px;
    }

    #BorderTable th, td {
        padding: 5px !important;
    }

    strong, span {
        font-size: 10px;
    }

    #BorderTable th {
        background-color: #E6E6E6 !important;
        border: 1px solid black;
        font-weight: bold;
    }

    .no-border {
        border: 0px solid !important;
    }
</style>
<div id="BorderTable">
    <table class="table table-striped table-hover  display nowrap cell-border GoldClass"
           style="width: 100%;">
        <tr style="margin-bottom: 15px;  width: 100%">
            <th colspan="3"><span class="float-left"><strong>Transport Company</strong> </span></th>
            <th width="25%" style="text-align: right"><span class="float-right">Sr. No 01 </span></th>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Year  </strong>  </span></th>
            <td style="width: 25%;border-spacing: 10px !important;"><span class="float-right">1256 </span></td>
            <th style="width: 25%"><span class="float-left"><strong>Bus No  </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">1256 </span></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Company Name   </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">Name Here  </span></td>
            <th style="width: 25%"><span class="float-left"><strong>Company Code  </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">2525 </span></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Driver Name   </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">M Nawaz Hayat  </span></td>
            <th style="width: 25%"><span class="float-left"><strong>Driver Cell No</strong>  </span></th>
            <td style="width: 25%"><span class="float-right">15465 </span></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Create Date/Time  </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">5 Jan , 2021 - 09 00 PM </span></td>
            <th style="width: 25%"><span class="float-left"><strong>Pickup Date/Time </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">5 Jan , 2021 - 09 00 PM  </span></td>
        </tr>

        <tr>
            <td width="50%" colspan="2"><strong>From <br> Medinah Airport - Makkah Hotel </strong></td>
            <td width="50%" colspan="2"><strong>To <br> Medinah Hotel - Jeddah Airport </strong></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Flight No   </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">253</span></td>
            <th style="width: 25%"><span class="float-left"><strong>Flight Carrier  </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">-----   </span></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>Flight Date   </strong>  </span>
            </td>
            <td style="width: 25%"><span class="float-right">25 Jan, 2021</span></td>
            <th style="width: 25%"><span class="float-left"><strong>Flight Time  </strong>  </span></th>
            <td style="width: 25%"><span class="float-right"> 12:30    </span></td>
        </tr>
        <tr style="width: 50%">
            <th style="width: 25%"><span class="float-left"><strong>BRN   </strong>  </span></th>
            <td style="width: 25%"><span class="float-right">SDF2234F324</span></td>
            <td colspan="2" class="no-border"></td>
        </tr>
    </table>


    <table class="table table-striped table-hover  display nowrap cell-border GoldClass"
           style="width: 100%;">
        <tr>
            <th>#</th>
            <th>BRN</th>
            <th>Agent</th>
            <th>Pilgrim ID</th>
            <th>PAX Name</th>
            <th>Country</th>
            <th>PPT No</th>
            <th>From</th>
            <th>To</th>
        </tr>

        <?php
        for ($i = 1; $i < 10; $i++) {
            echo '
            <tr>
                <td>' . $i . '</td>
                <td>Dummy BRN Number</td>
                <td>Agent Name</td>
                <td>Pilgrim ID</td>
                <td>PAX Name</td>
                <td>Country</td>
                <td>PPT No</td>
                <td>From</td>
                <td>To</td>
            </tr>';
        } ?>
    </table>
</div>