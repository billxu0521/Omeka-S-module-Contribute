<?php
namespace Contribute\Mvc\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class PropertyIdsByTerms extends AbstractPlugin
{
    /**
     * @var array
     */
    protected $properties;

    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Get all property ids by terms.
     *
     * @return array
     */
    public function __invoke()
    {
        return $this->properties;
    }
}
