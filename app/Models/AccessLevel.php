<?php namespace App\Models;

use App\Models\Main;
use App\Models\Crud;
use CodeIgniter\Model;


class AccessLevel extends Model
{
    var $data = array();

    public function __construct()
    {
        $this->data['template'] = TEMPLATE;
        $this->data['path'] = PATH;
    }

    public
    function TicketNavigationAccessLevel()
    {
        $data = $this->data;
        $TicketArray = array();

        $TicketArray['navigation']['home'] = 'Home';
        $TicketArray['navigation']['dashboard'] = 'Dashboard';

        $TicketArray['navigation']['client']['b2c_add_new'] = 'Add New';
        $TicketArray['navigation']['bulk_pilgrim'] = 'Bulk Pilgrim';
        $TicketArray['navigation']['booking']['all'] = 'All';
        $TicketArray['navigation']['booking']['pending'] = 'Pending';
        $TicketArray['navigation']['booking']['confirm'] = 'Confirm';
        $TicketArray['navigation']['booking']['expire'] = 'Expire';
        $TicketArray['navigation']['booking']['cancel'] = 'Cancel';
        $TicketArray['navigation']['issue'] = 'Ticket Issue';
        $TicketArray['navigation']['reissue'] = 'Ticket ReIssue';
        $TicketArray['navigation']['refund'] = 'Ticket Refund';
        $TicketArray['navigation']['traveling_tomorrow'] = 'Traveling Tomorrow';
        $TicketArray['navigation']['adm'] = 'Ticket ADM';
        $TicketArray['navigation']['reports']['detail_wise'] = 'Detail Wise';
        $TicketArray['navigation']['reports']['country_wise'] = 'Country Wise';
        $TicketArray['navigation']['reports']['month_wise'] = 'Month Wise';
        $TicketArray['navigation']['reports']['year_wise'] = 'Year Wise';
        $TicketArray['navigation']['reports']['airline_wise'] = 'Airline Wise';
        $TicketArray['navigation']['reports']['group_wise'] = 'Group Wise';
        $TicketArray['navigation']['reports']['international'] = 'International';
        $TicketArray['navigation']['reports']['domestic'] = 'Domestic';

        $TicketArray['navigation']['reports']['vendors']['report']['issue_report'] = ' Ticket Issue';
        $TicketArray['navigation']['reports']['vendors']['report']['reissue_report'] = ' Ticket Reissue';
        $TicketArray['navigation']['reports']['vendors']['report']['refund_report'] = ' Refund ';
        $TicketArray['navigation']['reports']['vendors']['report']['adm_report'] = ' A D M ';
        $TicketArray['navigation']['reports']['vendors']['report']['group_wise_report'] = ' Group wise ';
        $TicketArray['navigation']['reports']['vendors']['report']['detail_report'] = ' Detail Report ';
        $TicketArray['navigation']['reports']['vendors']['report']['country_wise_report'] = ' Country Wise ';
        $TicketArray['navigation']['reports']['vendors']['report']['month_wise_report'] = ' Month Wise ';
        $TicketArray['navigation']['reports']['vendors']['report']['year_wise_report'] = ' Year Wise ';
        $TicketArray['navigation']['reports']['vendors']['report']['airline_wise_report'] = ' Airline Wise ';
        $TicketArray['navigation']['reports']['vendors']['report']['international_report'] = ' International';
        $TicketArray['navigation']['reports']['vendors']['report']['domestic_report'] = ' Domestic';
        $TicketArray['navigation']['reports']['vendors']['report']['detail_report_amount_wise_report'] = 'Detail Report Amount Wise';


        $TicketArray['navigation']['reports']['vendors']['export']['issue'] = ' Ticket Issue ';
        $TicketArray['navigation']['reports']['vendors']['export']['reissue'] = ' Ticket Reissue ';
        $TicketArray['navigation']['reports']['vendors']['export']['refund'] = ' Refund  ';
        $TicketArray['navigation']['reports']['vendors']['export']['adm'] = ' A D M  ';
        $TicketArray['navigation']['reports']['vendors']['export']['group_wise'] = ' Group wise ';
        $TicketArray['navigation']['reports']['vendors']['export']['detail'] = ' Detail Report ';
        $TicketArray['navigation']['reports']['vendors']['export']['country_wise'] = ' Country Wise ';
        $TicketArray['navigation']['reports']['vendors']['export']['month_wise'] = ' Month Wise ';
        $TicketArray['navigation']['reports']['vendors']['export']['year_wise'] = ' Year Wise ';
        $TicketArray['navigation']['reports']['vendors']['export']['airline_wise'] = ' Airline Wise ';
        $TicketArray['navigation']['reports']['vendors']['export']['international'] = ' International ';
        $TicketArray['navigation']['reports']['vendors']['export']['domestic'] = ' Domestic ';
        $TicketArray['navigation']['reports']['vendors']['export']['detail_report_amount_wise'] = ' Detail Report Amount Wise ';

        $TicketArray['navigation']['visitors'] = 'Visitors';
        $TicketArray['navigation']['query'] = 'Query';
        $TicketArray['navigation']['inbox'] = 'Inbox';
        $TicketArray['navigation']['wallet'] = 'Wallet';
        $TicketArray['navigation']['users']['add'] = 'Add New';
        $TicketArray['navigation']['users']['update'] = 'Update';
        $TicketArray['navigation']['users']['delete'] = 'Delete';

        ksort($TicketArray);

        return $TicketArray;
    }

