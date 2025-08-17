<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Dosen;
use App\Models\KuotaDosen;

class SemhasSchedulerService
{
    // Parameter genetic algorithm
    protected $populationSize = 100;
    protected $generations = 200;
    protected $mutationRate = 0.1;

    public function generate($proposals, $ruangs, $tanggals, $sesis, $dosenKuota)
    {
        // 1. Inisialisasi populasi awal
        $population = [];
        for ($i = 0; $i < $this->populationSize; $i++) {
            $population[] = $this->generateRandomSchedule($proposals, $ruangs, $tanggals, $sesis, $dosenKuota);
        }

        // 2. Evolusi populasi
        for ($gen = 0; $gen < $this->generations; $gen++) {
            // Hitung fitness
            $fitness = [];
            foreach ($population as $schedule) {
                $fitness[] = $this->calculateFitness($schedule, $dosenKuota);
            }

            // Seleksi (roulette wheel)
            $newPopulation = [];
            for ($i = 0; $i < $this->populationSize; $i++) {
                $parent1 = $this->selectParent($population, $fitness);
                $parent2 = $this->selectParent($population, $fitness);
                $child = $this->crossover($parent1, $parent2);
                $child = $this->mutate($child, $ruangs, $tanggals, $sesis, $dosenKuota);
                $newPopulation[] = $child;
            }
            $population = $newPopulation;
        }

        // 3. Ambil solusi terbaik
        $bestSchedule = $population[0];
        $bestFitness = $this->calculateFitness($bestSchedule, $dosenKuota);
        foreach ($population as $schedule) {
            $fit = $this->calculateFitness($schedule, $dosenKuota);
            if ($fit > $bestFitness) {
                $bestFitness = $fit;
                $bestSchedule = $schedule;
            }
        }

        return $bestSchedule;
    }

    protected function generateRandomSchedule($proposals, $ruangs, $tanggals, $sesis, $dosenKuota)
    {
        $jadwal = [];
        $usedSlots = [];
        $kuotaPenguji1 = $dosenKuota;
        $kuotaPenguji2 = $dosenKuota;

        foreach ($proposals as $proposal) {
            // Pilih slot ruang, tanggal, sesi yang belum terpakai
            do {
                $ruang = $ruangs[array_rand($ruangs)];
                $tanggal = $tanggals[array_rand($tanggals)];
                $sesi = $sesis[array_rand($sesis)];
                $slotKey = $ruang . '|' . $tanggal . '|' . $sesi['waktu_mulai'] . '|' . $sesi['waktu_selesai'];
            } while (in_array($slotKey, $usedSlots));
            $usedSlots[] = $slotKey;

            // Dosen pembimbing dari proposal
            $dosenPembimbing1 = $proposal->dosen_pembimbing_1_id;
            $dosenPembimbing2 = $proposal->dosen_pembimbing_2_id;

            // Pilih dosen penguji 1 dan 2 (kuota harus cukup, tidak boleh bentrok dengan pembimbing)
            $penguji1 = $this->pickPenguji($kuotaPenguji1, [$dosenPembimbing1, $dosenPembimbing2], $proposal->bidang_minat_id);
            if ($penguji1 !== null)
                $kuotaPenguji1[$penguji1]['kuota_penguji_sidang_TA_1']--;

            $penguji2 = $this->pickPenguji($kuotaPenguji2, [$dosenPembimbing1, $dosenPembimbing2, $penguji1], $proposal->bidang_minat_id);
            if ($penguji2 !== null)
                $kuotaPenguji2[$penguji2]['kuota_penguji_sidang_TA_2']--;

            $jadwal[] = [
                'proposal_id' => $proposal->id,
                'ruang' => $ruang,
                'tanggal' => $tanggal,
                'sesi' => $sesi,
                'dosen_pembimbing_1_id' => $dosenPembimbing1,
                'dosen_pembimbing_2_id' => $dosenPembimbing2,
                'penguji_sidang_TA_1_id' => $penguji1,
                'penguji_sidang_TA_2_id' => $penguji2,
            ];
        }
        return $jadwal;
    }

    protected function pickPenguji($kuota, $exclude, $bidangMinat)
    {
        $candidates = [];
        foreach ($kuota as $dosen_id => $data) {
            // Cek bidang minat dosen
            $dosenBidang = $data['bidang_minat_id'] ?? null;
            $cocok = false;

            if (is_array($dosenBidang)) {
                $cocok = in_array($bidangMinat, $dosenBidang);
            }

            if (
                $cocok &&
                !in_array($dosen_id, $exclude) &&
                (!isset($data['kuota_penguji_sidang_TA_1']) || $data['kuota_penguji_sidang_TA_1'] > 0) &&
                (!isset($data['kuota_penguji_sidang_TA_2']) || $data['kuota_penguji_sidang_TA_2'] > 0)
            ) {
                $candidates[] = $dosen_id;
            }
        }
        if (empty($candidates))
            return null;
        return $candidates[array_rand($candidates)];
    }

    protected function calculateFitness($schedule, $dosenKuota)
    {
        $score = 0;
        $slotMap = [];
        $dosenWaktu = [];

        foreach ($schedule as $item) {
            $slotKey = $item['ruang'] . '|' . $item['tanggal'] . '|' . $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            // Constraint 1: Ruang tidak boleh bentrok
            if (!isset($slotMap[$slotKey])) {
                $slotMap[$slotKey] = true;
                $score++;
            }

            // Constraint 2: Dosen tidak boleh bentrok pada waktu yang sama
            $waktuKey = $item['tanggal'] . '|' . $item['sesi']['waktu_mulai'] . '|' . $item['sesi']['waktu_selesai'];
            foreach ([
                $item['dosen_pembimbing_1_id'],
                $item['dosen_pembimbing_2_id'],
                $item['penguji_sidang_TA_1_id'],
                $item['penguji_sidang_TA_2_id']
            ] as $dosen_id) {
                if ($dosen_id) {
                    if (!isset($dosenWaktu[$dosen_id]))
                        $dosenWaktu[$dosen_id] = [];
                    if (!in_array($waktuKey, $dosenWaktu[$dosen_id])) {
                        $dosenWaktu[$dosen_id][] = $waktuKey;
                        $score++;
                    }
                }
            }
        }
        return $score;
    }

    protected function selectParent($population, $fitness)
    {
        // Roulette wheel selection
        $sum = array_sum($fitness);
        $pick = mt_rand(0, $sum - 1);
        $current = 0;
        foreach ($population as $i => $chromosome) {
            $current += $fitness[$i];
            if ($current > $pick) {
                return $chromosome;
            }
        }
        return $population[0];
    }

    protected function crossover($parent1, $parent2)
    {
        // Single point crossover
        $point = rand(1, count($parent1) - 1);
        return array_merge(array_slice($parent1, 0, $point), array_slice($parent2, $point));
    }

    protected function mutate($chromosome, $ruangs, $tanggals, $sesis, $dosenKuota)
    {
        // Mutasi: acak salah satu slot
        if (rand(0, 100) / 100 < $this->mutationRate) {
            $idx = array_rand($chromosome);
            $chromosome[$idx]['ruang'] = $ruangs[array_rand($ruangs)];
            $chromosome[$idx]['tanggal'] = $tanggals[array_rand($tanggals)];
            $chromosome[$idx]['sesi'] = $sesis[array_rand($sesis)];
        }
        return $chromosome;
    }
}