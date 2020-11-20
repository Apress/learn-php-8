<?php
class Dog
{
private $dog_weight = 0;
private $dog_breed = "no breed";
private $dog_color = "no color";
private $dog_name = "no name";

function display_properties()
{

print "Dog weight is $this->dog_weight. Dog breed is $this->dog_breed. Dog color is $this->dog_color.";

}
}
?>