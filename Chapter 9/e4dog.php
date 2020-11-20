<?php
session_start();

const USER_ERROR_LOG = "../Logs/User_Errors.log";
const ERROR_LOG = "../Logs/Errors.log";

function clean_input($value)
{

 
 $value = htmlentities($value);
		// Removes any html from the string and turns it into &lt; format
		$value = strip_tags($value);
		
 
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
		
		// Gets rid of unwanted slashes
	}
		$value = htmlentities($value);
		
		// Removes any html from the string and turns it into &lt; format
		
       $bad_chars = array( "{", "}", "(", ")", ";", ":", "<", ">", "/", "$" );
       $value = str_ireplace($bad_chars,"",$value);			
		return $value;
	
}

class setException extends Exception {
   public function errorMessage() {
   
        list($name_error, $breed_error, $color_error, $weight_error) = explode(',', $this->getMessage());
		
		$name_error == 'TRUE' ? $eMessage = '' : $eMessage = 'Name update not successful<br/>';
        $breed_error == 'TRUE' ? $eMessage .= '' : $eMessage .= 'Breed update not successful<br/>';
        $color_error == 'TRUE' ? $eMessage .= '' : $eMessage .= 'Color update not successful<br/>';
        $weight_error == 'TRUE' ? $eMessage .= '' : $eMessage .= 'Weight update not successful<br/>';
   
     	return $eMessage;
   	}
 }

function get_dog_app_properties($lab)
{

print "Your dog's name is " . $lab->get_dog_name() . "<br/>";
print "Your dog weights " . $lab->get_dog_weight() . " lbs. <br />";
print "Your dog's breed is " . $lab->get_dog_breed() . "<br />";
print "Your dog's color is " . $lab->get_dog_color() . "<br />";

}
//----------------Main Section-------------------------------------
try {
	if ( file_exists("edog_container.php"))
	{
		Require_once("edog_container.php");
	}
	else
	{
		throw new Exception("Dog container file missing or corrupt");
	}

	if (isset($_POST['dog_app']))
	{

		if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed'])) && (isset($_POST['dog_color'])) && (isset($_POST['dog_weight'])))
		{
  
			$container = new dog_container(clean_input($_POST['dog_app']));
			$dog_name = clean_input(filter_input(INPUT_POST, "dog_name"));
			$dog_breed = clean_input($_POST['dog_breed']);
			$dog_color = clean_input($_POST['dog_color']);
			$dog_weight = clean_input($_POST['dog_weight']);
			$dog_index = clean_input($_POST['index']);
			$breedxml = $container->get_dog_application("breeds");
            if ((isset($_POST['insert'])) || (isset($_POST['update'])))
			{
			
				if (isset($_POST['insert']))
				{
		
					$insert = TRUE;
				}
				else
				{
		
					$insert = FALSE;
				}
				$properties_array = array($dog_name,$dog_breed,$dog_color,$dog_weight,$breedxml,$insert,$dog_index);
				$lab = $container->create_object($properties_array);
				$_SESSION['message'] = "Dog $dog_name Insert/Update was successful<br />";
		
				header("Location: elab.php");
				//print "Dog $dog_name Insert/Update was successful<br />";
				//get_dog_app_properties($lab);
			}
			else if($_POST['delete'])
			{
			
				$properties_array = $dog_index;
				$lab = $container->create_object($properties_array);
				$_SESSION['message'] = "Dog $dog_name Deletion was successful<br />";
			
				header("Location: elab.php");
			//	print "Dog $dog_name Deletion was successful<br />";
			}
		}

		else
		{
    
		print "<p>Missing or invalid parameters. Please go back to the dog.php page to enter valid information.<br />";

		print "<a href='elab.php'>Dog Creation Page</a>";

		}
	}
	else // select box
	{
  
		$container = new dog_container("selectbox");
     
		$properties_array = array("selectbox");
	 
		$lab = $container->create_object($properties_array);	
        $container->set_app("breeds");		
        $dog_app = $container->get_dog_application("breeds");
		$method_array = get_class_methods($lab);
		$last_position = count($method_array) - 1;
		$method_name = $method_array[$last_position]; 
		$result = $lab->$method_name($dog_app);

		$container = NULL;
		// read dog_data array
		
		$container = new dog_container("dog");
		$properties = "dog";
		$lab = $container->create_object($properties);
		$container->set_app("dog");
		$dog_app = $container->get_dog_application("dog");
		$method_array = get_class_methods($lab);
		$last_position = count($method_array) - 1;
		$method_name = $method_array[$last_position]; 
		
		$returned_array = $lab->$method_name("ALL");
	
		$resultstring = "<select name='dogs' id='dogs'>";
	 
		$resultstring = $resultstring . "<option value='-1' selected>NEW</option>";
     

		foreach ($returned_array as $column => $column_value)
		{

		$resultstring = $resultstring . "<option value='$column'>" . $column_value['dog_name'] . "&nbsp;&nbsp;&nbsp;" . $column_value['dog_breed'] . "</option>";
		}
		$resultstring = $resultstring . "</select>";

	   print $result . "|" . $resultstring . "|" . '{ "dogs" : ' . json_encode($returned_array) . "}";
       
	}
   }
   catch(setException $e)
   {
		echo $e->errorMessage(); // displays to the user
		
		$date = date('m.d.Y h:i:s'); 
		$errormessage = $e->errorMessage();
		$eMessage =  $date . " | User Error | " . $errormessage . "\n";
		error_log($eMessage,3,USER_ERROR_LOG); // writes message to user error log file

   }
   catch(Exception $e)
   {
        
		echo "The system is currently unavailable. Please try again later."; // displays message to the user
		
		$date = date('m.d.Y h:i:s'); 
		$eMessage =  $date . " | System Error | " . $e->getMessage() . " | " . $e->getFile() . " | ". $e->getLine() . "\n";
		error_log($eMessage,3,ERROR_LOG); // writes message to error log file
		
	//	error_log("Date/Time: $date - Serious System Problems with Dog Application. Check error log for details", 1, "noone@helpme.com", "Subject: Dog Application Error \nFrom: System Log <systemlog@helpme.com>" . "\r\n");
        // e-mails personnel to alert them of a system problem

   }
