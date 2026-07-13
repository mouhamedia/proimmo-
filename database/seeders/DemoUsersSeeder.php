<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Residence;
use App\Models\TenantApartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = [
            'Aminata', 'Moussa', 'Fatou', 'Ibrahima', 'Awa', 'Ousmane', 'Mariama', 'Cheikh', 'Khady', 'Babacar',
            'Ndeye', 'Serigne', 'Sokhna', 'Pape', 'Adama', 'Mame', 'Mamadou', 'Halima', 'Sidy', 'Rokhaya',
            'Amadou', 'Bineta', 'El Hadji', 'Coumba', 'Moustapha', 'Khadija', 'Samba', 'Nafissatou', 'Alioune', 'Diarra',
            'Mody', 'Astou', 'Abdou', 'Yacine', 'Lamine', 'Fanta', 'Penda', 'Balla', 'Nfaly', 'Oumy',
            'Cheikhna', 'Moussa', 'Aissatou', 'Mame Diarra', 'Saliou', 'Zeyna', 'Babou', 'Ndeye', 'Mbayang', 'Amel',
        ];

        $lastNames = [
            'Diop', 'Ndoye', 'Sarr', 'Fall', 'Sy', 'Ba', 'Ndiaye', 'Faye', 'Gaye', 'Seck',
            'Kane', 'Cisse', 'Diallo', 'Mbacke', 'Wade', 'Sow', 'Thiam', 'Traore', 'Niasse', 'Lo',
            'Camara', 'Dieng', 'Diagne', 'Mbaye', 'Ba', 'Ka', 'Tine', 'Jallow', 'Coly', 'Ndao',
            'Gningue', 'Khouma', 'Ndiaye', 'Niang', 'Sagna', 'Boye', 'Fallou', 'Coundoul', 'Sene', 'Ndour',
            'Diallo', 'Barry', 'Badiane', 'Samb', 'Ndaw', 'Goudiaby', 'Mane', 'Ba', 'Dione', 'Lamin',
        ];

        $residenceIds = Residence::query()->orderBy('id')->pluck('id')->all();
        $apartmentIds = Apartment::query()->orderBy('id')->pluck('id')->all();

        if (empty($residenceIds)) {
            $residenceIds = [null];
        }

        // Clean old demo accounts to keep seeded data aligned with route/login logic.
        User::query()->where('email', 'like', 'demo-%@immoapp.test')->delete();

        // 40 tenant accounts for /tenant/dashboard testing.
        for ($index = 1; $index <= 40; $index++) {
            $firstName = $firstNames[($index - 1) % count($firstNames)];
            $lastName = $lastNames[($index - 1) % count($lastNames)];
            $fullName = trim($firstName . ' ' . $lastName);
            $residenceId = $residenceIds[($index - 1) % count($residenceIds)];
            $email = sprintf('demo-tenant-%02d@immoapp.test', $index);

            $tenant = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => 'password',
                    'role' => 'tenant',
                    'residence_id' => $residenceId,
                ]
            );

            if (!empty($apartmentIds)) {
                $apartmentId = $apartmentIds[($index - 1) % count($apartmentIds)];

                TenantApartment::updateOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'apartment_id' => $apartmentId,
                    ],
                    [
                        'code' => sprintf('DMT-%06d', $tenant->id),
                        'start_date' => now()->subDays($index * 2)->toDateString(),
                        'end_date' => null,
                    ]
                );
            }
        }

        // 10 manager accounts for /manager/dashboard testing.
        for ($index = 1; $index <= 10; $index++) {
            $nameIndex = $index + 40;
            $firstName = $firstNames[($nameIndex - 1) % count($firstNames)];
            $lastName = $lastNames[($nameIndex - 1) % count($lastNames)];
            $fullName = trim($firstName . ' ' . $lastName);
            $residenceId = $residenceIds[($index - 1) % count($residenceIds)];
            $email = sprintf('demo-manager-%02d@immoapp.test', $index);

            $manager = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fullName,
                    'password' => 'password',
                    'role' => 'manager',
                    'residence_id' => $residenceId,
                ]
            );

            TenantApartment::query()->where('tenant_id', $manager->id)->delete();
        }
    }
}
