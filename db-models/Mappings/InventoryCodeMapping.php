<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 2/01/19
 * Time: 05:11 PM
 */

namespace DbModels\Mappings;

use DbModels\Repositories\InventoryCodeRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryCodeMapping
 * @package DbModels\Mappings
 */
class InventoryCodeMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s30_inventory_codes');
        $builder->setCustomRepositoryClass(InventoryCodeRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('code', 'string')->length(8)->build();

        $builder->addUniqueConstraint(['code'], 'inventory_codes_uidx_code');
    }
}