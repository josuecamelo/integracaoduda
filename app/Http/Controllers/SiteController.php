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
                'Authorization: Bearer QulmsDDTe6FeB7oRt6kYgKCJRWpQJT09WiT68eF7nO2P4Hfr2xy2e4AkPeli'
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
        $data = request()->all();

        $dados = json_encode(array (
            'phone' => '',
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
                'Authorization: Bearer QulmsDDTe6FeB7oRt6kYgKCJRWpQJT09WiT68eF7nO2P4Hfr2xy2e4AkPeli',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response);

        dd($data);
    }

    public function lerArquivo(){
        $stream = fopen('http://www.umass.edu/microbio/rasmol/country-.txt', 'r');
        $lineCount = 0;
        $countries = [];
        while (!feof($stream)) {
            $linha =  fgets($stream);
            if($lineCount >= 3){
                $country = explode(' ', $linha);
                if(isset($country[3])){
                    $countryName = trim(preg_replace('/\s\s+/', ' ', $country[3]));
                    $countries[] = [
                        'codigo' => $country[0],
                        'pais' => $countryName
                    ];
                }
            }
            $lineCount++;
        }
        fclose($stream);




        usort($countries, function($a, $b) {
            return $a['pais'] <=> $b['pais'];
        });


        $output = fopen("php://output", "w");
        fputcsv($output, array('Nome do país', 'Código do país'));
        foreach($countries as $row){
            //fputcsv($output, $row);
            fputcsv($output,$row, ";");
        }
        fclose($output);

        /* Download as CSV File */

        header('Content-Type: text/csv');
        header('Content-Type: text/html; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . 'countries.csv' . '";');
    }
}
