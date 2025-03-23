import { Component } from '@angular/core';
import { OnInit } from '@angular/core';
import { ClienteService } from '../../cliente.service';
import { CommonModule } from '@angular/common';
import { HttpClient } from '@angular/common/http';
import {ReactiveFormsModule}from '@angular/forms';
import { FormBuilder, FormGroup } from '@angular/forms';
import { response } from 'express';
import { error } from 'console';
@Component({
  selector: 'app-tabla-usuario',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './tabla-usuario.component.html',
  styleUrl: './tabla-usuario.component.css'
})
export class TablaUsuarioComponent implements OnInit {
  
  usuario: any[] = []; // Array para almacenar los datos de los usuarios
  mensajeError: string = ''; // Mensaje en caso de error
  formularioEdicion: FormGroup;
  formularioEliminar: FormGroup;
 
  constructor(private clienteService: ClienteService, private fb: FormBuilder , private http: HttpClient) {
    this.formularioEdicion = this.fb.group({
      UsuarioDocumento: [''],
      UsuarioDocumento1: [{value : '', disabled: true}],
      UsuarioTelefono: [''],
      Contrasena: [''],
      Correo: [''],
      UsuarioPrimerNombre: [''],
      UsuarioApellido: [''],
      idTipoDocumento: [''],
      idTipoUsuario: [''],
    });
    this.formularioEliminar = this.fb.group({
      UsuarioDocumento: ['']
    })
   }

  ngOnInit(): void {
    // Realizamos la solicitud cuando el componente se inicializa
    this.clienteService.getClientes().subscribe(
      (data) => {
        this.usuario = data;  // Asignamos los datos obtenidos a la variable usuario
      },
      (error) => {
        console.error('Error al obtener los Usuarios', error);
      }
    );
  }
  editarUsuario(usuario: any): void {
    // para Verificar que UsuarioDocumento este existiendo
    if (usuario && usuario.UsuarioDocumento) {
      console.log('Usuario a editar:', usuario);  // imprime los dtos del usario para ver sin son validos
      this.formularioEdicion.patchValue({
        UsuarioDocumento: usuario.UsuarioDocumento,
        UsuarioDocumento1: usuario.UsuarioDocumento,
        UsuarioTelefono: usuario.UsuarioTelefono,
        Contrasena: usuario.Contrasena,
        Correo: usuario.Correo,
        UsuarioPrimerNombre: usuario.UsuarioPrimerNombre,
        UsuarioApellido: usuario.UsuarioApellido,
        idTipoDocumento: usuario.idTipoDocumento,
        idTipoUsuario: usuario.idTipoUsuario
      });
    } else {
      console.error('Usuario no válido o sin Documento');
    }
  }

  guardarEdicion() {
    if (this.formularioEdicion.valid) {
      // Enviar los datos del formulario a la api para actualizar
      const datos =  this.formularioEdicion.value;
      this.http.put(`http://localhost:8000/api/pizzapaisa/${datos.UsuarioDocumento}`, datos)
      .subscribe(
        (response) => {
          console.log('Usuario actualizado', response);
          
        },
        (error: any) => {
          console.error('Error al actualizar el usuario', error);
        }
      );
    } else {
      console.log('Formulario inválido');
    }
  }
  eliminarUsuario(usuario: any): void{
    if(usuario.UsuarioDocumento){
      console.log('Usuario a elimianr:', usuario);
      this.formularioEliminar.patchValue({
        UsuarioDocumento: usuario.UsuarioDocumento
      });
  }else{
    console.error('error de usuario')
  }
    
 }

    guardarElimin(){
      if(this.formularioEliminar.valid){
        const datos =  this.formularioEliminar.value;
        this.http.delete(`http://localhost:8000/api/pizzapaisa/${datos.UsuarioDocumento}`)
        .subscribe(
          (response) =>{
            console.log('Usuario ELiminaod', response);
          },
          (error: any) =>{
            console.error('error al eliminar el usuario');
          }
        );
      }else{
        console.log('fornulario invalido');
      }
    }

}
  