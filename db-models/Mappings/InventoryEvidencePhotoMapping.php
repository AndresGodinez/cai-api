<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:36 PM
 */

namespace DbModels\Mappings;

use DbModels\Entities\InventoryEvidence;
use DbModels\Repositories\InventoryEvidencePhotoRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryEvidencePhotoMapping
 * @package DbModels\Mappings
 */
class InventoryEvidencePhotoMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s30_inventory_evidence_photos');
        $builder->setCustomRepositoryClass(InventoryEvidencePhotoRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('filePath', 'string')->columnName('file_path')->nullable()->build();
        $builder->createField('type', 'smallint')->length(4)->build();

        $builder->createManyToOne('inventoryEvidence', InventoryEvidence::class)
            ->addJoinColumn('inventory_evidence_id', 'id')
            ->cascadeAll()
            ->build();
    }
}