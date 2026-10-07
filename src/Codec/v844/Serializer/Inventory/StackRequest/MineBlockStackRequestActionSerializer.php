<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\MineBlockStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class MineBlockStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MineBlockStackRequestAction{
		return new MineBlockStackRequestAction(
			hotbarSlot: VarInt::readSignedInt($in),
			predictedDurability: VarInt::readSignedInt($in),
			stackId: CodecHelper::readItemStackNetIdVariant($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MineBlockStackRequestAction);

		VarInt::writeSignedInt($out, $data->hotbarSlot);
		VarInt::writeSignedInt($out, $data->predictedDurability);
		CodecHelper::writeItemStackNetIdVariant($out, $data->stackId);
	}
}
