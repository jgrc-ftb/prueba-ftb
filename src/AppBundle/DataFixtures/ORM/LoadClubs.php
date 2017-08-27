<?php
namespace AppBundle\DataFixtures\ORM;

use Domain\Model\Club;
use Domain\Model\ClubTranslation;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClubs extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $languages = [
            'es' => 'Texto de ejemplo en español.',
            'en' => 'English example text.'
        ];

        $data = [
            [
                'name' => 'Real Madrid',
                'manager' => 'Zinedine Zidane',
            ],
            [
                'name' => 'Fútbol Club Barcelona',
                'manager' => 'Ernesto Valverde'
            ],
            [
                'name' => 'Atlético de Madrid',
                'manager' => 'Diego Simeone'
            ],
            [
                'name' => 'Real Sociedad',
                'manager' => 'Eusebio Sacristán'
            ],
            [
                'name' => 'Sevilla',
                'manager' => 'Eduardo Berizzo'
            ],
            [
                'name' => 'Valencia',
                'manager' => 'Marcelino García Toral'
            ],
            [
                'name' => 'Deportivo de la Coruña',
                'manager' => 'Pepe Mel'
            ]
        ];

        foreach ($data as $row) {
            $club = Club::create($row['name'], $row['manager']);
            $manager->persist($club);
            foreach ($languages as $locale => $description) {
                $translation = ClubTranslation::create(
                    $club,
                    $this->getReference($locale),
                    $row['name'] . ' - '. $description
                );
                $manager->persist($translation);
            }

        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}