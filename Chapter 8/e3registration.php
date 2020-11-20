<?php
session_start();
$user_log_file = "user.log";


try {

if ((isset($_POST['username'])) && (isset($_POST['password'])))
{
$userid = $_POST['username'];
$password = $_POST['password'];
if (!(preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) || (!(strlen($userid) >= 8)))
{
	throw new Exception("Invalid Userid and/or Password Format");
}
else
{

	$hashed_password = password_hash($password, PASSWORD_DEFAULT);

	
	
	
	libxml_use_internal_errors(true);
	$xmlDoc = new DOMDocument(); 
	if ( file_exists("edog_applications.xml") )
	{
	$xmlDoc->load( 'edog_applications.xml' ); 
	$searchNode = $xmlDoc->getElementsByTagName( "type" ); 

		foreach( $searchNode as $searchNode ) 
		{ 
			$valueID = $searchNode->getAttribute('ID'); 
    
			if($valueID == "UIDPASS")
			{

				$xmlLocation = $searchNode->getElementsByTagName( "location" ); 
				$dog_data_xml = $xmlLocation->item(0)->nodeValue;
				
				break;
			}

		}
	}
	else 
	{
		throw new Exception("Dog applications xml file missing or corrupt");
	}
$newupstring = "<user>\n<userid>" . $userid . "</userid>\n<password>" . $hashed_password . "</password>\n";
$newupstring .= "<datestamp>" . date('Y-m-d', strtotime('+30 days')) . "</datestamp>\n";
$newupstring .= "<attempts>0</attempts>\n<lastattempt>" . date('mdYhis') . "</lastattempt>\n";
$newupstring .= "<validattempt>" . date('mdYhis') . "</validattempt>\n</user>\n</users>";
	
	$input = file_get_contents($dog_data_xml);

	$find = "</users>";
	$find_q = preg_quote($find,'/');
	$output = preg_replace("/^$find_q(\n|\$)/m","",$input);
	
	$output = $output . $newupstring;

	file_put_contents($dog_data_xml,$output);
				
	$login_string = date('mdYhis') . " | New Userid | " . $userid . "\n";
	error_log($login_string,3,$user_log_file); 
	header("Location: e2login.php");
	
	}
   }
   }
 
   catch(Exception $e)
   {
        
        echo $e->getMessage();
   }
 
?>
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required /><br />
<input type="submit" value="submit">
</form>