    public
    function accountantAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_services_packages_b2b',
            'umrah_services_packages_b2b_add',
            'umrah_services_packages_b2b_copy',
            'umrah_services_packages_b2b_download',
            'umrah_services_packages_b2b_export',
            'umrah_services_packages_b2b_external',
            'umrah_services_packages_b2b_external_add',
            'umrah_services_packages_b2b_external_copy_package',
            'umrah_services_packages_b2b_external_download',
            'umrah_services_packages_b2b_external_export',
            'umrah_services_packages_b2b_external_list',
            'umrah_services_packages_b2b_external_Update',
            'umrah_services_packages_B2b_general',
            'umrah_services_packages_b2b_list',
            'umrah_services_packages_b2b_Update',
            'umrah_travel_check_all_voucher_change_status',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_approved_voucher_change_status',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_executed_voucher_change_status',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_pending_voucher_change_status',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_updated_voucher_change_status',
            'umrah_travel_check_updated_voucher_list'
        );

        return $FinalArray;
    }

    public
    function mofaAdminAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_activity_visa_management_manage_mofa',
            'umrah_activity_visa_management_manage_visa',
            'umrah_activity_visa_management_manage_visa_list',
            'umrah_activity_visa_management_manage_visa_update',
            'umrah_client_b2b_add_new',
            'umrah_client_b2b_list',
            'umrah_client_b2b_update',
            'umrah_client_external_agent_add_new',
            'umrah_client_external_agent_list',
            'umrah_client_external_agent_update',
            'umrah_data_uploader',
            'umrah_groups_pilgrim_transfer'
        );

        return $FinalArray;
    }

    public
    function voucherAdminAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_activity_visa_management_manage_mofa',
            'umrah_activity_visa_management_manage_visa',
            'umrah_activity_visa_management_manage_visa_list',
            'umrah_activity_visa_management_manage_visa_update',
            'umrah_client_b2b_add_new',
            'umrah_client_b2b_list',
            'umrah_client_b2b_update',
            'umrah_client_external_agent_add_new',
            'umrah_client_external_agent_list',
            'umrah_client_external_agent_update',
            'umrah_data_uploader',
            'umrah_services_extra_services',
            'umrah_services_hotel',
            'umrah_services_hotel_add_new',
            'umrah_services_hotel_amenities',
            'umrah_services_hotel_categories',
            'umrah_services_hotel_delete',
            'umrah_services_hotel_export',
            'umrah_services_hotel_facilities',
            'umrah_services_hotel_list',
            'umrah_services_hotel_print_download',
            'umrah_services_hotel_room_types',
            'umrah_services_hotel_update',
            'umrah_services_packages_b2b_add',
            'umrah_services_packages_b2b_external_add',
            'umrah_services_packages_b2b_external_list',
            'umrah_services_packages_b2b_external_Update',
            'umrah_services_packages_B2b_general',
            'umrah_services_packages_b2b_list',
            'umrah_services_packages_b2b_Update',
            'umrah_services_transport',
            'umrah_services_transport_add_new',
            'umrah_services_transport_border_cities',
            'umrah_services_transport_borders',
            'umrah_services_transport_companies',
            'umrah_services_transport_delete',
            'umrah_services_transport_export',
            'umrah_services_transport_list',
            'umrah_services_transport_print_download',
            'umrah_services_transport_sea_ports',
            'umrah_services_transport_sectors',
            'umrah_services_transport_type',
            'umrah_services_transport_update',
            'umrah_services_ziyarat',
            'umrah_services_ziyarat_add',
            'umrah_services_ziyarat_delete',
            'umrah_services_ziyarat_export',
            'umrah_services_ziyarat_list',
            'umrah_services_ziyarat_print_download',
            'umrah_services_ziyarat_update',
            'umrah_travel_check_all_voucher_add',
            'umrah_travel_check_all_voucher_add_refund',
            'umrah_travel_check_all_voucher_change_status',
            'umrah_travel_check_all_voucher_edit',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_update_history',
            'umrah_travel_check_approved_voucher_add',
            'umrah_travel_check_approved_voucher_change_status',
            'umrah_travel_check_approved_voucher_edit',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_update_history',
            'umrah_travel_check_b2c_voucher_add_refund',
            'umrah_travel_check_b2c_voucher_add_voucher',
            'umrah_travel_check_b2c_voucher_change_status',
            'umrah_travel_check_b2c_voucher_edit',
            'umrah_travel_check_b2c_voucher_list',
            'umrah_travel_check_b2c_voucher_update_history',
            'umrah_travel_check_create_voucher',
            'umrah_travel_check_executed_voucher_change_status',
            'umrah_travel_check_executed_voucher_edit',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_update_history',
            'umrah_travel_check_pending_voucher_add',
            'umrah_travel_check_pending_voucher_change_status',
            'umrah_travel_check_pending_voucher_edit',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_update_history',
            'umrah_travel_check_refund_voucher_edit',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_update_history',
            'umrah_travel_check_updated_voucher_add',
            'umrah_travel_check_updated_voucher_change_status',
            'umrah_travel_check_updated_voucher_edit',
            'umrah_travel_check_updated_voucher_list',
            'umrah_travel_check_updated_voucher_update_history',
            'umrah_travel_check_wdout_voucher_arrival_list'
        );

        return $FinalArray;
    }

    public
    function SalesOfficerPreDefinedAccessLevel()
    {
        $FinalArray = array(
            'sales_dashboard'
        );

        return $FinalArray;
    }

    public
    function activityInchargeAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_activity_actual_pilgrim_activity_actual_hotel_activities_list',
            'umrah_activity_actual_pilgrim_activity_actual_hotel_activities_manage',
            'umrah_activity_actual_pilgrim_activity_actual_hotel_activities_refund_voucher',
            'umrah_activity_actual_pilgrim_activity_actual_transport_activities_list',
            'umrah_activity_actual_pilgrim_activity_actual_transport_activities_manage',
            'umrah_activity_actual_pilgrim_activity_actual_transport_activities_refund_voucher',
            'umrah_activity_allow_pilgrim_activity_allow_hotel_activities',
            'umrah_activity_allow_pilgrim_activity_allow_hotel_activities_list',
            'umrah_activity_allow_pilgrim_activity_allow_hotel_activities_manage',
            'umrah_activity_allow_pilgrim_activity_allow_hotel_activities_refund_voucher',
            'umrah_activity_allow_pilgrim_activity_allow_transport_activities_list',
            'umrah_activity_allow_pilgrim_activity_allow_transport_activities_manage',
            'umrah_activity_allow_pilgrim_activity_allow_transport_activities_refund_voucher'
        );

        return $FinalArray;
    }

    public
    function saleAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_client_b2b_list',
            'umrah_client_external_agent_list',
            'umrah_dashboard',
            'umrah_groups_manage_complete_list',
            'umrah_groups_manage_incomplete_list',
            'umrah_groups_pilgrim_b2b_list',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_print',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_print',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_print',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_print',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_print',
            'umrah_travel_check_updated_voucher_list',
            'umrah_travel_check_updated_voucher_print',
            'umrah_travel_check_wdout_voucher_arrival_export',
            'umrah_travel_check_wdout_voucher_arrival_list'
        );
        return $FinalArray;
    }

    public
    function externalAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_client_external_agent_sub_agents_add_new',
            'umrah_client_external_agent_sub_agents_list',
            'umrah_dashboard',
            'umrah_groups_create_new',
            'umrah_groups_manage_complete_create_group_new',
            'umrah_groups_manage_complete_list',
            'umrah_groups_manage_incomplete_create_group_new',
            'umrah_groups_manage_incomplete_list',
            'umrah_groups_pilgrim_b2b',
            'umrah_groups_pilgrim_b2b_list',
            'umrah_groups_pilgrim_b2c_list',
            'umrah_groups_pilgrim_new_registration',
            'umrah_groups_pilgrim_transfer',
            'umrah_inbox',
            'umrah_query',
            'umrah_query_list',
            'umrah_reports',
            'umrah_reports_stats',
            'umrah_reports_status_stats',
            'umrah_reports_vendors',
            'umrah_reports_stats_export_external_agent_monitor_screen',
            'umrah_reports_stats_export_group_stats',
            'umrah_reports_stats_export_manage_pilgrim',
            'umrah_reports_stats_export_voucher_issue',
            'umrah_reports_stats_export_without_voucher_arrival',
            'umrah_reports_stats_report_external_agent_monitor_screen',
            'umrah_reports_stats_report_group_stats',
            'umrah_reports_stats_report_manage_pilgrim',
            'umrah_reports_stats_report_voucher_issue',
            'umrah_reports_stats_report_without_voucher_arrival',
            'umrah_reports_status_stats_export_arrival',
            'umrah_reports_status_stats_export_check_in_jeddah',
            'umrah_reports_status_stats_export_check_in_mecca',
            'umrah_reports_status_stats_export_check_in_medina',
            'umrah_reports_status_stats_export_exit',
            'umrah_reports_status_stats_export_pax_in_jeddah',
            'umrah_reports_status_stats_export_pax_in_mecca',
            'umrah_reports_status_stats_export_pax_in_medina',
            'umrah_reports_status_stats_export_pax_in_saudiarabia',
            'umrah_reports_status_stats_export_total_pax',
            'umrah_reports_status_stats_export_voucher_issued',
            'umrah_reports_status_stats_export_voucher_not_issued',
            'umrah_reports_status_stats_report_arrival',
            'umrah_reports_status_stats_report_check_in_jeddah',
            'umrah_reports_status_stats_report_check_in_mecca',
            'umrah_reports_status_stats_report_check_in_medina',
            'umrah_reports_status_stats_report_exit',
            'umrah_reports_status_stats_report_pax_in_jeddah',
            'umrah_reports_status_stats_report_pax_in_mecca',
            'umrah_reports_status_stats_report_pax_in_medina',
            'umrah_reports_status_stats_report_pax_in_saudiarabia',
            'umrah_reports_status_stats_report_total_pax',
            'umrah_reports_status_stats_report_voucher_issued',
            'umrah_reports_status_stats_report_voucher_not_issued',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_print',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_print',
            'umrah_travel_check_create_voucher',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_print',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_print',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_print',
            'umrah_travel_check_wdout_voucher_arrival_export',
            'umrah_travel_check_wdout_voucher_arrival_list',
            'umrah_wallet',
        );

        return $FinalArray;
    }

    public
    function agentAccessLevel()
    {
        $FinalArray = array(
            'umrah_client_external_agent_sub_agents_add_new',
            'umrah_client_external_agent_sub_agents_list',
            'umrah_dashboard',
            'umrah_groups_create_new',
            'umrah_groups_manage_complete_create_group_new',
            'umrah_groups_manage_complete_list',
            'umrah_groups_manage_incomplete_create_group_new',
            'umrah_groups_manage_incomplete_list',
            'umrah_groups_pilgrim_b2b',
            'umrah_groups_pilgrim_b2b_list',
            'umrah_groups_pilgrim_b2c_list',
            'umrah_groups_pilgrim_new_registration',
            'umrah_groups_pilgrim_transfer',
            'umrah_inbox',
            'umrah_query',
            'umrah_query_list',
            'umrah_reports',
            'umrah_reports_stats',
            'umrah_reports_status_stats',
            'umrah_reports_vendors',
            'umrah_reports_stats_export_external_agent_monitor_screen',
            'umrah_reports_stats_export_group_stats',
            'umrah_reports_stats_export_manage_pilgrim',
            'umrah_reports_stats_export_voucher_issue',
            'umrah_reports_stats_export_without_voucher_arrival',
            'umrah_reports_stats_report_external_agent_monitor_screen',
            'umrah_reports_stats_report_group_stats',
            'umrah_reports_stats_report_manage_pilgrim',
            'umrah_reports_stats_report_voucher_issue',
            'umrah_reports_stats_report_without_voucher_arrival',
            'umrah_reports_status_stats_export_arrival',
            'umrah_reports_status_stats_export_check_in_jeddah',
            'umrah_reports_status_stats_export_check_in_mecca',
            'umrah_reports_status_stats_export_check_in_medina',
            'umrah_reports_status_stats_export_exit',
            'umrah_reports_status_stats_export_pax_in_jeddah',
            'umrah_reports_status_stats_export_pax_in_mecca',
            'umrah_reports_status_stats_export_pax_in_medina',
            'umrah_reports_status_stats_export_pax_in_saudiarabia',
            'umrah_reports_status_stats_export_total_pax',
            'umrah_reports_status_stats_export_voucher_issued',
            'umrah_reports_status_stats_export_voucher_not_issued',
            'umrah_reports_status_stats_report_arrival',
            'umrah_reports_status_stats_report_check_in_jeddah',
            'umrah_reports_status_stats_report_check_in_mecca',
            'umrah_reports_status_stats_report_check_in_medina',
            'umrah_reports_status_stats_report_exit',
            'umrah_reports_status_stats_report_pax_in_jeddah',
            'umrah_reports_status_stats_report_pax_in_mecca',
            'umrah_reports_status_stats_report_pax_in_medina',
            'umrah_reports_status_stats_report_pax_in_saudiarabia',
            'umrah_reports_status_stats_report_total_pax',
            'umrah_reports_status_stats_report_voucher_issued',
            'umrah_reports_status_stats_report_voucher_not_issued',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_print',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_print',
            'umrah_travel_check_create_voucher',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_print',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_print',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_print',
            'umrah_travel_check_wdout_voucher_arrival_export',
            'umrah_travel_check_wdout_voucher_arrival_list',
            'umrah_wallet',
        );

        return $FinalArray;
    }

    public
    function adminAgentAccessLevel()
    {
        $FinalArray = array(
            'umrah_client'

        );
        return $FinalArray;
    }

    public
    function subadminAccessLevel()
    {
        $FinalArray = array(
            'umrah_brn_management',
            'umrah_brn_management_hotel_brn',
            'umrah_brn_management_hotel_brn_brn_delete',
            'umrah_brn_management_hotel_brn_brn_update',
            'umrah_brn_management_hotel_brn_create_new_brn',
            'umrah_brn_management_hotel_brn_list',
            'umrah_brn_management_promo_code',
            'umrah_brn_management_promo_code_create_new_promo',
            'umrah_brn_management_promo_code_delete',
            'umrah_brn_management_promo_code_list',
            'umrah_brn_management_promo_code_update',
            'umrah_brn_management_transport_brn',
            'umrah_brn_management_transport_brn_create_new',
            'umrah_brn_management_transport_brn_delete',
            'umrah_brn_management_transport_brn_list',
            'umrah_brn_management_transport_brn_update',
            'umrah_client',
            'umrah_client_b2b',
            'umrah_client_b2b_add_new',
            'umrah_client_b2b_delete',
            'umrah_client_b2b_export',
            'umrah_client_b2b_list',
            'umrah_client_b2b_update',
            'umrah_client_b2c',
            'umrah_client_b2c_add_new',
            'umrah_client_b2c_list',
            'umrah_client_external_agent',
            'umrah_client_external_agent_add_new',
            'umrah_client_external_agent_delete',
            'umrah_client_external_agent_list',
            'umrah_client_external_agent_sub_agents',
            'umrah_client_external_agent_sub_agents_add_new',
            'umrah_client_external_agent_sub_agents_list',
            'umrah_client_external_agent_update',
            'umrah_client_sale_agents',
            'umrah_client_sale_agents_add_new',
            'umrah_client_sale_agents_delete',
            'umrah_client_sale_agents_export',
            'umrah_client_sale_agents_list',
            'umrah_client_sale_agents_update',
            'umrah_dashboard',
            'umrah_groups_create_new',
            'umrah_groups_deleted_groups',
            'umrah_groups_manage',
            'umrah_groups_manage_complete',
            'umrah_groups_manage_complete_create_group_new',
            'umrah_groups_manage_complete_delete',
            'umrah_groups_manage_complete_export',
            'umrah_groups_manage_complete_list',
            'umrah_groups_manage_complete_update',
            'umrah_groups_manage_incomplete',
            'umrah_groups_manage_incomplete_create_group_new',
            'umrah_groups_manage_incomplete_delete',
            'umrah_groups_manage_incomplete_export',
            'umrah_groups_manage_incomplete_list',
            'umrah_groups_manage_incomplete_update',
            'umrah_groups_pilgrim',
            'umrah_groups_pilgrim_b2b',
            'umrah_groups_pilgrim_b2b_add_new',
            'umrah_groups_pilgrim_b2b_export',
            'umrah_groups_pilgrim_b2b_list',
            'umrah_groups_pilgrim_b2b_update',
            'umrah_groups_pilgrim_b2b_update_b2b_visa_detail',
            'umrah_groups_pilgrim_b2c',
            'umrah_groups_pilgrim_b2c_add_new',
            'umrah_groups_pilgrim_b2c_export',
            'umrah_groups_pilgrim_b2c_list',
            'umrah_groups_pilgrim_b2c_update',
            'umrah_groups_pilgrim_b2c_update_b2c_visa_detail',
            'umrah_groups_pilgrim_new_registration',
            'umrah_groups_pilgrim_pilgrim_title_options',
            'umrah_groups_pilgrim_pilgrim_title_options_add',
            'umrah_groups_pilgrim_pilgrim_title_options_delete',
            'umrah_groups_pilgrim_pilgrim_title_options_list',
            'umrah_groups_pilgrim_pilgrim_title_options_update',
            'umrah_groups_pilgrim_transfer',
            'umrah_home',
            'umrah_inbox',
            'umrah_query',
            'umrah_query_add',
            'umrah_query_list',
            'umrah_reports',
            'umrah_reports_stats',
            'umrah_reports_stats_export',
            'umrah_reports_stats_export_actual_hotel',
            'umrah_reports_stats_export_actual_used_transport',
            'umrah_reports_stats_export_agent_monitor_screen',
            'umrah_reports_stats_export_agent_work',
            'umrah_reports_stats_export_approved_voucher',
            'umrah_reports_stats_export_arrival_airport',
            'umrah_reports_stats_export_arrival_hotel',
            'umrah_reports_stats_export_arrival_summary',
            'umrah_reports_stats_export_bed_loss',
            'umrah_reports_stats_export_departure_airport',
            'umrah_reports_stats_export_departure_hotel',
            'umrah_reports_stats_export_elm_data_summary_daywise',
            'umrah_reports_stats_export_executed_voucher',
            'umrah_reports_stats_export_external_agent_monitor_screen',
            'umrah_reports_stats_export_group_stats',
            'umrah_reports_stats_export_hotel_arrangement',
            'umrah_reports_stats_export_hotel_brn_balance_actual',
            'umrah_reports_stats_export_hotel_brn_balance_visa',
            'umrah_reports_stats_export_hotel_brn_purchase',
            'umrah_reports_stats_export_hotel_brn_summary',
            'umrah_reports_stats_export_hotel_brn_use_actual',
            'umrah_reports_stats_export_hotel_brn_use_visa',
            'umrah_reports_stats_export_hotel_sale_summary',
            'umrah_reports_stats_export_hotel_summary',
            'umrah_reports_stats_export_late_departure',
            'umrah_reports_stats_export_manage_pilgrim',
            'umrah_reports_stats_export_passport_complete',
            'umrah_reports_stats_export_passport_pending',
            'umrah_reports_stats_export_pilgrim_count',
            'umrah_reports_stats_export_refund_voucher',
            'umrah_reports_stats_export_seat_loss',
            'umrah_reports_stats_export_service_sale_summary',
            'umrah_reports_stats_export_status_summary',
            'umrah_reports_stats_export_tafeej_reports',
            'umrah_reports_stats_export_tafeej_reports_print',
            'umrah_reports_stats_export_transport_brn_balance_actual',
            'umrah_reports_stats_export_transport_brn_balance_visa',
            'umrah_reports_stats_export_transport_brn_purchase',
            'umrah_reports_stats_export_transport_brn_summary',
            'umrah_reports_stats_export_transport_brn_use_actual',
            'umrah_reports_stats_export_transport_brn_use_visa',
            'umrah_reports_stats_export_transport_sale_summary',
            'umrah_reports_stats_export_update_voucher',
            'umrah_reports_stats_export_used_transport_summary',
            'umrah_reports_stats_export_vehicle_arrangement',
            'umrah_reports_stats_export_voucher_issue',
            'umrah_reports_stats_export_voucher_not_approved',
            'umrah_reports_stats_export_voucher_summary',
            'umrah_reports_stats_export_without_voucher_arrival',
            'umrah_reports_stats_export_without_voucher_arrival_add_remarks',
            'umrah_reports_stats_report',
            'umrah_reports_stats_report_actual_hotel',
            'umrah_reports_stats_report_actual_used_transport',
            'umrah_reports_stats_report_agent_monitor_screen',
            'umrah_reports_stats_report_agent_work',
            'umrah_reports_stats_report_approved_voucher',
            'umrah_reports_stats_report_arrival_airport',
            'umrah_reports_stats_report_arrival_hotel',
            'umrah_reports_stats_report_arrival_summary',
            'umrah_reports_stats_report_bed_loss',
            'umrah_reports_stats_report_departure_airport',
            'umrah_reports_stats_report_departure_hotel',
            'umrah_reports_stats_report_elm_data_summary_daywise',
            'umrah_reports_stats_report_executed_voucher',
            'umrah_reports_stats_report_external_agent_monitor_screen',
            'umrah_reports_stats_report_group_stats',
            'umrah_reports_stats_report_hotel_arrangement',
            'umrah_reports_stats_report_hotel_brn_balance_actual',
            'umrah_reports_stats_report_hotel_brn_balance_visa',
            'umrah_reports_stats_report_hotel_brn_purchase',
            'umrah_reports_stats_report_hotel_brn_summary',
            'umrah_reports_stats_report_hotel_brn_use_actual',
            'umrah_reports_stats_report_hotel_brn_use_visa',
            'umrah_reports_stats_report_hotel_sale_summary',
            'umrah_reports_stats_report_hotel_summary',
            'umrah_reports_stats_report_late_departure',
            'umrah_reports_stats_report_manage_pilgrim',
            'umrah_reports_stats_report_passport_complete',
            'umrah_reports_stats_report_passport_pending',
            'umrah_reports_stats_report_pilgrim_count',
            'umrah_reports_stats_report_refund_voucher',
            'umrah_reports_stats_report_seat_loss',
            'umrah_reports_stats_report_service_sale_summary',
            'umrah_reports_stats_report_status_summary',
            'umrah_reports_stats_report_tafeejs_reports',
            'umrah_reports_stats_report_transport_brn_balance_actual',
            'umrah_reports_stats_report_transport_brn_balance_visa',
            'umrah_reports_stats_report_transport_brn_purchase',
            'umrah_reports_stats_report_transport_brn_summary',
            'umrah_reports_stats_report_transport_brn_use_actual',
            'umrah_reports_stats_report_transport_brn_use_visa',
            'umrah_reports_stats_report_transport_sale_summary',
            'umrah_reports_stats_report_update_voucher',
            'umrah_reports_stats_report_used_transport_summary',
            'umrah_reports_stats_report_vehicle_arrangement',
            'umrah_reports_stats_report_voucher_issue',
            'umrah_reports_stats_report_voucher_not_approved',
            'umrah_reports_stats_report_voucher_summary',
            'umrah_reports_stats_report_without_voucher_arrival',
            'umrah_reports_status_stats',
            'umrah_reports_status_stats_export',
            'umrah_reports_status_stats_export_allow_htl_jeddah',
            'umrah_reports_status_stats_export_allow_htl_mecca',
            'umrah_reports_status_stats_export_allow_htl_medina',
            'umrah_reports_status_stats_export_allow_tpt_arrival',
            'umrah_reports_status_stats_export_allow_tpt_departure',
            'umrah_reports_status_stats_export_allow_tpt_jeddah_chk_out',
            'umrah_reports_status_stats_export_allow_tpt_mecca_chk_out',
            'umrah_reports_status_stats_export_allow_tpt_medina_chk_out',
            'umrah_reports_status_stats_export_arrival',
            'umrah_reports_status_stats_export_b2b',
            'umrah_reports_status_stats_export_b2c',
            'umrah_reports_status_stats_export_check_in_jeddah',
            'umrah_reports_status_stats_export_check_in_mecca',
            'umrah_reports_status_stats_export_check_in_medina',
            'umrah_reports_status_stats_export_exit',
            'umrah_reports_status_stats_export_external',
            'umrah_reports_status_stats_export_free_bed',
            'umrah_reports_status_stats_export_mofa_issued',
            'umrah_reports_status_stats_export_mofa_not_issued',
            'umrah_reports_status_stats_export_over_25_days_arrival',
            'umrah_reports_status_stats_export_pax_in_jeddah',
            'umrah_reports_status_stats_export_pax_in_mecca',
            'umrah_reports_status_stats_export_pax_in_medina',
            'umrah_reports_status_stats_export_pax_in_saudiarabia',
            'umrah_reports_status_stats_export_ppt_management',
            'umrah_reports_status_stats_export_total_pax',
            'umrah_reports_status_stats_export_visa_issued',
            'umrah_reports_status_stats_export_voucher_issued',
            'umrah_reports_status_stats_export_voucher_not_issued',
            'umrah_reports_status_stats_export_without_vchr_arrival',
            'umrah_reports_status_stats_report',
            'umrah_reports_status_stats_report_allow_htl_jeddah',
            'umrah_reports_status_stats_report_allow_htl_mecca',
            'umrah_reports_status_stats_report_allow_htl_medina',
            'umrah_reports_status_stats_report_allow_tpt_arrival',
            'umrah_reports_status_stats_report_allow_tpt_departure',
            'umrah_reports_status_stats_report_allow_tpt_jeddah_chk_out',
            'umrah_reports_status_stats_report_allow_tpt_mecca_chk_out',
            'umrah_reports_status_stats_report_allow_tpt_medina_chk_out',
            'umrah_reports_status_stats_report_arrival',
            'umrah_reports_status_stats_report_b2b',
            'umrah_reports_status_stats_report_b2c',
            'umrah_reports_status_stats_report_check_in_jeddah',
            'umrah_reports_status_stats_report_check_in_mecca',
            'umrah_reports_status_stats_report_check_in_medina',
            'umrah_reports_status_stats_report_exit',
            'umrah_reports_status_stats_report_external',
            'umrah_reports_status_stats_report_free_bed',
            'umrah_reports_status_stats_report_mofa_issued',
            'umrah_reports_status_stats_report_mofa_not_issued',
            'umrah_reports_status_stats_report_over_25_days_arrival',
            'umrah_reports_status_stats_report_pax_in_jeddah',
            'umrah_reports_status_stats_report_pax_in_mecca',
            'umrah_reports_status_stats_report_pax_in_medina',
            'umrah_reports_status_stats_report_pax_in_saudiarabia',
            'umrah_reports_status_stats_report_ppt_management',
            'umrah_reports_status_stats_report_total_pax',
            'umrah_reports_status_stats_report_visa_issued',
            'umrah_reports_status_stats_report_voucher_issued',
            'umrah_reports_status_stats_report_voucher_not_issued',
            'umrah_reports_status_stats_report_without_vchr_arrival',
            'umrah_reports_vendors',
            'umrah_reports_vendors_export',
            'umrah_reports_vendors_export_hotel_brn_vendor',
            'umrah_reports_vendors_export_hotel_brn_vendor_summary',
            'umrah_reports_vendors_export_hotel_vendor',
            'umrah_reports_vendors_export_hotel_vendor_summary',
            'umrah_reports_vendors_export_tpt_brn_vendor',
            'umrah_reports_vendors_export_tpt_brn_vendor_summary',
            'umrah_reports_vendors_export_tpt_vendor_summary',
            'umrah_reports_vendors_export_transport_vendor',
            'umrah_reports_vendors_export_visa_vendor',
            'umrah_reports_vendors_export_visa_vendor_summary',
            'umrah_reports_vendors_report',
            'umrah_reports_vendors_report_hotel_brn_vendor',
            'umrah_reports_vendors_report_hotel_brn_vendor_summary',
            'umrah_reports_vendors_report_hotel_vendor',
            'umrah_reports_vendors_report_hotel_vendor_summary',
            'umrah_reports_vendors_report_tpt_brn_vendor',
            'umrah_reports_vendors_report_tpt_brn_vendor_summary',
            'umrah_reports_vendors_report_tpt_vendor_summary',
            'umrah_reports_vendors_report_transport_vendor',
            'umrah_reports_vendors_report_visa_vendor',
            'umrah_reports_vendors_report_visa_vendor_summary',
            'umrah_services_extra_services',
            'umrah_services_hotel',
            'umrah_services_hotel_add_new',
            'umrah_services_hotel_amenities',
            'umrah_services_hotel_categories',
            'umrah_services_hotel_delete',
            'umrah_services_hotel_export',
            'umrah_services_hotel_facilities',
            'umrah_services_hotel_list',
            'umrah_services_hotel_print_download',
            'umrah_services_hotel_room_types',
            'umrah_services_hotel_update',
            'umrah_services_operator',
            'umrah_services_operator_add',
            'umrah_services_operator_delete',
            'umrah_services_operator_list',
            'umrah_services_operator_update',
            'umrah_services_packages',
            'umrah_services_packages_b2b',
            'umrah_services_packages_b2b_add',
            'umrah_services_packages_b2b_copy',
            'umrah_services_packages_b2b_download',
            'umrah_services_packages_b2b_export',
            'umrah_services_packages_b2b_external',
            'umrah_services_packages_b2b_external_add',
            'umrah_services_packages_b2b_external_copy_package',
            'umrah_services_packages_b2b_external_download',
            'umrah_services_packages_b2b_external_export',
            'umrah_services_packages_b2b_external_list',
            'umrah_services_packages_b2b_external_Update',
            'umrah_services_packages_B2b_general',
            'umrah_services_packages_b2b_list',
            'umrah_services_packages_b2b_Update',
            'umrah_services_packages_b2c',
            'umrah_services_transport',
            'umrah_services_transport_add_new',
            'umrah_services_transport_border_cities',
            'umrah_services_transport_borders',
            'umrah_services_transport_companies',
            'umrah_services_transport_delete',
            'umrah_services_transport_export',
            'umrah_services_transport_list',
            'umrah_services_transport_print_download',
            'umrah_services_transport_sea_ports',
            'umrah_services_transport_sectors',
            'umrah_services_transport_type',
            'umrah_services_transport_update',
            'umrah_services_visa_type',
            'umrah_services_ziyarat',
            'umrah_services_ziyarat_add',
            'umrah_services_ziyarat_delete',
            'umrah_services_ziyarat_export',
            'umrah_services_ziyarat_list',
            'umrah_services_ziyarat_print_download',
            'umrah_services_ziyarat_update',
            'umrah_travel_check_all_voucher',
            'umrah_travel_check_all_voucher_add',
            'umrah_travel_check_all_voucher_add_refund',
            'umrah_travel_check_all_voucher_change_status',
            'umrah_travel_check_all_voucher_edit',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_print',
            'umrah_travel_check_all_voucher_update_history',
            'umrah_travel_check_approved_voucher',
            'umrah_travel_check_approved_voucher_add',
            'umrah_travel_check_approved_voucher_change_status',
            'umrah_travel_check_approved_voucher_edit',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_print',
            'umrah_travel_check_approved_voucher_update_history',
            'umrah_travel_check_b2c_voucher',
            'umrah_travel_check_b2c_voucher_add_refund',
            'umrah_travel_check_b2c_voucher_add_voucher',
            'umrah_travel_check_b2c_voucher_change_status',
            'umrah_travel_check_b2c_voucher_edit',
            'umrah_travel_check_b2c_voucher_list',
            'umrah_travel_check_b2c_voucher_print',
            'umrah_travel_check_b2c_voucher_update_history',
            'umrah_travel_check_create_voucher',
            'umrah_travel_check_executed_voucher',
            'umrah_travel_check_executed_voucher_change_status',
            'umrah_travel_check_executed_voucher_edit',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_print',
            'umrah_travel_check_executed_voucher_update_history',
            'umrah_travel_check_pending_voucher',
            'umrah_travel_check_pending_voucher_add',
            'umrah_travel_check_pending_voucher_change_status',
            'umrah_travel_check_pending_voucher_edit',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_print',
            'umrah_travel_check_pending_voucher_update_history',
            'umrah_travel_check_refund_voucher',
            'umrah_travel_check_refund_voucher_edit',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_print',
            'umrah_travel_check_refund_voucher_update_history',
            'umrah_travel_check_updated_voucher',
            'umrah_travel_check_updated_voucher_add',
            'umrah_travel_check_updated_voucher_change_status',
            'umrah_travel_check_updated_voucher_edit',
            'umrah_travel_check_updated_voucher_list',
            'umrah_travel_check_updated_voucher_print',
            'umrah_travel_check_updated_voucher_update_history',
            'umrah_travel_check_wdout_voucher_arrival',
            'umrah_travel_check_wdout_voucher_arrival_add_remarks',
            'umrah_travel_check_wdout_voucher_arrival_export',
            'umrah_travel_check_wdout_voucher_arrival_list',
            'umrah_wallet'
        );
        return $FinalArray;
    }

    public
    function subagentAccessLevel()
    {
        $FinalArray = array(
            'umrah_dashboard',
            'umrah_groups_create_new',
            'umrah_groups_manage_complete_create_group_new',
            'umrah_groups_manage_complete_list',
            'umrah_groups_manage_incomplete_create_group_new',
            'umrah_groups_manage_incomplete_list',
            'umrah_groups_pilgrim_b2b',
            'umrah_groups_pilgrim_b2b_list',
            'umrah_groups_pilgrim_b2c_list',
            'umrah_groups_pilgrim_new_registration',
            'umrah_inbox',
            'umrah_query',
            'umrah_query_list',
            'umrah_reports',
            'umrah_reports_stats',
            'umrah_reports_status_stats',
            'umrah_reports_vendors',
            'umrah_reports_stats_export_manage_pilgrim',
            'umrah_reports_stats_export_without_voucher_arrival',
            'umrah_reports_stats_report_manage_pilgrim',
            'umrah_reports_stats_report_without_voucher_arrival',
            'umrah_reports_status_stats_export_arrival',
            'umrah_reports_status_stats_export_check_in_jeddah',
            'umrah_reports_status_stats_export_check_in_mecca',
            'umrah_reports_status_stats_export_check_in_medina',
            'umrah_reports_status_stats_export_exit',
            'umrah_reports_status_stats_export_pax_in_jeddah',
            'umrah_reports_status_stats_export_pax_in_mecca',
            'umrah_reports_status_stats_export_pax_in_medina',
            'umrah_reports_status_stats_export_pax_in_saudiarabia',
            'umrah_reports_status_stats_export_total_pax',
            'umrah_reports_status_stats_export_voucher_issued',
            'umrah_reports_status_stats_export_voucher_not_issued',
            'umrah_reports_status_stats_report_arrival',
            'umrah_reports_status_stats_report_check_in_jeddah',
            'umrah_reports_status_stats_report_check_in_mecca',
            'umrah_reports_status_stats_report_check_in_medina',
            'umrah_reports_status_stats_report_exit',
            'umrah_reports_status_stats_report_pax_in_jeddah',
            'umrah_reports_status_stats_report_pax_in_mecca',
            'umrah_reports_status_stats_report_pax_in_medina',
            'umrah_reports_status_stats_report_pax_in_saudiarabia',
            'umrah_reports_status_stats_report_total_pax',
            'umrah_reports_status_stats_report_voucher_issued',
            'umrah_reports_status_stats_report_voucher_not_issued',
            'umrah_travel_check_all_voucher_list',
            'umrah_travel_check_all_voucher_print',
            'umrah_travel_check_approved_voucher_list',
            'umrah_travel_check_approved_voucher_print',
            'umrah_travel_check_create_voucher',
            'umrah_travel_check_executed_voucher_list',
            'umrah_travel_check_executed_voucher_print',
            'umrah_travel_check_pending_voucher_list',
            'umrah_travel_check_pending_voucher_print',
            'umrah_travel_check_refund_voucher_list',
            'umrah_travel_check_refund_voucher_print',
            'umrah_travel_check_wdout_voucher_arrival_export',
            'umrah_travel_check_wdout_voucher_arrival_list',
            'umrah_wallet'
        );

        return $FinalArray;
    }

    public
    function UmrahNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $UmrahArray = array();

