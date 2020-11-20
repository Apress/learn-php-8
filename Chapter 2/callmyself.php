<?php
if (isset($_POST['submitbutton']))
{
print "<h1> Hello World </h1>";
}
else
{
print "<html><head><title>PHP Example</title></head>";
print "<form method='post' action='e26callmyself.php'>";
print "<input type='submit' id='submitbutton' name='submitbutton' value='Find Hello World!'/>";
print "</form>";
print "</body></html>";
}
?>