<?php


namespace PHPOrchestra\BlockBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Form\FormBuilder;
use PHPOrchestra\BlockBundle\Type\ContactType;

/**
 * Description of ContactController
 * this controller allow to show form contact 
 * @author Ayman AWAD <ayman.awad@businessdecision.com>
 */
class ContactController extends Controller
{
    /**
     * 
     * Function to show contact form
     *
     * @param string $id id of block
     * @param string $class class of block
     */
    function showAction($id, $class)
    {
        $form = $this->createForm(new ContactType());
       
        return $this->render(
            'PHPOrchestraCMSBundle:Block/Contact:show.html.twig',
            array('form' => $form->createView())
        );
    }
    
    /**
     *
     * Function send a email 
     *
     * @param none
     *
     */
    function ContactMailSendAction()
    {
        $mailAdmin = null;//Email administrator

        $form = $this->createForm(new ContactType());

        $request = $this->get('request');

        if ($request->isMethod('POST')) {
            $form->bind($request);
         
            if ($form->isValid()) {
                //send alert message to webmaster
                $messageToAdmin = \Swift_Message::newInstance()
                    ->setSubject($form->get('Sujet')->getData())
                    ->setFrom($form->get('E-mail')->getData())
                    ->setTo($mailAdmin)
                    ->setBody(
                        $this->renderView(
                            'PHPOrchestraCMSBundle:Block/Email:show_admin.txt.twig',
                            array(
                                'name' => $form->get('Nom')->getData(),
                                'message' => $form->get('Message')->getData(),
                                'mail' => $form->get('E-mail')->getData()
                            )
                        )
                    );
                $this->get('mailer')->send($messageToAdmin);

                //send confirm e-mail for the user
                $messageToUser = \Swift_Message::newInstance()
                    ->setSubject("Votre demande de contact à été bien reçu")
                    ->setFrom($mailAdmin)
                    ->setTo($form->get('E-mail')->getData())
                    ->setBody(
                        $this->renderView(
                            'PHPOrchestraCMSBundle:Block/Email:show_user.txt.twig',
                            array('name' => "Orchestra")
                        )
                    );
                $this->get('mailer')->send($messageToUser);
            }
        }
        
        return $this->redirect($this->generateUrl('orchestra_page_home'));
    }


    /**
     *
     * Function to show contact form
     *
     * @param string $id id of block
     * @param string $class class of block
     */
    function showBackAction($id, $class)
    {
        $form = $this->createForm(new ContactType());

        return $this->render(
            'PHPOrchestraCMSBundle:Block/Contact:showBack.html.twig',
            array('form' => $form->createView())
        );
    }
}
