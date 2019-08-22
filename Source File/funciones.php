<?php
$ruta = "http://localhost/CRUD/";
    function conectarBD(){
        $conn = @mysql_connect("localhost","root", "")
            or die("No fue posible conectar con el servidor de MySQL.");
        mysql_select_db("tecweb2017",$conn)
            or die("No fue posible abrir la BD."); 
        
        return $conn;
    }
?>