<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Dosen;
use App\Models\KuotaDosen;

class SemproSchedulerService
{
    /**
     * Generate seminar proposal schedule using genetic algorithm (GA)
     * @param array $proposals List of proposal data
     * @param array $ruangs List of ruang (room)
     * @param array $tanggals List of tanggal (date)
     * @param array $sesis List of sesi (start & end time)
     * @param array $dosenKuota List of dosen beserta kuotanya
     * @return array Jadwal hasil penjadwalan
     */
    public function generate(array $proposals, array $ruangs, array $tanggals, array $sesis, array $dosenKuota, array $waktuBerhalangan = [])
    {
        $popSize = 30;
        $maxGen = 100;
        $population = $this->initPopulation($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, $popSize);
        $bestJadwal = null;
        $bestFitness = PHP_INT_MAX;

        for ($gen = 0; $gen < $maxGen; $gen++) {
            $fitnessList = [];
            foreach ($population as $idx => $jadwal) {
                $fitness = $this->fitness($jadwal, $dosenKuota, $waktuBerhalangan);
                $fitnessList[$idx] = $fitness;
                if ($fitness < $bestFitness) {
                    $bestFitness = $fitness;
                    $bestJadwal = $jadwal;
                }
            }
            // Seleksi: ambil 10 jadwal terbaik
            asort($fitnessList);
            $selected = array_slice(array_keys($fitnessList), 0, 10);
            $newPopulation = [];
            foreach ($selected as $idx) {
                $newPopulation[] = $population[$idx];
            }
            // Crossover & Mutasi sederhana: acak ulang sisanya
            while (count($newPopulation) < $popSize) {
                $newPopulation[] = $this->initPopulation($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, 1)[0];
            }
            $population = $newPopulation;
            if ($bestFitness == 0)
                break; // solusi optimal ditemukan
        }
        return $bestJadwal;
    }

    /**
     * Contoh fungsi evaluasi fitness (penalti constraint)
     */
    public function fitness(array $jadwal, array $dosenKuota, array $waktuBerhalangan = [])
    {
        $penalti = 0;
        $ruangWaktu = [];
        $dosenWaktu = [];
        $kuotaPenguji1 = [];
        $kuotaPenguji2 = [];

        foreach ($jadwal as $item) {
            // Gabungkan waktu mulai dan selesai menjadi string unik sesi
            $sesiStr = is_array($item['sesi'])
                ? ($item['sesi']['waktu_mulai'] . '-' . $item['sesi']['waktu_selesai'])
                : $item['sesi'];

            $keyRuang = $item['ruang'] . '|' . $item['tanggal'] . '|' . $sesiStr;
            // 1. Ruang tidak boleh bentrok
            if (!isset($ruangWaktu[$keyRuang])) {
                $ruangWaktu[$keyRuang] = 1;
            } else {
                $ruangWaktu[$keyRuang]++;
                $penalti += 10; // penalti ruang bentrok
            }

            // 2. Dosen tidak boleh bentrok pada waktu yang sama
            $dosenList = [$item['moderator'], $item['penguji_1'], $item['penguji_2']];
            foreach ($dosenList as $dosenId) {
                $keyDosen = $dosenId . '|' . $item['tanggal'] . '|' . $sesiStr;
                if (!isset($dosenWaktu[$keyDosen])) {
                    $dosenWaktu[$keyDosen] = 1;
                } else {
                    $dosenWaktu[$keyDosen]++;
                    $penalti += 10; // penalti dosen bentrok
                }
                // Penalti jika dosen berhalangan pada waktu ini
                if (!empty($waktuBerhalangan)) {
                    foreach ($waktuBerhalangan as $wb) {
                        if ($wb['dosen_id'] == $dosenId && $wb['tanggal'] == $item['tanggal']) {
                            // Cek overlap waktu
                            $mulaiA = $item['sesi']['waktu_mulai'] ?? null;
                            $selesaiA = $item['sesi']['waktu_selesai'] ?? null;
                            $mulaiB = $wb['waktu_mulai'];
                            $selesaiB = $wb['waktu_selesai'];
                            if ($mulaiA && $selesaiA && !($selesaiA <= $mulaiB || $mulaiA >= $selesaiB)) {
                                $penalti += 100; // penalti besar jika dosen berhalangan
                            }
                        }
                    }
                }
            }

            // 3. Kuota dosen penguji 1
            if (!isset($kuotaPenguji1[$item['penguji_1']]))
                $kuotaPenguji1[$item['penguji_1']] = 0;
            $kuotaPenguji1[$item['penguji_1']]++;
            // 4. Kuota dosen penguji 2
            if (!isset($kuotaPenguji2[$item['penguji_2']]))
                $kuotaPenguji2[$item['penguji_2']] = 0;
            $kuotaPenguji2[$item['penguji_2']]++;
        }

        // 5. Cek kuota dosen penguji 1
        foreach ($kuotaPenguji1 as $dosenId => $terpakai) {
            $kuota = $dosenKuota[$dosenId]['kuota_penguji_sempro_1'] ?? 0;
            if ($terpakai > $kuota) {
                $penalti += ($terpakai - $kuota) * 20; // penalti kuota penguji 1 habis
            }
        }
        // 6. Cek kuota dosen penguji 2
        foreach ($kuotaPenguji2 as $dosenId => $terpakai) {
            $kuota = $dosenKuota[$dosenId]['kuota_penguji_sempro_2'] ?? 0;
            if ($terpakai > $kuota) {
                $penalti += ($terpakai - $kuota) * 20; // penalti kuota penguji 2 habis
            }
        }

        // 7. Moderator harus sama dengan dosen_pembimbing_1_id (diasumsikan sudah benar di inisialisasi)
        // 8. Dosen penguji tidak boleh sama dengan moderator
        foreach ($jadwal as $item) {
            if ($item['penguji_1'] == $item['moderator'] || $item['penguji_2'] == $item['moderator'] || $item['penguji_1'] == $item['penguji_2']) {
                $penalti += 10;
            }
        }

        return $penalti;
    }

