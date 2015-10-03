<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use AppBundle\Entity\Service;
use AppBundle\Form\Type\BusinessType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BusinessServiceController extends ApiController implements ClassResourceInterface
{

    protected $class = 'AppBundle\Entity\Service';

    /**
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function cgetAction(Business $business)
    {
        $service = $this->getDoctrine()->getRepository($this->getClass())->findByBusiness($business);

        return $this->createView($service, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function getAction($business, Service $service)
    {
        return $this->createView($service, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function postAction(Request $request, Business $business)
    {
        return $this->post($request, ['business' => $business]);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     * )
     */
    public function putAction(Request $request, $business, Service $service)
    {
        return $this->put($request, $service);
    }
}
