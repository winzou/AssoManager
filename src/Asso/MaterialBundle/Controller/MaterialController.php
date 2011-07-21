<?php

namespace Asso\MaterialBundle\Controller;

use Asso\AbstractBundle\Controller\AbstractController;
use Asso\MaterialBundle\Form\MaterialType;

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\Httpfoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;


class MaterialController extends AbstractController
{
    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function deleteAction($id)
    {
        $em = $this->get('asso_material.material_manager');
        $request = $this->get('request');

        // check existence and permission
        if( ! $material = $em->getFullOne($id)
        OR $material->getAsso()->getId() != $this->getAssoId() )
        {
            throw new AccessDeniedException('User doesnt have access to this entry, or this entry doesnt exist');
        }

        // post request: we really want to do this action
        if( $request->getMethod() == 'POST' )
        {
            $em->delete($material);

            // ajax request: just return the action state
            if( $request->getRequestFormat() == 'json')
            {
                return new Response( json_encode(array('code' => true)) );
            }

            // normal request: set a flash and redirect to entries list
            $this->get('session')->setFlash('asso_material_notice', 'flash.material.delete');

            return $this->redirect( $this->generateUrl('asso_material_list') );
        }

        if( $request->getRequestFormat() == 'json')
        {
            throw new MethodNotAllowedHttpException(array('POST'), 'You must use the POST method here.');
        }

        // get request: we only want the confirmation form
        return $this->render( 'AssoMaterialBundle:Book:delete.html.twig', array(
            'material' => $material
        ));
    }

    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function listAction()
    {
        $materials = $this->get('asso_material.material_manager')->findBy(array('asso' => $this->getAssoId()));
        $form      = $this->createForm( new MaterialType() , $this->get('asso_material.material_manager')->create() );

        if( $this->getRequest()->getRequestFormat() == 'json' )
        {
            /** @todo Have to find a way to clean user attributes (passwd, etc) before dumping in json */
            //return new Response( json_encode($entries) );
            throw new NotFoundHttpException('You must not request the json format, try with html.');
        }

        return $this->render( 'AssoMaterialBundle:Material:list.html.twig', array(
            'materials' => $materials,
            'form'      => $form->createView()
        ));
    }

    /**
     * @Secure(roles="ROLE_SECRETARY")
     */
    public function newAction()
    {
        $assoId = $this->getAssoId();

        $mat = $this->get('asso_material.material_manager')->create();
        $mat->setAsso( $this->getAsso() );

        $form        = $this->createForm( new MaterialType , $mat );
        $formHandler = $this->get('asso_material.forms.material');

        if( $formHandler->process($form, $mat) )
        {
            $this->get('session')->setFlash('asso_material_notice', 'flash.material.new');

            return $this->redirect(
                $this->get('router')->generate('asso_material_list')
            );
        }

        return $this->render('AssoMaterialBundle:Material:new', array(
            'form' => $form->createView()
        ));
    }



    public function asso_needAssoSelected($action)
    {
        return true;
    }
}
