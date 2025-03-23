import { Component } from '@angular/core';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, FormArray} from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { RouterLink, RouterOutlet } from '@angular/router';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-reserva',
  standalone: true,
  imports: [RouterOutlet, ReactiveFormsModule, RouterLink, NgFor],
  templateUrl: './reserva.component.html',
  styleUrl: './reserva.component.css'
})
export class ReservaComponent {

  

  form: FormGroup;

  constructor(private http: HttpClient, private fb:FormBuilder) {
    
    this.form = this.fb.group({
      FechaHoraEntrega: [''],
      items: this.fb.array([])
    });
  }

  get items(): FormArray {
    return this.form.get('items') as FormArray;
  }

  addItem() {
    const itemGroup = this.fb.group({
      idSabor: [''],
      NumeroPorciones: ['']
    });
    this.items.push(itemGroup);
  }

  removeItem(index: number) {
    this.items.removeAt(index);
  }


  onSubmit(){
    if(this.form.valid){
      const datos = this.form.value;
      const TotalPrecio = datos.items.reduce((acc: number, item: { NumeroPorciones: number; }) => acc + item.NumeroPorciones * 14000, 0);
      this.http.post('http://127.0.0.1:8000/api/reserva', {FechaHoraEntrega: datos.FechaHoraEntrega, PrecioTotal: TotalPrecio, UsuarioDocumento: localStorage.getItem('documento')})
      .subscribe({
        next: (response) =>{
          console.log('Datos enviados exitosamente', response, localStorage.getItem('documento'));
        },
        error: (error) => {
          console.log('Error al enviar los datos', error, datos, datos.FechaHoraEntrega, localStorage.getItem('documento'));
        }
      });;
      
      datos.items.forEach((item: any) => {
        this.http.post('http://127.0.0.1:8000/api/linea', item)
        .subscribe({
          next: (response) => {
            console.log('Item enviado exitosamente', response, item);
          },
          error: (error) => {
            console.log('Error al enviar el item', error);
          }
        });
      });
    } else {
      console.log('Formulario invalido');
    }
  }
}

