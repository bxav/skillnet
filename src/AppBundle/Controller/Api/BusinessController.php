<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Business;
use AppBundle\Entity\Image;
use AppBundle\Form\Type\BusinessType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BusinessController extends ApiController implements ClassResourceInterface
{

    protected $class = 'AppBundle\Entity\Business';

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Return a collection of Business",
     * )
     */
    public function cgetAction()
    {
        $business = $this->getDoctrine()->getRepository($this->class)->findAll();

        return $this->createView($business, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a Business",
     * )
     */
    public function getAction(Business $business)
    {
        return $this->createView($business, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a collection of Employee",
     * )
     */
    public function getEmployeesAction(Business $business)
    {
        $employees = $this->getDoctrine()->getRepository("AppBundle:Employee")->findByBusiness($business);

        return $this->createView($employees, 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  requirements={
     *      {
     *          "name"="business",
     *          "dataType"="string",
     *          "requirement"="[a-z-]+",
     *          "description"="Business's slug"
     *      }
     *  },
     *  description="Return a collection of Service",
     * )
     */
    public function getServicesAction(Business $business)
    {
        return $this->createView($business->getServices(), 200);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      201="Returned if business created successfully"
     *  },
     *  description="Create a Business"
     * )
     */
    public function postAction(Request $request)
    {
        return $this->post($request);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Update a business",
     * )
     */
    public function putAction(Request $request, Business $business)
    {
        return $this->put($request, $business);
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      201="Returned if business created successfully"
     *  },
     *  description="Create a Business"
     * )
     */
    public function postImagesAction(Request $request, Business $business)
    {
        $uploader = $this->container->get('app.image_uploader');


        $img = $request->files->get('file');

        $image = new Image();
        $image->setFile(new UploadedFile($img->getRealPath(), $img->getFilename()));
        $uploader->upload($image);

        $business->setImage($image);

        $this->persistAndFlush($business);

        return $this->createView($business, 201);
    }
}
