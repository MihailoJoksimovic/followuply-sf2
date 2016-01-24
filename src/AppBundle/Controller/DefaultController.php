<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $msg = array('uri' => '/a', 'visitorUid' => 'test@test.com', 'appId' => 'xxx');
        $this->get('old_sound_rabbit_mq.event_producer')->publish(json_encode($msg));
        // $this->get('redis.client')->lpush('asd', 'asd');
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ));
    }


    /**
     * @Route("/receive", name="test")
     */
    public function receiveAction(Request $request)
    {
        die('x');
    }
}
