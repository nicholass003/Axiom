<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Camera;

class CameraAimAssistCategory{

    /** 
     * @since v898
     * @var int[] $blockTags
     */
    public readonly array $blockTags;

    /** 
     * @since v924
     * @var int[] $entityTypeFamilies
     */
    public readonly array $entityTypeFamilies;

    /**
     * @param list<CameraAimAssistCategoryPriority> $entities
     * @param list<CameraAimAssistCategoryPriority> $blocks
     * @param list<CameraAimAssistCategoryPriority> $blockTags
     * @param list<CameraAimAssistCategoryPriority> $entityTypeFamilies
     */
    public function __construct(
        public readonly string $name,
        public readonly array $entities,
        public readonly array $blocks,
        array $blockTags = [],
        array $entityTypeFamilies = [],
        public readonly ?int $defaultEntityPriority = null,
        public readonly ?int $defaultBlockPriority = null
    ){
        $this->blockTags = $blockTags;
        $this->entityTypeFamilies = $entityTypeFamilies;
    }
}
