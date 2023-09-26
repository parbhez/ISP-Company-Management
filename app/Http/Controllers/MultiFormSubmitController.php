<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MultiFormSubmitController extends Controller
{



   
    /**
     * Show the form for creating a new resource.
     */

    public function showMultiStepForm()
    {
        return Inertia::render('MultiForm/MultiStepForm', []);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function submitMultiStepForm(Request $request)
    {
        try {
            // You can add validation logic here if needed
            // Example: $this->validate($request, ['field' => 'required']);
            $formData = $request->all();
            // Process the form data or store it in the database, if needed
            return response()->json(['message' => 'Form data submitted successfully', 'data' => $formData], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchNumber(Request $request)
    {
        try {
            $client = new Client();

            $areaCode = $request->input('area_code');
            if ($areaCode != "") {
                $response = $client->request('GET', 'https://api.telnyx.com/v2/available_phone_numbers', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer KEY01857DD896838C8A75B0A887F46B90BE_nZVtg3gyIAsear9RVW9q98',
                    ],
                    'query' => [
                        'filter[national_destination_code][]' => $areaCode,
                    ],
                ]);

                $responseData = json_decode($response->getBody(), true);
                $phoneNumbersArray = [];
                // Extract phone numbers from the response data
                foreach ($responseData['data'] as $item) {
                    if (isset($item['phone_number'])) {
                        $phoneNumbersArray[] = $item['phone_number'];
                    }
                }

                return response()->json(['status' => true, 'message' => 'Numbers fetched successfully', 'data' => $phoneNumbersArray, 'code' => 200]);
            } else {
                return response()->json(['status' => false, 'message' => 'Number not found', 'error' => "Please write down area code", 'code' => 404]);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => 'Something went wrong', 'error' => $e->getMessage(), 'code' => 500]);
        }
    }


    public function encryptDES($plaintext, $key)
    {
        // Pad the plaintext to be a multiple of 8 bytes (DES block size)
        $blockSize = 8;
        $padLength = $blockSize - (strlen($plaintext) % $blockSize);
        $plaintext = $plaintext . str_repeat(chr($padLength), $padLength);

        // Perform DES encryption on plaintext
        $ciphertext = openssl_encrypt($plaintext, 'DES-ECB', $key, OPENSSL_RAW_DATA);

        // Return ciphertext as hex string
        return bin2hex($ciphertext);
    }

    public function decryptDES($ciphertext, $key)
    {
        // Parse ciphertext from hex string
        $ciphertextHex = hex2bin($ciphertext);

        // Perform DES decryption on ciphertext
        $decrypted = openssl_decrypt($ciphertextHex, 'DES-ECB', $key, OPENSSL_RAW_DATA);

        // Remove padding
        $padLength = ord($decrypted[strlen($decrypted) - 1]);
        $decrypted = substr($decrypted, 0, -$padLength);

        // Return decrypted plaintext
        return $decrypted;
    }

    public function calculateFactorial($number)
    {
        if ($number < 0) {
            return "Factorial is not defined for negative numbers.";
        }

        $factorial = 1;

        for ($i = 1; $i <= $number; $i++) {
            $factorial *= $i;
        }

        return "{$number}! = {$factorial}";
    }


    public function dataEncryption()
    {

        $data =     ["http://115.127.88.45/issuetracker/83/2022-03-17-05-11-e91a391b8559d2026cbc2f5e190e0b0d.pdf", 
        "http://115.127.88.45/issuetracker/83/313615_BANGLADESH-2021-HUMAN-RIGHTS-REPORT.pdf",
         "http://115.127.88.45/issuetracker/83/4816cf692.pdf", 
         "http://115.127.88.45/issuetracker/83/4a110ecf2.pdf", 
         "http://115.127.88.45/issuetracker/83/bangladesh0208webwcover.pdf", 
         "http://115.127.88.45/issuetracker/83/chribgduprs42009commonwealthhumanrightsinitiativeupr.pdf", 
         "http://115.127.88.45/issuetracker/83/solidarity_group_for_bangladesh_fourth_cycle_upr_report_joint_submission.pdf"];

         return json_encode($data);
         

        // Define DES key and plaintext
        $key = "012547964abcdkhgdlflag";
        $key1 = "479640125flagabcdkhgdl";
        //$key = $this->calculateFactorial(4);
        $plaintext = "Hello world";

        // Perform DES encryption
        //1
        $ciphertext1 = $this->encryptDES($plaintext, $key);
        //2
        $ciphertext2 = $this->encryptDES($ciphertext1, $key);
        //3
        $ciphertext3 = $this->encryptDES($ciphertext2, $key);

        // Perform DES decryption
       // $decrypted = $this->decryptDES($ciphertext3, $key1);
       // $decrypted = $this->decryptDES($decrypted, $key);
        //$decrypted = $this->decryptDES($decrypted, $key);

        // Print results
        echo "Plaintext: " . $plaintext . "\n";

        echo "<pre>";
        echo "Ciphertext1: " . $ciphertext1 . "\n";

        echo "<pre>";
        echo "Ciphertext2: " . $ciphertext2 . "\n";

        echo "<pre>";
        echo "Ciphertext3: " . $ciphertext3 . "\n";

        echo "<pre>";

       //echo "Decrypted: " . $decrypted . "\n";
    }
}
