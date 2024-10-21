<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TranslateController extends Controller
{
    public function index()
    {
        // Menampilkan halaman utama
        return view('translate.index');
    }

    public function translate(Request $request)
    {
        // Input Validation
        $request->validate([
            'text' => 'required|string',
            'target_language' => 'required|string',
        ]);

        $text = $request->input('text');
        $targetLanguage = $request->input('target_language');

        try {
            // API
            $client = new Client();
            $response = $client->request('POST', 'https://google-translate1.p.rapidapi.com/language/translate/v2', [
                'headers' => [
                    'Accept-Encoding' => 'application/gzip',
                    'x-rapidapi-host' => 'google-translate1.p.rapidapi.com',
                    'x-rapidapi-key' => '199f1439e8msh8c63f92e98d2186p19e88ejsnefd72cc6e125',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    'q' => $text,
                    'target' => $targetLanguage,
                ],
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['data']['translations'][0]['translatedText'])) {
                $translatedText = $result['data']['translations'][0]['translatedText'];
                return back()->with('success', 'Translation successful')->with('translatedText', $translatedText);
            } else {
                return back()->with('error', 'Translation failed');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}