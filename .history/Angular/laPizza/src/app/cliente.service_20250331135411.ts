import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ClienteService {

  private apiUrl = 'http://localhost:8000/api/pizzapaisa';
  
  constructor(private http: HttpClient) {}


  // Método para obtener los clientes
  getClientes(): Observable<any[]> {
    return this.http.get<any[]>(this.apiUrl);
  }
  getTiposUsuario() {
    return this.http.get<any[]>(`${this.apiUrl}/tipos-usuario`);
  }
  getTiposDocumento() {
    return this.http.get<any[]>(`${this.apiUrl}/tipos-documento`);
  }

  //updateCliente(usuario: any) {
   // const url = `http://localhost:8000/api/pizzapaisa/${usuario.UsuarioDocumento}`;
//return this.http.put(url, usuario);}
}
