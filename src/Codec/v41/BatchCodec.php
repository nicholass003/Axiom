<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v41;

use Nicholass003\Axiom\Axiom;
use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\LegacyBinaryStreamHelper as Binary;
use Nicholass003\Axiom\Packet\Legacy\BatchPacket;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Version\ProtocolVersion;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use function strlen;
use function zlib_decode;
use function zlib_encode;
use const ZLIB_ENCODING_DEFLATE;

/** @since v41 */
class BatchCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : BatchPacket{
        $axiom = Axiom::for(ProtocolVersion::v41->value);
        $compressed = substr($in->getData(), $in->getOffset());
        $decompressed = zlib_decode($compressed);
        if($decompressed === false){
            throw new \RuntimeException("Failed to decompress batch packet");
        }
        $reader = new ByteBufferReader($decompressed);
        $packets = [];
        $dataLen = strlen($reader->getData());
        while($reader->getOffset() < $dataLen){
            $packetId = ord($reader->readByteArray(1));
            $length = Binary::readLInt($reader);
            $packetData = $reader->readByteArray($length);
            $subReader = new ByteBufferReader($packetData);
            $packetCodec = $axiom->get($packetId);
            $packets[] = $packetCodec->decode($$subReader, $codec);
        }
        $pk = new BatchPacket();
        $pk->packets = $packets;
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof BatchPacket);
        $axiom = Axiom::for(ProtocolVersion::v41->value);
        $writer = new ByteBufferWriter();
        foreach($pk->packets as $packet){
            $subOut = new ByteBufferWriter();
            $packetCodec = $axiom->get($packet::ID);
            $packetCodec->encode($subOut, $packet, $codec);
            $data = $subOut->getData();
            $writer->writeByteArray(chr($packet::ID));
            Binary::writeLInt($writer, strlen($data));
            $writer->writeByteArray($data);
        }
        $compressed = zlib_encode($writer->getData(), ZLIB_ENCODING_DEFLATE);
        $out->writeByteArray($compressed);
    }
}
