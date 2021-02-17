<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Traits\DudaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use rapidweb\googlecontacts\factories\ContactFactory;

class SiteController extends Controller
{
    use DudaApi;

    private $templateModel;

    public function __construct(Template  $templateModel){
        $this->templateModel = $templateModel;
    }

    public function create(){
        Auth::loginUsingId(1);
        $siteName = $this->createSite();
        echo "Site Criado: " . $siteName."<br />";

        //criando conta
        //$this->createCustomerAccount(); //chamar apenas uma vez para cada usuário, pode ser no primeiro login dele

        $this->grantAccountAccess($siteName);

        echo $this->getSSOLink(Auth::user()->email, $siteName, 'EDITOR')."<br />";


        //Listar Sites Criados
        //dd($this->getSitesByExternalId();

       // dd($this->getSites());

        //importar templates
        /*$templates = json_decode($this->getAllTemplates());
        $this->templateModel
            ->createOrUpdate($templates);*/


    }

    public function store()
    {

    }

    public function index()
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zapito.com.br/api/bots/4373/start',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            //CURLOPT_POSTFIELDS => array('remotejid' => $phoneNumber,'text' => $message),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response);

        $qrCode = $data->data->qr;

        return view('teste.qrcode', compact('qrCode'));
    }

    public function sendMessage()
    {
        $dados = json_encode(array (
            'phone' => '5562992393275',
            'message' => 'Olá mundo! Testando 123',
            'bot_id' => 4373,
            'meta' => 'categoria-bot|identificador-5156444',
            'file' =>
                array (
                    'url' => 'https://via.placeholder.com/400',
                    'name' => 'arquivo_exemplo.png',
                    'optional' => false,
                    'headers' =>
                        array (
                            'X-Custom-Header' => 'valor_custom_header',
                        ),
                )
        ));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://zapito.com.br/api/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '['.$dados.']',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response);

        dd($data);
    }
}
