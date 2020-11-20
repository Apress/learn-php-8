<?php

class GetBreeds {

function __construct($properties_array)
{
if (!(method_exists('dog_container', 'create_object')))
{
exit;
}
}

     private $result = "??";
public function get_select($dog_app)
{
     
	 
	 if (($dog_app != FALSE) && ( file_exists($dog_app)))
	 {
     $breed_file = simplexml_load_file($dog_app);

     $xmlText = $breed_file->asXML();
	
     $this->result = "<select name='dog_breed' id='dog_breed'>";
	 
     $this->result = $this->result . "<option value='-1' selected>Select a dog breed</option>";
     
    foreach ($breed_file->children() as $name => $value)
    {
      $this->result = $this->result . "<option value='$value'>$value</option>";
    }
      $this->result = $this->result . "</select>";
	  
	  return $this->result;
    }
	else
	{
	  throw new Exception("Breed xml file missing or corrupt");
	 // return FALSE;
    }
  

}
}
?>