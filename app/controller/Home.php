<?php

use Swiftly\Base\Controller;
use Swiftly\Database\Database;

/**
 * The default controller that handles the homepage
 *
 * @author C Varley <clvarley>
 */
Class Home Extends Controller
{

    /**
     * Load the homepage template
     */
    public function index()
    {
        // Output a response
        return $this->setOutput($this->render('home', [
            'title'   => 'Swiftly',
            'message' => 'Thanks for installing Swiftly!'
        ]));
    }

    /**
     * Says hello to the given name
     *
     * @param string $name User name
     */
    public function hello( string $name )
    {
        // Pass the named paramater in
        return $this->setOutput($this->render('home', [
            'title'   => \mb_ucfirst( $name ),
            'message' => 'Welcome to Swiftly!'
        ]));
    }
}
