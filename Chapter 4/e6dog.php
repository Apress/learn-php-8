<?php
class Dog
{
private $dog_weight = 0;
private $dog_breed = "no breed";
private $dog_color = "no color";
private $dog_name = "no name";

function get_properties()
{

return "$this->dog_weight,$this->dog_breed,$this->dog_color.";

}
}
?>