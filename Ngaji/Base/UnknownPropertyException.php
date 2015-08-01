<?php namespace Ngaji\Base;

/**
 * UnknownPropertyException represents an exception caused by accessing unknown object properties.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class UnknownPropertyException extends Exception {
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Unknown Property';
    }
}
