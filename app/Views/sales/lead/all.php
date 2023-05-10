<?php

$ProductName = getSegment(3);


?>


<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">All <?=ucwords($product_name)?> Leads

                </h4>
            </div>
<?php /* echo "<pre>";
print_r($product_records); exit;*/?>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="table-responsive mb-4 mt-4">
                        <table id="AllProductsLeads" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Ref.ID</th>
                                <th>Submitted On</th>
                                <th>Full Name</th>
                                <th>Sale Officer</th>

                                <th>Lead Category</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody>
<!--                            <?php /*$cnt = 0; foreach ($product_records as $value){  $cnt++;

                                $WhatsAppUrl = '';
                                $ContactUrl = '';
                                if ($value['WhatsAppNo'] != '') {
                                    $WhatsAppUrl = WhatsAppUrl($value['WhatsAppNo']);
                                }
                                if ($value['ContactNo'] != '') {
                                    $ContactUrl = WhatsAppUrl($value['ContactNo']);
                                }
                                */?>
                                <tr>
                                    <td><?/*=$cnt*/?></td>
                                    <td><?php /*echo '<a href="' . SeoUrl('lead/activities/' . $value['UID'] . "-" . $value['FullName']) .
                                            '" target="_blank">' . Code('UF/L/', $value['UID']) . '</a>'; */?></td>
                                    <td><?/*=DATEFORMAT($value['CreatedAt'])*/?></td>
                                    <td><?/*=ucwords($value['FullName'])*/?></td>
                                    <td><?/*=$value['Email']*/?></td>
                                    <td><?php /*echo '<a target="_blank" style="cursor:pointer;" href="' . $ContactUrl . '">' . $value['ContactNo'] . '</a>'; */?></td>
                                    <td><?php /*echo '<a target="_blank" style="cursor:pointer;" href="' . $WhatsAppUrl . '">' . $value['WhatsAppNo'] . '</a>'; */?></td>
                                    <td><?/*=$value['LeadCategory']*/?></td>
                                    <td><badge class="badge badge-success"> <?/*=ucwords(str_replace('_', ' ', $value['Status']))*/?></badge> </td>


                                </tr>
                            --><?php /*} */?>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">


    // $('#ReportTable').DataTable({
    //     "scrollX": true,
    //     "oLanguage": {
    //         "oPaginate": {
    //             "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
    //             "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
    //         },
    //         "sInfo": "Showing page _PAGE_ of _PAGES_",
    //         "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
    //         "sSearchPlaceholder": "Search...",
    //         "sLengthMenu": "Results :  _MENU_",
    //     },
    //     "stripeClasses": [],
    //     "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
    //     "pageLength": 100
    // });



    $('#AllProductsLeads').DataTable({
        'searching' : true,
        'processing' : true,
        'serverSide' : true,
        'pageLength' : 100,
        'lengthMenu' : [[100,500,1000,-1],[100,500,1000,'All']],
        'ajax' : {
            url : '<?=$path?>lead/fetch_product_based_lead',
            type : 'POST',
            data : {
                segment : '<?=$ProductName ?>',
            },
        }

    });

    // setTimeout(function () {
    //     $('<a href="#" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    // }, 100);

</script>
