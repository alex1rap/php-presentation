<?php

namespace App\Controller;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class JsonController extends AbstractController
{
    protected static $serializeGroups = ['safe'];

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function respond($data, int $status = 200, array $headers = [], $groups = [], $exclude = []): JsonResponse
    {
        return new JsonResponse($this->serialize($data, $groups, $exclude), $status, $headers, true);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function error(string $message = 'Unknown error.', int $status = 500): JsonResponse
    {
        return new JsonResponse($this->serialize([
            'error' => $message
        ], []), $status, [], true);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function serialize($data, array $groups = [], array $exclude = []): ?string
    {
        if (null === $data) {
            return '';
        }

        if (is_string($data)) {
            return $data;
        }

        $groups = array_merge(static::$serializeGroups, $groups);
        if ($exclude) {
            $groups = array_diff($groups, $exclude);
        }

        $context = [
            'groups' => $groups,
        ];

        return $this->getSerializer()->serialize($data, 'json', $context);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getSerializer(): SerializerInterface
    {
        return $this->container->get('serializer');
    }

}
