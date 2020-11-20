<?php

include("e1dog_data.php");

$tester = new dog_data();


$records_array = Array ( 
0 => Array ( "dog_name" => "Sally", "dog_weight" => "19", "dog_color" => "Green", "dog_breed" => "Lab" )); 

$tester->insertRecords($records_array);

print_r ($tester->readRecords("ALL"));
print("<br><br><br><br>");
$records_array = Array ( 
1 => Array ( "dog_name" => "Spot", "dog_weight" => "19", "dog_color" => "Green", "dog_breed" => "Lab" )); 

$tester->updateRecords($records_array);

print_r ($tester->readRecords("ALL"));
print("<br><br><br><br>");

$tester->deleteRecord(1);
print_r ($tester->readRecords("ALL"));

$tester = NULL;
?>