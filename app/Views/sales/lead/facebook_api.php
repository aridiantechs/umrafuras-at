<h4 class="page-head"></h4>
<!--  BEGIN CONTENT AREA  -->
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <h4 class="page-head">Facebook Api Data

                </h4>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                <form class="section contact" id="AgentSearchFilter">
                    <div id="toggleAccordion">
                        <div class="card">
                            <div class="card-header">
                                <section class="mb-0 mt-0">
                                    <div role="menu" class="" data-toggle="collapse"
                                         data-target="#FilterDetails" aria-expanded="true"
                                         aria-controls="FilterDetails">
                                        Filters
                                    </div>
                                </section>
                            </div>
                            <div id="FilterDetails" class="collapse show " aria-labelledby=""
                                 data-parent="#toggleAccordion">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mx-auto">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="country">From To</label>
                                                        <input type="text"
                                                               class="form-control multidate validate[required,future[now]]"
                                                               name="FromTo" id="FromTo" readonly
                                                               placeholder="" value="">
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="Products">Products </label>
                                                        <select class="form-control validate[required]" id="Products"
                                                                name="Products">
                                                            <option value="" selected disabled> Select Projects</option>
                                                            <?php foreach ($Products as $value) {
                                                                if ($value == 'home' || $value == 'sales') {
                                                                } else {
                                                                    ?>
                                                                    <option value="<?= $value ?>"> <?= ucwords($value) ?></option>
                                                                <?php }
                                                            } ?>

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group mb-3">
                                                        <label for="Products">Agents </label>
                                                        <select class="form-control validate[required]" id="Products"
                                                                name="Products">
                                                            <option value="" selected disabled> Select Projects</option>
                                                            <option value="">Hamza</option>
                                                            <option value="">Ali</option>
                                                            <option value="">Toqeer</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12" id="FilterButtons">
                                                    <div class="form-group float-right">
                                                        <button onclick=""
                                                                class="btn btn-success">Display Records
                                                        </button>
                                                        <button onclick=""
                                                                class="btn btn-danger">Clear Filter
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <button type="button" onclick="LoadModal('sales/lead/facebookapiform', 0,'modal-md')"
                            class="btn btn-lg btn-primary btn-success float-right mb-2" >Facebook Forms
                    </button>

                    <div class="table-responsive mb-4 mt-4">
                        <table id="ReportTable" class="table table-hover non-hover display nowrap" style="width:100%">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>System Lead ID</th>
                                <th>Agent Name</th>
                                <th>Facebook Lead ID</th>
                                <th>Form Name</th>
                                <th>Created Date</th>
                                <th>Full Name</th>
                                <th>Phone No</th>
                                <th>Email</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">


    $('#ReportTable').DataTable({
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
        "lengthMenu": [[100, 500, 1000, -1], [100, 500, 1000, "All"]],
        "pageLength": 100
    });

    setTimeout(function () {
        $('<a href="#" target="_blank" class="btn btn_customized  btn-sm float-right">Export Record</a>').appendTo(".table-responsive");
    }, 100);

</script>
