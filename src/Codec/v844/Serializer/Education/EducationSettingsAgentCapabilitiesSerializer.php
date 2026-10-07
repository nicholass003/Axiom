<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Education;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsAgentCapabilities;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EducationSettingsAgentCapabilitiesSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : EducationSettingsAgentCapabilities{
		return new EducationSettingsAgentCapabilities(
			canModifyBlocks: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof EducationSettingsAgentCapabilities);

		CodecHelper::writeBool($out, $data->canModifyBlocks ?? false);
	}
}
