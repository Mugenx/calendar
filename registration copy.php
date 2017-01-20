		<?php if(isset($errorBrowser)) : ?>
		<div class='errorBrowser'>
			<?php 
			echo TextSelector("Outdated browser detected: To use this registration form, please upgrade your browser to Internet Explorer 11 or higher, alternatively you can also use Chrome or Firefox", "Navigateur web pas à jour! S'il vous plaît mettre à jour votre navigateur - Internet Explorer 11 ou plus, ou alternativement Chrome ou Firefox");
			?>
		</div>
	<?php else: ?>
			<?php 
			$titleSplit = explode(" ", $eventDetails['etitle']);
			$dateStart = explode("-", $eventDetails['start_date']);
			$dateEnd = explode("-", $eventDetails['end_date']);
			$dateString = "";
			
			if($dateStart[1] == $dateEnd[1]){
				$dateObj   = DateTime::createFromFormat('!m', $dateEnd[1]);
				$monthName = $dateObj->format('F'); 
				$dateString = $monthName . " " . ltrim($dateStart[2], '0') . "th - " . ltrim($dateEnd[2], '0') . "th, " . $dateEnd[0] ;
			} else {
				$startMonthName = DateTime::createFromFormat('!m', $dateStart[1])->format('F');
				$endMonthName = DateTime::createFromFormat('!m', $dateEnd[1])->format('F');
				$dateString = $startMonthName . " " . $dateStart[2] . " - " . $endMonthName . " " . $dateEnd[2] . ", " . $dateEnd[0] ;
			}
			$locationString = $eventDetails['location'];
			$infoString = $dateString . " | " . $locationString;
			$description = $eventDetails['edescription'];
			
			//Display Today's date
			$currentTime = date('F j, Y', time());
			
	
			//You need to evaluate super early and early birds
			$earlyDate=date('F j, Y', strtotime($eventDetails['early_date']));
			$superEarlyDate=date('F j, Y', strtotime($eventDetails['super_early_date']));
			$diffEarly = strtotime($earlyDate) - time();
			$diffSuperEarly = strtotime($superEarlyDate) - time();
			$isSuperSaver = false;
			$isEarlyBird = false;
			
			if($diffSuperEarly > 0){
				$isSuperSaver = true;
				$isEarlyBird = false;
			} else if($diffEarly > 0){
				$isSuperSaver = false;
				$isEarlyBird = true;
			} else {
				$isSuperSaver = false;
				$isEarlyBird = false;
			}
		
		 ?>
			<h1><?php echo TextSelector("Registration for: ".$title, "Inscription pour: ".$title);?></h1>
			<div class="bg-info" style="padding: 10px; border-radius: 10px;"><?php echo htmlspecialchars_decode(TextSelector($eventDetails['reg_preamble'],$eventDetails['reg_preamble_fr'])); ?></div>

	
	
	<p class="bg-danger" style="padding: 10px; border-radius: 10px;"><?php echo TextSelector("Required fields are marked <i class='glyphicon glyphicon-exclamation-sign'></i>", "Les champs obligatoires sont indiqu&eacute;s <i class='glyphicon glyphicon-exclamation-sign'></i>");?></p>
	<strong><p class="bg-danger" style="padding: 10px; border-radius: 10px;"><?php echo TextSelector("You may register multiple delegates in succession by clicking ‘add delegate’ at the bottom of this form. <big><i class='glyphicon glyphicon-info-sign'></i></big>", "Les champs obligatoires sont indiqu&eacute;s <big><i class='glyphicon glyphicon-info-sign'></i></big>");?></p></strong>
<div id="registered">
	<h3>Registered users in your group</h3>
</div>

