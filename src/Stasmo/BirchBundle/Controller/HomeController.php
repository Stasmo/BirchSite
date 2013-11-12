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
        $form = $this->createForm(new GetQuoteType, $getQuote);
        return array("form"=>$form->createView());
    }

    /**
     * @Route("/getQuote", name="_home_getQuote")
     */
    public function getQuoteAction()
    {

    }
}
