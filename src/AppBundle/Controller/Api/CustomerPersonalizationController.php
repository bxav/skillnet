<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Customer;
use AppBundle\Entity\PersonalizedService;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\Put;
use FOS\RestBundle\Controller\Annotations\Get;


class CustomerPersonalizationController extends ApiController implements ClassResourceInterface
{

    /**
     * @Get("/customers/{customer}/personalizations/services/{service}")
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function getServiceAction($customer, PersonalizedService $service)
    {
        return $this->createView($service, 200);
    }

    /**
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
     * @Put("/customers/{customer}/personalizations/services/{service}")
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function putServiceAction(Request $request, $customer, PersonalizedService $service)
    {
        $this->setClass('AppBundle\Entity\PersonalizedService');

        $personalizedServiceFromRequest = $this->hydrateWithRequest($request, $this->getClass());

        $this->resolvePartialNestedEntity($service);

        $updatedPersonalizedService = $this->patchWithSameTypeObject($service, $personalizedServiceFromRequest);

        $this->persistAndFlush($updatedPersonalizedService);

        return $this->createView($updatedPersonalizedService, 200);

    }
}
