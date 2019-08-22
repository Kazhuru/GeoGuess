<?php
    session_start();  
    include("funciones.php");
    conectarBD();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
  <link rel="stylesheet" href="StylesMainpage.css">
  <title>Main Page</title>

</head>

<body>
  <div id="headder">
    <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
    <?php
    if(isset ($_SESSION['idU'])) 
    {
      $qry="select Alias, Rol from usuarios where IdUsuario=" . $_SESSION['idU'];
      $rs=mysql_query($qry) or die ("No fue posible recuperar el Alias autenticado");
      $usuario = mysql_fetch_object($rs);
      if($usuario->Rol=="General") {
        echo "<p> Welcome back! User: " . $usuario->Alias . " </p>";
        echo '<a class="hdrOpt" id="login" href="logout.php">log out</a>';
        echo '<a class="hdrOpt" id="signup" href="modify.php?idU='.$_SESSION['idU'].'">modify profile</a>';
      }
      else{
        echo "<p> Welcome back! Admin: " . $usuario->Alias . " </p>";
        echo '<a class="hdrOpt" id="login" href="logout.php">log out</a>';
        echo '<a class="hdrOpt" id="signup" href="modifyall.php">modify all profiles</a>';
      }
    }
    else{
      echo "<p> Hey there new user! </p>";
      echo '<a class="hdrOpt" id="login" href="login.php">log in</a>';
      echo '<a class="hdrOpt" id="signup" href="signin.php">sign up</a>';      
    }
    ?>
  </div>

  <div id="MainSection">
    <div id="Image">
      <img src="fondo1.jpg" alt="fondomain">
    </div>
    <div id="MainSectionOverlay">
      <h1 id="textTitle">Let's Explore the World!</h1>
      <hr>
      <p style="position:relative">Embark on a journey that takes you all over the world. From the most desolate</p>
      <p style="position:relative;top:-10px;">roads in Australia to the busy, bustling streets of New York City.</p>
      <hr>
      <div id="contMargin">
        <?php
          if(isset ($_SESSION['idU'])) 
          {
            echo '<a id="butPlay" href="mapApp.php">Play Now!</a>';
          }
          else
          {
            echo '<a id="butPlay" href="login.php">Play Now!</a>';
          }
        ?>
        
      </div>
      <div id="contMargin" style="width: 191px;margin-top: 10px;">
      <?php
          if(isset ($_SESSION['idU'])) 
          {
            echo '<a id="butLaders" href="BestScores.php">Best Scores!</a>';
          }
          else
          {
            echo '<a id="butLaders" href="login.php">Best Scores!</a>';
          }
        ?>
      </div>
    </div>
  </div>

  <div id="Contactus">
    <div id="ContactusOverlay">
        <h3>Contact us</h3>
        <hr>
        <p>
          <a href="#">Do you have any feedback?</a> 
          Want to do business with us? Send us a mail at
          <a href="#">carlosr_gn@hotmail.com</a>.
        </p>
        <p>
          Please read and accept our
          <a href="#">Terms of Service and Privacy Policy</a>.
        </p>
        <p>
            <i style="cursor:pointer;" class="fa fa-twitter" aria-hidden="true"></i>
            <i style="cursor:pointer;" class="fa fa-facebook" aria-hidden="true"></i>
            <i style="cursor:pointer;" class="fa fa-instagram" aria-hidden="true"></i>
            <i style="cursor:pointer;" class="fa fa-comment" aria-hidden="true"></i>
        </p>
          
    </div>
  </div>
</body>

</html>