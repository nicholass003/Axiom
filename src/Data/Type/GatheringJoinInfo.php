<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class GatheringJoinInfo{

    /** @since v975 */
	public readonly string $targetId;
    /** @since v975 */
	public readonly string $scenarioId;
    /** @since v975 */
	public readonly string $serverId;
    /** @since v924 */
	public readonly string $storeId;

    public function __construct(
		public readonly string $experienceId,
		public readonly string $experienceName,
		public readonly string $experienceWorldId,
		public readonly string $experienceWorldName,
		public readonly string $creatorId,
		string $targetId = '',
		string $scenarioId = '',
		string $serverId = '',
		string $storeId = ''
    ){
		$this->targetId = $targetId;
		$this->scenarioId = $scenarioId;
		$this->serverId = $serverId;
		$this->storeId = $storeId;
	}
}