<div>
<?php if($eventDetails['is_soldout'] == 0): ?>
<div  id="registration-form">
<form method="post" action=""  id="reg" class="reg">
	<input type='hidden' id='dir' name='event_dir' value='<?php echo $eventDetails['directory_name']; ?>'>
	<div class="col-md-12 main formBlock">

			<?php
			if($eventDetails['cost_display_top'] == 1){
			 CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days);
			 createWorkshops($eventWorkshop);
			 createExtraCosts($isSuperSaver, $isEarlyBird, $eventExtraCost);
			}
			
			?>
			<div class="col-md-6">
				<h2><?php echo TextSelector("Personal Information","Information Personelle");?></h2>
				<!--<input type="hidden" name="number_of_delegates" value="<?php echo $num_delegates;?>">-->
				<input type="hidden" name="event_id" value="<?php echo $eventID; ?>">
			
				<label><?php echo TextSelector("First Name (Required)","Pr&eacute;nom (obligatoire)");?></label>&nbsp;<span class="glyphicon glyphicon-exclamation-sign"></span>
				<input type="text" class="form-control" name="first_name" value="<?php if(isset($_POST['first_name'])){echo $_POST['first_name'];} ?>">
				
				<label><?php echo TextSelector("Last Name (Required)","Nom de famille (obligatoire)");?></label>&nbsp;<span class="glyphicon glyphicon-exclamation-sign"></span>
				<input type="text" class="form-control" name="last_name" value="<?php if(isset($_POST['last_name'])){echo $_POST['last_name'];} ?>">
				
				<label><?php echo TextSelector("Job Title","Titre De Travail");?></label>
				<input type="text" class="form-control" name="job_title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">

				<label><?php echo TextSelector("Organization","Organisation");?></label>
				<input type="text" class="form-control" name="organization" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
			
			</div>
			<div class="col-md-6">
				<h2><?php echo TextSelector("Address Information","Adresse");?></h2>	
				
				<label><?php echo TextSelector("Address","Adresse");?></label>
				<input type="text" class="form-control" name="address1" value="<?php if(isset($_POST['address1'])){echo $_POST['address1'];} ?>">
			
				<label><?php echo TextSelector("Town or city","Ville");?></label>
				<input type="text" class="form-control" name="city" value="<?php if(isset($_POST['city'])){echo $_POST['city'];} ?>">
				
				<label><?php echo TextSelector("Province","Province");?></label>
				<input type="text" class="form-control" name="province" value="<?php if(isset($_POST['province'])){echo $_POST['province'];} ?>">
				
				<label><?php echo TextSelector("Postal Code","Code Postal");?></label>
				<input type="text" class="form-control" name="postal" value="<?php if(isset($_POST['postal'])){echo $_POST['postal'];} ?>">

			</div>
		
	</div>
	<div class="col-md-12 formBlock">

			<div class="col-md-6">
				<h2><?php echo TextSelector("Contact Information","Coordonn&eacute;es");?></h2>
				
				<label><?php echo TextSelector("Telephone","T&eacute;l&eacute;phone");?></label>
				<input id="telephone" type="text" class="form-control" name="telephone" value="<?php if(isset($_POST['telephone'])){echo $_POST['telephone'];} ?>">
				
				<label><?php echo TextSelector("Fax","T&eacute;l&eacute;copieur");?></label>
				<input id="fax" type="text" class="form-control" name="fax" value="<?php if(isset($_POST['fax'])){echo $_POST['fax'];} ?>">
				
				<label><?php echo TextSelector("Email (Required)","Courriel (obligatoire)");?></label>&nbsp;<span class="glyphicon glyphicon-exclamation-sign"></span>
				<input type="text" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
				
				<label><?php echo TextSelector("Confirm Email (Required)","Confirmer courriel (obligatoire)");?></label>&nbsp;<span class="glyphicon glyphicon-exclamation-sign"></span>
				<input type="text" class="form-control" id="confirmemail" name="confirmemail" value="<?php if(isset($_POST['confirmemail'])){echo $_POST['confirmemail'];} ?>">
				
				<?php if($num_delegates == 1)
				{ ?>
				<label><?php echo TextSelector("Send a copy of the invoice to this email address:","Envoyez une copie de la facture &agrave; courriel suivante :");?></label>
				<div class="input-group">
					<span class="input-group-addon">
						<input type="checkbox" value="1">
					</span>
						<input type="text" class="form-control" name="invoicecopyemail" value="<?php if(isset($_POST['invoicecopyemail'])){echo $_POST['invoicecopyemail'];} ?>">
				</div>
			</div>
				<?php }?>
			<div class="col-md-6">
				<h2><?php echo TextSelector("Special Requirements","Exigences particuli&egrave;res");?></h2>
		
					<label><?php echo TextSelector("In the space provided below please include any special requirements you may have, such as food allergies or accessibility needs.","Veuillez indiquer dans l'espace pr&eacute;vu ci-dessous, si vous avez des exigences particuli&egrave;res comme des allergies alimentaires ou des probl&egrave;mes d'accessibilit&eacute;.");?>
					<textarea class="form-control" name="needs" rows="10"></textarea></label>
					
			
			</div>
	</div>



	<div class="col-md-12 formBlock formEndBlock">
		<?php 
			if($eventDetails['cost_display_top'] == 0){
			 CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days);
			 createWorkshops($eventWorkshop);
			 createExtraCosts($isSuperSaver, $isEarlyBird, $eventExtraCost);
			}

		?>

