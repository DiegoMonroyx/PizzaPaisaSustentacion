import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, FormBuilder, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { RouterLink, RouterOutlet } from '@angular/router';
import { ClienteService } from '../../cliente.service';
@Component({
  selector: 'app-formulario',
  standalone: true,
  imports: [ReactiveFormsModule, RouterLink, RouterOutlet],
  templateUrl: './formulario.component.html',
  styleUrls: ['./formulario.component.css'] 
})
export class FormularioComponent {
  form: FormGroup;
  tipoUsuario: any[] = [];
  tipoDocumento: any[] = [];

  constructor(private http: HttpClient, private router: Router, private fb: FormBuilder, private clienteService: ClienteService) {
    this.form = new FormGroup({
      UsuarioDocumento: new FormControl(''),
      UsuarioTelefono: new FormControl(''),
      Contrasena: new FormControl(''),
      Correo: new FormControl(''),
      UsuarioPrimerNombre: new FormControl(''),
      UsuarioApellido: new FormControl(''),
      idTipoDocumento: new FormControl(''),
      idTipoUsuario: new FormControl('')
    });
  }

  ngOnInit() {
    this.form = this.fb.group({
      idTipoUsuario: ['', Validators.required],
      idTipoDocumento: ['', Validators.required]
    });
    this.clienteService.getTiposUsuario().subscribe(tipos => {
      this.tipoUsuario = tipos; // Asegúrate de usar el nombre correcto
    });
    this.clienteService.getTiposDocumento().subscribe(tipos => {
      this.tipoDocumento = tipos; // Asegúrate de usar el nombre correcto
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
