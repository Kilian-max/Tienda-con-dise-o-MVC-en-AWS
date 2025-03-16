# Índice

- [Descripción del Proyecto](#descripción-del-proyecto)
- [Objetivos](#objetivos)
- [Pasos a Seguir](#pasos-a-seguir)

## Descripción del Proyecto

Este es un proyecto con modelo MVC de una tienda online de videojuegos en Amazon AWS. 

La aplicación implementa un sistema completo de comercio electrónico especializado en videojuegos, utilizando la arquitectura Modelo-Vista-Controlador para mantener un código organizado y escalable. El sistema está desplegado en la infraestructura de Amazon Web Services, aprovechando sus servicios para garantizar rendimiento, disponibilidad y seguridad.

La plataforma permite a los usuarios navegar por un catálogo de videojuegos, ver detalles de productos, gestionar un carrito de compras y completar el proceso de compra. Además, cuenta con un panel de administración para la gestión de productos e inventario.

## Objetivos

### Objetivos mínimos a implementar
1. **Listado de productos.**
2. **Ver un producto (Mostrar una descripción de un producto).**
3. **Inicio de sesión (admin y usuario). Se deben crear los usuarios directamente en la BBDD.**
4. **Dar de alta nuevo producto (solo administrador).**
5. **Añadir producto a carro de compra.**
6. **Ver carro de la compra.**

## Pasos a Seguir

### Desarrollo Local con Docker
Lo primero de todo ha sido hacer los códigos de PHP y HTML de la página en contenedores de Docker de manera local para una vez tener la tienda lista, pasar los contenedores por SCP al servidor de AWS.

### Despliegue en AWS

1. **Creación de la instancia EC2**
   - Seleccionamos que la instancia se llame "mi página web" y la imagen sea una Ubuntu
   - *(Aquí irá la foto)*

2. **Configuración de la seguridad**
   - Creamos un par de claves para poder conectarnos con SSH
   - *(Aquí irá la foto)*
   - En el grupo de seguridad seleccionamos que permita el paso de SSH, HTTP y HTTPS desde todas las IPs
   - *(Aquí irá la foto)*

3. **Configuración de la IP**
   - Creamos una IP elástica y se la asignamos a la instancia que hemos creado
   - *(Aquí irá la foto)*

4. **Conexión SSH a la instancia**
   - En nuestra terminal vamos a descargas (donde tendremos el par de claves)
   - Hacemos un comando para que la clave no se pueda ver públicamente:
     ```
     chmod 400 "ssh_iaw.pem"
     ```
   - Nos conectamos a la instancia con este comando y creamos el directorio EntornoDesarrollo:
     ```
     ssh -i "ssh_iaw.pem" ubuntu@ec2-34-235-76-199.compute-1.amazonaws.com
     ```

5. **Transferencia de archivos**
   - Con el siguiente comando le pasamos todos los ficheros del directorio donde tenemos el docker.yml para crear los contenedores con los archivos .php de todos los scripts de la página:
     ```
     sudo scp -i "ssh_iaw.pem" -r /home/kilian/Escritorio/Entorno\ Desarrollo\ PHP/ ubuntu@ec2-34-235-76-199.compute-1.amazonaws.com:/home/ubuntu/EntornoDesarrollo
     ```

6. **Instalación de Docker**
   - Instalamos Docker:
     ```
     # Comandos para instalar Docker
     ```

7. **Despliegue de contenedores**
   - Levantamos los contenedores:
     ```
     sudo docker compose up -d
     ```
   - Hacemos que siempre que se encienda la máquina se levanten los contenedores:
     ```
     # Comando necesario
     ```

8. **Verificación del despliegue**
   - Comprobamos desde el navegador con la IP pública si se visualiza la página
   - *(Aquí irá la foto)*
