<?php
class testerror
{

function produceerror() {

 trigger_error( "User Error", E_USER_ERROR);
 echo "This line will not display";
 }
 function throwexception() {
 throw new userException("User Exception");
 echo "This line will not display";
 }
 }
?>