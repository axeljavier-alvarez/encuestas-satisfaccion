
# 📋 Sistema de Encuestas de Satisfacción

Sistema web desarrollado para administrar encuestas de satisfacción, permitiendo gestionar plantillas de evaluación, preguntas, factores, temas y tipos de respuesta.

El proyecto utiliza **Laravel 12, Livewire, Flux UI, Tailwind CSS y MySQL**, ofreciendo una interfaz moderna, dinámica y responsiva.

## 🚀 Tecnologías utilizadas

| Tecnología  | Descripción                 |
| ------------ | ---------------------------- |
| Laravel 12   | Framework backend            |
| PHP          | Lenguaje de programación    |
| Livewire     | Componentes dinámicos       |
| Flux UI      | Componentes de interfaz      |
| Tailwind CSS | Estilos y diseño responsivo |
| MySQL        | Base de datos                |
| Blade        | Motor de plantillas          |
| Vite         | Compilación de recursos     |
| Composer     | Dependencias PHP             |
| NPM          | Dependencias frontend        |

## ⚙️ Funcionalidades principales

### 📁 Administración de plantillas

- Crear y editar plantillas de evaluación.
- Activar y desactivar plantillas.
- Buscar plantillas por código o nombre.
- Consultar estadísticas de plantillas.
- Asignar preguntas a las plantillas.

### ❓ Gestión de preguntas

- Administración de un banco de preguntas.
- Clasificación mediante factores y temas.
- Configuración de tipos de respuesta.
- Identificación de preguntas predeterminadas.
- Búsqueda y selección interactiva de preguntas.

### 📝 Asignación de preguntas

Cada plantilla contiene **10 preguntas**:

- **2 preguntas predeterminadas**, incluidas automáticamente.
- **8 preguntas adicionales**, seleccionadas por el usuario.

Las preguntas predeterminadas permanecen seleccionadas y no pueden desmarcarse.

Cuando una pregunta tiene un único tipo de respuesta, se asigna automáticamente. Si tiene varios tipos disponibles, el usuario debe seleccionar uno.

El sistema valida las preguntas y los tipos de respuesta antes de guardar la asignación.

### 🎨 Interfaz de usuario

- Diseño responsivo.
- Modales interactivos.
- Selección mediante tarjetas.
- Contadores dinámicos.
- Búsquedas en tiempo real.
- Validación de formularios.
- Mensajes de confirmación y error.

## 📋 Requisitos previos

Para ejecutar el proyecto se necesita:

- PHP compatible con Laravel 12.
- Composer.
- Node.js y NPM.
- MySQL.
- Extensiones PHP requeridas por Laravel.

## 🛠️ Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/USUARIO/NOMBRE-REPOSITORIO.git
cd NOMBRE-REPOSITORIO
```

### 2. Instalar dependencias de Laravel

```bash
composer install
```

### 3. Instalar dependencias frontend

```bash
npm install
```

### 4. Configurar el archivo de entorno

Copiar el archivo de ejemplo:

```bash
cp .env.example .env
```

Configurar la conexión a MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=encuestas
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generar la clave de aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar las migraciones

```bash
php artisan migrate
```

Si el proyecto requiere datos iniciales:

```bash
php artisan db:seed
```

### 7. Iniciar el frontend

```bash
npm run dev
```

### 8. Iniciar Laravel

En otra terminal:

```bash
php artisan serve
```

La aplicación estará disponible en:

http://127.0.0.1:8000

## 📂 Estructura del proyecto

```text
app/
├── Livewire/
│   └── Administracion/
├── Models/
└── Providers/

database/
├── migrations/
└── seeders/

resources/
├── css/
├── js/
└── views/
    ├── components/
    └── livewire/
        └── administracion/

routes/
├── web.php
└── console.php
```

## 🔐 Seguridad

- No subir el archivo `.env` al repositorio.
- No publicar credenciales de acceso.
- Mantener actualizadas las dependencias.
- Configurar permisos y roles según las necesidades del sistema.
- Proteger la información almacenada en la base de datos.

## 📌 Estado del proyecto

🚧 **En desarrollo**

El sistema continúa en proceso de implementación, pruebas y mejoras de sus funcionalidades administrativas.

## 📄 Licencia

Pendiente de definir según las condiciones de distribución y uso del proyecto.
