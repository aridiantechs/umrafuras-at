<?php

use App\Models\HRModel;
$HrModel = new HRModel();
?>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head"> All Employees  </h4>
            </div>
<!--            --><?php
          // echo "<pre>";
          //  print_r($EmployeesData); exit;?>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4 datatableparentdiv">
                        <table id="MainRecords" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref.id</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Hire Date</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $cnt = 0;
                            foreach ($EmployeesData as $value) {
                                $cnt++; $color='#22af46'; if($value['emp_active']==0){$color = '#de4848';} ?>
                                <tr>
                                    <td><?= $cnt ?></td>
                                    <td><?='<a href="' . SeoUrl('hr/employee_attendance/' . $value['id'] . "-" . $value['emp_firstname'] . "-" . $value['emp_lastname']) . '" target="_blank">' . Code('UF/L/', $value['id']) . '</a>'?></td>
                                    <td><?php  echo "<span style='background-color: $color' class='dot mr-2'></span>".$value['emp_firstname'] . " " . $value['emp_lastname'] ?></td>
                                    <td><?= ($value['dept_name'] != '') ? $value['dept_name'] : '-'; ?></td>
                                    <td><?= ($value['emp_email'] != '') ? $value['emp_email'] : '-'; ?></td>
                                    <td><?= ($value['emp_city'] != '') ? $value['emp_city'] : '-'; ?></td>
                                    <td><?= ($value['emp_address'] != '') ? $value['emp_address'] : '-'; ?></td>
                                    <td><?= ($value['emp_phone'] != '') ? $value['emp_phone'] : '-'; ?></td>
                                    <td><?= ($value['emp_hiredate'] != '') ? DATEFORMAT($value['emp_hiredate']) : '-'; ?></td>

<!--                                    <td>--><?php '<div class="">
//                                    <img class="w-icon" src="https://cdn.creatureandcoagency.com/uploads/2014/04/Panda-facts-3-1.jpg">
//                                    </div>'; ?><!--</td>-->
                                    <td><?='-'?></td>
                                    <td ><?php if ($value['emp_cardnumber'] > 0 && $value['emp_cardnumber'] != '') {
                                            echo '<badge  class="badge badge-success badge-mini"><i class="fas fa-credit-card" style="font-size: 17px;"></i></badge>';
                                        }
                                        $ActionAccessControl = $HrModel->CheckAction($value['id'],'EFace10/ID');
                                        if ($ActionAccessControl[0]['FinalData'] > 0 && $ActionAccessControl[0]['FinalData'] != '') {
                                            echo '<badge  class="badge badge-success badge-mini"><i class="fas fa-user" style="font-size: 17px;"></i></badge>';
                                        }
                                          $ActionFingerPrint = $HrModel->CheckAction($value['id'],'K50');
                                        if ($ActionFingerPrint[0]['FinalData'] > 0 && $ActionFingerPrint[0]['FinalData'] != '') {
                                            echo '<badge class="badge badge-success badge-mini" >  <i class="fas fa-fingerprint" style="font-size: 17px;"></i></badge>';
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php } ?>

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
        "scrollX": true,
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

    function DeleteUser(UID) {
        if (confirm("Are You Want To Remove user")) {
            response = AjaxResponse("form_process/remove_system_user", "UID=" + UID);
            if (response.status == 'success') {
                location.href = "<?=base_url('user/index')?>";
            }


        }
    }
</script>
<style>
    .FontIconStyle {
        font-size: 18px;
        color: #2B8030;;
    }
    .dot {
        height: 10px;
        width: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .w-icon {
        /*color: #5c1ac3;*/
        /*background-color: #dccff7;*/
        height: 45px;
        display: inline-flex;
        width: 45px;
        align-self: center;
        justify-content: center;
        border-radius: 50%;
        /*padding: 10px;*/
    }
</style>