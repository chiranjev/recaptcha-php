<?php
    if(isset($_POST['submit']) && !empty($_POST['submit'])) {
        if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
            //your site secret key
            // testsite.com test
            $secret = 'secret key';
            //get verify response data
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
            echo $verifyResponse;
            $responseData = json_decode($verifyResponse);
            if ($responseData->success) {
                //contact form submission code
                $name = !empty($_POST['name']) ? $_POST['name'] : '';
                $email = !empty($_POST['email']) ? $_POST['email'] : '';
                $message = !empty($_POST['message']) ? $_POST['message'] : '';

                $to = 'test@mail.com';
                $subject = 'New contact form have been submitted';
                $htmlContent = "
                    <h1>Contact request details</h1>
                    <p><b>Name: </b>" . $name . "</p>
                    <p><b>Email: </b>" . $email . "</p>
                    <p><b>Message: </b>" . $message . "</p>
                ";
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers
                $headers .= 'From:' . $name . ' <' . $email . '>' . "\r\n";
                //send email
                @mail($to, $subject, $htmlContent, $headers);

                $succMsg = 'Your contact request have submitted successfully.';
            } else {
                $errMsg = 'Robot verification failed, please try again.';
            }
        }
        else{
            $errMsg = 'Please click on the reCAPTCHA box.';
        }
    }
    else{
        $errMsg = 'abc';
        $succMsg = 'def';
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Recaptcha implementation</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
    <?php echo $errMsg." abc " . $succMsg; ?>
    <form action="" method="POST">
      Name <input type="text" name="name" value="" />
      Email <input type="text" name="email" value="" />
      Message <textarea type="text" name="message"></textarea>
      <div class="g-recaptcha" data-sitekey="data-sitekey"></div>
      <input type="submit" name="submit" value="SUBMIT">
    </form>

  </body>
</html>
