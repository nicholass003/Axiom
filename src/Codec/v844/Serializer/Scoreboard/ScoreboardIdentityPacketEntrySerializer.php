<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Scoreboard;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Score\ScoreboardIdentityPacketEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ScoreboardIdentityPacketEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $isRegister = false) : ScoreboardIdentityPacketEntry{
		return new ScoreboardIdentityPacketEntry(
			scoreboardId: VarInt::readSignedLong($in),
			actorUniqueId: $isRegister ? CodecHelper::readActorUniqueId($in) : null
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, bool $isRegister = false) : void{
		assert($data instanceof ScoreboardIdentityPacketEntry);

		VarInt::writeSignedLong($out, $data->scoreboardId);
		if($isRegister){
			CodecHelper::writeActorUniqueId($out, $data->actorUniqueId ?? throw new \InvalidArgumentException("ActorUniqueId required for register identity"));
		}
	}
}
