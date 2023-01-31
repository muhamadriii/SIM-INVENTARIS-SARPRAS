<?php

// use App\Models\LogMemberLevel;
// use App\Models\Member;
// use App\Models\Order;
// use App\Models\Product;

// if (!function_exists('setAncesorsLevel')) {
//     function setAncesorsLevel($id)
//     {
//         $ancesors = Member::whereAncestorOf($id)->orderBy('created_at', 'desc')->get();
//         foreach ($ancesors as $ancesor) {
//             // check if childrens level are same with ancesor level
//             $increase = 0;
//             foreach ($ancesor->childrens as $child)
//                 if ($child->level >= $ancesor->level)
//                     $increase++;

//             // if same with ancesor level then will increase ancesor level and update the database
//             if ($increase == 5) {
//                 Member::whereId($ancesor->id)->update(['level' => $ancesor->level + 1]);
//                 LogMemberLevel::create([
//                     'member_id' => $ancesor->id,
//                     'level_id' => $ancesor->level_user->id,
//                     'level_name' => $ancesor->level_user->level,
//                     // 'bonus_name'    => $ancesor->level_user->bonus_name,
//                     // 'bonus_value'   => $ancesor->level_user->bonus_value,
//                 ]);
//             }
//         }
//     }
// }

// if (!function_exists('order_code')) {
//     function order_code()
//     {
//         $data = Order::max('order_code');
//         // dd($data);
//         // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
//         // dan diubah ke integer dengan (int)
//         if ($data) {
//             $urutan = (int)substr($data, 11, 5);

//             // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
//             $urutan++;
//         } else {
//             $urutan = "00001";
//         }
//         // dd($urutan);
//         // membentuk kode barang baru
//         // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
//         // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
//         // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG
//         $huruf = "ORD" . date('Ymd');
//         $kodeBarang = $huruf . sprintf("%05s", $urutan);
//         return $kodeBarang;

//     }
// }

// if (!function_exists('getInitial')) {
//     function getInitial($name)
//     {
//         //split name using spaces
//         $words = explode(" ", $name);
//         $inits = '';
//         //loop through array extracting initial letters
//         foreach ($words as $word) {
//             $inits .= strtoupper(substr($word, 0, 1));
//         }
//         return $inits;
//     }
// }

// if (!function_exists('sku')) {
//     function code_sku()
//     {
//         $data = Product::max('sku');
//         // dd($data);
//         // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
//         // dan diubah ke integer dengan (int)
//         if ($data) {
//             $urutan = (int)substr($data, 11, 5);

//             // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
//             $urutan++;
//         } else {
//             $urutan = "00001";
//         }
//         // dd($urutan);
//         // membentuk kode barang baru
//         // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
//         // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
//         // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG
//         $huruf = "PRD" . date('Ymd');
//         $kodeBarang = $huruf . sprintf("%05s", $urutan);
//         return $kodeBarang;

//     }
// }

// if (!function_exists('member_code')) {
//     function member_code()
//     {
//         $data = Member::max('code');
//         if ($data) {
//             $urutan = (int)substr($data, 11, 5);
//             $urutan++;
//         } else {
//             $urutan = "00001";
//         }
//         $letter = "M" . date('Ymd');
//         $code = $letter . sprintf("%05s", $urutan);
//         return $code;
//     }
// }
