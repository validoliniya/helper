<?php

namespace App\DataFixtures;

use App\Entity\Command\CommandSection;
use Doctrine\Persistence\ObjectManager;

class CommandSectionFixtures extends BaseFixture
{
    public const DEFAULT_COMMANDS_SECTIONS = [
        'openvpn', 'docker', 'handlers', 'mysql', 'tests', 'linux', 'server', 'composer', 'symfony', 'redis'
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(CommandSection::class, 10, function (CommandSection $commandSection, $count) {
            $commandSection->setName(self::DEFAULT_COMMANDS_SECTIONS[$count]);
        });

        $manager->flush();
    }

}