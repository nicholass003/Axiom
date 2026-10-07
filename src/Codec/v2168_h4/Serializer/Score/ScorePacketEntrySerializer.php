<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168_h4\Serializer\Score;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Enum\ScorePacketEntryType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ScorePacketEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ScorePacketEntry{
		$scoreboardId = VarInt::readSignedLong($in);

		$type = ScorePacketEntryType::fromOrdinal(VarInt::readUnsignedInt($in));
		$innerType = CodecHelper::readString($in);
		if($type->value !== $innerType){
			throw new \RuntimeException("Expected inner type {$type->value} for score packet entry ordinal {$type->toOrdinal()}, got $innerType");
		}

		$objectiveName = null;
		$score = 0;
		$actorUniqueId = null;
		$customName = null;

		if($type === ScorePacketEntryType::REMOVE){
			$objectiveName = CodecHelper::readDoubleOptional($in, CodecHelper::readString(...));
		}elseif($type === ScorePacketEntryType::CHANGE_PLAYER || $type === ScorePacketEntryType::CHANGE_ENTITY){
			$objectiveName = CodecHelper::readString($in);
			$score = LE::readSignedInt($in);
			$actorUniqueId = CodecHelper::readActorUniqueId($in);
		}elseif($type === ScorePacketEntryType::CHANGE_FAKE_PLAYER){
			$objectiveName = CodecHelper::readString($in);
			$score = LE::readSignedInt($in);
			$customName = CodecHelper::readString($in);
		}

		return new ScorePacketEntry(
			scoreboardId: $scoreboardId,
			objectiveName: $objectiveName,
			score: $score,
			type: $type,
			actorUniqueId: $actorUniqueId,
			customName: $customName
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ScorePacketEntry);

		if($data->type === null){
			throw new \InvalidArgumentException("ScorePacketEntry must have type");
		}

		VarInt::writeSignedLong($out, $data->scoreboardId);
		VarInt::writeUnsignedInt($out, $data->type->toOrdinal());
		CodecHelper::writeString($out, $data->type->value);

		if($data->type === ScorePacketEntryType::REMOVE){
			CodecHelper::writeDoubleOptional($out, $data->objectiveName, CodecHelper::writeString(...));
		}elseif($data->type === ScorePacketEntryType::CHANGE_PLAYER || $data->type === ScorePacketEntryType::CHANGE_ENTITY){
			if($data->objectiveName === null){
				throw new \InvalidArgumentException("ObjectiveName must be set for this entry type");
			}
			CodecHelper::writeString($out, $data->objectiveName);
			LE::writeSignedInt($out, $data->score);
			if($data->actorUniqueId === null){
				throw new \InvalidArgumentException("ActorUniqueId required for player/entity type");
			}
			CodecHelper::writeActorUniqueId($out, $data->actorUniqueId);
		}elseif($data->type === ScorePacketEntryType::CHANGE_FAKE_PLAYER){
			if($data->objectiveName === null){
				throw new \InvalidArgumentException("ObjectiveName must be set for this entry type");
			}
			CodecHelper::writeString($out, $data->objectiveName);
			LE::writeSignedInt($out, $data->score);
			if($data->customName === null){
				throw new \InvalidArgumentException("CustomName must be set for this entry type");
			}
			CodecHelper::writeString($out, $data->customName);
		}
	}
}
