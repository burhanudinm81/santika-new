<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Dosen;
use App\Models\KuotaDosen;
use Illuminate\Support\Facades\Log;

class SemproSchedulerService
{
    public function hyperparameterTuning(array $proposals, array $ruangs, array $tanggals, array $sesis, array $dosenKuota, array $waktuBerhalangan = [])
    {
        // $popSizes = [50, 100, 150, 200, 250, 300];
        // $maxGens = [100, 200, 300, 400, 500];
        // $mutationRates = [0.01, 0.05, 0.1, 0.2];
        $crossoverRates = [0.7, 0.8, 0.9, 0.95];

        $popSizes = [100];
        $maxGens = [100];
        $mutationRates = [0.05];
        // $crossoverRates = [0.8];

        $results = [];

        Log::info("--------------------------------------------------");
        Log::info("Memulai Hyperparameter Tuning...");
        Log::info("--------------------------------------------------");

        foreach ($popSizes as $popSize) {
            foreach ($maxGens as $maxGen) {
                foreach ($mutationRates as $mutationRate) {
                    foreach($crossoverRates as $crossoverRate){
                        $startTime = microtime(true);
                        $jadwal = $this->generate($proposals, $ruangs, $tanggals, $sesis, $dosenKuota, $waktuBerhalangan, $popSize, $maxGen, $crossoverRate, $mutationRate);
                        $endTime = microtime(true);
                        $executionTime = round($endTime - $startTime, 2);
                        $fitness = $this->fitness($jadwal, $dosenKuota, $waktuBerhalangan, $proposals);
                        Log::info("Pop Size: $popSize, Max Gen: $maxGen, Crossover Rate: $crossoverRate, Mutation Rate: $mutationRate => Fitness: $fitness, Execution Time: {$executionTime}s");
                        $results[] = [
                            'popSize' => $popSize,
                            'maxGen' => $maxGen,
                            'crossoverRate' => $crossoverRate,
                            'mutationRate' => $mutationRate,
                            'fitness' => $fitness,
                            'executionTime' => $executionTime
                        ];
                    }
                    
                }
            }
        }

        // Urutkan hasil dari fitness terbaik ke terburuk
        // usort($results, fn($a, $b) => $a['fitness'] <=> $b['fitness']);

        // Tampilkan hasil
        foreach ($results as $idx => $result) {
            echo "$idx. popSize: {$result['popSize']}, maxGen: {$result['maxGen']}, mutationRate: {$result['mutationRate']}, fitness: {$result['fitness']}, executionTime: {$result['executionTime']} <br>\n";
        }
    }

    
    /**
     * Generate seminar proposal schedule using genetic algorithm (GA)
     * @param array $proposals List of proposal data
     * @param array $ruangs List of ruang (room)
     * @param array $tanggals List of tanggal (date)
     * @param array $sesis List of sesi (start & end time)
     * @param array $dosenKuota List of dosen beserta kuotanya
     * @return array Jadwal hasil penjadwalan
     */
    public function generate(
        array $proposals,
        array $ruangs,
        array $tanggals,
        array $sesis,
        array $dosenKuota,
        array $waktuBerhalangan = [],
        int $popSize = 150,
        int $maxGen = 200,
        float $crossoverRate = 0,
        float $mutationRate = 0.01
    ) {
        $selectionCount = round(1 / 3 * $popSize);
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
            $selectedIndices = array_slice(array_keys($fitnessList), 0, $selectionCount);
            $selectedPopulation = [];
            foreach ($selectedIndices as $idx) {
                $selectedPopulation[] = $population[$idx];
            }

            $newPopulation = [];
            // Elitism: Mempertahankan 1 individu terbaik tanpa diubah
            if (!empty($selectedPopulation)) {
                $newPopulation[] = $selectedPopulation[0];
            }

            // Buat sisa populasi dengan mutasi dari individu terbaik
            // while (count($newPopulation) < $popSize) {
            //     // Ambil parent acak dari popoulasi terpilih
            //     $parent = $selectedPopulation[array_rand($selectedPopulation)];
            //     // Buat children dengan memutasi parent
            //     $child = $this->mutate($parent, $ruangs, $tanggals, $sesis, $dosenKuota, $proposals, $mutationRate);
            //     $newPopulation[] = $child;
            // }


            while (count($newPopulation) < $popSize) {
                // Pilih dua parent acak dari populasi terpilih
                $parent1 = $selectedPopulation[array_rand($selectedPopulation)];
                $parent2 = $selectedPopulation[array_rand($selectedPopulation)];

                if ((mt_rand() / mt_getrandmax()) < $crossoverRate) {
                    $offspring = $this->crossover($parent1, $parent2);
                } else {
                    $offspring = $parent1; // atau parent2
                }

                // Mutasi offspring
                $child = $this->mutate($offspring, $ruangs, $tanggals, $sesis, $dosenKuota, $proposals, $mutationRate);

                $newPopulation[] = $child;
            }

            $population = $newPopulation;
            if ($bestFitness == 0)
                break; // solusi optimal ditemukan
        }

