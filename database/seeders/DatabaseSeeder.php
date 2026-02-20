<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create sample users for each role
        $govUser = \App\Models\User::create([
            'name' => 'Government User',
            'email' => 'government@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'government',
        ]);

        $privateUser = \App\Models\User::create([
            'name' => 'Private User',
            'email' => 'private@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'private',
        ]);

        $soeUser = \App\Models\User::create([
            'name' => 'SOE User',
            'email' => 'soe@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'soe',
        ]);

        // Sample project data for Government (like in the image)
        \App\Models\Project::create([
            'user_id' => $govUser->id,
            'role' => 'government',
            'project_name' => 'Astinct Baliqe',
            'id_lop' => '',
            'cc' => 'Toba',
            'nipnas' => '',
            'am' => 'Dicky',
            'mitra' => 'Tanpa Mitra',
            'phn_bulan_billcomp' => '8',
            'est_nilai_bc' => '',
            'f0_inisiasi_solusi' => '',
            'f1_technical_budget' => '',
            'f2_p0_p1_jukbok' => '',
            'p2_evaluasi_bakal_calon' => '',
            'f2_p3_permintaan_penawaran' => '',
            'f2_p4_rapat_penjelasan' => '',
            'offering_harga_final' => '',
            'f2_p5_evaluasi_sph' => '',
            'f3_p6_klarifikasi_negosiasi' => '',
            'f3_p7_penetapan_mitra' => '',
            'f3_submit_proposal' => '',
            'negosiasi' => '',
            'surat' => 'FALSE',
            'tanda' => 'FALSE',
            'f5_p8_surat_penetapan' => '',
            'del_kontrak_layanan' => '',
            'baut' => '',
            'del_baso' => '',
            'billing_complete' => 'FALSE',
            'keterangan' => '',
        ]);
    }
}