<?php
		//Get extra questions here
		if(isset($extraQuestions)){
			
			foreach($extraQuestions as $question){
				echo "<fieldset class='col-md-12 formBlock'>";
				echo "<legend>". $question['question_label'] . "</legend>";
				echo "<div class='extraInfo'>". $question['extra_info'] ."</div>";
				if($question['question_type'] == "radio"){
					$options = explode("||", $question['options']);
					foreach($options as $o){
						echo "<input type='radio' name='extra_" . $question['question_id'] . "' value='$o'><label>$o</label><br>";
					}	
				}
				if($question['question_type'] == "checkbox"){
					$options = explode("||", $question['options']);
					foreach($options as $o){
						echo "<input type='checkbox' name='extra_" . $question['question_id'] . "[]' value='$o'><label>$o</label><br>";
					}	
				}
				if($question['question_type'] == "textbox"){
						echo "<input type='text' name='extra_" . $question['question_id'] . "' class='form-control'><br>";
				}
				if($question['question_type'] == "textarea"){
						echo "<textarea ' name='extra_" . $question['question_id'] . "' class='form-control'></textarea><br>";
				}
				echo "</fieldset>";
				//echo "EXTRA QUESTION: " . $question['question_label']; 
			}
		}


?>

			<h3><?php echo TextSelector("Promo Code","Code d'inscription");?></h3>
				<label><?php echo TextSelector("Please enter your promo code if applicable:","Si vous avez un code d'inscription, veuillez l'enscrire ici :");?><input type="text" name="promo_code_used"></label>


	
	
	<p id="codes">&nbsp;</p>
</div>
</form>
</div>

		<div>
			<button type='button' class='btn btn-primary' id="addDel"><?php echo TextSelector("Save and Add Delegate","Sauvegarder et ajouter un autre membre");?></button>
			<button class="btn btn-primary" id="saveReg" align="right" >
  				<?php echo TextSelector("Save and Continue","Soumettre");?>
			</button>
		</div>
</div>
<div id="registrants" style="display:none;"></div>

<div  id="myTerm" style="display:none;" tabindex="-1" role="dialog" >
  <div >
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="myModalLabel">Terms and Conditions</h2>
      </div>
      <div class="modal-body">
      <p><strong>Please note:</strong> In order to complete your registration you must acknowledge each term below by checking the "I accept" checkbox and provide a response to the CASL Compliance question.  Secondly you must prove you are not a robot maliciously auto filling forms by checking the "I'm not a Robot" box at the bottom of the page, fill in the randomly generated code provided, then finalize by hitting submit.</p>
    	<?php 
    	$countTerm = count($eventTerms);
    	for ($i=0; $i < $countTerm; $i++) { 
    		echo "<div class='term'><h3>".$eventTerms[$i]['title']."</h3>
    				<label><p>".$eventTerms[$i]['content']."</p></label>";
  
    		if($eventTerms[$i]['term_type'] == "radio"){
    			echo "<form class='radioAcceptForm ". $eventTerms[$i]['term_id'] . "'>";
    			$multiOptions = explode("||", $eventTerms[$i]['options']);
    			$op = 0;
    			foreach($multiOptions as $option){
    				echo "<input type='radio' class='terms_radio' name='term_".$eventTerms[$i]['term_id']."' value='$option'>$option<br>";
    				$op++;
    			}
    			echo "</form>";
    		} else {
    			echo"<p class='bg-danger'>I accept / J'accepte la ".$eventTerms[$i]['title']."
    				<input type='checkbox' class='terms_checkbox' name='term_".$eventTerms[$i]['term_id']."' value='1'></label>
    				</p>";
    		}
echo "</div>";
    			}?>
      </div>
      <div class="modal-footer">
      	<div class="g-recaptcha" id="recaptcha" data=type="image" data-sitekey="6Lckbv4SAAAAAEe_MFIXbaarlWIjw4NAVpeEtD9_"></div>
        <button type="button" class="btn btn-default" id="cancelReg" onclick="location.reload();">Cancel</button>
        <button id="termAccept" type="button" class="btn btn-primary">Continue</button>
      </div>
    </div>
  </div>
