<?php
session_start();  
include("funciones.php");
conectarBD();
$alta = true;
$msg ="";

//Validacion de los campos

if(!isset($_REQUEST['txtNombre']) || $_REQUEST['txtNombre'] == ""){
    $alta = false;
    //$msg = "No se puede omitir el nombre";
}
if(!isset($_REQUEST['txtAlias']) || $_REQUEST['txtAlias'] == ""){
    $alta = false;
    //$msg = "No se puede omitir el alias";
}
if(!isset($_REQUEST['txtPwd']) || $_REQUEST['txtPwd'] == ""){
    $alta = false;
    //$msg = "No se puede omitir la contraseña";
}
if(isset($_REQUEST['txtPwd']) && $_REQUEST['retxtPwd']){
    if($_REQUEST['txtPwd'] != $_REQUEST['retxtPwd']){
        $alta = false;
        //$msg = "Las contraseñas no coinciden";
    }
}

//Dar de alta el registro si paso las validaciones

if($alta){
    $qry= "insert into usuarios (Nombre, Alias, Pwd, Rol, Score)
        values('".$_REQUEST['txtNombre']."','".$_REQUEST['txtAlias']."','".$_REQUEST['txtPwd']."','General','0')";
    
    mysql_query($qry) or die ("No se pudo registra el usuario.");
    
    header("location:" . $ruta ."Mainpage.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
    <link rel="stylesheet" href="StylesSigninpage.css">
    <title>Sign In</title>

    <script type="text/javascript">
        function validaFrm() {
            if (document.getElementById("txtNombre").value == "") {
                alert("No se puede omitir el campo Nombre de la persona");
                return false;
            }
            if (document.getElementById("txtAlias").value == "") {
                alert("No se puede omitir el campo Alias de la persona");
                return false;
            }
            if (document.getElementById("txtPwd").value == "") {
                alert("No se puede omitir la Contraseña de la persona");
                return false;
            }
            if (document.getElementById("retxtPwd").value == "") {
                alert("No se puede omitir la verificacion de la Contraseña");
                return false;
            }
            if (document.getElementById("txtPwd").value != document.getElementById("retxtPwd").value) {
                alert("Las contraseñas no coinciden");
                return false;
            }
            return true;
        }
    </script>
</head>

<body>
    <div id="headder">
        <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
        <?php
        if(isset ($_SESSION['idU'])) 
            {
                $qry="select Alias from usuarios where IdUsuario=" . $_SESSION['idU'];
                $rs=mysql_query($qry) or die ("No fue posible recuperar el usuario autenticado");
                $usuario = mysql_fetch_object($rs);
                echo "<p> Welcome back! " . $usuario->Alias . " </p>";
            }
            else{
                echo "<p> Hey there new user! </p>";
            }
        ?>
        <a class="hdrOpt" id="login" href="login.php">log in</a>
        <a class="hdrOpt" id="signup" href="signin.php">sign up</a>
    </div>
    <div id="container">
        <div id="containerLayout">
            <h2 id="textHeader">Create an account</h2>
            <div id="FormBox">
                <form method="get" action="signin.php" onsubmit="return validaFrm()">
                    <p style="position:relative;left:-40px">Name:
                        <input class="FormBoxInput" type="text" name="txtNombre" id="txtNombre" />
                    </p>
                    <p style="position:relative;left:-15px"> Nickname:
                        <input class="FormBoxInput" type="text" name="txtAlias" id="txtAlias" />
                    </p>
                    <p style="position:relative;left:-15px">Password:
                        <input class="FormBoxInput" type="password" name="txtPwd" id="txtPwd" />
                    </p>
                    <p style="position:relative;left:25px">Password Again:
                        <input class="FormBoxInput" type="password" name="retxtPwd" id="retxtPwd" />
                    </p>



                    <input id="Aceptbut" type="submit" value="Acept" name="btnRegistrar" />
                    <input id="Cancelbut" type="reset" value="Cancel" />
                    <br/>
                </form>
            </div>
        </div>
        <img style="position: absolute;left: 0;bottom: -130px;max-width:65%;max-height:65%; z-index: 2" 
        src="Mountain Clipart 1894.png" alt="fondo">
        <img style="position: absolute;right: 0;bottom: -100px;max-width:55%;max-height:55%; z-index: 1" 
        src="Mountain Clipart 1894.png" alt="fondo">
    </div>


</body>

</html>