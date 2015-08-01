<?php namespace Ngaji\Base;

/**
 * Configurable is the interface that should be implemented by classes who support configuring
 * its properties through the last parameter to its constructor.
 *
 * The interface does not declare any method. Classes implementing this interface must declare their constructors
 * like the following:
 *
 * ```php
 * public function __constructor($param1, $param2, ..., $config = [])
 * ```
 *
 * That is, the last parameter of the constructor must accept a configuration array.
 *
 * @author Ocki Bagus Pratama <ocki.bagus.p@gmail.com>
 * @since 2.1
 */
interface Configurable {
}
