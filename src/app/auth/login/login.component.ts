import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApiService } from '../../autservices/api.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-login',
    imports: [CommonModule, ReactiveFormsModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  correo: string = '';
  contrasena: string = '';
  error: string = '';

  constructor(private apiService: ApiService, private router: Router) {}

  iniciarSesion(): void {
  this.apiService.loginUsuario(this.correo, this.contrasena).subscribe({
    next: (respuesta) => {
      console.log('Respuesta completa:', respuesta);

      if (respuesta.success && respuesta.usuario) {
        const usuario = respuesta.usuario;
         console.log('Usuario recibido:', usuario);
         console.log('Tipo original del rol:', typeof usuario.rol);

         const rol = Number(usuario.rol); // 🔥 Esta línea fuerza que el rol sea un number
         console.log('Rol recibido:', rol, 'Tipo:', typeof rol);

        switch (rol) {
        case 1:
          this.router.navigate(['/estudiante']);
          break;
        case 2:
          this.router.navigate(['/profesor']);
          break;
        default:
          console.warn('Rol desconocido:', rol);
      }
      } else {
        console.warn('Datos inválidos recibidos.');
        this.error = 'Datos inválidos.';
      }
    },
    error: (error) => {
      console.error('Error inesperado:', error);
      this.error = 'Hubo un error al intentar iniciar sesión.';
    }
  });
}

}
