<?php

/*
 * Copyright 2011 Piotr Śliwa <peter.pl7@gmail.com>
 *
 * License information is in LICENSE file
 */

namespace Ps\PdfBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;

/**
 * Controller with examples
 * 
 * @author Piotr Śliwa <peter.pl7@gmail.com>
 */
class ExampleController extends Controller
{
    public function indexAction()
    {
        return $this->render('PsPdfBundle:Example:index.html.twig');
    }
    
    public function usingFacadeDirectlyAction()
    {
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('PsPdfBundle:Example:usingFacadeDirectly.pdf.twig', array(), $response);
        
        $xml = $response->getContent();
        
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }

    /**
     * Posible custom headers
     * 
     * @Pdf(headers={"Expires"="Sat, 1 Jan 2000 12:00:00 GMT"})
     */
    public function usingAutomaticFormatGuessingAction($name)
    {
        $format = $this->get('request')->get('_format');
        
        return $this->render(sprintf('PsPdfBundle:Example:usingAutomaticFormatGuessing.%s.twig', $format), array(
            'name' => $name,
        ));
    }
}
