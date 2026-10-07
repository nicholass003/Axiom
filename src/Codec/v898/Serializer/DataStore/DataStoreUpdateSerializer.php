<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\DataStore;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DataStore\BoolDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Data\Type\DataStore\DoubleDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\StringDataStoreValue;
use Nicholass003\Axiom\Enum\DataStoreValueType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class DataStoreUpdateSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DataStoreUpdate{
		$name = CodecHelper::readString($in);
		$property = CodecHelper::readString($in);
		$path = CodecHelper::readString($in);

		$valueType = DataStoreValueType::safe(VarInt::readUnsignedInt($in));
		$data = match($valueType){
			DataStoreValueType::DOUBLE => $codec->read(DoubleDataStoreValue::class, $in),
			DataStoreValueType::BOOL => $codec->read(BoolDataStoreValue::class, $in),
			DataStoreValueType::STRING => $codec->read(StringDataStoreValue::class, $in),
			default => throw new \RuntimeException("Unknown DataStoreValue type $valueType->value")
		};

		$updateCount = VarInt::readUnsignedInt($in);
		return new DataStoreUpdate($name, $property, $path, $data, $updateCount);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DataStoreUpdate);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeString($out, $data->property);
		CodecHelper::writeString($out, $data->path);

		VarInt::writeUnsignedInt($out, $data->data->type->value);
		$codec->write($data->data::class, $out, $data->data);

		VarInt::writeUnsignedInt($out, $data->updateCount);
	}
}
