import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-resolver-examen',
  imports: [CommonModule],
  templateUrl: './resolver-examen.component.html',
  styleUrls: ['./resolver-examen.component.css']
})
export class ResolverExamenComponent {
  examen = {
    titulo: 'Examen creado',
    preguntas: [
      {
        texto: '¿Cuanto es 2 + 2?',
        opciones: ['4', '3', 'Pez', 'No']
      },
      {
        texto: '¿Que dia es hoy?',
        opciones: ['28', '29', '30']
      },
      {
        texto: '¿Esta respuesta funciona?',
        opciones: ['Verdadero', 'Falso']
      }
    ]
  };
}
