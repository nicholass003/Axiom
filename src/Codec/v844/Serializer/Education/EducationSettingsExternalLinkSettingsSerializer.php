<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Education;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsExternalLinkSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EducationSettingsExternalLinkSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : EducationSettingsExternalLinkSettings{
		return new EducationSettingsExternalLinkSettings(
			url: CodecHelper::readString($in),
			displayName: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof EducationSettingsExternalLinkSettings);

		CodecHelper::writeString($out, $data->url);
		CodecHelper::writeString($out, $data->displayName);
	}
}
