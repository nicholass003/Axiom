<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class GatheringJoinInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : GatheringJoinInfo{
		return new GatheringJoinInfo(
			experienceId: CodecHelper::readUuid($in),
			experienceName: CodecHelper::readString($in),
			experienceWorldId: CodecHelper::readUuid($in),
			experienceWorldName: CodecHelper::readString($in),
			creatorId: CodecHelper::readString($in),
			targetId: CodecHelper::readUuid($in),
			scenarioId: CodecHelper::readString($in),
			serverId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof GatheringJoinInfo);

		CodecHelper::writeUuid($out, $data->experienceId);
		CodecHelper::writeString($out, $data->experienceName);
		CodecHelper::writeUuid($out, $data->experienceWorldId);
		CodecHelper::writeString($out, $data->experienceWorldName);
		CodecHelper::writeString($out, $data->creatorId);
		CodecHelper::writeUuid($out, $data->targetId);
		CodecHelper::writeString($out, $data->scenarioId);
		CodecHelper::writeString($out, $data->serverId);
	}
}
