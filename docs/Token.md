# Token

This class is in charge of managing and generating unique tokens to associate with your visitors, including methods for setting and removing their tracking cookies.

| Name | Description |
|------|-------------|
|[getName](#tokengetname)|Get tracking token name|
|[setName](#tokensetname)|Set tracking token name|
|[getValue](#tokengetvalue)|Get tracking token value|
|[setValue](#tokensetvalue)|Set tracking token value|
|[generate](#tokengenerate)|Set the token value to a new generated hash|
|[setCookie](#tokensetcookie)|Set tracking cookie with the token name and value|
|[removeCookie](#tokenremovecookie)|Remove tracking cookie|

## Token::getName  

**Description**

```php
public getName (void)
```

Get tracking token name 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

<hr />

## Token::setName  

**Description**

```php
public setName (string $name)
```

Set tracking token name 

**Parameters**

* `(string) $name`

**Return Values**

`self`

<hr />

## Token::getValue  

**Description**

```php
public getValue (void)
```

Get tracking token value 

**Parameters**

`This function has no parameters.`

**Return Values**

`string|null`

<hr />

## Token::generate  

**Description**

```php
public generate (mixed $id)
```

Set the token value to a new generated hash 

Use `$id` to generate a static hash that will always be the same given the current token name and identifier  
This is useful for creating a token based on e.g. a user ID

If no identifier is passed, a unique hash is randomly generated 

**Parameters**

* `(mixed) $id`
: Unique identifier (e.g. a user ID)  

**Return Values**

`self`

<hr />

## Token::setValue  

**Description**

```php
public setValue (string $value)
```

Set tracking token value 

**Parameters**

* `(string) $value`

**Return Values**

`self`

<hr />

## Token::setCookie  

**Description**

```php
public setCookie (string|null $value, int|string|null $expires)
```

Set tracking cookie with the token name and value 

This sends a cookie to the users browser with the configured settings (and if passed, a custom value and expires timestamp)

**Parameters**

* `(string|null) $value`
: Defaults to configured value  
* `(int|string|null) $expires`
: Defaults to current time plus configured max age

**Return Values**

`self`

<hr />

## Token::removeCookie  

**Description**

```php
public removeCookie (void)
```

Remove tracking cookie 

This sends a cookie to the users browser with the configured settings, but with false as value, and an expiration date set to a time in the past, removing the cookie 

**Parameters**

`This function has no parameters.`

**Return Values**

`self`
