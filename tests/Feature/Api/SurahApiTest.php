<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class SurahApiTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_surah_list(): void
    {
        $this->get(route('surahs.list'))
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'revelation_place',
                        'revelation_order',
                        'bismillah_pre',
                        'name_simple',
                        'name_complex',
                        'name_arabic',
                        'ayahs_count',
                        'pages',
                        'translation',
                    ]
                ],
            ]);
    }
    
    /**
     * @test
     */
    public function cannot_get_surah_list_if_the_lang_is_invalid()
    {
        $this->get(route('surahs.list', ['lang' => 'invalid']))
            ->assertUnprocessable();
    }
}
