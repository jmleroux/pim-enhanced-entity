<?php

namespace Akeneo\Bundle\EnhancedEntityBundle\Entity;

class Category extends \Pim\Bundle\CatalogBundle\Entity\Category
{
    /** @var EnhancedCategory */
    protected $enhancedCategory;

    /**
     * @return EnhancedCategory
     */
    public function getEnhancedCategory()
    {
        return $this->enhancedCategory;
    }

    /**
     * @param EnhancedCategory $enhancedCategory
     */
    public function setEnhancedCategory($enhancedCategory)
    {
        $this->enhancedCategory = $enhancedCategory;
    }
}
