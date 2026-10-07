<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Skin;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Skin\PersonaSkinPiece;
use Nicholass003\Axiom\Enum\PersonaSkinPieceType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PersonaSkinPieceSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PersonaSkinPiece{
		return new PersonaSkinPiece(
			pieceId: CodecHelper::readString($in),
			pieceType: PersonaSkinPieceType::fromJsonString(CodecHelper::readString($in)),
			packId: CodecHelper::readString($in),
			isDefaultPiece: CodecHelper::readBool($in),
			productId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PersonaSkinPiece);

		CodecHelper::writeString($out, $data->pieceId);
		CodecHelper::writeString($out, $data->pieceType->toJsonString());
		CodecHelper::writeString($out, $data->packId);
		CodecHelper::writeBool($out, $data->isDefaultPiece);
		CodecHelper::writeString($out, $data->productId);
	}
}
