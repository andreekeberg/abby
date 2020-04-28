# User

This class is in charge of managing your users, including associating them with tracking tokens, adding them to groups and controlling their experiment participation, and handling when they have reached a conversion goal.

| Name | Description |
|------|-------------|
|[getToken](#usergettoken)|Get the current user's token|
|[setToken](#usersettoken)|Set the current user's tracking token|
|[getExperiments](#usergetexperiments)|Get all user experiments|
|[hasExperiment](#userhasexperiment)|Return whether the user has an experiment in the list|
|[isParticipant](#userisparticipant)|Return whether the user is a participant of an experiment, and optionally, part of a specific group|
|[inControl](#userincontrol)|RReturn whether the user belongs to the control group of an experiment|
|[inVariation](#userinvariation)|Return whether the user belongs to the variation group of an experiment|
|[addExperiment](#useraddexperiment)|Add an experiment to the user's list of experiments|
|[shouldParticipate](#usershouldparticipate)|Determine is user should be a participant in an experiment|
|[assignGroup](#userassigngroup)|Get a group that the user should be asssiged to|
|[hasConverted](#userhasconverted)|Get whether a user has converted in a specific experiment|
|[setConverted](#usersetconverted)|Set whether a user has converted in a specific experiment|

## User::getToken  

**Description**

```php
public getToken (void)
```

Get the current users token 

**Parameters**

`This function has no parameters.`

**Return Values**

`Token|null`

<hr />

## User::setToken  

**Description**

```php
public setToken (Token|array|string|null $token)
```

Set the current users tracking token 

If an array is passed, it will be used as configuration to create a new instance of Token, and if a string is passed a new Token instance will be created with this value, and all other configuration options set to default  
  
If nothing is passed, the same as above will happen, but the value will be null, and will be read from the users cookie (if one exists)

**Parameters**

* `(Token|array|string|null) $token`

**Return Values**

`self`

<hr />

## User::getExperiments  

**Description**

```php
public getExperiments (void)
```

Get all user experiments 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`

<hr />

## User::hasExperiment  

**Description**

```php
public hasExperiment (Experiment|int $experiment)
```

Return whether the user has an experiment in the list, regardless of whether the user actually is part of it 

**Parameters**

* `(Experiment|int) $experiment`
: Experiment instance or ID  

**Return Values**

`bool`

<hr />

## User::isParticipant  

**Description**

```php
public isParticipant (Experiment|int $experiment, int|null $group)
```

Return whether the user is a participant of an experiment, and optionally, part of a specific group

**Parameters**

* `(Experiment|int) $experiment`
: Experiment instance or ID  
* `(int|null) $group`
: Group type (0 or 1)  

**Return Values**

`bool`

<hr />

## User::inControl  

**Description**

```php
public inControl (Experiment|int $experiment)
```

Return whether the user belongs to the control group of an experiment

**Parameters**

* `(Experiment|int) $experiment`
: Experiment instance or ID  

**Return Values**

`bool`

<hr />

## User::inVariation  

**Description**

```php
public inVariation (Experiment|int $experiment)
```

Return whether the user belongs to the variation group of an experiment

**Parameters**

* `(Experiment|int) $experiment`
: Experiment instance or ID  

**Return Values**

`bool`

<hr />

## User::addExperiment  

**Description**

```php
public addExperiment (Experiment $experiment, Group|null $group, bool $converted)
```

Add an experiment to the users list of experiments 

If no group is set, the experiment is added to to list without the user being assigned a group

**Parameters**

* `(Experiment) $experiment`
* `(Group|null) $group`
* `(bool) $converted`

**Return Values**

`self`

<hr />

## User::shouldParticipate  

**Description**

```php
public shouldParticipate (Experiment $experiment)
```

Determine is user should be a participant in an experiment, based on the experiments configured percentual coverage 

**Parameters**

* `(Experiment) $experiment`

**Return Values**

`bool`

<hr />

## User::assignGroup  

**Description**

```php
public assignGroup (Experiment $experiment)
```

Get a group that the user should be asssiged to, either the control or variation (with a 50/50 chance) 

If the experiments coverage is below 100, it's percentage value will be used to determine if the user is assigned an experiment group at all

**Parameters**

* `(Experiment) $experiment`

**Return Values**

`int|null`

<hr />

## User::hasConverted  

**Description**

```php
public hasConverted (int $id)
```

Get whether a user has converted in a specific experiment 

**Parameters**

* `(int) $id`
: Experiment ID  

**Return Values**

`bool`

<hr />

## User::setConverted  

**Description**

```php
public setConverted (int $id, bool $converted)
```

Set whether a user has converted in a specific experiment 

**Parameters**

* `(int) $id`
: Experiment ID  
* `(bool) $converted`

**Return Values**

`self`

<hr />