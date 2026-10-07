<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum PersonaSkinPieceType : string{
	use OrdinalEnumTrait;

	case UNKNOWN = 'unknown';
	case SKELETON = 'skeleton';
	case BODY = 'body';
	case SKIN = 'skin';
	case BOTTOM = 'bottom';
	case FEET = 'feet';
	case DRESS = 'dress';
	case TOP = 'top';
	case HIGH_PANTS = 'high_pants';
	case HANDS = 'hands';
	case OUTERWEAR = 'outerwear';
	case FACIAL_HAIR = 'facialhair';
	case MOUTH = 'mouth';
	case EYES = 'eyes';
	case HAIR = 'hair';
	case HOOD = 'hood';
	case BACK = 'back';
	case FACE_ACCESSORY = 'faceaccessory';
	case HEAD = 'head';
	case LEGS = 'legs';
	case LEFT_LEG = 'leftleg';
	case RIGHT_LEG = 'rightleg';
	case ARMS = 'arms';
	case LEFT_ARM = 'leftarm';
	case RIGHT_ARM = 'rightarm';
	case CAPES = 'capes';
	case CLASSIC_SKIN = 'classicskin';
	case EMOTE = 'emote';
	case UNSUPPORTED = 'unsupported';

	private const JSON_STRING_TO_CASE = [
		"persona_unknown" => self::UNKNOWN,
		"persona_skeleton" => self::SKELETON,
		"persona_body" => self::BODY,
		"persona_skin" => self::SKIN,
		"persona_bottom" => self::BOTTOM,
		"persona_feet" => self::FEET,
		"persona_dress" => self::DRESS,
		"persona_top" => self::TOP,
		"persona_high_pants" => self::HIGH_PANTS,
		"persona_hands" => self::HANDS,
		"persona_outerwear" => self::OUTERWEAR,
		"persona_facial_hair" => self::FACIAL_HAIR,
		"persona_mouth" => self::MOUTH,
		"persona_eyes" => self::EYES,
		"persona_hair" => self::HAIR,
		"persona_hood" => self::HOOD,
		"persona_back" => self::BACK,
		"persona_face_accessory" => self::FACE_ACCESSORY,
		"persona_head" => self::HEAD,
		"persona_legs" => self::LEGS,
		"persona_left_leg" => self::LEFT_LEG,
		"persona_right_leg" => self::RIGHT_LEG,
		"persona_arms" => self::ARMS,
		"persona_left_arm" => self::LEFT_ARM,
		"persona_right_arm" => self::RIGHT_ARM,
		"persona_capes" => self::CAPES,
		"persona_classic_skin" => self::CLASSIC_SKIN,
		"persona_emote" => self::EMOTE,
		"persona_unsupported" => self::UNSUPPORTED,
	];

	public static function fromJsonString(string $jsonString) : self{
		return self::JSON_STRING_TO_CASE[$jsonString] ?? self::UNKNOWN;
	}

	public function toJsonString() : string{
		return match($this){
			self::UNKNOWN => "persona_unknown",
			self::SKELETON => "persona_skeleton",
			self::BODY => "persona_body",
			self::SKIN => "persona_skin",
			self::BOTTOM => "persona_bottom",
			self::FEET => "persona_feet",
			self::DRESS => "persona_dress",
			self::TOP => "persona_top",
			self::HIGH_PANTS => "persona_high_pants",
			self::HANDS => "persona_hands",
			self::OUTERWEAR => "persona_outerwear",
			self::FACIAL_HAIR => "persona_facial_hair",
			self::MOUTH => "persona_mouth",
			self::EYES => "persona_eyes",
			self::HAIR => "persona_hair",
			self::HOOD => "persona_hood",
			self::BACK => "persona_back",
			self::FACE_ACCESSORY => "persona_face_accessory",
			self::HEAD => "persona_head",
			self::LEGS => "persona_legs",
			self::LEFT_LEG => "persona_left_leg",
			self::RIGHT_LEG => "persona_right_leg",
			self::ARMS => "persona_arms",
			self::LEFT_ARM => "persona_left_arm",
			self::RIGHT_ARM => "persona_right_arm",
			self::CAPES => "persona_capes",
			self::CLASSIC_SKIN => "persona_classic_skin",
			self::EMOTE => "persona_emote",
			self::UNSUPPORTED => "persona_unsupported",
		};
	}
}
