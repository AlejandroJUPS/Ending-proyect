# Ending Project — prueba inicial

Proyecto temporal para probar PHP, MySQL y despliegue FTP en InfinityFree.

## Configurar secretos

En GitHub > repositorio > Settings > Secrets and variables > Actions > New repository secret, crear:

- `FTP_USERNAME`: `if0_43158060`
- `FTP_PASSWORD`: contraseña FTP de InfinityFree (no subirla al repositorio)
- `MYSQL_PASSWORD`: contraseña MySQL de InfinityFree (no subirla al repositorio)

La contraseña aparece en capturas previas: **se recomienda cambiar las contraseñas en InfinityFree antes de guardarlas en GitHub**.

## Subir desde GitHub Desktop

1. Abrir el repositorio `Ending-proyect` con rama `main`.
2. Abrir `Repository > Show in Explorer`.
3. Copiar `index.php`, `db.php`, `.gitignore` y la carpeta `.github` de este paquete a la raíz del repositorio.
4. En GitHub Desktop: escribir un resumen de cambios, pulsar `Commit to main` y luego `Push origin` (o `Publish repository` si aún no está publicado).
5. En GitHub web: pestaña `Actions` > `Publicar Ending en InfinityFree` > verificar que la ejecución sea verde.
6. Abrir `https://ending.xo.je` para ver el estado de PHP y MySQL.

Si aparece MySQL pendiente, revisar el secreto MYSQL_PASSWORD, el nombre de la base y la sección Actions; no se muestran detalles de errores al público.

## Notas

- El archivo `db-config.php` se genera en el runner de GitHub y se publica por FTP; no se almacena en Git.
- Esta página pública muestra estado de MySQL. Cuando se publique la web definitiva, eliminar el diagnóstico público o protegerlo.
- No se crean tablas ni se importa contenido antiguo.
- **Atención:** FTP sin cifrado no protege las credenciales ni los archivos en tránsito. Es una limitación del mecanismo FTP disponible; evitar usar este flujo para datos sensibles si se dispone de una alternativa cifrada.
- El directorio FTP `/htdocs/` es el esperado para el dominio principal. Si el sitio usa otra raíz FTP, ajustar `server-dir`.
