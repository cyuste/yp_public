<?php

namespace Yustplayit\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Yustplayit\WebBundle\Form\Model\Contact;
use Yustplayit\WebBundle\Form\Type\ContactType;

class DefaultController extends Controller
{
    
    /**
     * @Route("/submitContact", name="submitContact")
     * @Method("POST")
     * @Template()
     */
    public function submitContactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(new contactType(), $contact);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $email = $data->email;
            
            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
                ->setSubject('Solicitud de información')
                ->setFrom('no-reply@yustplayit.com')
                ->setTo($email)
                ->setBcc('c.yuste@yustplayit.com')    
                ->setBody(
                    $this->renderView(
                        'YustplayitWebBundle:email:contactForm.txt.twig',
                        array('data' => $data)
                    ),
                    'text/plain'
                );
            $mailer->send($message);
            return $this->redirectToRoute('index');
        } else {
            return $this->redirectToRoute('index');
        }
    }
    
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        $contact = new Contact();
        $form = $this->createForm(new ContactType(), $contact, array(
            'action' => $this->generateUrl('submitContact'),
            'method' => 'POST',
        ));
        return $this->render('YustplayitWebBundle:main:index.html.twig', array(
            'form' => $form->createView(),
        ));   
    }
}
