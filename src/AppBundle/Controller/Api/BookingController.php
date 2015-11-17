<?php

namespace AppBundle\Controller\Api;

use Sylius\Component\Resource\Event\ResourceEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BookingController extends ApiController
{

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createFromEmployeeAction(Request $request)
    {
        $this->isGrantedOr403('create');

        $resource = $this->createNew();
        $form = $this->getForm($resource);

        if ($request->isMethod('POST') && $form->submit($request)->isValid()) {
            $resource = $this->domainManager->create($form->getData());


            // set employee
            // todo add authorization control
            $criteria = $this->config->getCriteria();
            $employee = $this->get('app.repository.employee')->find($criteria['employee']);
            $resource->setEmployee($employee);



            if ($this->config->isApiRequest()) {
                if ($resource instanceof ResourceEvent) {
                    throw new HttpException($resource->getErrorCode(), $resource->getMessage());
                }

                return $this->handleView($this->view($resource, 201));
            }

            if ($resource instanceof ResourceEvent) {
                return $this->redirectHandler->redirectToIndex();
            }

            return $this->redirectHandler->redirectTo($resource);
        }

        if ($this->config->isApiRequest()) {
            return $this->handleView($this->view($form, 400));
        }

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('create.html'))
            ->setData(array(
                $this->config->getResourceName() => $resource,
                'form'                           => $form->createView(),
            ))
        ;

        return $this->handleView($view);
    }
}