</div>
<script>


</script>


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
</div>
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
			echo "<p> Super Saver - Valid Until $superEarlyDate </p>";
			$isSuperSaver = true;
			$isEarlyBird = false;
		} else if($diffEarly > 0){
			echo "<p> Early Bird - Valid Until $earlyDate </p>";
			$isSuperSaver = false;
			$isEarlyBird = true;
		} else {
			echo '<p>Today\'s date is: <strong>'.$currentTime.'</strong></p>';
			$isSuperSaver = false;
			$isEarlyBird = false;
		}
                echo "<p><strong>To see a complete rate sheet, please click <a href='http://cbs-scb.ca/cbs0517/about#Rates' target='_blank'>here</a></strong></p>";
		//Display Cost Options with ID and prices
		$countCost = count($eventCost);
		$eventCostDisp = $eventDetails['cost_display'];

		if($eventDetails['use_cost_cat'] == 1){
			$catChoices = "";
			foreach($costCategories as $cat){
				$catChoices .= "<div><input type='radio' name='catRadio' class='catRadio' value='". $cat['category_id']. "'><label>" . TextSelector($cat['category_name'], $cat['category_name_fr']) . "</label></div>";
			}
			echo "<div class='category-pick'><h3>" . TextSelector("Pick a conference category", "Veuillez faire un choix") . "</h3>$catChoices</div>";
			
			
		}

		if($eventCostDisp == "grid"){
			echo "<table class='table table-bordered' style='table-layout: auto !important;'><tr><td><strong>" . TextSelector("Conference Choice","Choix d'atelier") . "</strong></td><td><strong>" . TextSelector("Cost", "Prix") . "</strong></td><td><strong>" . TextSelector("Tax","Taxe") . "</strong></td><td><strong>" . TextSelector("Total","Total") . "</strong></td></tr>";
			if($eventDetails['use_cost_cat'] == 1){
				echo "<tr class='emptyCosts'><td><strong>" .  TextSelector("No options for selected category","Aucune options existe pour cette catégorie") . "</strong></td><td></td><td></td><td></td></tr>";
			}
			
		} else {
			echo "<div class='emptyCosts'><strong>"  .  TextSelector("No options for selected category","Aucune options existe pour cette catégorie") . "</strong></div>";
		} 

		for($i = 0; $i < $countCost; $i++)
		{
			$costType = $eventCost[$i]['cost_regular'];
			$costCategory = str_replace(" ", "_", $eventCost[$i]['cost_category']);
			$costCategory = str_replace("(", "", $costCategory );
			$costCategory = str_replace(")", "", $costCategory );
			$costCategory = str_replace("/", "", $costCategory );
			$costCategory = str_replace('\\', "", $costCategory );
			foreach($costCategories as $cat){
				if($cat['category_name'] == $eventCost[$i]['cost_category']){
					$costCategory = $cat['category_id'];
				}
			}
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
				$cChoice = TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr']);
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
			echo "<label class='". $costCategory . " costOption' style='width:100%'><input type='radio' name='event_option' value='".$eventCost[$i]['event_cost_option_id']."' class='$class' id='$cID'>$hiddenWW<span>".TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr'])."</span>: $".$costType ." + $taxDesc ".$taxRate." = ".money_format('%i', round(($taxRate*$costType+$costType), 2))."</label>";
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
			if($day != "2016-05-25" && $day != "2016-05-28"){
				$daySelect .= "<input type='checkbox' name='day_option[]' class='dayselector' value='$day'>  <label>$dayStr</label><br>";
			}
		}
		
		echo "<div class='daySelection' style='display:none;'><h3>Select a date: <span class='glyphicon glyphicon-exclamation-sign'></span></h3>$daySelect</div>";
}
function createWorkshops($eventWorkshop){
	global $lang;
	echo "<div class='workshops'>";
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
			echo "</div>";
			//echo "<button type='submit' class='btn btn-primary' name='saveSelections'>Submit</button>";
			//echo "<form>";
		} 

	}

