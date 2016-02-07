<?php

namespace AppBundle\Worker;

use AppBundle\Entity\Scenario;
use AppBundle\Model\EmailData;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class UserScenario extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('worker:user_scenario')
            ->setDescription('Worker that processes user_scenarios from mongo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $userScenarioRepository = $container->get('doctrine.odm.mongodb.document_manager')->getRepository('AppBundle:UserScenario');
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        while (true) {
            // could use a bit of a refactor

            /** @var \AppBundle\Document\UserScenario $userScenario */
            $userScenario = $userScenarioRepository->getExpired();

            if ($userScenario) {
                // successfully finished
                if ($userScenario->isDone()) {
                    continue;
                }

                // user didn't finish scenario. queue email
                $scenario = $entityManager->getReference('AppBundle:Scenario', $userScenario->getScenarioId());
                $emailTemplate = $entityManager->getRepository('AppBundle:EmailTemplate')->findOneTemplate($scenario);
                $appUid = $scenario->getUser()->getAppUid();

                // we already emailed this person
                if ($container->get('redis.client')->get(sprintf('%s:%s', $appUid, $userScenario->getEmail()))) {
                    continue;
                }

                $emailData = new EmailData($userScenario->getEmail(), $appUid, $emailTemplate);

                $this->getContainer()->get('old_sound_rabbit_mq.email_producer')->publish(serialize($emailData));
            }

            sleep(5);
        }
    }
}
