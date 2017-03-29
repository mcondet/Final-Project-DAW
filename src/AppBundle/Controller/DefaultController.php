<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="inicio")
     */
    public function indexAction()
    {
        $titulos = [
            "Aceite Virgen Extra",
            "Aceite Virgen",
            "Aceite Lampante",
            "Aceituna Picual",
            "Un mar de olivos..."
        ];

        $subtitulos = [
            "La joya de la corona",
            "El segundo de a bordo",
            "El gran subestimado",
            "Nuestra principal materia prima",
            "La tierra que nos da sus frutos"
        ];

        $fotos = [
            "virgen_extra.jpg",
            "virgen.jpg",
            "lampante.jpg",
            "picual.jpg",
            "paisaje2.jpg"
        ];

        return $this->render('default/index.html.twig', [
            'titulos' => $titulos,
            'subtitulos' => $subtitulos,
            'fotos' => $fotos
        ]);
    }

    /**
     * @Route("/1", name="inicio2")
     */
    public function layoutAction()
    {
        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();

        $aceites = $em->createQueryBuilder()
            ->select('a')
            ->from('AppBundle:Aceite', 'a')
            ->getQuery()
            ->getResult();

        return $this->render('layout.html.twig', [
            'aceites' => $aceites
        ]);
    }
}
