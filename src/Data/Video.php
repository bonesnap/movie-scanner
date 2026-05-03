<?php
namespace Scanner\Data;

readonly class Video
{
	public string $resolution;
	public string $bitRate;
	public string $aspectRatio;
	public bool   $dolbyVision;
	public bool   $hdr10Plus;
	public bool   $hdr10;

	public function __construct(array $data)
	{
		$this->resolution  = $this->formatResolution($data['Width'] ?? '', $data['Height'] ?? '');
		$this->bitRate     = $this->formatBitrate($data['BitRate'] ?? '');
		$this->aspectRatio = $this->formatAspectRatio($data['DisplayAspectRatio'] ?? '');
		$this->dolbyVision = $this->supportsDolbyVision($data['HDR_Format'] ?? '');
		$this->hdr10Plus   = $this->supportsHdr10Plus($data['HDR_Format'] ?? '', $data['HDR_Format_Compatibility'] ?? '');
		$this->hdr10       = $this->supportsHdr10($data['HDR_Format'] ?? '', $data['HDR_Format_Compatibility'] ?? '');
	}

	private function formatResolution(string $width, string $height) : string
	{
		return $width.'x'.$height;
	}

	private function formatBitrate(string $bps) : string
	{
		if (empty($bps) || !is_numeric($bps)) {
			return '';
		}

		return number_format(((float)$bps) / 1_000_000, 1).' Mb/s';
	}

	private function formatAspectRatio(string $ratio) : string
	{
		return match ($ratio) {
			'1.778', '1.78', '1.7778' => '16:9',
			'2.35', '2.350', '2.3500' => '2.35:1',
			'1.33', '1.333', '1.3333' => '4:3',
			'1.85', '1.850', '1.8500' => '1.85:1',
			'2.33', '2.333', '2.3333' => '21:9',
			default                   => $ratio,
		};
	}

	private function supportsDolbyVision(string $hdr) : bool
	{
		if (empty($hdr)) {
			return false;
		}

		return str_starts_with($hdr, 'Dolby Vision');
	}

	private function supportsHdr10Plus(string $hdr, string $compatibility) : bool
	{
		if (empty($hdr)) {
			return false;
		}

		if (empty($compatibility)) {
			return false;
		}

		return str_starts_with($hdr, 'HDR10+') || str_contains($compatibility, 'HDR10+');
	}

	private function supportsHdr10(string $hdr, string $compatibility) : bool
	{
		if (str_starts_with($hdr, 'HDR10') && !str_starts_with($hdr, 'HDR10+')) {
			return true;
		}

		if (str_starts_with($compatibility, 'HDR10') && !str_starts_with($compatibility, 'HDR10+')) {
			return true;
		}

		if (str_contains($compatibility, 'HDR10') && !str_contains($compatibility, 'HDR10+')) {
			return true;
		}

		return false;
	}
}