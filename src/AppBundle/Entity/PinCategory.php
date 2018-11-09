<?php

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Annotation\LoggableTableTitleAnnotation;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * PinCategory
 *
 * @ORM\Table(name="pin_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PinCategoryRepository")
 *
 * @UniqueEntity("sysname")
 *
 * @ApiResource
 *
 * @Gedmo\Loggable(logEntryClass="AppBundle\Entity\LogEntry")
 * @LoggableTableTitleAnnotation(title="Категории пинов")
 */
class PinCategory
{

    public const CATEGORY_BANNER = 'banner';

    public const CATEGORY_CATALOG = 'catalog';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({
     *     "federal-hotel-pin_GET",
     *     "local-hotel-pin_GET",
     *     "preset-pin_GET",
     * })
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="sysname", type="string", nullable=false, unique=true)
     *
     * @Groups({
     *     "federal-hotel-pin_GET",
     *     "local-hotel-pin_GET",
     *     "preset-pin_GET",
     * })
     */
    private $sysname;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", nullable=true)
     *
     * @Groups({
     *     "federal-hotel-pin_GET",
     *     "local-hotel-pin_GET",
     *     "preset-pin_GET",
     * })
     */
    private $description;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false)
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->createdAt = new \DateTime('now');
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set sysname.
     *
     * @param string $sysname
     *
     * @return PinCategory
     */
    public function setSysname($sysname)
    {
        $this->sysname = $sysname;

        return $this;
    }

    /**
     * Get sysname.
     *
     * @return string
     */
    public function getSysname()
    {
        return $this->sysname;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return PinCategory
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return PinCategory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set isActive.
     *
     * @param bool $isActive
     *
     * @return PinCategory
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive.
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