function createExtraCosts($isSuperSaver, $isEarlyBird, $extraCosts){
	if(!empty($extraCosts)){
		$titleStr = "<div id='extraCosts'><h2>I would like to subscribe/renew my CBS membership</h2>";
$titleStr .="<p>In order to be eligible to receive the CBS member conference registration rate, please register/renew your CBS membership. One-year CBS Memberships will expire on May 31, 2017; two-year CBS Memberships will expire on May 31, 2018. If you are not sure whether you are a currently registered member of the CBS, please contact <a href='mailto:info@bioethics.ca'>info@bioethics.ca</a>.</p>";
$titleStr .=  "<p>For details on the benefits and criteria for CBS Membership categories, please visit the <a href='https://www.bioethics.ca/becoming-member/benefits.html' target='_blank'>CBS website</a>.</p>";
		echo "$titleStr";
		echo "<ul class='yearSelect' style='list-style:none;'>";
		echo "<li class='year'><input type='radio' class='yearSelectRadio' id='1year' name='yearRenew'>1 Year</li>";
		echo "<li class='yearOptions' id='yo_1year'>";
		echo "<ul class='e_1year' >";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "1 Year"){
			echo "<li><input type='radio' name='extraCost[]' value='$costID'><label style='display:inline;'>$costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li class='year'><input type='radio' class='yearSelectRadio' id='2year'  name='yearRenew'>2 Years</li>";
		echo "<li class='yearOptions' id='yo_2year'>";
		echo "<ul class='e_2year' >";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "2 Year"){
			echo "<li><input type='radio' name='extraCost[]' value='$costID'><label style='display:inline;'>$costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li><br> </li><li class='year'>Optional Donations</li>";
		echo "<li class='d' id='yo_donations'>";
		echo "<ul class='e_donations' style='list-style:none;'>";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "Donations"){
			echo "<li><input type='checkbox' name='extraCost[]' value='$costID'> <label style='display:inline;'> $costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li><br> </li><li class='year'>Reception Tickets</li>";
		echo "<li class='d' id='yo_reception'>";
		echo "<ul class='e_reception' style='list-style:none;'>";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "Reception Ticket"){
			echo "<li><input type='checkbox' name='extraCost[]' value='$costID'> <label style='display:inline;'> $costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";

		echo "</ul>
		</div>";
	}
}
?>
<script>
$(".yearOptions").hide();
$(".yearSelectRadio").click(function(){
	var checked = $(this).prop("checked");
	var id = $(this).attr("id");
	$(".yearOptions").hide();
	console.log("Clicked year " + checked);
	if(checked){
		$("#yo_" + id).show();
		console.log("Showing #yo_" + id);
	}
});
var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);

	function refreshWorkshops(){
		//This function disables workshop selections based on days chosed and event option workshop score
		
	}
