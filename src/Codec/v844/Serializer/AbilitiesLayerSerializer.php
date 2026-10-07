<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AbilitiesLayer;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AbilitiesLayerSerializer implements SerializerInterface{
	use StatelessForkable;

	/**
	 * @return AbilitiesLayer
	 */
	public function read(ByteBufferReader $in, CodecType $codec) : AbilitiesLayer{
		$layerId = LE::readUnsignedShort($in);
		$setAbilities = LE::readUnsignedInt($in);
		$setValues = LE::readUnsignedInt($in);
		$flySpeed = LE::readFloat($in);
		$verticalFlySpeed = LE::readFloat($in);
		$walkSpeed = LE::readFloat($in);

		$abilities = [];
		for($i = 0; $i < 20; $i++){
			if($i === 13 || $i === 14){
				continue;
			}

			if(($setAbilities & (1 << $i)) !== 0){
				$abilities[$i] = ($setValues & (1 << $i)) !== 0;
			}
		}

		if(($setAbilities & (1 << 13)) === 0){
			$flySpeed = null;
		}
		if(($setAbilities & (1 << 19)) === 0){
			$verticalFlySpeed = null;
		}
		if(($setAbilities & (1 << 14)) === 0){
			$walkSpeed = null;
		}

		return new AbilitiesLayer(
			layerId: $layerId,
			abilities: $abilities,
			flySpeed: $flySpeed,
			verticalFlySpeed: $verticalFlySpeed,
			walkSpeed: $walkSpeed
		);
	}

	/**
	 * @param AbilitiesLayer $data
	 */
	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AbilitiesLayer);

		LE::writeUnsignedShort($out, $data->layerId);
		$setAbilities = 0;
		$setValues = 0;

		foreach($data->abilities as $ability => $value){
			$setAbilities |= (1 << $ability);
			if($value){
				$setValues |= (1 << $ability);
			}
		}

		if($data->flySpeed !== null){
			$setAbilities |= (1 << 13);
		}
		if($data->verticalFlySpeed !== null){
			$setAbilities |= (1 << 19);
		}
		if($data->walkSpeed !== null){
			$setAbilities |= (1 << 14);
		}

		LE::writeUnsignedInt($out, $setAbilities);
		LE::writeUnsignedInt($out, $setValues);
		LE::writeFloat($out, $data->flySpeed ?? 0.0);
		LE::writeFloat($out, $data->verticalFlySpeed ?? 0.0);
		LE::writeFloat($out, $data->walkSpeed ?? 0.0);
	}
}
