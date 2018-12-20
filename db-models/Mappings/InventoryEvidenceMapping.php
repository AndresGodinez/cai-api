<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 01:07 PM
 */

namespace DbModels\Mappings;

use DbModels\Entities\Brand;
use DbModels\Entities\Clerk;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\InventoryEvidencePhoto;
use DbModels\Entities\Store;
use DbModels\Entities\User;
use DbModels\Repositories\InventoryEvidenceRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class InventoryEvidenceMapping
 * @package DbModels\Mappings
 */
class InventoryEvidenceMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s30_inventory_evidences');
        $builder->setCustomRepositoryClass(InventoryEvidenceRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('code', 'string')->length(255)->build();

        $builder->createManyToOne('store', Store::class)
            ->addJoinColumn('store_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('brand', Brand::class)
            ->addJoinColumn('brand_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('furnitureType', FurnitureType::class)
            ->addJoinColumn('furniture_type_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('clerk', Clerk::class)
            ->addJoinColumn('clerk_id', 'id')
            ->cascadeAll()
            ->build();

        $builder->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id')
            ->cascadeAll()
            ->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->createOneToMany('photos', InventoryEvidencePhoto::class)
            ->mappedBy('inventoryEvidence')
            ->cascadeAll()
            ->build();

        $builder->addUniqueConstraint(['code'], 'ie_uidx_code');
        $builder->addIndex(['store_id'], 'ie_idx_store_id');
        $builder->addIndex(['brand_id'], 'ie_idx_brand_id');
        $builder->addIndex(['furniture_type_id'], 'ie_idx_furniture_type_id');
        $builder->addIndex(['clerk_id'], 'ie_idx_clerk_id');
        $builder->addIndex(['user_id'], 'ie_idx_user_id');
    }
}