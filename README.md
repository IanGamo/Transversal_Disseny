# Race & Meet 🏎️🏍️

**Race & Meet** es una plataforma web dedicada a los amantes de los coches clásicos, modernos y motos. Permite descubrir y participar en eventos del sector, conectar con otros aficionados y gestionar compras de entradas.

---

## Páginas

- **Home** — Página principal con presentación de la web y acceso al resto de secciones.
- **Eventos** — Listado de eventos de coches y motos disponibles.
- **Carrito** — Gestión de entradas seleccionadas para los eventos.
- **Comunidad** — Espacio para conectar con otros usuarios aficionados al motor.
- **Perfil** — Página personal del usuario con sus datos y opciones de cuenta.

---

## Autenticación

La web dispone de un sistema completo de registro y login:

- **Registro de usuario** — Formulario para crear una cuenta estándar con avatar opcional.
- **Registro de administrador** — Formulario con código secreto para cuentas con permisos de administración.
- **Login** — Acceso con email y contraseña.
- **Logout** — Cierre de sesión con redirección automática al login.

---

## Gestión de usuarios

### Usuario estándar
- Puede ver y editar su perfil.
- Puede **darse de baja** desde su perfil: elimina su cuenta y avatar del servidor de forma permanente, previa confirmación mediante modal.

### Administrador
- Accede al panel **Gestionar usuarios** desde su perfil.
- Puede ver el listado completo de usuarios estándar registrados (nombre, email, avatar y fecha de registro).
- Puede **eliminar cualquier usuario estándar**, incluyendo su avatar del servidor, previa confirmación mediante modal.
- No puede eliminarse a sí mismo ni eliminar otros administradores.

---

## Tecnologías

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Base de datos:** MySQL
- **Arquitectura:** MVC (Model - View - Controller)

---

## Estructura del proyecto

```
Responsive/
├── Controller/
│   ├── UserController.php      # Login, registro, logout, eliminar cuenta propia, eliminar usuario (admin)
│   └── EventController.php     # Lógica de eventos
└── View/
    ├── Login.php
    ├── Registro_user.php
    ├── registro_adm.php
    ├── Profile.php              # Perfil de usuario + opción darse de baja
    ├── eliminar_usuario.php     # Panel admin: listado y eliminación de usuarios estándar
    ├── ver_evento.php
    └── src/
        ├── css/
        │   ├── Profile.css
        │   ├── eliminar_usuario.css
        │   ├── Login.css
        │   ├── Registro.css
        │   ├── Eventos.css
        │   ├── Home.css
        │   └── ...
        ├── js/
        └── images/
```

---

## Base de datos

- **Host:** localhost
- **Base de datos:** `race_and_meet`
- **Usuario:** `adm1`
- **Tabla principal:** `usuarios`

| Campo | Tipo | Descripción |
|---|---|---|
| id | INT | Clave primaria autoincremental |
| name | VARCHAR | Nombre del usuario |
| email | VARCHAR | Email único |
| password | VARCHAR | Contraseña hasheada (bcrypt) |
| rol | ENUM | `usuario` o `admin` |
| path | VARCHAR | Ruta del avatar en el servidor |
| created_at | DATETIME | Fecha de registro |

---

## Roles y permisos

| Acción | Usuario | Admin |
|---|---|---|
| Ver perfil propio | ✅ | ✅ |
| Darse de baja | ✅ | ✅ |
| Ver listado de usuarios | ✅ | ✅ |
| Eliminar usuarios estándar | ✅ | ✅ |

---

## Instalación

1. Clona o descarga el proyecto en tu servidor local (XAMPP, WAMP, etc.).
2. Importa la base de datos `race_and_meet` en MySQL.
3. Accede desde el navegador a `localhost/Responsive/View/Login.php`.

> Para crear un administrador, accede a `registro_adm.php` e introduce el código secreto durante el registro.
