<?php
  $weather = "";
  $error = "";

  if (array_key_exists("city", $_GET)) {
    $city = str_replace(' ', '', $_GET['city']);

    $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

    // if (strpos($_SERVER['REQUEST_URI'], "locations") !== false) {

    // if($file_headers[0] == 'HTTP/1.0 404 Not Found') {

    if($file_headers[0] == 'https://www.weather-forecast.com') {
      // $exists = false;
      $error = "City not found";

    } else {

      $forecast = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");

      $pageArray = explode('(1–3 days):</div><p class="location-summary__text"><span class="phrase">', $forecast);

      if (sizeof($pageArray) > 1) {
        $secondPageArray = explode('</span><!--', $pageArray[1]);

        if (sizeof($secondPageArray) > 1) {

          $weather = $secondPageArray[0];
        } else {
          $error = "City cannot be found";
        }

      } else {

        $error = "City cannot be found";
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>WeatherScraperDemo</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="weatherScraper.css">
  </head>

  <body>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4">What's the Weather</h1>
        <p class="lead">Enter the name of a city.</p>

        <form class="col-md-6">
          <div class="form-group">
            <input type="text" class="form-control" id="city" placeholder="E.g London, Tokyo" name="city"value="<?php
              if (array_key_exists("city", $_GET)) {
                echo $_GET['city'];
              }
            ?>">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <div class="col-md-6" id="weather">
          <?php
            if ($weather) {
              echo '<div class="alert alert-success" role="alert" id="alert" name="alert">'.$weather.'</div>';
            } else if ($error){
              echo '<div class="alert alert-danger" role="alert" id="alert" name="alert">'.$error.'</div>';
            }
          ?>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="weatherScraper.js"></script>
  </body>
</html>