    /**
     * Inisialisasi populasi awal secara acak
     */
    public function initPopulation(array $proposals, array $ruangs, array $tanggals, array $sesis, array $dosenKuota, int $size = 10)
    {
        $population = [];
        $totalProposal = count($proposals);
        for ($i = 0; $i < $size; $i++) {
            $jadwal = [];
            foreach ($proposals as $proposal) {
                $ruang = $ruangs[array_rand($ruangs)];
                $tanggal = $tanggals[array_rand($tanggals)];
                $sesi = $sesis[array_rand($sesis)];
                $penguji1 = $this->getAvailableDosen($tanggal, $sesi, $dosenKuota, 1);
                $penguji2 = $this->getAvailableDosen($tanggal, $sesi, $dosenKuota, 2);
                $jadwal[] = [
                    'proposal_id' => $proposal['id'],
                    'ruang' => $ruang,
                    'tanggal' => $tanggal,
                    'sesi' => $sesi,
                    'moderator' => $proposal['dosen_pembimbing_1_id'],
                    'penguji_1' => $penguji1,
                    'penguji_2' => $penguji2,
                ];
            }
            $population[] = $jadwal;
        }
        return $population;
    }

    /**
     * Memilih dosen yang masih memiliki kuota penguji dan tidak bentrok dengan exclude
     * @param string $tanggal
     * @param string $sesi
     * @param array $dosenKuota
     * @param int $tipe 1=kuota_penguji_sempro_1, 2=kuota_penguji_sempro_2
     * @param array $exclude daftar dosen_id yang tidak boleh dipilih
     * @return int|null dosen_id terpilih atau null jika tidak ada yang valid
     */
    public function getAvailableDosen($tanggal, $sesi, $dosenKuota, $tipe = 1, $exclude = [])
    {
        $field = $tipe == 1 ? 'kuota_penguji_sempro_1' : 'kuota_penguji_sempro_2';
        $candidates = [];
        foreach ($dosenKuota as $dosenId => $kuota) {
            if (in_array($dosenId, $exclude))
                continue;
            if (($kuota[$field] ?? 0) > 0) {
                $candidates[] = $dosenId;
            }
        }
        if (empty($candidates))
            return null;
        return $candidates[array_rand($candidates)];
    }
}
