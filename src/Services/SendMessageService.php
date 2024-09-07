<?php

namespace Luanrodrigues\LaravelEvolution\Services;

use Luanrodrigues\LaravelEvolution\EvolutionApi;

class SendMessageService
{
    /**
     * @var EvolutionApi
     */
    protected EvolutionApi $api;

    /**
     * SendMessageService constructor.
     *
     * Inicializa o serviço com uma instância de EvolutionApi.
     */
    public function __construct(EvolutionApi $api)
    {
        $this->api = $api;
    }

    /**
     * Envia uma mensagem de texto.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $message Mensagem de texto
     * @param array $options (Opcional) Opções adicionais como delay ou quoted
     *
     * @return array Resposta da API
     */
    public function sendText(string $instance, string $number, string $message, array $options = []): array
    {
        $data = array_merge(['number' => $number, 'text' => $message], $options);
        return $this->api->post("/message/sendText/$instance", $data);
    }

    /**
     * Envia mídia (imagem, vídeo, ou documento).
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $mediaUrl URL ou base64 do arquivo de mídia
     * @param string $mediaType Tipo de mídia (image, video, document)
     * @param string $mimeType MimeType do arquivo (ex: image/png)
     * @param string $caption (Opcional) Legenda para o arquivo
     * @param array $options (Opcional) Opções adicionais
     *
     * @return array Resposta da API
     */
    public function sendMedia(string $instance, string $number, string $mediaUrl, string $mediaType, string $mimeType, string $caption = '', array $options = []): array
    {
        $data = array_merge([
            'number' => $number,
            'media' => $mediaUrl,
            'mediatype' => $mediaType,
            'mimetype' => $mimeType,
            'caption' => $caption
        ], $options);

        return $this->api->post("/message/sendMedia/$instance", $data);
    }

    /**
     * Envia um áudio narrado.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $audioUrl URL ou base64 do áudio
     * @param array $options (Opcional) Opções adicionais
     *
     * @return array Resposta da API
     */
    public function sendAudio(string $instance, string $number, string $audioUrl, array $options = []): array
    {
        $data = array_merge(['number' => $number, 'audio' => $audioUrl], $options);
        return $this->api->post("/message/sendWhatsAppAudio/$instance", $data);
    }

    /**
     * Envia um sticker.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $stickerUrl URL ou base64 do sticker
     * @param array $options (Opcional) Opções adicionais
     *
     * @return array Resposta da API
     */
    public function sendSticker(string $instance, string $number, string $stickerUrl, array $options = []): array
    {
        $data = array_merge(['number' => $number, 'sticker' => $stickerUrl], $options);
        return $this->api->post("/message/sendSticker/$instance", $data);
    }

    /**
     * Envia uma localização.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $name Nome da localização
     * @param string $address Endereço da localização
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param array $options (Opcional) Opções adicionais
     *
     * @return array Resposta da API
     */
    public function sendLocation(string $instance, string $number, string $name, string $address, float $latitude, float $longitude, array $options = []): array
    {
        $data = array_merge([
            'number' => $number,
            'name' => $name,
            'address' => $address,
            'latitude' => $latitude,
            'longitude' => $longitude
        ], $options);

        return $this->api->post("/message/sendLocation/$instance", $data);
    }

    /**
     * Envia um contato.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param array $contacts Lista de contatos com nome, telefone, e outras informações
     * @param array $options (Opcional) Opções adicionais
     *
     * @return array Resposta da API
     */
    public function sendContact(string $instance, string $number, array $contacts, array $options = []): array
    {
        $data = array_merge(['number' => $number, 'contact' => $contacts], $options);
        return $this->api->post("/message/sendContact/$instance", $data);
    }

    /**
     * Envia uma enquete para o número de destino.
     *
     * Estrutura do campo 'body':
     * - "number": O número de destino da enquete.
     * - "name": Texto principal da enquete.
     * - "selectableCount": Número de opções que podem ser selecionadas.
     * - "values": Lista de perguntas ou opções da enquete.
     * - Opções adicionais:
     *   - "delay": (Opcional) Tempo de atraso antes de enviar a mensagem.
     *   - "quoted": (Opcional) Mensagem ou ID de mensagem a ser citada.
     *   - "mentionsEveryOne": (Opcional) Se todos devem ser mencionados.
     *   - "mentioned": (Opcional) Lista de números mencionados.
     *
     * @param string $instance ID da instância
     * @param string $number Número de destino
     * @param string $name Texto principal da enquete
     * @param int $selectableCount Número de opções selecionáveis
     * @param array $values Lista de perguntas ou opções
     * @param array $options (Opcional) Opções adicionais como delay, quoted, etc.
     * @return array Resposta da API
     */
    public function sendPoll(string $instance, string $number, string $name, int $selectableCount, array $values, array $options = []): array
    {
        $data = array_merge([
            'number' => $number,
            'name' => $name,
            'selectableCount' => $selectableCount,
            'values' => $values
        ], $options);

        return $this->api->post("/message/sendPoll/$instance", $data);
    }

}
