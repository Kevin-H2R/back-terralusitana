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
                'varieties' => ['Castelão', 'Tinta Roriz', 'Pinot Noir']],
            ['name' => 'Azulejo Rosé',
                'description' => 'Un rosé léger très frais et savoureux, avec
                 des notes de fruits rouges, fraises et framboises.
                  Excellente fin en bouche.', 'soft' => 50,
                'dry' => 50, 'sweet' => 50, 'price' => 3.35,
                'imagePath' => 'azulejo-lisboa-vr-leve', 'alcohol' => 9.5,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Camarates', 'Cabernet Sauvignon']],
            ['name' => 'Azulejo Blanc',
                'description' => 'Extrêmement frais et aromatique.
                 Notes d\'agrumes et de fruits tropicaux. Vin léger disposant 
                 d\'une acidité rafraichissante. Partenaire idéal pour plats 
                 simple et saints.', 'soft' => 45,
                'dry' => 20, 'sweet' => 30, 'price' => 3.35,
                'imagePath' => 'azulejo-lisboa-vb-leve-750ml', 'alcohol' => 9.5,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Fernão Pires', 'Arinto', 'Vital', 'Moscatel']],
            ['name' => 'Colossal Reserve Rouge',
                'description' => 'Couleur rubis intense, ce vin propose des
                 arômes extrêmement riches en nez avec des notes prédominantes
                  de fruits rouges, de mûres et de fleurs. En bouche sa grande
                   complexité sera vous surprendre avec ses notes de mûres et 
                   de prunes. Fin en bouche riche et élégante.', 'soft' => 85,
                'dry' => 15, 'sweet' => 50, 'price' => 5.80,
                'imagePath' => 'colossal-vt', 'alcohol' => 14,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Syrah', 'Touriga Nacional', 'Alicante Bouschet', 'Tinta Roriz']],
            ['name' => 'Colossal Reserve Rosé',
                'description' => 'Belle couleur saumon, ce vin est très 
                aromatique et frais, notes de fraises et de baies. En bouche
                 on retrouve les notes de fraises ainsi que de framboises bien 
                 mariées à une excellente acidité et la minéralité typique de 
                 la région viticole de Lisbonne.', 'soft' => 50,
                'dry' => 50, 'sweet' => 50, 'price' => 4.99,
                'imagePath' => 'colossal-reserva-rose-2018', 'alcohol' => 12.5,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Cabernet Sauvignon', 'Castelão']],
            ['name' => 'Colossal Reserve Blanc',
                'description' => 'Vin extrêmement rafraîchissant riche en arômes
                 de fruits exotiques, de notes florales et d\'une acidité 
                 vibrante. Équilibré en bouche, il propose une combinaison 
                 optimale d\'agrumes et de bois, résultant d\'une étape en fûts 
                 de chêne. Ce vin présente une grande intensité et une 
                 minéralité typique de la région de Lisbonne.', 'soft' => 35,
                'dry' => 10, 'sweet' => 60, 'price' => 5.45,
                'imagePath' => 'colossal-reserva-lisboa-vb-2017', 'alcohol' => 12.5,
                'region' => 'Vin régional Lisbonne',
                'varieties' => ['Cabernet Sauvignon', 'Castelão']],
            ['name' => 'Montes Das Promessas Rouge',
                'description' => 'Teinte violette profonde. Bonne concentration 
                dans le nez, riches en arômes de fruits noirs combinés avec des
                 notes florales. En bouche, il se présente très fruité avec une
                  bonne structure indiquant un excellent équilibre entre tanins 
                  et acidité. Fin longue et élégante.', 'soft' => 75,
                'dry' => 30, 'sweet' => 50, 'price' => 4.50,
                'imagePath' => 'csl_monte_das_promessas_alentejo_2014_tinto_trat',
                'alcohol' => 14,
                'region' => 'Vin régional Alentejo',
                'varieties' => ['Syrah', 'Touriga Nacional', 'Alicante Bouschet', 'Petit Verdot']],
            ['name' => 'Bruto de Portugal Vinho Verde',
                'description' => 'Couleur agrûmes. Arômes de tilleuls, 
                d\'oranger et de fleurs. Saveur fruitée et acidité équilibrée. 
                Complexe et élégant en bouche.', 'soft' => 75,
                'dry' => 30, 'sweet' => 50, 'price' => 6.20,
                'imagePath' => 'bruto-de-pt-espumante-vinho-verde',
                'alcohol' => 11.5,
                'region' => 'DOC Vinho Verde',
                'varieties' => ['Loureiro']],
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