//        $UmrahArray['navigation']['home'] = 'Home';
        $UmrahArray['navigation']['dashboard'] = 'Umrah Dashboard';
        $UmrahArray['navigation']['client']['b2c']['list'] = 'List';
        $UmrahArray['navigation']['client']['b2c']['add_new'] = 'Add New ';

        $UmrahArray['navigation']['client']['b2b']['list'] = 'List';
        $UmrahArray['navigation']['client']['b2b']['add_new'] = 'Add New';
        $UmrahArray['navigation']['client']['b2b']['export'] = 'Export';
        $UmrahArray['navigation']['client']['b2b']['update'] = 'Update';
        $UmrahArray['navigation']['client']['b2b']['delete'] = 'Delete';
        $UmrahArray['navigation']['client']['b2b']['current_access_level'] = 'Current Access level';


        $UmrahArray['navigation']['client']['sale_agents']['list'] = 'List';
        $UmrahArray['navigation']['client']['sale_agents']['add_new'] = 'Add New ';
        $UmrahArray['navigation']['client']['sale_agents']['export'] = 'Export ';
        $UmrahArray['navigation']['client']['sale_agents']['update'] = 'Update ';
        $UmrahArray['navigation']['client']['sale_agents']['delete'] = 'Delete ';
        $UmrahArray['navigation']['client']['sale_agents']['current_access_level'] = 'Current Access level ';


        $UmrahArray['navigation']['client']['external_agent']['list'] = 'List';
        $UmrahArray['navigation']['client']['external_agent']['add_new'] = 'Add New';
        $UmrahArray['navigation']['client']['external_agent']['update'] = ' Update';
        $UmrahArray['navigation']['client']['external_agent']['delete'] = 'Delete';
        $UmrahArray['navigation']['client']['external_agent']['current_access_level'] = 'Current Access level ';


        $UmrahArray['navigation']['client']['external_agent']['sub_agents']['list'] = 'List ';
        $UmrahArray['navigation']['client']['external_agent']['sub_agents']['add_new'] = 'Add New';
        $UmrahArray['navigation']['client']['external_agent']['sub_agents']['update'] = ' Update';
        $UmrahArray['navigation']['client']['external_agent']['sub_agents']['delete'] = 'Delete';
        $UmrahArray['navigation']['client']['external_agent']['sub_agents']['current_access_level'] = 'Current Access level ';

        $UmrahArray['navigation']['travel_check']['b2c_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['add_voucher'] = 'Add Voucher';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['update_history'] = 'Update History';
        $UmrahArray['navigation']['travel_check']['b2c_voucher']['add_refund'] = 'Add Refund';

        $UmrahArray['navigation']['travel_check']['create_voucher'] = 'Create Vouchers';

        $UmrahArray['navigation']['travel_check']['all_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['all_voucher']['add'] = 'Add Voucher';
        $UmrahArray['navigation']['travel_check']['all_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['all_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['all_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['all_voucher']['update_history'] = 'Update History';
        $UmrahArray['navigation']['travel_check']['all_voucher']['add_refund'] = 'Add Refund';

        $UmrahArray['navigation']['travel_check']['pending_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['pending_voucher']['add'] = 'Add Voucher';
        $UmrahArray['navigation']['travel_check']['pending_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['pending_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['pending_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['pending_voucher']['update_history'] = 'Update History';

        $UmrahArray['navigation']['travel_check']['approved_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['approved_voucher']['add'] = 'Add Voucher';
        $UmrahArray['navigation']['travel_check']['approved_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['approved_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['approved_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['approved_voucher']['update_history'] = 'Update History';

        $UmrahArray['navigation']['travel_check']['updated_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['updated_voucher']['add'] = 'Add Voucher';
        $UmrahArray['navigation']['travel_check']['updated_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['updated_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['updated_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['updated_voucher']['update_history'] = 'Update History';

        $UmrahArray['navigation']['travel_check']['executed_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['executed_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['executed_voucher']['change_status'] = ' Change Status';
        $UmrahArray['navigation']['travel_check']['executed_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['executed_voucher']['update_history'] = 'Update History';


        $UmrahArray['navigation']['travel_check']['refund_voucher']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['refund_voucher']['edit'] = ' Edit';
        $UmrahArray['navigation']['travel_check']['refund_voucher']['print'] = ' Print';
        $UmrahArray['navigation']['travel_check']['refund_voucher']['update_history'] = 'Update History';

        $UmrahArray['navigation']['travel_check']['wdout_voucher_arrival']['list'] = 'List';
        $UmrahArray['navigation']['travel_check']['wdout_voucher_arrival']['export'] = 'Export Record';
        $UmrahArray['navigation']['travel_check']['wdout_voucher_arrival']['add_remarks'] = 'Add Remarks';

        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_hotel_activities']['list'] = 'List';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_hotel_activities']['manage'] = 'Manage Allow hotel Activities ';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_hotel_activities']['refund_voucher'] = 'Refund Voucher ';

        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allowd_hotel_activities']['manage'] = 'Manage Allowd hotel Activities ';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allowd_hotel_activities']['refund_voucher'] = 'Refund Voucher ';


        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_transport_activities']['list'] = 'List';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_transport_activities']['manage'] = 'Manage Allow Transport Activities';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allow_transport_activities']['refund_voucher'] = 'Refund Voucher';

        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allowd_transport_activities']['manage'] = 'Manage Allowd Transport Activities';
        $UmrahArray['navigation']['activity']['allow_pilgrim_activity']['allowd_transport_activities']['refund_voucher'] = 'Refund Voucher';

        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_hotel_activities']['list'] = 'List';
        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_hotel_activities']['manage'] = 'Manage Actual Hotel Activities';
        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_hotel_activities']['refund_voucher'] = 'Refund Voucher';


        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_transport_activities']['list'] = 'List';
        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_transport_activities']['manage'] = 'Manage Actual Transport Activities';
        $UmrahArray['navigation']['activity']['actual_pilgrim_activity']['actual_transport_activities']['refund_voucher'] = 'Refund Voucher';

        $UmrahArray['navigation']['activity']['passport_management']['passport_pending'] = ' Passport pending';
        $UmrahArray['navigation']['activity']['passport_management']['passport_completed'] = 'Passport Completed';

        $UmrahArray['navigation']['activity']['visa_management']['manage_visa']['list'] = 'List';
        $UmrahArray['navigation']['activity']['visa_management']['manage_visa']['update'] = ' Update';
        $UmrahArray['navigation']['activity']['visa_management']['manage_mofa'] = ' Manage Mofa';

        $UmrahArray['navigation']['data_uploader'] = 'Data Uploader';

        $UmrahArray['navigation']['brn_management']['hotel_brn']['list'] = 'List';
        $UmrahArray['navigation']['brn_management']['hotel_brn']['create_new_brn'] = 'Create New BRN ';
        $UmrahArray['navigation']['brn_management']['hotel_brn']['brn_update'] = 'Update ';
        $UmrahArray['navigation']['brn_management']['hotel_brn']['brn_delete'] = 'Delete ';


        $UmrahArray['navigation']['brn_management']['transport_brn']['list'] = 'List';
        $UmrahArray['navigation']['brn_management']['transport_brn']['create_new'] = 'Create New BRN ';
        $UmrahArray['navigation']['brn_management']['transport_brn']['update'] = 'Update ';
        $UmrahArray['navigation']['brn_management']['transport_brn']['delete'] = 'Delete ';

        $UmrahArray['navigation']['brn_management']['promo_code']['list'] = 'List';
        $UmrahArray['navigation']['brn_management']['promo_code']['create_new_promo'] = 'Create New Promo ';
        $UmrahArray['navigation']['brn_management']['promo_code']['update'] = 'Update ';
        $UmrahArray['navigation']['brn_management']['promo_code']['delete'] = 'Delete ';

        $UmrahArray['navigation']['groups']['create_new'] = 'Create New Groups';

        $UmrahArray['navigation']['groups']['manage']['incomplete']['list'] = 'list';
        $UmrahArray['navigation']['groups']['manage']['incomplete']['create_group_new'] = 'Create Group new';
        $UmrahArray['navigation']['groups']['manage']['incomplete']['export'] = 'Export';
        $UmrahArray['navigation']['groups']['manage']['incomplete']['update'] = 'Update';
        $UmrahArray['navigation']['groups']['manage']['incomplete']['delete'] = 'Delete';


        $UmrahArray['navigation']['groups']['manage']['complete']['list'] = 'list';
        $UmrahArray['navigation']['groups']['manage']['complete']['create_group_new'] = 'Create Group new';
        $UmrahArray['navigation']['groups']['manage']['complete']['export'] = 'Export';
        $UmrahArray['navigation']['groups']['manage']['complete']['update'] = 'Update';
        $UmrahArray['navigation']['groups']['manage']['complete']['delete'] = 'Delete';

        $UmrahArray['navigation']['groups']['deleted_groups'] = 'Deleted Groups';

        $UmrahArray['navigation']['groups']['pilgrim']['b2b']['list'] = 'list';
        $UmrahArray['navigation']['groups']['pilgrim']['b2b']['add_new'] = 'Add New';
        $UmrahArray['navigation']['groups']['pilgrim']['b2b']['update'] = ' Update';
        $UmrahArray['navigation']['groups']['pilgrim']['b2b']['export'] = ' Export Pilgrim Details';
        $UmrahArray['navigation']['groups']['pilgrim']['b2b']['update_b2b_visa_detail'] = ' Update Visa Detail';


        $UmrahArray['navigation']['groups']['pilgrim']['b2c']['list'] = 'list';
        $UmrahArray['navigation']['groups']['pilgrim']['b2c']['add_new'] = 'Add New';
        $UmrahArray['navigation']['groups']['pilgrim']['b2c']['update'] = ' Update';
        $UmrahArray['navigation']['groups']['pilgrim']['b2c']['export'] = ' Export Pilgrim Details';
        $UmrahArray['navigation']['groups']['pilgrim']['b2c']['update_b2c_visa_detail'] = ' Update Visa Detail';


        $UmrahArray['navigation']['groups']['pilgrim']['new_registration'] = 'New Registration';

        $UmrahArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['list'] = 'list';
        $UmrahArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['add'] = ' Add Options';
        $UmrahArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['update'] = ' Update';
        $UmrahArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['delete'] = 'Delete';

        $UmrahArray['navigation']['groups']['pilgrim']['transfer'] = ' Pilgrim Transfer';


        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['manage_pilgrim_report'] = 'Manage Pilgrim Report';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['manage_pilgrim_export'] = 'Manage Pilgrim Export';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['pilgrim_count_report'] = ' Pilgrim Count';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['pilgrim_count_export'] = ' Pilgrim Count Export';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['group_stats_report'] = ' Group Stats';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['group_stats_export'] = ' Group Stats Export';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['elm_data_summary_daywise_report'] = ' ELM Data Summary DayWise';
        $UmrahArray['navigation']['reports']['stats']['pilgrim_management']['elm_data_summary_daywise_export'] = ' ELM Data Summary DayWise Export';
        $UmrahArray['navigation']['reports']['stats']['statistics']['status_summary_report'] = ' Status Summary Report';
        $UmrahArray['navigation']['reports']['stats']['statistics']['status_summary_export'] = ' Status Summary Export';
        $UmrahArray['navigation']['reports']['stats']['statistics']['agent_monitor_screen_report'] = ' Agent Monitor Screen Report';
        $UmrahArray['navigation']['reports']['stats']['statistics']['agent_monitor_screen_export'] = ' Agent Monitor Screen Export';
        $UmrahArray['navigation']['reports']['stats']['statistics']['external_monitor_screen_report'] = ' External Agent Monitor Screen';
        $UmrahArray['navigation']['reports']['stats']['statistics']['external_monitor_screen_export'] = ' External Agent Monitor Screen Export';
        $UmrahArray['navigation']['reports']['stats']['statistics']['agent_work_report'] = ' Agent Work Report';
        $UmrahArray['navigation']['reports']['stats']['statistics']['agent_work_report_export'] = ' Agent Work Report Export';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['arrival_airport_report'] = ' Arrival Airport';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['arrival_airport_export'] = ' Arrival Airport Export';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['late_departure_report'] = '  Late Departure ';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['late_departure_export'] = '  Late Departure Export ';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['departure_airport_report'] = ' Departure Airport ';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['departure_airport_export'] = ' Departure Airport Export ';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['departure_hotel_report'] = ' Departure Hotel ';
        $UmrahArray['navigation']['reports']['stats']['arrival_departure']['departure_hotel_export'] = ' Departure Hotel Export';
        $UmrahArray['navigation']['reports']['stats']['hotel']['arrival_hotel_report'] = ' Arrival Hotel';
        $UmrahArray['navigation']['reports']['stats']['hotel']['arrival_hotel_export'] = ' Arrival Hotel Export';
        $UmrahArray['navigation']['reports']['stats']['hotel']['actual_hotel_report'] = ' Actual Hotel Report';
        $UmrahArray['navigation']['reports']['stats']['hotel']['actual_hotel_export'] = ' Actual Hotel Report Export';
        $UmrahArray['navigation']['reports']['stats']['hotel']['bed_loss_report'] = '  Bed Loss ';
        $UmrahArray['navigation']['reports']['stats']['hotel']['bed_loss_export'] = '  Bed Loss Export';
        $UmrahArray['navigation']['reports']['stats']['hotel']['hotel_summary_report'] = ' Hotel Summary';
        $UmrahArray['navigation']['reports']['stats']['hotel']['hotel_summary_export'] = ' Hotel Summary Export';
        $UmrahArray['navigation']['reports']['stats']['hotel']['hotel_arrangement_report'] = ' Hotel Arrangement Report ';
        $UmrahArray['navigation']['reports']['stats']['hotel']['hotel_arrangement_export'] = ' Hotel Arrangement Report Export ';
        $UmrahArray['navigation']['reports']['stats']['transport']['actual_used_report'] = ' Actual Used Transport';
        $UmrahArray['navigation']['reports']['stats']['transport']['actual_used_export'] = ' Actual Used Transport Export';
        $UmrahArray['navigation']['reports']['stats']['transport']['seat_loss_report'] = ' Seat Loss';
        $UmrahArray['navigation']['reports']['stats']['transport']['seat_loss_export'] = ' Seat Loss Export';
        $UmrahArray['navigation']['reports']['stats']['transport']['arrival_summary_report'] = 'Arrival Summary Report';
        $UmrahArray['navigation']['reports']['stats']['transport']['arrival_summary_export'] = 'Arrival Summary Report Export';
        $UmrahArray['navigation']['reports']['stats']['transport']['used_transport_summary_report'] = 'Used Transport Summary';
        $UmrahArray['navigation']['reports']['stats']['transport']['used_transport_summary_export'] = 'Used Transport Summary Export';
        $UmrahArray['navigation']['reports']['stats']['transport']['vehicle_arrangement_report'] = 'Vehicle Arrangement Report';
        $UmrahArray['navigation']['reports']['stats']['transport']['vehicle_arrangement_export'] = 'Vehicle Arrangement Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_issue_report'] = 'Voucher Issue Report';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_issue_export'] = 'Voucher Issue Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_not_approved_report'] = 'Voucher Not Approved';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_not_approved_export'] = 'Voucher Not Approved Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['approved_voucher_report'] = 'Approved Voucher Report';
        $UmrahArray['navigation']['reports']['stats']['voucher']['approved_voucher_export'] = 'Approved Voucher Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['update_voucher_report'] = 'Update Voucher Report ';
        $UmrahArray['navigation']['reports']['stats']['voucher']['update_voucher_export'] = 'Update Voucher Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['refund_voucher_report'] = 'Refund Voucher Report';
        $UmrahArray['navigation']['reports']['stats']['voucher']['refund_voucher_export'] = 'Refund Voucher Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['executed_voucher_report'] = 'Executed Voucher Report';
        $UmrahArray['navigation']['reports']['stats']['voucher']['executed_voucher_export'] = 'Executed Voucher Report Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['without_voucher_arrival_report'] = 'Without Voucher Arrival';
        $UmrahArray['navigation']['reports']['stats']['voucher']['without_voucher_arrival_export'] = 'Without Voucher Arrival Export';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_summary_report'] = 'Voucher Summary';
        $UmrahArray['navigation']['reports']['stats']['voucher']['voucher_summary_export'] = 'Voucher Summary Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_purchase_report'] = 'Hotel BRN Purchase';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_purchase_export'] = 'Hotel BRN Purchase Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_use_visa_report'] = 'Hotel BRN Use Visa';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_use_visa_export'] = 'Hotel BRN Use Visa Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_balance_visa_report'] = 'Hotel BRN Balance Visa';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_balance_visa_export'] = 'Hotel BRN Balance Visa Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_use_actual_report'] = 'Hotel BRN Use Actual';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_use_actual_export'] = 'Hotel BRN Use Actual Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_balance_actual_report'] = 'Hotel BRN Balance Actual';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_balance_actual_export'] = 'Hotel BRN Balance Actual Export';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_summary_report'] = 'Hotel BRN Summary ';
        $UmrahArray['navigation']['reports']['stats']['brn_hotel']['hotel_brn_summary_export'] = 'Hotel BRN Summary Export ';

        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_purchase_report'] = 'Transport BRN Purchase ';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_purchase_export'] = 'Transport BRN Purchase Export ';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_use_visa_report'] = 'Transport BRN use Visa ';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_use_visa_export'] = 'Transport BRN use Visa Export ';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_balance_visa_report'] = 'Transport BRN Balance Visa  ';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_balance_visa_export'] = 'Transport BRN Balance Visa  Export';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_use_actual_report'] = 'Transport BRN Use Actual';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_use_actual_export'] = 'Transport BRN Use Actual Export';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_balance_actual_report'] = 'Transport BRN Balance Actual';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_balance_actual_export'] = 'Transport BRN Balance Actual Export';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_summary_report'] = 'Transport BRN Summary';
        $UmrahArray['navigation']['reports']['stats']['brn_transport']['transport_brn_summary_export'] = 'Transport BRN Summary Export';

        $UmrahArray['navigation']['reports']['stats']['passport_management']['passport_pending_report'] = 'Passport Pending ';
        $UmrahArray['navigation']['reports']['stats']['passport_management']['passport_pending_export'] = 'Passport Pending Export';
        $UmrahArray['navigation']['reports']['stats']['passport_management']['passport_complete_report'] = 'Passport Complete';
        $UmrahArray['navigation']['reports']['stats']['passport_management']['passport_complete_export'] = 'Passport Complete Export';

        $UmrahArray['navigation']['reports']['stats']['sale']['hotel_sale_summary_report'] = 'Hotel Sale Summary';
        $UmrahArray['navigation']['reports']['stats']['sale']['hotel_sale_summary_export'] = 'Hotel Sale Summary Export';
        $UmrahArray['navigation']['reports']['stats']['sale']['transport_sale_summary_report'] = 'Transport Sale Summary';
        $UmrahArray['navigation']['reports']['stats']['sale']['transport_sale_summary_export'] = 'Transport Sale Summary Export';
        $UmrahArray['navigation']['reports']['stats']['sale']['service_sale_summary_report'] = 'Service Sale Summary';
        $UmrahArray['navigation']['reports']['stats']['sale']['service_sale_summary_export'] = 'Service Sale Summary Export';

        $UmrahArray['navigation']['reports']['stats']['extras']['tafeej_report'] = ' Tafeej Report ';
        $UmrahArray['navigation']['reports']['stats']['extras']['tafeej_report_export'] = ' Tafeej Report Export';


        $UmrahArray['navigation']['reports']['status_stats']['report']['b2c'] = 'B2C';
        $UmrahArray['navigation']['reports']['status_stats']['report']['b2b'] = 'B2B';
        $UmrahArray['navigation']['reports']['status_stats']['report']['external'] = 'External';
        $UmrahArray['navigation']['reports']['status_stats']['report']['total_pax'] = 'Total Pax';
        $UmrahArray['navigation']['reports']['status_stats']['report']['mofa_issued'] = 'Mofa Issued';
        $UmrahArray['navigation']['reports']['status_stats']['report']['mofa_not_issued'] = 'Mofa Not Issued';
        $UmrahArray['navigation']['reports']['status_stats']['report']['visa_issued'] = 'Visa Issued';
        $UmrahArray['navigation']['reports']['status_stats']['report']['voucher_not_issued'] = 'Voucher Not Issued';
        $UmrahArray['navigation']['reports']['status_stats']['report']['voucher_issued'] = 'Voucher Issued';
        $UmrahArray['navigation']['reports']['status_stats']['report']['arrival'] = 'Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['report']['check_in_medina'] = 'Check In Medina';
        $UmrahArray['navigation']['reports']['status_stats']['report']['check_in_mecca'] = 'Check In Mecca';
        $UmrahArray['navigation']['reports']['status_stats']['report']['check_in_jeddah'] = 'Check In Jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['report']['exit'] = 'Exit';
        $UmrahArray['navigation']['reports']['status_stats']['report']['pax_in_mecca'] = 'Pax in Mecca';
        $UmrahArray['navigation']['reports']['status_stats']['report']['pax_in_medina'] = 'Pax in Medina';
        $UmrahArray['navigation']['reports']['status_stats']['report']['pax_in_jeddah'] = 'Pax in jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['report']['pax_in_saudiarabia'] = 'Pax in Saudi Arabia';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_tpt_arrival'] = 'Allow TPT Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_htl_mecca'] = 'Allow HTL Mecca';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_tpt_mecca_chk_out'] = 'Allow TPT Mecca(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_htl_medina'] = 'Allow HTL Medina';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_tpt_medina_chk_out'] = 'Allow TPT Medina(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_htl_jeddah'] = 'Allow HTL Jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_tpt_jeddah_chk_out'] = 'Allow TPT Jeddah(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['report']['allow_tpt_departure'] = 'Allow TPT Departure';
        $UmrahArray['navigation']['reports']['status_stats']['report']['free_bed'] = 'Free Bed';
        $UmrahArray['navigation']['reports']['status_stats']['report']['ppt_management'] = 'PPT Management';
        $UmrahArray['navigation']['reports']['status_stats']['report']['without_vchr_arrival'] = 'Without VCHR Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['report']['over_25_days_arrival'] = 'Over 25 Days Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['report']['hotel_brn_chart'] = 'Hotel BRN Chart';
        $UmrahArray['navigation']['reports']['status_stats']['report']['transport_brn_chart'] = 'Transport BRN Chart';
        $UmrahArray['navigation']['reports']['status_stats']['report']['transport_brn_chart'] = 'Transport BRN Chart';
        $UmrahArray['navigation']['reports']['status_stats']['report']['only_hotels_chart'] = 'Only Hotels Chart';
        $UmrahArray['navigation']['reports']['status_stats']['report']['only_transport_chart'] = 'Only Transport Chart';
        $UmrahArray['navigation']['reports']['status_stats']['report']['services_chart'] = 'Services Chart';


        $UmrahArray['navigation']['reports']['sales']['export']['organic_activities_stats'] = 'Organic Activities Stats';


        $UmrahArray['navigation']['reports']['status_stats']['export']['b2c'] = 'B2C';
        $UmrahArray['navigation']['reports']['status_stats']['export']['b2b'] = 'B2B';
        $UmrahArray['navigation']['reports']['status_stats']['export']['external'] = 'External';
        $UmrahArray['navigation']['reports']['status_stats']['export']['total_pax'] = 'Total Pax';
        $UmrahArray['navigation']['reports']['status_stats']['export']['mofa_issued'] = 'Mofa Issued';
        $UmrahArray['navigation']['reports']['status_stats']['export']['mofa_not_issued'] = 'Mofa Not Issued';
        $UmrahArray['navigation']['reports']['status_stats']['export']['visa_issued'] = 'Visa Issued';
        $UmrahArray['navigation']['reports']['status_stats']['export']['voucher_not_issued'] = 'Voucher Not Issued';
        $UmrahArray['navigation']['reports']['status_stats']['export']['voucher_issued'] = 'Voucher  Issued';
        $UmrahArray['navigation']['reports']['status_stats']['export']['arrival'] = 'Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['export']['check_in_medina'] = 'Check In Medina';
        $UmrahArray['navigation']['reports']['status_stats']['export']['check_in_mecca'] = 'Check In mecca';
        $UmrahArray['navigation']['reports']['status_stats']['export']['check_in_jeddah'] = 'Check In jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['export']['exit'] = 'Exit';
        $UmrahArray['navigation']['reports']['status_stats']['export']['pax_in_mecca'] = 'Pax in Mecca';
        $UmrahArray['navigation']['reports']['status_stats']['export']['pax_in_medina'] = 'Pax in Medina';
        $UmrahArray['navigation']['reports']['status_stats']['export']['pax_in_jeddah'] = 'Pax in jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['export']['pax_in_saudiarabia'] = 'Pax in Saudi Arabia';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_tpt_arrival'] = 'Allow TPT Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_htl_mecca'] = 'Allow HTL Mecca';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_tpt_mecca_chk_out'] = 'Allow TPT Mecca(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_htl_medina'] = 'Allow HTL Medina';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_tpt_medina_chk_out'] = 'Allow TPT Medina(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_htl_jeddah'] = 'Allow HTL Jeddah';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_tpt_jeddah_chk_out'] = 'Allow TPT Jeddah(Chk/Out)';
        $UmrahArray['navigation']['reports']['status_stats']['export']['allow_tpt_departure'] = 'Allow TPT Departure';
        $UmrahArray['navigation']['reports']['status_stats']['export']['free_bed'] = 'Free Bed';
        $UmrahArray['navigation']['reports']['status_stats']['export']['ppt_management'] = 'PPT Management';
        $UmrahArray['navigation']['reports']['status_stats']['export']['without_vchr_arrival'] = 'Without VCHR Arrival';
        $UmrahArray['navigation']['reports']['status_stats']['export']['over_25_days_arrival'] = 'Over 25 Days Arrival';


        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['hotel_brn_vendor_report'] = ' Hotel BRN Vendor  ';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['hotel_brn_vendor_export'] = ' Hotel BRN Vendor Export';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['tpt_brn_vendor_report'] = 'TPT BRN Vendor';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['tpt_brn_vendor_export'] = 'TPT BRN Vendor Export';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['visa_vendor_report'] = 'Visa Vendor';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['visa_vendor_export'] = 'Visa Vendor Export';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['hotel_vendor_report'] = 'Hotel Vendor';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['hotel_vendor_export'] = 'Hotel Vendor Export';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['transport_vendor_report'] = 'Transport Vendor';
        $UmrahArray['navigation']['reports']['vendors']['vendor_reports']['transport_vendor_export'] = 'Transport Vendor Export';

        $UmrahArray['navigation']['reports']['vendors']['summary']['hotel_brn_vendor_summary_report'] = 'Hotel BRN Vendor Summary';
        $UmrahArray['navigation']['reports']['vendors']['summary']['hotel_brn_vendor_summary_export'] = 'Hotel BRN Vendor Summary Export';
        $UmrahArray['navigation']['reports']['vendors']['summary']['tpt_brn_vendor_summary_report'] = 'TPT BRN Vendor Summary';
        $UmrahArray['navigation']['reports']['vendors']['summary']['tpt_brn_vendor_summary_export'] = 'TPT BRN Vendor Summary Export';
        $UmrahArray['navigation']['reports']['vendors']['summary']['visa_vendor_summary_report'] = 'Visa Vendor Summary';
        $UmrahArray['navigation']['reports']['vendors']['summary']['visa_vendor_summary_export'] = 'Visa Vendor Summary Export';
        $UmrahArray['navigation']['reports']['vendors']['summary']['hotel_vendor_summary_report'] = 'Hotel Vendor Summary';
        $UmrahArray['navigation']['reports']['vendors']['summary']['hotel_vendor_summary_export'] = 'Hotel Vendor Summary Export';
        $UmrahArray['navigation']['reports']['vendors']['summary']['tpt_vendor_summary_report'] = 'TPT Vendor Summary';
        $UmrahArray['navigation']['reports']['vendors']['summary']['tpt_vendor_summary_export'] = 'TPT Vendor Summary Export';


        $UmrahArray['navigation']['services']['hotel']['list'] = 'List';
        $UmrahArray['navigation']['services']['hotel']['add_new'] = 'Add New';
        $UmrahArray['navigation']['services']['hotel']['export'] = ' Export';
        $UmrahArray['navigation']['services']['hotel']['update'] = 'Update';
        $UmrahArray['navigation']['services']['hotel']['delete'] = 'Delete';
        $UmrahArray['navigation']['services']['hotel']['print_download'] = 'Print/Download';


        $UmrahArray['navigation']['services']['hotel']['categories'] = 'Categories';
