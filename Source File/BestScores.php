<?php
    //Conectar a la BD y al usuario
    session_start(); 
	include("funciones.php");
    $conn=conectarBD();
    if(isset ($_SESSION['idU'])) 
    {
        $qry="select Alias, Rol from usuarios where IdUsuario=" . $_SESSION['idU'];
        $rs=mysql_query($qry) or die ("No fue posible recuperar el Alias autenticado");
        $usuario = mysql_fetch_object($rs);
    }

    //Recuperar los 3 mejores
    $first = array( "id" => 0,
                    "score" => 0,
                    "alias" => "");
    $second = array( "id" => 0,
                    "score" => 0,
                    "alias" => "");
    $third = array( "id" => 0,
                    "score" => 0,
                    "alias" => "");

    //Estructurar la consulta para recuperar los top 3 de la BD
    $qry = "select idUsuario, Score, Alias from usuarios";
    $rs = mysql_query($qry, $conn)
        or die ("No fue posible recuperar la informacion de los usuarios.". mysql_error());
    while($datos = mysql_fetch_object($rs))
    {
        if($datos->Score > $first['score']) 
        {
            if($first['score']>0)
            {   //se recorre el 1ro a el 2do y el 2do al 3ro
                $third['id'] = $second['id'];
                $third['alias'] = $second['alias'];
                $third['score'] = $second['score'];
                $second['id'] = $first['id'];
                $second['alias'] = $first['alias'];
                $second['score'] = $first['score'];
            }   //se guardan los datos del nuevo 1ro
            $first['id'] = $datos->idUsuario;
            $first['alias'] = $datos->Alias;
            $first['score'] = $datos->Score;
        }
        else
        {
            if($datos->Score > $second['score'])
            {
                if($second['score']>0)
                {   //se recorre el 2do al 3ro
                    $third['id'] = $second['id'];
                    $third['alias'] = $second['alias'];
                    $third['score'] = $second['score'];
                }   //se guardan los nuevos datos del 2do
                $second['id'] = $datos->idUsuario;
                $second['alias'] = $datos->Alias;
                $second['score'] = $datos->Score;
            }
            else
            {
                if($datos->Score > $third['score'])
                {   //se guardan los nuevos datos del 3ro
                    $third['id'] = $datos->idUsuario;
                    $third['alias'] = $datos->Alias;
                    $third['score'] = $datos->Score;                   
                }
            }
        }        
    }


    //Validacion de los campos

    if(isset($_REQUEST['TextFirst']) && $_REQUEST['TextFirst'] != "")
    {   //Dar de alta el registro si paso las validaciones
        $qry= "insert into comentarios (idRecibidor, Texto, Enviador) values('".$first['id']."', '".$_REQUEST['TextFirst']."', '".$usuario->Alias."')";
        mysql_query($qry) or die ("No se pudo registra el comentario.");
        header("location:" . $ruta ."BestScores.php");    
    }
    else
    {
        if(isset($_REQUEST['TextSecond']) && $_REQUEST['TextSecond'] != "")
        {   //Dar de alta el registro si paso las validaciones
            $qry= "insert into comentarios (idRecibidor, Texto, Enviador) values('".$second['id']."', '".$_REQUEST['TextSecond']."', '".$usuario->Alias."')";
            mysql_query($qry) or die ("No se pudo registra el comentario.");
            header("location:" . $ruta ."BestScores.php");    
        }
        else
        {
            if(isset($_REQUEST['TextThird']) && $_REQUEST['TextThird'] != "")
            {   //Dar de alta el registro si paso las validaciones
                $qry= "insert into comentarios (idRecibidor, Texto, Enviador) values('".$third['id']."', '".$_REQUEST['TextThird']."', '".$usuario->Alias."')";
                mysql_query($qry) or die ("No se pudo registra el comentario.");
                header("location:" . $ruta ."BestScores.php");    
            }
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestScr</title>
    <link rel="stylesheet" href="StylesSigninpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
    <style>
            #containerAll{
            width: 100%;
            height: auto;
            /*overflow: hidden;*/
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
            top: 0px;
            }
            </style>
        </head>
        <body>
        <form action="BestScores.php" method="get">
            <div id="headder">
            <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
            <?php
                
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
                
            ?>
            </div> 
            <div id="containerAll">
                <div id="containerLayoutAll">
                    <h2 id="textHeader">Best Scores!</h2>
                    <div id="FormBox">
                        <?php
                        //el 1ro
                        if($first['score'] > 0 )
                        {
                            echo "<p> TOP 1 </p>";
                            echo "<p>~ <b>".$first['alias']."</b> ~</p>";
                            echo "<p> Best Score: <b>".$first['score']."</b></p>"; 
                            echo "<hr/>";
                            echo "<p> <b>Comment Section</b> </p>";
                            //TODO
                            $qry = "select Texto, Enviador from comentarios where idRecibidor = ".$first['id']."";
                            $rs = mysql_query($qry, $conn)
                                or die ("No fue posible recuperar la informacion de los usuarios.". mysql_error());
                            while($coment = mysql_fetch_object($rs))
                            {
                                echo "<p style='font-size:22px;'>from: <b>".$coment->Enviador."</b></p>";
                                echo "<p style='font-size:18px;'> ".$coment->Texto." </p>"; 
                                echo "<p>- - - - - - - </p>";
                            }

                            echo "<hr/>";
                            echo '<textarea name = "TextFirst" rows = "3"cols = "45"></textarea>';
                            echo '<input id="Aceptbut" type="submit" value="make a comment!">';
                            echo "<br/>";
                            //el 2do
                            if($second['score'] > 0 )
                            {
                                echo "<p> TOP 2 </p>";
                                echo "<p>~ <b>".$second['alias']."</b> ~</p>";
                                echo "<p> Best Score: <b>".$second['score']."</b></p>"; 
                                echo "<hr/>";
                                echo "<p> <b>Comment Section</b> </p>";
                                //TODO
                                $qry = "select Texto, Enviador from comentarios where idRecibidor = ".$second['id']."";
                                $rs = mysql_query($qry, $conn)
                                    or die ("No fue posible recuperar la informacion de los usuarios.". mysql_error());
                                while($coment = mysql_fetch_object($rs))
                                {
                                    echo "<p style='font-size:22px;'>from: <b>".$coment->Enviador."</b></p>";
                                    echo "<p style='font-size:18px;'> ".$coment->Texto." </p> ";
                                    echo "<p>- - - - - - - </p>";
                                }

                                echo "<hr/>";
                                echo '<textarea name = "TextSecond" rows = "3"cols = "45"></textarea>';
                                echo '<input id="Aceptbut" type="submit" value="make a comment!">';
                                echo "<br/>";
                                //el 3ro
                                if($third['score'] > 0 )
                                {
                                    echo "<p> TOP 3 </p>";
                                    echo "<p>~ <b>".$third['alias']."</b> ~</p>";
                                    echo "<p> Best Score: <b>".$third['score']."</b></p>"; 
                                    echo "<hr/>";
                                    echo "<p> <b>Comment Section</b> </p>";
                                    //TODO
                                    $qry = "select Texto, Enviador from comentarios where idRecibidor = ".$third['id']."";
                                    $rs = mysql_query($qry, $conn)
                                        or die ("No fue posible recuperar la informacion de los usuarios.". mysql_error());
                                    while($coment = mysql_fetch_object($rs))
                                    {
                                        echo "<p style='font-size:22px;'>from: <b>".$coment->Enviador."</b></p>";
                                        echo "<p style='font-size:18px;'> ".$coment->Texto." </p>"; 
                                        echo "<p>- - - - - - - </p>";
                                    }

                                    echo "<hr/>";
                                    echo '<textarea name = "TextThird" rows = "3"cols = "45"></textarea>';
                                    echo '<input id="Aceptbut" type="submit" value="make a comment!">';
                                    echo "<br/>";
                                }
                            }
                        }        
                        ?>
                    </div>
                </div>
            </div>
        </form>
        </body>
</html>