<?php

namespace App\Services;

class FuzzyService
{
    public function calculate($pages, $binding, $urgency)
    {
        // 0. Hitung Durasi Fisik (Menit)
        $duration = ceil($pages * 0.1);

        if ($binding === 'staples') {
            $duration += 2; // Tambah 2 menit untuk proses stapler/klip
        } elseif ($binding === 'spiral') {
            $duration += 10;
        } elseif ($binding === 'hardcover') {
            $duration += 20;
        }

        // -------------------------------------------------------------
        // TAHAP 1: FUZZIFIKASI (Menghitung Derajat Keanggotaan [0 - 1])
        // -------------------------------------------------------------

        // Fuzzifikasi Durasi (Cepat: <=15, Sedang: 10-45, Lama: >=40)
        $uDurasiCepat = $duration <= 10 ? 1 : ($duration < 15 ? (15 - $duration) / 5 : 0);
        $uDurasiSedang = ($duration > 10 && $duration <= 25) ? ($duration - 10) / 15 : (($duration > 25 && $duration < 45) ? (45 - $duration) / 20 : 0);
        $uDurasiLama = $duration >= 45 ? 1 : ($duration > 40 ? ($duration - 40) / 5 : 0);

        // Fuzzifikasi Urgensi (Biasa: <=4, Penting: 3-7, Sangat Urgent: >=6)
        $uUrgensiBiasa = $urgency <= 3 ? 1 : ($urgency < 4 ? (4 - $urgency) : 0);
        $uUrgensiPenting = ($urgency > 3 && $urgency <= 5) ? ($urgency - 3) / 2 : (($urgency > 5 && $urgency < 7) ? (7 - $urgency) / 2 : 0);
        $uUrgensiUrgent = $urgency >= 7 ? 1 : ($urgency > 6 ? ($urgency - 6) : 0);

        // -------------------------------------------------------------
        // TAHAP 2: INFERENSI / EVALUASI RULE BASE (MIN Operator)
        // -------------------------------------------------------------

        $rulesTinggi = [];
        $rulesSedang = [];
        $rulesRendah = [];

        // Rule 1: IF Cepat AND Sangat Urgent THEN Tinggi
        $rulesTinggi[] = min($uDurasiCepat, $uUrgensiUrgent);
        // Rule 2: IF Cepat AND Penting THEN Tinggi
        $rulesTinggi[] = min($uDurasiCepat, $uUrgensiPenting);
        // Rule 3: IF Cepat AND Biasa THEN Sedang
        $rulesSedang[] = min($uDurasiCepat, $uUrgensiBiasa);
        // Rule 4: IF Sedang AND Sangat Urgent THEN Tinggi
        $rulesTinggi[] = min($uDurasiSedang, $uUrgensiUrgent);
        // Rule 5: IF Sedang AND Penting THEN Sedang
        $rulesSedang[] = min($uDurasiSedang, $uUrgensiPenting);
        // Rule 6: IF Sedang AND Biasa THEN Rendah
        $rulesRendah[] = min($uDurasiSedang, $uUrgensiBiasa);
        // Rule 7: IF Lama AND Sangat Urgent THEN Sedang
        $rulesSedang[] = min($uDurasiLama, $uUrgensiUrgent);
        // Rule 8: IF Lama AND Penting THEN Rendah
        $rulesRendah[] = min($uDurasiLama, $uUrgensiPenting);
        // Rule 9: IF Lama AND Biasa THEN Rendah
        $rulesRendah[] = min($uDurasiLama, $uUrgensiBiasa);
        // Rule 10: IF Cepat AND Tanpa Jilid THEN Tinggi
        if ($binding === 'tanpa_jilid') {
            $rulesTinggi[] = $uDurasiCepat;
        }

        // Agregasi MAX untuk tiap kategori output
        $alphaRendah = ! empty($rulesRendah) ? max($rulesRendah) : 0;
        $alphaSedang = ! empty($rulesSedang) ? max($rulesSedang) : 0;
        $alphaTinggi = ! empty($rulesTinggi) ? max($rulesTinggi) : 0;

        // -------------------------------------------------------------
        // TAHAP 3: DEFUZZIFIKASI (Mencari Center of Area / Centroid)
        // Nilai Tengah Kategori: Rendah = 25, Sedang = 50, Tinggi = 85
        // -------------------------------------------------------------

        $numerator = ($alphaRendah * 25) + ($alphaSedang * 50) + ($alphaTinggi * 85);
        $denominator = $alphaRendah + $alphaSedang + $alphaTinggi;

        // Cegah pembagian dengan nol
        $priorityScore = $denominator > 0 ? ($numerator / $denominator) : 50;

        return [
            'duration' => $duration,
            'priority_score' => round($priorityScore, 2),
        ];
    }
}
