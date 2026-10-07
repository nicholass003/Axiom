<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeModifier;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AttributeModifierSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeModifier{
		return new AttributeModifier(
			id: CodecHelper::readString($in),
			name: CodecHelper::readString($in),
			amount: LE::readFloat($in),
			operation: LE::readSignedInt($in),
			operand: LE::readSignedInt($in),
			serializable: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeModifier);

		CodecHelper::writeString($out, $data->id);
		CodecHelper::writeString($out, $data->name);
		LE::writeFloat($out, $data->amount);
		LE::writeSignedInt($out, $data->operation);
		LE::writeSignedInt($out, $data->operand);
		CodecHelper::writeBool($out, $data->serializable);
	}
}
