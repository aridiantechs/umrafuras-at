<?php

use App\Models\Crud;

$Crud = new Crud(); ?>
<?php if ($CheckAccess['home_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Dashboard</span>
            </div>
        </a>
    </li>

<?php } ?>

<?php if ($CheckAccess['home_client'] || $CheckAccess['home_client_b2c'] || $CheckAccess['home_client_b2b']
    || $CheckAccess['home_client_sale_agents']
    || $CheckAccess['home_client_external_agent']
) { ?>
    <li class="menu <?= (($module == 'agent' && $page == 'index') ? 'active' : '') ?>">
        <a href="#agents" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-users">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Client</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="agents" data-parent="#accordionExample">
            <?php if ($CheckAccess['home_client_b2c']) { ?>
                <li>
                    <a href="<?= $path ?>agent/B2C">B2C</a>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['home_client_b2b']) { ?>
                <li <?= (($module == "agent" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>agent/index">B2B </a>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['home_client_sale_agents']) { ?>
                <li>
                    <a href="<?= $path ?>sale_agents/index">Sale Agent</a>
                </li>
            <?php } ?>

            <?php if ($CheckAccess['home_client_external_agent'] || $CheckAccess['home_client_external_agent_list'] || $CheckAccess['home_client_external_agent_sub_agents']) { ?>
                <li>
                    <a href="#groups-error" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> External Agents
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="groups-error" data-parent="#groups">
                        <?php if ($CheckAccess['home_client_external_agent_list']) { ?>
                            <li <?= (($module == "user" && $page == "external_agent") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>user/external_agent">List</a>
                            </li>
                        <?php } ?>
                        <?php if ($CheckAccess['home_client_external_agent_sub_agents']) { ?>
                            <li <?= (($module == "agent" && $page == "sub_agents") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>agent/sub_agents">Sub Agents </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </li>
<?php } ?>


<?php if ($CheckAccess['home_booking'] || $CheckAccess['home_booking_all'] || $CheckAccess['home_booking_pending']
    || $CheckAccess['home_booking_confirm']
    || $CheckAccess['home_booking_expire']
    || $CheckAccess['home_booking_cancel']
) { ?>
    <li class="menu">
        <a href="#Booking" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Booking</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="Booking" data-parent="#accordionExample">
            <?php if ($CheckAccess['home_booking_all']) { ?>
                <li><a href="<?= $path ?>home/bookings">All</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_booking_pending']) { ?>
                <li><a href="<?= $path ?>home/pending_booking">Pending</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_booking_confirm']) { ?>
                <li><a href="<?= $path ?>home/confirm_booking">Confirm</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_booking_expire']) { ?>
                <li><a href="<?= $path ?>home/expire_booking">Expire</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_booking_cancel']) { ?>
                <li><a href="<?= $path ?>home/cancel_booking">Cancel</a></li>
            <?php } ?>
        </ul>
    </li>

<?php } ?>

<?php if ($CheckAccess['home_sale_reports'] || $CheckAccess['home_sale_reports_umrah'] || $CheckAccess['home_sale_reports_ticket']
    || $CheckAccess['home_sale_reports_hotel']
    || $CheckAccess['home_sale_reports_visa']
    || $CheckAccess['home_sale_reports_transport']
    || $CheckAccess['home_sale_reports_tour']
    || $CheckAccess['home_sale_reports_visitor']
) { ?>
    <li class="menu">
        <a href="#SaleReports" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Sale Reports</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="SaleReports" data-parent="#accordionExample">
            <?php if ($CheckAccess['home_sale_reports_umrah']) { ?>
                <li><a href="<?= $path ?>reports/sale_umrah">Umrah</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_ticket']) { ?>
                <li><a href="<?= $path ?>reports/sale_ticket">Ticket</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_hotel']) { ?>
                <li><a href="<?= $path ?>reports/sale_hotel">Hotel</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_visa']) { ?>
                <li><a href="<?= $path ?>reports/sale_visa">Visa</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_transport']) { ?>
                <li><a href="<?= $path ?>reports/sale_transport">Transport</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_tour']) { ?>
                <li><a href="<?= $path ?>reports/sale_tours">Tours</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_sale_reports_visitor']) { ?>
                <li><a href="<?= $path ?>reports/sale_visitors">Visitors</a></li>
            <?php } ?>
        </ul>
    </li>

<?php } ?>

<?php if ($CheckAccess['home_purchase_reports'] || $CheckAccess['home_purchase_reports_umrah'] || $CheckAccess['home_purchase_reports_ticket']
    || $CheckAccess['home_purchase_reports_hotel']
    || $CheckAccess['home_purchase_reports_visa']
    || $CheckAccess['home_purchase_reports_transport']
    || $CheckAccess['home_purchase_reports_tour']
    || $CheckAccess['home_purchase_reports_visitor']
) { ?>

    <li class="menu">
        <a href="#PurchaseReports" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Purchase Reports</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="PurchaseReports" data-parent="#accordionExample">
            <?php if ($CheckAccess['home_purchase_reports_umrah']) { ?>
                <li><a href="<?= $path ?>reports/purchase_umrah">Umrah</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_purchase_reports_ticket']) { ?>
                <li><a href="<?= $path ?>reports/purchase_ticket">Ticket</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_purchase_reports_hotel']) { ?>
                <li><a href="<?= $path ?>reports/purchase_hotel">Hotel</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_purchase_reports_visa']) { ?>
                <li><a href="<?= $path ?>reports/purchase_visa">Visa</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_purchase_reports_transport']) { ?>
                <li><a href="<?= $path ?>reports/purchase_transport">Transport</a></li>
            <?php } ?>
            <?php if ($CheckAccess['home_purchase_reports_tour']) { ?>
                <li><a href="<?= $path ?>reports/purchase_tours">Tours</a></li>
            <?php } ?>

        </ul>
    </li>

<?php } ?>

<?php
if ($CheckAccess['home_services'] || $CheckAccess['home_services_hotel'] || $CheckAccess['home_services_transport']
    || $CheckAccess['home_services_ziyarat'] || $CheckAccess['home_services_packages']
    || $CheckAccess['home_services_visa_type']
    || $CheckAccess['home_services_extra_services']
    || $CheckAccess['home_services_operator']
) {
    ?>
    <li class="menu">
        <a href="#package" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                <span>Services</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="package" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['home_services_hotel'] || $CheckAccess['home_services_hotel_list'] || $CheckAccess['home_services_hotel_categories'] || $CheckAccess['home_services_hotel_facilities'] || $CheckAccess['home_services_hotel_amenities'] || $CheckAccess['home_services_hotel_room_types']) { ?>
                <li>
                    <a href="#hotel" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Hotel
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="hotel" data-parent="#package">
                        <?php
                        if ($CheckAccess['home_services_hotel_list']) { ?>
                            <li>
                            <a href="<?= $path ?>package/hotel">List</a>
                            </li><?php
                        }
                        if ($CheckAccess['home_services_hotel_categories']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_category">Hotel Categories</a>
                            </li><?php
                        }
                        if ($CheckAccess['home_services_hotel_facilities']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_facilities">Hotel
                                Facilities</a>
                            </li><?php
                        }
                        if ($CheckAccess['home_services_hotel_amenities']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_amenities">Hotel Amenities</a>
                            </li><?php
                        }
                        if ($CheckAccess['home_services_hotel_room_types']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/room_types">Room Types</a>
                            </li><?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            } ?>
            <?php
            if ($CheckAccess['home_services_transport'] || $CheckAccess['home_services_transport_list']
                || $CheckAccess['home_services_transport_type']
                || $CheckAccess['home_services_transport_sectors']
                || $CheckAccess['home_services_transport_borders']
                || $CheckAccess['home_services_transport_sea_ports']
                || $CheckAccess['home_services_transport_companies']
            ) {
                ?>
                <li>
                    <a href="#transport" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Transport
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="transport" data-parent="#package">
                        <?php
                        if ($CheckAccess['home_services_transport_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/transport">List</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_transport_type']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/transport_types">Transport
                                    Types</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_transport_sectors']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/transport_sectors">Transport
                                    Sectors</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_transport_borders']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/land_borders">Borders</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_transport_sea_ports']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/sea_ports">Sea Ports</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_transport_companies']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/transportation_company">Transport
                                    Companies</a>
                            </li>
                        <?php }
                        ?>
                    </ul>
                </li>
            <?php } ?>
            <?php
            if ($CheckAccess['home_services_ziyarat'] || $CheckAccess['home_services_ziyarat_list']) {
                ?>
                <li>
                    <a href="#ziarat" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        Ziyarat
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="ziarat" data-parent="#package">
                        <?php if ($CheckAccess['home_services_ziyarat_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/ziyarat ">List</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php
            }
            if ($CheckAccess['home_services_packages'] || $CheckAccess['home_services_packages_b2b_external'] || $CheckAccess['home_services_packages_b2b'] || $CheckAccess['home_services_packages_B2b_general']
                || $CheckAccess['home_services_packages_b2c']) { ?>
                <li>
                    <a href="#packages" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Packages
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="packages" data-parent="#package">
                        <?php
                        if ($CheckAccess['home_services_packages_b2b_external']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_external_package">B2B External</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_packages_b2b']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_packages">B2B</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_packages_B2b_general']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_general_package">B2B General</a>
                            </li>
                        <?php }
                        if ($CheckAccess['home_services_packages_b2c']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2c_package">B2C</a>
                            </li>
                        <?php }
                        ?>
                    </ul>
                </li>
                <?php
            }
            if ($CheckAccess['home_services_visa_type']) {
                ?>
                <li>
                <a href="<?= $path ?>setting/lookup_options/visa_types">Visa Types</a>
                </li><?php
            }
            if ($CheckAccess['home_services_extra_services']) {
                ?>
                <li>
                    <a href="<?= $path ?>setting/lookup_options/extra_services">Extra Services
                    </a>
                </li>
            <?php }
            if ($CheckAccess['home_services_operator']) {
                ?>
                <li>
                    <a href="<?= $path ?>user/operator">Operators</a>
                </li>
                <?php
            } ?>
        </ul>
    </li>
    <?php
}
if ($CheckAccess['home_lookups']) {
    ?>
    <li class="menu">
        <a href="#lookups" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Lookups</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="lookups" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['home_lookups_options']) { ?>
                <li>
                    <a href="<?= $path ?>setting/lookups">Lookups</a>
                </li>
                <?php
            } ?>
        </ul>
    </li>
    <?php
}
?>
<?php
if ($CheckAccess['home_query']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/query" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Query</span>
            </div>
        </a>
    </li>
    <?php
}
?>
<?php
if ($CheckAccess['home_inbox']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/inbox" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Inbox</span>
            </div>
        </a>
    </li>
    <?php
}
?>

<?php
if ($CheckAccess['home_wallet']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/wallet" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Wallet</span>
            </div>
        </a>
    </li>
    <?php
}
?>
<?php

if ($CheckAccess['home_users'] || $CheckAccess['home_users_system_user'] || $CheckAccess['home_users_access_level']) {
    ?>
    <?php $options = array("index", "external_agent") ?>
    <li class="menu <?= (($module == 'user' && in_array($page, $options)) ? 'active' : '') ?>">
        <a href="#users" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="feather feather-users">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Users</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="users" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['home_users_system_user']) { ?>
                <li <?= (($module == "user" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>user/index">System Users </a>
                </li>
                <?php
            }
            if ($CheckAccess['home_users_access_level']) {
                ?>
                <li>
                    <a href="<?= $path ?>setting/access_levels">Access levels </a>
                </li>
                <?php
            }


            ?>
        </ul>
    </li>
    <?php
}
