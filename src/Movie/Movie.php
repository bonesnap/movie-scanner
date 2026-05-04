<?php
namespace Scanner\Movie;

use Scanner\Data\Audio;
use Scanner\Data\General;
use Scanner\Data\Video;
use Scanner\MediaInfo\MediaInfo;

class Movie
{
	public readonly bool    $remux;
	public readonly General $general;
	public readonly Video   $video;
	public readonly Audio   $primaryAudio;
	public readonly Audio   $secondaryAudio;

	public function __construct(private MediaInfo $mediaInfo) {}

	public function analyze(\SplFileInfo $fileInfo) : void
	{
		$this->remux = str_ends_with($fileInfo->getBasename('.'.$fileInfo->getExtension()), 'Remux');

		$this->parseData($this->mediaInfo->run($fileInfo));
	}

	private function parseData(array $mediaInfo) : void
	{
		$tracks      = $mediaInfo['media']['track'] ?? [];
		$audioTracks = [];

		if (empty($tracks)) {
			throw new \Exception('No media data!');
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
				&& $track['Language'] === 'en'
				&& !str_contains(strtolower($track['Title'] ?? ''), 'commentary')
				&& !str_contains(strtolower($track['Title'] ?? ''), 'sound only')
			) {
				$audioTracks[] = new Audio($track);
			}
		}

		$audioTracks = $this->sortAudioTracks($audioTracks);

		$this->primaryAudio = $audioTracks[0];

		if (isset($audioTracks[1])) {
			$this->secondaryAudio = $audioTracks[1];
		}
	}

	private function sortAudioTracks(array $audioTracks) : array
	{
		usort($audioTracks, function ($a, $b) {
			/** @var Audio $a */
			/** @var Audio $b */

			// TODO: Should probably use bit rate and/or compression as the tie-breaker instead?
			return Audio::AUDIO_NAMES[$b->name] <=> Audio::AUDIO_NAMES[$a->name];
		});

		return $audioTracks;
	}
}