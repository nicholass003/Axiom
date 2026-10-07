<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Armor\ArmorSlotAndDamagePair;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerArmorDamagePacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PlayerArmorDamageCodec implements Codec{

	public function decode(ByteBufferReader $in, CodecType $codec) : PlayerArmorDamagePacket{
		$pk = new PlayerArmorDamagePacket();

		$pk->armorSlotAndDamagePairs = CodecHelper::readList($in, fn($i) => $codec->read(ArmorSlotAndDamagePair::class, $i));

		return $pk;
	}

	public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
		assert($pk instanceof PlayerArmorDamagePacket);

		CodecHelper::writeList($out, $pk->armorSlotAndDamagePairs, fn($o, $v) => $codec->write(ArmorSlotAndDamagePair::class, $o, $v));
	}
}