?><?php
class Dog
{
// ----------------------------------------- Properties -----------------------------------------
private $dog_weight = 0;
private $dog_breed = "no breed";
private $dog_color = "no color";
private $dog_name = "no name";
private $error_message = "??";
private $breedxml = "";
private $insert = FALSE;
private $index = -1;

// ---------------------------------- Constructor ----------------------------------------------
function __construct($properties_array)
{
if (method_exists('dog_container', 'create_object')) {
if (is_array($properties_array)) {
$this->breedxml = $properties_array[4];

$name_error = $this->set_dog_name($properties_array[0]) == TRUE ? 'TRUE,' : 'FALSE,';
$color_error = $this->set_dog_color($properties_array[2]) == TRUE ? 'TRUE,' : 'FALSE,';
$weight_error= $this->set_dog_weight($properties_array[3]) == TRUE ? 'TRUE' : 'FALSE';
$breed_error = $this->set_dog_breed($properties_array[1]) == TRUE ? 'TRUE,' : 'FALSE,';
$this->error_message = $name_error . $breed_error . $color_error . $weight_error;


if(stristr($this->error_message, 'FALSE'))
{
	throw new setException($this->error_message);
}
if((is_bool($properties_array[5])) && ($properties_array[6] > -1))
{ // confirms true or false and valid index or takes default
	$this->insert = $properties_array[5];
	$this->index = $properties_array[6];
}
$this->change_dog_data("Insert/Update");
}
if(is_numeric($properties_array))
{   // confirms valid index don't delete if not valid
	$this->index = $properties_array;
	$this->change_dog_data("Delete");
}


}
else
{
exit;
}
}
function clean_input() { }

function set_dog_name($value)
{
$error_message = TRUE;
(ctype_alpha($value) && strlen($value) <= 20) ? $this->dog_name = $value : $this->error_message = FALSE;
return $this->error_message;
}
function set_dog_weight($value)
{
$error_message = TRUE;
(ctype_digit($value) && ($value > 0 && $value <= 120)) ? $this->dog_weight = $value : $this->error_message = FALSE;
return $this->error_message;
}
function set_dog_breed($value)
{
$error_message = TRUE;
($this->validator_breed($value) === TRUE) ? $this->dog_breed = $value : $this->error_message = FALSE;
return $this->error_message;
}
function set_dog_color($value)
{
$error_message = TRUE;
(ctype_alpha($value) && strlen($value) <= 15) ? $this->dog_color = $value : $this->error_message = FALSE;
return $this->error_message;
}
// ----------------------------------------- Get Methods ------------------------------------------------------------
function get_dog_name()
{
return $this->dog_name;
}
function get_dog_weight()
{
return $this->dog_weight;
}
function get_dog_breed()
{
return $this->dog_breed;
}
function get_dog_color()
{
return $this->dog_color;
}
function get_properties()
{
return "$this->dog_name,$this->dog_weight,$this->dog_breed,$this->dog_color.";
}
// ----------------------------------General Methods---------------------------------------------

private function validator_breed($value)
{

$breed_file = simplexml_load_file($this->breedxml);
$xmlText = $breed_file->asXML();

if(stristr($xmlText, $value) === FALSE)
{
return FALSE;
}
else
{
return TRUE;
}
}

private function change_dog_data($type)
{
if ( file_exists("e5dog_container.php")) {
		require_once("e5dog_container.php"); // use chapter 5 container w exception handling
	} else {
		throw new Exception("Dog container file missing or corrupt");
	}
	
	$container = new dog_container("dogdata"); // sets the tag name to look for in XML file
	$properties_array = array("dogdata"); // not used but must be passed into create_object
	$dog_data = $container->create_object($properties_array); // creates dog_data object 
	$method_array = get_class_methods($dog_data);
	$last_position = count($method_array) - 1;
	$method_name = $method_array[$last_position]; 
	
	if (($this->index > -1) && ($type == "Delete"))
	{
	$record_Array = $this->index;	
	$dog_data->$method_name("Delete",$record_Array);
	}
	 else if (($this->index == -1) && ($type == "Insert/Update"))
	{
	$record_Array = array(array('dog_name'=>"$this->dog_name", 'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color", 'dog_breed'=>"$this->dog_breed")); 	
	$dog_data->$method_name("Insert",$record_Array); 
	
	}
	else if ($type == "Insert/Update")
	{
	$record_Array = array($this->index => array('dog_name'=>"$this->dog_name", 'dog_weight'=>"$this->dog_weight", 'dog_color'=>"$this->dog_color", 'dog_breed'=>"$this->dog_breed")); 	
	$dog_data->$method_name("Update",$record_Array); 
	
	}
	
	
	$dog_data = NULL;
	
}

function display_dog_data($record)
{
if ( file_exists("e5dog_container.php")) {
		require_once("e5dog_container.php"); // use chapter 5 container w exception handling
	} else {
		throw new Exception("Dog container file missing or corrupt");
	}
	
	$container = new dog_container("dogdata"); // sets the tag name to look for in XML file
	$properties_array = array("dogdata"); // not used but must be passed into create_object
	$dog_data = $container->create_object($properties_array); // creates dog_data object
	$method_array = get_class_methods($dog_data);
	$last_position = count($method_array) - 1;
	$method_name = $method_array[$last_position]; 
	$record_Array = $record; 	
	
	return $dog_data->$method_name("Display",$record_Array);
	
}
}
?>