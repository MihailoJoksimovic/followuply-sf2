<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * @Route("/dashboard", name="dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Dashboard:index.html.twig');
    }
}
