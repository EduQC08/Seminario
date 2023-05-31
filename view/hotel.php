<?php
session_start();

//Si el usario ya tiene una sesión activa ... entonces no debe estar aqui!!!

if(!isset($_SESSION['seguridad']) || $_SESSION['seguridad']['login'] == false){

  header('Location: ../index.php ');
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>


</head>

<body>

  <!-- Modal trigger button -->
  
  
  <!-- Optional: Place to the bottom of scripts -->

    <div class="container" id="container">
      <!-- <div class="row"> -->
        <nav class="navbar navbar-light bg-primary fixed-top ">
          <div class="container-fluid">
            <a class="navbar-brand text-white" href="#">Panel de Inicio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
              aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
              <h5><?= $_SESSION['seguridad']['nombre']?> <?= $_SESSION['seguridad']['apellidos']?></h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                  <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Escriba.." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                  </form>
                  <li class="nav-item ">
                    <a class="nav-link" href="./hotel.php">Inicio</a>
                  </li>
                  <li class="nav-item ">
                    <a class="nav-link" href="./registrarusuario.view.html">Registro de habitaciones alquiladas</a>
                  </li>
  
                  <li>
                    <a class="nav-link" aria-current="page" href="./habitaciones.html">habitaciones</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="../controller/usuario.controller.php?operacion=destroy">Cerrar sesión</a>
                  </li>
                </ul>
                
              </div>
            </div>
          </div>
        </nav>


<br>






      <tbody>

      </tbody>

        </div>

        <div class="container-fluid" id="content-dinamics">


        </div>
        <!-- Modal trigger button -->

        
        <!-- Modal Body -->
        <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->

        
        
        <!-- Optional: Place to the bottom of scripts -->

        
      </div>

      <script src="./vendor/jquery/jquery.min.js"></script>
    <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="./js/sb-admin-2.min.js"></script>
    
      <script>
        document.addEventListener("DOMContentLoaded", ()=> {
          const tabla = document.querySelector("#tabla-alquiler")
          const cuerpoTabla = document.querySelector("tbody")
          const btregistrar = document.querySelector("#modal")
          const lista       = document.querySelector("#habitacion")
          const Guardar = document.querySelector("#guardar")
          const MDhabitacion = document.querySelector("#md-habitacion")

          function getURL() {
            const url = new URL(window.location.href);

            const vista = url.searchParams.get("view");

            const contenedor = document.querySelector("#content-dinamics");

            if(vista != null){
              fetch(vista)
              .then(respuesta => respuesta.text())
              .then(datos => {
                contenedor.innerHTML = datos;

                const scriptsTag = contenedor.getElementsByTagName("script");
                for(i = 0; i < scriptsTag.length; i++){
                  eval(scriptsTag[i].innerText);
                }
              });
            }
          }


          function obtenerLista(){
            const parametros = new URLSearchParams();
            parametros.append("operacion", "listar");

            fetch('../controller/Alquiler.php',{
              method: 'POST',
              body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
              cuerpoTabla.innerHTML = ``;
              datos.forEach(element => {
                const fila = `
                <tr>
                  <td>${element.idalquiler}</td>
                  <td>${element.numhabitacion}</td>
                  <td>${element.apellidos}</td>
                  <td>${element.nombres}</td>
                  <td>${element.horaentrada}</td>
                  <td>${element.horasalida}</td>
                  <td>${element.costo}</td>
                  <td>${element.pago}</td>
                  
                  <td><button type="button" class="btn btn-sm btn-secondary" id="editar" ">Registrar salida</button>
                    
                  </td>
                  </tr>
                  `;
                  cuerpoTabla.innerHTML +=fila;
                
              });
            });
          }

          function obtenerHabitacion(){
            const parametros = new URLSearchParams();
            parametros.append("operacion", "buscar");
            parametros.append("numhabitacion", parseInt(lista.value));
            
            fetch('../controller/Alquiler.php',{
              method: 'POST',
              body:parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos =>{
              cuerpoTabla.innerHTML = ``;
              datos.forEach(element =>{
                const fila = `
                <tr>
                  <td>${element.idhabitacion}</td>  
                <td>${element.numhabitacion}</td>
                  <td>${element.apellidos}</td>
                  <td>${element.nombres}</td>
                  <td>${element.horaentrada}</td>
                  <td>${element.horasalida}</td>
                  <td>${element.costo}</td>
                  <td>${element.pago}</td>
                  </tr>
                `;
                cuerpoTabla.innerHTML +=fila;
              })
            })
          }

          function selectHabitacion(){
            const parametros = new URLSearchParams();
            parametros.append("operacion", "listar");

            fetch('../controller/habitacion.php',{
              method: 'POST',
              body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
              datos.forEach(element => {
                const optionTag = document.createElement("option");
                optionTag.value= element.idhabitacion;
                optionTag.text = element.numhabitacion;
                lista.appendChild(optionTag)
                
              });
            });
          }

          function seleccionarHabitacion(){
            const parametros = new URLSearchParams();
            parametros.append("operacion", "listar");

            fetch('../controller/habitacion.php',{
              method: 'POST',
              body: parametros
            })
            .then(respuesta => respuesta.json())
            .then(datos => {
              datos.forEach(element => {
                const optionTag = document.createElement("option");
                optionTag.value= element.idhabitacion;
                optionTag.text = element.numhabitacion;
                MDhabitacion.appendChild(optionTag)
                
              });
            });
          }
          



          getURL();
          obtenerLista();
          selectHabitacion();
          
          seleccionarHabitacion();
          lista.addEventListener("change", selectHabitacion)
          
          
          
        });
      </script>

</body>
</html>