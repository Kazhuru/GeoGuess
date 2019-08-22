<?php
    //Conectar a la BD
    session_start();
	include("funciones.php");
	$conn=conectarBD();
    $msg="";

    //verificar la Existencia de idU
    if(!isset($_GET['idU']) || $_GET['idU'] == ""){
        header("location:" . $ruta ."Mainpage.php");

    }else if(isset($_GET['txtNombre']) && isset($_GET['txtAlias']) && isset($_GET['txtRol'])){
        if($_GET['txtNombre'] != "" && $_GET['txtAlias'] != "" && $_GET['txtRol'] != ""){
            //Se debe actualizar los datos del usuario
            $qry = "update usuarios set Nombre='".$_GET['txtNombre']."', Alias='".$_GET['txtAlias']."', Rol='".$_GET['txtRol']."' where idUsuario=".$_GET['idU'];
            mysql_query($qry,$conn) or die ("No se pudo actualizar los datos del usuario. ".mysql_error());
            header("location:" . $ruta ."Mainpage.php");
            
        }else{
            $msg = "No es posible actualizar los datos. Revisa que hayas proporcionado todos";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modify</title>
    <link rel="stylesheet" href="StylesSigninpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
</head>

<?php
    
    // Lectura de informacion de la BD PD:nose que haga pero ahi dejalo jijijiji xdxd
    $qry = "select Nombre, Alias, Rol from usuarios where idUsuario=".$_GET['idU'];
    $rs = mysql_query($qry,$conn);  
    $datos = mysql_fetch_array($rs);
    
?>

<body>
    <div id="headder">

        <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
        <?php
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
        ?>
    </div>
    <div id="container">
        <div id="containerLayout">
            <h2 id="textHeader">Modify Profile</h2>
            <div id="FormBox">
                <form action="modify.php" method="get">
                    <p>Nombre: <input class="FormBoxInput" type="text" name="txtNombre" value="<?php echo $datos["Nombre"];?>" /></p>
                    <p>Alias: <input class="FormBoxInput" type="text" name="txtAlias" value="<?php echo $datos["Alias"];?> "/> </p>
                    <p>Rol: <select name="txtRol" class="FormBoxInput">
                         <?php
                             if($datos["Rol"]=="General"){
                         ?>
                            <option value="General" selected="selected">General</option>
                            <option value="Administrador">Administrador</option>
                         <?php
                         }
                         else
                         {
                         ?>
                             <option value="General" >General</option>
                             <option value="Administrador" selected="selected">Administrador</option>
                         <?php
                         }
                         ?>   
                    </select></p>
                    <input type="hidden" value="<?php echo $_GET['idU'] ?>" name="idU"/>
                    <input id="Aceptbut" type="submit" value="Actualizar"/>
                    <input id="Cancelbut" type="reset" value="Cancelar"/>       
                     
                 </form>
            </div>
        </div>
        <img style="position: absolute;left: 0;bottom: -130px;max-width:65%;max-height:65%; z-index: 2" src="Mountain Clipart 1894.png"
            alt="fondo">
        <img style="position: absolute;right: 0;bottom: -100px;max-width:55%;max-height:55%; z-index: 1" src="Mountain Clipart 1894.png"
            alt="fondo">
    </div>
</body>

</html>