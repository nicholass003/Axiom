<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\PropertySyncData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PropertySyncDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PropertySyncData{
		$intProps = [];
		$count = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $count; $i++){
			$intProps[VarInt::readUnsignedInt($in)] = VarInt::readSignedInt($in);
		}
		$floatProps = [];
		$count = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $count; $i++){
			$floatProps[VarInt::readUnsignedInt($in)] = LE::readFloat($in);
		}
		return new PropertySyncData(
			intProperties: $intProps,
			floatProperties: $floatProps
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PropertySyncData);

		VarInt::writeUnsignedInt($out, count($data->intProperties));
		foreach($data->intProperties as $k => $v){
			VarInt::writeUnsignedInt($out, $k);
			VarInt::writeSignedInt($out, $v);
		}
		VarInt::writeUnsignedInt($out, count($data->floatProperties));
		foreach($data->floatProperties as $k => $v){
			VarInt::writeUnsignedInt($out, $k);
			LE::writeFloat($out, $v);
		}
	}
}
