<?php

namespace Scanner\Data;


readonly class General
{
	public string $fileSize;
	public string $fileSizeBinary;
	public string $duration;
	public string $bitRate;

	public function __construct(array $data)
	{
		$this->fileSize       = $this->formatFileSize($data['FileSize'], false);
		$this->fileSizeBinary = $this->formatFileSize($data['FileSize']);
		$this->duration       = $this->formatDuration($data['Duration']);
		$this->bitRate        = $this->formatBitrate($data['OverallBitRate']);
	}

	private function formatFileSize(?string $bytes, bool $binary = true) : string
	{
		if (!is_numeric($bytes)) {
			return '';
		}

		$value = (float)$bytes;

		if ($binary) {
			// Binary (IEC): 1 GiB = 1024^3 bytes
			$units   = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];
			$divisor = 1024;
		} else {
			// Decimal (SI): 1 GB = 1000^3 bytes
			$units   = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
			$divisor = 1000;
		}

		$index = 0;

		while ($value >= $divisor && $index < count($units) - 1) {
			$value /= $divisor;
			$index++;
		}

		return number_format($value, 1).' '.$units[$index];
	}

	private function formatDuration(?string $seconds) : string
	{
		if (!is_numeric($seconds)) {
			return '';
		}

		$total   = (int)round((float)$seconds);
		$hours   = intdiv($total, 3600);
		$minutes = intdiv($total % 3600, 60);

		return "{$hours} h {$minutes} min";
	}

	private function formatBitrate(?string $bps) : string
	{
		if (!is_numeric($bps)) {
			return '';
		}

		return number_format(((float)$bps) / 1_000_000, 1).' Mb/s';
	}
}