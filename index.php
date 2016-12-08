<?php
    spl_autoload_register(function ($class) {
        $baseDir = __DIR__ . '/res/classes/';
        $file = $baseDir . $class . '.php';
        if (file_exists($file)) { require $file; }
    });
    $weather = new Weather;
    $availableAreas = $weather->getAvailableAreaNumbers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Rhydian Jenkins">
<title>Weather API</title>
<!-- Bootstrap Core CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Bootstrap-select -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
</head>
<body>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Weather API</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" style="padding-bottom: 20px;">
                <div class="col-lg-11 col-md-11 col-sm-10 col-xs-10">
                    <select class="selectpicker show-menu-arrow" data-live-search="true">
                        <?php foreach ($availableAreas as $name => $number) : ?>
                            <option><?= $name; ?></option>
                        <?php endforeach ; ?>
                    </select>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2">
                    <img id="weatherImg" src="" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h4>Today:</h4>
                    <p id="item0"></p>
                    <br />
                    <h4>Tomorrow:</h4>
                    <p id="item1"></p>
                    <br />
                    <h4>Day After:</h4>
                    <p id="item2"></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-header"><h1>Raw API Response</h1></div>
                    <pre><p id="rawResponse" style="white-space: pre;"><?php var_dump($response); ?></p></pre>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.12.4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Bootstrap-select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>

    <!-- Send ajax to custom weather api -->
    <script>
        $(document).ready(function(){
            $('.selectpicker').change(function(e){
                e.preventDefault();
                updateWeather();
            });
            var updateWeather = function(){
                $.ajax({
                    method: 'post',
                    url: '/ror/weatherApi/res/classes/Weather.php',
                    data: {
                        'area': $(".selectpicker").val(),
                        'ajax': true
                    },
                    success: function(response) {
                        var responseObj = $.parseJSON(response);
                        var item0 = responseObj.channel.item[0].description;
                        var weatherImgUrl = responseObj.channel.image.url;
                        var item1 = responseObj.channel.item[1].description;
                        var item2 = responseObj.channel.item[2].description;
                        var prettyResponse = JSON.stringify(responseObj, null, 4);
                        $('#item0').html(item0);
                        $('#item1').html(item1);
                        $('#item2').html(item2);
                        $('#rawResponse').html(prettyResponse);
                        $('#weatherImg').attr('src', weatherImgUrl);
                    }
                });
            }
            updateWeather();
        });
    </script>
</body>
</html>