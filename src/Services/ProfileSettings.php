<?php

namespace Luanrodrigues\LaravelEvolution\Services;

use Luanrodrigues\LaravelEvolution\EvolutionApi;

class ProfileSettings
{
    /**
     * @var EvolutionApi
     */
    protected EvolutionApi $api;

    /**
     * @var string Nome da Instância API Evolution
     */
    protected string $instance;

    /**
     * GroupService constructor.
     *
     * Inicializa o serviço com uma instância de EvolutionApi.
     *
     * @param EvolutionApi $api
     * @param string $instance
     */
    public function __construct(EvolutionApi $api, string $instance)
    {
        $this->api = $api;
        $this->instance = $instance;
    }

    /**
     * Busca as configurações atuais da instância na API Evolution.
     *
     * @return array A resposta da API
     */
    public function fetchProfile(): array
    {
        return $this->api->get("/chat/fetchProfile/{$this->instance}");
    }
}
