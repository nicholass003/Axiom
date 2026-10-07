<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Armor;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Armor\ArmorSlotAndDamagePair;
use Nicholass003\Axiom\Enum\ArmorSlot;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ArmorSlotAndDamagePairSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ArmorSlotAndDamagePair{
		return new ArmorSlotAndDamagePair(
			slot: ArmorSlot::safe(Byte::readUnsigned($in)),
			damage: LE::readUnsignedShort($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ArmorSlotAndDamagePair);

		Byte::writeUnsigned($out, $data->slot->value);
		LE::writeUnsignedShort($out, $data->damage);
	}
}
