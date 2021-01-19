# Laravel API REST Carrito de Compras

## Cracion de producto
```
{
    "opcion": "create",
    "name": "Producto 1",
    "description": "Descripcion del Producto 1",
    "price": 12.30
}
```
## Mostrar todos los productos
```
{
    "opcion": "all"
}
```
## Mostrar un producto los productos
```
{
    "opcion": "show",
    "id":1
}
```
## Editar producto
```
{
    "opcion": "edit",
    "id":1,
    "name": "Producto 1",
    "description": "Descripcion del Producto 1",
    "price": 12.40
}
```
## Borrar Producto
```
{
    "opcion": "delete",
    "id":1
}
```
## Agregar Producto al Carrito
```
{
    "opcion": "addItem",
    "id": 1,
    "name": "Producto 1",
    "description": "Descripcion del Producto 1",
    "price": 12.30
}
```
## Obtener Carrito
```
{
    "opcion": "getCar"
}
```
## Boorrar item Car
```
{
    "opcion": "deleteItem",
    "id": 1
}
```
## Concluir la venta
```
{
    "opcion": "concluirCar",
    "id": 1
}
```