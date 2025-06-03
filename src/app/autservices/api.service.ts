import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Usuario } from '../usuario';
import { Examen } from '../examen';
import { Pregunta } from '../pregunta';
import { Opcion } from '../opcion';
import { Observable } from  'rxjs';
import { provideHttpClient } from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class ApiService {

  
  PHP_API_SERVER = "http://127.0.0.1:80";
  constructor(private httpClient: HttpClient) {}


  crearEvaluacion(examen: Examen): Observable<any> {
  return this.httpClient.post<any>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/crearEvaluacion.php`,
    examen,
    {
      headers: { 'Content-Type': 'application/json' }
    }
  );
}


loginUsuario(correo: string, contrasena: string) {
  return this.httpClient.post<any>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/login.php`,
    { correo, contrasena },
    {
      headers: { 'Content-Type': 'application/json' }
    }
  );
}


  crearOpcion(opcion: Opcion): Observable<any> {
  return this.httpClient.post<any>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/crearOpcion.php`,
    opcion,
    {
      headers: { 'Content-Type': 'application/json' }
    }
  );
}


crearPregunta(pregunta: Pregunta): Observable<any> {
  return this.httpClient.post<any>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/crearPregunta.php`,
    pregunta,
    {
      headers: { 'Content-Type': 'application/json' }
    }
  );
}

preguntas(): Observable<Pregunta[]> {
  return this.httpClient.get<Pregunta[]>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/preguntas.php`
  );
}

registro(usuario: Usuario): Observable<any> {
  return this.httpClient.post<any>(`${this.PHP_API_SERVER}/Mineval-Angular/api/registro.php`, usuario);
}

obtenerExamenes(): Observable<Examen[]> {
  return this.httpClient.get<Examen[]>(
    `${this.PHP_API_SERVER}/Mineval-Angular/api/obtenerExamenes.php`
  );
}


}

export interface RegistroResponse {
  success: boolean;
  message: string;
}
