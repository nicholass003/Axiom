<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Experiments;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ExperimentsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : Experiments{
		$count = LE::readUnsignedInt($in);
		$experiments = [];
		for($i = 0; $i < $count; ++$i){
			$experiments[CodecHelper::readString($in)] = CodecHelper::readBool($in);
		}
		return new Experiments(
			experiments: $experiments,
			hasPreviouslyUsedExperiments: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof Experiments);

		LE::writeUnsignedInt($out, count($data->experiments));
		foreach($data->experiments as $name => $enabled){
			CodecHelper::writeString($out, $name);
			CodecHelper::writeBool($out, $enabled);
		}
		CodecHelper::writeBool($out, $data->hasPreviouslyUsedExperiments);
	}
}
