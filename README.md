# Eniwer Training Kit

Eniwer Training Kit es un sistema diseñado para validar y entrenar personas en cargos de desarrollo full-stack.

### Características
- **Sesiones de usuario:** inicio de sesión bajo estándar OAuth 2.0.
- **Administración de usuarios:** módulo básico para registro y mantenimiento de usuarios.
- **Administración de tareas:** módulo básico para registro seguimiento de tareas.
- **Notificaciones:** reporte de eventos y alertas por correo electrónico.

### Estructura
- **API**: es el back-end del sistema y provee una interfaz de aplicaciones.
- **Web**: es el front-end del sistema y provee una interfaz gráfica para usuarios.
- **WebSocket**: es el canal de comunicación en tiempo real del sistema y provee notificaciones.

### Changelog
##### Versión 1.0 (Febrero 2025)
- Lanzamiento inicial.

## Requisitos
- [PostgreSQL](https://postgresql.org/)
- [git](https://git-scm.com/)
- [PHP](https://php.net/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [pm2](https://pm2.keymetrics.io/)

## 1. Clonar Repositorios
#### Usando HTTP
```
git clone https://github.com/eniwer/training-kit.git
```
#### Usando SSH
```
git clone git@github.com:eniwer/training-kit.git
```
## 2. Instalar Sistema
#### Instalar Back-end
```
cd training-kit/api
composer install
composer setup
```
#### Instalar Front-end
```
cd tranining-kit/web
npm install
```
#### Instalar WebSocket
```
cd tranining-kit/websocket
npm install
```

#### Configurar variables de entorno
| Directorio | Archivo | Contenido |
| ------ | ------ | ------ |
| `training-kit/api` | `.env` | Variables de entorno Back-end |
| `training-kit/web` | `.env` | Variables de entorno Front-end |
| `training-kit/websocket` | `.env` | Variables de entorno WebSocket |

## 3. Ejecutar Sistema
#### Iniciar Back-end
```
cd tranining-kit/api
php artisan serve
```

#### Iniciar Front-end
```
cd tranining-kit/web
npm run dev
```

#### Iniciar WebSocket
```
cd tranining-kit/websocket
node WebSocket.js
```

## 4. Ingresar al Sistema
```
http://localhost:5173
```

> Usuario: debug@eniwer.dev
>
> Contraseña: eniwer

## Licencia
Eniwer Training Kit es un sistema de código abierto desarrollado por ENIWER SpA en Chile bajo licencia XXXXXX.

##### Otras Licencias
- [Vue.js] - Framework Javascript para construir interfaces de usuario.
- [Vue Router] - Librería para gestionar enrutamiento de aplicaciones Vue.js.
- [Vuex] - Librería para gestionar el estado de aplicaciones Vue.js.
- [Laravel] - Framework PHP para construir interfaces de aplicaciones.
- [Laravel Passport] - Librería para implementar OAuth 2 en aplicaciones Laravel.
- [Bootstrap] - Librería CSS para estilizar interfaces gráficas.
- [FontAwesome] - Librería de iconos.


   [Vue.js]: <http://vuejs.org>
   [Vuex]: <https://vuex.vuejs.org/>
   [Vue Router]: <https://router.vuejs.org>
   [Laravel]: <https://laravel.com/>
   [Laravel Passport]: <https://laravel.com/docs/11.x/passport>
   [Bootstrap]: <https://getbootstrap.com>
   [FontAwesome]: <https://fontawesome.com>
