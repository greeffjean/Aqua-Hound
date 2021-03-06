<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['form'])){
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  define('MAILGUN_USERNAME', 'postmaster@sandbox9fa8fa834df5484396dbbdf0b68767fd.mailgun.org');
  define('MAILGUN_PASSWORD', 'd89106ebffb4cdb2237b4c066afc0afd-e566273b-ee9e950c');
  define('FROM_EMAIL','brian@aquahound.co.za');
  define('FROM_NAME','Aqua Hound');
  //While testing, you set this to your email address, otherwize he is gonna get a bunch of emails
  //define('TO_EMAIL','uhururay@gmail.com');
  //define('TO_NAME','Uhuru');
  define('TO_EMAIL','greeffjean@gmail.com');
  define('TO_NAME','Brian');

  $mail = new PHPMailer(true);

  $status = false;

  try {
      //Server settings
      $mail->SMTPDebug = 0;                                       // Enable verbose debug output
      $mail->isSMTP();                                            // Set mailer to use SMTP
      $mail->Host       = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = MAILGUN_USERNAME;                     // SMTP username
      $mail->Password   = MAILGUN_PASSWORD;                               // SMTP password
      $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom(FROM_EMAIL, FROM_NAME);
      $mail->addReplyTo(FROM_EMAIL, FROM_NAME);
      $mail->addAddress(TO_EMAIL, TO_NAME);     // Add a recipient

      $email_html = file_get_contents('email.html');
      if(strlen($_POST['need']) > 0){
          $email_subject = 'Aqua Hound - New Enquiry - ' . $_POST['need'];
      }
      else{
          $email_subject = 'Aqua Hound - New Enquiry';
      }
      $email_html = str_replace('[EMAIL-PREHEADER]',$email_subject,$email_html);
      $email_html = str_replace('[EMAIL-SUBJECT]',$email_subject,$email_html);
      $email_contents .= '<h2>New reply on your enquiry form</h2>';
      $email_contents .= '<p>Email: '.$_POST['email'].'<br />Name: '.$_POST['name'].' '.$_POST['surname'].'<br/>Requirement: '.$_POST['need'].'<br/>Message: '.$_POST['message'].'</p>';
      $email_html = str_replace('[EMAIL-CONTENTS]',$email_contents,$email_html);

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Body    = $email_html;
      $mail->AltBody = $email_html;
      $mail->Subject = $email_subject;
      $mail->send();
      $status = true;
  } catch (Exception $e) {
      print_r($e);
  }

  $response = new stdClass();
  if($status == true){
      $response->type =  'success';
      $response->message = 'Contact form successfully submitted. Thank you, I will get back to you soon!';
  }
  else{
      $response->type =  'danger';
      $response->message = 'There was an error while submitting the form. Please try again later';
  }
  header('Content-Type: application/json');
  echo json_encode($response);
  exit(0);
}
?>
<html>

<head>
  <title>Contact Us</title>
  <meta charset="UTF-8">
  <link rel="icon" href="resources/mstile-310x150.png" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">
  <link href='./css/style.css' rel='stylesheet' type='text/css'>
</head>

<body>

    <!-- Nav -->

    <div id="header">
      <nav class="nav" id="#navbar-mobile">

<div class="">
  <a  href="./index.html"> <img class="desktop-img" src="./resources/logo.png" alt=""></a>
  <a href="./index.html"><img class="mobile-img" src="./resources/logo-white.png" alt=""></a>
</div>

        <div id="mobile-top-menu" class="ul-fix-nav">

          <a id="mobile-link" data-toggle="modal" data-target="#exampleModalCenter" href="#">Join Us</a>
          <a id="mobile-link" target="_blank" href="./index.html">Home</a>
        </div>

        <!-- Nav Mobile -->

        <div class="menu-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>

      </nav>

      <div id="drop-down">
        <ul>
          <li data-toggle="modal" data-target="#exampleModalCenter"> <a href="#">Join Us</a> </li>
          <li> <a target="_blank" href="./index.html">Home</a> </li>
        </ul>
      </div>
    </div>


    <div id="body">

      <!-- Modal -->

      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalCenterTitle">Join Us</h5>


            </div>
            <div class="modal-body">
              <strong>DISTRIBUTORS, INSTALLERS</strong> <br> <br>
              Are you interested in becoming a distributor or installer then please contact <a class="email"
                href="mailto:brian@aquahound.co.za">brian@aquahound.co.za</a>
              <br> <br>
              Partnerships are important to us. Therefore we are careful when choosing distributors and installers. We
              supply Aquahound via a network of customer focused distributors and installers, who will deliver and
              professionally install the Aquahound system.
              <br> <br>
              If you need to discuss any aspects please contact <a class="email"
                href="mailto:brian@aquahound.co.za">brian@aquahound.co.za</a> and get your property protected by
              Aquahound.
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->


      <div id="contact" class="container">

        <div class="row">

          <div class="col-xl-8 offset-xl-2 py-5">

            <h1>Send us a message</h1>


            <form id="contact-form" method="post" role="form">

              <input type="hidden" name="form" value="contact-form" />

              <div class="messages"></div>

              <div class="controls">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="form_name">Firstname *</label>
                      <input id="form_name" type="text" name="name" class="form-control"
                        placeholder="Please enter your firstname *" required="required"
                        data-error="Firstname is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="form_lastname">Lastname *</label>
                      <input id="form_lastname" type="text" name="surname" class="form-control"
                        placeholder="Please enter your lastname *" required="required"
                        data-error="Lastname is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="form_email">Email *</label>
                      <input id="form_email" type="email" name="email" class="form-control"
                        placeholder="Please enter your email *" required="required"
                        data-error="Valid email is required.">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="form_need">Please specify your need *</label>
                      <select id="form_need" name="need" class="form-control" required="required"
                        data-error="Please specify your need.">
                        <option value=""></option>
                        <option value="Request quotation">Request quotation</option>
                        <option value="Request order status">Request order status</option>
                        <option value="Request copy of an invoice">Request copy of an invoice</option>
                        <option value="Other">Other</option>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="form_message">Message *</label>
                      <textarea id="form_message" name="message" class="form-control" placeholder="Message for me *"
                        rows="4" required="required" data-error="Please, leave us a message."></textarea>
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <input type="submit" class="btn btn-success btn-send" value="Send message">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">


                  </div>
                </div>
              </div>

            </form>

          </div>

        </div>
      </div>






  <!-- Scripts -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"
    integrity="sha256-dHf/YjH1A4tewEsKUSmNnV05DDbfGN3g7NMq86xgGh8=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/contact.js"></script>
  <script type="text/javascript">

    $(".menu-icon").on("click", function (event) {
      event.preventDefault();
      $("#drop-down").slideToggle();
    });


    $(window).scroll(function (e) {
      var scroll = $(window).scrollTop();
      var navbar = $('#navbar');
      if (scroll > 80) {
        if (!navbar.hasClass('opaque')) {
          navbar.addClass('opaque');
        }
      }
      else {
        if (navbar.hasClass('opaque')) {
          navbar.removeClass('opaque');
        }
      }
    });

    $(document).ready(function () {
      $('.menu-icon').click(function () {
        $('.menu-icon').toggleClass('active')
      })
    })

  </script>


</body>

</html>
