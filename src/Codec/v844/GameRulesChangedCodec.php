<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\BoolGameRule;
use Nicholass003\Axiom\Data\Type\FloatGameRule;
use Nicholass003\Axiom\Data\Type\IntGameRule;
use Nicholass003\Axiom\Enum\GameRuleType;
use Nicholass003\Axiom\Packet\GameRulesChangedPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class GameRulesChangedCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : GameRulesChangedPacket{
        $pk = new GameRulesChangedPacket();
        $rules = [];
        $count = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $name = CodecHelper::readString($in);
            $isPlayerModifiable = CodecHelper::readBool($in);
            $type = GameRuleType::safe(VarInt::readUnsignedInt($in));
            $rules[$name] = match($type){
                GameRuleType::BOOL => new BoolGameRule(CodecHelper::readBool($in), $isPlayerModifiable),
                GameRuleType::INT => new IntGameRule(LE::readUnsignedInt($in), $isPlayerModifiable),
                GameRuleType::FLOAT => new FloatGameRule(LE::readFloat($in), $isPlayerModifiable),
                GameRuleType::UNKNOWN => throw new \RuntimeException("Unknown game rule type")
            };
        }
        $pk->gameRules = $rules;
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof GameRulesChangedPacket);
        VarInt::writeUnsignedInt($out, count($pk->gameRules));
        foreach($pk->gameRules as $name => $rule){
            CodecHelper::writeString($out, $name);
            CodecHelper::writeBool($out, $rule->isPlayerModifiable);
            $type = match(true){
                $rule instanceof BoolGameRule => GameRuleType::BOOL,
                $rule instanceof IntGameRule => GameRuleType::INT,
                $rule instanceof FloatGameRule => GameRuleType::FLOAT,
                default => throw new \InvalidArgumentException("Unknown game rule class")
            };
            VarInt::writeUnsignedInt($out, $type->value);
            match(true){
                $rule instanceof BoolGameRule => CodecHelper::writeBool($out, $rule->value),
                $rule instanceof IntGameRule => LE::writeUnsignedInt($out, $rule->value),
                $rule instanceof FloatGameRule => LE::writeFloat($out, $rule->value),
                default => throw new \InvalidArgumentException("Unknown game rule class")
            };
        }
    }
}
