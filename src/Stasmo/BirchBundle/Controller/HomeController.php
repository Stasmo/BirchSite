<?php

namespace Stasmo\BirchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Stasmo\BirchBundle\Entity\GetQuote;
use Stasmo\BirchBundle\Form\GetQuoteType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Stasmo\BirchBundle\Entity\Config;

class HomeController extends Controller
{
    /**
     * @Route("/", name="_home")
     * @Template("StasmoBirchBundle:Home:index.html.twig")
     */
    public function indexAction()
    {
        $getQuote = new GetQuote();
        $config = $this->getLatestConfig();
        $form = $this->createForm(new GetQuoteType, $getQuote, array(
            'action' => $this->generateUrl('_home_getQuote'),
            'method' => 'POST',
        ));
        return array(
            'form'   => $form->createView(),
            'config' => $config,
        );
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

    /**
     * @Route("/admin", name="_admin")
     * @Template("StasmoBirchBundle:Home:admin.html.twig")
     */
    public function getAdmin(Request $request)
    {
        $config = $this->getLatestConfig();

        $form = $this->createFormBuilder($config)
            ->add('showFacebook', 'checkbox', array( 'required' => false ))
            ->add('facebookLink', 'text', array( 'required' => false ))
            ->add('showTwitter', 'checkbox', array( 'required' => false ))
            ->add('twitterLink', 'text', array( 'required' => false ))
            ->add('showMenu', 'checkbox', array( 'required' => false ))
            // ->add('menuFile', 'file', array( 'required' => false ))
            ->add('save', 'submit')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Changes saved'
                );
                // $files = $request->files->all();
                // if (count($files) === 1 && !is_null($file = array_values($files)[0]['menuFile'])) {
                //     $path = $request->server->get('DOCUMENT_ROOT') . '/menu';
                //     $filename = $file->getClientOriginalName();
                //     $file->move($path, $filename);
                // }
                $config->setLastUpdated(new \DateTime());
                $em = $this->get('doctrine')->getManager();
                $em->persist($config);
                $em->flush();
                return $this->redirect($this->generateUrl('_admin'));
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }

    private function getLatestConfig()
    {
        $em = $this->get('doctrine')->getManager();
        $configs = $em->getRepository('StasmoBirchBundle:Config')->findAll();
        if (count($configs) < 1) {
            $config = new Config();
        } else {
            $config = $configs[0];
        }

        return $config;
    }

}
