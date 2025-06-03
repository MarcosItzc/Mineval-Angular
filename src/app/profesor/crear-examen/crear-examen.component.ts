import { Component } from '@angular/core';
import { ApiService } from '../../autservices/api.service';
import { Examen } from '../../examen';
import { Pregunta } from '../../pregunta';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-crear-examen',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './crear-examen.component.html',
  styleUrls: ['./crear-examen.component.css']
})
export class CrearExamenComponent {
  materia = '';
  institucion = '';
  titulo = '';
  descripcion = '';
  duracion = '';

  // Preguntas
preguntas: {
  pregunta: string;
  tipo: number;
  puntaje: number;
  opciones: {
    texto_opcion: string;
    correcta: boolean;  // ✅ Esto acepta true/false
    id_pregunta: number;
  }[];
}[] = [];



  constructor(private apiService: ApiService) {
  this.agregarPregunta(); // 👈 Esto agrega una pregunta al iniciar
}


crearExamen() {
  const duracionFormateada = this.duracion.length === 5
    ? this.duracion + ':00.000000'
    : this.duracion;

  const nuevoExamen: Examen = {
    materia: this.materia,
    institucion: this.institucion,
    titulo: this.titulo,
    descripcion: this.descripcion,
    duracion: duracionFormateada
  };

  console.log('📤 Enviando examen:', nuevoExamen);
  console.log('📝 Preguntas asociadas:', this.preguntas);

  this.apiService.crearEvaluacion(nuevoExamen).subscribe({
    next: res => {
      const idExamen = res.id_examen;
      console.log('✅ Examen creado con ID:', idExamen);

      this.preguntas.forEach(p => {
        const nuevaPregunta = {
          id_examen: idExamen,
          pregunta: p.pregunta,
          tipo: p.tipo,
          puntaje: p.puntaje
        };

        this.apiService.crearPregunta(nuevaPregunta).subscribe({
          next: resPregunta => {
            const idPregunta = resPregunta.id_pregunta;
            console.log('✅ Pregunta creada con ID:', idPregunta);

            // Enviar opciones de la pregunta
            p.opciones.forEach(o => {
const nuevaOpcion = {
  id_pregunta: idPregunta,
  texto_opcion: o.texto_opcion,
  correcta: o.correcta ? 1 : 0  // 👈 convierte boolean a número si el backend lo requiere
};

console.log('➡️ Enviando opción:', nuevaOpcion);


              this.apiService.crearOpcion(nuevaOpcion).subscribe({
                next: res => {
                  console.log('✅ Opción guardada:', res);
                },
                error: err => {
                  console.error('❌ Error al guardar opción:', err);
                }
              });
            });
          },
          error: err => {
            console.error('❌ Error al guardar pregunta:', err);
          }
        });
      });

      alert('Examen, preguntas y opciones creados exitosamente');
      this.limpiarCampos();
    },
    error: err => {
      console.error('❌ Error al crear el examen:', err);
      alert(err.error?.error || 'Error al crear el examen');
    }
  });
}


limpiarCampos() {
  this.materia = '';
  this.institucion = '';
  this.titulo = '';
  this.descripcion = '';
  this.duracion = '';
  this.preguntas = [];
}


agregarPregunta() {
  const nuevaPregunta = {
    pregunta: '',
    tipo: 2,
    puntaje: 1,
    opciones: [
      { texto_opcion: '', correcta: false, id_pregunta: 0 },
      { texto_opcion: '', correcta: false, id_pregunta: 0 }
    ]
  };
  this.preguntas.push(nuevaPregunta);
}

agregarOpcion(i: number) {
  this.preguntas[i].opciones.push({
    texto_opcion: '',
    correcta: false,
    id_pregunta: 0
  });
}


eliminarOpcion(i: number, j: number) {
  if (this.preguntas[i].opciones.length > 2) {
    this.preguntas[i].opciones.splice(j, 1);
  }
}



  eliminarPregunta(index: number) {
    this.preguntas.splice(index, 1);
  }

  
}
