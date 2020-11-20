<?php
session_start();
// same code as constructor from chapter six with some minor changes
$user_log_file = "user.log";
try {
if ((isset($_POST['username'])) || (isset($_POST['password'])))
{

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
	$xmlfile = file_get_contents($dog_data_xml);
	$xmlstring = simplexml_load_string($xmlfile);
	
	if ($xmlstring === false) {
		$errorString = "Failed loading XML: ";
		foreach(libxml_get_errors() as $error) {
			$errorString .= $error->message . " " ;  }
		throw new Exception($errorString); }
	$json = json_encode($xmlstring);	
	
	$valid_useridpasswords = json_decode($json,TRUE); 
// …… code to verify userid and password ….
	$userid = $_POST['username'];
	$password = $_POST['password'];

    foreach($valid_useridpasswords as $users)
	{
	foreach($users as $user)
	{
	    $hash = $user['password'];
		if((in_array($userid, $user)) && (password_verify($password,$hash)))
		{
			
			$_SESSION['username'] = $userid;
			$_SESSION['password'] = $password;
			$login_string = date('mdYhis') . " | Login | " . $userid . "\n";
			error_log($login_string,3,$user_log_file); 
			header("Location: e71lab.php");
		}
	}
   }
 }
}
   catch(Exception $e)
   {
        
        echo $e->getMessage();
   }
 // code below executes if the user has not logged in or if it is an invalid login.
?>
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required /><br />
<input type="submit" value="Login">
</form>