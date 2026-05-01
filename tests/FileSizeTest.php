<?php

use PHPUnit\Framework\TestCase;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;

class FileSizeTest extends TestCase
{
	public function testFileSizeOblivion() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/oblivion.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/Oblivion (2013) - Remux.mkv'));

		$this->assertSame('74.3 GB', $movie->general->fileSize);
		$this->assertSame('69.2 GiB', $movie->general->fileSizeBinary);
	}

	public function testFileSizeApocalypseNow() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/apocalypse.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/Apocalypse Now (1979) {edition-Redux} - Remux.mkv'));

		$this->assertSame('80.8 GB', $movie->general->fileSize);
		$this->assertSame('75.2 GiB', $movie->general->fileSizeBinary);
	}

	public function testFileSizeLastActionHero() : void
	{
		$data = json_decode(file_get_contents(__DIR__.'/data/last.json'), true);

		$mediaInfo = $this->createStub(MediaInfo::class);
        $mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('filenames/Last Action Hero (1993) - Remux.mkv'));

		$this->assertSame('82.1 GB', $movie->general->fileSize);
		$this->assertSame('76.4 GiB', $movie->general->fileSizeBinary);
	}
}