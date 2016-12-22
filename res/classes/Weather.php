<?php

if ($_POST['area']) {
    $weather = new Weather;
    $availableAreaNumbers = $weather->getAvailableAreaNumbers();
    if (array_key_exists($_POST['area'], $availableAreaNumbers)) {
        $response = $weather->getWeather($availableAreaNumbers[$_POST['area']]);
    } else {
        $response = $weather->getWeather();
    }
    echo $response;
}

class Weather {
    /**
     * Gets the weather and returns it json encoded.
     * Returns FALSE on error.
     */
    public function getWeather($areaNumber = 2653822) {
        $xmlResponse = file_get_contents($this->getUri($areaNumber));
        try {
            $xml = simplexml_load_string($xmlResponse);
            $json = json_encode($xml);
        } Catch (Exception $e) {
            // something went wrong!
            return false;
        }
        return $json;
    }

    /**
     * Generates a uri depending on the area number given.
     * Cardiff area number is taken as the default.
     */
    public function getUri($areaNumber) {
        return 'http://open.live.bbc.co.uk/weather/feeds/en/' . $areaNumber . '/3dayforecast.rss';
    }

    /**
     * Returns a list of known area numbers
     */
    public function getAvailableAreaNumbers() {
        return array(
            'Briton Ferry' => '2654668',
            'Cardiff' => '2653822',
            'Aberystywth' => '2657782',
            'Greater London' => '2643743',
            'Bridgend' => '2654755',
            'Swansea' => '2636432',
        );
    }
}
