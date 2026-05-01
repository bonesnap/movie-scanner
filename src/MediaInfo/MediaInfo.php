<?php

namespace Scanner\MediaInfo;

class MediaInfo
{
	public function run(\SplFileInfo $fileInfo) : ?array
	{
		$result = shell_exec('mediainfo --Output=JSON '.escapeshellarg($fileInfo->getRealPath()));

		if (!$result) {
			throw new \Exception('MediaInfo failed!');
		}

		return json_decode($result, true);
	}
}