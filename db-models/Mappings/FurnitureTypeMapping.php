<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:30 AM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Brand;
use DbModels\Repositories\FurnitureTypeRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class FurnitureTypeMapping
 * @package DbModels\Mappings
 */
class FurnitureTypeMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_furniture_types');
        $builder->setCustomRepositoryClass(FurnitureTypeRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('description', 'string')->nullable()->build();

        $builder->createManyToOne('brand', Brand::class)
            ->addJoinColumn('brand_id', 'id')
            ->cascadeAll()
            ->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);
    }
}