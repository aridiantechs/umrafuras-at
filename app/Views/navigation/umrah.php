<?php

//print_r($session);exit;

if ($CheckAccess['umrah_dashboard']) { ?>

    <li class="menu">
        <a href="<?= $path ?>home/umrah" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Umrah Dashboard</span> <? /*= $session['domainid'] */ ?>
            </div>
        </a>
    </li>
<?php } ?>
<?php
//$KeysCheck = ['umrah_client_b2c_list'];
if ($CheckAccess['umrah_client_b2c_list'] || $CheckAccess['umrah_client_b2b_list'] || $CheckAccess['umrah_client_sale_agents_list'] || $CheckAccess['umrah_client_external_agent_list'] || $CheckAccess['umrah_client_external_agent_sub_agents_list'] ) { ?>
    <li class="menu <?= (($module == 'agent' && $page == 'index') ? 'active' : '') ?>">
        <a href="#agents" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg width="24" height="24" viewBox="0 0 24 24"
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
            <?php
            if ($CheckAccess['umrah_client_b2c_list']) { ?>
                <li><a href="<?= $path ?>pilgrim/b2c_pilgrims">B2C</a></li><?php
            }

            if ($CheckAccess['umrah_client_b2b_list']) { ?>
                <li <?= (($module == "agent" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>agent/index">B2B </a>
                </li> <?php
            }
            if ($CheckAccess['umrah_client_sale_agents_list']) { ?>
                <li>
                    <a href="<?= $path ?>sale_agents/index">Sale Agent</a>
                </li> <?php
            }
            if ($CheckAccess['umrah_client_external_agent_list'] || $CheckAccess['umrah_client_external_agent_sub_agents_list']) { ?>
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
                        <?php
                        if ($CheckAccess['umrah_client_external_agent_list']) {
                            ?>
                            <li <?= (($module == "user" && $page == "external_agent") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>user/external_agent">List</a>
                            </li> <?php
                        }
                        if ($CheckAccess['umrah_client_external_agent_sub_agents_list']) { ?>
                        <li <?= (($module == "agent" && $page == "sub_agents") ? ' class="active" ' : '') ?>>
                            <a href="<?= $path ?>agent/sub_agents">Sub Agents </a>
                            </li><?php
                        } ?>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </li>
    <?php
}
if ($CheckAccess['umrah_travel_check_b2c_voucher_list'] || $CheckAccess['umrah_travel_check_create_voucher'] || $CheckAccess['umrah_travel_check_all_voucher_list'] || $CheckAccess['umrah_travel_check_pending_voucher_list'] || $CheckAccess['umrah_travel_check_approved_voucher_list'] || $CheckAccess['umrah_travel_check_updated_voucher_list'] || $CheckAccess['umrah_travel_check_executed_voucher_list'] || $CheckAccess['umrah_travel_check_refund_voucher_list'] || $CheckAccess['umrah_travel_check_wdout_voucher_arrival_list']) {
    ?>
    <li class="menu">
        <a href="#voucher" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Travel Check</span>
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
            id="voucher" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['umrah_travel_check_b2c_voucher_list']) { ?>
                <li>
                    <a href="<?= $path ?>agent/b2c_voucher">B2C Voucher</a>
                </li>
                <?php
            } ?>
            <?php
            if ($CheckAccess['umrah_travel_check_create_voucher']) { ?>
                <li>
                    <a href="<?= $path ?>agent/voucher">Create Voucher</a>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_travel_check_all_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/all_voucher">All Voucher</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_pending_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/pending_voucher">Pending Voucher</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_approved_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/approved_voucher">Approved Vouchers</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_updated_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/updated_vouchers">Updated Voucher</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_executed_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/all_executed_voucher">Executed Vouchers</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_refund_voucher_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/refund_vouchers">Refund Voucher</a>
                </li><?php
            }
            if ($CheckAccess['umrah_travel_check_wdout_voucher_arrival_list']) { ?>
                <li>
                <a href="<?= $path ?>agent/without_voucher_arrival">Wdout Voucher Arrvl</a>
                </li><?php
            }
            ?>

        </ul>
    </li>
    <?php
}
if ($CheckAccess['umrah_activity_allow_pilgrim_activity'] || $CheckAccess['umrah_activity_actual_pilgrim_activity'] ||
    $CheckAccess['umrah_activity_passport_management']
    || $CheckAccess['umrah_activity_visa_management']
    || $CheckAccess['umrah_activity_visa_management_manage_visa_list']
    || $CheckAccess['umrah_activity_visa_management_manage_mofa ']


) { ?>
    <li class="menu">
        <a href="#activity" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
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
                <span>Activity</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="activity" data-parent="#accordionExample">
            <?php
            if ($CheckAccess['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_list'] || $CheckAccess['umrah_activity_allow_pilgrim_activity_allow_transport_activities_list']) { ?>
                <li class="menu">
                    <a href="#allow_pilgrim" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Allow Pilgrim Activity
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="allow_pilgrim"
                        data-parent="#allow_pilgrim">
                        <?php
                        if ($CheckAccess['umrah_activity_allow_pilgrim_activity_allow_hotel_activities_list']) { ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/allow_hotel_activities">Allow Hotel Activities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_allow_pilgrim_activity_allowd_hotel_activitiesssssssssssssss']) { ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/allowed_hotel_activities">Allowed Hotel Activities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_allow_pilgrim_activity_allow_transport_activities_list']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/allow_transport_activities">Allow Transport
                                Activities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_allow_pilgrim_activity_allowd_transport_activitiessssssssssssssssssssss']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/allowed_transport_activities">Allowed Transport
                                Activities</a>
                            </li><?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }

            if ($CheckAccess['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_list'] || $CheckAccess['umrah_activity_actual_pilgrim_activity_actual_transport_activities_list']) { ?>
                <li class="menu">
                    <a href="#actual_pilgrim" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Actual Pilgrim Activity
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="actual_pilgrim"
                        data-parent="#actual_pilgrim">
                        <?php
                        if ($CheckAccess['umrah_activity_actual_pilgrim_activity_actual_hotel_activities_list']) { ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/actual_hotel_activities">Actual Hotel
                                Activities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_actual_pilgrim_activity_actual_transport_activities']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/actual_transport_activities">Actual Transport
                                Activities</a>
                            </li><?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }

            if ($CheckAccess['navigation_pilgrim_activity']) { ?>
                <li>
                    <!--                    <a href="-->
                    <?//= $path ?><!--pilgrim/pilgrim_activity">Pilgrim Activity (OLD_</a>-->
                </li>
                <?php
            }

            if ($CheckAccess['umrah_activity_passport_management'] || $CheckAccess['umrah_activity_passport_management_passport_pending'] || $CheckAccess['umrah_activity_passport_management_passport_completed']) { ?>
                <li class="menu">
                    <a href="#passport" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Passport Management
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="passport" data-parent="#passport">
                        <?php
                        if ($CheckAccess['umrah_activity_passport_management_passport_pending']) { ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/pending_passports">Pending</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_passport_management_passport_completed']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/completed_passports">Completed</a>
                            </li><?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_activity_visa_management'] || $CheckAccess['umrah_activity_visa_management_manage_visa_list'] || $CheckAccess['umrah_activity_visa_management_manage_mofa']) { ?>
                <li class="menu">
                    <a href="#visa-manage" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Visa Management
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse submenu list-unstyled" id="visa-manage" data-parent="#visa-manage">
                        <?php
                        if ($CheckAccess['umrah_activity_visa_management_manage_visa_list']) {
                            ?>
                        <li <?= (($module == "user" && $page == "visa_details") ? ' class="active" ' : '') ?>>
                            <a href="<?= $path ?>mofa/visa_details"> Manage Visa</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_activity_visa_management_manage_mofa']) { ?>
                            <li <?= (($module == "user" && $page == "mofa") ? ' class="active" ' : '') ?>>
                                <a href="<?= $path ?>mofa/index">Manage Mofa</a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </li>
                <?php
            }

            ?>
        </ul>
    </li>
    <?php
}
if ($CheckAccess['umrah_data_uploader']) {
    ?>
    <li class="menu">
        <a href="<?= $path ?>pilgrim/file_uploader" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Data Uploader</span>
            </div>
        </a>
    </li>
    <?php
}
if ($CheckAccess['umrah_brn_management_hotel_brn_list'] || $CheckAccess['umrah_brn_management_transport_brn_list'] || $CheckAccess['umrah_brn_management_promo_code_list']) {
    ?>
    <li class="menu">
        <a href="#brn" class="dropdown-toggle" class="dropdown-toggle" data-toggle="collapse"
           aria-expanded="false">
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
                <span>BRN Management</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="brn" data-parent="#accordionExample">
            <?php
            //                        if ($CheckAccess['navigation_brn_operators']) { ?>
            <!--                            <li>-->
            <!--                                <a href="-->
            <?//= $path ?><!--brn/brn_operator">BRN Operators </a>-->
            <!--                            </li>-->
            <!--                            --><?php
            //                        }
            if ($CheckAccess['umrah_brn_management_hotel_brn_list']) { ?>
                <li>
                    <a href="<?= $path ?>brn/hotel_brn">Hotel BRN </a>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_brn_management_transport_brn_list']) { ?>
                <li>
                    <a href="<?= $path ?>brn/transport_brn">Transport BRN</a>
                </li>
                <?php
            } ?> <?php
            if ($CheckAccess['umrah_brn_management_promo_code_list']) { ?>
                <li>
                    <a href="<?= $path ?>brn/promo_code">Promo Code </a>
                </li> <?php } ?>

        </ul>
    </li>

    <?php
}
if ($CheckAccess['umrah_groups_create_new'] || $CheckAccess['umrah_groups_manage'] || $CheckAccess['umrah_groups_deleted_groups']
    || $CheckAccess['umrah_groups_pilgrim']
    || $CheckAccess['umrah_groups_manage_incomplete_list']
    || $CheckAccess['umrah_groups_manage_complete_list']
    || $CheckAccess['umrah_groups_pilgrim_b2b_list']
    || $CheckAccess['umrah_groups_pilgrim_b2c_list']
    || $CheckAccess['umrah_groups_pilgrim_pilgrim_title_options_list']
    || $CheckAccess['umrah_groups_pilgrim_new_registration']
    || $CheckAccess['umrah_groups_pilgrim_transfer']

) {
    ?>
    <li class="menu <?= (($module == 'group' && $page == 'index') ? 'active' : '') ?> ">
        <a href="#groups"
           class="dropdown-toggle" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
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
            if ($CheckAccess['umrah_groups_create_new']) { ?>
                <li <?= (($module == "group" && $page == "add_group") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>group/add_group">Create New Groups </a>
                </li> <?php } ?>
            <?php if ($CheckAccess['umrah_groups_manage_incomplete_list'] || $CheckAccess['umrah_groups_manage_complete_list']) { ?>
                <li>
                <a href="#groups-error" data-toggle="collapse" aria-expanded="false"
                   class="dropdown-toggle"> Manage
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
                <ul class="collapse list-unstyled sub-submenu" id="groups-error" data-parent="#groups">
                    <?php if ($CheckAccess['umrah_groups_manage_incomplete_list']) { ?>
                        <li>
                            <a href="<?= $path ?>group/index/in-complete">In-Complete</a>
                        </li>
                    <?php } ?>
                    <?php if ($CheckAccess['umrah_groups_manage_complete_list']) { ?>
                        <li>
                            <a href="<?= $path ?>group/index/complete">Complete </a>
                        </li>
                    <?php } ?>
                </ul>
                </li><?php
            }
            if ($CheckAccess['umrah_groups_deleted_groups']) { ?>
            <li <?= (($module == "group" && $page == "deleted_groups") ? ' class="active" ' : '') ?>>
                <a href="<?= $path ?>group/deleted_groups">Deleted Groups </a>
                </li><?php
            }
            if ($CheckAccess['umrah_groups_pilgrim_b2b_list'] || $CheckAccess['umrah_groups_pilgrim_b2c_list'] || $CheckAccess['umrah_groups_pilgrim_new_registration'] || $CheckAccess['umrah_groups_pilgrim_pilgrim_title_options_list'] || $CheckAccess['umrah_groups_pilgrim_transfer']) { ?>
                <li>
                    <a href="#pilgrim-error" data-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle"> Pilgrim
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                    <ul class="collapse list-unstyled sub-submenu" id="pilgrim-error" data-parent="#groups">

                        <?php if ($CheckAccess['umrah_groups_pilgrim_b2b_list']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/B2B">B2B</a>
                            </li>
                        <?php } ?>

                        <?php if ($CheckAccess['umrah_groups_pilgrim_b2c_list']) { ?>
                            <li>
                                <a href="<?= $path ?>agent/B2C">B2C</a>
                            </li>
                        <?php } ?>

                        <!--                        --><?php
                        //                        if ($CheckAccess['navigation_b2b_pilgrim']) { ?>
                        <!--                            <li><a href="-->
                        <? //= $path ?><!--pilgrim/b2b_pilgrims">B2B </a></li>--><?php
                        //                        }
                        //                        if ($CheckAccess['navigation_b2c_pilgrim']) { ?>
                        <!--                        <li><a href="-->
                        <? //= $path ?><!--pilgrim/b2c_pilgrims">B2C </a></li>--><?php
                        //                        }
                        //                        if ($CheckAccess['navigation_b2c_pilgrim']) { ?>
                        <!--                            <li>-->
                        <!--                                <a href="--><? //= $path ?><!--pilgrim/B2C">B2C</a>-->
                        <!--                            </li>-->
                        <!--                        --><?php //}
                        //
                        //                        if ($CheckAccess['navigation_add_pilgrim']) {
                        //                            ?>
                        <!--                            <li>-->
                        <!--                            <a href="-->
                        <? //= $path ?><!--pilgrim/new">New Registration</a>-->
                        <!--                            </li>--><?php
                        //                        }
                        //
                        if ($CheckAccess['umrah_groups_pilgrim_new_registration']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>pilgrim/new_bulk">New Registration</a>
                            </li><?php
                        }
                        //                        if ($CheckAccess['navigation_bulk_registration']) {
                        //                            ?>
                        <!--                            <li>-->
                        <!--                            <a href="-->
                        <? //= $path ?><!--pilgrim/new_bulk">Bulk Registration</a>-->
                        <!--                            </li>--><?php
                        //                        }
                        //                        if ($CheckAccess['navigation_pilgrim']) { ?>
                        <!--                            <li>-->
                        <!--                                <a href="--><? //= $path ?><!--pilgrim/index">List </a>-->
                        <!--                            </li>-->
                        <!--                            --><?php
                        //                        }

                        if ($CheckAccess['umrah_groups_pilgrim_pilgrim_title_options_list']) {
                            ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/title_options">Title Options</a>
                            </li>
                            <?php
                        }
                        if ($CheckAccess['umrah_groups_pilgrim_transfer']) {
                            ?>
                            <li>
                                <a href="<?= $path ?>pilgrim/pilgrim_transfer">Pilgrim Transfer</a>
                            </li>
                            <?php
                        }
                        //                                    if ($CheckAccess['navigation_elm_list']) {
                        //                                        ?>
                        <!--                                        <li>-->
                        <!--                                        <a href="-->
                        <? //= $path ?><!--pilgrim/elm_list">ELM List</a>-->
                        <!--                                        </li>--><?php
                        //                                    } ?>
                    </ul>
                </li>
                <?php
            } ?>
        </ul>
    </li>
    <?php
}
if ($CheckAccess['umrah_reports'] || $CheckAccess['umrah_reports_stats'] || $CheckAccess['umrah_reports_status_stats'] || $CheckAccess['umrah_reports_vendors']) {
    ?>
    <li class="menu">
        <a href="#reports" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2"
                     fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M2 16.1A5 5 0 0 1 5.9 20M2 12.05A9 9 0 0 1 9.95 20M2 8V6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-6"></path>
                    <line x1="2" y1="20" x2="2.01" y2="20"></line>
                </svg>
                <span>Reports</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-chevron-right">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled" id="reports" data-parent="#accordionExample">
            <?php
            //                        if ($CheckAccess['navigation_reports_stats']) { ?>
            <!--                            <li>-->
            <!--                                <a href="--><?//= $path ?><!--reports/index">Stats</a>-->
            <!--                            </li>-->
            <!--                            --><?php
            //                        }
            if ($CheckAccess['umrah_reports_stats']) { ?>
                <li>
                    <a href="<?= $path ?>reports/stats">Report Stats</a>
                </li>
                <?php
            } ?>
            <?php if ($CheckAccess['umrah_reports_status_stats']) { ?>
                <li>
                    <a href="<?= $path ?>home/stats">Status Stats</a>
                </li>
            <?php } ?>
            <?php if ($CheckAccess['umrah_reports_vendors']) { ?>
                <li>
                    <a href="<?= $path ?>reports/vendors">Vendors</a>
                </li>
                <?php
            } ?>
        </ul>
    </li>

    <?php
}
if ($CheckAccess['umrah_services_hotel'] || $CheckAccess['umrah_services_transport']
    || $CheckAccess['umrah_services_ziyarat_list']
    || $CheckAccess['umrah_services_packages']
    || $CheckAccess['umrah_services_visa_type']
    || $CheckAccess['umrah_services_extra_services']
    || $CheckAccess['umrah_services_operator_list']) {
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
            if ($CheckAccess['umrah_services_hotel_list'] || $CheckAccess['umrah_services_hotel_categories'] || $CheckAccess['umrah_services_hotel_facilities'] || $CheckAccess['umrah_services_hotel_amenities'] || $CheckAccess['umrah_services_hotel_room_types']) { ?>
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
                        if ($CheckAccess['umrah_services_hotel_list']) { ?>
                            <li>
                            <a href="<?= $path ?>package/hotel">List</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_services_hotel_categories']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_category">Hotel Categories</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_services_hotel_facilities']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_facilities">Hotel
                                Facilities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_services_hotel_amenities']) {
                            ?>
                            <li>
                            <a href="<?= $path ?>setting/lookup_options/hotel_amenities">Hotel Amenities</a>
                            </li><?php
                        }
                        if ($CheckAccess['umrah_services_hotel_room_types']) {
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
            if ($CheckAccess['umrah_services_transport_list'] || $CheckAccess['umrah_services_transport_type'] || $CheckAccess['umrah_services_transport_sectors'] || $CheckAccess['umrah_services_transport_borders'] || $CheckAccess['umrah_services_transport_sea_ports'] || $CheckAccess['umrah_services_transport_companies']) {
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
                        if ($CheckAccess['umrah_services_transport_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/transport">List</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_type']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/transport_types">Transport
                                    Types</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_sectors']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/transport_sectors">Transport
                                    Sectors</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_borders']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/land_borders">Borders</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_border_cities']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/land_border_cities">Border Cities</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_sea_ports']) { ?>
                            <li>
                                <a href="<?= $path ?>setting/lookup_options/sea_ports">Sea Ports</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_transport_companies']) { ?>
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
            if ($CheckAccess['umrah_services_ziyarat_list']) {
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
                        <li>
                            <a href="<?= $path ?>package/ziyarat ">List</a>
                        </li>
                    </ul>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_services_packages_b2b_external_list'] || $CheckAccess['umrah_services_packages_b2b_list'] || $CheckAccess['umrah_services_packages_B2b_general'] || $CheckAccess['umrah_services_packages_b2c']) { ?>
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
                        if ($CheckAccess['umrah_services_packages_b2b_external_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_external_package">B2B External</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_packages_b2b_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_packages">B2B</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_packages_B2b_general']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2b_general_package">B2B General</a>
                            </li>
                        <?php }
                        if ($CheckAccess['umrah_services_packages_b2c']) { ?>
                            <li>
                                <a href="<?= $path ?>package/b2c_package">B2C</a>
                            </li>
                        <?php }
                        ?>
                        <?php
                        if ($CheckAccess['umrah_services_packages_un_assign_list']) { ?>
                            <li>
                                <a href="<?= $path ?>package/un_assign_package">Un Assign</a>
                            </li>
                        <?php }
                        ?>
                    </ul>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_services_visa_type']) {
                ?>
                <li>
                <a href="<?= $path ?>setting/lookup_options/visa_types">Visa Types</a>
                </li><?php
            }
            if ($CheckAccess['umrah_services_extra_services']) {
                ?>
                <li>
                    <a href="<?= $path ?>setting/lookup_options/extra_services">Extra Services
                    </a>
                </li>
            <?php }
            if ($CheckAccess['umrah_services_operator_list']) {
                ?>
                <li>
                    <a href="<?= $path ?>user/operator">Operators</a>
                </li>
                <?php
            } ?>
        </ul>
    </li>
    <?php
} ?>
<?php
if ($CheckAccess['umrah_lookups_list']) { ?>
    <li class="menu">
        <a href="<?= $path ?>setting/lookups" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round" class="feather feather-home">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Lookups</span>
            </div>
        </a>
    </li>      <?php
} ?>



<?php
if ($CheckAccess['umrah_users_system_user_list'] || $CheckAccess['umrah_users_access_level']) {
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
            if ($CheckAccess['umrah_users_system_user_list']) { ?>
                <li <?= (($module == "user" && $page == "index") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>user/index">System Users </a>
                </li>
                <?php
            }
            if ($CheckAccess['umrah_users_access_level']) {
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
} ?>
<?php
if ($CheckAccess['umrah_settings'] || $CheckAccess['umrah_settings_mis'] || $CheckAccess['umrah_settings_websites'] || $CheckAccess['umrah_settings_websites_domain'] || $CheckAccess['umrah_settings_activity_log'] || $CheckAccess['umrah_settings_database_backup'] || $CheckAccess['umrah_settings_agent_types'] || $CheckAccess['umrah_settings_umrah_calender'] || $CheckAccess['umrah_settings_multi_languages']) {
    ?>
    <?php $options = array("operators", "settings", "access_levels", "activity_log");
    ?>
    <li class="menu <?= (($module == 'setting' && (in_array($page, $options))) ? 'active' : '') ?>">
        <a href="#settings" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     fill="none"
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
        <ul class="collapse submenu list-unstyled " id="settings" data-parent="#accordionExample">
            <?php if ($session['domain_parent'] > 0) { ?>
                <?php if ($CheckAccess['umrah_settings_mis']) { ?>
                    <li>
                        <a href="#settingss-error" data-toggle="collapse" aria-expanded="false"
                           class="dropdown-toggle"> MIS Settings
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                        <ul class="collapse list-unstyled sub-submenu" id="settingss-error"
                            data-parent="#settings">
                            <?php
                            if ($CheckAccess['umrah_settings_mis']) { ?>
                                <?php
                                foreach ($Domains as $Domain) { ?>
                                <li <?= (($module == "web_admin" && $page == "pages" && $domain == $Domain['Name']) ? ' class="active" ' : '') ?>>
                                    <a href="<?= SeoUrl("setting/settings/" . $Domain['UID'] . "-" . $Domain['FullName']) ?>"><?= $Domain['Name'] ?></a>
                                    </li><?php
                                } ?>
                                <?php
                            } ?>
                        </ul>
                    </li>   <?php } ?>
                <?php
            } else {
                $WebsiteName = \App\Models\Crud::SingleRecord('websites."Domains"', array("UID" => $session['domainid'])); ?>
                <li <?= (($module == "setting" && $page == "activity_log") ? ' class="active" ' : '') ?>>
                    <a href="<?= SeoUrl("setting/settings/" . $session['domainid'] . "-" . $WebsiteName['FullName']) ?>">MIS</a>
                </li>
            <?php }
            ?>
            <?php
            //            print_r($Domains);exit;
            if ($CheckAccess['umrah_settings_websites']) {
                if ($session['domain_parent'] > 0) { ?>
                    <li>
                        <a href="#websites" class="dropdown-toggle" data-toggle="collapse"
                           aria-expanded="false"> Websites
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-chevron-right">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled " id="websites" data-parent="#settings">

                            <?php
                            foreach ($Domains as $Domain) { ?>
                            <li <?= (($module == "web_admin" && $page == "pages" && $domain == $Domain['Name']) ? ' class="active" ' : '') ?>>
                                <a href="<?= SeoUrl("web_admin/index/" . $Domain['UID'] . "-" . $Domain['FullName']) ?>"><?= $Domain['Name'] ?></a>
                                </li><?php
                            } ?>
                        </ul>
                    </li>
                    <?php
                } else { ?>
                    <li>
                        <a href="<?= SeoUrl("web_admin/index/" . $session['domainid'] . "-website-admin") ?>"
                           class="dropdown-toggle">
                            <div class="">
                                <?php $WebsiteName = \App\Models\Crud::SingleRecord('websites."Domains"', array("UID" => $session['domainid']));
                                echo '   <span>Website</span>'; ?>
                            </div>
                        </a>
                    </li>
                    <?php
                }
            } ?>
            <?php
            if ($CheckAccess['umrah_settings_websites_domain']) {
                if ($session['domain_parent'] > 0 && $session['mis_type'] == "main") {
                    ?>
                    <li <?= (($module == "setting" && $page == "websites_domains") ? ' class="active" ' : '') ?>>
                        <a href="<?= $path ?>setting/websites_domains">Websites Domain </a>
                    </li>
                    <?php
                }
            } ?>
            <?php
            if ($CheckAccess['umrah_settings_websites_domain']) {
                if ($session['domain_parent'] > 0 && $session['mis_type'] == "main") {
                    ?>
                    <li <?= (($module == "setting" && $page == "websites_domains") ? ' class="active" ' : '') ?>>
                        <a href="<?= $path ?>setting/websites_domains">Websites Domain </a>
                    </li>
                    <?php
                }
            } ?>
            <?php
            if ($CheckAccess['umrah_settings_activity_log']) {
                ?>
                <li <?= (($module == "setting" && $page == "activity_log") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>setting/activity_log">Activity Log </a>
                </li>
                <?php
            } ?>
            <?php
            if ($CheckAccess['umrah_settings_database_backup']) {
                ?>
                <li <?= (($module == "setting" && $page == "database") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>setting/download_database">Database Backup</a>
                </li>
            <?php }
            if ($CheckAccess['umrah_settings_agent_types']) {
                ?>
                <li>
                <a href="<?= $path ?>setting/lookup_options/agent_types">Agent Types</a>
                </li><?php
            } ?> <?php
            if ($CheckAccess['umrah_settings_umrah_calender']) {
                ?>
                <li <?= (($module == "setting" && $page == "umrah_calender") ? ' class="active" ' : '') ?>>
                    <a href="<?= $path ?>setting/umrah_calender">Umrah Calender</a>
                </li>
            <?php }
            if ($CheckAccess['umrah_settings_multi_languages'] || $CheckAccess['umrah_settings_multi_languages_languages'] || $CheckAccess['umrah_settings_multi_languages_translation']) {
                ?>
                <li>
                <a href="#settings-error" data-toggle="collapse" aria-expanded="false"
                   class="dropdown-toggle"> Multi Languages
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </a>
                <ul class="collapse list-unstyled sub-submenu" id="settings-error" data-parent="#settings">
                    <?php if ($CheckAccess['umrah_settings_multi_languages_languages']) { ?>
                        <li>
                            <a href="<?= $path ?>setting/language">Languages</a>
                        </li> <?php } ?>

                    <?php if ($CheckAccess['umrah_settings_multi_languages_translation']) { ?>
                        <li>
                            <a href="<?= $path ?>setting/translations">Translations</a>
                        </li> <?php } ?>

                </ul>
                </li><?php
            } ?>

        </ul>
    </li>

    <?php
} ?>
<?php if ($CheckAccess['umrah_query_list']) { ?>
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
<?php } ?>

<?php if ($CheckAccess['umrah_inbox']) { ?>
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
<?php } ?>

<?php if ($CheckAccess['umrah_wallet']) { ?>
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
    </li>  <?php } ?>


<!--<li class="menu">-->
<!--    <a href="--><? //= $path ?><!--home/cron_activities" class="dropdown-toggle" aria-expanded="false">-->
<!--        <div class="">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"-->
<!--                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
<!--                 stroke-linejoin="round" class="feather feather-home">-->
<!--                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>-->
<!--                <polyline points="9 22 9 12 15 12 15 22"></polyline>-->
<!--            </svg>-->
<!--            <span>Cron Activities</span>-->
<!--        </div>-->
<!--    </a>-->
<!--</li>-->