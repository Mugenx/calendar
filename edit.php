<?php require_once('modelDAO.php'); ?>
<?php include 'header.php'; ?>

<?php
        //The abstractDAO and modelDAO will throw exceptions
        //if there is a problem with the database connection.
        //The entire web page is contained in the try block, so
        //if there is any issue, the page does not load, and instead
        //informs the user about the error.
try{
    $modelDAO = new modelDAO();
            //Tracks errors with the form fields
    $hasError = false;
            //Array for our error messages
    $errorMessages = Array();

            //Ensure all four values are set.
            //They will only be set when the form is submitted.
            //We only want the code that adds an event to 
            //the database to run if the form has been submitted.
    if( isset($_POST['event_name']) ||
        isset($_POST['event_start_date']) || 
        isset($_POST['event_end_date'])){

            //event_name check
        if($_POST['event_name'] == ""){
            $errorMessages['event_nameError'] = 'Please enter event name';
            $hasError = true;
        }

            //event_start_date check
        if($_POST['event_start_date'] == ""){
            $errorMessages['event_start_dateError'] = 'Please enter event start date';
            $hasError = true;
        }

            //event_end_date check
        if($_POST['event_end_date'] == ""){
            $errorMessages['event_end_dateError'] = 'Please enter event end date';
            $hasError = true;
        }

            //if no error, create a new event
        if(!$hasError){
            $event = new Event($_POST['event_name'], $_POST['event_start_date'], $_POST['event_end_date']);
            $addSuccess = $modelDAO->addEvent($event);
        }
    }   
    ?>


    <div id="frame" align="center">


        <form name="survey" id="survey"  method="post" action="edit.php">

            <input type="text" placeholder="EVENT NAME" name="event_name" id="event_name" value="<?php echo $_POST['event_name']; ?>">
            <?php 
            if(isset($errorMessages['event_nameError'])){
                echo '<br><span style=\'color:red\'>' . $errorMessages['event_nameError'] . '</span>';
            }
            ?>


            <input type="text" placeholder="EVENT START DATE" name="event_start_date" id="event_start_date" value="<?php echo $_POST['event_start_date']; ?>">
            <?php 
            if(isset($errorMessages['event_start_dateError'])){
                echo '<br><span style=\'color:red\'>' . $errorMessages['event_start_dateError'] . '</span>';
            }
            ?>


            <input type="text" placeholder="EVENT END DATE" name="event_end_date" id="event_end_date"  value="<?php echo $_POST['event_end_date']; ?>">
            <?php 
            if(isset($errorMessages['event_end_dateError'])){
                echo '<br><span style=\'color:red\'>' . $errorMessages['event_end_dateError'] . '</span>';
            }
            ?>
            
            <br>
            <?php echo '<h3>'. $addSuccess .'</h3>'; ?>

            <div id="submit">
                <br>
                <input type='submit' value='Submit'>&nbsp;&nbsp;&nbsp;
                <input type="reset" value='Reset'>
            </div>

            <div id="buttons">
                <br><br><br>
                <a href="index.php" >View the Calendar</a>
            </div>


            <?php
        }catch(Exception $e){
            //If there were any database connection/sql issues,
            //an error message will be displayed to the user.
            echo '<h3>Error on page.</h3>';
            echo '<p>' . $e->getMessage() . '</p>';   
        }         
        ?>
    </form>

</div>


<?php include 'footer.php'; ?>

