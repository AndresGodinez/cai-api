<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 29/11/18
 * Time: 04:39 PM
 */

namespace DbModels\Utils;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;

/**
 * Class ClassMetadataUtils
 * @package DbModels\Utils
 */
class ClassMetadataUtils
{
    /**
     * @param ClassMetadataBuilder $builder
     */
    public static function poblateMetadataWithBaseEntityFields(ClassMetadataBuilder &$builder)
    {
        $builder->createField('regCreatedDt', 'datetime')
            ->columnName('reg_created_dt')
            ->nullable()
            ->build();

        $builder->createField('regUpdatedDt', 'datetime')
            ->columnName('reg_updated_dt')
            ->nullable()
            ->build();

        $builder->createField('regStatus', 'integer')
            ->columnName('reg_status')
            ->option('default', 1)
            ->build();
    }
}