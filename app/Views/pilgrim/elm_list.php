<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">ELM List
                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>EA Code</th>
                                <th>EA Name</th>
                                <th>Group Code</th>
                                <th>Group Desc</th>
                                <th>Pilgrim ID</th>
                                <th>Name</th>
                                <th>Birth Date</th>
                                <th>Passport No</th>
                                <th>MOI Number</th>
                                <th>Visa No</th>
                                <th>Entry Date</th>
                                <th>Entry Time</th>
                                <th>Entry Port</th>
                                <th>Transport Mode</th>
                                <th>Entry Carrier</th>
                                <th>Flight No</th>
                                <th>Package</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $cnt = 0;
                            foreach ($ELMDATA as $ELMData) {
                                $cnt++;
                                echo '
                                 <tr>
                                 <td>' . $cnt . '</td>
                                 <td>' . $ELMData['EACode'] . '</td>
                                 <td>' . $ELMData['EAName'] . '</td>
                                 <td>' . $ELMData['GroupCode'] . '</td>
                                 <td>' . $ELMData['GroupDesc'] . '</td>
                                 <td>' . $ELMData['PilgrimID'] . '</td>
                                 <td>' . $ELMData['Name'] . '</td>
                                 <td>' . date("d M, Y ", strtotime($ELMData['BirthDate']))  . '</td>
                                 <td>' . $ELMData['PassportNo'] . '</td>
                                 <td>' . $ELMData['MOINumber'] . '</td>
                                 <td>' . $ELMData['VisaNo'] . '</td>
                                 <td>' . date("d M, Y ", strtotime($ELMData['EntryDate']))  . '</td>
                                 <td>' . $ELMData['EntryTime'] . '</td>
                                 <td>' . $ELMData['EntryPort'] . '</td>
                                 <td>' . $ELMData['TransportMode'] . '</td>
                                 <td>' . $ELMData['EntryCarrier'] . '</td>
                                 <td>' . $ELMData['FlightNo'] . '</td>
                                 <td>' . $ELMData['Package'] . '</td>
                                 </tr>
                                
                                 ';
                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->
<script type="application/javascript">

    $('#MainRecords').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [15, 30, 50, 100],
        "pageLength": 15
    });

    setTimeout(function () {
        $('<a target="_blank" href="<?=$path?>excel_export/elm_list" class="dt-filter-btn">Excel Export</a>').appendTo(".dataTables_wrapper .dataTables_filter");
    }, 100);


</script>