<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec;

use Nicholass003\Axiom\Codec\Support\Forkable;
use Nicholass003\Axiom\Codec\Support\ForkableInterface;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CodecType implements ForkableInterface{
	use Forkable;

	/**
	 * @var array<class-string, SerializerInterface>
	 */
	private array $registry = [];

	public function get(string $dtoClass) : SerializerInterface{
		if(!isset($this->registry[$dtoClass])){
			throw new \InvalidArgumentException("No serializer registered for $dtoClass");
		}
		return $this->registry[$dtoClass];
	}

	public function read(string $dtoClass, ByteBufferReader $in) : mixed{
		return $this->get($dtoClass)->read($in, $this);
	}

	public function write(string $dtoClass, ByteBufferWriter $out, mixed $dto) : void{
		$this->get($dtoClass)->write($out, $dto, $this);
	}

	public function register(string $dtoClass, SerializerInterface $serializer) : self{
		if(isset($this->registry[$dtoClass])){
			throw new \InvalidArgumentException("Serializer already registered for $dtoClass");
		}
		$this->registry[$dtoClass] = $serializer;
		return $this;
	}

	public function override(string $dtoClass, SerializerInterface $serializer) : self{
		$this->registry[$dtoClass] = $serializer;
		return $this;
	}

	public function has(string $dtoClass) : bool{
		return isset($this->registry[$dtoClass]);
	}

	/**
	 * @return array<class-string, SerializerInterface>
	 */
	public function getRegistry() : array{
		return $this->registry;
	}
}
