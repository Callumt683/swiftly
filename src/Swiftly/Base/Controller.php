<?php

namespace Swiftly\Base;

use \Swiftly\Template\TemplateInterface;
use \Swiftly\Dependencies\Container;
use \Swiftly\Base\Model;
use \Swiftly\Http\Server\{
    Response,
    RedirectResponse
};

/**
 * The abstract class all controllers should inherit
 *
 * @author C Varley <clvarley>
 */
Abstract Class Controller
{

    /**
     * @var \Swiftly\Dependencies\Container $dependencies Dependency manager
     */
    private $dependencies = null;

    /**
     * @var \Swiftly\Template\TemplateInterface $renderer Internal renderer
     */
    private $renderer = null;

    /**
     * @var Model[] $models DB Models
     */
    private $models = [];

    /**
     * Load the services into the base controller
     *
     * @param \Swiftly\Dependencies\Container $container  Dependency manager
     */
    public function __construct( Container $container )
    {
        $this->dependencies = $container;
    }


    /**
     * Provide access to services
     *
     * @param string $name  Service name
     * @return object|null  Service (Or null)
     */
    public function getService( string $name )
    {
        return $this->dependencies->resolve( $name );
    }

    /**
     * Sets the object that will be used for rendering
     *
     * @param TemplateInterface $renderer Template renderer
     */
    public function setRenderer( TemplateInterface $renderer ) : void
    {
        $this->renderer = $renderer;
    }

    /**
     * Attempts to get a DB model
     *
     * @param string $name  Model name
     * @return Model|null   DB model (Or null)
     */
    public function getModel( string $name ) : ?Model
    {

        if ( !isset( $this->models[$name] ) ) {
            $this->models[$name] = $this->createModel( $name );
        }

        return $this->models[$name];
    }

    /**
     * Tries to create a model of the given type
     *
     * @param string $name  Model name
     * @return Model|null   Db model (Or null)
     */
    private function createModel( string $name ) : ?Model
    {
        $result = null;

        // TODO: This needs a lot of work!
        if ( \is_file( $file = \APP_MODEL . $name . '.php' ) ) {

            include $file;

            if ( \class_exists( $name ) ) {
                $this->dependencies->bind( $name, $name )->singleton( true );
                $result = $this->dependencies->resolve( $name );
            }
        }

        return $result;
    }

    /**
     * Renders the given template with the data provided
     *
     * @param  string $template Template path
     * @param  array  $data     Template data
     * @return string           Rendered template
     */
    public function render( string $template, array $data = [] ) : string
    {
        return $this->renderer->render( \APP_VIEW . $template, $data );
    }

    /**
     * Renders a template and wraps it in a Response object
     *
     * @param  string $template              Template
     * @param  array  $data                  Template data
     * @return \Swiftly\Http\Server\Response Response object
     */
    public function output( string $template, array $data = [] ) : Response
    {
        return new Response(
            $this->renderer->render( \APP_VIEW . $template, $data ),
            200,
            []
        );
    }

    /**
     * Redirect the user to a new location
     *
     * @param string $url Redirect location
     * @param int $code   (Optional) HTTP code
     * @return void       N/a
     */
    public function redirect( string $url, int $code = 303 ) : void
    {
        $redirect = new RedirectResponse( $url, $code, [] );
        $redirect->send();
        die;
    }
}
