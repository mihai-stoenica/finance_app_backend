<?php

namespace App\Controller;

use App\Dto\Registration\RegistrationDto;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Json;

final class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'app_register')]
    public function index(
        #[MapRequestPayload] RegistrationDto $registrationDto,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ): Response
    {
        $user = new User();

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $registrationDto->password
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($registrationDto->email);
        $user->setRoles(['ROLE_USER']);
        $user->setName($registrationDto->name);

        $entityManager->persist($user);
        $entityManager->flush();

        $json = $serializer->serialize(
            $user,
            'json',
            ['groups' => 'user-information']
        );

        return new JsonResponse($json, Response::HTTP_CREATED);
    }
}
