<?php

use PHPUnit\Framework\TestCase;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

class RemuxTest extends TestCase
{
	public function testOblivionRemux() : void
	{
		$this->expectException(Exception::class);

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Oblivion (2013) - Remux.mkv'));

		$this->assertTrue($movie->remux);
	}

	public function testLastActionHeroRemux() : void
	{
		$this->expectException(Exception::class);

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Last Action Hero (1993) - Remux.mkv'));

		$this->assertTrue($movie->remux);
	}

	public function testApocalypseNowRemux() : void
	{
		$this->expectException(Exception::class);

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Apocalypse Now (1979) {edition-Redux} - Remux.mkv'));

		$this->assertTrue($movie->remux);
	}

	public function testSuperMarioBrosMovieRemux() : void
	{
		$this->expectException(Exception::class);

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/The Super Mario Bros. Movie (2023) - Remux.mkv'));

		$this->assertTrue($movie->remux);
	}

	public function testMadMaxFuryRoadRemux() : void
	{
		$this->expectException(Exception::class);

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Mad Max: Fury Road (2015).mkv'));

		$this->assertFalse($movie->remux);
	}
}