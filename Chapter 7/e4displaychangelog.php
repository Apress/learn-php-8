<?php
function displayRecords($row_Count, $change_Array, $change_File)
{
echo "<html><head>";
echo "<style> table { border: 2px solid #5c744d;}  </style>";
echo "</head><body>";
echo "<table>";
echo "<caption>Log File: " . $change_File . "</caption>";
echo "<tr><th></th><th>Date/Time</th><th>Change Type</th><th>Change Data</th></tr><tr>";

for ($J=$row_Count -1; $J >= 0; $J--)
{ 		
		echo "<td><a href='e4readchangelog.php?rn=$J&change_File=$change_File'>Delete</a></td>";
		
		for($I=0; $I < 3; $I++)
        { 	
			echo "<td> " . $change_Array[$J][$I] . " </td> "; 
		}
	echo "</tr>";
}
echo "</table>";
echo "</body></html>";

$directory = "";

$files = glob($directory . "*dog_data.xml");

echo "<form id='data_select' name='data_select' method='post' action='readchangelog.php'>";
echo "<h3>Delete entries above or select a file to update with change log $change_File</h3>";
echo "<select name='data_File' id='data_File'>";
foreach($files as $file)
{

echo "<option value='$file'>$file</option>";

}
echo "</select>";
echo "<input type='hidden' id='change_file' name='change_file' value='$change_File'>";
echo "<input type='submit' id='submit' name='submit' value='select'>";
echo "</form>";


}
function deleteRecord($recordNumber, &$row_Count, &$change_Array) 
{

	for ($J=$recordNumber; $J < $row_Count - 1; $J++)
{ 	
		for($I=0; $I < 3; $I++)
        { 	
			$change_Array[$J][$I] = $change_Array[$J + 1][$I];
		}
}

unset($change_Array[$row_Count]);
$row_Count--;

}

function saveChanges($row_Count,$change_Array,$change_File)
{

	$changeFile = fopen($change_File, "w"); 
	for($I=0; $I < $row_Count; $I++)
	{
	    $writeString = $change_Array[$I][0] . " | " . $change_Array[$I][1] . " | " . $change_Array[$I][2];
		fwrite($changeFile, $writeString);
	}
	fclose($changeFile);
}

function delete_Process()
{
$change_Array = load_Array();
deleteRecord($_GET['rn'], $row_Count, $change_Array);

saveChanges($row_Count,$change_Array,$change_File);
displayRecords($row_Count,$change_Array,$change_File);
}

function load_Array()
{

$change_File = $_POST['change_file'];

$logFile = fopen($change_File, "r");
$row_Count = 0;
while(!feof($logFile))
{
$change_Array[$row_Count] = explode(' | ', fgets($logFile));	
	 
    	$row_Count++; 
}
$row_Count--;
fclose($logFile);
return $change_Array;
}
function display_Process()
{
$change_Array = load_Array();

$row_Count = count($change_Array) -1;

displayRecords($row_Count, $change_Array, $_POST['change_file']);

}

function select_File_Process()
{
$directory = "";

$files = glob($directory . "*change.log");

echo "<form id='file_select' name='file_select' method='post' action='e4readchangelog.php'>";
echo "<h3>Select a file to display</h3>";
echo "<select name='change_file' id='change_file'>";
foreach($files as $file)
{

echo "<option value='$file'>$file</option>";

}
echo "</select>";
echo "<input type='submit' id='submit' name='submit' value='select'>";
echo "</form>";

}

function update_XML_File_Process()
{
$change_Array = load_Array();

require_once("e3dog_data.php");

$data_Changer = new dog_data();

$row_Count = count($change_Array) -1;

for($I=0;$I < $row_Count; $I++)
{

   if($change_Array[$I][1] != "Delete")
	{
	$temp = unserialize($change_Array[$I][2]);

	}
	else
	{
	
	$temp = (integer)$change_Array[$I][2];
	
	}
		
	$data_Changer->processRecords($change_Array[$I][1], $temp);
	
}

$data_Changer->setChangeLogFile($_POST['data_File']);

$data_Changer = NULL;

echo "Changes completed";
}

if(isset($_POST['data_File']))
{

update_XML_File_Process();

}
else if(isset($_GET['rn']))
{
delete_Process();
}
else if(isset($_POST['change_file']))
{
display_Process();
}
else
{
select_File_Process();
}

?>