# Spalopia API
Laravel backend para API que consume front VUE.

## Usage
Una vez clonado el proyecto:

Migrar la estructura de base de datos

```bash
$ php migrate
```

Instalar dependencias npm

```bash
$ npm install
```

Servir
```bash
$ php artisan serve
```

Vue
```bash
$ npm run watch
```



## API Endpoints
La Api esta expuesta al puerto 8000

### GET /api/horarios
Listado de servicios disponibles

Example GET value:
```javascript

    {
        "id": 1,
        "nombre": "Masaje espalda",
        "descripcion": "masaje tailandes especial",
        "precio": 20
    },
    {
        "id": 2,
        "nombre": "baño turco",
        "descripcion": "baño en piscinas",
        "precio": 50
    }

```

### http://localhost:8000/

Sirve una página en la que se encuentra el front el cual consume los tres endpoints de la API.

Listado servicios -> /api/horarios  GET

Filtro por fecha -> /api/servicios  POST

Reserva -> /api/reserva             POST