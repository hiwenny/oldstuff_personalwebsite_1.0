<!--
Copyright © 2016 Wenny Hidayat.
-->

<!-- CREDITS WHERE THEY'RE DUE
Elastic text area effect: Jan Jarfalk @ unwrongest.com
Word counter JS snippet by a good samaritan: http://jsfiddle.net/7DT5z/
-->

<!--
A cesspool of codes in one page since alot of the functionalities aren't shared with other pages..
To make separate files would be redundant.
Until they are, that is. But not now!
-->

<!-- known issues:
- FIXED BY USING NAVBAR AS TOP LV CONTAINER DIV THEN USE GRIDS ONLY FOR LAYOUT ETC navbar classes does not play nice with row/col grid classes (not aligned).
- TOO MUCH NESTING
- THE ABOVE FIX ALSO FIXED THIS ONE. MAYBE CONFLICT IN CLASSES? slow response when resizing window.
- also NAVBAR DOES NOT PLAY NICE WITH MODALS IN A GRID
- NAVBARS ARE NOT NICE
- they look bad on previews, uncombinable, but v ez to set up if following the given structure. bad customization is all. 
- still bad on previews tho even with proper usage. Cheesing using screencap temporarily since iframe preview is a pain 
when it comes to formatting.
- FIXED ADDED KEYUP ON GOAL x/y counter not updating
- FIXED ADDED SET TO 100% progress bar not auto-maxing when changed values of target word count
- FIXED error not coming up on setting target word count to nil
- DUCT TAPE SOLUTION since the update on word counts were done twice - at changes in target word field and text area changes,
- FIXED MIGHT BE SOME MISSING BRACKETS OR SEMICOLON WHEN COPY-PASTING FROM ANOTHER VERSION fix the non-popping up unload first tho

- to use the fixed textarea means cannot hide the scrollbar. Yes, overflow x and y, div width/textarea values has been messed with to no avail.
- to use elastic.js means the bottom will be 'clipped' every newline..
decisions, decisions.

- the count was defined twice (have to do with not making a separate reusable func prototype too). Will fix later - 
for now, the crude amount - 1 works just fine.
- change the prompt for desired word goal? annoying after a while. 
-set the init value to say 4000 and let the user change in the options? 
-->

<!--
To add:
- DONE how to update progress bar according to content
- DONE add discard to re-blank the textarea
- DONE add warnings to closing tab and discard (sure/not)
- DONE input goal!! and compare now vs goal
- DONE sync the word counter, just formatting
- toggle percent/numbers? instead of showing both
- better formatting eg tab acceptance, alignment and so on
- option to copy them all?
- DONE add save, no database structure yet? send to email -> submit functionality?
- database established ->users? can save and continue?
- hide / slide down functionality on the progress bar / save would actually be nice
- upload from file (continue where left off? how2extract text from diff sorts of files?)
- change themes / font / coloring (not v imp)
- add break points eg for quick search paragraphs/tabs for chapters, want rename breakpoints?or 1 2 3 4 etc?
-->

<!-- 
With the essential features in place, probs should change the scheme too.. 
It's safe, clean and simple yet feels.. a bit impersonal.
Clean though, me likey. Will do as a counter-on-the-go.
At least it's not as butt-ugly as before.
-->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AmITY</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cosmo/bootstrap.min.css">
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
	.form-control {
		border-color: inherit;
		-webkit-box-shadow: none;
		box-shadow: none;
	}

	.form-control:focus {
		border-color: inherit;
		-webkit-box-shadow: none;
		box-shadow: none;
	}

	.center {
		text-align:center;
	}
	
	#writeHere {		
		width:100%;
		border:none;
	    background-color:transparent;
		outline: none;
	}
		
	#writeContainer {
		width:100%;
	}
		
	.offsetTop20 {
		top:12px;
	}
	
	.offsetTop4 {
		top:4px;
	}
	
	.roundEdges {
		border-radius:5px;
	}

	#goalField {
		border:none;
		width:50px;
	}
	
	#currentWord{
		float:right;
		width:50px;
		top:10px;
		position:relative;
	}
	
	#emailSet {
		width:200px;
	}
	
	#emailField {
		padding:none;
		margin:0px 0px 4px 4px;
	}
	
	#emailSend {
		margin:0px 4px 4px 0px;	
		border:1px solid black;
	}
	
	#discardButton {
		width:95%;
		margin:0px 4px 0px 4px;
		background-color:#aaaaaa;
		border:1px solid #aaaaaa;
	}

	input[type='number'] {
		-moz-appearance:textfield;
	}

	input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
	}
	
	#progressBar {
		font-size:100%;
		padding-top:8px;
		color:#838383;
	}
	
	.btn {
		border:none;
	}
	
	.progress {
		background:rgba(224, 224, 224, 1); 
		border:2px solid rgba(204, 204, 204, 1); 
		border-radius:5px; height: 28px;
	}
	
	.progress-bar-custom {
		background:rgba(181, 181, 181, 1);
	} 
	.progress-striped .progress-bar-custom {
		background-color: rgba(181, 181, 181, 1); 
		background-image: -webkit-gradient(linear,0 100%,100% 0,color-stop(0.25,rgba(255, 255, 255, 1),color-stop(0.25,transparent),color-stop(0.5,transparent),color-stop(0.5,rgba(255, 255, 255, 1)),color-stop(0.75,rgba(255, 255, 255, 1)),color-stop(0.75,transparent),to(transparent))); 
		background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, 1) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, 1) 50%,rgba(255, 255, 255, 1) 75%,transparent 75%,transparent); 
		background-image: linear-gradient(45deg,rgba(255, 255, 255, 1) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, 1) 50%,rgba(255, 255, 255, 1) 75%,transparent 75%,transparent); 
		background-size: 40px 40px;
	}
	
	#bgNavbar {
		border:none;
	}
	
	.black {
		background-color:white;
		color:black;
	}
	</style>
  </head>
  <body>
