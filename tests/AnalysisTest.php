<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Scanner\MediaInfo\MediaInfo;
use Scanner\Movie\Movie;
use Tests\MovieData;

class AnalysisTest extends TestCase
{
	use MovieData;

	#[DataProvider('movieDataProvider')]
	public function testMovieAnalysis(string $fixture, string $expected) : void
	{
		$data     = json_decode(file_get_contents($fixture), true);
		$expected = json_decode(file_get_contents($expected), true);

		$this->assertIsArray($data);
		$this->assertIsArray($expected);

		$mediaInfo = $this->createStub(MediaInfo::class);
		$mediaInfo->method('run')->willReturn($data);

		$movie = new Movie($mediaInfo);
		$movie->analyze(new SplFileInfo('placeholder.mkv'));

		foreach ($expected as $track => $propertyList) {
			foreach ($propertyList as $property => $value) {
				$this->assertSame($value, $movie->$track->$property, 'Failed for property: '.$property);
			}
		}
	}
}