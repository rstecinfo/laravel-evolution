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
     * Define a instância da API Evolution.
     *
     * @param string $instance ID da instância
     * @return $this
     * @throws \InvalidArgumentException Se o ID da instância for inválido
     */
    public function setInstance(string $instance)
    {
        // Verificação básica se a instância não é uma string vazia
        if (empty($instance)) {
            throw new \InvalidArgumentException("A instância não pode ser vazio.");
        }

        $this->instance = $instance;
        return $this;
    }

    /**
     * Define as configurações padrão da instância na API Evolution.
     *
     * @param array $settings Dados das configurações a serem aplicadas*
     * @return array A resposta da API
     */
    public function setSettings(array $settings): array
    {
        return $this->api->post("/settings/set/{$this->instance}", $settings);
    }

    /**
     * Busca as configurações atuais da instância na API Evolution.
     *
     * @return array A resposta da API
     */
    public function findSettings(): array
    {
        return $this->api->get("/settings/find/{$this->instance}");
    }
}
