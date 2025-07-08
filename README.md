# 🎓 Sistema de Gestión de Temas de Curso

## 📋 Descripción del Proyecto

Sistema completo de gestión de temas de curso desarrollado en **Laravel 12** con arquitectura en capas, API RESTful y interfaz web moderna. Esta aplicación permite crear, leer, actualizar y eliminar temas de cursos con validaciones robustas y una experiencia de usuario fluida.

## 🚀 Instalación y Configuración

### 📋 Requisitos Previos
- PHP 8.1+
- Composer
- MySQL 5.7+ o SQLite
- Node.js (opcional, para compilar assets)

### 🔧 Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/DanielCriollo/prueba-tecnica
cd prueba-tecnica
```

2. **Instalar dependencias**
```bash
composer install
```

3. **Configurar variables de entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar base de datos**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prueba_tecnica
DB_USERNAME=root
DB_PASSWORD=
```

5. **Ejecutar migraciones y seeders**
```bash
php artisan migrate
php artisan db:seed --class=CourseTopicsTableSeeder
```

**Alternativa: Importar base de datos**
```bash
# Si prefieres importar directamente la base de datos
mysql -u root -p prueba_tecnica < database/prueba_tecnica.sql
```

6. **Iniciar servidor**
```bash
php artisan serve
```

### 🌐 Acceso a la Aplicación

- **Interfaz Web**: `http://localhost:8000/course-topics`
- **API Base**: `http://localhost:8000/api/v1/course-topics`

### 🎯 Funcionalidades Principales

- ✅ **CRUD completo** de temas de curso
- ✅ **API RESTful** con versionado (v1)
- ✅ **Interfaz web** moderna con Bootstrap 5
- ✅ **Validaciones** del lado del servidor
- ✅ **Operaciones AJAX** sin recarga de página
- ✅ **Paginación** dinámica
- ✅ **Arquitectura en capas** (Controller → Service → Repository)
- ✅ **Sistema de respuestas** estandarizado

## 🏗️ Arquitectura del Proyecto

### 📁 Estructura de Directorios

```
prueba-tecnica/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── BaseApiController.php
│   │   │   │   └── CourseTopicController.php
│   │   │   └── Controller.php
│   │   └── Requests/
│   │       └── CourseTopic/
│   │           ├── StoreCourseTopicRequest.php
│   │           └── UpdateCourseTopicRequest.php
│   ├── Models/
│   │   └── CourseTopic.php
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   │   └── CourseTopicRepositoryInterface.php
│   │   └── CourseTopicRepository.php
│   ├── Services/
│   │   └── CourseTopicService.php
│   ├── Resources/
│   │   └── CourseTopicResource.php
│   ├── Traits/
│   │   └── ApiResponse.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   └── 2025_07_07_215735_create_course_topics_table.php
│   ├── seeders/
│   │   └── CourseTopicsTableSeeder.php
│   └── factories/
│       └── CourseTopicFactory.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── master.blade.php
│       └── course-topics/
│           ├── index.blade.php
│           └── modals/
│               └── form.blade.php
└── routes/
    ├── api.php
    └── web.php

```

## 🔧 Backend - Laravel 12

### 🏛️ Arquitectura en Capas

#### **1. Modelo (Model)**
```php
// app/Models/CourseTopic.php
class CourseTopic extends Model
{
    protected $fillable = [
        'name', 'description', 'publication_date', 'is_mandatory'
    ];
    
    protected $casts = [
        'publication_date' => 'date',
        'is_mandatory' => 'boolean',
    ];
}
```

#### **2. Repositorio (Repository Pattern)**
```php
// app/Repositories/Interfaces/CourseTopicRepositoryInterface.php
interface CourseTopicRepositoryInterface
{
    public function getAllPaginated(int $perPage = 15);
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}

// app/Repositories/CourseTopicRepository.php
class CourseTopicRepository implements CourseTopicRepositoryInterface
{
    // Implementación de métodos de acceso a datos
}
```

#### **3. Servicio (Service Layer)**
```php
// app/Services/CourseTopicService.php
class CourseTopicService
{
    public function __construct(
        private CourseTopicRepositoryInterface $repository
    ) {}
    
    // Lógica de negocio y validaciones
}
```

#### **4. Controlador (Controller)**
```php
// app/Http/Controllers/Api/CourseTopicController.php
class CourseTopicController extends BaseApiController
{
    public function __construct(CourseTopicService $courseTopicService)
    {
        $this->courseTopicService = $courseTopicService;
    }
    
    // Endpoints CRUD
}
```

### 🔐 Validaciones

#### **Form Requests**
```php
// app/Http/Requests/CourseTopic/StoreCourseTopicRequest.php
class StoreCourseTopicRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:course_topics,name',
            'description' => 'nullable|string|max:1000',
            'publication_date' => 'required|date|after_or_equal:today',
            'is_mandatory' => 'required|boolean',
        ];
    }
}
```

### 📡 API RESTful

