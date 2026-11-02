<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum ItemDescriptorType : string{
	use OrdinalEnumTrait;

	case EMPTY = "empty";
	case STRING_ID_META = "name";
	case MOLANG = "molang";
	case TAG = "item_tag";
	case INT_ID_META = "int"; /** @internal v844 */
	case COMPLEX_ALIAS = "complex_alias"; /** @internal v844 */

	public static function fromLegacy(int|string $value) : self{
		return match($value){
			1 => self::INT_ID_META,
			2 => self::MOLANG,
			3 => self::TAG,
			4 => self::STRING_ID_META,
			5 => self::COMPLEX_ALIAS,
			default => throw new \InvalidArgumentException("Unknown ItemDescriptorType value: " . $value)
		};
	}

	public function toLegacy() : int{
		return match($this){
			self::INT_ID_META => 1,
			self::MOLANG => 2,
			self::TAG => 3,
			self::STRING_ID_META => 4,
			self::COMPLEX_ALIAS => 5,
			default => throw new \InvalidArgumentException("Unknown ItemDescriptorType: " . $this->name)
		};
	}
}
