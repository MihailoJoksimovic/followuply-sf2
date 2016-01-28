<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Scenario;
use AppBundle\Entity\User;
use AppBundle\Form\Type\ScenarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use AppBundle\Entity\Route as RouteEntity;
use AppBundle\Form\Type\RouteType;

/**
 * @Route("/dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        $route1 = new RouteEntity();
        $route1->setUriPattern('http://followuply.com/a');
        $route1->setPosition(1);

        $route2 = new RouteEntity();
        $route2->setUriPattern('http://followuply.com/b');
        $route2->setPosition(2);

        /** @var $user User */
        $user = $this->getUser();

        $scenario = new Scenario();
        $scenario->setAppUid($user->getAppUid());
        $scenario->getRoutes()->add($route1);
        $scenario->getRoutes()->add($route2);

        $form = $this->createForm(ScenarioType::class, $scenario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            return $this->redirectToRoute('task_success');
        }

        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
