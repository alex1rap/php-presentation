<?php

namespace App\Service\Vehicle;

use App\Entity\Vehicle;
use App\Service\AbstractRequestToEntityMapper;
use App\ValueObject\VehicleFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\QueryBuilder;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Request;

class VehicleService
{

    public const TYPE_CAR = 'car';
    public const TYPE_TRUCK = 'truck';

    protected const ALLOWED_TYPES = [
        self::TYPE_CAR,
        self::TYPE_TRUCK
    ];

    protected const POLLUTION_CERTIFICATES = ['A', 'B', 'C'];

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param VehicleFilter $filter
     * @param int $offset
     * @param int $limit
     * @return array
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function get(VehicleFilter $filter, int $offset = 0, int $limit = 10): array
    {
        $vehicles = $this->createQuery($filter)
            ->select('v')
            ->setFirstResult($offset)
            ->setMaxResults($limit)->getQuery()->getResult();
        $countQuery = $this->createQuery($filter);
        $count = $countQuery->select($countQuery->expr()->count('v'))->getQuery()->getSingleScalarResult();

        return [
            'count' => $count,
            'items' => $vehicles
        ];
    }

    /**
     * @param VehicleFilter $filter
     * @return QueryBuilder
     */
    protected function createQuery(VehicleFilter $filter): QueryBuilder
    {
        $qb = $this->em->createQueryBuilder()->from(Vehicle::class, 'v');
        if ($filter->getType()) {
            $qb->andWhere($qb->expr()->eq('v.type', $filter->getType()));
        }
        if ($filter->getStatus()) {
            $qb->andWhere($qb->expr()->eq('v.status', $filter->getStatus()));
        }
        return $qb;
    }

    /**
     * @param Request $request
     * @return Vehicle
     */
    public function create(Request $request): Vehicle
    {
        $vehicle = new Vehicle();

        $this->extractRequestToVehicle($request, $vehicle);

        $this->validateVehicle($vehicle);

        $this->em->persist($vehicle);
        $this->em->flush();

        return $vehicle;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Vehicle
     * @throws ORMException
     */
    public function update(Request $request, int $id): Vehicle
    {
        $vehicle = $this->em->getReference(Vehicle::class, $id);

        $this->extractRequestToVehicle($request, $vehicle);

        $this->validateVehicle($vehicle);

        $this->em->flush();

        return $vehicle;
    }

    /**
     * @param int $id
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $vehicle = $this->em->getReference(Vehicle::class, $id);

        $this->em->remove($vehicle);
        $this->em->flush();
    }

    /**
     * @param Request $request
     * @param Vehicle $vehicle
     */
    protected function extractRequestToVehicle(Request $request, Vehicle $vehicle): void
    {
        AbstractRequestToEntityMapper::map($request, $vehicle, ['id']);
    }

    /**
     * @param Vehicle $vehicle
     */
    protected function validateVehicle(Vehicle $vehicle): void
    {
        if (!in_array($vehicle->getType(), self::ALLOWED_TYPES)) {
            throw new InvalidArgumentException('Vehicle type is not supported.');
        }
        if ($vehicle->getType() === self::TYPE_TRUCK) {
            $this->validateTruck($vehicle);
        }
        if ($vehicle->getType() === self::TYPE_CAR) {
            $this->validateCar($vehicle);
        }
    }

    /**
     * @param Vehicle $vehicle
     */
    protected function validateTruck(Vehicle $vehicle): void
    {
        if (is_null($vehicle->getPollutionCertificate())) {
            throw new InvalidArgumentException('Truck pollution certificate is missed.');
        }
        if (!in_array($vehicle->getPollutionCertificate(), self::POLLUTION_CERTIFICATES)) {
            throw new InvalidArgumentException('Truck pollution certificate is not supported.');
        }
    }

    /**
     * @param Vehicle $vehicle
     */
    protected function validateCar(Vehicle $vehicle): void
    {
        if (!is_null($vehicle->getPollutionCertificate())) {
            throw new InvalidArgumentException("Pollution certificate is intended for trucks.");
        }
    }

}
