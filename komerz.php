<?php
include_once("YMC/Virus/Song.php");
date_default_timezone_set("Europe/Berlin");


$stations = [
    'virus' => '66815fe2-9008-4853-80a5-f9caaffdf3a9',
    'srf3' => 'dd0fa1ba-4ff6-4e1a-ab74-d7e49057d96f',
    'srf1' => '69e8ac16-4327-4af4-b873-fd5cd6e895a7'

];

$dataPoints = [];
foreach ($stations as $stationName => $id) {
    $dataPoints[$stationName] = getDataForChannel($id);
}

echo json_encode($dataPoints);


function getDataForChannel($channelId) {
    $songinfoUrl = 'http://ws.srf.ch/songlog/log/channel/'.$channelId.'?fromDate='.str_replace('+02:00', '', date('c', time() - 17200)).'&toDate='.str_replace('+02:00', '', date('c')).'&page.size=1000';
    $xml = simplexml_load_file($songinfoUrl);

    $songs = [];


    foreach ($xml->Songlog as $songlog) {
        $song = new \YMC\Virus\Song();
        $song->setTitle((string) $songlog->Song->title);
        $song->setArtist((string) $songlog->Artist->name);

        $metadata = $song->getMetadata();
        if ($metadata['spotify']['popularity'] > 0) {
            $songs[] = $metadata;
        }
        if (count($songs) > 5) {
            break;
        }
    }

    return $songs;

}


