<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;

class AvailabilityController extends ApiController
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $this->isGrantedOr403('index');

        $criteria = $this->config->getCriteria();

        $date = new \DateTimeImmutable($criteria['date']);
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($criteria['service']);

        $resources = $this->get("app.availability.finder")->findByDateAndService($date, $service);

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData($resources)
        ;

        return $this->handleView($view);
    }
}