//        $UmrahArray['navigation']['services']['hotel']['categories']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['hotel']['categories']['delete'] = 'Delete';


        $UmrahArray['navigation']['services']['hotel']['facilities'] = 'Facilities';
//        $UmrahArray['navigation']['services']['hotel']['facilities']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['hotel']['facilities']['delete'] = 'Delete';


        $UmrahArray['navigation']['services']['hotel']['amenities'] = 'Amenities';
//        $UmrahArray['navigation']['services']['hotel']['amenities']['update'] = ' Update';
//        $UmrahArray['navigation']['services']['hotel']['amenities']['delete'] = 'Delete';


        $UmrahArray['navigation']['services']['hotel']['room_types'] = 'Room Types';
//        $UmrahArray['navigation']['services']['hotel']['room_types']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['hotel']['room_types']['delete'] = 'Delete';

        $UmrahArray['navigation']['services']['transport']['list'] = 'List';
        $UmrahArray['navigation']['services']['transport']['add_new'] = 'Add New';
        $UmrahArray['navigation']['services']['transport']['export'] = 'Export';
        $UmrahArray['navigation']['services']['transport']['update'] = 'Update';
        $UmrahArray['navigation']['services']['transport']['delete'] = 'Delete';
        $UmrahArray['navigation']['services']['transport']['print_download'] = 'Print/Download';


        $UmrahArray['navigation']['services']['transport']['type'] = 'Type';
//        $UmrahArray['navigation']['services']['transport']['type']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['transport']['type']['delete'] = 'Delete';


        $UmrahArray['navigation']['services']['transport']['sectors'] = 'Sectors';
//        $UmrahArray['navigation']['services']['transport']['sectors']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['transport']['sectors']['delete'] = 'Delete';


        $UmrahArray['navigation']['services']['transport']['borders'] = 'Borders';
        $UmrahArray['navigation']['services']['transport']['border_cities'] = 'Border Cities';
//        $UmrahArray['navigation']['services']['transport']['borders']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['transport']['borders']['delete'] = 'Delete';

        $UmrahArray['navigation']['services']['transport']['sea_ports'] = 'Sea Ports';
//        $UmrahArray['navigation']['services']['transport']['sea_ports']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['transport']['sea_ports']['delete'] = 'Delete';

        $UmrahArray['navigation']['services']['transport']['companies'] = 'Companies';
//        $UmrahArray['navigation']['services']['transport']['companies']['update'] = 'Update';
//        $UmrahArray['navigation']['services']['transport']['companies']['delete'] = 'Delete';

        $UmrahArray['navigation']['services']['ziyarat']['list'] = 'List';
        $UmrahArray['navigation']['services']['ziyarat']['add'] = 'Add New';
        $UmrahArray['navigation']['services']['ziyarat']['update'] = 'Update';
        $UmrahArray['navigation']['services']['ziyarat']['delete'] = 'Delete';
        $UmrahArray['navigation']['services']['ziyarat']['print_download'] = 'Print/Download';
        $UmrahArray['navigation']['services']['ziyarat']['export'] = 'Export';


        $UmrahArray['navigation']['services']['packages']['b2b_external']['list'] = 'List';
        $UmrahArray['navigation']['services']['packages']['b2b_external']['copy_package'] = 'Copy Package';
        $UmrahArray['navigation']['services']['packages']['b2b_external']['add'] = 'Add New';
        $UmrahArray['navigation']['services']['packages']['b2b_external']['export'] = 'Export';
        $UmrahArray['navigation']['services']['packages']['b2b_external']['Update'] = 'Update';
        $UmrahArray['navigation']['services']['packages']['b2b_external']['download'] = 'Download';


        $UmrahArray['navigation']['services']['packages']['b2b']['list'] = 'List';
        $UmrahArray['navigation']['services']['packages']['b2b']['copy'] = 'Copy Package';
        $UmrahArray['navigation']['services']['packages']['b2b']['add'] = 'Add New';
        $UmrahArray['navigation']['services']['packages']['b2b']['export'] = 'Export';
        $UmrahArray['navigation']['services']['packages']['b2b']['Update'] = 'Update';
        $UmrahArray['navigation']['services']['packages']['b2b']['download'] = 'Download';

        $UmrahArray['navigation']['services']['packages']['B2b_general'] = 'B2B General';
        $UmrahArray['navigation']['services']['packages']['b2c'] = 'B2c ';

//        $UmrahArray['navigation']['services']['packages']['un_assign'] = 'Un assign';
        $UmrahArray['navigation']['services']['packages']['un_assign']['list'] = 'List';
//        $UmrahArray['navigation']['services']['packages']['un_assign']['copy'] = 'Copy Package';
        $UmrahArray['navigation']['services']['packages']['un_assign']['export'] = 'Export';
//        $UmrahArray['navigation']['services']['packages']['un_assign']['Update'] = 'Update';
        $UmrahArray['navigation']['services']['packages']['un_assign']['download'] = 'Download';


        $UmrahArray['navigation']['services']['visa_type'] = 'Visa Type';
//        $UmrahArray['navigation']['services']['visa_type']['update'] = 'Update ';
//        $UmrahArray['navigation']['services']['visa_type']['delete'] = 'Delete ';


        $UmrahArray['navigation']['services']['extra_services'] = 'Extra Services';
        /*  $UmrahArray['navigation']['services']['extra_services']['update'] = 'Update  ';
          $UmrahArray['navigation']['services']['extra_services']['delete'] = 'Delete  ';*/


        $UmrahArray['navigation']['services']['operator']['list'] = 'List';
        $UmrahArray['navigation']['services']['operator']['add'] = 'Add New  ';
        $UmrahArray['navigation']['services']['operator']['update'] = 'Update  ';
        $UmrahArray['navigation']['services']['operator']['delete'] = 'Delete  ';

        $UmrahArray['navigation']['lookups']['list'] = ' List ';
        $UmrahArray['navigation']['lookups']['options'] = ' List Options ';

        $UmrahArray['navigation']['users']['system_user']['list'] = 'List';
        $UmrahArray['navigation']['users']['system_user']['add'] = 'Add New';
        $UmrahArray['navigation']['users']['system_user']['update'] = 'Update';
        $UmrahArray['navigation']['users']['system_user']['delete'] = 'Delete';
        $UmrahArray['navigation']['users']['system_user']['current_access_level'] = 'Current Access level ';

        $UmrahArray['navigation']['users']['access_level'] = 'Access level';

        $UmrahArray['navigation']['settings']['mis'] = 'MIS Settings';
        $UmrahArray['navigation']['settings']['websites'] = 'Websites';
        $UmrahArray['navigation']['settings']['websites_domain']['update'] = 'Websites Domain ';
        $UmrahArray['navigation']['settings']['activity_log'] = 'Activity Log  ';
        $UmrahArray['navigation']['settings']['database_backup'] = 'Database Backup ';
        $UmrahArray['navigation']['settings']['agent_types'] = 'Agent Types ';

        $UmrahArray['navigation']['settings']['umrah_calender']['add'] = 'Add Umrah Calender';
        $UmrahArray['navigation']['settings']['umrah_calender']['update'] = 'Update Umrah Calender';


        $UmrahArray['navigation']['settings']['multi_languages']['languages'] = ' Languages';
        $UmrahArray['navigation']['settings']['multi_languages']['translation'] = ' Translation';
        $UmrahArray['navigation']['settings']['crone_activities']['crone'] = 'Cron Activities';


