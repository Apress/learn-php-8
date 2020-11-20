<?php

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
	if ( file_exists("e5dog_container.php"))
	{
		Require_once("e5dog_container.php");
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
			$breedxml = $container->get_dog_application("breeds");
	
			$properties_array = array($dog_name,$dog_breed,$dog_color,$dog_weight,$breedxml);
			$lab = $container->create_object($properties_array);
			
			print "Updates successful<br />";
			get_dog_app_properties($lab);
		}

		else
		{
    
		print "<p>Missing or invalid parameters. Please go back to the dog.html page to enter valid information.<br />";

		print "<a href='lab.html'>Dog Creation Page</a>";

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

	    print $result;
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
		
		error_log("Date/Time: $date - Serious System Problems with Dog Application. Check error log for details", 1, "noone@helpme.com", "Subject: Dog Application Error \nFrom: System Log <systemlog@helpme.com>" . "\r\n");
        // e-mails personnel to alert them of a system problem

   }
?>
    