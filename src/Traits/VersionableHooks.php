<?php

namespace Motor\CMS\Traits;

/**
 * Class VersionableHooks
 * @package Motor\CMS\Traits
 */
class VersionableHooks
{

    /**
     * Register hook on setAttribute method.
     *
     * @return \Closure
     */
    public function setAttribute()
    {
        return function ($next, $value, $args) {
            $key = $args->get('key');

            parent::setAttribute($key, $value);

            if (in_array($key, $this->versionableColumns)) {
                $this->versionAttributes[$key] = parent::getAttribute($key);
                unset($this->attributes[$key]);
            }

            return $next($value, $args);
        };
    }


    /**
     * Register hook on isDirty method
     *
     * @return \Closure
     */
    public function isDirty()
    {
        return function ($next, $attributes, $args) {

            // FIXME: make this better so it actually checks dirty states
            if (is_null($attributes)) {
                if (count($this->getVersionAttributes()) > 0) {
                    return true;
                }
            }

            return $next($attributes, $args);
        };
    }
}
