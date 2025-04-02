import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { RouterLink, RouterOutlet } from '@angular/router';
import { ClienteService } from '../../cliente.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-formulario',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterLink, RouterOutlet],
  templateUrl: './formulario.component.html',
  styleUrls: ['./formulario.component.css'] 
})
export class FormularioComponent implements OnInit {
  form: FormGroup;
  tiposUsuario = [{ idTipoUsuario: 3, tipoUsuario: 'Cliente' }];
  tiposDocumento = [
    { idTipoDocumento: 1, tipoDocumento: 'Cédula de ciudadanía' },
    { idTipoDocumento: 2, tipoDocumento: 'Cédula extranjera' },
    { idTipoDocumento: 3, tipoDocumento: 'Pasaporte' }
  ];

  constructor(private http: HttpClient, private router: Router, private fb: FormBuilder, private clienteService: ClienteService) {
    this.form = this.fb.group({
      UsuarioDocumento: ['', [Validators.required, Validators.pattern('^[0-9]*$')]], // Requerido y solo números
      UsuarioTelefono: ['', [Validators.required, Validators.pattern('^[0-9]*$')]], // Requerido y solo números
      Contrasena: ['', [Validators.required, Validators.minLength(6)]], // Requerido y longitud mínima de 6
      Correo: ['', [Validators.required, Validators.email]], // Requerido y correo electrónico
      UsuarioPrimerNombre: ['', Validators.required], // Requerido
      UsuarioApellido: ['', Validators.required], // Requerido
      idTipoDocumento: ['', Validators.required], // Requerido
      idTipoUsuario: [this.tiposUsuario[0].idTipoUsuario, Validators.required] // Requerido
    });
  }

  ngOnInit() {
    this.clienteService.getTiposDocumento().subscribe(tipos => {
      console.log('Tipos de documento recibidos:', tipos); 
      this.tiposDocumento = tipos; 
    }, error => {
      console.error('Error al obtener tipos de documento:', error);
    });
  }
  

  onSubmit() {
    if (this.form.valid) {
      const datos = this.form.value;
      this.http.post('http://localhost:8000/api/pizzapaisa', datos).subscribe({
        next: (respuesta) => {
          console.log('Datos enviados exitosamente', respuesta);
          this.router.navigate(['/inicio-sesion']);
        },
        error: (error) => {
          console.log('Hubo un error al enviar los datos', error);
        }
      });
    } else {
      console.log('Error en el formulario');
    }
  }
}
