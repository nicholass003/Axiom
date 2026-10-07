<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Map;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Map\MapImage;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;
use pocketmine\utils\Binary;

class MapImageSerializer implements SerializerInterface{
	use StatelessForkable;

	protected const MAX_WIDTH = 128;
	protected const MAX_HEIGHT = 128;

	public function read(ByteBufferReader $in, CodecType $codec, ?int $width = null, ?int $height = null) : MapImage{
		if($height < 1){
			throw new \InvalidArgumentException("Image height must be at least 1");
		}
		if($width > self::MAX_WIDTH){
			throw new \InvalidArgumentException("Image width exceeds maximum of " . self::MAX_WIDTH);
		}
		if($height > self::MAX_HEIGHT){
			throw new \InvalidArgumentException("Image height exceeds maximum of " . self::MAX_HEIGHT);
		}

		$pixels = [];
		for($y = 0; $y < $height; $y++){
			$row = [];
			for($x = 0; $x < $width; $x++){
				$row[] = Binary::flipIntEndianness(VarInt::readUnsignedInt($in));
			}
			$pixels[] = $row;
		}
		return new MapImage(width: $width, height: $height, pixels: $pixels);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MapImage);

		if($data->height < 1){
			throw new \InvalidArgumentException("Image height must be at least 1");
		}
		if($data->width > self::MAX_WIDTH){
			throw new \InvalidArgumentException("Image width exceeds maximum of " . self::MAX_WIDTH);
		}
		if($data->height > self::MAX_HEIGHT){
			throw new \InvalidArgumentException("Image height exceeds maximum of " . self::MAX_HEIGHT);
		}
		if(count($data->pixels) !== $data->height){
			throw new \InvalidArgumentException("Pixel rows count must equal height");
		}

		for($y = 0; $y < $data->height; $y++){
			$row = $data->pixels[$y] ?? throw new \InvalidArgumentException("Missing row $y");
			if(count($row) !== $data->width){
				throw new \InvalidArgumentException("All rows must have width columns");
			}
			for($x = 0; $x < $data->width; $x++){
				VarInt::writeUnsignedInt($out, Binary::flipIntEndianness($row[$x]));
			}
		}
	}
}
