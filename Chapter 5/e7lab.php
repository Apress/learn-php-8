<?php
Require_once("e9dog.php");

function clean_input($value)
{

 
 $value = htmlentities($value);
		// Removes any html from the string and turns it into &lt; format
		$value = strip_tags($value);
		
 $bad_chars = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$");
 $value = str_ireplace($bad_chars,"",$value);
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
		
		// Gets rid of unwanted slashes
	}
		$value = htmlentities($value);
		
		// Removes any html from the string and turns it into &lt; format
		$value = strip_tags($value);
		
		
		return $value;
	
}

if ((isset($_POST['dog_name'])) && (isset($_POST['dog_breed'])) && (isset($_POST['dog_color'])) && (isset($_POST['dog_weight'])))
{

$dog_name = clean_input($_POST['dog_name']);
$dog_breed = clean_input($_POST['dog_breed']);
$dog_color = clean_input($_POST['dog_color']);
$dog_weight = clean_input($_POST['dog_weight']);


	
$lab = new Dog($dog_name,$dog_breed,$dog_color,$dog_weight);

list($name_error, $breed_error, $color_error, $weight_error) = explode(',', $lab);

print $name_error == 'TRUE' ? 'Name update successful<br/>' : 'Name update not successful<br/>';
print $breed_error == 'TRUE' ? 'Breed update successful<br/>' : 'Breed update not successful<br/>';
print $color_error == 'TRUE' ? 'Color update successful<br/>' : 'Color update not successful<br/>';
print $weight_error == 'TRUE' ? 'Weight update successful<br/>' : 'Weight update not successful<br/>';


// ------------------------------Set Properties--------------------------
//$dog_error_message = $lab->set_dog_name('Sally');
//print $dog_error_message == TRUE ? 'Name update successful<br/>' : 'Name update not successful<br/>';

//$dog_error_message = $lab->set_dog_weight('5');
//print $dog_error_message == TRUE ? 'Weight update successful<br />' : 'Weight update not successful<br />';

//$dog_error_message = $lab->set_dog_breed('Labrador');
//print $dog_error_message == TRUE ? 'Breed update successful<br />' : 'Breed update not successful<br />';

//$dog_error_message = $lab->set_dog_color('Brown');
//print $dog_error_message == TRUE ? 'Color update successful<br />' : 'Color update not successful<br />';
// ------------------------------Get Properties--------------------------
//print $lab->get_dog_name() . "<br/>";
//print $lab->get_dog_weight() . "<br />";
//print $lab->get_dog_breed() . "<br />";
//print $lab->get_dog_color() . "<br />";
$dog_properties = $lab->get_properties();
list($dog_weight, $dog_breed, $dog_color) = explode(',', $dog_properties);
print "Dog weight is $dog_weight. Dog breed is $dog_breed. Dog color is $dog_color.";
}

else
{

print "<p>Missing or invalid parameters. Please go back to the lab.html page to enter valid information.<br />";

print "<a href='e41lab.html'>Dog Creation Page</a>";

}
?>