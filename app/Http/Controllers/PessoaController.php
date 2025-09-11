<?php

namespace App\Http\Controllers;

use App\Events\PerfilVisualizadoPorEmpresa;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\PessoasFisica;
use App\Models\Rede_Social;
use App\Models\Usuario;
use App\Models\Cidade;
use App\Models\Vaga;
use DB;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Pessoa;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pessoas = Pessoa::with(['endereco.cidade', 'empresa', 'usuario:id_pessoas,id_tipo_usuarios'])->get();

        if ($pessoas->isEmpty()) {
            return response()->json(['message' => 'Nenhuma pessoa encontrada'], 404);
        }

        return response()->json($pessoas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $commonRules = [
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'sobre' => 'nullable|string',
            'email' => 'required|string|max:255|email:rfc,dns,spoof|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'estado' => 'required|string|max:255',
            'cidade' => 'required|string|max:50',
        ];

        $specificRules = [];
        if ($request->input('id_tipo_usuarios') == 2) {
            $specificRules = [
                'cpf' => 'required|string|max:20|unique:pessoas_fisicas,cpf',
                'data_de_nascimento' => 'required',
                'sobrenome' => 'required|string|max:255',
                'genero' => 'required|string|max:45',
                'id_areas_atuacao' => 'nullable|integer|exists:areas_atuacao,id_areas_atuacao',
            ];
        } else if ($request->input('id_tipo_usuarios') == 3) {
            $specificRules = [
                'cnpj' => 'required|string|max:20|unique:empresas,cnpj',
            ];
        }

        $validator = Validator::make($request->all(), array_merge($commonRules, $specificRules));

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $pessoa = DB::transaction(function () use ($request) {

                $pessoa = Pessoa::create($request->only(['nome', 'telefone', 'sobre']));

                $pessoa->usuario()->create([
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'id_tipo_usuarios' => $request->input('id_tipo_usuarios'),
                ]);

                $cidade = Cidade::firstOrCreate(
                    ['nome_cidade' => $request->input('cidade')],
                    ['id_pais' => 1]
                );

                $pessoa->endereco()->create([
                    'estado' => $request->input('estado'),
                    'id_cidades' => $cidade->id_cidades,
                ]);

                $pessoa->redeSocial()->create($request->only(['instagram', 'github', 'linkedin', 'lattes']));

                if ($request->input('id_tipo_usuarios') == 2) { // Candidato
                    $pessoa->pessoasFisica()->create([
                        'cpf' => $request->input('cpf'),
                        'data_de_nascimento' => $request->input('data_de_nascimento'),
                        'sobrenome' => $request->input('sobrenome'),
                        'id_areas_atuacao' => $request->input('id_areas_atuacao'),
                        'cad_unico' => $request->input('cad_unico'),
                        'genero' => $request->input('genero'),
                    ]);
                } else if ($request->input('id_tipo_usuarios') == 3) { // Empresa
                    $pessoa->empresa()->create($request->only(['cnpj']));
                }

                return $pessoa;
            });

            $pessoa->load(['usuario', 'endereco.cidade', 'redeSocial', 'pessoasFisica', 'empresa']);

            return response()->json([
                'message' => 'Usuário cadastrado com sucesso!',
                'data' => $pessoa
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro durante o cadastro.', 'error' => $e->getMessage()], 500);
        }
    }

    //upload de imagem
    public function uploadImagem(Request $request, string $id_pessoas)
    {
        $validator = Validator::make($request->all(), [
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pessoa = Pessoa::findOrFail($id_pessoas);

        if ($request->hasFile('imagem')) {
            $requestImage = $request->file('imagem');

            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime('now')) . '.' . $extension;

            $requestImage->move(public_path('img/pessoas'), $imageName);

            $pessoa->imagem = $imageName;
            $pessoa->save();
        }

        return response()->json([
            'message' => 'Imagem atualizada com sucesso',
            'pessoa' => $pessoa
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        $usuario = Usuario::find($id_pessoas);

        if ($usuario->id_tipo_usuarios == 3) {

            $pessoa = Pessoa::with([
                'usuario.tipoUsuario',
                'endereco.cidade',
                'pessoasFisica.areaAtuacao',
                'redeSocial',
                'empresa'
            ])->find($id_pessoas);

            return response()->json(
                $pessoa,
                200
            );

        }

        if ($usuario->id_tipo_usuarios == 2) {

            $pessoa = Pessoa::with(['usuario', 'endereco.cidade', 'pessoasFisica', 'redeSocial', 'pessoasFisica.areaAtuacao:id_areas_atuacao,nome_area'])->find($id_pessoas);

            return response()->json(
                $pessoa,
                200
            );

        }

        if ($usuario->id_tipo_usuarios == 1) {

            $pessoa = Pessoa::with(['endereco.cidade', 'redeSocial',])->find($id_pessoas);

            return response()->json(
                $pessoa,
                200
            );

        }

    }

    public function visualizarPerfil(Request $request, string $id)
    {

        $usuario = $request->user();

        $pessoa = Pessoa::with([
            'usuario.tipoUsuario',
            'endereco.cidade',
            'pessoasFisica.areaAtuacao',
            'redeSocial',
            'empresa',
            'pessoasFisica.formacaoAcademica.instituicao',
            'pessoasFisica.experiencia',
            'pessoasFisica.habilidades',
            'pessoasFisica.cursos'
        ])->find($id);

        if ($usuario && $usuario->tipoUsuario->nome === "EMPRESA" && $pessoa->pessoasFisica && $usuario->id_pessoas !== $pessoa->id_pessoas) {
            PerfilVisualizadoPorEmpresa::dispatch($pessoa->pessoasFisica, $usuario->pessoa->empresa);
        }

        if ($usuario && $usuario->tipoUsuario->nome === "EMPRESA") {
            $empresa = $usuario->pessoa->empresa;

            if ($empresa->vaga()->exists()) {
                $pessoa->telefone = 'Acesso Restrito';
                $pessoa->usuario->email = 'Acesso Restrito';
                $pessoa->unsetRelation('redeSocial');
            }
        }

        if (!$pessoa) {
            return response()->json(['message' => 'Pessoa não encontrada'], 404);
        }

        return response()->json($pessoa, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {
        $commonRules = [
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:20',
            'email' => 'required|string|max:255|email:rfc,dns,spoof',
            'estado' => 'required|string|max:255',
            'cidade' => 'required|string|max:50',
        ];

        $specificRules = [];
        if ($request->input('id_tipo_usuarios') == 2) {
            $specificRules = [
                'data_de_nascimento' => 'required|date_format:Y-m-d',
                'sobrenome' => 'required|string|max:255',
                'genero' => 'required|string|max:45',
                'id_areas_atuacao' => 'nullable|integer|exists:areas_atuacao,id_areas_atuacao',
            ];
        }

        $validator = Validator::make($request->all(), array_merge($commonRules, $specificRules));

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            DB::transaction(function () use ($request, $id_pessoas) {
                $pessoa = Pessoa::findOrFail($id_pessoas);

                $pessoa->update($request->only(['nome', 'telefone']));

                $pessoa->usuario()->update($request->only(['email']));

                $cidade = Cidade::firstOrCreate(
                    ['nome_cidade' => $request->input('cidade')],
                    ['id_pais' => 1]
                );

                $pessoa->endereco()->update([
                    'estado' => $request->input('estado'),
                    'id_cidades' => $cidade->id_cidades,
                ]);

                $pessoa->redeSocial()->update([
                    'instagram' => $request->input('instagram'),
                    'github' => $request->input('github'),
                    'linkedin' => $request->input('linkedin'),
                    'curriculo_lattes' => $request->input('lattes'),
                ]);

                if ($request->input('id_tipo_usuarios') == 2) {
                    $pessoa->pessoasFisica()->update([
                        'data_de_nascimento' => $request->input('data_de_nascimento'),
                        'sobrenome' => $request->input('sobrenome'),
                        'genero' => $request->input('genero'),
                        'id_areas_atuacao' => $request->input('id_areas_atuacao'),
                    ]);
                }
            });

            $pessoaAtualizada = Pessoa::with([
                'usuario',
                'endereco.cidade',
                'redeSocial',
                'pessoasFisica.areaAtuacao'
            ])->find($id_pessoas);

            return response()->json([
                'message' => 'Dados atualizados com sucesso',
                'data' => $pessoaAtualizada
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro ao atualizar os dados.', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateSobre(Request $request, string $id_pessoas)
    {
        $pessoa = Pessoa::findOrFail($id_pessoas);
        $pessoa->update(['sobre' => $request->sobre]);

        return response()->json([
            $pessoa->sobre
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_pessoas)
    {
        // Verifica se o usuário existe
        $usuario = Usuario::find($id_pessoas);
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado.'], 404);
        }

        // Deleta Pessoa e Endereço
        Pessoa::find($id_pessoas)?->delete();
        Endereco::find($id_pessoas)?->delete();
        Rede_Social::find($id_pessoas)?->delete();

        // Se for empresa
        if ($usuario->id_tipo_usuarios == 3) {
            $empresa = Empresa::find($id_pessoas);

            if ($empresa) {
                $vagas = Vaga::where('id_empresas', $id_pessoas)->get();

                foreach ($vagas as $vaga) {
                    // Se vagaOnHabilidade for belongsToMany
                    $vaga->vagaOnHabilidade()->detach();

                    // candidato é belongsToMany
                    $vaga->candidato()->detach();

                    // Deleta a vaga após remover vínculos
                    $vaga->delete();
                }

                // Deleta a empresa após todas as vagas e relacionamentos serem limpos
                $empresa->delete();
            }


            $usuario->delete();

            return response()->json([
                'mensagem' => 'Tudo relacionado à empresa foi desativado com sucesso.',
            ], 200);
        }

        // Se for pessoa física
        if ($usuario->id_tipo_usuarios == 2) {
            $pessoaFisica = PessoasFisica::where('id_pessoas', $id_pessoas)->first();

            if ($pessoaFisica) {
                $pessoaFisica->candidato()->detach();
                $pessoaFisica->habilidades()->detach();
                $pessoaFisica->delete();
            }

            $usuario->delete();

            return response()->json([
                'mensagem' => 'Tudo relacionado à pessoa física foi desativado com sucesso.',
            ], 200);
        }

        // Tipo de usuário não previsto
        return response()->json([
            'mensagem' => 'Tipo de usuário não reconhecido.',
        ], 400);
    }

}
