<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 12.09.17
 * Time: 14:42
 */

namespace AppBundle\Controller;

use AppBundle\Entity\AboutUs;
use AppBundle\Entity\Contact;
use AppBundle\Entity\GalleryImages;
use AppBundle\Entity\GlobalVariables;
use AppBundle\Entity\Service;
use AppBundle\Service\DatabaseHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\Date;

class CmsMainController extends Controller {

    /**
     * @Route("/cms/set-cms/", name="cms_set")
     * @Method({"POST"})
     * @param Request $request
     */
    public function cmsSetDatabaseAndUpdateViewsAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $date =  $em ->getRepository(\AppBundle\Entity\Date::class)->findOneByDate(date_create());

        $this->setVariables($request, $date);
        $dbHelper = $this->get(DatabaseHelper::class);
        $this->updateViewsFromDatabase($em, $dbHelper, $date);

        return $this -> redirectToRoute("cms_index");
    }

    /**
     * @Route("/cms/set-cms-soft/", name="cms_set_soft")
     * @Method({"POST"})
     * @param Request $request
     */
    public function cmsSetDatabaseAndUpdateViewsSoftAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $date =  $em ->getRepository(\AppBundle\Entity\Date::class)->findOneByDate(date_create());

        $this->setVariables($request, $date);
        $dbHelper = $this->get(DatabaseHelper::class);
        $this->updateViewsFromDatabase($em, $dbHelper, $date);

        return $this -> redirect($request->headers->get("referer"));
    }

    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //
    //

    private function setVariables($request, $date) {

        $this->setGlobalVariables($request, $date);
        $this->setGalleryImages($request, $date);
        $this->setContactVariables($request, $date);
        $this->setAboutUsVariables($request, $date);
        $this->resetDatabaseToDate($request, $date);
    }

    private function setGlobalVariables(Request $request, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $dbRow = $em->getRepository(GlobalVariables::class)->findOneByDate($date);

        if($dbRow) {
            $faviconImage = $request->files->get("faviconImage");
            $pageTitle = $request->request->get("pageTitle");
            $brandImage = $request->files->get("brandImage");
            $footerText = $request->request->get("footerText");
            $phoneNumber = $request->request->get("phone-number");
            $secondPhoneNumber = $request->request->get("second-phone-number");


            if ($faviconImage) {
                if ($faviconImage->getClientSize() > 0) {
                    $uuid = Uuid::uuid4();
                    $uuid = $uuid->toString();
                    $file = __DIR__ ."/../../../web/static/images/all/" . $uuid.".ico";
                    move_uploaded_file($faviconImage->getPathname(), $file);
                    $dbRow->setFaviconImage($uuid);
                }
            }

            if ($pageTitle) {
                $dbRow->setPageTitle($pageTitle);
            }

            if ($footerText) {
                $dbRow->setFooterText($footerText);
            }

            if ($brandImage) {
                if ($brandImage->getClientSize() > 0) {
                    $uuid = Uuid::uuid4();
                    $uuid = $uuid->toString();

                    $file = __DIR__ . "/../../../web/static/images/all/" . $uuid.".png";
                    move_uploaded_file($brandImage->getPathname(), $file);
                    $dbRow->setBrandImage($uuid);
                }
            }

            if ($phoneNumber) {
                $dbRow->setPhoneNumber($phoneNumber);
            }

            if ($secondPhoneNumber) {
                $dbRow->setSecondPhoneNumber($secondPhoneNumber);
            }

            $em->persist($dbRow);
            $em->flush();
        }
    }

    private function setGalleryImages(Request $request, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $dbRow = $em->getRepository(GalleryImages::class)->findOneByDate($date);

        if($dbRow) {
            $textVariables = $request->request->all();
            $imageFiles = $request->files->all();

            $i = 0;
            $galleryImages = array();
            while (array_key_exists("galleryImageFile".$i, $textVariables) ||
                array_key_exists("galleryImageFile".$i, $imageFiles)) {
                if (array_key_exists("galleryImageFile".$i, $textVariables)) {
                    $galleryImages[$textVariables["galleryImageFile".$i]] =
                        $textVariables["galleryImageText".$i];
                } else {
                    $uuid = Uuid::uuid4();
                    $uuid = $uuid->toString();
                    $file = __DIR__ . "/../../../web/static/images/all/" . $uuid.".jpg";
                    move_uploaded_file($imageFiles["galleryImageFile".$i]->getPathname(), $file);
                    $galleryImages[$uuid] = $textVariables["galleryImageText".$i];
                }
                $i++;
            }

            if ($galleryImages) {
                $dbRow->setImages($galleryImages);
            }

            $em->persist($dbRow);
            $em->flush();
        }
    }

    private function setContactVariables(Request $request, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $dbRow = $em->getRepository(Contact::class)->findOneByDate($date);

        if($dbRow) {
            $contactCompanyTitle = $request->request->get("contactCompanyTitle");
            $addressFirstLine = $request->request->get("addressFirstLine");
            $addressSecondLine = $request->request->get("addressSecondLine");
            $addressThirdLine = $request->request->get("addressThirdLine");
            $contactPhoneNumber = $request->request->get("contactPhoneNumber");
            $contactEmail = $request->request->get("contactEmail");
            $contactCompanyDescription = $request->request->get("contactCompanyDescription");
            $contactFacebookLink = $request->request->get("contactFacebookLink");

            if ($contactCompanyTitle) {
                $dbRow->setContactCompanyTitle($contactCompanyTitle);
            }
            if ($addressFirstLine) {
                $dbRow->setAddressFirstLine($addressFirstLine);
            }
            if ($addressSecondLine) {
                $dbRow->setAddressSecondLine($addressSecondLine);
            }
            if ($addressThirdLine) {
                $dbRow->setAddressThirdLine($addressThirdLine);
            }
            if ($contactPhoneNumber) {
                $dbRow->setContactPhoneNumber($contactPhoneNumber);
            }
            if ($contactEmail) {
                $dbRow->setContactEmail($contactEmail);
            }
            if ($contactCompanyDescription) {
                $dbRow->setContactCompanyDescription($contactCompanyDescription);
            }
            if ($contactFacebookLink) {
                $dbRow->setContactFacebookLink($contactFacebookLink);
            }

            $em->persist($dbRow);
            $em->flush();
        }
    }

    private function setAboutUsVariables(Request $request, $date)
    {
        $em = $this->getDoctrine()->getManager();
        $dbRow = $em->getRepository(AboutUs::class)->findOneByDate($date);

        if($dbRow) {
            $aboutUsTitle = $request->request->get("aboutUsTitle");
            $aboutUsText = $request->request->get("aboutUsText");

            if ($aboutUsTitle) {
                $dbRow->setAboutUsTitle($aboutUsTitle);
            }

            if ($aboutUsText) {
                $dbRow->setAboutUsText($aboutUsText);
            }
            $em->persist($dbRow);
            $em->flush();
        }
    }

    private function resetDatabaseToDate($request, $date) {
        $newDate = $request->request->get("reset-database-to-date");
        if ($newDate) {
            $newDate = date_create($newDate);
            $databaseHelper = $this->get(DatabaseHelper::class);
            $databaseHelper->resetToDate($newDate);
        }
    }


    public function updateViewsFromDatabase($em, $dbHelper, $date) {
        // $em = $self->getDoctrine()->getManager();

        $this->updateViewsForGlobalVariables($date, $em);
        $this->updateViewsForAboutUsVariables($date, $em);
        $this->updateViewsForContactVariables($date, $em);
        $this->updateViewsForGalleryImages($date, $em);
        $this->updateViewsForServiceItems($date, $em);
        $this->updateOtherViews();
        //$databaseHelper = $self->get(DatabaseHelper::class);
        //$databaseHelper->removeUnusedImages();
        $dbHelper->removeUnusedImages();

        exec("php /var/www/miro-gradnja/bin/console cache:clear --env=prod --no-debug");
    }

    private function updateViewsForGlobalVariables($date, $em) {

        $allDates = $em->getRepository(\AppBundle\Entity\Date::class)->findAll();
        $firstDate = null;
        $lastDate = -1;
        for ($i = 0; $i < sizeof($allDates); $i++) {
            if (!$firstDate) {
                $firstDate = $allDates[$i]->getId();
            }
            if ($allDates[$i]->getId() < $firstDate) {
                $firstDate = $allDates[$i]->getId();
            }
            if ($allDates[$i]->getId() > $lastDate && !(($i+1) == sizeof($allDates))) {
                $lastDate = $allDates[$i]->getId();
            }
        }
        $firstDate = $em->getRepository(\AppBundle\Entity\Date::class)->find($firstDate)->getDate()->format("Y-m-d");
        $lastDate = $em->getRepository(\AppBundle\Entity\Date::class)->find($lastDate)->getDate()->format("Y-m-d");

        $dbRow = $em->getRepository(GlobalVariables::class)->findOneByDate($date);
        if ($dbRow) {
            $headerTemplate = file_get_contents(__DIR__
                . "/../../../app/Resources/views/includes/includesTemplates/header.html.twig");
            $__insertSecondPhoneNumber__ = "";
            if ($dbRow->getSecondPhoneNumber()) {
                $__insertSecondPhoneNumber__ = '<p><i class="fa fa-phone" aria-hidden="true"></i>  '
                    . '{#cms<small>cms#}'.$dbRow->getSecondPhoneNumber().'{#cms</small>cms#}</p>';
            }
            $headerTemplate =
str_replace("__insertFaviconImage__", $dbRow->getFaviconImage(),
str_replace("__insertPageTitle__", $dbRow->getPageTitle(),
str_replace("__insertBrandImage__", $dbRow->getBrandImage(),
str_replace("__insertPhoneNumber__", $dbRow->getPhoneNumber(),
str_replace("__insertSecondPhoneNumber__", $__insertSecondPhoneNumber__,
str_replace("__insertMinDate__", $firstDate,
str_replace("__insertMaxDate__", $lastDate, $headerTemplate)))))));

            $footerTemplate = file_get_contents(__DIR__
                . "/../../../app/Resources/views/includes/includesTemplates/footer.html.twig");
            $footerTemplate = str_replace("__insertFooterText__",
                $dbRow->getFooterText(), $footerTemplate);

            // write templates to web section
            file_put_contents(__DIR__ . "/../../../app/Resources/views/".
                "includes/includes/all/header.html.twig",
                str_replace("{#web", "",
                    str_replace("web#}", "", $headerTemplate)));
            file_put_contents(__DIR__ . "/../../../app/Resources/views/".
                "includes/includes/all/footer.html.twig",
                str_replace("{#web", "",
                    str_replace("web#}", "", $footerTemplate)));

            // write templates to cms section
            file_put_contents(__DIR__ . "/../../../app/Resources/views/".
                "includes/includes/cms/header.html.twig",
                str_replace("{#cms", "",
                    str_replace("cms#}", "", $headerTemplate)));
            file_put_contents(__DIR__ . "/../../../app/Resources/views/".
                "includes/includes/cms/footer.html.twig",
                str_replace("{#cms", "",
                    str_replace("cms#}", "", $footerTemplate)));
        }
    }

    private function updateViewsForServiceItems($date, $em) {
        $serviceItems = $em->getRepository(Service::class)->findByDate($date);

        $actions = "";

        foreach ($serviceItems as $keyOuter=> $valueOuter) {
            $mainImage = $valueOuter->getMainImage();
            $images = $valueOuter->getImages();
            $url = $valueOuter->getUrl();

            $template = file_get_contents(__DIR__
                . "/../../../app/Resources/views/views/templates/serviceItem/serviceItem.html.twig");


            $__insertCarouselIndicators__ = '<li class="active"></li>';
            for ($i = 0; $i < sizeof($images); $i++) {
                $__insertCarouselIndicators__ = $__insertCarouselIndicators__ . "<li></li>";
            }
            $template = str_replace("__insertCarouselIndicators__", $__insertCarouselIndicators__, $template);

            $carouselItemTemplate = file_get_contents(__DIR__
                . "/../../../app/Resources/views/views/templates/serviceItem/carouselItemTemplate.html.twig");
            $__insertCarouselItems__ = str_replace("__insertIsActive__", "active",
                str_replace("__insertCarouselText__", "",
                    str_replace("__insertCarouselImage__", $mainImage, $carouselItemTemplate)));
            foreach ($images as $key => $value) {
                $__insertCarouselItems__ = $__insertCarouselItems__ . "\n" . str_replace(
                        "__insertIsActive__", "", str_replace(
                        "__insertCarouselText__", $value, str_replace("__insertCarouselImage__",
                        $key, $carouselItemTemplate)));
            }
            $template = str_replace("__insertCarouselItems__", $__insertCarouselItems__, $template);

            $__insertTitle__ = $valueOuter->getTitle();
            $__insertDescriptionTitle__ = $valueOuter->getDescriptionTitle();
            $__insertDescription__ = $valueOuter->getDescription();
            $__insertUrl__ = $valueOuter->getUrl();
            $template = str_replace("__insertTitle__", $__insertTitle__,
                str_replace("__insertDescriptionTitle__", $__insertDescriptionTitle__,
                    str_replace("__insertDescription__", $__insertDescription__,
                        str_replace("__insertUrl__", $__insertUrl__, $template))));

            $__insertList__ = "";
            if ($valueOuter->getListTitle()) {
                $__insertList__ = '<h3 class="my-3">' . $valueOuter->getListTitle() . '</h3><ul>';
                foreach ($valueOuter->getList() as $key => $value) {
                    if ($value) {
                        $__insertList__ = $__insertList__ . "\n<li>" . $value . "</li>";
                    }
                }
                $__insertList__ = $__insertList__ . "\n</ul>";
            }
            $template = str_replace("__insertList__", $__insertList__, $template);

            $__insertMainImage__ = $mainImage;
            $template = str_replace("__insertMainImage__", $__insertMainImage__, $template);

            $__insertImageCards__ = "";
            $__ImageCardTemplate__ = file_get_contents(__DIR__
                . "/../../../app/Resources/views/views/templates/serviceItem/imageCardTemplate.html.twig");
            $slideIndex = 1;
            foreach ($images as $key => $value) {
                $__insertImageCards__ = $__insertImageCards__ . "\n" .
                    str_replace("__insertSlideIndex__", $slideIndex,
                        str_replace("__insertImageUid__", $key,
                            str_replace("__insertImageText__", $value, $__ImageCardTemplate__)));
                $slideIndex++;
            }
            $template = str_replace("__insertImageCards__", $__insertImageCards__, $template);

            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/services/" .
                $url . ".html.twig", str_replace("{#web", "",
                str_replace("web#}", "", $template)));
            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/services/" .
                $url . ".html.twig", str_replace("{#cms", "",
                str_replace("cms#}", "", $template)));

            $template = file_get_contents(__DIR__."/templates/serviceAction");
            $template = str_replace("__insertUrl__", $url, $template);
            $template = str_replace("__insertActionName__", $url, $template);
            $actions = $actions."\n\n\n".$template;
        }

        $controllerTemplate= file_get_contents(__DIR__."/templates/ServicesController");
        $controllerTemplate = $controllerTemplate."\n\n".$actions."\n}";
        file_put_contents(__DIR__."/ServicesController.php", $controllerTemplate);

        $template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/services.html.twig");

        $__insertSidebar__Template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/serviceItem/serviceList/sidebarItem.html.twig");
        $__insertSidebar__ = "";
        foreach ($serviceItems as $key => $value) {
            $__insertSidebar__ = $__insertSidebar__ . str_replace("__insertScrollspyId__", "sidebar-item-" . $key,
                    str_replace("__insertTitle__", $value->getTitle(), $__insertSidebar__Template));
        }

        $__insertJumbotron__Template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/serviceItem/serviceList/jumbotronItem.html.twig");
        $__insertJumbotron__ = "";
        foreach ($serviceItems as $key => $value) {
            $__insertJumbotron__ = $__insertJumbotron__ . str_replace("__insertScrollspyId__", "sidebar-item-" . $key,
                    str_replace("__insertTitle__", $value->getTitle(),
                        str_replace("__insertMainImage__", $value->getMainImage(),
                            str_replace("__insertUrl__", $value->getUrl(), $__insertJumbotron__Template))));
        }


        $template = str_replace("__insertSidebar__", $__insertSidebar__,
            str_replace("__insertJumbotron__", $__insertJumbotron__, $template));

        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/services.html.twig",
            str_replace("{#web", "",
                str_replace("web#}", "", $template)));
        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/services.html.twig",
            str_replace("{#cms", "",
                str_replace("cms#}", "", $template)));

    }

    private function updateViewsForGalleryImages($date, $em) {
        $dbRow = $em->getRepository(GalleryImages::class)->findOneByDate($date);

        $template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/gallery/gallery.html.twig");
        $galleryImages = array();
        if ($dbRow) {
            $galleryImages = $dbRow->getImages();
        }
        $galleryImagesKeys = array_keys($galleryImages);
        $galleryImagesValues = array_values($galleryImages);

        $__insertCarouselIndicators__ = "";
        if (sizeof($galleryImages) > 0) {
            $__insertCarouselIndicators__ = $__insertCarouselIndicators__.'<li class="active"></li>';
        }
        for ($i = 1; $i < sizeof($galleryImages); $i++) {
            $__insertCarouselIndicators__ = $__insertCarouselIndicators__.'<li></li>';
        }

        $__insertCarouselItems__ = "";
        $__insertCarouselItems__Template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/gallery/carouselItemTemplate.html.twig");
        if (sizeof($galleryImages) > 0) {
            $__insertCarouselItems__ = $__insertCarouselItems__ ."\n". str_replace(
"__insertIsActive__", "active", str_replace(
"__insertCarouselImage__", $galleryImagesKeys[0], str_replace(
"__insertCarouselText__", $galleryImagesValues[0], $__insertCarouselItems__Template)));
        }
        for ($i = 1; $i < sizeof($galleryImages); $i++) {
            $__insertCarouselItems__ = $__insertCarouselItems__ ."\n".str_replace(
"__insertIsActive__", "", str_replace(
"__insertCarouselImage__", $galleryImagesKeys[$i], str_replace(
"__insertCarouselText__", $galleryImagesValues[$i], $__insertCarouselItems__Template)));
        }

        $__insertSlideIndex__ = 0;
        $addImageButtonTemplate = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/gallery/addImageButton.html.twig");
        $__insertImageCards__ = str_replace(
"__insertUid__", Uuid::uuid4(), $addImageButtonTemplate);
        $__insertImageCards__Template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/gallery/imageCardTemplate.html.twig");
        if (sizeof($galleryImages) > 0) {
            $__insertImageCards__ = $__insertImageCards__ ."\n". str_replace(
"__insertSlideIndex__", $__insertSlideIndex__, str_replace(
"__insertImageUid__", $galleryImagesKeys[0], str_replace(
"__insertImageText__", $galleryImagesValues[0], str_replace(
"{#cms {{ forms.cmsElementThumbnail() }} cms#}", "{#cms {{ forms.cmsElementThumbnail() }}".
"id='".$galleryImagesKeys[0]."' cms#}", $__insertImageCards__Template))));
            $__insertImageCards__ = $__insertImageCards__.str_replace(
"__insertUid__", $galleryImagesKeys[0], $addImageButtonTemplate);
            $__insertSlideIndex__++;
            for ($i = 1; $i < sizeof($galleryImages); $i++) {
                $__insertImageCards__ = $__insertImageCards__ . "\n" . str_replace(
                        "__insertSlideIndex__", $__insertSlideIndex__, str_replace(
                        "__insertImageUid__", $galleryImagesKeys[$i], str_replace(
                        "__insertImageText__", $galleryImagesValues[$i], str_replace(
                        "{#cms {{ forms.cmsElementThumbnail() }} cms#}", "{#cms {{ forms.cmsElementThumbnail() }} " .
                        "id='" . $galleryImagesKeys[$i] . "' cms#}", $__insertImageCards__Template))));
                $__insertImageCards__ = $__insertImageCards__ . str_replace(
                        "__insertUid__", $galleryImagesKeys[$i], $addImageButtonTemplate);

                $__insertSlideIndex__++;
            }
        } else {
            $__insertImageCards__ = $__insertImageCards__."</div>";
        }

        $template = str_replace(
"__insertCarouselIndicators__", $__insertCarouselIndicators__, str_replace(
"__insertCarouselItems__", $__insertCarouselItems__, str_replace(
"__insertImageCards__", $__insertImageCards__, $template)));

        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/gallery.html.twig",
str_replace("{#web", "",
str_replace("web#}", "", $template)));
        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/gallery.html.twig",
