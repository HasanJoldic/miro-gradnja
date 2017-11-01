<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 10/26/17
 * Time: 11:41 AM
 */

namespace  AppBundle\Controller;

use AppBundle\Entity\Date;
use AppBundle\Entity\GalleryImages;
use AppBundle\Entity\GlobalVariables;
use AppBundle\Entity\Service;
use AppBundle\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MailController extends Controller {
    /**
     * @Route("/kontakt/posalji-upit/")
     * @Method({"POST"})
     * @param Request $request
     */
    public function sendEnquireMailAction(Request $request, \Swift_Mailer $mailer) {
        $error = null;
        $success = null;

        $message = (new \Swift_Message("Upit"))
            ->setFrom("miro@miro-gradnja.hr")
            ->setTo("miro@miro-gradnja.hr")
            ->setSender($request->request->get("email"))
            ->setReplyTo($request->request->get("email"), $request->request->get("name"))
            ->setBody("Ime: ".$request->request->get("name")."\r\n"
                    ."Tel.: ".$request->request->get("tel")."\r\n"
                    ."Email: ".$request->request->get("email")."\r\n"."\r\n"."\r\n"."Poruka:"."\r\n"
                        .$request->request->get("message"))
        ;

        $error = $mailer->send($message);

        if ($error == 0) {
            $error = "Doslo je do greske prilikom slanja email-a!";
        } else {
            $error = null;
            $success = "Email je uspjesno poslat!";
        }

        return $this -> redirectToRoute("contact", [
            "error" => $error,
            "success" => $success
        ]);

    }
}