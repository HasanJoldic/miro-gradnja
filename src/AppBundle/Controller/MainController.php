<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 11.09.17
 * Time: 20:16
 */

namespace  AppBundle\Controller;

use AppBundle\Entity\AboutUs;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Date;
use AppBundle\Entity\GalleryImages;
use AppBundle\Entity\GlobalVariables;
use AppBundle\Entity\Service;
use AppBundle\Entity\User;
use AppBundle\Service\DatabaseHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MainController extends Controller {

    /**
     * @Route("/", name="index")
     * @param Request $request
     */

    public function indexAction(Request $request)
    {
        return $this -> render("views/web/index.html.twig");
    }

    /**
     * @Route("/cms/", name="cms_index")
     * @Method({"GET"})
     * @param Request $request
     */
    public function cmsIndexAction(Request $request) {
        return $this -> render("views/cms/index.html.twig");
    }

    /**
     * @Route("/usluge/", name="services")
     * @Method({"GET"})
     * @param Request $request
     */
    public function servicesAction(Request $request) {

        return $this->render("views/web/services.html.twig");
    }

    /**
     * @Route("/cms/usluge/", name="cms_services")
     * @Method({"GET"})
     * @param Request $request
     */
    public function cmsServicesAction(Request $request) {

        return $this->render("views/cms/services.html.twig");
    }

    /**
     * @Route("/galerija/", name="gallery")
     * @param Request $request
     */

    public function galleryAction(Request $request)
    {
        return $this -> render("views/web/gallery.html.twig");
    }

    /**
     * @Route("/cms/galerija/", name="cms_gallery")
     * @param Request $request
     */

    public function cmsGalleryAction(Request $request)
    {
        return $this -> render("views/cms/gallery.html.twig");
    }

    /**
     * @Route("/kontakt/", name="contact")
     * @param Request $request
     */

    public function contactAction(Request $request)
    {
        $error = $request->query->get("error");
        $success = $request->query->get("success");

        return $this -> render("views/web/contact.html.twig", [
            "error"=> $error,
            "success"=> $success
        ]);
    }

    /**
     * @Route("/cms/kontakt/", name="cms_contact")
     * @param Request $request
     */

    public function cmsContactAction(Request $request)
    {
        return $this -> render("views/cms/contact.html.twig");
    }

    /**
     * @Route("/o-nama/", name="about_us")
     * @param Request $request
     */

    public function aboutUsAction(Request $request)
    {
        return $this -> render("views/web/aboutUs.html.twig");
    }

    /**
     * @Route("/cms/o-nama/", name="cms_about_us")
     * @param Request $request
     */
    public function cmsAboutUsAction(Request $request)
    {
        return $this -> render("views/cms/aboutUs.html.twig");
    }
}