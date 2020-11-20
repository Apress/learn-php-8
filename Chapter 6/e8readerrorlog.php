<?php

function deleteRecord($recordNumber, &$row_Count, &$error_Array) 
{

	for ($J=$recordNumber; $J < $row_Count - 1; $J++)
{ 	
		for($I=0; $I < 3; $I++)
        { 	
			$error_Array[$J][$I] = $error_Array[$J + 1][$I];
		}
}

unset($error_Array[$row_Count]);
$row_Count--;

}

function saveChanges($row_Count,$error_Array,$log_File)
{
	$logFile = fopen($log_File, "w"); 
	for($I=0; $I < $row_Count; $I++)
	{
	    $writeString = $error_Array[$I][0] . " | " . $error_Array[$I][1] . " | " . $error_Array[$I][2];
		fwrite($logFile, $writeString);
	}
	fclose($logFile);
}

function displayRecords($row_Count, $error_Array)
{
echo "<html><head>";
echo "<style> table { border: 2px solid #5c744d;}  </style>";
echo "</head><body>";
echo "<table>";
echo "<caption>Log File: " . ERROR_LOG . "</caption>";
echo "<tr><th></th><th>Date/Time</th><th>Error Type</th><th>Error Message</th></tr><tr>";

for ($J=$row_Count; $J >= 0; $J--)
{ 		
		echo "<td><a href='e8readlogfile.php?rn=$J'>Delete</a></td>";
		
		for($I=0; $I < 3; $I++)
        { 	
			echo "<td> " . $error_Array[$J][$I] . " </td> "; 
		}
	echo "</tr>";
}
echo "</table>";
echo "</body></html>";
}

const ERROR_LOG = "Errors.log";

$logFile = fopen(ERROR_LOG, "r");
$row_Count = 0;
while(!feof($logFile))
{
$error_Array[$row_Count] = explode(' | ', fgets($logFile));		 
    	$row_Count++; 
}
$row_Count--;
fclose($logFile);

if(isset($_GET['rn']))
{

deleteRecord($_GET['rn'], $row_Count, $error_Array);
saveChanges($row_Count,$error_Array,ERROR_LOG);
}

displayRecords($row_Count,$error_Array);

?>