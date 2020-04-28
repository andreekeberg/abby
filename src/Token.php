<?php

namespace Abby;

/**
 * Token
 */
class Token
{
    private $config;

    /**
     * @param array $config
     *
     * @return void
     */
    public function __construct($config = [])
    {
        $this->config = array_merge([
            'name' => 'abby-token',
            'value' => null,
            'maxAge' => 60 * 60 * 24 * 365,
            'path' => '/',
            'domain' => null,
            'secure' => null,
            'httpOnly' => null
        ], $config);

        if ($this->config['value'] === null) {
            $this->config['value'] = $_COOKIE[$this->config['name']] ?? null;
        } else {
            $this->setValue($this->config['value']);
        }
    }

    /**
     * Get tracking token name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->config['name'];
    }

    /**
     * Set tracking token name
     *
     * @param string $name
     * 
     * @return self
     */
    public function setName($name)
    {
        $this->config['name'] = $name;

        return $this;
    }

    /**
     * Get tracking token value
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->config['value'];
    }

    /**
     * Set tracking token value
     *
     * @param string $value
     * 
     * @return self
     */
    public function setValue($value)
    {
        $this->config['value'] = $value;

        return $this;
    }

    /**
     * Set the token value to a new generated hash
     * 
     * Use $id to generate a static hash that will always be the same
     * given the current token name and identifier
     * This is useful for creating a token based on e.g. a user ID
     * 
     * If no identifier is passed, a unique hash is randomly generated
     * 
     * @param mixed $id Unique identifier (e.g. a user ID)
     *
     * @return self
     */
    public function generate($id = null)
    {
        if ($id !== null) {
            $this->setValue(sha1($this->getName() . $id));
        } else {
            $this->setValue(sha1($this->getName() . uniqid(mt_rand(), true)));
        }

        return $this;
    }

    /**
     * Set tracking cookie with the token name and value
     * 
     * This sends a cookie to the users browser with the configured settings (and if
     * passed, a custom value and expires timestamp)
     *
     * @param string|null $value Defaults to configured value
     * @param int|null $expires Defaults to current time plus configured max age
     * 
     * @return self
     */
    public function setCookie($value = null, $expires = null)
    {
        if ($value === null) {
            $value = $this->config['value'];
        }

        if ($expires === null) {
            $expires = time() + $this->config['maxAge'];
        }

        setcookie(
            $this->config['name'],
            $value,
            $expires,
            $this->config['path'],
            $this->config['domain'],
            $this->config['secure'],
            $this->config['httpOnly']
        );

        return $this;
    }

    /**
     * Remove tracking cookie
     * 
     * This sends a cookie to the users browser with the configured settings,
     * but with false as value, and an expiration date set to a time in the
     * past, removing the cookie
     * 
     * @return self
     */
    public function removeCookie()
    {
        return $this->setCookie(false, 1);
    }
}