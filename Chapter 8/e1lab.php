<?php 
session_start();
if ((!isset($_SESSION['username'])) || (!isset($_SESSION['password']))) {
echo "You must login to access the ABC Canine Shelter Reservation System";
echo "<p>";
echo "<a href='e2login.php'>Login</a> | <a href='e3register.php'>Create an account</a>";
echo "</p>";
}
else
{
echo "<p>Welcome back, " . $_SESSION['username'] . "</p>";
?>
<!DOCTYPE html>
<html lan="en">
<head>
<title>Dog Object</title>
<script src="eget_breeds.js"></script>
<script src="evalidator.js"></script>
<style type="text/css">

#JS { display:none; }

</style>

<script>
function checkJS() {

document.getElementById('JS').style.display = "inline";

}
</script>

</head>

<body onload="checkJS();">
<h1>Dog Object Creater</h1>
<div id="JS">
<form method="post" action="e5dog_interface.php" onSubmit="return validate_input(this)">
<h2>Please complete ALL fields. Please note the required format of information.</h2>
Enter Your Dog's Name (max 20 characters, alphabetic) <input type="text" pattern="[a-zA-Z]*"  title="Up to 20 Alphabetic Characters" maxlength="20" name="dog_name" id="dog_name" required/><br /><br />
Select Your Dog's Color:<br />
<input type="radio" name="dog_color" id="dog_color" value="Brown">Brown<br />
<input type="radio" name="dog_color" id="dog_color" value="Black">Black<br />
<input type="radio" name="dog_color" id="dog_color" value="Yellow">Yellow<br />
<input type="radio" name="dog_color" id="dog_color" value="White">White<br />
<input type="radio" name="dog_color" id="dog_color" value="Mixed" checked >Mixed<br /><br />

Enter Your Dog's Weight (numeric only) <input type="number" min="1" max="120" name="dog_weight" id="dog_weight" required /><br /><br />
<script>
AjaxRequest('e5dog_interface.php');
</script>
<input type="hidden" name="dog_app" id="dog_app" value="dog" />
Select Your Dog's Breed <div id="AjaxResponse"></div><br />
<input type="submit" value="Click to create your dog" />
</form>
</div>
<noscript>
<div id="noJS">
<form method="post" action="e5dog_interface.php">
<h2>Please complete ALL fields. Please note the required format of information.</h2>
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
<input type="submit" value="Click to create your dog" />
</form>
</div>
</noscript>
</body>
</html>
<?php

}
?>