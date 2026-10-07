<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\FeatureRegistryPacketEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class FeatureRegistryPacketEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : FeatureRegistryPacketEntry{
		return new FeatureRegistryPacketEntry(
			featureName: CodecHelper::readString($in),
			featureJson: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof FeatureRegistryPacketEntry);

		CodecHelper::writeString($out, $data->featureName);
		CodecHelper::writeString($out, $data->featureJson);
	}
}
