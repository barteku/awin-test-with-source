<?php

namespace App\DataFixtures;

use Awin\Tools\CoffeeBreak\Entity\CoffeeBreakPreference;
use Awin\Tools\CoffeeBreak\Entity\OfficeTeam;
use Awin\Tools\CoffeeBreak\Entity\OfficeTeamInterface;
use Awin\Tools\CoffeeBreak\Entity\StaffMember;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $teams = ['developers', 'support', 'hr'];

        foreach ($teams as $key=>$team) {
            $object = new OfficeTeam();
            $object->setName($team);
            $object->setPreferredContactService($key > 0 ? OfficeTeamInterface::CONTACT_SERVICE_EMAIL : OfficeTeamInterface::CONTACT_SERVICE_SLACK);

            $manager->persist($object);

            $this->setReference(sprintf('%sTeam', $team), $object);
        }


        $staff = [
            [
                'name' => 'bart',
                'email' => 'bart@email.com',
                'slack' => "slackUserId",
                'team' => $this->getReference('developersTeam'),
                'preferences' => [
                    [
                        'food' => CoffeeBreakPreference::TYPES[0],
                        'type' => CoffeeBreakPreference::FOOD_TYPES[0],
                        'details' => [
                            'flavour' => 'Salmon & cream cheese'
                        ]

                    ],
                    [
                        'food' => CoffeeBreakPreference::TYPES[1],
                        'type' => CoffeeBreakPreference::DRINK_TYPES[0],
                        'details' => [
                            'number_of_sugars' => 1,
                            'milk' => false
                        ]

                    ]
                ]
            ],
            [
                'name' => 'john',
                'email' => 'john@email.com',
                'slack' => null,
                'team' => $this->getReference('supportTeam'),
                'preferences' => [
                    [
                        'food' => CoffeeBreakPreference::TYPES[0],
                        'type' => CoffeeBreakPreference::FOOD_TYPES[2],
                        'details' => [
                            'flavour' => 'Ham & cheese'
                        ]

                    ],
                    [
                        'food' => CoffeeBreakPreference::TYPES[1],
                        'type' => CoffeeBreakPreference::DRINK_TYPES[1],
                        'details' => [
                            'number_of_sugars' => 2,
                            'milk' => true
                        ]

                    ],
                ]

            ],
            [
                'name' => 'alice',
                'email' => 'alice@email.com',
                'slack' => null,
                'team' => $this->getReference('hrTeam'),
                'preferences' => [
                    [
                        'food' => CoffeeBreakPreference::TYPES[0],
                        'type' => CoffeeBreakPreference::FOOD_TYPES[1],
                        'details' => [
                            'flavour' => 'paprika'
                        ]

                    ],
                    [
                        'food' => CoffeeBreakPreference::TYPES[1],
                        'type' => CoffeeBreakPreference::DRINK_TYPES[1],
                        'details' => [
                            'number_of_sugars' => 1,
                            'milk' => true
                        ]

                    ],
                ]
            ],
        ];


        foreach ($staff as $staffMember){
            $sm = new StaffMember();
            $sm->setName($staffMember['name']);
            $sm->setEmail($staffMember['email']);
            $sm->setTeam($staffMember['team']);
            $sm->setSlackIdentifier($staffMember['slack']);

            $manager->persist($sm);

            foreach ($staffMember['preferences'] as $preference){
                $p = new CoffeeBreakPreference($preference['food'], $preference['type'], $sm, $preference['details']);
                $p->setRequestedDate(new \DateTime('today'));
                $manager->persist($p);
            }

        }


        $manager->flush();
    }
}
