<?php

class dog_container
{

private $app;
private $dog_location;

function __construct($value)
{
if (function_exists('clean_input'))
{
$this->app = $value;
}
else
{
exit;
}
}

public function set_app($value)
{
$this->app = $value;
}

public function get_dog_application($search_value)
{

$xmlDoc = new DOMDocument(); 

if ( file_exists("e5dog_applications.xml") )

{
$xmlDoc->load( 'e5dog_applications.xml' ); 

$searchNode = $xmlDoc->getElementsByTagName( "type" ); 

foreach( $searchNode as $searchNode ) 
{ 
    $valueID = $searchNode->getAttribute('ID'); 
    
    if($valueID == $search_value)
    {

    $xmlLocation = $searchNode->getElementsByTagName( "location" ); 
    return $xmlLocation->item(0)->nodeValue;
    break;

    }

}
}
    throw new Exception("Dog applications xml file missing or corrupt");
  //  return FALSE;
}
function create_object($properties_array)
{

  $dog_loc = $this->get_dog_application($this->app);
  if(($dog_loc == FALSE) || (!file_exists($dog_loc)))
  {
  
    throw new Exception("File $dog_loc missing or corrupt.");
  //  return FALSE;
  }
  else
  {

    require_once($dog_loc);
    $class_array = get_declared_classes();
	$last_position = count($class_array) - 1;
	$class_name = $class_array[$last_position];	
	$dog_object = new $class_name($properties_array);
	
	return $dog_object;
	}

}

}

?>