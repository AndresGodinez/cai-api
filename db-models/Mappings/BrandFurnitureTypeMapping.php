<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 6/01/19
 * Time: 01:48 PM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Brand;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\Store;
use DbModels\Repositories\BrandFurnitureTypeRepository;
use DbModels\Repositories\StoreBrandRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BrandFurnitureTypeMapping
 * @package DbModels\Mappings
 */
class BrandFurnitureTypeMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s20_brands_furniture_types');
        $builder->setCustomRepositoryClass(BrandFurnitureTypeRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createManyToOne('brand', Brand::class)
            ->addJoinColumn('brand_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('furnitureType', FurnitureType::class)
            ->addJoinColumn('furniture_type_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->addIndex(['brand_id'], 'bft_idx_brand_id');
        $builder->addIndex(['furniture_type_id'], 'bft_idx_furniture_type_id');
        $builder->addUniqueConstraint(['brand_id', 'furniture_type_id'], 'bft_uidx_brand_id_furniture_type_id');
    }
}