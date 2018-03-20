<?php

declare(strict_types=1);

namespace App\AppBundle\API\v1;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Password;
use App\Entity\Status;
use App\Entity\User;
use App\Exception\InvalidArgumentException;
use App\Service\IRoleFactory;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @package App\AppBundle\API\v1
 */
class UserController extends Controller
{
    /**
     * @Route("/api/v1/createUser")
     * @Method("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request, IRoleFactory $roleFactory): JsonResponse
    {
        if ($request->getMethod() === Request::METHOD_GET) {
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
                $roleFactory->createRole($userData['role'])
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

        return new JsonResponse(new Status($status, $message), 200, [], true);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function actionDelete(Request $request): JsonResponse
    {
        // ...
    }

    /**
     * @Route("/api/v1/userCount")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function userCount(): JsonResponse
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $count = $userRepository->getTotalCount();

        return new JsonResponse(Json::encode([
            'count' => $count,
        ]));
    }

    /**
     * @Route("/api/v1/userList/{page}", requirements={"page"="\d+"})
     * @Method("POST")
     *
     * @param int $page
     * @return JsonResponse
     */
    public function userList(int $page = 1): JsonResponse
    {
        /**
         * @var $paginator Paginator
         */
        $paginator = $this->getDoctrine()->getRepository(User::class)->getPaginator($page);
        $count = count($paginator);

        /**
         * @var $user User
         */
        $users = [];
        foreach ($paginator as $user) {
            $users[] = $user;
        }

        $serializer = $this->get('jms_serializer');
        $json = $serializer->serialize([
            'count' => $count,
            'users' => $users,
        ], 'json');

        return new JsonResponse($json);
    }
}
