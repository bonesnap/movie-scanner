<?php

namespace Tests;

trait MovieData
{
	public static function movieDataProvider() : array
	{
		$movies = [
			'Apocalypse Now Redux (1979)'        => 'apocalypse',
			'Last Action Hero (1993)'            => 'last',
			'Mad Max: Fury Road (2015)'          => 'madmax',
			'Oblivion (2013)'                    => 'oblivion',
			'The Naked Gun (2025)'               => 'naked',
			'The Smashing Machine (2025)'        => 'smashing',
			'The Super Mario Bros. Movie (2023)' => 'mario',
		];

		return array_map(function ($slug) {
			return [
				'fixture'  => __DIR__.'/data/'.$slug.'.json',
				'expected' => __DIR__.'/data/'.$slug.'.expected.json',
			];
		}, $movies);
	}
}