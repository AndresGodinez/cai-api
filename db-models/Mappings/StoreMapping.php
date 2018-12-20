<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:52 AM
 */

namespace DbModels\Mappings;

use DbModels\Entities\ChainStore;
use DbModels\Entities\State;
use DbModels\Repositories\StoreRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class StoreMapping
 * @package DbModels\Mappings
 */
class StoreMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s10_stores');
        $builder->setCustomRepositoryClass(StoreRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('cityName', 'string')->columnName('city_name')->length(255)->option('default', '')->build();
        $builder->createField('address', 'string')->option('default', '')->build();
        $builder->createField('postalCode', 'string')->columnName('postal_code')->length(30)->nullable()->build();
        $builder->createField('schedule', 'string')->length(50)->nullable()->build();
        $builder->createField('type', 'string')->length(50)->nullable()->build();

        $builder->createManyToOne('state', State::class)
            ->addJoinColumn('state_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('chainStore', ChainStore::class)
            ->addJoinColumn('chain_store_id', 'id')
            ->cascadeAll()
            ->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->addIndex(['type'], 'stores_idx_type');
        $builder->addIndex(['state_id'], 'stores_idx_state_id');
        $builder->addIndex(['chain_store_id'], 'stores_idx_chain_store_id');
        $builder->addIndex(['city_name'], 'stores_idx_city_name');
    }
}