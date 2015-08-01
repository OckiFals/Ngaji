<?php namespace Ngaji\Base;

/**
 * Exception represents a generic exception for all purposes.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
class Exception extends \Exception {
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName() {
        return 'Exception';
    }
}
