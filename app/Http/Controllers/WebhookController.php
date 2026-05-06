<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeadYapo;
use Log;
class WebhookController extends Controller
{
    public function receive(Request $request)
    {
        // Obtener todo el JSON
        $data = $request->all();

        if (empty($data)) {
            return response()->json(['error' => 'Payload vacío'], 400);
        }

        // Extraer datos importantes
        $leadId   = $data['id'] ?? null;
        $created  = $data['createdat'] ?? null;
        $message  = $data['message'] ?? null;

        $contact  = $data['contact'] ?? [];
        $name     = $contact['name'] ?? null;
        $email    = $contact['email'] ?? null;
        $phone    = $contact['phone'] ?? null;

        $ad       = $data['addetails'] ?? [];
        $title    = $ad['title'] ?? null;
        $price    = $ad['price'] ?? null;
        
        LeadYapo::create([
            'external_id' => $leadId,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
            'created_at_source' => $created,
            'ad_title' => $title,
            'price' => $price
        ]);

        return response()->json(['status' => 'ok'], 200);
    }
}
