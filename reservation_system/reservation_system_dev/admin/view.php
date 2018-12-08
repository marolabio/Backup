<?php
    session_start();

    // Remove white spaces
    $imageName = str_replace(' ', '', $_SESSION['bank']);
    $imageName .= '.jpg';
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/lightbox.min.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="../js/lightbox-plus-jquery.min.js"></script>
    <title>Deposit Slip</title>
</head>

<body>
<br>

<div class="container">
  <div class="row">
    <div class="col-md-auto">
    <div class="well">
        <center>
        <p><b>Bank Name: </b>
            <?php echo $_SESSION['bank']; ?>
        </p>
        <hr>
        <p><b>Message: </b>
            <?php echo $_SESSION['msg']; ?>
        </p>

        <a href='data:image;base64,<?php echo $_SESSION['slip'];?>' data-lightbox = 'DepositSlip'>
            <img style='border-radius: 8px;' width='500px' height="auto" src='data:image;base64,<?php echo $_SESSION['slip'];?>'>
        </a>
        <br>
        <br>
        <a href="data:image;base64,<?php echo $_SESSION['slip'];?>" download="<?php echo $imageName;?>"
            class="btn btn-info">Download</a>
            </center>
        </div>
    </div>
  </div>
</div>
   
</body>

</html>