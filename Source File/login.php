<?php 
	session_start();
	include("funciones.php");
	conectarBD();
	$alta = true;
	$msg="";
	
	if(!isset($_REQUEST['txtAlias'])  ||  $_REQUEST['txtAlias']=="")
	{
		$alta=false;
		$msg="No se puede omitir el usuario";
	
	}
	if(!isset($_REQUEST['txtPwd'])  ||  $_REQUEST['txtPwd']=="")
	{
		$alta=false;
		$msg="No se puede omitir la contraseña";
	
	}
	
	//se hace la validacion de los datos y la bd
	
	if($alta)
	{
		
	$qry ="select IdUsuario, Alias, Pwd, Rol from usuarios 
	where Alias='".$_REQUEST['txtAlias']. "' and Pwd='".$_REQUEST['txtPwd']."'";
	
	$rs = mysql_query($qry)
		or die("No fue posible leer informacion de la BD". mysql_error());
		
		if(mysql_num_rows($rs)==0)//no se encontro el usuario
		{
			$msg="El usuario y contraseña no existe";
		}
		else //si se encontro el usuario
		{
			$msg="El usuario y contraseña si existe";

			$usuario = mysql_fetch_object($rs);
			$_SESSION['idU']= $usuario -> IdUsuario;
			$_SESSION['Rol']= $usuario -> Rol;
			header("location:" . $ruta ."Mainpage.php");
		}
	
	}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="StylesSigninpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>

    <script type="text/javascript">
        function validaFrm() {
            if (document.getElementById("txtAlias").value == "" ||
                document.getElementById("txtPwd").value == "") {
                alert("El usuario y contraseña no puede faltar");
                return false;
            }
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
            <h2 id="textHeader">Log In</h2>
            <div id="FormBox">
                <form method="get" action="login.php" onsubmit="return validaFrm();">
                    <p>Nickname:
                        <input class="FormBoxInput" type="text" name="txtAlias" id="txtAlias" />
                    </p>
                    <p>Password:
                        <input class="FormBoxInput" type="password" name="txtPwd" id="txtPwd" />
                    </p>
                    <input id="Aceptbut" type="submit" name="btnAutenticar" value="Autenticate" />
                    <input id="Cancelbut" type="reset" name="Cancel" />
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