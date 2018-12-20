<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:36 AM
 */

namespace DbModels\Mappings;

use DbModels\Repositories\LineRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class LineMapping
 * @package DbModels\Mappings
 */
class LineMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_lines');
        $builder->setCustomRepositoryClass(LineRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('code', 'string')->length(100)->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->addUniqueConstraint(['code'], 'lines_uidx_code');
    }
}