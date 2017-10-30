<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 10/30/17
 * Time: 11:29 AM
 */

namespace AppBundle\Service;

use AppBundle\Entity\AboutUs;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Date;
use AppBundle\Entity\GalleryImages;
use AppBundle\Entity\GlobalVariables;
use Doctrine\ORM\EntityManager;
use Proxies\__CG__\AppBundle\Entity\Service;

class DatabaseHelper
{
    public function __construct(EntityManager $em)  {
        $this->em = $em;
    }

    public function resetToDate($date)
    {
        $em = $this->em;

        $currentDate = $em->getRepository(Date::class)->findOneByDate(date_create());

        $newDate = $em->getRepository(Date::class)->findOneByDate($date);

        $aboutUs = $em->getRepository(AboutUs::class)->findOneByDate($currentDate);
        $em->remove($aboutUs);
        $contact = $em->getRepository(Contact::class)->findOneByDate($currentDate);
        $em->remove($contact);
        $galleryImages = $em->getRepository(GalleryImages::class)->findOneByDate($currentDate);
        $em->remove($galleryImages);
        $globalVariables = $em->getRepository(GlobalVariables::class)->findOneByDate($currentDate);
        $em->remove($globalVariables);
        $services = $em->getRepository(Service::class)->findByDate($currentDate);
        foreach ($services as $ket=> $value) {
            $em->remove($value);
        }
        $em->flush();

        $newAboutUs = clone $em->getRepository(AboutUs::class)->findOneByDate($newDate);
        $newAboutUs->setDate($currentDate);
        $em->persist($newAboutUs);

        $newContact = clone $em->getRepository(Contact::class)->findOneByDate($newDate);
        $newContact->setDate($currentDate);
        $em->persist($newContact);

        $newGalleryImages = clone $em->getRepository(GalleryImages::class)->findOneByDate($newDate);
        $newGalleryImages->setDate($currentDate);
        $em->persist($newGalleryImages);

        $newGlobalVariables = clone $em->getRepository(GlobalVariables::class)->findOneByDate($newDate);
        $newGlobalVariables->setDate($currentDate);
        $em->persist($newGlobalVariables);

        $services = $em->getRepository(Service::class)->findByDate($newDate);
        foreach ($services as $key=> $value) {
            $newService = clone $value;
            $newService->setDate($currentDate);
            $em->persist($newService);
        }
        $em->flush();
    }

    public function removeUnusedImages()
    {
        $__DIR__ = "../web/static/images/all/";

        $allUidsInDb = array();
        $em = $this->em;

        $galleryImagesRows = $em->getRepository(GalleryImages::class)->findAll();
        for ($i = 0; $i < sizeof($galleryImagesRows); $i++) {
            foreach ($galleryImagesRows[$i]->getImages() as $key=> $value) {
                array_push($allUidsInDb, $key);
            }
        }

        $globalVariables = $em->getRepository(GlobalVariables::class)->findAll();
        for ($i = 0; $i < sizeof($globalVariables); $i++) {
            array_push($allUidsInDb, $globalVariables[$i]->getFaviconImage());
            array_push($allUidsInDb, $globalVariables[$i]->getBrandImage());
        }

        $serviceRows = $em->getRepository(Service::class)->findAll();
        for ($i = 0; $i < sizeof($serviceRows); $i++) {
            array_push($allUidsInDb, $serviceRows[$i]->getMainImage());
            foreach ($serviceRows[$i]->getImages() as $key=> $value) {
                array_push($allUidsInDb, $key);
            }
        }

        $files = scandir($__DIR__);
        $files = array_diff($files, [".", ".."]);

        foreach ($files as $key=> $value) {
            $uid = substr($value, 0, 36);
            $filePath = $__DIR__.$value;
            if (!in_array($uid, $allUidsInDb)) {
                unlink($filePath);
            }
        }
    }
}