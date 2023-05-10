<?php
$REPORTS = array();


?>
<style>
    .widget-table-one {
        margin-bottom: 20px !important;
    }
</style>

<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>System Reports</h3>
            </div>
        </div>
        <div class="row sales">
            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">Groups / Pilgrims</h5>
                    </div>

                    <div class="widget-content">
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Manage Pilgrim List</h4>
                                        <p class="meta-date">You can see pilgrim list in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/pilgrim_list" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Pilgrim Count</h4>
                                        <p class="meta-date">You can see pilgrim count in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/pilgrim_count" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Group Stats</h4>
                                        <p class="meta-date">You can see group stats in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Report Creator</h4>
                                        <p class="meta-date">You can see report creator in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">Statistics</h5>
                    </div>
                    <div class="widget-content">
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Status Summary Report</h4>
                                        <p class="meta-date">You can see status summary in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/summary_report" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Agent Monitor Screen Report Layout Same As WTU</h4>
                                        <p class="meta-date">You can see agent monitor screen in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>External Agent Monitor Screen Layout Same As WTU</h4>
                                        <p class="meta-date">You can see external agent monitor screen in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Arrival Summary Layout Same As WTU</h4>
                                        <p class="meta-date">You can see arrival summary in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="#" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-table-one">
                    <div class="widget-heading">
                        <h5 class="">Passport Information Reports</h5>
                    </div>
                    <div class="widget-content">
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Passport Information Report</h4>
                                        <p class="meta-date">You can see Passport Information stats in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/elm_report"  target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Passport Information Data Summary DayWise</h4>
                                        <p class="meta-date">You can see Passport Information data summary in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/elm_report" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                        <div class="transactions-list">
                            <div class="t-item">
                                <div class="t-company-name">
                                    <div class="t-name">
                                        <h4>Agent Work Report Layout same as WTU</h4>
                                        <p class="meta-date">You can see agent work report in this report</p>
                                    </div>
                                </div>
                                <div class="t-rate rate-dec">
                                    <a href="<?=$path?>reports/elm_report" target="_blank" class="btn btn-sm btn-outline-success">Click Here</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!--  END CONTENT AREA  -->