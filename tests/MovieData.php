<?php

namespace Tests;

trait MovieData
{
	public static function movieDataProvider() : array
	{
		$movies = [
			'2 Guns (2013)'                                 => '2guns',
			'Apocalypse Now Redux (1979)'                   => 'apocalypse',
			'Last Action Hero (1993)'                       => 'last',
			'Mad Max: Fury Road (2015)'                     => 'madmax',
			'National Lampoon\'s Christmas Vacation (1989)' => 'vacation',
			'Nosferatu (2024)'                              => 'nosferatu',
			'Oblivion (2013)'                               => 'oblivion',
			'The Big Lebowski (1998)'                       => 'lebowski',
			'The Naked Gun (2025)'                          => 'naked',
			'The Smashing Machine (2025)'                   => 'smashing',
			'The Super Mario Bros. Movie (2023)'            => 'mario',
		];

		return array_map(function ($slug) {
			return [
				'fixture'  => __DIR__.'/data/'.$slug.'.json',
				'expected' => __DIR__.'/data/'.$slug.'.expected.json',
			];
		}, $movies);
	}
}