<?php

namespace Database\Seeders;

use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RajaOngkirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curl = curl_init();
        $curl2 = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.rajaongkir.com/starter/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 2b5cd7a68882dcbc86b6b75da0af69a5"
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response);
        if($data->rajaongkir->status->code == 200){
            foreach ($data->rajaongkir->results as $key => $value) {
                Provinsi::create([
                    'id_provinsi' => $value->province_id,
                    'nama_provinsi' => $value->province
                ]);

                curl_setopt_array($curl2, array(
                    CURLOPT_URL => "http://api.rajaongkir.com/starter/city?province=".$value->province_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "key: 2b5cd7a68882dcbc86b6b75da0af69a5"
                    ),
                ));

                $kota = curl_exec($curl2);
                $data2 = json_decode($kota);
                if($data2->rajaongkir->status->code == 200){
                    foreach ($data2->rajaongkir->results as $key => $value2) {
                        Kota::create([
                            'id_kota' => $value2->city_id,
                            'nama_kota' => $value2->city_name,
                            'id_provinsi' => $value->province_id
                        ]);
                    }
                }
            }
        }
        $err = curl_error($curl);
    }
}
