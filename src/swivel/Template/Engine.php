<?php

namespace Swivel\Template;

use \Swivel\Lexer\LexerInterface;
use \Swivel\Parser\ParserInterface;
use \Swivel\Template\TemplateFile;
use \Swiftly\Template\TemplateInterface;

/**
 * Swivel main engine
 *
 * @author C Varley <cvarley@highorbit.co.uk>
 */
Class Engine Implements RenderableInterface, TemplateInterface
{

    /**
     * Path to the root folder
     *
     * @var string $root File path
     */
    private $root = '';

    /**
     * The template parser
     *
     * @var \Swivel\Lexer\ParserInterface $parser Parser
     */
    private $parser = null;

    /**
     * Sets the parser for this template engine
     *
     * @param \Swivel\Parser\ParserInterface $parser Parser
     */
    public function setParser( ParserInterface $parser ) : void
    {
        $this->parser = $parser;
    }

    /**
     * Sets the file system root for the template engine
     *
     * @param string $root [description]
     */
    public function setRoot( string $root ) : void
    {
        if ( !is_dir( $root ) ) {
            throw new \Exception( "Tried to set non-existant template root: $root" );
        }

        $this->root = rtrim( $root, "\n\r\\/" ) . '/';
    }

    /**
     * Renders the template with the data provided
     *
     * @param string $template Template file
     * @param array  $data     (Optional) Template data
     */
    public function render( string $template, array $data = [] ) : void
    {
        $template = new TemplateFile( $this->root . $template );

        if ( $template->isValid() ) {
            $content = $template->load();
        } else {
            $content = '';
        }

        $this->parser->setData( $data );
        $this->parser->parse( $content );

        return;
    }

    /**
     * Creates a default Swivel engine
     *
     * @return self Default engine
     */
    public static function fromDefault() : self
    {
        $lexer = \Swivel\Lexer\Lexer::fromDefault();
        $lexer->compile();

        $parser = new \Swivel\Parser\Parser();
        $parser->setLexer( $lexer );

        $engine = new Engine();
        $engine->parser = $parser;

        return $engine;
    }

}