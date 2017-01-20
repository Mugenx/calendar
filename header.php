<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../favicon.ico">

  <title>VERNEY CALENDAR</title>

  <!-- Bootstrap core CSS -->
  <!-- <link href="dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- Just for debugging purposes. Don"t actually copy these 2 lines! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  <script src="assets/js/ie-emulation-modes-warning.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
      
      <!-- Custom styles for this template -->
      <link href="css/style.css" rel="stylesheet">
      <!-- calendar css -->
      <link href="css/fullcalendar.min.css" rel="stylesheet" />
      <link href="css/fullcalendar.print.min.css" rel="stylesheet" media="print" />
     

      <style type="text/css">
        .navbar-nav > li > a {
          text-align: center;
          padding-top: 15px;
          font-size: 15px;
        }
        .navbar .navbar-nav {
          display: inline-block;
          float: none;
          vertical-align: top;
        }

        .navbar .navbar-collapse {
          text-align: center;
        }

        #nav {
          position: fixed;
          top: -200px;
          width: 100%;
          z-index: 10000;
          transition: top 0.5s ease 0s;
          -webkit-transition: top 0.5s ease 0s;
          -moz-transition: top 0.5s ease 0s;
          -o-transition: top 0.5s ease 0s;
        }

        #calendar {
          max-width: 800px;
          margin: 50px auto 0;
        }

        .fc td{
          color: #003366;
          background-color: white;
          border: 1px solid #d5d5d5;
        }
        .fc-ltr .fc-basic-view .fc-day-top .fc-day-number {
          color: #003366;
        }
        .fc-unthemed td.fc-today {
          background-color: #ffcc35;
        }

      </style>
      
    </head>
    <body>
      <!-- header -->
      <div class="container-fluid" style="background-color:#f3f8fc;color:#fff; padding:0;
      margin-bottom: -10px" >
      <div style="background: linear-gradient(to right, rgba(0,51,102,0.5),rgba(250,250,250,1),rgba(250,250,250,1),rgba(250,250,250,1),rgba(0,51,102,0.5)" align="center" >
        <a href="index.php"><img src="img/vcm_logo.png" style="width: 55vmin; padding:25px 0"></a>
        <p style="color: #003366; padding: 1rem; font-size: 3vmin; font-family:times new roman; font-style: italic;">
          "Celebrating 15 Years of Event Production and Management in Canada!"
        </p>
      </div>
    </div>

    <div  class="navbar" align="center"  >
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">VERNEY</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">EVENTS & CLIENTS</a></li>
            <li><a href="edit.php">EDIT</a></li>
            <li><a href="list.php">LIST</a></li>
            <!-- <li><a href="services.php">SERVICES</a></li> -->
            <!-- <li><a href="events&clients.php">EVENTS & CLIENTS</a></li>
            <li><a href="becomepartner.php">BECOME A PARTNER</a></li>
            <li><a href="contact.php">CONTACT US</a></li> -->
          </ul>
        </div>
      </div>
    </div>


    <!-- NAVBAR ================================================== -->
    <nav id="nav" class="navbar" align="center"  >
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">VERNEY</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">EVENTS & CLIENTS</a></li>
            <li><a href="edit.php">EDIT</a></li>
            <li><a href="list.php">LIST</a></li>
            <!-- <li><a href="services.php">SERVICES</a></li> -->
            <!-- <li><a href="events&clients.php">EVENTS & CLIENTS</a></li>
            <li><a href="becomepartner.php">BECOME A PARTNER</a></li>
            <li><a href="contact.php">CONTACT US</a></li> -->
          </ul>
        </div>
      </div>
    </nav>















