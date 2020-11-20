<?php

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

function error_check_dog_app($lab)
{

list($name_error, $breed_error, $color_error, $weight_error) = explode(',', $lab);

print $name_error == 'TRUE' ? 'Name update successful<br/>' : 'Name update not successful<br/>';
print $breed_error == 'TRUE' ? 'Breed update successful<br/>' : 'Breed update not successful<br/>';
print $color_error == 'TRUE' ? 'Color update successful<br/>' : 'Color update not successful<br/>';
print $weight_error == 'TRUE' ? 'Weight update successful<br/>' : 'Weight update not successful<br/>';

}

function get_dog_app_properties($lab)
{

print "Your dog's name is " . $lab->get_dog_name() . "<br/>";
print "Your dog weights " . $lab->get_dog_weight() . " lbs. <br />";
print "Your dog's breed is " . $lab->get_dog_breed() . "<br />";
print "Your dog's color is " . $lab->get_dog_color() . "<br />";

}
//----------------Main Section-------------------------------------

if ( file_exists("e11dog_container.php"))
{
  Require_once("e11dog_container.php");
 }
 else
 {
    print "System Error #1";
	exit;
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
	 
	 if ($lab != FALSE)
	 {
     error_check_dog_app($lab);
     get_dog_app_properties($lab);
	 }
	 else
	 {
	 print "System Error #2";
	 }
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
	 
	 
	 if ($lab != FALSE)
	 {
	
        $container->set_app("breeds");		
        $dog_app = $container->get_dog_application("breeds");
		$method_array = get_class_methods($lab);
		$last_position = count($method_array) - 1;
		$method_name = $method_array[$last_position]; 
		$result = $lab->$method_name($dog_app);
      
	  if ( $result == FALSE)
	  {
	    print "System Error #3";
	  }
	  else
	  {
	     print $result;
	   }
	 }
	 else
	 {
	 print "System Error #4";
	 }
   
  }
?>