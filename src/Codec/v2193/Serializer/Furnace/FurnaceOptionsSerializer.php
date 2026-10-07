<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\Furnace;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceLayout;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceLeftTab;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceOptions;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class FurnaceOptionsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : FurnaceOptions{
		return new FurnaceOptions(
			leftFurnaceTab: FurnaceLeftTab::fromPacket(VarInt::readSignedInt($in)),
			filtering: CodecHelper::readBool($in),
			layout: FurnaceLayout::fromPacket(VarInt::readSignedInt($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof FurnaceOptions);

		VarInt::writeSignedInt($out, $data->leftFurnaceTab->toPacket());
		CodecHelper::writeBool($out, $data->filtering);
		VarInt::writeSignedInt($out, $data->layout->toPacket());
	}
}
