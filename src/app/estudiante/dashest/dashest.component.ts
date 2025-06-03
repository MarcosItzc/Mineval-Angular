import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { Examen } from '../../examen';
import { ApiService } from '../../autservices/api.service';

@Component({
  selector: 'app-dashest',
  standalone: true,
  imports: [CommonModule, RouterModule],
  templateUrl: './dashest.component.html',
  styleUrls: ['./dashest.component.css']
})
export class DashestComponent {
  usuario = JSON.parse(localStorage.getItem('usuario') || '{}');
  evaluaciones: Examen[] = [];

  constructor(private apiService: ApiService) {}

  ngOnInit(): void {
    this.apiService.obtenerExamenes().subscribe(data => {
      this.evaluaciones = data;
      console.log(data); // Para depurar y ver si llegan los exámenes
    });
  }

  cerrarSesion(): void {
    localStorage.removeItem('usuario');
    window.location.href = '/login';
  }

  realizarEvaluacion(){
  }

  formatearDuracion(duracion: string): string {
  // Si viene en formato "HH:MM:SS.000000", cortamos hasta los primeros 8 caracteres
  return duracion ? duracion.substring(0, 8) : '';
}

}