//        $UmrahArray['navigation']['query'] = 'Query';
        $UmrahArray['navigation']['query']['list'] = 'List';
        $UmrahArray['navigation']['query']['add'] = 'Add New';
        $UmrahArray['navigation']['inbox'] = 'Inbox';
        $UmrahArray['navigation']['wallet'] = 'Wallet';


        ksort($UmrahArray);
        return $UmrahArray;
    }

    public
    function HajjNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $HajjArray = array();

        $HajjArray['navigation']['home'] = 'Home';
        $HajjArray['navigation']['dashboard'] = 'Dashboard';
        $HajjArray['navigation']['client']['b2c']['add_new'] = 'Add New ';
        $HajjArray['navigation']['client']['b2c']['export_pilgrim_detail'] = 'Export pilgrim detail ';
        $HajjArray['navigation']['client']['b2c']['update'] = 'Update ';
        $HajjArray['navigation']['client']['b2c']['update_visa_detail'] = 'Update visa detail ';

        $HajjArray['navigation']['client']['b2b']['add_new'] = 'Add New ';
        $HajjArray['navigation']['client']['b2b']['export'] = 'Export';
        $HajjArray['navigation']['client']['b2b']['update'] = 'Update';
        $HajjArray['navigation']['client']['b2b']['delete'] = 'Delete';


        $HajjArray['navigation']['client']['sale_agents']['add_new'] = 'Add New ';
        $HajjArray['navigation']['client']['sale_agents']['export'] = 'Export ';
        $HajjArray['navigation']['client']['sale_agents']['update'] = 'Update ';
        $HajjArray['navigation']['client']['sale_agents']['delete'] = 'Delete ';

        $HajjArray['navigation']['client']['external_agent']['add_new'] = 'Add New';
        $HajjArray['navigation']['client']['external_agent']['update'] = ' Update';
        $HajjArray['navigation']['client']['external_agent']['delete'] = 'Delete';
        $HajjArray['navigation']['client']['external_agent']['list'] = 'List';

        $HajjArray['navigation']['client']['external_agent']['sub_agents']['add_new'] = 'Add New';

        $HajjArray['navigation']['travel_check']['b2c_voucher']['add_voucher'] = 'Add Voucher';

        $HajjArray['navigation']['travel_check']['create_voucher'] = 'Create Vouchers';
        $HajjArray['navigation']['travel_check']['all_voucher']['add'] = 'Add Voucher';
        $HajjArray['navigation']['travel_check']['all_voucher']['edit'] = ' Edit';
        $HajjArray['navigation']['travel_check']['all_voucher']['change_status'] = ' Change Status';
        $HajjArray['navigation']['travel_check']['all_voucher']['print'] = ' Print';
        $HajjArray['navigation']['travel_check']['all_voucher']['update_history'] = 'Update History';
        $HajjArray['navigation']['travel_check']['all_voucher']['add_refund'] = 'Add Refund';

        $HajjArray['navigation']['travel_check']['pending_voucher']['add'] = 'Add Voucher';
        $HajjArray['navigation']['travel_check']['pending_voucher']['edit'] = ' Edit';
        $HajjArray['navigation']['travel_check']['pending_voucher']['change_status'] = ' Change Status';
        $HajjArray['navigation']['travel_check']['pending_voucher']['print'] = ' Print';
        $HajjArray['navigation']['travel_check']['pending_voucher']['update_history'] = 'Update History';

        $HajjArray['navigation']['travel_check']['approved_voucher']['add'] = 'Add Voucher';

        $HajjArray['navigation']['travel_check']['updated_voucher']['add'] = 'Add Voucher';
        $HajjArray['navigation']['travel_check']['updated_voucher']['edit'] = ' Edit';
        $HajjArray['navigation']['travel_check']['updated_voucher']['change_status'] = ' Change Status';
        $HajjArray['navigation']['travel_check']['updated_voucher']['print'] = ' Print';
        $HajjArray['navigation']['travel_check']['updated_voucher']['update_history'] = 'Update History';

        $HajjArray['navigation']['travel_check']['executed_voucher']['edit'] = ' Edit';
        $HajjArray['navigation']['travel_check']['executed_voucher']['change_status'] = ' Change Status';
        $HajjArray['navigation']['travel_check']['executed_voucher']['print'] = ' Print';
        $HajjArray['navigation']['travel_check']['executed_voucher']['update_history'] = 'Update History';

        $HajjArray['navigation']['travel_check']['refund_voucher']['edit'] = ' Edit';
        $HajjArray['navigation']['travel_check']['refund_voucher']['print'] = ' Print';
        $HajjArray['navigation']['travel_check']['refund_voucher']['update_history'] = 'Update History';

        $HajjArray['navigation']['travel_check']['wdout_voucher_arrival']['export'] = 'Export Record';
        $HajjArray['navigation']['travel_check']['wdout_voucher_arrival']['add_remarks'] = 'Add Remarks';


        $HajjArray['navigation']['activity']['allow_pilgrim_activity']['allow_hotel_activities']['manage'] = 'Manage Allow hotel Activities ';
        $HajjArray['navigation']['activity']['allow_pilgrim_activity']['allow_hotel_activities']['refund_voucher'] = 'Refund Voucher ';


        $HajjArray['navigation']['activity']['allow_pilgrim_activity']['allow_transport_activities']['manage'] = 'Manage Allow Transport Activities';
        $HajjArray['navigation']['activity']['allow_pilgrim_activity']['allow_transport_activities']['refund_voucher'] = 'Refund Voucher';

        $HajjArray['navigation']['activity']['actual_pilgrim_activity']['actual_hotel_activities']['manage'] = 'Manage Actual Hotel Activities';
        $HajjArray['navigation']['activity']['actual_pilgrim_activity']['actual_hotel_activities']['refund_voucher'] = 'Refund Voucher';


        $HajjArray['navigation']['activity']['actual_pilgrim_activity']['actual_transport_activities']['manage'] = 'Manage Actual Transport Activities';
        $HajjArray['navigation']['activity']['actual_pilgrim_activity']['actual_transport_activities']['refund_voucher'] = 'Refund Voucher';

        $HajjArray['navigation']['activity']['passport_management']['passport_pending'] = ' Passport pending';
        $HajjArray['navigation']['activity']['passport_management']['passport_completed'] = 'Passport Completed';

        $HajjArray['navigation']['activity']['visa_management']['manage_visa']['update'] = ' Update';
        $HajjArray['navigation']['activity']['visa_management']['manage_mofa'] = ' Manage Mofa';


        $HajjArray['navigation']['data_uploader'] = 'Data Uploader';
        $HajjArray['navigation']['brn_management']['hotel_brn']['create_new_brn'] = 'Create New BRN ';
        $HajjArray['navigation']['brn_management']['hotel_brn']['brn_update'] = 'Update ';
        $HajjArray['navigation']['brn_management']['hotel_brn']['brn_delete'] = 'Delete ';


        $HajjArray['navigation']['brn_management']['transport_brn']['create_new_brn'] = 'Create New BRN ';
        $HajjArray['navigation']['brn_management']['promo_code']['create_new_promo'] = 'Create New Promo ';

        $HajjArray['navigation']['groups']['create_new'] = 'Create New Groups';


        $HajjArray['navigation']['groups']['manage']['incomplete']['create_group_new'] = 'Create Group new';
        $HajjArray['navigation']['groups']['manage']['incomplete']['export'] = 'Export';
        $HajjArray['navigation']['groups']['manage']['incomplete']['update'] = 'Update';
        $HajjArray['navigation']['groups']['manage']['incomplete']['delete'] = 'Delete';


        $HajjArray['navigation']['groups']['manage']['complete']['create_group_new'] = 'Create Group new';
        $HajjArray['navigation']['groups']['manage']['complete']['export'] = 'Export';
        $HajjArray['navigation']['groups']['manage']['complete']['update'] = 'Update';
        $HajjArray['navigation']['groups']['manage']['complete']['delete'] = 'Delete';

        $HajjArray['navigation']['groups']['deleted_groups'] = 'Deleted Groups';

        $HajjArray['navigation']['groups']['pilgrim']['add_new'] = 'Add New';
        $HajjArray['navigation']['groups']['pilgrim']['update'] = 'Update';
        $HajjArray['navigation']['groups']['pilgrim']['list'] = 'List';
        $HajjArray['navigation']['groups']['pilgrim']['export_pilgrim_detail'] = 'Export Pilgrim Details';
        $HajjArray['navigation']['groups']['pilgrim']['update_visa_detail'] = 'Update Visa Detail';

        $HajjArray['navigation']['groups']['pilgrim']['new_registration'] = 'New Registration';

        $HajjArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['add'] = ' Add Options';
        $HajjArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['update'] = ' Update';
        $HajjArray['navigation']['groups']['pilgrim']['pilgrim_title_options']['delete'] = 'Delete';

        $HajjArray['navigation']['groups']['pilgrim']['transfer'] = ' Pilgrim Transfer';
