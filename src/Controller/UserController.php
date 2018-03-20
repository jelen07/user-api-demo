<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Email;
use App\Entity\Name;
use App\Entity\Password;
use App\Entity\User;
use App\Form\UserSignUpForm;
use App\Service\Api\UserClient;
use App\Utils\FlashType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Nette\Utils\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @param UserClient $userClient
     * @return Response
     */
    public function createUser(Request $request, UserClient $userClient): Response
    {
        $form = $this->createForm(UserSignUpForm::class, [])
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userData = $form->getData();

            try {
                $userClient->createUser($userData);

                // This part could be omitted due following UniqueConstraintViolationException
                // if ($userRepository->findOneBy(['email' => $user->getEmail()])) {
                //     throw new ...
                // }

                $user = new User(
                    new Name($userData['name']),
                    new Email($userData['email']),
                    new Password($userData['pass']),
                    $userData['role']
                );

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                // $em->flush();


                $this->addFlash(FlashType::SUCCESS, sprintf('%s \'%s\' was successfully created.', ucfirst((string) $user->getRole()), $user->getName()));

                return $this->redirectToRoute('createUser');
            } catch (UniqueConstraintViolationException $e) {
                $form->addError(new FormError('Duplicate entry, given email is already registered.'));
            } catch (\Exception $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param int $page
     * @param UserClient $userClient
     * @return Response
     */
    public function userList(int $page = 1, UserClient $userClient): Response
    {
        $users = $userClient->userList($page);

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }
}
