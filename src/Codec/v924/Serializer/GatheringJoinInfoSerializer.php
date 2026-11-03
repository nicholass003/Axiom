<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer;

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
			experienceId: CodecHelper::readString($in),
			experienceName: CodecHelper::readString($in),
			experienceWorldId: CodecHelper::readString($in),
			experienceWorldName: CodecHelper::readString($in),
			creatorId: CodecHelper::readString($in),
			storeId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof GatheringJoinInfo);

		CodecHelper::writeString($out, $data->experienceId);
		CodecHelper::writeString($out, $data->experienceName);
		CodecHelper::writeString($out, $data->experienceWorldId);
		CodecHelper::writeString($out, $data->experienceWorldName);
		CodecHelper::writeString($out, $data->creatorId);
		CodecHelper::writeString($out, $data->storeId);
	}
}