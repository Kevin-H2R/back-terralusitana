<?php

namespace App\DataFixtures;

use App\Entity\Region;
use App\Entity\Variety;
use App\Entity\Wine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class WineFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $regions = $this->loadRegions($manager);
        $varieties = $this->loadVarieties($manager);
        $wineData = [
            ['name' => 'Azulejo Rouge',
                'description' => 'Arômes intenses de cerises et de baies.
                 Long, agréable et persitant en bouche.', 'soft' => 75,
                'dry' => 30, 'sweet' => 50, 'price' => 3.85,
                'imagePath' => 'azulejo-lisboa-vt-750ml', 'alcohol' => 13,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Castelão', 'Tinta Roriz', 'Pinot Noir']]
        ];

        foreach ($wineData as $data) {
            $wine = new Wine();
            $wine->setName($data['name']);
            $wine->setDescription($data['description']);
            $wine->setSoft($data['soft']);
            $wine->setDry($data['dry']);
            $wine->setSweet($data['sweet']);
            $wine->setPrice($data['price']);
            $wine->setImagePath($data['imagePath']);
            $wine->setAlcohol($data['alcohol']);

            /** @var Region $regionObject */
            foreach ($regions as $region)
            {
                if ($region->getName() !== $data['region'])
                    continue;
                $wine->setRegion($region);
                break;
            }
            /** @var Variety $variety */
            foreach ($varieties as $variety) {
                if (in_array($variety->getName(), $data['varieties'])) {
                    $wine->addVariety($variety);
                }
            }

            $manager->persist($wine);
        }
        $manager->flush();
    }

    private function loadVarieties(ObjectManager $manager): array
    {
        $varieties = ['Castelão', 'Tinta Roriz', 'Pinot Noir', 'Camarates',
            'Cabernet Sauvignon', 'Fernão Pires', 'Arinto', 'Vital', 'Moscatel',
            'Syrah', 'Touriga Nacional', 'Alicante Bouschet',
            'Alicante Bouschet', 'Petit Verdot','Loureiro'];

        $result = [];
        foreach ($varieties as $varietyName) {
            $variety = new Variety();
            $variety->setName($varietyName);
            $result[] = $variety;
            $manager->persist($variety);
        }
        $manager->flush();
        return $result;
    }

    private function loadRegions(ObjectManager $manager): array
    {
        $regionData = [
            ['name' => 'Vin régional Lisbonne', 'imagePath' => 'lisbonne'],
            ['name' => 'Vin régional Alentejo', 'imagePath' => 'alentejo'],
            ['name' => 'DOC Vinho Verde', 'imagePath' => 'vinhoverde'],
        ];
        $result = [];
        foreach ($regionData as $data) {
            $region = new Region();
            $region->setName($data['name']);
            $region->setImagePath($data['imagePath']);
            $manager->persist($region);
            $result[] = $region;
        }
        $manager->flush();

        return $result;
    }
}
