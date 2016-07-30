<!-- Form submission php
to be used repeeatedly across so in separate file
access with iframe

MAIL IS WORKING
ALL IS WELL
KEEP CALM AND CARRY ONNNNN

to do: 
validation (formvalidation.io?) since php doesn't work - WORKS NOW 
BY CHANGING THE ORDER
AND PUTTING PHP CODE IN-BETWEEN HTML so error messages are in proper form inputs now
error handling alert when empty? YUS
confirmation when sent? bad form but can put in fields

Supposedly there is a jQuery plugin for this. Why...........
-->

<!DOCTYPE HTML> 
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/slate/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="styles_global.css">
	<style>
	body {
		background-color:#2E3338;
	}
	
	#messageField {
		height:140px;
	}
	
	.whiteButton {
		border:1px solid #b2b2b2;
		color:#b2b2b2;
	}

	.whiteButton:hover{
		border:1px solid #ededed;
		color:#ededed;
		background:transparent;
	}
	
	#wideButton {
		width:300px;
		text-align:center;
	}

	</style>
</head>
<body> 

<?php
// define variables and set to empty values
// bad naming convention?
$error = array(
	"nameErr" => "Your name (required)",
	"emailErr" => "Your email (required)",
	"messageErr" => "Message away!",
	"nameEcho" => "",
	"emailEcho" => "",
	"messageEcho" => "",
);
$nameTF = $emailTF = false;
$name = $email= $message = "";
$admin_email = "wenny.h@live.com";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["Name"])) {
		//must fill
		$error["nameErr"] = "Name, please :)";
	} elseif (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		//validation
		$nameErr = "Only letters and white space allowed"; 
	} else {
		$name = test_input($_POST["Name"]);
		$nameTF = true;
	}
	
		//sanitizing email
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	

	if (empty($_POST["Email"])) {
		//must fill
		$error["emailErr"] = "And your email too, please :D";
	//} elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	//	validation
	//	$email = test_input($_POST["Email"]);
	//	$emailTF = true;
	} else {
		$email = test_input($_POST["Email"]);
		$emailTF = true;
	}
	
	$message = test_input($_POST["Message"]);
}

if ($nameTF && $emailTF) {
	$appendmessage = "Sender: ". $name . "\n";
	$appendmessage .="Email: ". $email . "\n";
	$appendmessage .="Message: ". $message . "\n";

	mail($admin_email, $email . " left a message on uv", $appendmessage);
	
	$error["nameErr"] = "Your message has been sent!";
	$error["emailErr"] = "Feel free to close the window now ;)";
	$error["messageErr"] = "Unless you'd like to write another message?";
} else {
	$error["nameEcho"] = $name;
	$error["emailEcho"] = $email;
	$error["messageEcho"] = $message;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">
	<div class="form-group">
		<input type="text" name="Name" class="form-control" id="nameField" placeholder= "<?php echo $error["nameErr"]; ?>" value="<?php echo htmlspecialchars($error["nameEcho"]); ?>">
	</div>
	<div class="form-group">
		<input type="email" name="Email" class="form-control" id="emailField" placeholder="<?php echo $error["emailErr"]; ?>" value=<?php echo htmlspecialchars($error["emailEcho"]); ?>>
	</div>
	<div class="form-group">
		<textarea class="form-control" name="Message" id="messageField" placeholder="<?php echo $error["messageErr"]; ?>"><?php echo htmlspecialchars($error["messageEcho"]); ?></textarea>
	</div>
	<input type="submit" onclick="formSubmit(event)" class="btn btn-default transButton whiteButton" id="wideButton" value="Send">
</form>



</body>
</html>