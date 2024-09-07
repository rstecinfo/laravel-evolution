<?php

namespace Luanrodrigues\LaravelEvolution\Services;

use Luanrodrigues\LaravelEvolution\EvolutionApi;

class SettingsService
{
    /**
     * @var EvolutionApi
     */
    protected EvolutionApi $api;

    /**
     * SettingsService constructor.
     *
     * Inicializa o serviço com uma instância de EvolutionApi.
     */
    public function __construct(EvolutionApi $api)
    {
        $this->api = $api;
    }

    /**
     * Define as configurações padrão da instância na API Evolution.
     *
     * @param array $settings Dados das configurações a serem aplicadas
     * @param string $instance ID da instância
     *
     * @return array A resposta da API
     */
    public function setSettings(array $settings, string $instance): array
    {
        return $this->api->post("/settings/set/{$instance}", $settings);
    }

    /**
     * Busca as configurações atuais da instância na API Evolution.
     *
     * @param string $instance ID da instância
     *
     * @return array A resposta da API
     */
    public function findSettings(string $instance): array
    {
        return $this->api->get("/settings/find/{$instance}");
    }
}
