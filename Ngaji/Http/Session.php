<?php
/**
 * Class Session
 * Encapsulate the PHP Session
 * @package Ngaji\Http
 * @author Ocki Bagus Pratama
 * @since 2.0.1
 */

namespace Ngaji\Http;


class Session {

    private $instance;

    /**
     * Makes the instance
     */
    public function __construct() {
        $this->instance = $this;
    }

    /**
     * @return boolean whether the session has started
     */
    public function getIsActive() {
        return session_status() == PHP_SESSION_ACTIVE;
    }

    /**
     * Set the session with specifict $key
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $_SESSION["$key"] = $value;
    }

    /**
     * Get the session value with specifict $key
     * @param $key
     * @return null
     */
    public function get($key) {
        return $this->has($key) ? $_SESSION["$key"] : null;
    }

    /**
     * Delete the session value with specifict $key
     * @param $key
     */
    public function delete($key) {
        unset($_SESSION["$key"]);
    }

    /**
     * Destroy the current session
     */
    public function destroy() {
        session_destroy();
    }

    /**
     * Is the current session has $key?
     * @param $key
     * @return bool
     */
    public function has($key) {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * @return static
     */
    public static function flash() {
        return new Session();
    }

    /**
     * @param string $key
     * @param $value
     */
    public static function push($key='flash-message', $value) {
        (new Session())->set($key, $value);
    }

    /**
     * @param $key
     * @return null
     */
    public static function pop($key='flash-message') {
        $session = new Session();
        $temp = $session->get($key);
        $session->delete($key);
        return $temp;
    }
}