<?php
/**
 * The file for the create-token service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2016 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\CreateToken;

use InvalidArgumentException;

/**
 * The create-token service
 *
 * @since  0.1.0
 */
class Create
{
    /* !Magic methods */
    
    /**
     * Called when the class is treated like a function
     *
     * @param   int   $length  the token's length
     * @return  string
     * @throws  InvalidArgumentException  if $length is not a positive integer
     * @since   0.1.0
     */
    public function __invoke(int $length): string
    {
        if ($length < 1) {
            throw new InvalidArgumentException(
                __METHOD__ . "() expects parameter one, length, to be a positive "
                    . "integer"
            );    
        }
        
        return bin2hex(random_bytes($length / 2));
    }    
}
