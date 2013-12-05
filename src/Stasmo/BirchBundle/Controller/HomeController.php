<?php

namespace Stasmo\BirchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Stasmo\BirchBundle\Entity\GetQuote;
use Stasmo\BirchBundle\Form\GetQuoteType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template("StasmoBirchBundle:Home:index.html.twig")
     */
    public function indexAction()
    {
        $getQuote = new GetQuote();
        $form = $this->createForm(new GetQuoteType, $getQuote, array(
            'action' => $this->generateUrl('_home_getQuote'),
            'method' => 'POST',
        ));
        return array("form"=>$form->createView());
    }

    /**
     * @Route("/getQuote", name="_home_getQuote")
     */
    public function getQuoteAction()
    {
        $getQuote = new GetQuote();
        $form = $this->createForm(new GetQuoteType, $getQuote);
        $form->handleRequest($this->getRequest());
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Request for quote')
                ->setFrom($this->container->getParameter('mailer_user') . '@gmail.com')
                ->setTo($this->container->getParameter('mailer_user') . '@gmail.com')
                ->setBody(
                    $this->renderView(
                        'StasmoBirchBundle::quote.txt.twig',
                        array('form' => $getQuote)
                    )
                )
            ;
            $this->get('mailer')->send($message);
        }
        return $this->redirect($this->generateUrl('_home'));
    }
}
