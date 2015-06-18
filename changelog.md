beta4:
  - Actualizada Adicionar tarea adicional en funcionalidad Orden de trabajo para asimilar la nueva estructura de nomenclador Tare, Tarea mantenimiento, Grupo y Subgrupo.
  - Actualizada funcionalidad Tareas mantenimiento adicionando el nomenclador Tarea como parámetro "valor". Actualizada validación para Tarea de mantenimiento, que no permita crear más de una Tarea de mantenimiento con el mismo "valor" para el mismo Grupo y Subgrupo.
  - Adicionado/Actualizado nomenclador Tareas para el registro de las tareas comunes de mantenimiento(Diagnosticar, reparar, cambiar, ajustar).
  - Adicionado campo para Observaciones en la funcionalidad Registro de Compras.
  - Actualizada fórmula para el cálculo de los importes del Registro de compras(Cálculo de forma individual, línea por línea).
  - Adicionados los parámetros de Descuento, Impuesto, Importe de Descuento e Importe de impuesto para la factura de forma general(aplicando fórmula línea por línea).
  - Actualizada funcionalidad para adicionar líneas en Registro de Compras.
      Actualizada campo de selección para Producto al insertar/editar línea en Registro de compras, para permitir buscar por todos los códigos alternos activos que se encuentran registrados para un producto.
      Adicionada funcionalidad para mostrar listado de Proveedores, Códigos alternos y Costo para el Producto seleccionado al insertar/editar línea.
      Adicionada funcionalidad para editar el Costo del Producto desde la interfaz que muestra los datos mencionados anteriormente al seleccionar el Producto.
  - Actualizada funcionalidad para costos de Producto. Adicionados Proveedor y Código alternativo para el costo.
      Eliminados los campos de Codigo A y Proveedor en la interfaz de datos básicos del Producto.
  - Eliminada pestaña de Precios para funcionalidad de Productos(actualmente no es aplicable si uso).
beta3:
  PENDIENTES
  - [Update] Filtro de búsqueda de Inventario Físico.
  - [New] Filtro de búsqueda de Orden de Trabajo.
  - [New] Filtro de búsqueda de Tareas de Mantenimiento.
  - [Update] Filtro de búsqueda de Movimientos de Bodegas.
  - [New] Filtro de búsqueda de Salida de Bodega.
  - [New] Filtro de búsqueda de Movimientos de Productos.
  - [Hotfix] Show de Proveedor.
  - [New] Filtro de búsqueda de Proveedores.
  - [Hotfix] Mensaje autenticacion del sistema.
  - [Update] Funcionalidades de entidad Autobus.
  - Refactorizado el procesamiento de la entidad Autobus.
  - Adicionado botones Editar Producto y Actualizar Lineas de Registros de Compras, en el modal de las Lineas de Registro de Compras.
  - Solucionado problema al cargar Grupos y Subgrupos en la interfaz de edición de Producto.
  - Añadidos filtros 'Proveedor' y 'CodidoAlternativo' al Listado de Productos
beta2:
  - Refactorizando las funcionalidades para la Tarea.
  - Adicionado nuevo nomenclador Tarea.
  - Creanda la estructura básica de la entidad MantenimientoPreventivo y creando el maquetado inicial del los formularios correspondiantes al CRUD.
  - Refactorizada la Orden de Trabajo para adaptarla a la nueva notación de grupo y subgrupo.
  - Refactorizado el bundle BusesBundles para adicionar un histórico de los Mantenimientos Preventivos asociados a cada bus.
  - Adicionado filtros de grupo, subgrupo, tarea y autobus en los Mantenimientos Preventivos.
  - Cambiado campo de filtro para busqueda de InformeStock
  - Eliminados campos 'descripcion' y 'codigo' de los Nomencladores
  - Añadido proceso de Informe de Costos
  - Cambiado campo de filtro 'producto' por 'categoriaProducto' para busqueda de InformeStock
  - Solucionado problema de funcionalidad MovimientoAlmacenes que no trabajaba correctamente
  - Añadido campo CategoriaProducto al filtro de Producto
  - Creada entidad CategoriaProducto y relacionada con Producto
  - Creada entidad PrecioProducto y relacionada con Producto, se actualizaron todas las dependencias de ambas entidades
  - Refactoriza la Orden de Trabajo para adoptar el nomenclador de Tareas y los Terceros.
  - Eliminados los campos: 'revisado' y 'aprobado' y se agrega el campo 'estado' a la entidad OrdenTrabajo para usar como select.
  - Agregado el campo 'persona' a la entidad 'Tercero' y corregido filtro del Listado de Terceros.

beta1(13/02/2015):
  - Solucionadas no conformidades final sin edit de Producto, Tercero, OrdenTrabajo, Compra
  - Solucionadas no conformidades final sin edit: Tercero debido al atributo Direccion
  - Cambiada la administracion del Sistema para -SonataAdminBundle-
  - Arreglado routing de SonataBundle
  - Actualizado el proceso de Movimiento de Almacenes e InformeStock
  - Eliminados bundles no utilizados en el sistema
  - Eliminada herencia entre bundles nomenclador y admingenerator
  - Eliminadas configuraciones para admingenerator y liipimagine
  - Solucionado problema de generado automático de consecutivo_compra
  - Adicionada diseño para páginas de error
  - Solucionado problema al adicionar Producto
  - Solucionado problema al editar Producto
  - Solucionado problema al editar SubGrupos de entidad Autobus
  - Cambiado el formato Informe Stock
  - Cambio de la entidad Compra y sus relaciones para el módulo de Bodega
  - Solucionada no conformidad donde no debe aparecen el almacenOrigen al seleccionar el AlmacenDestino
  - Finalizada entidad y proceso de Pedido de Compra
  - Finalizadas operaciones con la entidad BitacoraAlmacen, Albaran y PedidoCompra
  - Completadas operaciones con entidades InformeStock, Albaran y MovimientoProductos
  - Entidad Lineas de Pedido de Compra ya permite modificar
  - Completada correctamente el proceso de PedidoCompra
  - Completada correctamente el proceso de PedidoCompra tenia problemas en el editar
  - Fue reestructurada la entidad Movimiento
  - Las plantillas Widgets q estaban en BusetaTemplateBundle fueron cambiadas por cada bundle correspondiente
  - Finalizado la funcionalidad de insertar un nuevo Albaran desde cero
  - Validados los formularios de la entidad Producto
  - Validados los formularios de la entidad Impuesto
  - Terminadas funcionalidades de PedidoCompra crear, editar y procesar
  - Solucionado problema al editar el Albaran
  - Implementados Filtros en la entidad Tercero
  - Implementados Filtros en la entidad Producto
  - Implementados Filtros en la entidad PedidoCompra
  - Implementados Filtros en la entidad Albaran
  - Implementados Filtros en la entidad Bodega
  - Implementadas las funcionalidades del InformeStock
  - Implementadas las funcionalidades de Movimiento de Productos con BitacoraAlmacen e InformeStock
  - Implementada la funcionalidad para obtener bitacora de un Producto seleccionad
  - Los modals de las entidades PedidoCompra, Albaran y Movimiento de Productos... han sido reseteados al iniciar
