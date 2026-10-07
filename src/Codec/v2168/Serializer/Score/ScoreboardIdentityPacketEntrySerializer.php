<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Score;

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

	public function read(ByteBufferReader $in, CodecType $codec) : ScoreboardIdentityPacketEntry{
		return new ScoreboardIdentityPacketEntry(
			scoreboardId: VarInt::readSignedLong($in),
			actorUniqueId: CodecHelper::readOptional($in, CodecHelper::readActorUniqueId(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ScoreboardIdentityPacketEntry);

		VarInt::writeSignedLong($out, $data->scoreboardId);
		CodecHelper::writeOptional($out, $data->actorUniqueId, CodecHelper::writeActorUniqueId(...));
	}
}
