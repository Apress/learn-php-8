<?php
session_start();
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

echo "<html><head><title>ABC Canine Shelter Reservation System</title>";
echo "<link href='e3ajaxdemo.css' rel='stylesheet'>";

echo "<style> table { border: 2px solid #5c744d;}";
echo "img { height: 100px; width: 140px; } </style>";

echo "</head><body>";
echo "<div id='wrapper'><div id='header'><h1><img src='brody.jpg'> ABC Canine Shelter Reservation System</h1></div><div id='content'>";
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
echo "</div><div id='footer'>Copyright &copy; 2020 Little Ocean Waves Publishing - Steve Prettyman</div></div>";
echo "</body></html>";
}
const ERROR_LOG = "Errors.log";

if ((!isset($_SESSION['username'])) || (!isset($_SESSION['password']))) {
echo "<html><head><title>ABC Canine Shelter Reservation System</title>";
echo "<link href='e3ajaxdemo.css' rel='stylesheet'><style type='text/css'>img { height: 100px; width: 140px; }</style></head><body>";
echo "<div id='wrapper'><div id='header'><h1><img src='brody.jpg'>ABC Canine Shelter Reservation System</h1></div>";
echo "<div id='content'>";
echo "You must login to access the ABC Canine Shelter Reservation System";
echo "<p>";
echo "<a href='e4login.php'>Login</a> | <a href='e3registration.php'>Create an account</a>";
echo "</p>";
echo "</div><div id='footer'>Copyright &copy; 2020 Little Ocean Waves Publishing - Steve Prettyman</div></div>";
echo "</body></html>";
}
else
{

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
}
?>