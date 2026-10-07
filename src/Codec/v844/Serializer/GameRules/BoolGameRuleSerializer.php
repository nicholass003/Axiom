<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\GameRules;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\BoolGameRule;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BoolGameRuleSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $isPlayerModifiable = false) : BoolGameRule{
		return new BoolGameRule(
			value: CodecHelper::readBool($in),
			isPlayerModifiable: $isPlayerModifiable
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BoolGameRule);

		CodecHelper::writeBool($out, $data->value);
	}
}
