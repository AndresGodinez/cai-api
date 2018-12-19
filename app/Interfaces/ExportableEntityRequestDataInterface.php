<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 12/12/18
 * Time: 09:31 AM
 */

namespace App\Interfaces;

/**
 * Interface ExportableEntityRequestDataInterface
 * @package App\Interfaces
 */
interface ExportableEntityRequestDataInterface
{
    /**
     * @return object
     */
    public function exportEntity(): object;
}