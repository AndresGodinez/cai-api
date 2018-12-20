<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:04 PM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Clerk;
use DbModels\Entities\Store;
use DbModels\Repositories\StoreClerkRepository;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class StoreClerkMapping
 * @package DbModels\Mappings
 */
class StoreClerkMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s20_stores_clerks');
        $builder->setCustomRepositoryClass(StoreClerkRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createManyToOne('store', Store::class)
            ->addJoinColumn('store_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('clerk', Clerk::class)
            ->addJoinColumn('clerk_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->addUniqueConstraint(['store_id', 'clerk_id'], 'sc_uidx_store_id_clerk_id');
    }
}