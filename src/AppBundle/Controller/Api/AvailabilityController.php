<?php

namespace AppBundle\Controller\Api;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;


class AvailabilityController extends ApiController implements ClassResourceInterface
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      200="Returned if everything is fine"
     *  },
     * )
     * @QueryParam(name="date", description="date")
     * @QueryParam(name="service-id", requirements="\d+", description="Service's id.")
     *
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $date = new \DateTimeImmutable($paramFetcher->get("date"));
        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find($paramFetcher->get('service-id'));
        $availabilities = $this->get("app.availability.finder")->findByDateAndService($date, $service);
        return new JsonResponse($availabilities, 200);
    }
}
