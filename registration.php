
<?php if($eventDetails['use_cost_cat'] == 1) : ?>
<script>
var catChoice = $('input[name=catRadio]:checked').val();
$(".costOption").hide();

$(".catRadio").change(function(){
	var catChoice = $('input[name=catRadio]:checked').val().replace(" ", "_");
	catChoice = catChoice.replace(/\(/g,"");
	catChoice = catChoice.replace(/\)/g,"");
	catChoice = catChoice.replace(/\//g,"");
	catChoice = catChoice.replace(/ /g,"_");
	//catChoice = catChoice.replace("\\","");
	
	console.log("CAT CHOICE CHANGED: " + catChoice); 
	$(".costOption").hide();
	$(".emptyCosts").hide();
	$("." + catChoice).show();
});

</script>
<?php endif; ?>
<?php else: ?>
	<div class='soldout'>
		<?php echo $eventDetails['sold_out_msg']; ?>
	</div>
<?php endif; ?>
<?php endif; ?>
<?php 

function CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days){
		
		$beginingString = "<div class='costOptionsForm'><h3>" . TextSelector("Conference Choice (Required)","Choix d'atelier (obligatoire)") . "&nbsp;<span class='glyphicon glyphicon-exclamation-sign'></span></h3>";
		echo "$beginingString";

		//Display Today's date
		$currentTime = date('F j, Y', time());
		

		//You need to evaluate super early and early birds
		$earlyDate=date('F j, Y', strtotime($eventDetails['early_date']));
		$superEarlyDate=date('F j, Y', strtotime($eventDetails['super_early_date']));
		$diffEarly = strtotime($earlyDate) - time();
		$diffSuperEarly = strtotime($superEarlyDate) - time();
		$isSuperSaver = false;
		$isEarlyBird = false;
		$taxRate = $eventDetails['tax_rate'];
		$taxDesc = $eventDetails['tax_desc'];
		
		if($diffSuperEarly > 0){
			echo "<p> Super Saver - Valid Before $superEarlyDate </p>";
			$isSuperSaver = true;
			$isEarlyBird = false;
		} else if($diffEarly > 0){
			echo "<p> Early Bird - Valid Before $earlyDate </p>";
			$isSuperSaver = false;
			$isEarlyBird = true;
		} else {
			echo '<p>Today\'s date is: <strong>'.$currentTime.'</strong></p>';
			$isSuperSaver = false;
			$isEarlyBird = false;
		}

		//Display Cost Options with ID and prices
		$countCost = count($eventCost);
		$eventCostDisp = $eventDetails['cost_display'];

		if($eventDetails['use_cost_cat'] == 1){
			$catChoices = "";
			foreach($costCategories as $cat){
				$catChoices .= "<div><input type='radio' name='catRadio' class='catRadio' value='". $cat['category_name']. "'><label>" . $cat['category_name'] . "</label></div>";
			}
			echo "<div class='category-pick'><h3>Pick a conference category</h3>$catChoices</div>";
			
			
		}

		if($eventCostDisp == "grid"){
			echo "<table class='table table-bordered' style='table-layout: auto !important;'><tr><td><strong>Conference Choice</strong></td><td><strong>Cost</strong></td><td><strong>Tax</strong></td><td><strong>Total</strong></td></tr>";
			if($eventDetails['use_cost_cat'] == 1){
				echo "<tr class='emptyCosts'><td><strong>No options for selected category</strong></td><td></td><td></td><td></td></tr>";
			}
			
		} else {
			echo "<div class='emptyCosts'><strong>No options for selected category</strong></div>";
		} 

		for($i = 0; $i < $countCost; $i++)
		{
			$costType = $eventCost[$i]['cost_regular'];
			$costCategory = str_replace(" ", "_", $eventCost[$i]['cost_category']);
			$costCategory = str_replace("(", "", $costCategory );
			$costCategory = str_replace(")", "", $costCategory );
			$costCategory = str_replace("/", "", $costCategory );
			$costCategory = str_replace('\\', "", $costCategory );
			$costOneday = $eventCost[$i]['is_oneday'];
			if($isSuperSaver){
				$costType = $eventCost[$i]['cost_super_early_bird'];
			
			}
			if($isEarlyBird){
				$costType = $eventCost[$i]['cost_early_bird'];
			}
			$class = "costOptionBox";
			$cID = "";
			if($costOneday == 1){
				$class .= " oneday";
			}
			if($eventCost[$i]['nDays'] != "" && $eventCost[$i]['nDays'] != 0){
				$cID = $eventCost[$i]['nDays'];
			}
			if($eventCostDisp == "grid"){
				$radioInput = "<input type='radio' name='event_option' class='$class' value='".$eventCost[$i]['event_cost_option_id']."' id='$cID'>";
				$cChoice = $eventCost[$i]['cost_level'];
				$cost = "$" . $costType;
				$tax = $taxDesc . " " . $taxRate ;
				$total = "<strong>$" .money_format('%i', round(($taxRate*$costType+$costType), 2)) . "</strong>";
				$hiddenWW = "<input type='hidden' id='wwc_" . $eventCost[$i]['event_cost_option_id'] . "' value='" . $eventCost[$i]['workshop_score'] . "'>";
				echo "<tr class='". $costCategory . " costOption'><td>". $radioInput. " $hiddenWW<span>$cChoice</span></td><td>$cost</td><td>$tax</td><td>$total</td></tr>";
				
			} else {
			echo "<input type='hidden' name='ev_cost' value='$costType' />";
			echo "<input type='hidden' name='ev_tax_type' value='$taxDesc' />";
			$taxVal = $taxRate*$costType;
			echo "<input type='hidden' name='ev_tax_val' value='$taxVal' />";
			$totalPrice = $costType + $taxVal;
			echo "<input type='hidden' name='ev_total_cost' value='$totalPrice' />";
			$hiddenWW = "<input type='hidden' id='ww_" . $eventCost[$i]['event_cost_option_id'] . "' value='" . $eventCost[$i]['workshop_score'] . "'>";
			echo "<label class='". $costCategory . " costOption' style='width:100%'><input type='radio' name='event_option' value='".$eventCost[$i]['event_cost_option_id']."' class='$class' id='$cID'>$hiddenWW<span>".$eventCost[$i]['cost_level']."</span>: $".$costType ." + $taxDesc ".$taxRate." = ".money_format('%i', round(($taxRate*$costType+$costType), 2))."</label>";
			}

		}
		if($eventCostDisp == "grid"){
			echo "</table>";
		}
		echo "</div>";	
		//Echo the extra days selection
		/*
		$daySelect = "<select name='day_option' class='form-control dayselector'><option></option>";
		foreach($days as $day){
			$dayDate = new DateTime($day);
			$dayStr = $dayDate->format("l jS F Y");
			$daySelect .= "<option value='$day'>$dayStr</option>";
		}
		$daySelect .= "</select>";
		*/
		$daySelect = "";
		foreach($days as $day){
			$dayDate = new DateTime($day);
			$dayStr = $dayDate->format("l jS F Y");
			$daySelect .= "<input type='checkbox' name='day_option[]' class='dayselector' value='$day'><label>$dayStr</label><br>";
		}
		
		echo "<div class='daySelection' style='display:none;'><h3>Select a date: <span class='glyphicon glyphicon-exclamation-sign'></span></h3>$daySelect</div>";
}
function createWorkshops($eventWorkshop){
	global $lang;
echo "<div class='note' style='    background-color: rgba(233, 234, 196, 0.72);
    padding: 5px;
    border: 1px solid rgba(0, 0, 0, 0.26);
    border-radius: 5px;'>" . TextSelector("To change your selections please click the reset selections button", "Pour changer vos séléctions, cliquer le boutton ci-dessous"). "        &nbsp; <br><br><button type='button' class='btn btn-secondary' id='resetWorkshops'>" . TextSelector("Reset Workshop Selection", "Réinitialiser les ateliers"). "</button></div>";
	if(!empty($eventWorkshop)){
		echo "<h4>" . TextSelector(" Workshop Selection: ", "Ateliers: ") . "</h4>";
			foreach($eventWorkshop as $day=>$sessionDay){
				$dayTable = "<div id='day_$day' class='wwDay'><table class='table dayTable'>";
				$dayDate = new DateTime($day);
				$dayStr = strftime("%A %e %B %G", strtotime($day));
				$dayTable .= "<tr><td><strong>$dayStr</strong></td></tr>";
				$dayTable .= "</table>";
				echo $dayTable;
				$sessionTable = "<table class='table table-striped sessionTable' style='table-layout:fixed;'>";
				foreach($sessionDay as $time=>$rsessions){
					$timeStr = explode("_", $time);
					$timeStart = new DateTime($timeStr[0]);
					$timeEnd = new DateTime($timeStr[1]);
					if($lang == "fr"){
						$timeStart = $timeStart->format("H\\hi");
						$timeEnd = $timeEnd->format("H\\hi");
					} else {
						$timeStart = $timeStart->format("H:i");
						$timeEnd = $timeEnd->format("H:i");
					}
					$rowStr = "<tr><td colspan='1'>$timeStart - $timeEnd</td><td colspan='3'>";
					$spkrStr = "";
					$spkrStr2 = "";
					foreach($rsessions as $session){
						$sessionTitle = TextSelector($session['session_title'], $session['session_title_fr']);
						$sessionID = $session['session_id'];
						$sessionCode = $session['session_code'];
						$sessionSpeakers = $session['speakers'];
						$containedSessions = $session['containedSessions'];
						$scStr = "";
						$spkrStr = "";
						$containedStr = "";
	
						$scStr = "";
						if(!empty($sessionSpeakers)){
							$spkrStr = "<div class='session_speakers'><h4>" . TextSelector("Featuring:", "Animé Par:") . "</h4>";
							$spkrStr2 = "<div class='session_speakers'><h4>" . TextSelector("Featuring:", "Animé Par:") . "</h4>";
							foreach($sessionSpeakers as $spkr){
								$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
								$spkrTitle = TextSelector($spkr['speaker_title'], $spkr['speaker_title_fr']);
								$spkrCompany = TextSelector($spkr['speaker_company'],$spkr['speaker_company_fr']);
								$spkrBio = TextSelector($spkr['speaker_bio'], $spkr['speaker_bio_fr']);
								$spkrStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span><br>
											<span class='spkrBio'>$spkrBio</span></div><br>";
								$spkrStr2 .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span></div><br>";
							}
							$spkrStr .= "</div>";
						}

						if($sessionCode != ""){
							$scStr = "$sessionCode : ";
						}
						$sessionDesc = html_entity_decode(TextSelector($session['session_description'], $session['session_description_fr']));
						$sessionRoom = $session['roomName'];
						$sessionType = $session['session_type'];
						$sessionColor = $session['color'];
						$sessionWW =$session['workshop_weight'];
						$hiddenWW = "<input type='hidden' class='workshopweight' id='ww_$sessionID' value='$sessionWW'>";
						$selectBox= "";
						$checked = "";
						$sessionInfoStr ="<h4><strong>" .  $sessionTitle . "</strong></h4>" . $sessionDesc . $spkrStr;
						$shortSpkr = '';
						if(!empty($containedSessions)){
							$containedStr = "<div class='contained_sessions'><h2>" . TextSelector("Grouped Session", "Session en groupe") . "</h2>";
							foreach($containedSessions as $cSession){
								$cSpkrs = $cSession['speakers'];
								$cspStr = "";
								if(!empty($cSpkrs)){
									$cspStr = "<div class='session_speakers'><h4>" . TextSelector("Featuring:", "Animé Par:") . " </h4>";
									$shortSpkr = "<div class='session_speakers'><h4>" . TextSelector("Featuring:", "Animé Par:") ."</h4>";
									foreach($cSpkrs as $spkr){
										$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
										$spkrTitle = TextSelector($spkr['speaker_title'], $spkr['speaker_title_fr']);
										$spkrCompany = TextSelector($spkr['speaker_company'],$spkr['speaker_company_fr']);
										$spkrBio = TextSelector($spkr['speaker_bio'], $spkr['speaker_bio_fr']);
										$cspStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span><br>
													<span class='spkrBio'>$spkrBio</span></div><br>";
										$shortSpkr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span></div><br>";
									}
									$cspStr .= "</div>";
								}

								$csStr = "<div class='c_session' style='background-color:" . $cSession['color'] . ";'><h3>" . html_entity_decode(TextSelector($cSession['session_title'], $cSession['session_title_fr'])) . "</h3><p>" . html_entity_decode(TextSelector($cSession['session_description'],$cSession['session_description_fr'])) . "</p>$cspStr</div>";
								$containedStr .= $csStr;
							}
							$containedStr .= "</div>";
							$sessionInfoStr = $containedStr;
						}
						
						if(isset($selections)){
							foreach($selections as $sel){
								//echo "CHECK IF $sel[session_id] == $sessionID ";
								if($sel['session_id'] == $sessionID){
									$checked = "checked";
								}
							}
						}
						if($sessionType != "plenary"){
							if(count($rsessions) > 1){
								$selectBox =  "<input type='radio' id='$sessionID' class='selectSession' name='selectWorkshop_" . $sessionID . "[]' value='$sessionID' $checked>";
							} else{
								$selectBox =  "<input type='checkbox' id='$sessionID' class='selectSession' name='selectWorkshop_" . $sessionID . "[]' value='$sessionID' $checked>";
							}
						}
						if($spkrStr != ""){
							$rightSpkr = "<div class='spkrs_$sessionID'> $spkrStr2 </div>";
						} else {
							$rightSpkr =  "<div class='spkrs_$sessionID'> $shortSpkr </div>";
						}
						$showMore = "<span class='showMore' id='$sessionID'>" . TextSelector("Show Details", "Plus de détails") . "</span> <span style='font-style:italic;'>$sessionRoom</span>";
						$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$selectBox  $scStr $sessionTitle $showMore $hiddenWW </div></div>";
						$details = "<div id='details_$sessionID' class='sDetails' style='display:none;'>$sessionInfoStr </div>";
						$rowStr .= $sessionStr;
						$rowStr .= $details;
					}
					$rowStr .= "</td></tr>";
					$sessionTable .= $rowStr;
				}
				$sessionTable .= "</table></div>";
				echo $sessionTable;
			}

			//echo "<button type='submit' class='btn btn-primary' name='saveSelections'>Submit</button>";
			//echo "<form>";
		} 

	}

