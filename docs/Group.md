# Group

This class is in charge of creating and handling the control and variation groups of an experiment, including getting and setting their values such as group type, size, number of conversions, and whether the group is the winning or losing variant.

| Name | Description |
|------|-------------|
|[getValues](#groupgetvalues)|Get all values for the group|
|[getValue](#groupgetvalue)|Get property value of group|
|[setValue](#groupsetvalue)|Set property value of group|
|[getName](#groupgetname)|Get group name|
|[setName](#groupsetname)|Set group name|
|[getSize](#groupgetsize)|Get group size|
|[setSize](#groupsetsize)|Set group size|
|[getConversions](#groupgetconversions)|Get number of conversions for the group|
|[setConversions](#groupsetconversions)|Set number of conversions for the group|
|[getConversionRate](#groupgetconversionrate)|Get conversion rate for the group|
|[isWinner](#groupiswinner)|Get whether the group is the winner|
|[setWinner](#groupsetwinner)|Define the group as the winner|
|[isLoser](#groupisloser)|Get whether the group is the loser|
|[setLoser](#groupsetloser)|Define the group as the loser|
|[getType](#groupgettype)|Get group type|
|[isType](#groupistype)|Get whether the variation is a specific type|
|[setType](#groupsettype)|Set group type|
|[isControl](#groupiscontrol)|Get whether the group is the control|
|[setControl](#groupsetcontrol)|Define the group as the control|
|[isVariation](#groupisvariation)|Get whether the group is the variation|
|[setVariation](#groupsetvariation)|Define the group as the variation|

## Group::getValues  

**Description**

```php
public getValues (void)
```

Get all values for the group 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`

<hr />

## Group::getValue  

**Description**

```php
public getValue (int|string $property)
```

Get property value of group 

**Parameters**

* `(int|string) $property`

**Return Values**

`mixed`

<hr />

## Group::setValue  

**Description**

```php
public setValue (string $property, mixed $value)
```

Set property value of group 

**Parameters**

* `(string) $property`
* `(mixed) $value`

**Return Values**

`self`

<hr />

## Group::getName  

**Description**

```php
public getName (void)
```

Get group name 

**Parameters**

`This function has no parameters.`

**Return Values**

`null|string`

<hr />

## Group::setName  

**Description**

```php
public setName (string $name)
```

Set group name 

**Parameters**

* `(string) $name`

**Return Values**

`self`

<hr />

## Group::getSize  

**Description**

```php
public getSize (void)
```

Get group size 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

<hr />

## Group::setSize  

**Description**

```php
public setSize (int $size)
```

Set group size 

**Parameters**

* `(int) $size`

**Return Values**

`self`

<hr />

## Group::getConversions  

**Description**

```php
public getConversions (void)
```

Get number of conversions for the group 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

<hr />

## Group::setConversions  

**Description**

```php
public setConversions (int $conversions)
```

Set number of conversions for the group 

**Parameters**

* `(int) $conversions`

**Return Values**

`self`

<hr />

## Group::getConversionRate  

**Description**

```php
public getConversionRate (void)
```

Get conversion rate for the group 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`

<hr />

## Group::isWinner  

**Description**

```php
public isWinner (void)
```

Get whether the group is the winner 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Group::setWinner  

**Description**

```php
public setWinner (void)
```

Define the group as the winner 

**Parameters**

`This function has no parameters.`

**Return Values**

`self`

<hr />

## Group::isLoser  

**Description**

```php
public isLoser (void)
```

Get whether the group is the loser 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Group::setLoser  

**Description**

```php
public setLoser (void)
```

Define the group as the loser 

**Parameters**

`This function has no parameters.`

**Return Values**

`self`

<hr />

## Group::getType  

**Description**

```php
public getType (void)
```

Get group type 

Returns 0 for control, 1 for variation and null when type is unknown 

**Parameters**

`This function has no parameters.`

**Return Values**

`int|null`

<hr />

## Group::isType  

**Description**

```php
public isType (int $type)
```

Get whether the variation is a specific type 

**Parameters**

* `(int) $type`

**Return Values**

`bool`

<hr />

## Group::setType  

**Description**

```php
public setType (int $type)
```

Set group type 

**Parameters**

* `(int) $type`

**Return Values**

`self`

<hr />

## Group::isControl  

**Description**

```php
public isControl (void)
```

Get whether the group is the control 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Group::setControl  

**Description**

```php
public setControl (void)
```

Define the group as the control 

**Parameters**

`This function has no parameters.`

**Return Values**

`self`

<hr />

## Group::isVariation  

**Description**

```php
public isVariation (void)
```

Get whether the group is the variation 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Group::setVariation  

**Description**

```php
public setVariation (void)
```

Define the group as the variation 

**Parameters**

`This function has no parameters.`

**Return Values**

`self`

<hr />