<?php
function errorHandler($severity, $message, $file, $line) {
   	 throw new errorException($message, 0, $severity, $file, $line);
      }
	  
class userException extends Exception { }

set_error_handler('errorHandler');

try {
require_once("e1testerror.php");
$tester = new testerror();
$tester->throwexception();
echo "This line does not display";
$tester->produceerror(); // will not execute if line 13 is executed
echo "This line does not display";
   }      
catch (errorException $e ){
	echo $e->getMessage(); }
catch (userException $e) {
    echo $e->getMessage(); }
catch (Exception $e) {
	echo $e->getMessage(); }
echo "This line will display";
?>