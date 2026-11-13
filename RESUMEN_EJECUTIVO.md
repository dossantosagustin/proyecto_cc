# Resumen ejecutivo del sistema

## 1. Idea general

El sistema es una plataforma web para gestionar la disponibilidad de espacios del centro cultural y facilitar la recepción de propuestas artísticas. La idea central es permitir que bandas y proyectos artísticos consulten fechas disponibles, presenten sus solicitudes y, a su vez, que el administrador del centro cultural revise, apruebe o rechace esas propuestas y coordine la programación de eventos.

El proyecto está pensado como una solución simple, funcional y orientada a la gestión operativa diaria: no es un sistema complejo de múltiples módulos, sino una herramienta para organizar fechas, solicitudes y eventos de forma centralizada.

## 2. Objetivos del sistema

Los objetivos principales del proyecto son:

- Administrar la disponibilidad de fechas del centro cultural.
- Permitir la inscripción de propuestas por parte de artistas o agrupaciones.
- Centralizar la información de solicitudes en una base de datos.
- Facilitar la revisión y aprobación de propuestas por parte del administrador.
- Generar un calendario de eventos activos y programados.
- Brindar acceso administrativo con control de sesión.

## 3. Usuarios y roles

El sistema contempla dos perfiles principales:

### Usuario público
- Consulta el calendario.
- Visualiza fechas disponibles.
- Completa un formulario con la propuesta artística.
- Envía datos de contacto, tipo de evento y requisitos.

### Administrador
- Inicia sesión en el panel de administración.
- Gestiona la disponibilidad del espacio.
- Revisa propuestas pendientes.
- Decide aceptar o rechazar una solicitud.
- Consulta y controla la programación de eventos.

## 4. Funcionalidad principal

El flujo principal del sistema es el siguiente:

1. El usuario visita la página principal o el calendario.
2. Revisa las fechas disponibles.
3. Completa el formulario de propuesta con la información del proyecto.
4. La solicitud se registra en la base de datos.
5. El administrador accede al panel y revisa las propuestas recibidas.
6. El administrador aprueba o rechaza la solicitud.
7. En caso de aprobación, la fecha pasa a estar ocupada y el evento queda programado.
8. El administrador puede consultar los eventos agendados en la vista de administración.

## 5. Estructura del sistema

El proyecto está compuesto por varios archivos PHP y una base de datos MySQL. Entre los elementos relevantes se encuentran:

- `index.php`: página principal.
- `calendario.php`: consulta pública de fechas.
- `propuesta.php`: formulario para enviar propuestas.
- `guardar_propuesta.php`: guarda la solicitud en la base de datos.
- `login.php`: acceso administrativo.
- `admin.php`: panel principal del administrador.
- `admin_disponibilidad.php`: gestión de fechas disponibles.
- `guardar_disponibilidad.php`: registro de disponibilidad.
- `admin_propuestas.php`: listado de propuestas recibidas.
- `gestionar_propuesta.php`: aprobación o rechazo de propuestas.
- `admin_eventos.php`: visualización de eventos calendarizados.
- `conexion.php` y `database.php`: conexiones a la base de datos.
- `proyecto_cc.sql`: script base de la base de datos.

## 6. Modelo de datos

La aplicación utiliza MySQL para persistir la información. Los datos principales que maneja son:

- Disponibilidad del espacio.
- Propuestas artísticas.
- Datos del solicitante.
- Estado de la propuesta (pendiente, aceptada, rechazada).
- Fechas y eventos programados.

Esto hace que el sistema sea útil para controlar la operación diaria del centro cultural con poca complejidad, pero con una buena capacidad de registro y seguimiento de solicitudes.

## 7. Tecnología empleada

El repositorio tiene una composición de lenguajes predominante en PHP, con un porcentaje muy alto del total del código. La aplicación usa tecnologías web tradicionales:

- PHP para lógica del backend.
- HTML para las vistas.
- CSS para el diseño visual.
- JavaScript para interacciones.
- MySQL como motor de base de datos.

La implementación es de tipo no-framework, es decir, una aplicación PHP simple con archivos dedicados a cada funcionalidad.

## 8. Estado del proyecto y alcance

El proyecto se presenta como una solución funcional de gestión administrativa para un centro cultural. Su alcance está centrado en:

- gestión de disponibilidad,
- recepción de propuestas,
- revisión administrativa,
- programación de eventos.

No parece ser un sistema de gran envergadura ni multi-tenant, sino una herramienta práctica para un contexto específico: la administración del espacio del centro cultural.

## 9. Fortalezas del sistema

- Solución directa para un problema real y operativo.
- Fácil de comprender y mantener.
- Permite automatizar la gestión de disponibilidades.
- Reduce la carga de trabajo manual.
- Centraliza toda la información en una base de datos.
- Tiene una lógica clara de administración y programación.

## 10. Aspectos a mejorar

Si bien el sistema es funcional, existen varios puntos importantes a reforzar antes de usarlo en producción:

- Las credenciales del administrador están codificadas en el sistema, lo cual no es recomendable.
- La validación de datos y la gestión de errores pueden mejorarse.
- La seguridad del acceso y la protección de sesiones debería reforzarse.
- La separación entre lógica, vistas y configuración podría ordenarse mejor.
- El manejo de fechas y duplicados podría complementarse con validaciones más robustas.
- La experiencia de usuario podría mejorarse con una interfaz más moderna y responsive.

## 11. Conclusión

Este repositorio corresponde a un sistema de gestión para un centro cultural que permite coordinar la disponibilidad de espacio, registrar propuestas artísticas y controlar la programación de eventos. Su enfoque es práctico, directo y adaptado a una operación concreta del día a día.

En términos ejecutivos, el proyecto demuestra una solución útil para resolver un problema real de coordinación y administración, con una base sólida en PHP y MySQL, pero con margen de mejora en seguridad, estructura y escalabilidad.

## 12. Recomendación final

El sistema tiene potencial como herramienta operativa para un centro cultural y podría evolucionar hacia una plataforma más robusta si se mejoran aspectos de seguridad, diseño y mantenimiento. En su estado actual, funciona como una solución funcional de gestión administrativa con foco en la operación diaria.
