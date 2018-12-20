<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:06 AM
 */

namespace DbModels\Mappings;

use DbModels\Repositories\ClerkRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class ClerkMapping
 * @package DbModels\Mappings
 */
class ClerkMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_clerks');
        $builder->setCustomRepositoryClass(ClerkRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('code', 'string')->length(100)->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->addUniqueConstraint(['code'], 'clerks_uidx_code');
    }
}