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

use AppBundle\Entity\Employee;
use AppBundle\Entity\Image;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends ApiController
{
    protected $class = 'AppBundle\Entity\Employee';

    /**
     * @ApiDoc(
     *  resource=true,
     *  statusCodes={
     *      201="Returned if business created successfully"
     *  }
     * )
     */
    public function postImagesAction(Request $request, Employee $employee)
    {
        $uploader = $this->container->get('app.image_uploader');

        $img = $request->files->get('file');

        $image = new Image();
        $image->setFile(new UploadedFile($img->getRealPath(), $img->getFilename()));
        $uploader->upload($image);

        $employee->setImage($image);

        $this->persistAndFlush($employee);

        return $this->createView($employee, 201);
    }
}
