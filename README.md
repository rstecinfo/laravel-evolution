laravel evolution-api

https://doc.evolution-api.com/v2/api-reference/

```
class WhatsappHelper {
    
    public $api;
    public $instance;

    public static function instance() {
        return new AppHelper();
    }
    
    public function __construct() {
        $this->instance = 'teste';
        $key = config('evolution.api_key');
        $url = config('evolution.api_url');
        $this->api = new EvolutionApi($url,$key);
    }
    
    /**
     * Inicia whatsapp
     * @reconnect bool true para reconectar instancia
     * @return bool true
     */
    public function startInstance($reconnect=false) 
    {
        //verifica status da instancia
        $evolutionInstanceService = new EvolutionInstanceService($this->api);
        $connectionState = $evolutionInstanceService->getConnectionStatus($this->instance);
     }
}
```
