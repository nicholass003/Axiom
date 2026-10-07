<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\PackSetting;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\PackSetting\StringArrayPackSetting;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class StringArrayPackSettingSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : StringArrayPackSetting{
		throw new \LogicException("StringArrayPackSetting should be read via PackSetting::read()");
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof StringArrayPackSetting);

		CodecHelper::writeList($out, $data->value, CodecHelper::writeString(...));
	}
}