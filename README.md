# Project Specs

Aplicacion Laravel para documentar y planificar proyectos de software. Permite organizar el contexto de un proyecto, sus tecnologias, funcionalidades, historias de usuario, criterios de aceptacion y tareas de planificacion desde un panel administrativo.

## Funcionalidades

- Gestion de proyectos con descripcion, audiencia y convenciones.
- Catalogo reutilizable de tecnologias y sus convenciones.
- Modelado de features, bugs y mejoras con prioridad, estado y orden.
- Historias de usuario y criterios de aceptacion asociados a cada feature.
- Tareas de planificacion con estado y orden.
- Autenticacion en el panel, registro, recuperacion de contrasena y verificacion de correo.

## Stack

- PHP 8.3+
- Laravel 13
- Filament 5
- Livewire 4
- SQLite por defecto en desarrollo
- Vite, Tailwind CSS 4 y Vite Plus
- Pest y PHPStan para calidad y pruebas

## Requisitos

- PHP 8.3 o superior con Composer
- Node.js y npm
- Una base de datos compatible con la configuracion de Laravel

## Instalacion

1. Clona el repositorio y entra en su directorio.
2. Ejecuta el script de preparacion:

```bash
composer run setup
```

Este comando instala las dependencias PHP y JavaScript, crea `.env` a partir de `.env.example`, genera la clave de aplicacion, ejecuta las migraciones y compila los recursos frontend.

La configuracion inicial usa SQLite. Si la base de datos no existe, creala antes de ejecutar las migraciones:

```bash
touch database/database.sqlite
```

En Windows PowerShell puedes usar:

```powershell
New-Item database/database.sqlite -ItemType File
```

Para usar otra base de datos, ajusta las variables `DB_*` en `.env` antes de migrar.

## Desarrollo

Inicia Laravel y el proceso frontend con:

```bash
php artisan dev
```

La aplicacion estara disponible normalmente en `http://localhost:8000`.

El panel administrativo esta en:

```text
http://localhost:8000/admin
```

Tambien puedes ejecutar solo el proceso frontend con `npm run dev`.

## Calidad y pruebas

Ejecuta la suite completa, que incluye limpieza de configuracion, Pint, PHPStan y Pest:

```bash
composer test
```

Comandos individuales:

```bash
composer lint
composer lint:check
composer types:check
php artisan test
```

## Estructura principal

```text
app/
  Actions/                 Acciones de dominio y transiciones de estado
  Enums/                   Estados, prioridades y tipos del dominio
  Filament/Resources/     Recursos y pantallas del panel administrativo
  Models/                 Modelos Eloquent
database/
  factories/               Factories para pruebas y datos de ejemplo
  migrations/              Esquema de la base de datos
  seeders/                 Datos iniciales
resources/                 Vistas y recursos frontend
routes/                    Rutas web y de consola
tests/                     Pruebas Pest
```

## Rutas principales

- `/`: pagina inicial.
- `/admin`: panel de administracion protegido por autenticacion.

Las rutas de gestion se registran automaticamente a traves de los recursos de Filament.

## Licencia

Este proyecto se distribuye bajo la licencia [GNU General Public License v3.0](LICENSE).
