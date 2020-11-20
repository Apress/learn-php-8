<?php 
session_start();
if (isset($_GET['logoff']))
{
session_destroy();
}
if ((!isset($_SESSION['username'])) || (!isset($_SESSION['password'])) || (isset($_GET['logoff']))) {
echo "<html><head><title>ABC Canine Shelter Reservation System</title>";
echo "<link href='e3ajaxdemo.css' rel='stylesheet'><style type='text/css'>img { height: 100px; width: 140px; }</style></head><body>";
echo "<div id='wrapper'><div id='header'><h1><img src='brody.jpg'>ABC Canine Shelter Reservation System</h1></div>";
echo "<div id='content'>";
echo "You must login to access the ABC Canine Shelter Reservation System";
echo "<p>";
echo "<a href='e4login.php'>Login</a> | <a href='e3registration.php'>Create an account</a>";
echo "</p>";
echo "</div><div id='footer'>Copyright &copy; 2020 Little Ocean Waves Publishing - Steve Prettyman</div></div>";
echo "</body></html>";
}
else if(($_SERVER['HTTP_REFERER'] == 'http://127.0.0.1:8080/mysite/bgchapter8/ExampleFile7.4/e74login.php') || ($_SERVER['HTTP_REFERER'] == 'http://127.0.0.1:8080/mysite/bgchapter8/ExampleFile7.4/e8lab.php'))
{
?>
<!DOCTYPE html>
<html lan="en">
<head>
<title>ABC Canine Shelter Reservation System</title>
<link href="e3ajaxdemo.css" rel="stylesheet">
<script src="egetlists.js"></script>
<script src="evalidator.js"></script>
<style type="text/css">
#JS { display:none; }
#input_form { display:none; }
#insert {display: none; }
#delete {display: none; }
#update {display: none; }
img { height: 100px; width: 140px; }
</style>
<script>
function checkJS() {

document.getElementById('JS').style.display = "inline";

}
function process_select() {
	
	 var colorbuttons = document.getElementsByName('dog_color');
	 
if(!(document.getElementById('dogs').value == -1))
{
	 
	 index = document.getElementById('dogs').selectedIndex -1;
	 document.getElementById('index').value = index;
	 document.getElementById('dog_name').value = obj.dogs[index].dog_name;
	 document.getElementById('dog_weight').value = obj.dogs[index].dog_weight;
	 dog_color = obj.dogs[index].dog_color;
		
	 if(dog_color == "Brown")
	 {	 
		 colorbuttons[0].checked = true;
	 } else if (dog_color == "Black")
	 {
		 colorbuttons[1].checked = true;
	 } else if (dog_color == "Yellow")
	 {
		 colorbuttons[2].checked = true;
	 } else if (dog_color == "White")
	 {
		 colorbuttons[3].checked = true;
	 }
	 
	 dog_breed = obj.dogs[index].dog_breed;
	 
	 document.getElementById('dog_breed').value = dog_breed;
	 
	 document.getElementById('update').style.display = "inline";
	 document.getElementById('delete').style.display = "inline";
	 document.getElementById('insert').style.display = "none";
}
else
{
	colorbuttons[4].checked = true;
	document.getElementById('dog_name').value = "";
	document.getElementById('dog_weight').value = "";	
	document.getElementById('dog_breed').value = "Select a dog breed";	
	document.getElementById('insert').style.display = "inline";
	document.getElementById('update').style.display = "none";
	 document.getElementById('delete').style.display = "none";
	
}
	 document.getElementById('input_form').style.display = "inline";
}
</script>
</head>
<body onload="checkJS();">
<div id="wrapper">
<div id="header"><h1><img src="brody.jpg"> ABC Canine Shelter Reservation System</h1>
<a href="e8readerrorlog.php">Manage Error Logs</a> | <a href="e5changepassword.php">Change Password</a> | <a href="elab.php?logoff=True">Log Off</a>
</div>
<div id="content">
<?php
if (isset($_SESSION['message']))
{
echo "<p>" . $_SESSION['message'] . "</p>";
}
else
{
echo "<p> Welcome back, " . $_SESSION['username'] . "</p>";
}
?>
<div id="JS">

<script>
AjaxRequest('edog_interface.php');
</script>
<h3>Pick the dog name and breed to change from the dropdown box, then click the button.<br>For new dog information select 'NEW'.</h3>

Select 'NEW' or Dog's Name/Breed <div id="AjaxReturnValue"></div>
<input type="button" name="selected" id="selected" value="Click to select" onclick="process_select()" /><br><br>
<div id="input_form">
<form method="post" action="edog_interface.php" onSubmit="return validate_input(this)">
<h3>Please note the required format of information.</h3>

<hr>
Enter Your Dog's Name (max 20 characters, alphabetic) <input type="text" pattern="[a-zA-Z]*"  title="Up to 20 Alphabetic Characters" maxlength="20" name="dog_name" id="dog_name" required/><br /><br />
Select Your Dog's Color:<br />
<input type="radio" name="dog_color" id="dog_color" value="Brown">Brown<br />
<input type="radio" name="dog_color" id="dog_color" value="Black">Black<br />
<input type="radio" name="dog_color" id="dog_color" value="Yellow">Yellow<br />
<input type="radio" name="dog_color" id="dog_color" value="White">White<br />
<input type="radio" name="dog_color" id="dog_color" value="Mixed" checked >Mixed<br /><br />

Enter Your Dog's Weight (numeric only) <input type="number" min="1" max="120" name="dog_weight" id="dog_weight" required /><br /><br />

<input type="hidden" name="dog_app" id="dog_app" value="dog" />
Select Your Dog's Breed <div id="AjaxResponse"></div><br />
<input type="hidden" name="index" id="index" value="-1"/>
<input type="submit" name="insert" id="insert" value="Click to create your dog info" />
<input type="submit" name="delete" id="delete" value="Click to remove your selected dog info" />
<input type="submit" name="update" id="update" value="Click to update your selected dog info" />
<hr>
</form>
</div>
</div>
<noscript>
<div id="noJS">
<form method="post" action="edog_interface.php">
<h3>For Updates please enter all fields. For Deletions enter at least the dog name and breed. Then click the button.<br>For new dog information enter the requested information, Then click the button.<br> Please note the required format of information.</h3>
Enter Your Dog's Name (max 20 characters, alphabetic) <input type="text" pattern="[a-zA-Z ]*"  title="Up to 20 Alphabetic Characters" maxlength="20" name="dog_name" id="dog_name" required/><br /><br />
Select Your Dog's Color:<br />
<input type="radio" name="dog_color" id="dog_color" value="Brown">Brown<br />
<input type="radio" name="dog_color" id="dog_color" value="Black">Black<br />
<input type="radio" name="dog_color" id="dog_color" value="Yellow">Yellow<br />
<input type="radio" name="dog_color" id="dog_color" value="White">White<br />
<input type="radio" name="dog_color" id="dog_color" value="Mixed" checked >Mixed<br /><br />
Enter Your Dog's Weight (numeric only) <input type="number" min="1" max="120" name="dog_weight" id="dog_weight" required /><br /><br />
Enter Your Dog's Breed (max 35 characters, alphabetic) <input type="text" pattern="[a-zA-Z ]*" title="Up to 15 Alphabetic Characters" maxlength="35" name="dog_breed" id="dog_breed" required /><br />
<input type="hidden" name="dog_app" id="dog_app" value="dog" />
<input type="submit" name="input" id="input" value="Click to create your dog info" />
<input type="submit" name="delete" id="delete" value="Click to remove your selected dog info" />
<input type="submit" name="update" id="update" value="Click to update your selected dog info" />
</form>
</div>
</noscript>
</div>
<div id="footer">Copyright &copy; 2020 Little Ocean Waves Publishing - Steve Prettyman</div>
</div> 
</body>
</html>
<?php

}
?>