<?php namespace Ngaji\Base;

/**
 * InvalidCallException represents an exception caused by calling a method in a wrong way.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class InvalidCallException extends \BadMethodCallException {
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Invalid Call';
    }
}
