<?php

use PHPUnit\Framework\TestCase;
use Scanner\Data\DataException;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

class RemuxTest extends TestCase
{
	public function testOblivionRemux() : void
	{
		try {
			$movie = new Movie(new MediaInfo());
			$movie->analyze(new SplFileInfo('filenames/Oblivion (2013) - Remux.mkv'));
		} catch (DataException) {
			$this->assertTrue($movie->remux);
		}
	}

	public function testLastActionHeroRemux() : void
	{
		try {
			$movie = new Movie(new MediaInfo());
			$movie->analyze(new SplFileInfo('filenames/Last Action Hero (1993) - Remux.mkv'));
		} catch (DataException) {
			$this->assertTrue($movie->remux);
		}
	}

	public function testApocalypseNowRemux() : void
	{
		try {
			$movie = new Movie(new MediaInfo());
			$movie->analyze(new SplFileInfo('filenames/Apocalypse Now (1979) {edition-Redux} - Remux.mkv'));
		} catch (DataException) {
			$this->assertTrue($movie->remux);
		}
	}

	public function testSuperMarioBrosMovieRemux() : void
	{
		try {
			$movie = new Movie(new MediaInfo());
			$movie->analyze(new SplFileInfo('filenames/The Super Mario Bros. Movie (2023) - Remux.mkv'));
		} catch (DataException) {
			$this->assertTrue($movie->remux);
		}
	}

	public function testMadMaxFuryRoadRemux() : void
	{
		try {
			$movie = new Movie(new MediaInfo());
			$movie->analyze(new SplFileInfo('filenames/Mad Max: Fury Road (2015).mkv'));
		} catch (DataException) {
			$this->assertFalse($movie->remux);
		}
	}
}