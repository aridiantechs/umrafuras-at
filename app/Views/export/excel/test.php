<?php
$line_terminated = "\r\n";
$field_terminated="\t";


$output = "Name".$field_terminated."Code".$field_terminated."Email".$field_terminated."Designation".$field_terminated."Number".$field_terminated."Salary".$field_terminated."Age";



$output.= $line_terminated;
$output.= $strData['1'].$field_terminated;
$output.= $strData['2'].$field_terminated;
$output.= $strData['3'].$field_terminated;
$output.= $strData['4'].$field_terminated;
$output.= $strData['5'].$field_terminated;
$output.= $strData['6'].$field_terminated;
$output.= $strData['7'].$delimeter;


?>