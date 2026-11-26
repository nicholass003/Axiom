<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer\Enchant;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Enchant\Enchant;
use Nicholass003\Axiom\Data\Type\Enchant\EnchantOption;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class EnchantOptionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : EnchantOption{
		return new EnchantOption(
			cost: Byte::readUnsigned($in),
			slotFlags: LE::readUnsignedInt($in),
			equipActivatedEnchantments: CodecHelper::readList($in, fn($i) => $codec->read(Enchant::class, $i)),
			heldActivatedEnchantments: CodecHelper::readList($in, fn($i) => $codec->read(Enchant::class, $i)),
			selfActivatedEnchantments: CodecHelper::readList($in, fn($i) => $codec->read(Enchant::class, $i)),
			name: CodecHelper::readString($in),
			optionId: CodecHelper::readRecipeNetId($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof EnchantOption);

		Byte::writeUnsigned($out, $data->cost);
		LE::writeUnsignedInt($out, $data->slotFlags);
		CodecHelper::writeList($out, $data->equipActivatedEnchantments, fn($o, $v) => $codec->write(Enchant::class, $o, $v));
		CodecHelper::writeList($out, $data->heldActivatedEnchantments, fn($o, $v) => $codec->write(Enchant::class, $o, $v));
		CodecHelper::writeList($out, $data->selfActivatedEnchantments, fn($o, $v) => $codec->write(Enchant::class, $o, $v));
		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeRecipeNetId($out, $data->optionId);
	}
}
