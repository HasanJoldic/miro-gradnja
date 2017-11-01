<?php
/**
 * Created by PhpStorm.
 * User: hasan
 * Date: 10/27/17
 * Time: 5:24 PM
 */

namespace AppBundle\Command;

use AppBundle\Controller\CmsMainController;
use AppBundle\Entity\AboutUs;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Date;
use AppBundle\Entity\GalleryImages;
use AppBundle\Entity\GlobalVariables;
use AppBundle\Entity\Service;
use AppBundle\Service\DatabaseHelper;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CopyDatabaseToNewDateCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:copy-date')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create a new date table')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command copies all data from previous date and links the copies to today\'s date')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        $dates = $em->getRepository(Date::class)->findAll();
        $currentDateId = -1;

        foreach ($dates as $key=> $value) {
            if ($value->getId() > $currentDateId) {
                $currentDateId = $value->getId();
            }
        }

        $currentDate = $em->getRepository(Date::class)->find($currentDateId);
        $newDate = new Date();
        $newDate->setDate(date_create());
        $em->persist($newDate);

        $aboutUs = $em->getRepository(AboutUs::class)->findOneByDate($currentDate);
        $contact = $em->getRepository(Contact::class)->findOneByDate($currentDate);
        $galleryImages = $em->getRepository(GalleryImages::class)->findOneByDate($currentDate);
        $globalVariables = $em->getRepository(GlobalVariables::class)->findOneByDate($currentDate);
        $services = $em->getRepository(Service::class)->findByDate($currentDate);

        $newAboutUs = clone $aboutUs;
        $newAboutUs->setDate($newDate);
        $em->persist($newAboutUs);

        $newContact = clone $contact;
        $newContact->setDate($newDate);
        $em->persist($newContact);

        $newGalleryImages = clone $galleryImages;
        $newGalleryImages->setDate($newDate);
        $em->persist($newGalleryImages);

        $newGlobalVariables = clone $globalVariables;
        $newGlobalVariables->setDate($newDate);
        $em->persist($newGlobalVariables);

        foreach ($services as $key=> $value) {
            $newService = clone $value;
            $newService->setDate($newDate);
            $em->persist($newService);
        }

        $em->flush();
        $em = $this->getContainer()->get("doctrine.orm.entity_manager");

        $cmsHomepageController = new CmsMainController();
        $dbHelper = $this->getContainer()->get("database_helper");
        $cmsHomepageController->updateViewsFromDatabase($em, $dbHelper, $currentDate);
    }
}