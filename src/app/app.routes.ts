import { Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { RegistroComponent } from './auth/registro/registro.component';
import { LoginComponent } from './auth/login/login.component';
import { DashboardComponent } from './profesor/dashboard/dashboard.component';
import { CrearExamenComponent } from './profesor/crear-examen/crear-examen.component';
import { DashestComponent } from './estudiante/dashest/dashest.component';
import { ResolverExamenComponent } from './estudiante/resolver-examen/resolver-examen.component';


export const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },
  { path: 'home', component: HomeComponent },
  { path: 'registro', component: RegistroComponent },
  { path: 'login', component: LoginComponent },
  { path: 'profesor', component: DashboardComponent},
  { path: 'crearExamen', component: CrearExamenComponent},
  { path: 'estudiante', component: DashestComponent},
  { path: 'resolver', component: ResolverExamenComponent}
];
