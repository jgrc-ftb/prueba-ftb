<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Model\Language;

class LoadLanguages extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'locale' => 'es',
                'name' => 'Español'
            ],
            [
                'locale' => 'en',
                'name' => 'English'
            ]
        ];

        foreach ($data as $row) {
            $language = Language::create($row['locale'], $row['name']);
            $manager->persist($language);
            $this->addReference($row['locale'], $language);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}