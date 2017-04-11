<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Linea;
use AppBundle\Entity\Lote;
use AppBundle\Entity\Porcentaje;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Socio;
use AppBundle\Entity\Venta;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\Compiler\Lille;
use Symfony\Component\HttpFoundation\Request;

class LineaController extends Controller
{
    /**
     * @Route("/ventas/detalle/{venta}", name="ventas_detalle")
     */
    public function detalleAction(Venta $venta)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $lineas = $em->getRepository('AppBundle:Linea')
            ->getVentasDetalle($venta);

        return $this->render('venta/detalle.html.twig', [
            'lineas' => $lineas,
            'venta' => $venta
        ]);
    }

    /**
     * @Route("/lineas/insertar/producto/{venta}/{cantidad}/{producto}", name="lineas_insertar_producto")
     */
    public function insertarLineaSocioAction(Venta $venta, $cantidad, Producto $producto)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención del precio del producto
        $precio = $producto->getPrecio();

        //Creación de línea
        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setPrecio($precio)
            ->setProducto($producto);

        //Añadimos la cantidad a la base imponible de la venta
        $base = $venta->getBaseImponible();
        $em->persist($venta);
        $venta->setBaseImponible($base + ($cantidad * $precio));

        //Quitamos cantidad al producto
        $em->persist($producto);
        $producto
            ->setStock($producto->getStock() - $cantidad);

        $em->flush();

        $mensaje = 'Linea insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }

    /**
     * @Route("/lineas/insertar/lote/{venta}/{cantidad}/{lote}", name="lineas_insertar_lote")
     */
    public function insertarLineaClienteAction(Venta $venta, $cantidad, Lote $lote)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        //Obtención del precio del lote
        $precio = $lote->getAceite()->getPrecioKg() * $lote->getAceite()->getDensidadKgLitro();

        //Creación de línea
        $linea = new Linea();
        $em->persist($linea);
        $linea
            ->setVenta($venta)
            ->setCantidad($cantidad)
            ->setPrecio($precio)
            ->setLote($lote);

        //Añadimos la cantidad a la base imponible de la venta
        $base = $venta->getBaseImponible();
        $venta->setBaseImponible($base + ($cantidad * $precio));

        //Quitamos cantidad al lote
        $em->persist($lote);
        $lote
            ->setStock($lote->getStock() - $cantidad);

        $em->flush();

        $mensaje = 'Linea insertada correctamente';

        return $this->render('venta/confirma.html.twig', [
            'mensaje' => $mensaje
        ]);
    }
}
