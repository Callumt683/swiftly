<?php

namespace Swiftly\Base;

use Swiftly\Database\Database;
use Swiftly\Services\Manager;

/**
 * The abstract class all models should inherit
 *
 * @author C Varley <clvarley>
 */
Abstract Class Model
{

    /**
     * @var Database $database DB wrapper
     */
    private $database = null;

    /**
     * Pass the db object into the model
     *
     * @param Database $database DB wrapper
     */
    public function __construct( Database $database )
    {
        $this->database = $database;
    }

    /**
     * Get the database object
     *
     * @return Database DB wrapper
     */
    protected function getDatabase() : Database
    {
        return $this->database;
    }

    /**
     * Get the database object
     *
     * Alias for `getDatabase()`
     *
     * @see Model::getDatabase
     * @return Database [description]
     */
    protected function getDb() : Database
    {
        return $this->database;
    }

}
