<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Scoreboard;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Enum\ScorePacketEntryType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ScorePacketEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $isRemove = false) : ScorePacketEntry{
		$scoreboardId = VarInt::readSignedLong($in);
		$objectiveName = CodecHelper::readString($in);
		$score = LE::readSignedInt($in);

		$type = ScorePacketEntryType::CHANGE_PLAYER;
		$actorUniqueId = null;
		$customName = null;

        if(!$isRemove){
            $type = ScorePacketEntryType::fromOrdinal(Byte::readUnsigned($in));
            switch($type){
                case ScorePacketEntryType::CHANGE_PLAYER:
                case ScorePacketEntryType::CHANGE_ENTITY:
                    $actorUniqueId = CodecHelper::readActorUniqueId($in);
                    break;
                case ScorePacketEntryType::CHANGE_FAKE_PLAYER:
                    $customName = CodecHelper::readString($in);
                    break;
                default:
                    throw new \RuntimeException("Unknown score entry type {$type->value}");
            }
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

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, bool $isRemove = false) : void{
		assert($data instanceof ScorePacketEntry);

        VarInt::writeSignedLong($out, $data->scoreboardId);
        CodecHelper::writeString($out, $data->objectiveName);
        LE::writeSignedInt($out, $data->score);

        if(!$isRemove){
            Byte::writeUnsigned($out, $data->type->toOrdinal());
            switch($data->type){
                case ScorePacketEntryType::CHANGE_PLAYER:
                case ScorePacketEntryType::CHANGE_ENTITY:
                    if($data->actorUniqueId === null){
                        throw new \InvalidArgumentException("ActorUniqueId required for player/entity type");
                    }
                    CodecHelper::writeActorUniqueId($out, $data->actorUniqueId);
                    break;
                case ScorePacketEntryType::CHANGE_FAKE_PLAYER:
                    if($data->customName === null){
                        throw new \InvalidArgumentException("CustomName required for fake player type");
                    }
                    CodecHelper::writeString($out, $data->customName);
                    break;
                default:
                    throw new \InvalidArgumentException("Unknown score entry type {$data->type->value}");
            }
        }
	}
}
