<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 12.09.17
 * Time: 19:02
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Date;
use AppBundle\Entity\Service;
use Doctrine\ORM\Query\Expr\Math;
use Ramsey\Uuid\Uuid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServiceAddController extends Controller {

    /**
     * @Route("/cms/usluge/dodaj/", name="service_add")
     * @param Request $request
     */
    public function serviceAddAction(Request $request) {
        $error = $request->query->get("error");
        $success = $request->query->get("success");

        return $this->render("views/cms/servicesAdd.html.twig", [
            "error"=> $error,
            "success"=> $success
        ]);
    }

    /**
     * @Route("/cms/usluge/dodaj-novu/")
     * @Method({"POST"})
     * @param Request $request
     */
    public function serviceAddPostAction(Request $request) {
        $error = null;
        $success = null;
        $error = $this->validateCreateService($request);
        if ($error) {
            return $this->redirectToRoute("service_add", array(
                "error" => $error
            ));
        }

        $success = "Uspjesno je dodat novi element";
        $service = new Service();

        $textInputs = $request->request->all();
        $service->setTitle($textInputs["title"]);
        $service->setUrl($textInputs["url"]);
        $service->setDescriptionTitle($textInputs["description-title"]);
        $service->setDescription($textInputs["description"]);
        if ($textInputs["list-title"]) {
            $service->setListTitle($textInputs["list-title"]);
            $tempArray = array();
            for ($i = 0; $i < sizeof($textInputs["list-elements"]); $i++) {
                if ($textInputs["list-elements"][$i]) {
                    array_push($tempArray, $textInputs["list-elements"][$i]);
                }
            }
            $service->setList($tempArray);
        }

        $fileInputs = $request->files->all();
        $uuid = Uuid::uuid4();
        while (false) {
            $uuid = Uuid::uuid4();
        }
        $mainImage = $fileInputs["main-image"];
        $mainImage->move(__DIR__."/../../../web/static/images/all/", $uuid->toString().".jpg");
        $service->setMainImage($uuid->toString());
        $images = array();
        $sortedKeys = $this->sortImageInputs($fileInputs);
        for ($i = 0; $i < sizeof($sortedKeys); $i++) {
            $uuid = Uuid::uuid4();
            while (false) {
                $uuid = Uuid::uuid4();
            }
            $fileInputs[$sortedKeys[$i]]->move(__DIR__."/../../../web/static/images/all/", $uuid->toString().".jpg");
            $images[$uuid->toString()] = $textInputs[$sortedKeys[$i]."-text"];
        }
        $service->setImages($images);
        $service->setPlaceInList(1);
        $em = $this->getDoctrine()->getManager();

        $date = $em->getRepository(Date::class)->findOneByDate(date_create());
        $service->setDate($date);

        $em->persist($service);
        $em->flush();

        $date = $em->getRepository(Date::class)->findOneByDate(date_create());
        $cmsHomepageController = new CmsMainController();
        $cmsHomepageController->updateViewsFromDatabase($this, $date);

        return $this->redirectToRoute("service_add", [
            "error" => $error,
            "success" => $success
        ]);

    }

    /**
     * @Route("/cms/usluge/{url}/izbrisi/")
     * @Method({"POST"})
     * @param Request $request
     */
    public function serviceDeleteAction(Request $request) {
        $error = null;
        $success = null;

        $url = $request->attributes->get("url");

        $date = date_create();
        $em = $this->getDoctrine()->getManager();
        $dbRow = $em
            ->getRepository(Service::class)
            ->createQueryBuilder("q")
            ->join("q.date", "r")
            ->where("r.date = (:date)")
            ->setParameter("date", $date)
            ->getQuery()
            ->getResult();

        $serviceItem = null;
        foreach ($dbRow as $key=> $value) {
            if ($value->getUrl() == $url) {
                $serviceItem = $value;
            }
        }

        $em->remove($serviceItem);
        $em->flush();

        $date = $em->getRepository(Date::class)->findOneByDate(date_create());
        $cmsHomepageController = new CmsMainController();
        $cmsHomepageController->updateViewsFromDatabase($this, $date);

        return $this->redirectToRoute("services", [
            "error" => $error,
            "success" => $success
        ]);
    }

    private function validateCreateService(Request $request) {
        $textInputs = $request->request->all();
        $error = "";
        foreach (array("title", "url", "description-title", "description") as $key) {
            if (!$textInputs[$key]) {
                $error = $error."Naslov, url, naslov opisa, i tekst opisa ne smiju biti prazni<br>";
            }
        }

        $service = $this->getDoctrine()->getManager()->getRepository(Service::class)
            ->findOneByUrl($textInputs["url"]);
        if ($service) {
            $error = $error."Url, koju ste unijeli, je zauzeta <br>";
        }
        if ($textInputs["list-title"] == "") {
            for ($i = 0; $i < sizeof($textInputs["list-elements"]); $i++) {
                if ($textInputs["list-elements"][$i] != "") {
                    $error = $error."Ako elementi liste nisu prazni, onda naslov liste ne smije biti prazan<br>";
                }
            }
        }

        $fileInputs = $request->files->all();
        if (!$fileInputs["main-image"]) {
            $error = $error."Glavna slika ne smije ostati prazna<br>";
        }
        if (!exif_imagetype($fileInputs["main-image"])) {
            $error = $error."Glavna slika nije u pravom formatu<br>";
        }
        foreach ($fileInputs as $key => $value) {
            if($key != "main-image") {
                if (!exif_imagetype($fileInputs[$key])) {
                    $error = $error . "Jedna ili vise dodatnih slika nije u pravom formatu<br>";
                }
            }
        }
        return $error;
    }

    private function sortImageInputs($array) {
        $toReturnArray = array();
        for ($i = 1000; $i < 2000; $i++) {
            $key = "img".$i;
            if (array_key_exists($key, $array)) {
                array_push($toReturnArray, $key);
            }
        }
        return $toReturnArray;
    }


}