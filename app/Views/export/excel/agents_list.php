<?php
$line_terminated = "\r\n";
$field_terminated="\t";


$output = "Ref. Code".$field_terminated."Name";

foreach ($records as $record){
    $output.= $line_terminated;
    $output.= Code("xxx", $record['UID']).$field_terminated;
    $output.= $record['FullName'];
}
echo $output;
?>