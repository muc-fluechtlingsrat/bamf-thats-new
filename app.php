<?php
ini_set('display_errors', 1);

require 'vendor/autoload.php';
require 'config.php';
require 'sendMail.php';
require 'normalizeUrl.php';

$compareFile = './compare.txt';
if(!file_exists($compareFile)) {
    $isFileCreated = file_put_contents($compareFile, '');

    if($isFileCreated === false) {
        exit("Error: $compareFile doesn't exist and couldn't be created.\n");
    }
}
if(!is_writable($compareFile)) {
    exit("Error: $compareFile must be writable.\n");
}
$compareFileContents = file_get_contents($compareFile);

$uri = 'http://www.bamf.de/DE/Infothek/Statistiken/Asylzahlen/Asylgesch%C3%A4ftsstatistik/asylgeschaeftsstatistik-node.html';
$html = file_get_html($uri);
$linkNodes = $html->find('.Publication');

$downloadUrls = '';
foreach ($linkNodes as $linkNode) {
    $downloadUrls .= normalizeUrl($linkNode->href . PHP_EOL);
}

//URLs changed!
if(trim($downloadUrls) !== trim($compareFileContents)) {
    echo "URLs changed!\n\n$downloadUrls";
    sendMail($downloadUrls);
    file_put_contents($compareFile, $downloadUrls);
}
