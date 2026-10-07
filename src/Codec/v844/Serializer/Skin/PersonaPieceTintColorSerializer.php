<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Skin;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\Color;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Skin\PersonaPieceTintColor;
use Nicholass003\Axiom\Enum\PersonaSkinPieceType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class PersonaPieceTintColorSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PersonaPieceTintColor{
		$pieceType = PersonaSkinPieceType::fromJsonString(CodecHelper::readString($in));
		$colorCount = LE::readUnsignedInt($in);
		$colors = [];
		for($i = 0; $i < $colorCount; $i++){
			$colors[] = Color::fromHex(CodecHelper::readString($in));
		}
		return new PersonaPieceTintColor(
			pieceType: $pieceType,
			colors: $colors
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PersonaPieceTintColor);

		CodecHelper::writeString($out, $data->pieceType->toJsonString());
		LE::writeUnsignedInt($out, count($data->colors));
		foreach($data->colors as $color){
			CodecHelper::writeString($out, $color->toHex());
		}
	}
}
