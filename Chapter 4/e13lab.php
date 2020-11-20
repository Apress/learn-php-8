<?php
Require_once("e12dog.php");
$lab = new Dog('Fred','Lab','Yellow','100');

list($name_error, $breed_error, $color_error, $weight_error) = explode(',', $lab);

print $name_error == 'TRUE' ? 'Name update successful<br/>' : 'Name update not successful<br/>';
print $breed_error == 'TRUE' ? 'Breed update successful<br/>' : 'Breed update not successful<br/>';
print $color_error == 'TRUE' ? 'Color update successful<br/>' : 'Color update not successful<br/>';
print $weight_error == 'TRUE' ? 'Weight update successful<br/>' : 'Weight update not successful<br/>';

// ------------------------------Set Properties--------------------------
$dog_error_message = $lab->set_dog_name('Sally');
print $dog_error_message == TRUE ? 'Name update successful<br/>' : 'Name update not successful<br/>';

$dog_error_message = $lab->set_dog_weight('5');
print $dog_error_message == TRUE ? 'Weight update successful<br />' : 'Weight update not successful<br />';

$dog_error_message = $lab->set_dog_breed('Labrador');
print $dog_error_message == TRUE ? 'Breed update successful<br />' : 'Breed update not successful<br />';

$dog_error_message = $lab->set_dog_color('Brown');
print $dog_error_message == TRUE ? 'Color update successful<br />' : 'Color update not successful<br />';
// ------------------------------Get Properties--------------------------
print $lab->get_dog_name() . "<br/>";
print $lab->get_dog_weight() . "<br />";
print $lab->get_dog_breed() . "<br />";
print $lab->get_dog_color() . "<br />";
$dog_properties = $lab->get_properties();
list($dog_weight, $dog_breed, $dog_color) = explode(',', $dog_properties);
print "Dog weight is $dog_weight. Dog breed is $dog_breed. Dog color is $dog_color.";
?>