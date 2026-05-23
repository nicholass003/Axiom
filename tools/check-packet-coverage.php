<?php

declare(strict_types=1);

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Packet\PacketIds;
use Nicholass003\Axiom\Version\ProtocolVersion;

require __DIR__ . "/../vendor/autoload.php";

$registered = [];
$invalidCodecs = [];

foreach(ProtocolVersion::cases() as $protocol){
    $protocolClass = "Nicholass003\\Axiom\\Version\\Protocol\\Protocol{$protocol->value}";

    if(!class_exists($protocolClass)){
        continue;
    }

    $builder = $protocolClass::build();

    foreach($builder->getCodecs() as $id => $codec){
        $registered[$id] = $codec;

        if(!is_object($codec)){
            $invalidCodecs[] = "{$protocol->name} -> invalid codec instance ({$id})";
            continue;
        }

        $codecClass = $codec::class;

        if(!class_exists($codecClass)){
            $invalidCodecs[] = "{$protocol->name} -> missing codec class {$codecClass}";
            continue;
        }

        $reflection = new ReflectionClass($codec);

        if(!$reflection->implementsInterface(Codec::class)){
            $invalidCodecs[] = "{$protocol->name} -> invalid codec interface {$codecClass}";
            continue;
        }

        if(!$reflection->hasMethod('encode')){
            $invalidCodecs[] = "{$protocol->name} -> missing encode() {$codecClass}";
            continue;
        }

        if(!$reflection->hasMethod('decode')){
            $invalidCodecs[] = "{$protocol->name} -> missing decode() {$codecClass}";
            continue;
        }
    }
}

$registeredIds = array_keys($registered);

$ref = new ReflectionClass(PacketIds::class);
$constants = $ref->getConstants();
$allPacketIds = array_values($constants);

sort($registeredIds);
sort($allPacketIds);

$missing = array_diff($allPacketIds, $registeredIds);
$extra = array_diff($registeredIds, $allPacketIds);

$packetDir = __DIR__ . "/../src/Packet";

$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($packetDir)
);

$packetFiles = [];
$packetIdMap = []; // id => filename
$validPacketCount = 0;
$invalidPacketFiles = [];

foreach($files as $file){
    if(!$file->isFile() || $file->getExtension() !== 'php'){
        continue;
    }

    $path = $file->getPathname();
    $content = file_get_contents($path);

    if(preg_match('/public\s+const\s+ID\s*=\s*PacketIds::(\w+)/', $content, $matches)){
        $constName = $matches[1];

        if(isset($constants[$constName])){
            $id = $constants[$constName];

            $packetIdMap[$id] = $file->getFilename();
            $validPacketCount++;
        }
    }else{
        if(!in_array($file->getFilename(), ['Packet.php', 'PacketIds.php'], true)){
            $invalidPacketFiles[] = $file->getFilename();
        }
    }

    $packetFiles[] = $file->getFilename();
}

$totalPacketFiles = count($packetFiles);

$packetNotRegistered = array_diff(
    array_keys($packetIdMap),
    $registeredIds
);

echo "===== TOTAL =====\n";
echo "PacketIds (Global): " . count($allPacketIds) . "\n";
echo "Registered (All Versions): " . count($registeredIds) . "\n";
echo "Packet Files: {$validPacketCount}\n";

$coverage = $validPacketCount > 0
    ? (count($registeredIds) / $validPacketCount) * 100
    : 0;

echo "Coverage: " . round($coverage, 2) . "%\n\n";

echo "===== PACKET FILE ANALYSIS =====\n";
echo "Total Packet Files: {$totalPacketFiles}\n";
echo "Valid Packet (has ID): {$validPacketCount}\n";
echo "Invalid Packet (missing ID): " . count($invalidPacketFiles) . "\n";

if(count($invalidPacketFiles) > 0){
    echo "\n===== INVALID PACKET FILES =====\n";

    foreach($invalidPacketFiles as $file){
        echo "[❗] {$file}\n";
    }
}

echo "\n===== PACKET FILE EXISTS BUT NOT REGISTERED =====\n";

foreach($packetNotRegistered as $id){
    $name = array_search($id, $constants, true);
    $file = $packetIdMap[$id] ?? 'unknown';

    echo "[❌] {$name} ({$id}) -> {$file}\n";
}

echo "[❌] Total: " . count($packetNotRegistered) . "\n";

echo "\n===== PACKET WITHOUT CODEC =====\n";

$codecFiles = [];

foreach(ProtocolVersion::cases() as $protocol){
    $codecDir = __DIR__ . "/../src/Codec/{$protocol->name}";

    if(!is_dir($codecDir)){
        continue;
    }

    $codecIterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($codecDir)
    );

    foreach($codecIterator as $file){
        if(!$file->isFile() || $file->getExtension() !== 'php'){
            continue;
        }

        $codecFiles[] = $file->getBasename('.php');
    }
}

$codecFiles = array_unique($codecFiles);

$packetWithoutCodec = [];

foreach($packetFiles as $packetFile){
    $packetName = pathinfo($packetFile, PATHINFO_FILENAME);

    if(
        $packetName === 'Packet' ||
        $packetName === 'PacketIds'
    ){
        continue;
    }

    if(!str_ends_with($packetName, 'Packet')){
        continue;
    }

    $baseName = substr(
        $packetName,
        0,
        -strlen('Packet')
    );

    $expectedCodec = "{$baseName}Codec";

    if(!in_array($expectedCodec, $codecFiles, true)){
        $packetWithoutCodec[] = [
        	'packet' => $packetName,
        	'codec' => $expectedCodec
        ];
    }
}

foreach($packetWithoutCodec as $data){
    echo "[❌] {$data['packet']} -> Missing {$data['codec']}\n";
}

echo "[❌] Total: " . count($packetWithoutCodec) . "\n";

echo "\n===== INVALID CODECS =====\n";

foreach($invalidCodecs as $error){
    echo "[❌] {$error}\n";
}

echo "[❌] Total: " . count($invalidCodecs) . "\n";

echo "\n===== MISSING PACKETS (GLOBAL PacketIds) =====\n";

foreach($constants as $name => $id){
    if(in_array($id, $missing, true)){
        echo "[⚠️] {$name} ({$id})\n";
    }
}

echo "[⚠️] Total: " . count($missing) . "\n";

echo "\n===== EXTRA REGISTERED =====\n";

foreach($extra as $id){
    $name = array_search($id, $constants, true);

    echo "[⚠️] {$name} ({$id})\n";
}

echo "[⚠️] Total: " . count($extra) . "\n";

echo "\n===== DONE =====\n";