str_replace("{#cms", "",
str_replace("cms#}", "", $template)));

    }

    private function updateViewsForContactVariables($date, $em) {
        $dbRow = $em->getRepository(Contact::class)->findOneByDate($date);

        if ($dbRow) {
            $template = file_get_contents(__DIR__
                . "/../../../app/Resources/views/views/templates/contact.html.twig");
            $template = str_replace(
                "__insertContactCompanyTitle__", $dbRow->getContactCompanyTitle(), str_replace(
                "__insertAddressFirstLine__", $dbRow->getAddressFirstLine(), str_replace(
                "__insertAddressSecondLine__", $dbRow->getAddressSecondLine(), str_replace(
                "__insertAddressThirdLine__", $dbRow->getAddressThirdLine(), str_replace(
                "__insertContactPhoneNumber__", $dbRow->getContactPhoneNumber(), str_replace(
                "__insertContactEmail__", $dbRow->getContactEmail(), str_replace(
                "__insertContactCompanyDescription__", $dbRow->getContactCompanyDescription(), str_replace(
                "__insertContactFacebookLink__", $dbRow->getContactFacebookLink(),
                $template))))))));

            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/contact.html.twig",
                str_replace("{#web", "",
                    str_replace("web#}", "", $template)));
            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/contact.html.twig",
                str_replace("{#cms", "",
                    str_replace("cms#}", "", $template)));
        }
    }

    private function updateViewsForAboutUsVariables($date, $em) {
        $dbRow = $em->getRepository(AboutUs::class)->findOneByDate($date);

        if ($dbRow) {
            $template = file_get_contents(__DIR__
                . "/../../../app/Resources/views/views/templates/aboutUs.html.twig");
            $template = str_replace("__insertAboutUsTitle__",
                $dbRow->getAboutUsTitle(), str_replace("__insertAboutUsText__",
                    $dbRow->getAboutUsText(),  $template));

            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/aboutUs.html.twig",
                str_replace("{#web", "",
                    str_replace("web#}", "", $template)));
            file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/aboutUs.html.twig",
                str_replace("{#cms", "",
                    str_replace("cms#}", "", $template)));
        }
    }

    private function updateOtherViews() {
        $template = file_get_contents(__DIR__
            . "/../../../app/Resources/views/views/templates/index.html.twig");
        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/web/index.html.twig",
            str_replace("{#web", "",
                str_replace("web#}", "", $template)));
        file_put_contents(__DIR__ . "/../../../app/Resources/views/views/cms/index.html.twig",
            str_replace("{#cms", "",
                str_replace("cms#}", "", $template)));
    }
}