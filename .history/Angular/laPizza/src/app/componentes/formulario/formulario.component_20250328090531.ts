import { Component } from '@angular/core';
import { FormControl,FormGroup,ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { RouterLink, RouterOutlet } from '@angular/router';
@Component({
  selector: 'app-formulario',
  standalone: true,
  imports: [ReactiveFormsModule,RouterLink,RouterOutlet],
  templateUrl: './formulario.component.html',
  styleUrl: './formulario.component.css'
})
export class FormularioComponent {
  form: FormGroup;

  constructor(private http: HttpClient, private router: Router) {
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
