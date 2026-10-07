<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeModifier;
use Nicholass003\Axiom\Data\Type\Entity\UpdateAttribute;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class UpdateAttributeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : UpdateAttribute{
		$min = LE::readFloat($in);
		$max = LE::readFloat($in);
		$current = LE::readFloat($in);
		$defaultMin = LE::readFloat($in);
		$defaultMax = LE::readFloat($in);
		$default = LE::readFloat($in);
		$id = CodecHelper::readString($in);

		$modifiers = [];
		$count = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $count; ++$i){
			$modifiers[] = $codec->read(AttributeModifier::class, $in);
		}

		return new UpdateAttribute(
			id: $id,
			min: $min,
			max: $max,
			current: $current,
			defaultMin: $defaultMin,
			defaultMax: $defaultMax,
			default: $default,
			modifiers: $modifiers
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof UpdateAttribute);

		LE::writeFloat($out, $data->min);
		LE::writeFloat($out, $data->max);
		LE::writeFloat($out, $data->current);
		LE::writeFloat($out, $data->defaultMin);
		LE::writeFloat($out, $data->defaultMax);
		LE::writeFloat($out, $data->default);
		CodecHelper::writeString($out, $data->id);

		VarInt::writeUnsignedInt($out, count($data->modifiers));
		foreach($data->modifiers as $modifier){
			$codec->write(AttributeModifier::class, $out, $modifier);
		}
	}
}
