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
  tiposUsuario = [{ idTipoUsuario: 3, tipoUsuario: 'Cliente' }]; // Solo una opción para Tipo Usuario
  tiposDocumento = [
    { idTipoDocumento: 1, tipoDocumento: 'Cédula de ciudadanía' },
    { idTipoDocumento: 2, tipoDocumento: 'Cédula extranjera' },
    { idTipoDocumento: 3, tipoDocumento: 'Pasaporte' }
  ];

  constructor(private http: HttpClient, private router: Router, private fb: FormBuilder, private clienteService: ClienteService) {
    this.form = this.fb.group({
      UsuarioDocumento: [''],
      UsuarioTelefono: [''],
      Contrasena: [''],
      Correo: [''],
      UsuarioPrimerNombre: [''],
      UsuarioApellido: [''],
      idTipoDocumento: ['', Validators.required],
      idTipoUsuario: [this.tiposUsuario[0].idTipoUsuario, Validators.required] // Establecer valor por defecto
    });
  }

  ngOnInit() {
    // Aquí puedes cargar tiposUsuario desde el servicio si lo necesitas
    this.clienteService.getTiposDocumento().subscribe(tipos => {
      this.tiposDocumento = tipos; // Asegúrate de que esta variable esté definida
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
