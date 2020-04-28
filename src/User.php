<?php

namespace Abby;

/**
 * User
 */
class User
{
    private $token = null;
    private $experiments = [];

    /**
     * @param array $config
     *
     * @return void
     */
    public function __construct($config = [])
    {
        // Set token (if defined)
        if (isset($config['token'])) {
            $this->setToken($config['token']);
        }

        // Add experiments (if defined)
        if (isset($config['experiments'])) {
            foreach ($config['experiments'] as $experiment) {
                $this->addExperiment($experiment);
            }
        }
    }

    /**
     * Get the current users token
     *
     * @return Token|null
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the current users tracking token
     * 
     * If an array is passed, it will be used as configuration
     * to create a new instance of Token, and if a string is passed
     * a new Token instance will be created with this value and all
     * other configuration options set to default
     * 
     * If nothing is passed, the same as above will happen, but the
     * value will be null, and will be read from the users cookie
     * (if one exists)
     *
     * @param Token|array|string|null $token
     * 
     * @return self
     */
    public function setToken($token = null)
    {
        if (!$token instanceof Token) {
            if (!is_array($token)) {
                $token = $token ? ['value' => $token] : [];
            }

            $token = new Token($token);
        }

        $this->token = $token;

        return $this;
    }

    /**
     * Get all user experiments
     * 
     * @return array
     */
    public function getExperiments()
    {
        return $this->experiments;
    }

    /**
     * Return whether the user has an experiment in it's experiment list,
     * regardless of whether the user actually is part of it
     * 
     * @param Experiment|int $experiment Experiment instance or ID
     * 
     * @return bool
     */
    public function hasExperiment($experiment)
    {
        if ($experiment instanceof Experiment) {
            $id = $experiment->id;
        } else if (is_int($experiment)) {
            $id = $experiment;
        } else {
            throw new \Exception(
                'Invalid $experiment (type must be Abby\Experiment or int)'
            );
        }

        foreach ($this->experiments as $item) {
            if ($item->id == $id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return whether the user is a participant of an experiment (belongs to
     * either of the groups), and if passed, part of a specific group
     * 
     * @param Experiment|int $experiment Experiment instance or ID
     * @param int|null $group Group type (0 or 1)
     * 
     * @return bool
     */
    public function isParticipant($experiment, $group = null)
    {
        if ($experiment instanceof Experiment) {
            $id = $experiment->id;
        } else if (is_int($experiment)) {
            $id = $experiment;
        } else {
            throw new \Exception(
                'Invalid $experiment (type must be Abby\Experiment or int)'
            );
        }

        foreach ($this->experiments as $item) {
            if ($item->id == $id) {
                if ($group === null && $item->group !== null) {
                    return true;
                } else if ($group !== null && $item->group === $group) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Return whether the user belongs to the control group of an experiment
     * 
     * @param Experiment|int $experiment Experiment instance or ID
     * 
     * @return bool
     */
    public function inControl($experiment)
    {
        return $this->isParticipant($experiment, 0);
    }

    /**
     * Return whether the user belongs to the variation group of an experiment
     * 
     * @param Experiment|int $experiment Experiment instance or ID
     * 
     * @return bool
     */
    public function inVariation($experiment)
    {
        return $this->isParticipant($experiment, 1);
    }

    /**
     * Add an experiment to the user's list of experiments
     * 
     * If no group is set, the experiment is added to to list without the user being assigned a group
     * 
     * @param Experiment $experiment
     * @param Group|null $group
     * @param bool $converted
     * 
     * @return self
     */
    public function addExperiment(Experiment $experiment, $group = null, $converted = false)
    {
        // Setup user experiment array
        $userExperiment = (object)[
            'id' => $experiment->getID()
        ];

        // Add group type if a group is set
        $userExperiment->group = $group ? $group->getType() : null;

        // Only set converted value if the user is part of an experiment group
        if ($group) {
            $userExperiment->converted = $converted;
        }

        // Add to list of experiments
        $this->experiments[] = $userExperiment;

        return $this;
    }

    /**
     * Determine is user should be a participant in an experiment, based on the
     * experiments configured percentual coverage
     * 
     * @param Experiment $experiment
     * 
     * @return bool
     */
    public function shouldParticipate(Experiment $experiment)
    {
        // Get experiments percentual coverage
        $coverage = $experiment->getCoverage();

        // Return true if coverage is 100%
        if ($coverage == 100) {
            return true;
        }

        // Create an array of a 100 positive and negative numbers, based
        // on the value of $coverage
        $slots = str_split(
            str_repeat(1, $coverage) . str_repeat(0, 100 - $coverage)
        );

        // Shuffle all the slots
        shuffle($slots);

        // Return whether the randomly selected slot is a positive number
        return $slots[mt_rand(0, 99)];
    }

    /**
     * Get a group that the used should be asssiged to, either the control
     * or variation (with a 50/50 chance)
     * 
     * If the experiments coverage is below 100, its percentage value will be 
     * used to determine if the user is assigned an experiment group at all
     * 
     * @param Experiment $experiment
     * 
     * @return int|null
     */
    public function assignGroup(Experiment $experiment)
    {
        if ($this->shouldParticipate($experiment)) {
            // If the user is selected, randomly choose either group
            return $experiment->getGroup(mt_rand(0, 1));
        } else {
            // Otherwise return no group
            return null;
        }
    }

    /**
     * Get whether a user has converted in a specific experiment
     * 
     * @param int $id Experiment ID
     * 
     * @return bool
     */
    public function hasConverted($id)
    {
        foreach ($this->experiments as $i => $experiment) {
            if ($experiment->id == $id) {
                if ($this->experiments[$i]->converted) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set whether a user has converted in a specific experiment
     * 
     * @param int $id Experiment ID
     * @param bool $converted
     * 
     * @return self
     */
    public function setConverted($id, $converted = true)
    {
        foreach ($this->experiments as $i => $experiment) {
            if ($experiment->id == $id) {
                $this->experiments[$i]->converted = $converted;
            }
        }

        return $this;
    }
}