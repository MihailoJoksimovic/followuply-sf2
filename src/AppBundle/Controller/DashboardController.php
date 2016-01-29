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
        $route1->setPatternType(RouteEntity::ROUTE_TYPE_BEGINS_WITH); // Use this one by default for now
        $route1->setPosition(0);

        $route2 = new RouteEntity();
        $route2->setUriPattern('http://followuply.com/b');
        $route2->setPatternType(RouteEntity::ROUTE_TYPE_BEGINS_WITH); // Use this one by default for now
        $route2->setPosition(1);

        /** @var $user User */
        $user = $this->getUser();

        $scenario = new Scenario();
        $scenario->setUser($user);
        $scenario->addRoute($route1);
        $scenario->addRoute($route2);

        $form = $this->createForm(ScenarioType::class, $scenario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($route1);
            $em->persist($route2);
            $em->persist($scenario);

            $em->flush();

            $this->addFlash(
                'info',
                'New scenario has been added!'
            );

            return $this->redirectToRoute('dashboard_scenarios_list');
        }

        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/scenarios", name="dashboard_scenarios_list")
     */
    public function listScenariosAction()
    {
        /** @var $user User */
        $user = $this->getUser();

        $scenarios = $user->getScenarios();

        return $this->render('AppBundle:Dashboard:scenarios.html.twig', array(
            'scenarios' => $scenarios
        ));
    }

    /**
     * @Route("/scenario/edit/{id}", name="dashboard_scenario_edit")
     */
    public function editScenarioAction(Scenario $scenario, Request $request)
    {
        $this->denyAccessUnlessGranted('edit', $scenario);

        $form = $this->createForm(ScenarioType::class, $scenario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'Your changes have been saved!'
            );

            return $this->redirectToRoute('dashboard_scenarios_list');
        }

        return $this->render('AppBundle:Dashboard:edit-scenario.html.twig', array(
            'form'      => $form->createView()
        ));
    }
}


