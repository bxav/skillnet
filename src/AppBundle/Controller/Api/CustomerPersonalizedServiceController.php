<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Customer;
use AppBundle\Entity\PersonalizedService;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\QueryParam;

/**
 * todo move to personalized service
 * Class CustomerPersonalizationController
 * @package AppBundle\Controller\Api
 */
class CustomerPersonalizedServiceController extends ApiController
{


    /**
     * @Get("/customers/{customer}/personalized-services")
     * @ApiDoc(
     *  resource=true,
     * )
     * @QueryParam(name="service-id", description="real service's id.")
     */
    public function getServicesAction(ParamFetcher $paramFetcher, $customer)
    {
        $personalizedService = null;
        $service = $this->getDoctrine()->getRepository("AppBundle:Service")->find($paramFetcher->get('service-id'));
        if ($service) {
            $personalizedService = $this->getDoctrine()->getRepository("AppBundle:PersonalizedService")->findOneBy([
                'service' => $service,
                'customer' => $customer
            ]);
        }
        return $this->createView($personalizedService, 200);
    }

    /**
     * @Get("/customers/{customer}/personalized-services/{service}")
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function getServiceAction($customer, PersonalizedService $personalizedService)
    {
        return $this->createView($personalizedService, 200);
    }

    /**
     * @Post("/customers/{customer}/personalized-services")
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function postServiceAction(Request $request, Customer $customer)
    {
        $this->setClass('AppBundle\Entity\PersonalizedService');

        $personalizedService = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($personalizedService);

        $personalizedService->setCustomer($customer);

        $this->persistAndFlush($personalizedService);

        return $this->createView($personalizedService, 201);
    }

    /**
     * @Put("/customers/{customer}/personalized-services/{service}")
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function putServiceAction(Request $request, $customer, PersonalizedService $personalizedService)
    {
        $this->setClass('AppBundle\Entity\PersonalizedService');

        $personalizedServiceFromRequest = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($personalizedService);

        $updatedPersonalizedService = $this->patchWithSameTypeObject($personalizedService, $personalizedServiceFromRequest);

        $this->persistAndFlush($updatedPersonalizedService);

        return $this->createView($updatedPersonalizedService, 200);

    }
}
