<?php
class dog_data
{
private $dogs_array = array(); //defined as an empty array initially
private $dog_data_xml = "";
function __construct() {
	libxml_use_internal_errors(true);
	$xmlDoc = new DOMDocument(); 
	if ( file_exists("e1dog_applications.xml") )
	{
	$xmlDoc->load( 'e1dog_applications.xml' ); 
	$searchNode = $xmlDoc->getElementsByTagName( "type" ); 

		foreach( $searchNode as $searchNode ) 
		{ 
			$valueID = $searchNode->getAttribute('ID'); 
    
			if($valueID == "datastorage")
			{

				$xmlLocation = $searchNode->getElementsByTagName( "location" ); 
				$this->dog_data_xml = $xmlLocation->item(0)->nodeValue;
				
				break;
			}

		}
	}
	else 
	{
		throw new Exception("Dog applications xml file missing or corrupt");
	}
	$xmlfile = file_get_contents($this->dog_data_xml);
	$xmlstring = simplexml_load_string($xmlfile);
	
	if ($xmlstring === false) {
		$errorString = "Failed loading XML: ";
		foreach(libxml_get_errors() as $error) {
			$errorString .= $error->message . " " ;  }
		throw new Exception($errorString); }
	$json = json_encode($xmlstring);
	print_r($json);
	
	$this->dogs_array = json_decode($json,TRUE); 
	
}

function __destruct()
{
	$xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
   	 $xmlstring .= "\n<dogs>\n";   
   	 foreach ($this->dogs_array as $dogs=>$dogs_value) {	    
		foreach ($dogs_value as $dog => $dog_value)
		{		
			$xmlstring .="<$dogs>\n";
				foreach ($dog_value as $column => $column_value)
				{
				$xmlstring .= "<$column>" . $dog_value[$column] . "</$column>\n";
				}
			$xmlstring .= "</$dogs>\n";
		}		
    } 
	$xmlstring .= "</dogs>\n";
	file_put_contents($this->dog_data_xml,$xmlstring); 
}


function deleteRecord($recordNumber) 
{
	foreach ($this->dogs_array as $dogs=>&$dogs_value) {
		for($J=$recordNumber; $J < count($dogs_value) -1; $J++) {
            		 
			foreach ($dogs_value[$J] as $column => $column_value)
			{
				$dogs_value[$J][$column] = $dogs_value[$J + 1][$column];
			}				
		
}
	unset ($dogs_value[count($dogs_value) -1]);
	}
 }

function readRecords($recordNumber) 
 {
	if($recordNumber === "ALL") {
		return $this->dogs_array["dog"];
	}
	else 
	{
		return $this->dogs_array["dog"][$recordNumber];
	} 
}

function insertRecords($records_array)
{
	$dogs_array_size = count($this->dogs_array["dog"]);
	for($I=0;$I< count($records_array);$I++)
	{
		$this->dogs_array["dog"][$dogs_array_size + $I] = $records_array[$I];
	} 
}

function updateRecords($records_array)
{
	foreach ($records_array as $records=>$records_value) 
	{
		foreach ($records_value as $record => $record_value) 
		{        	
            		$this->dogs_array["dog"][$records] = $records_array[$records];		
		}
	}
}

}

?>