<?php

namespace App\Console\Commands;

use App\Card;
use App\Set;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportSet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:set {set} {--booster-only}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cards from a set from scryfall';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $set_to_import = $this->argument('set');
        $booster_only = $this->option('booster-only') ? '+is%3Abooster' : '';
        $this->output->text("Starting import of set {$set_to_import}");
        $api_endpoint = 'https://api.scryfall.com';

        //Get set data
        $set_response = Http::get($api_endpoint . '/sets/' . $set_to_import);

        if ($set_response->failed()) {
            $this->output->error("Something went wrong getting the set data. Does this set exist on Scryfall? Code: {$set_response->status()}");
            exit;
        }

        $set_data = \GuzzleHttp\json_decode($set_response->body());

        if (Set::whereCode($set_data->code)->count()) {
            $this->output->error("This set already exists");
            exit;
        }

        $this->output->text("Staring import of {$set_data->name} ({$set_data->code}) with {$set_data->card_count} available cards");
        $this->output->text("You can see all cards in this set here: {$set_data->scryfall_uri}");
        sleep(0.1); // Be a good Scryfall citizen

        //Get card data
        $cards_request = "{$api_endpoint}/cards/search?order=set&q=set%3A{$set_data->code}{$booster_only}&unique=cards";
        $all_cards = [];
        do {
            $cards_response = Http::get($cards_request);
            if ($cards_response->failed()) {
                $this->output->error("Something went wrong getting the card data. Code: {$cards_response->status()}");
                exit;
            }
            $cards_data = \GuzzleHttp\json_decode($cards_response->body());

            if ($cards_data->has_more) {
                $cards_request = $cards_data->next_page;
            }

            foreach ($cards_data->data as $card) {
                $all_cards[] = $card;
            }
            sleep(0.1); // Be a good Scryfall citizen
        } while ($cards_data->has_more);

        $card_count = count($all_cards);
        if ($card_count < 1) {
            $this->output->error("We couldn't collect any cards. Please try again");
            exit;
        }

        $this->output->text("Collected {$card_count} cards. Starting import:");

        $this->output->progressStart($card_count);

        DB::transaction(function () use ($set_data, $all_cards) {
            $set = Set::create([
                'name' => $set_data->name,
                'code' => $set_data->code,
            ]);

            foreach ($all_cards as $card) {
                $oracle_text = '';
                if (property_exists($card, 'card_faces')) {
                    foreach ($card->card_faces as $card_face) {
                        $oracle_text .= $card_face->oracle_text . ' // ';
                    }
                }

                Card::create([
                    'set_id' => $set->id,
                    'name' => $card->name,
                    'small_image' => $card->image_uris->small,
                    'normal_image' => $card->image_uris->normal,
                    'large_image' => $card->image_uris->large,
                    'colors' => implode(',', $card->colors),
                    'cmc' => $card->cmc,
                    'type_line' => $card->type_line,
                    'text' => $card->oracle_text ?? $oracle_text,
                    'rarity' => $card->rarity,
                    'collector_number' => $card->collector_number,
                ]);
                $this->output->progressAdvance();
            }
        });


        $this->output->progressFinish();

        return 0;
    }
}
