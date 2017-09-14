<link href="style.css" rel="stylesheet" type="text/css" />
<link href="icons.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="customalert.js"></script>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="shortcut icon" href="images/favicon.png" />
<title>Actualizador</title>
<div id="dialogoverlay"></div>
<div id="dialogbox">
  <div>
     <div id="dialogboxhead"></div>
    <div id="dialogboxbody"></div>
    <div id="dialogboxfoot"></div>
    </div>
</div>

<?php
/*$asd = 1;
while(true || $asd==15)
{
    sleep(1800); // sleep for 30 min
    if (time("H") == 0) {
        echo "<script>console.log( 'hi' );</script>";
    }

}*/
include 'config.php';
/*if ($db) {
  echo "Se conecto a la base de datos";
} else {
  echo "No se conecto a la base de datos";
}*/

$sqlcheckifnew = "SELECT * FROM properties";
$resultcheckifnew = mysqli_query($db, $sqlcheckifnew);
if (mysqli_num_rows($resultcheckifnew) == 0) {
    $localIP = getHostByName(getHostName());
    //echo $localIP;
    $url = 'https://frank.fabregat.com.mx/cevideo/checkip.php?ip=' . $localIP;
    //echo $url;
    $json = file_get_contents('https://frank.fabregat.com.mx/cevideo/checkip.php?ip=' . $localIP);
    $obj = json_decode($json);
    $code = $obj->{'code'};
    if ($code == "ERROR") {
        echo "<br>ERROR: No existe hotel con IP '" . $localIP . "'";
    } else {
        //echo strtoupper($code);

        include 'config.php';
        $sqlupdate = "INSERT INTO `properties` (`code`, `version`) VALUES ('$code', '1')";
        if (mysqli_query($db, $sqlupdate)) {
            ?><meta http-equiv="refresh" content="0"><?php
        } else {
            echo "No se ha podido modificar la base de datos";
        }
    }
} else {
    //echo "not new";
    $row = mysqli_fetch_assoc($resultcheckifnew);
    //echo strtoupper($row['code']);


    function updateVideo($code9, $version9, $output)
    {
        $jsonu = file_get_contents('https://frank.fabregat.com.mx/cevideo/checkip.php?code='.$code9.'&version=' . $version9);
        $obju = json_decode($jsonu);
        $update = $obju->{'update'};
        $newversion = $obju->{'version'};
        if ($update == "yes" || !file_exists(video/video.mp4)) {
            /*$source = "https://frank.fabregat.com.mx/cevideo/videos/".$row['code']."/video.mp4";
$dest = "video/video.mp4";
if (copy($source, $dest)) {
    if ($output == true) {
echo "<script>Alert.render('Se ha actualizado el video.','');</script>";
    } else {
                echo "<script>console.log('Se ha actualizado el video.');</script>";
            }
    include 'config.php';
    $sqlversion = "UPDATE properties SET version='$newversion'";
    $resultversion = mysqli_query($db, $sqlversion);
} else {
    if ($output == true) {
    echo "<script>Alert.render('No se ha podido actualizar el video.','');</script>";
    } else {
                echo "<script>console.log('No se ha podido actualizar el video.');</script>";
            }
}*/
            $source = "https://frank.fabregat.com.mx/cevideo/videos/".$code9."/video.mp4";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $source);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            //curl_setopt($ch, CURLOPT_SSLVERSION,3);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $data = curl_exec($ch);
            $error = curl_error($ch);
            //var_dump(curl_getinfo($ch));
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $destination = "video/video.mp4";
            $file = fopen($destination, "wb");
            if (fwrite($file, $data)) {
                if ($output == true) {
                    echo "<script>Alert.render('Se ha actualizado el video.','');</script>";
                } else {
                    echo "<script>console.log('Se ha actualizado el video.');</script>";
                }
                include 'config.php';
                $sqlversion = "UPDATE properties SET version='$newversion'";
                $resultversion = mysqli_query($db, $sqlversion);
            } else {
                if ($output == true) {
                    echo "<script>Alert.render('No se ha podido actualizar el video.','');</script>";
                } else {
                    echo "<script>console.log('No se ha podido actualizar el video.');</script>";
                }
            }
            fclose($file);
        } else {
            if ($output == true) {
                echo "<script>Alert.render('El video esta actualizado.','');</script>";
            } else {
                echo "<script>console.log('El video esta actualizado.');</script>";
            }
            //echo "dsa";
        }
    }

    updateVideo($row['code'], $row['version'], false);
    if (isset($_POST['update'])) {
        updateVideo($row['code'], $row['version'], true);
        /*$jsonu = file_get_contents('https://frank.fabregat.com.mx/cevideo/checkip.php?code='.$row['code'].'&version=' . $row['version']);
    $obju = json_decode($jsonu);
    $update = $obju->{'update'};
        $newversion = $obju->{'version'};
    if ($update == "yes") {
        $source = "https://frank.fabregat.com.mx/cevideo/videos/".$row['code']."/video.mp4";
$dest = "video/video.mp4";
if (copy($source, $dest)) {
echo "<script>Alert.render('Se ha actualizado el video.','');</script>";
    include 'config.php';
    $sqlversion = "UPDATE properties SET version='$newversion'";
    $resultversion = mysqli_query($db, $sqlversion);
} else {
    echo "<script>Alert.render('No se ha podido actualizar el video.','');</script>";
}
     } else {
        echo "<script>Alert.render('El video esta actualizado.','');</script>";
        //echo "dsa";
    }*/
    }
    /*$localIP = getHostByName(getHostName());
    $url = 'https://frank.fabregat.com.mx/cevideo/checkip.php?ip=' . $localIP;
    echo $url;*/ ?>
<center><div class="heading"><a><?php echo strtoupper($row['code']); ?></a></div></center>
<center><a class="btn" href="index.php?showvideo=true">Ver Video</a></center>
<center><form action="" method="post"><input type="submit" value="Actualizar Video" name="update"></form></center>
<?php
if ($_GET['showvideo'] == "true") {
        ?>
<center>
<div id="dialogoverlay2"></div>
<div id="dialogbox2">
	<div class="closebtn"><a href="index.php"><span class="icon-remove"></span></a></div>
	<div>
		<div id='dialogboxbody2'><video loop controls autoplay><source src="video/video.mp4"></video></div>
		</div>
		</div>
</center>

<?php
    }
    date_default_timezone_set('America/Mexico_City'); ?>
<div class="timer"><center><div id="timer_div"></div><a>Actualizado el <?php echo date('j'); ?>/<?php echo date('n'); ?>/<?php echo date('Y'); ?> a las <?php echo date('g'); ?>:<?php echo date('i'); ?>:<?php echo date('s'); ?><?php echo date('a'); ?></a></center></div>
<script>
	//var seconds_left = 30;
	var seconds_left = 1800;
var interval = setInterval(function() {
    document.getElementById('timer_div').innerHTML ='Actualizando video en: ' + --seconds_left + ' segundos.';
//console.log(--seconds_left);
    if (seconds_left <= 0)
    {
        document.getElementById('timer_div').innerHTML = 'Actualizando video en: Actualizando...';
        clearInterval(interval);
		location.reload(true);
    }
}, 1500);
	</script>
	<?php
}
?>