#### **Endpoints Disponibles**
```
GET    /api/v1/course-topics          - Listar con paginación
POST   /api/v1/course-topics          - Crear nuevo tema
GET    /api/v1/course-topics/all      - Listar todos
GET    /api/v1/course-topics/{id}     - Mostrar tema específico
PUT    /api/v1/course-topics/{id}     - Actualizar tema
DELETE /api/v1/course-topics/{id}     - Eliminar tema
```

#### **Respuestas Estandarizadas**
```json
{
    "success": true,
    "message": "Operación exitosa",
    "data": {
        // Datos de la respuesta
    }
}
```

### 🎨 Sistema de Respuestas

#### **Trait ApiResponse**
```php
// app/Traits/ApiResponse.php
trait ApiResponse
{
    public function successResponse($data, string $message = 'Success')
    public function createdResponse($data, string $message = 'Created successfully')
    public function updatedResponse($data, string $message = 'Updated successfully')
    public function deletedResponse(string $message = 'Deleted successfully')
    public function errorResponse(string $message, int $statusCode = 400)
    public function notFoundResponse(string $message = 'Resource not found')
    public function validationErrorResponse(string $message, array $errors = [])
    public function serverErrorResponse(string $message = 'Server error')
}
```

## 🎨 Frontend - Bootstrap 5 + AJAX

### 🏗️ Arquitectura Frontend

#### **Layout Master**
```php
// resources/views/layouts/master.blade.php
@extends('layouts.master')

@section('title', 'Título de la página')
@section('content')
    <!-- Contenido -->
@endsection

@push('scripts')
    <!-- JavaScript específico -->
@endpush
```

#### **Vista Principal**
```php
// resources/views/course-topics/index.blade.php
@extends('layouts.master')

@section('content')
    <!-- Tabla de temas -->
    <!-- Paginación -->
    @include('course-topics.modals.form')
@endsection
```

#### **Modal Reutilizable**
```php
// resources/views/course-topics/modals/form.blade.php
<!-- Modal para crear/editar temas -->
```

### 🎯 Características Frontend

#### **Tecnologías Utilizadas**
- **Bootstrap 5.3.0** - Framework CSS
- **Bootstrap Icons 1.10.0** - Iconografía
- **jQuery 3.7.1** - Manipulación DOM y AJAX
- **SweetAlert2 11.x** - Alertas y confirmaciones

#### **Funcionalidades AJAX**
```javascript
// Cargar datos
$.ajax({
    url: '/api/v1/course-topics',
    method: 'GET',
    success: function(response) {
        renderTable(response.data);
    }
});

// Crear/Editar
$.ajax({
    url: '/api/v1/course-topics',
    method: 'POST',
    data: JSON.stringify(formData),
    contentType: 'application/json'
});

// Eliminar con confirmación
showConfirm('¿Estás seguro?', function() {
    $.ajax({
        url: `/api/v1/course-topics/${id}`,
        method: 'DELETE'
    });
});
```

#### **Validaciones Frontend**
- ✅ **Validación en tiempo real** con feedback visual
- ✅ **Manejo de errores** del servidor
- ✅ **Estados de carga** con spinners
- ✅ **Confirmaciones** antes de eliminar

## 🗄️ Base de Datos

### 📊 Estructura de la Tabla

```sql
CREATE TABLE course_topics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    publication_date DATE NOT NULL,
    is_mandatory BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 🌱 Seeders

```php
// database/seeders/CourseTopicsTableSeeder.php
class CourseTopicsTableSeeder extends Seeder
{
    public function run(): void
    {
        CourseTopic::insert([
            [
                'name' => 'Introduction to Programming',
                'description' => 'Covers fundamental programming concepts.',
                'publication_date' => '2023-01-15',
                'is_mandatory' => true,
            ],
            // Más datos de ejemplo...
        ]);
    }
}
```

## 🎯 Conclusión

Este proyecto demuestra una implementación completa y profesional de un CRUD de temas de curso, utilizando las mejores prácticas de desarrollo web moderno:

- ✅ **Arquitectura sólida** con separación de responsabilidades
- ✅ **API RESTful** bien diseñada y documentada
- ✅ **Frontend moderno** con UX/UI profesional
- ✅ **Validaciones robustas** en frontend y backend
- ✅ **Testing automatizado** para garantizar calidad
- ✅ **Código limpio** y bien documentado
- ✅ **Escalabilidad** para futuras funcionalidades

Perfecto para demostrar competencias técnicas en un perfil de desarrollador web. 🚀

## ⏱️ Tiempo de Desarrollo

### 📊 Distribución del Tiempo

- **🗄️ Base de Datos** (Migración y Modelo): ~10 minutos
- **🔧 Backend Completo** (API, Servicios, Repositorios, Validaciones): ~1 hora
- **🎨 Frontend** (Interfaz, AJAX, Modales, UX/UI): ~1 hora
- **📝 Documentación**: ~15 minutos

**⏰ Tiempo Total**: Aproximadamente **2 horas y 25 minutos**

---
