<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\BeaconPaymentStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class BeaconPaymentStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BeaconPaymentStackRequestAction{
		return new BeaconPaymentStackRequestAction(
			primaryEffectId: VarInt::readSignedInt($in),
			secondaryEffectId: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BeaconPaymentStackRequestAction);

		VarInt::writeSignedInt($out, $data->primaryEffectId);
		VarInt::writeSignedInt($out, $data->secondaryEffectId);
	}
}
