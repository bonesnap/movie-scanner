<?php

use PHPUnit\Framework\TestCase;
use Scanner\Data\DataException;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

class TitleTest extends TestCase
{
	public function test2Guns2013Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for 2 Guns (2013)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/2 Guns (2013) - Remux.mkv'));
	}

	public function testApocalypseNow1979ReduxEditionTitle() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for Apocalypse Now (1979) Redux');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Apocalypse Now (1979) {edition-Redux} - Remux.mkv'));
	}

	public function testLastActionHero1993Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for Last Action Hero (1993)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Last Action Hero (1993) - Remux.mkv'));
	}

	public function testMadMaxFuryRoad2015Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for Mad Max: Fury Road (2015)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Mad Max: Fury Road (2015).mkv'));
	}

	public function testNationalLampoonsChristmasVacation1989Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for National Lampoon\'s Christmas Vacation (1989)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/National Lampoon\'s Christmas Vacation (1989) - Remux.mkv'));
	}

	public function testNosferatuExtendedCut2024Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for Nosferatu (2024) Extended Cut');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Nosferatu (2024) {edition-Extended Cut} - Remux.mkv'));
	}

	public function testOblivion2013Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for Oblivion (2013)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/Oblivion (2013) - Remux.mkv'));
	}

	public function testTheBigLebowski1998Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for The Big Lebowski (1998)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/The Big Lebowski (1998) - Remux.mkv'));
	}

	public function testTheNakedGun2025Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for The Naked Gun (2025)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/The Naked Gun (2025) - Remux.mkv'));
	}

	public function testTheSmashingMachine2025Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for The Smashing Machine (2025)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/The Smashing Machine (2025) - Remux.mkv'));
	}

	public function testTheSuperMarioBrosMovie2023Title() : void
	{
		$this->expectException(DataException::class);
		$this->expectExceptionMessage('No media data for The Super Mario Bros. Movie (2023)');

		$movie = new Movie(new MediaInfo());
		$movie->analyze(new SplFileInfo('filenames/The Super Mario Bros. Movie (2023) - Remux.mkv'));
	}
}