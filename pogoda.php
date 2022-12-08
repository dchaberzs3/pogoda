<?php
$pelnaPogoda ="";

if(isset($_POST["submit"])){
    if( empty($_POST["szerokosc"]) && empty($_POST["dlugosc"])){
        echo "Podaj szerokość i długość geograficzną";
    } else {
        $szerokosc = $_POST["szerokosc"];
        $dlugosc = $_POST["dlugosc"];

        $dane = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=".$szerokosc."&lon=".$dlugosc."&appid=8180f2e5938c96ec63f51f004902d775");
        $pogoda = json_decode($dane, true);
        $tempCel = intval($pogoda["main"]["temp"] - 273);
        $tempCelOdcz = intval($pogoda["main"]["feels_like"] - 273);
        $cisnienie = $pogoda["main"]["pressure"];
        $wiatr = $pogoda["wind"]["speed"];
        $wiatrPorywy = $pogoda["wind"]["gust"];
        $wilgotnosc = $pogoda["main"]["humidity"];

        $pelnaPogoda = "W danej lokalizacji geograficznej znajduje się: " .$pogoda["name"] . "<br> Aktuane warunki pogodowe: <br>
        Temperatura : " . $tempCel . "&#8451; <br>" . "Temperatura odczuwalna : " . $tempCelOdcz . "&#8451; <br>
        Ciśnienie atmosferyczne : " .  $cisnienie ." hPa <br>  Wiatr : " . $wiatr . " km/h,  w porywach do : " . $wiatrPorywy . "km/h <br> 
        Wilgotność : " . $wilgotnosc . "%";
    }

}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pogoda dla świata</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1> Wpisz współrzędne geograficzne </h1>
    <form method="POST" action="pogoda.php">
    <div class="form-group">
        <label for="szerokosc">Podaj szerkość geograficzną</label>
        <input type="text" class="form-control" id="szerokosc" name="szerokosc"  placeholder="00.0000">
    </div>
    <div class="form-group">
        <label for="dlugosc">Podaj długość geograficzną</label>
        <input type="text" class="form-control" id="dlugosc" name="dlugosc" placeholder="00.0000">
    </div>
    <button type="submit" class="btn btn-primary" name="submit" >Submit</button>
    </form>
    </div>

    <div class="container">
    <?php if($pelnaPogoda) : ?> <div class="alert alert-success bg-success text-white"><?php echo $pelnaPogoda; ?></div> <?php endif; ?>
    </div>
</body>
</html>