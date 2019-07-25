<?php

namespace EllipseSynergie\ApiResponse\Tests\Laravel;

/**
 * Class ResponseFactoryFake
 * @package EllipseSynergie\ApiResponse\Tests\Laravel
 * @author Maxime Beaudoin <maxime.beaudoin@ellipse-synergie.com>
 */
class ResponseFactoryFake implements \Illuminate\Contracts\Routing\ResponseFactory
{
    /**
     * Return a new response from the application.
     *
     * @param  string $content
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function make($content = '', $status = 200, array $headers = array())
    {
        // TODO: Implement make() method.
    }

    /**
     * Return a new view response from the application.
     *
     * @param  string $view
     * @param  array $data
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function view($view, $data = array(), $status = 200, array $headers = array())
    {
        // TODO: Implement view() method.
    }

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array $data
     * @param  int $status
     * @param  array $headers
     * @param  int $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function json($data = array(), $status = 200, array $headers = array(), $options = 0)
    {
        return $data;
    }

    /**
     * Return a new JSONP response from the application.
     *
     * @param  string $callback
     * @param  string|array $data
     * @param  int $status
     * @param  array $headers
     * @param  int $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function jsonp($callback, $data = array(), $status = 200, array $headers = array(), $options = 0)
    {
        // TODO: Implement jsonp() method.
    }

    /**
     * Return a new streamed response from the application.
     *
     * @param  \Closure $callback
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream($callback, $status = 200, array $headers = array())
    {
        // TODO: Implement stream() method.
    }

    /**
     * Create a new file download response.
     *
     * @param  \SplFileInfo|string $file
     * @param  string $name
     * @param  array $headers
     * @param  null|string $disposition
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($file, $name = null, array $headers = array(), $disposition = 'attachment')
    {
        // TODO: Implement download() method.
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string $path
     * @param  int $status
     * @param  array $headers
     * @param  bool $secure
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectTo($path, $status = 302, $headers = array(), $secure = null)
    {
        // TODO: Implement redirectTo() method.
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param  string $route
     * @param  array $parameters
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToRoute($route, $parameters = array(), $status = 302, $headers = array())
    {
        // TODO: Implement redirectToRoute() method.
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param  string $action
     * @param  array $parameters
     * @param  int $status
     * @param  array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToAction($action, $parameters = array(), $status = 302, $headers = array())
    {
        // TODO: Implement redirectToAction() method.
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param  string $path
     * @param  int $status
     * @param  array $headers
     * @param  bool $secure
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectGuest($path, $status = 302, $headers = array(), $secure = null)
    {
        // TODO: Implement redirectGuest() method.
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param  string $default
     * @param  int $status
     * @param  array $headers
     * @param  bool $secure
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function redirectToIntended($default = '/', $status = 302, $headers = array(), $secure = null)
    {
        // TODO: Implement redirectToIntended() method.
    }

    /**
     * Return a new streamed response as a file download from the application.
     *
     * @param  \Closure $callback
     * @param  string|null $name
     * @param  array $headers
     * @param  string|null $disposition
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
    {
        // TODO: Implement streamDownload() method.
    }

    /**
     * Create a new "no content" response.
     *
     * @param  int $status
     * @param  array $headers
     * @return \Illuminate\Http\Response
     */
    public function noContent($status = 204, array $headers = [])
    {
        // TODO: Implement noContent() method.
    }

    /**
     * Return the raw contents of a binary file.
     *
     * @param \SplFileInfo|string $file
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function file($file, array $headers = [])
    {
        // TODO: Implement file() method.
    }
}
