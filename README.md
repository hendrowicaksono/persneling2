BACASAYA
========

Apa itu Persneling2?
--------------------

Persneling adalah API for SLiMS (slims.web.id). Kalau yang satu ini sepertinya bakal di-maintain, tapi seserius apa, Wallahu'alam. Tools ini saya buat untuk kebutuhan sederhana, memudahkan konversi data ke SLiMS. API ini masih sederhana, baru bisa input baru, belum bisa edit data. Cara penggunaanya sederhana, seperti dibawah ini:


```
<?php

// setup the autoloading
require_once 'vendor/autoload.php';

// setup Propel
require_once 'src/props/local/generated-conf/config.php';

use Slims\Persneling\Bibliography\Collection as C;
 
$koleksi = new C;
$data = $koleksi->collection_load();
#var_dump($data);die();

$data->title = 'Pengantar Sejarah';
$data->sor = 'Hendro Wicaksono et al.';
$data->edition = '2nd ed.';
$data->isbn_issn = '1234567890123';
$data->publisher = 'Erlangga';
$data->publish_year = '2016';
$data->collation = '451 p.';
$data->series_title = 'Seri belajar sejarah';
$data->call_number = '330.56 Wic p';
$data->language = 'Indonesia';
$data->source = 'sou';
$data->place = 'Jakarta';
$data->classification = '330.56';
$data->notes = 'Catatan notes disini.';
$data->image = 'pengantar_sejarah.jpg';
$data->file_att = 'file_att disini';
$data->opac_hide = '0';
$data->promoted = '1';
$data->labels = 'Labels disini';
$data->frequency_id = '2';
$data->spec_detail_info = 'spec_detail_info disini';
$data->input_date = date("Y-m-d H:i:s");
$data->uid = '1';
$data->authors[0]['name'] = 'Hendro Wicaksono';
$data->authors[1]['name'] = 'Dian Tirtha Kusuma';
$data->subjects[0]['name'] = 'Fisika';
$data->subjects[1]['name'] = 'Perpustakaan';
$data->items[0]['item_code'] = 'B000000001';
$data->items[0]['call_number'] = '330.56 Wic p';
$data->items[0]['coll_type_name'] = 'Reference';
$data->items[0]['inventory_code'] = '23/34/46';
$data->items[0]['received_date'] = '2017-02-01';
$data->items[0]['uid'] = '1';
$data->items[1]['item_code'] = 'B000000002';
$data->items[1]['call_number'] = '330.56 Wic p';
$data->items[1]['coll_type_name'] = 'Reference';
$data->items[1]['inventory_code'] = '23/34/47';
$data->items[1]['received_date'] = '2017-02-02';
$data->items[1]['uid'] = '1';
$data->items[2]['item_code'] = 'B000000003';
$data->items[2]['call_number'] = '330.56 Wic p';
$data->items[2]['coll_type_name'] = 'Reference';
$data->items[2]['inventory_code'] = '23/34/48';
$data->items[2]['received_date'] = '2017-04-01';
$data->items[2]['uid'] = '1';
$koleksi->collection_save($data);

```
Done, data sudah masuk ke SLiMS. Silahkan mencoba.

NB: oiya, API ini didevelop dengan mencoba merekonstruksi struktur database SLiMS melalui schema.xml. Jadi kalau mau nyoba ini silahkan jalankan:
jalankan: vendor/propel/propel/bin/propel sql:insert

Jangan lupa buat dulu database dengan kolasi utf8-mb4. Sesuaikan koneksi pada file src/props/local/propel.yml.
