<?php namespace Ngaji\Base;

/**
 * UnknownMethodException represents an exception caused by accessing an unknown object method.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class UnknownMethodException extends \BadMethodCallException {
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Unknown Method';
    }
}
