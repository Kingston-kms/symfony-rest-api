<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DoctorController extends AbstractController
{

    private Serializer $encoder;
    public function __construct()
    {
        $this->encoder = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
    }

    #[Route('/doctors', name: 'app_doctors')]
    public function index(DoctorRepository $doctorRepository): Response
    {
        $doctor = $doctorRepository->findAll();
        return new Response($this->encoder->encode($doctor, 'xml'), 200, ['Content-Type' => 'text/xml']);
    }

    #[Route('/doctors/{id}', name: 'app_doctor')]
    public function doctor(int $id, DoctorRepository $doctorRepository): Response
    {
        $doctor = $doctorRepository->find($id);
        return new Response($this->encoder->encode($doctor, 'xml'), 200, ['Content-Type' => 'text/xml']);
    }
}
