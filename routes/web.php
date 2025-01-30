<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BloqueoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetalleSemanalController;
use App\Http\Controllers\EstadisticasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ConvenioController;
use App\Models\Cita;
use App\Http\Controllers\EspecialidadController;
use App\Models\Especialidad;

// LOGIN
Route::get('/', [LoginController::class, 'indexLogin'])->name('login');
Route::get('/register', [LoginController::class, 'indexRegistro'])->name('registro');

Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/iniciar-sesion', [LoginController::class, 'login'])->name('iniciar-sesion');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

//user
Route::resource('users', UserController::class);
Route::put('users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
Route::put('users/{user}/edit', [UserController::class, 'update'])->name('users.update');


//medico
Route::resource('medicos', MedicoController::class);
Route::get('/medicos/create', [MedicoController::class, 'create'])->name('medicos.create');
//medico horario
Route::get('/medicos/{medico}/horario', [MedicoController::class, 'editHorario'])->name('medicos.horario');
Route::put('/medicos/{medico}/horario', [MedicoController::class, 'updateHorario'])->name('medicos.horario.update');
//medico Bloqueo temporal
Route::get('/medicos/{medico}/bloqueos', [MedicoController::class, 'getBloqueos'])->name('medicos.bloqueos');
// Route::post('/medicos/{medico}/bloqueos', [MedicoController::class, 'storeBloqueo'])->name('medicos.bloqueos.store');
// Route::post('/bloqueos_programados', [BloqueoController::class, 'store'])->name('bloqueos.store');

// PACIENTE
Route::resource('paciente', PacienteController::class);
Route::get('paciente/{paciente}/edit', [PacienteController::class, 'edit'])->name('paciente.edit'); // Ruta para editar
Route::get('paciente/{paciente}', [PacienteController::class, 'show'])->name('paciente.show');     // Ruta para mostrar
Route::delete('paciente/{paciente}', [PacienteController::class, 'destroy'])->name('paciente.destroy'); // Ruta para eliminar


// CITAS
Route::resource('cita', CitaController::class);
Route::get('/citas', [CitaController::class, 'index']);
Route::get('/citas/{cita}', [CitaController::class, 'show'])->name('cita.show');;
// Ruta para crear una nueva cita
Route::post('/api/citas', [CitaController::class, 'store']);
// Route::middleware('api')->group(function () {
//   Route::post('/citas', [CitaController::class, 'store']);
// });
Route::post('/citas', [CitaController::class, 'store']);

// Ruta para actualizar una cita existente
Route::put('/citas/{id}', [CitaController::class, 'update']);
// Ruta para eliminar una cita
Route::delete('/citas/{id}', [CitaController::class, 'destroy']);
Route::get('/api/citas', function () {
  return Cita::all(); // Puedes agregar filtros o relaciones si es necesario
});


//ESPECIALIDAD
Route::resource('especialidades', EspecialidadController::class);
Route::post('/especialidades/{id}/especialidades', [EspecialidadController::class, 'store']);
Route::post('/especialidades', [EspecialidadController::class, 'store'])->name('especialidades.store');
Route::put('especialidades/{id}', [EspecialidadController::class, 'update'])->name('especialidades.update');


// Mostrar bloqueos por médico
Route::get('/medicos/{medicoId}/bloqueos', [BloqueoController::class, 'index']);
// Guardar nuevo bloqueo
Route::post('/medicos/{medicoId}/bloqueos', [BloqueoController::class, 'store']);
// Eliminar bloqueo
Route::delete('/bloqueos/{id}', [BloqueoController::class, 'destroy']);

//Agenda- paso 1
Route::get('/agenda/agendamiento', [AgendaController::class, 'index'])->name('agenda');
Route::post('/agenda/agendamiento', [AgendaController::class, 'validarRUT']);

//Agenda- paso 2
// Mostrar el formulario de reserva
Route::get('/reservar-cita', [CitaController::class, 'mostrarFormularioReserva'])->name('reservar-cita');
// Guardar una reserva
Route::post('/guardar-reserva', [CitaController::class, 'guardarReserva'])->name('guardar-reserva');
// Obtener horarios disponibles
Route::post('/horarios-disponibles', [CitaController::class, 'obtenerHorariosDisponibles'])->name('horarios.disponibles');


//Agenda-Pacientes
Route::post('/agenda/validar-paciente', [PacienteController::class, 'validarPaciente']);
Route::get('/registro-paciente', [PacienteController::class, 'mostrarFormularioRegistro'])->name('registro-paciente');
Route::post('/guardar-paciente', [PacienteController::class, 'guardarPaciente'])->name('guardar-paciente');




//Box
Route::resource('boxes', BoxController::class);

//encuesta
Route::view('/encuesta', 'content.encuesta-satisfacion.encuesta')->name('encuesta');
Route::get('/encuesta/enviar', [EncuestaController::class, 'enviar'])->name('encuesta.enviar');



//Convenio
Route::resource('convenios', ConvenioController::class);


// Route::post('/medicos', [MedicoController::class, 'store'])->name('medicos.store');


Route::middleware([
  'auth',
  // 'verified',
  // 'checkRole:3',
])->group(function () {});
