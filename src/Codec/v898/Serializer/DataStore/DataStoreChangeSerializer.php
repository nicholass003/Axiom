<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\DataStore;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DataStore\BoolDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreChange;
use Nicholass003\Axiom\Data\Type\DataStore\DoubleDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\StringDataStoreValue;
use Nicholass003\Axiom\Enum\DataStoreValueType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class DataStoreChangeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DataStoreChange{
		$name = CodecHelper::readString($in);
		$property = CodecHelper::readString($in);
		$updateCount = VarInt::readUnsignedInt($in);

		$valueType = DataStoreValueType::safe(VarInt::readUnsignedInt($in));
		$data = match($valueType){
			DataStoreValueType::DOUBLE => $codec->read(DoubleDataStoreValue::class, $in),
			DataStoreValueType::BOOL => $codec->read(BoolDataStoreValue::class, $in),
			DataStoreValueType::STRING => $codec->read(StringDataStoreValue::class, $in),
			default => throw new \RuntimeException("Unknown DataStoreValue type $valueType->value")
		};

		return new DataStoreChange($name, $property, $updateCount, $data);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DataStoreChange);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeString($out, $data->property);
		VarInt::writeUnsignedInt($out, $data->updateCount);

		VarInt::writeUnsignedInt($out, $data->data->type->value);
		$codec->write($data->data::class, $out, $data->data);
	}
}
