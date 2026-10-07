<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class MismatchTransactionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MismatchTransactionData{
		$actions = CodecHelper::readList($in, fn($in) => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction::class, $in));

		if(count($actions) > 0){
			throw new \RuntimeException("Mismatch transaction should not have actions");
		}

		return new MismatchTransactionData();
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MismatchTransactionData);

		CodecHelper::writeList($out, $data->actions, fn($out, $a) => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction::class, $out, $a));
	}
}
