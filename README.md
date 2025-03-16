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
   ![Captura desde 2025-03-16 16-53-14](https://github.com/user-attachments/assets/bfc8b293-fee9-4aaa-9c85-e21e5325fc8c)


2. **Configuración de la seguridad**
   - Creamos un par de claves para poder conectarnos con SSH
   ![Captura desde 2025-03-16 16-53-43](https://github.com/user-attachments/assets/4873f5a3-3dcd-4eb5-af5e-90230a0b235c)

   - En el grupo de seguridad seleccionamos que permita el paso de SSH, HTTP y HTTPS desde todas las IPs
   ![Captura desde 2025-03-16 16-54-13](https://github.com/user-attachments/assets/9feb3b02-ab67-4704-ab7c-591d4b6bd1d8)


3. **Configuración de la IP**
   - Creamos una IP elástica y se la asignamos a la instancia que hemos creado
   ![Captura desde 2025-03-16 16-54-49](https://github.com/user-attachments/assets/a420a328-f3b8-49e9-a329-2fc23f3c1f5d)


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
     #Actualizamos los repositorios
     sudo apt update && sudo apt upgrade -y
     ```
     ```
     # Instala paquetes necesarios para permitir a apt usar repositorios sobre HTTPS
     sudo apt-get install -y \
     apt-transport-https \
     ca-certificates \
     curl \
     gnupg \
     lsb-release
     ```
     ```
     # Añade la clave GPG oficial de Docker
     curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
     ```
     ```
      # Configura el repositorio estable de Docker
      echo \
        "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/ubuntu \
        $(lsb_release -cs) stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
     ```
     ```
     # Actualiza de nuevo los repositorios con el nuevo repositorio de Docker añadido
     sudo apt-get update
     ```
     ```
     # Instala Docker Engine
     sudo apt-get install -y docker-ce docker-ce-cli containerd.io
     ```
     ```
     # Instala Docker Compose
     sudo apt-get install -y docker-compose

     ```

7. **Despliegue de contenedores**
   - Levantamos los contenedores:
     ```
     sudo docker compose up -d
     ```
   - Hacemos que siempre que se encienda la máquina se levanten los contenedores:
     ```
     sudo systemctl enable docker
     ```
   - Crea un archivo de servicio systemd para tu proyecto Docker Compose. Por ejemplo, en /etc/systemd/system/docker-compose-app.service:
      ```
      [Unit]
      Description=Docker Compose Application
      After=docker.service
      Requires=docker.service
      
      [Service]
      WorkingDirectory="/home/ubuntu/Entorno Desarrollo PHP
      ExecStart=/usr/local/bin/docker-compose up --remove-orphans
      ExecStop=/usr/local/bin/docker-compose down
      Restart=always
      TimeoutSec=300
      
      [Install]
      WantedBy=multi-user.target
      ```

8. **Verificación del despliegue**
   - Reiniciamos la máquina
     ```
     sudo reboot
     ```
   - Comprobamos desde el navegador con la IP pública  si se visualiza la página
   ![Captura desde 2025-03-16 18-01-48](https://github.com/user-attachments/assets/8fb86007-f34f-45b5-9a84-0ca77ecd250d)