//hajj reports start here


        $HajjArray['navigation']['reports']['stats']['report']['manage_pilgrim'] = 'Manage Pilgrim Report';
        $HajjArray['navigation']['reports']['stats']['report']['pilgrim_count'] = ' Pilgrim Count';
        $HajjArray['navigation']['reports']['stats']['report']['group_stats'] = ' Group Stats';
        $HajjArray['navigation']['reports']['stats']['report']['elm_data_summary_daywise'] = ' ELM Data Summary DayWise';
        $HajjArray['navigation']['reports']['stats']['report']['status_summary'] = ' Status Summary Report';
        $HajjArray['navigation']['reports']['stats']['report']['agent_monitor_screen'] = 'Agent Monitor Screen Report';
        $HajjArray['navigation']['reports']['stats']['report']['external_agent_monitor_screen'] = 'External Agent Monitor Screen';
        $HajjArray['navigation']['reports']['stats']['report']['agent_work'] = 'Agent Work Report';
        $HajjArray['navigation']['reports']['stats']['report']['arrival_airport'] = 'Arrival Airport';
        $HajjArray['navigation']['reports']['stats']['report']['late_departure'] = 'Late Departure';
        $HajjArray['navigation']['reports']['stats']['report']['departure_airport'] = 'Departure Airport';
        $HajjArray['navigation']['reports']['stats']['report']['departure_hotel'] = 'Departure Hotel';
        $HajjArray['navigation']['reports']['stats']['report']['arrival_hotel'] = 'Arrival Hotel';
        $HajjArray['navigation']['reports']['stats']['report']['actual_hotel'] = 'Actual Hotel Report';
        $HajjArray['navigation']['reports']['stats']['report']['bed_loss'] = 'Bed Loss';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_summary'] = 'Hotel Summary';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_arrangement'] = 'Hotel Arrangement Report';
        $HajjArray['navigation']['reports']['stats']['report']['actual_used_transport'] = 'Actual Used Transport';
        $HajjArray['navigation']['reports']['stats']['report']['seat_loss'] = 'Seat Loss';
        $HajjArray['navigation']['reports']['stats']['report']['arrival_summary'] = 'Arrival Summary Report';
        $HajjArray['navigation']['reports']['stats']['report']['used_transport_summary'] = 'Used Transport Summary';
        $HajjArray['navigation']['reports']['stats']['report']['vehicle_arrangement'] = 'Vehicle Arrangement Report';
        $HajjArray['navigation']['reports']['stats']['report']['voucher_issue'] = 'Voucher Issue Report';
        $HajjArray['navigation']['reports']['stats']['report']['voucher_not_approved'] = 'Voucher Not Approved';
        $HajjArray['navigation']['reports']['stats']['report']['approved_voucher'] = 'Approved Voucher Report';
        $HajjArray['navigation']['reports']['stats']['report']['update_voucher'] = 'Update Voucher Report';
        $HajjArray['navigation']['reports']['stats']['report']['refund_voucher'] = 'Refund Voucher Report';
        $HajjArray['navigation']['reports']['stats']['report']['executed_voucher'] = 'Executed Voucher Report';
        $HajjArray['navigation']['reports']['stats']['report']['without_voucher_arrival'] = 'Without Voucher Arrival ';
        $HajjArray['navigation']['reports']['stats']['report']['without_voucher_arrival_add_remarks'] = 'Without Voucher Arrival dropdown(Add Remarks)';
        $HajjArray['navigation']['reports']['stats']['report']['voucher_summary'] = 'Voucher Summary';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_purchase'] = 'Hotel BRN Purchase';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_use_visa'] = 'Hotel BRN Use Visa';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_balance_visa'] = 'Hotel BRN Balance Visa';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_use_actual'] = 'Hotel BRN Use Actual';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_balance_actual'] = 'Hotel BRN Balance Actual';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_brn_summary'] = 'Hotel BRN Summary';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_purchase'] = 'Transport BRN Purchase';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_use_visa'] = 'Transport BRN use Visa';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_balance_visa'] = 'Transport BRN Balance Visa';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_use_actual'] = 'Transport BRN Use Actual';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_balance_actual'] = 'Transport BRN Balance Actual';
        $HajjArray['navigation']['reports']['stats']['report']['transport_brn_summary'] = 'Transport BRN Summary';
        $HajjArray['navigation']['reports']['stats']['report']['passport_pending'] = 'Passport Pending';
        $HajjArray['navigation']['reports']['stats']['report']['passport_complete'] = 'Passport Complete';
        $HajjArray['navigation']['reports']['stats']['report']['hotel_sale_summary'] = 'Hotel Sale Summary';
        $HajjArray['navigation']['reports']['stats']['report']['transport_sale_summary'] = 'Transport Sale Summary';
        $HajjArray['navigation']['reports']['stats']['report']['service_sale_summary'] = 'Service Sale Summary';
        $HajjArray['navigation']['reports']['stats']['report']['tafeejs_reports'] = 'Tafeej Report ';
        $HajjArray['navigation']['reports']['stats']['report']['tafeejs_reports_print'] = 'Tafeej Report dropdown(print)';


        $HajjArray['navigation']['reports']['stats']['export']['manage_pilgrim'] = 'Manage Pilgrim Report';
        $HajjArray['navigation']['reports']['stats']['export']['pilgrim_count'] = 'Pilgrim Count';
        $HajjArray['navigation']['reports']['stats']['export']['group_stats'] = 'Group Stats';
        $HajjArray['navigation']['reports']['stats']['export']['elm_data_summary_daywise'] = 'ELM Data Summary DayWise';
        $HajjArray['navigation']['reports']['stats']['export']['status_summary'] = 'Status Summary Report';
        $HajjArray['navigation']['reports']['stats']['export']['agent_monitor_screen'] = 'Agent Monitor Screen Report';
        $HajjArray['navigation']['reports']['stats']['export']['external_agent_monitor_screen'] = 'External Agent Monitor Screen Report';
        $HajjArray['navigation']['reports']['stats']['export']['agent_work'] = 'Agent Work Report';
        $HajjArray['navigation']['reports']['stats']['export']['arrival_airport'] = 'Arrival Airport';
        $HajjArray['navigation']['reports']['stats']['export']['late_departure'] = 'Late Departure';
        $HajjArray['navigation']['reports']['stats']['export']['departure_airport'] = 'Departure Airport';
        $HajjArray['navigation']['reports']['stats']['export']['departure_hotel'] = 'Departure Hotel';
        $HajjArray['navigation']['reports']['stats']['export']['arrival_hotel'] = 'Arrival Hotel';
        $HajjArray['navigation']['reports']['stats']['export']['actual_hotel'] = 'Actual Hotel Report';
        $HajjArray['navigation']['reports']['stats']['export']['bed_loss'] = 'Bed Loss';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_summary'] = 'Hotel Summary';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_arrangement'] = 'Hotel Arrangement Report';
        $HajjArray['navigation']['reports']['stats']['export']['actual_used_transport'] = 'Actual Used Transport';
        $HajjArray['navigation']['reports']['stats']['export']['seat_loss'] = 'Seat Loss';
        $HajjArray['navigation']['reports']['stats']['export']['arrival_summary'] = 'Arrival Summary Report';
        $HajjArray['navigation']['reports']['stats']['export']['used_transport_summary'] = 'Used Transport Summary';
        $HajjArray['navigation']['reports']['stats']['export']['vehicle_arrangement'] = 'Vehicle Arrangement Report';
        $HajjArray['navigation']['reports']['stats']['export']['voucher_issue'] = 'Voucher Issue Report';
        $HajjArray['navigation']['reports']['stats']['export']['voucher_not_approved'] = 'Voucher Not Approved';
        $HajjArray['navigation']['reports']['stats']['export']['approved_voucher'] = 'Approved Voucher Report';
        $HajjArray['navigation']['reports']['stats']['export']['update_voucher'] = 'Update Voucher Report';
        $HajjArray['navigation']['reports']['stats']['export']['refund_voucher'] = 'Refund Voucher Report';
        $HajjArray['navigation']['reports']['stats']['export']['executed_voucher'] = 'Executed Voucher Report';
        $HajjArray['navigation']['reports']['stats']['export']['without_voucher_arrival'] = 'Without Voucher Arrival (Add Remarks)';
        $HajjArray['navigation']['reports']['stats']['export']['voucher_summary'] = 'Voucher Summary';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_purchase'] = 'Hotel BRN Purchase';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_use_visa'] = 'Hotel BRN Use Visa';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_balance_visa'] = 'Hotel BRN Balance Visa';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_use_actual'] = 'Hotel BRN Use Actual';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_balance_actual'] = 'Hotel BRN Balance Actual';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_brn_summary'] = 'Hotel BRN Summary';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_purchase'] = 'Transport BRN Purchase';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_use_visa'] = 'Transport BRN use Visa';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_balance_visa'] = 'Transport BRN Balance Visa';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_use_actual'] = 'Transport BRN Use Actual';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_balance_actual'] = 'Transport BRN Balance Actual';
        $HajjArray['navigation']['reports']['stats']['export']['transport_brn_summary'] = 'Transport BRN Summary';
        $HajjArray['navigation']['reports']['stats']['export']['passport_pending'] = 'Passport Pending';
        $HajjArray['navigation']['reports']['stats']['export']['passport_complete'] = 'Passport Complete';
        $HajjArray['navigation']['reports']['stats']['export']['hotel_sale_summary'] = 'Hotel Sale Summary';
        $HajjArray['navigation']['reports']['stats']['export']['transport_sale_summary'] = 'Transport Sale Summary';
        $HajjArray['navigation']['reports']['stats']['export']['service_sale_summary'] = 'Service Sale Summary';
        $HajjArray['navigation']['reports']['stats']['export']['tafeej_reports'] = 'Tafeej Report dropdown(print)';


        $HajjArray['navigation']['reports']['status_stats']['report']['b2c'] = 'B2C';
        $HajjArray['navigation']['reports']['status_stats']['report']['b2b'] = 'B2B';
        $HajjArray['navigation']['reports']['status_stats']['report']['external'] = 'External';
        $HajjArray['navigation']['reports']['status_stats']['report']['total_pax'] = 'Total Pax';
        $HajjArray['navigation']['reports']['status_stats']['report']['mofa_issued'] = 'Mofa Issued';
        $HajjArray['navigation']['reports']['status_stats']['report']['mofa_not_issued'] = 'Mofa Not Issued';
        $HajjArray['navigation']['reports']['status_stats']['report']['visa_issued'] = 'Visa Issued';
        $HajjArray['navigation']['reports']['status_stats']['report']['voucher_not_issued'] = 'Voucher Not Issued';
        $HajjArray['navigation']['reports']['status_stats']['report']['voucher_issued'] = 'Voucher Issued';
        $HajjArray['navigation']['reports']['status_stats']['report']['arrival'] = 'Arrival';
        $HajjArray['navigation']['reports']['status_stats']['report']['check_in_medina'] = 'Check In Medina';
        $HajjArray['navigation']['reports']['status_stats']['report']['check_in_mecca'] = 'Check In Mecca';
        $HajjArray['navigation']['reports']['status_stats']['report']['check_in_jeddah'] = 'Check In Jeddah';
        $HajjArray['navigation']['reports']['status_stats']['report']['exit'] = 'Exit';
        $HajjArray['navigation']['reports']['status_stats']['report']['pax_in_mecca'] = 'Pax in Mecca';
        $HajjArray['navigation']['reports']['status_stats']['report']['pax_in_medina'] = 'Pax in Medina';
        $HajjArray['navigation']['reports']['status_stats']['report']['pax_in_jeddah'] = 'Pax in jeddah';
        $HajjArray['navigation']['reports']['status_stats']['report']['pax_in_saudiarabia'] = 'Pax in Saudi Arabia';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_tpt_arrival'] = 'Allow TPT Arrival';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_htl_mecca'] = 'Allow HTL Mecca';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_tpt_mecca_chk_out'] = 'Allow TPT Mecca(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_htl_medina'] = 'Allow HTL Medina';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_tpt_medina_chk_out'] = 'Allow TPT Medina(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_htl_jeddah'] = 'Allow HTL Jeddah';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_tpt_jeddah_chk_out'] = 'Allow TPT Jeddah(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['report']['allow_tpt_departure'] = 'Allow TPT Departure';
        $HajjArray['navigation']['reports']['status_stats']['report']['free_bed'] = 'Free Bed';
        $HajjArray['navigation']['reports']['status_stats']['report']['ppt_management'] = 'PPT Management';
        $HajjArray['navigation']['reports']['status_stats']['report']['without_vchr_arrival'] = 'Without VCHR Arrival';
        $HajjArray['navigation']['reports']['status_stats']['report']['over_25_days_arrival'] = 'Over 25 Days Arrival';


        $HajjArray['navigation']['reports']['status_stats']['export']['b2c'] = 'B2C';
        $HajjArray['navigation']['reports']['status_stats']['export']['b2b'] = 'B2B';
        $HajjArray['navigation']['reports']['status_stats']['export']['external'] = 'External';
        $HajjArray['navigation']['reports']['status_stats']['export']['total_pax'] = 'Total Pax';
        $HajjArray['navigation']['reports']['status_stats']['export']['mofa_issued'] = 'Mofa Issued';
        $HajjArray['navigation']['reports']['status_stats']['export']['mofa_not_issued'] = 'Mofa Not Issued';
        $HajjArray['navigation']['reports']['status_stats']['export']['visa_issued'] = 'Visa Issued';
        $HajjArray['navigation']['reports']['status_stats']['export']['voucher_not_issued'] = 'Voucher Not Issued';
        $HajjArray['navigation']['reports']['status_stats']['export']['voucher_issued'] = 'Voucher  Issued';
        $HajjArray['navigation']['reports']['status_stats']['export']['arrival'] = 'Arrival';
        $HajjArray['navigation']['reports']['status_stats']['export']['check_in_medina'] = 'Check In Medina';
        $HajjArray['navigation']['reports']['status_stats']['export']['check_in_mecca'] = 'Check In mecca';
        $HajjArray['navigation']['reports']['status_stats']['export']['check_in_jeddah'] = 'Check In jeddah';
        $HajjArray['navigation']['reports']['status_stats']['export']['exit'] = 'Exit';
        $HajjArray['navigation']['reports']['status_stats']['export']['pax_in_mecca'] = 'Pax in Mecca';
        $HajjArray['navigation']['reports']['status_stats']['export']['pax_in_medina'] = 'Pax in Medina';
        $HajjArray['navigation']['reports']['status_stats']['export']['pax_in_jeddah'] = 'Pax in jeddah';
        $HajjArray['navigation']['reports']['status_stats']['export']['pax_in_saudiarabia'] = 'Pax in Saudi Arabia';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_tpt_arrival'] = 'Allow TPT Arrival';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_htl_mecca'] = 'Allow HTL Mecca';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_tpt_mecca_chk_out'] = 'Allow TPT Mecca(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_htl_medina'] = 'Allow HTL Medina';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_tpt_medina_chk_out'] = 'Allow TPT Medina(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_htl_jeddah'] = 'Allow HTL Jeddah';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_tpt_jeddah_chk_out'] = 'Allow TPT Jeddah(Chk/Out)';
        $HajjArray['navigation']['reports']['status_stats']['export']['allow_tpt_departure'] = 'Allow TPT Departure';
        $HajjArray['navigation']['reports']['status_stats']['export']['free_bed'] = 'Free Bed';
        $HajjArray['navigation']['reports']['status_stats']['export']['ppt_management'] = 'PPT Management';
        $HajjArray['navigation']['reports']['status_stats']['export']['without_vchr_arrival'] = 'Without VCHR Arrival';
        $HajjArray['navigation']['reports']['status_stats']['export']['over_25_days_arrival'] = 'Over 25 Days Arrival';

        $HajjArray['navigation']['reports']['vendors'] = 'vendors';


        $HajjArray['navigation']['services']['hotel']['add_new'] = 'Add New';
        $HajjArray['navigation']['services']['hotel']['export'] = ' Export';
        $HajjArray['navigation']['services']['hotel']['update'] = 'Update';
        $HajjArray['navigation']['services']['hotel']['delete'] = 'Delete';
        $HajjArray['navigation']['services']['hotel']['list'] = 'List';
        $HajjArray['navigation']['services']['hotel']['print_download'] = 'Print/Download';


        $HajjArray['navigation']['services']['hotel']['categories']['add_options'] = 'Add Options';
        $HajjArray['navigation']['services']['hotel']['categories']['update'] = 'Update';
        $HajjArray['navigation']['services']['hotel']['categories']['delete'] = 'Delete';


        $HajjArray['navigation']['services']['hotel']['facilities']['add_options'] = 'Add Options';
        $HajjArray['navigation']['services']['hotel']['facilities']['update'] = 'Update';
        $HajjArray['navigation']['services']['hotel']['facilities']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['hotel']['amenities']['add_options'] = 'Add Options';
        $HajjArray['navigation']['services']['hotel']['amenities']['update'] = ' Update';
        $HajjArray['navigation']['services']['hotel']['amenities']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['hotel']['room_types']['add_options'] = 'Add Options';
        $HajjArray['navigation']['services']['hotel']['room_types']['update'] = 'Update';
        $HajjArray['navigation']['services']['hotel']['room_types']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['transport']['add_new'] = 'Add New';
        $HajjArray['navigation']['services']['transport']['export'] = 'Export';
        $HajjArray['navigation']['services']['transport']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['delete'] = 'Delete';
        $HajjArray['navigation']['services']['transport']['list'] = 'List';
        $HajjArray['navigation']['services']['transport']['print_download'] = 'Print/Download';

        $HajjArray['navigation']['services']['transport']['type']['add'] = 'Add Options';
        $HajjArray['navigation']['services']['transport']['type']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['type']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['transport']['sectors']['add'] = 'Add Options';
        $HajjArray['navigation']['services']['transport']['sectors']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['sectors']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['transport']['borders']['add'] = 'Add Options';
        $HajjArray['navigation']['services']['transport']['borders']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['borders']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['transport']['sea_ports']['add'] = 'Add Options';
        $HajjArray['navigation']['services']['transport']['sea_ports']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['sea_ports']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['transport']['companies']['add'] = 'Add Options';
        $HajjArray['navigation']['services']['transport']['companies']['update'] = 'Update';
        $HajjArray['navigation']['services']['transport']['companies']['delete'] = 'Delete';

        $HajjArray['navigation']['services']['ziyarat']['add'] = 'Add New';
        $HajjArray['navigation']['services']['ziyarat']['update'] = 'Update';
        $HajjArray['navigation']['services']['ziyarat']['delete'] = 'Delete';
        $HajjArray['navigation']['services']['ziyarat']['print_download'] = 'Print/Download';


        $HajjArray['navigation']['services']['packages']['b2b_external']['copy_package'] = 'Copy Package';
        $HajjArray['navigation']['services']['packages']['b2b_external']['add'] = 'Add New';
        $HajjArray['navigation']['services']['packages']['b2b_external']['export'] = 'Export';
        $HajjArray['navigation']['services']['packages']['b2b_external']['Update'] = 'Update';
        $HajjArray['navigation']['services']['packages']['b2b_external']['download'] = 'Download';


        $HajjArray['navigation']['services']['packages']['b2b']['copy'] = 'Copy Package';
        $HajjArray['navigation']['services']['packages']['b2b']['add'] = 'Add New';
        $HajjArray['navigation']['services']['packages']['b2b']['export'] = 'Export';
        $HajjArray['navigation']['services']['packages']['b2b']['Update'] = 'Update';
        $HajjArray['navigation']['services']['packages']['b2b']['download'] = 'Download';

        $HajjArray['navigation']['services']['packages']['B2b_general'] = 'B2B General';
        $HajjArray['navigation']['services']['packages']['b2c'] = 'B2c ';


        $HajjArray['navigation']['services']['visa_type']['add'] = 'Add Options ';
        $HajjArray['navigation']['services']['visa_type']['update'] = 'Update ';
        $HajjArray['navigation']['services']['visa_type']['delete'] = 'Delete ';


        $HajjArray['navigation']['services']['extra_services']['add'] = 'Add Options  ';
        $HajjArray['navigation']['services']['extra_services']['update'] = 'Update  ';
        $HajjArray['navigation']['services']['extra_services']['delete'] = 'Delete  ';


        $HajjArray['navigation']['services']['operator']['add'] = 'Add New  ';
        $HajjArray['navigation']['services']['operator']['update'] = 'Update  ';
        $HajjArray['navigation']['services']['operator']['delete'] = 'Delete  ';

        $HajjArray['navigation']['lookups']['options'] = ' List Options ';

        $HajjArray['navigation']['users']['system_user']['add'] = 'Add New';
        $HajjArray['navigation']['users']['system_user']['update'] = 'Update';
        $HajjArray['navigation']['users']['system_user']['delete'] = 'Delete';

        $HajjArray['navigation']['users']['access_level'] = 'Access level';

        $HajjArray['navigation']['settings']['mis'] = 'MIS Settings';
        $HajjArray['navigation']['settings']['websites'] = 'Websites';
        $HajjArray['navigation']['settings']['websites_domain'] = 'Websites Domain ';
        $HajjArray['navigation']['settings']['activity_log'] = 'Activity Log  ';
        $HajjArray['navigation']['settings']['database_backup'] = 'Database Backup ';
        $HajjArray['navigation']['settings']['agent_types'] = 'Agent Types ';


        $HajjArray['navigation']['settings']['multi_languages']['languages'] = ' Languages';
        $HajjArray['navigation']['settings']['multi_languages']['translation'] = ' Translation';


        ksort($HajjArray);
        return $HajjArray;


    }

    public
    function HomeNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $HomeArray = array();

        $HomeArray['navigation']['dashboard'] = ' Dashboard';

        $HomeArray['navigation']['client']['b2c']['add_new'] = 'Add New ';
        $HomeArray['navigation']['client']['b2c']['export_pilgrim_detail'] = 'Export pilgrim detail ';
        $HomeArray['navigation']['client']['b2c']['update'] = 'Update ';
        $HomeArray['navigation']['client']['b2c']['update_visa_detail'] = 'Update visa detail ';

        $HomeArray['navigation']['client']['b2b']['add_new'] = 'Add New ';
        $HomeArray['navigation']['client']['b2b']['export'] = 'Export';
        $HomeArray['navigation']['client']['b2b']['update'] = 'Update';
        $HomeArray['navigation']['client']['b2b']['delete'] = 'Delete';

        $HomeArray['navigation']['client']['sale_agents']['add_new'] = 'Add New ';
        $HomeArray['navigation']['client']['sale_agents']['export'] = 'Export ';
        $HomeArray['navigation']['client']['sale_agents']['update'] = 'Update ';
        $HomeArray['navigation']['client']['sale_agents']['delete'] = 'Delete ';

        $HomeArray['navigation']['client']['external_agent']['add_new'] = 'Add New';
        $HomeArray['navigation']['client']['external_agent']['update'] = ' Update';
        $HomeArray['navigation']['client']['external_agent']['delete'] = 'Delete';
        $HomeArray['navigation']['client']['external_agent']['list'] = 'List';

        $HomeArray['navigation']['client']['external_agent']['sub_agents']['add_new'] = 'Add New';
        $HomeArray['navigation']['client']['external_agent']['sub_agents']['list'] = 'List';

        $HomeArray['navigation']['booking']['all'] = 'All';
        $HomeArray['navigation']['booking']['pending'] = 'Pending';
        $HomeArray['navigation']['booking']['confirm'] = 'Confirm';
        $HomeArray['navigation']['booking']['expire'] = 'Expire';
        $HomeArray['navigation']['booking']['cancel'] = 'Cancel';

        $HomeArray['navigation']['sale_reports']['umrah']['reports']['hotel_brn_use_layouts'] = ' Hotel BRN Use Layouts';
        $HomeArray['navigation']['sale_reports']['umrah']['reports']['transport_brn_use_layouts'] = ' Transport  BRN Use Layouts';
        $HomeArray['navigation']['sale_reports']['umrah']['reports']['group_delete_list'] = ' Group Delete List';
        $HomeArray['navigation']['sale_reports']['umrah']['reports']['b2c_client_list'] = ' B2C client List';

        $HomeArray['navigation']['sale_reports']['umrah']['exports']['hotel_brn_use_layouts'] = ' Hotel BRN Use Layouts';
        $HomeArray['navigation']['sale_reports']['umrah']['exports']['transport_brn_use_layouts'] = ' Transport  BRN Use Layouts';
        $HomeArray['navigation']['sale_reports']['umrah']['exports']['group_delete_list'] = ' Group Delete List';
        $HomeArray['navigation']['sale_reports']['umrah']['exports']['b2c_client_list'] = ' B2C client List';

        $HomeArray['navigation']['sale_reports']['ticket']['reports']['detail_wise_report'] = 'Detail Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['year_wise_report'] = 'Year  Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['airline_wise_report'] = 'Airline   Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['international_report'] = 'International';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['domestic_report'] = 'Domestic';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['amount_report'] = 'Amount Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['airline_month_wise_report'] = 'Airline Month Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['group_airline_wise_report'] = 'Group & Airline Wise Summery';
        $HomeArray['navigation']['sale_reports']['ticket']['reports']['group_summary_report'] = 'Group Summery';

        $HomeArray['navigation']['sale_reports']['ticket']['exports']['detail_wise_export'] = 'Detail Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['year_wise_export'] = 'Year  Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['airline_wise_export'] = 'Airline   Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['international_export'] = 'International';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['domestic_export'] = 'Domestic';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['amount_export'] = 'Amount Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['airline_month_wise_export'] = 'Airline Month Wise';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['group_airline_wise_export'] = 'Group & Airline Wise Summery';
        $HomeArray['navigation']['sale_reports']['ticket']['exports']['group_summary_export'] = 'Group Summery';

        $HomeArray['navigation']['sale_reports']['hotel']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['hotel']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['reports']['hotel_category_wise_report'] = 'Hotel Category Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['reports']['hotel_month_wise_report'] = 'Hotel With Month Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['reports']['hotel_year_wise_report'] = 'Hotel With year Wise';

        $HomeArray['navigation']['sale_reports']['hotel']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['hotel']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['exports']['hotel_category_wise_export'] = 'Hotel Category Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['exports']['hotel_month_wise_export'] = 'Hotel With Month Wise';
        $HomeArray['navigation']['sale_reports']['hotel']['exports']['hotel_year_wise_export'] = 'Hotel With year Wise';

        $HomeArray['navigation']['sale_reports']['visa']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['visa']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['visa']['reports']['month_country_wise_category_report'] = 'Month & Country Wise Category';
        $HomeArray['navigation']['sale_reports']['visa']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['visa']['reports']['year_wise_report'] = 'year Wise';


        $HomeArray['navigation']['sale_reports']['visa']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['visa']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['visa']['exports']['month_country_wise_category_export'] = 'Month & Country Wise Category';
        $HomeArray['navigation']['sale_reports']['visa']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['visa']['exports']['year_wise_export'] = 'year Wise';

        $HomeArray['navigation']['sale_reports']['transport']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['transport']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['transport']['reports']['category_wise_report'] = 'Category Wise';
        $HomeArray['navigation']['sale_reports']['transport']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['transport']['reports']['year_wise_report'] = 'year Wise';
        $HomeArray['navigation']['sale_reports']['transport']['reports']['category_wise_month_country_report'] = 'Category Wise with Month & Country';

        $HomeArray['navigation']['sale_reports']['transport']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['transport']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['transport']['exports']['category_wise_export'] = 'Category Wise';
        $HomeArray['navigation']['sale_reports']['transport']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['transport']['exports']['year_wise_export'] = 'year Wise';
        $HomeArray['navigation']['sale_reports']['transport']['exports']['category_wise_month_country_export'] = 'Category Wise with Month & Country';

        $HomeArray['navigation']['sale_reports']['tour']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['tour']['reports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['tour']['reports']['package_category_wise_report'] = 'Package Category Wise';
        $HomeArray['navigation']['sale_reports']['tour']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['tour']['reports']['year_wise_report'] = 'year Wise';
        $HomeArray['navigation']['sale_reports']['tour']['reports']['package_category_month_wise_report'] = 'Package Category Month Wise';

        $HomeArray['navigation']['sale_reports']['tour']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['tour']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['tour']['exports']['package_category_wise_export'] = 'Package Category Wise';
        $HomeArray['navigation']['sale_reports']['tour']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['tour']['exports']['year_wise_export'] = 'year Wise';
        $HomeArray['navigation']['sale_reports']['tour']['exports']['package_category_month_wise_export'] = 'Package Category Month Wise';

        $HomeArray['navigation']['sale_reports']['visitor']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['visitor']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['reports']['successful_product_wise_report'] = 'Successful Product Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['reports']['unsuccessful_product_wise_report'] = 'UnSuccessful Product Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['reports']['year_wise_report'] = 'year Wise';

        $HomeArray['navigation']['sale_reports']['visitor']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['sale_reports']['visitor']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['exports']['successful_product_wise_export'] = 'Successful Product Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['exports']['unsuccessful_product_wise_export'] = 'UnSuccessful Product Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['sale_reports']['visitor']['exports']['year_wise_export'] = 'year Wise';


        $HomeArray['navigation']['purchase_reports']['umrah']['reports']['hotel_brn_vendors'] = ' Hotel BRN Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['reports']['transport_brn_vendors'] = ' Transport BRN Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['reports']['visa_vendors'] = ' Visa  Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['reports']['hotel_vendors'] = ' Hotel   Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['reports']['transport_vendors'] = ' Transport   Vendor';

        $HomeArray['navigation']['purchase_reports']['umrah']['exports']['hotel_brn_vendors'] = 'Hotel BRN Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['exports']['transport_brn_vendors'] = 'Transport BRN Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['exports']['visa_vendors'] = 'Visa Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['exports']['hotel_vendors'] = 'Hotel  Vendor';
        $HomeArray['navigation']['purchase_reports']['umrah']['exports']['transport_vendors'] = 'Transport  Vendor';

        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['issue_report'] = 'Ticket Issue';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['reissue_report'] = 'Ticket ReIssue';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['refund_report'] = 'Ticket Refund';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['adm_report'] = 'Ticket ADM';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['group_wise_report'] = 'Group  Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['detail_wise_report'] = 'Detail Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['year_wise_report'] = 'Year  Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['airline_wise_report'] = 'Airline   Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['international_report'] = 'International';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['domestic_report'] = 'Domestic';
        $HomeArray['navigation']['purchase_reports']['ticket']['reports']['amount_report'] = 'Amount Wise';

        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['issue_export'] = 'Ticket Issue';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['reissue_export'] = 'Ticket ReIssue';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['refund_export'] = 'Ticket Refund';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['adm_export'] = 'Ticket ADM';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['group_wise_export'] = 'Group  Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['detail_wise_export'] = 'Detail Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['month_wise_export'] = 'Month Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['year_wise_export'] = 'Year  Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['airline_wise_export'] = 'Airline   Wise';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['international_export'] = 'International';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['domestic_export'] = 'Domestic';
        $HomeArray['navigation']['purchase_reports']['ticket']['exports']['amount_export'] = 'Amount Wise';

        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['cancel_booking_report'] = ' Cancel Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['confirm_booking_report'] = ' Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['refund_booking_report'] = ' Refund Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['change_booking_report'] = ' Change Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['allotment_report'] = ' Hotel Allotment';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['hotel_category_wise_report'] = 'Hotel Category Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['hotel_month_wise_report'] = 'Hotel With Month Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['reports']['hotel_year_wise_report'] = 'Hotel With year Wise';

        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['cancel_booking_exports'] = ' Cancel Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['confirm_booking_exports'] = ' Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['refund_booking_exports'] = ' Refund Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['change_booking_exports'] = ' Change Booking';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['allotment_exports'] = ' Hotel Allotment';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['detail_wise_export'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['country_wise_export'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['hotel_category_wise_export'] = 'Hotel Category Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['hotel_month_wise_export'] = 'Hotel With Month Wise';
        $HomeArray['navigation']['purchase_reports']['hotel']['exports']['hotel_year_wise_export'] = 'Hotel With year Wise';

        $HomeArray['navigation']['purchase_reports']['visa']['reports']['visa_issue_report'] = 'Visa Issue';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['reject_visa_report'] = 'Reject  Visa ';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['refund_visa_report'] = 'Refund   Visa ';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['detail_report'] = 'Detail';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['vendor_country_wise_report'] = 'Vendor Country Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['visa_country_wise_report'] = 'Visa Country Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['month_wise_report'] = 'Month Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['reports']['year_wise_report'] = 'Year  Wise';

        $HomeArray['navigation']['purchase_reports']['visa']['exports']['visa_issue_exports'] = 'Visa Issue';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['reject_visa_exports'] = 'Reject Visa ';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['refund_visa_exports'] = 'Refund  Visa ';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['detail_exports'] = 'Detail';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['vendor_country_wise_exports'] = 'Vendor Country Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['visa_country_wise_exports'] = 'Visa Country Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['month_wise_exports'] = 'Month Wise';
        $HomeArray['navigation']['purchase_reports']['visa']['exports']['year_wise_exports'] = 'Year  Wise';


        $HomeArray['navigation']['purchase_reports']['transport']['reports']['confirm_booking'] = 'Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['refund_booking'] = 'Refund Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['change_booking'] = 'Change Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['category_wise_report'] = 'Category  Wise';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['month_wise_report'] = 'Month Wise  ';
        $HomeArray['navigation']['purchase_reports']['transport']['reports']['year_wise_report'] = 'Year  Wise  ';

        $HomeArray['navigation']['purchase_reports']['transport']['exports']['confirm_booking'] = 'Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['refund_booking'] = 'Refund Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['change_booking'] = 'Change Booking';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['detail_wise_exports'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['country_wise_exports'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['category_wise_exports'] = 'Category  Wise';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['month_wise_exports'] = 'Month Wise  ';
        $HomeArray['navigation']['purchase_reports']['transport']['exports']['year_wise_exports'] = 'Year  Wise  ';


        $HomeArray['navigation']['purchase_reports']['tour']['reports']['confirm_booking'] = 'Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['change_booking'] = 'Change Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['refund_booking'] = 'Refund Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['detail_wise_report'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['country_wise_report'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['package_category_wise_report'] = 'Package Category  Wise';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['month_wise_report'] = 'Month Wise  ';
        $HomeArray['navigation']['purchase_reports']['tour']['reports']['year_wise_report'] = 'Year  Wise  ';

        $HomeArray['navigation']['purchase_reports']['tour']['exports']['confirm_booking'] = 'Confirm Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['change_booking'] = 'Change Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['refund_booking'] = 'Refund Booking';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['detail_wise_exports'] = 'Detail Report';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['country_wise_exports'] = 'Country Wise';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['package_category_wise_exports'] = 'Package Category  Wise';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['month_wise_exports'] = 'Month Wise  ';
        $HomeArray['navigation']['purchase_reports']['tour']['exports']['year_wise_exports'] = 'Year  Wise  ';

        $HomeArray['navigation']['services']['hotel']['add_new'] = 'Add New';
        $HomeArray['navigation']['services']['hotel']['export'] = ' Export';
        $HomeArray['navigation']['services']['hotel']['update'] = 'Update';
        $HomeArray['navigation']['services']['hotel']['delete'] = 'Delete';
        $HomeArray['navigation']['services']['hotel']['list'] = 'List';
        $HomeArray['navigation']['services']['hotel']['print_download'] = 'Print/Download';

        $HomeArray['navigation']['services']['hotel']['categories']['add_options'] = 'Add Options';
        $HomeArray['navigation']['services']['hotel']['categories']['update'] = 'Update';
        $HomeArray['navigation']['services']['hotel']['categories']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['hotel']['facilities']['add_options'] = 'Add Options';
        $HomeArray['navigation']['services']['hotel']['facilities']['update'] = 'Update';
        $HomeArray['navigation']['services']['hotel']['facilities']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['hotel']['amenities']['add_options'] = 'Add Options';
        $HomeArray['navigation']['services']['hotel']['amenities']['update'] = ' Update';
        $HomeArray['navigation']['services']['hotel']['amenities']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['hotel']['room_types']['add_options'] = 'Add Options';
        $HomeArray['navigation']['services']['hotel']['room_types']['update'] = 'Update';
        $HomeArray['navigation']['services']['hotel']['room_types']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['transport']['add_new'] = 'Add New';
        $HomeArray['navigation']['services']['transport']['export'] = 'Export';
        $HomeArray['navigation']['services']['transport']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['delete'] = 'Delete';
        $HomeArray['navigation']['services']['transport']['list'] = 'List';
        $HomeArray['navigation']['services']['transport']['print_download'] = 'Print/Download';


        $HomeArray['navigation']['services']['transport']['type']['add'] = 'Add Options';
        $HomeArray['navigation']['services']['transport']['type']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['type']['delete'] = 'Delete';


        $HomeArray['navigation']['services']['transport']['sectors']['add'] = 'Add Options';
        $HomeArray['navigation']['services']['transport']['sectors']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['sectors']['delete'] = 'Delete';


        $HomeArray['navigation']['services']['transport']['borders']['add'] = 'Add Options';
        $HomeArray['navigation']['services']['transport']['borders']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['borders']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['transport']['sea_ports']['add'] = 'Add Options';
        $HomeArray['navigation']['services']['transport']['sea_ports']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['sea_ports']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['transport']['companies']['add'] = 'Add Options';
        $HomeArray['navigation']['services']['transport']['companies']['update'] = 'Update';
        $HomeArray['navigation']['services']['transport']['companies']['delete'] = 'Delete';

        $HomeArray['navigation']['services']['ziyarat']['add'] = 'Add New';
        $HomeArray['navigation']['services']['ziyarat']['update'] = 'Update';
        $HomeArray['navigation']['services']['ziyarat']['delete'] = 'Delete';
        $HomeArray['navigation']['services']['ziyarat']['list'] = 'List';
        $HomeArray['navigation']['services']['ziyarat']['print_download'] = 'Print/Download';

        $HomeArray['navigation']['services']['packages']['b2b_external']['copy_package'] = 'Copy Package';
        $HomeArray['navigation']['services']['packages']['b2b_external']['add'] = 'Add New';
        $HomeArray['navigation']['services']['packages']['b2b_external']['export'] = 'Export';
        $HomeArray['navigation']['services']['packages']['b2b_external']['Update'] = 'Update';
        $HomeArray['navigation']['services']['packages']['b2b_external']['download'] = 'Download';

        $HomeArray['navigation']['services']['packages']['b2b']['copy'] = 'Copy Package';
        $HomeArray['navigation']['services']['packages']['b2b']['add'] = 'Add New';
        $HomeArray['navigation']['services']['packages']['b2b']['export'] = 'Export';
        $HomeArray['navigation']['services']['packages']['b2b']['Update'] = 'Update';
        $HomeArray['navigation']['services']['packages']['b2b']['download'] = 'Download';

        $HomeArray['navigation']['services']['packages']['B2b_general'] = 'B2B General';
        $HomeArray['navigation']['services']['packages']['b2c'] = 'B2c ';

        $HomeArray['navigation']['services']['visa_type']['add'] = 'Add Options ';
        $HomeArray['navigation']['services']['visa_type']['update'] = 'Update ';
        $HomeArray['navigation']['services']['visa_type']['delete'] = 'Delete ';

        $HomeArray['navigation']['services']['extra_services']['add'] = 'Add Options  ';
        $HomeArray['navigation']['services']['extra_services']['update'] = 'Update  ';
        $HomeArray['navigation']['services']['extra_services']['delete'] = 'Delete  ';

        $HomeArray['navigation']['services']['operator']['add'] = 'Add New  ';
        $HomeArray['navigation']['services']['operator']['update'] = 'Update  ';
        $HomeArray['navigation']['services']['operator']['delete'] = 'Delete  ';

        $HomeArray['navigation']['lookups']['options'] = ' List Options ';

        $HomeArray['navigation']['users']['system_user']['add'] = 'Add New';
        $HomeArray['navigation']['users']['system_user']['update'] = 'Update';
        $HomeArray['navigation']['users']['system_user']['delete'] = 'Delete';

        $HomeArray['navigation']['users']['access_level'] = 'Access level';

        $HomeArray['navigation']['query'] = 'Query';
        $HomeArray['navigation']['inbox'] = 'Inbox';
        $HomeArray['navigation']['wallet'] = 'Wallet';


        ksort($HomeArray);
        return $HomeArray;
    }

    public
    function HotelNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $HotelArray = array();

        $HotelArray['navigation']['home'] = 'Home';
        $HotelArray['navigation']['dashboard'] = ' Dashboard';
        $HotelArray['navigation']['client']['b2c_client']['add_new'] = 'Add New ';
        $HotelArray['navigation']['client']['b2c_client']['export'] = 'Export';
        $HotelArray['navigation']['client']['b2c_client']['update'] = 'Update';
        $HotelArray['navigation']['client']['b2c_client']['export_pilgrim_details'] = 'Export Pilgrim Details';
        $HotelArray['navigation']['client']['b2c_client']['update_visa_detail'] = 'Update Visa Detail';

        $HotelArray['navigation']['client']['b2b_client']['add_new'] = 'Add New ';
        $HotelArray['navigation']['client']['b2b_client']['export'] = 'Export';
        $HotelArray['navigation']['client']['b2b_client']['update'] = 'Update';
        $HotelArray['navigation']['client']['b2b_client']['delete'] = 'Delete';

        $HotelArray['navigation']['client']['sale_agent']['add'] = 'Add ';
        $HotelArray['navigation']['client']['sale_agent']['export'] = 'Export ';
        $HotelArray['navigation']['client']['sale_agent']['update'] = ' Update';
        $HotelArray['navigation']['client']['sale_agent']['delete'] = 'Delete ';

        $HotelArray['navigation']['client']['external_agent']['list'] = 'list ';
        $HotelArray['navigation']['client']['external_agent']['sub_agents'] = 'Sub Agent ';
        $HotelArray['navigation']['bulk_pilgrim'] = 'Bulk Pilgrim';



        $HotelArray['navigation']['booking']['all'] = 'All';
        $HotelArray['navigation']['booking']['pending'] = 'Pending';
        $HotelArray['navigation']['booking']['confirm'] = 'Confirm';
        $HotelArray['navigation']['booking']['expire'] = 'Expire';
        $HotelArray['navigation']['booking']['cancel'] = 'Cancel';
        $HotelArray['navigation']['change_booking'] = 'Change Booking';
        $HotelArray['navigation']['refund_booking'] = 'Refund Booking';
        $HotelArray['navigation']['tomorrow_checkIn'] = 'Tomorrow CheckIn';
        $HotelArray['navigation']['tomorrow_checkout'] = 'Tomorrow CheckOut';

        $HotelArray['navigation']['reports']['detail_wise'] = 'Detail Report';
        $HotelArray['navigation']['reports']['country_wise'] = 'Country wise';
        $HotelArray['navigation']['reports']['category_wise'] = 'Category wise';
        $HotelArray['navigation']['reports']['hotel_wise'] = 'Hotel Wise';

        $HotelArray['navigation']['reports']['vendors']['report']['cancel_booking'] = ' Cancel Booking';
        $HotelArray['navigation']['reports']['vendors']['report']['confirm_booking'] = ' Confirm Booking';
        $HotelArray['navigation']['reports']['vendors']['report']['refund_booking'] = ' Refund Booking';
        $HotelArray['navigation']['reports']['vendors']['report']['change_booking'] = ' Change Booking';
        $HotelArray['navigation']['reports']['vendors']['report']['allotment'] = ' Hotel Allotment';
        $HotelArray['navigation']['reports']['vendors']['report']['detail'] = ' Detail Report';
        $HotelArray['navigation']['reports']['vendors']['report']['country_wise'] = ' Country Wise';
        $HotelArray['navigation']['reports']['vendors']['report']['category_wise'] = ' Category Wise';
        $HotelArray['navigation']['reports']['vendors']['report']['with_month_wise'] = ' Hotel With Month Wise';
        $HotelArray['navigation']['reports']['vendors']['report']['with_year_wise'] = ' Hotel With Year Wise';


        $HotelArray['navigation']['reports']['vendors']['export']['cancel_booking'] = ' Cancel Booking';
        $HotelArray['navigation']['reports']['vendors']['export']['confirm_booking'] = ' Confirm Booking';
        $HotelArray['navigation']['reports']['vendors']['export']['refund_booking'] = ' Refund Booking';
        $HotelArray['navigation']['reports']['vendors']['export']['change_booking'] = ' Change Booking';
        $HotelArray['navigation']['reports']['vendors']['export']['allotment'] = 'Hotel Allotment';
        $HotelArray['navigation']['reports']['vendors']['export']['detail'] = ' Detail Report';
        $HotelArray['navigation']['reports']['vendors']['export']['country_wise'] = ' Country Wise';
        $HotelArray['navigation']['reports']['vendors']['export']['category_wise'] = ' Category Wise';
        $HotelArray['navigation']['reports']['vendors']['export']['with_month_wise'] = 'Hotel With Month Wise';
        $HotelArray['navigation']['reports']['vendors']['export']['with_year_wise'] = 'Hotel With Year Wise';

        $HotelArray['navigation']['visitors'] = 'Visitors';
        $HotelArray['navigation']['query'] = 'Query';
        $HotelArray['navigation']['inbox'] = 'Inbox';
        $HotelArray['navigation']['wallet'] = 'Wallet';
        $HotelArray['navigation']['users']['system_user']['add'] = 'Add New';
        $HotelArray['navigation']['users']['system_user']['update'] = 'Update';
        $HotelArray['navigation']['users']['system_user']['delete'] = 'Delete';

        $HotelArray['navigation']['users']['access_level'] = 'Access level';

        ksort($HotelArray);
        return $HotelArray;
    }

    public
    function TransportNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $TransportArray = array();

        $TransportArray['navigation']['home'] = 'Home';
        $TransportArray['navigation']['dashboard'] = 'Transport Dashboard';
        $TransportArray['navigation']['client']['b2c_add_new'] = 'Add New';
        $TransportArray['navigation']['bulk_pilgrim'] = 'Bulk Pilgrim';
        $TransportArray['navigation']['booking']['all'] = 'All';
        $TransportArray['navigation']['booking']['pending'] = 'Pending';
        $TransportArray['navigation']['booking']['confirm'] = 'Confirm';
        $TransportArray['navigation']['booking']['expire'] = 'Expire';
        $TransportArray['navigation']['booking']['cancel'] = 'Cancel';
        $TransportArray['navigation']['refund_booking'] = 'Refund Booking';
        $TransportArray['navigation']['change_booking'] = 'Change Booking';
        $TransportArray['navigation']['tomorrow_vehicle_required'] = 'Tomorrow Vehicle Required';
        $TransportArray['navigation']['reports']['detail_wises'] = 'Detail Report';
        $TransportArray['navigation']['reports']['country_wises'] = 'Country Wise';
        $TransportArray['navigation']['reports']['category_wises'] = 'Category Wise';
        $TransportArray['navigation']['reports']['month_wises'] = 'Month Wise';
        $TransportArray['navigation']['reports']['year_wises'] = 'Year Wise';


        $TransportArray['navigation']['reports']['vendors']['report']['confirm_booking'] = 'Confirm Booking';
        $TransportArray['navigation']['reports']['vendors']['report']['refund_booking'] = 'Refund Booking';
        $TransportArray['navigation']['reports']['vendors']['report']['change_booking'] = 'Change Booking';
        $TransportArray['navigation']['reports']['vendors']['report']['detail_wise'] = 'Detail Report';
        $TransportArray['navigation']['reports']['vendors']['report']['country_wise'] = 'Country Wise';
        $TransportArray['navigation']['reports']['vendors']['report']['category_wise'] = 'Category  Wise';
        $TransportArray['navigation']['reports']['vendors']['report']['month_wise'] = 'Month Wise  ';
        $TransportArray['navigation']['reports']['vendors']['report']['year_wise'] = 'Year  Wise  ';


        $TransportArray['navigation']['reports']['vendors']['export']['confirm_booking'] = 'Confirm Booking';
        $TransportArray['navigation']['reports']['vendors']['export']['refund_booking'] = 'Refund Booking';
        $TransportArray['navigation']['reports']['vendors']['export']['change_booking'] = 'Change Booking';
        $TransportArray['navigation']['reports']['vendors']['export']['detail_wise'] = 'Detail Report';
        $TransportArray['navigation']['reports']['vendors']['export']['country_wise'] = 'Country Wise';
        $TransportArray['navigation']['reports']['vendors']['export']['category_wise'] = 'Category Wise';
        $TransportArray['navigation']['reports']['vendors']['export']['month_wise'] = 'Month Wise';
        $TransportArray['navigation']['reports']['vendors']['export']['year_wise'] = 'Year  Wise';


        $TransportArray['navigation']['visitor'] = ' Visitor';
        $TransportArray['navigation']['query'] = ' Query';
        $TransportArray['navigation']['inbox'] = ' Inbox';
        $TransportArray['navigation']['wallet'] = ' Wallet';

        $TransportArray['navigation']['users']['add_new'] = ' Add New';
        $TransportArray['navigation']['users']['update'] = ' Update';
        $TransportArray['navigation']['users']['delete'] = ' Delete';


        ksort($TransportArray);
        return $TransportArray;


    }

    public
    function TourismNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $TourismArray = array();

        $TourismArray['navigation']['home'] = 'Home';
        $TourismArray['navigation']['dashboard'] = ' Dashboard';
        $TourismArray['navigation']['client']['add_new'] = 'Add New';
        $TourismArray['navigation']['bulk_pilgrim'] = 'Bulk Pilgrim';
        $TourismArray['navigation']['booking']['all'] = 'All';
        $TourismArray['navigation']['booking']['pending'] = 'Pending';
        $TourismArray['navigation']['booking']['confirm'] = 'Confirm';
        $TourismArray['navigation']['booking']['expire'] = 'Expire';
        $TourismArray['navigation']['booking']['cancel'] = 'Cancel';
        $TourismArray['navigation']['refund_booking'] = 'Refund Booking';
        $TourismArray['navigation']['change_booking'] = 'Change Booking';
        $TourismArray['navigation']['reports']['detail_wise_reports'] = 'Detail Report';
        $TourismArray['navigation']['reports']['country_wise_reports'] = 'Country Wise';
        $TourismArray['navigation']['reports']['category_wise_reports'] = 'Category Wise';
        $TourismArray['navigation']['reports']['month_wise_reports'] = 'Month Wise';
        $TourismArray['navigation']['reports']['year_wise_reports'] = 'Year Wise';


        $TourismArray['navigation']['reports']['vendors']['reports']['confirm_booking_report'] = 'Confirm Booking';
        $TourismArray['navigation']['reports']['vendors']['reports']['refund_booking_report'] = 'Refund Booking';
        $TourismArray['navigation']['reports']['vendors']['reports']['change_booking_report'] = 'Change Booking';
        $TourismArray['navigation']['reports']['vendors']['reports']['detail_wise_report'] = 'Detail Report';
        $TourismArray['navigation']['reports']['vendors']['reports']['country_wise_report'] = 'Country Wise';
        $TourismArray['navigation']['reports']['vendors']['reports']['package_category_wise_report'] = 'Package Category  Wise';
        $TourismArray['navigation']['reports']['vendors']['reports']['month_wise_report'] = 'Month Wise  ';
        $TourismArray['navigation']['reports']['vendors']['reports']['year_wise_report'] = 'Year  Wise  ';


        $TourismArray['navigation']['reports']['vendors']['exports']['confirm_booking_export'] = 'Confirm Booking';
        $TourismArray['navigation']['reports']['vendors']['exports']['refund_booking_export'] = 'Refund Booking';
        $TourismArray['navigation']['reports']['vendors']['exports']['change_booking_export'] = 'Change Booking';
        $TourismArray['navigation']['reports']['vendors']['exports']['detail_wise_export'] = 'Detail Report';
        $TourismArray['navigation']['reports']['vendors']['exports']['country_wise_export'] = 'Country Wise';
        $TourismArray['navigation']['reports']['vendors']['exports']['package_category_wise_export'] = 'Package Category  Wise';

        $TourismArray['navigation']['reports']['vendors']['exports']['month_wise_export'] = 'Month Wise';
        $TourismArray['navigation']['reports']['vendors']['exports']['year_wise_export'] = 'Year  Wise';


        $TourismArray['navigation']['visitor'] = 'Visitor';
        $TourismArray['navigation']['query'] = ' Query';
        $TourismArray['navigation']['inbox'] = ' Inbox';
        $TourismArray['navigation']['wallet'] = ' Wallet';

        $TourismArray['navigation']['user']['add_new'] = ' Add New';
        $TourismArray['navigation']['user']['update'] = ' Update';
        $TourismArray['navigation']['user']['delete'] = ' Delete';


        ksort($TourismArray);
        return $TourismArray;


    }

    public
    function OtherAccessLevels()
    {
        $data = $this->data;
        $records = array();

        $records['navigation']["agents"] = "Manage Agents";
        $records['navigation']["sub_agents"] = "Manage Sub Agents";
        $records['navigation']["b2c"] = "Manage B2C";
        $records['navigation']["groups"] = "Manage Groups";
        $records['navigation']["umrah_operator"] = "Manage Umrah Operators";
        $records['navigation']["visa_types"] = "Manage Visa Types";
        $records['navigation']["deleted_groups"] = "Manage Deleted Groups";
        $records['navigation']["pilgrim"] = "Manage Pilgrim";
        $records['navigation']["title_options"] = "Manage Title Options";
        $records['navigation']["add_pilgrim"] = "Add Pilgrim";
        $records['navigation']["hotels"] = "Manage Hotels";
        $records['navigation']["extra_services"] = "Manage Extra Services";
        $records['navigation']["transport"] = "Manage Transport";
        $records['navigation']["transport_types"] = "Manage Transport Types";
        $records['navigation']["transport_sectors"] = "Manage Transport Sectors";
        $records['navigation']["transport_companies"] = "Manage Transport Companies";
        $records['navigation']["land_borders"] = "Manage Land Borders";
        $records['navigation']["sea_ports"] = "Manage Sea Ports";
        $records['navigation']["ziyarats"] = "Manage Ziyarats";
        $records['navigation']["b2b_package"] = "Manage B2B Package";
        $records['navigation']["b2b_packages"] = "Manage B2B Packages For Sale Agent";
        $records['navigation']["b2c_package"] = "Manage B2C Package";
        $records['navigation']["b2b_general_package"] = "Manage B2B General Package";
        $records['navigation']["b2b_external_agent"] = "Manage B2B External Package";
        $records['navigation']["hotel_category"] = "Manage Hotel Category ";
        $records['navigation']["room_types"] = "Manage Room Types ";
        $records['navigation']["hotel_amenities"] = "Manage Hotel Amenities ";
        $records['navigation']["hotel_facilities"] = "Manage Hotel Facilities";
        $records['navigation']["pilgrim_activity"] = "Add Pilgrim Activity";
        $records['navigation']["visa_not_printed"] = "VISA Not Printed";
        $records['navigation']["visa_details"] = "Manage Visa Details";
        $records['navigation']["b2b_package"] = "Manage B2B Package";
        $records['navigation']["b2c_package"] = "Manage B2C Package";
        $records['navigation']["b2b_general_package"] = "Manage B2B General Package";
        $records['navigation']["b2b_external_agent"] = "Manage B2B External Package";
        $records['navigation']["users"] = "Manage Users";
        $records['navigation']["b2b_packages"] = "Manage B2B Packages For Sale Agent";
        $records['navigation']["access_levels"] = "Manage Access Levels";
        $records['navigation']["new_voucher"] = "Manage New Vouchers";
        $records['navigation']["executed_voucher"] = "Manage Executed Vouchers";
        $records['navigation']["without_voucher_arrival"] = "Manage Without Voucher Arrival";
        $records['navigation']["all_voucher"] = "Manage All Vouchers";
        $records['navigation']["updated_voucher"] = "Manage Updated Vouchers";
        $records['navigation']["refund_voucher"] = "Manage Refund Vouchers";
        $records['navigation']["pending_voucher"] = "Manage Pending Vouchers";
        $records['navigation']["voucher_summary"] = "Manage Voucher Summary";
        $records['navigation']["file_uploader"] = "Manage File Uploader";
        $records['navigation']["completed_passports"] = "Manage Completed Passports";
        $records['navigation']["approved_voucher"] = "Manage Approved Vouchers";
        $records['navigation']["website_domains"] = "Manage Approved Vouchers";

        $records['navigation']["pilgrim_transfer"] = "Manage Pilgrim Transfer";

        $records['navigation']["pending_passports"] = "Manage Pending Passports";
        $records['navigation']["brn_operators"] = "Manage BRN Operators";
        $records['navigation']["hotel_brn_list"] = "Manage Hotel BRN ";
        $records['navigation']["transport_brn_list"] = "Manage Transport BRN ";


        $records['reports']["stats"] = "Reports Stats";
        $records['reports']["all"] = "All Reports";

        $records['dashboard']["monthly_agent_graph"] = "Monthly Agent Graph";


        ksort($records);
        return $records;
    }


    public function SalesNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $SalesArray = array();

        $SalesArray['navigation']['dashboard'] = 'Dashboard';
        $SalesArray['navigation']['leads']['facebook_api'] = 'Facebook API';

        $SalesArray['navigation']['leads']['un_assigned_leads']['list'] = 'List';
        $SalesArray['navigation']['leads']['un_assigned_leads']['update'] = 'Update';
        $SalesArray['navigation']['leads']['un_assigned_leads']['delete'] = 'Delete';
        $SalesArray['navigation']['leads']['un_assigned_leads']['manual_lead_import'] = 'Manual LeadModel Import';
        $SalesArray['navigation']['leads']['un_assigned_leads']['fb_lead_import'] = 'Facebook LeadModel Import';

        $SalesArray['navigation']['leads']['export_leads'] = 'Export Leads';
        $SalesArray['navigation']['organic']['organic_leads'] = ' Organic Leads';
        $SalesArray['navigation']['organic']['worksheets'] = ' Worksheets';
        $SalesArray['navigation']['organic']['organic_platforms'] = 'Organic Platforms';

        $SalesArray['navigation']['sales_officer']['list'] = 'list';
        $SalesArray['navigation']['leads']['comments']['list'] = 'List';
        $SalesArray['navigation']['leads']['comments']['export'] = 'export';

        ksort($SalesArray);
        return $SalesArray;
    }

    public
    function VisaNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $VisaArray = array();

        $VisaArray['navigation']['home'] = 'Home';
        $VisaArray['navigation']['dashboard'] = ' Dashboard';
        $VisaArray['navigation']['client']['add_new'] = 'Add New';
        $VisaArray['navigation']['bulk_pilgrim'] = 'Bulk Pilgrim';
        $VisaArray['navigation']['booking']['all'] = 'All';
        $VisaArray['navigation']['booking']['pending'] = 'Pending';
        $VisaArray['navigation']['booking']['confirm'] = 'Confirm';
        $VisaArray['navigation']['booking']['expire'] = 'Expire';
        $VisaArray['navigation']['booking']['cancel'] = 'Cancel';
        $VisaArray['navigation']['visa_issue'] = 'Visa Issue';
        $VisaArray['navigation']['visa_reject'] = 'Visa Reject';
        $VisaArray['navigation']['visa_refund'] = 'Visa Refund';

        $VisaArray['navigation']['reports']['detail_wise_reports'] = 'Detail Report';
        $VisaArray['navigation']['reports']['country_wise_reports'] = 'Country Wise';
        $VisaArray['navigation']['reports']['category_wise_reports'] = 'Category Wise';
        $VisaArray['navigation']['reports']['month_wise_reports'] = 'Month Wise';
        $VisaArray['navigation']['reports']['year_wise_reports'] = 'Year Wise';

        $VisaArray['navigation']['reports']['vendors']['reports']['visa_issue_report'] = 'Visa Issue';
        $VisaArray['navigation']['reports']['vendors']['reports']['reject_visa_report'] = 'Reject Visa';
        $VisaArray['navigation']['reports']['vendors']['reports']['refund_visa_report'] = 'Refund Visa';
        $VisaArray['navigation']['reports']['vendors']['reports']['detail_report'] = 'Detail';
        $VisaArray['navigation']['reports']['vendors']['reports']['vendor_country_wise_report'] = 'Vendor Country Wise';
        $VisaArray['navigation']['reports']['vendors']['reports']['visa_country_wise_report'] = 'Visa Country Wise';
        $VisaArray['navigation']['reports']['vendors']['reports']['month_wise_report'] = 'Month Wise  ';
        $VisaArray['navigation']['reports']['vendors']['reports']['year_wise_report'] = 'Year  Wise  ';

        $VisaArray['navigation']['reports']['vendors']['exports']['visa_issue_export'] = 'Visa Issue';
        $VisaArray['navigation']['reports']['vendors']['exports']['reject_visa_export'] = 'Reject Visa';
        $VisaArray['navigation']['reports']['vendors']['exports']['refund_visa_export'] = 'Refund Visa';
        $VisaArray['navigation']['reports']['vendors']['exports']['detail_export'] = 'Detail';
        $VisaArray['navigation']['reports']['vendors']['exports']['vendor_country_wise_export'] = 'Vendor Country Wise';
        $VisaArray['navigation']['reports']['vendors']['exports']['visa_country_wise_export'] = 'Visa Country Wise';
        $VisaArray['navigation']['reports']['vendors']['exports']['month_wise_export'] = 'Month Wise';
        $VisaArray['navigation']['reports']['vendors']['exports']['year_wise_export'] = 'Year  Wise';

        $VisaArray['navigation']['visitor'] = 'Visitor';
        $VisaArray['navigation']['query'] = ' Query';
        $VisaArray['navigation']['inbox'] = ' Inbox';
        $VisaArray['navigation']['wallet'] = ' Wallet';

        $VisaArray['navigation']['user']['add'] = ' Add New';
        $VisaArray['navigation']['user']['update'] = ' Update';
        $VisaArray['navigation']['user']['delete'] = ' Delete';


        ksort($VisaArray);
        return $VisaArray;
    }

    public
    function VisitorNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $VisitorArray = array();

        $VisitorArray['navigation']['home'] = 'Home';
        $VisitorArray['navigation']['dashboard'] = ' Dashboard';
        $VisitorArray['navigation']['visitor'] = 'Visitor';
        $VisitorArray['navigation']['unique_visitor'] = 'Unique Visitor';
        $VisitorArray['navigation']['old_visitor'] = 'Old Visitor';
        $VisitorArray['navigation']['confirm_visitor'] = ' Confirm Visitor';
        $VisitorArray['navigation']['not_interested_visitor'] = 'Not interested Visitor';
        $VisitorArray['navigation']['subscribers'] = 'Subscribers';
        $VisitorArray['navigation']['reports']['detail_wise_reports'] = 'Detail Report';
        $VisitorArray['navigation']['reports']['country_wise_reports'] = 'Country Wise';
        $VisitorArray['navigation']['reports']['product_wise']['successful_product_wise'] = 'successful Product Wise visitor ';
        $VisitorArray['navigation']['reports']['product_wise']['unsuccessful_product_wise'] = 'Unsuccessful Product Wise visitor';
        $VisitorArray['navigation']['reports']['month_wise_report'] = 'Month Wise  ';
        $VisitorArray['navigation']['reports']['year_wise_report'] = 'Year  Wise  ';

        $VisitorArray['navigation']['reports']['vendors']['reports']['visitor'] = ' Visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['unique_visitor'] = ' Unique Visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['old_visitor'] = ' Old Visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['confirm_visitor'] = ' Confirm Visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['not_interested_visitor'] = ' Not interested Visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['subscribers'] = 'Subscribers';

        $VisitorArray['navigation']['reports']['vendors']['reports']['detail_wise'] = 'Detail Report';
        $VisitorArray['navigation']['reports']['vendors']['reports']['country_wise'] = 'Country Wise';
        $VisitorArray['navigation']['reports']['vendors']['reports']['successful_product_wise'] = 'successful Product Wise visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['unsuccessful_product_wise'] = 'Unsuccessful Product Wise visitor';
        $VisitorArray['navigation']['reports']['vendors']['reports']['month_wise'] = 'Month Wise';
        $VisitorArray['navigation']['reports']['vendors']['reports']['year_wise'] = 'Year Wise';

        $VisitorArray['navigation']['reports']['vendors']['exports']['visitor'] = 'Visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['unique_visitor'] = 'Unique Visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['old_visitor'] = 'Old Visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['confirm_visitor'] = 'Confirm Visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['not_interested_visitor'] = 'Not interested Visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['subscribers'] = 'Subscribers';

        $VisitorArray['navigation']['reports']['vendors']['exports']['detail_wise'] = 'Detail Report';
        $VisitorArray['navigation']['reports']['vendors']['exports']['country_wise'] = 'Country Wise';
        $VisitorArray['navigation']['reports']['vendors']['exports']['successful_product_wise'] = 'successful Product Wise visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['unsuccessful_product_wise'] = 'Unsuccessful Product Wise visitor';
        $VisitorArray['navigation']['reports']['vendors']['exports']['month_wise'] = 'Month Wise';
        $VisitorArray['navigation']['reports']['vendors']['exports']['year_wise'] = 'Year Wise';

        $VisitorArray['navigation']['query'] = ' Query';
        $VisitorArray['navigation']['inbox'] = ' Inbox';
        $VisitorArray['navigation']['wallet'] = ' Wallet';

        $VisitorArray['navigation']['user']['add'] = ' Add New';
        $VisitorArray['navigation']['user']['update'] = ' Update';
        $VisitorArray['navigation']['user']['delete'] = ' Delete';


        ksort($VisitorArray);
        return $VisitorArray;


    }
    public
    function HumanResourceNavigationAccessLevel()
    {
        $data = $this->data;
        $FinalArray = $HumanResourceArray = array();

//        $HumanResourceArray['navigation']['home'] = 'Home';
        $HumanResourceArray['navigation']['dashboard'] = ' Dashboard';
        $HumanResourceArray['navigation']['employees'] = 'Employees';
        $HumanResourceArray['navigation']['leave'] = 'Leave';
        $HumanResourceArray['navigation']['attendance_report'] = 'Attendance Report';
        $HumanResourceArray['navigation']['roaster_report'] = 'Roasters Report';

        ksort($HumanResourceArray);
        return $HumanResourceArray;


    }

}
