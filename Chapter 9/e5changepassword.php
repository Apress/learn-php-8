<html>
<head><title>ABC Canine Shelter Reservation System</title>
<link href="e3ajaxdemo.css" rel="stylesheet">
<style type="text/css">
img { height: 100px; width: 140px; }
</style>
</head>
<body>
<div id="wrapper">
<div id="header"><h1><img src="brody.jpg"> ABC Canine Shelter Reservation System</h1>
</div>
<div id="content">
<form method="post" action="">
Userid must contain eight or more characters.<br/>
Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters.<br />
Username: <input type="text" pattern=".{8,}" title="Userid must contain eight or more characters." name="username" id="username" required/><br />
Old Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="oldpassword" id="oldpassword" required /><br />
New Password: <input type="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least one number, one uppercase and lowercase letter, and at least 8 total characters."
 name="password" id="password" required /><br />
Confirm Password:<input name="password_confirm" required="required" type="password" id="password_confirm" oninput="check(this)"  />
<script language='javascript' type='text/javascript'>
function check(input) {
if (input.value != document.getElementById('password').value) {
input.setCustomValidity('Password Must be Matching.');
} else {
// input is valid -- reset the error message
input.setCustomValidity('');
}
}
</script>
<input type="submit" value="submit">
</form>
</div>
<div id="footer">Copyright &copy; 2020 Little Ocean Waves Publishing - Steve Prettyman</div>
</div> 
</body>