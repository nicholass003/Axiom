<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Skin;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Skin\PersonaPieceTintColor;
use Nicholass003\Axiom\Data\Type\Skin\PersonaSkinPiece;
use Nicholass003\Axiom\Data\Type\Skin\SkinAnimation;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Data\Type\Skin\SkinImage;
use Nicholass003\Axiom\Enum\PersonaSkinPieceType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class SkinDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SkinData{
		$skinId = CodecHelper::readString($in);
		$playFabId = CodecHelper::readString($in);
		$resourcePatch = CodecHelper::readString($in);
		$skinImage = $codec->read(SkinImage::class, $in);

		$animations = [];
		$animationCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $animationCount; ++$i){
			$animations[] = new SkinAnimation(
				image: $codec->read(SkinImage::class, $in),
				type: VarInt::readUnsignedInt($in),
				frames: LE::readFloat($in),
				expressionType: VarInt::readUnsignedInt($in)
			);
		}

		$capeImage = $codec->read(SkinImage::class, $in);
		$geometryData = CodecHelper::readString($in);
		$geometryDataEngineVersion = CodecHelper::readString($in);
		$skinColor = CodecHelper::readColor($in);

		$personaPieces = [];
		$personaPieceCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $personaPieceCount; ++$i){
			$personaPieces[] = new PersonaSkinPiece(
				pieceId: CodecHelper::readString($in),
				pieceType: PersonaSkinPieceType::fromJsonString(CodecHelper::readString($in)),
				packId: CodecHelper::readString($in),
				isDefaultPiece: CodecHelper::readBool($in),
				productId: CodecHelper::readString($in)
			);
		}

		$pieceTintColors = [];
		$tintColorCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $tintColorCount; ++$i){
			$pieceType = PersonaSkinPieceType::fromJsonString(CodecHelper::readString($in));
			$colors = [];
			$colorCount = VarInt::readUnsignedInt($in);
			for($j = 0; $j < $colorCount; ++$j){
				$colors[] = CodecHelper::readColor($in);
			}
			$pieceTintColors[] = new PersonaPieceTintColor($pieceType, $colors);
		}

		$isPremium = CodecHelper::readBool($in);
		$isPersona = CodecHelper::readBool($in);
		$isPersonaCapeOnClassic = CodecHelper::readBool($in);
		$isPrimaryUser = CodecHelper::readBool($in);
		$isOverride = CodecHelper::readBool($in);
		$isVerified = CodecHelper::readBool($in);

		return new SkinData(
			skinId: $skinId,
			playFabId: $playFabId,
			resourcePatch: $resourcePatch,
			skinImage: $skinImage,
			animations: $animations,
			capeImage: $capeImage,
			geometryData: $geometryData,
			geometryDataEngineVersion: $geometryDataEngineVersion,
			animationData: '',
			capeId: '',
			fullSkinId: '',
			armSize: '',
			skinColor: $skinColor,
			personaPieces: $personaPieces,
			pieceTintColors: $pieceTintColors,
			isPremium: $isPremium,
			isPersona: $isPersona,
			isPersonaCapeOnClassic: $isPersonaCapeOnClassic,
			isPrimaryUser: $isPrimaryUser,
			isOverride: $isOverride,
			isVerified: $isVerified
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SkinData);

		CodecHelper::writeString($out, $data->skinId);
		CodecHelper::writeString($out, $data->playFabId);
		CodecHelper::writeString($out, $data->resourcePatch);
		$codec->write(SkinImage::class, $out, $data->skinImage);

		VarInt::writeUnsignedInt($out, count($data->animations));
		foreach($data->animations as $animation){
			assert($animation instanceof SkinAnimation);
			$codec->write(SkinImage::class, $out, $animation->image);
			VarInt::writeUnsignedInt($out, $animation->type);
			LE::writeFloat($out, $animation->frames);
			VarInt::writeUnsignedInt($out, $animation->expressionType);
		}

		$codec->write(SkinImage::class, $out, $data->capeImage);
		CodecHelper::writeString($out, $data->geometryData);
		CodecHelper::writeString($out, $data->geometryDataEngineVersion);
		CodecHelper::writeColor($out, $data->skinColor);

		VarInt::writeUnsignedInt($out, count($data->personaPieces));
		foreach($data->personaPieces as $piece){
			assert($piece instanceof PersonaSkinPiece);
			CodecHelper::writeString($out, $piece->pieceId);
			CodecHelper::writeString($out, $piece->pieceType->toJsonString());
			CodecHelper::writeString($out, $piece->packId);
			CodecHelper::writeBool($out, $piece->isDefaultPiece);
			CodecHelper::writeString($out, $piece->productId);
		}

		VarInt::writeUnsignedInt($out, count($data->pieceTintColors));
		foreach($data->pieceTintColors as $tintColor){
			assert($tintColor instanceof PersonaPieceTintColor);
			CodecHelper::writeString($out, $tintColor->pieceType->toJsonString());
			VarInt::writeUnsignedInt($out, count($tintColor->colors));
			foreach($tintColor->colors as $color){
				CodecHelper::writeColor($out, $color);
			}
		}

		CodecHelper::writeBool($out, $data->isPremium);
		CodecHelper::writeBool($out, $data->isPersona);
		CodecHelper::writeBool($out, $data->isPersonaCapeOnClassic);
		CodecHelper::writeBool($out, $data->isPrimaryUser);
		CodecHelper::writeBool($out, $data->isOverride);
		CodecHelper::writeBool($out, $data->isVerified);
	}
}
