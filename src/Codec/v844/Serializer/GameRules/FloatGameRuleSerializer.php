<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\GameRules;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\FloatGameRule;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class FloatGameRuleSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $isPlayerModifiable = false) : FloatGameRule{
		return new FloatGameRule(
			value: LE::readFloat($in),
			isPlayerModifiable: $isPlayerModifiable
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof FloatGameRule);

		LE::writeFloat($out, $data->value);
	}
}
