<?php

namespace App\DataFixtures;

use App\Entity\Links\LinkSection;
use Doctrine\Persistence\ObjectManager;

class CommandLinkSectionFixtures extends BaseFixture
{
    public const DEFAULT_LINKS_SECTIONS = [
        'php', 'js', 'python'
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(LinkSection::class, count(self::DEFAULT_LINKS_SECTIONS), function (LinkSection $commandSection, $count) {
            $commandSection->setName(self::DEFAULT_LINKS_SECTIONS[$count]);
        });

        $manager->flush();
    }

}
