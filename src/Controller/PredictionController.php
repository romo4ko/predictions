<?php
namespace App\Controller;

use App\Entity\Prediction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PredictionController extends AbstractController
{
    #[Route('/prediction/create', name: 'create_prediction')]
    public function createPrediction(EntityManagerInterface $entityManager, ValidatorInterface $validator, Request $request): Response
    {
        $prediction = new Prediction();
        $prediction->setText($request->get('text'));
        $prediction->setType('default');

        $errors = $validator->validate($prediction);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $entityManager->persist($prediction);
        $entityManager->flush();

        return new Response('Saved #'.$prediction->getId());
    }

    #[Route('/prediction/get', name: 'prediction')]
    public function getOne(EntityManagerInterface $entityManager): Response
    {
        $prediction = $entityManager->getRepository(Prediction::class)->findRandomOne();

        return $this->json([
            'prediction' => $prediction->getText(),
        ]);
    }
}