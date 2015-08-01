<?php namespace Ngaji\Base;

/**
 * UnknownClassException represents an exception caused by using an unknown class.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class UnknownClassException extends Exception {
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Unknown Class';
    }
}
