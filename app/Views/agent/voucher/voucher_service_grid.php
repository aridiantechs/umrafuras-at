<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <div class="widget-content widget-content-area br-6">
        <div class="table-responsive">
            <table class="display nowrap table table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                <thead>
                <tr>
                    <th class="checkbox-column">
                        <label class="new-control new-checkbox checkbox-primary"
                               style="height: 18px; margin: 0 auto;">
                            <input type="checkbox"
                                   class="new-control-input todochkbox"
                                   id="todoAlls">
                            <span class="new-control-indicator"></span>
                        </label>
                    </th>
                    <th>Service Name</th>
                    <th>Serivce Charges</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt=0;
                $extra_services = $records['extra_services'];
                 foreach ($ExtrasGrid as $record) { $cnt++;
//                     echo' <input type="hidden" name="VoucherServiceRate" id="VoucherServiceRate" value="'.$record['Rate'].'">';
                    echo '
                                                                       <tr>
                                                                        <td class="checkbox-column">
                                                                            <label class="new-control new-checkbox checkbox-primary" style="height: 18px; margin: 0 auto;">
                                                                                <input type="checkbox" ' . ((in_array($record['UID'], $extra_services)) ? ' checked' : '') . ' class="new-control-input todochkbox"  id="todo-' . $cnt . '" name="VoucherServicesID[]" value="' . $record['UID'] . '">
                                                                                <span class="new-control-indicator"></span>
                                                                            </label>
                                                                            
                                                                        </td>
                                                                        <td>' . OptionName($record['ServiceUID']) . '</td>
                                                                        <td>' . Money($record['Rate']) . '</td>
                                                                        </tr>';
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    checkall('todoAlls', 'todochkbox');
    $('[data-toggle="tooltip"]').tooltip()

</script>