<?php

namespace App\Controller\Api;

use App\Controller\JsonController;
use App\Service\Vehicle\VehicleService;
use App\ValueObject\VehicleFilter;
use Doctrine\ORM\ORMException;
use Exception;
use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/vehicle")
 */
class VehicleController extends JsonController
{

    /**
     * @var VehicleService
     */
    protected $vehicleService;

    /**
     * @param ContainerInterface $container
     * @param VehicleService $vehicleService
     */
    public function __construct(ContainerInterface $container, VehicleService $vehicleService)
    {
        parent::__construct($container);
        $this->vehicleService = $vehicleService;
    }

    /**
     * @Route("/", name="vehicles_list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Request $request): JsonResponse
    {
        $filter = new VehicleFilter($request->get('status'), $request->get('type'));

        try {
            return $this->respond($this->vehicleService->get(
                $filter,
                $request->get('offset', 0),
                $request->get('limit', 10)
            ));
        } catch (Exception $e) {
            return $this->error();
        }
    }

    /**
     * @Route("/", name="vehicle_create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(Request $request): JsonResponse
    {
        $vehicle = $this->vehicleService->create($request);
        try {
            return $this->respond([
                'status' => 'created',
                'vehicle' => $vehicle
            ]);
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage());
        } catch (Exception $e) {
            return $this->error();
        }
    }

    /**
     * @Route("/{id}", name="vehicle_update", methods={"PATCH", "PUT"})
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $vehicle = $this->vehicleService->update($request, $id);

        try {
            return $this->respond([
                'status' => 'updated',
                'vehicle' => $vehicle,
            ]);
        } catch (InvalidArgumentException $e) {
            return $this->error($e->getMessage());
        } catch (Exception $e) {
            return $this->error();
        }
    }

    /**
     * @Route("/{id}", name="vehicle_delete", methods={"DELETE"})
     *
     * @param int $id
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ORMException
     */
    public function delete(int $id): JsonResponse
    {
        $this->vehicleService->delete($id);

        try {
            return $this->respond([
                'status' => 'deleted'
            ]);
        } catch (Exception $e) {
            return $this->error();
        }
    }

}
