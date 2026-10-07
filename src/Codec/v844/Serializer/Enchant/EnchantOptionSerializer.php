<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Enchant;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Enchant\Enchant;
use Nicholass003\Axiom\Data\Type\Enchant\EnchantOption;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class EnchantOptionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : EnchantOption{
		return new EnchantOption(
			cost: VarInt::readUnsignedInt($in),
			slotFlags: LE::readUnsignedInt($in),
			equipActivatedEnchantments: CodecHelper::readList($in, fn($in) => $codec->read(Enchant::class, $in)),
			heldActivatedEnchantments: CodecHelper::readList($in, fn($in) => $codec->read(Enchant::class, $in)),
			selfActivatedEnchantments: CodecHelper::readList($in, fn($in) => $codec->read(Enchant::class, $in)),
			name: CodecHelper::readString($in),
			optionId: CodecHelper::readRecipeNetId($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof EnchantOption);

		VarInt::writeUnsignedInt($out, $data->cost);
		LE::writeUnsignedInt($out, $data->slotFlags);
		CodecHelper::writeList($out, $data->equipActivatedEnchantments, fn($out, $v) => $codec->write(Enchant::class, $out, $v));
		CodecHelper::writeList($out, $data->heldActivatedEnchantments, fn($out, $v) => $codec->write(Enchant::class, $out, $v));
		CodecHelper::writeList($out, $data->selfActivatedEnchantments, fn($out, $v) => $codec->write(Enchant::class, $out, $v));
		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeRecipeNetId($out, $data->optionId);
	}
}
