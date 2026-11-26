<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ClientStoreEntrypointConfig;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use Nicholass003\Axiom\Data\Type\PresenceConfig;
use Nicholass003\Axiom\Data\Type\ServerJoinInformation;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ServerJoinInformationSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ServerJoinInformation{
		return new ServerJoinInformation(
			gatheringJoinInfo: CodecHelper::readOptional($in, fn($i) => $codec->read(GatheringJoinInfo::class, $i)),
			clientStoreEntrypointConfig: CodecHelper::readOptional($in, fn($i) => $codec->read(ClientStoreEntrypointConfig::class, $i)),
			presenceConfig: CodecHelper::readOptional($in, fn($i) => $codec->read(PresenceConfig::class, $i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ServerJoinInformation);

		CodecHelper::writeOptional($out, $data->gatheringJoinInfo, fn($o, $v) => $codec->write(GatheringJoinInfo::class, $o, $v));
		CodecHelper::writeOptional($out, $data->clientStoreEntrypointConfig, fn($o, $v) => $codec->write(ClientStoreEntrypointConfig::class, $o, $v));
		CodecHelper::writeOptional($out, $data->presenceConfig, fn($o, $v) => $codec->write(PresenceConfig::class, $o, $v));
	}
}
