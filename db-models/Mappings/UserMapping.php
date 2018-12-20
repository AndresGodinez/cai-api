<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 20/12/18
 * Time: 10:19 AM
 */

namespace DbModels\Mappings;

use DbModels\Consts\UserType;
use DbModels\Entities\Clerk;
use DbModels\Repositories\UserRepository;
use DbModels\Utils\ClassMetadataUtils;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class UserMapping
 * @package DbModels\Mappings
 */
class UserMapping
{
    /**
     * @param ClassMetadata $metadata
     */
    public function __invoke(ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('s00_users');
        $builder->setCustomRepositoryClass(UserRepository::class);

        $builder->createField('id', 'bigint')->makePrimaryKey()->generatedValue()->build();

        $builder->createField('name', 'string')->length(255)->build();
        $builder->createField('username', 'string')->length(100)->build();
        $builder->createField('pswd', 'string')->nullable()->build();
        $builder->createField('type', 'smallint')->length(4)->option('default', UserType::UNKNOWN)->build();

        $builder->createManyToOne('clerk', Clerk::class)
            ->addJoinColumn('clerk_id', 'id')
            ->cascadeAll()
            ->build();

        ClassMetadataUtils::poblateMetadataWithBaseEntityFields($builder);

        $builder->addIndex(['clerk_id'], 'users_idx_clerk_id');
    }
}