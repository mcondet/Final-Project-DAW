<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lote;
use AppBundle\Entity\Producto;
use AppBundle\Form\Type\ProductoNuevoType;
use AppBundle\Form\Type\ProductoType;
use AppBundle\Service\TemporadaActual;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends Controller
{
    /**
     * @Route("/productos/listar", name="productos_listar")
     * @Security("is_granted('ROLE_ADMINISTRADOR') or is_granted('ROLE_EMPLEADO')")
     */
    public function indexAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        return $this->render('producto/listar.html.twig', [
            'productos' => $productos
        ]);
    }

    /**
     * @Route("/productos/principal", name="productos_principal")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function productosPrincipalAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtenemos los productos
        $productos = $em->getRepository('AppBundle:Producto')
            ->findAll();

        return $this->render('producto/principal.html.twig', [
            'productos' => $productos
        ]);
    }

    /**
     * @Route("/producto/nuevo", name="producto_nuevo")
     * @Security("is_granted('ROLE_COMERCIAL')")
     */
    public function formProductoNuevoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Nuevo producto
        $producto = new Producto();
        $em->persist($producto);

        //stock a 0
        $producto->setStock(0);

        //Obtenemos la temporada auxiliar
        $temporadas = $em->getRepository('AppBundle:Temporada')
            ->getTemporadaAuxiliar();

        $form = $this->createForm(ProductoNuevoType::class, $producto, [
            'temporada' => $temporadas[0]
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $aceite = $form['lotes']->getData();

                //Obtenemos el aceite que tiene esa denominacion
                /*$aceite = $em->getRepository('AppBundle:Aceite')
                    ->getTemporadaAuxiliar($datosAceite);*/

                //Obtenemos el lote auxiliar que tiene ese aceite
                $lotes = $em->getRepository('AppBundle:Lote')
                    ->getLoteAuxiliarDenominacion($aceite);

                //Asignamos al producto nuevo el lote auxiliar obtenido
                $producto->addLote($lotes[0]);

                $em->flush();
                $this->addFlash('estado', 'Producto guardado con éxito');
                return $this->redirectToRoute('productos_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se ha podido guardar el producto');
            }
        }

        return $this->render('producto/formNuevo.html.twig', [
            'formulario' => $form->createView()
        ]);
    }

    /**
     * @Route("/producto/form/{producto}", name="producto_form")
     * @Security("is_granted('ROLE_ENCARGADO')")
     */
    public function formProductoAction(Request $request, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención temporada actual
        $temporadaActual = new TemporadaActual($em);
        $temporada = $temporadaActual->temporadaActualAction();

        //Obtenemos el aceite del producto
        $aceite = $producto->getLotes()[0]->getAceite();

        //Obtención cantidad del producto
        $cantidadProducto = $producto->getStock();

        $form = $this->createForm(ProductoType::class, $producto, [
            'temporada' => $temporada,
            'aceite' => $aceite
        ]);
        $form->handleRequest($request);

        //Si es válido
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Obtención de la cantidad en peso que se ha envasado
                $pesoEnvasar = $form['stock']->getData();

                //Pasamos ese peso a unidades de producto
                $cantidadEnvasar = (int)(($pesoEnvasar * $producto->getLotes()[0]->getAceite()->getDensidadKgLitro()) / ($producto->getEnvase()->getCapacidadLitros()));

                //Obtención del lote del que procede
                $lote = $form['lotes']->getData();

                //Suma cantidad al producto
                $em->persist($producto);
                $producto
                     ->setStock($cantidadProducto + $cantidadEnvasar);

                //Restamos la cantidad del stock del lote del que procede
                $em->persist($lote);
                $lote
                    ->setStock($lote->getStock() - $pesoEnvasar);

                $em->flush();
                $this->addFlash('estado', 'Cambios guardados con éxito');
                return $this->redirectToRoute('productos_principal');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'No se han podido guardar los cambios');
            }
        }

        return $this->render('producto/form.html.twig', [
            'formulario' => $form->createView()
        ]);
    }
}
