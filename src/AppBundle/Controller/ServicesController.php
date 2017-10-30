<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 27.09.17
 * Time: 18:51
 */


namespace  AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServicesController extends Controller {





    /**
     * @Route("/usluge/44441sd/")
     * @param Request $request
     */

    public function web44441sdAction(Request $request) {
        return $this -> render("views/web/services/44441sd.html.twig");
    }

    /**
     * @Route("/cms/usluge/44441sd/")
     * @param Request $request
     */

    public function cms44441sdAction(Request $request) {
        return $this -> render("views/cms/services/44441sd.html.twig");
    }


    /**
     * @Route("/usluge/newurl/")
     * @param Request $request
     */

    public function webnewurlAction(Request $request) {
        return $this -> render("views/web/services/newurl.html.twig");
    }

    /**
     * @Route("/cms/usluge/newurl/")
     * @param Request $request
     */

    public function cmsnewurlAction(Request $request) {
        return $this -> render("views/cms/services/newurl.html.twig");
    }


    /**
     * @Route("/usluge/34t3qgggas/")
     * @param Request $request
     */

    public function web34t3qgggasAction(Request $request) {
        return $this -> render("views/web/services/34t3qgggas.html.twig");
    }

    /**
     * @Route("/cms/usluge/34t3qgggas/")
     * @param Request $request
     */

    public function cms34t3qgggasAction(Request $request) {
        return $this -> render("views/cms/services/34t3qgggas.html.twig");
    }
}