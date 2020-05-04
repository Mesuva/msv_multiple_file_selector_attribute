<?php
namespace Concrete\Package\MsvMultipleFileSelectorAttribute\Entity\Attribute\Key\Settings;

use Concrete\Core\Entity\Attribute\Key\Settings\Settings;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultipleFileSelectorSettings")
 */
class MultipleFileSelectorSettings extends Settings
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $akType = '';

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $akMaxItems = '';

    /**
     * @return string
     */
    public function getType()
    {
        return $this->akType;
    }

    /**
     * @param string $akType
     */
    public function setType($akType)
    {
        $this->akType = $akType;
    }

    /**
     * @return string
     */
    public function getMaxItems()
    {
        return $this->akMaxItems;
    }

    /**
     * @param string $akMaxItems
     */
    public function setMaxItems($akMaxItems)
    {
        $this->akMaxItems = $akMaxItems;
    }
}
