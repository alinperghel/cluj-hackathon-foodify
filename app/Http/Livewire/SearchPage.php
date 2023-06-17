<?php

namespace App\Http\Livewire;

use Livewire\Component;
use OpenAI\Client;

class SearchPage extends Component
{
    public string $userPrompt = '';
    public bool $isLoading = false;

    private Client $openAIClient;

    protected $listeners = ['tagClicked' => 'onTagClicked'];

    public function __construct()
    {
        $this->openAIClient = \OpenAI::client(
            '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',
            'org-13XqhgSIiTfx62J31IrzqLHM'
        );

        parent::__construct();
    }

    public function onTagClicked($tag)
    {
        $this->userPrompt = $tag;
        $this->isLoading = true;
        $this->onClickSearch();
    }

    public function onClickSearch()
    {
        $this->isLoading = true;

        try {
            $response = $this->openAIClient->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Esti un sistem ce creaza retele in functie de ingredientele sau specificatiile date si raspunde mereu in JSON.',
                    ],
                    [
                        'role' => 'user',
                        'content' => 'Vei crea o reteta ce raspunde cat mai bine la nevoile utilizatorului.\n'.
                            'Utilizatorul poate cere o reteta cu anumite ingrediente sau pentru anumite ocazii.\n\n'.
                            'Solicitarea utilizatorului este: '.
                            $this->userPrompt.'\n\n'.
                            'Vei raspunde cu retata intr-un obiect JSON. Nu vei oferi alte detalii sau clarificari. Vei genera reteta doar cu informatia pe care o ai.\n'.
                            '```json\n'.
                            '{\n'.
                            '\'title\': "numele retetei"\n'.
                            '\'ingredients\': [<lista de text cu ingredientele>]\n'.
                            '\'instructions\': "instructiunile de preparare"\n '.
                            '}\n'.
                            '```\n'.'Vei genera cate o singura cheie in JSON. Reteta trebuie sa fie in limba romana.\n'.'JSON Response: \n',
                    ]
                ],
                'temperature' => 0.15,
                'max_tokens' => 1024,
            ]);

            $recipe = json_decode($response->choices[0]->message->content, true);
        } catch (\Exception $exception) {
            $this->message = 'RateLimitException. Te rog sa incerci din nou.';
        }
        $this->userPrompt = '';

        if (isset($recipe['title']) && isset($recipe['ingredients']) && isset($recipe['instructions'])) {
            $this->recipe = $recipe;
        } else {
            $this->message = 'RateLimitException. Te rog sa incerci din nou.';
        }

        $this->isLoading = false;
    }

    public function render()
    {
        return view('livewire.search-page', [
            'userPrompt' => $this->userPrompt,
            'isLoading' => $this->isLoading,
        ]);
    }
}