        Log::info("------------------------");
        Log::info("Nilai Fitness Terbaik: $bestFitness");
        return $bestJadwal;
    }

    /**
     * Contoh fungsi evaluasi fitness (penalti constraint)
     */
    public function fitness(array $jadwal, array $dosenKuota, array $waktuBerhalangan = [], array $proposals = [])
    {
        $penalti = 0;
        $ruangWaktu = [];
        $dosenWaktu = [];
        $kuotaPenguji1 = [];
        $kuotaPenguji2 = [];

        foreach ($jadwal as $idx => $item) {
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

            // 2. Dosen tidak boleh bentrok pada waktu yang sama (lintas proposal/peran)
            foreach (['moderator', 'penguji_1', 'penguji_2'] as $role) {
                $dosenId = $item[$role];
                $keyDosen = $dosenId . '|' . $item['tanggal'] . '|' . $sesiStr;
                if (!isset($dosenWaktu[$keyDosen])) {
                    $dosenWaktu[$keyDosen] = 1;
                } else {
                    $dosenWaktu[$keyDosen]++;
                    $penalti += 20; // penalti dosen bentrok lintas proposal/peran
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

            // 5. Penalti jika bidang minat penguji tidak sesuai proposal
            if (!empty($proposals)) {
                $proposal = $proposals[$idx] ?? null;
                if ($proposal) {
                    $bidangMinat = $proposal['bidang_minat_id'];
                    foreach (['penguji_1', 'penguji_2'] as $role) {
                        $dosenId = $item[$role];
                        $dosenBidang = $dosenKuota[$dosenId]['bidang_minat_id'] ?? [];
                        if (is_array($dosenBidang)) {
                            if (!in_array($bidangMinat, $dosenBidang)) {
                                $penalti += 100; // penalti besar
                            }
                        } else {
                            if ($dosenBidang != $bidangMinat) {
                                $penalti += 100; // penalti besar
                            }
                        }
                    }
                }
            }
        }

        // 6. Cek kuota dosen penguji 1
        foreach ($kuotaPenguji1 as $dosenId => $terpakai) {
            $kuota = $dosenKuota[$dosenId]['kuota_penguji_sempro_1'] ?? 0;
            if ($terpakai > $kuota) {
                $penalti += ($terpakai - $kuota) * 20; // penalti kuota penguji 1 habis
            }
        }
        // 7. Cek kuota dosen penguji 2
        foreach ($kuotaPenguji2 as $dosenId => $terpakai) {
            $kuota = $dosenKuota[$dosenId]['kuota_penguji_sempro_2'] ?? 0;
            if ($terpakai > $kuota) {
                $penalti += ($terpakai - $kuota) * 20; // penalti kuota penguji 2 habis
            }
        }

        // 8. Dosen penguji tidak boleh sama dengan moderator atau satu sama lain
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
                $penguji1 = $this->getAvailableDosen($tanggal, $sesi, $dosenKuota, 1, [], $proposal['bidang_minat_id'], $jadwal);
                $penguji2 = $this->getAvailableDosen($tanggal, $sesi, $dosenKuota, 2, [$penguji1], $proposal['bidang_minat_id'], $jadwal);
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
    public function getAvailableDosen($tanggal, $sesi, $dosenKuota, $tipe = 1, $exclude = [], $bidangMinat = null, $jadwalSaatIni = [])
    {
        $field = $tipe == 1 ? 'kuota_penguji_sempro_1' : 'kuota_penguji_sempro_2';
        $candidates = [];

        // Kumpulkan dosen yang sudah terjadwal pada tanggal & sesi ini di proposal lain
        $dosenTerjadwal = [];
        foreach ($jadwalSaatIni as $item) {
            // Cek waktu sama
            $sesiStr = is_array($item['sesi'])
                ? ($item['sesi']['waktu_mulai'] . '-' . $item['sesi']['waktu_selesai'])
                : $item['sesi'];
            $sesiStrInput = is_array($sesi)
                ? ($sesi['waktu_mulai'] . '-' . $sesi['waktu_selesai'])
                : $sesi;
            if ($item['tanggal'] == $tanggal && $sesiStr == $sesiStrInput) {
                foreach (['moderator', 'penguji_1', 'penguji_2'] as $role) {
                    $dosenTerjadwal[] = $item[$role];
                }
            }
        }

        foreach ($dosenKuota as $dosenId => $kuota) {
            if (in_array($dosenId, $exclude))
                continue;
            if (in_array($dosenId, $dosenTerjadwal))
                continue;
            // Cek bidang minat jika diberikan
            if ($bidangMinat) {
                if (isset($kuota['bidang_minat_id']) && is_array($kuota['bidang_minat_id'])) {
                    if (!in_array($bidangMinat, $kuota['bidang_minat_id']))
                        continue;
                } elseif (isset($kuota['bidang_minat_id']) && $kuota['bidang_minat_id'] != $bidangMinat) {
                    continue;
                }
            }
            if (($kuota[$field] ?? 0) > 0) {
                $candidates[] = $dosenId;
            }
        }
        if (empty($candidates))
            return null;
        return $candidates[array_rand($candidates)];
    }

    /**
     * Melakukan mutasi pada sebuah individu (jadwal)
     * @param array $jadwal Jadwal yang akan dimutasi
     * @param float $mutationRate Peluang terjadinya mutasi
     * @return array Jadwal hasil mutasi
     */
    public function mutate(array $jadwal, array $ruangs, array $tanggals, array $sesis, array $dosenKuota, array $proposals, float $mutationRate): array
    {
        $mutatedJadwal = $jadwal;

        foreach ($mutatedJadwal as $idx => &$item) {
            // Mutasi Ruang
            if ((mt_rand() / mt_getrandmax()) < $mutationRate) {
                $item['ruang'] = $ruangs[array_rand($ruangs)];
            }

            // Mutasi Tanggal
            if ((mt_rand() / mt_getrandmax()) < $mutationRate) {
                $item['tanggal'] = $tanggals[array_rand($tanggals)];
            }

            // Mutasi Sesi
            if ((mt_rand() / mt_getrandmax()) < $mutationRate) {
                $item['sesi'] = $sesis[array_rand($sesis)];
            }

            // Mutasi Penguji 1
            if ((mt_rand() / mt_getrandmax()) < $mutationRate) {
                $item['penguji_1'] = $this->getAvailableDosen($item['tanggal'], $item['sesi'], $dosenKuota, 1, [$item['moderator'], $item['penguji_2']], $proposals[$idx]['bidang_minat_id'], $mutatedJadwal);
            }

            // Mutasi Penguji 2
            if ((mt_rand() / mt_getrandmax()) < $mutationRate) {
                $item['penguji_2'] = $this->getAvailableDosen($item['tanggal'], $item['sesi'], $dosenKuota, 2, [$item['moderator'], $item['penguji_1']], $proposals[$idx]['bidang_minat_id'], $mutatedJadwal);
            }
        }

        return $mutatedJadwal;
    }



    /**
     * Menggabungkan dua parent menjadi satu offspring menggunakan single-point crossover
     * @param array $parent1 Jadwal induk pertama
     * @param array $parent2 Jadwal induk kedua
     * @return array Jadwal anak (offspring)
     */
    public function crossover(array $parent1, array $parent2): array
    {
        $offspring = [];
        $totalItems = count($parent1);

        // Tentukan titik potong (crossover point) secara acak
        // Hindari titik 0 dan titik akhir agar persilangan bermakna
        $crossoverPoint = mt_rand(1, $totalItems - 2);

        // Ambil bagian "kepala" dari parent 1
        $head = array_slice($parent1, 0, $crossoverPoint);

        // Ambil bagian "ekor" dari parent 2
        $tail = array_slice($parent2, $crossoverPoint);

        // Gabungkan menjadi satu children
        $offspring = array_merge($head, $tail);

        return $offspring;
    }
}
