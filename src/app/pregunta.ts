import { Opcion } from './opcion';

export interface Pregunta {
  id_examen?: number;
  pregunta: string;
  tipo: number;
  puntaje: number;
  opciones?: Opcion[]; // 👈 Agregado para evitar errores
}
