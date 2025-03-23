import { Routes } from '@angular/router';
import { FormularioComponent } from './componentes/formulario/formulario.component';
import { IniciosesionComponent } from './componentes/iniciosesion/iniciosesion.component';
import { DisboardComponent } from './componentes/disboard/disboard.component';
import { authGuard } from './auth.guard';
import { TablaUsuarioComponent } from './componentes/tabla-usuario/tabla-usuario.component';
import { IframesComponent } from './componentesPhp/iframes/iframes.component';
import { ReservaComponent } from './componentes/reserva/reserva.component';

export const routes: Routes = [
<<<<<<< Updated upstream:laPizza/src/app/app.routes.ts
    { path: '', component: FormularioComponent },
    { path: 'inicio-sesion', component: IniciosesionComponent},
    { path: 'disboard', component: DisboardComponent,canActivate: [authGuard]},
    { path: 'tablaUsuario', component: TablaUsuarioComponent,canActivate: [authGuard]},
    { path: 'iframes', component: IframesComponent,canActivate: [authGuard]},
    { path: 'reserva', component: ReservaComponent},
=======
    { path: '', redirectTo: 'inicio-sesion', pathMatch: 'full' }, // 🔹 Cambiado
    { path: 'inicio-sesion', component: IniciosesionComponent },
    { path: 'disboard', component: DisboardComponent, canActivate: [authGuard] },
    { path: 'tablaUsuario', component: TablaUsuarioComponent, canActivate: [authGuard] },
    { path: 'iframes', component: IframesComponent, canActivate: [authGuard] },
    { path: 'reserva', component: ReservaComponent },
    { path: 'formulario', component: FormularioComponent }
>>>>>>> Stashed changes:Angular/laPizza/src/app/app.routes.ts
];
