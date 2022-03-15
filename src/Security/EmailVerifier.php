<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\Templatedusername;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\Verifyusername\Exception\VerifyusernameExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    private $verifyusernameHelper;
    private $mailer;
    private $entityManager;

    public function __construct(VerifyemailHelperInterface $helper, MailerInterface $mailer, EntityManagerInterface $manager)
    {
        $this->verifyusernameHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
    }

    public function sendusernameConfirmation(string $verifyusernameRouteName, UserInterface $user, Templatedusername $username): void
    {
        $signatureComponents = $this->verifyusernameHelper->generateSignature(
            $verifyusernameRouteName,
            $user->getId(),
            $user->getusername()
        );

        $context = $username->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();

        $username->context($context);

        $this->mailer->send($username);
    }

    /**
     * @throws VerifyusernameExceptionInterface
     */
    public function handleusernameConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyusernameHelper->validateusernameConfirmation($request->getUri(), $user->getId(), $user->getusername());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
