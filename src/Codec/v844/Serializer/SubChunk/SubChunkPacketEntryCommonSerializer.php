<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketEntryCommon;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketHeightMapInfo;
use Nicholass003\Axiom\Enum\SubChunkPacketHeightMapType;
use Nicholass003\Axiom\Enum\SubChunkRequestResult;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SubChunkPacketEntryCommonSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $cacheEnabled = false) : SubChunkPacketEntryCommon{
		$offset = CodecHelper::readSubChunkOffset($in);
		$requestResult = Byte::readUnsigned($in);

		$terrainData = (!$cacheEnabled || $requestResult !== SubChunkRequestResult::SUCCESS_ALL_AIR) ? CodecHelper::readString($in) : "";

		// Read heightMap type
		$heightMapType = Byte::readUnsigned($in);
		$heightMap = match($heightMapType){
			SubChunkPacketHeightMapType::NO_DATA->value => null,
			SubChunkPacketHeightMapType::DATA->value => $codec->read(SubChunkPacketHeightMapInfo::class, $in),
			SubChunkPacketHeightMapType::ALL_TOO_HIGH->value => new SubChunkPacketHeightMapInfo(array_fill(0, 256, 16)),
			SubChunkPacketHeightMapType::ALL_TOO_LOW->value => new SubChunkPacketHeightMapInfo(array_fill(0, 256, -1)),
			default => null
		};

		// Read renderHeightMap type
		$renderHeightMapType = Byte::readUnsigned($in);
		$renderHeightMap = match($renderHeightMapType){
			SubChunkPacketHeightMapType::NO_DATA->value => null,
			SubChunkPacketHeightMapType::DATA->value => $codec->read(SubChunkPacketHeightMapInfo::class, $in),
			SubChunkPacketHeightMapType::ALL_TOO_HIGH->value => new SubChunkPacketHeightMapInfo(array_fill(0, 256, 16)),
			SubChunkPacketHeightMapType::ALL_TOO_LOW->value => new SubChunkPacketHeightMapInfo(array_fill(0, 256, -1)),
			SubChunkPacketHeightMapType::ALL_COPIED->value => $heightMap,
			default => null
		};

		return new SubChunkPacketEntryCommon(
			offset: $offset,
			requestResult: $requestResult,
			terrainData: $terrainData,
			heightMap: $heightMap,
			renderHeightMap: $renderHeightMap
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, bool $cacheEnabled = false) : void{
		assert($data instanceof SubChunkPacketEntryCommon);

		CodecHelper::writeSubChunkOffset($out, $data->offset);
		Byte::writeUnsigned($out, $data->requestResult);

		if(!$cacheEnabled || $data->requestResult !== SubChunkRequestResult::SUCCESS_ALL_AIR){
			CodecHelper::writeString($out, $data->terrainData);
		}

		// Write heightMap type
		if($data->heightMap === null){
			Byte::writeUnsigned($out, SubChunkPacketHeightMapType::NO_DATA->value);
		}else{
			$allTooLow = true;
			$allTooHigh = true;
			foreach($data->heightMap->heights as $h){
				if($h >= 0) $allTooLow = false;
				if($h <= 15) $allTooHigh = false;
			}
			if($allTooLow){
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::ALL_TOO_LOW->value);
			}elseif($allTooHigh){
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::ALL_TOO_HIGH->value);
			}else{
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::DATA->value);
				$codec->write(SubChunkPacketHeightMapInfo::class, $out, $data->heightMap);
			}
		}

		// Write renderHeightMap type
		if($data->renderHeightMap === null){
			Byte::writeUnsigned($out, SubChunkPacketHeightMapType::NO_DATA->value);
		}elseif($data->renderHeightMap === $data->heightMap){
			Byte::writeUnsigned($out, SubChunkPacketHeightMapType::ALL_COPIED->value);
		}else{
			$allTooLow = true;
			$allTooHigh = true;
			foreach($data->renderHeightMap->heights as $h){
				if($h >= 0) $allTooLow = false;
				if($h <= 15) $allTooHigh = false;
			}
			if($allTooLow){
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::ALL_TOO_LOW->value);
			}elseif($allTooHigh){
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::ALL_TOO_HIGH->value);
			}else{
				Byte::writeUnsigned($out, SubChunkPacketHeightMapType::DATA->value);
				$codec->write(SubChunkPacketHeightMapInfo::class, $out, $data->renderHeightMap);
			}
		}
	}
}
