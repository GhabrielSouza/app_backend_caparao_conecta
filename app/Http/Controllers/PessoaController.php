<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\PessoasFisica;
use App\Models\Rede_Social;
use App\Models\Usuario;
use App\Models\Cidade;
use App\Models\Vaga;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Pessoa;
use Mockery\Undefined;

class PessoaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->id_tipo_usuarios == 3) {
            $rules = [

                'nome' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'sobre' => 'string',
                'imagem' => 'string|max:255',

                'cnpj' => 'required|string|max:20|unique:App\Models\Empresa,cnpj',

                'email' => 'required|string|max:255|email:rfc,dns,spoof',
                'password' => 'required|string|max:512',

                'estado' => 'required|string|max:255',
                'cidade' => 'required|string|max:50',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()
                ], 422);

            }

        }

        if ($request->id_tipo_usuarios == 2) {

            $rules = [

                'nome' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'sobre' => 'string',
                'imagem' => 'string|max:255',
                'id_areas_atuacao' => 'integer',
                'cpf' => 'required|string|max:20|unique:App\Models\PessoasFisica,cpf',
                'data_de_nascimento' => 'required|date',
                'sobrenome' => 'required|string|max:255',
                'cad_unico' => 'string|max:12|unique:App\Models\PessoasFisica,cad_unico',
                'genero' => 'required|string|max:45',

                'email' => 'required|string|max:255|email:rfc,dns,spoof',
                'password' => 'required|string|max:512',

                'estado' => 'required|string|max:255',

                'cidade' => 'required|string|max:50',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()
                ], 422);

            }

        }

        $cidade = Cidade::where('nome_cidade', $request->cidade)->first();

        if (!$cidade) {

            // Cria a cidade se ela ainda não existir
            $cidade = Cidade::create([
                'nome_cidade' => $request->cidade,
                'id_pais' => 1,
            ]);

        }

        // Cria a pessoa
        $pessoa = Pessoa::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'sobre' => $request->sobre,
            'imagem' => $request->imagem,
        ]);

        $request->merge(['id_pessoas' => $pessoa->id_pessoas]);

        // Cria o usuário
        $usuario = Usuario::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_pessoas' => $pessoa->id_pessoas,
            'id_tipo_usuarios' => $request->id_tipo_usuarios
        ]);

        $rede_social = Rede_Social::create([
            'instagram' => $request->instagram,
            'github' => $request->github,
            'linkedin' => $request->linkedin,
            'curriculo_lattes' => $request->lattes,
            'id_pessoas' => $pessoa->id_pessoas
        ]);

        // Cria o endereço com o ID da cidade
        $endereco = Endereco::create([
            'estado' => $request->estado,
            'id_cidades' => $cidade->id_cidades,
            'id_pessoas' => $pessoa->id_pessoas
        ]);

        if ($request->id_tipo_usuarios == 3) {
            $empresa = Empresa::create([
                'id_pessoas' => $pessoa->id_pessoas,
                'cnpj' => $request->cnpj,
            ]);

            return response()->json([
                'mensagem' => 'Pessoa, empresa, cidade, endereço e usuário cadastrados com sucesso',
                'data - pessoa' => $pessoa,
                'data - redes sociais' => $rede_social,
                'data - cidade' => $cidade,
                'data - endereço' => $endereco,
                'data - empresa' => $empresa,
                'data - usuário' => $usuario
            ], 200);
        }

        if ($request->id_tipo_usuarios == 2) {
            $pessoaFisica = PessoasFisica::create([
                'id_pessoas' => $pessoa->id_pessoas,
                'cpf' => $request->cpf,
                'data_de_nascimento' => Carbon::createFromFormat('d/m/Y', $request->data_de_nascimento)->format('Y-m-d'),
                'sobrenome' => $request->sobrenome,
                'id_areas_atuacao' => $request->id_areas_atuacao,
                'cad_unico' => $request->cad_unico,
                'genero' => $request->genero,
            ]);

            return response()->json([
                'mensagem' => 'Pessoa, pessoa física, cidade, endereço e usuário cadastrados com sucesso',
                'data - pessoa' => $pessoa,
                'data - redes sociais' => $rede_social,
                'data - cidade' => $cidade,
                'data - endereço' => $endereco,
                'data - pessoa física' => $pessoaFisica,
                'data - usuário' => $usuario
            ], 200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_pessoas)
    {
        $usuario = Usuario::find($id_pessoas);

        if ($usuario->id_tipo_usuarios == 3) {

            $pessoa = Pessoa::with(['usuario', 'endereco.cidade', 'empresa', 'redeSocial'])->find($id_pessoas);

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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_pessoas)
    {

        if ($request->id_tipo_usuarios == 3) {

            $rules = [

                'nome' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'sobre' => 'string',
                'imagem' => 'string|max:255',



                'email' => 'required|string|max:255|email:rfc,dns,spoof',

                'estado' => 'required|string|max:255',

                'cidade' => 'required|string|max:50',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()
                ], 422);

            }

        }

        if ($request->id_tipo_usuarios == 2) {

            $rules = [

                'nome' => 'required|string|max:255',
                'telefone' => 'required|string|max:20',
                'sobre' => 'string',
                'imagem' => 'string|max:255',
                'id_areas_atuacao' => 'integer',

                'data_de_nascimento' => 'required|date',
                'sobrenome' => 'required|string|max:255',
                'cad_unico' => 'string|max:12|unique:App\Models\PessoasFisica,cad_unico',
                'genero' => 'required|string|max:45',

                'email' => 'required|string|max:255|email:rfc,dns,spoof',

                'estado' => 'required|string|max:255',

                'cidade' => 'required|string|max:50',

            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                return response()->json([
                    'error' => $validator->errors()
                ], 422);

            }

        }

        // Atualiza ou cria a cidade
        $cidade = Cidade::where('nome_cidade', $request->cidade)->first();

        if (!$cidade) {
            $cidade = Cidade::create([
                'nome_cidade' => $request->cidade,
                'id_pais' => 1,
            ]);
        }

        // Atualiza a pessoa
        $pessoa = Pessoa::find($id_pessoas);
        if (!$pessoa) {
            return response()->json(['mensagem' => 'Pessoa não encontrada'], 404);
        }
        $pessoa->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,

        ]);

        $rede_social = Rede_Social::find($id_pessoas);
        if (!$rede_social) {
            return response()->json(['mensagem' => 'Rede social não encontrada'], 404);
        }
        $rede_social->update([
            'instagram' => $request->instagram,
            'github' => $request->github,
            'linkedin' => $request->linkedin,
            'curriculo_lattes' => $request->lattes,
        ]);

        // Atualiza o usuário
        $usuario = Usuario::find($id_pessoas);
        if (!$usuario) {
            return response()->json(['mensagem' => 'Usuário não encontrado'], 404);
        }
        $usuario->update([
            'email' => $request->email,
        ]);

        // Atualiza o endereço
        $endereco = Endereco::where('id_pessoas', $id_pessoas)->first();
        if (!$endereco) {
            return response()->json(['mensagem' => 'Endereço não encontrado'], 404);
        }
        $endereco->update([
            'estado' => $request->estado,
            'id_cidades' => $cidade->id_cidades
        ]);

        if ($request->id_tipo_usuarios == 3) {
            $empresa = Empresa::find($id_pessoas);
            if (!$empresa) {
                return response()->json(['mensagem' => 'Empresa não encontrada'], 404);
            }


            return response()->json([
                'mensagem' => 'Dados atualizados com sucesso',
                'pessoa' => $pessoa,
                'rede social' => $rede_social,
                'cidade' => $cidade,
                'endereço' => $endereco,
                'empresa' => $empresa,
                'usuário' => $usuario
            ], 200);
        }

        if ($request->id_tipo_usuarios == 2) {
            $pessoaFisica = PessoasFisica::find($id_pessoas);
            if (!$pessoaFisica) {
                return response()->json(['mensagem' => 'Pessoa física não encontrada'], 404);
            }
            $pessoaFisica->update([
                'data_de_nascimento' => Carbon::createFromFormat('d/m/Y', $request->data_de_nascimento)->format('Y-m-d'),
                'sobrenome' => $request->sobrenome,
                'cad_unico' => $request->cad_unico,
                'id_areas_atuacao' => $request->id_areas_atuacao,
                'genero' => $request->genero,
            ]);

            return response()->json([
                'mensagem' => 'Dados atualizados com sucesso',
                'pessoa' => $pessoa,
                'rede social' => $rede_social,
                'cidade' => $cidade,
                'endereço' => $endereco,
                'pessoa_fisica' => $pessoaFisica,
                'usuário' => $usuario
            ], 200);
        }

        return response()->json(['mensagem' => 'Tipo de usuário inválido'], 400);
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