function createExtraCosts($isSuperSaver, $isEarlyBird, $extraCosts){
	if(!empty($extraCosts)){
		$titleStr = "<div id='extraCosts'><h2>Extra Options</h2><ul>";
		echo "$titleStr";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = $cost['cost_level'];
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			echo "<li><input type='checkbox' name='extraCost[]' value='$costID'><label style='display:inline;'>$costLabel - $$costPrice</label></li>";
		}
		echo "</ul></div>";
	}
}
?>
<script>
var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);

	function refreshWorkshops(){
		//This function disables workshop selections based on days chosed and event option workshop score
		
	}

jQuery(document).ready(function($) {
	var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);
	var handleSessions = function(form){
		
		if(isOneDay){
			//Get the days selected
			$(".wwDay").hide();
			$(".dayselector").each(function(){
				var sDay = $(this).val();
			//	console.log("checking " + sDay);
				var checked = $(this).prop("checked");
				
				if(checked){
					console.log("DAY : " + sDay );
					$("#day_" + sDay).show();
				}
			});
		} else {
			$(".wwDay").show();
		}
		
		if(totalScore == workshopScore){
			//console.log("Score met");
			//disable all inpupt that isn't checked
			$(".selectSession").each(function(){
				var sChecked = $(this).prop("checked");
				if(!sChecked){
					$(this).prop("disabled", true);
				}
			});
		} else {
			//enable only selections that don't over the score
			$(".selectSession").each(function(){
				var sChecked = $(this).prop("checked");
				var sID = $(this).attr("id");
				var sScore = parseInt($("#ww_" + sID).val());
				
				if(!sChecked){
				
					if(totalScore + sScore > workshopScore){
					
						$(this).prop("disabled", true);
					} else {
					
						$(this).prop("disabled", false);
					}
				}
			})
		}
		console.log("Handle sessions: WS: " + workshopScore + " TS: "  + totalScore);
	};
	handleSessions();
$("#resetWorkshops").click(function(){
 $(".selectSession").each(function(){
    $(this).prop('checked', false);
 });
  totalScore = 0;
  handleSessions();
});
	$(".costOptionBox").change(function(){
		var isOneDayChecked = false;
		var checkedOption = null;
		var costID = $(this).val();
		$(".dayselector").each(function(){
			$(this).prop("checked", false);
		});
		$(".selectSession").each(function(){
			$(this).prop('checked', false);
		});
		workshopScore = 0;
		totalScore = 0;
		$(".costOptionBox").each(function(){
			var checked = $(this).prop("checked");
			var costID = $(this).val();
			var costWW = $("#wwc_" + costID).val();
			
			if($(this).hasClass("oneday")){
				if(checked){
				//	console.log("checked one day option");
					isOneDayChecked = true;
					isOneDay = true;
					checkedOption = $(this);
					
				} else {
					//console.log("Unchecked one day option");
				}	
			} else {
				if(checked)
					isOneDay = false;
			}
			if(checked){
				workshopScore = costWW;
				handleSessions();
			}
		});
		if(isOneDayChecked){
			//display day selection
			$(".daySelection").fadeIn("fast");
		} else {
			$(".daySelection").fadeOut("fast");
		}
		if(checkedOption != null){
			nDays = parseInt(checkedOption.attr("id"));
			//console.log("Checked option is here");
			checkDays();
		}
	});
	$(".dayselector").click(function(){
		checkDays();
		handleSessions();
	});
	
	$(".showMore").click(function(){
console.log("Clicked show more");
		var id = $(this).attr("id");
		$("#details_" + id).slideToggle();
	});
	//Calc total score by checked sessions
	$(".selectSession").each(function(){
		var checked = $(this).prop("checked");
		var id = $(this).attr('id');
		var score = parseInt($("#ww_" + id).val());
		if(checked){
			totalScore += score;
		}
	});
	handleSessions();
	
	$(".selectSession").click(function(){
		//console.log("Clicked a session box");
		var checked = $(this).prop("checked");
		var id = $(this).attr("id");
		var score = parseInt($("#ww_" + id).val());
		if(checked){
			totalScore += score;
			//console.log("Added " + score + " to score: " + totalScore);
		} else {
			totalScore -= score;
			//console.log("Removed " + score + " from score: " + totalScore);
		}
		
		handleSessions();
	});


var dir = $("#dir").val();
var validOptions = {
		rules:{
			catRadio: "required",
			email:{
				required:true,
				email:true
			},
			confirmemail:{
				required:true,
				equalTo: '#email',
				
			},
			first_name:"required",
			last_name:"required",
			day_option:"required",
			event_option:"required"
		},
		messages:{
			catRadio: "Please select a category",
			email: {
				required: "We need your e-mail address to contact you back",
				email: "Your email address must be in the format of name@domain.com"
			},
			confirmemail: {
				required: "Please confirm your email",
				equalTo: "Your confirmation email must match your email"
			},
			first_name:"Please enter your first name",
			last_name:"Please enter your last name",
			day_option:"Please select a date",
			event_option:"Please choose an option"
		},
		invalidHandler: function(event, validator) {
		    // 'this' refers to the form
		    var errors = validator.numberOfInvalids();
		    if (errors) {
		      var message = errors == 1
		        ? 'You missed 1 field. It has been highlighted'
		        : 'You missed ' + errors + ' fields. They have been highlighted';
		      alert(message);
		      
		    } else {
		      $("div.error").hide();
		    }
	      },
	      submitHandler: function(form){
	      	
	      	//$('#myTerm').modal();
	      //	console.log("SUBMIT FORM");
	      },
	      errorPlacement: function(error, element) {
	      	if(element.hasClass("dayselector")){
	      		error.appendTo(element.parent());
	      	} else {
		      	  if(element.prev(".glyphicon").length > 0){
	  		 	 error.appendTo( element.prev(".glyphicon") );
	  		  } else if(element.parent().parent().find(".glyphicon").length > 0){
	  		  	error.appendTo( element.parent().parent().find(".glyphicon") );
	  		  } else if(element.parent().parent().parent().find(".glyphicon").length > 0){
	  		  	error.appendTo( element.parent().parent().parent().find(".glyphicon") );
	  		  } else{
	  		  	error.appendTo( element.parent().parent().parent().parent().parent().find(".glyphicon") );
	  		  }
  		  }
  		},
	      debug:true
	};
$("#reg").validate(validOptions);
	
	$("#addDel").click(function(){
		addDelegate();
		$('html,body').animate({
	          scrollTop: $('#registered').offset().top
	        }, 500);
	});
	$("#saveReg").click(function(){
		var $frm = $("#reg");
		if($frm.valid()){
			addDelegate();
			$("#registration-form").parent().hide();
			$("#myTerm").show();
			$('html,body').animate({
		          scrollTop: $('#registered').offset().top
		        }, 500);
		}
	});
	
	$('#termAccept').click(function(){
		var checkboxes = $('#myTerm').find('.term').length;
		var Rchecked = $('.terms_checkbox').filter(':checked').length + $('.terms_radio').filter(':checked').length;
		console.log("CHECKBOXES: " + checkboxes +  " CHECKED:  " + Rchecked);
		var buttonElem = $(this);
		var captchaVal = grecaptcha.getResponse();
		if (checkboxes == Rchecked && captchaVal != "")
		{
			
			var regArray = new Array();
			$(".regged").each(function(index){
			//	console.log("GOT A REG");
				regArray[index] = $(this).serialize();
			});
			var termsArray = new Array();
			$(".terms_checkbox").filter(':checked').each(function(index){
				var termName= $(this).prop("name");
				var termVal = $(this).val();
				var obj = {};
				obj["" + termName] = termVal;
				termsArray.push(obj);
				console.log("Got a term " + termName + termVal);
			});
			$(".terms_radio").filter(':checked').each(function(index){
				var termName= $(this).prop("name");
				var termVal = $(this).val();
				var obj = {};
				obj["" + termName] = termVal;
				termsArray.push(obj);
			});
			var jsonString = JSON.stringify(regArray);
			var termInfo = JSON.stringify(termsArray);
			buttonElem.hide();
			buttonElem.parent().append($("<span>Please wait...</span>"));
			
			$.ajax({
				type: 'POST',
				url: '../' + dir + '/addregs',
				data: {data: jsonString, terms: termInfo, recaptcha: captchaVal},
				success: function(result){
					
					if(result != 0){
						location.href="../" + dir + "/confirmation";
					//	console.log("RESULT: " + result);
					} else {
						alert("Wrong Captcha Information");
					}
					//location.href="../" + dir + "/confirmation";

				},
				error: function(){
					alert('There was a problem during registration.  Please contact Verney');
				}

			});//ajax
			
			
		}else{
			alert('You must read and check all to continue with Registration');

		}
	});
	
function addDelegate(){
	//console.log("add delegate");
	var $frm = $("#reg");
	
	if($frm.valid()){
		//Add delegate info

		var newForm = $("#reg").clone();
		
		
		newForm.find("input").each(function(index){
			if($(this).attr("class") != "catRadio valid" && $(this).attr("type") != "radio" && $(this).attr("type") != "checkbox" && $(this).attr("name") != "event_id" && $(this).attr("type") != "hidden"){
				$(this).val("");
			} else if($(this).attr("class") != "catRadio valid"){
				$(this).prop("checked", false);
			}
		});
		var that = newForm;
		newForm.find(".catRadio").each(function(index){
			$(this).change(function(){
				var catChoice = "";
				if($(this).prop('checked')){
					catChoice = $(this).val().replace(" ", "_");
					catChoice = $(this).val().replace("(","");
					catChoice = $(this).val().replace(")","");
					catChoice = $(this).val().replace("/","");
					catChoice = $(this).val().replace("\\","");
					that.find(".costOption").hide();
					that.find(".emptyCosts").hide();
					that.find("." + catChoice).show();
				}
				
				
			});
		});
		newForm.find(".selectSession").each(function(index){
			$(this).prop("disabled", false);
		});
		newForm.find(".dayselector").click(function(){
		checkDays();
		handleSessions();
	});
newForm.find(".costOptionBox").change(function(){
console.log("Clicked cost option");
		var isOneDayChecked = false;
		var checkedOption = null;
		var costID = $(this).val();
		that.find(".dayselector").each(function(){
			$(this).prop("checked", false);
		});
		that.find(".selectSession").each(function(){
			$(this).prop('checked', false);
		});
		workshopScore = 0;
		totalScore = 0;
		that.find(".costOptionBox").each(function(){
			var checked = $(this).prop("checked");
			var costID = $(this).val();
			var costWW = $("#wwc_" + costID).val();
			
			if($(this).hasClass("oneday")){
				if(checked){
				//	console.log("checked one day option");
					isOneDayChecked = true;
					isOneDay = true;
					checkedOption = $(this);
					
				} else {
					//console.log("Unchecked one day option");
				}	
			} else {
				if(checked)
					isOneDay = false;
			}
			if(checked){
				workshopScore = costWW;
				handleSessions();
			}
		});
		if(isOneDayChecked){
			//display day selection
			$(".daySelection").fadeIn("fast");
		} else {
			$(".daySelection").fadeOut("fast");
		}
		if(checkedOption != null){
			nDays = parseInt(checkedOption.attr("id"));
			//console.log("Checked option is here");
			checkDays();
		}
	});
	newForm.find(".selectSession").click(function(){
		//console.log("Clicked a session box");
		var checked = $(this).prop("checked");
		var id = $(this).attr("id");
		var score = parseInt($("#ww_" + id).val());
		if(checked){
			totalScore += score;
			//console.log("Added " + score + " to score: " + totalScore);
		} else {
			totalScore -= score;
			//console.log("Removed " + score + " from score: " + totalScore);
		}
		
		handleSessions();
	});
		newForm.validate(validOptions);
		
		$(".reg").each(function(index){
			//console.log("PARENT: " + $(this).parent().attr("id"));
			var parent = $(this).parent().attr("id");
			if(parent == "registration-form"){
				$(this).addClass("regged");
				$("#registrants").append($(this));
				//Create element for HUD
				var name = $(this).find("[name=first_name]").val() + " " + $(this).find("[name=last_name]").val();
				var selection = $(this).find("[name=event_option]:checked").next().html();
				
				var HUDelem = $("<table style='table-layout:fixed; width:100%;'><tr class='registeredHUD'><td>" + name + "</td><td style='margin-left: 50%;'><strong>" + selection + "</strong></td></tr></table>");
				$("#registered").append(HUDelem);
				$("#registered").show();
			}
		});
		$("#registration-form").append(newForm);
		newForm = null;
		
		
	}

}
function checkDays(){
		if(nDays == 0){
			$(".dayselector").attr("disabled", true);
		}else{
			//Get number of selected days
			var nDaysSelected = 0;
			$(".dayselector:checked").each(function(){
				nDaysSelected++;
			});
			if(nDaysSelected == nDays){
				$(".dayselector").each(function(){
					var dayChecked = $(this).prop("checked");
					if(!dayChecked ){
						$(this).attr("disabled", true);
					}
				});
			} else if(nDaysSelected < nDays){
				$(".dayselector").attr("disabled", false);
			}
		}
		
	}
});


	

	
</script>