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
 * @Route("/api")
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
     * @Route("/vehicles", name="vehicles_list", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->toArray();
        $status = (empty($data['status']) ? null : $data['status']);
        $type = (empty($data['type']) ? null : $data['type']);
        $offset = (empty($data['offset']) ? 0 : $data['offset']);
        $limit = (empty($data['limit']) ? 10 : $data['limit']);

        $filter = new VehicleFilter($status, $type, $offset, $limit);

        try {
            return $this->respond($this->vehicleService->get($filter));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * @Route("/vehicle", name="vehicle_create", methods={"POST"})
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
     * @Route("/vehicle/{id}", name="vehicle_update", methods={"PATCH", "PUT"})
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
     * @Route("/vehicle/{id}", name="vehicle_delete", methods={"DELETE"})
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
