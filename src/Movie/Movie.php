<?php
namespace Scanner\Movie;

use Scanner\Data\General;
use Scanner\Data\Video;
use Scanner\MediaInfo\MediaInfo;

class Movie
{
	public readonly bool    $remux;
	public readonly General $general;
	public readonly Video   $video;

	public function __construct(private MediaInfo $mediaInfo) {}

	public function analyze(\SplFileInfo $fileInfo) : void
	{
		$this->remux = str_ends_with($fileInfo->getBasename('.'.$fileInfo->getExtension()), 'Remux');

		$this->parseData($this->mediaInfo->run($fileInfo));
	}

	private function parseData(array $mediaInfo) : void
	{
		$tracks = $mediaInfo['media']['track'] ?? [];

		if (empty($tracks)) {
			return;
		}

		foreach ($tracks as $track) {
			if ($track['@type'] === 'General') {
				$this->general = new General($track);
			}

			if ($track['@type'] === 'Video' && $track['ID'] === '1') {
				$this->video = new Video($track);
			}
		}
	}
}