<?php
    //Conectar a la BD
    session_start();
	include("funciones.php");
	$conn=conectarBD();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ModifyAll</title>
    <link rel="stylesheet" href="StylesSigninpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>

    <style>
    #containerAll{
    width: 100%;
    height: auto;
    overflow: hidden;
    position: relative;
    top: 24px;
    background: linear-gradient(to right,rgb(224, 224, 224), rgb(22, 33, 54));
    }
    #containerLayoutAll{
    width: 30%;
    height: auto;
    text-align: center;
    margin: 0 auto;
    position: relative;
    top: 80px;
    }
    </style>
</head>
<body>
    <div id="headder">

        <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
        <?php
            $qry="select Alias, Rol from usuarios where IdUsuario=" . $_SESSION['idU'];
            $rs=mysql_query($qry) or die ("No fue posible recuperar el Alias autenticado");
            $usuario = mysql_fetch_object($rs);
            echo "<p> Welcome back! Admin: " . $usuario->Alias . " </p>";
            echo '<a class="hdrOpt" id="login" href="logout.php">log out</a>';
            echo '<a class="hdrOpt" id="signup" href="">modify all profiles</a>'; 
        ?>
    </div>

    <div id="containerAll">
        <div id="containerLayoutAll">
            <h2 id="textHeader">Modify All Users</h2>
            <div id="FormBox">
            <?php
                //Estructurar la consulta para recuperar la informacion d la BD
                $qry = "select idUsuario, Nombre, Alias, Rol from usuarios";
                $rs = mysql_query($qry, $conn)
                    or die ("No fue posible recuperar la informacion de los usuarios.". mysql_error());
                while($datos = mysql_fetch_object($rs))
                {
                    echo "<p>Id de Usuario: <b>".$datos->idUsuario."</b></p>";
                    echo "<p>Nombre: <b>".$datos->Nombre."</b></p>";
                    echo "<p>Alias: <b>".$datos->Alias."</b></p>";
                    echo "<p>Rol: <b>".$datos->Rol."</b></p>";   
                    echo "<a id='Aceptbut' href='modify.php?idU=".$datos->idUsuario."'>Modificar</a>";
                    echo "<hr/>";
                }
                mysql_close($conn);
            ?>
            </div>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <img style="position: absolute;left: 0;bottom: -130px;max-width:65%;max-height:65%; z-index: 2" src="Mountain Clipart 1894.png"
            alt="fondo">
        <img style="position: absolute;right: 0;bottom: -100px;max-width:55%;max-height:55%; z-index: 1" src="Mountain Clipart 1894.png"
            alt="fondo">
    </div>
</body>
</html>