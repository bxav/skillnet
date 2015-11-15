<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Hateoas\Configuration\Route;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

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

        $resources = array_values($this->get("app.availability.finder")->findByDateAndService($date, $service));

        $adapter = new ArrayAdapter($resources);
        $resources = new Pagerfanta($adapter);

        $resources->setMaxPerPage(100);

        $resources = $this->getPagerfantaFactory()->createRepresentation(
            $resources,
            new Route(
                $request->attributes->get('_route'),
                array_merge($request->attributes->get('_route_params'), $request->query->all())
            )
        );


        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData($resources)
        ;

        return $this->handleView($view);
    }
}
