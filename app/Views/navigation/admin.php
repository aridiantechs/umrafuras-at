<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">

        <ul class="navbar-nav theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="<?= $path ?>">
                    <img src="<?= $path ?>template/<?=$domain_themes[$hostdomain]['logo']?>" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="<?=$path?>" class="nav-link"><span style="font-size: 16px;">MIS - Umrah Furas </span></a>
            </li>
        </ul>

        <ul class="list-unstyled menu-categories" id="accordionExample">
            <li class="menu <?= (($module == '' && $page == '') ? 'active' : '') ?>">
                <a href="<?= $path ?>" aria-expanded="true" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <span>Dashboards</span>
                    </div>
                </a>
            </li>

            <?php
            if($CheckAccess['navigation_agents'] || $CheckAccess['navigation_sub_agents']){?>
            <li class="menu <?= (($module == 'agent' && $page == 'index') ? 'active' : '') ?>">
                <a href="#agents" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Agents</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled"
                    id="agents" data-parent="#accordionExample">
                    <?php
                    if($CheckAccess['navigation_sub_agents']){?>
                    <li <?= (($module == "agent" && $page == "sub_agents") ? ' class="active" ' : '') ?>>
                        <a href="<?= $path ?>agent/sub_agents">Sub Agents </a>
                        </li><?php
                    }?>
                </ul>
                </li><?php
            } ?>
            <?php
            if($CheckAccess['navigation_groups'] || $CheckAccess['navigation_pilgrim'] || $CheckAccess['navigation_add_pilgrim']){?>
                <li class="menu <?= (($module == 'group' && $page == 'index') ? 'active' : '') ?> ">
                    <a href="#groups"
                       class="dropdown-toggle" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span>Groups</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="groups" data-parent="#accordionExample">
                        <?php
                        if($CheckAccess['navigation_groups']){ ?>
                        <li <?= (($module == "group" && $page == "index") ? ' class="active" ' : '') ?>>
                            <a href="<?= $path ?>group/index">List </a>
                            </li><?php
                        }
                        if($CheckAccess['navigation_pilgrim'] ||$CheckAccess['navigation_add_pilgrim']||$CheckAccess['navigation_title_options']||$CheckAccess['navigation_elm_list']){ ?>
                            <li>
                                <a href="#groups-error" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Pilgrim <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="groups-error" data-parent="#groups">
                                    <?php
                                    if($CheckAccess['navigation_pilgrim']){ ?>
                                        <li>
                                            <a href="<?= $path ?>pilgrim/index">List </a>
                                        </li>
                                        <?php
                                    }
                                    if($CheckAccess['navigation_add_pilgrim']){?>
                                        <li>
                                        <a href="<?= $path ?>pilgrim/new">New Registration</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_title_options']){?>
                                        <li>
                                        <a href="<?= $path ?>setting/lookup_options/title_options">Title Options</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_elm_list']){?>
                                        <li>
                                        <a href="<?= $path ?>pilgrim/elm_list">ELM List</a>
                                        </li><?php
                                    }?>
                                </ul>
                            </li>
                            <?php
                        }?>
                    </ul>
                </li>
                <?php
            }
            if($CheckAccess['navigation_reports']){?>
                <li class="menu">
                    <a href="<?=$path?>reports/index" class="dropdown-toggle" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Reports</span>
                        </div>
                    </a>
                </li>
                <?php
            }
            if($CheckAccess['navigation_voucher']){?>
                <li class="menu">
                    <a href="<?=$path?>reports/index" class="dropdown-toggle" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Voucher</span>
                        </div>
                    </a>
                </li>
                <?php
            }
            if($CheckAccess['navigation_mofa_upload'] || $CheckAccess['navigation_visa_not_printed'] || $CheckAccess['navigation_visa_issued']){?>
                <li class="menu <?= (($module == 'user' && $page == 'mofa') ? 'active' : '') ?>">
                    <a href="#MOFA" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                                <line x1="2" y1="20" x2="2.01" y2="20"></line>
                            </svg>
                            <span>MOFA</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="MOFA" data-parent="#accordionExample">
                        <?php
                        if($CheckAccess['navigation_mofa_upload']){ ?>
                        <li <?= (($module == "user" && $page == "mofa") ? ' class="active" ' : '') ?>>
                            <a href="<?=$path?>mofa/index">Upload</a>
                            </li><?php
                        }
                        if($CheckAccess['navigation_visa_not_printed']){?>
                        <li <?= (($module == "user" && $page == "visa") ? ' class="active" ' : '') ?>>
                            <a href="<?=$path?>mofa/visa_not_printed">Visa Not Printed</a>
                            </li><?php
                        }
                        if($CheckAccess['navigation_visa_issued']){?>
                        <li <?= (($module == "user" && $page == "visa") ? ' class="active" ' : '') ?>>
                            <a href="<?=$path?>mofa/visa_issued">Visa Issued</a>
                            </li><?php
                        }?>
                    </ul>
                </li>
                <?php
            } ?>
            <?php
            if($CheckAccess['navigation_hotels'] || $CheckAccess['navigation_transport'] || $CheckAccess['navigation_ziyarats'] || $CheckAccess['navigation_extra_services'] || $CheckAccess['navigation_packages']){?>
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
                            <span>Package</span>
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
                        if($CheckAccess['navigation_hotels'] || $CheckAccess['navigation_hotel_amenities'] || $CheckAccess['navigation_room_types'] || $CheckAccess['navigation_hotel_category'] || $CheckAccess['navigation_hotel_facilities']){ ?>
                            <li>
                                <a href="#hotel" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Hotel <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="hotel" data-parent="#package">
                                    <?php
                                    if($CheckAccess['navigation_hotels']){ ?>
                                        <li>
                                        <a href="<?=$path?>package/hotel">List</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_hotel_category']){?>
                                        <li>
                                        <a href="<?=$path?>setting/lookup_options/hotel_category">Hotel Categories</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_hotel_facilities']){?>
                                        <li>
                                        <a href="<?=$path?>setting/lookup_options/hotel_facilities">Hotel Facilities</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_hotel_amenities']){?>
                                        <li>
                                        <a href="<?=$path?>setting/lookup_options/hotel_amenities">Hotel Amenities</a>
                                        </li><?php
                                    }
                                    if($CheckAccess['navigation_room_types']){?>
                                        <li>
                                        <a href="<?=$path?>setting/lookup_options/room_types">Room Types</a>
                                        </li><?php
                                    }?>
                                </ul>
                            </li>
                            <?php
                        } ?>
                        <?php
                        if($CheckAccess['navigation_transport'] || $CheckAccess['navigation_transport_types']|| $CheckAccess['navigation_transport_companies']){?>
                            <li>
                                <a href="#transport" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Transport <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="transport" data-parent="#package">
                                    <?php
                                    if($CheckAccess['navigation_transport']){ ?>
                                        <li>
                                            <a href="<?=$path?>package/transport">List</a>
                                        </li>
                                    <?php }
                                    if($CheckAccess['navigation_transport_types']){ ?>
                                        <li>
                                            <a href="<?=$path?>setting/lookup_options/transport_types">Transport Types</a>
                                        </li>
                                    <?php }
                                    if($CheckAccess['navigation_transport_sectors']){ ?>
                                        <li>
                                            <a href="<?=$path?>setting/lookup_options/transport_sectors">Transport Sectors</a>
                                        </li>
                                    <?php }
                                    if($CheckAccess['navigation_transport_companies']){ ?>
                                        <li>
                                            <a href="<?=$path?>setting/lookup_options/transportation_company">Transport Companies</a>
                                        </li>
                                    <?php }
                                    ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <?php
                        if($CheckAccess['navigation_ziyarats']){?>
                            <li>
                                <a href="#ziarat" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Ziyarat  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="ziarat" data-parent="#package">
                                    <li>
                                        <a href="<?=$path?>package/ziyarat ">List</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_packages']){?>
                            <li>
                                <a href="#packages" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Packages <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                                <ul class="collapse list-unstyled sub-submenu" id="packages" data-parent="#package">
                                    <li>
                                        <a href="<?=$path?>package/b2b_packages">List</a>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_extra_services']){?>
                            <li>
                                <a href="<?=$path?>setting/lookup_options/extra_services">Extra Services
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <?php
            } ?>
            <li class="menu">
                <a href="#arrangement" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                    <div class="">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                             fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                            <line x1="2" y1="20" x2="2.01" y2="20"></line>
                        </svg>
                        <span>Arrangement</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="arrangement" data-parent="#accordionExample">
                    <li>
                        <a href="">Hotel</a>
                        <a href="">Hotel Summary</a>
                        <a href="">Transport</a>
                        <a href="">Transport Summary</a>
                    </li>
                </ul>
            </li>
            <li class="menu">
                <a href="#arrival_departure" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-users">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span>Arrival Departure</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="arrival_departure" data-parent="#accordionExample">
                    <li>
                        <a href="">Arrival Airport</a>
                        <a href="">Arrival Hotel</a>
                        <a href="">Departure Airport</a>
                        <a href="">Departure Hotel</a>
                    </li>
                </ul>
            </li>
            <!--            <li class="menu">-->
            <!--                <a href="" class="dropdown-toggle" aria-expanded="false">-->
            <!--                    <div class="">-->
            <!--                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"-->
            <!--                             fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
            <!--                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>-->
            <!--                            <polyline points="13 2 13 9 20 9"></polyline>-->
            <!--                        </svg>-->
            <!--                        <span>Agent Work Report Layout same as WTU</span>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--            </li>-->
            <!--            <li class="menu">-->
            <!--                <a href="" class="dropdown-toggle" aria-expanded="false">-->
            <!--                    <div class="">-->
            <!--                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"-->
            <!--                             fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">-->
            <!--                            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>-->
            <!--                            <polyline points="13 2 13 9 20 9"></polyline>-->
            <!--                        </svg>-->
            <!--                        <span>ELM Data Summary DayWise</span>-->
            <!--                    </div>-->
            <!--                </a>-->
            <!--            </li>-->
            <?php
            if($CheckAccess['navigation_websites']){?>
                <?php $options = array("pages", "settings", "access_levels", "activity_log") ?>
                <li class="menu <?= (($module == 'web_admin' && (in_array($page, $options))) ? 'active' : '') ?>">
                    <a href="#websites" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                                 fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                            <span>Websites</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled " id="websites" data-parent="#accordionExample">
                        <?php
                        if($CheckAccess['navigation_websites']){ ?>
                            <?php
                            foreach ($Domains as $Domain) { ?>
                            <li <?= (($module == "web_admin" && $page == "pages" && $domain == $Domain['Name']) ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>web_admin/pages/<?= $Domain['UID'] ?>"><?= $Domain['Name'] ?></a>
                                </li><?php
                            } ?>
                            <?php
                        }?>
                    </ul>
                </li>
                <?php
            } ?>
            <?php
            if($CheckAccess['navigation_lookups']){?>
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
                        if($CheckAccess['navigation_lookups']){ ?>
                            <li>
                                <a href="<?= $path ?>setting/lookups">Lookups</a>
                            </li>
                            <?php
                        }?>
                    </ul>
                </li>
                <?php
            } ?>
            <?php
            if($CheckAccess['navigation_users'] || $CheckAccess['navigation_external_agents'] || $CheckAccess['navigation_umrah_operator'] ){?>
                <?php $options = array("index", "external_agent") ?>
                <li class="menu <?= (($module == 'user' && in_array($page, $options)) ? 'active' : '') ?>">
                    <a href="#users"class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
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
                        if($CheckAccess['navigation_users']){ ?>
                            <li <?= (($module == "user" && $page == "index") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>user/index">System Users </a>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_external_agents']){?>
                            <li <?= (($module == "user" && $page == "external_agent") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>user/external_agent">External Agent</a>
                            </li> <?php
                        }
                        if($CheckAccess['navigation_umrah_operator']){?>
                            <li>
                                <a href="<?= $path ?>user/operator">Umrah Operator</a>
                            </li>
                            <?php
                        }?>
                    </ul>
                </li>
                <?php
            } ?>
            <?php
            if($CheckAccess['navigation_settings'] || $CheckAccess['navigation_activity_log'] || $CheckAccess['navigation_languages'] || $CheckAccess['navigation_access_levels'] || $CheckAccess['navigation_agent_types'] ){?>
                <?php $options = array("operators", "settings", "access_levels", "activity_log") ?>
                <li class="menu <?= (($module == 'setting' && (in_array($page, $options))) ? 'active' : '') ?>">
                    <a href="#settings" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                 class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                            <span>Settings</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled "
                        id="settings" data-parent="#accordionExample">
                        <?php
                        if($CheckAccess['navigation_settings']){ ?>
                            <li <?= (($module == "setting" && $page == "settings") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>setting/settings">Settings </a>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_activity_log']){?>
                            <li <?= (($module == "setting" && $page == "activity_log") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>setting/activity_log">Activity Log </a>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_database']){?>
                            <li <?= (($module == "setting" && $page == "database") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>setting/database">Download Database</a>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_access_levels']){?>
                            <li <?= (($module == "setting" && $page == "access_levels") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>setting/access_levels">Access levels </a>
                            </li>
                            <?php
                        }
                        if($CheckAccess['navigation_agent_types']){?>
                            <li>
                            <a href="<?=$path?>setting/lookup_options/agent_types">Agent Types</a>
                            </li><?php
                        }
                        if($CheckAccess['navigation_languages']){?>
                            <li>
                            <a href="#settings-error" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"> Multi Languages <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg> </a>
                            <ul class="collapse list-unstyled sub-submenu" id="settings-error" data-parent="#settings">
                                <li>
                                    <a href="<?= $path ?>setting/language">Languages</a>
                                </li>
                                <li>
                                    <a href="<?= $path ?>setting/translations">Translations</a>
                                </li>
                            </ul>
                            </li><?php
                        }?>

                    </ul>
                </li>

                <?php
            } ?>
            <li class="menu">
                <a href="<?= $path ?>home/logout" class="dropdown-toggle" aria-expanded="false">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="feather feather-log-out">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->