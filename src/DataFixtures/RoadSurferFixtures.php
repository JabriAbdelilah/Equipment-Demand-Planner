<?php

namespace App\DataFixtures;

use App\Entity\Campervan;
use App\Entity\CampervanType;
use App\Entity\Equipment;
use App\Entity\Order;
use App\Entity\OrderEquipment;
use App\Entity\Station;
use App\Entity\StationEquipment;
use App\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoadSurferFixtures extends Fixture
{
    private const STATIONS = [
        'Munich',
        'Paris',
        'Madrid',
        'Porto',
    ];

    private const USERS = [
        [
            'name' => 'Abdelilah Jabri',
            'phone' => '+212660782460',
            'email' => 'jbrabdelilah@gmail.com',
        ],
        [
            'name' => 'Janina Fritze',
            'phone' => '+49 (0) 89 - 2109 4815',
            'email' => 'j.fritze@roadsurfer.com',
        ],
        [
            'name' => 'John Webber',
            'phone' => '+49 (0) 89 - 2109 4815',
            'email' => 'j.webber@roadsurfer.com',
        ],
    ];

    private const CAMPERVAN_TYPES = [
        'Surfer Suite' => 5999,
        'Travel Home' => 7999,
        'Camper Cabin' => 8999,
        'Road House' => 12099,
    ];

    private const CAMPERVANS = [
        [
            'registration_number' => 'M DT 5081',
            'is_rented_out' => true,
        ],
        [
            'registration_number' => 'M DT 5082',
            'is_rented_out' => false,
        ],
        [
            'registration_number' => 'M DT 5083',
            'is_rented_out' => false,
        ],
    ];

    private const EQUIPMENTS = [
        [
            'name' => 'Portable toilet',
            'description' => 'Portable toilets',
            'price' => 1999,
            'max_order_quantity' => 6,
        ],
        [
            'name' => 'Bed sheet',
            'description' => 'Bed sheet',
            'price' => 999,
            'max_order_quantity' => 4,
        ],
        [
            'name' => 'Sleeping bag',
            'description' => 'Sleeping bag',
            'price' => 1599,
            'max_order_quantity' => 8,
        ],
        [
            'name' => 'Camping table',
            'description' => 'Camping table',
            'price' => 799,
            'max_order_quantity' => 2,
        ],
        [
            'name' => 'Chair',
            'description' => 'Chair',
            'price' => 499,
            'max_order_quantity' => 10,
        ],
    ];

    private const ORDERS = [
        [
            'functional_id' => 'R0120220514',
            'status' => Order::STATUS['IN_PROGRESS'],
            'pickup_station_id' => 1,
            'return_station_id' => 2,
            'user_id' => 1,
            'campervan_id' => 1,
        ],
        [
            'functional_id' => 'R0220220514',
            'status' => Order::STATUS['CONFIRMED'],
            'pickup_station_id' => 2,
            'return_station_id' => 1,
            'user_id' => 2,
            'campervan_id' => 2,
        ],
        [
            'functional_id' => 'R0320220514',
            'status' => Order::STATUS['CONFIRMED'],
            'pickup_station_id' => 3,
            'return_station_id' => 1,
            'user_id' => 3,
            'campervan_id' => 3,
        ],
    ];

    private const ORDER_EQUIPMENTS = [
        [
            'order' => 1,
            'equipment' => 1,
            'quantity' => 2,
        ],
        [
            'order' => 1,
            'equipment' => 2,
            'quantity' => 3,
        ],
        [
            'order' => 1,
            'equipment' => 3,
            'quantity' => 2,
        ],
        [
            'order' => 2,
            'equipment' => 4,
            'quantity' => 1,
        ],
        [
            'order' => 2,
            'equipment' => 5,
            'quantity' => 4,
        ],
        [
            'order' => 3,
            'equipment' => 1,
            'quantity' => 2,
        ],
        [
            'order' => 3,
            'equipment' => 3,
            'quantity' => 1,
        ],
    ];

    private const STATION_EQUIPMENTS = [
        [
            'equipment_id' => 1,
            'quantity' => 15,
        ],
        [
            'equipment_id' => 2,
            'quantity' => 20,
        ],
        [
            'equipment_id' => 3,
            'quantity' => 32,
        ],
        [
            'equipment_id' => 4,
            'quantity' => 13,
        ],
        [
            'equipment_id' => 5,
            'quantity' => 17,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $stations = [];
        foreach (self::STATIONS as $stationName) {
            $station = new Station();
            $station->setName($stationName);
            $stations[] = $station;
            $manager->persist($station);
        }

        $users = [];
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setFullname($userFixture['name']);
            $user->setEmail($userFixture['email']);
            $user->setPhone($userFixture['phone']);
            $users[] = $user;
            $manager->persist($user);
        }

        foreach (self::CAMPERVAN_TYPES as $campervanTypeName => $price) {
            $campervanType = new CampervanType();
            $campervanType->setName($campervanTypeName);
            $campervanType->setPrice($price);
            $manager->persist($campervanType);
        }

        $campervans = [];
        foreach (self::CAMPERVANS as $campervanFixture) {
            $campervan = new Campervan();
            $campervan->setRegistrationNumber($campervanFixture['registration_number']);
            $campervan->setIsRentedOut($campervanFixture['is_rented_out']);
            $campervan->setType($campervanType);
            $campervans[] = $campervan;
            $manager->persist($campervan);
        }

        $equipments = [];
        foreach (self::EQUIPMENTS as $equipmentFixture) {
            $equipment = new Equipment();
            $equipment->setName($equipmentFixture['name']);
            $equipment->setDescription($equipmentFixture['description']);
            $equipment->setPrice($equipmentFixture['price']);
            $equipment->setMaxOrderQuantity($equipmentFixture['max_order_quantity']);
            $equipments[] = $equipment;
            $manager->persist($equipment);
        }

        $orders = [];
        foreach (self::ORDERS as $key => $orderFixture) {
            $order = new Order();
            $order->setFunctionalId($orderFixture['functional_id']);
            $order->setStatus($orderFixture['status']);

            $order->setCampervan($campervans[$key]);

            $order->setUser($users[$key]);

            $order->setPickupStation($stations[$orderFixture['pickup_station_id'] - 1]);
            $order->setReturnStation($stations[$orderFixture['return_station_id'] - 1]);
            if (0 === $key) {
                $order->setStartDate(new DateTime());
                $order->setEndDate((new DateTime())->add(new DateInterval('P1D')));
            } else {
                $startInterval = 'P' . $key . 'D';
                $endInterval = 'P' . ($key + 5) . 'D';
                $order->setStartDate((new DateTime())->add(new DateInterval($startInterval)));
                $order->setEndDate((new DateTime())->add(new DateInterval($endInterval)));
            }
            $orders[] = $order;
            $manager->persist($order);
        }

        foreach (self::ORDER_EQUIPMENTS as $orderEquipmentFixture) {
            $orderEquipment = new OrderEquipment();
            $orderEquipment->setQuantity($orderEquipmentFixture['quantity']);
            $orderEquipment->setRent($orders[$orderEquipmentFixture['order'] - 1]);

            $orderEquipment->setEquipment($equipments[$orderEquipmentFixture['equipment'] - 1]);

            $manager->persist($orderEquipment);
        }

        for ($i = 0; $i < count(self::STATIONS); $i++) {
            foreach (self::STATION_EQUIPMENTS as $stationEquipmentFixture) {
                $stationEquipment = new StationEquipment();
                $stationEquipment->setStation($stations[$i]);
                $stationEquipment->setEquipment($equipments[$stationEquipmentFixture['equipment_id'] - 1]);
                $stationEquipment->setQuantity($stationEquipmentFixture['quantity']);
                $manager->persist($stationEquipment);
            }
        }

        $manager->flush();
    }
}
