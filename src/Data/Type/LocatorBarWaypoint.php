<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class LocatorBarWaypoint{

	/** @since v975 */
	public readonly ?string $texturePath;
	/** @since v975 */
	public readonly ?Vec2 $iconSize;

    public function __construct(
        public readonly int $updateFlag,
        public readonly ?bool $visible,
		public readonly ?WorldPosition $worldPosition,
		/** @deprecated v975 */
		public readonly ?int $textureId,
		?string $texturePath,
		?Vec2 $iconSize,
		public readonly ?int $color,
		public readonly ?bool $clientPositionAuthority,
		public readonly ?int $actorUniqueId,
    ){
		$this->texturePath = $texturePath ?? null;
		$this->iconSize = $iconSize ?? null;
	}
}
