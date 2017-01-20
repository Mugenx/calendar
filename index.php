<?php include('header.php') ?>
<?php require_once('modelDAO.php') ?>


<div class="container" style="color: white; width: 900px; background-color: #b78500;  padding:50px 50px 50px; margin: 50px auto; box-shadow: 0 0 2rem rgba(0, 0, 0, 0.3);">

  <p style="text-align:center"><span style="font-size:48px">EVENTS &amp; CLIENTS</span></p>

  <p style="text-align:center"><span style="font-size:16px"><em><strong>~ Celebrating 15 years of great clients and fabulous events! ~</strong></em></span></p>

  <hr />
  <p>The essence of continued operational excellence at VCM is the ability to deliver a complete end-to-end service. VCM integrates innovative solutions and best practices in a way that creates a real bond with our clients and ensures high value outcomes for their events - both now and in the future. <em>At VCM, we believe that effective communication breeds efficiency.</em><br />
    <br />
    Efficiency has woven its way into our business practices as well. Nothing can facilitate the event planning process more than eliminating steps, which we&#39;ve done by assuming many 3rd party service provider responsibilities in-house.<br />
    <br />
    VCM&#39;s independently produced events have also grown more efficient - they target the exact audience they should with the precise message that needs to be heard. We know this because the audience has a seat at the planning table, and always will. Our delegates have a stake in their learning, and it&#39;s efficient.<br />
    <br />
    Finally, we&#39;ve streamlined the event planning process so much, that we were able to put the tools we developed in a box, put a bow on it and present EventSystemPro (ESP) to the masses. Designed by VCM&#39;s event planners, ESP&#39;s Suite simplifies the event management process so planners can manage the complexities of multiple events in less time.<br />
    <br />
    <em>As we continue to grow and change, finding efficiencies for ourselves and our clients remains our first priority.</em></p>


    <div id='calendar' ></div>

  </div>

  <script type="text/javascript">
    $(document).ready(function() {

      $('#calendar').fullCalendar({
        header: {
          left: 'prev,next today',
          center: 'title',
          right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: ' <?php echo date("Y-m-d") ?>',
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [

      <?php 
      try{
        $modelDAO = new modelDAO();
        $events = $modelDAO->getEvents();
        if($events){
          foreach($events as $event){
            echo '{';
            echo 'title: "' . $event->getName() . '",';
            echo 'start: "' . $event->getStartDate() . '",';
            echo 'end: "' . $event->getEndDate() . '",';
            echo '},';
          }
        }
        
      }catch(Exception $e){
     //If there were any database connection/sql issues,
    //an error message will be displayed to the user.
        echo '<h3>Error on page.</h3>';
        echo '<p>' . $e->getMessage() . '</p>';   
      }

      ?>
      // {
      //   title: 'SK Connections',
      //   url: 'http://www.skconnections.ca',
      //   start: '2017-05-10',
      //   end: '2017-05-12'
      // },
      // {
      //   title: 'ARMA Spring Workshops',
      //   url: 'http://www.eventsystempro.com/arma2217',
      //   start: '2017-05-15',
      //   end: '2017-05-17'
      // },
      // {
      //   title: 'CBS Annual Conference',
      //   url: 'http://www.cbs-scb.ca',
      //   start: '2017-05-24',
      //   end: '2017-05-27'
      // },
      // {
      //   title: 'Maritime Connections Workshops',
      //   url: 'http://www.maritimeconnections.ca',
      //   start: '2017-06-13',
      //   end: '2017-06-15'
      // },
      // {
      //   title: 'Staff of Elected Officials Bootcamp',
      //   url: 'http://www.seobootcamp.ca',
      //   start: '2017-06-01',
      //   end: '2017-07-01'
      // }
      ]
    });
      
    });
  </script>

  <div class="rTop" id="rTop" onClick="toTop()">
    <span class="glyphicon glyphicon-chevron-up" style="font-size: 20px; padding: 10px 0; 
    " ></span>
  </div>





  <?php include('footer.php') ?>