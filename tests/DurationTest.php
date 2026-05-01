<?php

use PHPUnit\Framework\TestCase;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

class DurationTest extends TestCase
{
	public function testOblivionDuration() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/oblivion.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/Oblivion (2013) - Remux.mkv'));

		$this->assertSame('2 h 4 min', $movie->general->duration);
	}

	public function testDurationLastActionHero() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/last.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/Last Action Hero (1993) - Remux.mkv'));

		$this->assertSame('2 h 10 min', $movie->general->duration);
	}

	public function testTheSuperMarioBrosMovie() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/mario.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/The Super Mario Bros. Movie (2025) - Remux.mkv'));

		$this->assertSame('1 h 33 min', $movie->general->duration);
	}
}