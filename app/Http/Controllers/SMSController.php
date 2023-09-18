<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Request;

use Telnyx\Message;
use Telnyx\Webhook;
use Aws\S3\S3Client;
use Inertia\Inertia;
use Slim\Factory\AppFactory;
use Aws\S3\Exception\S3Exception;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class SMSController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

    public function webhooks(Request $request)
    {

        $TELNYX_API_KEY       = "KEY01857DD896838C8A75B0A887F46B90BE_nZVtg3gyIAsear9RVW9q98";
        $TELNYX_PUBLIC_KEY    = "UG32bb3SIkUOcqdZcQ6w7Tlr34Wn9LQ/Hpp1f3p0z54=";
        // $AWS_REGION           = $_ENV['AWS_REGION'];
        // $TELNYX_MMS_S3_BUCKET = $_ENV['TELNYX_MMS_S3_BUCKET'];
        // $AWS_PROFILE          = $_ENV['AWS_PROFILE'];

        \Telnyx\Telnyx::setApiKey($TELNYX_API_KEY);
        \Telnyx\Telnyx::setPublicKey($TELNYX_PUBLIC_KEY);


        // Instantiate App
        $app = AppFactory::create();

        // Add error middleware
        $app->addErrorMiddleware(true, true, true);

        //Callback signature verification
        $telnyxWebhookVerify = function (Request $request, RequestHandler $handler) {
            $payload = $request->getBody()->getContents();
            $sigHeader = $request->getHeader('HTTP_TELNYX_SIGNATURE_ED25519')[0];
            $timeStampHeader = $request->getHeader('HTTP_TELNYX_TIMESTAMP')[0];
            $telnyxEvent = Webhook::constructEvent($payload, $sigHeader, $timeStampHeader);
            $request = $request->withAttribute('telnyxEvent', $telnyxEvent);
            $response = $handler->handle($request);
            return $response;
        };

        $app->post('/messaging/inbound', function (Request $request, Response $response) {
            $body = $request->getParsedBody();
            $payload = $body['data']['payload'];
            $toNumber = $payload['to'][0]['phone_number'];
            $fromNumber = $payload['from']['phone_number'];
            $medias = $payload['media'];
            $dlrUrl = http_build_url([
                'scheme' => $request->getUri()->getScheme(),
                'host' => $request->getUri()->getHost(),
                'path' => '/messaging/outbound'
            ]);
            $mediaUrls = array_map('downloadUpload', $medias);
            try {
                $new_message = Message::Create([
                    'from' => $toNumber,
                    'to' => $fromNumber,
                    'text' => 'Hello, world!',
                    'media_urls' => $mediaUrls,
                    'use_profile_webhooks' => false,
                    'webhook_url' => $dlrUrl
                    ]);
                $messageId = $new_message->id;
                echo 'Sent message with ID: ', $messageId;
            }
            catch (\Exception $e) {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            return $response->withStatus(200);
        })->add($telnyxWebhookVerify);

        $app->post('/messaging/outbound', function (Request $request, Response $response) {
            // Handle outbound DLR
            return $response->withStatus(200);
        })->add($telnyxWebhookVerify);
        $app->run();

      
    }


    public function index2(Request $request)
    {
        \Telnyx\Telnyx::setApiKey('KEY01857DD896838C8A75B0A887F46B90BE_nZVtg3gyIAsear9RVW9q98');




        //SMS receiving process

        $json = json_decode(file_get_contents("php://input"), true);
        // $json = json_decode($request->getContent(), true);

        if ($json) {
            print_r($json);
        } else {
            echo "No";
        }

        exit();





        //SMS sending process
        // $your_telnyx_number = '+15802001875';
        // $destination_number = '+14142796339';
        // $new_message = \Telnyx\Message::Create(['from' => $your_telnyx_number, 'to' => $destination_number, 'text' => 'Hello, world! Testting SMS']);
        // return response()->json([
        //     "data" => $new_message
        // ]);



        //   //Reterieving SMS
        //   $get_message = \Telnyx\Message::Retrieve("403188bd-e6bf-4cd5-a3f7-175ed07be510");
        //   return response()->json([
        //       "data" => $get_message
        //   ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
