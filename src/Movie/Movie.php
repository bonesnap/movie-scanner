<?php
namespace Scanner\Movie;

use Scanner\Data\Audio;
use Scanner\Data\DataException;
use Scanner\Data\General;
use Scanner\Data\Video;
use Scanner\MediaInfo\MediaInfo;

class Movie
{
	public readonly bool    $remux;
	public readonly string  $title;
	public readonly General $general;
	public readonly Video   $video;
	public readonly Audio   $primaryAudio;

	public function __construct(private MediaInfo $mediaInfo) {}

	public function analyze(\SplFileInfo $fileInfo) : void
	{
		$this->remux = str_ends_with($fileInfo->getBasename('.'.$fileInfo->getExtension()), 'Remux');
		$this->title = $this->parseTitle($fileInfo->getBasename('.'.$fileInfo->getExtension()));

		echo 'Scanning '.$this->title.PHP_EOL;

		$this->parseData($this->mediaInfo->run($fileInfo));
	}

	private function parseTitle(string $filename) : string
	{
		if (str_ends_with($filename, ' - Remux')) {
			$filename = str_replace(' - Remux', '', $filename);
		}

		if (str_contains($filename, '{edition-')) {
			return preg_replace('/\{edition-([\w\s]+)\}/i', '$1', $filename);
		}

		return $filename;
	}

	private function parseData(array $mediaInfo) : void
	{
		$tracks      = $mediaInfo['media']['track'] ?? [];
		$audioTracks = [];

		if (empty($tracks)) {
			throw new DataException('No media data for '.$this->title);
		}

		foreach ($tracks as $track) {
			if ($track['@type'] === 'General') {
				$this->general = new General($track);
			}

			if ($track['@type'] === 'Video' && $track['ID'] === '1') {
				$this->video = new Video($track);
			}

			if (
				$track['@type'] === 'Audio'
				&& ($track['@typeorder'] ?? '' === '1' || $track['StreamOrder'] === '1')
				&& $track['Language'] === 'en'
			) {
				$audioTracks[] = new Audio($track);
			}
		}

		$this->primaryAudio = $audioTracks[0];
	}
}