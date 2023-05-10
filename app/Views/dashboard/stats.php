<link rel="stylesheet" type="text/css" href="<?= $template ?>umrahfuras-dashboard.css">
<?php

use App\Models\Crud;

$Crud = new Crud();

$PAGEJS = '';
?>
<style>
    #ReportsPage a {
        color: white;
    }

    font.lang-ar {
        font-size: 130% !important;
    }

</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing" id="ReportsPage">
        <div class="page-header">
            <div class="page-title">
                <h3><?= ((isset($language_translation['stats']) && $language_translation['stats'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['stats'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Stats</font>') ?></h3>
            </div>
        </div>
        <!--        --><?php //print_r($DashboardCounters);  exit; ?>
        <div class="row analytics">

            <?php if ($CheckAccess['umrah_reports_status_stats_report_b2c'] || $CheckAccess['umrah_reports_status_stats_report_b2b']
                || $CheckAccess['umrah_reports_status_stats_report_external'] || $CheckAccess['umrah_reports_status_stats_report_total_pax']) { ?>
                <div class="col-xl-7 col-lg-12 col-md-7 ">
                    <div class="row">
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_b2c']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                                <div class="widget widget-card-four btb-box p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100" Id="B2cCount">
                                                <div class="blue-circle float-right"></div>
                                                <h6 class="value">
                                                    <span><?= ((isset($DashboardCounters['total-b2c'])) ? $DashboardCounters['total-b2c'] : '-') ?></span>
                                                </h6>
                                                <div class="blue-box text-center mt-2"><a
                                                            href="<?= $path ?>reports/stats_b2c"
                                                            target="_blank"><?= ((isset($language_translation['b2c']) && $language_translation['b2c'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['b2c'] . '</font>' : '<font class="lang-' . $session['lang'] . '">B2C</font>') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_b2b']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                                <div class="widget widget-card-four btb-box p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100" Id="B2bCount">
                                                <div class="green-circle float-right"></div>
                                                <h6 class="value">
                                                    <span><?= ((isset($DashboardCounters['total-b2b-pilgrim'])) ? $DashboardCounters['total-b2b-pilgrim'] : '-') ?></span>
                                                </h6>
                                                <div class="green-box text-center mt-2"><a
                                                            href="<?= $path ?>reports/stats_b2b"
                                                            target="_blank"><?= ((isset($language_translation['b2b']) && $language_translation['b2b'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['b2b'] . '</font>' : '<font class="lang-' . $session['lang'] . '">B2B</font>') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_external']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                                <div class="widget widget-card-four btb-box p-3">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info w-100" id="ExternalAgents">
                                                <div class="yellow-circle float-right"></div>
                                                <h6 class="value">
                                                    <span><?= ((isset($DashboardCounters['total-external-pilgrim'])) ? $DashboardCounters['total-external-pilgrim'] : '-') ?></span>
                                                </h6>
                                                <div class="yellow-box text-center mt-2"><a
                                                            href="<?= $path ?>reports/external"
                                                            target="_blank"><?= ((isset($language_translation['external']) && $language_translation['external'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['external'] . '</font>' : '<font class="lang-' . $session['lang'] . '">External</font>') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_total_pax']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 layout-spacing">
                                <div class="widget widget-card-four btb-box p-3">
                                    <div class="widget-content">
                                        <div class="w-content" Id="TotalPilgrim">
                                            <div class="w-info w-100">
                                                <div class="pink-circle float-right"></div>
                                                <h6 class="value">
                                                    <span><?= ((isset($DashboardCounters['total-b2c'])) ? $DashboardCounters['total-b2c'] : '0') + ((isset($DashboardCounters['total-b2b-pilgrim'])) ? $DashboardCounters['total-b2b-pilgrim'] : '0') + ((isset($DashboardCounters['total-external-pilgrim'])) ? $DashboardCounters['total-external-pilgrim'] : '0') ?></span>
                                                </h6>
                                                <div class="pink-box text-center mt-2"><a
                                                            href="<?= $path ?>reports/total_pax"
                                                            target="_blank"><?= ((isset($language_translation['total_pax']) && $language_translation['total_pax'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['total_pax'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Total Pax</font>') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>



            <?php if ($CheckAccess['umrah_reports_status_stats_report_mofa_issued'] || $CheckAccess['umrah_reports_status_stats_report_mofa_not_issued']
            || $CheckAccess['umrah_reports_status_stats_report_visa_issued']) { ?>
            <div class="col-xl-5 col-lg-12 col-md-5">
                <div class="row">
                    <?php if ($CheckAccess['umrah_reports_status_stats_report_mofa_issued']) { ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                            <div class="widget widget-card-four btb-box p-3">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-100">
                                            <div class="lightseagreen-circle float-right"></div>
                                            <h6 class="value"><?= ((isset($DashboardCounters['mofa-issued'])) ? $DashboardCounters['mofa-issued'] : '-') ?></h6>
                                            <div class="lightseagreen-box text-center mt-2"><a
                                                        href="<?= $path ?>reports/mofa_issued"
                                                        target="_blank"><?= ((isset($language_translation['mofa_issued']) && $language_translation['mofa_issued'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['mofa_issued'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Mofa Issued</font>') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($CheckAccess['umrah_reports_status_stats_report_mofa_not_issued']) { ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                            <div class="widget widget-card-four btb-box p-3">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-100">
                                            <div class="orange-circle float-right"></div>
                                            <h6 class="value"><?= ((isset($DashboardCounters['mofa-not-issued'])) ? $DashboardCounters['mofa-not-issued'] : '-') ?></h6>
                                            <div class="orange-box text-center mt-2"><a
                                                        href="<?= $path ?>reports/mofa_not_issued"
                                                        target="_blank"><?= ((isset($language_translation['mofa_not_issued']) && $language_translation['mofa_not_issued'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['mofa_not_issued'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Mofa Not Issued</font>') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6 layout-spacing">
                        <div class="widget widget-card-four btb-box p-3">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info w-100">
                                        <div class="orange-circle float-right"></div>
                                        <h6 class="value"><? /*= ((isset($DashboardCounters['visa-not-printed'])) ? $DashboardCounters['visa-not-printed'] : '-') */ ?></h6>
                                        <div class="orange-box text-center mt-2"><a
                                                    href="<? /*= $path */ ?>reports/visa_not_issue" target="_blank">Visa Not
                                                Issue</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <?php if ($CheckAccess['umrah_reports_status_stats_report_visa_issued']) { ?>
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-card-four btb-box p-3">
                                <div class="widget-content">
                                    <div class="w-content">
                                        <div class="w-info w-100">
                                            <div class="dodgerblue-circle float-right"></div>
                                            <h6 class="value"><?= ((isset($DashboardCounters['visa-issued'])) ? $DashboardCounters['visa-issued'] : '-') ?></h6>
                                            <div class="dodgerblue-box text-center mt-2"><a
                                                        href="<?= $path ?>reports/visa_issue"
                                                        target="_blank"><?= ((isset($language_translation['visa_issued']) && $language_translation['visa_issued'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['visa_issued'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Visa Issued</font>') ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>


        <div class="row analytics">
            <!-- voucher-box  -->
            <?php if ($CheckAccess['umrah_reports_status_stats_report_voucher_not_issued'] || $CheckAccess['umrah_reports_status_stats_report_voucher_issued']
                || $CheckAccess['umrah_reports_status_stats_report_arrival']
                || $CheckAccess['umrah_reports_status_stats_report_check_in_medina']) { ?>
                <div class="col-xl-7 col-lg-12 col-md-7">
                    <div class="row">
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_voucher_not_issued']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/voucher_not_issued" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="VoucherNotIssueChart" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="yellow-box text-center mb-2"><?= ((isset($language_translation['voucher_not_issued']) && $language_translation['voucher_not_issued'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['voucher_not_issued'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Voucher Not Issued</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "VoucherNotIssueChart",
                                          "color": "#dea41f",
                                          "labels": { "A": "Not Issued", "B": "Issued" },
                                          "series": { "A": ' . ($DashboardCounters['travel-voucher-not-issued'] + 0) . ', "B": ' . ($DashboardCounters['travel-voucher-issued'] + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_voucher_issued']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/voucher_issued" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="VoucherIssueChart" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="blue-box text-center mb-2"><?= ((isset($language_translation['voucher_issued']) && $language_translation['voucher_issued'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['voucher_issued'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Voucher Issued</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "VoucherIssueChart",
                                          "color": "#4f6cfd",
                                          "labels": { "A": "Issued", "B": "Not Issued" },
                                          "series": { "A": ' . ($DashboardCounters['travel-voucher-issued'] + 0) . ', "B": ' . ($DashboardCounters['travel-voucher-not-issued'] + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_arrival']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/arrival_airport" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="ArrivalChart" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="green-box text-center mb-2"><?= ((isset($language_translation['arrival']) && $language_translation['arrival'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['arrival'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Arrival</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "ArrivalChart",
                                          "color": "#8ac344",
                                          "labels": { "A": "Jeddah Arrival", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['total-arrival'] + 0) . ', "B": ' . (($DashboardCounters['mofa-issued'] - $DashboardCounters['total-arrival']) + 0) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_check_in_medina']) { ?>
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/check_in_medina" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="ChecKinMedina" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="orange-box text-center mb-2"><?= ((isset($language_translation['check_in_medina']) && $language_translation['check_in_medina'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['check_in_medina'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Check In Medina</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "ChecKinMedina",
                                          "color": "#f77925",
                                          "labels": { "A": "Check In Medina", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-medina'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-medina']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($CheckAccess['umrah_reports_status_stats_report_check_in_mecca']
                || $CheckAccess['umrah_reports_status_stats_report_check_in_jeddah']
                || $CheckAccess['umrah_reports_status_stats_report_exit']) { ?>

                <div class="col-xl-5 col-lg-12 col-md-5">
                    <div class="row">
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_check_in_mecca']) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/check_in_mecca" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="CheckInMakkah" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="blue-box text-center mb-2"><?= ((isset($language_translation['check_in_mecca']) && $language_translation['check_in_mecca'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['check_in_mecca'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Check In Mecca</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "CheckInMakkah",
                                          "color": "#4f6cfd",
                                          "labels": { "A": "Check In Mecca", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-mecca'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-mecca']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_check_in_jeddah']) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/check_in_jeddah" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="CheckInJeddah" class=""
                                                             style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="lightseagreen-box text-center mb-2"><?= ((isset($language_translation['check_in_jeddah']) && $language_translation['check_in_jeddah'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['check_in_jeddah'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Check In Jeddah</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "CheckInJeddah",
                                          "color": "#49b0a4",
                                          "labels": { "A": "Check In Jeddah", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['check-in-jeddah'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['check-in-jeddah']) . ' }
                                        };
                                        LoadDashboardStatChart(htmldata);'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($CheckAccess['umrah_reports_status_stats_report_exit']) { ?>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 layout-spacing">
                                <div class="widget widget-card-four voucher-box p-2">
                                    <div class="widget-content">
                                        <div class="w-content">
                                            <div class="w-info">
                                                <a href="<?= $path ?>reports/pilgrim_exit" target="_blank">
                                                    <div class="widget-content for-bottom-mrg">
                                                        <div id="Exit" class="" style="min-height: 220px;"></div>
                                                    </div>
                                                </a>
                                                <div class="pink-box text-center mb-2"><?= ((isset($language_translation['exit']) && $language_translation['exit'] != '') ? '<font class="lang-' . $session['lang'] . '">' . $language_translation['exit'] . '</font>' : '<font class="lang-' . $session['lang'] . '">Exit</font>') ?></div>
                                                <?php
                                                $PAGEJS .= '
                                        htmldata = {
                                          "divid": "Exit",
                                          "color": "#e2525d",
                                          "labels": { "A": "Exit From KSA", "B": "Remaining Pilgrim" },
                                          "series": { "A": ' . ($DashboardCounters['total-exit'] + 0) . ', "B": ' . ($DashboardCounters['mofa-issued'] - $DashboardCounters['total-exit']) . ' }
                                        };                                       
                                        LoadDashboardStatChart(htmldata); '; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>

        <?php if ($CheckAccess['umrah_reports_status_stats_report_pax_in_mecca'] || $CheckAccess['umrah_reports_status_stats_report_pax_in_medina']
            || $CheckAccess['umrah_reports_status_stats_report_pax_in_jeddah']
            || $CheckAccess['umrah_reports_status_stats_report_pax_in_saudiarabia']) { ?>
            <div class="row analytics">

                <!-- voucher-box  -->

                <?php if ($CheckAccess['umrah_reports_status_stats_report_pax_in_mecca']) { ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <div class="lightseagreen-circle"></div>
                                        <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-mecca'])) ? $DashboardCounters['pax-in-mecca'] : '-') ?></h6>
                                        <div class="w-summary-details">
                                            <div class="w-summary-stats">
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                                         style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_mecca"
                                                                              target="_blank" style="color: #888ea8">Pax
                                                in
                                                Mecca</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_status_stats_report_pax_in_medina']) { ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <div class="yellow-circle"></div>
                                        <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-medina'])) ? $DashboardCounters['pax-in-medina'] : '-') ?></h6>
                                        <div class="w-summary-details">
                                            <div class="w-summary-stats">
                                                <div class="progress for-yellow-bar">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                                         style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_medina"
                                                                              target="_blank" style="color: #888ea8">Pax
                                                in
                                                Medinah</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_status_stats_report_pax_in_jeddah']) { ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <div class="blue-circle"></div>
                                        <h6 class="value text-center mt-4"><?= ((isset($DashboardCounters['pax-in-jeddah'])) ? $DashboardCounters['pax-in-jeddah'] : '-') ?></h6>
                                        <div class="w-summary-details">
                                            <div class="w-summary-stats">
                                                <div class="progress for-blue-bar">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                                         style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-4"><a href="<?= $path ?>reports/pax_in_jeddah"
                                                                              target="_blank" style="color: #888ea8">Pax
                                                in
                                                Jeddah</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($CheckAccess['umrah_reports_status_stats_report_pax_in_saudiarabia']) { ?>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                        <div class="widget widget-card-four voucher-box p-2">
                            <div class="widget-content">
                                <div class="w-content">
                                    <div class="w-info">
                                        <div class="orange-circle"></div>
                                        <h6 class="value text-center mt-4"><?php
                                            $Total = ((isset($DashboardCounters['pax-in-mecca'])) ? $DashboardCounters['pax-in-mecca'] : '0') + ((isset($DashboardCounters['pax-in-jeddah'])) ? $DashboardCounters['pax-in-jeddah'] : '0') + ((isset($DashboardCounters['pax-in-medina'])) ? $DashboardCounters['pax-in-medina'] : '0');
                                            ?>
                                            <?= ((isset($Total)) ? $Total : '-') ?></h6>
                                        <div class="w-summary-details">
                                            <div class="w-summary-stats">
                                                <div class="progress for-orange-bar">
                                                    <div class="progress-bar bg-gradient-success" role="progressbar"
                                                         style="width: 65%" aria-valuenow="65" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center mt-2 mb-4"><a
                                                    href="<?= $path ?>reports/pax_in_saudi_arabia"
                                                    target="_blank" style="color: #888ea8">Total
                                                Pax
                                                in Saudi Arabia</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- allow-box  -->
            </div>
        <?php } ?>
        <div class="row analytics">
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_tpt_arrival']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a href="<?= $path ?>reports/allow_tpt_arrival"
                                                                          style="color: #DDA420"
                                                                          target="_blank"><?= ((isset($DashboardCounters['allow-tpt-arrival'])) ? $DashboardCounters['allow-tpt-arrival'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="pink-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_tpt_arrival"
                                                                 target="_blank"
                                                    >Allow TPT Arrival</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-tpt-arrival'])) ? $DashboardCounters['completed-allow-tpt-arrival'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_htl_mecca']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a href="<?= $path ?>reports/arrival_htl_mecca"
                                                                          style="color: #DDA420"
                                                                          target="_blank"><?= ((isset($DashboardCounters['allow-htl-mecca'])) ? $DashboardCounters['allow-htl-mecca'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="green-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_htl_mecca"
                                                                 target="_blank">Allow HTL Mecca</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-htl-mecca'])) ? $DashboardCounters['completed-allow-htl-mecca'] : '-') ?></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_tpt_mecca_chk_out']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/allow_transport_mecca"
                                                style="color: #DDA420"
                                                target="_blank"><?= ((isset($DashboardCounters['allow-tpt-mecca'])) ? $DashboardCounters['allow-tpt-mecca'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="lightseagreen-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_tpt_mecca"
                                                                 target="_blank">Allow TPT Mecca(Chk/Out)</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-tpt-mecca'])) ? $DashboardCounters['completed-allow-tpt-mecca'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_htl_medina']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a href="<?= $path ?>reports/arrival_htl_medina"
                                                                          style="color: #DDA420"
                                                                          target="_blank"><?= ((isset($DashboardCounters['allow-htl-medina'])) ? $DashboardCounters['allow-htl-medina'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="dodgerblue-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_htl_medina"
                                                                 target="_blank">Allow HTL Medina</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-htl-medina'])) ? $DashboardCounters['completed-allow-htl-medina'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_tpt_medina_chk_out']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/allow_transport_medina" style="color: #DDA420"
                                                target="_blank"><?= ((isset($DashboardCounters['allow-tpt-medina'])) ? $DashboardCounters['allow-tpt-medina'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="yellow-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_tpt_medina"
                                                                 target="_blank">Allow TPT Medina(Chk/Out)</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-tpt-medina'])) ? $DashboardCounters['completed-allow-tpt-medina'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_htl_jeddah']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a href="<?= $path ?>reports/arrival_htl_jeddah"
                                                                          style="color: #DDA420"
                                                                          target="_blank"><?= ((isset($DashboardCounters['allow-htl-jeddah'])) ? $DashboardCounters['allow-htl-jeddah'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="blue-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_htl_jeddah"
                                                                 target="_blank">Allow HTL Jeddah</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-htl-jeddah'])) ? $DashboardCounters['completed-allow-htl-jeddah'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <!-- allow-box2  -->

            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_tpt_jeddah_chk_out']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/allow_transport_jeddah"
                                                style="color: #DDA420"
                                                target="_blank"><?= ((isset($DashboardCounters['allow-tpt-jeddah'])) ? $DashboardCounters['allow-tpt-jeddah'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="orange-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_allow_tpt_jeddah"
                                                                 target="_blank">Allow
                                                        TPT Jeddah(Chk/Out)</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-tpt-jeddah'])) ? $DashboardCounters['completed-allow-tpt-jeddah'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_allow_tpt_departure']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/allow_transport_departure"
                                                style="color: #DDA420"
                                                target="_blank"><?= ((isset($DashboardCounters['allow-tpt-departure'])) ? $DashboardCounters['allow-tpt-departure'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="blue-box text-center mt-5 p-1">
                                                <div class=""><a
                                                            href="<?= $path ?>reports/completed_allow_tpt_departure"
                                                            target="_blank">Allow
                                                        TPT Departure</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-tpt-departure'])) ? $DashboardCounters['completed-allow-tpt-departure'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_free_bed']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/free_bed_counter_report"
                                                style="color: #DDA420" target="_blank">
                                            <?= ((isset($DashboardCounters['allow-bed'])) ? $DashboardCounters['allow-bed'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="pink-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/allow_bed" target="_blank">Free
                                                        Bed</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-allow-bed'])) ? $DashboardCounters['completed-allow-bed'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_ppt_management']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a href="<?= $path ?>reports/ppt_management"
                                                                          style="color: #DDA420" target="_blank">
                                            <?= ((isset($DashboardCounters['ppt-management'])) ? $DashboardCounters['ppt-management'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="green-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/completed_ppt_management"
                                                                 target="_blank">PPT
                                                        Management</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['completed-ppt-management'])) ? $DashboardCounters['completed-ppt-management'] : '-') ?></a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_without_vchr_arrival']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/without_arrival_voucher"
                                                style="color: #DDA420"
                                                target="_blank">
                                            <?= ((isset($DashboardCounters['without-vchr-arrival'])) ? $DashboardCounters['without-vchr-arrival'] : '-') ?>
                                        </a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="yellow-box text-center mt-5 p-1">
                                                <div class=""><a
                                                            href="<?= $path ?>reports/completed_without_voucher_arrival"
                                                            target="_blank">Without VCHR Arrival</a></div>
                                                <div class="">  <?= ((isset($DashboardCounters['completed-without-vchr-arrival'])) ? $DashboardCounters['completed-without-vchr-arrival'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_over_25_days_arrival']) { ?>
                <div class="col-xl-2 col-lg-2 layout-spacing">
                    <div class="widget widget-card-four allow-box-2 p-2">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info">
                                    <div class="orange-circle"></div>
                                    <h6 class="value text-center mt-4"><a
                                                href="<?= $path ?>reports/Over25DaysArrival"
                                                style="color: #DDA420"
                                                target="_blank">
                                            <?= ((isset($DashboardCounters['over-25-days-arrival'])) ? $DashboardCounters['over-25-days-arrival'] : '-') ?></a>
                                    </h6>
                                    <div class="w-summary-details">
                                        <div class="w-summary-stats">
                                            <div class="lightseagreen-box text-center mt-5 p-1">
                                                <div class=""><a href="<?= $path ?>reports/Over25DaysArrivalCompleted"
                                                                 target="_blank">Over
                                                        25 Days Arrival</a></div>
                                                <div class=""><?= ((isset($DashboardCounters['complete-in-over-25-days-arrival'])) ? $DashboardCounters['complete-in-over-25-days-arrival'] : '-') ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row analytics">
            <!-- hotels  -->
            <?php if ($CheckAccess['umrah_reports_status_stats_report_hotel_brn_chart']) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4 layout-spacing">
                    <div class="widget widget-card-four hotel-box brn-box p-3 ">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100 pt-1">
                                    <div class="lightseagreen-circle float-right"></div>
                                    <div class="amount pt-2">Hotel BRN</div>
                                    <div class="row mt-3">
                                        <div class="col-lg-3 col-3 bor-right">
                                            <div class="star"><?= ((isset($DashboardCounters['purchase-hotel'])) ? $DashboardCounters['purchase-hotel'] : '-') ?></div>
                                            <div class="details bor-none">Purchase</div>
                                        </div>
                                        <div class="col-lg-3 col-3 bor-right">
                                            <div class="star"><?= ((isset($DashboardCounters['hotel-brn-used'])) ? $DashboardCounters['hotel-brn-used'] : '-') ?></div>
                                            <div class="details bor-none">Used</div>
                                        </div>
                                        <div class="col-lg-3 col-3 bor-right">
                                            <div class="star"><?= ((isset($DashboardCounters['purchase-hotel']) && isset($DashboardCounters['hotel-brn-used'])) ? $DashboardCounters['purchase-hotel'] - $DashboardCounters['hotel-brn-used'] : '-') ?></div>
                                            <div class="details bor-none">Balance</div>
                                        </div>
                                        <div class="col-lg-3 col-3">
                                            <div class="star"><?= ((isset($DashboardCounters['hotel-brn-expired'])) ? $DashboardCounters['hotel-brn-expired'] : '-') ?></div>
                                            <div class="details bor-none">Expired</div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 col-6 bor-right">
                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <div class="star"><?= ((isset($DashboardCounters['hotel-brn-actual-room'])) ? $DashboardCounters['hotel-brn-actual-room'] : '-') ?></div>
                                                    <div class="details bor-none">Actual Rooms</div>
                                                </div>
                                                <div class="col-lg-6 col-6">
                                                    <div class="star"><?= ((isset($DashboardCounters['hotel-brn-actual-beds'])) ? $DashboardCounters['hotel-brn-actual-beds'] : '-') ?></div>
                                                    <div class="details bor-none">Actual Beds</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-6">
                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <div class="star"><?= ((isset($DashboardCounters['hotel-brn-balance-room'])) ? $DashboardCounters['hotel-brn-actual-room'] - $DashboardCounters['hotel-brn-balance-room'] : '-') ?></div>
                                                    <div class="details bor-none">Balance Rooms</div>
                                                </div>
                                                <div class="col-lg-6 col-6">
                                                    <div class="star"><?= ((isset($DashboardCounters['hotel-brn-balance-bed'])) ? $DashboardCounters['hotel-brn-actual-beds'] - $DashboardCounters['hotel-brn-balance-bed'] : '-') ?></div>
                                                    <div class="details bor-none">Balance Beds</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_transport_brn_chart']) { ?>
                <div class="col-xl-8 col-lg-8 col-md-8 layout-spacing">
                    <div class="widget widget-card-four hotel-box brn-box p-3 ">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100 pt-1">
                                    <div class="pink-circle float-right"></div>
                                    <div class="amount pt-2">Transport BRN</div>
                                    <div class="row">
                                        <div class="col-lg-2 col-2 bor-right mt-3">
                                            <div class="star"><?= ((isset($DashboardCounters['purchase-transport'])) ? $DashboardCounters['purchase-transport'] : '-') ?></div>
                                            <div class="details bor-none">Purchase</div>
                                        </div>
                                        <div class="col-lg-2 col-2 bor-right mt-3">
                                            <div class="star"><?= ((isset($DashboardCounters['transport-brn-used'])) ? $DashboardCounters['transport-brn-used'] : '-') ?></div>
                                            <div class="details bor-none">Used</div>
                                        </div>
                                        <div class="col-lg-2 col-2 bor-right mt-3">
                                            <div class="star"><?= ((isset($DashboardCounters['purchase-transport']) && isset($DashboardCounters['transport-brn-used'])) ? $DashboardCounters['purchase-transport'] - $DashboardCounters['transport-brn-used'] : '-') ?></div>
                                            <div class="details bor-none">Balance</div>
                                        </div>
                                        <div class="col-lg-2 col-2 bor-right mt-3">
                                            <div class="star"><?= ((isset($DashboardCounters['transport-brn-expired'])) ? $DashboardCounters['transport-brn-expired'] : '-') ?></div>
                                            <div class="details bor-none">Expired</div>
                                        </div>
                                        <div class="col-lg-2 col-2 mt-3">
                                            <div class="star"><?= ((isset($DashboardCounters['transport-brn-visa-used'])) ? $DashboardCounters['transport-brn-visa-used'] : '-') ?></div>
                                            <div class="details bor-none">Visa Used</div>
                                        </div>
                                        <?php
                                        $LookupsOptions = $Crud->LookupOptions('transport_sectors');
                                        foreach ($LookupsOptions as $options) {
                                            echo '<div class="col-lg-2 col-2 bor-right mt-3">
                                        <div class="star">' . ((isset($DashboardCounters['transport-brn-sector-' . $options['UID'] . ' '])) ? $DashboardCounters['transport-brn-sector-' . $options['UID'] . ' '] : '-') . '</div>
                                        <div class="details bor-none">' . $options['Name'] . '</div>
                                              </div>';
                                        } ?>

                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Jed - Mad</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">5</div>-->
                                        <!--                                        <div class="details bor-none">Jed - Mak</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Mad - Mad</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Mad - Mak</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Mak - Mad</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Mak - Jed</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 bor-right mt-3">-->
                                        <!--                                        <div class="star">3</div>-->
                                        <!--                                        <div class="details bor-none">Mad - Jed</div>-->
                                        <!--                                    </div>-->
                                        <!--                                    <div class="col-lg-2 col-2 mt-3">-->
                                        <!--                                        <div class="star">84</div>-->
                                        <!--                                        <div class="details bor-none">Loss Seat</div>-->
                                        <!--                                    </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($CheckAccess['umrah_reports_status_stats_report_only_hotels_chart']) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4 layout-spacing">
                    <div class="widget widget-card-four hotel-box p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100 pt-1" id="HotelStats">
                                    <div class="lightseagreen-circle float-right"></div>
                                    <div class="amount pt-2">Only Hotels</div>
                                    <div id="LoadHotelsStat">
                                        <?php
                                        if (!empty($OnlyHotels)) {
                                            $FinalArray = array();
                                            foreach ($OnlyHotels as $OnlyHotelsRecords) {

                                                $FinalArray[$OnlyHotelsRecords['Category']]['Name'] = $OnlyHotelsRecords['Name'];

                                                if (isset($FinalArray[$OnlyHotelsRecords['Category']]['NoofNights']))
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['NoofNights'] += $OnlyHotelsRecords['NoofNights'];
                                                else
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['NoofNights'] = $OnlyHotelsRecords['NoofNights'];

                                                if (isset($FinalArray[$OnlyHotelsRecords['Category']]['MetaPEX']))
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['MetaPEX'] += $OnlyHotelsRecords['MetaPEX'];
                                                else
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['MetaPEX'] = $OnlyHotelsRecords['MetaPEX'];

                                                if (isset($FinalArray[$OnlyHotelsRecords['Category']]['MetaRoom']))
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['MetaRoom'] += $OnlyHotelsRecords['MetaRoom'];
                                                else
                                                    $FinalArray[$OnlyHotelsRecords['Category']]['MetaRoom'] = $OnlyHotelsRecords['MetaRoom'];
                                            }


                                            if (count($FinalArray) > 0) {
                                                $keys = array_column($FinalArray, 'MetaPEX');

                                                array_multisort($keys, SORT_DESC, $FinalArray);
                                                foreach ($FinalArray as $FinalArr) {
                                                    if ($FinalArr['MetaPEX'] > 0) {
                                                        echo '
                                                <div class="star mt-3">' . $FinalArr['Name'] . ' 
                                                <span>' . $FinalArr['MetaPEX'] . ' <small>PAX</small></span> </div>
                                                <div class="details pb-2">' . $FinalArr['MetaRoom'] . ' Rooms, ' . $FinalArr['NoofNights'] . ' Nights</div>';
                                                    }

                                                }
                                            }
                                        } else {
                                            ?>
                                            <div class="star mt-3" align="center"><img
                                                        src="<?php echo $template ?>no-record.png" width="60%"></div>
                                            <?php
                                        } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php if ($CheckAccess['umrah_reports_status_stats_report_only_transport_chart']) { ?>
                <div class="col-lg-4 col-md-4 layout-spacing">
                    <div class="widget widget-card-four hotel-box p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100 pt-1">
                                    <div class="pink-circle float-right"></div>
                                    <div class="amount pt-2">Only Transport</div>
                                    <div style="overflow: auto; height: 360px;">
                                        <?php
                                        if (!empty($OnlyTransport)) {
                                            foreach ($OnlyTransport as $OnlyTransportRecords) {
//

                                                echo '<div class="star mt-3">' . $OnlyTransportRecords['Name'] . '  <span>' . $OnlyTransportRecords['TotalTransport'] . '</span></div>
                                      <div class="details pb-2"> ' . $OnlyTransportRecords['NoOfSeats'] . ' Seats, ' . $OnlyTransportRecords['NoOfPax'] . ' Pax </div>';
                                            }
                                        } else {
                                            ?>
                                            <div class="star mt-3" align="center"><img
                                                        src="<?php echo $template ?>no-record.png" width="60%"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats_report_services_chart']) { ?>
                <div class="col-lg-4 col-md-4 layout-spacing">
                    <div class="widget widget-card-four hotel-box p-3">
                        <div class="widget-content">
                            <div class="w-content">
                                <div class="w-info w-100 pt-1">
                                    <div class="yellow-circle float-right"></div>
                                    <div class="amount pt-2">Services</div>
                                    <div class="star mt-3 pt-1">Package
                                        <span><?php echo $OnlyExtras[0][0]['Package'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">Visa & Transport
                                        <span><?php echo $OnlyExtras[1][0]['Visa_and_Transport'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">Visa & Hotel
                                        <span><?php echo $OnlyExtras[2][0]['Visa_and_Hotel'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">Only
                                        Visa<span><?php echo $OnlyExtras[3][0]['OnlyVisa'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">
                                        Hotel<span><?php echo $OnlyExtras[4][0]['OnlyHotel'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">
                                        Transport<span><?php echo $OnlyExtras[5][0]['OnlyTransport'] + 0; ?></span>
                                    </div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">
                                        Services<span><?php echo $OnlyExtras[6][0]['OnlyServices'] + 0; ?></span></div>
                                    <div class="details pb-4"></div>
                                    <div class="star mt-3 pt-1">Total
                                        PAX<span><?php echo $OnlyExtras[0][0]['Package'] + $OnlyExtras[1][0]['Visa_and_Transport'] + $OnlyExtras[2][0]['Visa_and_Hotel'] + $OnlyExtras[3][0]['OnlyVisa'] + $OnlyExtras[4][0]['OnlyHotel'] + $OnlyExtras[5][0]['OnlyTransport'] + $OnlyExtras[6][0]['OnlyServices'] + 0; ?></span>
                                    </div>

                                    <!--                                <div class="star mt-3 pt-1">PAX without Hotel-->
                                    <!--                                    <span>-->
                                    <?php //echo NUMBER($OnlyExtras[0][0]['PaxWithoutHotel'] + 0); ?><!--</span></div>-->
                                    <!--                                <div class="details pb-4"></div>-->
                                    <!--                                <div class="star mt-3 pt-1">PAX without Hotel-->
                                    <!--                                    <span>-->
                                    <?php //echo NUMBER($OnlyExtras[0][0]['PaxWithoutHotel'] + 0); ?><!--</span></div>-->
                                    <!--                                <div class="details pb-3"></div>-->
                                    <!--                                <div class="star mt-3 pt-1">PAX without Transport-->
                                    <!--                                    <span>-->
                                    <?php //echo NUMBER($OnlyExtras[1][0]['PaxWithoutTransport'] + 0); ?><!--</span>-->
                                    <!--                                </div>-->
                                    <!--                                <div class="details pb-3"></div>-->
                                    <!--                                <div class="star mt-3 pt-1">Only Visa-->
                                    <!--                                    <span>-->
                                    <?php //echo NUMBER($OnlyExtras[2][0]['OnlyVisa'] + 0); ?><!--</span></div>-->
                                    <!--                                <div class="details pb-3"></div>-->
                                    <!--                                <div class="star mt-3 pt-1">Total PAX-->
                                    <!--                                    <span>-</span></div>-->
                                    <!--                                <div class="details pb-3"></div>-->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>
</div>

<script src="<?= $template ?>plugins/apex/apexcharts.min.js"></script>

<script type="text/javascript">

    //function LoadReportsFunc(page) {
    //    window.open('<?//= $path ?>//reports/'+page, '_blank');
    //}
    function LoadHotelsStat() {
        result = AjaxResponse("dashboard_ajax/hotel_stats");

        $("#HotelStats #Load5StarHotelsStat").html(result.five_star);
        $("#HotelStats #Load4StarHotelsStat").html(result.four_star);
        $("#HotelStats #Load3StarHotelsStat").html(result.three_star);
        $("#HotelStats #Load2StarHotelsStat").html(result.two_star);
        $("#HotelStats #Load1StarHotelsStat").html(result.one_star);
        $("#HotelStats #LoadEconomyHotelsStat").html(result.economy);

    }

    // function LoadCounts() {
    //     Counts = AjaxResponse("dashboard_ajax/all_counts");
    //     $("#B2cCount #B2C").html(Counts.b2c);
    //     $("#B2bCount #B2B").html(Counts.b2b);
    //     $("#ExternalAgents #External").html(Counts.external_agents);
    //     $("#TotalPilgrim #TotalPax").html(Counts.TotalPax);
    //
    // }

    function LoadDashboardStatChart(htmldata) {
        var chartDataOptions = {
            chart: {
                type: 'donut',
                width: '100%',
                height: '200px'
            },
            colors: [htmldata.color, htmldata.color],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '12px',
                markers: {
                    width: 10,
                    height: 10,
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 8
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '80%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '100%',
                                fontFamily: 'Nunito, sans-serif',
                                color: undefined,
                                offsetY: -10
                            },
                            value: {
                                show: true,
                                fontSize: '100%',
                                fontFamily: 'Nunito, sans-serif',
                                color: '#bfc9d4',
                                offsetY: 16,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: htmldata.series.A,
                                color: '#000000',
                                width: '30px',
                                height: '30px',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce(function (a, b) {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            },
            stroke: {
                show: true,
                width: 10
            },
            series: [htmldata.series.A, htmldata.series.B],
            labels: [htmldata.labels.A, htmldata.labels.B],
            responsive: [{
                breakpoint: 1599,
                options: {
                    chart: {
                        width: '150%',
                        height: '200px'
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }, {

                breakpoint: 1439,
                options: {
                    chart: {
                        width: '120%',
                        height: '220px'
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                            }
                        }
                    }
                }
            }]
        }
        var chartOne = new ApexCharts(
            document.querySelector("#" + htmldata.divid),
            chartDataOptions
        );

        chartOne.render();
    }

    setTimeout(function () {
        LoadHotelsStat();
        // LoadCounts();
        <?=$PAGEJS?>
    }, 1000)
</script>
