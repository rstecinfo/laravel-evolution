<?php

namespace RSTecInfo\LaravelEvolution;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class EvolutionApi
 *
 * Essa classe é responsável por interagir com a API Evolution, utilizando o cliente Guzzle para
 * fazer requisições HTTP. Suporta operações GET, POST e DELETE, com a opção de passar parâmetros
 * e dados como JSON.
 */
class EvolutionApi
{
    /**
     * @var string $baseUrl URL base da API Evolution
     */
    protected string $baseUrl;

    /**
     * @var string $apiKey Chave de API para autenticação
     */
    protected string $apiKey;

    /**
     * @var Client $client Cliente Guzzle HTTP usado para fazer as requisições
     */
    protected Client $client;

    /**
     * EvolutionApi constructor.
     *
     * Inicializa a classe EvolutionApi com a URL base e a chave de API.
     * Também instancia o cliente Guzzle e armazena como uma propriedade da classe.
     *
     * @param string $baseUrl URL base da API Evolution
     * @param string $apiKey Chave de API fornecida pela Evolution
     */
    public function __construct(string $baseUrl = null, string $apiKey = null)
    {
        // Se não forem passados valores, utiliza as configurações
        $this->baseUrl = $baseUrl ?? config('evolution.api_url');
        $this->apiKey = $apiKey ?? config('evolution.api_key');
        
        // Instancia o cliente Guzzle com a URL base e os headers padrões (API Key)
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'apikey' => $this->apiKey,  // Adiciona o cabeçalho da chave de API para todas as requisições
            ]
        ]);
    }

    // Novo método para definir o cliente Guzzle (apenas para fins de teste)
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    /**
     * Faz uma requisição GET para a API Evolution.
     *
     * @param string $endpoint O endpoint relativo da API (ex: '/instance/fetchInstances')
     * @param array $params Parâmetros de consulta (query) a serem enviados na URL
     *
     * @return array A resposta da API decodificada para um array PHP
     * @throws GuzzleException
     */
    public function get(string $endpoint, array $params = []): array
    {
        try {
            // Faz uma requisição GET passando os parâmetros na URL (query string)
            $response = $this->client->request('GET', $endpoint, [
                'query' => $params,
            ]);

            // Retorna o corpo da resposta decodificado como array
            $ret = json_decode($response->getBody()->getContents(), true);
            return $ret ?? [];
        } catch (GuzzleException $e) {
            // Lidar com exceções de forma apropriada
            //throw new \Exception("Erro ao fazer requisição GET: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Faz uma requisição POST para a API Evolution.
     *
     * @param string $endpoint O endpoint relativo da API (ex: '/instance/create')
     * @param array $data Dados a serem enviados como JSON no corpo da requisição
     *
     * @return array A resposta da API decodificada para um array PHP
     * @throws GuzzleException
     */
    public function post(string $endpoint, array $data = []): array
    {
        try {
            // Faz uma requisição POST enviando os dados como JSON no corpo
            $response = $this->client->request('POST', $endpoint, [
                'json' => $data,  // Envia os dados como JSON
            ]);

            // Retorna o corpo da resposta decodificado como array
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            // Lidar com exceções de forma apropriada
            //throw new \Exception("Erro ao fazer requisição POST: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Faz uma requisição DELETE para a API Evolution.
     *
     * @param string $endpoint O endpoint relativo da API (ex: '/instance/delete')
     * @param array $data (Opcional) Dados a serem enviados como JSON no corpo da requisição DELETE
     *
     * @return array A resposta da API decodificada para um array PHP
     * @throws GuzzleException
     */
    public function delete(string $endpoint, array $data = []): array
    {
        try {
            // Faz uma requisição DELETE enviando os dados como JSON no corpo, se necessário
            $response = $this->client->request('DELETE', $endpoint, [
                'json' => $data,  // Envia os dados como JSON, caso seja necessário
            ]);

            // Retorna o corpo da resposta decodificado como array
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            // Lidar com exceções de forma apropriada
            //throw new \Exception("Erro ao fazer requisição DELETE: " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
    
    /**
     * Faz uma requisição GET para a API Evolution.
     *
     * @param string $endpoint O endpoint relativo da API (ex: '/instance/fetchInstances')
     * @param array $params Parâmetros de consulta (query) a serem enviados na URL
     *
     * @return array A resposta da API decodificada para um array PHP
     * @throws GuzzleException
     */
    public function status(string $endpoint): array
    {
        try {
            // Faz uma requisição GET 
            $response = $this->client->request('GET', $endpoint);

            // Retorna o corpo da resposta decodificado como array
            $ret = json_decode($response->getBody()->getContents(), true);
            if ($ret == null) {
                return [null];
            }
            return is_array($ret) ? $ret : [$ret];
            
        } catch (GuzzleException $e) {
            $response = $e?->getResponse();
            return json_decode($response?->getBody()?->getContents(),true);
        }
    }
    
}
