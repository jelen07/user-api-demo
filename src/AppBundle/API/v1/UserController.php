<?php

declare(strict_types=1);

namespace App\AppBundle\API\v1;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Password;
use App\Entity\Role;
use App\Entity\Status;
use App\Entity\User;
use App\Exception\InvalidArgumentException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use JMS\Serializer\SerializerInterface;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    const PAGE_SIZE = 20;

    /**
     * @Route("/api/v1/createUser")
     * @Method("POST")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        if (Request::METHOD_GET === $request->getMethod()) {
            return new JsonResponse(['Unallowed method']);
        }

        try {
            // Get data via request body
            $userData = Json::decode($request->getContent(), true);
        } catch (JsonException $e) {
            // Or try query string
            $userData = $request->query->all();
        }

        try {
            $user = new User(
                new Name($userData['name']),
                new Email($userData['email']),
                new Password($userData['pass']),
                new Role($userData['role'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $status = Status::STATUS_SUCCESS;
            $message = sprintf('%s \'%s\' was successfully created.', ucfirst((string) $user->getRole()), $user->getName());
        } catch (UniqueConstraintViolationException $e) {
            $status = Status::STATUS_ERROR;
            $message = 'Duplicate entry, given email is already registered.';
        } catch (InvalidArgumentException $e) {
            $status = Status::STATUS_ERROR;
            $message = $e->getMessage();
        }

        return new JsonResponse(new Status($status, $message), Response::HTTP_OK, [], true);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function actionDelete(Request $request): JsonResponse
    {
        // @todo
    }

    /**
     * @Route("/api/v1/userCount")
     * @Method("POST")
     *
     * @return Response
     */
    public function userCount(): JsonResponse
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $count = $userRepository->getTotalCount();

        return new JsonResponse([
            'count' => $count,
        ]);
    }

    /**
     * @Route("/api/v1/userList/{page}", requirements={"page"="\d+"})
     * @Method("POST")
     *
     * @param int $page
     *
     * @return Response
     */
    public function userList(int $page = 1, SerializerInterface $serializer): Response
    {
        /**
         * @var Paginator
         */
        $paginator = $this->getDoctrine()->getRepository(User::class)->getPaginator($page, self::PAGE_SIZE);
        $count = count($paginator);

        /**
         * @var User
         */
        $users = [];
        foreach ($paginator as $user) {
            $users[] = $user;
        }

        $data = [
            'count' => $count,
            'size' => self::PAGE_SIZE,
            'users' => $users,
        ];

        return new Response($serializer->serialize($data, 'json'), Response::HTTP_OK, [
            'Content-Type' => 'application:json',
        ]);
    }

    /**
     * This method SHOULD NOT be called in production.
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function userListAll(SerializerInterface $serializer): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        $data = [
            'count' => count($users),
            'users' => $users,
        ];

        return new Response($serializer->serialize($data, 'json'), Response::HTTP_OK, [
            'Content-Type' => 'application:json',
        ]);
    }
}
