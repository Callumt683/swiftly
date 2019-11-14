<?php

namespace Swiftly\Services;

/**
 * Service manager singleton
 *
 * @author C Varley <cvarley@highorbit.co.uk>
 */
Final Class Manager
{

    /**
     * @var Manager $instance Service manager (this)
     */
    private static $instance = null;

    /**
     * @var object[] $services Array of service
     */
    private $services = [];

    /**
     * Service manager is created using {@see Manager::getInstance()}
     */
    protected function __construct()
    {
        // Singleton
    }

    /**
     * Get instance of service manager
     *
     * @return Manager Service manager
     */
    public static function getInstance() : Manager
    {
        if ( is_null( self::$instance ) ) {
            self::$instance = new Manager();
        }

        return self::$instance;
    }

    /**
     * Register a service with the manager
     *
     * @param string $name    Service name
     * @param object $service Service object
     */
    public function registerService( string $name, /* object */ $service ) : void
    {
        $this->services[mb_strtolower( $name )] = $service;
    }

    /**
     * Unregister a service with the manager
     *
     * @param string $name Service name
     */
    public function removeService( string $name ) : void
    {
        unset( $this->services[mb_strtolower( $name )] );
    }

    /**
     * Get a service from the manager
     *
     * @param string $name Service name
     * @return object|null Service [Or null]
     */
    public function getService( string $name ) // : ?object
    {
        return ( $this->services[mb_strtolower( $name )] ?? null );
    }
}
