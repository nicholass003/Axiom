<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Skin;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Skin\SkinImage;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SkinImageSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SkinImage{
		return new SkinImage(
			width: VarInt::readUnsignedInt($in),
			height: VarInt::readUnsignedInt($in),
			data: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SkinImage);

		VarInt::writeUnsignedInt($out, $data->width);
		VarInt::writeUnsignedInt($out, $data->height);
		CodecHelper::writeString($out, $data->data);
	}
}
