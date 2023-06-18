<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Livewire\Component;
use OpenAI\Client;

class SearchPage extends Component
{
    public string $userPrompt = '';
    public bool $isLoading = false;

    private Client $openAIClient;

    protected $listeners = ['tagClicked' => 'onTagClicked'];
    public array $recipe = [];

    public function __construct()
    {
        $this->openAIClient = \OpenAI::client(
            env('OPENAI_KEY'),
            env('OPENAI_ORG')
        );

        parent::__construct();
    }

    public function onTagClicked($tag)
    {
        $this->userPrompt = $tag;
        $this->isLoading = true;
        $this->onClickSearch();
        $this->userPrompt = '';
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

        if (isset($recipe['title']) && isset($recipe['ingredients']) && isset($recipe['instructions'])) {
            $this->recipe = $recipe;
            $this->recipe['instructions'] = $this->formatInstructions($recipe['instructions']);
            $dbRecepie = new Recipe([
                'title' => $this->recipe['title'],
                'prompt' => $this->userPrompt,
                'ingredients' => $this->recipe['ingredients'],
                'instructions' => $this->recipe['instructions'],
            ]);
            $dbRecepie->save();
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

    private function formatInstructions(string $instructions): string
    {
        $pattern = '/(\d+)\. (.+?)(?=\d+\.|\z)/s'; // Regex pattern to match numbers followed by text

        $matches = array();
        preg_match_all($pattern, $instructions, $matches);

        $results = '';

        foreach ($matches[1] as $key => $number) {
            $results .= $number . '. ' . $matches[2][$key] . "<br/>";
        }

        return $results;
    }
}
