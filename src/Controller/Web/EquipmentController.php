<?php

namespace App\Controller\Web;

use App\Service\EquipmentService;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentController extends AbstractController
{
    #[Route('/')]
    public function index(EquipmentService $equipmentService): Response
    {
        //I hard coded the dates only for testing purposes
        $startDate = new DateTime();
        $endDate = (new DateTime())->add(new DateInterval('P7D'));
        $data = $equipmentService->getEquipmentsForDateInterval(
            $startDate,
            $endDate,
        );

        return $this->render('web/equipment/index.html.twig', [
            'stations'      => $data,
            'allEquipments' => $equipmentService->getAllEquipments(),
        ]);
    }
}
