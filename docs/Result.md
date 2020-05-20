# Result

This class is in charge of calculating your experiment winner, relative conversion rate change between groups, the level of confidence of the results (including whether you have achieved statistical significance), and getting a minimum sample size for your variants.

| Name | Description |
|------|-------------|
|[getMinimumConfidence](#resultgetminimumconfidence)|Get the specified minimum confidence|
|[setMinimumConfidence](#resultsetminimumconfidence)|Set the minimum confidence|
|[getMinimumDetectableEffect](#resultgetminimumdetectableeffect)|Get the specified minimum detectable effect|
|[setMinimumDetectableEffect](#resultsetminimumdetectableeffect)|Set the minimum detectable effect|
|[getWinner](#resultgetwinner)|Get the winning group|
|[getLoser](#resultgetloser)|Get the losing group|
|[getConversionRateChange](#resultgetconversionratechange)|Get the percentual conversion rate change between the control and variation|
|[getConfidence](#resultgetconfidence)|Get confidence of result|
|[isConfident](#resultisconfident)|Return whether we can be confident of the result|
|[getMinimumSampleSize](#resultgetminimumsamplesize)|Get minimum sample size for the current experiment|
|[isSignificant](#resultissignificant)|Return whether the result is statistically significant|
|[getAll](#resultgetall)|Get complete results|

## Result::getMinimumConfidence  

**Description**

```php
public getMinimumConfidence (void)
```

Get the specified minimum confidence 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`

<hr />

## Result::setMinimumConfidence  

**Description**

```php
public setMinimumConfidence (float|string $confidence)
```

Set the minimum confidence 

**Parameters**

* `(float|string) $confidence`

**Return Values**

`self`

<hr />

## Result::getMinimumDetectableEffect  

**Description**

```php
public getMinimumDetectableEffect (void)
```

Get the specified minimum detectable effect 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`

<hr />

## Result::setMinimumDetectableEffect  

**Description**

```php
public setMinimumDetectableEffect (float|string $effect)
```

Set the minimum detectable effect 

**Parameters**

* `(float|string) $effect`

**Return Values**

`self`

<hr />

## Result::getWinner  

**Description**

```php
public getWinner (void)
```

Get the winning group 

**Parameters**

`This function has no parameters.`

**Return Values**

`Group|null`

<hr />

## Result::getLoser  

**Description**

```php
public getLoser (void)
```

Get the losing group 

**Parameters**

`This function has no parameters.`

**Return Values**

`Group|null`

<hr />

## Result::getConversionRateChange  

**Description**

```php
public getConversionRateChange (void)
```

Get the percentual conversion rate change between the control and variation 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`

<hr />

## Result::getConfidence  

**Description**

```php
public getConfidence (void)
```

Get confidence of result 

Returns the probability that the null hypothesis (the hypothesis that there is no difference or no change between the two variants) can be rejected  
  
This is called the alternative hypothesis (inverse of the probability value) 

**Parameters**

`This function has no parameters.`

**Return Values**

`float`

<hr />

## Result::isConfident  

**Description**

```php
public isConfident (void)
```

Return whether we can be confident of the result 

This requires the confidence to be greater than or equal to the configured minimum confidence 

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Result::getMinimumSampleSize  

**Description**

```php
public getMinimumSampleSize (void)
```

Get minimum sample size for the current experiment 

This is based on the control conversion rate, minimum confidence, and minimum detectable change in conversion rate, and is calculated using a two-tailed test with a false discovery rate control 

**Parameters**

`This function has no parameters.`

**Return Values**

`int`

<hr />

## Result::isSignificant  

**Description**

```php
public isSignificant (void)
```

Return whether the result is statistically significant 

This requires both the confidence (alternative hypothesis, i.e the inverse of the p-value) to be high enough (based on the specified minimum confidence) that the null hypothesis can be rejected, and the number of views for both groups to be greater than or equal to the minimum sample size (which is in turn calculated based on the minimum detectable effect, and the conversion rate of the control group)

**Parameters**

`This function has no parameters.`

**Return Values**

`bool`

<hr />

## Result::getAll  

**Description**

```php
public getAll (void)
```

Get complete results 

**Parameters**

`This function has no parameters.`

**Return Values**

`object`
