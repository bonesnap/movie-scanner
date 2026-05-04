<?php
namespace Scanner\Data;

readonly class Audio
{
	public string $name;
	public string $codec;
	public int    $channels;
	public string $layout;

	public const array AUDIO_NAMES = [
		'Dolby TrueHD with Dolby Atmos' => 100,
		'DTS-HD MA + DTS:X'             => 80,
		'DTS-HD Master Audio'           => 60,
		'Dolby Digital Plus'            => 40,
		'Dolby Digital'                 => 20,
	];

	public function __construct(array $data)
	{
		$this->name     = $data['Format_Commercial_IfAny'] ?? '';
		$this->codec    = $this->formatCodec($data['CodecID'] ?? '');
		$this->channels = (int)$data['Channels'];
		$this->layout   = $this->formatLayout($data['Channels'] ?? '');
	}

	private function formatCodec(string $codec) : string
	{
		return match ($codec) {
			'A_TRUEHD' => 'TrueHD',
			'A_AC3'    => 'AC3',
			'A_EAC3'   => 'EAC3',
			'A_DTS'    => 'DTS',
			default    => 'Unknown codec: '.$codec
		};
	}

	private function formatLayout(string $channels) : string
	{
		return match ($channels) {
			'2'     => '2.0',
			'3'     => '2.1',
			'6'     => '5.1',
			'8'     => '7.1',
			default => 'Unknown channels: '.$channels
		};
	}
}