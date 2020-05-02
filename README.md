# 🙋‍♀️ Abby

[![Latest Stable Version](https://poser.pugx.org/andreekeberg/abby/v/stable)](https://packagist.org/packages/andreekeberg/abby) [![Total Downloads](https://poser.pugx.org/andreekeberg/abby/downloads)](https://packagist.org/packages/andreekeberg/abby) [![License](https://poser.pugx.org/andreekeberg/abby/license)](https://packagist.org/packages/andreekeberg/abby)

Abby is a simple, but powerful PHP A/B testing library.

The library lets you easily setup tests (**experiments**), their control and variation **groups**, track your **users**, get detailed statistics (like recommended sample sizes, and determining the confidence of your **results**), including whether an experiment has achieved **statistical significance**.

The winner (and confidence) is detemined using [Bayesian statistics](Bayesian_statistics), calculating the [p-value](https://en.wikipedia.org/wiki/P-value) of your results to check if the [null hypothesis](http://en.wikipedia.org/wiki/Null_hypothesis) can be rejected. An accompanying minimum [sample size](https://en.wikipedia.org/wiki/Sample_size_determination) is also calculated using a [two-tailed test](https://en.wikipedia.org/wiki/One-_and_two-tailed_tests) to control the [false discovery rate](https://en.wikipedia.org/wiki/False_discovery_rate).

Abby is dependency free, and completely database agnostic, meaning it simply works with data you provide it with, and exposes a variety of methods for you to store the result in your own storage of choice.

## Requirements

- PHP 5.4.0 or higher

## Installation

```
composer require andreekeberg/abby
```

## Basic usage

### Tracking a user

```php
// Setup a new Token instance
$token = new Abby\Token();

// If we can't find an existing token cookie, generate one and set tracking cookie
if (!$token->getValue()) {
    $token->generate()->setCookie();
}

// Setup a User instance
$user = new Abby\User();

// Associate the token with our user
$user->setToken($token);
```

### Adding existing user experiments to a user instance

```php
// List of experiments associated with a tracking token
$data = [
    [
        'id' => 1,
        'group' => 1,
        'converted' => false
    ]
];

// Loop through users existing experiments and add them to our user instance
foreach ($data as $item) {
    // Setup experiment instance based on an existing experiment
    $experiment = new Abby\Experiment([
        'id' => $item['id']
    ]);

    // Setup a group instance based on stored data
    $group = new Abby\Group([
        'type' => $item['group']
    ]);

    // Add the experiment (including their group and whether they have
    // already converted) to our user instance
    $user->addExperiment($experiment, $group, $item['converted']);
}
```

### Including the using in new experiments
```php
// Experiment data
$data = [
    'id' => 2
];

// Make sure the experiment isn't already in the users list
if (!$user->hasExperiment($data['id'])) {
    // Setup a new experiment instance
    $experiment = new Abby\Experiment([
        'id' => $data['id']
    ]);

    // Assign the user to either control or variation in the experiment
    $group = $user->assignGroup($experiment);

    // Add the experiment (including assigned group) to our user instance
    $user->addExperiment($experiment, $group);
}

// Getting updated user experiment list
$user->getExperiments();

// Store updated experiment list for our user
```

### Delivering a custom experience based on group participation

```php
// Experiment data
$data = [
    'id' => 1
];

// If the user is part of the variation in our experiment
if ($user->inVariation($data['id'])) {
    // Apply a custom class to an element, load a script, etc.
}
```

### Defining a user conversion in an experiment

```php
// Experiment data
$data = [
    'id' => 1
];

// On a custom experiment goal, check if user is a participant and define a conversion
if ($user->isParticipant($data['id'])) {
    $user->setConverted($data['id']);
}

// Getting updated user experiment data
$user->getExperiments();

// Store updated data for our user
```

### Getting experiment results

```php
// Setup experiment instance with stored results
$experiment = new Abby\Experiment([
    'groups' => [
        [
            'name' => 'Control',
            'size' => 3000,
            'conversions' => 300
        ],
        [
            'name' => 'Variation',
            'size' => 3000,
            'conversions' => 364
        ]
    ]
]);

// Retrieve the results
$result = $experiment->getResult();

// Get the winner
$winner = $result->getWinner();

/**
 * Get whether we can be confident of the result (even if we haven't
 * reached the minimum group size for each variant)
 */

$confident = $result->isConfident();

/**
 * Get the minimum sample size required for each group to reach statistical
 * significance, given the control groups current conversion rate (based on
 * the configured minimumDetectableEffect)
 */

$minimum = $result->getMinimumGroupSize();

/**
 * Get whether the results are statistically significant
 */

$significant = $result->isSignificant();

/**
 * Get complete experiment result
 */

$summary = $result->getAll();
```

## Documentation

* [Experiment](docs/Experiment.md)
* [Token](docs/Token.md)
* [User](docs/User.md)
* [Group](docs/Group.md)
* [Result](docs/Result.md)

## Changelog

Refer to the [changelog](CHANGELOG.md) for a full history of the project.

## License

Abby is licensed under the [MIT license](LICENSE).