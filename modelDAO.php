<?php 
require_once('abstractDAO.php');
require_once('event.php');

class modelDAO extends abstractDAO{


	function __construct() {

        try{
            parent::__construct();
        } catch(mysqli_sql_exception $e){
            throw $e;
        }
    }

    public function addEvent($event){
        
        if(!$this->mysqli->connect_errno){
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            $query = 'INSERT INTO events (event_name, event_start_date, event_end_date) VALUES (?,?,?)';
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $stmt = $this->mysqli->prepare($query);
            //The first parameter of bind_param takes a string
            //describing the data. In this case, we are passing 
            //three variables: an integer(employeeId), and two
            //strings (firstName and lastName).
            //
            //The string contains a one-letter datatype description
            //for each parameter. 'i' is used for integers, and 's'
            //is used for strings.
            $stmt->bind_param('sss', 
                $event->getName(),
                $event->getStartDate(), 
                $event->getEndDate()
                );
            //Execute the statement
            $stmt->execute();
            //If there are errors, they will be in the error property of the
            //mysqli_stmt object.
            if($stmt->error){
                return $stmt->error; 
            } else {
                return $event->getName() . ' added successfully!';
            }
        } else {
            return 'Could not connect to Database.';
        }
    }

    public function getEvents(){
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM events');
        $events = Array();
        
        if($result->num_rows >= 1){
            while($row = $result->fetch_assoc()){
                //Create a new employee object, and add it to the array.
                $event = new Event($row['event_name'], $row['event_start_date'], $row['event_end_date']);
                $events[] = $event;
            }
            $result->free();
            return $events;
        }
        $result->free();
        return false;
    }

}
?>










































