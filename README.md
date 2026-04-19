# Race & Meet 🏎️🏍️

**Race & Meet** es una plataforma web dedicada a los amantes de los coches clásicos, modernos y motos. Permite descubrir y participar en eventos del sector, conectar con otros aficionados y gestionar compras de entradas.

---

## Páginas

- **Home** — Página principal con presentación de la web y acceso al resto de secciones.
- **Eventos** — Listado de eventos de coches y motos disponibles.
- **Carrito** — Gestión de entradas seleccionadas para los eventos.
- **Comunidad** — Espacio para conectar con otros usuarios aficionados al motor.

---

## Autenticación

La web dispone de un sistema completo de registro y login:

- **Registro de usuario** — Formulario para crear una cuenta estándar.
- **Registro de administrador** — Formulario con código secreto para cuentas con permisos de administración.
- **Login** — Acceso con email y contraseña.
- **Logout** — Cierre de sesión con redirección automática al login.

---

## Tecnologías

- **Frontend:** HTML, CSS
- **Backend:** PHP
- **Base de datos:** MySQL
- **Arquitectura:** MVC (Model - View - Controller)

---

## Estructura del proyecto

```
Responsive/
├── BDD/
│   └── bdd.php               # Conexión a la base de datos
├── Controller/
├── Model/
│   ├── Login.php
│   └── Registro.php
├── UserController/
│   ├── UserController.php    # Lógica de login, registro y logout
│   ├── Login.html
│   ├── Registro_usuario.html
│   ├── Registro_admin.html
│   └── Logout.php
└── View/
    ├── Home.html
    ├── Eventos.html
    ├── Carrito.html
    └── Comunidad.html
```

---

## Base de datos

- **Host:** localhost
- **Base de datos:** `race_and_meet`
- **Tabla principal:** `usuarios` (id, name, email, password, rol)

---

## Instalación

1. Clona o descarga el proyecto en tu servidor local (XAMPP, WAMP, etc.).
2. Importa la base de datos `race_and_meet` en MySQL.
3. Accede desde el navegador a `localhost/Diseño/Responsive/UserController/Login.html`.
