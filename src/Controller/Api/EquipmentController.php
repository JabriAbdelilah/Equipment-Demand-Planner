<?php

namespace App\Controller\Api;

use App\Service\EquipmentService;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class EquipmentController extends AbstractController
{
    #[Rest\Get("/equipments")]
    public function equipments(Request $request, EquipmentService $equipmentService): Response
    {
        $startDate = $request->query->get('startDate');
        $endDate = $request->query->get('endDate');

        if (empty($startDate) || empty($endDate)) {
            throw new UnprocessableEntityHttpException();
        }

        try {
            $startDate = new DateTime($startDate);
            $endDate = new DateTime($endDate);
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException();
        }

        return new JsonResponse($equipmentService->getEquipmentsForDateInterval(
            $startDate,
            $endDate,
        ));
    }
}
