<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Entity;

use Akeneo\Component\Classification\Model\CategoryInterface;

class EnhancedCategory
{
    /** @var int */
    protected $id;

    /** @var CategoryInterface */
    protected $category;

    /** @var string */
    protected $description;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return CategoryInterface
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param CategoryInterface $category
     */
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}
