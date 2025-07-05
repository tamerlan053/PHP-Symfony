<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
class ItemFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);

        $itemsData = [
            ['name' => 'Dell XPS 13 Laptop', 'description' => '13-inch laptop met Intel Core i7, 16GB RAM, 512GB SSD', 'price' => 1199.99, 'quantity' => 12],
            ['name' => 'LG UltraFine 27MD5KL-B Monitor', 'description' => '27 inch 5K Retina Display, perfect voor grafisch werk', 'price' => 1299.00, 'quantity' => 5],
            ['name' => 'Logitech MX Master 3 Muismat', 'description' => 'Ergonomische draadloze muis met programmeerbare knoppen', 'price' => 99.99, 'quantity' => 8],
            ['name' => 'Corsair K95 RGB Platinum Keyboard', 'description' => 'Mechanisch gaming toetsenbord met RGB verlichting', 'price' => 179.99, 'quantity' => 17],
            ['name' => 'Sony WH-1000XM4 Headset', 'description' => 'Draadloze noise-cancelling koptelefoon met lange batterijduur', 'price' => 349.00, 'quantity' => 3],
            ['name' => 'Logitech C920 HD Pro Webcam', 'description' => '1080p HD webcam ideaal voor videoconferenties', 'price' => 79.99, 'quantity' => 14],
            ['name' => 'Samsung 970 EVO Plus 1TB SSD', 'description' => 'NVMe M.2 SSD voor snelle opslag en laadtijden', 'price' => 149.99, 'quantity' => 9],
            ['name' => 'HP OfficeJet Pro 9015 Printer', 'description' => 'All-in-one inkjet printer met hoge printsnelheid', 'price' => 229.99, 'quantity' => 6],
            ['name' => 'Anker USB-C Hub', 'description' => '6-in-1 USB-C hub met HDMI, USB 3.0 en SD kaartlezer', 'price' => 59.99, 'quantity' => 11],
            ['name' => 'Rain Design mStand Laptopstandaard', 'description' => 'Aluminium standaard voor betere ventilatie en houding', 'price' => 39.95, 'quantity' => 2],
            ['name' => 'Netgear Nighthawk R7000 Router', 'description' => 'Dual-band WiFi router met hoge doorvoersnelheid', 'price' => 159.99, 'quantity' => 13],
            ['name' => 'JBL Flip 5 Bluetooth Speaker', 'description' => 'Draagbare waterbestendige speaker met helder geluid', 'price' => 89.99, 'quantity' => 18],
            ['name' => 'Ergotron LX Monitorarm', 'description' => 'Flexibele monitorarm voor ergonomische werkplekken', 'price' => 129.95, 'quantity' => 4],
            ['name' => 'AmazonBasics HDMI Kabel', 'description' => 'High-Speed HDMI kabel van 2 meter lengte', 'price' => 12.99, 'quantity' => 7],
            ['name' => 'Incase Icon Sleeve voor 15-inch MacBook', 'description' => 'Slanke beschermhoes van neopreen materiaal', 'price' => 34.99, 'quantity' => 16],
            ['name' => 'Apple MacBook Pro 14-inch', 'description' => 'Apple M2 Pro chip, 16GB RAM, 1TB SSD, Space Gray', 'price' => 2399.00, 'quantity' => 1],
            ['name' => 'Asus ROG Strix G15 Gaming Laptop', 'description' => '15.6" 144Hz, AMD Ryzen 7, RTX 3060, 16GB RAM, 1TB SSD', 'price' => 1399.99, 'quantity' => 19],
            ['name' => 'BenQ EX3501R Curved Monitor', 'description' => '35" UltraWide QHD monitor met HDR en USB-C', 'price' => 649.00, 'quantity' => 10],
            ['name' => 'Razer DeathAdder V2 Gaming Muis', 'description' => 'Ergonomische muis met optische switches en Razer Chroma', 'price' => 59.99, 'quantity' => 15],
            ['name' => 'SteelSeries Apex Pro TKL Keyboard', 'description' => 'Tenkeyless mechanisch toetsenbord met OLED display', 'price' => 199.99, 'quantity' => 20],
            ['name' => 'Bose QuietComfort Earbuds II', 'description' => 'Noise-cancelling draadloze oordopjes met superieure audio', 'price' => 299.00, 'quantity' => 6],
            ['name' => 'Logitech BRIO 4K Webcam', 'description' => 'Ultra HD 4K video, HDR, Windows Hello compatibel', 'price' => 199.00, 'quantity' => 13],
            ['name' => 'Crucial P5 Plus 2TB SSD', 'description' => 'Gen4 NVMe M.2 SSD met lees-/schrijfsnelheden tot 6600 MB/s', 'price' => 229.99, 'quantity' => 9],
        ];

        foreach ($itemsData as $data) {
            $item = new Item();
            $item->setName($data['name']);
            $item->setDescription($data['description']);
            $item->setPrice($data['price']);
            $item->setQuantity($data['quantity']);
            $item->setUser($user);

            $manager->persist($item);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [AppFixtures::class];
    }
}