<?php
	// define variables and set to empty values
	// bad naming convention?
	$error = array(
		"emailErr" => "Your email (required)",
		"emailEcho" => "",
		"messageEcho" => "",
	);
	
	$emailTF = false;
	$email= $message = "";

	  if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//sanitizing email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);

		if (empty($_POST["Email"])) {
			//must fill
			$error["emailErr"] = "Your email, please";
		} else {
			$email = test_input($_POST["Email"]);
			$emailTF = true;
		}
		
		$message = test_input($_POST["Essay"]);
		$stats = test_input($_POST["Stats"]);
	}

	if ($emailTF) {
		$appendmessage = "Hi there, thank you for using AmITY! Hope you liked it.\n\n";
		$appendmessage .="If you have any suggestions on how to make it better, ";
		$appendmessage .="or saw any bugs that need exterminating - please don't hesitate to send a message or two.\n";
		$appendmessage .="Cheers, wenny@uncannyverily.com\n \n \n";
		$appendmessage .="Word count: ". $stats . "\n\n" . $message . "\n\n";

		mail($email, "Your draft on AmITY", $appendmessage);
		
		$error["emailErr"] = "Your draft has been sent";
	} else {
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

  	<!-- title -->
	<div class="container center" id="topContainer">
		<div class="row center">
			<div id="topRow">
				<h1 class="marginTop50">Am I There Yet?</h1>
				
				<p class="lead">Your progression, visualized.</p>
			</div>
		</div>
	</div>
	
<form method="POST" action="<?PHP echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" accept-charset="UTF-8">	
	<!-- text area for writing -->
	<div class="container center">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
			<div  id="writeContainer">
				<textarea class="marginTop30 form-control" name="Essay" id="writeHere" placeholder="Start your journey here!" /></textarea>
			</div>
			</div>
		</div>
	</div>
				
	<!-- bottom navbar -->
	<div class="navbar navbar-default navbar-fixed-bottom black" id="bgNavbar">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-sm-4 col-md-3 offsetTop4">
					<div class="row">
						<div class="col-xs-6 col-md-6">
							<!-- dropup button -->
							<div class="dropup">
								<button class="btn btn-default dropdown-toggle black" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Options
								<span class="caret"></span>
								</button>
							
								<!-- inside dropdown -->
								<ul class="dropdown-menu" id="emailSet" aria-labelledby="dropdownMenu">
									<li> 
										<div class="input-group">
											<input type="email" class="form-control roundEdges" name="Email" id="emailField" placeholder="Your email">
											<span class="input-group-btn">
												<input type="submit" class="submit btn btn-default roundEdges" id="emailSend" value="Send" />
											</span>
										</div>
									</li>		
									
									<li>
										<button class="btn btn-danger roundEdges" type="button" id="discardButton">Discard</button>
									</li>
								</ul>
							</div>
						</div>
						
						<div class="col-xs-6 col-md-6">
							<div id="currentWord">0</div>
							<input type="hidden" name="Stats" id="hiddenStats" />
						</div>						
					</div>
				</div>
			
				<div class="col-xs-3 col-sm-3 col-md-6 offsetTop20">
					<div class="row">						
						<div class="col-md-10">
							<div class="progress progress-striped">
								<div class="progress-bar progress-bar-custom" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;" id="progressBar">
									0%
								</div>
							</div>
						</div>
					</div>
				</div>		
				
				<div class="col-xs-3 col-sm-3 col-md-3 offsetTop20">
					<input type="number" min="1" step="1" name="Goal" id="goalField" placeholder="Target" />
					<label for="goalField">words</label>
				</div>				
			</div>
		</div>
	</div>
</form>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	
	<!--Elastic script addon-->
	<script src="jquery.elastic.source.js" type="text/javascript" charset="utf-8"></script>
	
	<!-- Custom script add -->
	<script src="javascript_global.js"></script>
	
	<script type="text/javascript">		
		
		$(document).ready(function(){
			//reblank the area on refresh
			$("textarea").val("");
			$("#goalField").val("");
						
			//presets for textarea elasticity
			//no need for elastics? if the method below works. sadly not so far.
			$("#writeHere").elastic();
			$("#writeHere").trigger('update');
			
			// // // //add these lines to limit the area due to navbar below
			// // // //set the height of writing area
			// // // var textareaHeight = $(window).height() - $("#topContainer").height() - $("#bgNavbar").height();
			// // // $("#writeHere").css("min-height",textareaHeight);
			
			// // // //to hide the y-scrollbar tho?
			// // // //overflow hide the x!
			// // // var textareaWidth = $("#writeContainer").width() +50;
			// // // var writeContainerWidth = textareaWidth - 100;
			// // // alert($("#writeHere").width());
			// // // alert($("#writeContainer").width());
			
			// // // // $("#writeContainer").width();
			// // // $("#writeHere").css("min-width",textareaWidth);
			// // // $("#writeHere").width(writeContainerWidth);
			// // // alert($("#writeHere").width());
			// // // alert($("#writeContainer").width());
			
			//setting the vars: targetWord to get the value from input, wordCounts initialized at {}, finalCount as the current # of words init at 0
			var targetWord = 0;
			var wordCounts = {};
			var finalCount = 0;
		
			//update in pairs
			$("#currentWord").html("0/???");
			$("#hiddenStats").val($("#currentWord").html());
			
			//upon setting a goal, update the finalCount/targetWord comparison div
			//restricting non-numeric inputs, negatives, and non-integers.
			$("#goalField").keyup(function() {
				if ($("#goalField").val() > 0) {
					if (( ($("#goalField").val()*10) % 10) == 0) {
						targetWord = $("#goalField").val();
						//update comparison info html
						$("#currentWord").html(finalCount+"/"+targetWord);
						$("#hiddenStats").val($("#currentWord").html());
					}
					
					//same as below. should clean up and put as a standalone function to reuse.........
					//will do for now, though. not v effective since redefinition and all.
					if (targetWord > 0){
						//count the words pnp
						var matches = this.value.match(/\b/g);
						wordCounts[this.id] = matches ? matches.length / 2 : 0;
						finalCount = 0;
						$.each(wordCounts, function(k, v) {
							finalCount += v;
						});
						finalCount = finalCount - 1;
						//update in %
						var valueCount = (finalCount/targetWord)*100;
						valuePercent = Math.round(valueCount*100)/100 + "%";
						//update label and width on progress bar
						$("#currentWord").html(finalCount+"/"+targetWord);
						$("#hiddenStats").val($("#currentWord").html());
						
						$("#progressBar").text(valuePercent);
						if (valueCount <= 100) {
							$("#progressBar").width(valuePercent);
						} else {
							$("#progressBar").width("100%");
						}
					}
				} else {
					$("#goalField").val("");
					targetWord = 0;
					$("#currentWord").html(finalCount+"/???");
					$("#hiddenStats").val($("#currentWord").html());
					$("#goalField").attr("placeholder", "Integers > 0 only");				
				}
			});

			$("textarea").focus(function() {
				if (targetWord < 1) {
					alert("Please set the target word count first");
					$("#goalField").focus();
				}
			});
			
			//upon typing in the text area update the finalCount/targetWord comparison div
			$("textarea").keyup(function() {
				targetWord = $("#goalField").val();
				//check for value in target word count, has to be filled in first
				if (targetWord > 0){
					//count the words pnp
					var matches = this.value.match(/\b/g);
					wordCounts[this.id] = matches ? matches.length / 2 : 0;
					finalCount = 0;
					$.each(wordCounts, function(k, v) {
						finalCount += v;
					});
					
					finalCount = finalCount - 1;
					
					//update in %
					var valueCount = (finalCount/targetWord)*100;
					//for some reason I can't explaiiin
					//i know st. js won't round my nums	
					//therefore the ooodddd methoddddd
					//until the time i rule the worlddd
					valuePercent = Math.round(valueCount*100)/100 + "%";
					
					//update label and width on progress bar
					$("#currentWord").html(finalCount+"/"+targetWord);
					$("#hiddenStats").val($("#currentWord").html());
					
					$("#progressBar").text(valuePercent);
					if (valueCount <= 100) {
						$("#progressBar").width(valuePercent);
					} else {
						$("#progressBar").width("100%");
					}
				} else {
					alert("Please set the target word count first");
					$("#goalField").focus();
				}
			});	
			
			//discard confirmation
			$("#discardButton").click(function() {
				var r = confirm("Do you wish to restart?");
				if (r == true) {			
					$("textarea").val("");
					if($("#goalField").val() == "") {
						$("#currentWord").html("0/???");
					} else {
						$("#currentWord").html("0/"+targetWord);
					}
				$("#hiddenStats").val($("#currentWord").html());
				}				
			});
			
		});
		
		//form submission handling
		$("form").submit( function() {
			if ($("#emailField").val() == "") {
				alert("Please enter an email address");
				return false;
			} else {
				var q = confirm("Is your email address correct?");
				if (q == false) {
					return false;
				} else {
					alert("Sent successfully");
					window.onbeforeunload = null;
				}
			}

		});
				
		//browser closing confirmation
		window.onbeforeunload = function() {
			//checking textarea contents
			if ($("textarea").val() != "") {
				return "Your work will be discarded.";
			}
		};


	</script>
	
</body>
</html>