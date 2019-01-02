<?php
/**
 * Created by IntelliJ IDEA.
 * User: alberto
 * Date: 27/12/18
 * Time: 11:18 AM
 */

namespace App\Data\Requests;

use App\Exceptions\ValidationException;
use App\Interfaces\ExportableEntityRequestDataInterface;
use App\Interfaces\ValidatableRequestDataInterface;
use DbModels\Consts\DefaultEntityRegStatus;
use DbModels\Entities\Brand;
use DbModels\Entities\Clerk;
use DbModels\Entities\FurnitureType;
use DbModels\Entities\InventoryCode;
use DbModels\Entities\InventoryEvidence;
use DbModels\Entities\Store;
use DbModels\Repositories\InventoryCodeRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class InventoryEvidenceCreateRequestData
 * @package App\Data\Requests
 */
class InventoryEvidenceCreateRequestData implements ValidatableRequestDataInterface, ExportableEntityRequestDataInterface
{
    /** @var EntityManagerInterface */
    protected $em;
    
    /** @var string */
    protected $code;
    
    /** @var null|string */
    protected $comments;

    /** @var int */
    protected $storeId;

    /** @var int */
    protected $brandId;

    /** @var int */
    protected $furnitureTypeId;
    
    /** @var int */
    protected $clerkId;

    /**
     * @param EntityManagerInterface $em
     */
    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @param null|string $comments
     */
    public function setComments(?string $comments): void
    {
        $this->comments = $comments;
    }

    /**
     * @param int $storeId
     */
    public function setStoreId(int $storeId): void
    {
        $this->storeId = $storeId;
    }

    /**
     * @param int $brandId
     */
    public function setBrandId(int $brandId): void
    {
        $this->brandId = $brandId;
    }

    /**
     * @param int $furnitureTypeId
     */
    public function setFurnitureTypeId(int $furnitureTypeId): void
    {
        $this->furnitureTypeId = $furnitureTypeId;
    }

    /**
     * @param int $clerkId
     */
    public function setClerkId(int $clerkId): void
    {
        $this->clerkId = $clerkId;
    }

    /**
     * @return object
     */
    public function exportEntity(): object
    {
        /** @var Store $store */
        $store = $this->em->find(Store::class, $this->storeId);

        /** @var Brand $brand */
        $brand = $this->em->find(Brand::class, $this->brandId);

        /** @var FurnitureType $furnitureType */
        $furnitureType = $this->em->find(FurnitureType::class, $this->furnitureTypeId);

        /** @var Clerk $clerk */
        $clerk = $this->em->find(Clerk::class, $this->clerkId);

        $inst = new InventoryEvidence();

        $inst->setCode($this->code);
        $inst->setComments($this->comments);
        $inst->setStore($store);
        $inst->setBrand($brand);
        $inst->setFurnitureType($furnitureType);
        $inst->setClerk($clerk);

        return $inst;
    }

    public function validate()
    {
        if (!$this->code) {
            throw new ValidationException("El código es inválido");
        }
        
        if (!$this->storeId) {
            throw new ValidationException("La tienda es inválida");
        }
        
        /** @var Store $store */
        $store = $this->em->find(Store::class, $this->storeId);
        
        if (!$store || $store->getRegStatus() !== DefaultEntityRegStatus::ACTIVE) {
            throw new ValidationException("La tienda es inválida");
        }
        
        if (!$this->brandId) {
            throw new ValidationException("La marca es inválida");
        }

        /** @var Brand $brand */
        $brand = $this->em->find(Brand::class, $this->brandId);

        if (!$brand || $brand->getRegStatus() !== DefaultEntityRegStatus::ACTIVE) {
            throw new ValidationException("La marca es inválida");
        }
        
        if (!$this->furnitureTypeId) {
            throw new ValidationException("El tipo de mueble es inválido");
        }

        /** @var FurnitureType $furnitureType */
        $furnitureType = $this->em->find(FurnitureType::class, $this->furnitureTypeId);

        if (!$furnitureType || $furnitureType->getRegStatus() !== DefaultEntityRegStatus::ACTIVE) {
            throw new ValidationException("El tipo de mueble es inválido");
        }
        
        if (!$this->clerkId) {
            throw new ValidationException("El capturista es inválido");
        }

        /** @var Clerk $clerk */
        $clerk = $this->em->find(Clerk::class, $this->clerkId);

        if (!$clerk || $clerk->getRegStatus() !== DefaultEntityRegStatus::ACTIVE) {
            throw new ValidationException("El capturista es inválido");
        }

        // validate code structure

        $line = $brand->getLine();
        $expectedCode = $line->getCode() . $brand->getCode();
        $expectedCodeRx = '/^' . $expectedCode . '[0-4][0-9]{3}$/i';

        if (!\preg_match($expectedCodeRx, $this->code)) {
            throw new ValidationException("El código no cumple con el formato esperado.");
        }

        /** @var InventoryCodeRepository $inventoryCodeRepo */
        $inventoryCodeRepo = $this->em->getRepository(InventoryCode::class);

        $inventoryCode = $inventoryCodeRepo->findBy(['code' => $this->code]);

        if (!$inventoryCode) {
            throw new ValidationException("El código es inválido.");
        }
    }
}