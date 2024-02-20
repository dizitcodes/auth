<?php

namespace App\Filters;

use App\Models\AnalyticsModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Analytics implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Lista de User Agents de bots conhecidos
        $bots = ['Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider', 'YandexBot', 'Sogou'];

        // Obtém o User Agent do cliente
        $userAgent = $request->getUserAgent()->getAgentString();

        // Verifica se o User Agent pertence a um bot conhecido
        foreach ($bots as $bot) {
            if (strpos($userAgent, $bot) !== false) {
                // Se for um bot, não prossegue com o registro de analytics
                return;
            }
        }

        // Prossegue com outras ações caso não seja um bot
    }


    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        helper('cookie');
        // Obtém informações básicas
        $uri = $request->getUri();

        $data['uri'] = current_url();  // Obtém a URL atual
        $data['method'] = $request->getMethod();  // Obtém o método da requisição (GET, POST, etc.)
        $data['ip'] = $request->getIPAddress();  // Obtém o endereço IP do cliente
        $data['date'] = date('Y-m-d H:i:s');  // Obtém a data e hora atuais no formato MySQL


        // Verifica se já existe um cookie indicando que o usuário foi registrado recentemente
        $cookieName = 'a_' . md5($data['uri']);
        if (!$request->getCookie($cookieName) && $uri->getSegment(1) != 'admin') :

            // Obtém informações do navegador usando a classe UserAgent
            $userAgent = $request->getUserAgent();
            $data['navegador'] = $userAgent->getBrowser();  // Obtém o nome do navegador
            $data['versao_navegador'] = $userAgent->getVersion();  // Obtém a versão do navegador

            // Obtém informações do sistema operacional
            $data['sistema_operacional'] = $userAgent->getPlatform();

            // Obtém a referência (URL de referência)
            $data['referencia'] = $request->getServer('HTTP_REFERER');

            $analyticsModel = new AnalyticsModel();
            $analyticsModel->insert($data);

            // Define o cookie indicando que o usuário foi registrado recentemente
            $response->setCookie($cookieName, '1', 60 * 60 * 24); // Define o cookie por 24 horas (ou ajuste conforme necessário)
        endif;
    }
}
