<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ServerTelemetryData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ServerTelemetryDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ServerTelemetryData{
		return new ServerTelemetryData(
			serverId: CodecHelper::readString($in),
			scenarioId: CodecHelper::readString($in),
			worldId: CodecHelper::readString($in),
			ownerId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ServerTelemetryData);

		CodecHelper::writeString($out, $data->serverId);
		CodecHelper::writeString($out, $data->scenarioId);
		CodecHelper::writeString($out, $data->worldId);
		CodecHelper::writeString($out, $data->ownerId);
	}
}