$(".workshops").hide();
jQuery(document).ready(function($) {
	var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);
	var handleSessions = function(form){
		
		if(isOneDay){
			//Get the days selected
			//$(".wwDay").hide();
			$(".dayselector").each(function(){
				var sDay = $(this).val();
			//	console.log("checking " + sDay);
				var checked = $(this).prop("checked");
				
				if(checked){
				//	console.log("DAY : " + sDay );
					$("#day_" + sDay).show();
				}
			});
		} else {
			//$(".wwDay").show();
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
				if(costWW == 0){
					$(".workshops").hide();
				}else{
					$(".workshops").show();
				}
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
		var checkboxes = $('#myTerm').find('.terms').length;
		var Rchecked = $('.terms').filter(':checked').length;
		//console.log("CHECKBOXES: " + checkboxes +  " CHECKED:  " + Rchecked);
		var buttonElem = $(this);
		var captchaVal = grecaptcha.getResponse();
		if (checkboxes == Rchecked && captchaVal != "")
		{
			
			var regArray = new Array();
			$(".regged").each(function(index){
			//	console.log("GOT A REG");
				regArray[index] = $(this).serialize();
			});
			
			var jsonString = JSON.stringify(regArray);
			
			buttonElem.hide();
			buttonElem.parent().append($("<span>Please wait...</span>"));
			
			$.ajax({
				type: 'POST',
				url: 'https://www.eventsystempro.net/cbs0517/addregs',
				data: {data: jsonString, recaptcha: captchaVal},
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
					catChoice = $(this).val().replace(" ", "_");
console.log("Find " + catChoice);
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
				if(costWW == 0){
					$(".workshops").hide();
				}else{
					$(".workshops").show();
				}
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
</div>
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
</div>
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
			echo "<p> Super Saver - Valid Until $superEarlyDate </p>";
			$isSuperSaver = true;
			$isEarlyBird = false;
		} else if($diffEarly > 0){
			echo "<p> Early Bird - Valid Until $earlyDate </p>";
			$isSuperSaver = false;
			$isEarlyBird = true;
		} else {
			echo '<p>Today\'s date is: <strong>'.$currentTime.'</strong></p>';
			$isSuperSaver = false;
			$isEarlyBird = false;
		}
                echo "<p><strong>To see a complete rate sheet, please click <a href='http://cbs-scb.ca/cbs0517/about#Rates' target='_blank'>here</a></strong></p>";
		//Display Cost Options with ID and prices
		$countCost = count($eventCost);
		$eventCostDisp = $eventDetails['cost_display'];

		if($eventDetails['use_cost_cat'] == 1){
			$catChoices = "";
			foreach($costCategories as $cat){
				$catChoices .= "<div><input type='radio' name='catRadio' class='catRadio' value='". $cat['category_id']. "'><label>" . TextSelector($cat['category_name'], $cat['category_name_fr']) . "</label></div>";
			}
			echo "<div class='category-pick'><h3>" . TextSelector("Pick a conference category", "Veuillez faire un choix") . "</h3>$catChoices</div>";
			
			
		}

		if($eventCostDisp == "grid"){
			echo "<table class='table table-bordered' style='table-layout: auto !important;'><tr><td><strong>" . TextSelector("Conference Choice","Choix d'atelier") . "</strong></td><td><strong>" . TextSelector("Cost", "Prix") . "</strong></td><td><strong>" . TextSelector("Tax","Taxe") . "</strong></td><td><strong>" . TextSelector("Total","Total") . "</strong></td></tr>";
			if($eventDetails['use_cost_cat'] == 1){
				echo "<tr class='emptyCosts'><td><strong>" .  TextSelector("No options for selected category","Aucune options existe pour cette catégorie") . "</strong></td><td></td><td></td><td></td></tr>";
			}
			
		} else {
			echo "<div class='emptyCosts'><strong>"  .  TextSelector("No options for selected category","Aucune options existe pour cette catégorie") . "</strong></div>";
		} 

		for($i = 0; $i < $countCost; $i++)
		{
			$costType = $eventCost[$i]['cost_regular'];
			$costCategory = str_replace(" ", "_", $eventCost[$i]['cost_category']);
			$costCategory = str_replace("(", "", $costCategory );
			$costCategory = str_replace(")", "", $costCategory );
			$costCategory = str_replace("/", "", $costCategory );
			$costCategory = str_replace('\\', "", $costCategory );
			foreach($costCategories as $cat){
				if($cat['category_name'] == $eventCost[$i]['cost_category']){
					$costCategory = $cat['category_id'];
				}
			}
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
				$cChoice = TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr']);
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
			echo "<label class='". $costCategory . " costOption' style='width:100%'><input type='radio' name='event_option' value='".$eventCost[$i]['event_cost_option_id']."' class='$class' id='$cID'>$hiddenWW<span>".TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr'])."</span>: $".$costType ." + $taxDesc ".$taxRate." = ".money_format('%i', round(($taxRate*$costType+$costType), 2))."</label>";
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
			if($day != "2016-05-25" && $day != "2016-05-28"){
				$daySelect .= "<input type='checkbox' name='day_option[]' class='dayselector' value='$day'>  <label>$dayStr</label><br>";
			}
		}
		
		echo "<div class='daySelection' style='display:none;'><h3>Select a date: <span class='glyphicon glyphicon-exclamation-sign'></span></h3>$daySelect</div>";
}
function createWorkshops($eventWorkshop){
	global $lang;
	echo "<div class='workshops'>";
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
			echo "</div>";
			//echo "<button type='submit' class='btn btn-primary' name='saveSelections'>Submit</button>";
			//echo "<form>";
		} 

	}

function createExtraCosts($isSuperSaver, $isEarlyBird, $extraCosts){
	if(!empty($extraCosts)){
		$titleStr = "<div id='extraCosts'><h2>I would like to subscribe/renew my CBS membership</h2>";
$titleStr .="<p>In order to be eligible to receive the CBS member conference registration rate, please register/renew your CBS membership. One-year CBS Memberships will expire on May 31, 2017; two-year CBS Memberships will expire on May 31, 2018. If you are not sure whether you are a currently registered member of the CBS, please contact <a href='mailto:info@bioethics.ca'>info@bioethics.ca</a>.</p>";
$titleStr .=  "<p>For details on the benefits and criteria for CBS Membership categories, please visit the <a href='https://www.bioethics.ca/becoming-member/benefits.html' target='_blank'>CBS website</a>.</p>";
		echo "$titleStr";
		echo "<ul class='yearSelect' style='list-style:none;'>";
		echo "<li class='year'><input type='radio' class='yearSelectRadio' id='1year' name='yearRenew'>1 Year</li>";
		echo "<li class='yearOptions' id='yo_1year'>";
		echo "<ul class='e_1year' >";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "1 Year"){
			echo "<li><input type='radio' name='extraCost[]' value='$costID'><label style='display:inline;'>$costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li class='year'><input type='radio' class='yearSelectRadio' id='2year'  name='yearRenew'>2 Years</li>";
		echo "<li class='yearOptions' id='yo_2year'>";
		echo "<ul class='e_2year' >";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "2 Year"){
			echo "<li><input type='radio' name='extraCost[]' value='$costID'><label style='display:inline;'>$costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li><br> </li><li class='year'>Optional Donations</li>";
		echo "<li class='d' id='yo_donations'>";
		echo "<ul class='e_donations' style='list-style:none;'>";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "Donations"){
			echo "<li><input type='checkbox' name='extraCost[]' value='$costID'> <label style='display:inline;'> $costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";
		echo "<li><br> </li><li class='year'>Reception Tickets</li>";
		echo "<li class='d' id='yo_reception'>";
		echo "<ul class='e_reception' style='list-style:none;'>";
		foreach($extraCosts as $cost){
			$costID = $cost['extra_event_cost_option_id'];
			$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
			$costPrice = $cost['cost_regular'];
			if($isEarlyBird){
				$costPrice = $cost['cost_early_bird'];
			} 
			if($isSuperSaver){
				$costPrice = $cost['cost_super_early_bird'];
			}
			if($cost['category'] == "Reception Ticket"){
			echo "<li><input type='checkbox' name='extraCost[]' value='$costID'> <label style='display:inline;'> $costLabel - $$costPrice</label></li>";
			}
		}
		echo "</ul>
			</li>";

		echo "</ul>
		</div>";
	}
}
?>
<script>
$(".yearOptions").hide();
$(".yearSelectRadio").click(function(){
	var checked = $(this).prop("checked");
	var id = $(this).attr("id");
	$(".yearOptions").hide();
	console.log("Clicked year " + checked);
	if(checked){
		$("#yo_" + id).show();
		console.log("Showing #yo_" + id);
	}
});
var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);

	function refreshWorkshops(){
		//This function disables workshop selections based on days chosed and event option workshop score
		
	}
$(".workshops").hide();
jQuery(document).ready(function($) {
	var nDays = 0;
	var workshopScore = 0;
	var isOneDay = false;
	var totalScore = parseInt(0);
	var handleSessions = function(form){
		
		if(isOneDay){
			//Get the days selected
			//$(".wwDay").hide();
			$(".dayselector").each(function(){
				var sDay = $(this).val();
			//	console.log("checking " + sDay);
				var checked = $(this).prop("checked");
				
				if(checked){
				//	console.log("DAY : " + sDay );
					$("#day_" + sDay).show();
				}
			});
		} else {
			//$(".wwDay").show();
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
				if(costWW == 0){
					$(".workshops").hide();
				}else{
					$(".workshops").show();
				}
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
		var checkboxes = $('#myTerm').find('.terms').length;
		var Rchecked = $('.terms').filter(':checked').length;
		//console.log("CHECKBOXES: " + checkboxes +  " CHECKED:  " + Rchecked);
		var buttonElem = $(this);
		var captchaVal = grecaptcha.getResponse();
		if (checkboxes == Rchecked && captchaVal != "")
		{
			
			var regArray = new Array();
			$(".regged").each(function(index){
			//	console.log("GOT A REG");
				regArray[index] = $(this).serialize();
			});
			
			var jsonString = JSON.stringify(regArray);
			
			buttonElem.hide();
			buttonElem.parent().append($("<span>Please wait...</span>"));
			
			$.ajax({
				type: 'POST',
				url: 'https://www.eventsystempro.net/cbs0517/addregs',
				data: {data: jsonString, recaptcha: captchaVal},
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
					catChoice = $(this).val().replace(" ", "_");
console.log("Find " + catChoice);
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
				if(costWW == 0){
					$(".workshops").hide();
				}else{
					$(".workshops").show();
				}
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
</div>