<?php

use Scanner\IgnorantRecursiveDirectoryIterator\IgnorantRecursiveDirectoryIterator;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

require_once 'vendor/autoload.php';

$directory = '/movies/4k-movies';

try {
	$movies   = [];
	$iterator = new RecursiveIteratorIterator(new IgnorantRecursiveDirectoryIterator($directory));

	echo 'Beginning scanning...'.PHP_EOL;

	foreach ($iterator as $fileInfo) {
		/** @var $fileInfo SplFileInfo */

		if ($fileInfo->isDir()) {
			continue;
		}

		$movie = new Movie(new MediaInfo());
		$movie->analyze($fileInfo);

		$movies[] = $movie;

		echo 'Scanned '.$movie->title.PHP_EOL;
	}

	if (empty($movies)) {
		die('No movies scanned!'.PHP_EOL);
	}

	usort($movies, function($a, $b) {
		return $a->title <=> $b->title;
	});

	$dataRows = '';

	foreach ($movies as $movie) {
		$hdr10Plus = ($movie->video->hdr10Plus) ? 'Yes' : 'No';
		$hdr10     = ($movie->video->hdr10) ? 'Yes' : 'No';

		$rp = new ReflectionProperty(Movie::class, 'secondaryAudio');
		if ($rp->isInitialized($movie)) {
			$secondaryAudioName   = $movie->secondaryAudio->name;
			$secondaryAudioLayout = $movie->secondaryAudio->layout;
		} else {
			$secondaryAudioName   = '-';
			$secondaryAudioLayout = '-';
		}

		$dataRows .= '<tr>';
			$dataRows .= '<td>'.$movie->title.'</td>';
			$dataRows .= '<td>'.$movie->general->fileSize.'</td>';
			$dataRows .= '<td>'.$movie->general->duration.'</td>';
			$dataRows .= '<td>'.$movie->general->bitRate.'</td>';
			$dataRows .= '<td>'.$movie->video->dolbyVision.'</td>';
			$dataRows .= '<td>'.$hdr10Plus.'</td>';
			$dataRows .= '<td>'.$hdr10.'</td>';
			$dataRows .= '<td>'.$movie->video->resolution.'</td>';
			$dataRows .= '<td>'.$movie->video->aspectRatio.'</td>';
			$dataRows .= '<td>'.$movie->video->bitRate.'</td>';
			$dataRows .= '<td>'.$movie->primaryAudio->name.'</td>';
			$dataRows .= '<td>'.$movie->primaryAudio->layout.'</td>';
			$dataRows .= '<td>'.$secondaryAudioName.'</td>';
			$dataRows .= '<td>'.$secondaryAudioLayout.'</td>';
		$dataRows .= '</tr>';
	}

	$html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px 14px; text-align: left; }
        th { background-color: #4a90e2; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #e8f0fe; }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
            	<th rowspan="3">Title</th>
            	<th rowspan="2" colspan="3">General</th>
            	<th colspan="6">Video</th>
            	<th colspan="4">Audio</th>
            </tr>
            <tr>
            	<th colspan="3">HDR</th>
            	<th colspan="3">Presentation</th>
            	<th colspan="2">Primary</th>
            	<th colspan="2">Secondary</th>
			</tr>
			<tr>
				<th>File Size</th>
				<th>Duration</th>
				<th>Bit Rate</th>
				<th>Dolby Vision</th>
				<th>HDR10+</th>
				<th>HDR10</th>
				<th>Resolution</th>
				<th>Aspect Ratio</th>
				<th>Bit Rate</th>
				<th>Name</th>
				<th>Layout</th>
				<th>Name</th>
				<th>Layout</th>
			</tr>
        </thead>
        <tbody>
            $dataRows
        </tbody>
    </table>
</body>
</html>
HTML;

	$outputFile   = __DIR__."/results.html";
	$bytesWritten = file_put_contents($outputFile, $html);

	if ($bytesWritten !== false) {
		echo 'Success! results.html generated ('.$bytesWritten.' bytes).'.PHP_EOL;
	} else {
		echo 'Error: Could not write to '.$outputFile.'. Check directory permissions.'.PHP_EOL;
	}
} catch (\UnexpectedValueException $e) {
	echo 'Error: '.$e->getMessage().PHP_EOL;
}
