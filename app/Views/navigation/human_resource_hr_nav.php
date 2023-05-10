<?php

if ($CheckAccess['hr_dashboard']) { ?>
    <li class="menu">
        <a href="<?= $path ?>home/humanresourcehr" class="dropdown-toggle" aria-expanded="false">
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


<?php
if ($CheckAccess['hr_employees']) {
    ?>

    <li class="menu">
        <a href="<?= $path ?>hr/employees" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                     stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Employees</span>
            </div>
        </a>
    </li>

<?php } ?>

<?php
if ($CheckAccess['hr_leave']) {
    ?>
    <li class="menu">
        <a href="<?= $path ?>hr/leaves" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                     stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Leaves</span>
            </div>
        </a>
    </li>
<?php } ?>
<?php
if ($CheckAccess['hr_attendance_report']) {
    ?>
    <li class="menu">
        <a href="<?= $path ?>hr/attendance_report" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                     stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Attendance Report</span>
            </div>
        </a>
    </li>
<?php } ?>


<?php
#if ($CheckAccess['hr_roaster_report']) {
?>

    <li class="menu">
        <a href="<?= $path ?>hr/roasters_report" class="dropdown-toggle" aria-expanded="false">
            <div class="">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                     stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                </svg>
                <span>Roaster Report</span>
            </div>
        </a>
    </li>

<?php #} ?>

<li class="menu">
    <a href="<?= $path ?>hr/employee_summary" class="dropdown-toggle" aria-expanded="false">
        <div class="">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                 stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                <polyline points="13 2 13 9 20 9"></polyline>
            </svg>
            <span>Employee Summary</span>
        </div>
    </a>
</li>
