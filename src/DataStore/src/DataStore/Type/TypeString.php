<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

namespace rollun\datastore\DataStore\Type;

class TypeString extends TypeAbstract
{
    /**
     * @return string
     */
    public static function getTypeName()
    {
        return 'string';
    }

    /**
     * @return string
     * @throws TypeException
     */
    public function toTypeValue()
    {
        if (is_resource($this->value)) {
            throw new TypeException('Resource could not be converted to string');
        }

        try {
            return strval($this->value);
        } catch (\Exception $e) {
            throw new TypeException($e->getMessage());
        }
    }
}
