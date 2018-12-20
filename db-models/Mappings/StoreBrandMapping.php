<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 11:07 AM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Brand;
use DbModels\Entities\Store;
use DbModels\Repositories\StoreBrandRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class StoreBrandMapping
 * @package DbModels\Mappings
 */
class StoreBrandMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s20_stores_brands');
        $builder->setCustomRepositoryClass(StoreBrandRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createManyToOne('store', Store::class)
            ->addJoinColumn('store_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('brand', Brand::class)
            ->addJoinColumn('brand_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->addUniqueConstraint(['store_id', 'brand_id'], 'sc_uidx_store_id_clerk_id');
    }
}