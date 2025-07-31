<?php

use App\Http\Controllers\AreaAtuacaoController;
use App\Http\Controllers\CursoController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstituicaoController;
use App\Http\Controllers\Formacao_AcademicaController;

use App\Http\Controllers\ExperienciaController;
use App\Http\Controllers\CidadeController;
use App\Http\Controllers\EnderecoController;

use App\Http\Controllers\PessoaController;
use App\Http\Controllers\PessoasFisicaController;


use App\Http\Controllers\VagaController;
use App\Http\Controllers\HabilidadeController;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

Route::get('/status', function () {
    return response()->json(
        [
            'status' => 'ok',
            'message' => 'API is runing'
        ],
        200
    );
});

//Rotas de areas de atuação
Route::resource('/areas', AreaAtuacaoController::class);

//Rotas de Instituição
Route::resource('/instituicoes', InstituicaoController::class);

//Rotas de formacoes academicas
Route::resource('/formacoes_academicas', Formacao_AcademicaController::class);

//Rotas de experiencias
Route::resource('/experiencias', ExperienciaController::class);


Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/showAllCursos', [CursoController::class, 'showAll']);
Route::get('/cursos/{id_curso}', [CursoController::class, 'show']);
Route::post('/cursos', [CursoController::class, 'store']);
Route::put('/cursos/{id_curso}', [CursoController::class, 'update']);
Route::delete('/cursos/{id_cursos}', [CursoController::class, 'destroy']);
Route::post('/cursos/{id}/toggle-status', [CursoController::class, 'toggleStatus']);

Route::get('/showAllHabilidades', [HabilidadeController::class, 'showAll']);
Route::get('/habilidades', [HabilidadeController::class, 'index']);
Route::get('/habilidades/{id_habilidade}', [HabilidadeController::class, 'show']);
Route::post('/habilidades', [HabilidadeController::class, 'store']);
Route::put('/habilidades/{id_habilidade}', [HabilidadeController::class, 'update']);
Route::delete('/habilidades/{id_habilidade}', [HabilidadeController::class, 'destroy']);
Route::post('/habilidades/{id}/toggle-status', [HabilidadeController::class, 'toggleStatus']);


Route::post('/cursosOnVaga/{id_cursos}/{id_vagas}', [CursoController::class, 'adicionarCursoVaga']);
Route::get('/cursosOnVaga/{id_vagas}', [CursoController::class, 'verCursosVaga']);
Route::delete('/cursosOnVaga/{id_cursos}/{id_vagas}', [CursoController::class, 'removerCursoVaga']);

Route::post('/cursosOnPessoaFisica', [CursoController::class, 'adicionarCurso']);
Route::get('/cursosOnPessoaFisica/{id_pessoas}', [CursoController::class, 'verCursos']);
Route::put('/cursosOnPessoaFisica/{id}', [CursoController::class, 'updateCurso']);
Route::delete('/cursosOnPessoaFisica/{id_cursos}/{id_pessoas}', [CursoController::class, 'removerCurso']);
Route::get('/cursos/por-instituicao/{id}', [CursoController::class, 'listarPorInstituicao']);
//Route de vagas
Route::post('/cadVagas', [VagaController::class, 'store']);
Route::get('/vagas/{id_vagas}', [VagaController::class, 'show']);
Route::get('/vagasShowAll', [VagaController::class, 'showAll']);
Route::delete('/vagas/{id_vagas}', [VagaController::class, 'destroy']);
Route::put('/vagas/{id_vagas}', [VagaController::class, 'update']);
Route::patch('/vagas/reativar', [VagaController::class, 'updateReativar']);
Route::patch('/vagas/{id_vagas}', [VagaController::class, 'updateStatusFinalizar']);
Route::patch('/vagas/{id}/prorrogar', [VagaController::class, 'prorrogarVaga']);


//Route da habilidades + vagas (relação N pra N)
Route::post('/habOnVagas/{id_habilidades}/{id_vagas}', [VagaController::class, 'adicionarHabilidades']);

Route::get('/habOnVagas/{id_vagas}', [VagaController::class, 'verHabilidades']);

//Route da pessoa fisica + vagas (relação N pra N)
Route::get('/vagas/{id_vagas}/candidatos', [VagaController::class, 'verCandidatos']);
Route::patch('/vagas/{vaga}/candidatos/{pessoaFisica}', [VagaController::class, 'atualizarStatusCandidato']);

//Relação de habilidades com pessoas físicas N pra N
Route::post('/habOnCandidato', [PessoasFisicaController::class, 'adicionarHabilidades']);
Route::delete('/habOnCandidato', [PessoasFisicaController::class, 'removerHabilidades']);
Route::get('/habOnCandidato/{id_pessoas}', [PessoasFisicaController::class, 'verHabilidades']);

//Route de cidades
Route::post('/cadCidades', [CidadeController::class, 'store']);
Route::get('/cidades/{id_cidades}', [CidadeController::class, 'show']);
Route::get('/cidadesShowAll', [CidadeController::class, 'showAll']);
Route::delete('/cidades/{id_cidades}', [CidadeController::class, 'destroy']);
Route::put('/cidades/{id_cidades}', [CidadeController::class, 'update']);

Route::get('/enderecoShowAll', [EnderecoController::class, 'showAll']);

//Route de pessoas
Route::post('/cadPessoas', [PessoaController::class, 'store']);
Route::get('/pessoas/{id_pessoas}', [PessoaController::class, 'show']);
Route::delete('/pessoas/{id_pessoas}', [PessoaController::class, 'destroy']);
Route::put('/pessoas/{id_pessoas}', [PessoaController::class, 'update']);

//Route update sobre de pessoas
Route::patch('/pessoas/{id}/sobre', [PessoaController::class, 'updateSobre']);

Route::middleware('web')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    Route::post('/vagas/{id_vagas}/candidatar', [VagaController::class, 'candidatarPessoas'])
        ->middleware('auth:sanctum');

});


