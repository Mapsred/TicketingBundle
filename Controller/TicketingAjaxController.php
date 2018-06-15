<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 14/06/2018
 * Time: 23:42
 */

namespace Maps_red\TicketingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/ajax")
 */
class TicketingAjaxController extends Controller
{
    /**
     * @Route("/{type}", name="data_table", options={"expose": "true"}, requirements={})
     * @param Request $request
     * @param string $type
     * @return Response
     */
    public function dataTableProcessing(Request $request, string $type)
    {
        var_dump($request->query->all());exit;

        return $this->json([]);
    }
}