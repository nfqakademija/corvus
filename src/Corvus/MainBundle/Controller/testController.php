<?php

namespace Corvus\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class testController extends Controller
{
    /**
     * @Route("/Contacts")
     * @Template()
     */
    public function ContactsAction(Request $request)
    {	
        $data = array(
            'name' => ''
            );
	$form = $this->createFormBuilder($data)
            ->add('name', 'text', array('label' => 'Įveskite adresą:'))
            ->add('save', 'submit', array('label' => 'Rodyti temperatūrą'))
            ->getForm();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            
            $data = $form->getData();
        }

        return array(
            'form' => $form->createView(),
	    'data' => $data['name']	
        );
	
    }

}
