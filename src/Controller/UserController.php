<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{

    #[Route('/my_api/users', name: 'users', methods: ['GET'])]
    public function getUserList(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $userList = array_reverse($userRepository->findAll());
        $jsonUserList = $serializer->serialize($userList, 'json');
        return new JsonResponse($jsonUserList, Response::HTTP_OK, [], true);
    }

    #[Route('/my_api/user', name: "createUser", methods: ['POST'])]
    public function createUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $em): JsonResponse
    {
        /**
         * @var User
         */
        $user = new User();
        $content = $request->toArray();
        $firstname = $content['firstname'] ?? -1;
        $lastname = $content['lastname'] ?? -1;
        $email = $content['email'] ?? -1;
        $password = $content['password'] ?? -1;
        $role = $content['role'] === 'ROLE_ADMIN' ? 'ROLE_ADMIN' : 'ROLE_USER';

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setPassword($userPasswordHasher->hashPassword($user, $password));
        $user->setRoles([$role]);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/my_api/editUser/{id}', name: "updateUser", methods: ['PUT'])]
    public function updateUser(Request $request, SerializerInterface $serializer, int $id, UserRepository $userrepo, EntityManagerInterface $em): JsonResponse
    {
        /**
         * @var User
         */
        $user = $userrepo->find($id);
        $content = $request->toArray();

        $firstname = $content['firstname'] ?? -1;
        $lastname = $content['lastname'] ?? -1;
        $email = $content['email'] ?? -1;
        $role = $content['role'] === 'ROLE_ADMIN' ? 'ROLE_ADMIN' : 'ROLE_USER';

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setRoles([$role]);

        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    #[Route('/my_api/deleteUser/{id}', name: 'deleteUser', methods: ['DELETE'])]
    public function deleteUser(int $id, UserRepository $userrepo, EntityManagerInterface $em): JsonResponse
    {
        $rapport = $userrepo->find($id);
        $em->remove($rapport);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
