<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $families = [
            ['name' => 'Floral', 'color' => '#FFB7B2'],
            ['name' => 'Fresh', 'color' => '#A0E7E5'],
            ['name' => 'Oriental', 'color' => '#E2F0CB'],
            ['name' => 'Woody', 'color' => '#B5EAD7'],
            ['name' => 'Fruity', 'color' => '#FF9AA2'],
            ['name' => 'Spicy', 'color' => '#FFDAC1'],
            ['name' => 'Gourmand', 'color' => '#C7CEEA'],
            ['name' => 'Aquatic', 'color' => '#E0FEFE'],
        ];

        $tenant = \App\Models\Tenant::first();

        foreach ($families as $data) {
            Attribute::create([
                'tenant_id' => $tenant->id,
                'name' => $data['name'],
                'type' => 'family',
                'color' => $data['color'],
            ]);
        }

        $notes = [
            'Rose', 'Jasmine', 'Lavender', 'Bergamot', 'Lemon', 'Orange',
            'Vanilla', 'Musk', 'Amber', 'Sandalwood', 'Oud', 'Cedar',
            'Patchouli', 'Mint', 'Sea Salt', 'Apple', 'Blackcurrant', 'Saffron',
            'Cardamom', 'Cinnamon', 'Leather', 'Tobacco', 'Honey', 'Coffee'
        ];

        foreach ($notes as $note) {
            Attribute::create([
                'tenant_id' => $tenant->id,
                'name' => $note,
                'type' => 'note',
            ]);
        }
    }
}
