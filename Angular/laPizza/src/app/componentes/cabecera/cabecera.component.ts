import { Component} from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import { AuthService } from '../../auth.service';
@Component({
  selector: 'app-cabecera',
  standalone: true,
  imports: [RouterLink, CommonModule],
  templateUrl: './cabecera.component.html',
  styleUrl: './cabecera.component.css'
})
export class CabeceraComponent {
  esGerente: boolean = false;
  constructor(private authService: AuthService) {}
   
   ngOnInit(): void {
    // Determina si el usuario es gerente
    this.esGerente = this.authService.isAuthenticatedGerente();
  }
  onLogout() {
    this.authService.logout();
  }
}
