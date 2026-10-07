<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\Common;

final class Color{

	public static function fromARGB(int $argb) : self{
		return new self(
			a: ($argb >> 24) & 0xFF,
			r: ($argb >> 16) & 0xFF,
			g: ($argb >> 8) & 0xFF,
			b: $argb & 0xFF
		);
	}

	public static function fromHex(string $hex) : self{
		$hex = ltrim($hex, '#');
		if(strlen($hex) === 6){
			$hex = 'FF' . $hex;
		}
		$argb = hexdec($hex);
		return self::fromARGB($argb);
	}

	public function __construct(
		public readonly int $a,
		public readonly int $r,
		public readonly int $g,
		public readonly int $b
	){}

	public function toARGB() : int{
		return ($this->a << 24) | ($this->r << 16) | ($this->g << 8) | $this->b;
	}

	public function toHex() : string{
		return strtoupper(sprintf('%02X%02X%02X%02X', $this->a, $this->r, $this->g, $this->b));
	}

	public function __toString() : string{
		return $this->toHex();
	}
}
