<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Skin;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\Color;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Skin\PersonaPieceTintColor;
use Nicholass003\Axiom\Data\Type\Skin\PersonaSkinPiece;
use Nicholass003\Axiom\Data\Type\Skin\SkinAnimation;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Data\Type\Skin\SkinImage;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class SkinDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SkinData{
		$skinId = CodecHelper::readString($in);
		$playFabId = CodecHelper::readString($in);
		$resourcePatch = CodecHelper::readString($in);
		$skinImage = $codec->read(SkinImage::class, $in);

		$animationCount = LE::readUnsignedInt($in);
		$animations = [];
		for($i = 0; $i < $animationCount; $i++){
			$animations[] = $codec->read(SkinAnimation::class, $in);
		}

		$capeImage = $codec->read(SkinImage::class, $in);
		$geometryData = CodecHelper::readString($in);
		$geometryDataVersion = CodecHelper::readString($in);
		$animationData = CodecHelper::readString($in);
		$capeId = CodecHelper::readString($in);
		$fullSkinId = CodecHelper::readString($in);
		$armSize = CodecHelper::readString($in);
		$skinColor = Color::fromHex(CodecHelper::readString($in));

		$personaPieceCount = LE::readUnsignedInt($in);
		$personaPieces = [];
		for($i = 0; $i < $personaPieceCount; $i++){
			$personaPieces[] = $codec->read(PersonaSkinPiece::class, $in);
		}

		$tintCount = LE::readUnsignedInt($in);
		$pieceTintColors = [];
		for($i = 0; $i < $tintCount; $i++){
			$pieceTintColors[] = $codec->read(PersonaPieceTintColor::class, $in);
		}

		return new SkinData(
			skinId: $skinId,
			playFabId: $playFabId,
			resourcePatch: $resourcePatch,
			skinImage: $skinImage,
			animations: $animations,
			capeImage: $capeImage,
			geometryData: $geometryData,
			geometryDataEngineVersion: $geometryDataVersion,
			animationData: $animationData,
			capeId: $capeId,
			fullSkinId: $fullSkinId,
			armSize: $armSize,
			skinColor: $skinColor,
			personaPieces: $personaPieces,
			pieceTintColors: $pieceTintColors,
			isVerified: true,
			isPremium: CodecHelper::readBool($in),
			isPersona: CodecHelper::readBool($in),
			isPersonaCapeOnClassic: CodecHelper::readBool($in),
			isPrimaryUser: CodecHelper::readBool($in),
			isOverride: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SkinData);

		CodecHelper::writeString($out, $data->skinId);
		CodecHelper::writeString($out, $data->playFabId);
		CodecHelper::writeString($out, $data->resourcePatch);
		$codec->write(SkinImage::class, $out, $data->skinImage);

		LE::writeUnsignedInt($out, count($data->animations));
		foreach($data->animations as $anim){
			$codec->write(SkinAnimation::class, $out, $anim);
		}

		$codec->write(SkinImage::class, $out, $data->capeImage);
		CodecHelper::writeString($out, $data->geometryData);
		CodecHelper::writeString($out, $data->geometryDataEngineVersion);
		CodecHelper::writeString($out, $data->animationData);
		CodecHelper::writeString($out, $data->capeId);
		CodecHelper::writeString($out, $data->fullSkinId);
		CodecHelper::writeString($out, $data->armSize);
		CodecHelper::writeString($out, $data->skinColor->toHex());

		LE::writeUnsignedInt($out, count($data->personaPieces));
		foreach($data->personaPieces as $piece){
			$codec->write(PersonaSkinPiece::class, $out, $piece);
		}

		LE::writeUnsignedInt($out, count($data->pieceTintColors));
		foreach($data->pieceTintColors as $tint){
			$codec->write(PersonaPieceTintColor::class, $out, $tint);
		}

		CodecHelper::writeBool($out, $data->isPremium);
		CodecHelper::writeBool($out, $data->isPersona);
		CodecHelper::writeBool($out, $data->isPersonaCapeOnClassic);
		CodecHelper::writeBool($out, $data->isPrimaryUser);
		CodecHelper::writeBool($out, $data->isOverride);
	}
}
