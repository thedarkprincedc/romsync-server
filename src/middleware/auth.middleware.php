<?php
class AuthMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        // $response->getBody()->write('BEFORE');
        // //$response = $next($request, $response);
        // $response->getBody()->write('AFTER');
        // return $response;
        $authorized = true;

        if ($authorized) {
            // authorized, call next middleware
            return $next($request, $response);
        }
        $body = new Body(fopen('php://temp', 'r+'));
        $body->write('Forbidden');
        return $response
            ->withBody($body)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
            ->withStatus(403);
    }
}
