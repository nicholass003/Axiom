<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use Nicholass003\Axiom\Data\Type\ServerJoinInformation;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ServerJoinInformationSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ServerJoinInformation{
		return new ServerJoinInformation(
			gatheringJoinInfo: CodecHelper::readOptional($in, fn($i) => $codec->read(GatheringJoinInfo::class, $i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ServerJoinInformation);

		CodecHelper::writeOptional($out, $data->gatheringJoinInfo, fn($o, $v) => $codec->write(GatheringJoinInfo::class, $o, $v));
	}
}