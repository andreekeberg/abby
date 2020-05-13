<?php

namespace Abby;

class Experiment
{
    private $id = null;
    private $name = null;
    private $allocation = 100;
    private $groups = [];
    private $defaultGroups = [
        [
            'type' => 0,
            'name' => 'control'
        ],
        [
            'type' => 1,
            'name' => 'variation'
        ]
    ];

    /**
     * @param array $config
     *
     * @return void
     */
    public function __construct($config = [])
    {
        // Merge groups (if defined) with defaults
        if (isset($config['groups']) && is_array($config['groups'])) {
            for ($i = 0; $i <= 1; $i++) {
                if (isset($config['groups'][$i])) {
                    $this->setGroup($i, $config['groups'][$i]);
                }
            }
        }

        // If not both groups are defined, set them to defaults
        for ($i = 0; $i <= 1; $i++) {
            if (!$this->getGroup($i)) {
                $this->setGroup($i, $this->defaultGroups[$i]);
            }
        }

        // Set ID (if defined)
        if (isset($config['id'])) {
            $this->setID($config['id']);
        }

        // Set name (if defined)
        if (isset($config['name'])) {
            $this->setName($config['name']);
        }

        // Set allocation (if defined)
        if (isset($config['allocation'])) {
            $this->setAllocation($config['allocation']);
        }
    }

    /**
     * Get experiment ID
     *
     * @return mixed|null
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Set experiment ID
     *
     * @param mixed $id
     * 
     * @return self
     */
    public function setID($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get experiment name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set experiment name
     *
     * @param string $name
     * 
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Map group names to their respective index
     * 
     * @param int|string $key
     * 
     * @return int
     */
    private function mapGroup($key)
    {
        if (is_string($key)) {
            $index = false;

            foreach ($this->groups as $i => $group) {
                if ($group->getName() == $key) {
                    $index = $i;
                }
            }

            if ($index === false) {
                throw new \Exception('Undefined group "' . $key . '"');
            }

            return $index;
        }

        return $key;
    }

    /**
     * Get both groups
     * 
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Get a specific group
     * 
     * @param int|string $key
     * 
     * @return Group
     */
    public function getGroup($key)
    {
        // Convert group name to index
        $key = $this->mapGroup($key);

        // Get specified group
        return $this->groups[$key] ?? null;
    }

    /**
     * Define a group
     * 
     * @param int|string $key
     * @param Group|array|object $group
     * 
     * @return self
     */
    public function setGroup($key, $group)
    {
        // Convert group name to index
        $key = $this->mapGroup($key);

        // Make group an instance of Group if it isn't already
        if (!$group instanceof Group) {
            $group = new Group($group);
        }

        // Set default name if none is defined
        if ($group->getName() === null) {
            $group->setName($this->defaultGroups[$key]['name']);
        }

        // Set default type if none is defined
        if ($group->getType() === null) {
            $group->setType($this->defaultGroups[$key]['type']);
        }

        $this->groups[$key] = $group;

        return $this;
    }

    /**
     * Get the control
     * 
     * @return Group
     */
    public function getControl()
    {
        return $this->getGroup(0);
    }

    /**
     * Define the control
     * 
     * @param Group|array|object $group
     * 
     * @return self
     */
    public function setControl($group)
    {
        return $this->setGroup(0, $group);
    }

    /**
     * Get the variation
     * 
     * @return Group
     */
    public function getVariation()
    {
        return $this->getGroup(1);
    }

    /**
     * Define the variation
     * 
     * @param Group|array|object $group
     * 
     * @return self
     */
    public function setVariation($group)
    {
        return $this->setGroup(1, $group);
    }

    /**
     * Get experiment allocation
     *
     * @return int
     */
    public function getAllocation()
    {
        return $this->allocation;
    }

    /**
     * Set experiment allocation
     * 
     * This is the percentual chance that a new user will be included in the experiment
     *
     * @param int $percent
     * 
     * @return self
     */
    public function setAllocation($percent)
    {
        if ($percent < 0 || $percent > 100) {
            throw new \Exception('Invalid $percent (value must be between 0 and 100)');
        }

        $this->allocation = round($percent);

        return $this;
    }

    /**
     * Return a Result instance from the current experiment
     *
     * @return Result
     */
    public function getResult()
    {
        return new Result($this);
    }
}