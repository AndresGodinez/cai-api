<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:48 AM
 */

namespace DbModels\Mappings;

use DbModels\Repositories\ChainStoreRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class ChainStoreMapping
 * @package DbModels\Mappings
 */
class ChainStoreMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_chain_stores');
        $builder->setCustomRepositoryClass(ChainStoreRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);
    }
}