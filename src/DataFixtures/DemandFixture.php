<?php

namespace App\DataFixtures;

use App\Entity\Demand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DemandFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $demand = new Demand();
            $demand->setDate(new \DateTime());
            $demand->setDemand([
                $faker->name,
                $faker->email,
                $faker->sentence,
            ]);
            $demand->setStatus("New");
            $manager->persist($demand);}
        
        for ($j = 0; $j < 3; $j++) {
                $email="lalala@gmail.com";
                $demand = new Demand();
                $demand->setDate(new \DateTime());
                $demand->setDemand([
                    $faker->name,
                    $email,
                    $faker->sentence,
                ]);
                $demand->setStatus("New");
                $manager->persist($demand);
            }
        
        for ($k = 0; $k < 3; $k++) {
                $email="hello@gmail.com";
                $demand = new Demand();
                $demand->setDate(new \DateTime());
                $demand->setDemand([
                    $faker->name,
                    $email,
                    $faker->sentence,
                ]);
                $demand->setStatus("New");
                $manager->persist($demand);
            }
        
        
        $manager->flush();
    }      }  

    

