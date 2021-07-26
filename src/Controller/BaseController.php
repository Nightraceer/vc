<?php


namespace TestWork\Controller;


use Nyholm\Psr7\Response;
use TestWork\Connection\DB;

/**
 * Class BaseController
 * @package TestWork\Controller
 */
class BaseController
{
    protected DB $db;

    /**
     * BaseController constructor.
     * @param DB $db
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * @param array $data
     * @param int $status
     * @return Response
     */
    protected function getResponse(array $data, $status = 200): Response
    {
        return new Response($status, [], json_encode($data));
    }
}
