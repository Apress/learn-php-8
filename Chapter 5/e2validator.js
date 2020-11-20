function allalphabetic(the_string)  
{  

   var letters = /^[a-zA-Z ]+$/;  
   
   if (the_string.match(letters))  
    {  
	  
     return true;  
	 
    }  
   else  
    {   
 
    return false;  
   }  
}  

function validate_dog_name(the_string)
{
  
	if ((the_string.length > 0) && (allalphabetic(the_string)) && (the_string.length <= 20))
	{
	 
	  
	  return true;
	}
	else
	{
	  return false;
	}
}

function validate_dog_breed_color(the_string)
{

    if ((the_string.length > 0) && (allalphabetic(the_string)) && (the_string.length <= 35))
	{

	   return true;
	}
	else
	{ 
	 	 
	   return false;
	}
}

function validate_dog_weight(the_string)
{
    if ((the_string > 0 && the_string <=120) && (!isNaN(the_string)))
	{

	   return true;
	}
	else
	{
	
	   return false;
	}
}

function validate_input(form)
{
    var error_message = "";
	
    if (!validate_dog_name(form.dog_name.value))
	{ 
	   
        error_message += "Invalid dog name. ";
	}
	
	if (!validate_dog_breed_color(form.dog_breed.value))
	{
	
	    error_message += "Invalid dog breed. ";
	}
	
	if (!validate_dog_breed_color(form.dog_color.value))
	{
	    error_message += "Invalid dog color. ";
    }
	
	if (!validate_dog_weight(form.dog_weight.value))
	{
	
	    error_message += "Invalid dog weight. ";
	}
	if (error_message.length > 0)
	{
	    
	alert(error_message);
	return false;
	
	}
	else
	{
	return true;
	}

}