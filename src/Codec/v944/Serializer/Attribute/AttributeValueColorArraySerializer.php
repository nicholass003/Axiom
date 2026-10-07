<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeValueColorArray;
use Nicholass003\Axiom\Enum\AttributeValueColorType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AttributeValueColorArraySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeValueColorArray{
		$r = LE::readUnsignedInt($in);
		$g = LE::readUnsignedInt($in);
		$b = LE::readUnsignedInt($in);
		$a = LE::readUnsignedInt($in);

		return new AttributeValueColorArray(
			value: new \pocketmine\color\Color($r, $g, $b, $a)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeValueColorArray);

		LE::writeUnsignedInt($out, $data->value->getR());
		LE::writeUnsignedInt($out, $data->value->getG());
		LE::writeUnsignedInt($out, $data->value->getB());
		LE::writeUnsignedInt($out, $data->value->getA());
	}
}
