<?php

namespace App\Service;

use App\Entity\Station;
use App\Repository\EquipmentRepository;
use App\Repository\OrderRepository;
use App\Repository\StationRepository;
use DateInterval;
use DatePeriod;
use DateTime;

class EquipmentService
{
    public function __construct(
        private readonly StationRepository   $stationRepository,
        private readonly OrderRepository     $orderRepository,
        private readonly EquipmentRepository $equipmentRepository,
    ) {}

    public function getAllEquipments(): array
    {
        return $this->equipmentRepository->findAll();
    }

    public function getEquipmentsForDateInterval(DateTime $startDate, DateTime $endDate): array
    {
        $equipments = [];
        $period = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate,
        );
        $stations = $this->stationRepository->findAll();
        $allEquipments = $this->getAllEquipments();
        foreach ($stations as $station) {
            $equipmentsForStation = [
                'station' => $station->toArray(),
                'days' => []
            ];
            $inStockEquipments = $station->getEquipments();
            foreach ($period as $day) {
                $bookedByDay = $this->getBookedEquipmentsByDayAndStation($day, $station);
                $bookedByFromStationInDateInterval = $this->getBookedEquipmentsByDateIntervalAndStation($startDate, $day, $station);
                $returned = $this->getReturnedEquipmentsByDateIntervalAndStation($startDate, $day, $station);
                $bookedByDayEquipmentsQuantities = $this->getBookedEquipmentsQuantitiesByStation(
                    $allEquipments,
                    $bookedByDay,
                );
                $bookedByFromStationInDateIntervalEquipmentsQuantities = $this->getBookedEquipmentsQuantitiesByStation(
                    $allEquipments,
                    $bookedByFromStationInDateInterval,
                );
                $availableEquipmentsQuantities = $this->getAvailableEquipmentsQuantitiesByStation(
                    $allEquipments,
                    $inStockEquipments,
                    $returned,
                    $bookedByFromStationInDateIntervalEquipmentsQuantities
                );
                $dayData = [
                    'day'  => $day,
                    'bookedEquipments' => $bookedByDayEquipmentsQuantities,
                    'availableEquipments' => $availableEquipmentsQuantities
                ];
                $equipmentsForStation['days'][] = $dayData;
            }
            $equipments[] = $equipmentsForStation;
        }

        return $equipments;
    }

    private function getBookedEquipmentsByDayAndStation(DateTime $date, Station $station): array
    {
        $equipments = [];
        $orders = $this->orderRepository->findByPickupStationAndDate($station->getId(), $date);

        if (empty($orders)) {
            return $equipments;
        }

        foreach ($orders as $order) {
            $orderEquipments = $order->getEquipments();
            if (empty($orderEquipments)) {
                continue;
            }
            foreach ($orderEquipments as $orderEquipment) {
                $equipments[] = $orderEquipment;
            }
        }

        return $equipments;
    }

    private function getBookedEquipmentsByDateIntervalAndStation(DateTime $startDate, DateTime $endDate, Station $station): array
    {
        $equipments = [];
        $orders = $this->orderRepository->findByPickupStationAndDateInterval($station->getId(), $startDate, $endDate);

        if (empty($orders)) {
            return $equipments;
        }

        foreach ($orders as $order) {
            $orderEquipments = $order->getEquipments();
            if (empty($orderEquipments)) {
                continue;
            }
            foreach ($orderEquipments as $orderEquipment) {
                $equipments[] = $orderEquipment;
            }
        }

        return $equipments;
    }

    private function getBookedEquipmentsQuantitiesByStation($equipments, $bookedEquipments): array
    {
        $result = [];
        foreach ($equipments as $equipment) {
            $quantity = 0;
            foreach ($bookedEquipments as $bookedEquipment) {
                if ($bookedEquipment->getEquipment()->getId() === $equipment->getId()) {
                    $quantity += $bookedEquipment->getQuantity();
                }
            }

            $result[] = [
                'equipment' => $equipment->toArray(),
                'quantity'  => $quantity,
            ];
        }

        return $result;
    }

    private function getReturnedEquipmentsByDateIntervalAndStation(
        DateTime $startDay,
        DateTime $endDay,
        Station $station
    ): array {
        $equipments = [];
        $orders = $this->orderRepository->findByReturnStationAndDateInterval($station->getId(), $startDay, $endDay);

        if (empty($orders)) {
            return $equipments;
        }

        foreach ($orders as $order) {
            $orderEquipments = $order->getEquipments();
            if (empty($orderEquipments)) {
                continue;
            }
            foreach ($orderEquipments as $orderEquipment) {
                $equipments[] = $orderEquipment;
            }
        }

        return $equipments;
    }

    private function getAvailableEquipmentsQuantitiesByStation(
        $equipments,
        $inStockEquipments,
        $returnedEquipments,
        $bookedEquipmentsQuantities
    ): array
    {
        $result = [];
        foreach ($equipments as $key => $equipment) {
            $quantity = 0;
            foreach ($inStockEquipments as $inStockEquipment) {
                if ($inStockEquipment->getEquipment()->getId() === $equipment->getId()) {
                    $quantity = $inStockEquipment->getQuantity();
                }
            }
            foreach ($returnedEquipments as $returnedEquipment) {
                if ($returnedEquipment->getEquipment()->getId() === $equipment->getId()) {
                    $quantity += $returnedEquipment->getQuantity();
                }
            }
            $quantity -= $bookedEquipmentsQuantities[$key]['quantity'];

            $result[] = [
                'equipment' => $equipment->toArray(),
                'quantity'  => $quantity,
            ];
        }

        return $result;
    }
}
