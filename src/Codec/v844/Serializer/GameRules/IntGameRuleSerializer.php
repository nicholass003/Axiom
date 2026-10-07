<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\GameRules;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\IntGameRule;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class IntGameRuleSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $isStartGame = false, bool $isPlayerModifiable = false) : IntGameRule{
		$value = $isStartGame ? VarInt::readUnsignedInt($in) : LE::readUnsignedInt($in);
		return new IntGameRule(
			value: $value,
			isPlayerModifiable: $isPlayerModifiable
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, bool $isStartGame = false) : void{
		assert($data instanceof IntGameRule);

		if($isStartGame){
			VarInt::writeUnsignedInt($out, $data->value);
		}else{
			LE::writeUnsignedInt($out, $data->value);
		}
	}
}
