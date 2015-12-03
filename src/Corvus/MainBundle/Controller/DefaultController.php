<?php

namespace Corvus\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isFullyAuthenticated) {
            return $this->redirectToRoute('dashboard');
        } else{
            return $this->welcomeAction();
        }
    }

    /**
     * @Route("/login")
     */
    public function welcomeAction()
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $isFullyAuthenticated = $this->get('security.context')
            ->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isFullyAuthenticated) {
            return $this->redirectToRoute('dashboard');
        } else {
            $formFactory = $this->get('fos_user.registration.form.factory');

            $form = $formFactory->createForm();
            return $this->render('CorvusMainBundle:welcome:welcome.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }
}