<?php
  //Conectar a la BD
  session_start();
	include("funciones.php");
	$conn=conectarBD();
  $msg="";

  /******************/
  $qry = "select Score from usuarios where idUsuario=".$_SESSION['idU'];
  $rs = mysql_query($qry,$conn);  
  $datos = mysql_fetch_array($rs);
  /******************/

  if(isset($_GET['txtResult'])){
    if($_GET['txtResult'] != ""){
        //Se debe actualizar los datos del usuario
        if($_GET['txtResult'] > $datos["Score"]) {
          $qry = "update usuarios set Score='".$_GET['txtResult']."' where idUsuario=".$_SESSION['idU'];
          mysql_query($qry,$conn) or die ("No se pudo actualizar los datos del usuario. ".mysql_error());
          echo '<script> alert("Bravo!! you got a new Best Score"); </script>';
        }
        else{
          echo '<script> alert("The next time you will beat your Best Score!"); </script>';
        }
        header("location:" . $ruta ."Mainpage.php");
        
    }else{
        $msg = "No es posible actualizar los datos. Revisa que hayas proporcionado todos";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>MapApp</title>
  <link rel="stylesheet" href="StylesSigninpage.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
  <style>
    #map {
      margin: 0 auto;
      width: 25%;
      height: 400px;
      background-color: grey;
      float: left;
      position: relative;
      top: -400px;
      z-index: 2;
    }

    #mapSV {
      margin: 0 auto;
      width: 100%;
      height: 800px;
      background-color: grey;
      z-index: 1;
      
    }

    html,
    body {
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      font-weight: bold;
    }

    #coords {
      font-family: sans-serif;
      text-transform: uppercase;
      font-weight: bold;
      background-color: rgba(12, 12, 12, 0.5);
      border-radius: 35px;
      color: white;
      padding: 5px;
    }

    #coordsSV {
      font-family: sans-serif;
      text-transform: uppercase;
      font-weight: bold;
      background-color: rgba(12, 12, 12, 0.5);
      border-radius: 35px;
      color: white;
      padding: 5px;
    }
    #filler{
      width: 100%;
      height:400px;
      background: linear-gradient(to right,rgb(10, 10, 10), rgb(22, 33, 54));
    }
  </style>

  <script>
    function gameover()
    {
      document.getElementById("resId").value = score;
      return true;
    }
  </script>
</head>

