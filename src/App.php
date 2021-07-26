<?php


namespace TestWork;


use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;
use TestWork\Connection\DB;
use Throwable;

/**
 * Class App
 * @package TestWork
 */
class App
{
    private Router $router;
    private PsrHttpFactory $psrHttpFactory;
    private AppConfig $config;
    private DB $db;

    /**
     * App constructor.
     * @param array $config
     * @param string $appRoot
     */
    public function __construct(array $config, string $appRoot)
    {
        $this->config = new AppConfig($config, $appRoot);
        $this->router = new Router(
            new YamlFileLoader(new FileLocator([$this->config->getConfigPath()])),
            'routes.yml',
            ['cache_dir' => $this->config->getCachePath()]
        );;
        $this->db = new DB($this->config->getDBConfig());
        $psr17Factory = new Psr17Factory();
        $this->psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->router->setContext((new RequestContext())->fromRequest($request));

        try {
            $routerMeta = $this->router->matchRequest($request);

            $controller = $routerMeta['_controller'];
            $action = $routerMeta['_action'];

            $psrResponse = (new $controller($this->db))->{$action}($this->psrHttpFactory->createRequest($request), $routerMeta);
            $response = (new HttpFoundationFactory())->createResponse($psrResponse);
        } catch (ResourceNotFoundException $e) {
            $response = new Response(json_encode([
                'message' => 'Service not found',
                'code' => Response::HTTP_NOT_FOUND
            ]), Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            $response = new Response(json_encode([
                'message' => $e->getMessage(),
                'code' => Response::HTTP_NOT_FOUND
            ]), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response;
    }
}
