<?php include 'header.php'; ?>
<?php require_once('modelDAO.php'); ?>

<div id="list" align="center">

    <?php 
    try{
      $modelDAO = new modelDAO();
      $events = $modelDAO->getEvents();
      if($events){
                //We only want to output the table if we have customer.
                //If there are none, this code will not run.
        echo '<table>';
        echo '<tr><th>name</th><th>start date</th><th>end date</th></tr>';
        foreach($events as $event){
            echo '<tr>';
            echo '<td>' . $event->getName() . '</td>';
            echo '<td>' . $event->getStartDate() . '</td>';
            echo '<td>' . $event->getEndDate() . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
    
}catch(Exception $e){
     //If there were any database connection/sql issues,
    //an error message will be displayed to the user.
    echo '<h3>Error on page.</h3>';
    echo '<p>' . $e->getMessage() . '</p>';   
}

?>




</div>
<?php include 'footer.php'; ?>