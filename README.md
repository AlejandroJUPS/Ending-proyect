# Ending XMB v1.0

## Instalación
1. **Haz copia de seguridad del repositorio y del sitio actual.** Esta versión sustituye el `index.php` de diagnóstico cuando la copies a la raíz del repositorio.
2. Copia el contenido de esta carpeta a la raíz de `Ending-proyect` (no dentro de otra subcarpeta). Mantén los secretos `FTP_USERNAME`, `FTP_PASSWORD` y `MYSQL_PASSWORD` en GitHub Settings → Secrets and variables → Actions.
3. En InfinityFree abre phpMyAdmin de `if0_43158060_END`, pestaña **Importar**, y selecciona `sql/ending.sql`. El SQL solo crea `users` y `favorites` si no existen; verifica que no haya tablas antiguas con estructura incompatible.
4. En GitHub Desktop: Commit → Push origin. Comprueba el resultado en Actions y luego `https://ending.xo.je`.
5. Para juegos, **no subas ROMs a GitHub**. Sube tus archivos de juego autorizados directamente por FTP a `htdocs/roms/<carpeta>/` y los cores compatibles a `htdocs/data/cores/`. Las ROMs están excluidas de Git y del despliegue automático. El catálogo detecta archivos sin necesidad de insertar registros SQL.

## Carpetas para ROMs
`roms/nes`, `roms/snes`, `roms/n64`, `roms/gb`, `roms/gbc`, `roms/gba`, `roms/psx`, `roms/segaMD`.

## Emulación
El reproductor usa `data/loader.js` y la biblioteca EmulatorJS recuperada del proyecto anterior. Los núcleos **no están incluidos**. Necesitas las versiones y nombres compatibles con tu `data/loader.js`; comprueba la compatibilidad de cada consola y formato. Los juegos con archivos adicionales (por ejemplo PS1 con BIN/CUE) requieren subir también sus dependencias y una estructura de archivos adecuada; esta versión inicial detecta archivos sueltos y no gestiona automáticamente conjuntos multidisco. Los juegos solo funcionan cuando el navegador puede acceder a los archivos necesarios. Las carpetas de ROMs y sus archivos son accesibles por URL si los publicas en `htdocs`; no uses esta solución para material privado.

## Seguridad y alcance
Se usan consultas preparadas, contraseñas hasheadas, sesiones y token CSRF. La autenticación no incluye aún recuperación de contraseña, correo verificado ni limitación de intentos de acceso: **no lo consideres un sistema de cuentas endurecido para producción pública**. Recomendamos probar con usuarios de prueba y añadir protección contra fuerza bruta antes de abrir el registro a todos. El servidor debe admitir PDO MySQL. El archivo `.private/db-config.php` se genera en GitHub Actions, no debe incluirse en el repositorio. Si ya tienes otras tablas, haz backup antes de importar.

## Notas
Los iconos son SVG uniformes y el XMB conserva la navegación horizontal y vertical. Los recursos de `assets` son demostrativos; no se asignan carátulas automáticamente a juegos nuevos. La búsqueda y favoritos sí funcionan cuando las tablas existen. Se recomienda revisar permisos/licencias de imágenes y de cada juego.
