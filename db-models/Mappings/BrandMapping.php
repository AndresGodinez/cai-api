<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:45 AM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Line;
use DbModels\Repositories\BrandRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class BrandMapping
 * @package DbModels\Mappings
 */
class BrandMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_brands');
        $builder->setCustomRepositoryClass(BrandRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('code', 'string')->length(100)->build();

        $builder->createManyToOne('line', Line::class)
            ->addJoinColumn('line_id', 'id')
            ->cascadeAll()
            ->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->addUniqueConstraint(['code', 'line_id'], 'brands_uidx_code_line_id');
        $builder->addIndex(['line_id'], 'brands_idx_line_id');
    }
}