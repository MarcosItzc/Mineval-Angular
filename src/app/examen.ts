export interface Examen {
  id_examen?: number;
  materia: string;
  institucion: string;
  titulo: string;
  descripcion: string;
  duracion: string; // formato HH:mm:ss (si usas <input type="time"> puede bastar con HH:mm)
}