<body>
<form action="mapApp.php" method="get"  onsubmit="return gameover()">
  <div id="headder" style="z-index: 4;">

    <a id="logo-main" href="Mainpage.php">ge<i class="fa fa-map-marker"></i>guess </a>
    <?php
            $qry="select Alias, Rol from usuarios where IdUsuario=" . $_SESSION['idU'];
            $rs=mysql_query($qry) or die ("No fue posible recuperar el Alias autenticado");
            $usuario = mysql_fetch_object($rs);
            if($usuario->Rol=="General") {
              echo "<p> Good Luck!  User: " . $usuario->Alias . " </p>";
              echo '<a class="hdrOpt" id="login" href="logout.php">log out</a>';
            }
            else{
              echo "<p> Good Luck!  Admin: " . $usuario->Alias . " </p>";
              echo '<a class="hdrOpt" id="login" href="logout.php">log out</a>';
            }

            
        ?>
        <p>Score :  <span id="points"></p>
        <p>Level :  <span id="lvl"></p>
        <input id="Aceptbut" style="margin:20px;font-size:10px;position:relative;top:-6px; visibility:hidden" 
                  type="submit" value="Submit Score"/>

  </div>
  <div id="mapSV"></div>
  <div id="coordsSV"></div>
  <div id="map"></div>
  <div id="coords"></div>
  <input type="hidden" value="" name="txtResult" id="resId" />
  <div id="filler" ></div>

  <script>
    var myLatlng;
    var map;
    var panorama;
    var marker;
    var markerYourPos;
    var markerOriginalPos;
    var line; 
    var controlUI;
    var RandomInt;
    var ListPos;
    var ListofUsed = [];
    var score;

    function initMap() {  
      score=0;
      GetRngValue();
      GenPositions();
      document.getElementById("points").innerHTML = score;
      document.getElementById("lvl").innerHTML =  ListofUsed.length+"/5";
      
      myLatlng = new google.maps.LatLng(ListPos[RandomInt].lat, ListPos[RandomInt].in);
      var sv = new google.maps.StreetViewService();
      //Set the Map 1 Options before creating one
      var mapOptions = {
        zoom: 1,
        center: myLatlng,
        mapTypeId: 'roadmap',
        disableDefaultUI: true,
        zoomControl: true,
        zoomControlOptions: {
          position: google.maps.ControlPosition.LEFT_BOTTOM,
        },
      };

      //Create a new map
      map = new google.maps.Map(document.getElementById('map'), mapOptions);

      //Create a new Panoram
      panorama = new google.maps.StreetViewPanorama(
        document.getElementById('mapSV'), {
          //position: myLatlng,
          visible: true,
          disableDefaultUI: true,
        });

      // Set the initial Street View camera to the center of the map
      sv.getPanorama({ location: myLatlng, radius: 500 }, processSVData);

      //Create a new Marker an Line
      marker = new google.maps.Marker({map: map,title: 'm'});
      markerYourPos = new google.maps.Marker({map: map,title: 'myp'});
      markerOriginalPos = new google.maps.Marker({map: map,title: 'mop'});
      marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
      markerYourPos.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
      markerOriginalPos.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');

      line = new google.maps.Polyline({
        strokeColor: "#000000",
        strokeOpacity: 0.8,
        strokeWeight: 2,
      });
      line.setMap(map);


      //Listener clicking the map
      var coordsDiv = document.getElementById('coords');
      map.controls[google.maps.ControlPosition.TOP_CENTER].push(coordsDiv);
      map.addListener('click', function (event) {
        myLatlng = event.latLng;
        marker.setPosition(myLatlng);
        marker.setAnimation(google.maps.Animation.DROP);
        coordsDiv.textContent =
          'lat: ' + Math.round(marker.getPosition().lat()) + ', ' +
          'lng: ' + Math.round(marker.getPosition().lng());
      });

      //Crate a custom control and show it
      var guessControlDiv = document.createElement('div');
      var centerControl = new GuessControl(guessControlDiv, map);
      guessControlDiv.index = 1;
      map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(guessControlDiv);

      // Setup the click event listeners in a custom control
      controlUI.addEventListener('click', function () { 
        if(!(ListofUsed.length > 5) )
        {
          var res = google.maps.geometry.spherical.computeDistanceBetween (
          marker.getPosition(), 
          panorama.getPosition()
          );  
          //Modificando los markers y generando linea
          map.setZoom(1);
          markerYourPos.setPosition(marker.getPosition());
          markerYourPos.setAnimation(google.maps.Animation.DROP);
          markerOriginalPos.setPosition(panorama.getPosition());
          markerOriginalPos.setAnimation(google.maps.Animation.DROP);
          var path = line.getPath();
          if(path.length > 0 ) 
          {
            path.pop(); 
            path.pop();
          }
          path.push(markerYourPos.getPosition());
          path.push(markerOriginalPos.getPosition());

          var percent = 12000000 - res;
          if(percent<0)
            percent = 0;
          percent = percent/12000000;  
          percent = percent*100; 
          percent = Math.round(percent);
          score = score + percent;
          GetRngValue();
          alert("percentage of accuracy: " + percent + "% , Total score: " +score);
          document.getElementById("points").innerHTML = score;
          if(ListofUsed.length > 5)
          {
            document.getElementById("lvl").innerHTML =  "Game Over";
            document.getElementById("Aceptbut").style.visibility="visible";
          }
          else
          {
            document.getElementById("lvl").innerHTML =  ListofUsed.length+"/5";
            sv.getPanorama({ location: new google.maps.LatLng(ListPos[RandomInt].lat, ListPos[RandomInt].in)
                                    , radius: 50 }, processSVData);
          }
        }

      });
    }

  /**************************************************************/
    function GetRngValue()
    {
      finded = false;
      while(!finded)
      {
        RandomInt = Math.floor(Math.random() * (17 - 0 + 1)) + 0;
        if((ListofUsed.indexOf(RandomInt) > -1) == false)
        {
          ListofUsed.push(RandomInt);
          finded = true;
        }
      }
    }
    /**************************************************************/
    function GuessControl(controlDiv, map) {
      // Set CSS for the control border.
      controlUI = document.createElement('div');
      controlUI.style.backgroundColor = '#fff';
      controlUI.style.border = '2px solid #fff';
      controlUI.style.borderRadius = '3px';
      controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)';
      controlUI.style.cursor = 'pointer';
      controlUI.style.marginBottom = '22px';
      controlUI.style.marginLeft = '5px';
      controlUI.style.textAlign = 'center';
      controlUI.title = 'Click to guess';
      controlDiv.appendChild(controlUI);
      // Set CSS for the control interior.
      var controlText = document.createElement('div');
      controlText.style.color = 'rgb(25,25,25)';
      controlText.style.fontFamily = 'Roboto,Arial,sans-serif';
      controlText.style.fontSize = '16px';
      controlText.style.lineHeight = '38px';
      controlText.style.paddingLeft = '5px';
      controlText.style.paddingRight = '5px';
      controlText.innerHTML = 'Make a guess!';
      controlUI.appendChild(controlText);
    }

    /**************************************************************/
    function processSVData(data, status) {
      if (status === 'OK') {
        myLatlng = data.location.latLng;
        //marker.setPosition(myLatlng);
        //marker.setAnimation(google.maps.Animation.DROP);
        panorama.setPano(data.location.pano);
        panorama.setPov({
          heading: 270,
          pitch: 0
        });
        panorama.setVisible(true);

        marker.addListener('click', function () {
          var markerPanoID = data.location.pano;
          // Set the Pano to use the passed panoID.
          panorama.setPano(markerPanoID);
          panorama.setPov({
            heading: 270,
            pitch: 0
          });
          panorama.setVisible(true);
        });
      } else {
        console.error('Street View data not found for this location.');
      }
    }

    /**************************************************************/
    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2, unit) {
      var radlat1 = Math.PI * lat1/180
      var radlat2 = Math.PI * lat2/180
      var theta = lon1-lon2
      var radtheta = Math.PI * theta/180
      var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
      dist = Math.acos(dist)
      dist = dist * 180/Math.PI
      dist = dist * 60 * 1.1515
      if (unit=="K") { dist = dist * 1.609344 }
      if (unit=="N") { dist = dist * 0.8684 }
      return dist
    }

    /**************************************************************/
    function GenPositions() {
      ListPos = 
      [
        { lat:37.25165416626439, in:-121.89370364087301},
        { lat:42.345573, in:-71.098326},
        { lat:65.87727289816574, in:-149.7202032863271},
        { lat:-17.81257893169227, in:-63.20775159878349 },
        { lat:-37.80930928394946, in:144.95255814813152},
        { lat:6.923072136719838, in:79.85248124419638},
        { lat:34.92698343460437, in:136.62504121482993},
        { lat:26.3334226088020, in:127.93638713399343},
        { lat:47.91917769683369, in:106.91756749979697},
        { lat:62.10256299330446, in:-7.143516661309604},       
        { lat:38.11344989924454, in:13.355951464303644}, 
        { lat:46.75627469819567, in:7.629952521820087},
        { lat:59.31213888670724, in:18.08766750196378},   
        { lat:-33.93815880631364, in:18.46875834987395},
        { lat:38.00105339136656, in:23.776463011152373},
        { lat:-4.879876387123086, in:119.89524597689808},
        { lat:-54.51336838230669, in:-67.19095232530645}, 
        { lat:65.64548892680418, in:-22.547502487805446},
      ];
    }

  </script>

  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCt6rEi1SWAr74vk52G2lycASs0dGRHt60&callback=initMap">
  </script>
</form>
</body>

</html>