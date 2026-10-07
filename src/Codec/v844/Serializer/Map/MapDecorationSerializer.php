<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Map;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Map\MapDecoration;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;
use pocketmine\utils\Binary;

class MapDecorationSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MapDecoration{
		return new MapDecoration(
			icon: Byte::readUnsigned($in),
			rotation: Byte::readUnsigned($in),
			xOffset: Byte::readUnsigned($in),
			yOffset: Byte::readUnsigned($in),
			label: CodecHelper::readString($in),
			colorRgba: Binary::flipIntEndianness(VarInt::readUnsignedInt($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MapDecoration);

		Byte::writeUnsigned($out, $data->icon);
		Byte::writeUnsigned($out, $data->rotation);
		Byte::writeUnsigned($out, $data->xOffset);
		Byte::writeUnsigned($out, $data->yOffset);
		CodecHelper::writeString($out, $data->label);
		VarInt::writeUnsignedInt($out, Binary::flipIntEndianness($data->colorRgba));
	}
}
