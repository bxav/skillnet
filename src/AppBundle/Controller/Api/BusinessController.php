<?php

/*
 * This file is part of the BxMarket package.
 *
 * (c) Xavier Buillit
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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


class BusinessController extends ApiController
{

    protected $class = 'AppBundle\Entity\Business';

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
