<?php

namespace Abby;

/**
 * Group
 */
class Group
{
    private $group;

    /**
     * @param array $group
     *
     * @return void
     */
    public function __construct($group = []) {
        $this->group = array_merge([
            'type' => null,
            'name' => null,
            'views' => 0,
            'conversions' => 0,
            'winner' => null
        ], (array)$group);
    }

    /**
     * Get all values for the group
     * 
     * @return object
     */
    public function getValues()
    {
        $values = array_merge($this->group, [
            'conversionRate' => $this->getConversionRate()
        ]);

        return (object)$values;
    }

    /**
     * Get property value of group
     * 
     * @param int|string $property
     * 
     * @return mixed
     */
    public function getValue($property)
    {
        return $this->group[$property];
    }

    /**
     * Set property value of group
     * 
     * @param string $property
     * @param mixed $value
     * 
     * @return self
     */
    public function setValue($property, $value)
    {
        // Set new value
        $this->group[$property] = $value;

        // Return self
        return $this;
    }

    /**
     * Get group name
     * 
     * @return null|string
     */
    public function getName()
    {
        return $this->getValue('name');
    }

    /**
     * Set group name
     * 
     * @param string $name
     * 
     * @return self
     */
    public function setName($name)
    {
        return $this->setValue('name', $name);
    }

    /**
     * Get group views
     * 
     * @return int
     */
    public function getViews()
    {
        return $this->getValue('views');
    }

    /**
     * Set group views
     * 
     * @param int $views
     * 
     * @return self
     */
    public function setViews($views)
    {
        return $this->setValue('views', $views);
    }

    /**
     * Get number of conversions for the group
     * 
     * @return int
     */
    public function getConversions()
    {
        return $this->getValue('conversions');
    }

    /**
     * Set number of conversions for the group
     * 
     * @param int $conversions
     * 
     * @return self
     */
    public function setConversions($conversions)
    {
        return $this->setValue('conversions', $conversions);
    }

    /**
     * Get conversion rate for the group
     * 
     * @return float
     */
    public function getConversionRate()
    {
        $views = $this->getViews();
        $conversions = $this->getConversions();

        if (!$views || !$conversions) {
            return 0;
        }

        return $conversions / $views;
    }

    /**
     * Get whether the group is the winner
     * 
     * @return bool
     */
    public function isWinner()
    {
        return $this->getValue('winner') === true;
    }

    /**
     * Define the group as the winner
     * 
     * @return self
     */
    public function setWinner()
    {
        return $this->setValue('winner', true);
    }

    /**
     * Get whether the group is the loser
     * 
     * @return bool
     */
    public function isLoser()
    {
        return $this->getValue('winner') === false;
    }

    /**
     * Define the group as the loser
     * 
     * @return self
     */
    public function setLoser()
    {
        return $this->setValue('winner', false);
    }

    /**
     * Get group type
     * 
     * Returns 0 for control, 1 for variation and null when type is unknown
     * 
     * @return int|null
     */
    public function getType()
    {
        return $this->getValue('type');
    }

    /**
     * Get whether the variation is a specific type
     * 
     * @param int $type
     * 
     * @return bool
     */
    public function isType(int $type)
    {
        return $this->getType() === $type;
    }

    /**
     * Set group type
     * 
     * @param int $type
     * 
     * @return self
     */
    public function setType(int $type)
    {
        return $this->setValue('type', $type);
    }

    /**
     * Get whether the group is the control
     * 
     * @return bool
     */
    public function isControl()
    {
        return $this->isType(0);
    }

    /**
     * Define the group as the control
     * 
     * @return self
     */
    public function setControl()
    {
        return $this->setType(0);
    }

    /**
     * Get whether the group is the variation
     * 
     * @return bool
     */
    public function isVariation()
    {
        return $this->isType(1);
    }

    /**
     * Define the group as the variation
     * 
     * @return self
     */
    public function setVariation()
    {
        return $this->setType(1);
    }
}