//Actualizar InformeStock
//Comprobar que no exista ya un almacén con un producto determinado
$informeStock = $em->getRepository('BusetaBodegaBundle:InformeStock')->comprobarInformeStock($almacen,$producto);

//                $informeProductoBodega = $em->getRepository('BusetaBodegaBundle:InformeProductosBodega')->findOneBy(array(
//                    'producto' => $idProducto,
//                    'almacen' => $idAlmacenOrigen//                ));

//Si ya existe un producto en un almacen determinado
if($informeStock)
{
$cantidadDisponible = $informeStock->getCantidadProductos() - $movimiento['cantidad'];

//Si existen la cantidad requerida de productos en el almacen
if($cantidadDisponible >= 0){

//Extraigo la cantidad de productos del almacen de origen
$informeStock->setCantidadProductos($cantidadDisponible);
$em->persist($informeStock);

$almacen = $em->getRepository('BusetaBodegaBundle:Bodega')->find($idAlmacenDestino);
//Adiciono la cantidad de productos en el almacen de destino
$informeStock = $em->getRepository('BusetaBodegaBundle:InformeStock')->comprobarInformeStock($almacen,$producto);

//Si existe ese producto en ese almacen
if($informeStock){
$informeStock->setCantidadProductos($informeStock->getCantidadProductos() + $movimiento['cantidad']);
$em->persist($informeStock);
}
else //Si no existe ese producto en ese almacen
{
$informeProductosBodega->setProducto($producto);
$informeProductosBodega->setAlmacen($bodega);
$informeProductosBodega->setCantidadProductos($movimiento['cantidad']);
$em->persist($informeProductosBodega);
}

}

}
else //Si no existe
{
$form->addError(new FormError("Mensaje error"));
}