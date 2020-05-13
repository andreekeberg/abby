# Experiment

This class is in charge of managing your experiment, including configuring the name, identifier, optionally limiting the percentual amount of visitors to include, defining and handling their control and variant groups, and returning your results.

| Name | Description |
|------|-------------|
|[getID](#experimentgetid)|Get experiment ID|
|[setID](#experimentsetid)|Set experiment ID|
|[getName](#experimentgetname)|Get experiment name|
|[setName](#experimentsetname)|Set experiment name|
|[getGroups](#experimentgetgroups)|Get both groups|
|[getGroup](#experimentgetgroup)|Get a specific group|
|[setGroup](#experimentsetgroup)|Define a group|
|[getControl](#experimentgetcontrol)|Get the control|
|[setControl](#experimentsetcontrol)|Define the control|
|[getVariation](#experimentgetvariation)|Get the variation|
|[setVariation](#experimentsetvariation)|Define the variation|
|[getAllocation](#experimentgetallocation)|Get experiment allocation|
|[setAllocation](#experimentsetallocation)|Set experiment allocation|
|[getResult](#experimentgetresult)|Return a Result instance from the current experiment|

## Experiment::getID  

**Description**

```php
public getID (void)
```

Get experiment ID 

**Parameters**

`This function has no parameters.`

**Return Values**

`mixed|null`

<hr />

## Experiment::setID  

**Description**

```php
public setID (mixed $id)
```

Set experiment ID 

**Parameters**

* `(mixed) $id`

**Return Values**

`self`

<hr />

## Experiment::getName  

**Description**

```php
public getName (void)
```

Get experiment name 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

<hr />

## Experiment::setName  

**Description**

```php
public setName (string $name)
```

Set experiment name 

**Parameters**

* `(string) $name`

**Return Values**

`self`

<hr />

## Experiment::getGroups  

**Description**

```php
public getGroups (void)
```

Get both groups 

**Parameters**

`This function has no parameters.`

**Return Values**

`array`

<hr />

## Experiment::getGroup  

**Description**

```php
public getGroup (int|string $key)
```

Get a specific group 

**Parameters**

* `(int|string) $key`

**Return Values**

`Group`

<hr />

## Experiment::setGroup  

**Description**

```php
public setGroup (int|string $key, Group|array|object $group)
```

Define a group 

**Parameters**

* `(int|string) $key`
* `(Group|array|object) $group`

**Return Values**

`self`

<hr />

## Experiment::getControl  

**Description**

```php
public getControl (void)
```

Get the control 

**Parameters**

`This function has no parameters.`

**Return Values**

`Group`

<hr />

## Experiment::setControl  

**Description**

```php
public setControl (Group|array|object $group)
```

Define the control 

**Parameters**

* `(Group|array|object) $group`

**Return Values**

`self`

<hr />

## Experiment::getVariation  

**Description**

```php
public getVariation (void)
```

Get the variation 

**Parameters**

`This function has no parameters.`

**Return Values**

`Group`

<hr />

## Experiment::setVariation  

**Description**

```php
public setVariation (Group|array|object $group)
```

Define the variation 

**Parameters**

* `(Group|array|object) $group`

**Return Values**

`self`

<hr />

## Experiment::getAllocation  

**Description**

```php
public getAllocation (void)
```

Get experiment allocation

This is the percentual chance that a new user will be included in the experiment 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

<hr />

## Experiment::setAllocation  

**Description**

```php
public setAllocation (int $percent)
```

Set experiment allocation 

This is the percentual chance that a new user will be included in the experiment 

**Parameters**

* `(int) $percent`

**Return Values**

`self`

<hr />

## Experiment::getResult  

**Description**

```php
public getResult (void)
```

Return a Result instance from the current experiment

**Parameters**

`This function has no parameters.`

**Return Values**

`Result`