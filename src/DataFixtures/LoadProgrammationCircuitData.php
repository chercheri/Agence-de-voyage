<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\ProgrammationCircuit;

class LoadProgrammationCircuitData extends Fixture implements DependentFixtureInterface{
    public function load(ObjectManager $manager)
    {
        $circuit = $this->getReference('andalousie-circuit');
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2018-08-08"));
        $prog->setNombrePersonnes(25);
        $prog->setPrix(50);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2019-08-08"));
        $prog->setNombrePersonnes(50);
        $prog->setPrix(20);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $manager->persist($circuit);
        
        $circuit = $this->getReference('idf-circuit');
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2020-08-08"));
        $prog->setNombrePersonnes(25);
        $prog->setPrix(100);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2019-01-01"));
        $prog->setNombrePersonnes(100);
        $prog->setPrix(200);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $manager->persist($circuit);
        
        $circuit = $this->getReference('italie-circuit');
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2018-08-08"));
        $prog->setNombrePersonnes(140);
        $prog->setPrix(140);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $prog = new ProgrammationCircuit();
        $prog->setDateDepart(\DateTime::createFromFormat('Y-m-d', "2019-08-08"));
        $prog->setNombrePersonnes(150);
        $prog->setPrix(120);
        $circuit->addProgrammationCircuit($prog);
        $manager->persist($prog);
        
        $manager->persist($circuit);
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadCircuitData::class,
        );
    }

    
}