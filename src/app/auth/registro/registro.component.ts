import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ApiService } from '../../autservices/api.service'; // ajusta la ruta
import { Usuario } from '../../usuario';


@Component({
  selector: 'app-registro',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css']
})

export class RegistroComponent {
  registroForm: FormGroup;
  mensaje: string = '';

  

  constructor(private fb: FormBuilder, private apiService: ApiService) {
    this.registroForm = this.fb.group({
      nombre: ['', Validators.required],
      apellido: ['', Validators.required],
      correo: ['', [Validators.required, Validators.email]],
      contrasena: ['', Validators.required],
      rol: [null, Validators.required], // o un select con 1 = prof, 2 = estudiante
    });
  }

  onSubmit() {
  if (this.registroForm.invalid) return;

  const formValues = this.registroForm.value;

const nuevoUsuario: Usuario = {
  nombre: formValues.nombre,
  apellido: formValues.apellido,
  correo: formValues.correo,
  contrasena: formValues.contrasena,
  rol: Number(formValues.rol) // ← fuerza que sea entero
};

  this.apiService.registro(nuevoUsuario).subscribe({
    next: (res) => {
      if (res.success) {
        this.mensaje = 'Registro exitoso';
        this.registroForm.reset();
      } else {
        this.mensaje = res.message || 'Error en el registro';
      }
    },
    error: (err) => {
      this.mensaje = 'Error en la comunicación con el servidor';
    },
  });
}

}
