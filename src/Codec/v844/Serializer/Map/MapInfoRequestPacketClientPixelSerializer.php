<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Map;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Map\MapInfoRequestPacketClientPixel;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class MapInfoRequestPacketClientPixelSerializer implements SerializerInterface{
	use StatelessForkable;

	protected const Y_INDEX_MULTIPLIER = 128;

	public function read(ByteBufferReader $in, CodecType $codec) : MapInfoRequestPacketClientPixel{
		$color = LE::readUnsignedInt($in);
		$index = LE::readUnsignedShort($in);

		$x = $index % self::Y_INDEX_MULTIPLIER;
		$y = intdiv($index, self::Y_INDEX_MULTIPLIER);

		return new MapInfoRequestPacketClientPixel(
			colorRgba: $color,
			x: $x,
			y: $y
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MapInfoRequestPacketClientPixel);

		LE::writeUnsignedInt($out, $data->colorRgba);
		LE::writeUnsignedShort($out, $data->x + ($data->y * self::Y_INDEX_MULTIPLIER));
	}
}
