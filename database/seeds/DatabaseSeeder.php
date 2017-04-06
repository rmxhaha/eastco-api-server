<?php

use Illuminate\Database\Seeder;
use App\Address;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $addrs = ["Sasana Budaya Ganesa",
        "Stasiun Mandala Wangi",
        "Kolam renang UPT olahraga",
        "Menwa",
        "Labtek III ; Matematika, HIMATIKA, Astronomi, HIMASTRON, Pusat Penelitian dan Pengembangan dan Penerapan Matematika)",
        "Teknik Industri, MTI",
        "Labtek Mesin",
        "Labtek Metalurgi Pengecoran, Labtek Metalurgi Mekanik",
        "Labtek II ; (Teknik Mesin, HMM, Teknik Penerbangan, KMPN)",
        "Botanical Garden",
        "Lab Telekomunikasi Radio dan gelombang Mikro (EL)",
        "Gedung Kuliah Umum Lama, Kantin",
        "Lab Konversi Energi Elektro (EL)",
        "Gedung Serba Guna",
        "KPP",
        "Pos Satpam, Gerbang Utama Belakang",
        "Sunken Court",
        "Perpustakaan Pusat, Penerbit ITB",
        "Labtek X ; (Teknik Kimia, HIMATEK, Teknik Material, MTM)",
        "Labtek XI ; ( Biologi, NYMPHAEA, Geofisika, Meteorologi, Oseanografi, HMGF)",
        "Gedung Kuliah Umum Oktagon",
        "Gedung Kuliah Umum TVST",
        "Lab Fisika Dasar TPB",
        "Lab Penelitian Sistem Tenaga dan Distribusi, Lab teknik Tegangan Tinggi dan Pengukuran Listrik (EL)",
        "Labtek I ; (Lab Struktur, Lab Tanah)",
        "Lab struktur dan bahan",
        "Labtek VI ; ( Teknik Fisika, HMFT. Prog. Studi Kelautan, Pusat penelitian Kelautan, IOM,COMLABS, TPB, UPT Pendidikan)",
        "Labtek V ; (Teknik Informatika, HMIF, FTI, Kantin)",
        "Labtek VII ; (Farmasi, HMF, Sosioteknologi)",
        "Labtek VIII ; (FMIPA, Teknik Elektro, HME, UPT bahasa)",
        "Pusat Sumber Daya air, Pool Kendaraan",
        "LAPI, P2T",
        "Labtek IV ; (Teknik Geologi, GEA, Teknik Pertambangan, HMT)",
        "Wisma Rektor",
        "Kantin",
        "Teknik Perminyakan, PATRA",
        "Basic Science Center B (FIKTM, Teknik Geofisika,HMTG Terra, Lab Kimia, Dasar)",
        "Kimia",
        "AMISCA",
        "Kantin",
        "Lab Uji Model Hidraulik",
        "Gedung Kuliah Umum Baru, Bank BNI ITB, CDC",
        "Magister Teknik Geodesi, LPKM",
        "Magister Sistem dan Teknik Jalan Raya",
        "Seni Rupa Tekstil",
        "IMG",
        "Teknik Lingkungan, HMTL",
        "Labtek IX C ; (Teknik Geodesi, TeknikLingkungan)",
        "Labtek IX A ; (Teknik Planologi, HMP)",
        "Campus Center Timur",
        "Lap. Segitiga",
        "Seni Murni-Desain",
        "Musholla Bundar, Kantin",
        "Labtek IX B ; (Teknik Arsitektur, IMA-G)",
        "Galeri Soemardja",
        "Gedung Kuliah",
        "LFM",
        "Aula Timur",
        "Pos Satpam",
        "FSRD",
        "FTSP",
        "Pusat Informasi Kampus, ATM BNI",
        "Aula Barat",
        "Teknik Sipil, HMS",
        "Lap. Basket, Lap. Volley",
        "Student center barat",
        "Fisika, HIMAFI",
        "Lab Elektronika dan Instrumentasi (Fisika)",
        "BRT ITB",
        "Lab Adhiwijogo (Teknik Fisika)",
        "Basic Science Center A",
        "Pusat Penelitian Teknologi",
        "Koperasi Keluarga Pegawai ITB",
        "Pusat Penelitian Kepariwisataan",
        "Magister Manajemen Teknologi",
        "Apotek Ganesha, Balai Pengobatan Keluarga"];

        foreach($addrs as $addr){
          Address::firstOrCreate(['name'=>$addr]);
        }
        // $this->call(UsersTableSeeder::class);
    }
}
