<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\PlayerListEntry;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PlayerListEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PlayerListEntry{
		$uuid = CodecHelper::readUUID($in);
		$actorUniqueId = CodecHelper::readOptional($in, CodecHelper::readActorUniqueId(...));
		$username = CodecHelper::readOptional($in, CodecHelper::readString(...));
		$xboxUserId = CodecHelper::readOptional($in, CodecHelper::readString(...));
		$platformChatId = CodecHelper::readOptional($in, CodecHelper::readString(...));
		$buildPlatform = CodecHelper::readOptional($in, VarInt::readSignedInt(...));
		$skinData = CodecHelper::readOptional($in, fn($i) => $codec->read(SkinData::class, $i));
		$isTeacher = CodecHelper::readOptional($in, CodecHelper::readBool(...));
		$isHost = CodecHelper::readOptional($in, CodecHelper::readBool(...));
		$isSubClient = CodecHelper::readOptional($in, CodecHelper::readBool(...));
		$color = CodecHelper::readOptional($in, fn($i) => LE::readUnsignedInt($i));
		$skinVerified = CodecHelper::readOptional($in, CodecHelper::readBool(...));

		return new PlayerListEntry(
			uuid: $uuid,
			actorUniqueId: $actorUniqueId,
			username: $username,
			xboxUserId: $xboxUserId,
			platformChatId: $platformChatId,
			buildPlatform: $buildPlatform,
			skinData: $skinData,
			isTeacher: $isTeacher,
			isHost: $isHost,
			isSubClient: $isSubClient,
			color: $color,
			skinVerified: $skinVerified
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PlayerListEntry);

		CodecHelper::writeUUID($out, $data->uuid);
		CodecHelper::writeOptional($out, $data->actorUniqueId, CodecHelper::writeActorUniqueId(...));
		CodecHelper::writeOptional($out, $data->username, CodecHelper::writeString(...));
		CodecHelper::writeOptional($out, $data->xboxUserId, CodecHelper::writeString(...));
		CodecHelper::writeOptional($out, $data->platformChatId, CodecHelper::writeString(...));
		CodecHelper::writeOptional($out, $data->buildPlatform, VarInt::writeSignedInt(...));
		CodecHelper::writeOptional($out, $data->skinData, fn($o, $v) => $codec->write(SkinData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->isTeacher, CodecHelper::writeBool(...));
		CodecHelper::writeOptional($out, $data->isHost, CodecHelper::writeBool(...));
		CodecHelper::writeOptional($out, $data->isSubClient, CodecHelper::writeBool(...));
		CodecHelper::writeOptional($out, $data->color, fn($o, $c) => LE::writeUnsignedInt($o, $c));
		CodecHelper::writeOptional($out, $data->skinVerified, CodecHelper::writeBool(...));
	}
}
